<?php

namespace Blog\Form\Form;
 
use Zend\Form\Form,
    Zend\Form\Element\Captcha,
    Zend\Captcha\Image as CaptchaImage;

use Zend\InputFilter\InputFilterProviderInterface;

class AnonymousCommentForm extends Form implements InputFilterProviderInterface
{
    public function __construct($urlcaptcha = null)
    {
        parent::__construct('anonymous-comment');
        $this->setAttribute('method', 'post');
 
        $dirdata = './data';
    
        $captchaImage = new CaptchaImage(  array(
                'font' => $dirdata . '/fonts/arial.ttf',
                'width' => 250,
                'height' => 100,
                'dotNoiseLevel' => 40,
                'lineNoiseLevel' => 3)
        );

        $captchaImage->setImgDir($dirdata.'/captcha');
        $captchaImage->setImgUrl($urlcaptcha);
          
        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Retape ce que tu vois dans la photo',
                'captcha' => $captchaImage,
            ),
        ));

        $this->add(array(
            'name' => 'comment',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Commentaire',
            ),
            'attributes' => array(
                'class' => "ckeditor",
            )
        ));

        $this->add(array(
            'name' => 'anonymous',
            'type' => 'text',
            'options' => array(
                'label' => 'Pseudo',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'commenter',
                "class" => "btn btn-info"
            ),
        ));
    }

    public function getInputFilterSpecification()
    {
        return [
            [
                'name' => 'captcha',
                'required' => true
               
            ],
            [
                'name' => 'comment',
                'required' => true,
                
            ],
            [
                'name' => 'anonymous',
                'required' => true,
            ],
        ];
    }
 
}