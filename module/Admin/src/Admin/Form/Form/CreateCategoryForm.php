<?php
namespace Admin\Form\Form;

use Zend\Form\Form;
use Zend\Form\Element\Csrf;

class CreateCategoryForm extends Form
{
    public function init() {
        
        $this->setAttribute('method', 'post');

        $this->add(new Csrf('csrf'));

        $this->add(array(
            'name' => 'category',
            'type' => 'CategoryFieldset',
            /* 'options' => array(
                 'use_as_base_fieldset' => true,
             ),*/
        ));

        // Id
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
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
   /* public function __construct()
    {
        parent::__construct('create-category-form');

        $this->add(new Csrf('csrf'));
        $this->add(array(
             'name' => 'label',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Label',
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

    }*/
}