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
class ItemComment extends AppModel
{
    public $name = 'ItemComment';
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'comment' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) 
        );
        $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'Item' => array(
            'className' => 'Item',
            'foreignKey' => 'item_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => false
        ) ,
         'PostedUser' => array(
            'className' => 'User',
            'foreignKey' => 'posted_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => false
        )
    );
}