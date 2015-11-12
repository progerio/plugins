<?php

App::uses('AppController', 'Controller');

class RevistaAppController extends AppController {
    
    public  $helpers = array('Ckeditor.Ckeditor');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->unlockedActions[] = 'admin_toggle';
    }

}
