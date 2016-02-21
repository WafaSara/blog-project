<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container; // Pour les sessions
use Blog\Entity\Post;
use Blog\Entity\Category;


class AdminPostController extends AbstractActionController
{

    /**
     * listin of all the posts
     * @return array
     */
    public function listAction()
    {
        $request = $this->getRequest();
        $pageParam = $this->params('page');
        $pageSession = new Container('pagePost');
        $tabFiltreSession = new Container('tabFiltrePostSession');

        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        // initialisation du tableau de filtre
        $tabFiltre['title'] = null;
        $tabFiltre['category'] = null;
        $tabFiltre['deleted'] = 0;
        $reset = $this->params('reset');

        // on réinitialise toute la session
        if(!empty($reset))
        {
            $tabFiltreSession->filtre = $tabFiltre;
            $pageSession->page = 1;

        }

        // le numéro de page on récupère celui reçut en param si y'en a un sinon celui en session
        $numPage = ($pageParam) ? $pageParam : $pageSession->page;

        // créer le form de filtre
        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('Admin\Form\Form\FilterPostForm');

        $post = new Post();
        if($tabFiltreSession->filtre != null)
        {
            $post->setTitle($tabFiltreSession->filtre['title']);
            $post->setCategory($tabFiltreSession->filtre['category']);
            $post->setDeleted($tabFiltreSession->filtre['deleted']);
        }

        $form->bind($post);
        

        if($request->isPost() == false)
        {
            if(empty($tabFiltreSession->filtre))
                $posts = $em->getRepository('Blog\Entity\Post')->getList($numPage,10,$tabFiltre);
            else // on filtre avec la session
                $posts = $em->getRepository('Blog\Entity\Post')->getList($numPage,10,$tabFiltreSession->filtre);
        }
        else // on est en post, on filtre
        {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                
                $data = $form->getData();
                $tabFiltre = array();

                $tabFiltre['title'] = $data->getTitle();
                $tabFiltre['category'] = $data->getCategory();
                $tabFiltre['deleted'] = $data->getDeleted();

                $posts = $em->getRepository('Blog\Entity\Post')->getList($numPage,10,$tabFiltre);

                $tabFiltreSession->filtre = $tabFiltre;
            }
        }

        // On écrase la variable de session
        if($numPage)
            $pageSession->page = $numPage;

