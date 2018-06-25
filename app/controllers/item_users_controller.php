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
class ItemUsersController extends AppController
{
    public $name = 'ItemUsers';
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'ItemUser.more_action_id',
            'ItemUser.item_name',
            'ItemUser.pass_code',
            'ItemUser.r',
            'ItemUser.id',
            'ItemUser.filter_id',
            'ItemUser.item_id',
            'Item.id',
            'ItemUser.search',
        );
        parent::beforeFilter();
    }
    public function index($item_id = null)
	{
		$this->disableCache();
		$this->_redirectGET2Named(array(
			'pass_code'
		));
		$db = $this->ItemUser->getDataSource();
		$conditions = array();
		$item_pass_conditions = array();
		if (!empty($this->request->params['named']['item_id'])) {
			$item_id = $this->request->params['named']['item_id'];
		}
		$this->set('item_id', $item_id);
		$merchant = $this->ItemUser->Item->User->Merchant->find('first', array(
			'conditions' => array(
				'Merchant.user_id' => $this->Auth->User('id')
			) ,
			'fields' => array(
				'Merchant.id'
			) ,
			'recursive' => -1
		));
		// Available tab count //
		$available_count_conditions = $item_conditions = array();
		if (!empty($item_id) && ($this->Auth->user('user_type_id') != ConstUserTypes::User)) {
			$item_conditions['ItemUser.item_id'] = $item_id;
		}
		if ($this->Auth->user('user_type_id') != ConstUserTypes::User && !empty($item_id)) {
			$item_conditions['ItemUser.item_id'] = $item_id;
		}
		if ($this->Auth->user('user_type_id') != ConstUserTypes::Admin) {
			if ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant && (!empty($this->request->params['named']['item_id']) || !empty($item_id))) {
				$available_count_conditions['OR'] = array(
					'Item.user_id' => $this->Auth->user('id') ,
					'Item.merchant_id' => $merchant['Merchant']['id']
				);
			} else {
				$available_count_conditions['ItemUser.user_id'] = $this->Auth->user('id');
			}
		}
		$available_count_conditions['ItemUser.quantity >'] = $db->expression('ItemUser.item_user_pass_count');
		$available_count_conditions['ItemUser.item_user_pass_count'] = 0;
		$available_count_conditions['ItemUser.is_canceled'] = 0;
		$available_count_conditions['ItemUser.is_paid'] = 1;
		$available_count_conditions['ItemUser.item_user_pass_count'] = 0;
		$available_count_conditions['Item.item_status_id'] = array(
			ConstItemStatus::Closed,
			ConstItemStatus::Tipped,
			ConstItemStatus::PaidToMerchant
		);
		$availableCount = $this->ItemUser->find('all', array(
			'conditions' => array_merge($item_conditions, $available_count_conditions) ,
			'fields' => array(
				'count(ItemUser.id) as available_count'
			) ,
			'contain' => array(
				'Item',
			) ,
			'group' => array(
				'ItemUser.user_id'
			) ,
			'recursive' => 1
		));
		$this->set('available', !empty($availableCount[0][0]['available_count']) ? $availableCount[0][0]['available_count'] : '0');
		// Used tab count //
		$used = $this->ItemUser->find('all', array(
			'conditions' => array_merge(array(
				'ItemUser.item_user_pass_count !=' => 0,
				'ItemUser.is_canceled' => 0,
				'ItemUser.user_id' => $this->Auth->user('id'),
			) , $item_conditions) ,
			'fields' => array(
				'count(ItemUser.id) as used_count'
			) ,
			'recursive' => 1
		));
		$this->set('used', !empty($used[0][0]['used_count']) ? $used[0][0]['used_count'] : '0');
		unset($conditions['ItemUser.is_repaid']); // NEED TO REMOVE/CHECK
		// Refund tab count //
		$refund = $this->ItemUser->find('all', array(
			'conditions' => array_merge(array(
				'ItemUser.is_repaid' => 1,
				'ItemUser.user_id' => $this->Auth->user('id'),
				'ItemUser.is_canceled' => 0
			) , $item_conditions) ,
			'fields' => array(
				'count(ItemUser.id) as refund_count'
			) ,
			'recursive' => 1
		));
		$this->set('refund', !empty($refund[0][0]['refund_count']) ? $refund[0][0]['refund_count'] : '0');
		// Expired tab count //
		$expired_conditions = array(); // Quick Fix //
		$expired_conditions['ItemUser.is_repaid'] = 0;
		$expired_conditions['ItemUser.is_canceled'] = 0;
		$expired_conditions['ItemUser.user_id'] = $this->Auth->user('id');
		if (!empty($item_id) && ($this->Auth->user('user_type_id') != ConstUserTypes::User)) {
			$expired_conditions['ItemUser.item_id'] = $item_id;
			$expired_conditions['Item.item_status_id'] = ConstItemStatus::Expired;
		} else {
			$expired_conditions['Item.item_status_id'] = ConstItemStatus::Expired;
		}
		$expired = $this->ItemUser->find('all', array(
			'conditions' => $expired_conditions,
			'fields' => array(
				'count(ItemUser.id) as expired_count'
			) ,
			'recursive' => 1
		));
		$this->set('expired', !empty($expired[0][0]['expired_count']) ? $expired[0][0]['expired_count'] : 0);
		// Open tab count //
		$open = $this->ItemUser->find('all', array(
			'conditions' => array_merge(array(
				'Item.item_status_id' => ConstItemStatus::Open,
				'ItemUser.is_canceled' => 0,
				'ItemUser.user_id' => $this->Auth->user('id'),
			) , $item_conditions) ,
			'fields' => array(
				'count(ItemUser.id) as open_count'
			) ,
			'recursive' => 1
		));
		$this->set('open', !empty($open[0][0]['open_count']) ? $open[0][0]['open_count'] : '0');
		// Canceled tab count //
		$canceled = $this->ItemUser->find('all', array(
			'conditions' => array_merge(array(
				'ItemUser.is_canceled' => 1,
				'ItemUser.user_id' => $this->Auth->user('id'),
			) , $item_conditions) ,
			'fields' => array(
				'count(ItemUser.id) as canceled_count'
			) ,
			'recursive' => 1
		));
		$this->set('canceled', !empty($canceled[0][0]['canceled_count']) ? $canceled[0][0]['canceled_count'] : '0');
		// All tab count //
		if (!empty($item_id)) {
			$all_conditions['ItemUser.item_id'] = $item_id;
		} else {
			$all_conditions['ItemUser.user_id'] = $this->Auth->User('id');
		}
		$all = $this->ItemUser->find('all', array(
			'conditions' => $all_conditions,
			'fields' => array(
				'Sum(ItemUser.quantity) as all_count'
			) ,
			'recursive' => -1
		));
		//gift tab count
		$all_conditions['ItemUser.quantity >'] = 1;
		$gift = $this->ItemUser->find('all', array(
			'conditions' => $all_conditions,
			'fields' => array(
				'count(ItemUser.id) as gift_count'
			) ,
			'recursive' => -1
		));
		$this->set('all_items', !empty($all[0][0]['all_count']) ? $all[0][0]['all_count'] : '0');
		$this->set('gift_items', !empty($gift[0][0]['gift_count']) ? $gift[0][0]['gift_count'] : '0');
		$show_pass_code = 0;
		if (!empty($this->request->data['ItemUser']['item_id'])) {
			$this->request->params['named']['item_id'] = $this->request->data['ItemUser']['item_id'];
		}
		$conditions = array();
		if (!empty($this->request->params['named']['item_id'])) {
			$item_id = $this->request->params['named']['item_id'];
			$conditions['ItemUser.is_canceled'] = 0;
		}
		if (!empty($this->request->params['named']['sub_item_id'])) {
			$sub_item_id = $this->request->params['named']['sub_item_id'];
		}
		$this->pageTitle = __l('Item Orders/Passes');
		$pass_find_id = array();
		if (!empty($this->request->data['ItemUser']['pass_code'])) {
			$get_item_user_id = $this->ItemUser->ItemUserPass->find('first', array(
				'conditions' => array(
					'OR' => array(
						'ItemUserPass.pass_code like' => $this->request->data['ItemUser']['pass_code'] . '%',
						'ItemUserPass.unique_pass_code like' => $this->request->data['ItemUser']['pass_code'] . '%',
					)
				) ,
				'recursive' => -1
			));
			$conditions['ItemUser.id'] = $get_item_user_id['ItemUserPass']['item_user_id'];
			$pass_find_id[] = $get_item_user_id['ItemUserPass']['id'];
			$this->pageTitle.= ' - ' . $this->request->data['ItemUser']['pass_code'];
		}
		if (!empty($this->request->data['ItemUser']['type'])) {
			$this->request->params['named']['type'] = $this->request->data['ItemUser']['type'];
		}
		if ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant && !empty($item_id)) {
			if (!empty($sub_item_id)) {
				$conditions['ItemUser.sub_item_id'] = $sub_item_id;
			}
			$conditions['ItemUser.item_id'] = $item_id;
			$conditions['ItemUser.is_repaid'] = 0;
			$item = $this->ItemUser->Item->find('first', array(
				'conditions' => array(
					'Item.id' => $item_id
				) ,
				'recursive' => -1
			));
			if (empty($this->request->params['named']['type'])) {
				$conditions['ItemUser.is_canceled'] = 0;
			}
			if (!empty($item) && ($item['Item']['item_status_id'] == ConstItemStatus::Tipped || $item['Item']['item_status_id'] == ConstItemStatus::Closed || $item['Item']['item_status_id'] == ConstItemStatus::PaidToMerchant)) {
				$show_pass_code = 1;
				if (!empty($this->request->data['ItemUser']['item_user_view'])) {
					$this->request->params['named']['item_user_view'] = $this->request->data['ItemUser']['item_user_view'];
				}
			}
			$conditions['Item.id'] = $this->request->params['named']['item_id'];
			$this->pageTitle = '';
		} else if (isset($this->request->params['named']['item_id'])) {
			$this->request->data['ItemUser']['item_id'] = $this->request->params['named']['item_id'];
			if (!empty($item) && ($item['Item']['item_status_id'] == ConstItemStatus::Tipped || $item['Item']['item_status_id'] == ConstItemStatus::Closed || $item['Item']['item_status_id'] == ConstItemStatus::PaidToMerchant)) {
				$show_pass_code = 1;
				if (!empty($this->request->data['ItemUser']['item_user_view'])) {
					$this->request->params['named']['item_user_view'] = $this->request->data['ItemUser']['item_user_view'];
				}
			}
			$conditions['Item.id'] = $this->request->params['named']['item_id'];
		} elseif ($this->ItemUser->User->isAllowed($this->Auth->user('user_type_id'))) {
			if ($this->Auth->user('user_type_id') != ConstUserTypes::Admin) {
				$conditions['ItemUser.user_id'] = $this->Auth->user('id');
			}
			if (empty($item_id)) { // Checked for admin viewing his grouponpro in my stuffs tab
				$conditions['ItemUser.user_id'] = $this->Auth->user('id');
			}
		} else {
			throw new NotFoundException(__l('Invalid request'));
		}
		$merchant = $this->ItemUser->Item->User->Merchant->find('first', array(
			'conditions' => array(
				'Merchant.user_id' => $this->Auth->User('id')
			) ,
			'fields' => array(
				'Merchant.id'
			) ,
			'recursive' => -1
		));
		if (!empty($item_id) && ($this->Auth->user('user_type_id') != ConstUserTypes::User)) {
			if (!empty($sub_item_id)) {
				$conditions['ItemUser.sub_item_id'] = $sub_item_id;
			}
			$conditions['ItemUser.item_id'] = $item_id;
		} else {
			$conditions['ItemUser.user_id'] = $this->Auth->user('id');
		}
		$user = $this->ItemUser->Item->User->Merchant->find('first', array(
			'conditions' => array(
				'Merchant.user_id' => $this->Auth->User('id')
			) ,
			'fields' => array(
				'Merchant.id'
			) ,
			'recursive' => -1
		));
		$this->set('user', $user);
		$this->set('pass_find_id', $pass_find_id); //Used for search //
		$item_user_count = !empty($item_users['0']['Item']['item_user_count']) ? $item_users['0']['Item']['item_user_count'] : '0';
		$this->set('item_user_count', $item_user_count);
		$moreActions = $this->ItemUser->moreActions;
		if (!empty($this->request->params['named']['item_user_view']) && $this->request->params['named']['item_user_view'] == 'pass') {
			$moreActions = array(
				ConstMoreAction::Used => __l('Used') ,
				ConstMoreAction::NotUsed => __l('Not Used')
			);
		}
		$this->set(compact('moreActions'));
		if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'available') {
			$this->pageTitle.= __l('Available');
			if ($this->Auth->user('user_type_id') != ConstUserTypes::Admin) {
				if ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant && !empty($this->request->params['named']['item_id'])) {
					$conditions['OR'] = array(
						'Item.user_id' => $this->Auth->user('id') ,
						'Item.merchant_id' => $merchant['Merchant']['id']
					);
				} else {
					$conditions['ItemUser.user_id'] = $this->Auth->user('id');
				}
			}
			$conditions['ItemUser.quantity >'] = $db->expression('ItemUser.item_user_pass_count');
			$conditions['Item.item_status_id'] = array(
				ConstItemStatus::Closed,
				ConstItemStatus::Tipped,
				ConstItemStatus::PaidToMerchant
			);
			$conditions['ItemUser.is_canceled'] = 0;
			$conditions['ItemUser.is_paid'] = 1;
			$item_pass_conditions['ItemUserPass.is_used'] = 0;
		} elseif (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'used') {
			$this->pageTitle.= __l('Used');
			$conditions['ItemUser.item_user_pass_count !='] = 0;
			$conditions['ItemUser.is_canceled'] = 0;
			$item_pass_conditions['ItemUserPass.is_used'] = 1;
		} elseif (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'refund') {
			$this->pageTitle.= __l('Refund');
			$conditions['ItemUser.is_repaid'] = 1;
			$conditions['ItemUser.is_canceled'] = 0;
		} elseif (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'expired') {
			$this->pageTitle.= __l('Expired');
			$conditions = array(); // Quick Fix //
			$conditions['ItemUser.is_repaid'] = 0;
			$conditions['ItemUser.is_canceled'] = 0;
			if (!empty($item_id) && ($this->Auth->user('user_type_id') != ConstUserTypes::User)) {
				$conditions['ItemUser.item_id'] = $item_id;
				$conditions['Item.item_status_id'] = ConstItemStatus::Expired;
			} else {
				$conditions['Item.item_status_id'] = ConstItemStatus::Expired;
			}
		} elseif (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'open') {
			$this->pageTitle.= __l('Pending');
			$conditions['Item.item_status_id'] = ConstItemStatus::Open;
			$conditions['ItemUser.is_canceled'] = 0;
		} elseif (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'canceled') {
			$this->pageTitle.= __l('Canceled');
			$conditions['ItemUser.is_canceled'] = 1;
		} elseif (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'all') {
			if ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) {
				$this->pageTitle = sprintf(__l('My %s Passes') , Configure::read('site.name'));
			} else {
				$this->pageTitle = sprintf(__l('My %s Items') , Configure::read('site.name'));
			}
			if(!empty($this->request->params['named']['gift_user']))
			{
				$conditions['ItemUser.quantity >'] =1;
			}
			unset($conditions['ItemUser.is_canceled']);
			unset($conditions['ItemUser.is_repaid']);
		}
		if (!empty($this->request->params['named']['type'])) {
			$this->request->data['ItemUser']['type'] = $this->request->params['named']['type'];
		}
		if(!empty($this->request->params['named']['item_type']) && $this->request->params['named']['item_type']=="current_item_view")
		{
			unset($conditions['ItemUser.user_id']); 
		}
		$this->paginate = array(
			'conditions' => $conditions,
			'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.user_type_id',
                            'User.username',
                            'User.id',
                            'User.user_comment_count',
                        ),
                        'UserProfile',
                        'UserAvatar',
                    ) ,
					'Item' => array(
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
						)
					) ,
					'ItemStatus' => array(
						'fields' => array(
							'ItemStatus.name',
						)
					) ,
					'Attachment',
					'fields' => array(
						'Item.name',
						'Item.slug',
						'Item.end_date',
						'Item.event_date',
						'Item.item_status_id',
						'Item.merchant_id',
						'Item.item_user_count',
						'Item.price',
						'Item.be_next_increase_price',
						'Item.is_be_next',
						'Item.max_limit',
					)
				) ,
				'CharitiesItemUser' => array(
					'Charity' => array(
						'fields' => array(
							'Charity.id',
							'Charity.name',
							'Charity.url'
						)
					) ,
					'fields' => array(
						'CharitiesItemUser.amount',
						'CharitiesItemUser.site_commission_amount',
						'CharitiesItemUser.seller_commission_amount'
					)
				) ,
				'ItemUserPass' => array(
					'conditions' => $item_pass_conditions
				),
				'City',
			) ,
			'order' => array(
				'ItemUser.created' => 'desc'
			) ,
			'recursive' => 3
		);
		$item_users = $this->paginate();
		$this->set('show_pass_code', $show_pass_code);
		$this->set('itemUsers', $item_users);
		if (!empty($item)) {
			$this->set('item', $item);
		}
		// <-- For iPhone App code
		if ($this->RequestHandler->prefers('json')) {
			if (!empty($item_users)) {
				$total_items = count($item_users);
				for ($i = 0; $i < $total_items; $i++) {
					if (!empty($item_users[$i]['ItemUserPass'])) {
						$total_pass = count($item_users[$i]['ItemUserPass']);
						for ($j = 0; $j < $total_pass; $j++) {
							if (Configure::read('barcode.is_barcode_enabled') == 1) {
								$symbology_code_url = '';
								if (Configure::read('barcode.symbology') == 'qr') {
									$parsed_url = parse_url(Router::url('/', true));
									$qr_mobile_site_url = str_ireplace($parsed_url['host'], 'm.' . $parsed_url['host'], Router::url(array(
										'controller' => 'item_user_passes',
										'action' => 'check_qr',
										$item_users[$i]['ItemUserPass'][$j]['pass_code'],
										$item_users[$i]['ItemUserPass'][$j]['unique_pass_code'],
										'admin' => false
									) , true));
									$symbology_code_url = 'http://chart.apis.google.com/chart?cht=qr&chs=140x140&chl=' . $qr_mobile_site_url;
								} elseif (Configure::read('barcode.symbology') == 'c39') {
									$symbology_code_url = Router::url(array(
										'controller' => 'items',
										'action' => 'barcode',
										$item_users[$i]['Item']['id']
									) , true);
								}
								if (!empty($symbology_code_url)) {
									$symbology_code_url = '<p class="pass-code-img"><img class="img" src="' . $symbology_code_url . '" /></p>';
								}
								$item_users[$i]['ItemUserPass'][$j]['symbology_code_url'] = $symbology_code_url;
								$item_users[$i]['ItemUserPass'][$j]['use_pass_url'] = Router::url(array(
									'controller' => 'item_user_passes',
									'action' => 'update_status',
									$item_users[$i]['ItemUser']['id'],
									'pass_id' => $item_users[$i]['ItemUserPass'][$j]['id'],
									'is_used',
									'admin' => false
								) , true);
							} else {
								$item_users[$i]['ItemUserPass'][$j]['symbology_code_url'] = '';
								$item_users[$i]['ItemUserPass'][$j]['use_pass_url'] = Router::url(array(
									'controller' => 'item_user_passes',
									'action' => 'update_status',
									$item_users[$i]['ItemUser']['id'],
									'pass_id' => $item_users[$i]['ItemUserPass'][$j]['id'],
									'is_used',
									'admin' => false
								) , true);
							}
						}
					}
					$this->ItemUser->Item->saveiPhoneAppThumb($item_users[$i]['Item']['Attachment']);
					$image_options = array(
						'dimension' => 'iphone_big_thumb',
						'class' => '',
						'alt' => $item_users[$i]['Item']['name'],
						'title' => $item_users[$i]['Item']['name'],
						'type' => 'jpg'
					);
					$iphone_big_thumb = $this->ItemUser->Item->getImageUrl('Item', $item_users[$i]['Item']['Attachment'][0], $image_options);
					$item_users[$i]['Item']['iphone_big_thumb'] = $iphone_big_thumb;
					$image_options = array(
						'dimension' => 'iphone_small_thumb',
						'class' => '',
						'alt' => $item_users[$i]['Item']['name'],
						'title' => $item_users[$i]['Item']['name'],
						'type' => 'jpg'
					);
					$iphone_small_thumb = $this->ItemUser->Item->getImageUrl('Item', $item_users[$i]['Item']['Attachment'][0], $image_options);
					$item_users[$i]['Item']['iphone_small_thumb'] = $iphone_small_thumb;
				}
			}
			$this->view = 'Json';
			$this->set('json', (empty($this->viewVars['iphone_response'])) ? $item_users : $this->viewVars['iphone_response']);
		}
		$this->set('pageTitle', $this->pageTitle);
		// For iPhone App code -->
		if (!empty($this->request->params['named']['item_id'])) {
			$item = $this->ItemUser->Item->_getItemInfo($this->request->params['named']['item_id']);
			$this->set('item_info', $item);
		}
        if(!empty($this->request->params['named']['item_type'])){
            if($this->request->params['named']['item_type']!="default"){
            if($this->request->params['named']['item_type']=="current_item_view"){
				$this->autoRender=false;
                $this->render('item_user_index');
            }
            else{
                $this->render('restaurent_user_index');
            }
            }
        }
		if($this->Auth->user('user_type_id')==ConstUserTypes::Merchant or $this->Auth->user('user_type_id')==ConstUserTypes::Admin)
		{
			$this->render('index_merchant');
		}
		$show_tab = 1;
		if ((!empty($this->request->params['named']['item_user_view']) && $this->request->params['named']['item_user_view'] == 'pass') || (!empty($this->request->data['ItemUser']['item_user_view']) && $this->request->data['ItemUser']['item_user_view'] == 'pass')) {
			$show_tab = 0; // Hiding 'tabs' for 
		}		
		$this->set('show_tab', $show_tab);
	}
    public function update()
    {
        $this->autoRender = false;
        if (!empty($this->request->data['ItemUser'])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $ItemUserIds = array();
            $itemuserpass_code = array();
            if (!empty($this->request->data['ItemUserPass']) && $actionid) {
                foreach($this->request->data['ItemUserPass'] as $itemuserpass_id => $code) {
                    if (!empty($code['unique_pass_code'])) {
                        $itemuserpass_code[$itemuserpass_id] = $code['unique_pass_code'];
                    }
                }
                if (!empty($itemuserpass_code)) {
                    if ($actionid == ConstMoreAction::Used) {
                        foreach($itemuserpass_code as $id => $code) {
							if(isset($code) && !empty($code)) {
								$conditions = array();
								$conditions['ItemUserPass.id'] = $id;
								$conditions['ItemUserPass.unique_pass_code'] = $code;
								$conditions['ItemUserPass.is_used'] = 0;
								$get_item_user_passes = $this->ItemUser->ItemUserPass->find('first', array(
									'conditions' => $conditions,
									'recursive' => -1
								));
								if (!empty($get_item_user_passes)) {
									$ItemUserPasses = array();
									$ItemUserPasses['id'] = $get_item_user_passes['ItemUserPass']['id'];
									$ItemUserPasses['is_used'] = '1';
									$this->ItemUser->ItemUserPass->save($ItemUserPasses);
									$ItemPasses['pass_code'] = $get_item_user_passes['ItemUserPass']['pass_code'];
									$this->ItemUser->Item->ItemPass->updateAll(array(
										'ItemPass.is_used' => '1'
									) , array(
										'ItemPass.pass_code' => $get_item_user_passes['ItemUserPass']['pass_code']
									));
								}
							}	
                        }
                    } else if ($actionid == ConstMoreAction::NotUsed) {
                        foreach($itemuserpass_code as $id => $code) {
                            $conditions = array();
                            $conditions['ItemUserPass.id'] = $id;
                            $conditions['ItemUserPass.unique_pass_code'] = $code;
                            $conditions['ItemUserPass.is_used'] = 1;
                            $get_item_user_passes = $this->ItemUser->ItemUserPass->find('first', array(
                                'conditions' => $conditions,
                                'recursive' => -1
                            ));
                            if (!empty($get_item_user_passes)) {
                                $ItemUserPasses = array();
                                $ItemUserPasses['id'] = $get_item_user_passes['ItemUserPass']['id'];
                                $ItemUserPasses['is_used'] = '0';
                                $this->ItemUser->ItemUserPass->save($ItemUserPasses);
                                $ItemPasses['pass_code'] = $get_item_user_passes['ItemUserPass']['pass_code'];
									$this->ItemUser->Item->ItemPass->updateAll(array(
										'ItemPass.is_used' => '0'
									) , array(
										'ItemPass.pass_code' => $get_item_user_passes['ItemUserPass']['pass_code']
								));
                            }
                        }
                    }else if ($actionid == ConstMoreAction::Delete) {
                    foreach($this->request->data['ItemUser'] as $itemuser_id => $is_checked) {
                        if ($is_checked['id']) {
                            $ItemUserIds[] = $itemuser_id;
                        }
                    }
                    unset($ItemUserIds['0']);
                    foreach($ItemUserIds as $ItemUserId) {
                        $this->ItemUser->ItemUserPass->deleteAll(array(
                            'ItemUserPass.item_user_id' => $ItemUserId
                        ));
                        $this->ItemUser->delete($ItemUserId);
                    }
                    $this->Session->setFlash(__l('Item Pass deleted') , 'default', null, 'success');
                }
                }
            }
        }
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect(Router::url('/', true) . $r);
        } else {
            $this->redirect($r);
        }
    }
    public function view($id = null)
    {
        $pass_conditions = array();
        if (!empty($this->request->params['named']['pass_id'])) {
            $pass_conditions['ItemUserPass.id'] = $this->request->params['named']['pass_id'];
        }
        if (!empty($this->request->params['named']['filter_id'])) {
            $db = $this->ItemUser->getDataSource();
            if (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'available') {
                $conditions['ItemUser.quantity >'] = $db->expression('ItemUser.item_user_pass_count');
                $pass_conditions['ItemUserPass.is_used'] = 0;
            } elseif (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'used') {
                $pass_conditions['ItemUserPass.is_used'] = 1;
                $conditions['ItemUser.item_user_pass_count !='] = 0;
            } elseif (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'expired') {
                $conditions['ItemUser.is_repaid'] = 0;
            } elseif (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'open') {
                $conditions['Item.item_status_id'] = ConstItemStatus::Open;
            } elseif (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'refunded') {
                $conditions['Item.item_status_id'] = ConstItemStatus::Refunded;
                $conditions['ItemUser.is_repaid'] = 1;
            }
        }
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) {
            $item = $this->ItemUser->find('first', array(
                'conditions' => array(
                    'ItemUser.id' => $id
                ) ,
                'contain' => array(
                    'Item'
                ) ,
                'recursive' => 0
            ));
            $merchant = $this->ItemUser->Item->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.user_id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
        }
        $conditions['ItemUser.id'] = $id;
        if ($this->Auth->user('user_type_id') != ConstUserTypes::Admin) {
            $conditions['ItemUser.user_id'] = $this->Auth->user('id');
            if (!empty($merchant['Merchant']['user_id']) && !empty($item['Item']['merchant_id']) && ($merchant['Merchant']['id'] == $item['Item']['merchant_id'])) {
                unset($conditions['OR']);
				unset($conditions['ItemUser.user_id']);
            }
        }
        $ItemUser = $this->ItemUser->find('first', array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.first_name',
                            'UserProfile.last_name',
                        )
                    ) ,
                    'fields' => array(
                        'User.user_type_id',
                        'User.username',
                        'User.id',
                    )
                ) ,
                'ItemUserPass' => array(
                    'conditions' => $pass_conditions
                ) ,
                'Item' => array(
                    'Merchant' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name'
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name'
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name'
                            )
                        )
                    ) ,
                    'fields' => array(
                        'Item.name',
                        'Item.id',
                    ) ,
                )
            ) ,
            'recursive' => 3
        ));
        if (empty($ItemUser)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'print') {
            $this->layout = 'print';
        }
        $this->set('ItemUser', $ItemUser);
    }
    public function user_items($user_id = null)
    {
        if (!empty($this->request->params['named']['user_id'])) {
            $conditions = array(
                'ItemUser.user_id' => $this->request->params['named']['user_id'],
                'ItemUser.is_repaid' => 0,
            );
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'Item' => array(
                    'Attachment' => array(
                        'fields' => array(
                            'Attachment.id',
                            'Attachment.dir',
                            'Attachment.filename',
                            'Attachment.width',
                            'Attachment.height'
                        )
                    ) ,
                    'Merchant',
                    'ItemCategory',
                ) ,
            )
        );
        $this->ItemUser->recursive = 2;
        $user_items = $this->paginate();
        $this->set('user_items', $user_items);
    }
    public function admin_index()
    {
        $this->disableCache();
        $this->pageTitle = __l('Item Orders/Passes');
        if (!empty($this->request->data['ItemUser']['item_name'])) {
            $this->request->params['named']['item_name'] = $this->request->data['ItemUser']['item_name'];
        }
        if (!empty($this->request->data['ItemUser']['pass_code'])) {
            $this->request->params['named']['pass_code'] = $this->request->data['ItemUser']['pass_code'];
        }
        if (!empty($this->request->data['ItemUser']['filter_id'])) {
            $this->request->params['named']['filter_id'] = $this->request->data['ItemUser']['filter_id'];
        }
        if (!empty($this->request->data['ItemUser']['item_id'])) {
            $this->request->params['named']['item_id'] = $this->request->data['ItemUser']['item_id'];
        }
        $conditions = array();
        $pass_find_id = array();
        $conditions['ItemUser.is_repaid'] = 0;
        $is_show_pass_code = 0;
        $param_string = '';
        if (!empty($this->request->data['ItemUser'])) {
            $param_string.= !empty($this->request->params['named']['filter_id']) ? '/filter_id:' . $this->request->params['named']['filter_id'] : '';
            $param_string.= !empty($this->request->params['named']['item_name']) ? '/item_name:' . $this->request->params['named']['item_name'] : '';
            $param_string.= !empty($this->request->params['named']['pass_code']) ? '/pass_code:' . $this->request->params['named']['pass_code'] : '';
            $param_string.= !empty($this->request->params['named']['item_id']) ? '/item_id:' . $this->request->params['named']['item_id'] : '';
        }
        if (isset($this->request->params['named']['item_name'])) {
            $this->request->data['ItemUser']['item_name'] = $this->request->params['named']['item_name'];
            $conditions['Item.name'] = $this->request->params['named']['item_name'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['item_name']);
        }
        if (!empty($this->request->params['named']['pass_code'])) {
            $this->request->data['ItemUser']['pass_code'] = $this->request->params['named']['pass_code'];
            $get_item_user_id = $this->ItemUser->ItemUserPass->find('first', array(
                'conditions' => array(
                    'OR' => array(
                        'ItemUserPass.pass_code like' => $this->request->data['ItemUser']['pass_code'] . '%',
                        'ItemUserPass.unique_pass_code like' => $this->request->data['ItemUser']['pass_code'] . '%',
                    )
                ) ,
                'recursive' => - 1
            ));
            $conditions['ItemUser.id'] = $get_item_user_id['ItemUserPass']['item_user_id'];
            $pass_find_id[] = $get_item_user_id['ItemUserPass']['id'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['pass_code']);
        }
        if (isset($this->request->params['named']['item_id'])) {
            $conditions['Item.id'] = $this->request->params['named']['item_id'];
            $this->request->data['ItemUser']['item_id'] = $this->request->params['named']['item_id'];
        }
        $db = $this->ItemUser->getDataSource();
        $conditions['ItemUser.is_canceled'] = 0;
        if (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'available') {
			$this->pageTitle.= __l('Available');
            $conditions['ItemUser.quantity >'] = $db->expression('ItemUser.item_user_pass_count');
            $conditions['Item.item_status_id'] = array(
                ConstItemStatus::Closed,
                ConstItemStatus::Tipped,
                ConstItemStatus::PaidToMerchant
            );
        } elseif (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'used') {
			$this->pageTitle.= __l(' - Used');
            $conditions['ItemUser.item_user_pass_count !='] = 0;
        } elseif (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'expired') {
			$this->pageTitle.= __l(' - Expired');
            $conditions['ItemUser.is_repaid'] = 0;
        } elseif (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'open') {
			$this->pageTitle.= __l(' - Pending');
            $conditions['Item.item_status_id'] = ConstItemStatus::Open;
        } elseif (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'canceled') {
			$this->pageTitle.= __l(' - Canceled');
            $conditions['ItemUser.is_canceled'] = 1;
        } elseif (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'refunded') {
			$this->pageTitle.= __l(' - Refund');
            $conditions['Item.item_status_id'] = ConstItemStatus::Refunded;
            $conditions['ItemUser.is_repaid'] = 1;
        } elseif (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'all') {
            unset($conditions['ItemUser.is_canceled']);
            unset($conditions['ItemUser.is_repaid']);
        } else {
            unset($conditions['ItemUser.is_repaid']);
        }
        if (!empty($this->request->params['named']['item_name'])) {
            $this->request->data['ItemUser']['item_name'] = $this->request->params['named']['item_name'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['item_name']);
            $conditions['Item.name'] = $this->request->data['ItemUser']['item_name'];
        }
        if (!empty($this->request->params['named']['filter_id'])) {
            $this->request->data['ItemUser']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        // Citywise admin filter //
        $city_filter_id = $this->Session->read('city_filter_id');
        if (!empty($city_filter_id)) {
            $item_cities = $this->ItemUser->Item->City->find('first', array(
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
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                    'fields' => array(
                        'User.user_type_id',
                        'User.username',
                        'User.id',
                        'User.fb_user_id'
                    )
                ) ,
                'CharitiesItemUser' => array(
                    'Charity' => array(
                        'fields' => array(
                            'Charity.id',
                            'Charity.name',
                            'Charity.url'
                        )
                    ) ,
                    'fields' => array(
                        'CharitiesItemUser.amount',
                        'CharitiesItemUser.site_commission_amount',
                        'CharitiesItemUser.seller_commission_amount'
                    )
                ) ,
                'ItemUserPass',
                'City',
                'Item' => array(
                    'fields' => array(
                        'Item.name',
                        'Item.slug',
                        'Item.price',
                        'Item.be_next_increase_price',
                    ) ,
                    'Attachment' => array(
                        'fields' => array(
                            'Attachment.id',
                            'Attachment.dir',
                            'Attachment.filename',
                            'Attachment.mimetype',
                            'Attachment.filesize',
                            'Attachment.height',
                            'Attachment.width',
                        )
                    )
                )
            ) ,
            'order' => array(
                'ItemUser.id' => 'desc'
            ) ,
            'recursive' => 2
        );
        if (!empty($this->request->params['named']['item_id'])) {
            $check_item = $this->ItemUser->Item->find('first', array(
                'conditions' => array(
                    'Item.id' => $this->request->params['named']['item_id'],
                    'Item.item_status_id' => array(
                        ConstItemStatus::Tipped,
                        ConstItemStatus::Closed,
                        ConstItemStatus::PaidToMerchant,
                    ) ,
                ) ,
                'fields' => array(
                    'Item.id',
                    'Item.name',
                    'Item.item_status_id',
                ) ,
                'recursive' => - 1
            ));
            if (!empty($check_item)) {
                $is_show_pass_code = 1;
            }
        }
        $this->set('itemUsers', $this->paginate());
        // Citywise admin filter //
        $count_conditions = array();
        $available_conditions = array();
        if (!empty($city_filter_id)) {
            $item_cities = $this->ItemUser->Item->City->find('first', array(
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
            $count_conditions['Item.id'] = $city_item_id;
        }
         if (!empty($this->request->params['named']['item_id'])) {
            $count_conditions['Item.id'] = $this->request->params['named']['item_id'];
         }
        //	Configure::write('debug',1);
        $available_conditions['ItemUser.quantity >'] = $db->expression('ItemUser.item_user_pass_count');
        $available_conditions['ItemUser.is_repaid'] = 0;
        $available_conditions['ItemUser.is_canceled'] = 0;
        $available_conditions['Item.item_status_id'] = array(
            ConstItemStatus::Closed,
            ConstItemStatus::Tipped,
            ConstItemStatus::PaidToMerchant
        );
        $available = $this->ItemUser->find('all', array(
            'conditions' => array_merge($available_conditions, $count_conditions) ,
            'fields' => array(
                'SUM(ItemUser.quantity - ItemUser.item_user_pass_count) as available_count'
            ) ,
            'recursive' => 1
        ));
        $this->set('available', !empty($available[0][0]['available_count']) ? $available[0][0]['available_count'] : '0');
        $used = $this->ItemUser->find('all', array(
            'conditions' => array_merge(array(
                'ItemUser.item_user_pass_count !=' => 0,
                'ItemUser.is_canceled' => 0,
                'ItemUser.is_repaid' => 0
            ) , $count_conditions) ,
            'fields' => array(
                'SUM(ItemUser.item_user_pass_count) as used_count'
            ) ,
            'recursive' => 1
        ));
        $this->set('used', !empty($used[0][0]['used_count']) ? $used[0][0]['used_count'] : '0');
        $expired = $this->ItemUser->find('all', array(
            'conditions' => array_merge(array(
                'ItemUser.is_repaid' => 0,
                'ItemUser.is_canceled' => 0,
                 'Item.item_status_id' => ConstItemStatus::Expired
            ) , $count_conditions) ,
            'fields' => array(
                'SUM(ItemUser.quantity) as expired_count',
            ) ,
            'recursive' => 1
        ));
        $this->set('expired', !empty($expired[0][0]['expired_count']) ? $expired[0][0]['expired_count'] : '0');
        $open = $this->ItemUser->find('all', array(
            'conditions' => array_merge(array(
                'Item.item_status_id' => ConstItemStatus::Open,
                'ItemUser.is_repaid' => 0,
                'ItemUser.is_canceled' => 0,
            ) , $count_conditions) ,
            'fields' => array(
                'SUM(ItemUser.quantity) as open_count'
            ) ,
            'recursive' => 1
        ));
        $this->set('open', !empty($open[0][0]['open_count']) ? $open[0][0]['open_count'] : '0');
        $canceled = $this->ItemUser->find('all', array(
            'conditions' => array_merge(array(
                'ItemUser.is_canceled' => 1
            ) , $count_conditions) ,
            'fields' => array(
                'SUM(ItemUser.quantity) as canceled_count'
            ) ,
            'recursive' => 1
        ));
        $this->set('canceled', !empty($canceled[0][0]['canceled_count']) ? $canceled[0][0]['canceled_count'] : '0');
        $refund = $this->ItemUser->find('all', array(
            'conditions' => array_merge(array(
                'Item.item_status_id' => ConstItemStatus::Refunded,
                'ItemUser.is_repaid' => 1
            ) , $count_conditions) ,
            'fields' => array(
                'SUM(ItemUser.quantity) as refund_count'
            ) ,
            'recursive' => 1
        ));
        $this->set('refunded', !empty($refund[0][0]['refund_count']) ? $refund[0][0]['refund_count'] : '0');
        $all = $this->ItemUser->find('all', array(
            'conditions' => $count_conditions,
            'fields' => array(
                'SUM(ItemUser.quantity) as all_count'
            ) ,
            'recursive' => 1
        ));
        $this->set('all', !empty($all[0][0]['all_count']) ? $all[0][0]['all_count'] : '0');
        $this->set('pass_find_id', $pass_find_id);
        $this->set('is_show_pass_code', $is_show_pass_code);
        $moreActions = $this->ItemUser->moreActions;
        if (!empty($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == 'available')) {
            unset($moreActions[ConstMoreAction::NotUsed]); // NotUsed options will not show for 'available' filter
            
        } elseif (!empty($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == 'used')) {
            unset($moreActions[ConstMoreAction::Used]); // NotUsed options will not show for 'available' filter
            
        }
        $this->set(compact('moreActions'));
        $this->set('param_string', $param_string);
        $this->set('pageTitle', $this->pageTitle);
    }
    public function admin_update()
    {
        $this->autoRender = false;
        if (!empty($this->request->data['ItemUser'])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $ItemUserIds = array();
            foreach($this->request->data['ItemUser'] as $itemuser_id => $is_checked) {
                if ($is_checked['id']) {
                    $ItemUserIds[] = $itemuser_id;
                }
            }
            if ($actionid && !empty($ItemUserIds)) {
                if ($actionid == ConstMoreAction::Used) {
                    unset($ItemUserIds['0']);
                    foreach($ItemUserIds as $ItemUserId) {
                        $get_item_user_passes = $this->ItemUser->ItemUserPass->find('all', array(
                            'conditions' => array(
                                'ItemUserPass.item_user_id' => $ItemUserId
                            ) ,
                            'recursive' => -1
                        ));
                        foreach($get_item_user_passes as $get_item_user_pass) {
                            if (!empty($get_item_user_pass)) {
                                $ItemUserPasses['id'] = $get_item_user_pass['ItemUserPass']['id'];
                                $ItemUserPasses['is_used'] = '1';
                                $this->ItemUser->ItemUserPass->save($ItemUserPasses);
                            }
                        }
                    }
                    $this->Session->setFlash(__l('Checked item pass status has been changed') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::NotUsed) {
                    foreach($ItemUserIds as $ItemUserId) {
                        $get_item_user_passes = $this->ItemUser->ItemUserPass->find('all', array(
                            'conditions' => array(
                                'ItemUserPass.item_user_id' => $ItemUserId
                            ) ,
                            'recursive' => -1
                        ));
                        foreach($get_item_user_passes as $get_item_user_pass) {
                            if (!empty($get_item_user_pass)) {
                                $ItemUserPasses['id'] = $get_item_user_pass['ItemUserPass']['id'];
                                $ItemUserPasses['is_used'] = '0';
                                $this->ItemUser->ItemUserPass->save($ItemUserPasses);
                            }
                        }
                    }
                    $this->Session->setFlash(__l('Checked item pass status has been changed') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Delete) {
                    unset($ItemUserIds['0']);
                    foreach($ItemUserIds as $ItemUserId) {
                        $this->ItemUser->ItemUserPass->deleteAll(array(
                            'ItemUserPass.item_user_id' => $ItemUserId
                        ));
                        $this->ItemUser->delete($ItemUserId);
                    }
                    $this->Session->setFlash(__l('Item Pass deleted') , 'default', null, 'success');
                }
            }
        }
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect(Router::url('/', true) . $r);
        } else {
            $this->redirect($r);
        }
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ItemUser->delete($id)) {
            $this->ItemUser->ItemUserPass->deleteAll(array(
                'ItemUserPass.item_user_id' => $id
            ));
            $this->Session->setFlash(__l('Item Pass deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function update_status($item_user_id = null, $field = 'is_used')
    {
        $action = 1;
        $this->autoRender = false;
        if (!empty($item_user_id)) {
            $ItemUser = $this->ItemUser->find('first', array(
                'conditions' => array(
                    'ItemUser.id' => $item_user_id
                ) ,
                'contain' => array(
                    'Item',
                    'ItemUserPass',
                ) ,
                'recursive' => 2
            ));
        }
        $user = $this->ItemUser->Item->User->Merchant->find('first', array(
            'conditions' => array(
                'Merchant.user_id' => $this->Auth->User('id')
            ) ,
            'fields' => array(
                'Merchant.id'
            ) ,
            'recursive' => -1
        ));
        if ($ItemUser['ItemUser']['quantity'] > $ItemUser['ItemUser']['item_user_pass_count']) {
            $status = 1;
        } elseif ($ItemUser['ItemUser']['quantity'] == $ItemUser['ItemUser']['item_user_pass_count']) {
            $status = 0;
            if (($ItemUser['Item']['merchant_id'] != $user['Merchant']['id']) && !empty($user['Merchant']['id']) && $user['User']['user_type_id'] != ConstUserTypes::Merchant) {
                $action = 0;
            }
        } else {
            $status = 1;
        }
        if (!empty($action)) {
            $ItemUserPass = array();
            foreach($ItemUser['ItemUserPass'] as $item_user_pass) {
                $ItemUserPass['id'] = $item_user_pass['id'];
                $ItemUserPass['is_used'] = $status;
                $this->ItemUser->ItemUserPass->save($ItemUserPass);
            }
        }
        echo $action;
    }
    public function cancel_item($id = null)
    {
        if (empty($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $itemuser = $this->ItemUser->find('first', array(
            'conditions' => array(
                'ItemUser.id' => $id,
                'ItemUser.user_id' => $this->Auth->user('id') ,
                'Item.item_status_id' => ConstItemStatus::Open,
                'ItemUser.is_canceled' => 0,
            ) ,
            'contain' => array(
                'Item',
                'User',
                'PaypalDocaptureLog',
                'AuthorizenetDocaptureLog',
                'PaypalTransactionLog'
            ) ,
            'recursive' => 0
        ));
        if (empty($itemuser)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $response = $this->ItemUser->Item->_refundItemAmountForCacel($itemuser);
        // SubItem: Resetting the actual Item array //
        if (!empty($temp_item)) {
            $itemuser['Item'] = $temp_item;
        }
        if (!is_array($response)) {
            $_data['ItemUser']['id'] = $itemuser['ItemUser']['id'];
            $_data['ItemUser']['is_canceled'] = 1;
            $this->ItemUser->save($_data);
            // after save fields //
            $data_for_aftersave = array();
            $data_for_aftersave['item_id'] = $itemuser['Item']['id'];
            $data_for_aftersave['item_user_id'] = $itemuser['ItemUser']['id'];
            $data_for_aftersave['user_id'] = $itemuser['ItemUser']['user_id'];
            $data_for_aftersave['merchant_id'] = $itemuser['Item']['merchant_id'];
            $data_for_aftersave['payment_gateway_id'] = $itemuser['ItemUser']['payment_gateway_id'];
            $this->ItemUser->Item->UpdateAll(array(
                'Item.item_user_count' => $itemuser['Item']['item_user_count']-$itemuser['ItemUser']['quantity']
            ) , array(
                'Item.id' => $itemuser['Item']['id']
            ));
            $this->ItemUser->Item->_updateAfterPurchase($data_for_aftersave, 'cancel');
            $this->Session->setFlash(__l('Item canceled successfully.') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(sprintf(__l('Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.') , $response['message']) , 'default', null, 'error');
        }
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'my_stuff',
            '#My_Purchases'
        ));
    }
    public function admin_referral_commission()
    {
        $this->pageTitle = __l('Referral Commission');
        $conditions = array();
        $conditions['NOT']['ItemUser.referred_by_user_id'] = 0;
        $conditions['ItemUser.is_referral_commission_sent'] = 1;
        $this->ItemUser->recursive = 1;
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'ItemUser.referred_by_user_id',
                'ItemUser.referral_commission_amount',
                'ItemUser.created',
                'ItemUser.referral_commission_type',
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.username',
                    )
                ) ,
                'Item' => array(
                    'fields' => array(
                        'Item.name',
                        'Item.slug'
                    )
                ) ,
            )
        );
        $this->set('referred_users_earned', $this->paginate());
        $this->set('pageTitle', $this->pageTitle);
    }
}
?>