<?php
App::uses('AppController', 'Controller');

class EmarketingAppController extends AppController {

    public $components = array(
        'Paginator',
        'Emarketing.ComFile'
    );

    public $helpers = array(
        'Js',
        'Ckeditor.Ckeditor'
    );

    public $uses = array(
        'Emarketing.Mailing',
        'Emarketing.Contact',
        'Emarketing.Outbox',
        'Emarketing.Sent'
    );

    public function beforeFilter() {
        parent::beforeFilter();
        Configure::write('debug', 2);
        $this->Security->unlockedActions[] = 'admin_toggle';
        $this->Security->unlockedActions[] = 'admin_add';
        $this->Security->unlockedActions[] = 'admin_send';
        $this->Security->unlockedActions[] = 'admin_sender';
    }

    public function admin_toggle($id = null, $status = null) {
        $this->Croogo->fieldToggle($this->{$this->modelClass}, $id, $status);
    }
}
