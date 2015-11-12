<?php

/**
 * Description of StoredProcedure
 *
 * 
 * @author Paulo Rogério <paulo.rogeriobr@gmail.com>
 */
class StoredProcedureBehavior extends ModelBehavior
{

    /**
     * 
     * @param type $Model
     * @param type $procName
     * @param type $params
     * @return type
     * @example 
     */
    
      $params = array(
                    'prm_nm_tipo_servidor' => array(
                    'type' => 'varchar(40)',
                    'value' => 'TESTE2'
                ),
                    'prm_in_sucesso' => array(
                    'type' => 'int',
                    'out' => true
                ),
                    'prm_tx_retorno' => array(
                    'type' => 'varchar(80)',
                    'out' => true
                ),
              );
     */
    
    public function procedure(&$Model, $storedproc, $params = array())
    {
        $varlist = $outs = array();
        $setlist = $paramlist = $stmt = "";
       
        foreach ($params as $key => $value) {
            $quote = strpos($value['type'], 'char') !== false;
            $varlist[] = "@$key  " . $value['type'];
            if (isset($value['value'])) {
                $setlist .= "set @" . $key . " = " . ($quote ? "'" : '') . $value['value'] . ($quote ? "'\n" : "\n");
            }
            $paramlist[] = " @" . $key . (isset($value['out']) ? ' output' : '');
            if (isset($value['out'])) {
                $outs[] = "@$key as $key";
            }
        }

        $stmt .= "declare\n";
        $stmt .= implode(",\n", $varlist); //variaveis escalares
        $stmt .= "\n" . $setlist; // setando variaveis 
        $stmt .= "exec  " . $storedproc . implode(",\n", $paramlist) . "\n";
       
        //select parametros de saida..
        if (!empty($outs)) {
            $stmt .= "select " . implode(", \n", $outs) . "\n";
        }else{
            unset($outs);
        }
        pr($stmt);exit();
        $result = $Model->query($stmt);
        return $result;
    }
    
    
    /**
     * Retorna o tipo de entrada dos parametros
     * @param type $params
     * @return type
     */
    
    public function getTypeParams(&$Model, $params = array())
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

}
