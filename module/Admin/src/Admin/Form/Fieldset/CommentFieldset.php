<?php

namespace Admin\Form\Fieldset;

use Blog\Entity\Post;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Blog\Entity\Category;

class CommentFieldset extends Fieldset implements InputFilterProviderInterface
{
    private $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('comment');

        $this->entityManager = $entityManager;
        $this->setHydrator(new DoctrineHydrator($entityManager, 'Blog\Entity\Post'));

        $this->add(array(
            'name' => 'comment',
            'type' => 'textarea',
            'options' => array(
                'label' => 'Commentaire',
            ),
        ));

        $this->add(
            array(
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'name' => 'post',

                'options' => array(

                        'object_manager' => $entityManager,
                        'label' => 'Article',
                        'target_class'   => 'Blog\Entity\Post',
                        'property'       => 'title',
                        'is_method' => true,
                        'find_method'        => array(
                            'name'   => 'getAllOrderByTitle',
                        ),
                ),
                'allow_empty'  => false,
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
            
            'comment' => array(
                'required' => true,
            ),
            'post' => array(
                'required' => true,
            ),
           
        );
    }
}