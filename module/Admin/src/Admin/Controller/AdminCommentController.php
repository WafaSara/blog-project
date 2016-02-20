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
        
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $reset = $this->params('reset');
        if(!empty($reset))
        {
            // $monNamespace = new Zend_Session_Namespace('monNamespace');
        }
        // récupération des filtres de sessions
       
        // le numéro de page on récupère celui reçut en param si y'en a un sinon celui en session
        $numPage = ($pageParam) ? $pageParam : $pageSession->page;

        // si méthode post on met à jour les variables de sessions
        if($request->isPost())
        {
           
        }
        // créer le form de filtre

        if($request->isPost() == false)
        {
            $comments = $em->getRepository('Blog\Entity\Comment')->getList($numPage);
        }
        else // on filtre
        {

        }
        // dans le cas ou on a pas de page en paramètre on la met a 1
        $numPage = ($pageParam) ? $pageParam : '1';

        // On écrase la variable de session
        if($numPage)
            $pageSession->page = $numPage;

        return new ViewModel(array("comments" => $comments));
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

    /**
     * edit a a comment by id
     * @param  int $id
     * @return
     */
    public function editAction($id)
    {
      # code...
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
