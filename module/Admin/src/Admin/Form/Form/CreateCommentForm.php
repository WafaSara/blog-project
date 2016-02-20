<?php
namespace Admin\Form\Form;

use Zend\Form\Form;
use Zend\Form\Element\Csrf;

class CreateCommentForm extends Form
{
    public function init() {
        
        $this->setAttribute('method', 'post');

        $this->add(new Csrf('csrf'));
        $this->add(array(
            'name' => 'comment',
            'type' => 'CommentFieldset',
             'options' => array(
                 'use_as_base_fieldset' => true,
             ),
        ));
        
         $this->add(array(
            'name'       => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Enregistrer et retourner à la liste',
                'class' => 'btn btn-info'

            )
        ));

        $this->add(array(
            'name'       => 'submit-and-continue',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Enregistrer et continuer',
                'class' => 'btn btn-success'
            )
        ));

        
    }
}