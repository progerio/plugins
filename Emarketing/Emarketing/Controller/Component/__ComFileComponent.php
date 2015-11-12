<?php

/**
 * @author Paulo Rogerio <progerio@castelobranco.br>
 * ComFileComponent - Componente para tratamento de arquivos 
 */
App::uses('CakeResponse', 'Network');
App::uses('Component', 'Controller');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class ComFileComponent extends Component {

    public $types = array(
        'text/plain',
        'application/octet-stream'
    );

    public function startup(&$controller) {
        $this->controller = $controller;
    }

    static function resultSearch($params) {
        $folder = new Folder($params['folder'], true, 0777);
        $result = $folder->findRecursive($params['search']);
        return $result;
    }

    static function find($params) {
        $folder = new Folder($params['folder'], true, 0777);
        $result = $folder->find($params['search']);
        return $result;
    }

    public static function isUploadedFile($params = array()) {
        if ((isset($params['error']) && $params['error'] == 0) || (!empty($params['tmp_name']) && $params['tmp_name'] != 'none' && in_array($params['type'], $this->types))) {
            return is_uploaded_file($params['tmp_name']);
        }
        return false;
    }

    static function create($params = array()) {
        $contentFile = null;
        $year = date('Y');
        $title = Inflector::slug($params['title'], '-');
        $filename = strtolower($title);

        $directory = new Folder(WWW_ROOT . 'uploads' . DS . 'marketing' . DS . $filename . DS, true, 0777);
        $upload = explode('.', $params['file']['name']);
        $filename = $upload[0];
        if (!empty($params)) {
            $destination = $directory->pwd() . $params['file']['name'];
            move_uploaded_file($params['file']['tmp_name'], $destination);
        }
        $contentFile = $params['body'];

        try {
            $file = new File($directory->path . DS . $title . '.html', true, 0777);
            $file->write('<!doctype html>');
            $file->append('<html lang="en">');
            $file->append('<head>');
            $file->append('<meta charset="UTF-8">');
            $file->append('<title>Universidade Castelo Branco :: ' . $params['title'] . '</title>');
            $file->append('</head>');
            $file->append('<body>');
            $file->append('<p align="center" font size="1"> Caso não consiga visualizar este email, <a href="'.WWW_ROOT.DS.'uploads'.DS.'marketing'.DS. $filename . '.html" title="' . $params['title'] . '"> acesse aqui.</a></p>');
            $file->append('<div style="margin:auto; width:600px">');
            $file->append($contentFile);
            $file->append('</div>');
            $file->append('</body>');
            $file->append('</html>');
            $file->close();

            return true;
        } catch (CakeException $e) {
            $e->getMessage("Não foi possivel Criar o arquivo!");
            return false;
        }
        return false;
    }

    static function createFile($type, $params = array()) {
        $contentFile = null;
        $year = date('Y');
        $title = Inflector::slug($params['title'], '-');
        $filename = strtolower($title);

        $directory = new Folder(WWW_ROOT . 'files' . DS . 'arquivos' . DS . $filename . DS, true, 0777);

        if ($type == 'marketing') {
            $upload = explode('.', $params['file']['name']);
            $filename = $upload[0];
            if (!empty($params)) {
                $destination = $directory->pwd() . $params['file']['name'];
                move_uploaded_file($params['file']['tmp_name'], $destination);
            }
        } else {
            $contentFile = $params['content'];
        }

        try {
            $file = new File($directory->path . DS . $filename . '.html', true, 0777);
            $file->write('<!doctype html>');
            $file->append('<html lang="en">');
            $file->append('<head>');
            $file->append('<meta charset="UTF-8">');
            $file->append('<title>Universidade Castelo Branco :: ' . $params['title'] . '</title>');
            $file->append('</head>');
            $file->append('<body>');
            $file->append('<p align="center"> Caso não consiga visualizar este email, <a href="http://arquivos.castelobranco.br/data/publico/email/' . $year . '/' . $filename . '.html" title="' . $params['title'] . '"> acesse aqui.</a></p>');
            $file->append('<div style="margin:auto; width:600px">');

            switch ($type) {
                case 'marketing':
                    $file->append('<img src="http://arquivos.castelobranco.br/data/publico/email/2014/' . $params['file']['name'] . '" alt="' . $params['title'] . '" width="600" />');
                    break;
                case 'text':
                    $file->append('<img src="http://arquivos.castelobranco.br/data/publico/outros/2012/img/logo-castelo.jpg" alt="Logo" /><hr/>');
                    $file->append($contentFile);
                    break;
                default:
                    break;
            }

            $file->append('</div>');
            $file->append('</body>');
            $file->append('</html>');
            $file->close();

            return true;
        } catch (CakeException $e) {
            $e->getMessage("Não foi possivel Criar o arquivo!");
            return false;
        }
        return false;
    }

    public function delete($id = null) {
        if ($id) {
            $controller = new MarketingsController();
            $controller->loadModel('Marketing.Marketing');
            $result = $controller->Marketing->findById($id);
            if (!empty($result)) {
                $params = json_decode($result['Marketing']['params'], true);
                $directory = new Folder(WWW_ROOT . 'files' . DS . 'arquivos' . DS . strtolower($params['Marketing']['title']) . DS, true, 0777);
                $filename = $params['Marketing']['filename'];
                $files = $directory->find($filename . '.*');
                foreach ($files as $f) {
                    $handler = new File($directory->path . DS . $f, true, 0777);
                    $handler->delete();
                }
                $path = $directory->path;
                $directory->delete($path);
                $controller->Marketing->delete($id);
                return true;
            }
        }
        return false;
    }

    public function splitFile($data = array(), $qtd = 0, $filename) {
        $string = null;
        foreach ($data as $value) {
            $string .= $value . "\n";
        }

        if ($handle = fopen(WWW_ROOT . 'files' . DS . 'split' . DS . $filename . '_' . $qtd, "x+")) {
            fwrite($handle, $string);
            return true;
        }
        return false;
    }

    public function makeSplit($get = array(), $filename) {
        $arr = array();
        $aux = 0;
        $qtd = 0;
        $end = count($get);
        $data = array();
        for ($i = 0; $i < sizeof($get); $i ++) {
//             echo $aux . ' - ' . @$get[$i] . "<br/>";
            $data[] = $aux . ' - ' . @$get[$i] . "<br/>";
            $arr[$i] = $get[$i];
            $end --;
            $aux ++;
            if ($aux == 2000) {
                ++$qtd;
                $this->splitFile($arr, $qtd, $filename);
                $arr = array();
                $aux = 0;
                continue;
            }

            if ($end == 0) {
                $qtd ++;
                $this->splitFile($arr, $qtd, $filename);
            }
        }
        return $data;
    }

}
