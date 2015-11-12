<?php

App::uses('RevistaAppController', 'Revista.Controller');

/**
 * Artigos Controller
 *
 */
class ArtigosController extends RevistaAppController {

    public $types = array('application/pdf', 'application/msword');
    public $components = array('Curso.Upload');

    public function afterConstruct() {
        parent::afterConstruct();
        $this->_setupAclComponent();
    }

    public function beforeFilter() {
        parent::beforeFilter();
        Configure::write('debug', 2);
        $this->Security->unlockedActions[] = 'admin_toggle';
        $this->Security->unlockedActions[] = 'admin_add';
//        $this->Security->requirePost[] = 'admin_moveup';
//        $this->Security->requirePost[] = 'admin_movedown';
    }

    public function admin_index() {
        $edicao_id = $this->request->params['named']['edicao'];

        if (!$edicao_id) {
            $this->redirect(array('controller' => 'edtions', 'action' => 'index'));
        }

        $this->paginate['Artigo']['limit'] = 10;
        $this->paginate['Artigo']['conditions'] = array('Artigo.edicao_id' => $edicao_id);
        $result = $this->paginate();
        $this->set('edicao_id', $edicao_id);
        $this->set('Artigos', $result);
    }

    public function admin_add($id = null) {
        $this->loadModel('Revista.Edition');
        $edicao_id = null;
        if (isset($this->request->params['named']['edicao'])) {
            $result = $this->Edition->findById($this->request->params['named']['edicao']);
            if ($result) {
                $edicao_id = $result['Edition']['id'];
            }
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            
            if (empty($this->request->data['Artigo']['weight'])) {
                $result = $this->Artigo->find('all', array('conditions' => array('Artigo.edicao_id' => $edicao_id), 'order' => 'Artigo.weight DESC', 'limit' => 1));
                if (!empty($result)) {
                    $weight = Hash::extract($result, '{n}.Artigo.weight');
                    $this->request->data['Artigo']['weight'] = $weight[0] + 1;
                }
            }

            if (isset($this->request->data['Artigo']['arquivo']['tmp_name']) && $this->request->data['Artigo']['arquivo']['tmp_name']) {
                if ($this->_upload($this->request->data['Artigo'])) {
                    $this->request->data['Artigo']['arquivo'] = $this->request->data['Artigo']['arquivo']['name'];
                }
            } else {
                unset($this->request->data['Artigo']['arquivo']);
            }

            if ($this->Artigo->save($this->request->data)) {
                $this->Session->setFlash('Artigo cadastrado com sucesso', 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'admin_index', 'edicao' => $edicao_id));
            }
        }

        if ($this->request->is('get')) {
            $this->request->data = $this->Artigo->read(null, $id);
        }

        $this->set('edicao_id', $edicao_id);
    }

    public function admin_toggle($id = null, $status = null) {
        $this->Croogo->fieldToggle($this->Artigo, $id, $status);
    }

    public function admin_process() {
        $action = $this->request->data['Artigo']['action'];
        $edicao_id = $this->request->data['Artigo']['edicao_id'];
        $ids = array();
        foreach ($this->request->data['Artigo'] as $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }

        if (count($ids) == 0 || $action == null) {
            $this->Session->setFlash(__d('croogo', 'No items selected.'), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'index', 'edicao' => $edicao_id));
        }

        $actionProcessed = $this->Artigo->processAction($action, $ids);
        $eventName = 'Controller.Artigos.after' . ucfirst($action);

        if ($actionProcessed) {
            switch ($action) {
                case 'delete':
                    $messageFlash = __d('croogo', 'Artigos excluidos!');
                    break;
                case 'publish':
                    $messageFlash = __d('croogo', 'Artigos publicados!');
                    break;
                case 'unpublish':
                    $messageFlash = __d('croogo', 'Artigos despublicados!');
                    break;
            }
            $this->Session->setFlash($messageFlash, 'default', array('class' => 'success'));
            Croogo::dispatchEvent($eventName, $this, compact($ids));
        } else {
            $this->Session->setFlash(__d('croogo', 'An error occurred.'), 'default', array('class' => 'error'));
        }

        $this->redirect(array('action' => 'index', 'edicao' => $edicao_id));
    }

    /**
     * Atualiza a linha para posição anterior.
     * @param int $id
     * @param int $step
     */
    public function admin_moveup($id, $edicao = null, $step = 1) {
        $message = __('Não Pode ser movido!');
        $class = 'error';
        if ($this->Artigo->moveUp($id, $step)) {
            $message = __('Movido com sucesso!');
            $class = 'success';
        }
        $this->Session->setFlash($message, 'default', array('class' => $class));
        $this->redirect(array('action' => 'index', 'edicao' => $edicao));
    }

    /**
     * Atualiza a linha para uma posição posterior.
     * @param int $id
     * @param int $step
     */
    public function admin_movedown($id, $edicao = null, $step = 1) {
        $message = __('Não Pode ser movido!');
        $class = 'error';
        if ($this->Artigo->moveDown($id, $step)) {
            $message = __('Movido com sucesso!');
            $class = 'success';
        }
        $this->Session->setFlash($message, 'default', array('class' => $class));
        $this->redirect(array('action' => 'index', 'edicao' => $edicao));
    }

    protected function _upload($file = array()) {
        if (!empty($file['arquivo']['tmp_name'])) {
            if (in_array($file['arquivo']['type'], $this->types)) {
                $folder = new Folder(WWW_ROOT . 'uploads' . DS . 'revista' . DS . $file['edicao_id'], true, 0777);
                $arquivo = strtolower( preg_replace('/[[:space:][:punct:]]/', '-', $file['arquivo']['name']) );
                $destination = $folder->pwd() . DS . $arquivo;
                if (move_uploaded_file($file['arquivo']['tmp_name'], $destination)) {
                    return true;
                }
            }
        }
        return;
    }


}
