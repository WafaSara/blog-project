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
