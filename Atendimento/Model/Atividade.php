<?php

/**
 * Description of Atividade
 *
 * @author Paulo Rogério <paulo.rogeriobr@gmail.com>
 */
class Atividade extends AtendimentoAppModel
{

    public $useTable = 'TB_Atividade';
    public $alias = 'Atividade';
    public $validate = array(
        'NM_Atividade' => array(
            'alphaNumeric' => array(
                'rule' => 'notEmpty',
                'on' => 'create',
                'required' => true,
                'message' => 'Somente letras e numeros !'
            ),
            'between' => array(
                'rule' => array('minLength', 3),
                'message' => 'Digite no minimo 3 caracteres!'
            )
        ),
        'TX_Atividade' => array(
            'alphaNumeric' => array(
                'rule' => 'notEmpty',
                'on' => 'create',
                'required' => true,
                'message' => 'Somente letras e numeros !'
            ),
            'between' => array(
                'rule' => array('minLength', 3),
                'message' => 'Digite no minimo 3 caracteres!'
            )
        ),
        'ID_Projeto' => array(
            'numeric' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Somente numeros !'
            ),
        ),
        'ID_Funcionario' => array(
            'numeric' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Somente numeros !'
            ),
        ),
        'ID_Usuario' => array(
            'numeric' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Somente numeros !'
            ),
        ),
    );

    public function pr_sgt_atividade_con($prm_id_atividade = 0)
    {
        $dados = array();
        if (is_numeric($prm_id_atividade)) {
            $bindParam = array(':prm_id_atividade' => $prm_id_atividade);
            $sql = "EXEC PR_SGT_Atividade_Con @prm_id_atividade = :prm_id_atividade";
            $result = $this->query($sql, $bindParam);
            $count = count($result);
            if ($count) {
                foreach ($result as $k => $val) {
                    $dados[$k][$this->alias] = $val[0];
                }
            }
        }
        return $dados;
    }

    public function pr_sgt_atividade_ins($params = array())
    {


        //nome procedure
        $name = 'dbo.PR_SGT_Atividade_Ins';
        //verifica o tipo de parametros de entrada
        $paramIn = $this->getTypeParams($params);


        //parametros de saida 
        $paramOut = array(
            'prm_in_sucesso' => array('type' => 'int', 'out' => true),
            'prm_tx_retorno' => array('type' => 'varchar(80)', 'out' => true),
            'prm_id_atividade' => array('type' => 'int', 'out' => true),
        );
        // atualiza procedure
        if (isset($params['id_atividade']) && $params['id_atividade']) {
            $name = 'dbo.PR_SGT_Atividade_Upd';
            unset($paramOut['prm_id_atividade']);
        }
        $options = array_merge($paramIn, $paramOut);

        $return = $this->procedure($name, $options);
        return array_pop(array_pop($return));
    }

}
