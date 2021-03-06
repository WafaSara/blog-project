<?php
namespace User\Form\Form;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class ForgotPasswordForm extends Form implements InputFilterProviderInterface
{
    protected $inputFilter;

    public function __construct()
    {
        parent::__construct('forgot-password');

        $this->setAttribute('method', 'post');

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
        $this->add([
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Button',
            'attributes' => [
                'type' => 'submit',
                // 'value' => 'Envoyer',

                'class' => 'btn btn-success',
            ],
        ]);
    }
    public function getInputFilterSpecification()
    {
        return [
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