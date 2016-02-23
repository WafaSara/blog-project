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
        $pageSession = new Container('pageCategory');
        $tabFiltreSession = new Container('tabFiltreCategorySession');
        
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        // initialisation du tableau de filtre
        $tabFiltre['label'] = null;

        $reset = $this->params('reset');

        if(!empty($reset))
        {
            $tabFiltreSession->filtre = $tabFiltre;
            $pageSession->page = 1;
        }
        // récupération des filtres de sessions
       
        // le numéro de page on récupère celui reçut en param si y'en a un sinon celui en session
        $numPage = ($pageParam) ? $pageParam : $pageSession->page;

        // créer le form de filtre
        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('Admin\Form\Form\FilterCategoryForm');

        $category = new Category();

        if($tabFiltreSession->filtre != null)
        {
            $category->setLabel($tabFiltreSession->filtre['label']);
        }

        $form->bind($category);

        if($request->isPost() == false)
        {
            if(empty($tabFiltreSession->filtre))
                $categorys = $em->getRepository('Blog\Entity\Category')->getList($numPage,20,$tabFiltre);
            else // on filtre avec la session
                $categorys = $em->getRepository('Blog\Entity\Category')->getList($numPage,20,$tabFiltreSession->filtre);

        }
        else // on filtre
        {
            $form->setData($request->getPost());

             if ($form->isValid()) {
                
                $data = $form->getData();
                $tabFiltre = array();

                $tabFiltre['label'] = $data->getLabel();
          
                $categorys = $em->getRepository('Blog\Entity\Category')->getList($numPage,20,$tabFiltre);

                $tabFiltreSession->filtre = $tabFiltre;
            }
        }

        // On écrase la variable de session
        if($numPage)
            $pageSession->page = $numPage;

        return new ViewModel(array(
            "categorys" => $categorys,
            "form" => $form));
    }

    /**
     * Create a new category
     * @param  none
     * @return 
     */
    public function newAction()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

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
                
                $em->persist($category);
                $em->flush();

                $this->flashMessenger()
                   ->setNamespace('success')
                   ->addMessage('Ajout réussi');
                // Le user a cliqué sur Enregistrer et retourner à la liste
                if($submit)
                    return $this->redirect()->toRoute('admin_list_category');
                else
                    return $this->redirect()->toRoute('admin_new_category');
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

        if(!$category)
        {
            return $this->redirect()->toRoute('admin_list_category');
        }

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
                else
                    return $this->redirect()->toRoute('admin_edit_category',array("id" => $category->getId()));
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
