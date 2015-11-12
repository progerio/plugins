<?php

App::uses('RevistaAppController', 'Revista.Controller');

/**
 * Edicoes Controller
 *
 */
class EditionsController extends RevistaAppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->unlockedActions[] = 'admin_toggle';
        $this->Security->unlockedActions[] = 'admin_add';
    }

    public function beforeRender() {
        parent::beforeRender();
        $conditions = array('conditions' => array('Edition.status' => 1), 'order' => 'Edition.id DESC');
        $result = $this->Edition->find('all', $conditions);
        foreach ($result as $k => $val) {
            $menu[$k]['edicao'] = $val['Edition']['id'];
            $menu[$k]['titulo'] = $val['Edition']['titulo'];
        }
        $this->set('menuEdicoes', $menu);
    }

    public function afterConstruct() {
        parent::afterConstruct();
        $this->_setupAclComponent();
    }

    public function admin_index() {
        $this->paginate['Edition']['limit'] = 10;
        $this->set('editions', $this->paginate());
    }

    public function admin_add($id = null) {
        if ($this->request->data) {
            if ($this->Edition->save($this->request->data)) {
                $this->Session->setFlash('Edição cadastrada com sucesso!', 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'admin_index'));
            }
        }
        if ($id) {
            $this->request->data = $this->Edition->read(null, $id);
        }
    }

    public function admin_toggle($id = null, $status = null) {
        $this->Croogo->fieldToggle($this->Edition, $id, $status);
    }

    public function admin_process() {
        $action = $this->request->data['Edition']['action'];
        $ids = array();
        foreach ($this->request->data['Edition'] as $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }

        if (count($ids) == 0 || $action == null) {
            $this->Session->setFlash(__d('croogo', 'No items selected.'), 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'index'));
        }

        $actionProcessed = $this->Edition->processAction($action, $ids);
        $eventName = 'Controller.Editions.after' . ucfirst($action);

        if ($actionProcessed) {
            switch ($action) {
                case 'delete':
                    $messageFlash = __d('croogo', 'Edições excluidas!');
                    break;
                case 'publish':
                    $messageFlash = __d('croogo', 'Edições publicadas!');
                    break;
                case 'unpublish':
                    $messageFlash = __d('croogo', 'Edições despublicadas');
                    break;
            }
            $this->Session->setFlash($messageFlash, 'default', array('class' => 'success'));
            Croogo::dispatchEvent($eventName, $this, compact($ids));
        } else {
            $this->Session->setFlash(__d('croogo', 'An error occurred.'), 'default', array('class' => 'error'));
        }
        $this->redirect(array('action' => 'index'));
    }

    public function admin_links() {
        if (isset($this->request->query['edition_id'])) {
            $editionId = $this->request->query['edition_id'];
        }
        if (empty($editionId)) {
            $this->redirect(array(
                'controller' => 'editions',
                'action' => 'index',
            ));
            return;
        }
        $this->loadModel('Revista.Link');
        $editions = $this->Edition->findById($editionId);
       
        if (!isset($editions['Edition']['id'])) {
            $this->redirect(array(
                'controller' => 'editions',
                'action' => 'index',
            ));
            return;
        }
        $this->set('title_for_layout', __d('croogo', 'Links: %s', $editions['Edition']['title']));

        $this->Link->recursive = 0;
        $linksTree = $this->Link->generateTreeList(array(
            'Link.edition_id' => $editionId,
        ));
        $linksStatus = $this->Link->find('list', array(
            'conditions' => array(
                'Link.edition_id' => $menuId,
            ),
            'fields' => array(
                'Link.id',
                'Link.status',
            ),
        ));
        $this->set(compact('linksTree', 'linksStatus', 'editions'));
    }

    public function admin_links_add($menuId = null) {
        $this->set('title_for_layout', __d('croogo', 'Add Link'));

        if (!empty($this->request->data)) {
            $this->Link->create();
            $this->request->data['Link']['visibility_roles'] = $this->Link->encodeData($this->request->data['Role']['Role']);
            $this->Link->Behaviors->attach('Tree', array(
                'scope' => array(
                    'Link.menu_id' => $this->request->data['Link']['menu_id'],
                ),
            ));
            if ($this->Link->save($this->request->data)) {
                $this->Session->setFlash(__d('croogo', 'The Link has been saved'), 'default', array('class' => 'success'));
                if (isset($this->request->data['apply'])) {
                    $this->redirect(array('action' => 'edit', $this->Link->id));
                } else {
                    $this->redirect(array(
                        'action' => 'index',
                        '?' => array(
                            'menu_id' => $this->request->data['Link']['menu_id']
                        )
                    ));
                }
            } else {
                $this->Session->setFlash(__d('croogo', 'The Link could not be saved. Please, try again.'), 'default', array('class' => 'error'));
            }
        }
        $menus = $this->Link->Menu->find('list');
        $roles = $this->Role->find('list');
        $parentLinks = $this->Link->generateTreeList(array(
            'Link.menu_id' => $menuId,
        ));
        $this->set(compact('menus', 'roles', 'parentLinks', 'menuId'));
    }

    public function admin_links_edit($id = null) {
        $this->set('title_for_layout', __d('croogo', 'Edit Link'));

        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__d('croogo', 'Invalid Link'), 'default', array('class' => 'error'));
            $this->redirect(array(
                'controller' => 'menus',
                'action' => 'index',
            ));
        }
        if (!empty($this->request->data)) {
            $this->request->data['Link']['visibility_roles'] = $this->Link->encodeData($this->request->data['Role']['Role']);
            $this->Link->Behaviors->attach('Tree', array(
                'scope' => array(
                    'Link.menu_id' => $this->request->data['Link']['menu_id'],
                ),
            ));
            if ($this->Link->save($this->request->data)) {
                $this->Session->setFlash(__d('croogo', 'The Link has been saved'), 'default', array('class' => 'success'));
                if (isset($this->request->data['apply'])) {
                    $this->redirect(array('action' => 'edit', $this->Link->id));
                } else {
                    $this->redirect(array(
                        'action' => 'index',
                        '?' => array(
                            'menu_id' => $this->request->data['Link']['menu_id']
                        )
                    ));
                }
            } else {
                $this->Session->setFlash(__d('croogo', 'The Link could not be saved. Please, try again.'), 'default', array('class' => 'error'));
            }
        }
        if (empty($this->request->data)) {
            $data = $this->Link->read(null, $id);
            $data['Role']['Role'] = $this->Link->decodeData($data['Link']['visibility_roles']);
            $this->request->data = $data;
        }
        $menus = $this->Link->Menu->find('list');
        $roles = $this->Role->find('list');
        $menu = $this->Link->Menu->findById($this->request->data['Link']['menu_id']);
        $parentLinks = $this->Link->generateTreeList(array(
            'Link.menu_id' => $menu['Menu']['id'],
        ));
        $menuId = $menu['Menu']['id'];
        $this->set(compact('menus', 'roles', 'parentLinks', 'menuId'));
    }

    public function index() {
        $edicao = null;
        $result = array();
        $this->layout = 'volume';
        if (isset($this->request->params['named']['edicao'])) {
            $edicao = $this->request->params['named']['edicao'];
        }
        if ($edicao) {
            $conditions = array('conditions' => array('Edition.id' => $edicao));
        } else {
            $conditions = array('conditions' => array('Edition.status' => 1), 'order' => 'Edition.id DESC');
        }
        $result = $this->Edition->find('all', $conditions);
        if ($result) {
            $edicao_atual = $result[0];
            $this->set('edicaoAtual', $edicao_atual);
        }
    }

     public function paginas($conteudo = 'apresentacao', $edicao= 1 ) {
        $this->layout = 'volume';
        $this->set('edicao', $edicao);
        $this->render('paginas/' . $conteudo);
    }

    public function links() {
        
    }

}
