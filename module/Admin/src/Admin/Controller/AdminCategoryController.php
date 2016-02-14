<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container; // We need this when using sessions
use Blog\Entity\Category;
use Admin\Form\Form\CreateCategoryForm;



class AdminCategoryController extends AbstractActionController
{

    public function listAction()
    {
        $request = $this->getRequest();
        $pageParam = $this->params('page');

        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $reset = $this->params('reset');
        if(!empty($reset))
        {
            // $monNamespace = new Zend_Session_Namespace('monNamespace');
            
        }
        // récupération des filtres de sessions
       
        // le numéro de page on récupère celui reçut en param si y'en a un sinon celui en session
        $numPage = ($pageParam) ? $pageParam : $_SESSION['category_page'];

        // si méthode post on met à jour les variables de sessions
        if($request->isPost())
        {
           
        }
        // créer le form de filtre

        if($request->isPost() == false)
        {
            $categorys = $em->getRepository('Blog\Entity\Category')->getList($numPage);
        }
        else // on filtre
        {

        }
        // dans le cas ou on a pas de page en paramètre on la met a 1
        $numPage = ($pageParam) ? $pageParam : '1';

        // On écrase la variable de session que quand on a une page passer en paramètre
        if($numPage != 1)
            $_SESSION['category_page'] = $numPage;

        return new ViewModel(array("categorys" => $categorys));
    }

    /**
     * Create a new category
     * @param  none
     * @return 
     */
    public function newAction()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('Admin\Form\Form\CreateCategoryForm');

        $request = $this->getRequest();
        $category = new Category();

        $form->bind($category);

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                
                $submit = $request->getPost('submit');

                $category = $form->getData();
                
                $category->setCreatedAt(new \DateTime());
                $em->persist($category);
                $em->flush();

                $this->flashMessenger()
                   ->setNamespace('success')
                   ->addMessage('Ajout réussi');
                // Le user a cliqué sur Enregistrer et retourner à la liste
                if($submit)
                    return $this->redirect()->toRoute('admin_list_category');
            }
        }
        return new ViewModel(array(
            'form'    => $form,
            'flashMessages' => $this->flashMessenger()->getMessages()
        ));
    }

    /**
     * edit a a category by id
     * @param  none
     * @return
     */
    public function editAction()
    {

        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $id = $this->params('id');

        $category = $em->getRepository('Blog\Entity\Category')->find($id);

        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('Admin\Form\Form\CreateCategoryForm');

        $request = $this->getRequest();

        $form->bind($category);
      
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $submit = $request->getPost('submit');

                $category = $form->getData();
                
                $em->flush();

                $this->flashMessenger()
                   ->setNamespace('success')
                   ->addMessage('Modification réussi');
                // Le user a cliqué sur Enregistrer et retourner à la liste
                if($submit)
                    return $this->redirect()->toRoute('admin_list_category');
            }
        }
        return new ViewModel(array(
            'form'    => $form,
            'flashMessages' => $this->flashMessenger()->getMessages(),
            'category' => $category
        ));
    }

    /**
     * delete a category by id
     * @param  int $id
     * @return
     */
    public function deleteAction()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $id = $this->params('id');

        $category = $em->getRepository('Blog\Entity\Category')->find($id);

        if(!$category)
        {
            return $this->redirect()->toRoute('admin_list_category');
        }

        $posts = $em->getRepository('Blog\Entity\Post')->findByCategory($category);

        if($posts)
        {
            foreach ($posts as $onePost)
            {
                $comments = $em->getRepository('Blog\Entity\Comment')->findByPost($onePost);
                foreach ($comments as $oneComment) {
                    $em->remove($oneComment);
                    $em->flush();
                }
                $em->remove($onePost);
                $em->flush();
            }
        }
        
        $em->remove($category);
        $em->flush();

        $this->flashMessenger()
           ->setNamespace('success')
           ->addMessage('Suppression réussi');

        return $this->redirect()->toRoute('admin_list_category');
    }
}
