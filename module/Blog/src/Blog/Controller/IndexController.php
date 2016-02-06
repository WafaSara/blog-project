<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 *
 */
class  IndexController extends AbstractActionController
{

  public function indexAction()
  {
    $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

  	// on récupère les 10 posts plus récent
    $posts = $em->getRepository('Blog\Entity\Post')->getLastPosts();
    
    return new ViewModel(array('posts' => $posts));
  }

  public function contactAction()
  {
    return new ViewModel();
  }
}

 ?>
