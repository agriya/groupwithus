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
class UserInterest extends AppModel
{
    public $name = 'UserInterest';
    public $displayField = 'name';
    public $actsAs = array(
        'Sluggable' => array(
            'label' => array(
                'name'
            )
        ) ,
    );
	var $hasMany = array(
        'UserInterestFollower' => array(
            'className' => 'UserInterestFollower',
            'foreignKey' => 'user_interest_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => true
        ) ,
    );
	public $hasOne = array(
		'MailChimpList' => array(
            'className' => 'MailChimpList',
            'foreignKey' => 'user_interest_id',
            'dependent' => true,
            'conditions' => '',           
        )
    );
    var $hasAndBelongsToMany = array(
        'User' => array(
            'className' => 'User',
            'joinTable' => 'user_interest_followers',
            'foreignKey' => 'user_interest_id',
            'associationForeignKey' => 'user_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ),
        'Item' => array(
            'className' => 'Item',
            'joinTable' => 'user_interest_items',
            'foreignKey' => 'user_interest_id',
            'associationForeignKey' => 'item_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );
	function __construct($id = false, $table = null, $ds = null)
	{
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'name' => array(
				'rule2' => array(
					'rule' => 'isUnique',
					'allowEmpty' => false,
					'message' => __l('Interest name is already exist')
				) ,
				'rule1' => array(
					'rule' => 'notempty',
					'allowEmpty' => false,
					'message' => __l('Required')
				)
            ),
			 'UserInterest' => array(
                'rule' => 'is_check',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,

        );
          $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }
	function is_check()
    {
        if (empty($this->data['UserInterest']['UserInterest'])) {
            return false;
        }
        return true;
    }
}