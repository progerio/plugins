<?php

Croogo::hookRoutes('Revista');
CroogoNav::add('revista', array(
    'icon' => array(
        'tags',
        'large'
    ),
    'title' => __('Revista'),
    'weight' => 30,
    'url' => array(
        'admin' => true,
        'plugin' => 'revista',
        'controller' => 'editions',
        'action' => 'index'
    ),
));


Croogo::mergeConfig('Wysiwyg.actions', array(
    'Editions/admin_add' => array(
        array(
            'elements' => 'EditionIntro',
            'preset' => 'standard'
        ),
        array(
            'elements' => 'EditionBanner',
           'preset' => 'standard'
        ),
        array(
            'elements' => 'EditionDescricao',
            'preset' => 'basic'
        ),
//        array(
//            'elements' => 'EditionParams',
//            'toolbar' => array(
//                array('Copy', 'Paste', 'Source'),
//            ),
//        ),
    ),
    'Artigos/admin_add'=>array(
        array(
            'elements'=>'ArtigoResumo',
            'preset'=>'basic'
        ),
        array(
            'elements'=>'ArtigoAutores',
            'preset'=>'basic'
        ),
    ),

));

?>
