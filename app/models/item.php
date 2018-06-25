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
class Item extends AppModel
{
    public $name = 'Item';
    public $displayField = 'name';
    public $actsAs = array(
        'Sluggable' => array(
            'label' => array(
                'name'
            )
        ) ,
        'Aggregatable',
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
            'counterCache' => true,
            'counterScope' => ''
        ) ,
        'Merchant' => array(
            'className' => 'Merchant',
            'foreignKey' => 'merchant_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'ItemStatus' => array(
            'className' => 'ItemStatus',
            'foreignKey' => 'item_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'Charity' => array(
            'className' => 'Charity',
            'foreignKey' => 'charity_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
    );
    public $hasMany = array(
        'Attachment' => array(
            'className' => 'Attachment',
            'foreignKey' => 'foreign_id',
            'conditions' => array(
                'Attachment.class =' => 'Item'
            ) ,
            'dependent' => true
        ) ,
        'UserInterestItem' => array(
            'className' => 'UserInterestItem',
            'foreignKey' => 'item_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'ItemCategoriesItem' => array(
            'className' => 'ItemCategoriesItem',
            'foreignKey' => 'item_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'ItemUser' => array(
            'className' => 'ItemUser',
            'foreignKey' => 'item_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'ItemReferrer' => array(
            'className' => 'ItemReferrer',
            'foreignKey' => 'item_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'ItemPass' => array(
            'className' => 'ItemPass',
            'foreignKey' => 'item_id',
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
        'ItemComment' => array(
            'className' => 'ItemComment',
            'foreignKey' => 'item_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'Transaction' => array(
            'className' => 'Transaction',
            'foreignKey' => 'foreign_id',
            'dependent' => true,
            'conditions' => array(
                'Transaction.class' => 'Item'
            ) ,
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
		'PagseguroTransactionLog' => array(
            'className' => 'PagseguroTransactionLog',
            'foreignKey' => 'item_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'CitiesItem' => array(
            'className' => 'CitiesItem',
            'foreignKey' => 'item_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
		'ItemView' => array(
            'className' => 'ItemView',
            'foreignKey' => 'item_id',
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
    public $hasAndBelongsToMany = array(
        'City' => array(
            'className' => 'City',
            'joinTable' => 'cities_items',
            'foreignKey' => 'item_id',
            'associationForeignKey' => 'city_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ) ,
        'ItemCategory' => array(
            'className' => 'ItemCategory',
            'joinTable' => 'item_categories_items',
            'foreignKey' => 'item_id',
            'associationForeignKey' => 'item_category_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ) ,
        'UserInterest' => array(
            'className' => 'UserInterest',
            'joinTable' => 'user_interest_items',
            'foreignKey' => 'item_id',
            'associationForeignKey' => 'user_interest_id',
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
            'user_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'name' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'min_limit' => array(
                'rule3' => array(
                    'rule' => array(
                        'comparison',
                        '>',
                        0
                    ) ,
                    'allowEmpty' => false,
                    'message' => __l('Should be greater than 0')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'custom',
                        '/^[1-9]\d*\.?[0]*$/'
                    ) ,
                    'allowEmpty' => false,
                    'message' => __l('Should be a number')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                )
            ) ,
            'max_limit' => array(
                'rule3' => array(
                    'rule' => array(
                        '_checkMaxLimt'
                    ) ,
                    'allowEmpty' => true,
                    'message' => __l('Maximum limit should be greater than or equal to minimum limit')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'comparison',
                        '>',
                        0
                    ) ,
                    'allowEmpty' => true,
                    'message' => __l('Should be greater than 0')
                ) ,
                'rule1' => array(
                    'rule' => array(
                        'custom',
                        '/^[1-9]\d*\.?[0]*$/'
                    ) ,
                    'allowEmpty' => true,
                    'message' => __l('Should be a number')
                ) ,
            ) ,
            'commission_percentage' => array(
				'rule3' => array(
                    'rule' => array(
                        '_checkCommissionAmount'
                    ) ,
					'allowEmpty' => false,
                    'message' => (Configure::read('item.commission_amount_type') == 'minimum')? __l('Should be greater than or equal to').' '.Configure::read('item.commission_amount') : __l('Should be equal to').' '.Configure::read('item.commission_amount')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'range',
                        0,
                        100
                    ) ,
                    'allowEmpty' => false,
                    'message' => __l('Must be between of 1 to 100')
                ) ,
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => __l('Should be a number')
                ) ,
            ) ,
            'bonus_amount' => array(
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => true,
                    'message' => __l('Should be a number')
                ) ,
            ) ,
            'city_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'merchant_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'item_status_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'quantity' => array(
                'rule5' => array(
                    'rule' => array(
                        '_isEligibleMaximumQuantity'
                    ) ,
                    'allowEmpty' => false,
                    'message' => __l('Quantity is more than the maximum quantity.')
                ) ,
                'rule4' => array(
                    'rule' => array(
                        '_isEligibleQuantity'
                    ) ,
                    'allowEmpty' => false,
                    'message' => __l('You can\'t buy this quantity.')
                ) ,
                'rule3' => array(
                    'rule' => array(
                        '_isEligibleMinimumQuantity'
                    ) ,
                    'allowEmpty' => false,
                    'message' => __l('Quantity is less than the minimum quantity.')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'comparison',
                        '>',
                        0
                    ) ,
                    'allowEmpty' => false,
                    'message' => __l('Should be greater than 0')
                ) ,
                'rule1' => array(
                    'rule' => array(
                        'custom',
                        '/^[1-9]\d*\.?[0]*$/'
                    ) ,
                    'allowEmpty' => false,
                    'message' => __l('Should be a number')
                ) ,
            ) ,
            'gift_from' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'gift_email' => array(
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
            'gift_to' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'menu' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'price' => array(
                'rule2' => array(
                    'rule' => array(
                        'comparison',
                        '>',
                        0
                    ) ,
                    'allowEmpty' => false,
                    'message' => __l('Should be greater than 0')
                ) ,
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
            ) ,
            'end_date' => array(
                'rule2' => array(
                    'rule' => '_isValidEndDate',
                    'message' => __l('End date should be greater than today') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'event_date' => array(
                'rule3' => array(
                    'rule' => '_isValidEventEndDate',
                    'message' => __l('Event date should be greater than end date') ,
                    'allowEmpty' => false
                ) ,
                'rule2' => array(
                    'rule' => '_isValidEventDate',
                    'message' => __l('Event date should be greater than today') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'be_next_increase_price' => array(
                'rule2' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
                'rule1' => array(
                    'rule' => array(
                        'comparison',
                        '>',
                        0
                    ) ,
                    'allowEmpty' => false,
                    'message' => __l('Should be greater than 0')
                ) ,
            ) ,
            'charity_percentage' => array(
                'rule2' => array(
                    'rule' => '_isValidpercentage',
                    'message' => __l('Charity Amount cannot be zero') ,
                    'allowEmpty' => true
                ) ,
            ) ,
        );
        $this->validateCreditCard = array(
            'firstName' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'lastName' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'creditCardNumber' => array(
                'rule2' => array(
                    'rule' => 'numeric',
                    'message' => __l('Should be numeric') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'cvv2Number' => array(
                'rule2' => array(
                    'rule' => 'numeric',
                    'message' => __l('Should be numeric') ,
                    'allowEmpty' => false
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'zip' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'address' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'city' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'state' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'country' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
        );
        $this->filters = array(
            ConstItemStatus::PendingApproval => __l('Pending') ,
            ConstItemStatus::Open => __l('Open') ,
            ConstItemStatus::Closed => __l('Closed') ,
        );
    }
    //items add page validation
    function _isValidEndDate()
    {
        if (strtotime($this->data[$this->name]['end_date']) > strtotime(date('Y-m-d H:i:s'))) {
            return true;
        }
        return false;
    }
    function _isValidEventDate()
    {
        if (strtotime($this->data[$this->name]['event_date']) < strtotime(date('Y-m-d H:i:s'))) {
            return false;
        }
        return true;
    }
    function _isValidEventEndDate()
    {
        if (!empty($this->data[$this->name]['end_date']) && strtotime($this->data[$this->name]['event_date']) < strtotime($this->data[$this->name]['end_date'])) {
            return false;
        }
        return true;
    }
    //items add page validation
    function _isValidpercentage()
    {
        if ($this->data[$this->name]['charity_percentage'] != 0) {
            return true;
        }
        return false;
    }
    //check whether user can buy this quantity by checking already bought count and buy_max_quantity_per_user field
    //called from items controller
    function isEligibleForBuy($item_id, $user_id, $buy_max_quantity_per_user)
    {
        $items_count = $this->ItemUser->find('first', array(
            'conditions' => array(
                'ItemUser.item_id' => $item_id,
                'ItemUser.user_id' => $user_id,
            ) ,
            'fields' => array(
                'SUM(ItemUser.quantity) as total_count'
            ) ,
            'group' => array(
                'ItemUser.user_id'
            ) ,
            'recursive' => -1
        ));
        if (empty($buy_max_quantity_per_user) || $items_count[0]['total_count'] < $buy_max_quantity_per_user) {
            return true;
        }
        return false;
    }
    //for quantity maximum quantity per user validation
    function _isEligibleMaximumQuantity()
    {
        $items_count = $this->_countUserBoughtItems();
        $item = $this->find('first', array(
            'conditions' => array(
                'Item.id' => $this->data[$this->name]['item_id'],
            ) ,
            'fields' => array(
                'Item.buy_max_quantity_per_user',
            ) ,
            'recursive' => -1
        ));
        $newTotal = (!empty($items_count[0]['total_count']) ? $items_count[0]['total_count'] : 0) +$this->data[$this->name]['quantity'];
        if (empty($item['Item']['buy_max_quantity_per_user']) || $newTotal <= $item['Item']['buy_max_quantity_per_user']) {
            return true;
        }
        return false;
    }
    //for minimum quantity per user validation
    function _isEligibleMinimumQuantity()
    {
        $item = $this->find('first', array(
            'conditions' => array(
                'Item.id' => $this->data[$this->name]['item_id'],
            ) ,
            'fields' => array(
                'Item.buy_min_quantity_per_user',
                'Item.item_user_count',
                'Item.max_limit'
            ) ,
            'recursive' => -1
        ));
        if ($item['Item']['buy_min_quantity_per_user'] > 1) {
            $items_count = $this->_countUserBoughtItems();
            $boughtTotal = (!empty($items_count[0]['total_count']) ? $items_count[0]['total_count'] : 0) +$this->data[$this->name]['quantity'];
            $min = $item['Item']['buy_min_quantity_per_user'];
            if (!empty($item['Item']['max_limit']) && $min >= $item['Item']['max_limit']-$item['Item']['item_user_count']) {
                $min = $item['Item']['max_limit']-$item['Item']['item_user_count'];
            }
            if ($boughtTotal >= $min) {
                return true;
            }
            return false;
        } else {
            return true;
        }
    }
    //count upto this user how much items bought
    function _countUserBoughtItems()
    {
        $items_count = $this->ItemUser->find('first', array(
            'conditions' => array(
                'ItemUser.item_id' => $this->data[$this->name]['item_id'],
                'ItemUser.user_id' => $this->data[$this->name]['user_id'],
            ) ,
            'fields' => array(
                'SUM(ItemUser.quantity) as total_count'
            ) ,
            'group' => array(
                'ItemUser.user_id'
            ) ,
            'recursive' => -1
        ));
        return $items_count;
    }
    //check whether it's eligible quantity to buy
    function _isEligibleQuantity()
    {
        $item = $this->find('first', array(
            'conditions' => array(
                'Item.id' => (!empty($this->data[$this->name]['sub_item_id']) ? $this->data[$this->name]['sub_item_id'] : $this->data[$this->name]['item_id']) ,
            ) ,
            'fields' => array(
                'Item.item_user_count',
                'Item.max_limit'
            ) ,
            'recursive' => -1
        ));
        $newTotal = $item['Item']['item_user_count']+$this->data[$this->name]['quantity'];
        if ($item['Item']['max_limit'] <= 0 || $newTotal <= $item['Item']['max_limit']) {
            return true;
        }
        if (preg_match("/./", $item['Item']['max_limit'])) {
            return false;
        }
        return false;
    }
    //validate item buy_min_quantity_per_user limit with maximum limit
    function _compareItemAndBuyMinLimt()
    {
        if (empty($this->data[$this->name]['max_limit']) || $this->data[$this->name]['max_limit'] >= $this->data[$this->name]['buy_min_quantity_per_user']) {
            return true;
        }
        return false;
    }
    //validate item buy_max_quantity_per_user limit with maximum limit
    function _compareItemAndBuyMaxLimt()
    {
        if (empty($this->data[$this->name]['max_limit']) || $this->data[$this->name]['max_limit'] >= $this->data[$this->name]['buy_max_quantity_per_user']) {
            return true;
        }
        return false;
    }
    //validate item minimum limit with maximum limit
    function _checkMaxLimt()
    {
        if ($this->data[$this->name]['max_limit'] >= $this->data[$this->name]['min_limit']) {
            return true;
        }
        return false;
    }
    //validate item buy_max_quantity_per_user limit with buy_min_quantity_per_user limit
    function _checkMaxQuantityLimt()
    {
        if ($this->data[$this->name]['buy_max_quantity_per_user'] >= $this->data[$this->name]['buy_min_quantity_per_user']) {
            return true;
        }
        return false;
    }
	function _checkCommissionAmount($data) 
	{
		$is_valid_field = true;
		if ($_SESSION['Auth']['User']['id'] != ConstUserTypes::Admin && Configure::read('item.is_admin_enable_commission')) {
			if (!empty($this->data['Item']['price'])) {
				if (Configure::read('item.commission_amount_type') == 'minimum' && $this->data['Item']['commission_percentage'] < Configure::read('item.commission_amount')) {
					$is_valid_field = false;
				}
				if (Configure::read('item.commission_amount_type') == 'fixed' && $this->data['Item']['commission_percentage'] != Configure::read('item.commission_amount')) {
					$is_valid_field = false;
				}
			}
		}
		return $is_valid_field;
    }
    //Process Tipped and closing status of item
    function processItemStatus($item_id, $last_inserted_id)
    {
        $item = $this->find('first', array(
            'conditions' => array(
                'Item.item_status_id' => ConstItemStatus::Tipped,
                'Item.id' => $item_id
            ) ,
            'fields' => array(
                'Item.is_pass_mail_sent',
                'Item.max_limit',
                'Item.item_user_count',
                'Item.id'
            ) ,
            'recursive' => -1,
        ));
        if (!empty($item)) {
            // - X Referral Methiod //
            if (Configure::read('referral.referral_enabled_option') == ConstReferralOption::XRefer) {
                $this->referalRefunding($item_id);
            }
            //handle tipped status
            $this->processTippedStatus($item, $last_inserted_id);
            //handle closed status if max user reached
            if (!empty($item['Item']['max_limit']) && $item['Item']['item_user_count'] >= $item['Item']['max_limit']) {
                $this->_closeItems(array(
                    $item['Item']['id']
                ));
            }
        }
    }
    //Process Tipped status of item
    function processTippedStatus($item_details, $last_inserted_id)
    {
        $ItemUserConditions = array();
        $ItemUserConditions['ItemUser.is_canceled'] = 0;
        if ($item_details['Item']['is_pass_mail_sent']) {
            $ItemUserConditions['ItemUser.id'] = $last_inserted_id;
        }
        $item = $this->find('first', array(
            'conditions' => array(
                'Item.item_status_id' => ConstItemStatus::Tipped,
                'Item.id' => $item_details['Item']['id']
            ) ,
            'contain' => array(
                'ItemUser' => array(
                    'User' => array(
                        'fields' => array(
                            'User.username',
                            'User.id',
                            'User.email',
                            'User.cim_profile_id'
                        ) ,
                        'UserProfile' => array(
                            'fields' => array(
                                'UserProfile.first_name',
                                'UserProfile.last_name'
                            ) ,
                        ) ,
                    ) ,
                    'ItemUserPass',
                    'PaypalDocaptureLog' => array(
                        'fields' => array(
                            'PaypalDocaptureLog.currency_id',
                            'PaypalDocaptureLog.converted_currency_id',
                            'PaypalDocaptureLog.original_amount',
                            'PaypalDocaptureLog.rate',
                            'PaypalDocaptureLog.authorizationid',
                            'PaypalDocaptureLog.dodirectpayment_amt',
                            'PaypalDocaptureLog.id',
                            'PaypalDocaptureLog.currencycode'
                        )
                    ) ,
                    'AuthorizenetDocaptureLog' => array(
                        'fields' => array(
                            'AuthorizenetDocaptureLog.currency_id',
                            'AuthorizenetDocaptureLog.converted_currency_id',
                            'AuthorizenetDocaptureLog.original_amount',
                            'AuthorizenetDocaptureLog.rate',
                            'AuthorizenetDocaptureLog.authorize_amt'
                        )
                    ) ,
                    'PaypalTransactionLog' => array(
                        'fields' => array(
                            'PaypalTransactionLog.currency_id',
                            'PaypalTransactionLog.converted_currency_id',
                            'PaypalTransactionLog.orginal_amount',
                            'PaypalTransactionLog.rate',
                            'PaypalTransactionLog.authorization_auth_exp',
                            'PaypalTransactionLog.authorization_auth_id',
                            'PaypalTransactionLog.authorization_auth_amount',
                            'PaypalTransactionLog.authorization_auth_status',
                            'PaypalTransactionLog.mc_currency',
                            'PaypalTransactionLog.mc_gross',
                            'PaypalTransactionLog.id'
                        )
                    ) ,
                    'conditions' => $ItemUserConditions,
                ) ,
                'Merchant' => array(
                    'City' => array(
                        'fields' => array(
                            'City.id',
                            'City.name',
                            'City.slug',
                        )
                    ) ,
                    'State' => array(
                        'fields' => array(
                            'State.id',
                            'State.name'
                        )
                    ) ,
                    'Country' => array(
                        'fields' => array(
                            'Country.id',
                            'Country.name',
                            'Country.slug',
                        )
                    ) ,
                ) ,
                'Attachment' => array(
                    'fields' => array(
                        'Attachment.id',
                        'Attachment.dir',
                        'Attachment.filename',
                        'Attachment.width',
                        'Attachment.height'
                    )
                ) ,
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                    )
                ) ,
            ) ,
            'recursive' => 3,
        ));
        //do capture for credit card
        if (!empty($item['ItemUser'])) {
            App::import('Core', 'ComponentCollection');
            $collection = new ComponentCollection();
            App::import('Component', 'Paypal');
            $this->Paypal = new PaypalComponent($collection);
            $paymentGateways = $this->User->Transaction->PaymentGateway->find('all', array(
                'conditions' => array(
                    'PaymentGateway.id' => array(
                        ConstPaymentGateways::CreditCard,
                        ConstPaymentGateways::AuthorizeNet
                    ) ,
                ) ,
                'contain' => array(
                    'PaymentGatewaySetting' => array(
                        'fields' => array(
                            'PaymentGatewaySetting.key',
                            'PaymentGatewaySetting.test_mode_value',
                            'PaymentGatewaySetting.live_mode_value',
                        ) ,
                    ) ,
                ) ,
                'recursive' => 1
            ));
            foreach($paymentGateways as $paymentGateway) {
                if ($paymentGateway['PaymentGateway']['id'] == ConstPaymentGateways::CreditCard) {
                    if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                        foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                            if ($paymentGatewaySetting['key'] == 'directpay_API_UserName') {
                                $paypal_sender_info['API_UserName'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                            }
                            if ($paymentGatewaySetting['key'] == 'directpay_API_Password') {
                                $paypal_sender_info['API_Password'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                            }
                            if ($paymentGatewaySetting['key'] == 'directpay_API_Signature') {
                                $paypal_sender_info['API_Signature'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                            }
                            $paypal_sender_info['is_testmode'] = $paymentGateway['PaymentGateway']['is_test_mode'];
                        }
                    }
                }
                if ($paymentGateway['PaymentGateway']['id'] == ConstPaymentGateways::AuthorizeNet) {
                    if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                        foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                            if ($paymentGatewaySetting['key'] == 'authorize_net_api_key') {
                                $authorize_sender_info['api_key'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                            }
                            if ($paymentGatewaySetting['key'] == 'authorize_net_trans_key') {
                                $authorize_sender_info['trans_key'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                            }
                        }
                    }
                    $authorize_sender_info['is_test_mode'] = $paymentGateway['PaymentGateway']['is_test_mode'];
                }
            }
            $paidItemUsers = array();
            foreach($item['ItemUser'] as $ItemUser) {
                if (!$ItemUser['is_paid'] && $ItemUser['payment_gateway_id'] != ConstPaymentGateways::Wallet) {
                    $payment_response = array();
                    if ($ItemUser['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
                        $capture = 0;
                        require_once (APP . 'vendors' . DS . 'CIM' . DS . 'AuthnetCIM.class.php');
                        if ($authorize_sender_info['is_test_mode']) {
                            $cim = new AuthnetCIM($authorize_sender_info['api_key'], $authorize_sender_info['trans_key'], true);
                        } else {
                            $cim = new AuthnetCIM($authorize_sender_info['api_key'], $authorize_sender_info['trans_key']);
                        }
                        $ItemUser['discount_amount'] = $this->_convertAuthorizeAmount($ItemUser['discount_amount'], $ItemUser['AuthorizenetDocaptureLog']['rate']);
                        $cim->setParameter('amount', $ItemUser['discount_amount']);
                        $cim->setParameter('refId', time());
                        $cim->setParameter('customerProfileId', $ItemUser['User']['cim_profile_id']);
                        $cim->setParameter('customerPaymentProfileId', $ItemUser['payment_profile_id']);
                        $cim_transaction_type = 'profileTransAuthCapture';
                        if (!empty($ItemUser['cim_approval_code'])) {
                            $cim->setParameter('approvalCode', $ItemUser['cim_approval_code']);
                            $cim_transaction_type = 'profileTransCaptureOnly';
                        }
                        $title = Configure::read('site.name') . ' - Item Bought';
                        $description = 'Item Bought in ' . Configure::read('site.name');
                        // CIM accept only 30 character in title
                        if (strlen($title) > 30) {
                            $title = substr($title, 0, 27) . '...';
                        }
                        $unit_amount = $ItemUser['discount_amount']/$ItemUser['quantity'];
                        $cim->setLineItem($ItemUser['item_id'], $title, $description, $ItemUser['quantity'], $unit_amount);
                        $cim->createCustomerProfileTransaction($cim_transaction_type);
                        $response = $cim->getDirectResponse();
                        $response_array = explode(',', $response);
                        if ($cim->isSuccessful() && $response_array[0] == 1) {
                            $capture = 1;
                        }
                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['item_user_id'] = $ItemUser['id'];
                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_response_text'] = $cim->getResponseText();
                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_authorization_code'] = $cim->getAuthCode();
                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_avscode'] = $cim->getAVSResponse();
                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['transactionid'] = $cim->getTransactionID();
                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_amt'] = $response_array[9];
                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_gateway_feeamt'] = $response[32];
                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_cvv2match'] = $cim->getCVVResponse();
                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['authorize_response'] = $response;
                        if (!empty($capture)) {
                            $data_authorize_docapture_log['AuthorizenetDocaptureLog']['payment_status'] = 'Completed';
                        }
                        $this->ItemUser->AuthorizenetDocaptureLog->save($data_authorize_docapture_log);
                    } else {
                        //doCapture process for credit card and paypal auth
                        if ($ItemUser['payment_gateway_id'] == ConstPaymentGateways::CreditCard && !empty($ItemUser['PaypalDocaptureLog']['authorizationid'])) {
                            $post_info['authorization_id'] = $ItemUser['PaypalDocaptureLog']['authorizationid'];
                            $post_info['amount'] = $ItemUser['PaypalDocaptureLog']['dodirectpayment_amt'];
                            $post_info['invoice_id'] = $ItemUser['PaypalDocaptureLog']['id'];
                            $post_info['currency'] = $ItemUser['PaypalDocaptureLog']['currencycode'];
                        } else if ($ItemUser['payment_gateway_id'] == ConstPaymentGateways::PayPalAuth && !empty($ItemUser['PaypalTransactionLog']['authorization_auth_id'])) {
                            $post_info['authorization_id'] = $ItemUser['PaypalTransactionLog']['authorization_auth_id'];
                            $post_info['amount'] = $ItemUser['PaypalTransactionLog']['authorization_auth_amount'];
                            $post_info['invoice_id'] = $ItemUser['PaypalTransactionLog']['id'];
                            $post_info['currency'] = $ItemUser['PaypalTransactionLog']['mc_currency'];
                        }
                        $post_info['CompleteCodeType'] = 'Complete';
                        $post_info['note'] = __l('Item Payment');
                        //call doCapture from paypal component
                        $payment_response = $this->Paypal->doCapture($post_info, $paypal_sender_info);
                    }
                    if ((!empty($payment_response) && $payment_response['ACK'] == 'Success') || !empty($capture)) {
                        //update PaypalDocaptureLog for credit card
                        if ($ItemUser['payment_gateway_id'] == ConstPaymentGateways::CreditCard) {
                            $data_paypal_docapture_log['PaypalDocaptureLog']['id'] = $ItemUser['PaypalDocaptureLog']['id'];
                            foreach($payment_response as $key => $value) {
                                if ($key != 'AUTHORIZATIONID' && $key != 'VERSION' && $key != 'CURRENCYCODE') {
                                    $data_paypal_docapture_log['PaypalDocaptureLog']['docapture_' . strtolower($key) ] = $value;
                                }
                            }
                            $data_paypal_docapture_log['PaypalDocaptureLog']['docapture_response'] = serialize($payment_response);
                            $data_paypal_docapture_log['PaypalDocaptureLog']['payment_status'] = 'Completed';
                            $this->ItemUser->PaypalDocaptureLog->save($data_paypal_docapture_log);
                        } else if ($ItemUser['payment_gateway_id'] == ConstPaymentGateways::PayPalAuth) {
                            //update PaypalTransactionLog for PayPalAuth
                            $data_paypal_capture_log['PaypalTransactionLog']['id'] = $ItemUser['PaypalTransactionLog']['id'];
                            foreach($payment_response as $key => $value) {
                                $data_paypal_capture_log['PaypalTransactionLog']['capture_' . strtolower($key) ] = $value;
                            }
                            $data_paypal_capture_log['PaypalTransactionLog']['capture_data'] = serialize($payment_response);
                            $data_paypal_capture_log['PaypalTransactionLog']['error_no'] = '0';
                            $data_paypal_capture_log['PaypalTransactionLog']['payment_status'] = 'Completed';
                            $this->ItemUser->PaypalTransactionLog->save($data_paypal_capture_log);
                        }
                        // need to updatee item user record is_paid as 1
                        $paidItemUsers[] = $ItemUser['id'];
                        //add amount to wallet
                        // coz of 'act like groupon' logic, amount updated from what actual taken, instead of updating item amount directly.
                        if (!empty($ItemUser['PaypalTransactionLog']['orginal_amount'])) {
                            $paid_amount = $ItemUser['PaypalTransactionLog']['orginal_amount'];
                        } elseif (!empty($ItemUser['PaypalDocaptureLog']['original_amount'])) {
                            $paid_amount = $ItemUser['PaypalDocaptureLog']['original_amount'];
                        }
                        $data['Transaction']['user_id'] = $ItemUser['user_id'];
                        $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                        $data['Transaction']['class'] = 'SecondUser';
                        //$data['Transaction']['amount'] = $ItemUser['discount_amount'];
                        $data['Transaction']['amount'] = $paid_amount;
                        $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
                        $data['Transaction']['payment_gateway_id'] = $ItemUser['payment_gateway_id'];
                        $transaction_id = $this->User->Transaction->log($data);
                        if (!empty($transaction_id)) {
                            $this->User->updateAll(array(
                                'User.available_balance_amount' => 'User.available_balance_amount +' . $paid_amount
                            ) , array(
                                'User.id' => $ItemUser['user_id']
                            ));
                        }
                        //Buy item transaction
                        $transaction['Transaction']['user_id'] = $ItemUser['user_id'];
                        $transaction['Transaction']['foreign_id'] = $ItemUser['id'];
                        $transaction['Transaction']['class'] = 'ItemUser';
                        $transaction['Transaction']['amount'] = $paid_amount;
                        $transaction['Transaction']['payment_gateway_id'] = $ItemUser['payment_gateway_id'];
                        if (!empty($ItemUser['PaypalTransactionLog']['rate'])) {
                            $transaction['Transaction']['currency_id'] = $ItemUser['PaypalTransactionLog']['currency_id'];
                            $transaction['Transaction']['converted_currency_id'] = $ItemUser['PaypalTransactionLog']['converted_currency_id'];
                            $transaction['Transaction']['converted_amount'] = $ItemUser['PaypalTransactionLog']['mc_gross'];
                            $transaction['Transaction']['rate'] = $ItemUser['PaypalTransactionLog']['rate'];
                        }
                        if (!empty($ItemUser['PaypalDocaptureLog']['rate'])) {
                            $transaction['Transaction']['currency_id'] = $ItemUser['PaypalDocaptureLog']['currency_id'];
                            $transaction['Transaction']['converted_currency_id'] = $ItemUser['PaypalDocaptureLog']['converted_currency_id'];
                            $transaction['Transaction']['converted_amount'] = $ItemUser['PaypalDocaptureLog']['dodirectpayment_amt'];
                            $transaction['Transaction']['rate'] = $ItemUser['PaypalDocaptureLog']['rate'];
                        }
                        if (!empty($ItemUser['AuthorizenetDocaptureLog']['rate'])) {
                            $transaction['Transaction']['currency_id'] = $ItemUser['AuthorizenetDocaptureLog']['currency_id'];
                            $transaction['Transaction']['converted_currency_id'] = $ItemUser['AuthorizenetDocaptureLog']['converted_currency_id'];
                            $transaction['Transaction']['converted_amount'] = $ItemUser['AuthorizenetDocaptureLog']['authorize_amt'];
                            $transaction['Transaction']['rate'] = $ItemUser['AuthorizenetDocaptureLog']['rate'];
                        }
                        $transaction['Transaction']['transaction_type_id'] = (!empty($ItemUser['is_gift'])) ? ConstTransactionTypes::ItemGift : ConstTransactionTypes::BuyItem;
                        $this->User->Transaction->log($transaction);
                        //user update
                        $this->User->updateAll(array(
                            'User.available_balance_amount' => 'User.available_balance_amount -' . $paid_amount
                        ) , array(
                            'User.id' => $ItemUser['user_id']
                        ));
                    } else {
                        //ack from paypal is not succes, so increasing payment_failed_count in items table
                        $this->updateAll(array(
                            'Item.payment_failed_count' => 'Item.payment_failed_count +' . $ItemUser['quantity'],
                        ) , array(
                            'Item.id' => $ItemUser['item_id']
                        ));
                    }
                }
            }
            if (!empty($paidItemUsers)) {
                //update is_paid field
                $this->ItemUser->updateAll(array(
                    'ItemUser.is_paid' => 1
                ) , array(
                    'ItemUser.id' => $paidItemUsers
                ));
                // paid user "is_paid" field update on $item array, bcoz this array pass the _sendPassMail.
                if (!empty($item['ItemUser'])) {
                    foreach($item['ItemUser'] as &$item_user) {
                        foreach($paidItemUsers as $paid) {
                            if ($item_user['id'] == $paid) {
                                $item_user['is_paid'] = 1;
                            }
                        }
                    }
                }
            }
        }
        //do capture for credit card end
        //send pass mail to users when item tipped
        $this->_sendPassMail($item);
        if (!$item_details['Item']['is_pass_mail_sent']) {
            //update in items table as pass_mail_sent
            $this->updateAll(array(
                'Item.is_pass_mail_sent' => 1
            ) , array(
                'Item.id' => $item['Item']['id']
            ));
        }
    }
    //send buyers list to merchant user
    function _sendBuyersListMerchant($itemIds)
    {
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Email');
        $this->Email = new EmailComponent($collection);
        $items = $this->find('all', array(
            'conditions' => array(
                'Item.id' => $itemIds
            ) ,
            'contain' => array(
                'ItemUser' => array(
                    'User' => array(
                        'fields' => array(
                            'User.username',
                            'User.email',
                        ) ,
                        'order' => array(
                            'User.username' => 'asc'
                        )
                    ) ,
                    'ItemUserPass',
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                    ) ,
                    'order' => array(
                        'User.username' => 'asc'
                    ) ,
                ) ,
                'Merchant' => array(
                    'City' => array(
                        'fields' => array(
                            'City.id',
                            'City.name',
                            'City.slug',
                        )
                    ) ,
                    'State' => array(
                        'fields' => array(
                            'State.id',
                            'State.name'
                        )
                    ) ,
                    'Country' => array(
                        'fields' => array(
                            'Country.id',
                            'Country.name',
                            'Country.slug',
                        )
                    )
                ) ,
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                    )
                ) ,
            ) ,
            'recursive' => 2,
        ));
        if (!empty($items)) {
            foreach($items as $item) {
                if (!empty($item['Merchant']['is_online_account'])) {
                    $ItemUsers = $item['ItemUser'];
                    if (!empty($ItemUsers)) {
                        //form users list array
                        $userslist = '';
                        $userslist.= '<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC" border="0"  style="color:#666; font-size:11px;">';
                        $userslist.= '<tr><th align="left" bgcolor="#BEE27B" style="color:#ffffff; font-size:14px;" rowspan="2">' . __l('Username') . '</th><th align="center" bgcolor="#BEE27B" style="color:#ffffff; font-size:14px;" colspan="2">' . __l('Pass code') . '</th><th bgcolor="#BEE27B" style="color:#ffffff; font-size:14px;" rowspan="2">' . __l('Quantity') . '</th><th bgcolor="#BEE27B" style="color:#ffffff; font-size:14px;" rowspan="2">' . __l('Payment pending') . '</th></tr><tr><th bgcolor="#BEE27B" style="color:#ffffff; font-size:14px;">' . __l('Top code') . '</th><th bgcolor="#BEE27B" style="color:#ffffff; font-size:14px;">' . __l('Bottom code') . '</th></tr>';
                        foreach($ItemUsers as $ItemUser) {
                            $pending_amount = "";
                            if (!empty($ItemUser['Item']['is_enable_payment_advance'])) {
                                $pending_amount = Configure::read('site.currency') . $ItemUser['Item']['payment_remaining'];
                            } else {
                                $pending_amount = "-";
                            }
                            if (!empty($ItemUser) && empty($ItemUser['is_canceled'])) {
                                $item_user_pass_codes = array();
                                $item_user_pass_codes = '<ul>';
                                $item_user_unqiue_codes = '<ul>';
                                foreach($ItemUser['ItemUserPass'] as $item_user_pass) {
                                    $item_user_pass_codes.= '<li>' . $item_user_pass['pass_code'] . '</li>';
                                    $item_user_unqiue_codes.= '<li>' . $item_user_pass['unique_pass_code'] . '</li>';
                                }
                                $item_user_pass_codes.= '</ul>';
                                $item_user_unqiue_codes.= '</ul>';
                                $userslist.= '<tr><td bgcolor="#FFFFFF" align="left">' . $ItemUser['User']['username'] . '</td><td bgcolor="#FFFFFF" align="left">' . $item_user_pass_codes . '</td><td bgcolor="#FFFFFF" align="center">' . $item_user_unqiue_codes . '</td><td bgcolor="#FFFFFF" align="center">' . $ItemUser['quantity'] . '</td><td bgcolor="#FFFFFF" align="center">' . $pending_amount . '</td></tr>';
                            }
                        }
                        $userslist.= '</table>';
                    }
                    $merchantUser = $this->Merchant->User->find('first', array(
                        'conditions' => array(
                            'User.id' => $item['Merchant']['user_id']
                        ) ,
                        'fields' => array(
                            'User.username',
                            'User.id',
                            'User.email',
                        ) ,
                        'contain' => array(
                            'UserProfile.first_name',
                            'UserProfile.last_name'
                        ) ,
                        'recursive' => 2,
                    ));
                    $address = $item['Merchant']['address1'] . '<br/>' . $item['Merchant']['address2'];
                    if (!empty($item['Merchant']['City']['name'])) {
                        $address.= '<br/>' . $item['Merchant']['City']['name'];
                    }
                    if (!empty($item['Merchant']['State']['name'])) {
                        $address.= '<br/>' . $item['Merchant']['State']['name'];
                    }
                    if (!empty($item['Merchant']['Country']['name'])) {
                        $address.= '<br/>' . $item['Merchant']['Country']['name'];
                    }
                    if (!empty($item['Merchant']['zip'])) {
                        $address.= '<br/>' . $item['Merchant']['zip'];
                    }
                    //send mail to merchant user
                    $template = $this->EmailTemplate->selectTemplate('Item Pass Buyers List');
                    $emailFindReplace = array(
                        '##SITE_URL##' => Cache::read('site_url_for_shell', 'long') ,
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##ITEM_NAME##' => $item['Item']['name'],
                        '##ITEM_LINK##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'items',
                            'action' => 'view',
                            $item['Item']['slug'],
                            'admin' => false
                        ) , false) , 1) ,
                        '##USERNAME##' => $merchantUser['User']['username'],
                        '##EVENT_DATE##' => strftime(Configure::read('site.datetime.format'), strtotime($item['Item']['event_date'])),
                        '##PASS_CONDITION##' => !empty($item['Item']['pass_condition']) ? $item['Item']['pass_condition'] : 'N/A',
                        '##REDEMPTION_PLACE##' => $address,
                        '##ITEM_URL##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'items',
                            'action' => 'view',
                            'city' => $item['City']['0']['slug'],
                            $item['Item']['slug'],
                            'admin' => false
                        ) , false) , 1) ,
                        '##CONTACT_URL##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add',
                            'city' => $item['City']['0']['slug'],
                            'admin' => false
                        ) , false) , 1) ,
                        '##FROM_EMAIL##' => $this->changeFromEmail(($template['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $template['from']) ,
                        '##TABLE##' => $userslist,
                        '##SITE_LOGO##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'img',
                            'action' => 'blue-theme',
                            'logo-email.png',
                            'admin' => false
                        ) , false) , 1) ,
                    );
                    if (!empty($item['ItemUser'])) {
                        $this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $template['from'];
                        $this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $template['reply_to'];
                        $this->Email->to = $this->formatToAddress($merchantUser);
                        $this->Email->subject = strtr($template['subject'], $emailFindReplace);
                        $this->Email->content = strtr($template['email_content'], $emailFindReplace);
                        $this->Email->sendAs = ($template['is_html']) ? 'html' : 'text';
                        $this->Email->send($this->Email->content);
                    }
                }
            }
        }
    }
    //send pass mail to users once item tipped
    function _sendPassMail($item)
    {
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Email');
        $this->Email = new EmailComponent($collection);
        /* sending pass to all item users and vendor starts here */
        $is_mail_sent = '';
        $emailFindReplace = array();
        if (!empty($item['ItemUser'])) {
            foreach($item['ItemUser'] as $item_user) {
                if ($item_user['is_paid']) {
                    if (empty($item_user['is_canceled'])) {
                        $barcode = Router::url(array(
                            'controller' => 'items',
                            'action' => 'barcode',
                            $item_user['id'],
                            'admin' => false
                        ) , true);
                        //for normal bought items send Item Pass mail
                        $i = 1;
                        $content = '';
						$is_mail_sent = $item['Item']['is_pass_mail_sent'];
						$language_code = $this->getUserLanguageIso($item_user['User']['id']);
						$template = $this->EmailTemplate->selectTemplate('Item Pass', $language_code);
						$emailFindReplace = array(
							'##SITE_URL##' => Cache::read('site_url_for_shell', 'long') ,
							'##ITEM_NAME##' => $item['Item']['name'],
							'##SITE_NAME##' => Configure::read('site.name') ,
							'##QUANTITY##' => 1,
							'##MERCHANT_ADDRESS##' => $content,
							'##PASS_PURCHASED_DATE##' => strftime(Configure::read('site.datetime.format') , strtotime($item_user['created'])) ,
							'##FROM_EMAIL##' => $this->changeFromEmail(($template['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $template['from']) ,
							'##SITE_LOGO##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
								'controller' => 'img',
								'action' => 'blue-theme',
								'logo-black.png',
								'admin' => false
							) , false) , 1) ,
							'##CONTACT_URL##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', 'contactus', 1) ,
							'##CONTACT_LINK##' => "<a href='mailto:" . Configure::read('site.contact_email') . "'>" . Configure::read('site.contact_email') . "</a>",
							'##GOOGLE_MAP##' => $this->formGooglemap($item['Merchant'], '340x250')
						); //is_enable_payment_advance, payment_remaining
						if (!empty($item['Item']['is_enable_payment_advance'])) {
							$emailFindReplace['##PENDING_AMOUNT##'] = "<strong style=\"color:#000; font-size:16px;display:block;margin:6px 0px 0px 0px; padding:0px 0px 0px 0px;display:block;\">Pending Amount:</strong>
								<p style=\"margin:0px;padding:0px;font-size:13px;color:#000;\">" . Configure::read('site.currency') . $item['Item']['payment_remaining'] . "</p>";
						} else {
							$emailFindReplace['##PENDING_AMOUNT##'] = '';
						}
						// Multiple pass - sending mail for each pass //
						if (!empty($item_user['ItemUserPass'])) {
							foreach($item_user['ItemUserPass'] as $item_user_pass) {
								$emailFindReplace['##PASS_CODE##'] = '#' . $item_user_pass['pass_code'];
								$emailFindReplace['##USER_NAME##'] = $item_user_pass['guest_name'];
								$parsed_url = parse_url(Router::url('/', true));
								$qr_code = str_ireplace($parsed_url['host'], 'm.' . $parsed_url['host'], Router::url(array(
									'controller' => 'item_user_passes',
									'action' => 'check_qr',
									$item_user_pass['pass_code'],
									$item_user_pass['unique_pass_code'],
									'admin' => false
								) , true));
								$display_barcode = '';
								if (Configure::read('barcode.is_barcode_enabled')) {
									$barcode_width = Configure::read('barcode.width');
									$barcode_height = Configure::read('barcode.height');
									if (Configure::read('barcode.symbology') == 'qr') {
										$display_barcode = '<img src="http://chart.apis.google.com/chart?cht=qr&chs=' . $barcode_width . 'x' . $barcode_height . '&chl=' . $qr_code . '" alt="[Image: Item qr code]" />';
									}
									if (Configure::read('barcode.symbology') == 'c39') {
										$display_barcode = '<img src="' . $barcode . '" alt="[Image: barcode]" />';
									}
									$display_barcode.= '<br><b>' . $item_user_pass['unique_pass_code'] . '</b>';
								}
								$emailFindReplace['##BARCODE##'] = $display_barcode;
								$this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $template['from'];
								$this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $template['reply_to'];
								$this->Email->to = $item_user_pass['guest_name'] . ' <' . $item_user_pass['guest_email'] . '>';
								$this->Email->subject = strtr($template['subject'], $emailFindReplace);
								$this->Email->content = strtr($template['email_content'], $emailFindReplace);
								$this->Email->sendAs = ($template['is_html']) ? 'html' : 'text';
								$this->Email->send($this->Email->content);
							}
						}
                    }
                }
            }
        }
    }
    //refund item amount to users if item expired or canceled
    function _refundItemAmount($type = '', $itemIds = array())
    {
        $ItemUserConditions = array(
            'OR' => array(
                array(
                    'ItemUser.is_paid' => 1,
                    'ItemUser.is_repaid' => 0,
                    'ItemUser.is_canceled' => 0,
                    'ItemUser.payment_gateway_id' => ConstPaymentGateways::Wallet
                ) ,
                array(
                    'ItemUser.is_paid' => 0,
                    'ItemUser.is_repaid' => 0,
                    'ItemUser.is_canceled' => 0,
                    'ItemUser.payment_gateway_id' => array(
                        ConstPaymentGateways::CreditCard,
                        ConstPaymentGateways::PayPalAuth,
                        ConstPaymentGateways::AuthorizeNet,
                    )
                )
            )
        );
        if (!empty($itemIds)) {
            $conditions['Item.id'] = $itemIds;
        } elseif (!empty($type) && $type == 'cron') {
            $conditions['Item.item_status_id'] = array(
                ConstItemStatus::Expired,
                ConstItemStatus::Canceled
            );
        }
        $items = $this->find('all', array(
            'conditions' => $conditions,
            'contain' => array(
                'ItemUser' => array(
                    'User' => array(
                        'fields' => array(
                            'User.username',
                            'User.email',
                            'User.id',
                            'User.cim_profile_id',
                        ) ,
                        'UserProfile' => array(
                            'fields' => array(
                                'UserProfile.first_name',
                                'UserProfile.last_name'
                            ) ,
                        ) ,
                    ) ,
                    'PaypalDocaptureLog' => array(
                        'fields' => array(
                            'PaypalDocaptureLog.authorizationid',
                            'PaypalDocaptureLog.dodirectpayment_amt',
                            'PaypalDocaptureLog.id',
                            'PaypalDocaptureLog.currencycode'
                        )
                    ) ,
                    'PaypalTransactionLog' => array(
                        'fields' => array(
                            'PaypalTransactionLog.id',
                            'PaypalTransactionLog.authorization_auth_exp',
                            'PaypalTransactionLog.authorization_auth_id',
                            'PaypalTransactionLog.authorization_auth_amount',
                            'PaypalTransactionLog.authorization_auth_status'
                        )
                    ) ,
                    'AuthorizenetDocaptureLog' => array(
                        'fields' => array(
                            'AuthorizenetDocaptureLog.id',
                            'AuthorizenetDocaptureLog.authorize_amt',
                        )
                    ) ,
                    'conditions' => $ItemUserConditions,
                ) ,
                'Merchant' => array(
                    'fields' => array(
                        'Merchant.name',
                        'Merchant.id',
                        'Merchant.url',
                        'Merchant.zip',
                        'Merchant.address1',
                        'Merchant.address2',
                        'Merchant.city_id'
                    ) ,
                    'City' => array(
                        'fields' => array(
                            'City.id',
                            'City.name',
                            'City.slug',
                        )
                    ) ,
                    'State' => array(
                        'fields' => array(
                            'State.id',
                            'State.name'
                        )
                    ) ,
                    'Country' => array(
                        'fields' => array(
                            'Country.id',
                            'Country.name',
                            'Country.slug',
                        )
                    )
                ) ,
                'Attachment' => array(
                    'fields' => array(
                        'Attachment.id',
                        'Attachment.dir',
                        'Attachment.filename',
                        'Attachment.width',
                        'Attachment.height'
                    )
                ) ,
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                    )
                ) ,
            ) ,
            'recursive' => 3,
        ));
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Email');
        $this->Email = new EmailComponent($collection);
        if (!empty($items)) {
            $itemIds = array();
            App::import('Component', 'Paypal');
            $this->Paypal = new PaypalComponent($collection);
            $paymentGateways = $this->User->Transaction->PaymentGateway->find('all', array(
                'conditions' => array(
                    'PaymentGateway.id' => array(
                        ConstPaymentGateways::CreditCard,
                        ConstPaymentGateways::AuthorizeNet
                    ) ,
                ) ,
                'contain' => array(
                    'PaymentGatewaySetting' => array(
                        'fields' => array(
                            'PaymentGatewaySetting.key',
                            'PaymentGatewaySetting.test_mode_value',
                            'PaymentGatewaySetting.live_mode_value',
                        ) ,
                    ) ,
                ) ,
                'recursive' => 1
            ));
            foreach($paymentGateways as $paymentGateway) {
                if ($paymentGateway['PaymentGateway']['id'] == ConstPaymentGateways::CreditCard) {
                    if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                        foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                            if ($paymentGatewaySetting['key'] == 'directpay_API_UserName') {
                                $paypal_sender_info['API_UserName'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                            }
                            if ($paymentGatewaySetting['key'] == 'directpay_API_Password') {
                                $paypal_sender_info['API_Password'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                            }
                            if ($paymentGatewaySetting['key'] == 'directpay_API_Signature') {
                                $paypal_sender_info['API_Signature'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                            }
                        }
                        $paypal_sender_info['is_testmode'] = $paymentGateway['PaymentGateway']['is_test_mode'];
                    }
                }
                if ($paymentGateway['PaymentGateway']['id'] == ConstPaymentGateways::AuthorizeNet) {
                    if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                        foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                            if ($paymentGatewaySetting['key'] == 'authorize_net_api_key') {
                                $authorize_sender_info['api_key'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                            }
                            if ($paymentGatewaySetting['key'] == 'authorize_net_trans_key') {
                                $authorize_sender_info['trans_key'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                            }
                        }
                    }
                    $authorize_sender_info['is_test_mode'] = $paymentGateway['PaymentGateway']['is_test_mode'];
                }
            }
            foreach($items as $item) {
                if (!empty($item['ItemUser'])) {
                    $ItemUserIds = array();
					$itemUserIdData = array();
					$itemIds = array();
                    foreach($item['ItemUser'] as $item_user) {
                        //do void for credit card
                        if ($item_user['payment_gateway_id'] != ConstPaymentGateways::Wallet) {
                            if ($item_user['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
                                require_once (APP . 'vendors' . DS . 'CIM' . DS . 'AuthnetCIM.class.php');
                                if ($authorize_sender_info['is_test_mode']) {
                                    $cim = new AuthnetCIM($authorize_sender_info['api_key'], $authorize_sender_info['trans_key'], true);
                                } else {
                                    $cim = new AuthnetCIM($authorize_sender_info['api_key'], $authorize_sender_info['trans_key']);
                                }
                                $cim->setParameter('customerProfileId', $item_user['User']['cim_profile_id']);
                                $cim->setParameter('customerPaymentProfileId', $item_user['payment_profile_id']);
                                $cim->setParameter('transId', $item_user['cim_transaction_id']);
                                $cim->voidCustomerProfileTransaction();
                                // And if enbaled n Credit docapture amount and item discount amount is not equal, add amount to user wallet and update transactions //
                                if (Configure::read('wallet.is_handle_wallet')) {
                                    if ($item_user['AuthorizenetDocaptureLog']['authorize_amt'] != $item['Item']['discount_amount']) {
                                        $update_wallet = '';
                                        $update_wallet = ($item['Item']['price']*$item_user['quantity']) -$item_user['AuthorizenetDocaptureLog']['authorize_amt'];
                                        //Updating transactions
                                        $data = array();
                                        $data['Transaction']['user_id'] = $item_user['user_id'];
                                        $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                                        $data['Transaction']['class'] = 'SecondUser';
                                        $data['Transaction']['amount'] = $update_wallet;
                                        $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
                                        $transaction_id = $this->User->Transaction->log($data);
                                        if (!empty($transaction_id)) {
                                            $this->User->updateAll(array(
                                                'User.available_balance_amount' => 'User.available_balance_amount +' . $update_wallet
                                            ) , array(
                                                'User.id' => $item_user['user_id']
                                            ));
                                        }
                                    }
                                } // END  act like groupon wallet funct., //
                                if ($cim->isSuccessful()) {
                                    if (!empty($itemuser['AuthorizenetDocaptureLog']['id'])) {
                                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['id'] = $itemuser['AuthorizenetDocaptureLog']['id'];
                                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['payment_status'] = 'Cancelled';
                                        $this->ItemUser->AuthorizenetDocaptureLog->save($data_authorize_docapture_log);
                                    }
                                    return true;
                                }
                            } else {
                                $payment_response = array();
                                if ($item_user['payment_gateway_id'] == ConstPaymentGateways::CreditCard) {
                                    $post_info['authorization_id'] = $item_user['PaypalDocaptureLog']['authorizationid'];
                                } else if ($item_user['payment_gateway_id'] == ConstPaymentGateways::PayPalAuth) {
                                    $post_info['authorization_id'] = $item_user['PaypalTransactionLog']['authorization_auth_id'];
                                }
                                $post_info['note'] = __l('Item Payment refund');
                                //call void function in paypal component
                                $payment_response = $this->Paypal->doVoid($post_info, $paypal_sender_info);
                                //update payment responses
                                if (!empty($payment_response)) {
                                    if ($item_user['payment_gateway_id'] == ConstPaymentGateways::CreditCard) {
                                        $data_paypal_docapture_log['PaypalDocaptureLog']['id'] = $item_user['PaypalDocaptureLog']['id'];
                                        foreach($payment_response as $key => $value) {
                                            $data_paypal_docapture_log['PaypalDocaptureLog']['dovoid_' . strtolower($key) ] = $value;
                                        }
                                        $data_paypal_docapture_log['PaypalDocaptureLog']['dovoid_response'] = serialize($payment_response);
                                        $data_paypal_docapture_log['PaypalDocaptureLog']['payment_status'] = 'Cancelled';
                                        //update PaypalDocaptureLog table
                                        $this->ItemUser->PaypalDocaptureLog->save($data_paypal_docapture_log);
                                        // And if enbaled n Credit docapture amount and item discount amount is not equal, add amount to user wallet and update transactions //
                                        if (Configure::read('wallet.is_handle_wallet')) {
                                            if ($data_paypal_docapture_log['PaypalDocaptureLog']['original_amount'] != $item['Item']['discount_amount']) {
                                                $update_wallet = '';
                                                $update_wallet = ($item['Item']['price']*$item_user['quantity']) -$item_user['PaypalDocaptureLog']['dodirectpayment_amt'];
                                                //Updating transactions
                                                $data = array();
                                                $data['Transaction']['user_id'] = $item_user['user_id'];
                                                $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                                                $data['Transaction']['class'] = 'SecondUser';
                                                $data['Transaction']['amount'] = $update_wallet;
                                                $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
                                                $transaction_id = $this->User->Transaction->log($data);
                                                if (!empty($transaction_id)) {
                                                    $this->User->updateAll(array(
                                                        'User.available_balance_amount' => 'User.available_balance_amount +' . $update_wallet
                                                    ) , array(
                                                        'User.id' => $item_user['user_id']
                                                    ));
                                                }
                                            }
                                        } // END  act like groupon wallet funct., //

                                    } else if ($item_user['payment_gateway_id'] == ConstPaymentGateways::PayPalAuth) {
                                        $data_paypal_capture_log['PaypalTransactionLog']['id'] = $item_user['PaypalTransactionLog']['id'];
                                        foreach($payment_response as $key => $value) {
                                            $data_paypal_capture_log['PaypalTransactionLog']['void_' . strtolower($key) ] = $value;
                                        }
                                        $data_paypal_capture_log['PaypalTransactionLog']['void_data'] = serialize($payment_response);
                                        $data_paypal_capture_log['PaypalTransactionLog']['payment_status'] = 'Cancelled';
                                        $data_paypal_capture_log['PaypalTransactionLog']['error_no'] = '0';
                                        //update PaypalTransactionLog table
                                        $this->ItemUser->PaypalTransactionLog->save($data_paypal_capture_log);
                                        // And if enabled n PayPal docapture amount and item discount amount is not equal, add amount to user wallet and update transactions //
                                        if (Configure::read('wallet.is_handle_wallet')) {
                                            if ($item_user['PaypalTransactionLog']['orginal_amount'] != $item['Item']['discount_amount']) {
                                                $update_wallet = '';
                                                $update_wallet = ($item['Item']['price']*$item_user['quantity']) -$item_user['PaypalTransactionLog']['authorization_auth_amount'];
                                                //Updating transactions
                                                $data = array();
                                                $data['Transaction']['user_id'] = $item_user['user_id'];
                                                $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                                                $data['Transaction']['class'] = 'SecondUser';
                                                $data['Transaction']['amount'] = $update_wallet;
                                                $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
                                                $transaction_id = $this->User->Transaction->log($data);
                                                if (!empty($transaction_id)) {
                                                    $this->User->updateAll(array(
                                                        'User.available_balance_amount' => 'User.available_balance_amount +' . $update_wallet
                                                    ) , array(
                                                        'User.id' => $item_user['user_id']
                                                    ));
                                                }
                                            }
                                        } // END  act like groupon wallet funct., //

                                    }
                                }
                            }
                            //authorization_auth_amount

                        } else {
                            $transaction['Transaction']['user_id'] = $item_user['user_id'];
                            $transaction['Transaction']['foreign_id'] = $item_user['id'];
                            $transaction['Transaction']['class'] = 'ItemUser';
                            $transaction['Transaction']['amount'] = $item_user['discount_amount'];
                            $transaction['Transaction']['transaction_type_id'] = (!empty($item_user['is_gift'])) ? ConstTransactionTypes::ItemGiftRefund : ConstTransactionTypes::ItemBoughtRefund;
                            $this->ItemUser->User->Transaction->log($transaction);
                            //update user balance
                            $this->ItemUser->User->updateAll(array(
                                'User.available_balance_amount' => 'User.available_balance_amount +' . $item_user['discount_amount'],
                            ) , array(
                                'User.id' => $item_user['user_id']
                            ));
                        }
                        /* sending mail to all subscribers starts here */
                        $city = (!empty($item['Merchant']['City']['name'])) ? $item['Merchant']['City']['name'] : '';
                        $state = (!empty($item['Merchant']['State']['name'])) ? $item['Merchant']['State']['name'] : '';
                        $country = (!empty($item['Merchant']['Country']['name'])) ? $item['Merchant']['Country']['name'] : '';
                        $address = (!empty($item['Merchant']['address1'])) ? $item['Merchant']['address1'] : '';
                        $address.= (!empty($item['Merchant']['address2'])) ? ', ' . $item['Merchant']['address2'] : '';
                        $address.= (!empty($item['Merchant']['City']['name'])) ? ', ' . $item['Merchant']['City']['name'] : '';
                        $address.= (!empty($item['Merchant']['State']['name'])) ? ', ' . $item['Merchant']['State']['name'] : '';
                        $address.= (!empty($item['Merchant']['Country']['name'])) ? ', ' . $item['Merchant']['Country']['name'] : '';
                        $address.= (!empty($item['Merchant']['zip'])) ? ', ' . $item['Merchant']['zip'] : '';
                        $language_code = $this->getUserLanguageIso($item_user['User']['id']);
                        $template = $this->EmailTemplate->selectTemplate('Item Amount Refunded', $language_code);
                        $emailFindReplace = array(
                            '##SITE_URL##' => Cache::read('site_url_for_shell', 'long') ,
                            '##USER_NAME##' => $item_user['User']['username'],
                            '##SITE_NAME##' => Configure::read('site.name') ,
                            '##ITEM_NAME##' => $item['Item']['name'],
                            '##MERCHANT_NAME##' => $item['Merchant']['name'],
                            '##MERCHANT_ADDRESS##' => $address,
                            '##CITY_NAME##' => $item['City']['0']['name'],
                            '##FROM_EMAIL##' => $this->changeFromEmail(($template['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $template['from']) ,
                            '##BUY_PRICE##' => Configure::read('site.currency') . $item['Item']['price'],
                            '##MERCHANT_SITE##' => $item['Merchant']['url'],
                            '##CONTACT_URL##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', 'contactus', 1) ,
                            '##ITEM_URL##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                                'controller' => 'items',
                                'action' => 'view',
                                $item['Item']['slug'],
                                'admin' => false
                            ) , false) , 1) ,
                            '##ITEM_LINK##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                                'controller' => 'items',
                                'action' => 'view',
                                $item['Item']['slug'],
                                'admin' => false
                            ) , false) , 1) ,
                            '##SITE_LOGO##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                                'controller' => 'img',
                                'action' => 'blue-theme',
                                'logo-email.png',
                                'admin' => false
                            ) , false) , 1) ,
                        );
                        $this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $template['from'];
                        $this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $template['reply_to'];
                        $this->Email->to = $this->formatToAddress($item_user);
                        $this->Email->subject = strtr($template['subject'], $emailFindReplace);
                        $this->Email->content = strtr($template['email_content'], $emailFindReplace);
                        $this->Email->sendAs = ($template['is_html']) ? 'html' : 'text';
                        $this->Email->send($this->Email->content);
                        $ItemUserIds[] = $item_user['id'];
						$itemIds[] = $item['Item']['id'];
                        // SubItem: Resetting the actual item array //
                        if (!empty($temp_item)) {
                            $item['Item'] = $temp_item;
                        }
						// after save fields //
						$data_for_aftersave = array();
						$data_for_aftersave['item_id'] = $item['Item']['id'];
						$data_for_aftersave['item_user_id'] = $item_user['id'];
						$data_for_aftersave['user_id'] = $item_user['user_id'];
						$data_for_aftersave['merchant_id'] = $item['Merchant']['id'];
						$data_for_aftersave['payment_gateway_id'] = $item_user['payment_gateway_id'];
						$itemUserIdData[] = $data_for_aftersave;
                    }
                    if (!empty($ItemUserIds)) {
                        //is_repaid field updated
                        $this->ItemUser->updateAll(array(
                            'ItemUser.is_repaid' => 1,
                        ) , array(
                            'ItemUser.id' => $ItemUserIds
                        ));
						$this->updateAll(array(
							'Item.item_user_count' => 0,
						) , array(
							'Item.id' => $itemIds
						));
						foreach($itemUserIdData as $itemUserData) {
							$this->_updateAfterPurchase($itemUserData, 'cancel');
						}
                    }
                }
                $refundedItemIds[] = $item['Item']['id'];
            }
            if (!empty($refundedItemIds)) {
                foreach($refundedItemIds as $refunded_item_id) {
                    $data = array();
                    $data['Item']['id'] = $refunded_item_id;
                    $data['Item']['item_status_id'] = ConstItemStatus::Refunded; // Already updated in model itself, calling it again for affiliate behaviour
                    $this->save($data);
                }
            }
        }
    }
    //pay item amount to merchant when item in closed status
    function _payToMerchant($pay_type = '', $itemIds = array())
    {
        $conditions = array();
        if (!empty($itemIds)) {
            $conditions['Item.id'] = $itemIds;
        } elseif ($pay_type == 'cron') {
            $conditions['Item.item_status_id'] = ConstItemStatus::Closed;
        }
        $items = $this->find('all', array(
            'conditions' => $conditions,
            'contain' => array(
                'Merchant' => array(
                    'fields' => array(
                        'Merchant.name',
                        'Merchant.id',
                        'Merchant.user_id',
                        'Merchant.url',
                        'Merchant.zip',
                        'Merchant.address1',
                        'Merchant.address2',
                        'Merchant.city_id',
                        'Merchant.is_online_account'
                    ) ,
                ) ,
            ) ,
            'recursive' => 0,
        ));
        if (!empty($items)) {
            foreach($items as $item) {
                $user_id = $item['Merchant']['user_id'];
                $amount = ($item['Item']['total_purchased_amount']-($item['Item']['total_commission_amount']+$item['Item']['seller_charity_amount']));
                $data = array();
                //pay item amount to merchant
                $data['Transaction']['user_id'] = ConstUserIds::Admin;
                $data['Transaction']['foreign_id'] = $item['Item']['id'];
                $data['Transaction']['class'] = 'Item';
                $data['Transaction']['amount'] = $amount;
                $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::PaidItemAmountToMerchant;
                $this->User->Transaction->log($data);
                $data = array();
                //add record to merchant
                $data['Transaction']['user_id'] = $user_id;
                $data['Transaction']['foreign_id'] = $item['Item']['id'];
                $data['Transaction']['class'] = 'Item';
                $data['Transaction']['amount'] = $amount;
                $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::ReceivedItemPurchasedAmount;
                $this->User->Transaction->log($data);
                //amount to charity given //
                if (!empty($item['Item']['seller_charity_amount']) && $item['Item']['seller_charity_amount'] > 0) {
                    $data['Transaction']['user_id'] = $user_id;
                    $data['Transaction']['foreign_id'] = $item['Item']['id'];
                    $data['Transaction']['class'] = 'Item';
                    $data['Transaction']['amount'] = $item['Item']['seller_charity_amount'];
                    $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AmountTakenForCharity;
                    $this->User->Transaction->log($data);
                }
				if (!empty($item['Item']['site_charity_amount']) && $item['Item']['site_charity_amount'] != '0.00') {
					$data['Transaction']['user_id'] = ConstUserIds::Admin;
					$data['Transaction']['foreign_id'] = $item['Item']['id'];
					$data['Transaction']['class'] = 'Item';
					$data['Transaction']['amount'] = $item['Item']['site_charity_amount'];
					$data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AmountTakenForCharityFromAdmin;
					$this->User->Transaction->log($data);
				}
                $this->User->updateAll(array(
                    'User.available_balance_amount' => 'User.available_balance_amount +' . $amount,
                ) , array(
                    'User.id' => $user_id
                ));
                $paidItemIds[] = $item['Item']['id'];
            }
            $this->updateAll(array(
                'Item.item_status_id' => ConstItemStatus::PaidToMerchant,
                'Item.end_date' => '"' . date('Y-m-d H:i:s') . '"'
            ) , array(
                'Item.id' => $paidItemIds
            ));
        }
    }
    // pay to charity
    function _payToCharity($item_id)
    {
        $ItemUserIds = $this->ItemUser->find('list', array(
            'conditions' => array(
                'ItemUser.item_id' => $item_id
            ) ,
            'fields' => array(
                'ItemUser.id'
            ) ,
            'recursive' => -1,
        ));
        $charitiesItemUsers = $this->ItemUser->CharitiesItemUser->find('all', array(
            'conditions' => array(
                'CharitiesItemUser.item_user_id' => $ItemUserIds
            ) ,
            'recursive' => -1,
        ));
        $total_charity_amount = $site_charity_amount = $seller_charity_amount = 0;
        foreach($charitiesItemUsers as $charitiesItemUser) {
            $total_charity_amount+= $charitiesItemUser['CharitiesItemUser']['amount'];
            $site_charity_amount+= $charitiesItemUser['CharitiesItemUser']['site_commission_amount'];
            $seller_charity_amount+= $charitiesItemUser['CharitiesItemUser']['seller_commission_amount'];
            // update in charity
            $this->Charity->updateAll(array(
                'Charity.total_amount' => 'Charity.total_amount + ' . $charitiesItemUser['CharitiesItemUser']['amount'],
                'Charity.available_amount' => 'Charity.available_amount + ' . $charitiesItemUser['CharitiesItemUser']['amount'],
                'Charity.total_site_amount' => 'Charity.total_site_amount + ' . $charitiesItemUser['CharitiesItemUser']['site_commission_amount'],
                'Charity.total_seller_amount' => 'Charity.total_seller_amount + ' . $charitiesItemUser['CharitiesItemUser']['seller_commission_amount']
            ) , array(
                'Charity.id' => $charitiesItemUser['CharitiesItemUser']['charity_id']
            ));
        }
        $this->updateAll(array(
            'Item.total_charity_amount' => $total_charity_amount,
            'Item.site_charity_amount' => $site_charity_amount,
            'Item.seller_charity_amount' => $seller_charity_amount
        ) , array(
            'Item.id' => $item_id
        ));
    }
    //send subscription mail to users once item coming to open status
    function _sendSubscriptionMail()
    {
         App::import('Model', 'Subscription');
        $this->Subscription = new Subscription();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Email');
        $this->Email = new EmailComponent($collection);
        $i = 0;
        do {
            $items = $this->find('all', array(
                'conditions' => array(
                    'Item.item_status_id' => ConstItemStatus::Open,
                    'Item.is_subscription_mail_sent' => 0
                ) ,
                'contain' => array(
                    'Merchant' => array(
                        'fields' => array(
                            'Merchant.name',
                            'Merchant.id',
                            'Merchant.url',
                            'Merchant.zip',
                            'Merchant.address1',
                            'Merchant.address2',
                            'Merchant.city_id',
                            'Merchant.phone'
                        ) ,
                        'City' => array(
                            'fields' => array(
                                'City.id',
                                'City.name',
                                'City.slug',
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.id',
                                'State.name'
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.id',
                                'Country.name',
                                'Country.slug',
                            )
                        )
                    ) ,
                    'Attachment' => array(
                        'fields' => array(
                            'Attachment.id',
                            'Attachment.dir',
                            'Attachment.filename',
                            'Attachment.width',
                            'Attachment.height'
                        )
                    ) ,
                    'CitiesItem' => array(
                        'City' => array(
                            'Subscription' => array(
                                'fields' => array(
                                    'Subscription.id',
                                    'Subscription.user_id',
                                    'Subscription.email',
                                ) ,
                                'conditions' => array(
                                    'Subscription.is_subscribed' => 1
                                )
                            ) ,
                            'fields' => array(
                                'City.id',
                                'City.name',
                                'City.slug',
                            )
                        )
                    ) ,
                    'City' => array(
                        'fields' => array(
                            'City.id',
                            'City.name',
                            'City.slug',
                        )
                    ) ,
                ) ,
                'recursive' => 2,
                'limit' => 2,
                'offset' => $i
            ));
                 if (!empty($items)) {
                $itemIds = array();
                foreach($items as $item) {
                    // Updating Item subscriptions
                    $this->updateAll(array(
                        'Item.is_subscription_mail_sent' => 1,
                    ) , array(
                        'Item.id' => $item['Item']['id']
                    ));
                    /* sending mail to all subscribers starts here */
                    $city = (!empty($item['Merchant']['City']['name'])) ? $item['Merchant']['City']['name'] : '';
                    $state = (!empty($item['Merchant']['State']['name'])) ? $item['Merchant']['State']['name'] : '';
                    $country = (!empty($item['Merchant']['Country']['name'])) ? $item['Merchant']['Country']['name'] : '';
                    $address = (!empty($item['Merchant']['address1'])) ? $item['Merchant']['address1'] : '';
                    $address.= (!empty($item['Merchant']['address2'])) ? ', ' . $item['Merchant']['address2'] : '';
                    $address.= (!empty($item['Merchant']['City']['name'])) ? ', ' . $item['Merchant']['City']['name'] : '';
                    $address.= (!empty($item['Merchant']['State']['name'])) ? ', ' . $item['Merchant']['State']['name'] : '';
                    $address.= (!empty($item['Merchant']['Country']['name'])) ? ', ' . $item['Merchant']['Country']['name'] : '';
                    $address.= (!empty($item['Merchant']['zip'])) ? ', ' . $item['Merchant']['zip'] : '';
                    $address.= (!empty($item['Merchant']['phone'])) ? ', ' . $item['Merchant']['phone'] : '';
                    $image_hash = 'small_big_thumb/Item/' . $item['Attachment'][0]['id'] . '.' . md5(Configure::read('Security.salt') . 'Item' . $item['Attachment'][0]['id'] . 'jpg' . 'small_big_thumb' . Configure::read('site.name')) . '.' . 'jpg';
                    $item_url = Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                        'controller' => 'items',
                        'action' => 'view',
                        'city' => $item['City']['0']['slug'],
                        $item['Item']['slug'],
                        'admin' => false
                    ) , false) , 1);
                    $image_options = array(
                        'dimension' => 'subscription_thumb',
                        'class' => '',
                        'alt' => $item['Item']['name'],
                        'title' => $item['Item']['name'],
                        'type' => 'jpg'
                    );
                    $src = Router::url('/',true).getImageUrl('Item', $item['Attachment'][0], $image_options);
                    $tmpURL = $this->getCityTwitterFacebookURL($item['City']['0']['slug']);
                    $item_name = $item['Item']['name'];
                    $item_price = $item['Item']['price'];
                    $emailFindReplace = array(
                        '##SITE_URL##' => Cache::read('site_url_for_shell', 'long') ,
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##ITEM_NAME##' => $item_name,
                        '##MERCHANT_NAME##' => $item['Merchant']['name'],
                        '##MERCHANT_ADDRESS##' => $address,
                        '##MERCHANT_WEBSITE##' => $item['Merchant']['url'],
                        '##CITY_NAME##' => $item['City']['0']['name'],
                        '##SAVINGS##' => '',
                        '##BUY_PRICE##' => Configure::read('site.currency') . $item_price,
                        '##DISCOUNT##' => '',
                        '##DESCRIPTION##' => $item['Item']['description'],
                        '##MERCHANT_SITE##' => $item['Merchant']['url'],
                        '##ITEM_URL##' => $item_url,
                        '##ITEM_LINK##' => $item_url,
                        '##CONTACT_URL##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add',
                            'city' => $item['City']['0']['slug'],
                            'admin' => false
                        ) , false) , 1) ,
                        '##ITEM_IMAGE##' => "<img src =" . Router::url('/', true) . $src . " />",
                        '##TWITTER_URL##' => !empty($tmpURL['City']['0']['twitter_url']) ? $tmpURL['City']['0']['twitter_url'] : Configure::read('twitter.site_twitter_url') ,
                        '##FACEBOOK_URL##' => !empty($tmpURL['City']['0']['facebook_url']) ? $tmpURL['City']['0']['facebook_url'] : Configure::read('facebook.site_facebook_url') ,
                        '##DATE##' => date('l, F j, Y', strtotime(Date('Y-m-d H:i:s'))) ,
                        '##END_DATE##' => __l('End Date:') . ' ' . strftime(Configure::read('site.datetime.format') , strtotime($item['Item']['end_date'])) ,
                        '##FACEBOOK_IMAGE##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'img',
                            'action' => 'icon-facebook.png',
                            'admin' => false
                        ) , false) , 1) ,
                        '##TWITTER_IMAGE##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'img',
                            'action' => 'icon-twitter.png',
                            'admin' => false
                        ) , false) , 1) ,
                        '##COMMENT##' => $item['Item']['description'],
                        '##CONTACT_US##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add',
                            'city' => $item['City']['0']['slug'],
                            'admin' => false
                        ) , false) , 1) ,
                        '##BACKGROUND##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'img',
                            'action' => 'blue-theme',
                            'ing13.png',
                            'admin' => false
                        ) , false) , 1) ,
                        '##ITEM_IMAGE##' => $src,
                        '##BTN_IMAGE##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'img',
                            'action' => 'blue-theme',
                            'btn1.png',
                            'admin' => false
                        ) , false) , 1) ,
                        '##READMORE_IMAGE##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'img',
                            'action' => 'blue-theme',
                            'readmore.png',
                            'admin' => false
                        ) , false) , 1) ,
                        '##READMORE##' => $item_url,
                        '##EMAIL-COMMENT-BG##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'img',
                            'action' => 'blue-theme',
                            'email-comment-bg.png',
                            'admin' => false
                        ) , false) , 1) ,
                        '##SITE_LOGO##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'img',
                            'action' => 'blue-theme',
                            'logo-email.png',
                            'admin' => false
                        ) , false) , 1) ,
                    );
                    $sub_city_id = array();
                    foreach($item['CitiesItem'] as $city_item) {
                        $sub_city_id[] = $city_item['city_id'];
                        if (Configure::read('site.city_url') == 'prefix') {
                            $url = Router::url('/', true) . 'item/' . $item['Item']['slug'] . '/city:' . $city_item['City']['slug'];
                        } else {
                            $url = 'http://' . $city_item['City']['slug'] . '.' . $domain . 'item/' . $item['Item']['slug'];
                        }
                        // Sending mail through MailChimp Server //
                        if (Configure::read('mailchimp.is_enabled')== 1) {
                               $merge_vars = array(
                                'SITE_URL' => Cache::read('site_url_for_shell', 'long') ,
                                'SITE_NAME' => Configure::read('site.name') ,
                                'ITEM_NAME' => $item['Item']['name'],
                                'C_NAME' => $item['Merchant']['name'],
                                'C_ADDRESS' => $address,
                                'C_WEBSITE' => $item['Merchant']['url'],
                                'CITY_NAME' => $city_item['City']['name'],
                                'PRICE' => Configure::read('site.currency') . $item['Item']['price'],
                                'DISCOUNT' => !empty($item['Item']['discount_percentage']) ? $item['Item']['discount_percentage'] . '%' : '',
                                'DESCRIP' => $item['Item']['description'],
                                'ITEM_URL' => $item_url,
                                'ITEM_IMAGE' => "<img src =" . Router::url('/', true) . $src . " />",
                                'FACE_URL' => 'http://www.facebook.com/share.php?u=' . preg_replace('/\//', '', Router::url('/', true) , 1) . 'item/' . $item['Item']['slug'],
                                'TWITT_URL' => 'http://www.twitter.com/home?status=' . urlencode($item['Item']['name'] . ' - ') . $url,
                                'DATE' => date('l, F j, Y', strtotime($item['Item']['event_date'])) ,
                                'END_DATE' => __l('End Date:') . ' ' . date('M d, Y H:i:s A', strtotime($item['Item']['end_date'])) ,
                                'COMMENT' => $item['Item']['description'],
                                'CONTACT_US' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                                    'controller' => 'contacts',
                                    'action' => 'add',
                                    'city' => $city_item['City']['slug'],
                                    'admin' => false
                                ) , false) , 1) ,
                                'ITEM_IMAGE' => $src,
                            );
                            App::import('Model', 'MailChimpList');
                            $citylist_mod = new MailChimpList();
                            $get_city_list = $citylist_mod->find('first', array(
                                'conditions' => array(
                                    'MailChimpList.city_id' => $city_item['city_id']
                                ) ,
                                'fields' => array(
                                    'MailChimpList.list_id',
                                )
                            ));
                            include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'MCAPI.class.php');
                            include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'config.inc.php');
                            //$emailFindReplace['##UNSUB_LNK##'] = '';
                            $emailFindReplace['##UNSUB_LNK##'] = "<a href='" . Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                                'controller' => 'subscriptions',
                                'action' => 'unsubscribe_mailchimp',
                                'sub_city' => $city_item['City']['slug'],
                                'email' => "*|HTML:EMAIL|*",
                                'admin' => false
                            ) , false) , 1) . "' title='Unsubscribe'>unsubscribe</a>" . ".";
                            $emailFindReplace['##UNSUB_LBL##'] = '';
                            $api = new MCAPI(Configure::read('mailchimp.api_key'));
                            $type = 'regular';
                            $template = $this->EmailTemplate->selectTemplate('Item of the day');
                            
                            $opts['list_id'] = $get_city_list['MailChimpList']['list_id'];
                            $opts['subject'] = strtr($template['subject'], $emailFindReplace);
                            $opts['from_email'] = Configure::read('mailchimp.from_mail');
                            $opts['from_name'] = Configure::read('site.name');
                            $opts['tracking'] = array(
                                'opens' => true,
                                'html_clicks' => true,
                                'text_clicks' => false
                            );
                            $opts['authenticate'] = true;
                            $opts['auto_footer'] = false;
                            $opts['analytics'] = array(
                                'google' => 'my_google_analytics_key'
                            );
                            $opts['title'] = 'Subcription mail';
                            $text_content_var = $template['email_content'];
                            $content_var = strtr($template['email_content'], $emailFindReplace);
                            $content = array(
                                'html' => $content_var,
                                'text' => $text_content_var
                            );
                            $campaignId = $api->campaignCreate($type, $opts, $content);
                            $retval = $api->campaignSendNow($campaignId);
                            $itemIds[] = $item['Item']['id'];
                        }
                        // END OF MAIL SEND THROUGH MAILCHIMP //

                    }
                   $condition['Subscription.city_id'] = $sub_city_id;
                    $condition['Subscription.is_subscribed'] = 1;
                    $Subscription_emails = $this->Subscription->find('all', array(
                        'conditions' => $condition,
                        'contain' => array(
                            'City'
                        ) ,
                        'recursive' => 0,
                    ));
                   // if (!empty($Subscription_emails) && (Configure::read('mailchimp.is_enabled')== 0)) {
                   if (!empty($Subscription_emails)) {
                             foreach($Subscription_emails as $Subscription_email) {
                            $language_code = $this->getUserLanguageIso($Subscription_email['Subscription']['user_id']);
                            $template = $this->EmailTemplate->selectTemplate('Item of the day', $language_code);
                            $this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $template['from'];
                            $this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $template['reply_to'];
                            $emailFindReplace['##UNSUB_LNK##'] = "<a href='" . Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                                'controller' => 'subscriptions',
                                'action' => 'unsubscribe',
                                'city' => $city_item['City']['slug'],
                                $Subscription_email['Subscription']['id'],
                                'admin' => false
                            ) , false) , 1) . "' title='Unsubscribe'>unsubscribe</a>" . ".";
                            $emailFindReplace['##UNSUB_LBL##'] = __l('If you do not wish to receive these messages in the future, please');
                            $emailFindReplace['##CITY_NAME##'] = $Subscription_email['City']['name'];
                            $this->Email->to = $Subscription_email['Subscription']['email'];
                            $this->Email->subject = strtr($template['subject'], $emailFindReplace);
                            $this->Email->content = strtr($template['email_content'], $emailFindReplace);
                            $this->Email->sendAs = ($template['is_html']) ? 'html' : 'text';
                            $this->Email->send($this->Email->content);
                        }
                    }
                }
            }
            $i+= 2;
        }
        while (!empty($items));
    }
    //send interest mail to users once item coming to open status
    function _sendInterestMail()
    {
        App::import('Model', 'UserInterest');
        $this->UserInterest = new UserInterest();
        App::import('Model', 'UserInterestFollower');
        $this->UserInterestFollower = new UserInterestFollower();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Email');
        $this->Email = new EmailComponent($collection);
        $i = 0;
        do {
            $items = $this->find('all', array(
                'conditions' => array(
                    'Item.item_status_id' => ConstItemStatus::Open,
                    'Item.is_interest_mail_sent' => 0
                ) ,
                'contain' => array(
                    'Merchant' => array(
                        'fields' => array(
                            'Merchant.name',
                            'Merchant.id',
                            'Merchant.url',
                            'Merchant.zip',
                            'Merchant.address1',
                            'Merchant.address2',
                            'Merchant.city_id',
                            'Merchant.phone'
                        ) ,
                        'City' => array(
                            'fields' => array(
                                'City.id',
                                'City.name',
                                'City.slug',
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.id',
                                'State.name'
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.id',
                                'Country.name',
                                'Country.slug',
                            )
                        )
                    ) ,
                    'Attachment' => array(
                        'fields' => array(
                            'Attachment.id',
                            'Attachment.dir',
                            'Attachment.filename',
                            'Attachment.width',
                            'Attachment.height'
                        )
                    ) ,
                    'CitiesItem' => array(
                        'City' => array(
                            'Subscription' => array(
                                'fields' => array(
                                    'Subscription.id',
                                    'Subscription.user_id',
                                    'Subscription.email',
                                ) ,
                                'conditions' => array(
                                    'Subscription.is_subscribed' => 1
                                )
                            ) ,
                            'fields' => array(
                                'City.id',
                                'City.name',
                                'City.slug',
                            )
                        )
                    ) ,
                    'UserInterestItem' => array(
                        'UserInterest' => array(
                            'fields' => array(
                                'UserInterest.id',
                                'UserInterest.name',
                                'UserInterest.slug',
                            )
                        ) ,
                    ) ,
                    'City' => array(
                        'fields' => array(
                            'City.id',
                            'City.name',
                            'City.slug',
                        )
                    ) ,
                ) ,
                'recursive' => 2,
                'limit' => 2,
                'offset' => $i
            ));
            if (!empty($items)) {
                $itemIds = array();
                foreach($items as $item) {
                    // Updating Item subscriptions
                    $this->updateAll(array(
                        'Item.is_interest_mail_sent' => 1,
                    ) , array(
                        'Item.id' => $item['Item']['id']
                    ));
                    /* sending mail to all subscribers starts here */
                    $city = (!empty($item['Merchant']['City']['name'])) ? $item['Merchant']['City']['name'] : '';
                    $state = (!empty($item['Merchant']['State']['name'])) ? $item['Merchant']['State']['name'] : '';
                    $country = (!empty($item['Merchant']['Country']['name'])) ? $item['Merchant']['Country']['name'] : '';
                    $address = (!empty($item['Merchant']['address1'])) ? $item['Merchant']['address1'] : '';
                    $address.= (!empty($item['Merchant']['address2'])) ? ', ' . $item['Merchant']['address2'] : '';
                    $address.= (!empty($item['Merchant']['City']['name'])) ? ', ' . $item['Merchant']['City']['name'] : '';
                    $address.= (!empty($item['Merchant']['State']['name'])) ? ', ' . $item['Merchant']['State']['name'] : '';
                    $address.= (!empty($item['Merchant']['Country']['name'])) ? ', ' . $item['Merchant']['Country']['name'] : '';
                    $address.= (!empty($item['Merchant']['zip'])) ? ', ' . $item['Merchant']['zip'] : '';
                    $address.= (!empty($item['Merchant']['phone'])) ? ', ' . $item['Merchant']['phone'] : '';
                    $image_hash = 'small_big_thumb/Item/' . $item['Attachment'][0]['id'] . '.' . md5(Configure::read('Security.salt') . 'Item' . $item['Attachment'][0]['id'] . 'jpg' . 'small_big_thumb' . Configure::read('site.name')) . '.' . 'jpg';
                    $item_url = Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                        'controller' => 'items',
                        'action' => 'view',
                        'city' => $item['City']['0']['slug'],
                        $item['Item']['slug'],
                        'admin' => false
                    ) , false) , 1);
                    $image_options = array(
                        'dimension' => 'subscription_thumb',
                        'class' => '',
                        'alt' => $item['Item']['name'],
                        'title' => $item['Item']['name'],
                        'type' => 'jpg'
                    );
                    $src = getImageUrl('Item', $item['Attachment'][0], $image_options);
                    $tmpURL = $this->getCityTwitterFacebookURL($item['City']['0']['slug']);
                    $item_name = $item['Item']['name'];
                    $item_price = $item['Item']['price'];
                    $emailFindReplace = array(
                        '##SITE_URL##' => Cache::read('site_url_for_shell', 'long') ,
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##ITEM_NAME##' => $item_name,
                        '##MERCHANT_NAME##' => $item['Merchant']['name'],
                        '##MERCHANT_ADDRESS##' => $address,
                        '##MERCHANT_WEBSITE##' => $item['Merchant']['url'],
                        '##CITY_NAME##' => $item['City']['0']['name'],
                        '##SAVINGS##' => '',
                        '##BUY_PRICE##' => Configure::read('site.currency') . $item_price,
                        '##DISCOUNT##' => '',
                        '##DESCRIPTION##' => $item['Item']['description'],
                        '##MERCHANT_SITE##' => $item['Merchant']['url'],
                        '##ITEM_URL##' => $item_url,
                        '##ITEM_LINK##' => $item_url,
                        '##CONTACT_URL##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add',
                            'city' => $item['City']['0']['slug'],
                            'admin' => false
                        ) , false) , 1) ,
                        '##ITEM_IMAGE##' => "<img src =" . Router::url('/', true) . $src . " />",
                        '##TWITTER_URL##' => !empty($tmpURL['City']['0']['twitter_url']) ? $tmpURL['City']['0']['twitter_url'] : Configure::read('twitter.site_twitter_url') ,
                        '##FACEBOOK_URL##' => !empty($tmpURL['City']['0']['facebook_url']) ? $tmpURL['City']['0']['facebook_url'] : Configure::read('facebook.site_facebook_url') ,
                        '##DATE##' => date('l, F j, Y', strtotime(Date('Y-m-d H:i:s'))) ,
                        '##END_DATE##' => __l('End Date:') . ' ' . strftime(Configure::read('site.datetime.format') , strtotime($item['Item']['end_date'])) ,
                        '##FACEBOOK_IMAGE##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'img',
                            'action' => 'icon-facebook.png',
                            'admin' => false
                        ) , false) , 1) ,
                        '##TWITTER_IMAGE##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'img',
                            'action' => 'icon-twitter.png',
                            'admin' => false
                        ) , false) , 1) ,
                        '##COMMENT##' => $item['Item']['description'],
                        '##CONTACT_US##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add',
                            'city' => $item['City']['0']['slug'],
                            'admin' => false
                        ) , false) , 1) ,
                        '##BACKGROUND##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'img',
                            'action' => 'blue-theme',
                            'ing13.png',
                            'admin' => false
                        ) , false) , 1) ,
                        '##ITEM_IMAGE##' => $src,
                        '##BTN_IMAGE##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'img',
                            'action' => 'blue-theme',
                            'btn1.png',
                            'admin' => false
                        ) , false) , 1) ,
                        '##READMORE_IMAGE##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'img',
                            'action' => 'blue-theme',
                            'readmore.png',
                            'admin' => false
                        ) , false) , 1) ,
                        '##READMORE##' => $item_url,
                        '##EMAIL-COMMENT-BG##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'img',
                            'action' => 'blue-theme',
                            'email-comment-bg.png',
                            'admin' => false
                        ) , false) , 1) ,
                        '##SITE_LOGO##' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'img',
                            'action' => 'blue-theme',
                            'logo-email.png',
                            'admin' => false
                        ) , false) , 1) ,
                    );
                    $sub_city_id = array();
                    foreach($item['UserInterestItem'] as $interest_item) {
                        // Sending mail through MailChimp Server //
                        if (Configure::read('site.city_url') == 'prefix') {
                            $url = Router::url('/', true) . 'item/' . $item['Item']['slug'] . '/city:' . $item['City']['0']['slug'];
                        } else {
                            $url = 'http://' . $item['City']['0']['slug'] . '.' . $domain . 'item/' . $item['Item']['slug'];
                        }
                        if (Configure::read('mailchimp.is_enabled')) {
                            $merge_vars = array(
                                'SITE_URL' => Cache::read('site_url_for_shell', 'long') ,
                                'SITE_NAME' => Configure::read('site.name') ,
                                'ITEM_NAME' => $item['Item']['name'],
                                'C_NAME' => $item['Merchant']['name'],
                                'C_ADDRESS' => $address,
                                'C_WEBSITE' => $item['Merchant']['url'],
                                'INTEREST_NAME' => $interest_item['UserInterest']['name'],
                                'PRICE' => Configure::read('site.currency') . $item['Item']['price'],
                                'DISCOUNT' => !empty($item['Item']['discount_percentage']) ? $item['Item']['discount_percentage'] . '%' : '',
                                'DESCRIP' => $item['Item']['description'],
                                'ITEM_URL' => $item_url,
                                'ITEM_IMAGE' => "<img src =" . Router::url('/', true) . $src . " />",
                                'FACE_URL' => 'http://www.facebook.com/share.php?u=' . preg_replace('/\//', '', Router::url('/', true) , 1) . 'item/' . $item['Item']['slug'],
                                'TWITT_URL' => 'http://www.twitter.com/home?status=' . urlencode($item['Item']['name'] . ' - ') . $url,
                                'DATE' => date('l, F j, Y', strtotime($item['Item']['event_date'])) ,
                                'END_DATE' => __l('End Date:') . ' ' . date('M d, Y H:i:s A', strtotime($item['Item']['end_date'])) ,
                                'COMMENT' => $item['Item']['description'],
                                'CONTACT_US' => Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                                    'controller' => 'contacts',
                                    'action' => 'add',
                                    'city' => $item['City']['0']['slug'],
                                    'admin' => false
                                ) , false) , 1) ,
                                'ITEM_IMAGE' => $src,
                            );
                            App::import('Model', 'MailChimpList');
                            $citylist_mod = new MailChimpList();
                            $get_city_list = $citylist_mod->find('first', array(
                                'conditions' => array(
                                    'MailChimpList.user_interest_id' => $interest_item['UserInterest']['id']
                                ) ,
                                'fields' => array(
                                    'MailChimpList.list_id',
                                )
                            ));
                            include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'MCAPI.class.php');
                            include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'config.inc.php');
                            $emailFindReplace['##UNSUB_LNK##'] = "<a href='" . Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                                'controller' => 'subscriptions',
                                'action' => 'unsubscribe_mailchimp',
                                'sub_city' => $item['City'][0]['slug'],
                                'email' => "*|HTML:EMAIL|*",
                                'admin' => false
                            ) , false) , 1) . "' title='Unsubscribe'>unsubscribe</a>" . ".";
                            $emailFindReplace['##UNSUB_LBL##'] = '';
                            $api = new MCAPI(Configure::read('mailchimp.api_key'));
                            $type = 'regular';
                            $template = $this->EmailTemplate->selectTemplate('Interest of the day');
                            $opts['list_id'] = $get_city_list['MailChimpList']['list_id'];
                            $opts['subject'] = strtr($template['subject'], $emailFindReplace);
                            $opts['from_email'] = Configure::read('mailchimp.from_mail');
                            $opts['from_name'] = Configure::read('site.name');
                            $opts['tracking'] = array(
                                'opens' => true,
                                'html_clicks' => true,
                                'text_clicks' => false
                            );
                            $opts['authenticate'] = true;
                            $opts['auto_footer'] = false;
                            $opts['analytics'] = array(
                                'google' => 'my_google_analytics_key'
                            );
                            $opts['title'] = 'Subcription mail';
                            $text_content_var = $template['email_content'];
                            $content_var = strtr($template['email_content'], $emailFindReplace);
                            $content = array(
                                'html' => $content_var,
                                'text' => $text_content_var
                            );
                            $campaignId = $api->campaignCreate($type, $opts, $content);
                            $retval = $api->campaignSendNow($campaignId);
                            $itemIds[] = $item['Item']['id'];
							// END OF MAIL SEND THROUGH MAILCHIMP //
                        } else {
							$user_interest = array();
							foreach($item['UserInterestItem'] as $userInterest) {
								$user_interest[] = $userInterest['user_interest_id'];
							}
							$conditions = array();
							$conditions['UserInterestFollower.user_interest_id'] = $user_interest;
							$userInterestFollowers = $this->UserInterestFollower->find('list', array(
								'conditions' => $conditions,
								'fields' => array(
									'UserInterestFollower.user_id'
								) ,
								'recursive' => -1
							));
							if (!empty($userInterestFollowers)) {
								$userList = $this->User->UserNotification->find('list', array(
									'conditions' => array(
										'UserNotification.user_id' => $userInterestFollowers,
										'UserNotification.when_new_item_was_added_from_my_interests' => 1
									) ,
									'fields' => array(
										'UserNotification.user_id'
									) ,
									'recursive' => -1
								));
								if (!empty($userList)) {
									$userList=array_unique($userList);
									$users = $this->User->find('all', array(
										'conditions' => array(
											'User.id' => $userList
										) ,
										'fields' => array(
											'User.id',
											'User.email',
											'User.username'
										) ,
										'recursive' => -1
									));
									if (!empty($users) && !Configure::read('mailchimp.is_enabled')) {
										foreach($users as $user) {
											$language_code = $this->getUserLanguageIso($user['User']['id']);
											$template = $this->EmailTemplate->selectTemplate('Interest of the day', $language_code);
											$this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $template['from'];
											$this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $template['reply_to'];
											if(!empty($interest_item['UserInterest']['name'])):
											$emailFindReplace['##INTEREST_NAME##'] = $interest_item['UserInterest']['name'];
          									endif;
											$this->Email->to = $user['User']['email'];
											$this->Email->subject = strtr($template['subject'], $emailFindReplace);
											$this->Email->content = strtr($template['email_content'], $emailFindReplace);
											$this->Email->sendAs = ($template['is_html']) ? 'html' : 'text';
											$this->Email->send($this->Email->content);
										}
									}
								}
							}
						}
                    }
                }
            }
            $i+= 2;
        }
        while (!empty($items));
    }
    //close items and calculate commission amount and net profit
    function _closeItems($itemIds = array())
    {
        $conditions = array();
        if (empty($itemIds)) {
            $items = $this->find('list', array(
                'conditions' => array(
                    'Item.item_status_id' => ConstItemStatus::Tipped,
                    'Item.end_date <= ' => _formatDate('Y-m-d H:i:s', date('Y-m-d H:i:s') , true) ,
                ) ,
                'fields' => array(
                    'Item.id',
                    'Item.id',
                ) ,
            ));
            if (!empty($items)) {
                $itemIds = array_keys($items);
            }
        }
        if (!empty($itemIds)) {
            $items = $this->find('all', array(
                'conditions' => array(
                    'Item.id' => $itemIds
                ) ,
                'contain' => array(
                    'ItemUser',
                ) ,
                'fields' => array(
                    'Item.id',
                    'Item.item_user_count',
                    'Item.total_purchased_amount',
                    'Item.commission_percentage',
                    'Item.bonus_amount',
                    'Item.price',
                ) ,
                'recursive' => 1
            ));
            foreach($items as $item) {
                $this->_payToCharity($item['Item']['id']);
                $item_total_price = 0;
                if (!empty($item['ItemUser'])) {
                    foreach($item['ItemUser'] as $itemuser) {
                        $item_total_price = $item_total_price + $itemuser['discount_amount'];
                    }
                }
                $data = array();
                $data['Item']['id'] = $item['Item']['id'];
                $data['Item']['total_purchased_amount'] = $item_total_price;
                $data['Item']['total_commission_amount'] = ($item['Item']['bonus_amount']+($data['Item']['total_purchased_amount']*($item['Item']['commission_percentage']/100)));
                $data['Item']['end_date'] = date('Y-m-d H:i:s');
                $data['Item']['item_status_id'] = ConstItemStatus::Closed; // Already updated in model itself, calling it again for affiliate behaviour
                $this->save($data, false);
            }
            $this->_sendBuyersListMerchant($itemIds);
        }
    }
    //process items which are coming to open status
    function _processOpenStatus($item_id = null)
    {
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'OauthConsumer');
        $this->OauthConsumer = new OauthConsumerComponent($collection);
        $conditions = array();
        if (is_null($item_id)) {
            $conditions['Item.item_status_id'] = ConstItemStatus::PendingApproval;
            $conditions['Item.end_date <='] = _formatDate('Y-m-d H:i:s', date('Y-m-d H:i:s') , true);
        } else {
            $conditions['Item.id'] = $item_id;
        }
        $items = $this->find('all', array(
            'conditions' => array(
                $conditions,
            ) ,
            'contain' => array(
                'CitiesItem',
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                        'City.fb_user_id',
                        'City.fb_access_token',
                        'City.facebook_page_id',
                        'City.twitter_username',
                        'City.twitter_password',
                        'City.twitter_access_token',
                        'City.twitter_access_key',
                        'City.twitter_url',
                        'City.facebook_url',
                        'City.foursquare_venue',
                    )
                ) ,
                'Attachment',
            ) ,
            'recursive' => 2
        ));
         if (!empty($items)) {
            // Importing Facebook //
            if (Configure::read('facebook.enable_facebook_post_open_deal') == 1) {
                App::import('Vendor', 'facebook/facebook');
                $this->facebook = new Facebook(array(
                    'appId' => Configure::read('facebook.fb_api_key') ,
                    'secret' => Configure::read('facebook.fb_secrect_key') ,
                    'cookie' => true
                ));
            }
            // Importing Twitter //
            if (Configure::read('twitter.enable_twitter_post_open_deal') == 1) {
                App::import('Core', 'ComponentCollection');
                $collection = new ComponentCollection();
                App::import('Component', 'OauthConsumer');
                $this->OauthConsumer = new OauthConsumerComponent($collection);
            }
            // Importing FourSquare //
            if (Configure::read('foursquare.enable_foursquare_post_open_item')) {
                $client_key = Configure::read('foursquare.consumer_key');
                $client_secret = Configure::read('foursquare.consumer_secret');
                $token = Configure::read('foursquare.site_user_access_token');
                include_once APP . 'vendors' . DS . 'foursquare' . DS . 'FoursquareAPI.class.php';
                // Load the Foursquare API library
                $foursquare = new FoursquareAPI($client_key, $client_secret);
                $foursquare->SetAccessToken($token);
            }
            foreach($items as $item) {
               if (Configure::read('twitter.enable_twitter_post_open_item') or Configure::read('facebook.enable_facebook_post_open_item') or Configure::read('foursquare.enable_foursquare_post_open_item')) {
                    $slug = $item['Item']['slug'];
                    $item_id = $item['Item']['id'];
                    foreach($item['City'] as $k => $city) {
                        $city_slug = $city['slug'];
                        $city_id = $city['id'];
                        if (Configure::read('site.city_url') == 'prefix') {
                            $url = Router::url('/', true) . 'item/' . $slug . '/city:' . $city_slug;
                        } else {
                            $url = 'http://' . $city_slug . '.' . $domain . 'item/' . $slug;
                        }
                        $message = strtr(Configure::read('twitter.new_item_message') , array(
                             '##URL##' => !empty($url) ? $url : '',
                             '##ITEM_NAME##' => $item['Item']['name'],
                             '##SLUGED_SITE_NAME##' => Inflector::slug(strtolower(Configure::read('site.name'))) ,
                        ));
                        $fs_message = strtr(Configure::read('foursquare.new_item_message') , array(
                            '##ITEM_NAME##' => $item['Item']['name'],
                            '##SLUGGED_SITE_NAME##' => Inflector::slug(strtolower(Configure::read('site.name'))) ,
                        ));
                        $fb_message = strtr(Configure::read('facebook.new_item_message') , array(
                                '##ITEM_LINK##' => !empty($url) ? $url : '',
                                '##ITEM_NAME##' => $item['Item']['name'],
                            ));
                        $image_options = array(
                                'dimension' => 'normal_thumb',
                                'class' => 'Item',
                                'alt' => $item['Item']['name'],
                                'title' => $item['Item']['name'],
                                'type' => 'jpg',
                                'full_url' => true,
                            );
                        if (Configure::read('twitter.enable_twitter_post_open_item')) {
                                $twitter_access_token = (!empty($city['twitter_access_token'])) ? $city['twitter_access_token'] : Configure::read('twitter.site_user_access_token');
                                $twitter_access_key = (!empty($city['twitter_access_key'])) ? $city['twitter_access_key'] : Configure::read('twitter.site_user_access_key');
                                $this->log('----- twitter ----');
                                $xml = $this->OauthConsumer->post('Twitter', $twitter_access_token, $twitter_access_key, 'http://api.twitter.com/1/statuses/update.json', array(
                                    'status' => $message
                                ));
                                $this->log($xml);
                           }
                        if (Configure::read('facebook.enable_facebook_post_open_item')) {
                           if (!empty($item['City']['fb_access_token'])) {
                            $fb_access_token = $city['fb_access_token'];
                            $fb_user_id = $item['City']['facebook_page_id'];
                        } else {
                            $fb_access_token = Configure::read('facebook.fb_access_token');
                            $fb_user_id = Configure::read('facebook.page_id');
                        }
                            //Send To Facebook
                            App::import('Vendor', 'facebook/facebook');
                            $this->facebook = new Facebook(array(
                                'appId' => Configure::read('facebook.fb_api_key') ,
                                'secret' => Configure::read('facebook.fb_secrect_key') ,
                                'cookie' => true
                            ));
                           $image_url = getImageUrl('Item', $item['Attachment'][0], $image_options);
                            try {
                                $this->facebook->api('/' . $fb_user_id . '/feed', 'POST', array(
                                    'access_token' => $fb_access_token,
                                    'message' => $fb_message,
                                    'picture' => $image_url,
                                    'icon' => $image_url,
                                    'link' => !empty($url) ? $url : '',
                                    'caption' => Router::url('/', true) ,
                                    'description' => strip_tags($item['Item']['description'])
                                ));
                            }
                            catch(Exception $e) {
                                $this->log('Post on facebook error');
                            }
                            //End

                        }
                        // Post in FourSquare //
                        if (Configure::read('foursquare.enable_foursquare_post_open_item')) {
                            $foursquare_venue_id = (!empty($city['foursquare_venue'])) ? $city['foursquare_venue'] : Configure::read('foursquare.site_foursquare_venue_id');
                            $params['text'] = $fs_message;
                            $params['url'] = $url;
                            $params['venueId'] = $foursquare_venue_id;
                            $tipsresult = $foursquare->postTips($params);
                        }
                    }
                }
            }
        }
    }
    function _refundItemAmountForCacel($itemuser = array())
    {
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Email');
        $this->Email = new EmailComponent($collection);
        App::import('Component', 'Paypal');
        $this->Paypal = new PaypalComponent($collection);
        $paymentGateways = $this->User->Transaction->PaymentGateway->find('all', array(
            'conditions' => array(
                'PaymentGateway.id' => array(
                    ConstPaymentGateways::CreditCard,
                    ConstPaymentGateways::AuthorizeNet
                ) ,
            ) ,
            'contain' => array(
                'PaymentGatewaySetting' => array(
                    'fields' => array(
                        'PaymentGatewaySetting.key',
                        'PaymentGatewaySetting.test_mode_value',
                        'PaymentGatewaySetting.live_mode_value',
                    ) ,
                ) ,
            ) ,
            'recursive' => 1
        ));
        foreach($paymentGateways as $paymentGateway) {
            if ($paymentGateway['PaymentGateway']['id'] == ConstPaymentGateways::CreditCard) {
                if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                    foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                        if ($paymentGatewaySetting['key'] == 'directpay_API_UserName') {
                            $paypal_sender_info['API_UserName'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                        }
                        if ($paymentGatewaySetting['key'] == 'directpay_API_Password') {
                            $paypal_sender_info['API_Password'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                        }
                        if ($paymentGatewaySetting['key'] == 'directpay_API_Signature') {
                            $paypal_sender_info['API_Signature'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                        }
                    }
                    $paypal_sender_info['is_testmode'] = $paymentGateway['PaymentGateway']['is_test_mode'];
                }
            }
            if ($paymentGateway['PaymentGateway']['id'] == ConstPaymentGateways::AuthorizeNet) {
                if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                    foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                        if ($paymentGatewaySetting['key'] == 'authorize_net_api_key') {
                            $authorize_sender_info['api_key'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                        }
                        if ($paymentGatewaySetting['key'] == 'authorize_net_trans_key') {
                            $authorize_sender_info['trans_key'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                        }
                    }
                }
                $authorize_sender_info['is_test_mode'] = $paymentGateway['PaymentGateway']['is_test_mode'];
            }
        }
        //do void for credit card
        if ($itemuser['ItemUser']['payment_gateway_id'] != ConstPaymentGateways::Wallet) {
            if ($itemuser['ItemUser']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
                require_once (APP . 'vendors' . DS . 'CIM' . DS . 'AuthnetCIM.class.php');
                if ($authorize_sender_info['is_test_mode']) {
                    $cim = new AuthnetCIM($authorize_sender_info['api_key'], $authorize_sender_info['trans_key'], true);
                } else {
                    $cim = new AuthnetCIM($authorize_sender_info['api_key'], $authorize_sender_info['trans_key']);
                }
                $cim->setParameter('customerProfileId', $itemuser['User']['cim_profile_id']);
                $cim->setParameter('customerPaymentProfileId', $itemuser['ItemUser']['payment_profile_id']);
                $cim->setParameter('transId', $itemuser['ItemUser']['cim_transaction_id']);
                $cim->voidCustomerProfileTransaction();
                // And if enbaled n Credit docapture amount and item discount amount is not equal, add amount to user wallet and update transactions //
                if (Configure::read('wallet.is_handle_wallet')) {
                    if ($itemuser['AuthorizenetDocaptureLog']['authorize_amt'] != $itemuser['Item']['discount_amount']) {
                        $update_wallet = '';
                        $update_wallet = ($itemuser['Item']['price']*$itemuser['ItemUser']['quantity']) -$itemuser['AuthorizenetDocaptureLog']['authorize_amt'];
                        //Updating transactions
                        $data = array();
                        $data['Transaction']['user_id'] = $itemuser['ItemUser']['user_id'];
                        $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                        $data['Transaction']['class'] = 'SecondUser';
                        $data['Transaction']['amount'] = $update_wallet;
                        $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
                        $transaction_id = $this->User->Transaction->log($data);
                        if (!empty($transaction_id)) {
                            $this->User->updateAll(array(
                                'User.available_balance_amount' => 'User.available_balance_amount +' . $update_wallet
                            ) , array(
                                'User.id' => $itemuser['ItemUser']['user_id']
                            ));
                        }
                    }
                } // END  act like groupon wallet funct., //
                if ($cim->isSuccessful()) {
                    if (!empty($itemuser['AuthorizenetDocaptureLog']['id'])) {
                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['id'] = $itemuser['AuthorizenetDocaptureLog']['id'];
                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['payment_status'] = 'Cancelled';
                        $this->ItemUser->AuthorizenetDocaptureLog->save($data_authorize_docapture_log);
                    }
                    return true;
                } else {
                    $response['message'] = $cim->getResponse();
                    return $response;
                }
            } else {
                $payment_response = array();
                if ($itemuser['ItemUser']['payment_gateway_id'] == ConstPaymentGateways::CreditCard) {
                    $post_info['authorization_id'] = $itemuser['PaypalDocaptureLog']['authorizationid'];
                } else if ($itemuser['ItemUser']['payment_gateway_id'] == ConstPaymentGateways::PayPalAuth) {
                    $post_info['authorization_id'] = $itemuser['PaypalTransactionLog']['authorization_auth_id'];
                }
                $post_info['note'] = __l('Item Payment refund');
                //call void function in paypal component
                $payment_response = $this->Paypal->doVoid($post_info, $paypal_sender_info);
                //update payment responses
                if (!empty($payment_response)) {
                    if ($itemuser['ItemUser']['payment_gateway_id'] == ConstPaymentGateways::CreditCard) {
                        $data_paypal_docapture_log['PaypalDocaptureLog']['id'] = $itemuser['PaypalDocaptureLog']['id'];
                        foreach($payment_response as $key => $value) {
                            $data_paypal_docapture_log['PaypalDocaptureLog']['dovoid_' . strtolower($key) ] = $value;
                        }
                        $data_paypal_docapture_log['PaypalDocaptureLog']['dovoid_response'] = serialize($payment_response);
                        $data_paypal_docapture_log['PaypalDocaptureLog']['payment_status'] = 'Cancelled';
                        //update PaypalDocaptureLog table
                        $this->ItemUser->PaypalDocaptureLog->save($data_paypal_docapture_log);
                        // And if enbaled n Credit docapture amount and item discount amount is not equal, add amount to user wallet and update transactions //
                        if (Configure::read('wallet.is_handle_wallet')) {
                            if ($data_paypal_docapture_log['PaypalDocaptureLog']['original_amount'] != $itemuser['Item']['discount_amount']) {
                                $update_wallet = '';
                                $update_wallet = ($itemuser['Item']['price']*$itemuser['ItemUser']['quantity']) -$itemuser['PaypalDocaptureLog']['dodirectpayment_amt'];
                                //Updating transactions
                                $data = array();
                                $data['Transaction']['user_id'] = $itemuser['ItemUser']['user_id'];
                                $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                                $data['Transaction']['class'] = 'SecondUser';
                                $data['Transaction']['amount'] = $update_wallet;
                                $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
                                $transaction_id = $this->User->Transaction->log($data);
                                if (!empty($transaction_id)) {
                                    $this->User->updateAll(array(
                                        'User.available_balance_amount' => 'User.available_balance_amount +' . $update_wallet
                                    ) , array(
                                        'User.id' => $itemuser['ItemUser']['user_id']
                                    ));
                                }
                            }
                        } // END  act like groupon wallet funct., //

                    } else if ($itemuser['ItemUser']['payment_gateway_id'] == ConstPaymentGateways::PayPalAuth) {
                        $data_paypal_capture_log['PaypalTransactionLog']['id'] = $itemuser['PaypalTransactionLog']['id'];
                        foreach($payment_response as $key => $value) {
                            $data_paypal_capture_log['PaypalTransactionLog']['void_' . strtolower($key) ] = $value;
                        }
                        $data_paypal_capture_log['PaypalTransactionLog']['void_data'] = serialize($payment_response);
                        $data_paypal_capture_log['PaypalTransactionLog']['payment_status'] = 'Cancelled';
                        $data_paypal_capture_log['PaypalTransactionLog']['error_no'] = '0';
                        //update PaypalTransactionLog table
                        $this->ItemUser->PaypalTransactionLog->save($data_paypal_capture_log);
                        // And if enabled n PayPal docapture amount and item discount amount is not equal, add amount to user wallet and update transactions //
                        if (Configure::read('wallet.is_handle_wallet')) {
                            if ($itemuser['PaypalTransactionLog']['orginal_amount'] != $itemuser['Item']['discount_amount']) {
                                $update_wallet = '';
                                $update_wallet = ($itemuser['Item']['price']*$itemuser['ItemUser']['quantity']) -$itemuser['PaypalTransactionLog']['authorization_auth_amount'];
                                //Updating transactions
                                $data = array();
                                $data['Transaction']['user_id'] = $itemuser['ItemUser']['user_id'];
                                $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                                $data['Transaction']['class'] = 'SecondUser';
                                $data['Transaction']['amount'] = $update_wallet;
                                $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
                                $transaction_id = $this->User->Transaction->log($data);
                                if (!empty($transaction_id)) {
                                    $this->User->updateAll(array(
                                        'User.available_balance_amount' => 'User.available_balance_amount +' . $update_wallet
                                    ) , array(
                                        'User.id' => $itemuser['ItemUser']['user_id']
                                    ));
                                }
                            }
                        } // END  act like groupon wallet funct., //

                    }
                }
            }
        } else {
            $transaction['Transaction']['user_id'] = $itemuser['ItemUser']['user_id'];
            $transaction['Transaction']['foreign_id'] = $itemuser['ItemUser']['id'];
            $transaction['Transaction']['class'] = 'ItemUser';
            $transaction['Transaction']['amount'] = $itemuser['ItemUser']['discount_amount'];
            $transaction['Transaction']['transaction_type_id'] = (!empty($itemuser['ItemUser']['is_gift'])) ? ConstTransactionTypes::ItemGiftCancel : ConstTransactionTypes::ItemBoughtCancel;
            $this->ItemUser->User->Transaction->log($transaction);
            //update user balance
            $this->ItemUser->User->updateAll(array(
                'User.available_balance_amount' => 'User.available_balance_amount +' . $itemuser['ItemUser']['discount_amount'],
            ) , array(
                'User.id' => $itemuser['ItemUser']['user_id']
            ));
        }
        return true;
    }
    // quick fix for to update transaction for paid users
    function _updateTransaction($ItemUser)
    {
        //add amount to wallet
        $data['Transaction']['user_id'] = $ItemUser['user_id'];
        $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
        $data['Transaction']['class'] = 'SecondUser';
        $data['Transaction']['amount'] = $ItemUser['discount_amount'];
        $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
        $data['Transaction']['payment_gateway_id'] = $ItemUser['payment_gateway_id'];
        $transaction_id = $this->User->Transaction->log($data);
        if (!empty($transaction_id)) {
            $this->User->updateAll(array(
                'User.available_balance_amount' => 'User.available_balance_amount +' . $ItemUser['discount_amount']
            ) , array(
                'User.id' => $ItemUser['user_id']
            ));
        }
        //Buy item transaction
        $transaction['Transaction']['user_id'] = $ItemUser['user_id'];
        $transaction['Transaction']['foreign_id'] = $ItemUser['id'];
        $transaction['Transaction']['class'] = 'ItemUser';
        $transaction['Transaction']['amount'] = $ItemUser['discount_amount'];
        $transaction['Transaction']['transaction_type_id'] = (!empty($ItemUser['is_gift'])) ? ConstTransactionTypes::ItemGift : ConstTransactionTypes::BuyItem;
        $transaction['Transaction']['payment_gateway_id'] = $ItemUser['payment_gateway_id'];
        if (!empty($ItemUser['rate'])) {
            $transaction['Transaction']['currency_id'] = $ItemUser['currency_id'];
            $transaction['Transaction']['converted_currency_id'] = $ItemUser['converted_currency_id'];
            $transaction['Transaction']['converted_amount'] = $ItemUser['authorize_amt'];
            $transaction['Transaction']['rate'] = $ItemUser['rate'];
        }
        $this->User->Transaction->log($transaction);
        //user update
        $this->User->updateAll(array(
            'User.available_balance_amount' => 'User.available_balance_amount -' . $ItemUser['discount_amount']
        ) , array(
            'User.id' => $ItemUser['user_id']
        ));
    }
    function _updateCityItemCount()
    {
        // Take city_item_count
        $city_item_counts = $this->City->find('all', array(
            'fields' => array(
                'City.id',
            ) ,
            'contain' => array(
                'Item' => array(
                    'conditions' => array(
                        'Item.item_status_id' => array(
                            ConstItemStatus::Open,
                            ConstItemStatus::Tipped
                        )
                    ) ,
                    'fields' => array(
                        'Item.id'
                    )
                )
            ) ,
            'recursive' => 1
        ));
        $this->City->updateAll(array(
            'City.active_item_count' => 0
        ) , array(
            'City.is_approved' => array(
                0,
                1
            )
        ));
        foreach($city_item_counts as $city_item_count) {
            if (!empty($city_item_count['Item'])) {
                if ($count = count($city_item_count['Item'])) {
                    $this->City->updateAll(array(
                        'City.active_item_count' => $count
                    ) , array(
                        'City.id' => $city_item_count['City']['id']
                    ));
                }
            }
        }
        // delete view more cities cache files
        $this->City->deleteAllCache();
    }
    // <-- For iPhone App code
    function saveiPhoneAppThumb($attachments)
    {
        $options[] = array(
            'dimension' => 'iphone_big_thumb',
            'class' => '',
            'alt' => '',
            'title' => '',
            'type' => 'jpg'
        );
        $options[] = array(
            'dimension' => 'iphone_small_thumb',
            'class' => '',
            'alt' => '',
            'title' => '',
            'type' => 'jpg'
        );
        $model = 'Item';
        $attachment = $attachments[0];
        foreach($options as $option) {
            $destination = APP . 'webroot' . DS . 'img' . DS . $option['dimension'] . DS . $model . DS . $attachment['id'] . '.' . md5(Configure::read('Security.salt') . $model . $attachment['id'] . $option['type'] . $option['dimension'] . Configure::read('site.name')) . '.' . $option['type'];
            if (!file_exists($destination) && !empty($attachment['id'])) {
                $url = getImageUrl($model, $attachment, $option);
                getimagesize($url);
            }
        }
    }
    // For iPhone App code -->
    // - X Referral Methiod //
    function referalRefunding($item_id = null)
    {
        App::import('Model', 'ItemUser');
        $this->ItemUser = new ItemUser();
        $item_users = $this->ItemUser->find('all', array(
            'conditions' => array(
                'Item.id' => $item_id,
                'Item.item_status_id' => ConstItemStatus::Tipped,
                'ItemUser.referred_by_user_id !=' => '0'
            ) ,
            'fields' => array(
                'ItemUser.referred_by_user_id',
                'ItemUser.item_id',
                'ItemUser.user_id',
                'SUM(ItemUser.quantity) as referred_user_total_purchased_quantity',
            ) ,
            'group' => array(
                'ItemUser.referred_by_user_id'
            ) ,
            'contain' => array(
                'Item' => array(
                    'fields' => array(
                        'Item.id',
                        'Item.price',
                    )
                ) ,
            ) ,
            'recursive' => 1
        ));
        foreach($item_users as $item_user) {
            if ($item_user[0]['referred_user_total_purchased_quantity'] >= Configure::read('referral.no_of_refer_to_get_a_refund')) { // If creteria matches for refund
                $check_refer = $this->ItemReferrer->find('first', array(
                    'conditions' => array(
                        'ItemReferrer.user_id' => $item_user['ItemUser']['referred_by_user_id'],
                        'ItemReferrer.item_id' => $item_user['ItemUser']['item_id'],
                    ) ,
                    'recursive' => -1
                ));
                $refer_data = $this->ItemUser->find('first', array(
                    'conditions' => array(
                        'ItemUser.user_id' => $item_user['ItemUser']['referred_by_user_id'],
                        'ItemUser.item_id' => $item_user['ItemUser']['item_id'],
                    ) ,
                    'recursive' => -1
                ));
                if (empty($check_refer)) { // If empty, refer amount
                    // Add amount to referral user amount //
                    if (Configure::read('referral.refund_type') == ConstReferralRefundType::RefundItemAmount) {
                        $refund_amount = $refer_data['ItemUser']['discount_amount']/$refer_data['ItemUser']['quantity'];
                    } else {
                        $refund_amount = Configure::read('referral.refund_amount');
                    }
                    $this->User->updateAll(array(
                        'User.available_balance_amount' => 'User.available_balance_amount + ' . $refund_amount,
						'User.total_referral_earned_amount' => 'User.total_referral_earned_amount + ' . $refund_amount,
                    ) , array(
                        'User.id' => $item_user['ItemUser']['referred_by_user_id']
                    ));
                    $this->User->updateAll(array(
                        'User.available_balance_amount' => 'User.available_balance_amount + ' . $refund_amount,
						'User.total_referral_earned_amount' => 'User.total_referral_earned_amount + ' . $refund_amount,
                    ) , array(
                        'User.id' => $item_user['ItemUser']['user_id']
                    ));
					$this->User->ItemUser->updateAll(array(
						'ItemUser.referral_commission_amount ' => $refund_amount,
						'ItemUser.is_referral_commission_sent ' => 1,
						'ItemUser.referral_commission_type ' => ConstReferralCommissionType::XRefer
					) , array(
						'ItemUser.id' => $item_user['ItemUser']['user_id']
					));
                    $data = array();
                    $data['Transaction']['user_id'] = $item_user['ItemUser']['referred_by_user_id'];
                    $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                    $data['Transaction']['class'] = 'SecondUser';
                    $data['Transaction']['amount'] = $refund_amount;
                    $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::ReferralAddedToWallet;
                    $this->User->Transaction->save($data);
                    // Insert Record into ItemReferrrer //
                    $referrer = array();
                    $referrer['ItemReferrer']['user_id'] = $item_user['ItemUser']['referred_by_user_id'];
                    $referrer['ItemReferrer']['item_id'] = $item_user['Item']['id'];
                    $referrer['ItemReferrer']['earned_amount'] = $refund_amount;
                    $referrer['ItemReferrer']['refferral_count'] = Configure::read('referral.no_of_refer_to_get_a_refund');
                    $this->ItemReferrer->save($referrer);
                } else {
                    $this->ItemReferrer->updateAll(array(
                        'ItemReferrer.total_purchased_referral_count' => 'ItemReferrer.total_purchased_referral_count + ' . 1,
                    ) , array(
                        'ItemReferrer.item_id' => $item_user['Item']['id'],
                        'ItemReferrer.id' => $check_refer['ItemReferrer']['id']
                    ));
                }
            }
        }
    }
    function _getItemInfo($item_id = null)
    {
        $item = $this->find('first', array(
            'conditions' => array(
                'Item.id' => $item_id
            ) ,
            'fields' => array(
                'Item.id',
                'Item.name',
                'Item.slug',
                'Item.item_status_id',
                'Item.charity_id',
                'Item.charity_percentage',
                'Charity.name',
                'Charity.url',
            ) ,
            'recursive' => 0
        ));
        return $item;
    }
	function _updateAfterPurchase($data, $type = null)
	{
		// Updating Purchase [USER] Related 'AfterSave' Fields //
		$this->_updateUserAfterPurchase($data, $type);
		// Updating Purchase [ITEM] Related 'AfterSave' Fields //
		$this->_updateItemAfterPurchase($data, $type);
		// Updating Purchase [ITEM] Related 'AfterSave' Counts //
		$this->ItemUser->_updateItemAfterPurchaseCount($data, $type);
		// Updating Purchase [MERCHANT] Related 'AfterSave' Counts //
		$this->_updateMerchantAfterPurchase($data, $type);
	}
	// Updating Purchase [USER] Related 'AfterSave' Fields //
	function _updateUserAfterPurchase($data, $type = null)
	{
		$conditions = $updation = $group = $extra_fields = array();
		if (!empty($data['user_id'])) {
			$conditions['ItemUser.user_id'] = $data['user_id'];
			if (!empty($type) && $type == 'cancel') {
				$conditions['OR'] = array(
					'ItemUser.is_repaid' => 1,
					'ItemUser.is_canceled' => 1
				);
			} else {
				$extra_fields = $group = array(
					'ItemUser.payment_gateway_id'
				);
			}
			$item_users = $this->ItemUser->find('all', array(
				'conditions' => $conditions,
				'fields' => array_merge(array(
					'SUM(ItemUser.discount_amount) as total_purchased_amount',
					'COUNT(ItemUser.quantity) as total_item_purchase_count'
				) , $extra_fields) ,
				'group' => $group,
				'recursive' => -1
			));
			$update_model = array(
				'User.id' => $data['user_id']
			);
			$total_purchashed_amount = $total_purchashed_count = '0';
			// When CANCELED/REFUNDED //
			if (!empty($type) && $type == 'cancel') {
				$updation['User.total_item_purchase_cancel_count'] = $item_users[0][0]['total_item_purchase_count'];
			} else { // ELSE i.e Purchase //
				foreach($item_users as $item_user) {
					$total_purchashed_count+= $item_user[0]['total_item_purchase_count'];
					$total_purchashed_amount+= $item_user[0]['total_purchased_amount'];
					if ($item_user['ItemUser']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
						$updation['User.total_purchased_amount_via_wallet'] = $item_user[0]['total_purchased_amount'];
					}
					if ($item_user['ItemUser']['payment_gateway_id'] == ConstPaymentGateways::CreditCard) {
						$updation['User.total_purchased_amount_via_credit_card'] = $item_user[0]['total_purchased_amount'];
					}
					if ($item_user['ItemUser']['payment_gateway_id'] == ConstPaymentGateways::PayPalAuth) {
						$updation['User.total_purchased_amount_via_paypal'] = $item_user[0]['total_purchased_amount'];
					}
					if ($item_user['ItemUser']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
						$updation['User.total_purchased_amount_via_cim'] = $item_user[0]['total_purchased_amount'];
					}
					if ($item_user['ItemUser']['payment_gateway_id'] == ConstPaymentGateways::PagSeguro) {
						$updation['User.total_purchased_amount_via_pagseguro'] = $item_user[0]['total_purchased_amount'];
					}
				}
				$updation['User.total_purchased_amount'] = $total_purchashed_amount;
				$updation['User.total_item_purchase_count'] = $total_purchashed_count;
			}
		}
		if (!empty($updation) && !empty($update_model)) {
			$this->User->updateAll($updation, $update_model);
		}
	}
	// Updating Purchase [ITEM] Related 'AfterSave' Fields //
	function _updateItemAfterPurchase($data, $type = null)
	{
		$conditions = $item_user_conditions = $updation = array();
		$conditions['Item.id'] = $data['item_id'];
		// Getting Purchased & Commission Amounts //
		$item = $this->find('first', array(
			'conditions' => $conditions,
			'fields' => array(
				'Item.bonus_amount',
				'Item.commission_percentage',
			) ,
			'recursive' => -1
		));
		$items = $this->ItemUser->find('all', array(
			'conditions' => array(
				'ItemUser.item_id' => $data['item_id'],
				'ItemUser.is_repaid' => 0,
				'ItemUser.is_canceled' => 0,
			) ,
			'fields' => array(
				'SUM(ItemUser.discount_amount) as total_purchased_amount',
			) ,
			'recursive' => -1
		));
		$items[0][0]['total_commission_amount'] = $item['Item']['bonus_amount'] + ($items[0][0]['total_purchased_amount'] * ($item['Item']['commission_percentage']/100));
		// Getting Charity //
		$item_user_conditions = array(
			'ItemUser.is_repaid' => 0,
			'ItemUser.is_canceled' => 0
		);
		$item_user_conditions['ItemUser.item_id'] = $data['item_id'];
		$item_users = $this->ItemUser->find('all', array(
			'conditions' => $item_user_conditions,
			'fields' => array(
				'SUM(ItemUser.charity_paid_amount) as total_charity_amount',
				'SUM(ItemUser.charity_seller_amount) as seller_charity_amount',
				'SUM(ItemUser.charity_site_amount) as site_charity_amount',
				'SUM(ItemUser.affiliate_commission_amount) as total_affiliate_amount',
				'SUM(ItemUser.referral_commission_amount) as total_referral_amount',
				'COUNT(ItemUser.id) as item_user_canceled_count',
			) ,
			'recursive' => -1,
		));
		if (!empty($type) && $type == 'cancel') {
			$item_user_conditions = array();
			$item_user_conditions['ItemUser.item_id'] = $data['item_id'];
			$item_user_conditions['OR'] = array(
				'ItemUser.is_repaid' => 1,
				'ItemUser.is_canceled' => 1
			);
			$item_user_canceled = $this->ItemUser->find('all', array(
				'conditions' => $item_user_conditions,
				'fields' => array(
					'SUM(ItemUser.discount_amount) as total_sales_lost_amount',
				) ,
				'recursive' => -1,
			));
			$updation['Item.total_sales_lost_amount'] = (!empty($item_user_canceled[0][0]['total_sales_lost_amount']) ? $item_user_canceled[0][0]['total_sales_lost_amount'] : '0.00');
			$updation['Item.item_user_canceled_count'] = (!empty($item_user_canceled[0][0]['item_user_canceled_count']) ? $item_user_canceled[0][0]['item_user_canceled_count'] : '0');
		}
		$update_model = array(
			'Item.id' => $data['item_id']
		);
		$updation['Item.total_purchased_amount'] = (!empty($items[0][0]['total_purchased_amount']) ? $items[0][0]['total_purchased_amount'] : '0.00');
		$updation['Item.total_commission_amount'] = (!empty($items[0][0]['total_commission_amount']) ? $items[0][0]['total_commission_amount'] : '0.00');
		$updation['Item.total_charity_amount'] = (!empty($item_users[0][0]['total_charity_amount']) ? $item_users[0][0]['total_charity_amount'] : '0.00');
		$updation['Item.seller_charity_amount'] = (!empty($item_users[0][0]['seller_charity_amount']) ? $item_users[0][0]['seller_charity_amount'] : '0.00');		
		$updation['Item.site_charity_amount'] = (!empty($item_users[0][0]['site_charity_amount']) ? $item_users[0][0]['site_charity_amount'] : '0.00');		
		$updation['Item.total_merchant_earned_amount'] = ($updation['Item.total_purchased_amount'] - ($updation['Item.total_commission_amount'] + $updation['Item.seller_charity_amount']));
		$updation['Item.total_affiliate_amount'] = (!empty($item_users[0][0]['total_affiliate_amount']) ? $item_users[0][0]['total_affiliate_amount'] : '0.00');
		$updation['Item.total_referral_amount'] = (!empty($item_users[0][0]['total_referral_amount']) ? $item_users[0][0]['total_referral_amount'] : '0.00');
		if (!empty($updation) && !empty($update_model)) {
			$this->updateAll($updation, $update_model);
		}
	}
	// Updating Purchase [MERCHANT] Related 'AfterSave' Counts //
	function _updateMerchantAfterPurchase($data, $type = null)
	{
		$updation = array();
		$total_sales = $this->find('all', array(
			'conditions' => array(
				'Item.merchant_id' => $data['merchant_id'],
				'Item.item_status_id' => ConstItemStatus::PaidToMerchant
			) ,
			'fields' => array(
				'SUM(Item.total_sales_lost_amount) as total_sales_lost_amount',
				'SUM(Item.seller_charity_amount) as seller_charity_amount',
				'SUM(Item.total_commission_amount) as total_site_revenue_amount',
				'SUM(Item.total_purchased_amount - (Item.total_commission_amount + Item.seller_charity_amount)) as total_sales_cleared_amount'
			) ,
			'recursive' => -1
		));
		$updation['Merchant.total_sales_lost_amount'] = (!empty($total_sales[0][0]['total_sales_lost_amount']) ? $total_sales[0][0]['total_sales_lost_amount'] : '0');
		$updation['Merchant.total_paid_for_charity_amount'] = (!empty($total_sales[0][0]['seller_charity_amount']) ? $total_sales[0][0]['seller_charity_amount'] : '0');
		$updation['Merchant.total_site_revenue_amount'] = (!empty($total_sales[0][0]['total_site_revenue_amount']) ? $total_sales[0][0]['total_site_revenue_amount'] : '0');
		$updation['Merchant.total_sales_cleared_amount'] = (!empty($total_sales[0][0]['total_sales_cleared_amount']) ? $total_sales[0][0]['total_sales_cleared_amount'] : '0');
		$total_items = $this->find('list', array(
			'conditions' => array(
				'Item.merchant_id' => $data['merchant_id'],
				'Item.item_status_id' => array(
					ConstItemStatus::Open,
					ConstItemStatus::Tipped,
					ConstItemStatus::Closed,
				)
			) ,
			'recursive' => -1
		));
		$total_sales_pipeline_amount = $this->ItemUser->find('all', array(
			'conditions' => array(
				'ItemUser.item_id' => array_keys($total_items),
				'ItemUser.is_repaid' => 0,
				'ItemUser.is_canceled' => 0,
			) ,
			'fields' => array(
				'SUM(ItemUser.discount_amount) as total_sales_pipeline_amount',
			) ,
			'recursive' => -1
		));
		$updation['Merchant.total_sales_pipeline_amount'] = (!empty($total_sales_pipeline_amount[0][0]['total_sales_pipeline_amount']) ? $total_sales_pipeline_amount[0][0]['total_sales_pipeline_amount'] : '0');
		// Updating //
		$update_model = array(
			'Merchant.id' => $data['merchant_id']
		);
		if (!empty($updation) && !empty($update_model)) {
			$this->Merchant->updateAll($updation, $update_model);
		}
	}
}
?>