<?php
/**
 * @author Paulo Rogerio <paulo.rogeriobr@gmail.com>
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

    public function startup(Controller $controller) {
        $this->controller = $controller;
    }

    public static function isUploaded($file) {
        if ((isset($file['error']) && $file['error'] == 0) || (! empty($file['tmp_name']) && $file['tmp_name'] != 'none' && in_array($file['type'], $this->types))) {
            return is_uploaded_file($file['tmp_name']);
        }
        return false;
    }

    public static function create($params) {
        $contentFile = null;
        $pathApp = Router::url('/', true);
        $title = Inflector::slug($params['title'], '-');
        $filename = strtolower($title);
        
        $directory = new Folder(WWW_ROOT . 'uploads' . DS . 'marketing' . DS . $filename . DS, true, 0777);
        $upload = explode('.', $params['file']['name']);
        $filename = $upload[0];
        if (! empty($params)) {
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
            $file->append('<p align="center"><font size="1"> Caso não consiga visualizar este email, <a href="' . $pathApp . 'uploads' . '/' . 'marketing' . '/' . $title . '/' . $title . '.html" title="' . $params['title'] . '" target="_blank" > acesse aqui.</a></font></p>');
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
    
    
    public static function importCsv(){
        
    }
    
}