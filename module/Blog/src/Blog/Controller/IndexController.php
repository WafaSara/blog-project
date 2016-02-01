<?php
<<<<<<< HEAD
=======
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

>>>>>>> 967a39e830089fdc1c9fce3a738fbbb2b8f647c2
namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

<<<<<<< HEAD
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
=======
class IndexController extends AbstractActionController
{
    public function indexAction()
    {
    	// die('ok');
        return new ViewModel();
    }
}
>>>>>>> 967a39e830089fdc1c9fce3a738fbbb2b8f647c2
