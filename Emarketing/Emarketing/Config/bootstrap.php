<?php
Croogo::hookRoutes('Emarketing');

// Croogo::hookHelper('Attachments', 'Tinymce.Tinymce');
/**
 * Admin menu (navigation)
 */
CroogoNav::add('emarketing', array(
    'title' => __('Emarketing'),
    'icon'=> 'envelope large',
    'url' => array(
        'admin' => true,
        'plugin' => 'emarketing',
        'controller' => 'mailings',
        'action' => 'index'
    ),
    'weight' => 30,
));

Croogo::mergeConfig('Wysiwyg.actions', array(
    'Mailings/admin_add' => array(
        array(
            'elements' => 'MailingBody',
            'preset' => 'standard'
        ),
        
    ),
    'Mailings/admin_edit'=>array(
    array(
        'elements' => 'MailingBody',
        'preset' => 'standard'
    )
    )
));