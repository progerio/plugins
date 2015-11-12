<?php

/**
 * Description of Usuario
 *
 * @author Paulo Rogério <progerio@castelobranco.br>
 */
class Usuario extends AtendimentoAppModel
{

    public $useTable = 'TB_Usuario';
    public $alias = 'Usuario';

     public function pr_sgt_usuario_con($prm_id_usuario = 0)
    {
          if (is_numeric($prm_id_usuario)) {
            $bindParam = array(':prm_id_usuario' =>$prm_id_usuario);
            $sql = "EXEC dbo.PR_SGT_Usuario_Con @prm_id_usuario = :prm_id_usuario";
            $result = $this->query($sql, $bindParam);
            $count = count($result);
            $dados = array();
            if ($count > 1) {
                foreach ($result as $k => $val) {
                    $dados[$k][$this->alias] = $val[0];
        
                }
            } else {
                $dados[$this->alias] = array_pop(array_pop($result));
            }
            return $dados;
        }
        return false;
    }
    
    
    
    
}
