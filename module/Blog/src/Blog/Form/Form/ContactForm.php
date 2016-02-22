<?php

namespace Blog\Form\Form;

use Zend\Form\Form,
    Zend\Form\Element\Captcha,
    Zend\Captcha\Image as CaptchaImage;

use Zend\InputFilter\InputFilterProviderInterface;

class ContactForm extends Form implements InputFilterProviderInterface
{
    public function __construct($urlcaptcha = null)
    {
        parent::__construct('contact');
        $this->setAttribute('method', 'post');

        $dirdata = './data';
    
        $captchaImage = new CaptchaImage(
            array(
                'font' => $dirdata . '/fonts/arial.ttf',
                'width' => 250,
                'height' => 100,
                'dotNoiseLevel' => 40,
                'lineNoiseLevel' => 3
            )
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
            'name' => 'message',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Votre message',
            ),
            'attributes' => array(
                'class' => "ckeditor",
            )
        ));

        $this->add([
            'name' => 'email',
            'type'  => 'Zend\Form\Element\Text',
            'attributes' => [
                'class' => 'form-control',
            ],
            'options' => [
                'type' => 'text',
                'label' => 'E-mail',
            ],
        ]);

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
                'name' => 'message',
                'required' => true,
            ],
            [
                'name' => 'email',
                'required' => true,
                'filters'  => [
                    [
                        'name' => 'StripTags'
                    ],
                    [
                        'name' => 'StringTrim'
                    ],
                ],
                'validators' => [
                    [
                        'name'    => '\Zend\Validator\EmailAddress',
                        'options' => [
                            'domain' => false,
                            'messages' => [
                                \Zend\Validator\EmailAddress::INVALID => 'Veuiilez saisir une adresse mail correcte',
                                // \Zend\Validator\NotEmpty::IS_EMPTY => "Veuillez remplir ce champ"
                            ]
                        ],
                    ],
                ],
            ],
        ];
    }
 
}