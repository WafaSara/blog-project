<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CategoryController extends AbstractActionController
{

    /**
     * listin of all the categories
     * @return array
     */
    public function indexAction()
    {
        return new ViewModel();
    }

    /**
     * get a category by id
     * @param  int $id id
     * @return
     */
    public function showAction($id)
    {
      # code...
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
