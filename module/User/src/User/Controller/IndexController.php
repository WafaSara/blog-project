<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Crypt\Password\Bcrypt;
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
    /*$t = $this->zfcUserAuthentication()->hasIdentity();

    var_dump($t);
    die();*/
    // http://blog-project.localhost/user/register
  	$password = $this->generatePassword();
  	$bcrypt = new Bcrypt;
	  $bcrypt->setCost(14);

    	$crypt = $bcrypt->create($password);
    	// $t = $bcrypt->verify($password, $crypt);
	
  	return new ViewModel(array('password' => $password,
  		'crypt' => $crypt));
  }

  private function generatePassword($nbCaractere = 6)
	{
		$password = "";

        $string = "abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ023456789+@!$%?&";
        $len_string = strlen($string);

        for($i = 1; $i <= $nbCaractere; $i++)
        {
            $place_aleatoire = mt_rand(0,($len_string-1));
            $password .= $string[$place_aleatoire];
        }

        return $password;
	}
}

 ?>

