<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


/**
 *
 */
class  IndexController extends AbstractActionController
{

  function __construct()
  {
    # code...
  }
  public function indexAction()
  {
    return new ViewModel();
  }
}

 ?>
