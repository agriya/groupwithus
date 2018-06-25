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
 
class CronComponent extends Component
{
    var $controller;
    public function main()
    {
        App::import('Model', 'Item');
        $this->Item = new Item();
        App::import('Model', 'Subscription');
        $this->Subscription = new Subscription();
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Email');
        $this->Email = new EmailComponent($collection);
        App::import('Model', 'UserCashWithdrawal');
        $this->UserCashWithdrawal = new UserCashWithdrawal();
        $timeZone = Configure::read('site.timezone_offset');
        if (!empty($timeZone)) {
            date_default_timezone_set($timeZone);
        }
        require_once (LIBS . 'router.php');
        $this->Item->_processOpenStatus();
        //change status of Pending to open
        $this->Item->updateAll(array(
            'Item.item_status_id' => ConstItemStatus::Open
        ) , array(
            'Item.end_date <= ' => _formatDate('Y-m-d H:i:s', date('Y-m-d H:i:s') , true) ,
            'Item.item_status_id' => ConstItemStatus::PendingApproval,
        ));
        //send subscription mail
        $this->Item->_sendSubscriptionMail();
        //send Interest mail
        $this->Item->_sendInterestMail();
        //update failure items
        $this->Item->updateAll(array(
            'Item.item_status_id' => ConstItemStatus::Expired
        ) , array(
            'Item.end_date <= ' => _formatDate('Y-m-d H:i:s', date('Y-m-d H:i:s') , true) ,
            'Item.item_status_id' => ConstItemStatus::Open
        ));
        // Expired Tripped Items To Closed With An Email To The Item Owner With Item User List
        $this->Item->_closeItems();
        //refund amount
        if (Configure::read('item.is_auto_refund_enabled')) {
            $this->Item->_refundItemAmount('cron');
        }
        //Automatic user cash with draw payment
        if (Configure::read('user.is_withdraw_request_amount_paid_automatic')) {
            $this->UserCashWithdrawal->_automaticTransferAmount(ConstUserTypes::User);
        }
        //Automatic merchant cash with draw payment for merchant
        if (Configure::read('merchant.is_withdraw_request_amount_paid_automatic')) {
            $this->UserCashWithdrawal->_automaticTransferAmount(ConstUserTypes::Merchant);
        }
        //Automatic pament to items
        if (Configure::read('merchant.is_paid_to_merchant_automatic')) {
            $this->Item->_payToMerchant('cron');
        }
        // City wise item count update
        $this->Item->_updateCityItemCount();
        // For Affiliates ( //
        if (Configure::read('affiliate.is_enabled')) {
            App::import('Model', 'Affiliate');
            $this->Affiliate = new Affiliate();
            $this->Affiliate->update_affiliate_status();
        }
        // ) For affiliates //
		// Expired Count Updation //
		$this->updatePassExpiryCount();
    }
    function currency_conversion($is_manual_update = 0)
    {
		App::import('Model', 'Currency');
		$this->Currency = new Currency();		
		$this->Currency->currency_conversion();
    }
	function updatePassExpiryCount()
	{
		$expired_conditions = array(); // Quick Fix //
		$expired_conditions['Item.item_status_id'] = array(
			ConstItemStatus::Tipped,
			ConstItemStatus::PaidToMerchant,
			ConstItemStatus::Closed,
		);
		$expired_conditions['Item.item_status_id'] = ConstItemStatus::Expired;
		$db = $this->Item->getDataSource();
		$expired_item_users = $this->Item->find('all', array(
			'conditions' => $expired_conditions,
			'fields' => array(
				'Item.id',
				'Item.name',
				'Item.item_status_id'
			) ,
			'contain' => array(
				'ItemUser' => array(
					'conditions' => array(
						'ItemUser.is_paid' => 1,
						'ItemUser.is_repaid' => 0,
						'ItemUser.is_canceled' => 0,
						'ItemUser.quantity >' => $db->expression('ItemUser.item_user_pass_count')
					)
				)
			) ,
			'recursive' => 1
		));
		foreach($expired_item_users as $expired_item_user) {
			$expired_item_users_expired_count = array();
			if (!empty($expired_item_user['ItemUser'])) {
				$expired_item_users_expired_count = $this->Item->ItemUser->find('all', array(
					'conditions' => array(
						'ItemUser.item_id' => $expired_item_user['Item']['id'],
						'ItemUser.is_paid' => 1,
						'ItemUser.is_repaid' => 0,
						'ItemUser.is_canceled' => 0,
						'ItemUser.quantity >' => $db->expression('ItemUser.item_user_pass_count')
					) ,
					'fields' => array(
						'SUM(ItemUser.quantity - ItemUser.item_user_pass_count) as expired_count'
					) ,
					'recursive' => -1
				));
				$this->Item->updateAll(array(
					'Item.item_user_expired_count' => $expired_item_users_expired_count[0][0]['expired_count'],
					'Item.item_user_available_count' => 'Item.item_user_available_count -' . $expired_item_users_expired_count[0][0]['expired_count']
				) , array(
					'Item.id' => $expired_item_user['Item']['id']
				));
			}
		}
	}
}
?>