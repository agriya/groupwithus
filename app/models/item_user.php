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
class ItemUser extends AppModel
{
    public $name = 'ItemUser';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'Item' => array(
            'className' => 'Item',
            'foreignKey' => 'item_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
            'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
    );
    public $hasMany = array(
        'Transaction' => array(
            'className' => 'Transaction',
            'foreignKey' => 'foreign_id',
            'dependent' => true,
            'conditions' => array(
                'Transaction.class' => 'ItemUser'
            ) ,
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'ItemUserPass' => array(
            'className' => 'ItemUserPass',
            'foreignKey' => 'item_user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    public $hasOne = array(
        'PaypalDocaptureLog' => array(
            'className' => 'PaypalDocaptureLog',
            'foreignKey' => 'item_user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'PaypalTransactionLog' => array(
            'className' => 'PaypalTransactionLog',
            'foreignKey' => 'item_user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'AuthorizenetDocaptureLog' => array(
            'className' => 'AuthorizenetDocaptureLog',
            'foreignKey' => 'item_user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'CharitiesItemUser' => array(
            'className' => 'CharitiesItemUser',
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
            'user_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'item_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'quantity' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
        $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete')
        );
    }
    function afterSave($model)
    {
        if ((Configure::read('charity.is_enabled') == 1)) {
            if (!empty($this->data['ItemUser']['is_canceled'])) {
                $charity = $this->CharitiesItemUser->find('first', array(
                    'conditions' => array(
                        'CharitiesItemUser.item_user_id' => $this->data['ItemUser']['id']
                    ) ,
                    'recusive' => - 1
                ));
                if (!empty($charity['CharitiesItemUser']['id'])) $this->CharitiesItemUser->delete($charity['CharitiesItemUser']['id']);
            }
        }
    }
	function _updateItemAfterPurchaseCount($data, $type = null)
	{
		$item = $this->Item->find('first', array(
			'conditions' => array(
				'Item.id' => $data['item_id']
			) ,
			'fields' => array(
				'Item.id',
				'Item.item_status_id',
				'Item.item_user_count',
			) ,
			'recursive' => -1
		));
		$conditions = $updation = array();
		$conditions['ItemUser.item_id'] = $data['item_id'];
		// For Pending //
		if ($item['Item']['item_status_id'] == ConstItemStatus::Open) {
			$updation['Item.item_user_pending_count'] = $item['Item']['item_user_count'];
			$updation['Item.item_user_available_count'] = 0;
		} elseif ($item['Item']['item_status_id'] > ConstItemStatus::Open) {
			$db = $this->getDataSource();
			$updation['Item.item_user_pending_count'] = 0;
			$available_count_conditions = array();
			$available_count_conditions['ItemUser.item_id'] = $data['item_id'];
			$available_count_conditions['ItemUser.quantity >'] = $db->expression('ItemUser.item_user_pass_count');
			$available_count_conditions['ItemUser.is_canceled'] = 0;
			$available_count_conditions['ItemUser.is_paid'] = 1;
			$availableCount = $this->find('all', array(
				'conditions' => array_merge($conditions, $available_count_conditions) ,
				'fields' => array(
					'SUM(ItemUser.quantity - ItemUser.item_user_pass_count) as available_count'
				) ,
				'contain' => array(
					'Item'
				) ,
				'group' => array(
					'ItemUser.user_id'
				) ,
				'recursive' => 2
			));
			$updation['Item.item_user_available_count'] = !empty($availableCount[0][0]['available_count']) ? $availableCount[0][0]['available_count'] : '0';
		}
		// USED //
		$item_user_used_count = $this->find('all', array(
			'conditions' => array_merge(array(
				'ItemUser.item_user_pass_count !=' => 0,
				'ItemUser.is_canceled' => 0,
				'ItemUser.is_repaid' => 0,
			) , $conditions) ,
			'fields' => array(
				'SUM(ItemUser.item_user_pass_count) as used_count'
			) ,
			'recursive' => -1
		));
		$updation['Item.item_user_used_count'] = (!empty($item_user_used_count[0][0]['used_count']) ? $item_user_used_count[0][0]['used_count'] : '0');
		// Updating //
		$update_model = array(
			'Item.id' => $data['item_id']
		);
		if (!empty($updation) && !empty($update_model)) {
			$this->Item->updateAll($updation, $update_model);
		}
	}
}
?>