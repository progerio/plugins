<?php
class Galeria extends GaleriaAppModel{
	public $tablePrefix = 'gallery_';
	public $actsAs = array('Encoder');

	public $validate = array(
		'title' => array(
			'rule' => 'notEmpty',
			'message' => 'Este campo não pode ser deixado em branco.',
	),
		'slug' => array(
			'rule' => 'notEmpty',
			'message' => 'Este campo não pode ser deixado em branco.',
	)
	);

	public function beforeValidate($options = array()) {
		$params = $this->data['Galeria']['params'];
		$error = array();
		if (empty($params['width']) ) {
			$error['params']['width'] = array('Este campo não pode ser deixado em branco.');
		} else if ( !is_numeric($params['width']) ) {
			$error['params']['width'] = array('Este campo tem de ser número.');
		}
		if (!empty($params['height']) ){
			if (!is_numeric($params['height'])) {
				$error['params']['height'] = array('Este campo tem de ser número.');
			}
		}
		if(empty($error)){
			return true;
		}else{
			$this->validationErrors = $error;
			unset($error);
		}

	}

	public function beforeSave($options = array()){
		$this->data['Galeria']['params'] = json_encode($this->data['Galeria']['params']);
	}

}
?>