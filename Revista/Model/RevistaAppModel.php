<?php

App::uses('AppModel', 'Model');

class RevistaAppModel extends AppModel {

    public $tablePrefix = 'revista_';

    const STATUS_PUBLISHED = 1;
    const STATUS_UNPUBLISHED = 0;
    const PUBLICATION_STATE_FIELD = 'status';
    const UNPROCESSED_ACTION = 'delete';
    
    
   
    public $actionsMapping = array(
        'delete' => 'deleteAll',
        'publish' => '_publish',
        'unpublish' => '_unpublish',
    );

    public function processAction($action, $ids) {
        $success = true;
        $actionToPerform = strtolower($action);
        if (!in_array($actionToPerform, array_keys($this->actionsMapping))) {
            throw new InvalidArgumentException(__d('croogo', 'Invalid action to perform'));
        }
        if (empty($ids)) {
            throw new InvalidArgumentException(__d('croogo', 'No target to process action upon'));
        }
        if ($actionToPerform === self::UNPROCESSED_ACTION) {
            $success = $this->{$this->actionsMapping[$actionToPerform]}(array($this->escapeField() => $ids));
        } else {
            $success = $this->{$this->actionsMapping[$actionToPerform]}($ids);
        }
        return $success;
    }

    protected function _publish($ids) {
        return $this->_saveStatus($ids, self::PUBLICATION_STATE_FIELD, self::STATUS_PUBLISHED);
    }

    protected function _unpublish($ids) {
        return $this->_saveStatus($ids, self::PUBLICATION_STATE_FIELD, self::STATUS_UNPUBLISHED);
    }

    protected function _saveStatus($ids, $field, $status) {
        return $this->updateAll(array($this->escapeField($field) => $status), array($this->escapeField() => $ids));
    }

}
