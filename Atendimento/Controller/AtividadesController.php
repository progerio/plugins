<?php

/**
 * Description of AtividadesController
 *
 * @author Paulo Rogério <paulo.rogeriobr@gmail.com>
 */
App::uses('AtendimentoAppController', 'Atendimento.Controller');

class AtividadesController extends AtendimentoAppController
{

    public $uses = array('Atendimento.Atividade', 'Atendimento.Funcionario', 'Atendimento.Projeto', 'Atendimento.Usuario', 'Atendimento.AtividadeSituacao');

    public function admin_index()
    {
        $results = $this->Atividade->pr_sgt_atividade_con();
        $atividades = array();
      
        foreach ($results as $key => $value) {
//            pr($value);exit('oi');
                $usuario = $this->Usuario->pr_sgt_usuario_con($value['Atividade']['ID_Usuario']);
                $value['Atividade']['NM_Usuario'] = ($usuario['Usuario']['NM_Usuario']) ? $usuario['Usuario']['NM_Usuario'] : null;
                $funcionario = $this->Funcionario->pr_sgt_funcionario_con($value['Atividade']['ID_Funcionario']);
            $value['Atividade']['NM_Funcionario'] = ($funcionario['Funcionario']['NM_Funcionario'])? $funcionario['Funcionario']['NM_Funcionario'] : null;
            $projeto = $this->Projeto->pr_sgt_projeto_con($value['Atividade']['ID_Projeto']);
            $value['Atividade']['NM_Projeto'] = ($projeto['Projeto']['NM_Projeto'])? $projeto['Projeto']['NM_Projeto'] : null;
            $situacao = $this->AtividadeSituacao->pr_sgt_atividade_situacao_con($value['Atividade']['ID_Situacao_Atividade']);
            $value['Atividade']['NM_Situacao_Atividade'] = ($situacao['AtividadeSituacao']['NM_Situacao_Atividade']) ? $situacao['AtividadeSituacao']['NM_Situacao_Atividade']: null;
            $atividades[$key] = $value;
        }
        $this->set("atividades", $atividades);
    }

    public function admin_add($id = null)
    {
        $params = array( );
        if ($this->request->data) {
            $request = $this->request->data;
            
            foreach ($request[$this->modelClass] as $key => $value) {
                if (isset($value) && $value) {
                    $colums = array('ID_Usuario', 'ID_Funcionario', 'ID_Projeto', 'NR_Prioridade', 'QT_Esforco_Previsto');
                    if(in_array($key, $colums )){
                        $value = (int) $value;
                    }
                    $params[$key] = $value;
                }
            }
          
            $output = $message = $class = array();
            //save
            if (!empty($params)) {
                $output = $this->Atividade->pr_sgt_atividade_ins($params);
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
            $this->request->data = $this->Atividade->pr_sgt_atividade_con($id);
        }


        $funcs = $this->Funcionario->pr_sgt_funcionario_con();
        $funcionarios = array();
        foreach ($funcs as $val) {
            $key = (int)$val['Funcionario']['ID_Funcionario'];
            $funcionarios[$key] = $val['Funcionario']['NM_Funcionario'];
        }
        $projs = $this->Projeto->pr_sgt_projeto_con();
        $projetos = array();
        
        foreach ($projs as $val) {
            $projetos[$val['Projeto']['ID_Projeto']] = $val['Projeto']['NM_Projeto'];
        }
        $users = $this->Usuario->pr_sgt_usuario_con();
        $usuarios = array();
        foreach ($users as $val) {
            $usuarios[$val['Usuario']['ID_Usuario']] = $val['Usuario']['NM_Usuario'];
        }

        $sits = $this->AtividadeSituacao->pr_sgt_atividade_situacao_con();
        $situacoes = array();

        foreach ($sits as $val) {
            $situacoes[$val['AtividadeSituacao']['ID_Situacao_Atividade']] = $val['AtividadeSituacao']['NM_Situacao_Atividade'];
        }
        $this->set(compact('funcionarios', 'projetos', 'usuarios', 'situacoes'));
    }

}
