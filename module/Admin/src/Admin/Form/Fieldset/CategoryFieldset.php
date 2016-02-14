<?php

namespace Admin\Form\Fieldset;

use Blog\Entity\Category;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class CategoryFieldset extends Fieldset implements InputFilterProviderInterface
{
    private $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('category');

        $this->entityManager = $entityManager;
        $this->setHydrator(new DoctrineHydrator($entityManager, 'Admin\Entity\Category'));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'name' => 'label',
            'type' => 'Text',
            'options' => array(
            'label' => 'Label',
            ),
            
        ));
    }

    /**
    * Should return an array specification compatible with
    * {@link Zend\InputFilter\Factory::createInputFilter()}.
    *
    * @return array
    */
    public function getInputFilterSpecification()
    {
        return array(
            
            'label' => array(
                'required' => true,

                'validators' => array(
                    array(
                        'name' => 'DoctrineModule\Validator\NoObjectExists',
                        'options' => array(
                            'use_context'       => true,
                            'object_repository' => $this->entityManager->getRepository('Blog\Entity\Category'),
                            'object_manager' => $this->entityManager,
                            'fields' => 'label',
                            'message' => "Le label saisit existe déjà"
                         
                        ),
                    )
                ),
            ),
        );
    }
}