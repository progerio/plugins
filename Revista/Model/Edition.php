<?php

App::uses('RevistaAppModel', 'Revista.Model');

/**
 * RevistaEdicoe Model
 *
 */
class Edition extends RevistaAppModel {

    public $useTable = 'edicoes';

   public $actsAs = array('Croogo.Params');
    
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
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
    
    
    
    
    public $hasMany = array(
        'Artigo'=>array(
            'className'=>'Revista.Artigo',
            'foreignKey'=>'edicao_id'
        ),
//        'RevistaLink'=>array(
//            'className'=>'Revista.Link',
//            'foreignKey'=>'edition_id'
//        )
    );

}
