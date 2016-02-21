<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container; // We need this when using sessions
use Blog\Entity\Comment;

class AdminCommentController extends AbstractActionController
{

    /**
     * listing of all the comments
     * @return array
     */
    public function listAction()
    {
        $request = $this->getRequest();
        $pageParam = $this->params('page');
        $pageSession = new Container('pageComment');
        $tabFiltreSession = new Container('tabFiltreCommentSession');

        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        // initialisation du tableau de filtre
        $tabFiltre['post'] = null;
        // $tabFiltre['category'] = null;

        $reset = $this->params('reset');
        if(!empty($reset))
        {
            $tabFiltreSession->filtre = $tabFiltre;
            $pageSession->page = 1;
        }
       
        // le numéro de page on récupère celui reçut en param si y'en a un sinon celui en session
        $numPage = ($pageParam) ? $pageParam : $pageSession->page;

        // créer le form de filtre
        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('Admin\Form\Form\FilterCommentForm');

        
        $comment = new Comment();

        if($tabFiltreSession->filtre != null)
        {
            $comment->setPost($tabFiltreSession->filtre['post']);
            // $post->setCategory($tabFiltreSession->filtre['category']);
        }

        $form->bind($comment);

        if($request->isPost() == false)
        {
            if(empty($tabFiltreSession->filtre))
                $comments = $em->getRepository('Blog\Entity\Comment')->getList($numPage,10,$tabFiltre);
            else // on filtre avec la session
                $comments = $em->getRepository('Blog\Entity\Comment')->getList($numPage,10,$tabFiltreSession->filtre);
        }
        else // on filtre
        {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                
                $data = $form->getData();
                $tabFiltre = array();

                $tabFiltre['post'] = $data->getPost();
                // $tabFiltre['category'] = $data->getCategory();

                $comments = $em->getRepository('Blog\Entity\Comment')->getList($numPage,10,$tabFiltre);

                $tabFiltreSession->filtre = $tabFiltre;
            }
        }

        // On écrase la variable de session
        if($numPage)
            $pageSession->page = $numPage;

        return new ViewModel(array(
            "comments" => $comments,
            "form" => $form
        ));
    }

    public function newAction()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('Admin\Form\Form\CreateCommentForm');

        $request = $this->getRequest();
        $comment = new Comment();

        $form->bind($comment);

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                
                $submit = $request->getPost('submit');
                $comment = $form->getData();
                $auth = $this->getServiceLocator()->get('zfcuser_auth_service');

                $user = $auth->getIdentity();

                $comment->setUserEmail($user->getEmail());

                $em->persist($comment);
                $em->flush();

                $this->flashMessenger()
                   ->setNamespace('success')
                   ->addMessage('Ajout réussi');
                // Le user a cliqué sur Enregistrer et retourner à la liste
                if($submit)
                    return $this->redirect()->toRoute('admin_list_comment');
                else
                    return $this->redirect()->toRoute('admin_new_comment');
            }
        }
        return new ViewModel(array(
            'form'    => $form,
            'flashMessages' => $this->flashMessenger()->getMessages()
        ));
    }

    public function editAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }

        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $id = $this->params('id');

        $comment = $em->getRepository('Blog\Entity\Comment')->find($id);

        if(!$comment)
        {
            return $this->redirect()->toRoute('admin_list_comment');
        }

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('Admin\Form\Form\CreateCommentForm');

        $request = $this->getRequest();

        $form->bind($comment);
      
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $submit = $request->getPost('submit');

                $comment = $form->getData();
                
                $em->flush();

                $this->flashMessenger()
                   ->setNamespace('success')
                   ->addMessage('Modification réussi');
                // Le user a cliqué sur Enregistrer et retourner à la liste
                if($submit)
                    return $this->redirect()->toRoute('admin_list_comment');
                else
                    return $this->redirect()->toRoute('admin_edit_comment',array("id" => $comment->getId()));
            }
        }
        return new ViewModel(array(
            'form'    => $form,
            'flashMessages' => $this->flashMessenger()->getMessages(),
            'comment' => $comment
        ));
    }

    public function deleteAction()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $id = $this->params('id');

        $comment = $em->getRepository('Blog\Entity\Comment')->find($id);

        if(!$comment)
        {
            return $this->redirect()->toRoute('admin_list_comment');
        }

        $em->remove($comment);
        $em->flush();
      
        $this->flashMessenger()
           ->setNamespace('success')
           ->addMessage('Suppression réussi');

        return $this->redirect()->toRoute('admin_list_comment');
    }


    public function deleteGroupsAction()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $allParam = $this->params()->fromPost();
        $tabId = $this->params()->fromPost('toDelete');

        if(isset($allParam['supprimer']))
        {
            if($tabId)
            {
                foreach ($tabId as $id) {
                    $comment = $em->getRepository('Blog\Entity\Comment')->find($id);
                
                    if($comment)
                    {
                        $em->remove($comment);
                    }
                }
                $em->flush();

                $this->flashMessenger()
                           ->setNamespace('success')
                           ->addMessage('Suppression réussi');
            }
        }
       
        return $this->redirect()->toRoute('admin_list_comment');
    }


}
