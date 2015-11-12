<?php

class GaleriaActivation {
	
	public function beforeActivation(&$controller) {
		$sql = file_get_contents(APP.'Plugin'.DS.'Galeria'.DS.'Config'.DS.'gallery.sql');
		if(!empty($sql)){
			App::uses('File', 'Utility');
			App::import('Model', 'ConnectionManager');
			$db = ConnectionManager::getDataSource('default');

			$statements = explode(';', $sql);

			foreach ($statements as $statement) {
				if (trim($statement) != '') {
					$db->query($statement);
				}
			}
		}
		return true;
	}

	public function onActivation(&$controller) {

		$controller->Croogo->addAco('Galerias');
		$controller->Croogo->addAco('Galerias/admin_index', array('admin'));
		$controller->Croogo->addAco('Galerias/admin_addPhoto', array('admin'));
		$controller->Croogo->addAco('Galerias/admin_addGallery', array('admin'));
		$controller->Croogo->addAco('Galerias/viewGallery', array('public'));

		// Main menu: add an FlashRotator link
		$mainMenu = $controller->Link->Menu->findByAlias('main');
		$controller->Link->Behaviors->attach('Tree', array(
			'scope' => array(
				'Link.menu_id' => $mainMenu['Menu']['id'],
		),
		));
		$controller->Link->save(array(
			'menu_id' => $mainMenu['Menu']['id'],
			'title' => 'Gallery',
			'link' => 'plugin:galeria/controller:galerias/action:index',
			'status' => 1,
			'class' => 'galerias',
		));
	}

	public function beforeDeactivation(&$controller) {

		$sql = file_get_contents(APP.'Plugin'.DS.'Galeria'.DS.'Config'.DS.'gallery_deactivate.sql');
		if(!empty($sql)){
			App::uses('File', 'Utility');
			App::import('Model', 'ConnectionManager');
			$db = ConnectionManager::getDataSource('default');
			$statements = explode(';', $sql);

			foreach ($statements as $statement) {
				if (trim($statement) != '') {
					$db->query($statement);
				}
			}
		}
		return true;
	}

	public function onDeactivation(&$controller) {
		// ACL: remove ACOs with permissions
		$controller->Croogo->removeAco('Galeria'); // FlashrotatorController ACO and it's actions will be removed

		// Main menu: delete Example link
		$link = $controller->Link->find('first', array(
			'conditions' => array(
				'Menu.alias' => 'main',
				'Link.link' => 'plugin:galeria/controller:galerias/action:index',
		),
		));
		$controller->Link->Behaviors->attach('Tree', array(
			'scope' => array(
				'Link.menu_id' => $link['Link']['menu_id'],
		),
		));
		if (isset($link['Link']['id'])) {
			$controller->Link->delete($link['Link']['id']);
		}
	}
}
?>