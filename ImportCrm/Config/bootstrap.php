<?php
Croogo::hookRoutes('ImportCrm');

CroogoNav::add('importcrm', array(
    'icon' => 'th',
    'title' => 'Import CRM',
    'url' => array(
        'admin' => true,
        'plugin' => 'import_crm',
        'controller' => 'Importcrms',
        'action' => 'index'
    ),
    'weight' => 20
));