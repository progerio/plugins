<?php

App::uses('RevistaAppModel', 'Revista.Model');

/**
 * RevistaArtigo Model
 *
 * @property Edicoes $Edicoes
 */
class Artigo extends RevistaAppModel {

    public $actsAs = array(
        'Croogo.Ordered' => array(
            'field' => 'weight',
            'foreign_key' => false,
        ),
    );
    

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'edicoes_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'arquivo' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
//        'weight' => array(
//            'numeric' => array(
//                'rule' => array('numeric'),
//            //'message' => 'Your custom message here',
//            //'allowEmpty' => false,
//            //'required' => false,
//            //'last' => false, // Stop validation after this rule
//            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
//        ),
        'status' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Edition' => array(
            'className' => 'Revista.Edition',
            'foreignKey' => 'edicao_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    
    
    
//    public function getWeight($weight = null){
//        if($weight = null){
//            $result = $this->find('all',array('conditions'))
//        }
//    }
//            if (empty($this->request->data['Artigo']['weight'])) {
//                $result = $this->Artigo->find('all', array('conditions' => array('Artigo.edicao_id' => $edicao_id), 'order' => 'Artigo.weight DESC', 'limit' => 1));
//                if (!empty($result)) {
//                    $weight = Hash::extract($result, '{n}.Artigo.weight');
//                    $this->request->data['Artigo']['weight'] = $weight[0] + 1;
//                }
//            }
}
