<?php
/**
 * GroupWithUs
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    groupwithus
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
class ItemUserPass extends AppModel
{
    public $name = 'ItemUserPass';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'ItemUser' => array(
            'className' => 'ItemUser',
            'foreignKey' => 'item_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
            'counterScope' => array(
                'ItemUserPass.is_used' => 1
            ) ,
        )
    );
    public $hasOne = array(
        'PaypalTransactionLog' => array(
            'className' => 'PaypalTransactionLog',
            'foreignKey' => 'item_user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
    );
	function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'guest_name' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
             'guest_email' => array(
                'rule2' => array(
                    'rule' => 'email',
                    'allowEmpty' => false,
                    'message' => __l('Must be a valid email')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            );
    }
}
?>