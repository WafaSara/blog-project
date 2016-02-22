<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Blog\Form\Form\ContactForm;
use Zend\Mail\Message as MailMessage;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Mime;
use Zend\Mail\Message;

/**
 *
 */
class  IndexController extends AbstractActionController
{

  public function indexAction()
  {
    $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

  	// on récupère les 10 posts plus récent
    $posts = $em->getRepository('Blog\Entity\Post')->getLastPosts();
    
    return new ViewModel(array('posts' => $posts));
  }

  public function contactAction()
  {
    $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

    $form = new ContactForm($this->getRequest()->getBaseUrl().'/post/captcha/');

    $request = $this->getRequest();
    if ($request->isPost()) {
        //set data post
        $form->setData($request->getPost());
    
        if ($form->isValid()) {
            $data = $form->getData();
            $email = $data['email'];
            $message = $data['message'];
            $value = array('message' => $message);
            $mailService = $this->getServiceLocator()->get('goaliomailservice_message');

            $admin = $em->getRepository('User\Entity\MyUser')->findOneByIsSuperAdmin(1);

            $viewTemplate = 'user/index/mail-contact';
            $ok = false;
            try {
                $html = $mailService->getRenderer()->render(
                  $viewTemplate, $value
                );

                $htmlPart = new MimePart($html);
                $htmlPart->type = "text/html; charset=UTF-8";
                $htmlPart->encoding = Mime::ENCODING_QUOTEDPRINTABLE;

                $body = new MimeMessage();
                $body->setParts(array($htmlPart));

                $message = new Message();
                $message->setFrom($email, $email)
                    ->setEncoding('utf-8')
                    ->setSubject("Blog Sport questions")
                    ->setBody($body)
                    ->setTo($admin->getMailCompany());

                $mailService->send($message);
                $ok = true;
                
            } catch (\Exception $e) {
            }

            if ($ok) {
                $this->flashMessenger()
                   ->setNamespace('success')
                   ->addMessage('Votre message a été envoyé avec succès');
            }
            else
            {
              $this->flashMessenger()
                   ->setNamespace('error')
                   ->addMessage('L\'envoie de mail a échoué');
            }
            return $this->redirect()->toRoute('contact');
        }
    }

    return new ViewModel(array(
        'form' => $form,
        'flashMessages' => $this->flashMessenger()->getMessages()
    ));
  }
}

 ?>
