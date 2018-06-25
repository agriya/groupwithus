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
class AffiliateBehavior extends ModelBehavior
{
    function afterSave($model, $created)
    {
        if (Configure::read('affiliate.is_enabled')) {
            $affiliate_model = Cache::read('affiliate_model', 'affiliatetype');
            if (array_key_exists($model->name, $affiliate_model)) {
                if ($created) {
                    $this->__createAffiliate($model);
                } else {
                    $this->__updateAffiliate($model);
                }
            }
        }
    }
    function __createAffiliate($model)
    {
        App::import('Core', 'Cookie');
        $collection = new ComponentCollection();
        App::import('Component', 'Email');
        $cookie = new CookieComponent($collection);
        $referrer = $cookie->read('referrer');
        $this->User = $this->__getparentClass('User');
        $affiliate_model = Cache::read('affiliate_model', 'affiliatetype');
        if (((!empty($referrer['refer_id'])) || (!empty($model->data['User']['referred_by_user_id']))) && ($model->name == 'User')) {
            if (empty($referrer['refer_id'])) {
                $referrer['refer_id'] = $model->data['User']['referred_by_user_id'];
            }
            // update refer_id
            $data['User']['referred_by_user_id'] = $referrer['refer_id'];
            $data['User']['id'] = $model->id;
            $this->User->save($data);
            // referred count update
            $this->User->updateAll(array(
                'User.referred_by_user_count' => 'User.referred_by_user_count + ' . '1'
            ) , array(
                'User.id' => $referrer['refer_id']
            ));
            if ($this->__CheckAffiliateUSer($referrer['refer_id'])) {
                $this->AffiliateType = $this->__getparentClass('AffiliateType');
                $affiliateType = $this->AffiliateType->find('first', array(
                    'conditions' => array(
                        'AffiliateType.id' => $affiliate_model['User']
                    ) ,
                    'fields' => array(
                        'AffiliateType.id',
                        'AffiliateType.commission',
                        'AffiliateType.affiliate_commission_type_id'
                    ) ,
                    'recursive' => - 1
                ));
                $affiliate_commision_amount = 0;
                if (!empty($affiliateType)) {
                    if (($affiliateType['AffiliateType']['affiliate_commission_type_id'] == ConstAffiliateCommissionType::Percentage)) {
                        $affiliate_commision_amount = 0.0; //($model->data['ItemUser']['commission_amount'] * $affiliateType['AffiliateType']['commission']) / 100;
                        
                    } else {
                        $affiliate_commision_amount = $affiliateType['AffiliateType']['commission'];
                    }
                }
                // set affiliate data
                $affiliate['Affiliate']['class'] = 'User';
                $affiliate['Affiliate']['foreign_id'] = $model->id;
                $affiliate['Affiliate']['affiliate_type_id'] = $affiliate_model['User'];
                $affiliate['Affiliate']['affliate_user_id'] = $referrer['refer_id'];
                $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::PipeLine;
                $affiliate['Affiliate']['commission_holding_start_date'] = date('Y-m-d');
                $affiliate['Affiliate']['commission_amount'] = $affiliate_commision_amount;
                $this->__saveAffiliate($affiliate);
                $cookie->delete('referrer');
            }
        } else if ($model->name == 'ItemUser') {
            $this->ItemUser = $this->__getparentClass('ItemUser');
            if (empty($model->data['ItemUser']['referred_by_user_id'])) {
                if (isset($model->data['ItemUser']['user_id']) && !empty($model->data['ItemUser']['user_id'])) {
                    $user = $this->User->find('first', array(
                        'conditions' => array(
                            'User.id' => $model->data['ItemUser']['user_id']
                        ) ,
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.referred_by_user_id'
                        ) ,
                        'recursive' => - 1
                    ));
                    if (!empty($user['User']['referred_by_user_id'])) {
                        if (Configure::read('affiliate.commission_on_every_item_purchase')) {
                            $referrer['refer_id'] = $user['User']['referred_by_user_id'];
                        } else {
                            $itemusers = $this->ItemUser->find('count', array(
                                'conditions' => array(
                                    'ItemUser.id <>' => $model->id,
                                    'ItemUser.user_id' => $model->data['ItemUser']['user_id'],
                                    'ItemUser.referred_by_user_id' => $user['User']['referred_by_user_id'],
                                ) ,
                            ));
                            if ($itemusers < 1) $referrer['refer_id'] = $user['User']['referred_by_user_id'];
                        }
                    }
                }
            } else {
                $referrer['refer_id'] = $model->data['ItemUser']['referred_by_user_id'];
            }
            if (!empty($referrer['refer_id']) && $this->__CheckAffiliateUSer($referrer['refer_id'])) {
                $this->AffiliateType = $this->__getparentClass('AffiliateType');
                $affiliateType = $this->AffiliateType->find('first', array(
                    'conditions' => array(
                        'AffiliateType.id' => $affiliate_model['ItemUser']
                    ) ,
                    'fields' => array(
                        'AffiliateType.id',
                        'AffiliateType.commission',
                        'AffiliateType.affiliate_commission_type_id'
                    ) ,
                    'recursive' => - 1
                ));
                $affiliate_commision_amount = 0;
                $admin_commision_amount = 0;
                if (!empty($affiliateType)) {
                    $this->Item = $this->__getparentClass('Item');
                    $itemuser_condition = array();
                    $itemuser_condition['Item.id'] = $model->data['ItemUser']['item_id'];
                    $item = $this->Item->find('first', array(
                        'conditions' => $itemuser_condition,
						'fields' => array(
                            'Item.id',
                            'Item.price',
                            'Item.item_status_id'
                        ) ,
                        'recursive' => -1
                    ));
					$itemUser = $this->ItemUser->find('first', array(
                        'conditions' => array(
							'ItemUser.id' => $model->id
						) ,
                        'recursive' => -1
                    ));
                    $item_commission = $itemUser['ItemUser']['discount_amount'];
                    if (($affiliateType['AffiliateType']['affiliate_commission_type_id'] == ConstAffiliateCommissionType::Percentage)) {
                        $affiliate_commision_amount = ($item_commission * $affiliateType['AffiliateType']['commission']) / 100;
                    } else {
                        $affiliate_commision_amount = $affiliateType['AffiliateType']['commission'];
                    }
                    $admin_commision_amount = $item_commission - $affiliate_commision_amount;
                }
                $this->ItemUser->updateAll(array(
                    'ItemUser.referred_by_user_id' => $referrer['refer_id'],
                    'ItemUser.admin_commission_amount' => $admin_commision_amount,
                    'ItemUser.affiliate_commission_amount' => $affiliate_commision_amount
                ) , array(
                    'ItemUser.id' => $model->id
                ));
                // set affiliate data
                $affiliate['Affiliate']['class'] = 'ItemUser';
                $affiliate['Affiliate']['foreign_id'] = $model->id;
                $affiliate['Affiliate']['affiliate_type_id'] = $affiliate_model['ItemUser'];
                $affiliate['Affiliate']['affliate_user_id'] = $referrer['refer_id'];
                if($item['Item']['item_status_id'] ==ConstItemStatus::Tipped){
                $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::PipeLine;
                }else{
                $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::Pending;
                }
                $affiliate['Affiliate']['commission_holding_start_date'] = date('Y-m-d');
                $affiliate['Affiliate']['commission_amount'] = $affiliate_commision_amount;
                $this->__saveAffiliate($affiliate);
                $cookie->delete('referrer');
                $this->User->updateAll(array(
                    'User.referred_purchase_count' => 'User.referred_purchase_count + ' . '1'
                ) , array(
                    'User.id' => $referrer['refer_id']
                ));
                $this->User->updateAll(array(
                    'User.affiliate_refer_purchase_count' => 'User.affiliate_refer_purchase_count + ' . '1'
                ) , array(
                    'User.id' => $model->data['ItemUser']['user_id']
                ));
                $conditions['Affiliate.class'] = 'ItemUser';
                $conditions['Affiliate.foreign_id'] = $model->id;
                $affliates = $this->__findAffiliate($conditions);
                if (!empty($affliates) && empty($affliates['ItemUser']['item_id'])) {
                    $item_id = $model->data['ItemUser']['item_id'];
                } else {
                    $item_id = $affliates['ItemUser']['item_id'];
                }
                $this->ItemUser->Item->updateAll(array(
                    'Item.referred_purchase_count' => 'Item.referred_purchase_count + ' . '1'
                ) , array(
                    'Item.id' => $item_id
                ));
            }
        }
    }
    // Can be optimized. //
    function __updateAffiliate($model)
    {
        $conditions = array();
        if ($model->name == 'ItemUser' && !empty($model->data['ItemUser']['is_canceled'])) {
            $conditions['Affiliate.class'] = 'ItemUser';
            $conditions['Affiliate.foreign_id'] = $model->id;
            $affliates = $this->__findAffiliate($conditions);
            if (!empty($affliates) && empty($affliates['ItemUser']['referred_by_user_id'])) {
                $this->ItemUser = $this->__getparentClass('ItemUser');
                $item_user = $this->ItemUser->find('first', array(
                    'conditions' => array(
                        'ItemUser.id' => $affliates['Affiliate']['foreign_id']
                    ) ,
                    'fields' => array(
                        'ItemUser.id',
                        'ItemUser.item_id',
                        'ItemUser.referred_by_user_id',
                    ) ,
                    'recursive' => - 1
                ));
                $affliates['ItemUser']['referred_by_user_id'] = $item_user['ItemUser']['referred_by_user_id'];
            }
            if (!empty($affliates['ItemUser']['referred_by_user_id'])) {
                $affiliate['Affiliate']['id'] = $affliates['Affiliate']['id'];
                $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::Canceled;
                $this->User = $this->__getparentClass('User');
                $this->User->updateAll(array(
                    'User.total_commission_canceled_amount' => 'User.total_commission_canceled_amount + ' . $affliates['Affiliate']['commission_amount']
                ) , array(
                    'User.id' => $affliates['Affiliate']['affliate_user_id']
                ));
                $this->__saveAffiliate($affiliate);
            }
        } else if ($model->name == 'Item' && !empty($model->data['Item']['item_status_id']) && ($model->data['Item']['item_status_id'] == ConstItemStatus::Canceled || $model->data['Item']['item_status_id'] == ConstItemStatus::Refunded || $model->data['Item']['item_status_id'] == ConstItemStatus::Closed)) {
            $this->ItemUser = $this->__getparentClass('ItemUser');
            $item_users = $this->ItemUser->find('all', array(
                'conditions' => array(
                    'ItemUser.item_id' => $model->data['Item']['id']
                ) ,
                'fields' => array(
                    'ItemUser.id',
                    'ItemUser.item_id',
                    'ItemUser.referred_by_user_id',
                ) ,
                'recursive' => - 1
            ));
            foreach($item_users as $item_user) {
                $conditions['Affiliate.class'] = 'ItemUser';
                $conditions['Affiliate.foreign_id'] = $item_user['ItemUser']['id'];
                $affliates = $this->__findAffiliate($conditions);
                if (!empty($affliates) && empty($affliates['ItemUser']['referred_by_user_id'])) {
                    $affliates['ItemUser']['referred_by_user_id'] = $item_user['ItemUser']['referred_by_user_id'];
                }
                if (!empty($affliates['ItemUser']['referred_by_user_id'])) {
                    $affiliate['Affiliate']['id'] = $affliates['Affiliate']['id'];
                    if ($model->data['Item']['item_status_id'] == ConstItemStatus::Closed) {
                        $affiliate['Affiliate']['commission_holding_start_date'] = date('Y-m-d');
                        $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::PipeLine;
                    } else {
                        $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::Canceled;
                    }
                    $this->User = $this->__getparentClass('User');
                    $this->__saveAffiliate($affiliate);
                    if ($model->data['Item']['item_status_id'] != ConstItemStatus::Closed) {
                        $this->User->updateAll(array(
                            'User.total_commission_canceled_amount' => 'User.total_commission_canceled_amount + ' . $affliates['Affiliate']['commission_amount']
                        ) , array(
                            'User.id' => $affliates['Affiliate']['affliate_user_id']
                        ));
                    }
                }
            }
        }
    }
    function __saveAffiliate($data)
    {
        $this->Affiliate = $this->__getparentClass('Affiliate');
        if (!isset($data['Affiliate']['id'])) {
            $this->Affiliate->create();
            $this->Affiliate->AffiliateUser->updateAll(array(
                'AffiliateUser.total_commission_pending_amount' => 'AffiliateUser.total_commission_pending_amount + ' . $data['Affiliate']['commission_amount']
            ) , array(
                'AffiliateUser.id' => $data['Affiliate']['affliate_user_id']
            ));
        }
        $this->Affiliate->save($data);
    }
    function __findAffiliate($condition)
    {
        $this->Affiliate = $this->__getparentClass('Affiliate');
        $affiliate = $this->Affiliate->find('first', array(
            'conditions' => $condition,
            'recursive' => - 1
        ));
        return $affiliate;
    }
    function __CheckAffiliateUSer($refer_user_id)
    {
        $this->User = $this->__getparentClass('User');
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $refer_user_id
            ) ,
            'recursive' => - 1
        ));
        if (!empty($user) && ($user['User']['is_affiliate_user'])) {
            return true;
        }
        return false;
    }
    function __getparentClass($parentClass)
    {
        App::import('model', $parentClass);
        return new $parentClass;
    }
}
?>