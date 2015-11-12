<?php

/**
 * Description of Funcionario
 *
 * @author Paulo Rogério <progerio@castelobranco.br>
 */
class Funcionario extends AtendimentoAppModel
{

    public $useTable = 'TB_Funcionario';
    public $alias = 'Funcionario';

    public function pr_sgt_funcionario_con($prm_id_funcionario = 0)
    {
        if (is_numeric($prm_id_funcionario)) {
            $bindParam = array(':prm_id_funcionario' => $prm_id_funcionario);
            $sql = "EXEC dbo.PR_SGT_Funcionario_Con @prm_id_funcionario = :prm_id_funcionario";
            $result = $this->query($sql, $bindParam);
            $count = count($result);
            $dados = array();
            if ($count) {
                foreach ($result as $k => $val) {
                    $dados[$k][$this->alias] = $val[0];
                }
            }
            return $dados;
        }
        return false;
    }
}
