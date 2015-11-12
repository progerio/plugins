<?php
App::uses('ImportCrmAppController', 'ImportCrm.Controller');

/**
 * ImportCrms Controller
 *
 */
class ImportCrmsController extends ImportCrmAppController
{

    public $types = array(
        'text/plain',
        'application/octet-stream',
        'application/vnd.ms-excel'
    );


    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Security->validatePost = false;
        $this->Security->blackHoleCallback = $this->action;
    }

    public function admin_index()
    {
        if ($this->request->data) {

            $file = $this->request->data['Import']['arquivo'];


            if ($this->isUploaded($file)) {

                if (!in_array($file['type'], $this->types)) {
                    $this->Session->setFlash('Tipo de arquivo inválido!', 'default', array(
                        'class' => 'error'
                    ));
                    $this->redirect(array('action' => 'admin_index'));
                }

                //importando...
                $row = 1;
                $handle = fopen($file['tmp_name'], "r");
                $callCenter = array();
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $arr = explode(';', $data[0]);
                    if ($arr[0] == 'NOMES') {
                        continue;
                    }
                    $telefone = null;
                    $celular = null;
                    $created = null;
                    $modified = null;

                    if (isset($arr[1])) {
                        $telefone = $arr[1];
                    } else if (isset($arr[9])) {
                        $telefone = $arr[9];
                    }
                    if (isset($arr[2])) {
                        $celular = $arr[2];
                    } else if (isset($arr[10])) {
                        $celular = $arr[10];
                    }

                    if (isset($arr[3]) && $arr[3]) {
                        $dt = explode('/', $arr[3]);
                        $created = $dt[2] . '-' . $dt[0] . '-' . $dt[1] . " 00:00:00";
                    }
                  //  pr($created);exit();

                    if (isset($arr[13]) && $arr[13]) {
                        $dtm = explode('/', $arr[13]);
                        $modified = $dtm[2] . '-' . $dtm[0] . '-' . $dtm[1] . " 00:00:00";
                    }

                    $callCenter[] = array(
                        'id' => null,
                        'nome' => $arr[0],
                        'email' => $arr[5],
                        'telefone' => $telefone,
                        'celular' => $celular,
                        'operador' => $arr[14],
                        'modalidade' => $arr[6],
                        'forma_de_ingresso' => $arr[7],
                        'curso' => $arr[11],
                        'campus' => $arr[12],
                        'status_atend' => $arr[15],
                        'anotacoes' => $arr[16],
                        'created' => $created,
                        'modified' => $modified
                    );

                    $row++;
                }
               pr($callCenter);exit();
            }
        }
    }

    public function isUploaded($file)
    {
        if ((isset($file['error']) && $file['error'] == 0) || (!empty($file['tmp_name']) && $file['tmp_name'] != 'none' && in_array($file['type'], $this->types))) {
            return is_uploaded_file($file['tmp_name']);
        }

        return false;
    }


}
