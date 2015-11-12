<?php
/**
 * Description of UsersController
 *
 * @author Paulo Rogério <paulo.rogeriobr@gmail.com>
 */
class UsersController extends AtendimentoAppController
{

    public $uses = array();
    public $theme = 'AdminLTE-2.0.3';
    public $username = 'admin';
    public $password = 'password';

    public function login()
    {
        $this->layout = 'login';

        $username = $password = null;
        if ($this->request->is('post')) {
            $username = trim($this->request->data['User']['username']);
            $password = trim($this->request->data['User']['password']);
            if ($username == $this->username && $password == $this->password) {
                $this->Session->write('username', $username);
                $this->log($username . "acessou o sistema em " . date('d/m/Y H:i:s'));
                $this->redirect(array('admin' => true, 'controller' => 'servidores', 'action' => 'index'));
            } else {
                $this->Session->setFlash('Usuário ou senha não está cadastrado!');
                unset($this->request->data);
            }
        }
    }

}