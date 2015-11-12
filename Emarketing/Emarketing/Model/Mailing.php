<?php

class Mailing extends EmarketingAppModel {

    public $useTable = 'mailings';
    public $validate = array(
        'title' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser deixado em branco.'
        ),
//         'from' => array(
//             'rule' => 'notEmpty',
//             'message' => 'Este campo não pode ser deixado em branco.'
//         ),
//         'body' => array(
//             'rule' => 'notEmpty',
//             'message' => 'Este campo não pode ser deixado em branco.'
//         )
    );

}
