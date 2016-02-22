<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Blog\Form\Form\AnonymousCommentForm;
use Blog\Entity\Comment;
use Zend\View\Model\JsonModel;

class PostController extends AbstractActionController
{

    /**
     * listin of all the posts
     * @return array
     */
    public function listAction()
    {
    }

    public function showAction()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $idPost = $this->params('id');

        $post = $em->getRepository('Blog\Entity\Post')->find($idPost);

        $form = new AnonymousCommentForm($this->getRequest()->getBaseUrl().'/post/captcha/');

        $request = $this->getRequest();
        if ($request->isPost()) {
            //set data post
            $form->setData($request->getPost());
        
            if ($form->isValid()) {
                $data = $form->getData();
                $comment = new Comment();
                $comment->setPost($post);
                $comment->setAnonymous($data['anonymous']);
                $comment->setComment($data['comment']);
                $em->persist($comment);
                $em->flush();

                $this->flashMessenger()
                   ->setNamespace('success')
                   ->addMessage('Votre commentaire a été ajouté');
                return $this->redirect()->toRoute('show_post',array("id" => $post->getId()));
            }
        }

        // Le post passé en param est erroné on redirige vers l'accueil
        if($post == null)
        {
            return $this->redirect()->toRoute('home'); 
        }
        
        $comments = $em->getRepository('Blog\Entity\Comment')->getByPosts($post);

        return new ViewModel(array(
            'post' => $post,
            'form' => $form,
            'comments' => $comments
        ));
    }

    public function generateAction()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', "image/png");

        $id = $this->params('id', false);

        if ($id) {

          $image = './data/captcha/' . $id;

          if (file_exists($image) !== false) {
              $imagegetcontent = @file_get_contents($image);

              $response->setStatusCode(200);
              $response->setContent($imagegetcontent);

              if (file_exists($image) == true) {
                  unlink($image);
              }
          }
        }

        return $response;
    }

    public function refreshCaptchaAjaxAction()
    {
        $request = $this->getRequest();

        $data = array('text' => 'Non un requete ajax');

        if ($request->isXmlHttpRequest())
        {
            $form = new AnonymousCommentForm($this->getRequest()->getBaseUrl().'/post/captcha/');
            $captcha = $form->get('captcha')->getCaptcha();             
            $data = array();              
            $data['id']  = $captcha->generate();
            $data['src'] = $captcha->getImgUrl().$captcha->getId().$captcha->getSuffix();
        }

        return new JsonModel($data);
    }

}
