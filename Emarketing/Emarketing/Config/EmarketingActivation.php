<?php
/**
 * @author Paulo Rogério Rodrigues <progerio@castelobranco.br>
 */
App::uses('File', 'Utility');
App::import('Model', 'ConnectionManager');

class EmarketingActivation {

    public function beforeActivation(Controller $controller) {
        $sql = file_get_contents(APP . 'Plugin' . DS . 'Emarketing' . DS . 'Config' . DS . 'emarketing.sql');
        if (! empty($sql)) {
            $db = ConnectionManager::getDataSource('default');
            $statements = explode(';', $sql);
            foreach ($statements as $statement) {
                if (trim($statement) != '') {
                    $db->query($statement);
                }
            }
        }
        return true;
    }

    public function onActivation(Controller $controller) {
        $controller->Croogo->addAco('Mailings');
        $controller->Croogo->addAco('Mailings/admin_index');
        $controller->Croogo->addAco('Mailings/admin_add');
        return true;
    }

    public function beforeDeactivation(Controller $controller) {
        return true;
    }

    public function onDeactivation(Controller $controller) {
        $controller->Croogo->removeAco('Mailings');
    }
}