<?php

namespace Admin\Form\Fieldset;

use Blog\Entity\Post;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Blog\Entity\Category;

class PostFilterFieldset extends Fieldset implements InputFilterProviderInterface
{
    private $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('filter-post');

        $this->entityManager = $entityManager;
        $this->setHydrator(new DoctrineHydrator($entityManager, 'Admin\Entity\Post'));

        $this->add(array(
            'name' => 'title',
            'type' => 'Text',
            'options' => array(
            'label' => 'Titre',
            ),
            
        ));

        $this->add(
            array(

                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'name' => 'category',

                'options' => array(

                        'object_manager' => $entityManager,
                        'label' => 'Catégorie',
                        'target_class'   => 'Blog\Entity\Category',
                        'display_empty_item' => true,
                        'empty_item_label'   => '',
                        'property'       => 'label',
                        'is_method' => true,
                        'find_method'        => array(
                                'name'   => 'getAllOrderBylabel',
                        ),
                ),
                'allow_empty'  => true,
                'required'     => false,
                'attributes' => array(
                        'id' => 'categoryList',
                        'multiple' => false,


                )
            )
         );
     
        $this->add(array(
             'type' => 'Zend\Form\Element\Select',
             'name' => 'deleted',
             'options' => array(
                     'label' => 'Publier ?',
                     'value_options' => array(
                             '0' => 'oui',
                             '1' => 'non',
                     ),
             )
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
            
            'title' => array(
                'required' => false,
            ),
            'category' => array(
                'required' => false,
            ),
            'deleted' => array(
                'required' => false,
            ),
        );
    }
}