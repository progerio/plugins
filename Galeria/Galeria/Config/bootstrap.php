<?php
/**
 * Routes
 *
 * example_routes.php will be loaded in main app/config/routes.php file.
 */
	Croogo::hookRoutes('Galeria');
/**
 * Admin menu (navigation)
 */
    CroogoNav::add('extensions.children.galeria', array(
        'title' => 'Galerias',
        'url' => '/admin/galeria/galerias/index',
        'children' => array(
            'gallery1' => array(
                'title' => 'Listar Galerias',
                'url' => '/admin/galeria/galerias/index',
            ),
         ),
    ));

