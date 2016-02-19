<?php

namespace Admin\Form\Fieldset;

use Blog\Entity\Post;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Blog\Entity\Category;

class PostCreateFieldset extends Fieldset implements InputFilterProviderInterface
{
    private $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct('post');

        $this->entityManager = $entityManager;
        $this->setHydrator(new DoctrineHydrator($entityManager, 'Admin\Entity\Post'));

        $this->add(array(
            'name' => 'title',
            'type' => 'Text',
            'options' => array(
            'label' => 'Titre',
            ),
            
        ));

        $this->add(array(
            'name' => 'content',
            'type' => 'textarea',
            'options' => array(
            'label' => 'Contenu',
            ),
            
        ));

     /*   $this->add(array(
             'type' => 'Blog\Entity\Category',
             'name' => 'category',
             'options' => array(
                 'label' => 'Catégorie',
             ),
         ));*/

         $this->add(
            array(

                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'name' => 'category',

                'options' => array(

                        'object_manager' => $entityManager,
                        'label' => 'Catégorie',
                        'target_class'   => 'Blog\Entity\Category',
                        'property'       => 'label',
                        'is_method' => true,
                        'find_method'        => array(
                                'name'   => 'getAllOrderBylabel',
                        ),
                ),
                'allow_empty'  => false,
                'required'     => true,
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

        $this->add(array(
            'name' => 'file',
            'type'  => 'Zend\Form\Element\File',
            'options' => array(
                     'label' => 'Photo',
              /*       'validators' => array(
                        array(
                            'name' => '\Application\Validator\Image',
                            'options' => array(
                                    'minSize' => '64',
                                    'maxSize' => '10024',
                                    // 'newFileName' => 'newFileName2',
                                    // 'uploadPath' => '/public/upload/posts'
                            )
                        )
                    )*/
                    /*'validators' => array(
                        array(
                            'name' => 'Zend\Validator\File\Size',
                            'options' => array(
                                // 'min' => 50,
                                'max' => 200000000000000000000000000000,
                            ),
                        ),
                        array(
                            'name' => 'Zend\Validator\File\Extension',
                            'options' => array(
                                'extension' => array('jpg', 'png', 'gif', 'jpeg')
                            ),
                        ),
                    ),*/

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
                'required' => true,
            ),
            'content' => array(
                'required' => true,
            ),
            'category' => array(
                'required' => true,
            ),
            'deleted' => array(
                'required' => false,
            ),
            'photo' => array(
                'required' => false,
            ),
        );
    }
}