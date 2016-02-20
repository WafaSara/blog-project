<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Crypt\Password\Bcrypt;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\Mail\Message as MailMessage;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Mime;
use Zend\Mail\Message;
use User\Entity\Token;

/**
 *
 */
class  IndexController extends AbstractActionController
{

  function __construct()
  {
    # code...
  }

  public function indexAction()
  {
    /*$t = $this->zfcUserAuthentication()->hasIdentity();

    var_dump($t);
    die();*/
    // http://blog-project.localhost/user/register
  	$password = $this->generatePassword();
  	$bcrypt = new Bcrypt;
	  $bcrypt->setCost(14);

    	$crypt = $bcrypt->create($password);
    	// $t = $bcrypt->verify($password, $crypt);
	
  	return new ViewModel(array('password' => $password,
  		'crypt' => $crypt));
  }

  private function generatePassword($nbCaractere = 6)
	{
		$password = "";

        $string = "abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ023456789+@!$%?&";
        $len_string = strlen($string);

        for($i = 1; $i <= $nbCaractere; $i++)
        {
            $place_aleatoire = mt_rand(0,($len_string-1));
            $password .= $string[$place_aleatoire];
        }

        return $password;
	}

  public function forgotPasswordAction()
  {
      $formManager = $this->serviceLocator->get('FormElementManager');
      $form = $formManager->get('User\Form\Form\ForgotPasswordForm');
      
      $request = $this->getRequest();

      if ($request->isPost()) {
          $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

          $form->setData($request->getPost());
          if ($form->isValid()) {
              $data = $form->getData();
              $email = $data['email'];

              $user = $em->getRepository('User\Entity\MyUser')->findOneByEmail($email);
              if(!$user)
              {

                $this->flashMessenger()
                   ->setNamespace('error')
                   ->addMessage('Le mail saisit n\'existe pas');
                return $this->redirect()->toRoute('user_forgot_password');
              }
              else // on envoie un mail ac un jeton valide 24h pour puvoir changer de mot de pass 
              {
                $viewTemplate = 'user/index/mail-change-password';
                $uri = $this->getRequest()->getUri();
                $host = $uri->getHost();

                $exToken = $em->getRepository('User\Entity\Token')->findOneByUser($user);
                if($exToken)
                {
                    $em->remove($exToken);
                    $em->flush();
                }
                $token = new Token();
                $token->setUser($user);
                $em->persist($token);
                $em->flush();
             
                // The ViewModel variables to pass into the renderer
                $value = array('token' => $token->getToken(),'host' => $host);

                $mailService = $this->getServiceLocator()->get('goaliomailservice_message');

                $admin = $em->getRepository('User\Entity\MyUser')->findOneByIsSuperAdmin(1);

               /* try {
                    
                    $html = $mailService->getRenderer()->render(
                    $viewTemplate, $value
                    );

                    $htmlPart = new MimePart($html);
                    $htmlPart->type = "text/html; charset=UTF-8";
                    $htmlPart->encoding = Mime::ENCODING_QUOTEDPRINTABLE;

                    $body = new MimeMessage();
                    $body->setParts(array($htmlPart));

                    $message = new Message();
                    $message->setFrom($admin->getMailCompany(), $admin->getMailCompany())
                        ->setEncoding('utf-8')
                        ->setSubject("Mot de passe oublié")
                        ->setBody($body)
                        ->setTo($email);

                    $mailService->send($message);
                } catch (\Exception $e) {
                    $this->flashMessenger()
                       ->setNamespace('error')
                       ->addMessage('L\'envoie de mail a échoué');
                }*/

     /*           $message = $mailService->createTextMessage("soumare.iss@gmail.com", "isoumare@atixnet.fr", "reset-password", $viewTemplate,$value);
                $message->getHeaders()->get('content-type')->setType('multipart/alternative');
                $mailService->send($message);
*/
              }
              

              $this->flashMessenger()
                 ->setNamespace('success')
                 ->addMessage('Un mail vous a été envoyé afin de pouvoir changer votre email');
              // Le user a cliqué sur Enregistrer et retourner à la liste
              return $this->redirect()->toRoute('user_forgot_password');
          }
      }

      return new ViewModel(array(
        'form'    => $form,
        'flashMessages' => $this->flashMessenger()->getMessages()

        ));
  }


    public function changePasswordAction()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        
        $paramToken = $this->params('token');
        
        $token = $em->getRepository('User\Entity\Token')->findOneByToken($paramToken);
        
        if(!$token)
        {
           return $this->redirect()->toRoute('home');
        }

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('User\Form\Form\ChangePasswordForm');
        
        $request = $this->getRequest();


        if($request->isPost()) 
        {
          $form->setData($request->getPost());
           if($form->isValid()) {
              $data = $form->getData();
              $user = $em->getRepository('User\Entity\MyUser')->find($token->getUser());
              $password = $data["new_password"];
              $bcrypt = new Bcrypt;
              $bcrypt->setCost(14);

              $crypt = $bcrypt->create($password);
              $user->setPassword($crypt);
              $em->remove($token);
              $em->flush();
              $this->flashMessenger()->addMessage("Changement de mot de passe réussi Authentifié vous");
            /*  $this->flashMessenger()
                   ->setNamespace('notice')
                   ->addMessage('Changement de mot de passe réussi Authentifié vous');*/

              return $this->redirect()->toRoute('zfcuser');
           }
        }
        // $form->bind($category);

        return new ViewModel(array(
          'form'    => $form,
          'flashMessages' => $this->flashMessenger()->getMessages(),
          'token' => $token

        ));
    }

}

?>

