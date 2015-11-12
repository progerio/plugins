<?php

/**
 * Description of AtividadeSituacao
 *
 * @author Paulo Rogério <progerio@castelobranco.br>
 */
class AtividadeSituacao extends AtendimentoAppModel
{

    public $useTable = 'TB_Atividade_Situacao';
    public $alias = 'AtividadeSituacao';

    public function pr_sgt_atividade_situacao_con($prm_id_atividade_situacao = 0)
    {
        if (is_numeric($prm_id_atividade_situacao)) {
            $bindParam = array(':prm_id_atividade_situacao' => $prm_id_atividade_situacao);
            $sql = "EXEC dbo.PR_SGT_Atividade_Situacao_Con @prm_id_atividade_situacao = :prm_id_atividade_situacao";
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
