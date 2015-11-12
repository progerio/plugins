<?php

/**
 * Description of ServidorTipo
 *
 * @author Paulo Rogério <progerio@castelobranco.br>
 */
class ServidorTipo extends AtendimentoAppModel
{

    public $useTable = 'TB_Servidor_Tipo';
    public $primaryKey = 'ID_Tipo_Servidor';
//    public $actsAs = array('Atendimento.StoredProcedure');

    public $validate = array(
        'nm_tipo_servidor' => array(
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
    );

    /**
     * Consulta 
     *  @param type $prm_id_tipo_servidor
     *  $prm_id_tipo_servidor = 0 retorna todos
     * @return type
     */
    public function pr_sgt_servidor_tipo_con($prm_id_tipo_servidor = 0)
    {
        if (is_numeric($prm_id_tipo_servidor)) {
            $bindParam = array(':prm_id_tipo_servidor' => $prm_id_tipo_servidor);
            $sql = "EXEC dbo.PR_SGT_Servidor_Tipo_Con @prm_id_tipo_servidor = :prm_id_tipo_servidor";
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

    /**
     * Inclusão
     * @param type $prm_nm_tipo_servidor
     * @return type
     */
    /*
      public function pr_servidor_tipo_ins($prm_nm_tipo_servidor = null)
      {
      if ($prm_nm_tipo_servidor != null) {

      $sql = "DECLARE
      @prm_nm_tipo_servidor	TD_NM_40
      ,@prm_in_sucesso	TD_IN_1_0
      ,@prm_tx_retorno	TD_NM_120
      ,@prm_id_tipo_servidor	TD_ID_Tipo_Servidor

      EXEC PR_SGT_Servidor_Tipo_Ins '$prm_nm_tipo_servidor'
      , @prm_in_sucesso output
      , @prm_tx_retorno output
      , @prm_id_tipo_servidor output

      SELECT	@prm_in_sucesso as in_sucesso
      , @prm_tx_retorno as txt_retorno
      , @prm_id_tipo_servidor as id_tipo_servidor";

      /*
      $prm_nm_tipo_servidor = (string) "'". $prm_nm_tipo_servidor ."'";
      $params = array(':prm_nm_tipo_servidor' => $prm_nm_tipo_servidor);
      $sql = $this->prepareQuery('PR_Servidor_Tipo_Ins', $params);
      pr($sql);exit();
     * 
     */
    /*      $return = $this->query($sql);
      $dados = array_pop(array_pop($return));
      return $dados;
      }
      }
     * 
     */

    /**
     * Salva ou Atualiza tipo servidor
     * @param type $params
     * @return type
     */
    public function pr_sgt_servidor_tipo_ins($params = array())
    {
        //nome procedure
        $name = 'PR_SGT_Servidor_Tipo_Ins';
        //verifica o tipo de parametros de entrada
        $paramIn = $this->getTypeParams($params);
        //parametros de saida 
        $paramOut = array(
            'prm_in_sucesso' => array('type' => 'int', 'out' => true),
            'prm_tx_retorno' => array('type' => 'varchar(80)', 'out' => true),
            'prm_id_tipo_servidor' => array('type' => 'int', 'out' => true),
        );

        // atualiza procedure
        if (isset($params['id_tipo_servidor']) && $params['id_tipo_servidor']) {
            $name = 'dbo.PR_SGT_Servidor_Tipo_Upd';
            unset($paramOut['prm_id_tipo_servidor']);
        }
        $options = array_merge($paramIn, $paramOut);
        $return = $this->procedure($name, $options);
        return array_pop(array_pop($return));
    }

    public function pr_sgt_servidor_tipo_del($params = array())
    {
        //nome procedure
        $name = 'PR_SGT_Servidor_Tipo_Del';
        //verifica o tipo de parametros de entrada
        $paramIn = $this->getTypeParams($params);
        $paramOut = array(
            'prm_in_sucesso' => array('type' => 'int', 'out' => true),
            'prm_tx_retorno' => array('type' => 'varchar(80)', 'out' => true),
        );
        $options = array_merge($paramIn, $paramOut);
        $return = $this->procedure($name, $options);
        return array_pop(array_pop($return));
    }

    /**
     * Retorna o tipo de entrada dos parametros
     * @param type $params
     * @return type
     */
    public function getType($params = array())
    {
        $paramIn = array();
        foreach ($params as $key => $value) {
            if (is_string($value)) {
                $length = strlen($value);
                $paramIn[$key]['type'] = 'varchar(' . $length . ')';
            } elseif (is_int($value)) {
                $paramIn[$key]['type'] = 'int';
            } elseif (is_null($value)) {
                $paramIn[$key]['type'] = 'null';
            }
            $paramIn[$key]['value'] = $value;
        }
        return $paramIn;
    }

    /**
      public function pr_servidor_tipo_upd($params = array())
      {
      if (!empty($params)) {

      $sql = "declare
      @prm_id_tipo_servidor	TD_ID_Tipo_Servidor
      ,@prm_nm_tipo_servidor	TD_NM_40
      ,@prm_in_sucesso	TD_IN_1_0
      ,@prm_tx_retorno	TD_NM_120
      EXEC dbo.PR_SGT_Servidor_Tipo_Upd {$params['prm_id_tipo_servidor']} , '{$params['prm_nm_tipo_servidor']}'
      , @prm_in_sucesso output
      , @prm_tx_retorno output
      select	@prm_in_sucesso as in_sucesso
      , @prm_tx_retorno as txt_retorno
      , @prm_id_tipo_servidor as id_tipo_servidor";
      $retorno = $this->query($sql);
      $dados = array_pop(array_pop($retorno));
      return $dados;
      }
      }
     */
    /**
     * Delete
     * @param type $prm_id_tipo_servidor
     * @return type
     */
    /**
      public function pr_servidor_tipo_del($prm_id_tipo_servidor)
      {
      if (is_numeric($prm_id_tipo_servidor)) {
      $bindParam = array(':prm_id_tipo_servidor' => $prm_id_tipo_servidor);
      $sql = "DECLARE
      @prm_id_tipo_servidor	TD_ID_Tipo_Servidor
      ,@prm_in_sucesso	TD_IN_1_0
      ,@prm_tx_retorno	TD_NM_120

      EXEC  dbo.PR_SGT_Servidor_Tipo_Del :prm_id_tipo_servidor
      ,@prm_in_sucesso	output
      ,@prm_tx_retorno	output

      SELECT @prm_in_sucesso	as in_sucesso
      ,@prm_tx_retorno as txt_retorno";
      $execute = $this->query($sql, $bindParam);
      $dados = array_pop(array_pop($execute));
      return $dados;
      }
      }
     */
}
