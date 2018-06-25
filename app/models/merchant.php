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
class Merchant extends AppModel
{
    public $name = 'Merchant';
    public $displayField = 'name';
    public $actsAs = array(
        'Sluggable' => array(
            'label' => array(
                'name'
            )
        ) ,
		'Aggregatable',
    );
	var $aggregatingFields = array(
        'total_open_count' => array(
            'mode' => 'real',
            'key' => 'merchant_id',
            'foreignKey' => 'merchant_id',
            'model' => 'Item',
            'function' => 'COUNT(Item.id)',
			'conditions' => array(
				'Item.item_status_id' => ConstItemStatus::Open			
            )
        ) ,
        'total_canceled_count' => array(
            'mode' => 'real',
            'key' => 'merchant_id',
            'foreignKey' => 'merchant_id',
            'model' => 'Item',
            'function' => 'COUNT(Item.id)',
			'conditions' => array(
				'Item.item_status_id' => ConstItemStatus::Canceled			
            )
        ) ,
        'total_expired_count' => array(
            'mode' => 'real',
            'key' => 'merchant_id',
            'foreignKey' => 'merchant_id',
            'model' => 'Item',
            'function' => 'COUNT(Item.id)',
			'conditions' => array(
				'Item.item_status_id' => ConstItemStatus::Expired			
            )
        ) ,
        'total_tipped_count' => array(
            'mode' => 'real',
            'key' => 'merchant_id',
            'foreignKey' => 'merchant_id',
            'model' => 'Item',
            'function' => 'COUNT(Item.id)',
			'conditions' => array(
				'Item.item_status_id' => ConstItemStatus::Tipped			
            )
        ) ,
        'total_closed_count' => array(
            'mode' => 'real',
            'key' => 'merchant_id',
            'foreignKey' => 'merchant_id',
            'model' => 'Item',
            'function' => 'COUNT(Item.id)',
			'conditions' => array(
				'Item.item_status_id' => ConstItemStatus::Closed			
            )
        ) ,
        'total_refunded_count' => array(
            'mode' => 'real',
            'key' => 'merchant_id',
            'foreignKey' => 'merchant_id',
            'model' => 'Item',
            'function' => 'COUNT(Item.id)',
			'conditions' => array(
				'Item.item_status_id' => ConstItemStatus::Refunded			
            )
        ) ,
        'total_paid_to_merchant_count' => array(
            'mode' => 'real',
            'key' => 'merchant_id',
            'foreignKey' => 'merchant_id',
            'model' => 'Item',
            'function' => 'COUNT(Item.id)',
			'conditions' => array(
				'Item.item_status_id' => ConstItemStatus::PaidToMerchant
            )
        ) ,
        'total_pending_approval_count' => array(
            'mode' => 'real',
            'key' => 'merchant_id',
            'foreignKey' => 'merchant_id',
            'model' => 'Item',
            'function' => 'COUNT(Item.id)',
			'conditions' => array(
				'Item.item_status_id' => ConstItemStatus::PendingApproval			
            )
        ) ,
        'total_rejected_count' => array(
            'mode' => 'real',
            'key' => 'merchant_id',
            'foreignKey' => 'merchant_id',
            'model' => 'Item',
            'function' => 'COUNT(Item.id)',
			'conditions' => array(
				'Item.item_status_id' => ConstItemStatus::Rejected			
            )
        ) ,
        'total_draft_count' => array(
            'mode' => 'real',
            'key' => 'merchant_id',
            'foreignKey' => 'merchant_id',
            'model' => 'Item',
            'function' => 'COUNT(Item.id)',
			'conditions' => array(
				'Item.item_status_id' => ConstItemStatus::Draft						
            )
        ) ,
        'item_count' => array(
            'mode' => 'real',
            'key' => 'merchant_id',
            'foreignKey' => 'merchant_id',
            'model' => 'Item',
            'function' => 'COUNT(Item.id)',
			'conditions' => array()
        )
    );
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
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'state_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'country_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    public $hasMany = array(
        'Item' => array(
            'className' => 'Item',
            'foreignKey' => 'merchant_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
		'MerchantView' => array(
            'className' => 'MerchantView',
            'foreignKey' => 'merchant_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => true,
        )
    );
    var $hasOne = array(
        'Attachment' => array(
            'className' => 'Attachment',
            'foreignKey' => 'foreign_id',
            'dependent' => true,
            'conditions' => array(
                'Attachment.class'=>'Merchant'),
            'fields' => '',
            'order' => ''
        ) ,
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'name' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'slug' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'address1' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'email' => array(
                'rule' => 'email',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'user_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'city_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'state_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'country_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'zip' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'url' => array(
                'rule2' => array(
                    'rule' => array(
                        'url'
                    ) ,
                    'message' => __l('Must be a valid URL, starting with http://') ,
                    'allowEmpty' => true
                ) ,
                'rule1' => array(
                    'rule' => array(
                        'custom',
                        '/^http:\/\//'
                    ) ,
                    'message' => __l('Must be a valid URL, starting with http://') ,
                    'allowEmpty' => true
                )
            )
        );
        $this->moreActions = array(
            ConstMoreAction::EnableMerchantProfile => __l('Enable Profile') ,
            ConstMoreAction::DisableMerchantProfile => __l('Disable Profile') ,
            ConstMoreAction::Active => __l('Activate') ,
            ConstMoreAction::Inactive => __l('Deactivate') ,
        );
    }
}
?>