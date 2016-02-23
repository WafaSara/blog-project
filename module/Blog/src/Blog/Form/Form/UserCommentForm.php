<?php

namespace Blog\Form\Form;
 
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Form;

class UserCommentForm extends Form implements InputFilterProviderInterface
{
    public function __construct($urlcaptcha = null)
    {
        parent::__construct('user-comment');
        $this->setAttribute('method', 'post');

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
                'name' => 'comment',
                'required' => true,
                
            ],
        ];
    }
 
}