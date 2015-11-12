<?php

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class GaleriasController extends GaleriaAppController {

    public $uses = array('Galeria.Galeria', 'Galeria.Photo');
    public $helpers = array('Filemanager', 'Text', 'Galeria.Upload');
    public $uploadsDir = 'uploads';
    public $galleryDir = 'gallery';
    public $layout = 'admin';
    public $paginate = array(
        'Galeria' => array('limit' => 10, 'order' => 'id ASC', 'conditions' => array('status' => 0)),
        'Photo' => array('limit' => 10, 'order' => 'id ASC', 'conditions' => array('status' => 0))
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->allowedActions = 'admin_importar';
        $this->Security->validatePost = false;
    }

    public function viewGallery($gallery_id) {
        $gallery['Config'] = $this->Galeria->find('first', array('conditions' => array('Galeria.id' => $gallery_id)));
        $gallery['Photos'] = $this->Photo->find('all', array('conditions' => array('Photo.gallery_id' => $gallery_id)));
        return $gallery;
    }

    public function admin_index() {
        if (isset($this->params['named']['gallery'])) {
            $Photos = $this->paginate('Photo', array('gallery_id' => $this->params['named']['gallery']));

            $Gallery = $this->Galeria->findById($this->params['named']['gallery']);
            $this->set('title_for_layout', 'Galeria ' . $Gallery['Galeria']['title']);
            $this->set('slug_gallery', $Gallery['Galeria']['slug']);
            $this->set('attachments', $Photos);
        } else {
            $this->set('title_for_layout', 'Galerias');
            $this->set('attachments', $this->paginate('Galeria'));
        }
    }

    public function admin_addPhoto() {
        $this->set('title_for_layout', __('Adicionar Foto'));
        if (isset($this->request->params['named']['gallery'])) {
            $checkGallery = $this->Galeria->findById($this->request->params['named']['gallery']);
        }
        //pr($checkGallery['Gallery']);
        if ($this->request->data) {
            // check dir
            //pr($this->request->data);exit();
            $dirCheck = WWW_ROOT . $this->uploadsDir . DS . $this->galleryDir . DS . $checkGallery['Galeria']['slug'];
            if (!file_exists($dirCheck)) {
                $dirGalleryCreate = new Folder(WWW_ROOT . $this->uploadsDir . DS . $this->galleryDir . DS . $checkGallery['Galeria']['slug'], true, 0777);
                if (file_exists($dirCheck)) {
                    $dirGalleryCreateThumb = new Folder(WWW_ROOT . $this->uploadsDir . DS . $this->galleryDir . DS . $checkGallery['Galeria']['slug'] . DS . 'thumb', true, 0777);
                }
            }
            if (file_exists($dirCheck)) {
                $file = $this->request->data['Photo']['file'];
                //unset($this->request->data['Photo']['file']);
                // check if file with same path exists
                $destination = $dirCheck . DS . $file['name'];
                if (file_exists($destination)) {
                    $newFileName = String::uuid() . '-' . $file['name'];
                    $destination = $dirCheck . DS . $newFileName;
                } else {
                    $newFileName = $file['name'];
                }
                // remove the extension for title
                if (explode('.', $file['name']) > 0) {
                    $fileTitleE = explode('.', $file['name']);
                    array_pop($fileTitleE);
                    $fileTitle = implode('.', $fileTitleE);
                } else {
                    $fileTitle = $file['name'];
                }

                $this->request->data['Photo']['mime_type'] = $file['type'];
                $this->request->data['Photo']['params']['path'] = '/' . $this->uploadsDir . '/' . $this->galleryDir . '/' . $checkGallery['Galeria']['slug'] . '/' . $newFileName;
                $this->request->data['Photo']['params']['thumb'] = '/' . $this->uploadsDir . '/' . $this->galleryDir . '/' . $checkGallery['Galeria']['slug'] . '/thumb/' . $newFileName;
                $this->Photo->create();
                if ($this->Photo->save($this->request->data)) {
                    // move the file
                    move_uploaded_file($file['tmp_name'], $destination);
                    $this->Session->setFlash('Foto adicionada com sucesso!', 'default', array('class' => 'success'));
                    $this->redirect(array('action' => 'index', 'gallery' => $this->request->params['named']['gallery']));
                }
            }
        }
    }

    public function admin_editPhoto($id = NULL) {
        $this->set('title_for_layout', __('Editar Foto'));
        if ($this->request->data && $this->request->is('post')) {
            if ($this->Photo->save($this->request->data)) {
                $this->Session->setFlash('Foto editada com sucesso.', 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'index', 'gallery' => $this->params['named']['gallery']));
            } else {
                $this->Session->setFlash('Não foi possivel editar a foto, tente novamente.', 'default', array('class' => 'error'));
                $this->redirect(array('action' => 'index', 'gallery' => $this->params['named']['gallery']));
            }
        }
        if ($id) {
            $this->Photo->id = $id;
            $this->request->data = $this->Photo->read();
            $this->request->data['Photo']['params'] = $this->Photo->decodeData($this->request->data['Photo']['params']);
        }
    }

    public function admin_addGallery($id = NULL) {
        $this->set('title_for_layout', 'Adicionar Galeria');
        if ($this->request->is('post') && $this->request->data) {
            //$this->request->data['Galeria']['params'] = $this->Galeria->encodeData($this->request->data['Galeria']['params'], array('json' => true,'trim' => false));
            //pr($this->request->data);exit();
            if ($this->Galeria->save($this->request->data)) {
                if ($id) {
                    $this->Session->setFlash('Galeria editada com sucesso.', 'default', array('class' => 'success'));
                } else {
                    $this->Session->setFlash('Galeria criada com sucesso.', 'default', array('class' => 'success'));
                }
                $this->redirect(array('action' => 'index'));
            }
        }

        if ($this->request->is('get') && $id) {
            $this->Galeria->id = $id;
            $this->request->data = $this->Galeria->read();
            $this->request->data['Galeria']['params'] = $this->Galeria->decodeData($this->request->data['Galeria']['params']);
            //pr($this->data);exit();
        }
    }

    public function admin_deletePhoto($id = null) {
        if (!$id && !$this->request->is('get')) {
            $this->Session->setFlash('Foto inválida!', 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'index'));
        }

        $attachment = $this->Photo->find('first', array(
            'conditions' => array(
                'Photo.id' => $id,
            ),
                ));
        if (isset($attachment['Photo'])) {
            $attachment['Photo']['id'] = $id;
            $attachment['Photo']['status'] = 1;
            if ($this->Photo->save($attachment)) {
                $this->Session->setFlash('Foto apagada!', 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'index', 'gallery' => $this->request->params['named']['gallery']));
            }
        } else {
            $this->Session->setFlash('Impossivel apagar a foto!', 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'index', 'gallery' => $this->request->params['named']['gallery']));
        }
    }

    public function admin_deleteGallery($id = null) {
        if (!$id && !$this->request->is('get')) {
            $this->Session->setFlash('Galeria inválida!', 'default', array('class' => 'error'));
            $this->redirect(array('action' => 'index'));
        }
        $attachment = $this->Galeria->find('first', array('conditions' => array('id' => $id)));
        if ($attachment <> null) {
            $attachment['Galeria']['id'] = $id;
            $attachment['Galeria']['status'] = 1;
            if ($this->Galeria->save($attachment)) {
                $this->Session->setFlash('Galeria apagada!', 'default', array('class' => 'success'));
                $this->redirect(array('controller' => 'galerias', 'action' => 'index'));
            }
        } else {
            $this->Session->setFlash('Impossivel apagar a galeria!', 'default', array('class' => 'error'));
            $this->redirect(array('controller' => 'galerias', 'action' => 'index'));
        }
    }

    /**
     * Importa imagens zipadas
     *
     */
    public function admin_importar() {
        $checkGallery = array();
        if (isset($this->request->params['named']['gallery'])) {
            $checkGallery = $this->Galeria->findById($this->request->params['named']['gallery']);
        }

        if ($this->request->is('post') && $this->request->data) {

            $path = WWW_ROOT . $this->uploadsDir . DS . $this->galleryDir . DS . $checkGallery['Galeria']['slug'];

            $folder = new Folder($path, true, 0777);
            $fileName = $this->request->data['Photo']['file'];

            $Zip = new ZipArchive();

            if ($Zip->open($fileName['tmp_name'], ZIPARCHIVE::FL_COMPRESSED) === true) {
                $Zip->extractTo($folder->pwd());
                $Zip->close();
            } else {
                throw new CakeException(__('Falha ao extrair as imagens!'));
            }

            $Files = $folder->find('.*\.png|jpg|gif|bmp', true);
            $data = array();
            foreach ($Files as $key => $file) {
                $data['Photo']['gallery_id'] = $checkGallery['Galeria']['id'];
                $data['Photo']['params']['title'] = 'Titulo' . $key;
                $data['Photo']['params']['description'] = 'Descrição' . $key;
                $data['Photo']['params']['categoria'] = null;
                $data['Photo']['params']['comentario'] = null;
                $data['Photo']['params']['link'] = null;
                $data['Photo']['params']['link'] = 'Titulo' . $key;
                $type = explode('.', $file);
                $data['Photo']['mime_type'] = $type[1];
                $data['Photo']['params']['path'] = '/' . $this->uploadsDir . '/' . $this->galleryDir . '/' . $checkGallery['Galeria']['slug'] . '/' . $file;
                $data['Photo']['params']['thumb'] = '/' . $this->uploadsDir . '/' . $this->galleryDir . '/' . $checkGallery['Galeria']['slug'] . '/thumb/' . $file;
                $this->Photo->save($data);
                    
                }

                $this->Session->setFlash("Importação Realizada com sucesso!");
                $this->redirect(array('action' => 'index', 'gallery' => $this->request->params['named']['gallery']));
        }

        $this->set('title_for_layout', __('Importar Fotos'));
    }

}