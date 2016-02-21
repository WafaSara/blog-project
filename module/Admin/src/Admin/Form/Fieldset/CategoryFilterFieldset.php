<?php

namespace Admin\Form\Fieldset;

use Blog\Entity\Category;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\EntityManager;

class CategoryFilterFieldset extends Fieldset implements InputFilterProviderInterface
{
    private $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('category-filtre');

        $this->entityManager = $entityManager;
        $this->setHydrator(new DoctrineHydrator($entityManager, 'Blog\Entity\Category'));

        $this->add(array(
            'name' => 'label',
            'type' => 'Text',
            'options' => array(
            'label' => 'Nom de la catégorie',
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
                'required' => false,
            ),
        );
    }
}