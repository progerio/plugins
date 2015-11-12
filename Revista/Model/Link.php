<?php

App::uses('RevistaAppModel', 'Revista.Model');

/**
 * @author Paulo Rogerio <progerio@castelobranco.br>
 */
class Link extends RevistaAppModel {

    /**
     * Model name
     *
     * @var string
     * @access public
     */
    public $name = 'Link';

    /**
     * Behaviors used by the Model
     *
     * @var array
     * @access public
     */
    public $actsAs = array(
        'Croogo.Encoder',
        'Tree',
        'Croogo.Cached' => array(
            'groups' => array(
                'editions',
            ),
        ),
        'Croogo.Params',
    );

    /**
     * Validation
     *
     * @var array
     * @access public
     */
    public $validate = array(
        'title' => array(
            'rule' => array('minLength', 1),
            'message' => 'Title cannot be empty.',
        ),
        'link' => array(
            'rule' => array('minLength', 1),
            'message' => 'Link cannot be empty.',
        ),
    );

    /**
     * Model associations: belongsTo
     *
     * @var array
     * @access public
     */
    public $belongsTo = array(
        'Edition' => array(
            'className' => 'Revista.Edition',
            'counterCache' => true,
            'foreignKey' => 'edition_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
