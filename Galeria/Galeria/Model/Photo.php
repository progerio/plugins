<?php


class Photo extends GaleriaAppModel{
	public $tablePrefix = 'gallery_';
	public $actsAs = array('Encoder');
	
	 

	
	public function beforeValidate($options = array()) {
		$error = array();
		$params = $this->data['Photo']['params'];
		$file = $this->data['Photo']['file'];
		$type_file = explode('/', $file['type']);
		$type_file = $type_file[0];
		
		if ((isset($file['error']) && $file['error'] != 0)){
			$error['file'] = array("É necessário enviar uma imagem!");
		}
		if($type_file <> 'image'){
			$error['file'] = array("O arquivo carregado não é uma imagem!");
		}
		
		if (empty($params['title']) ) {
			$error['params']['title'] = array('Este campo não pode ser deixado em branco.');
		}
		if (empty($params['description']) ) {
			$error['params']['description'] = array('Este campo não pode ser deixado em branco.');
		}
		if(empty($error)){
			return true;
		}else{
			
			$this->validationErrors = $error;
			unset($error);
		}

	}

	public function beforeSave($options = array()){
			
		$this->data['Photo']['params'] = json_encode($this->data['Photo']['params']);
	}
	
	
	
// 	public function isUploaded($params = array()){
// 		if ((isset($params['error']) && $params['error'] == 0) ||
// 				(!empty( $params['tmp_name']) && $params['tmp_name'] != 'none'  ) ) {
// 			return is_uploaded_file($params['tmp_name']);
// 		}
// 		return false;
// 	}
		
		
	
	
}
?>