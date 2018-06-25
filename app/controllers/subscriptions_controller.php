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
class SubscriptionsController extends AppController
{
    public $name = 'Subscriptions';
    public $uses = array(
        'Subscription',
        'User',
    );
    public function beforeFilter()
    {
        if (!$this->User->isAllowed($this->Auth->user('user_type_id'))) {
            throw new NotFoundException(__l('Invalid request'));
        }
        parent::beforeFilter();
    }
	public function index()
	{
		$this->pageTitle = __l('My Subscriptions');
		$subscriptions = $this->Subscription->find('all', array(
			'conditions' => array(
				'Subscription.is_subscribed' => 1,
				'Subscription.user_id' => $this->Auth->user('id')
			) ,
			'contain' => array(
				'City'
			) ,
			'recursive' => 0
		));
		$this->set('subscriptions', $subscriptions);
		$conditions['City.is_approved'] = 1;
		$conditions['City.is_enable'] = 1;
		if (!empty($subscriptions)) {
			foreach($subscriptions as $subscription) {
				$city_ids[] = $subscription['Subscription']['city_id'];
			}
			$conditions['Not']['City.id'] = $city_ids;
		}
		$cities = $this->Subscription->City->find('list', array(
            'conditions' => $conditions,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
        $this->set(compact('cities'));
	}
    public function add()
    {
        $this->pageTitle = __l('Add Subscription');
        $Currentstep = 1;
        if (!empty($this->request->data)) {
            $subscription = $this->Subscription->find('first', array(
                'conditions' => array(
                    'Subscription.email' => $this->request->data['Subscription']['email'],
                    'Subscription.city_id' => $this->request->data['Subscription']['city_id']
                ) ,
                'fields' => array(
                    'Subscription.id',
                    'Subscription.is_subscribed'
                ) ,
                'recursive' => - 1
            ));
            if (!empty($this->request->data['Subscription']['city_id'])) {
                $get_city = $this->Subscription->City->find('first', array(
                    'conditions' => array(
                        'City.id' => $this->request->data['Subscription']['city_id']
                    ) ,
                    'recursive' => - 1
                ));
            }
            $this->request->data['Subscription']['user_id'] = $this->Auth->user('id');
            if (empty($subscription)) {
                $this->Subscription->create();
                if ($this->Subscription->save($this->request->data)) {
                    // Saving record in MailChimp Server //
                    if (Configure::read('mailchimp.is_enabled') == 1) {
						$this->loadModel('MailChimpList');
                        $city_list_id = $this->MailChimpList->find('first', array(
                            'conditions' => array(
                                'MailChimpList.city_id' => $this->request->data['Subscription']['city_id']
                            ) ,
                            'fields' => array(
                                'MailChimpList.list_id'
                            )
                        ));
                        include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'MCAPI.class.php');
                        include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'config.inc.php');
                        $api = new MCAPI(Configure::read('mailchimp.api_key'));
                        $email = $this->request->data['Subscription']['email'];
                        $unsub_link = Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'subscriptions',
                            'action' => 'unsubscribe',
                            $this->Subscription->getLastInsertId() ,
                            'admin' => false
                        ) , false) , 1);
                        $merge_vars = array(
                            'UNSUBSCRIB' => $unsub_link
                        );
                        $retval = $api->listSubscribe($city_list_id['MailChimpList']['list_id'], $email, $merge_vars, 'html', false);
                        $retval = $api->listUpdateMember($city_list_id['MailChimpList']['list_id'], $email, $merge_vars, 'html', false);
                    }
                    // END OF MAIL CHIMP SAVING //
                    $city = $this->Subscription->City->find('first', array(
                        'conditions' => array(
                            'City.id' => $this->request->data['Subscription']['city_id']
                        ) ,
                        'recursive' => - 1
                    ));
                    if (Configure::read('referral.referral_enabled_option') == ConstReferralOption::GrouponLikeRefer) {
                        $referal_person = "Refer A Friend";
                        $referal_amount = Configure::read('site.currency') . Configure::read('user.referral_amount');
                        $referal_link = Router::url(array(
                            'controller' => 'pages',
                            'action' => 'refer_a_friend',
                        ) , true);
                    }
                    if (Configure::read('referral.referral_enabled_option') == ConstReferralOption::XRefer) {
                        $referal_person = "Refer" . ' ' . Configure::read('referral.no_of_refer_to_get_a_refund') . ' ' . "Friends";
                        $referal_link = Router::url(array(
                            'controller' => 'pages',
                            'action' => 'refer_friend',
                        ) , true);
                        if (Configure::read('referral.refund_type') == ConstReferralRefundType::RefundItemAmount) {
                            $referal_amount = __l('a free');
                        } else {
                            $referal_amount = Configure::read('site.currency') . Configure::read('referral.refund_amount');
                        }
                    }
                    $this->loadModel('EmailTemplate');
                    $this->EmailTemplate = new EmailTemplate();
                    App::import('Core', 'ComponentCollection');
                    $collection = new ComponentCollection();
                    App::import('Component', 'Email');
                    $this->Email = new EmailComponent($collection);
                    $language_code = $this->Subscription->getUserLanguageIso($this->Auth->user('id'));
                    $template = $this->EmailTemplate->selectTemplate('Subscription Welcome Mail', $language_code);
                    $emailFindReplace = array(
                        '##FROM_EMAIL##' => $this->Subscription->changeFromEmail(Configure::read('EmailTemplate.from_email')) ,
                        '##SITE_URL##' => Router::url('/', true) ,
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##FROM_EMAIL##' => ($template['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $template['from'],
                        '##LEARN_HOW_LINK##' => Router::url(array(
                            'controller' => 'pages',
                            'action' => 'view',
                            'whitelist'
                        ) , true) ,
                        '##REFERAL_PERSON##' => $referal_person,
                        '##REFERRAL_AMOUNT##' => $referal_amount,
                        '##REFER_FRIEND_LINK##' => $referal_link,
                        '##FACEBOOK_LINK##' => ($city['City']['facebook_url']) ? $city['City']['facebook_url'] : Configure::read('facebook.site_facebook_url') ,
                        '##TWITTER_LINK##' => ($city['City']['twitter_url']) ? $city['City']['twitter_url'] : Configure::read('twitter.site_twitter_url') ,
                        '##RECENT_ITEMS##' => Router::url(array(
                            'controller' => 'items',
                            'action' => 'index',
                            'admin' => false,
                            'type' => 'recent'
                        ) , true) ,
                        '##CONTACT_US_LINK##' => Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add',
                            'admin' => false
                        ) , true) ,
                        '##SITE_LOGO##' => Router::url(array(
                            'controller' => 'img',
                            'action' => 'blue-theme',
                            'logo-email.png',
                            'admin' => false
                        ) , true) ,
                        '##UNSUBSCRIBE_LINK##' => Router::url(array(
                            'controller' => 'subscriptions',
                            'action' => 'unsubscribe',
                            $this->Subscription->getLastInsertId() ,
                            'admin' => false
                        ) , true) ,
                        '##CONTACT_URL##' => Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add',
                            'city' => $this->request->params['named']['city'],
                            'admin' => false
                        ) , true) ,
                    );
                    $this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $template['from'];
                    $this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $template['reply_to'];
                    $this->Email->to = $this->request->data['Subscription']['email'];
                    $this->Email->subject = strtr($template['subject'], $emailFindReplace);
                    $this->Email->content = strtr($template['email_content'], $emailFindReplace);
                    $this->Email->sendAs = ($template['is_html']) ? 'html' : 'text';
                    $this->Email->send($this->Email->content);
                    $this->Session->setFlash(sprintf(__l('You are now subscribed to %s in %s city'), Configure::read('site.name'), $get_city['City']['name']), 'default', null, 'success');
					if (!empty($this->request->data['is_from_manage_subscriptions'])) {
						$this->redirect(array(
							'controller' => 'subscriptions',
							'action' => 'index'
						));
					}
                } else {
                    $Currentstep = 2;
                    if (empty($this->Subscription->validationErrors)) {
                        $this->Session->setFlash(__l('You\'ll start receiving your emails soon.') , 'default', null, 'success');
                    } else {
                      //	unset($this->request->data['Subscription']['email']);
                        $this->Session->setFlash(__l('Could not be subscribed. Please, try again.') , 'default', null, 'error');
                    }
                }
            } elseif (!empty($subscription) && !$subscription['Subscription']['is_subscribed']) {
                $this->request->data['Subscription']['is_subscribed'] = 1;
                $this->request->data['Subscription']['id'] = $subscription['Subscription']['id'];
                $this->Subscription->save($this->request->data);
                $this->Session->setFlash(__l('You are now subscribed to') . ' ' . Configure::read('site.name') . ' ' . $get_city['City']['name'] . '. ' . __l('Thanks for subscribing again.') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('You\'ll start receiving your emails soon.') , 'default', null, 'success');
            }
			if (empty($this->Subscription->validationErrors))
			{
			//confirmation page redirects
			 $this->redirect(array(
				'controller' => 'subscriptions',
				'action' => 'confirmation',
               ));
			}

            if (empty($this->Subscription->validationErrors) && Configure::read('site.enable_three_step_subscription')) {
                $this->Cookie->write('is_subscribed', 1, false); // For skipping subscriptions
                $check_item_exist = $this->Subscription->User->ItemUser->Item->CitiesItem->find('first', array(
                    'conditions' => array(
                        'CitiesItem.city_id' => $get_city['City']['id']
                    ) ,
                    'contain' => array(
                        'Item' => array(
                            'fields' => array(
                                'Item.id',
                                'Item.name',
                                'Item.slug',
                                'Item.city_id',
                                'Item.item_status_id',
                            ) ,
                            'conditions' => array(
                                'Item.item_status_id' => array(
                                    ConstItemStatus::Closed,
                                    ConstItemStatus::Tipped,
                                ) ,
                            )
                        ) ,
                    ) ,
                    'recursive' => 1
                ));
                if (!empty($check_item_exist['Item'])) {
                    $this->redirect(array(
                        'controller' => 'items',
                        'action' => 'index',
                        'city' => $get_city['City']['slug']
                    ));
                } else {
                    $this->redirect(array(
                        'controller' => 'page',
                        'action' => 'view',
                        'city' => $get_city['City']['slug'],
                        'how_it_works'
                    ));
                }
            }
        } else {
            $city = $this->Subscription->City->find('first', array(
                'conditions' => array(
                    'City.slug' => $this->request->params['named']['city']
                ) ,
                'fields' => array(
                    'City.id'
                ) ,
                'recursive' => - 1
            ));
            $this->request->data['Subscription']['city_id'] = $city['City']['id'];
        }
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) {
            $merchant = $this->Subscription->User->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.user_id' => $this->Auth->user('id')
                ) ,
                'recursive' => - 1
            ));
            $this->set('merchant', $merchant);
        }
        $cities = $this->Subscription->City->find('list', array(
            'conditions' => array(
                'City.is_approved' => 1,
				'City.is_enable' => 1
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
        $this->set(compact('cities'));
		if($this->RequestHandler->isAjax())
		{
			 $this->set('isAjax',1);
		}
		else
		{
			$this->set('isAjax',0);
		}
        $this->set('Currentstep', $Currentstep);
        $this->set('pageTitle', __l('Item of the Day'));
    }
	function confirmation()
	{
	   $this->pageTitle = __l('Subscription confirmation');

	}
    function admin_update_subscribers()
    {
        $this->Subscription->_updateSubscribersList();
        $this->Session->setFlash(__l('Subscribers list has been updated.') , 'default', null, 'success');
        $this->redirect(array(
            'action' => 'index'
        ));
    }
    function skip()
    {
        $this->Cookie->write('is_subscribed', 1, false); // For skipping subscriptions
        $this->redirect(array(
            'controller' => 'items',
            'action' => 'index'
        ));
    }
    public function unsubscribe($id = null)
    {
        $this->pageTitle = __l('Unsubscribe');
        if (is_null($id) && empty($this->request->data)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            $subscription = $this->Subscription->find('first', array(
                'conditions' => array(
                    'Subscription.id' => $this->request->data['Subscription']['id']
                ) ,                
                'recursive' => - 1
            ));
            if (empty($subscription)) {
                $this->Session->setFlash(__l('Please provide a subscribed email') , 'default', null, 'error');
            } else {
                $this->request->data['Subscription']['is_subscribed'] = 0;
                if ($this->Subscription->save($this->request->data)) {
                    if (Configure::read('mailchimp.is_enabled') == 1) {
						$this->loadModel('MailChimpList');
                        //unsubscribe the email in mail chimp
                        $city_list_id = $this->MailChimpList->find('first', array(
                            'conditions' => array(
                                'MailChimpList.city_id' => $subscription['Subscription']['city_id']
                            ) ,
                            'fields' => array(
                                'MailChimpList.list_id'
                            )
                        ));
                        include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'MCAPI.class.php');
                        include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'config.inc.php');
                        $api = new MCAPI(Configure::read('mailchimp.api_key'));
                        $retval = $api->listUnsubscribe($city_list_id['MailChimpList']['list_id'], $subscription['Subscription']['email']);
                    }
                    $this->Session->setFlash(__l('You have unsubscribed from the subscribers list') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'items',
                        'action' => 'index'
                    ));
                }
            }
        } else {
            $this->request->data['Subscription']['id'] = $id;
        }
    }
    function unsubscribe_mailchimp()
    {
        $this->pageTitle = __l('Unsubscribe');
        $this->loadModel('MailChimpList');
        if (!empty($this->request->params['named']['sub_city']) && !empty($this->request->params['named']['email'])) {
            $city = $this->Subscription->City->find('first', array(
                'conditions' => array(
                    'City.slug' => $this->request->params['named']['sub_city'],
                ) ,
                'recursive' => - 1
            ));
            $get_subscriber = $this->Subscription->find('first', array(
                'conditions' => array(
                    'Subscription.email' => $this->request->params['named']['email'],
                ) ,
                'recursive' => - 1
            ));
            if (!empty($get_subscriber)) {
                $this->Subscription->updateAll(array(
                    'Subscription.is_subscribed' => 0
                ) , array(
                    'Subscription.id' => $get_subscriber['Subscription']['id'],
                ));
                if (Configure::read('mailchimp.is_enabled') == 1) {
                    //unsubscribe the email in mail chimp
                    $city_list_id = $this->MailChimpList->find('first', array(
                        'conditions' => array(
                            'MailChimpList.city_id' => $city['City']['id']
                        ) ,
                        'fields' => array(
                            'MailChimpList.list_id'
                        )
                    ));
                    include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'MCAPI.class.php');
                    include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'config.inc.php');
                    $api = new MCAPI(Configure::read('mailchimp.api_key'));
                    $retval = $api->listUnsubscribe($city_list_id['MailChimpList']['list_id'], $this->request->params['named']['email']);
                }
                $this->Session->setFlash(__l('You have unsubscribed from the subscribers list.') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'items',
                    'action' => 'index'
                ));
            }
        }
        $this->redirect(array(
            'controller' => 'items',
            'action' => 'index'
        ));
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q',
			'city_id'
        ));
        $this->pageTitle = __l('Subscriptions');
        $conditions = array();
        $param_string = '';
        $param_string.= !empty($this->request->params['named']['type']) ? '/type:' . $this->request->params['named']['type'] : $param_string;
        if (!empty($this->request->data['Subscription']['type'])) {
            $this->request->params['named']['type'] = $this->request->data['Subscription']['type'];
        }
		if (empty($this->request->data['Subscription']['city_id']) && !empty($this->request->params['named']['city_id'])) {
            $this->request->data['Subscription']['city_id'] = $this->request->params['named']['city_id'];
        }
        if (empty($this->request->data['Subscription']['q']) && !empty($this->request->params['named']['q'])) {
            $this->request->data['Subscription']['q'] = $this->request->params['named']['q'];
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'subscribed') {
            $this->request->data['Subscription']['type'] = $this->request->params['named']['type'];
            $conditions['Subscription.is_subscribed'] = 1;
            $this->pageTitle = __l('Subscribed Users');
        } elseif (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'unsubscribed') {
            $this->request->data['Subscription']['type'] = $this->request->params['named']['type'];
            $conditions['Subscription.is_subscribed'] = 0;
            $this->pageTitle = __l('Unsubscribed Users');
        }
        if (isset($this->request->data['Subscription']['q']) && !empty($this->request->data['Subscription']['q'])) {
            $this->request->params['named']['q'] = $this->request->data['Subscription']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->data['Subscription']['q']);
        }
		if (isset($this->request->data['Subscription']['city_id']) && !empty($this->request->data['Subscription']['city_id'])) {
            $this->request->params['named']['city_id'] = $this->request->data['Subscription']['city_id'];
			$conditions['Subscription.city_id'] = $this->request->data['Subscription']['city_id'];
        }
        // Citywise admin filter //
        $city_filter_id = $this->Session->read('city_filter_id');
        if (!empty($city_filter_id)) {
            $conditions['Subscription.city_id'] = $city_filter_id;
        }
        if ($this->RequestHandler->prefers('csv')) {
            Configure::write('debug', 0);
            $this->set('SubscriptionObj', $this);
            $this->set('conditions', $conditions);
            if (isset($this->request->params['named']['q'])) {
                $this->set('q', $this->request->params['named']['q']);
            }
            $this->set('contain', $contain);
        } else {
            $this->Subscription->recursive = 0;
            $this->paginate = array(
                'conditions' => $conditions,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.email',
                            'User.id',
                            'User.username',
                        ) ,
                    ) ,
                    'City',
                ) ,
                'recursive' => 1,
                'order' => array(
                    'Subscription.id' => 'desc'
                ) ,
            );
            $export_subscriptions = $this->Subscription->find('all', array(
                'conditions' => $conditions,
                'recursive' => - 1
            ));
            if (!empty($export_subscriptions)) {
                $ids = array();
                foreach($export_subscriptions as $export_subscription) {
                    $ids[] = $export_subscription['Subscription']['id'];
                }
                $hash = $this->Subscription->getIdHash(implode(',', $ids));
                $_SESSION['export_subscriptions'][$hash] = $ids;
                $this->set('export_hash', $hash);
            }
            if (!empty($this->request->data['Subscription']['q'])) {
                $this->paginate = array_merge($this->paginate, array(
                    'search' => $this->request->params['named']['q']
                ));
            }
            $this->set('subscriptions', $this->paginate());
            // Citywise admin filter //
            $count_conditions = array();
            if (!empty($city_filter_id)) {
                $count_conditions['Subscription.city_id'] = $city_filter_id;
            }
            $this->set('subscribed', $this->Subscription->find('count', array(
                'conditions' => array_merge(array(
                    'Subscription.is_subscribed' => 1,
                ) , $count_conditions) ,
                'recursive' => 0
            )));
            $this->set('unsubscribed', $this->Subscription->find('count', array(
                'conditions' => array_merge(array(
                    'Subscription.is_subscribed' => 0,
                ) , $count_conditions) ,
                'recursive' => 0
            )));
            $this->set('pageTitle', $this->pageTitle);
            $moreActions = $this->Subscription->moreActions;
            if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'unsubscribed')) {
                unset($moreActions[ConstMoreAction::UnSubscripe]);
            }
            $cities = $this->Subscription->City->find('list', array(
				'conditions' => array(
					'City.is_approved' => 1,
					'City.is_enable' => 1
				) ,
				'order' => array(
					'City.name' => 'asc'
				)
			));
            $this->set(compact('moreActions', 'cities'));
            $this->set('param_string', $param_string);
        }
    }
    public function admin_update()
    {
        $this->autoRender = false;
        if (!empty($this->request->data['Subscription'])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $userIds = array();
            foreach($this->request->data['Subscription'] as $subscription_id => $is_checked) {
                if ($is_checked['id']) {
                    $subscriptionIds[] = $subscription_id;
                }
            }
            if ($actionid && !empty($subscriptionIds)) {
                if ($actionid == ConstMoreAction::Delete) {
                    $this->Subscription->deleteAll(array(
                        'Subscription.id' => $subscriptionIds
                    ));
                    $this->Session->setFlash(__l('Checked subscriptions has been deleted') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::UnSubscripe) {
                    $this->Subscription->updateAll(array(
                        'Subscription.is_subscribed' => 0,
                    ) , array(
                        'Subscription.id' => $subscriptionIds
                    ));
                    $this->Session->setFlash(__l('Checked subscriptions has been un subscribed') , 'default', null, 'success');
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
        if ($this->Subscription->delete($id)) {
            $this->Session->setFlash(__l('Subscription deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    function subscribes()
    {
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['Subscription']['City'])) {
                $cities = $this->request->data['Subscription']['City'];
                unset($this->request->data['Subscription']['City']);
                $this->request->data['Subscription']['email'] = $this->Auth->user('email');
                $this->request->data['Subscription']['user_id'] = $this->Auth->user('id');
                $this->request->data['Subscription']['is_subscribed'] = 1;
                foreach($cities as $city) {
                    $this->request->data['Subscription']['city_id'] = $city;
                    $subscription = $this->Subscription->find('first', array(
                        'conditions' => array(
                            'Subscription.email' => $this->Auth->user('email') ,
                            'Subscription.city_id' => $city
                        ) ,
                        'recursive' => - 1
                    ));
                    if (empty($subscription)) {
                        $this->Subscription->create();
                    } else {
                        $this->request->data['Subscription']['id'] = $subscription['Subscription']['id'];
                        $insert_id = $subscription['Subscription']['id'];
                    }
                    $this->Subscription->save($this->request->data);
                    if (empty($subscription)) {
                        $insert_id = $this->Subscription->getLastInsertId();
                    }
                    if (Configure::read('mailchimp.is_enabled') == 1) {
                        $this->loadModel('MailChimpList');
                        $city_list_id = $this->MailChimpList->find('first', array(
                            'conditions' => array(
                                'MailChimpList.city_id' => $city
                            ) ,
                            'fields' => array(
                                'MailChimpList.list_id'
                            )
                        ));
                        include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'MCAPI.class.php');
                        include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'config.inc.php');
                        $api = new MCAPI(Configure::read('mailchimp.api_key'));
                        $email = $this->request->data['Subscription']['email'];
                        $unsub_link = Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
                            'controller' => 'subscriptions',
                            'action' => 'unsubscribe',
                            $insert_id,
                            'admin' => false
                        ) , false) , 1);
                        $merge_vars = array(
                            'UNSUBSCRIB' => $unsub_link
                        );
                        $retval = $api->listSubscribe($city_list_id['MailChimpList']['list_id'], $email, $merge_vars, 'html', false);
                        $retval = $api->listUpdateMember($city_list_id['MailChimpList']['list_id'], $email, $merge_vars, 'html', false);
                    }
                }
                $this->Session->setFlash(__l('Checked cities has been subscribed') , 'default', null, 'success');
                if ($this->RequestHandler->isAjax()) {
                    $url = Router::url(array(
                        'controller' => 'subscriptions',
                        'action' => 'manage_subscription',
                        'city' => $this->request->params['named']['city'],
                        'admin' => false
                    ) , true);
                    echo 'redirect*' . $url;
                    exit;
                } else {
                    $this->redirect(array(
                        'controller' => 'subscriptions',
                        'action' => 'manage_subscription'
                    ));
                }
            } else {
                $this->Session->setFlash(__l('Subscriptions Could not be added. please select cities') , 'default', null, 'error');
            }
        }
        $conditions[] = array(
            'OR' => array(
                array(
                    'Subscription.email' => $this->Auth->user('email')
                ) ,
                array(
                    'Subscription.user_id' => $this->Auth->user('id')
                ) ,
            )
        );
        $conditions['Subscription.is_subscribed'] = 1;
        $get_subscribers = $this->Subscription->find('list', array(
            'conditions' => $conditions,
            'fields' => array(
                'Subscription.id',
                'Subscription.city_id'
            ) ,
            'recursive' => - 1
        ));
        $cities = $this->Subscription->City->find('list', array(
            'conditions' => array(
                'NOT' => array(
                    'City.id' => $get_subscribers
                ) ,
                'City.is_approved' => 1,
				'City.is_enable' => 1
            ) ,
            'fields' => array(
                'City.id',
                'City.name'
            ) ,
            'recursive' => - 1
        ));
        $this->set(compact('cities'));
    }
    function unsubscribes()
    {
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['Subscription']['unsubscribers'])) {
                $subcriber_ids = $this->request->data['Subscription']['unsubscribers'];
                unset($this->request->data['Subscription']['unsubscribers']);
                foreach($subcriber_ids as $subcriber_id) {
                    $this->request->data['Subscription']['id'] = $subcriber_id;
                    $this->request->data['Subscription']['is_subscribed'] = 0;
                    $this->Subscription->save($this->request->data);
                    if (Configure::read('mailchimp.is_enabled') == 1) {
                        $this->loadModel('MailChimpList');
                        //unsubscribe the email in mail chimp
                        $city_list_id = $this->MailChimpList->find('first', array(
                            'conditions' => array(
                                'MailChimpList.city_id' => $subcriber_id
                            ) ,
                            'fields' => array(
                                'MailChimpList.list_id'
                            )
                        ));
                        include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'MCAPI.class.php');
                        include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'config.inc.php');
                        $api = new MCAPI(Configure::read('mailchimp.api_key'));
                        $retval = $api->listUnsubscribe($city_list_id['MailChimpList']['list_id'], $this->Auth->user('email'));
                    }
                }
                $this->Session->setFlash(__l('Checked city has been Unsubscribed') , 'default', null, 'success');
                if ($this->RequestHandler->isAjax()) {
                    $url = Router::url(array(
                        'controller' => 'subscriptions',
                        'action' => 'manage_subscription',
                        'city' => $this->request->params['named']['city'],
                        'admin' => false
                    ) , true);
                    echo 'redirect*' . $url;
                    exit;
                } else {
                    $this->redirect(array(
                        'controller' => 'subscriptions',
                        'action' => 'manage_subscription'
                    ));
                }
            } else {
                $this->Session->setFlash(__l('Could not be Unsubscribed. please select cities') , 'default', null, 'error');
            }
        }
        $conditions[] = array(
            'OR' => array(
                array(
                    'Subscription.email' => $this->Auth->user('email')
                ) ,
                array(
                    'Subscription.user_id' => $this->Auth->user('id')
                ) ,
            )
        );
        $conditions['Subscription.is_subscribed'] = 1;
        $unsubscribers = $this->Subscription->find('list', array(
            'conditions' => $conditions,
            'fields' => array(
                'Subscription.id',
                'City.name'
            ) ,
            'recursive' => 2
        ));
        $this->set(compact('unsubscribers'));
    }
    function manage_subscription()
    {
        $this->pageTitle = __l('Manage Subscriptions');
    }
}
?>