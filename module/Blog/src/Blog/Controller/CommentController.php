<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CommentController extends AbstractActionController
{

    /**
     * listin of all the comments
     * @return array
     */
    public function indexAction()
    {
        return new ViewModel();
    }

    /**
     * get a comment by id
     * @param  int $id id
     * @return
     */
    public function showAction($id)
    {
      # code...
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

    /**
     * delete a comment by id 
     * @param  int $id
     * @return
     */
    public function deleteAction($id)
    {
      # code...
    }


}
