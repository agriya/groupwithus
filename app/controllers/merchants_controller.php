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
class MerchantsController extends AppController
{
    public $name = 'Merchants';
    public $components = array(
        'Email',
    );
    public $helpers = array(
        'Csv',
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'City',
            'State',
            'Merchant.latitude',
            'Merchant.longitude',
            'Merchant.map_zoom_level',
            'UserAvatar.filename',
            'User.id',
            'Merchant.id',
            'Merchant.address1',
            'Merchant.address2',
            'Merchant.country_id',
            'Merchant.name',
            'Merchant.phone',
            'Merchant.url',
            'Merchant.zip',
            'User.UserProfile.paypal_account'
        );
        parent::beforeFilter();
    }
	public function view($slug = null)
    {
        $this->pageTitle = __l('Merchant');
        $allowed_merchant_addresses = array();
        if (is_null($slug)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $conditions['Merchant.slug'] = $slug;
        $merchant = $this->Merchant->find('first', array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.email',
                        'User.user_type_id',
                        'User.username',
                        'User.id',
                        'User.available_balance_amount',
                        'User.is_email_confirmed',
                        'User.is_active'
                    ) ,
                    'UserAvatar',
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
                ) ,
                'Item' => array(
                    'conditions' => array(
                        'Item.item_status_id' => array(
                            ConstItemStatus::Open,
                            ConstItemStatus::Expired,
                            ConstItemStatus::Tipped,
                            ConstItemStatus::Closed,
                            ConstItemStatus::PaidToMerchant
                        )
                    ) ,
                    'fields' => array(
                        'Item.id',
                        'Item.name',
                        'Item.slug',
                        'Item.description'
                    ) ,
                    'limit' => 5
                )
            ) ,
            'recursive' => 2,
        ));
           if ($this->RequestHandler->prefers('kml')) {
            $this->set('merchant', $merchant);
        } else {
            $statistics = array();
            $statistics['referred_users'] = $this->Merchant->User->find('count', array(
                'conditions' => array(
                    'User.referred_by_user_id' => $merchant['Merchant']['user_id']
                )
            ));
            $item_status_conditions = array(
                ConstItemStatus::Open,
                ConstItemStatus::Expired,
                ConstItemStatus::Tipped,
                ConstItemStatus::Closed,
                ConstItemStatus::PaidToMerchant
            );
			$owned = array(
                ConstItemStatus::Open,
                ConstItemStatus::Tipped,
                ConstItemStatus::Closed,
                ConstItemStatus::PaidToMerchant
            );
            $statistics['item_created'] = $this->Merchant->Item->find('count', array(
                'conditions' => array(
                        'Item.merchant_id' => $merchant['Merchant']['id'],
						'Item.item_status_id' => $owned
                )
            ));
            if ($merchant['Merchant']['user_id'] == $this->Auth->user('id')) {
                $item_status_conditions[] = ConstItemStatus::Draft;
                $item_status_conditions[] = ConstItemStatus::PendingApproval;
                $item_status_conditions[] = ConstItemStatus::Refunded;
                $item_status_conditions[] = ConstItemStatus::Canceled;
            }
            $statistics['item_purchased'] = $this->Merchant->User->ItemUser->find('count', array(
                'conditions' => array(
                    'ItemUser.user_id' => $merchant['Merchant']['user_id'],
                    'ItemUser.is_gift' => 0
                )
            ));
            $statistics['user_friends'] = $this->Merchant->User->UserFriend->find('count', array(
                'conditions' => array(
                    'UserFriend.user_id' => $merchant['Merchant']['user_id'],
                    'UserFriend.friend_status_id' => 2,
                    'UserFriend.is_requested' => 0,
                )
            ));
            if (empty($merchant)) {
                throw new NotFoundException(__l('Invalid request'));
            }
			$this->Merchant->MerchantView->create();
			$this->request->data['MerchantView']['merchant_id'] = $merchant['Merchant']['id'];
			$this->request->data['MerchantView']['user_id'] = $this->Auth->user('id');
			$this->request->data['MerchantView']['ip_id'] = $this->Merchant->toSaveIp();
			$this->Merchant->MerchantView->save($this->request->data);
            $this->set('statistics', $statistics);
            $this->pageTitle.= ' - ' . $merchant['Merchant']['name'];
            $this->set('merchant', $merchant);
            $this->request->data['UserComment']['user_id'] = $merchant['User']['id'];
        }
    }
	public function admin_commission($id=null)
	{
		    if (empty($id)) {
                throw new NotFoundException(__l('Invalid request'));
            }
			  $conditions=array();
			  $conditions['Merchant.id']=$id;
			  $merchant = $this->Merchant->find('first', array(
				'conditions' => $conditions,
				'recursive' => -1,
				));
		   if (empty($merchant)) {
                throw new NotFoundException(__l('Invalid request'));
            }
			echo  $merchant['Merchant']['bonus_amount'].'|'.$merchant['Merchant']['commission_percentage'];
			exit;

	}
    public function edit($id = null)
    {
        $this->pageTitle = __l('Edit Merchant');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
		$this->loadModel('Attachment');
		$this->Merchant->User->UserAvatar->Behaviors->attach('ImageUpload', Configure::read('avatar.file'));
        if (!empty($this->request->data)) {
            $user = $this->Merchant->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    ) ,
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.paypal_account',
                            'UserProfile.language_id'
                        )
                    ) ,
                ) ,
                'recursive' => 0
            ));
            if (!empty($user['UserAvatar']['id'])) {
                $this->request->data['UserAvatar']['id'] = $user['UserAvatar']['id'];
            }
            if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                $this->request->data['UserAvatar']['filename']['type'] = get_mime($this->request->data['UserAvatar']['filename']['tmp_name']);
            }
            if (!empty($this->request->data['UserAvatar']['filename']['name']) || (!Configure::read('avatar.file.allowEmpty') && empty($this->request->data['UserAvatar']['id']))) {
                $this->Merchant->User->UserAvatar->set($this->request->data);
            }
            $ini_upload_error = 1;
            if (!empty($this->request->data['UserAvatar']['filename']['error']) && ($this->request->data['UserAvatar']['filename']['error'] == 1)) {
                $ini_upload_error = 0;
            }
            $this->request->data['Merchant']['city_id'] = !empty($this->request->data['City']['id']) ? $this->request->data['City']['id'] : $this->Merchant->City->findOrSaveAndGetId($this->request->data['City']['name']);
            $this->request->data['Merchant']['state_id'] = !empty($this->request->data['State']['id']) ? $this->request->data['State']['id'] : $this->Merchant->State->findOrSaveAndGetId($this->request->data['State']['name']);
            unset($this->Merchant->validate['city_id']);
            unset($this->Merchant->validate['state_id']);
            $this->Merchant->State->set($this->request->data);
            $this->Merchant->City->set($this->request->data);
            $this->Merchant->set($this->request->data['Merchant']);
            unset($this->Merchant->City->validate['City']);
            if ($this->Merchant->validates() && $this->Merchant->State->validates() && $this->Merchant->City->validates() && $this->Merchant->User->UserAvatar->validates() && $ini_upload_error) {
                if ($this->Merchant->save($this->request->data, false)) {
                    if (!empty($this->request->data['UserProfile']['language_id'])) {
                        $this->Merchant->User->UserProfile->updateAll(array(
                            'UserProfile.language_id' => $this->request->data['UserProfile']['language_id']
                        ) , array(
                            'UserProfile.user_id' => $this->Auth->user('id')
                        ));
                    }
                    if ($this->request->data['UserProfile']['language_id'] != $user['UserProfile']['language_id']) {
                        $this->Merchant->User->UserProfile->User->UserLogin->updateUserLanguage();
                    }
                    if (!empty($this->request->data['User']['UserProfile']['paypal_account'])) {
                        $this->Merchant->User->UserProfile->updateAll(array(
                            'UserProfile.paypal_account' => '\'' . $this->request->data['User']['UserProfile']['paypal_account'] . '\'',
                            'UserProfile.language_id' => '\'' . $this->request->data['UserProfile']['language_id'] . '\''
                        ) , array(
                            'UserProfile.user_id' => $this->Auth->user('id')
                        ));
                    }
					if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                        $this->Attachment->create();
                        $this->request->data['UserAvatar']['class'] = 'UserAvatar';
                        $this->request->data['UserAvatar']['foreign_id'] = $this->request->data['User']['id'];
                        $this->Attachment->save($this->request->data['UserAvatar']);
                    }
					$this->Session->setFlash(__l('Merchant has been updated') , 'default', null, 'success');
                    if (!empty($this->request->params['form']['is_iframe_submit'])) {
                        $this->layout = 'ajax';
                    }
                } else {
                    $this->Session->setFlash(__l('Merchant could not be updated. Please, try again.') , 'default', null, 'error');
                }
                if ($this->Merchant->User->isAllowed($this->Auth->user('user_type_id'))) {
                    $ajax_url = Router::url(array(
                        'controller' => 'users',
                        'action' => 'my_stuff',
                    ) , true);
                    $success_msg = 'redirect*' . $ajax_url;
                    echo $success_msg;
                    exit;
                }
            } else {
                $this->Session->setFlash(__l('Merchant could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            unset($this->Merchant->City->validate['City']);
            $this->request->data = $this->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.id = ' => $id,
                ) ,
                'contain' => array(
                    'User' => array(
                        'UserAvatar' => array(
                            'fields' => array(
                                'UserAvatar.id',
                                'UserAvatar.dir',
                                'UserAvatar.filename',
                                'UserAvatar.width',
                                'UserAvatar.height'
                            )
                        ) ,
                        'UserProfile' => array(
                            'fields' => array(
                                'UserProfile.paypal_account',
                                'UserProfile.language_id'
                            )
                        ) ,
                        'fields' => array(
                            'User.user_type_id',
                            'User.username',
                            'User.id',
                            'User.available_balance_amount',
                            'User.email',
                        )
                    ) ,
                    'City' => array(
                        'fields' => array(
                            'City.name'
                        )
                    ) ,
                    'State' => array(
                        'fields' => array(
                            'State.name'
                        )
                    )
                ) ,
                'recursive' => 2
            ));
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            if (!empty($this->request->data['Merchant']['City'])) {
                $this->request->data['City']['name'] = $this->request->data['Merchant']['City']['name'];
            }
            if (!empty($this->request->data['Merchant']['State']['name'])) {
                $this->request->data['State']['name'] = $this->request->data['Merchant']['State']['name'];
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Merchant']['name'];
        $cities = $this->Merchant->City->find('list', array(
            'conditions' => array(
                'City.is_approved =' => 1
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
        $states = $this->Merchant->State->find('list');
        $countries = $this->Merchant->Country->find('list');
        //get languages
        $languageLists = $this->Merchant->User->UserProfile->Language->Translation->find('all', array(
            'conditions' => array(
                'Language.id !=' => 0
            ) ,
            'fields' => array(
                'DISTINCT(Translation.language_id)',
                'Language.name',
                'Language.id'
            ) ,
            'order' => array(
                'Language.name' => 'ASC'
            )
        ));
        $languages = array();
        if (!empty($languageLists)) {
            foreach($languageLists as $languageList) {
                $languages[$languageList['Language']['id']] = $languageList['Language']['name'];
            }
        }
        //end
        $this->set(compact('cities', 'states', 'countries', 'languages'));
    }
    public function delete($id = null)
    {
         if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $merchant = $this->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.id = ' => $id,
                ) ,
                'filds'=>array(
                    'Merchant.user_id'
                )));
        if ($this->Merchant->delete($id)) {
            $this->Merchant->User->delete($merchant['Merchant']['user_id']);
            $this->Session->setFlash(__l('Merchant deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_index()
    {
      $this->disableCache();
     $this->_redirectGET2Named(array(
               'q',
               'main_filter_id',
               'filter_id'
        ));
        
        $this->pageTitle = __l('Merchants');
        if (!empty($this->request->data['Merchant']['q'])) {
            $this->request->params['named']['q'] = $this->request->data['Merchant']['q'];
            $this->pageTitle.= __l(' - Search - ') . $this->request->params['named']['q'];
        }
        if (!empty($this->request->data['Merchant']['main_filter_id'])) {
            $this->request->params['named']['filter_id'] = $this->request->data['Merchant']['main_filter_id'];
        }
        $this->set('online', $this->Merchant->find('count', array(
            'conditions' => array(
                'Merchant.is_online_account = ' => 1,
            ) ,
            'recursive' => - 1
        )));
        // total approved users list
        $this->set('offline', $this->Merchant->find('count', array(
            'conditions' => array(
                'Merchant.is_online_account = ' => 0,
            ) ,
            'recursive' => - 1
        )));
        // total openid users list
        $this->set('all', $this->Merchant->find('count', array(
            'recursive' => - 1
        )));
        $conditions = $count_conditions = array();
        if (!empty($this->request->params['named']['main_filter_id'])) {
			if ($this->request->params['named']['main_filter_id'] == ConstMoreAction::AffiliateUser) {
                $conditions['User.is_affiliate_user'] = 1;
                $this->pageTitle.= __l(' - Affiliate');
            } elseif ($this->request->params['named']['main_filter_id'] == ConstMoreAction::OpenID) {
                $conditions['User.is_openid_register'] = 1;
                $this->pageTitle.= __l(' - Registered through OpenID ');
            } else if ($this->request->params['named']['main_filter_id'] == ConstMoreAction::FaceBook) {
                $conditions['User.is_facebook_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Facebook ');
            } else if ($this->request->params['named']['main_filter_id'] == ConstMoreAction::Twitter) {
                $conditions['User.is_twitter_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Twitter ');
            } else if ($this->request->params['named']['main_filter_id'] == ConstMoreAction::Gmail) {
                $conditions['User.is_gmail_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Gmail ');
            } else if ($this->request->params['named']['main_filter_id'] == ConstMoreAction::Yahoo) {
                $conditions['User.is_yahoo_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Yahoo ');
            } 
        }
        if (!empty($this->request->params['named']['main_filter_id'])) {
            if ($this->request->params['named']['main_filter_id'] == ConstMoreAction::Online) {
                $conditions['Merchant.is_online_account'] = 1;
                $this->pageTitle.= __l(' - Online Account');
            } else if ($this->request->params['named']['main_filter_id'] == ConstMoreAction::Offline) {
                $conditions['Merchant.is_online_account'] = 0;
                $this->pageTitle.= __l(' - Offline Account');
            }
            $this->request->data['Merchant']['main_filter_id'] = $this->request->params['named']['main_filter_id'];
        }
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['User.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['User.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            }
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Merchant.created) <= '] = 0;
            $this->pageTitle.= __l(' - Registered today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Merchant.created) <= '] = 7;
            $this->pageTitle.= __l(' - Registered in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Merchant.created) <= '] = 30;
            $this->pageTitle.= __l(' - Registered in this month');
        }
        if ($this->RequestHandler->prefers('csv')) {
            Configure::write('debug', 0);
            $this->set('merchant', $this);
            $this->set('conditions', $conditions);
            if (isset($this->request->data['Merchant']['q'])) {
                $this->set('q', $this->request->data['Merchant']['q']);
            }
            $this->set('contain', $contain);
        } else {
            $this->paginate = array(
                'conditions' => array(
                    $conditions,
                ) ,
                'contain' => array(
                    'User' => array(
						'UserProfile' => array(
							'Country' => array(
								'fields' => array(
									'Country.name',
									'Country.iso2',
								) 
							)
						) ,
                        'UserAvatar',
						'LastLoginIp' => array(
							'City' => array(
								'fields' => array(
									'City.name',								
								) 
							) ,
							'State' => array(
								'fields' => array(
									'State.name',								
								) 
							) ,
							'Country' => array(
								'fields' => array(
									'Country.name',
									'Country.iso2',								
								) 
							) ,
							'Timezone' => array(
								'fields' => array(
									'Timezone.name',								
								)
							) ,
							'fields' => array(
								'LastLoginIp.ip',
								'LastLoginIp.host',
								'LastLoginIp.latitude',
								'LastLoginIp.longitude'
							 ) 						
						) ,
						'Ip' => array(
							'City' => array(
								'fields' => array(
									'City.name',								
								) 
							) ,
							'State' => array(
								'fields' => array(
									'State.name',								
								) 
							) ,
							'Country' => array(
								'fields' => array(
									'Country.name',
									'Country.iso2',								
								) 
							) ,
							'Timezone' => array(
								'fields' => array(
									'Timezone.name',								
								) 
							) ,
							'fields' => array(
								'Ip.ip',
								'Ip.latitude',
								'Ip.longitude'
							 )
						) ,
                    )
                ) ,
                'order' => array(
                    'Merchant.id' => 'desc'
                ) ,
                'recursive' => 3,
            );
            if (!empty($this->request->params['named']['q'])) {
                $this->paginate = array_merge($this->paginate, array(
                    'search' => $this->request->params['named']['q']
                ));
                $this->request->data['Merchant']['q'] = $this->request->params['named']['q'];
            }
            if (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::Offline) {
                     $moreActions[ConstMoreAction::DeductAmountFromWallet] = __l('Set As Paid');
            } else {
                $moreActions = $this->Merchant->moreActions;
            }
            $this->set(compact('moreActions'));
            $this->set('merchants', $this->paginate());
            $this->set('pageTitle', $this->pageTitle);
            // total approved users list
            $this->set('active', $this->Merchant->find('count', array(
                'conditions' => array(
                    'User.is_active' => 1,
                ) ,
                'recursive' => 1
            )));
            // total approved users list
            $this->set('inactive', $this->Merchant->find('count', array(
                'conditions' => array(
                    'User.is_active' => 0,
                ) ,
                'recursive' => 1
            )));
            $this->set('affiliate_user_count', $this->Merchant->User->find('count', array(
                'conditions' => array(
                    'User.is_affiliate_user' => 1,
					'User.user_type_id' => ConstUserTypes::Merchant,
                ) ,
                'recursive' => - 1
            )));
        }
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Merchant');
        $this->loadModel('EmailTemplate');
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['City']['name'])) {
                $this->request->data['Merchant']['city_id'] = !empty($this->request->data['City']['id']) ? $this->request->data['City']['id'] : $this->Merchant->City->findOrSaveAndGetId($this->request->data['City']['name']);
            }
            if (!empty($this->request->data['State']['name'])) {
                $this->request->data['Merchant']['state_id'] = !empty($this->request->data['State']['id']) ? $this->request->data['State']['id'] : $this->Merchant->State->findOrSaveAndGetId($this->request->data['State']['name']);
            }
            $this->Merchant->create();
            $this->Merchant->set($this->request->data);
            $this->Merchant->User->set($this->request->data);
            $this->Merchant->State->set($this->request->data);
            $this->Merchant->City->set($this->request->data);
            unset($this->Merchant->City->validate['City']);
            if ($this->Merchant->validates() & $this->Merchant->User->validates() & $this->Merchant->City->validates() & $this->Merchant->State->validates()) {
				if (empty($this->request->data['Merchant']['user_id'])) {
                    $this->request->data['User']['user_type_id'] = ConstUserTypes::Merchant;
                    $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['passwd']);
                    if ($this->request->data['Merchant']['is_online_account']) {
                        $this->request->data['User']['is_email_confirmed'] = '1';
                        $this->request->data['User']['is_active'] = '1';
                    } else {
                        $this->request->data['User']['is_email_confirmed'] = '0';
                        $this->request->data['User']['is_active'] = '0';
                    }
                    if ($this->Merchant->User->save($this->request->data)) {
                        $user_id = $this->Merchant->User->getLastInsertId();
                        $this->request->data['Merchant']['user_id'] = $user_id;
                        $this->request->data['UserProfile']['user_id'] = $user_id;
                        $this->request->data['UserProfile']['city_id'] = $this->request->data['Merchant']['city_id'];
                        $this->request->data['UserProfile']['state_id'] = $this->request->data['Merchant']['state_id'];
                        $this->request->data['UserProfile']['country_id'] = $this->request->data['Merchant']['country_id'];
                        $this->request->data['UserProfile']['paypal_account'] = $this->request->data['User']['UserProfile']['paypal_account'];
                        $this->Merchant->User->UserProfile->create();
                        $this->Merchant->User->UserProfile->save($this->request->data);
                    }
                }
                if ($this->Merchant->save($this->request->data)) {
					if (!empty($this->request->data['Merchant']['is_online_account'])) {
                        $email = $this->EmailTemplate->selectTemplate('Admin User Add');
                        $emailFindReplace = array(
                            '##FROM_EMAIL##' => $this->Merchant->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
                            '##USERNAME##' => $this->request->data['User']['username'],
                            '##LOGINLABEL##' => ucfirst(Configure::read('user.using_to_login')) ,
                            '##USEDTOLOGIN##' => $this->request->data['User'][Configure::read('user.using_to_login') ],
                            '##SITE_NAME##' => Configure::read('site.name') ,
                            '##PASSWORD##' => $this->request->data['User']['passwd'],
                            '##SITE_URL##' => Router::url('/', true) ,
                            '##CONTACT_URL##' => Router::url(array(
                                'controller' => 'contacts',
                                'action' => 'add',
                                'city' => $this->request->params['named']['city'],
                                'admin' => false
                            ) , true) ,
                            '##SITE_LOGO##' => Router::url(array(
                                'controller' => 'img',
                                'action' => 'logo-email.png',
                                'admin' => false
                            ) , true) ,
                        );
                        $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
                        $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
                        $this->Email->to = $this->request->data['User']['email'];
                        $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                        $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                        $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                    }
					$userprofile['UserProfile']['user_id'] = $this->Merchant->getLastInsertId();
					$this->Merchant->User->UserProfile->save($userprofile);
                    $this->Session->setFlash(__l('Merchant has been added') , 'default', null, 'success');
                    $this->redirect(array(
                        'action' => 'index'
                    ));
                } else {
                    $this->Session->setFlash(__l('Merchant could not be added. Please, try again.') , 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(__l('Merchant could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        unset($this->Merchant->City->validate['City']);
        $countries = $this->Merchant->Country->find('list');
        $this->set(compact('countries'));
        unset($this->request->data['User']['passwd']);
        unset($this->request->data['User']['confirm_password']);
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Merchant');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->loadModel('Attachment');
        $this->Merchant->User->UserAvatar->Behaviors->attach('ImageUpload', Configure::read('avatar.file'));
        $id = (!empty($this->request->data['Merchant']['id'])) ? $this->request->data['Merchant']['id'] : $id;
        $merchant = $this->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.id ' => $id,
                ) ,
                'contain' => array(
                    'User' => array(
                        'UserAvatar' => array(
                            'fields' => array(
                                'UserAvatar.id',
                                'UserAvatar.dir',
                                'UserAvatar.filename',
                                'UserAvatar.width',
                                'UserAvatar.height'
                            )
                        ) ,
                        'UserProfile' => array(
                            'fields' => array(
                                'UserProfile.first_name',
                                'UserProfile.last_name',
                                'UserProfile.middle_name',
                                'UserProfile.gender_id',
                                'UserProfile.about_me',
                                'UserProfile.city_id',
                                'UserProfile.dob',
                                'UserProfile.language_id',
                                'UserProfile.paypal_account'
                            ) ,
                        ) ,
                        'fields' => array(
                        'User.email',
                        'User.user_type_id',
                        'User.username',
                        'User.id',
                    )
                    ) ,
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
                ) ,
                'recursive' => 2
            ));
              if (!empty($this->request->data)) {
                if (!empty($merchant['User']['UserAvatar']['id'])) {
                $this->request->data['UserAvatar']['id'] = $merchant['User']['UserAvatar']['id'];
                       }
                if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                $this->request->data['UserAvatar']['filename']['type'] = get_mime($this->request->data['UserAvatar']['filename']['tmp_name']);
            }
            if (!empty($this->request->data['UserAvatar']['filename']['name']) || (!Configure::read('avatar.file.allowEmpty') && empty($this->request->data['UserAvatar']['id']))) {
               $this->Merchant->User->UserAvatar->set($this->request->data['UserAvatar']);
                   }
           $ini_upload_error = 1;
            if (!empty($this->request->data['UserAvatar']['filename']['error']) && ($this->request->data['UserAvatar']['filename']['error'] == 1)) {
                $ini_upload_error = 0;
            }
            $this->request->data['Merchant']['city_id'] = !empty($this->request->data['City']['id']) ? $this->request->data['City']['id'] : $this->Merchant->City->findOrSaveAndGetId($this->request->data['City']['name']);
            $this->request->data['Merchant']['state_id'] = !empty($this->request->data['State']['id']) ? $this->request->data['State']['id'] : $this->Merchant->State->findOrSaveAndGetId($this->request->data['State']['name']);
            $this->Merchant->set($this->request->data);
            $this->Merchant->State->set($this->request->data);
            $this->Merchant->City->set($this->request->data);
            $this->Merchant->User->set($this->request->data);
            unset($this->Merchant->City->validate['City']);
			if ($merchant['User']['email'] == $this->request->data['User']['email']) {
                unset($this->Merchant->User->validate['email']['rule3']);
            }
            if ($this->Merchant->validates() & $this->Merchant->City->validates() & $this->Merchant->State->validates() & $this->Merchant->User->validates()) {
                if ($this->Merchant->save($this->request->data)) {
                    $merchant = $this->Merchant->find('first', array(
                        'fields' => array(
                            'Merchant.user_id'
                        ) ,
                        'recursive' => - 1,
                    ));
					if ($this->request->data['Merchant']['is_online_account']) {
                        $this->request->data['User']['is_email_confirmed'] = '1';
                        $this->request->data['User']['is_active'] = '1';
                    } else {
                        $this->request->data['User']['is_email_confirmed'] = '0';
                        $this->request->data['User']['is_active'] = '0';
                    }
                    $this->request->data['User']['id'] = $merchant['Merchant']['user_id'];
                    $this->Merchant->User->save($this->request->data);
					$this->Merchant->User->UserProfile->updateAll(array(
                        'UserProfile.paypal_account' => '\'' . $this->request->data['User']['UserProfile']['paypal_account'] . '\'',
                        'UserProfile.city_id' => '\'' . $this->request->data['Merchant']['city_id'] . '\'',
                        'UserProfile.state_id' => '\'' . $this->request->data['Merchant']['state_id'] . '\'',
                        'UserProfile.country_id' => '\'' . $this->request->data['Merchant']['country_id'] . '\'',
                    ) , array(
                        'UserProfile.user_id' => $merchant['Merchant']['user_id']
                    ));
                     $this->Merchant->User->UserAvatar->set($this->request->data['UserAvatar']['filename']);
                      	if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                        $this->Attachment->create();
                        $this->request->data['UserAvatar']['class'] = 'UserAvatar';
                        $this->request->data['UserAvatar']['foreign_id'] = $this->request->data['User']['id'];
                        $this->Attachment->save($this->request->data['UserAvatar']);
                    }
                    $this->Session->setFlash(__l('Merchant has been updated') , 'default', null, 'success');
                    $this->redirect(array(
                        'action' => 'index'
                    ));
                } else {
                    $this->Session->setFlash(__l('Merchant could not be updated. Please, try again.') , 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(__l('Merchant could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.id ' => $id,
                ) ,
                'contain' => array(
                    'User' => array(
                        'UserAvatar' => array(
                            'fields' => array(
                                'UserAvatar.id',
                                'UserAvatar.dir',
                                'UserAvatar.filename',
                                'UserAvatar.width',
                                'UserAvatar.height'
                            )
                        ) ,
                        'UserProfile' => array(
                            'fields' => array(
                                'UserProfile.first_name',
                                'UserProfile.last_name',
                                'UserProfile.middle_name',
                                'UserProfile.gender_id',
                                'UserProfile.about_me',
                                'UserProfile.city_id',
                                'UserProfile.dob',
                                'UserProfile.language_id',
                                'UserProfile.paypal_account'
                            ) ,
                        ) ,
                    ) ,
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
                ) ,
                'recursive' => 2
            ));
                     if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        unset($this->Merchant->City->validate['City']);
        $this->pageTitle.= ' - ' . $this->request->data['Merchant']['name'];
        $countries = $this->Merchant->Country->find('list');
        $this->set(compact('countries'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $merchant = $this->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.id = ' => $id,
                ) ,
                'filds'=>array(
                    'Merchant.user_id'
                )));
        if ($this->Merchant->delete($id)) {
            $this->Merchant->User->delete($merchant['Merchant']['user_id']);
            $this->Session->setFlash(__l('Merchant deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function _sendAdminActionMail($merchant_id, $email_template)
    {
        $this->loadModel('EmailTemplate');
        $merchant = $this->Merchant->find('first', array(
            'conditions' => array(
                'Merchant.id' => $merchant_id
            ) ,
            'fields' => array(
                'Merchant.id',
                'Merchant.name',
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                    )
                )
            ) ,
            'recursive' => 1
        ));
        if (!empty($merchant['User']['email'])) {
            $email = $this->EmailTemplate->selectTemplate($email_template);
            $emailFindReplace = array(
                '##SITE_URL##' => Router::url('/', true) ,
                '##USERNAME##' => $merchant['User']['username'],
                '##SITE_NAME##' => Configure::read('site.name') ,
                '##FROM_EMAIL##' => $this->Merchant->User->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
                '##CONTACT_URL##' => Router::url(array(
                    'controller' => 'contacts',
                    'action' => 'add',
                    'city' => $this->request->params['named']['city'],
                    'admin' => false
                ) , true) ,
                '##SITE_LOGO##' => Router::url(array(
                    'controller' => 'img',
                    'action' => 'blue-theme',
                    'logo-email.png',
                    'admin' => false
                ) , true) ,
            );
            $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
            $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
            $this->Email->to = $this->Merchant->User->formatToAddress($merchant);
            $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
            $this->Email->subject = strtr($email['subject'], $emailFindReplace);
            $this->Email->send(strtr($email['email_content'], $emailFindReplace));
        }
    }
    public function admin_deductamount($merchants_list = null)
    {
        if (empty($merchants_list)) {
            $merchants_list = $this->Session->read('merchants_list.data');
        }
        if (!empty($merchants_list)) {
            $merchants = $this->Merchant->find('all', array(
                'conditions' => array(
                    'Merchant.id' => $merchants_list
                ) ,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.user_type_id',
                            'User.username',
                            'User.id',
                            'User.available_balance_amount'
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            $this->set('merchants', $merchants);
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            foreach($this->request->data['Merchant'] as $merchant_id => $merchant) {
                $get_merchant = $this->Merchant->find('first', array(
                    'conditions' => array(
                        'Merchant.id' => $merchant_id
                    ) ,
                    'contain' => array(
                        'User' => array(
                            'fields' => array(
                                'User.user_type_id',
                                'User.username',
                                'User.id',
                                'User.available_balance_amount'
                            )
                        )
                    ) ,
                    'recursive' => 0
                ));
                if ($this->request->data['Merchant'][$merchant_id]['amount'] > $get_merchant['User']['available_balance_amount']) {
                    $this->Merchant->validationErrors[$merchant_id]['amount'] = __l('Should be less than available balance amount');
                }
                if (empty($merchant['amount'])) {
                    $this->Merchant->validationErrors[$merchant_id]['amount'] = __l('Required');
                }
            }
            if (empty($this->Merchant->validationErrors)) {
                $transactions = array();
                $transactions['Transaction']['foreign_id'] = $this->Auth->user('id');
                foreach($this->request->data['Merchant'] as $merchant_id => $merchant) {
                    $transactions['Transaction']['user_id'] = $merchant['user_id'];
                    $transactions['Transaction']['class'] = 'SecondUser';
                    $transactions['Transaction']['amount'] = $merchant['amount'];
                    $transactions['Transaction']['description'] = $merchant['description'];
                    $transactions['Transaction']['transaction_type_id'] = ConstTransactionTypes::DeductedAmountForOfflineMerchant;
                    $this->Merchant->User->Transaction->log($transactions);
                    $this->Merchant->User->updateAll(array(
                        'User.available_balance_amount' => 'User.available_balance_amount -' . $merchant['amount'],
                    ) , array(
                        'User.id' => $merchant['user_id']
                    ));
                }
                $this->Session->delete('merchants_list');
                $this->Session->setFlash(__l('Amount deducted for the selected merchants') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'merchants',
                    'action' => 'index',
                    'main_filter_id' => ConstMoreAction::Offline,
                    'admin' => true
                ));
            } else {
                $this->Session->setFlash(__l('Amount could not be deducted for the selected merchants. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    function dashboard()
    {
        if (($this->Auth->user('user_type_id')) == ConstUserTypes::Merchant) {
            $this->loadModel('Item');
            $this->loadModel('ItemUser');
            $this->loadModel('Merchant');
            $this->loadModel('UserCashWithdrawal');
            $this->loadModel('Transaction');
            $this->loadModel('ItemUserPass');
            $this->pageTitle = __l('Dashboard');
            $periods = array(
                'day' => array(
                    'display' => __l('Today') ,
                    'conditions' => array(
                        'TO_DAYS(NOW()) - TO_DAYS(created) <= ' => 0,
                    )
                ) ,
                'week' => array(
                    'display' => __l('This week') ,
                    'conditions' => array(
                        'TO_DAYS(NOW()) - TO_DAYS(created) <= ' => 7,
                    )
                ) ,
                'month' => array(
                    'display' => __l('This month') ,
                    'conditions' => array(
                        'TO_DAYS(NOW()) - TO_DAYS(created) <= ' => 30,
                    )
                ) ,
                'total' => array(
                    'display' => __l('Total') ,
                    'conditions' => array()
                )
            );
            $merchant_id = $this->User->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.user_id' => $this->Auth->user('id')
                ) ,
                'fields' => array(
                    'Merchant.id',
                    'Merchant.slug'
                ) ,
                'recursive' => 0
            ));
            $models[] = array(
                'Item' => array(
                    'display' => __l('Items') ,
                    'link' => array(
                        'controller' => 'items',
                        'action' => 'index'
                    ) ,
                    'rowspan' => 11
                )
            );
            $models[] = array(
                'Item' => array(
                    'display' => __l('Draft') ,
                    'link' => array(
                        'controller' => 'items',
                        'action' => 'index',
                        'filter_id' => ConstItemStatus::Draft,
                        'merchant' => $merchant_id['Merchant']['slug']
                    ) ,
                    'conditions' => array(
                        'Item.item_status_id' => ConstItemStatus::Draft,
                        'Item.merchant_id' => $merchant_id['Merchant']['id'],
                    ) ,
                    'alias' => 'ItemDraft',
                    'isSub' => 'Item',
					'class' => 'draft-item-highlights'
                )
            );
            $models[] = array(
                'Item' => array(
                    'display' => __l('Pending Approval') ,
                    'link' => array(
                        'controller' => 'items',
                        'action' => 'index',
                        'filter_id' => ConstItemStatus::PendingApproval,
                        'merchant' => $merchant_id['Merchant']['slug']
                    ) ,
                    'conditions' => array(
                        'Item.item_status_id' => ConstItemStatus::PendingApproval,
                        'Item.merchant_id' => $merchant_id['Merchant']['id'],
                    ) ,
                    'alias' => 'ItemPendingApproval',
                    'isSub' => 'Item',
					'class' => 'pending-item-highlights'
                )
            );
            $models[] = array(
                'Item' => array(
                    'display' => __l('Open') ,
                    'link' => array(
                        'controller' => 'items',
                        'action' => 'index',
                        'filter_id' => ConstItemStatus::Open,
                        'merchant' => $merchant_id['Merchant']['slug']
                    ) ,
                    'conditions' => array(
                        'Item.item_status_id' => ConstItemStatus::Open,
                        'Item.merchant_id' => $merchant_id['Merchant']['id'],
                    ) ,
                    'alias' => 'ItemOpen',
                    'isSub' => 'Item',
					'class' => 'open-item-highlights'
                )
            );
            $models[] = array(
                'Item' => array(
                    'display' => __l('Tipped') ,
                    'link' => array(
                        'controller' => 'items',
                        'action' => 'index',
                        'filter_id' => ConstItemStatus::Tipped,
                        'merchant' => $merchant_id['Merchant']['slug']
                    ) ,
                    'conditions' => array(
                        'Item.item_status_id' => ConstItemStatus::Tipped,
                        'Item.merchant_id' => $merchant_id['Merchant']['id'],
                    ) ,
                    'alias' => 'ItemTipped',
                    'isSub' => 'Item',
					'class' => 'tipped-item-highlights'
                )
            );
            $models[] = array(
                'Item' => array(
                    'display' => __l('Closed') ,
                    'link' => array(
                        'controller' => 'items',
                        'action' => 'index',
                        'filter_id' => ConstItemStatus::Closed,
                        'merchant' => $merchant_id['Merchant']['slug']
                    ) ,
                    'conditions' => array(
                        'Item.item_status_id' => ConstItemStatus::Closed,
                        'Item.merchant_id' => $merchant_id['Merchant']['id'],
                    ) ,
                    'alias' => 'ItemClosed',
                    'isSub' => 'Item',
					'class' => 'closed-item-highlights'
                )
            );
            $models[] = array(
                'Item' => array(
                    'display' => __l('Paid To Merchant') ,
                    'link' => array(
                        'controller' => 'items',
                        'action' => 'index',
                        'filter_id' => ConstItemStatus::PaidToMerchant,
                        'merchant' => $merchant_id['Merchant']['slug']
                    ) ,
                    'conditions' => array(
                        'Item.item_status_id' => ConstItemStatus::PaidToMerchant,
                        'Item.merchant_id' => $merchant_id['Merchant']['id'],
                    ) ,
                    'alias' => 'ItemPaidToMerchant',
                    'isSub' => 'Item',
					'class' => 'paidtomerchant-item-highlights'
                )
            );
            $models[] = array(
                'Item' => array(
                    'display' => __l('Refunded') ,
                    'link' => array(
                        'controller' => 'items',
                        'action' => 'index',
                        'filter_id' => ConstItemStatus::Refunded,
                        'merchant' => $merchant_id['Merchant']['slug']
                    ) ,
                    'conditions' => array(
                        'Item.item_status_id' => ConstItemStatus::Refunded,
                        'Item.merchant_id' => $merchant_id['Merchant']['id'],
                    ) ,
                    'alias' => 'ItemRefunded',
                    'isSub' => 'Item'
                )
            );
            $models[] = array(
                'Item' => array(
                    'display' => __l('Rejected') ,
                    'link' => array(
                        'controller' => 'items',
                        'action' => 'index',
                        'filter_id' => ConstItemStatus::Rejected,
                        'merchant' => $merchant_id['Merchant']['slug']
                    ) ,
                    'conditions' => array(
                        'Item.item_status_id' => ConstItemStatus::Rejected,
                        'Item.merchant_id' => $merchant_id['Merchant']['id'],
                    ) ,
                    'alias' => 'ItemRejected',
                    'isSub' => 'Item'
                )
            );
            $models[] = array(
                'Item' => array(
                    'display' => __l('Cancelled') ,
                    'link' => array(
                        'controller' => 'items',
                        'action' => 'index',
                        'filter_id' => ConstItemStatus::Canceled,
                        'merchant' => $merchant_id['Merchant']['slug']
                    ) ,
                    'conditions' => array(
                        'Item.item_status_id' => ConstItemStatus::Canceled,
                        'Item.merchant_id' => $merchant_id['Merchant']['id'],
                    ) ,
                    'alias' => 'ItemCanceled',
                    'isSub' => 'Item'
                )
            );
            $models[] = array(
                'Item' => array(
                    'display' => __l('Expired') ,
                    'link' => array(
                        'controller' => 'items',
                        'action' => 'index',
                        'filter_id' => ConstItemStatus::Expired,
                        'merchant' => $merchant_id['Merchant']['slug']
                    ) ,
                    'conditions' => array(
                        'Item.item_status_id' => ConstItemStatus::Expired,
                        'Item.merchant_id' => $merchant_id['Merchant']['id'],
                    ) ,
                    'alias' => 'ItemExpired',
                    'isSub' => 'Item'
                )
            );
            $models[] = array(
                'Item' => array(
                    'display' => __l('All') ,
                    'link' => array(
                        'controller' => 'items',
                        'action' => 'index',
                        'type' => 'all',
                        'merchant' => $merchant_id['Merchant']['slug']
                    ) ,
                    'conditions' => array(
                        'Item.merchant_id' => $merchant_id['Merchant']['id'],
                    ) ,
                    'alias' => 'ItemAll',
                    'isSub' => 'Item',
					'class' => 'all-item-highlights'
                )
            );
            // Redeem
            $reedeem_item_id = $this->Item->find('list', array(
                'conditions' => array(
                    'Item.merchant_id' => $merchant_id['Merchant']['id']
                ) ,
                'fields' => array(
                    'Item.id'
                ) ,
                'recursive' => - 1
            ));
            $reedeem_item_user = $this->ItemUser->find('list', array(
                'conditions' => array(
                    'ItemUser.item_id' => $reedeem_item_id
                ) ,
                'fields' => array(
                    'ItemUser.id'
                ) ,
                'recursive' => 0
            ));
            $models[] = array(
                'ItemUserPass' => array(
                    'display' => __l('Item Passes') ,
                    'link' => array(
                        'controller' => 'items',
                        'action' => 'index'
                    ) ,
                    'rowspan' => 3
                )
            );
            $models[] = array(
                'ItemUserPass' => array(
                    'display' => __l('Redeemed') ,
                    'conditions' => array(
                        'ItemUserPass.item_user_id' => $reedeem_item_user,
                        'ItemUserPass.is_used' => 1,
                    ) ,
                    'fields' => array(
                        'SUM(is_used) AS used'
                    ) ,
                    'recursive' => 0,
                    'alias' => 'ItemReedeem',
					'isSub' => 'ItemUserPass'
                )
            );
            //not redeem
            $models[] = array(
                'ItemUserPass' => array(
                    'display' => __l('Not Redeemed') ,
                    'conditions' => array(
                        'ItemUserPass.item_user_id' => $reedeem_item_user,
                        'ItemUserPass.is_used' => 0,
                    ) ,
                    'fields' => array(
                        'SUM(is_used) AS used'
                    ) ,
                    'recursive' => 0,
                    'alias' => 'ItemNotReedeem',
					'isSub' => 'ItemUserPass'
                )
            );
            //all
            $models[] = array(
                'ItemUserPass' => array(
                    'display' => __l('All') ,
                    'conditions' => array(
                        'ItemUserPass.item_user_id' => $reedeem_item_user,
                    ) ,
                    'fields' => array(
                        'SUM(is_used) AS used'
                    ) ,
                    'recursive' => 0,
                    'alias' => 'ItemAllPasses',
					'isSub' => 'ItemUserPass'
                )
            );
			$tra_rwspn = 5;
			if(!$this->Merchant->User->isAllowed($this->Auth->user('user_type_id'))){
				$tra_rwspn--;
			}
            $models[] = array(
                'Transaction' => array(
                    'display' => __l('Transactions') . ' (' . Configure::read('site.currency') . ')',
                    'link' => array(
                        'controller' => 'Transaction',
                        'action' => 'index'
                    ) ,
                    'rowspan' => $tra_rwspn
                )
            );
            $models[] = array(
                'UserCashWithdrawal' => array(
                    'display' => __l('No. of Pending Withdraw Request') ,
                    'link' => array(
                        'controller' => 'user_cash_withdrawals',
                        'action' => 'index',
                        'filter_id' => ConstWithdrawalStatus::Pending,
                    ) ,
                    'conditions' => array(
                        'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Pending,
                        'UserCashWithdrawal.user_id' => $this->Auth->user('id') ,
                    ) ,
					'isSub' => 'Transaction',
                )
            );
            $models[] = array(
                'Transaction' => array(
                    'display' => __l('Withdrawn Amount by Merchant') ,
                    'link' => array(
                        'controller' => 'transactions',
                        'action' => 'index',
                        'type' => ConstTransactionTypes::UserCashWithdrawalAmount
                    ) ,
                    'conditions' => array(
                        'Transaction.transaction_type_id' => ConstTransactionTypes::UserCashWithdrawalAmount,
                        'Transaction.user_id' => $this->Auth->user('id')
                    ) ,
                    'alias' => 'TransactionWithdrawAmount',
                    'isSub' => 'Transaction',
					'type' => 'cFloat'
                )
            );
            $models[] = array(
                'Item' => array(
                    'display' => __l('Paid To Charity') . ' (' . Configure::read('site.currency') . ')',
                    'conditions' => array(
                        'Item.merchant_id' => $merchant_id['Merchant']['id']
                    ) ,
                    'fields' => array(
                        'SUM(seller_charity_amount) AS seller_charity_amount'
                    ) ,
                    'alias' => 'PayToCharity',
                    'type' => 'cFloat',
                )
            );
            $models[] = array(
                'Transaction' => array(
                    'display' => __l('Total Item Amount Received from Admin') ,
                    'link' => array(
                        'controller' => 'transactions',
                        'action' => 'index',
                        'type' => ConstTransactionTypes::ReceivedItemPurchasedAmount
                    ) ,
                    'conditions' => array(
                        'Transaction.transaction_type_id' => ConstTransactionTypes::ReceivedItemPurchasedAmount,
                        'Transaction.user_id' => $this->Auth->user('id')
                    ) ,
                    'alias' => 'TransactionPaidToMerchant',
                    'isSub' => 'Transaction',
					'type' => 'cFloat'
                )
            );
			if($this->Merchant->User->isAllowed($this->Auth->user('user_type_id'))){
				$models[] = array(
					'Transaction' => array(
						'display' => __l('Deposits to Wallet') ,
						'link' => array(
							'controller' => 'transactions',
							'action' => 'index',
							'type' => ConstTransactionTypes::AddedToWallet
						) ,
						'conditions' => array(
							'Transaction.transaction_type_id' => ConstTransactionTypes::AddedToWallet,
							'Transaction.user_id' => $this->Auth->user('id')
						) ,
						'alias' => 'TransactionAmountToWallet',
						'isSub' => 'Transaction'
					)
				);
			}
            foreach($models as $unique_model) {
                foreach($unique_model as $model => $fields) {
                    foreach($periods as $key => $period) {
                        $conditions = $period['conditions'];
                        if (!empty($fields['conditions'])) {
                            $conditions = array_merge($periods[$key]['conditions'], $fields['conditions']);
                        }
                        $aliasName = !empty($fields['alias']) ? $fields['alias'] : $model;
                        if ($model == 'Transaction') {
                            $TransTotAmount = $this->{$model}->find('first', array(
                                'conditions' => $conditions,
                                'fields' => array(
                                    'SUM(Transaction.amount) as total_amount'
                                ) ,
                                'recursive' => - 1
                            ));
                            $this->set($aliasName . $key, $TransTotAmount['0']['total_amount']);
                        } else if ($model == 'Item' && $aliasName == 'ItemCommssionAmount') {
                            $TransTotAmount = $this->{$model}->find('first', array(
                                'conditions' => $conditions,
                                'fields' => array(
                                    'SUM(Item.total_commission_amount) as total_amount'
                                ) ,
                                'recursive' => - 1
                            ));
                            $this->set($aliasName . $key, $TransTotAmount['0']['total_amount']);
                        } else if ($model == 'Item' && $aliasName == 'PayToCharity') {
                            $TransTotAmount = $this->{$model}->find('first', array(
                                'conditions' => $conditions,
                                'fields' => array(
                                    'SUM(Item.seller_charity_amount) as seller_charity_amount'
                                ) ,
                                'recursive' => - 1
                            ));
                            $this->set($aliasName . $key, $TransTotAmount['0']['seller_charity_amount']);
                        }else {
                            $this->set($aliasName . $key, $this->{$model}->find('count', array(
                                'conditions' => $conditions,
                                'recursive' => - 1
                            )));
                        }
                    }
                }
            }
            $this->set(compact('periods', 'models'));
        }
    }
	function stats()
	{
		$merchants = $this->Merchant->find('first', array(
			'conditions' => array(
				'Merchant.user_id' => $this->Auth->user('id')
			) ,
			'recursive' => -1
		));
		$itemStatuses = $this->Merchant->Item->ItemStatus->find('list');
		$this->set('merchants', $merchants);
		$this->set('itemStatuses', $itemStatuses);
	}
	function admin_merchant_stats()
	{
		$this->pageTitle = __l('Merchant Snapshot');
		$this->set('pageTitle', $this->pageTitle);
	}
	public function admin_update()
    {
        $this->autoRender = false;
        if (!empty($this->request->data['Merchant'])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $merchantIds = array();
            foreach($this->request->data['Merchant'] as $merchant_id => $is_checked) {
                if ($is_checked['id']) {
                    $merchantIds[] = $merchant_id;
                }
            }
                if ($actionid && !empty($merchantIds)) {
                if ($actionid == ConstMoreAction::EnableMerchantProfile) {
                    $this->Merchant->updateAll(array(
                        'Merchant.is_merchant_profile_enabled' => 1
                    ) , array(
                        'Merchant.id' => $merchantIds
                    ));
                    $this->Session->setFlash(__l('Checked merchants has been enabled') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::DisableMerchantProfile) {
                    $this->Merchant->updateAll(array(
                        'Merchant.is_merchant_profile_enabled' => 0
                    ) , array(
                        'Merchant.id' => $merchantIds
                    ));
                    $this->Session->setFlash(__l('Checked merchants has been disabled') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Active) {
                    foreach($merchantIds as $merchantId) {
                        $get_merchant_user = $this->Merchant->find('first', array(
                            'conditions' => array(
                                'Merchant.id' => $merchantId
                            ) ,
                            'recursive' => -1
                        ));
                        $this->Merchant->User->updateAll(array(
                            'User.is_active' => 1
                        ) , array(
                            'User.id' => $get_merchant_user['Merchant']['user_id']
                        ));
                        $this->_sendAdminActionMail($merchantId, 'Admin User Active');
                    }
                    $this->Session->setFlash(__l('Checked merchants user has been activated') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Inactive) {
                    foreach($merchantIds as $merchantId) {
                        $get_merchant_user = $this->Merchant->find('first', array(
                            'conditions' => array(
                                'Merchant.id' => $merchantId
                            ) ,
                            'recursive' => -1
                        ));
                        $this->Merchant->User->updateAll(array(
                            'User.is_active' => 0
                        ) , array(
                            'User.id' => $get_merchant_user['Merchant']['user_id']
                        ));
                        $this->_sendAdminActionMail($merchantId, 'Admin User Deactivate');
                    }
                    $this->Session->setFlash(__l('Checked merchants user has been deactivated') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::DeductAmountFromWallet) {
                    $this->Session->write('merchants_list.data', $merchantIds);
                    $this->redirect(array(
                        'controller' => 'merchants',
                        'action' => 'admin_deductamount',
                        'admin' => true
                    ));
                }
            }
        }
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect(Router::url('/', true) . $r);
        } else {
            $this->redirect($r);
        }
    }
}
?>