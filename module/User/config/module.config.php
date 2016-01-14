<?php

namespace User;

return array(
	// Doctrine
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),
    'zfcuser' => array(
            // telling ZfcUser to use our own class
            'user_entity_class'       => 'User\Entity\User',
            // telling ZfcUserDoctrineORM to skip the entities it defines
            'enable_default_entities' => false,
    ),
);
