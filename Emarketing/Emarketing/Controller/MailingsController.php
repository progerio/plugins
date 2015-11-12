<?php
/**
 * Mensagens Controller
 *
 * @author Paulo Rogério Rodrigues <paulo.rogeriobr@gmail.com>
 */
App::uses('CakeEmail', 'Network/Email');
App::uses('EmarketingAppController', 'Emarketing.Controller');
App::uses('Attachments', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('ComFile', 'Emarketing.Controller/Component');

class MailingsController extends EmarketingAppController {

    public function admin_index() {
        
        $this->Paginator->settings['Mailing']['limit'] = 20;
        $this->Paginator->settings['Mailing']['order'] = 'Mailing.title';
        $result = $this->Paginator->paginate('Mailing', array(
            'Mailing.status' => 1
        ));
        $this->set('marketings', $result);
    }

    public function admin_add() {
        $params = array();

        if ($this->request->is('post')) {
            $params = $this->request->data[$this->modelClass];
            if (ComFileComponent::isUploaded($params['file'])) {
                if (ComFileComponent::create($params)) {
                    $title = Inflector::slug($this->request->data['Mailing']['title'], '-');
                    $filename = $this->request->data['Mailing']['file']['name'];
                    $imported = WWW_ROOT . 'uploads' . DS . 'marketing' . DS . $title . DS . $filename;
                    unset($params['file']);
                    $this->Mailing->id = null;
                    $this->Mailing->save($params);
                    
                    $row = 1;
                    $handle = fopen($imported, "r");
                    $dados = array();
                    $outbox = array();
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        
                        $separator = explode(';', $data[0]);
                        if (count($separator) == 2) {
                            $contact = $this->verifyContact($separator[0], $separator[1]);
                            if (! $contact) {
                                $dados[$row]['Contact']['nome'] = $separator[0];
                                $dados[$row]['Contact']['email'] = $separator[1];
                                $dados[$row]['Contact']['status'] = 1;
                            }
                            
                            $outbox[$row]['Outbox']['mailing_id'] = $this->Mailing->id;
                            $outbox[$row]['Outbox']['nome'] = $separator[0];
                            $outbox[$row]['Outbox']['to'] = $separator[1];
                            $outbox[$row]['Outbox']['subject'] = $params['title'];
                            $outbox[$row]['Outbox']['body'] = $params['body'];
                            $outbox[$row]['Outbox']['status'] = 0;
                        }
                        $row ++;
                    }
                    
                    $this->Contact->saveAll($dados);
                    $this->Outbox->saveAll($outbox);
                    
                    $this->redirect(array(
                        'action' => 'admin_next',
                        'mailing' => $this->Mailing->id
                    ));
                }
            }
        }
        // pr($this->request->params);exit();
    }

    public function admin_edit($id = null) {
        $this->set('title_for_layout', __d('croogo', 'Edit Mailings'));
        
        if (! $id && empty($this->request->data)) {
            $this->Session->setFlash(__d('croogo', 'Invalid Message'), 'default', array(
                'class' => 'error'
            ));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if (! empty($this->request->data)) {
            $this->request->data['Mailing']['status'] = 1;
            if ($this->Mailing->save($this->request->data)) {
                $this->Session->setFlash(__d('croogo', 'Mensagem Alterada com Sucesso!'), 'default', array(
                    'class' => 'success'
                ));
                $this->Croogo->redirect(array(
                    'action' => 'edit',
                    $this->Mailing->id
                ));
            } else {
                $this->Session->setFlash(__d('croogo', 'Mensagem não pode ser salva. Por favor tente novamente!'), 'default', array(
                    'class' => 'error'
                ));
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Mailing->read(null, $id);
        }
    }

    public function admin_next() {
        $mailing_id = $this->request->params['named']['mailing'];
        if ($mailing_id) {
            $this->Paginator->settings['limit'] = 10;
            $result = $this->Paginator->paginate('Outbox', array(
                'Outbox.mailing_id' => $mailing_id
            ));
             $mailing = $this->Mailing->find('first', array(
                'conditions' => array(
                    'Mailing.id' => $mailing_id
                )
            ));
            if ($mailing) {
                $this->set('mailing', $mailing);
            }
            if (! empty($result)) {
                $this->set('mailing_id', $mailing_id);
                $this->set('mailings', $result);
            }
        }
    }

    public function verifyContact($name, $mail) {
        if (isset($name) && isset($mail)) {
            $conditions = array(
                'conditions' => array(
                    'Contact.email' => $mail
                )
            );
            $result = $this->Contact->find('first', $conditions);
            if (! empty($result)) {
                return $result;
            }
            return false;
        }
        return false;
    }

    public function admin_send() {
        if ($this->request->data) {
            $request = $this->request->data['Sent'];
            $result = $this->Outbox->find('all', array(
                'conditions' => array(
                    'Outbox.mailing_id' => $request['mailing_id']
                )
            ));
            if (! empty($result)) {
                
                if (isset($request['teste']) && $request['teste']) {
                    $email = new CakeEmail();
                    $email->config('smtp');
                    
                    $count = 10;
                    if(count($result) < $count){
                        $count = count($result);
                    }
                    
                    for ($i = 0; $i < $count; $i++) {
                        $email->from(array(
                            'progerio@castelobranco.br' => 'Croogo Desenvolvimento'
                        ));
                        $email->to('progerio@castelobranco.br');
                        $email->subject($result[$i]['Outbox']['subject']);
                        $email->template('Emarketing.template');
                        $email->emailFormat('html');
                        $email->viewVars(array(
                            'content' => $result[$i]['Outbox']['body'],
                            'subject' => $result[$i]['Outbox']['subject']
                        ));
                        $email->send($result[$i]['Outbox']['body']);
                    }
                    $this->Session->setFlash('E-mails testes enviados!', 'default', array(
                        'class' => 'success'
                    ));
                    
                    $this->redirect(array(
                        'action' => 'admin_next',
                        'mailing' => $request['mailing_id']
                    ));
                } else {
                    $mailing = $this->Mailing->find('first', array(
                        'conditions' => array(
                            'Mailing.id' => $request['mailing_id']
                        )
                    ));
                    $this->redirect(array(
                        'action' => 'admin_sender',
                        'mailing' => $request['mailing_id']
                    ));
                }
            }
        }
    }

    public function admin_sender() {
        $mailing_id = null;
        
        if (isset($this->request->params['named']['mailing']) && $this->request->params['named']['mailing']) {
            $mailing_id = $this->request->params['named']['mailing'];
        }
        if (isset($this->request->query['mailing']) && $this->request->query['mailing']) {
            $mailing_id = $this->request->query['mailing'];
        }
        
        if ($mailing_id) {
            $mailing = $this->Mailing->find('first', array(
                'conditions' => array(
                    'id' => $mailing_id
                )
            ));
            $this->set('mailing', $mailing);
            if ($mailing) {
                $result = $this->Outbox->find('first', array(
                    'conditions' => array(
                        'mailing_id' => $mailing_id
                    )
                ));
                $email = new CakeEmail();
                $email->config('smtp');
                if (!empty($result)) {
                    try {
                        $email->from(array(
                            'progerio@castelobranco.br' => 'Croogo Desenvolvimento'
                        ));
                        $email->to('progerio@castelobranco.br');
                        $email->subject($result['Outbox']['subject']);
                        $email->template('Emarketing.template');
                        $email->emailFormat('html');
                        $email->viewVars(array(
                            'content' => $result['Outbox']['body'],
                            'subject' => $result['Outbox']['subject']
                        ));
                        $email->send($result['Outbox']['body']);
                        $this->Outbox->delete($result['Outbox']['id']);
                        $sent['Sent']['mailing_id'] = $result['Outbox']['mailing_id'];
                        $sent['Sent']['nome'] = $result['Outbox']['nome'];
                        $sent['Sent']['email'] = $result['Outbox']['to'];
                        
                        $this->Sent->save($sent);
                    } catch (Exception $e) {
                        $this->set('error', $e->getMessage());
                    }
                    $this->set('mailing_id', $mailing_id);
                    $this->set('result', $result);
                }else{
                    $this->Mailing->id = $mailing_id;
                    $this->Mailing->saveField('status', 1);
                    $this->Session->setFlash('E-mails enviados com sucesso!', 'default',array('class'=>'success'));
                    $this->redirect(array('action'=>'admin_index'));
                }
            }
        } else {
            $this->Session->setFlash('Não foi possivel enviar o e-mail', 'default', array(
                'class' => "error"
            ));
            $this->redirect(array(
                'admin_index'
            ));
        }
    }

    public function admin_process() {
    	
    }
}
