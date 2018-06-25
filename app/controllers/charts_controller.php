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
class ChartsController extends AppController
{
    public $name = 'Charts';
    public $lastDays;
    public $lastMonths;
    public $lastYears;
    public $lastWeeks;
    public $selectRanges;
    public $lastDaysStartDate;
    public $lastMonthsStartDate;
    public $lastYearsStartDate;
    public $lastWeeksStartDate;
    public function initChart()
    {
        //# last days date settings
        $days = 6;
        $this->lastDaysStartDate = date('Y-m-d', strtotime("-$days days"));
        for ($i = $days; $i > 0; $i--) {
            $this->lastDays[] = array(
                'display' => date('D, M d', strtotime("-$i days")) ,
                'conditions' => array(
                    "DATE_FORMAT(#MODEL#.created, '%Y-%m-%d')" =>date('Y-m-d', strtotime("-$i days")),
                )
            );
        }
        $this->lastDays[] = array(
            'display' => date('D, M d') ,
            'conditions' => array(
                "DATE_FORMAT(#MODEL#.created, '%Y-%m-%d')" => date('Y-m-d')
            )
        );
        //# last weeks date settings
        $timestamp_end = strtotime('last Saturday');
        $weeks = 3;
        $this->lastWeeksStartDate = date('Y-m-d', $timestamp_end-((($weeks*7) -1) *24*3600));
        for ($i = $weeks; $i > 0; $i--) {
            $start = $timestamp_end-((($i*7) -1) *24*3600);
            $end = $start+(6*24*3600);
            $this->lastWeeks[] = array(
                'display' => date('M d', $start) . ' - ' . date('M d', $end) ,
                'conditions' => array(
                    '#MODEL#.created >=' => _formatDate('Y-m-d', date('Y-m-d', $start) , true) ,
                    '#MODEL#.created <=' => _formatDate('Y-m-d', date('Y-m-d', $end) , true) ,
                )
            );
        }
        $this->lastWeeks[] = array(
            'display' => date('M d', $timestamp_end+24*3600) . ' - ' . date('M d') ,
            'conditions' => array(
                '#MODEL#.created >=' => _formatDate('Y-m-d', date('Y-m-d', $timestamp_end+24*3600) , true) ,
                '#MODEL#.created <=' => _formatDate('Y-m-d', date('Y-m-d') , true)
            )
        );
        //# last months date settings
        $months = 2;
        $this->lastMonthsStartDate = date('Y-m-01', strtotime("-$months months"));
        for ($i = $months; $i > 0; $i--) {
            $this->lastMonths[] = array(
                'display' => date('M, Y', strtotime("-$i months")) ,
                'conditions' => array(
                    "DATE_FORMAT(#MODEL#.created, '%Y-%m')" => _formatDate('Y-m', date('Y-m-d', strtotime("-$i months")) , true)
                )
            );
        }
        $this->lastMonths[] = array(
            'display' => date('M, Y') ,
            'conditions' => array(
                "DATE_FORMAT(#MODEL#.created, '%Y-%m')" => _formatDate('Y-m', date('Y-m-d') , true)
            )
        );
        //# last years date settings
        $years = 2;
        $this->lastYearsStartDate = date('Y-01-01', strtotime("-$years years"));
        for ($i = $years; $i > 0; $i--) {
            $this->lastYears[] = array(
                'display' => date('Y', strtotime("-$i years")) ,
                'conditions' => array(
                    "DATE_FORMAT(#MODEL#.created, '%Y')" => _formatDate('Y', date('Y-m-d', strtotime("-$i years")) , true)
                )
            );
        }
        $this->lastYears[] = array(
            'display' => date('Y') ,
            'conditions' => array(
                "DATE_FORMAT(#MODEL#.created, '%Y')" => _formatDate('Y', date('Y-m-d') , true)
            )
        );
        $this->selectRanges = array(
            'lastDays' => __l('Last 7 days') ,
            'lastWeeks' => __l('Last 4 weeks') ,
            'lastMonths' => __l('Last 3 months') ,
            'lastYears' => __l('Last 3 years')
        );
    }
    public function admin_chart_users()
    {
        $this->initChart();
        $this->loadModel('User');
        if (isset($this->request->params['named']['user_type_id'])) {
            $this->request->data['Chart']['user_type_id'] = $this->request->params['named']['user_type_id'];
        }
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $user_type_id = ConstUserTypes::User;
        if (isset($this->request->data['Chart']['user_type_id'])) {
            if ($this->request->data['Chart']['user_type_id'] == ConstUserTypes::Merchant) {
                $user_type_id = ConstUserTypes::Merchant;
            }
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $this->request->data['Chart']['user_type_id'] = $user_type_id;
        $model_datas['Normal'] = array(
            'display' => __l('Normal') ,
            'conditions' => array(
                'User.is_facebook_register' => 0,
                'User.is_twitter_register' => 0,
                'User.is_foursquare_register' => 0,
                'User.is_openid_register' => 0,
                'User.is_gmail_register' => 0,
                'User.is_yahoo_register' => 0,
            )
        );
        $model_datas['Twitter'] = array(
            'display' => __l('Twitter') ,
            'conditions' => array(
                'User.is_twitter_register' => 1,
            ) ,
        );
        $model_datas['Foursquare'] = array(
            'display' => __l('Foursquare') ,
            'conditions' => array(
                'User.is_foursquare_register' => 1,
            ) ,
        );
        if (Configure::read('facebook.is_enabled_facebook_connect')) {
            $model_datas['Facebook'] = array(
                'display' => __l('Facebook') ,
                'conditions' => array(
                    'User.is_facebook_register' => 1,
                )
            );
        }
        if (Configure::read('user.is_enable_openid')) {
            $model_datas['OpenID'] = array(
                'display' => __l('OpenID') ,
                'conditions' => array(
                    'User.is_openid_register' => 1,
                )
            );
        }
        $model_datas['Gmail'] = array(
            'display' => __l('Gmail') ,
            'conditions' => array(
                'User.is_gmail_register' => 1,
            )
        );
        $model_datas['Yahoo'] = array(
            'display' => __l('Yahoo') ,
            'conditions' => array(
                'User.is_yahoo_register' => 1,
            )
        );
        if (Configure::read('affiliate.is_enabled')) {
            $_periods['Affiliate'] = array(
                'display' => __l('Affiliate') ,
                'conditions' => array(
                    'User.is_affiliate_user' => 1,
                )
            );
        }
        $model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array()
        );
        $common_conditions = array(
            'User.user_type_id' => $user_type_id
        );
        $_data = $this->_setLineData($select_var, $model_datas, 'User', 'User', $common_conditions);
        $this->set('chart_data', $_data);
        $this->set('chart_periods', $model_datas);
        $this->set('selectRanges', $this->selectRanges);
        // overall pie chart
        $select_var.= 'StartDate';
        $startDate = $this->$select_var;
        $endDate = date('Y-m-d 23:59:59');
        $total_users = $this->User->find('count', array(
            'conditions' => array(
                'User.user_type_id' => $user_type_id,
                'created >=' => _formatDate('Y-m-d H:i:s', $startDate, true) ,
                'created <=' => _formatDate('Y-m-d H:i:s', $endDate, true)
            ) ,
            'recursive' => -1
        ));
        unset($model_datas['All']);
        unset($model_datas['Affiliate']);
           $_pie_data = $chart_pie_relationship_data = $chart_pie_education_data = $chart_pie_employment_data = $chart_pie_income_data = $chart_pie_gender_data = $chart_pie_age_data = array();
        if (!empty($total_users)) {
            foreach($model_datas as $_period) {
                $new_conditions = array();
                $new_conditions = array_merge($_period['conditions'], array(
                    'created >=' => _formatDate('Y-m-d H:i:s', $startDate, true) ,
                    'created <=' => _formatDate('Y-m-d H:i:s', $endDate, true)
                ));
                $new_conditions['User.user_type_id'] = $user_type_id;
                $sub_total = $this->User->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => -1
                ));
                $_pie_data[$_period['display']] = number_format(($sub_total/$total_users) *100, 2);
            }
            // demographics
            $conditions = array(
                'User.created >=' => _formatDate('Y-m-d H:i:s', $startDate, true) ,
                'User.created <=' => _formatDate('Y-m-d H:i:s', $endDate, true) ,
                'User.user_type_id' => $user_type_id
            );
            $this->_setDemographics($total_users, $conditions);
        }
        $this->set('chart_pie_data', $_pie_data);
    }
    public function admin_chart_user_logins()
    {
        $this->initChart();
        $this->loadModel('UserLogin');
        if (isset($this->request->params['named']['user_type_id'])) {
            $this->request->data['Chart']['user_type_id'] = $this->request->params['named']['user_type_id'];
        }
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $user_type_id = ConstUserTypes::User;
        if (isset($this->request->data['Chart']['user_type_id'])) {
            if ($this->request->data['Chart']['user_type_id'] == ConstUserTypes::Merchant) {
                $user_type_id = ConstUserTypes::Merchant;
            }
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $this->request->data['Chart']['user_type_id'] = $user_type_id;
        $model_datas['Normal'] = array(
            'display' => __l('Normal') ,
            'conditions' => array(
                'User.is_facebook_register' => 0,
                'User.is_twitter_register' => 0,
                'User.is_foursquare_register' => 0,
                'User.is_openid_register' => 0,
                'User.is_gmail_register' => 0,
                'User.is_yahoo_register' => 0,
            )
        );
        $model_datas['Twitter'] = array(
            'display' => __l('Twitter') ,
            'conditions' => array(
                'User.is_twitter_register' => 1,
            ) ,
        );
        $model_datas['Foursquare'] = array(
            'display' => __l('Foursquare') ,
            'conditions' => array(
                'User.is_foursquare_register' => 1,
            ) ,
        );
        if (Configure::read('facebook.is_enabled_facebook_connect')) {
            $model_datas['Facebook'] = array(
                'display' => __l('Facebook') ,
                'conditions' => array(
                    'User.is_facebook_register' => 1,
                )
            );
        }
        if (Configure::read('user.is_enable_openid')) {
            $model_datas['OpenID'] = array(
                'display' => __l('OpenID') ,
                'conditions' => array(
                    'User.is_openid_register' => 1,
                )
            );
        }
        $model_datas['Gmail'] = array(
            'display' => __l('Gmail') ,
            'conditions' => array(
                'User.is_gmail_register' => 1,
            )
        );
        $model_datas['Yahoo'] = array(
            'display' => __l('Yahoo') ,
            'conditions' => array(
                'User.is_yahoo_register' => 1,
            )
        );
        $model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array()
        );
        $common_conditions = array(
            'User.user_type_id' => $user_type_id
        );
        $_data = $this->_setLineData($select_var, $model_datas, 'UserLogin', 'UserLogin', $common_conditions);
        $this->set('chart_data', $_data);
        $this->set('chart_periods', $model_datas);
        $this->set('selectRanges', $this->selectRanges);
        // overall pie chart
        $select_var.= 'StartDate';
        $startDate = $this->$select_var;
        $endDate = date('Y-m-d H:i:s');
        $total_users = $this->UserLogin->find('count', array(
            'conditions' => array(
                'User.user_type_id' => $user_type_id,
                'UserLogin.created >=' => _formatDate('Y-m-d H:i:s', $startDate, true) ,
                'UserLogin.created <=' => _formatDate('Y-m-d H:i:s', $endDate, true) ,
            ) ,
            'recursive' => 0
        ));
        unset($model_datas['All']);
        //unset($model_datas['OpenID']);
        $_pie_data = array();
        if (!empty($total_users)) {
            foreach($model_datas as $_period) {
                $new_conditions = array();
                $new_conditions = array_merge($_period['conditions'], array(
                    'UserLogin.created >=' => _formatDate('Y-m-d H:i:s', $startDate, true) ,
                    'UserLogin.created <=' => _formatDate('Y-m-d H:i:s', $endDate, true)
                ));
                $new_conditions['User.user_type_id'] = $user_type_id;
                $sub_total = $this->UserLogin->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $_pie_data[$_period['display']] = number_format(($sub_total/$total_users) *100, 2);
            }
        }
        $this->set('chart_pie_data', $_pie_data);
    }
    public function admin_chart_items()
    {
        $this->setAction('chart_items');
    }
    public function chart_items()
    {
        $this->loadModel('Item');
        if ($this->Auth->user('user_type_id') != ConstUserTypes::Merchant && $this->Auth->user('user_type_id') != ConstUserTypes::Admin) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->initChart();
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
        //# items stats
        $conditions = array();
        $not_conditions = array();
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
            $city_filter_id = $this->Session->read('city_filter_id');
            if (!empty($city_filter_id)) {
                $item_cities = $this->Item->User->UserProfile->City->find('first', array(
                    'conditions' => array(
                        'City.id' => $city_filter_id
                    ) ,
                    'fields' => array(
                        'City.name'
                    ) ,
                    'contain' => array(
                        'Item' => array(
                            'fields' => array(
                                'Item.id'
                            ) ,
                        )
                    ) ,
                    'recursive' => 1
                ));
                foreach($item_cities['Item'] as $item_city) {
                    $city_item_id[] = $item_city['id'];
                }
                $conditions['Item.id'] = $city_item_id;
            }
        }
         if ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) {
            $merchant = $this->Item->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.user_id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            $conditions['Item.merchant_id'] = $merchant['Merchant']['id'];
        }
       $item_model_datas['Draft'] = array(
            'display' => __l('Draft') ,
            'conditions' => array_merge(array(
                'Item.item_status_id' => ConstItemStatus::Draft
            ) , $conditions) ,
        );
        $item_model_datas['Pending'] = array(
            'display' => __l('Pending') ,
            'conditions' => array_merge(array(
                'Item.item_status_id' => ConstItemStatus::PendingApproval
            ) , $conditions) ,
        );
        $item_model_datas['Open'] = array(
            'display' => __l('Open') ,
            'conditions' => array_merge(array(
                'Item.item_status_id' => ConstItemStatus::Open
            ) , $conditions) ,
        );
        $item_model_datas['Tipped'] = array(
            'display' => __l('Tipped') ,
            'conditions' => array_merge(array(
                'Item.item_status_id' => ConstItemStatus::Tipped
            ) , $conditions) ,
        );
        $item_model_datas['Closed'] = array(
            'display' => __l('Closed') ,
            'conditions' => array_merge(array(
                'Item.item_status_id' => ConstItemStatus::Closed
            ) , $conditions) ,
        );
        $item_model_datas['Paid To Merchant'] = array(
            'display' => __l('Paid To Merchant') ,
            'conditions' => array_merge(array(
                'Item.item_status_id' => ConstItemStatus::PaidToMerchant
            ) , $conditions) ,
        );
        $item_model_datas['Refunded'] = array(
            'display' => __l('Refunded') ,
            'conditions' => array_merge(array(
                'Item.item_status_id' => ConstItemStatus::Refunded
            ) , $conditions) ,
        );
        $item_model_datas['Rejected'] = array(
            'display' => __l('Rejected') ,
            'conditions' => array_merge(array(
                'Item.item_status_id' => ConstItemStatus::Rejected
            ) , $conditions) ,
        );
        $item_model_datas['Canceled'] = array(
            'display' => __l('Canceled') ,
            'conditions' => array_merge(array(
                'Item.item_status_id' => ConstItemStatus::Canceled
            ) , $conditions) ,
        );
        $item_model_datas['Expired'] = array(
            'display' => __l('Expired') ,
            'conditions' => array_merge(array(
                'Item.item_status_id' => ConstItemStatus::Expired
            ) , $conditions) ,
        );
        $item_model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array(
                $conditions,
                $not_conditions
            )
        );
         $common_conditions = array();
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) {
            $merchant = $this->Item->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.user_id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            $common_conditions['Item.merchant_id'] = $merchant['Merchant']['id'];
        }
         $chart_items_data = $this->_setLineData($select_var, $item_model_datas, 'Item', $common_conditions);
        //# item purchase
        $item_user_model_datas = array();
        $this->loadModel('ItemUser');
        $item_user_model_datas['Available'] = array(
            'display' => __l('Available') ,
            'conditions' => array(
                'ItemUser.quantity >' => 'ItemUser.item_user_pass_count' ,
                'ItemUser.is_repaid' => 0,
                'ItemUser.is_canceled' => 0,
                'Item.item_status_id' => array(
                    ConstItemStatus::Closed,
                    ConstItemStatus::Tipped,
                    ConstItemStatus::PaidToMerchant)
                )
        );
        $item_user_model_datas['Used'] = array(
            'display' => __l('Used') ,
            'conditions' => array(
                'ItemUser.item_user_pass_count !=' => 0,
                'ItemUser.is_canceled' => 0,
                'ItemUser.is_repaid' => 0,
            ) ,
        );
        $item_user_model_datas['Expired'] = array(
            'display' => __l('Expired') ,
            'conditions' => array(
                'ItemUser.is_repaid' => 0,
                'ItemUser.is_canceled' => 0,
            ) ,
        );
        $item_user_model_datas['Pending'] = array(
            'display' => __l('Pending') ,
            'conditions' => array(
                'Item.item_status_id' => ConstItemStatus::Open,
                'ItemUser.is_repaid' => 0,
                'ItemUser.is_canceled' => 0,
            ) ,
        );
        $item_user_model_datas['Canceled'] = array(
            'display' => __l('Canceled') ,
            'conditions' => array(
                'ItemUser.is_canceled' => 1,
            ) ,
        );
        $chart_item_pass_data = $this->_setLineData($select_var, $item_user_model_datas, array(
            'ItemUser',
            'ItemUserPass'
        ) , 'ItemUser', $common_conditions);
        // pass usages
        $item_usage_model_datas = array();
        $pass_usage_model_datas['Redeemed'] = array(
            'display' => __l('Redeemed') ,
            'conditions' => array(
                'ItemUserPass.is_used' => 1,
            ) ,
        );
        $pass_usage_model_datas['Not Redeemed'] = array(
            'display' => __l('Not Redeemed') ,
            'conditions' => array(
                'ItemUserPass.is_used' => 0,
            ) ,
        );
        $pass_usage_model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array() ,
        );
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) {
            $reedeem_item_id = $this->Item->find('list', array(
                'conditions' => array(
                    'Item.merchant_id' => $merchant['Merchant']['id']
                ) ,
                'fields' => array(
                    'Item.id'
                ) ,
                'recursive' => -1
            ));
            $reedeem_item_user = $this->Item->ItemUser->find('list', array(
                'conditions' => array(
                    'ItemUser.item_id' => $reedeem_item_id
                ) ,
                'fields' => array(
                    'ItemUser.id'
                ) ,
                'recursive' => 0
            ));
            $common_conditions = array(
                'ItemUserPass.item_user_id' => $reedeem_item_user
            );
        }
        $chart_pass_usages_data = $this->_setLineData($select_var, $pass_usage_model_datas, array(
            'ItemUserPass'
        ) , 'ItemUserPass', $common_conditions);
        $this->set('chart_items_data', $chart_items_data);
        $this->set('chart_items_periods', $item_model_datas);
        $this->set('chart_item_pass_periods', $item_user_model_datas);
        $this->set('chart_item_pass_data', $chart_item_pass_data);
        $this->set('chart_pass_usage_periods', $pass_usage_model_datas);
        $this->set('chart_pass_usage_data', $chart_pass_usages_data);
        $this->set('selectRanges', $this->selectRanges);
    }
    public function admin_chart_transactions()
    {
        $this->initChart();
        $this->loadModel('Item');
        $this->loadModel('Transaction');
        $this->loadModel('UserCashWithdrawal');
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $conditions = array();
        $city_filter_id = $this->Session->read('city_filter_id');
        if (!empty($city_filter_id)) {
            $item_cities = $this->User->UserProfile->City->find('first', array(
                'conditions' => array(
                    'City.id' => $city_filter_id
                ) ,
                'fields' => array(
                    'City.name'
                ) ,
                'contain' => array(
                    'Item' => array(
                        'fields' => array(
                            'Item.id'
                        ) ,
                    )
                ) ,
                'recursive' => 1
            ));
            foreach($item_cities['Item'] as $item_city) {
                $city_item_id[] = $item_city['id'];
            }
            $conditions['Item.id'] = $city_item_id;
        }
        $transaction_model_datas = array();
        $transaction_model_datas['Total Earned (Site) Amount'] = array(
            'display' => __l('Site Earned Amount') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Item',
            'conditions' => array_merge(array(
                'Item.item_status_id' => array(
                    ConstItemStatus::PaidToMerchant
                )
            ) , $conditions) ,
        );
        $transaction_model_datas['Total Deposited (Add to wallet) Amount'] = array(
            'display' => __l('Deposited') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::AddedToWallet
            ) ,
        );
        $transaction_model_datas['Total Paid Commission Amount for Merchant'] = array(
            'display' => __l('Paid Commission for Merchant') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::PaidItemAmountToMerchant
            ) ,
        );
        $transaction_model_datas['Total Paid Referral Amount to Users'] = array(
            'display' => __l('Paid Referral for User') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::ReferralAmountPaid
            ) ,
        );
        $transaction_model_datas['Total Withdrawn Amount'] = array(
            'display' => __l('Withdrawn Amount') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::AcceptCashWithdrawRequest
            ) ,
        );
        $transaction_model_datas['Total Pending Withdraw Request'] = array(
            'display' => __l('Pending Withdraw Request') ,
            'model' => 'UserCashWithdrawal',
            'conditions' => array(
                'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Pending
            ) ,
        );
        $chart_transactions_data = array();
        foreach($this->$select_var as $val) {
            foreach($transaction_model_datas as $model_data) {
                $new_conditions = array();
                if (isset($model_data['model'])) {
                    $modelClass = $model_data['model'];
                } else {
                    $modelClass = 'Transaction';
                }
                foreach($val['conditions'] as $key => $v) {
                    $key = str_replace('#MODEL#', $modelClass, $key);
                    $new_conditions[$key] = $v;
                }
                $new_conditions = array_merge($new_conditions, $model_data['conditions']);
                if ($modelClass == 'Transaction') {
                    $value_count = $this->{$modelClass}->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(Transaction.amount) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else if ($modelClass == 'Item') {
                    $value_count = $this->{$modelClass}->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(Item.total_commission_amount) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else {
                    $value_count = $this->{$modelClass}->find('count', array(
                        'conditions' => $new_conditions,
                        'recursive' => 0
                    ));
                }
                $chart_transactions_data[$val['display']][] = $value_count;
            }
        }
        $this->_setItemOrders($select_var);
        $this->set('chart_transactions_periods', $transaction_model_datas);
        $this->set('chart_transactions_data', $chart_transactions_data);
        $this->set('selectRanges', $this->selectRanges);
    }
    protected function _setItemOrders($select_var)
    {
        $this->loadModel('Item');
        $common_conditions = array();
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) {
            $merchant = $this->Item->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.user_id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            $item_id = $this->Item->find('list', array(
                'conditions' => array(
                    'Item.merchant_id' => $merchant['Merchant']['id']
                ) ,
                'fields' => array(
                    'Item.id'
                ) ,
                'recursive' => -1
            ));
            $common_conditions['ItemUser.item_id'] = $item_id;
        }
        $item_order_model_datas['Order'] = array(
            'display' => __l('Orders') ,
            'conditions' => array() ,
        );
        $chart_item_orders_data = $this->_setLineData($select_var, $item_order_model_datas, array(
            'ItemUser'
        ) , 'ItemUser', $common_conditions);
        $this->set('chart_item_orders_data', $chart_item_orders_data);
    }
    public function admin_chart_merchants()
    {
        $this->loadModel('Item');
        $merchants = $this->Item->Merchant->find('all', array(
            'recursive' => -1,
            'order' => array(
                'Merchant.total_site_revenue_amount' => 'DESC'
            ) ,
            'fields' => array(
                'Merchant.name',
                'Merchant.id',
                'Merchant.total_site_revenue_amount'
            ) ,
            'limit' => 10
        ));
        if (!empty($merchants)) {
            foreach($merchants as $key => $merchant) {
                $merchants[$key]['Merchant']['items_count'] = $this->Item->find('count', array(
                    'conditions' => array(
                        'Item.merchant_id' => $merchant['Merchant']['id'],
                    ) ,
                    'recursive' => -1
                ));
                $pass = $this->Item->ItemUser->find('all', array(
                    'conditions' => array(
                        'Item.merchant_id' => $merchant['Merchant']['id']
                    ) ,
                    'fields' => array(
                        'SUM(ItemUser.quantity) as pass'
                    ) ,
                    'recursive' => 0
                ));
                $merchants[$key]['Merchant']['pass_count'] = is_null($pass[0][0]['pass']) ? 0 : $pass[0][0]['pass'];
                $merchants[$key]['Merchant']['average_pass_item_count'] = !empty($merchants[$key]['Merchant']['items_count']) ? ($merchants[$key]['Merchant']['pass_count']/$merchants[$key]['Merchant']['items_count']) : 0;
                $merchants[$key]['Merchant']['average_revenue_item_amoumt'] = !empty($merchants[$key]['Merchant']['items_count']) ? ($merchants[$key]['Merchant']['total_site_revenue_amount']/$merchants[$key]['Merchant']['items_count']) : 0;
                $total_offered = $this->Item->find('all', array(
                    'conditions' => array(
                        'Item.merchant_id' => $merchant['Merchant']['id']
                    ) ,
                    'fields' => array(
                        'SUM(Item.price) as total_offered'
                    ) ,
                    'recursive' => 0
                ));
                $total_offered_price = is_null($total_offered[0][0]['total_offered']) ? 0 : $total_offered[0][0]['total_offered'];
                $merchants[$key]['Merchant']['average_offered_price'] = !empty($merchants[$key]['Merchant']['items_count']) ? ($total_offered_price/$merchants[$key]['Merchant']['items_count']) : 0;
                $max_pass_per_item = $this->Item->ItemUser->find('all', array(
                    'conditions' => array(
                        'Item.merchant_id' => $merchant['Merchant']['id']
                    ) ,
                    'fields' => array(
                        'SUM(ItemUser.quantity) as pass',
                    ) ,
                    'group' => array(
                        'ItemUser.item_id'
                    ) ,
                    'order' => array(
                        'pass' => 'DESC'
                    ) ,
                    'limit' => 1,
                    'recursive' => 0
                ));
                if (!empty($max_pass_per_item)) {
                    $merchants[$key]['Merchant']['max_pass_per_item'] = is_null($max_pass_per_item[0][0]['pass']) ? 0 : $max_pass_per_item[0][0]['pass'];
                } else {
                    $merchants[$key]['Merchant']['max_pass_per_item'] = 0;
                }
                $max_revenue_per_item = $this->Item->find('all', array(
                    'conditions' => array(
                        'Item.merchant_id' => $merchant['Merchant']['id']
                    ) ,
                    'fields' => array(
                        'MAX(Item.total_commission_amount) as total_commission_amount',
                    ) ,
                    'recursive' => 0
                ));
                if (!empty($max_revenue_per_item)) {
                    $merchants[$key]['Merchant']['max_revenue_per_item'] = is_null($max_revenue_per_item[0][0]['total_commission_amount']) ? 0 : $max_revenue_per_item[0][0]['total_commission_amount'];
                } else {
                    $merchants[$key]['Merchant']['max_revenue_per_item'] = 0;
                }
            }
        }
        $this->set('merchants', $merchants);
    }
    public function admin_chart_items_stats()
    {
        $this->loadModel('Item');
        $items_stats = array();
        // price
        $min_item_price = $this->Item->find('all', array(
            'fields' => array(
                'MIN(Item.price) as min_item_price',
            ) ,
            'recursive' => -1
        ));
        if (!empty($min_item_price)) {
            $items_stats['price']['min'] = is_null($min_item_price[0][0]['min_item_price']) ? 0 : $min_item_price[0][0]['min_item_price'];
        } else {
            $items_stats['price']['min'] = 0;
        }
        $max_item_price = $this->Item->find('all', array(
            'fields' => array(
                'MAX(Item.price) as max_item_price',
            ) ,
            'recursive' => -1
        ));
        if (!empty($max_item_price)) {
            $items_stats['price']['max'] = is_null($max_item_price[0][0]['max_item_price']) ? 0 : $max_item_price[0][0]['max_item_price'];
        } else {
            $items_stats['price']['max'] = 0;
        }
        // sold quantity
        $min_sold_per_item = $this->Item->ItemUser->find('all', array(
            'fields' => array(
                'SUM(ItemUser.quantity) as pass',
            ) ,
            'group' => array(
                'ItemUser.item_id'
            ) ,
            'order' => array(
                'pass' => 'ASC'
            ) ,
            'limit' => 1,
            'recursive' => 0
        ));
        $max_sold_per_item = $this->Item->ItemUser->find('all', array(
            'fields' => array(
                'SUM(ItemUser.quantity) as pass',
            ) ,
            'group' => array(
                'ItemUser.item_id'
            ) ,
            'order' => array(
                'pass' => 'DESC'
            ) ,
            'limit' => 1,
            'recursive' => 0
        ));
        $sum_sold_item = $this->Item->ItemUser->find('all', array(
            'fields' => array(
                'SUM(ItemUser.quantity) as pass',
            ) ,
            'recursive' => 0
        ));
        if (!empty($min_sold_per_item)) {
            $items_stats['sold_quantity']['min'] = is_null($min_sold_per_item[0][0]['pass']) ? 0 : $min_sold_per_item[0][0]['pass'];
        } else {
            $items_stats['sold_quantity']['min'] = 0;
        }
        if (!empty($max_sold_per_item)) {
            $items_stats['sold_quantity']['max'] = is_null($max_sold_per_item[0][0]['pass']) ? 0 : $max_sold_per_item[0][0]['pass'];
        } else {
            $items_stats['sold_quantity']['max'] = 0;
        }
        if (!empty($sum_sold_item)) {
            $items_stats['sold_quantity']['sum'] = is_null($sum_sold_item[0][0]['pass']) ? 0 : $sum_sold_item[0][0]['pass'];
        } else {
            $items_stats['sold_quantity']['sum'] = 0;
        }
        // total revenue
        $min_total_revenue_per_item = $this->Item->find('all', array(
			'conditions' => array(
				'Item.item_status_id' => array(
					ConstItemStatus::Tipped,
					ConstItemStatus::Closed,
					ConstItemStatus::PaidToMerchant,
				)
			) ,
            'fields' => array(
                'MIN(Item.total_commission_amount) as revenue',
            ) ,
            'recursive' => 0
        ));
        $max_total_revenue_per_item = $this->Item->find('all', array(
            'fields' => array(
                'MAX(Item.total_commission_amount) as revenue',
            ) ,
            'recursive' => 0
        ));
        $sum_total_revenue_item = $this->Item->find('all', array(
            'fields' => array(
                'SUM(Item.total_commission_amount) as revenue',
            ) ,
            'recursive' => 0
        ));
        if (!empty($min_sold_per_item)) {
            $items_stats['total_revenue']['min'] = is_null($min_total_revenue_per_item[0][0]['revenue']) ? 0 : $min_total_revenue_per_item[0][0]['revenue'];
        } else {
            $items_stats['total_revenue']['min'] = 0;
        }
        if (!empty($max_total_revenue_per_item)) {
            $items_stats['total_revenue']['max'] = is_null($max_total_revenue_per_item[0][0]['revenue']) ? 0 : $max_total_revenue_per_item[0][0]['revenue'];
        } else {
            $items_stats['total_revenue']['max'] = 0;
        }
        if (!empty($sum_total_revenue_item)) {
            $items_stats['total_revenue']['sum'] = is_null($sum_total_revenue_item[0][0]['revenue']) ? 0 : $sum_total_revenue_item[0][0]['revenue'];
        } else {
            $items_stats['total_revenue']['sum'] = 0;
        }
        $this->set('items_stats', $items_stats);
    }
    public function admin_chart_price_points()
    {
        $this->loadModel('Item');
        for ($i = 0; $i < 10; $i++) {
            $start = $i*10;
            $end = $start+9.99;
            $pricePoints[] = array(
                'price_points' => $start . '-' . $end,
                'range' => array(
                    $start,
                    $end
                )
            );
        }
        for ($i = 1; $i < 5; $i++) {
            $start = $i*100;
            $end = $start+99.99;
            $pricePoints[] = array(
                'price_points' => $start . '-' . $end,
                'range' => array(
                    $start,
                    $end
                )
            );
        }
        $pricePoints[] = array(
            'price_points' => __l('500+') ,
            'range' => array(
                500
            )
        );
        foreach($pricePoints as $key => $pricePoint) {
            $new_conditions = array();
            $new_conditions['Item.price >='] = $pricePoint['range'][0];
            if (isset($pricePoint['range'][1])) {
                $new_conditions['Item.price <='] = $pricePoint['range'][1];
            }
			$new_conditions['Item.item_status_id'] = array(
				ConstItemStatus::Tipped,
				ConstItemStatus::Closed,
				ConstItemStatus::PaidToMerchant,
			);
            $sum_total_revenue_item = $this->Item->find('all', array(
                'conditions' => $new_conditions,
                'fields' => array(
                    'SUM(Item.total_commission_amount) as revenue',
                ) ,
                'recursive' => -1
            ));
            if (!empty($sum_total_revenue_item)) {
                $pricePoints[$key]['revenue'] = is_null($sum_total_revenue_item[0][0]['revenue']) ? 0 : $sum_total_revenue_item[0][0]['revenue'];
            } else {
                $pricePoints[$key]['revenue'] = 0;
            }
            $pricePoints[$key]['items_count'] = $this->Item->find('count', array(
                'conditions' => $new_conditions,
                'recursive' => -1
            ));
            $pass = $this->Item->ItemUser->find('all', array(
                'conditions' => $new_conditions,
                'fields' => array(
                    'SUM(ItemUser.quantity) as pass'
                ) ,
                'recursive' => 0
            ));
            $pricePoints[$key]['pass_count'] = is_null($pass[0][0]['pass']) ? 0 : $pass[0][0]['pass'];
            $pricePoints[$key]['average_pass_item_count'] = !empty($pricePoints[$key]['items_count']) ? ($pricePoints[$key]['pass_count']/$pricePoints[$key]['items_count']) : 0;
            $pricePoints[$key]['average_revenue_item_amoumt'] = !empty($pricePoints[$key]['items_count']) ? ($pricePoints[$key]['revenue']/$pricePoints[$key]['items_count']) : 0;
            $avg_discounted_price_item = $this->Item->find('all', array(
                'conditions' => $new_conditions,
                'fields' => array(
                    'AVG(Item.price) as price',
                ) ,
                'recursive' => 0
            ));
            if (!empty($avg_discounted_price_item)) {
                $pricePoints[$key]['avg_discounted_price'] = is_null($avg_discounted_price_item[0][0]['price']) ? 0 : $avg_discounted_price_item[0][0]['price'];
            } else {
                $pricePoints[$key]['avg_discounted_price'] = 0;
            }
        }
        $this->set('pricePoints', $pricePoints);
    }
    public function chart_merchant_users()
    {
        $this->loadModel('Item');
        if ($this->Auth->user('user_type_id') != ConstUserTypes::Merchant) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $merchant = $this->Item->Merchant->find('first', array(
            'conditions' => array(
                'Merchant.user_id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        $item_users = $this->Item->ItemUser->find('list', array(
            'conditions' => array(
                'Item.merchant_id' => $merchant['Merchant']['id']
            ) ,
            'fields' => array(
                'ItemUser.user_id'
            ) ,
            'recursive' => 0
        ));
         if (!empty($item_users)) {
            $item_users_key = array_values($item_users);
            $item_users = array_combine($item_users_key, $item_users_key);
        }
        $total_users = count($item_users);
        $model_datas['Normal'] = array(
            'display' => __l('Normal') ,
            'conditions' => array(
                'User.is_facebook_register' => 0,
                'User.is_twitter_register' => 0,
                'User.is_foursquare_register' => 0,
                'User.is_openid_register' => 0,
                'User.is_gmail_register' => 0,
                'User.is_yahoo_register' => 0,
            )
        );
        $model_datas['Twitter'] = array(
            'display' => __l('Twitter') ,
            'conditions' => array(
                'User.is_twitter_register' => 1,
            ) ,
        );
        $model_datas['Foursquare'] = array(
            'display' => __l('Foursquare') ,
            'conditions' => array(
                'User.is_foursquare_register' => 1,
            ) ,
        );
        if (Configure::read('facebook.is_enabled_facebook_connect')) {
            $model_datas['Facebook'] = array(
                'display' => __l('Facebook') ,
                'conditions' => array(
                    'User.is_facebook_register' => 1,
                )
            );
        }
        if (Configure::read('user.is_enable_openid')) {
            $model_datas['OpenID'] = array(
                'display' => __l('OpenID') ,
                'conditions' => array(
                    'User.is_openid_register' => 1,
                )
            );
        }
        $model_datas['Gmail'] = array(
            'display' => __l('Gmail') ,
            'conditions' => array(
                'User.is_gmail_register' => 1,
            )
        );
        $model_datas['Yahoo'] = array(
            'display' => __l('Yahoo') ,
            'conditions' => array(
                'User.is_yahoo_register' => 1,
            )
        );
        $_pie_data = array();
        if (!empty($total_users)) {
            foreach($model_datas as $_period) {
                $new_conditions = array(
                    'User.id' => $item_users
                );
                $new_conditions = array_merge($new_conditions, $_period['conditions']);
                $sub_total = $this->Item->User->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => -1
                ));
                $_pie_data[$_period['display']] = number_format(($sub_total/$total_users) *100, 2);
            }
        }
        $this->set('chart_pie_data', $_pie_data);
         }
    function admin_chart_item_stats($item_id)
    {
        $this->setAction('chart_item_stats', $item_id);
    }
    public function chart_item_stats($item_id)
    {
        $this->pageTitle = __l('Item Stats');
        $this->loadModel('Item');
        if ($this->Auth->user('user_type_id') != ConstUserTypes::Admin && $this->Auth->user('user_type_id') != ConstUserTypes::Merchant) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $conditions = array();
        $conditions['Item.id'] = $item_id;
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) {
            $merchant = $this->Item->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.user_id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            $conditions['Item.merchant_id'] = $merchant['Merchant']['id'];
        }
        $item = $this->Item->find('first', array(
            'conditions' => $conditions,
            'contain' => array(
                'ItemUser' => array(
                    'order' => array(
                        'ItemUser.created' => 'ASC'
                    ) ,
                )
            ) ,
            'recursive' => 1
        ));
        if (empty($item)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $chart_quantity_sold = $item_users = array();
        $item_stats = array();
        $item_stats['pass'] = 0;
        $item_stats['redeemed'] = 0;
        if (!empty($item['ItemUser'])) {
            $i = 0;
            $itemUserIds = array();
            foreach($item['ItemUser'] as $itemUser) {
                $chart_quantity_sold[$i]['display'] = _formatDate('M d, y H:i', $itemUser['created'], true);
                $chart_quantity_sold[$i]['quantity'] = $itemUser['quantity'];
                $item_users[$itemUser['user_id']] = $itemUser['user_id'];
                $item_stats['pass']+= $itemUser['quantity'];
                $itemUserIds[$itemUser['id']] = $itemUser['id'];
                $i++;
            }
            $item_stats['redeemed'] = $this->Item->ItemUser->ItemUserPass->find('count', array(
                'conditions' => array(
                    'ItemUserPass.is_used' => 1,
                    'ItemUserPass.item_user_id' => $itemUserIds
                ) ,
                'recursive' => 0
            ));
        }
        $total_users = count($item['ItemUser']);
        // demographics
        $conditions = array(
            'User.id' => $item_users
        );
		$this->pageTitle .= ' - '.substr($item['Item']['name'], 0 , 100 );
		$this->pageTitle .= (strlen($item['Item']['name']) > 100)? '...': '';
        $this->_setDemographics($total_users, $conditions);
        $this->set('chart_quantity_sold', $chart_quantity_sold);
        $this->set('item', $item);
        $this->set('item_stats', $item_stats);
    }
    protected function _setDemographics($total_users, $conditions = array())
    {
        $this->loadModel('User');
        $chart_pie_relationship_data = $chart_pie_education_data = $chart_pie_employment_data = $chart_pie_income_data = $chart_pie_gender_data = $chart_pie_age_data = array();
        if (!empty($total_users)) {
            $not_mentioned = array(
                '0' => __l('Not Mentioned')
            );
            //# genders
            $genders = $this->User->UserProfile->Gender->find('list');
            $genders = array_merge($not_mentioned, $genders);
            foreach($genders As $gen_key => $gender) {
                $new_conditions = $conditions;
                if ($gen_key == 0) {
                    $new_conditions['UserProfile.gender_id'] = NULL;
                } else {
                    $new_conditions['UserProfile.gender_id'] = $gen_key;
                }
                $gender_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 1
                ));
                $chart_pie_gender_data[$gender] = number_format(($gender_count/$total_users) *100, 2);
            }
            //# age calculation
            $user_ages = array(
                '1' => __l('18 - 34 Yrs') ,
                '2' => __l('35 - 44 Yrs') ,
                '3' => __l('45 - 54 Yrs') ,
                '4' => __l('55+ Yrs')
            );
            $user_ages = array_merge($not_mentioned, $user_ages);
            foreach($user_ages As $age_key => $user_ages) {
                $new_conditions = $conditions;
                if ($age_key == 1) {
                    $new_conditions['Year(Now()) - Year(UserProfile.dob) >= '] = 18;
                    $new_conditions['Year(Now()) - Year(UserProfile.dob) <= '] = 34;
                } elseif ($age_key == 2) {
                    $new_conditions['Year(Now()) - Year(UserProfile.dob) >= '] = 35;
                    $new_conditions['Year(Now()) - Year(UserProfile.dob) <= '] = 44;
                } elseif ($age_key == 3) {
                    $new_conditions['Year(Now()) - Year(UserProfile.dob) >= '] = 45;
                    $new_conditions['Year(Now()) - Year(UserProfile.dob) <= '] = 54;
                } elseif ($age_key == 4) {
                    $new_conditions['Year(Now()) - Year(UserProfile.dob) >= '] = 55;
                } elseif ($age_key == 0) {
                    $new_conditions['UserProfile.dob'] = NULL;
                }
                $age_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 1
                ));
                $chart_pie_age_data[$user_ages] = number_format(($age_count/$total_users) *100, 2);
            }
        }
        $this->set('chart_pie_education_data', $chart_pie_education_data);
        $this->set('chart_pie_relationship_data', $chart_pie_relationship_data);
        $this->set('chart_pie_employment_data', $chart_pie_employment_data);
        $this->set('chart_pie_income_data', $chart_pie_income_data);
        $this->set('chart_pie_gender_data', $chart_pie_gender_data);
        $this->set('chart_pie_age_data', $chart_pie_age_data);
    }
    public function chart_merchant_transactions()
    {
        if ($this->Auth->user('user_type_id') != ConstUserTypes::Merchant) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->initChart();
        $this->loadModel('Transaction');
        $this->loadModel('UserCashWithdrawal');
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $conditions = array();
        $transaction_model_datas = array();
        $transaction_model_datas['Total Item Amount Received from Admin'] = array(
            'display' => __l('Amount Received from Admin') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::ReceivedItemPurchasedAmount,
                'Transaction.user_id' => $this->Auth->user('id')
            ) ,
        );
        $transaction_model_datas['Total Withdrawn Amount by Merchant'] = array(
            'display' => __l('Withdrawn Amount') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::UserCashWithdrawalAmount,
                'Transaction.user_id' => $this->Auth->user('id')
            ) ,
        );
        $transaction_model_datas['Total Amount Paid To Charity'] = array(
            'display' => __l('Paid To Charity') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::AmountTakenForCharity,
                'Transaction.user_id' => $this->Auth->user('id')
            ) ,
        );
        if ($this->isAllowed($this->Auth->user('user_type_id'))) {
            $transaction_model_datas['Total Deposited (Add to wallet) Amount'] = array(
                'display' => __l('Deposited Amount') . ' (' . Configure::read('site.currency') . ')',
                'model' => 'Transaction',
                'conditions' => array(
                    'Transaction.transaction_type_id' => ConstTransactionTypes::AddedToWallet,
                    'Transaction.user_id' => $this->Auth->user('id')
                ) ,
            );
        }
        $transaction_model_datas['Total Pending withdrwaw request'] = array(
            'display' => __l('Pending withdrwaw request') ,
            'model' => 'UserCashWithdrawal',
            'conditions' => array(
                'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Pending,
                'UserCashWithdrawal.user_id' => $this->Auth->user('id') ,
            ) ,
        );
        $chart_transactions_data = array();
        foreach($this->$select_var as $val) {
            foreach($transaction_model_datas as $model_data) {
                $new_conditions = array();
                if (isset($model_data['model'])) {
                    $modelClass = $model_data['model'];
                } else {
                    $modelClass = 'Transaction';
                }
                foreach($val['conditions'] as $key => $v) {
                    $key = str_replace('#MODEL#', $modelClass, $key);
                    $new_conditions[$key] = $v;
                }
                $new_conditions = array_merge($new_conditions, $model_data['conditions']);
                if ($modelClass == 'Transaction') {
                    $value_count = $this->{$modelClass}->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(Transaction.amount) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else {
                    $value_count = $this->{$modelClass}->find('count', array(
                        'conditions' => $new_conditions,
                        'recursive' => 0
                    ));
                }
                $chart_transactions_data[$val['display']][] = $value_count;
            }
        }
        $this->_setItemOrders($select_var);
        $this->set('chart_transactions_periods', $transaction_model_datas);
        $this->set('chart_transactions_data', $chart_transactions_data);
        $this->set('selectRanges', $this->selectRanges);
    }
    protected function _setLineData($select_var, $model_datas, $models, $model = '', $common_conditions = array())
    {
          if (is_array($models)) {
            foreach($models as $m) {
                $this->loadModel($m);
            }
        } else {
            $this->loadModel($models);
            $model = $models;
        }
        $_data = array();
        foreach($this->$select_var as $val) {
            foreach($model_datas as $model_data) {
                $new_conditions = array();
                foreach($val['conditions'] as $key => $v) {
                    $key = str_replace('#MODEL#', $model, $key);
                    $new_conditions[$key] = $v;
                }
                $new_conditions = array_merge($new_conditions, $model_data['conditions']);
                $new_conditions = array_merge($new_conditions, $common_conditions);
                if (isset($model_data['model'])) {
                    $modelClass = $model_data['model'];
                } else {
                    $modelClass = $model;
                }
                $_data[$val['display']][] = $this->{$modelClass}->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 1
                ));
            }
        }
        return $_data;
    }
	public function admin_chart_stats()
	{		
	}
}
