<?php

namespace Admin\Form\Fieldset;

use Blog\Entity\Comment;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\EntityManager;

class CommentFilterFieldset extends Fieldset implements InputFilterProviderInterface
{
    private $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('filter-comment');

        $this->entityManager = $entityManager;
        $this->setHydrator(new DoctrineHydrator($entityManager, 'Blog\Entity\Comment'));

        $this->add(
            array(

                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'name' => 'post',

                'options' => array(
                        'object_manager' => $entityManager,
                        'label' => 'Article',
                        'target_class'   => 'Blog\Entity\Post',
                        'display_empty_item' => true,
                        'empty_item_label'   => '',
                        'property'       => 'title',
                        'is_method' => true,
                        'find_method'        => array(
                                'name'   => 'getOpenOrderByTitle',
                        ),
                ),
                'allow_empty'  => true,
                'required'     => false,
                'attributes' => array(
                        'id' => 'post-list',
                        'multiple' => false,
                )
            )
         );
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
            
            'post' => array(
                'required' => false,
            ),
        );
    }
}