        return new ViewModel(array(
            "posts" => $posts,
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
        $form = $formManager->get('Admin\Form\Form\CreatePostForm');

        $request = $this->getRequest();
        $post = new Post();
        $form->bind($post);

        if ($request->isPost()) {
            $postData = array_merge_recursive((array)$request->getPost(), (array)$request->getFiles());
            $file = (array)$request->getFiles();
        
            // fichier incorect
            if(!$file)
            {
                $this->flashMessenger()
                   ->setNamespace('error')
                   ->addMessage('Le fichier envoyé est incorrect');
                return $this->redirect()->toRoute('admin_new_post');
            }
            
            $form->setData($postData);

            if ($form->isValid()) {
                $post = $form->getData();

                // tableau contenant le nom dufichier['name'] uploader,[type], [tmp_name],[error],[size]
                $filesDetails = $post->getFile();
             
                $httpadapter = new \Zend\File\Transfer\Adapter\Http(); 
                $httpadapter->setDestination($post->getAbsoluteUploadDir());
                
                $path_parts = pathinfo($filesDetails['name']);
                
                $photo = sha1(uniqid(mt_rand(), true)).".".$path_parts['extension'];

                $newFilePath  = "./public/".$post->getUploadDir().'/'.$photo;
                // modification du fichier uploader
                $httpadapter->addFilter('\Zend\Filter\File\Rename', array('target' => $newFilePath,
                    'overwrite' => false));

                // move uploaded file
                $httpadapter->receive();
             
                $post->setPhoto($photo);
                $post->setPhotoRealName($filesDetails['name']);
                $post->setPhotoExtension($path_parts['extension']);

                $submit = $request->getPost('submit');
                $auth = $this->getServiceLocator()->get('zfcuser_auth_service');

                $user = $auth->getIdentity();
                $post->setAuthor($user);
                $post->setUpdatedBy($user);

                $em->persist($post);
                $em->flush();

                $this->flashMessenger()
                   ->setNamespace('success')
                   ->addMessage('Ajout réussi');
                // Le user a cliqué sur Enregistrer et retourner à la liste
                if($submit)
                    return $this->redirect()->toRoute('admin_list_post');
                else
                    return $this->redirect()->toRoute('admin_new_post');
            }
        }
        return new ViewModel(array(
            'form'    => $form,
            'flashMessages' => $this->flashMessenger()->getMessages()
        ));
    }

    /**
     * edit a a post by id
     * @return
     */
    public function editAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $id = $this->params('id');

        $post = $em->getRepository('Blog\Entity\Post')->find($id);

        if(!$post)
        {
            return $this->redirect()->toRoute('admin_list_post');
        }

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('Admin\Form\Form\CreatePostForm');

        $request = $this->getRequest();

        $form->bind($post);
      
        if ($request->isPost()) {
            $postData = array_merge_recursive((array)$request->getPost(), (array)$request->getFiles());
            $file = (array)$request->getFiles();
        
            // fichier incorect
            if(!$file)
            {
                $this->flashMessenger()
                   ->setNamespace('error')
                   ->addMessage('Le fichier envoyé est incorrect');
                return $this->redirect()->toRoute('admin_edit_post',array("id" => $post->getId()));
            }

            $form->setData($postData);
            if ($form->isValid()) {
                $post = $form->getData();

                // tableau contenant le nom dufichier['name'] uploader,[type], [tmp_name],[error],[size]
                $filesDetails = $post->getFile();
               
                // on a un fichier a upload
                if($filesDetails['tmp_name'] != "")
                {
                    if($post->getPhoto() != null && file_exists($post->getAbsoluteWebPath()))
                    {
                        unlink($post->getAbsoluteWebPath());
                    }

                    $httpadapter = new \Zend\File\Transfer\Adapter\Http(); 
                    $httpadapter->setDestination($post->getAbsoluteUploadDir());
                    
                    $path_parts = pathinfo($filesDetails['name']);
                    
                    $photo = sha1(uniqid(mt_rand(), true)).".".$path_parts['extension'];

                    $newFilePath  = "./public/".$post->getUploadDir().'/'.$photo;
                    // modification du fichier uploader
                    $httpadapter->addFilter('\Zend\Filter\File\Rename', array('target' => $newFilePath,
                        'overwrite' => false));

                    // move uploaded file
                    $httpadapter->receive();
                 
                    $post->setPhoto($photo);
                    $post->setPhotoRealName($filesDetails['name']);
                    $post->setPhotoExtension($path_parts['extension']);
                }

                $submit = $request->getPost('submit');

                $post = $form->getData();
                $em->flush();

                $this->flashMessenger()
                   ->setNamespace('success')
                   ->addMessage('Modification réussi');
                // Le user a cliqué sur Enregistrer et retourner à la liste
                if($submit)
                    return $this->redirect()->toRoute('admin_list_post');
                else
                    return $this->redirect()->toRoute('admin_edit_post',array("id" => $post->getId()));
            }
        }
        return new ViewModel(array(
            'form'    => $form,
            'flashMessages' => $this->flashMessenger()->getMessages(),
            'post' => $post
        ));
    }

    /**
     * delete a post by id
     * @param  int $id
     * @return
     */
    public function deleteAction()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $id = $this->params('id');

        $post = $em->getRepository('Blog\Entity\Post')->find($id);

        if(!$post)
        {
            return $this->redirect()->toRoute('admin_list_post');
        }

        $comments = $em->getRepository('Blog\Entity\Comment')->findByPost($post);
        
        if($comments)
        {
            foreach ($comments as $oneComment) {
                $em->remove($oneComment);
                $em->flush();
            }
        }
        
        $em->remove($post);
        $em->flush();

        $this->flashMessenger()
           ->setNamespace('success')
           ->addMessage('Suppression réussi');

        return $this->redirect()->toRoute('admin_list_post');
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
                    $post = $em->getRepository('Blog\Entity\Post')->find($id);

                    if(!$post)
                    {
                        $this->flashMessenger()
                           ->setNamespace('error')
                           ->addMessage('Article non supprimé');
                        return $this->redirect()->toRoute('admin_list_post');
                    }

                    $comments = $em->getRepository('Blog\Entity\Comment')->findByPost($post);
                
                    if($comments)
                    {
                        foreach ($comments as $oneComment) {
                            $em->remove($oneComment);
                        }
                    }
                    
                    $em->remove($post);
                }

                $em->flush();

                $this->flashMessenger()
                           ->setNamespace('success')
                           ->addMessage('Suppression réussi');
            }
            
        }
        else // on publie ou on ne publie pas les posts
        {
            if($tabId)
            {
                foreach ($tabId as $id) {
                    $post = $em->getRepository('Blog\Entity\Post')->find($id);

                    if(!$post)
                    {
                        $this->flashMessenger()
                           ->setNamespace('error')
                           ->addMessage('Articles non masqués');
                        return $this->redirect()->toRoute('admin_list_post');
                    }

                    if($post->isDeleted())
                        $post->setDeleted(0);
                    else // L'article est publié on le masque
                        $post->setDeleted(1);

                    $em->flush();
                }

                $this->flashMessenger()
                           ->setNamespace('success')
                           ->addMessage('Modification enregistré');
            }
    }
        return $this->redirect()->toRoute('admin_list_post');
    }

}
