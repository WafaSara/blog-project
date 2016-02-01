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
    public function indexAction()
    {
        return new ViewModel();
    }

    /**
     * get a post by id
     * @param  int $id id
     * @return
     */
    public function showAction($id)
    {
      # code...
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
