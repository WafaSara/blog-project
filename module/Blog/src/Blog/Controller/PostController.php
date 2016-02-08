<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

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

        // Le post passé en param est erroné on redirige vers l'accueil
        if($post == null)
        {
            return $this->redirect()->toRoute('home'); 
        }
        
        return new ViewModel(array('post' => $post));
    }

    /**
     * edit a a post by id
     * @param  int $id
     * @return
     */
    public function editAction($id)
    {
      # code...
    }

    /**
     * delete a post by id
     * @param  int $id
     * @return
     */
    public function deleteAction($id)
    {
      # code...
    }


}
