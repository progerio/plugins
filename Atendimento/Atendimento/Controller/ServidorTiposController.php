<?php

/**
 * Description of ServidoresController
 *
 * @author Paulo Rogério <progerio@castelobranco.br>
 */
class ServidorTiposController extends AtendimentoAppController
{

    public $uses = array('Atendimento.ServidorTipo');

    /**
     * admin_index
     */
    public function admin_index()
    {
        $servidorTipos = $this->ServidorTipo->pr_sgt_servidor_tipo_con();
        $this->set('servidorTipos', $servidorTipos);
    }

    /**
     * Salva ou atualiza procedure
     * @param type $id
     */
    public function admin_add($id = null)
    {
        $params = array();
        if ($this->request->data) {
            $request = $this->request->data;
            foreach ($request[$this->modelClass] as $key => $value) {
                if (isset($value) && $value) {
                    $params[$key] = $value;
                }
            }
            $output = $message = $class = array();
            //save
            if (!empty($params)) {
                $output = $this->ServidorTipo->pr_sgt_servidor_tipo_ins($params);
            }
            if ($output) {
                $message = $output['prm_tx_retorno'];
                $class = 'danger';
                if ($output['prm_in_sucesso']) {
                    $class = 'success';
                }
                $this->Session->setFlash($message, 'default', array('class' => $class));
            }
            $this->redirect(array('action' => 'index'));
        }
        if ($id) {
            $this->request->data = $this->ServidorTipo->pr_sgt_servidor_tipo_con($id);
            
        }
    }

    /**
     * admin_delete
     * @param type $id
     */
    public function admin_delete($id = null)
    {
        if ($id) {
           $params = array('prm_id_tipo_servidor' =>$id);
            $record = $this->ServidorTipo->pr_sgt_servidor_tipo_del($params);
            $this->Session->setFlash($record['prm_tx_retorno'], 'default', array('class' => 'success'));
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * Remove topicos selecionados
     */
    public function admin_process()
    {
        $checks = $record = array();
        $action = $this->request->data['Process']['action'];
        if ($this->request->data['Process']['action'] && isset($this->request->data['Process']['data'])) {
            foreach ($this->request->data['Process']['data'] as $k => $v) {
                if ($v['check']) {
                    $checks[$k] = $k;
                }
            }
        }
        if ($action == 'delete' && !empty($checks)){
            
            foreach ($checks as $val) {
                $record = $this->ServidorTipo->pr_sgt_servidor_tipo_del($val);
            }
            $this->Session->setFlash('Item(s) removidos com sucesso!', 'default', array('class' => 'success'));
        }
        $this->redirect(array('action' => 'index'));
    }

    /**
     * adicionar e editar
     * @param type $id
     */
    /**
      public function admin_add($id = null)
      {
      if ($this->request->data) {
      $request = $this->request->data;
      $prm_id_tipo_servidor = ($request['ServidorTipo']['id_tipo_servidor']) ? $request['ServidorTipo']['id_tipo_servidor'] : 0;
      $prm_nm_tipo_servidor = $request['ServidorTipo']['nm_tipo_servidor'];
      $output = $message = $class = array();
      //save
      if ($prm_nm_tipo_servidor && !$prm_id_tipo_servidor) {
      $output = $this->ServidorTipo->pr_servidor_tipo_ins($prm_nm_tipo_servidor);
      } else {
      //update
      $params = array(
      'prm_id_tipo_servidor' => $prm_id_tipo_servidor,
      'prm_nm_tipo_servidor' => $prm_nm_tipo_servidor
      );
      $output = $this->ServidorTipo->pr_servidor_tipo_upd($params);
      }

      if ($output) {
      $message = $output['txt_retorno'];
      $class = 'danger';
      if ($output['in_sucesso']) {
      $class = 'success';
      }
      $this->Session->setFlash($message, 'default', array('class' => $class));
      }
      $this->redirect(array('action' => 'index'));
      }
      if ($id) {
      $this->request->data = $this->ServidorTipo->pr_servidor_tipo_con($id);
      }
      } */

    /**
     * Testando...
     */
    public function admin_teste()
    {
        $output = array();
        $this->loadModel('Atendimento.ServidorTipo');

        $params = array(
            'prm_nm_tipo_servidor' => array(
                'type' => 'varchar(40)',
                'value' => 'Testando 123'
            ),
            'prm_in_sucesso' => array(
                'type' => 'int',
                'out' => true
            ),
            'prm_tx_retorno' => array(
                'type' => 'varchar(80)',
                'out' => true
            ),
            'prm_id_tipo_servidor' => array(
                'type' => 'int',
                'out' => true
            ),
        );

//        $params = array('prm_id_tipo_servidor' =>array('type'=>'int','value'=>0));

        $procName = 'PR_SGT_Servidor_Tipo_Ins';
//        $procName = 'PR_SGT_Servidor_Tipo_Con';
        $result = $this->ServidorTipo->procedure($procName, $params);
        pr($result);
        exit();
        /*
          //$params = array(':prm_id_tipo_servidor' => 0);
          $params = array(':prm_nm_tipo_servidor' => 'testando', ':prm_in_sucesso' => null, ':prm_tx_retorno' => null);
          $output = array('prm_in_sucesso' => SQLINT4, 'prm_tx_retorno' => SQLVARCHAR, 'prm_id_tipo_servidor' => SQLINT4);

          $result = $this->ServidorTipo->executeMssqlSp('PR_SGT_Servidor_Tipo_Con', $params, $output );
          $result = $this->ServidorTipo->executeMssqlSp('dbo.PR_SGT_Servidor_Tipo_Ins', $params ,$output );

         * 
         */
        #consulta
        /*
          $params = array(':prm_id_tipo_servidor' => 0);
          $result = $this->ServidorTipo->procedure('PR_SGT_Servidor_Tipo_Con', $params);
         */

        /*
          #insert
          $params = array(':prm_nm_tipo_servidor' => 'testando', ':prm_in_sucesso' => null, ':prm_tx_retorno' => null);
          $output = array('@prm_in_sucesso as prm_in_sucesso', '@prm_tx_retorno as txt_retorno', '@prm_id_tipo_servidor as prm_id_tipo_servidor');
          $result = $this->ServidorTipo->procedure('dbo.PR_SGT_Servidor_Tipo_Ins', $params, $output);
          pr($result);
          exit();
         * 
         */
    }

    /*
     *     public $components = array('Paginator');
      public function admin_index() {
      //        $this->set('servidorTipos', $this->ServidorTipo->find('all'));
      $this->Paginator->settings['ServidorTipo']['limit'] = 5;
      $servidorTipos = $this->Paginator->paginate('ServidorTipo');
      $this->set('servidorTipos', $servidorTipos );
      }

      public function admin_add($id = null) {


      if ($this->request->data) {
      if ($this->ServidorTipo->save($this->request->data)) {
      $this->Session->setFlash('Tipo de servidor cadastrado com sucesso!');
      $this->redirect(array('action' => 'index'));
      }
      }
      if ($id) {
      $this->ServidorTipo->id = $id;
      $this->request->data = $this->ServidorTipo->read(null, $id);
      }
      }

      public function admin_delete($id = null) {
      if ($this->request->is('get') && $id) {
      if ($this->ServidorTipo->delete($id)) {
      $this->Session->setFlash('Tipo de servidor excluido com sucesso!');
      $this->redirect(array('action' => 'index'));
      }
      }
      }

     */
}
