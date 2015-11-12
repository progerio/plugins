<?php

/**
 * Description of Projeto
 *
 * @author Paulo Rogério <progerio@castelobranco.br>
 */
class Projeto extends AtendimentoAppModel
{

    public $useTable = 'TB_Projeto';
    public $alias = 'Projeto';

    public function pr_sgt_projeto_con($prm_id_projeto = 0)
    {
        $dados = array();
        if (is_numeric($prm_id_projeto)) {
            $bindParam = array(':prm_id_projeto' => $prm_id_projeto);
            $sql = "EXEC dbo.PR_SGT_Projeto_Con @prm_id_projeto = :prm_id_projeto";
            $result = $this->query($sql, $bindParam);
            $count = count($result);

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
