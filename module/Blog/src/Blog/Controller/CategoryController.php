<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CategoryController extends AbstractActionController
{

    /**
     * listing of all the categories
     * @return array
     */
    public function listAction()
    {
    }

    public function showAction()
    {
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $slug = $this->params('slug');

        $category = $em->getRepository('Blog\Entity\Category')->findOneBySlug($slug);
        // Le slug passé en param est erroné on affiche une error 404
        if($category == null)
        {
            return $this->redirect()->toRoute('home');
        }

        // on récupère les posts du plus récent au plus ancien en fonction de la category
        $posts = $em->getRepository('Blog\Entity\Post')->getByCategory($category);
        
        return new ViewModel(array('posts' => $posts));
    }

    /**
     * edit a a category by id
     * @param  int $id
     * @return
     */
    public function editAction($id)
    {
      # code...
    }

    /**
     * delete a category by id
     * @param  int $id
     * @return
     */
    public function deleteAction($id)
    {
      # code...
    }


}
