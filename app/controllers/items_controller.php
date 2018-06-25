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
class ItemsController extends AppController
{
    public $name = 'Items';
    public $components = array(
        'Email',
        'Paypal',
        'RequestHandler',
        'PagSeguro',
    );
    public $helpers = array(
        'Csv',
        'Gateway',
        'PagSeguro',
        'Cache'
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Attachment',
            'Item.calculator_min_limit',
            'ItemStatus.id',
            'ItemStatus.name',
            'Item.is_save_draft',
            'Item.id',
            'Item.save_as_draft',
            'Item.send_to_admin',
            'Item.old_pass_code',
            'Item.quantity',
            'Item.message',
            'Item.item_amount',
            'Item.item_id',
            'Item.is_gift',
            'User.confirm_password',
            'User.email',
            'User.f',
            'User.is_requested',
            'User.is_remember',
            'Item.user_available_balance',
            'Item.gift_to',
            'Item.is_purchase_via_wallet',
            'Item.is_show_new_card',
            'Item.payment_gateway_id',
            'Item.budget_amt',
            'Item.original_amt',
            'Item.discount_amt',
            'Item.max_limit',
            'Item.bonus_amount',
            'Item.commission_percentage',
            'Item.name',
            'Item.continue',
            'Item.event_date',
            'Item.end_date',
            'Item.menu',
            'Item.price',
            'ItemCategory.id',
            'ItemUserPass',
            'City.city_id'
        );
        parent::beforeFilter();
    }
    public function index($city_slug = null)
    {
        $has_near_by_item = 0;
        $sub_title = '';
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'success') {
            if ($this->Session->read('Item.id')) {
                $item_id = $this->Session->read('Item.id');
                $this->Session->delete('Item.id');
            }
        }
        $this->_redirectGET2Named(array(
            'q'
        ));
        if (!empty($this->request->data['Item']['q'])) {
           $this->request->params['named']['q'] = $this->request->data['Item']['q'];
        }
        if (!empty($this->request->data['Item']['filter_id'])) {
            $this->request->params['named']['filter_id'] = $this->request->data['Item']['filter_id'];
        }
        if (!empty($this->request->data['Item']['merchant_slug'])) {
            $this->request->params['named']['merchant'] = $this->request->data['Item']['merchant_slug'];
        }
        if (!empty($this->request->data['Item']['type'])) {
            $this->request->params['named']['type'] = $this->request->data['Item']['type'];
        }
        $limit = (!empty($this->request->params['named']['limit'])) ? $this->request->params['named']['limit'] : 30;
        $city_conditions = array();
        // item add sucess message
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'success') {
            $this->Session->setFlash(__l('Item has been added.') , 'default', null, 'success');
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'near') {
			$data_max = $this->setMaxmindInfo();
            $city_slug = $this->request->params['named']['city'];
            $cities = $this->Item->City->find('all', array(
                'fields' => array(
                    'City.id',
                    '( 6371 * acos( cos( radians(' . $_SESSION['maxmaind_latitude'] . ') ) * cos( radians( City.latitude ) ) * cos( radians( City.longitude ) - radians(' . $_SESSION['maxmaind_longitude'] . ') ) + sin( radians(' . $_SESSION['maxmaind_latitude'] . ') ) * sin( radians( City.latitude ) ) ) ) AS distance'
                ) ,
                'group' => array(
                    'City.id HAVING distance <' . Configure::read('item.nearby_item_km')
                ) ,
                'conditions' => array(
                    'City.slug !=' => $city_slug
                ) ,
                'order' => array(
                    'distance' => 'asc'
                ) ,
                'recursive' => -1,
            ));
            if (!empty($cities)) {
                $city_ids = array();
                foreach($cities as $city) {
                    $city_ids[$city['City']['id']] = $city['City']['id'];
                }
                $citiesItems = $this->Item->CitiesItem->find('all', array(
                    'conditions' => array(
                        'CitiesItem.city_id' => $city_ids,
                    ) ,
                    'recursive' => -1
                ));
                $city_item_ids = array();
                $s = 0;
                foreach($citiesItems as $citiesItem) {
                    if (!empty($citiesItem['CitiesItem']['item_id']) && $citiesItem['CitiesItem']['item_id'] != $this->request->params['named']['item_id']) {
                        $city_item_ids[] = $citiesItem['CitiesItem']['item_id'];
                        $s++;
                    }
                    if (!empty($this->request->params['named']['view']) && $this->request->params['named']['view'] == 'simple' && $s >= Configure::read('item.nearby_item_index_limit')) {
                        break;
                    }
                }
                if (!empty($city_item_ids)) {
                    $has_near_by_item = 1;
                    $conditions['Item.id'] = $city_item_ids;
                }
            }
        } else {
            //home page items
            if (empty($this->request->params['named']['merchant'])) {
                if (empty($this->request->params['named']['city'])) {
                    $this->request->params['named']['city'] = Configure::read('site.city');
                }
                $city_slug = $this->request->params['named']['city'];
                $city = $this->Item->City->find('first', array(
                    'conditions' => array(
                        'City.slug' => $city_slug
                    ) ,
                    'contain' => array(
                        'Attachment',
                        'Item' => array(
                            'fields' => array(
                                'Item.id'
                            ) ,
                        )
                    ) ,
                    'recursive' => 1
                ));
                $this->set('city', $city);
                if (empty($city)) {
                    throw new NotFoundException(__l('Invalid request'));
                }
                $city_item_ids = array();
                foreach($city['Item'] as $item) {
                    $city_item_ids[] = $item['id'];
                }
                $conditions['Item.id'] = $city_item_ids;
            }
        }
        //merchant users items list ends
        $order = array(
            'Item.end_date' => 'asc'
        );
        //recent and merchant items list
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'near') {
            $this->pageTitle = __l('Nearby Items');
            $sub_title = __l('Nearby Items');
            $conditions['Item.item_status_id'] = array(
                ConstItemStatus::Open,
                ConstItemStatus::Tipped,
                ConstItemStatus::Closed,
            );
        } elseif (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'past') {
            $this->pageTitle = __l('Past Items');
            $conditions['Item.item_status_id'] = array(
                ConstItemStatus::Closed,
                ConstItemStatus::PaidToMerchant,
            );
        } elseif (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'main') {
            $this->pageTitle = __l('Main Items');
            $sub_title = __l('Main Items');
            $conditions['Item.item_status_id'] = array(
                ConstItemStatus::Open,
                ConstItemStatus::Tipped,
                ConstItemStatus::Closed,
            );
        } elseif (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'side') {
            $conditions['Item.item_status_id'] = array(
                ConstItemStatus::Open,
                ConstItemStatus::Tipped,
                ConstItemStatus::Closed,
            );
        } elseif (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'recent') {
            $conditions['Item.item_status_id'] = array(
                ConstItemStatus::Closed,
                ConstItemStatus::Expired,
                ConstItemStatus::Canceled,
                //ConstItemStatus::PaidToMerchant

            );
            $conditions['Item.end_date <'] = _formatDate('Y-m-d H:i:s', date('Y-m-d H:i:s') , true);
            $this->pageTitle = __l('Recent Items');
            $order = array(
                'Item.end_date' => 'desc'
            );
            $sub_title = __l('Recent Items');
        } elseif (empty($this->request->params['named']['merchant'])) {
            $conditions['Item.item_status_id'] = array(
                ConstItemStatus::Open,
                ConstItemStatus::Tipped,
                ConstItemStatus::Closed,
            );
            $this->pageTitle = ucfirst($city['City']['name']) . ' ' . __l('Items of the Day');
            $this->set('city_name', $city['City']['name']);
            $conditions['Item.end_date >'] = _formatDate('Y-m-d H:i:s', date('Y-m-d H:i:s') , true);
        }
        //for category
        if (!empty($this->request->params['named']['category'])) {
            $itemcategories = $this->Item->ItemCategory->find('all', array(
                'conditions' => array(
                    'ItemCategory.slug' => $this->request->params['named']['category']
                ) ,
                'contain' => array(
                    'Item'
                ) ,
            ));
            $item_ids = array();
            if ($itemcategories[0]['Item']) {
                foreach($itemcategories[0]['Item'] as $itemcategory) {
                    $item_ids[] = $itemcategory['id'];
                }
            }
            if(empty($conditions['Item.id'])){
            $conditions['Item.id'] = $item_ids;
            }else{
                $olditem_ids = $conditions['Item.id'];
                unset($conditions['Item.id']);
                $conditions['Item.id']=array_intersect($olditem_ids,$item_ids);
            }
        }
        //for merchant
        if (!empty($this->request->params['named']['merchant'])) {
            $merchant = $this->Item->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.slug = ' => $this->request->params['named']['merchant'],
                ) ,
                'fields' => array(
                    'Merchant.id',
                    'Merchant.name',
                    'Merchant.slug',
                    'Merchant.user_id',
                ) ,
                'recursive' => -1
            ));
            if ((!$this->Auth->user('id')) || ($merchant['Merchant']['user_id'] != $this->Auth->user('id'))) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['Item.merchant_id'] = $merchant['Merchant']['id'];
            if (!empty($this->request->params['named']['filter_id'])) {
                $conditions['Item.item_status_id'] = $this->request->params['named']['filter_id'];
            }
            $headings = __l('My Items');
            $this->pageTitle = __l('My Items');
            $this->set('headings', $headings);
            $this->set('merchant_slug', $merchant['Merchant']['slug']);
        }
           if (isset($this->request->params['named']['q'])) {
            $conditions['Item.name LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
          $not_conditions = array();
        if ($this->Auth->user('user_type_id') == ConstUserTypes::User) {
            $not_conditions['Not']['Item.item_status_id'] = array(
                ConstItemStatus::PendingApproval,
            );
        }
        if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'all')) {
                  $conditions['Item.end_date >='] = _formatDate('Y-m-d H:i:s', date('Y-m-d H:i:s') , true);
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'interest') {
            $interest_ids = $this->Item->UserInterestItem->find('list', array(
                'conditions' => array(
                    'UserInterestItem.user_interest_id' => $this->request->params['named']['interest_id']
                ) ,
                'fields' => array(
                    'UserInterestItem.item_id',
                )
            ));
            $interest = $this->Item->User->UserInterest->find('first', array(
                'conditions' => array(
                    'UserInterest.id' => $this->request->params['named']['interest_id']
                ) ,
                'recursive' => -1
            ));
            $this->set('interest', $interest['UserInterest']['name']);
            if(empty($conditions['Item.id']) and (empty($this->request->params['named']['category'])) ){
               $conditions['Item.id'] = $interest_ids;
            }elseif(empty($conditions['Item.id'])and(!empty($this->request->params['named']['category']))){
                $conditions['Item.id'] = array();
            }else{
                $item_ids = $conditions['Item.id'];
                unset($conditions['Item.id']);
                $conditions['Item.id']=array_intersect($item_ids,$interest_ids);
            }
            
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'past_item') {
             $conditions['Item.item_status_id'] = array(
                ConstItemStatus::Closed,
            );
            $items = $this->Item->find('all', array(
                'conditions' => array(
                    $conditions,
                    $not_conditions,
                ) ,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.user_type_id',
                            'User.username',
                            'User.id',
                            'User.email',
                            'User.password',
                        )
                    ) ,
                    'Merchant' => array(
                        'fields' => array(
                            'Merchant.name',
                            'Merchant.slug',
                            'Merchant.id',
                            'Merchant.user_id',
                            'Merchant.url',
                            'Merchant.zip',
                            'Merchant.address1',
                            'Merchant.address2',
                            'Merchant.city_id',
                            'Merchant.latitude',
                            'Merchant.longitude',
                            'Merchant.is_merchant_profile_enabled',
                            'Merchant.is_online_account',
                            'Merchant.map_zoom_level'
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
                    'ItemUser' => array(
                        'fields' => array(
                            'ItemUser.user_id',
                            'ItemUser.discount_amount'
                        ) ,
                        'User' => array(
                            'UserAvatar' => array(
                                'fields' => array(
                                    'UserAvatar.id',
                                    'UserAvatar.filename',
                                    'UserAvatar.dir',
                                    'UserAvatar.width',
                                    'UserAvatar.height'
                                )
                            ) ,
                        ) ,
                        'limit' => 5
                    ) ,
                ) ,
                'order' => $order,
                'recursive' => 3,
                'limit' => $limit,
            ));
           
           
        } else {
                //For iPhone App code -->
            $this->paginate = array(
                'conditions' => array(
                    $conditions,
                    $not_conditions,
                ) ,
                'contain' => array(
                    'Charity' => array(
                        'fields' => array(
                            'Charity.name',
                            'Charity.url',
                            'Charity.id',
                        )
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.user_type_id',
                            'User.username',
                            'User.id',
                            'User.email',
                            'User.password',
                        )
                    ) ,
                    'Merchant' => array(
                        'fields' => array(
                            'Merchant.name',
                            'Merchant.slug',
                            'Merchant.id',
                            'Merchant.user_id',
                            'Merchant.url',
                            'Merchant.zip',
                            'Merchant.address1',
                            'Merchant.address2',
                            'Merchant.city_id',
                            'Merchant.latitude',
                            'Merchant.longitude',
                            'Merchant.is_merchant_profile_enabled',
                            'Merchant.is_online_account',
                            'Merchant.map_zoom_level'
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
                            'City.latitude',
                            'City.longitude',
                            'City.fb_access_token'
                        )
                    ) ,
                    'ItemStatus' => array(
                        'fields' => array(
                            'ItemStatus.name',
                        )
                    ) ,
                    'ItemUser' => array(
                        'fields' => array(
                            'ItemUser.user_id',
                            'ItemUser.discount_amount'
                        ) ,
                        'User' => array(
                            'UserAvatar' => array(
                                'fields' => array(
                                    'UserAvatar.id',
                                    'UserAvatar.filename',
                                    'UserAvatar.dir',
                                    'UserAvatar.width',
                                    'UserAvatar.height'
                                )
                            ) ,
                        ) ,
                        'limit' => 5
                    ) ,
                    'ItemCategory',
                    'UserInterest' => array(
                        'fields' => array(
                            'UserInterest.id',
                            'UserInterest.name',
                            'UserInterest.slug',
                        )
                    ) ,
                ) ,
                'order' => $order,
                'recursive' => 3,
                'limit' => $limit,
            );
            $items = $this->paginate();
        }
        if (!empty($this->request->params['named']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->params['named']['q']
            ));
        }
        $this->set('items', $items);
        $this->set('sub_title', $sub_title);
        $slug = (!empty($items[0]['Item']['slug'])) ? $items[0]['Item']['slug'] : '';
        // for side bar main item
        $conditions['Item.item_status_id'] = array(
            ConstItemStatus::Open,
            ConstItemStatus::Tipped,
        );
        $main_items = $this->Item->find('all', array(
            'conditions' => array_merge(array(
                'Item.slug !=' => $slug
            ) , $conditions) ,
            'contain' => array(
                'City',
                'Attachment' => array(
                    'fields' => array(
                        'Attachment.id',
                        'Attachment.dir',
                        'Attachment.filename',
                        'Attachment.width',
                        'Attachment.height'
                    )
                ) ,
            ) ,
            'recursive' => 1,
            'limit' => Configure::read('item.main_item_index_limit') ,
        ));
        $this->set('main_items', $main_items);
        // Coding for API Call
        if (Configure::read('site.is_api_enabled') and !empty($this->request->query['api_key']) and !empty($this->request->query['api_token'])) {
            $response['status'] = (empty($items)) ? 0 : 1001; // Not Items found Eror Code
            $response['message'] = (empty($items)) ? __l('No Items available') : __l('Items found');
            $response['items'] = array();
            if (!empty($items)) {
                foreach($items as $item) {
                    $image_options = array(
                        'dimension' => 'small_thumb',
                        'class' => '',
                        'alt' => $item['Item']['name'],
                        'title' => $item['Item']['name'],
                        'type' => 'jpg'
                    );
                    $small_image_url = getImageUrl('Item', $item['Attachment'][0], $image_options);
                    $image_options = array(
                        'dimension' => 'normal_thumb',
                        'class' => '',
                        'alt' => $item['Item']['name'],
                        'title' => $item['Item']['name'],
                        'type' => 'jpg'
                    );
                    $medium_image_url = getImageUrl('Item', $item['Attachment'][0], $image_options);
                    $image_options = array(
                        'dimension' => 'medium_big_thumb',
                        'class' => '',
                        'alt' => $item['Item']['name'],
                        'title' => $item['Item']['name'],
                        'type' => 'jpg'
                    );
                    $large_image_url = getImageUrl('Item', $item['Attachment'][0], $image_options);
                    $item_xml_content = array(
                        'id' => $item['Item']['id'],
                        'item_url' => Router::url(array(
                            'controller' => 'items',
                            'action' => 'view',
                            $item['Item']['slug']
                        ) , true) ,
                        'title' => $item['Item']['name'],
                        'small_image_url' => $small_image_url,
                        'medium_image_url' => $medium_image_url,
                        'large_image_url' => $large_image_url,
                        'division_id' => $item['City']['id'],
                        'division_name' => $item['City']['name'],
                        'division_lat' => $item['City']['latitude'],
                        'division_lng' => $item['City']['longitude'],
                        'vendor_id' => $item['Merchant']['id'],
                        'vendor_name' => $item['Merchant']['name'],
                        'vendor_website_url' => $item['Merchant']['url'],
                        'status' => $item['ItemStatus']['name'],
                        'end_date' => strftime(Configure::read('site.datetime.format') , strtotime($item['Item']['end_date'])) ,
                        'price' => Configure::read('site.currency') . $item['Item']['price'],
                        'tipped' => ($item['Item']['item_status_id'] == ConstItemStatus::Tipped) ? __l('true') : __l('false') ,
                        'tipping_point' => $item['Item']['min_limit'],
                        'tipped_date' => ($item['Item']['item_status_id'] == ConstItemStatus::Tipped) ? strftime(Configure::read('site.datetime.format') , strtotime($item['Item']['item_tipped_time'])) : __l('Not Yet Tipped') ,
                        'quantity_sold' => $item['Item']['item_user_count'],
                        'conditions' => array(
                            'limited_quantity' => (!empty($item['Item']['max_limit'])) ? __l('true') : __l('false') ,
                            'initial_quantity' => $item['Item']['min_limit'],
                            'quantity_remaining' => (empty($item['Item']['max_limit'])) ? __l('No Limit') : ($item['Item']['max_limit']-$item['Item']['item_user_count']) ,
                            'minimum_purchase' => $item['Item']['buy_min_quantity_per_user'],
                            'maximum_purchase' => $item['Item']['buy_max_quantity_per_user']
                        )
                    );
                    $response['items'][] = $item_xml_content;
                }
            }
            $this->set('api_response', $response);
        } else {
            if (!empty($this->request->params['named']['city'])) {
                $get_current_city = $this->request->params['named']['city'];
            } else {
                $get_current_city = Configure::read('site.city');
            }
            $this->set('get_current_city', $get_current_city);
            //render view file depends on the page
            if (!empty($this->request->params['named']['merchant'])) {
                $itemStatuses = $this->Item->ItemStatus->find('list', array());
                $itemStatusesCount = array();
                foreach($itemStatuses as $id => $itemStatus) {
                    $itemStatusesCount[$id] = $this->Item->find('count', array(
                        'conditions' => array(
                            'Item.item_status_id' => $id,
                            'Item.merchant_id' => $merchant['Merchant']['id'],
                        ) ,
                        'recursive' => -1
                    ));
                }
                $this->set('itemStatusesCount', $itemStatusesCount);
                $this->set('itemStatuses', $itemStatuses);
                $this->render('index_merchant_items');
            } else if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'recent') {
                $this->render('index_recent_items');
            }
        }
        if ((empty($this->request->params['named']['type']) || ($this->request->params['named']['type'] != 'geocity' && $this->request->params['named']['type'] != 'interest' && $this->request->params['named']['type'] != 'past' && $this->request->params['named']['type'] != 'past_item'&$this->request->params['named']['type'] != 'recent')) && empty($this->request->params['named']['merchant']) && empty($this->request->params['named']['item_id']) && empty($this->params['named']['category']) && ((!empty($items) && (!isset($_COOKIE['CakeCookie']['is_subscribed']) && !$this->Auth->user() && Configure::read('site.enable_three_step_subscription'))) || empty($items))) {
            if ((!empty($_COOKIE['CakeCookie']['is_subscribed']) || $this->Auth->user('id')) && empty($items)) { // Already Subscribed
                $this->Session->setFlash(__l('Its seems that the current select city does\'t have any open items. Please select another city') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'page',
                    'action' => 'view',
                    'learn'
                ));
            } else {
                $this->redirect(array(
                    'controller' => 'subscriptions',
                    'action' => 'add'
                ));
            }
        }
        // <-- For iPhone App code
        if ($this->RequestHandler->prefers('json')) {
            $this->view = 'Json';
            $items = $this->paginate();
            $total_items = count($items);
            for ($i = 0; $i < $total_items; $i++) {
                $this->Item->saveiPhoneAppThumb($items[$i]['Attachment']);
                $image_options = array(
                    'dimension' => 'iphone_big_thumb',
                    'class' => '',
                    'alt' => $items[$i]['Item']['name'],
                    'title' => $items[$i]['Item']['name'],
                    'type' => 'jpg'
                );
                $iphone_big_thumb = getImageUrl('Item', $items[$i]['Attachment'][0], $image_options);
                $items[$i]['Item']['iphone_big_thumb'] = $iphone_big_thumb;
                $image_options = array(
                    'dimension' => 'iphone_small_thumb',
                    'class' => '',
                    'alt' => $items[$i]['Item']['name'],
                    'title' => $items[$i]['Item']['name'],
                    'type' => 'jpg'
                );
                $iphone_small_thumb = getImageUrl('Item', $items[$i]['Attachment'][0], $image_options);
                $items[$i]['Item']['iphone_small_thumb'] = $iphone_small_thumb;
                $items[$i]['Item']['end_date'] = date('m/d/Y', strtotime($items[$i]['Item']['end_date']));
            }
            $this->view = 'Json';
            $this->set('json', (empty($this->viewVars['iphone_response'])) ? $items : $this->viewVars['iphone_response']);
        }
        if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'near' || $this->request->params['named']['type'] == 'main' || $this->request->params['named']['type'] == 'side')) {
            $this->set('has_near_by_item', $has_near_by_item);
            if (!empty($this->request->params['named']['view']) && $this->request->params['named']['view'] == 'simple') {
                $this->render('index_simple_near');
            } else {
                $this->render('index_near');
            }
        }
        if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'all_item')) {
            $this->set('item_id', $this->request->params['named']['item_id']);
            $this->render('item-slider');
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'past_item') {
            $this->render('item-slider');
        }
        // For iPhone App code -->

    }
    //comapny items listing
    public function merchant_items()
    {
        $conditions = $not_conditions = $order = array();
        if (!empty($this->request->params['named']['merchant_id'])) {
            $statusList = array(
                ConstItemStatus::Open,
                ConstItemStatus::Tipped,
                ConstItemStatus::Closed,
                ConstItemStatus::PaidToMerchant

            );
            $merchantUser = $this->Item->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.id' => $this->request->params['named']['merchant_id'],
                    'Merchant.user_id' => $this->Auth->user('id')
                ) ,
                'fields' => array(
                    'Merchant.user_id'
                ) ,
                'recursive' => -1
            ));
            if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                $statusList[] = ConstItemStatus::Open;
                $statusList[] = ConstItemStatus::Expired;
                $statusList[] = ConstItemStatus::Tipped;
                $statusList[] = ConstItemStatus::Closed;
                $statusList[] = ConstItemStatus::PaidToMerchant;
            }
            $conditions = array(
                'Item.merchant_id' => $this->request->params['named']['merchant_id'],
                'Item.item_status_id' => $statusList
            );
        }
        $this->paginate = array(
            'conditions' => array(
                $conditions,
                $not_conditions,
            ) ,
            'contain' => array(
                'Charity' => array(
                    'fields' => array(
                        'Charity.name',
                        'Charity.url',
                        'Charity.id',
                    )
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.user_type_id',
                        'User.username',
                        'User.id',
                        'User.email',
                        'User.password',
                    )
                ) ,
                'Merchant' => array(
                    'fields' => array(
                        'Merchant.name',
                        'Merchant.slug',
                        'Merchant.id',
                        'Merchant.user_id',
                        'Merchant.url',
                        'Merchant.zip',
                        'Merchant.address1',
                        'Merchant.address2',
                        'Merchant.city_id',
                        'Merchant.latitude',
                        'Merchant.longitude',
                        //'Merchant.is_merchant_profile_enabled',
                        'Merchant.is_online_account',
                        'Merchant.map_zoom_level'
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
                'UserInterest' => array(
                    'fields' => array(
                        'UserInterest.id',
                        'UserInterest.name',
                        'UserInterest.slug',
                    )
                ) ,
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                        'City.latitude',
                        'City.longitude',
                        'City.fb_access_token'
                    )
                ) ,
                'ItemStatus' => array(
                    'fields' => array(
                        'ItemStatus.name',
                    )
                ) ,
                'ItemUser' => array(
                    'fields' => array(
                        'ItemUser.user_id',
                        'ItemUser.discount_amount'
                    ) ,
                    'User' => array(
                        'UserAvatar' => array(
                            'fields' => array(
                                'UserAvatar.id',
                                'UserAvatar.filename',
                                'UserAvatar.dir',
                                'UserAvatar.width',
                                'UserAvatar.height'
                            )
                        ) ,
                    ) ,
                ) ,
                'ItemCategory',
            ) ,
            'order' => $order,
            'recursive' => 3,
        );
        $this->set('merchant_items', $this->paginate());
    }
    //export item listing in csv file
    public function passes_export()
    {
        if (empty($this->request->params['named']['item_id'])) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $itemusers = $this->Item->ItemUser->find('all', array(
            'conditions' => array(
                'ItemUser.item_id' => $this->request->params['named']['item_id'],
                'ItemUser.is_canceled' => 0
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.user_type_id',
                        'User.username',
                        'User.id',
                    )
                ) ,
                'Item' => array(
                    'fields' => array(
                        'Item.id',
                        'Item.name'
                    )
                ) ,
                'ItemUserPass'
            ) ,
            'fields' => array(
                'ItemUser.id',
                'ItemUser.discount_amount',
                'ItemUser.quantity'
            ) ,
            'recursive' => 1
        ));
        Configure::write('debug', 0);
        if (!empty($itemusers)) {
            foreach($itemusers as $itemuser) {
                $pass_array = array();
                $unique_pass_array = array();
                foreach($itemuser['ItemUserPass'] as $item_user_pass) {
                    $pass_array[] = $item_user_pass['pass_code'];
                    $unique_pass_array[] = $item_user_pass['unique_pass_code'];
                }
                $data[]['Item'] = array(
                    __l('User name') => $itemuser['User']['username'],
                    __l('Quantity') => $itemuser['ItemUser']['quantity'],
                    __l('Amount') => Configure::read('site.currency') . $itemuser['ItemUser']['discount_amount'],
                    __l('Top Code') => !empty($pass_array) ? implode('|', $pass_array) : '',
                    __l('Bottom Code') => !empty($unique_pass_array) ? implode('|', $unique_pass_array) : ''
                );
                $item_name = $itemuser['Item']['name'];
            }
        }
        $this->set('data', $data);
        $this->set('item_name', $item_name);
    }
    function stats()
    {
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
            $conditions = array(
                'Item.id' => $this->request->params['named']['item_id']
            );
        } else {
            $merchant = $this->Item->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.user_id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            if (empty($merchant)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions = array(
                'Item.id' => $this->request->params['named']['item_id'],
                'Item.merchant_id' => $merchant['Merchant']['id']
            );
        }
        $item = $this->Item->find('first', array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                    )
                ) ,
                'Merchant' => array(
                    'fields' => array(
                        'Merchant.id',
                        'Merchant.name',
                        'Merchant.slug',
                    )
                ) ,
                'ItemStatus' => array(
                    'fields' => array(
                        'ItemStatus.id',
                        'ItemStatus.name',
                    )
                ) ,
                'CitiesItem',
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                    )
                )
            )
        ));
        if (empty($item)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->set('item', $item);
    }
    //admin export item listing in csv file
    public function admin_export()
    {
        $this->setAction('passes_export');
    }
    function view($slug = null, $count = null)
    {
        $this->pageTitle = __l('Item');
        if (is_null($slug)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        // for side bar item
        $city_slug = $this->request->params['named']['city'];
        $city = $this->Item->City->find('first', array(
            'conditions' => array(
                'City.slug' => $city_slug
            ) ,
            'fields' => array(
                'City.name',
                'City.id'
            ) ,
            'recursive' => 1
        ));
        if (empty($city)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $city_item_ids = array();
        foreach($city['Item'] as $item) {
            $city_item_ids[] = $item['id'];
        }
        $conditions['Item.id'] = $city_item_ids;
        $item = $this->Item->find('first', array(
            'conditions' => array(
                'Item.slug = ' => $slug
            ) ,
            'contain' => array(
                'Charity' => array(
                    'fields' => array(
                        'Charity.name',
                        'Charity.url',
                        'Charity.id',
                    )
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.user_type_id',
                        'User.username',
                        'User.id',
                        'User.email',
                        'User.password',
                    ) ,
                ) ,
                'Merchant' => array(
                    'fields' => array(
                        'Merchant.name',
                        'Merchant.phone',
                        'Merchant.slug',
                        'Merchant.id',
                        'Merchant.user_id',
                        'Merchant.url',
                        'Merchant.zip',
                        'Merchant.address1',
                        'Merchant.address2',
                        'Merchant.city_id',
                        'Merchant.latitude',
                        'Merchant.longitude',
                        'Merchant.is_merchant_profile_enabled',
                        'Merchant.is_online_account',
                        'Merchant.map_zoom_level',
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
                'ItemUser' => array(
                    'fields' => array(
                        'ItemUser.user_id',
                        'ItemUser.discount_amount'
                    ) ,
                    'User' => array(
                        'UserAvatar' => array(
                            'fields' => array(
                                'UserAvatar.id',
                                'UserAvatar.filename',
                                'UserAvatar.dir',
                                'UserAvatar.width',
                                'UserAvatar.height'
                            )
                        ) ,
                    ) ,
                ) ,
                'UserInterest' => array(
                    'fields' => array(
                        'UserInterest.id',
                        'UserInterest.name',
                        'UserInterest.slug',
                    )
                ) ,
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                    ) ,
                ) ,
            ) ,
            'recursive' => 3,
        ));
        $itemPurchased = $this->Item->ItemUser->find('first', array(
            'conditions' => array(
                'ItemUser.item_id ' => $item['Item']['id'],
                'ItemUser.user_id ' => $this->Auth->user('id')
            )
        ));
        $this->set('itemPurchased', $itemPurchased);
        if (empty($item)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($item['Item']['name'])) {
            Configure::write('meta.item_name', $item['Item']['name']);
        }
        if (!empty($item['Attachment'])) {
            $image_options = array(
                'dimension' => 'medium_thumb',
                'class' => '',
                'alt' => $item['Item']['name'],
                'title' => $item['Item']['name'],
                'type' => 'png',
                'full_url' => true
            );
            $item_image = getImageUrl('Item', $item['Attachment'][0], $image_options);
            Configure::write('meta.item_image', $item_image);
        }
        // Check For Normal User
        if (($this->Auth->user('user_type_id') == ConstUserTypes::User or !$this->Auth->user('user_type_id')) && ($item['Item']['item_status_id'] == ConstItemStatus::PendingApproval || $item['Item']['item_status_id'] == ConstItemStatus::Draft)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        // Check for Merchant User
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant && ($item['Item']['item_status_id'] == ConstItemStatus::PendingApproval || $item['Item']['item_status_id'] == ConstItemStatus::Draft)) {
            $merchantUser = $this->Item->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.user_id' => $this->Auth->user('id')
                ) ,
                'fields' => array(
                    'Merchant.id'
                ) ,
                'recursive' => -1
            ));
            if ($item['Item']['merchant_id'] != $merchantUser['Merchant']['id']) throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $item['Item']['name'];
        if (!empty($this->request->params['named']['city'])) {
            $get_current_city = $this->request->params['named']['city'];
        } else {
            $get_current_city = Configure::read('site.city');
        }
        // for side bar main item
        $conditions['Item.item_status_id'] = array(
            ConstItemStatus::Open,
            ConstItemStatus::Tipped,
        );
        $main_items = $this->Item->find('all', array(
            'conditions' => array_merge(array(
                'Item.slug !=' => $slug
            ) , $conditions) ,
            'contain' => array(
                'City',
                'Attachment' => array(
                    'fields' => array(
                        'Attachment.id',
                        'Attachment.dir',
                        'Attachment.filename',
                        'Attachment.width',
                        'Attachment.height'
                    )
                ) ,
            ) ,
            'recursive' => 1,
            'limit' => Configure::read('item.main_item_index_limit') ,
        ));
        $this->set('main_items', $main_items);
		$this->Item->ItemView->create();
        $this->request->data['ItemView']['item_id'] = $item['Item']['id'];
        $this->request->data['ItemView']['user_id'] = ($this->Auth->user('id')) ? $this->Auth->user('id') : 0;
        $this->request->data['ItemView']['ip_id'] = $this->Item->toSaveIp();
        $this->Item->ItemView->save($this->request->data);
        $this->set('get_current_city', $get_current_city);
        $this->set('count', $count);
        $this->set('item', $item);
        $this->set('from_page', 'item_view');
    }
    public function edit($id = null)
    {
        $this->pageTitle = __l('Edit Item');
        $this->loadModel('Attachment');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        
        $id = !empty($id) ? $id : $this->request->data['Item']['id'];
        $item = $this->Item->find('first', array(
            'conditions' => array(
                'Item.id' => $id
            ) ,
            'contain' => array(
                'City'
            ) ,
            'recursive' => 1
        ));
        if (empty($item)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) && $item['Item']['item_status_id'] != ConstItemStatus::Draft) {
           throw new NotFoundException(__l('Invalid request'));
         }
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['OldAttachment'])) {
                foreach($this->request->data['OldAttachment'] as $attachment_id => $is_checked) {
                    if (isset($is_checked['id']) && ($is_checked['id'] == 1)) {
                        $this->Item->Attachment->delete($attachment_id);
                    }
                }
            }
            unset($this->request->data['OldAttachment']);
            unset($this->Item->validate['end_date']['rule2']);
            if (!empty($this->request->data['Item']['send_to_admin']) && $item['Item']['item_status_id'] == ConstItemStatus::Draft) {
                $this->request->data['Item']['item_status_id'] = ConstItemStatus::PendingApproval;
            }
            if (empty($this->request->data['Item']['is_be_next'])) {
                unset($this->request->data['Item']['be_next_increase_price']);
            }
            if (empty($this->request->data['Item']['is_tipped_item'])) {
                $this->request->data['Item']['min_limit'] = 1;
            }
            if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                unset($this->Item->validate['commission_percentage']['rule4']);
            }
            $this->Item->City->set($this->request->data);
            $this->Item->UserInterest->set($this->request->data);
            if ($this->Item->validates() &$this->Item->City->validates() &$this->Item->UserInterest->validates()) {
                if ($this->Item->save($this->request->data)) {
                    // Inserting pass, if given //
                    if (!empty($this->request->data['Item']['pass_code'])) {
                        $split_codes = explode(',', $this->request->data['Item']['pass_code']);
                        $item_passes = array();
                        foreach($split_codes as $key => $value) {
                            $pass_value = trim($value);
                            if (!empty($pass_value)) {
                                $item_passes['id'] = '';
                                $item_passes['item_id'] = $this->request->data['Item']['id'];
                                $item_passes['pass_code'] = $pass_value;
                                $this->Item->ItemPass->save($item_passes);
                            }
                        }
                    }
                    $this->Item->_updateCityItemCount();
                    // Tipping Items
                    if (($this->request->data['Item']['min_limit'] <= $item['Item']['item_user_count']) && $item['Item']['item_status_id'] == ConstItemStatus::Open) {
                        $this->Item->updateAll(array(
                            'Item.item_status_id' => ConstItemStatus::Tipped,
                            'Item.item_tipped_time' => '\'' . date('Y-m-d H:i:s') . '\''
                        ) , array(
                            'Item.item_status_id' => ConstItemStatus::Open,
                            'Item.id' => $item['Item']['id']
                        ));
                        $this->Item->processItemStatus($item['Item']['id']);
                    }
                    $this->Item->set($this->request->data);
                    $foreign_id = $this->request->data['Item']['id'];
                    $this->Item->Attachment->create();
                    if (!isset($this->request->data['Attachment']) && $this->RequestHandler->isAjax()) { // Flash Upload
                        $this->request->data['Attachment']['foreign_id'] = $foreign_id;
                        $this->request->data['Attachment']['description'] = 'Item';
                        $this->XAjax->flashuploadset($this->request->data);
                    } else { // Normal Upload
                        $is_form_valid = true;
                        $upload_photo_count = 0;
                        if (!empty($this->request->data['Attachment'])) {
                            for ($i = 0; $i < count($this->request->data['Attachment']); $i++) {
                                if (!empty($this->request->data['Attachment'][$i]['filename']['tmp_name'])) {
                                    $upload_photo_count++;
                                    $image_info = getimagesize($this->request->data['Attachment'][$i]['filename']['tmp_name']);
                                    $this->request->data['Attachment']['filename'] = $this->request->data['Attachment'][$i]['filename'];
                                    $this->request->data['Attachment']['filename']['type'] = $image_info['mime'];
                                    $this->request->data['Attachment'][$i]['filename']['type'] = $image_info['mime'];
                                    $this->Item->Attachment->Behaviors->attach('ImageUpload', Configure::read('photo.file'));
                                    $this->Item->Attachment->set($this->request->data);
                                    if (!$this->Item->validates() |!$this->Item->Attachment->validates()) {
                                        $attachmentValidationError[$i] = $this->Item->Attachment->validationErrors;
                                        $is_form_valid = false;
                                        $this->Session->setFlash(__l('Item could not be added. Please, try again.') , 'default', null, 'error');
                                    }
                                }
                            }
                            if (!$upload_photo_count) {
                                $this->Item->validates();
                                $this->Item->Attachment->validationErrors[0]['filename'] = __l('Required');
                                $is_form_valid = false;
                            }
                            if (!empty($attachmentValidationError)) {
                                foreach($attachmentValidationError as $key => $error) {
                                    $this->Item->Attachment->validationErrors[$key]['filename'] = $error;
                                }
                            }
                            if ($is_form_valid) {
                                $this->request->data['foreign_id'] = $foreign_id;
                                $this->request->data['Attachment']['description'] = 'Item';
                                $this->XAjax->normalupload($this->request->data, false);
                                $this->Session->setFlash(__l('Item has been added.') , 'default', null, 'success');
                            }
                        }
                    }
                    $this->Session->setFlash(__l('Item has been updated') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'items',
                        'action' => 'index'
                    ));
                }
            } else {
                $this->Session->setFlash(__l('Item could not be updated. Please, try again.') , 'default', null, 'error');
            }
            $attachments = $this->Item->Attachment->find('all', array(
                'conditions' => array(
                    'Attachment.foreign_id' => $this->request->data['Item']['id'],
                    'Attachment.class = ' => 'Item'
                ) ,
                'recursive' => 1,
            ));
            if (!empty($attachments)) {
                foreach($attachments as $attachment) {
                    $this->request->data['Attachment'][] = $attachment['Attachment'];
                }
            }
        } else {
            $this->request->data = $this->Item->find('first', array(
                'conditions' => array(
                    'Item.id' => $id
                ) ,
                'recursive' => 1
            ));
            if (!empty($this->request->data['ItemPass'])) {
                foreach($this->request->data['ItemPass'] as $pass_codes) {
                    $pass_code[] = $pass_codes['pass_code'];
                }
                $pass_code = implode(',', $pass_code);
                $this->set('manual_pass_codes', $pass_code);
            }
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Item']['name'];
        $discounts = array();
        for ($i = 1; $i <= 100; $i++) {
            $discounts[$i] = $i;
        }
        $cities = $this->Item->City->find('list', array(
            'conditions' => array(
                'City.is_approved' => 1,
				'City.is_enable' => 1
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
        $merchants = $this->Item->Merchant->find('list');
        $itemStatuses = $this->Item->ItemStatus->find('list', array());
        $this->set('item', $item);
        if(Configure::read('charity.who_will_choose') == ConstCharityWhoWillChoose::MerchantUser){
            $charities = $this->Item->Charity->find('list', array(
                'conditions' => array(
                    'Charity.is_active =' => 1
                ) ,
                'order' => array(
                    'Charity.name' => 'asc'
                )
            ));
            $this->set(compact('charities'));
        }
        $this->set(compact('cities', 'itemStatuses', 'merchants', 'discounts'));
        $itemCategories = $this->Item->ItemCategory->find('list', array(
            'order' => array(
                'ItemCategory.name' => 'asc'
            )
        ));
        $userInterests = $this->Item->User->UserInterest->find('list', array(
            'order' => array(
                'UserInterest.name' => 'asc'
            )
        ));
        $this->set(compact('itemCategories', 'userInterests'));
    }
    public function add()
    {
        $this->pageTitle = __l('Add Item');
        $this->loadModel('Attachment');
        $this->Item->Behaviors->attach('ImageUpload', Configure::read('image.file'));
        if (!empty($this->request->data)) {
            $this->request->data['Item']['bonus_amount'] = (!empty($this->request->data['Item']['bonus_amount'])) ? $this->request->data['Item']['bonus_amount'] : 0;
            $this->request->data['Item']['commission_percentage'] = (!empty($this->request->data['Item']['commission_percentage'])) ? $this->request->data['Item']['commission_percentage'] : 0;
            if (!empty($this->request->data['OldAttachment'])) {
                $attachmentIds = array();
                foreach($this->request->data['OldAttachment'] as $attachment_id => $is_checked) {
                    if (isset($is_checked['id']) && ($is_checked['id'] == 1)) {
                        $attachmentIds[] = $attachment_id;
                    }
                }
                $attachmentIds = array(
                    'Attachment' => $attachmentIds
                );
                if (!empty($attachmentIds) && empty($this->data['Item']['clone_item_id'])) {
                    $this->Item->Attachment->delete($attachmentIds);
                }
            }
            if (!empty($this->request->data['OldAttachment'])) {
                $oldAttachmentArray = $this->request->data['OldAttachment'];
                unset($this->request->data['OldAttachment']);
            }
            $ini_clone_attachment = 0;
            if (!empty($this->request->data['CloneAttachment'])) {
                $ini_clone_attachment = 1;
            }
            if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                unset($this->Item->validate['commission_percentage']['rule4']);
            }
            if (empty($this->request->data['Item']['is_be_next'])) {
                unset($this->request->data['Item']['be_next_increase_price']);
            }
            $this->Item->set($this->request->data);
            $this->Item->City->set($this->request->data);
            $this->Item->UserInterest->set($this->request->data);
            if ($this->Item->validates() &$this->Item->City->validates() &$this->Item->UserInterest->validates()) {
                $this->Item->create();
                if (!empty($this->request->data['Item']['save_as_draft']) || !empty($this->request->data['Item']['is_save_draft'])) {
                    $this->request->data['Item']['item_status_id'] = ConstItemStatus::Draft;
                } elseif ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                    $this->request->data['Item']['item_status_id'] = ConstItemStatus::Open;
					 $this->request->data['Item']['start_date'] = date('Y-m-d H:i:s');
                } else {
                    $this->request->data['Item']['item_status_id'] = ConstItemStatus::PendingApproval;
                }
                $this->Item->save($this->request->data);
                $item_id = $this->Item->getLastInsertId();
                // Inserting pass, if given //
                if (!empty($this->request->data['Item']['pass_code'])) {
                    $split_codes = explode(',', $this->request->data['Item']['pass_code']);
                    $item_passes = array();
                    foreach($split_codes as $key => $value) {
                        if (!empty($value)) {
                            $this->Item->ItemPass->create();
                            $item_passes['item_id'] = $item_id;
                            $item_passes['pass_code'] = trim($value);
                            $this->Item->ItemPass->save($item_passes);
                        }
                    }
                }
                $this->Item->Attachment->create();
                if (!empty($ini_clone_attachment)) {
                    $this->Item->Attachment->enableUpload(false); //don't trigger upload behavior on save
                    $this->Item->Attachment->create();
                    foreach($this->request->data['CloneAttachment'] as $key => $value) {
                        if (!$oldAttachmentArray[$value['id']]['id']) {
                            $cloneAttachment = $this->Item->Attachment->find('first', array(
                                'conditions' => array(
                                    'Attachment.id' => $value['id']
                                )
                            ));
                            $this->Item->Attachment->create();
                            $data['Attachment']['foreign_id'] = $item_id;
                            $data['Attachment']['class'] = 'Item';
                            $data['Attachment']['mimetype'] = $cloneAttachment["Attachment"]['mimetype'];
                            $data['Attachment']['dir'] = 'Item/' . $item_id;
                            $data['Attachment']['filename'] = $cloneAttachment["Attachment"]['filename'];
                            $upload_path = APP . 'media' . DS . 'Item' . DS . $item_id . DS;
                            new Folder($upload_path, true);
                            $upload_path = $upload_path . $cloneAttachment["Attachment"]['filename'];
                            $source_path = APP . 'media' . DS . 'Item' . DS . $cloneAttachment["Attachment"]['foreign_id'] . DS . $cloneAttachment["Attachment"]['filename'];
                            copy($source_path, $upload_path);
                            $this->Item->Attachment->save($data['Attachment']);
                        }
                    }
                }
                if (!isset($this->request->data['Attachment']) && $this->RequestHandler->isAjax()) { // Flash Upload
                    $this->request->data['Attachment']['foreign_id'] = $item_id;
                    $this->request->data['Attachment']['description'] = 'Item';
                     if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                        if($this->request->data['Item']['item_status_id'] != ConstItemStatus::Draft){
                            $this->Session->write('Item.id', $item_id);
                        }
                    }
                   
                    $this->XAjax->flashuploadset($this->request->data);
                } else { // Normal Upload
                    $is_form_valid = true;
                    $upload_photo_count = 0;
                    if (!empty($this->request->data['Attachment'])) {
                        for ($i = 0; $i < count($this->request->data['Attachment']); $i++) {
                            if (!empty($this->request->data['Attachment'][$i]['filename']['tmp_name'])) {
                                $upload_photo_count++;
                                $image_info = getimagesize($this->request->data['Attachment'][$i]['filename']['tmp_name']);
                                $this->request->data['Attachment']['filename'] = $this->request->data['Attachment'][$i]['filename'];
                                $this->request->data['Attachment']['filename']['type'] = $image_info['mime'];
                                $this->request->data['Attachment'][$i]['filename']['type'] = $image_info['mime'];
                                $this->Item->Attachment->Behaviors->attach('ImageUpload', Configure::read('photo.file'));
                                $this->Item->Attachment->set($this->request->data);
                                if (!$this->Item->validates() |!$this->Item->Attachment->validates()) {
                                    $attachmentValidationError[$i] = $this->Item->Attachment->validationErrors;
                                    $is_form_valid = false;
                                    $this->Session->setFlash(__l('Item could not be added. Please, try again.') , 'default', null, 'error');
                                }
                            }
                        }
                    }
                    if (!$upload_photo_count) {
                        $this->Item->validates();
                        $this->Item->Attachment->validationErrors[0]['filename'] = __l('Required');
                        $is_form_valid = false;
                    }
                    if (!empty($attachmentValidationError)) {
                        foreach($attachmentValidationError as $key => $error) {
                            $this->Item->Attachment->validationErrors[$key]['filename'] = $error;
                        }
                    }
                    if ($is_form_valid) {
                        $this->request->data['foreign_id'] = $this->Item->getLastInsertId();
                        $this->request->data['Attachment']['description'] = 'Item';
                        $this->XAjax->normalupload($this->request->data, false);
                        $this->Session->setFlash(__l('Item has been added.') , 'default', null, 'success');
                    }
                }
                $items = $this->Item->find('first', array(
                    'conditions' => array(
                        'Item.id' => $this->Item->getLastInsertId()
                    ) ,
                    'contain' => array(
                        'Merchant',
                    ) ,
					'recursive' => 0
                ));
                $slug = $items['Item']['slug'];
                $item_id = $items['Item']['id'];
                $this->Session->setFlash(__l('Item has been added') , 'default', null, 'success');
                if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                    $this->redirect(array(
                        'action' => 'index',
                    ));
                } else {
                    $this->redirect(array(
                        'action' => 'merchant',
                        $items['Merchant']['slug']
                    ));
                }
            } else {
                $this->Session->setFlash(__l('Item could not be added. Please, try again.') , 'default', null, 'error');
                if (!empty($this->request->data['Item']['clone_item_id'])) {
                    $cloneItem = $this->Item->find('first', array(
                        'conditions' => array(
                            'Item.id' => $this->request->data['Item']['clone_item_id'],
                        ) ,
                        'contain' => array(
                            'Attachment'
                        ) ,
                        'fields' => array(
                            'Item.user_id',
                            'Item.name',
                        ) ,
                        'recursive' => 2
                    ));
                    $this->request->data['CloneAttachment'] = $cloneItem['Attachment'];
                }
            }
        } else {
            if ($this->Auth->user('user_type_id') == ConstUserTypes::User) {
                throw new NotFoundException(__l('Invalid request'));
            } elseif ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) {
                $merchant = $this->Item->Merchant->find('first', array(
                    'conditions' => array(
                        'Merchant.user_id' => $this->Auth->user('id')
                    ) ,
                    'fields' => array(
                        'Merchant.id',
                        'Merchant.slug',
                    ) ,
                    'recursive' => -1
                ));
                if (empty($merchant)) {
                    throw new NotFoundException(__l('Invalid request'));
                }
                $this->request->data['Item']['merchant_id'] = $merchant['Merchant']['id'];
                $this->request->data['Item']['merchant_slug'] = $merchant['Merchant']['slug'];
            }
            if (!empty($this->request->params['named']['clone_item_id'])) {
                $cloneItem = $this->Item->find('first', array(
                    'conditions' => array(
                        'Item.id' => $this->request->params['named']['clone_item_id'],
                    ) ,
                    'contain' => array(
                        'Attachment',
                        'CitiesItem',
                        'ItemCategoriesItem',
                        'UserInterestItem',
                        'Merchant' => array(
                            'fields' => array(
                                'Merchant.id',
                                'Merchant.slug'
                            ) ,
                        ) ,
                    ) ,
                    'recursive' => 2
                ));
                $this->request->data['Item'] = $cloneItem['Item'];
                $this->request->data['Item']['clone_item_id'] = $this->request->params['named']['clone_item_id'];
                $this->request->data['Item']['merchant_slug'] = $cloneItem['Merchant']['slug'];
                $this->request->data['CloneAttachment'] = $cloneItem['Attachment'];
                if ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant && $this->request->data['Item']['merchant_id'] != $merchant['Merchant']['id']) {
                    throw new NotFoundException(__l('Invalid request'));
                }
                foreach($cloneItem['CitiesItem'] as $city_item) {
                    $city_id[] = $city_item['city_id'];
                }
                $this->set('city_id', $city_id);
                $this->request->data['UserInterest']['UserInterest']=array();
				foreach($cloneItem['UserInterestItem'] as $user_interest_item) {
                    array_push($this->request->data['UserInterest']['UserInterest'],$user_interest_item['user_interest_id']);
                }
                
				if (!empty($cloneItem['ItemCategoriesItem'])) {
				$this->request->data['ItemCategory']['ItemCategory']=array();
					foreach($cloneItem['ItemCategoriesItem'] as $item_category_item) {
						array_push($this->request->data['ItemCategory']['ItemCategory'],$item_category_item['item_category_id']);
					}

				}
            }
            if (($this->Auth->user('user_type_id') != ConstUserTypes::Admin) && (Configure::read('item.is_admin_enable_commission'))):
                $this->request->data['Item']['commission_percentage'] = Configure::read('item.commission_amount');
            endif;
            $this->request->data['Item']['user_id'] = $this->Auth->user('id');
            $this->request->data['Item']['min_limit'] = !empty($this->request->data['Item']['min_limit']) ? $this->request->data['Item']['min_limit'] : 1;
            if (empty($this->request->params['named']['clone_item_id']) && $this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                $this->request->data['Item']['city_id'] = $this->Session->read('city_filter_id');
            }
        }
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
            $merchants = $this->Item->Merchant->find('list', array(
														'order' => array(
																'Merchant.name' => 'asc'
														)
													));
            $this->set(compact('merchants'));
        }
        $cities = $this->Item->City->find('list', array(
            'conditions' => array(
                'City.is_approved' => 1,
				'City.is_enable' => 1
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
        if(Configure::read('charity.who_will_choose') == ConstCharityWhoWillChoose::MerchantUser){
            $charities = $this->Item->Charity->find('list', array(
                'conditions' => array(
                    'Charity.is_active =' => 1
                ) ,
                'order' => array(
                    'Charity.name' => 'asc'
                )
            ));
            $this->set(compact('charities'));
       }
        if (!empty($this->request->data['City']['City'])) {
            foreach($this->request->data['City']['City'] as $city) {
                $city_id[] = $city;
            }
            $this->set(compact('city_id'));
        }
        $this->set(compact('cities'));
        $itemCategories = $this->Item->ItemCategory->find('list', array(
            'order' => array(
                'ItemCategory.name' => 'asc'
            )
        ));
        $userInterests = $this->Item->User->UserInterest->find('list', array(
            'order' => array(
                'UserInterest.name' => 'asc'
            )
        ));
        $this->set(compact('itemCategories', 'userInterests'));
    }
    public function flashupload()
    {
        $this->Item->Attachment->Behaviors->attach('ImageUpload', Configure::read('photo.file'));
        $this->XAjax->flashupload();
    }
    public function invite_friends()
    {
    }
    public function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Item->delete($id)) {
            $this->Item->_updateCityItemCount();
            $this->Session->setFlash(__l('Item deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function update_status($item_id = null)
    {
        if (is_null($item_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->Item->updateAll(array(
            'Item.item_status_id' => ConstItemStatus::PendingApproval
        ) , array(
            'Item.id' => $item_id,
            'Item.item_status_id' => ConstItemStatus::Draft
        ));
        $item = $this->Item->find('first', array(
            'conditions' => array(
                'Item.id' => $item_id
            ) ,
            'contain' => array(
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                    )
                ) ,
                'Attachment',
                'Merchant',
            ) ,
            'recursive' => 2
        ));
        $slug = $item['Item']['slug'];
        $city_name = $item['City']['name'];
        $this->Item->_updateCityItemCount();
        $this->Session->setFlash(__l('Item has been updated') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'items',
            'action' => 'merchant',
            $item['Merchant']['slug']
        ));
    }
    public function admin_index()
    {
        $this->disableCache();
        $title = '';
        $this->_redirectGET2Named(array(
            'filter_id',
            'q'
        ));
        $conditions = array();
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'success') {
            if ($this->Session->read('Item.id')) {
                $item_id = $this->Session->read('Item.id');
                $this->Session->delete('Item.id');
                 $this->Item->_processOpenStatus($item_id);
            }
            }
        if (!empty($this->request->params['named']['merchant'])) {
            $merchant_id = $this->Item->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.slug' => $this->request->params['named']['merchant']
                ) ,
                'recursive' => -1
            ));
            $conditions['Item.merchant_id'] = $merchant_id['Merchant']['id'];
        }
        if (!empty($this->request->params['named']['city_slug'])) {
            $city_id = $this->Item->City->find('first', array(
                'conditions' => array(
                    'City.slug' => $this->request->params['named']['city_slug']
                ) ,
                'recursive' => -1
            ));
            $city_filter_id = $city_id['City']['id'];
        }
        if (!empty($this->request->data['Item']['filter_id'])) {
            $this->request->params['named']['filter_id'] = $this->request->data['Item']['filter_id'];
        }
        if (!empty($this->request->data['Item']['q'])) {
            $this->request->params['named']['q'] = $this->request->data['Item']['q'];
        }
        if (!empty($this->request->params['named']['filter_id'])) {
            $conditions['Item.item_status_id'] = $this->request->params['named']['filter_id'];
            $status = $this->Item->ItemStatus->find('first', array(
                'conditions' => array(
                    'ItemStatus.id' => $this->request->params['named']['filter_id'],
                ) ,
                'fields' => array(
                    'ItemStatus.name'
                ) ,
                'recursive' => -1
            ));
            $title = $status['ItemStatus']['name'];
			// This is for page header used in admin.ctp
			$this->set('title', $title);
        }
        $this->pageTitle = sprintf(__l(' %s Items') , $title);
        if (isset($this->request->params['named']['q'])) {
            $conditions['Item.name LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        // check the filer passed through named parameter
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Item.created) <= '] = 0;
            $this->pageTitle.= __l(' - Created today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Item.created) <= '] = 7;
            $this->pageTitle.= __l(' - Created in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(Item.created) <= '] = 30;
            $this->pageTitle.= __l(' - Created in this month');
        }
        // Citywise admin filter //
        if (!empty($this->request->data['Item']['item_city_id'])) {
            $city_filter_id = $this->request->data['Item']['item_city_id'];
        }
        if (empty($city_filter_id)) {
            $city_filter_id = $this->Session->read('city_filter_id');
        }
        if (!empty($city_filter_id)) {
            $item_cities = $this->Item->City->find('first', array(
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
            if (!empty($city_item_id)) {
                $conditions['Item.id'] = $city_item_id;
            }
        }
		if (!empty($this->request->params['named']['interest_slug'])) {
            $item_interests = $this->Item->UserInterest->find('first', array(
                'conditions' => array(
                    'UserInterest.slug' => $this->request->params['named']['interest_slug']
                ) ,
                'fields' => array(
                    'UserInterest.name'
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
            foreach($item_interests['Item'] as $item_interest) {
                $interest_item_id[] = $item_interest['id'];
            }
            if (!empty($interest_item_id)) {
                $conditions['Item.id'] = $interest_item_id;
            }
        }
		if (!empty($this->request->params['named']['category_slug'])) {
            $item_categories = $this->Item->ItemCategory->find('first', array(
                'conditions' => array(
                    'ItemCategory.slug' => $this->request->params['named']['category_slug']
                ) ,
                'fields' => array(
                    'ItemCategory.name'
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
            foreach($item_categories['Item'] as $item_category) {
                $category_item_id[] = $item_category['id'];
            }
            if (!empty($category_item_id)) {
                $conditions['Item.id'] = $category_item_id;
            }
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
                        'User.email',
                        'User.password',
                        'User.fb_user_id'
                    )
                ) ,
                'City' => array(
                    'fields' => array(
                        'City.id',
                        'City.name',
                        'City.slug',
                    )
                ) ,
				'UserInterest' => array(
                    'fields' => array(
                        'UserInterest.id',
                        'UserInterest.name',
                        'UserInterest.slug',
                    )
                ) ,
				'ItemCategory' => array(
                    'fields' => array(
                        'ItemCategory.id',
                        'ItemCategory.name',
                        'ItemCategory.slug',
                    )
                ) ,
                'ItemStatus' => array(
                    'fields' => array(
                        'ItemStatus.name',
                    )
                ) ,
                'ItemUser' => array(
                    'fields' => array(
                        'distinct(ItemUser.user_id) as count_user'
                    )
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
                    'fields' => array(
                        'Merchant.id',
                        'Merchant.name',
                        'Merchant.slug',
                        'Merchant.address1',
                        'Merchant.address2',
                        'Merchant.city_id',
                        'Merchant.state_id',
                        'Merchant.country_id',
                        'Merchant.zip',
                        'Merchant.url',
                    )
                ) ,
                'Attachment' => array(
                    'fields' => array(
                        'Attachment.id',
                        'Attachment.dir',
                        'Attachment.filename'
                    )
                ) ,
            ) ,
            'order' => array(
                'Item.id' => 'desc'
            )
        );
        if (!empty($this->request->params['named']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->params['named']['q']
            ));
        }
        $itemStatuses = $this->Item->ItemStatus->find('list', array());
        $itemStatusesCount = array();
        $count_conditions = array();
        if (!empty($this->request->params['named']['merchant'])) {
            $merchant_id = $this->Item->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.slug' => $this->request->params['named']['merchant']
                ) ,
                'recursive' => -1
            ));
            $count_conditions['Item.merchant_id'] = $merchant_id['Merchant']['id'];
        }
        if (!empty($this->request->params['named']['city_slug'])) {
            $city_id = $this->Item->City->find('first', array(
                'conditions' => array(
                    'City.slug' => $this->request->params['named']['city_slug']
                ) ,
                'recursive' => -1
            ));
            $city_filter_id = $city_id['City']['id'];
        }
        // Citywise admin filter //
        if (!empty($city_filter_id)) {
            $item_cities = $this->Item->City->find('first', array(
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
            if (!empty($city_item_id)) {
                $count_conditions['Item.id'] = $city_item_id;
            }
        }
        foreach($itemStatuses as $id => $itemStatus) {
            $count_conditions['Item.item_status_id'] = $id;
            $itemStatusesCount[$id] = $this->Item->find('count', array(
                'conditions' => $count_conditions,
                'recursive' => -1
            ));
        }
        $this->set('itemStatusesCount', $itemStatusesCount);
        $this->set('itemStatuses', $itemStatuses);
        $this->set('items', $this->paginate());
        //add more actions depends on the item status
        $moreActions = array();
        if (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstItemStatus::PendingApproval) {
            $moreActions = array(
                ConstItemStatus::Open => __l('Open') ,
                ConstItemStatus::Canceled => __l('Canceled') ,
                ConstItemStatus::Rejected => __l('Rejected') ,
            );
        } elseif (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstItemStatus::Open) {
            $moreActions = array(
                ConstItemStatus::Canceled => __l('Cancel and refund') ,
                ConstItemStatus::Expired => __l('Expired') ,
            );
        } elseif (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstItemStatus::Canceled) {
            $moreActions = array(
                ConstItemStatus::Open => __l('Open') ,
            );
        } elseif (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstItemStatus::Expired) {
            $moreActions = array(
                ConstItemStatus::Refunded => __l('Refunded') ,
            );
        } elseif (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstItemStatus::Tipped) {
            $moreActions = array(
                ConstItemStatus::Closed => __l('Closed') ,
            );
        } elseif (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstItemStatus::Rejected) {
            $moreActions = array(
                ConstItemStatus::Open => __l('Open') ,
                ConstItemStatus::Canceled => __l('Canceled') ,
            );
        } elseif (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstItemStatus::Draft) {
            $moreActions = array(
                ConstItemStatus::Delete => __l('Delete') ,
                ConstItemStatus::Canceled => __l('Canceled') ,
            );
        } elseif (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstItemStatus::Closed) {
            $moreActions = array(
                ConstItemStatus::PaidToMerchant => __l('Pay To Merchant')
            );
        }
        if (!empty($moreActions)) {
            $this->set(compact('moreActions'));
        }
        $cities = $this->Item->City->find('list', array(
            'conditions' => array(
                'City.is_approved' => 1,
				'City.is_enable' => 1
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'success') {
            $this->Session->setFlash(__l('Item has been added.') , 'default', null, 'success');
        }
        $this->set('item_selected_city', $city_filter_id);
        $this->set('cities', $cities);
        $this->set('pageTitle', $this->pageTitle);
    }
    public function items_print()
    {
        //print item details and item users list
        $this->autoRender = false;
        // Checking whether the item belows to the logged in merchant user.
        $merchant = $this->Item->Merchant->find('first', array(
            'conditions' => array(
                'Merchant.user_id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        if (!empty($this->request->params['named']['page_type']) && ((!empty($merchant) && $this->Auth->user('user_type_id') == ConstUserTypes::Merchant) || ($this->Auth->user('user_type_id') == ConstUserTypes::Admin)) && $this->request->params['named']['page_type'] == 'print') {
            $this->layout = 'print';
            if ($this->Auth->user('user_type_id') != ConstUserTypes::Admin) {
                $conditions['Item.merchant_id'] = $merchant['Merchant']['id']; // Checking whether the item belows to the logged in merchant user.

            }
            if (!empty($this->request->params['named']['item_id'])) {
                $conditions['Item.id'] = $this->request->params['named']['item_id'];
            }
            if (!empty($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] != 'all')) {
                $conditions['Item.item_status_id'] = $this->request->params['named']['filter_id'];
            }
            $items = $this->Item->find('all', array(
                'conditions' => $conditions,
                'contain' => array(
                    'ItemUser' => array(
                        'User' => array(
                            'fields' => array(
                                'id',
                                'username',
                                'email',
                            )
                        ) ,
                        'fields' => array(
                            'id',
                            'discount_amount',
                            'quantity',
                            'is_canceled'
                        ) ,
                        'ItemUserPass'
                    ) ,
                    'ItemStatus' => array(
                        'fields' => array(
                            'ItemStatus.id',
                            'ItemStatus.name',
                        )
                    ) ,
                ) ,
                'fields' => array(
                    'Item.id',
                    'Item.name',
                    'Item.event_date',
                    'Item.item_user_count'
                ) ,
                'recursive' => 2
            ));
            Configure::write('debug', 0);
            if (!empty($items)) {
                foreach($items as $item) {
                    foreach($item['ItemUser'] as $itemusers) {
                        if ($itemusers['is_canceled'] == 0) {
                            $data[]['Item'] = array(
                                'itemname' => $item['Item']['name'],
                                'username' => $itemusers['User']['username'],
                                'quantity' => $itemusers['quantity'],
                                'discount_amount' => $itemusers['discount_amount'],
                                'pass_code' => $itemusers['ItemUserPass'],
                                'is_used' => $itemusers['ItemUserPass']
                            );
                        }
                    }
                }
                $item_list['item_name'] = $items['0']['Item']['name'];
                $item_list['event_date'] = $items['0']['Item']['event_date'];
                $item_list['item_user_count'] = $items['0']['Item']['item_user_count'];
                $item_list['item_status'] = $items['0']['ItemStatus']['name'];
                $this->set('items', $data);
                $this->set('item_list', $item_list);
                $this->render('index_print_item_users');
            }
        }
    }
    public function admin_items_print()
    {
        $this->setAction('items_print');
    }
    public function admin_add()
    {
        $this->setAction('add');
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Item');
        $this->loadModel('Attachment');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $id = !empty($id) ? $id : $this->request->data['Item']['id'];
        $item = $this->Item->find('first', array(
            'conditions' => array(
                'Item.id' => $id
            ) ,
            'contain' => array(
                'City'
            ) ,
            'recursive' => 1
        ));
        if (empty($item)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['OldAttachment'])) {
                foreach($this->request->data['OldAttachment'] as $attachment_id => $is_checked) {
                    if (isset($is_checked['id']) && ($is_checked['id'] == 1)) {
                        $this->Item->Attachment->delete($attachment_id);
                    }
                }
            }
            unset($this->request->data['OldAttachment']);
            unset($this->Item->validate['end_date']['rule2']);
            if (!empty($this->request->data['Item']['send_to_admin']) && $item['Item']['item_status_id'] == ConstItemStatus::Draft) {
                $this->request->data['Item']['item_status_id'] = ConstItemStatus::PendingApproval;
            }
            if (empty($this->request->data['Item']['is_be_next'])) {
                unset($this->request->data['Item']['be_next_increase_price']);
            }
            if (empty($this->request->data['Item']['is_tipped_item'])) {
                $this->request->data['Item']['min_limit'] = 1;
            }
            if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                unset($this->Item->validate['commission_percentage']['rule4']);
            }
            $this->Item->City->set($this->request->data);
            $this->Item->UserInterest->set($this->request->data);
            if ($this->Item->validates() &$this->Item->City->validates() &$this->Item->UserInterest->validates()) {
                if ($this->Item->save($this->request->data)) {
                    // Inserting pass, if given //
                    if (!empty($this->request->data['Item']['pass_code'])) {
                        $split_codes = explode(',', $this->request->data['Item']['pass_code']);
                        $item_passes = array();
                        foreach($split_codes as $key => $value) {
                            $pass_value = trim($value);
                            if (!empty($pass_value)) {
                                $item_passes['id'] = '';
                                $item_passes['item_id'] = $this->request->data['Item']['id'];
                                $item_passes['pass_code'] = $pass_value;
                                $this->Item->ItemPass->save($item_passes);
                            }
                        }
                    }
                    // finding again, coz item slug has been changed during edit
                    $item = $this->Item->find('first', array(
                        'conditions' => array(
                            'Item.id' => $this->request->data['Item']['id']
                        ) ,
                        'contain' => array(
                            'CitiesItem',
                            'City'
                        ) ,
                        'recursive' => 1
                    ));
                    $slug = $item['Item']['slug'];
                    $item_id = $item['Item']['id'];
                    $this->Item->_updateCityItemCount();
                    // Tipping Items
                    if (($this->request->data['Item']['min_limit'] <= $item['Item']['item_user_count']) && $item['Item']['item_status_id'] == ConstItemStatus::Open) {
                        $this->Item->updateAll(array(
                            'Item.item_status_id' => ConstItemStatus::Tipped,
                            'Item.item_tipped_time' => '\'' . date('Y-m-d H:i:s') . '\''
                        ) , array(
                            'Item.item_status_id' => ConstItemStatus::Open,
                            'Item.id' => $item['Item']['id']
                        ));
                        $this->Item->processItemStatus($item['Item']['id']);
                    }
                    $this->Item->set($this->request->data);
                    $foreign_id = $this->request->data['Item']['id'];
                    $this->Item->Attachment->create();
                    if (!isset($this->request->data['Attachment']) && $this->RequestHandler->isAjax()) { // Flash Upload
                        $this->request->data['Attachment']['foreign_id'] = $foreign_id;
                        $this->request->data['Attachment']['description'] = 'Item';
                        $this->XAjax->flashuploadset($this->request->data);
                    } else { // Normal Upload
                        $is_form_valid = true;
                        $upload_photo_count = 0;
                        if (!empty($this->request->data['Attachment'])) {
                            for ($i = 0; $i < count($this->request->data['Attachment']); $i++) {
                                if (!empty($this->request->data['Attachment'][$i]['filename']['tmp_name'])) {
                                    $upload_photo_count++;
                                    $image_info = getimagesize($this->request->data['Attachment'][$i]['filename']['tmp_name']);
                                    $this->request->data['Attachment']['filename'] = $this->request->data['Attachment'][$i]['filename'];
                                    $this->request->data['Attachment']['filename']['type'] = $image_info['mime'];
                                    $this->request->data['Attachment'][$i]['filename']['type'] = $image_info['mime'];
                                    $this->Item->Attachment->Behaviors->attach('ImageUpload', Configure::read('photo.file'));
                                    $this->Item->Attachment->set($this->request->data);
                                    if (!$this->Item->validates() |!$this->Item->Attachment->validates()) {
                                        $attachmentValidationError[$i] = $this->Item->Attachment->validationErrors;
                                        $is_form_valid = false;
                                        $this->Session->setFlash(__l('Item could not be added. Please, try again.') , 'default', null, 'error');
                                    }
                                }
                            }
                            if (!$upload_photo_count) {
                                $this->Item->validates();
                                $this->Item->Attachment->validationErrors[0]['filename'] = __l('Required');
                                $is_form_valid = false;
                            }
                            if (!empty($attachmentValidationError)) {
                                foreach($attachmentValidationError as $key => $error) {
                                    $this->Item->Attachment->validationErrors[$key]['filename'] = $error;
                                }
                            }
                            if ($is_form_valid) {
                                $this->request->data['foreign_id'] = $foreign_id;
                                $this->request->data['Attachment']['description'] = 'Item';
                                $this->XAjax->normalupload($this->request->data, false);
                                $this->Session->setFlash(__l('Item has been added.') , 'default', null, 'success');
                            }
                        }
                    }
                    $this->Session->setFlash(__l('Item has been updated') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'items',
                        'action' => 'index'
                    ));
                }
            } else {
                $this->Session->setFlash(__l('Item could not be updated. Please, try again.') , 'default', null, 'error');
            }
            $attachments = $this->Item->Attachment->find('all', array(
                'conditions' => array(
                    'Attachment.foreign_id' => $this->request->data['Item']['id'],
                    'Attachment.class = ' => 'Item'
                ) ,
                'recursive' => 1,
            ));
            if (!empty($attachments)) {
                foreach($attachments as $attachment) {
                    $this->request->data['Attachment'][] = $attachment['Attachment'];
                }
            }
        } else {
            $this->request->data = $this->Item->find('first', array(
                'conditions' => array(
                    'Item.id' => $id
                ) ,
                'recursive' => 1
            ));
            if (!empty($this->request->data['ItemPass'])) {
                foreach($this->request->data['ItemPass'] as $pass_codes) {
                    $pass_code[] = $pass_codes['pass_code'];
                }
                $pass_code = implode(',', $pass_code);
                $this->set('manual_pass_codes', $pass_code);
            }
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Item']['name'];
        $discounts = array();
        for ($i = 1; $i <= 100; $i++) {
            $discounts[$i] = $i;
        }
        $cities = $this->Item->City->find('list', array(
            'conditions' => array(
                'City.is_approved' => 1,
				'City.is_enable' => 1
            ) ,
            'order' => array(
                'City.name' => 'asc'
            )
        ));
        $merchants = $this->Item->Merchant->find('list');
        $itemStatuses = $this->Item->ItemStatus->find('list', array());
        $this->set('item', $item);
        if ($this->Auth->user('id') == ConstUserTypes::Admin) {
            $charities = $this->Item->Charity->find('list', array(
                'conditions' => array(
                    'Charity.is_active =' => 1
                ) ,
                'order' => array(
                    'Charity.name' => 'asc'
                )
            ));
            $this->set(compact('charities'));
        }
        $this->set(compact('cities', 'itemStatuses', 'merchants', 'discounts'));
        $itemCategories = $this->Item->ItemCategory->find('list', array(
            'order' => array(
                'ItemCategory.name' => 'asc'
            )
        ));
        $userInterests = $this->Item->User->UserInterest->find('list', array(
            'order' => array(
                'UserInterest.name' => 'asc'
            )
        ));
        $this->set(compact('itemCategories', 'userInterests'));
        //$merchantid = (!empty($merchant['Merchant']['id']) ? $merchant['Merchant']['id'] : '');
        //$merchant_id = (!empty($this->request->data['Item']['merchant_id']) ? $this->request->data['Item']['merchant_id'] : $merchantid);
        //$branch_addresses = $this->Item->getBranchAddresses($merchant_id);
        //$this->set('branch_addresses', $branch_addresses);

    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Item->delete($id)) {
            $this->Item->_updateCityItemCount();
            $this->Session->setFlash(__l('Item deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    //more actions in admin index page
    public function admin_update()
    {
        $this->autoRender = false;
        if (!empty($this->request->data['Item'])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $itemIds = array();
            foreach($this->request->data['Item'] as $item_id => $is_checked) {
                if ($is_checked['id']) {
                    $itemIds[] = $item_id;
                }
            }
            if ($actionid && !empty($itemIds)) {
                if ($actionid == ConstItemStatus::Open) {
                    $itemsLeft = false;
                    foreach($this->request->data['Item'] as $item_id => $is_checked) {
                        if ($is_checked['id']) {
                            $item = $this->Item->find('first', array(
                                'conditions' => array(
                                    'Item.id' => $item_id
                                ) ,
                                'recursive' => -1
                            ));
                            $this->Item->updateAll(array(
                                'Item.item_status_id' => ConstItemStatus::Open,
                                'Item.start_date' => '\''.date('Y-m-d h:i:s').'\'',
                            ) , array(
                                'Item.id' => $item_id
                            ));
                            $this->Item->_sendInterestMail();
                            $this->Item->_processOpenStatus($item_id);
                            
                        }
                    }
                    $this->Item->_sendSubscriptionMail();
                    $msg = __l('Checked items have been moved to open status. ');
                    if ($itemsLeft) {
                        $msg.= __l('Some of the items are not opened due to the end date and pass expiry date in past.');
                    }
                    $this->Session->setFlash($msg, 'default', null, 'success');
                } else if ($actionid == ConstItemStatus::Canceled) {
                    $openItemIds = $this->Item->find('list', array(
                        'conditions' => array(
                            'Item.id' => $itemIds,
                            'Item.item_status_id' => ConstItemStatus::Open,
                        ) ,
                        'recursive' => -1,
                    ));
                    if (!empty($openItemIds)) {
                        $this->Item->_refundItemAmount('update', array_keys($openItemIds));
                    }
                    //manual refund for items. So items are not closed
                    foreach($itemIds as $item_id) {
                        $is_not_already_refunded = $this->Item->find('first', array(
                            'conditions' => array(
                                'Item.id' => $item_id,
                                'Item.item_status_id !=' => ConstItemStatus::Refunded,
                            ) ,
                            'recursive' => -1,
                        ));
                        if (!empty($is_not_already_refunded)) {
                            $data = array();
                            $data['Item']['id'] = $item_id;
                            $data['Item']['item_status_id'] = ConstItemStatus::Canceled;
                            $data['Item']['item_user_count'] = 0;
                            $data['Item']['item_tipped_time'] = "'0000-00-00 00:00:00'";
                            $data['Item']['is_pass_mail_sent'] = 0;
                            $data['Item']['is_subscription_mail_sent'] = 0;
                            $data['Item']['total_purchased_amount'] = 0;
                            $data['Item']['total_commission_amount'] = 0;
                            $this->Item->save($data);
                        }
                    }
                    $this->Session->setFlash(__l('Checked items have been canceled') , 'default', null, 'success');
                } else if ($actionid == ConstItemStatus::Rejected) {
                    $this->Item->updateAll(array(
                        'Item.item_status_id' => ConstItemStatus::Rejected
                    ) , array(
                        'Item.id' => $itemIds
                    ));
                    $this->Session->setFlash(__l('Checked items have been rejected') , 'default', null, 'success');
                } else if ($actionid == ConstItemStatus::Expired) {
                    //Get the Quantity for selected items.
                    $quantities = $this->Item->find('all', array(
                        'conditions' => array(
                            'Item.id' => $itemIds
                        ) ,
                        'fields' => array(
                            'Item.item_user_count',
                            'Item.id',
                        ) ,
                        'recursive' => -1
                    ));
                    foreach($quantities as $quantity) {
                        if (empty($quantity['Item']['is_anytime_item'])) {
                            if ($quantity['Item']['item_user_count'] == 0) {
                                $data = array();
                                $data['Item']['id'] = $quantity['Item']['id'];
                                $data['Item']['item_status_id'] = ConstItemStatus::Expired;
                                $this->Item->save($data);
                            } else {
                                $this->Item->_refundItemAmount('admin_update', $quantity['Item']['id']);
                            }
                        } else {
                            $itemsLeft = true;
                        }
                    }
                    $msg = __l('Items have been changed as expired. ');
                    if ($itemsLeft) {
                        $msg.= __l('Some of the items are not expired becasue "AnyTime" Item cannot be expired. It can be either cancelled or closed.');
                    }
                    $this->Session->setFlash($msg, 'default', null, 'success');
                } else if ($actionid == ConstItemStatus::Refunded) {
                    $this->Item->_refundItemAmount('admin_update', $itemIds);
                    $this->Session->setFlash(__l('Expired items have been refunded') , 'default', null, 'success');
                } else if ($actionid == ConstItemStatus::Closed) {
                    $this->Item->_closeItems($itemIds);
                    $this->Session->setFlash(__l('Checked items have been closed') , 'default', null, 'success');
                } else if ($actionid == ConstItemStatus::PaidToMerchant) {
                    $this->Item->_payToMerchant('admin_update', $itemIds);
                    $this->Session->setFlash(__l('Checked item amount have been transferred') , 'default', null, 'success');
                } else if ($actionid == ConstItemStatus::Delete) {
                    $this->Item->deleteAll(array(
                        'Item.id' => $itemIds
                    ));
                    $this->Session->setFlash(__l('Checked items have been deleted') , 'default', null, 'success');
                }
					$this->Item->Behaviors->attach('Aggregatable');
					$this->Item->updateRealAggregators();
					$this->Item->Behaviors->detach('Aggregatable');
            }
        }
        $this->Item->_updateCityItemCount();
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect(Router::url('/', true) . $r);
        } else {
            $this->redirect($r);
        }
    }
    //run cron manually from admin side
    public function admin_update_status()
    {
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'cron');
        $this->Cron = new CronComponent($collection);
        $this->Cron->main();
        $this->Item->_updateCityItemCount();
		$this->Session->setFlash(__l('Item status updated successfully'), 'default', null, 'success');
        $this->redirect(array(
			'controller' => 'pages',
			'action' => 'display',
			'tools',
			'admin' => true
		));
    }
    //buy a new item
    public function buy($item_id = null)
    {
        $this->pageTitle = __l('Buy Item');
        if ((!$this->Item->User->isAllowed($this->Auth->user('user_type_id'))) || (is_null($item_id) && empty($this->request->data['Item']['item_id']))) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!$this->Auth->user('id') and !empty($this->request->url)) $this->Session->write('Auth.redirectUrl', $this->request->url);
        if (!empty($this->request->data['Item']['item_id'])) {
            $item_id = $this->request->data['Item']['item_id'];
        }
        $conditions = array();
        $conditions['Item.id'] = $item_id;
        $conditions['Item.item_status_id'] = array(
            ConstItemStatus::Open,
            ConstItemStatus::Tipped
        );
        $item = $this->Item->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'Item.id',
                'Item.name',
                'Item.slug',
                'Item.description',
                'Item.min_limit',
                'Item.max_limit',
                'Item.item_user_count',
                'Item.buy_min_quantity_per_user',
                'Item.buy_max_quantity_per_user',
                'Item.charity_id',
                'Item.charity_percentage',
                'Item.price',
                'Item.menu',
                'Item.event_date',
                'Item.end_date',
                'Item.merchant_id',
                'Item.is_be_next',
                'Item.be_next_increase_price',
            ) ,
            'contain'=>array(
             'Charity'=>array(
              'fields'=>array(
                'Charity.name',
                'Charity.url',
              )
             ),
             'ItemUser'
            ),
            'recursive' => 2
        ));
        $user = $this->Item->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id') ,
            ) ,
            'fields' => array(
                'User.id',
                'User.fb_user_id',
                'User.email',
            ) ,
            'contain' => array(
                'ItemUser'
            ) ,
            'recursive' => 1
        ));
        if (empty($item)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $user_quantity = '';
        if (!empty($user) && !empty($item['Item']['buy_max_quantity_per_user'])) {
            foreach($user['ItemUser'] as $user_pass) {
                if ($user_pass['item_id'] == $item_id) {
                    $user_quantity+= $user_pass['quantity'];
                }
            }
        }
        $user_available_balance = 0;
        if ($this->Auth->user('id')) {
            $user_available_balance = $this->Item->User->checkUserBalance($this->Auth->user('id'));
        }
        if (!empty($this->request->data)) {
            if ($this->request->data['Item']['user_id'] == $this->Auth->user('id')) {
                //purchase item before login and do the validations
                if (!$this->Auth->user('id')) {
                    $this->Item->User->set($this->request->data);
                    $this->Item->User->validates();
                }
                //before login user_id is null
                if (empty($this->request->data['Item']['user_id'])) {
                    unset($this->Item->validate['user_id']);
                }
                // If wallet act like groupon enabled, and purchase with wallet enabled, setting below for making purchase through wallet //
                if (Configure::read('wallet.is_handle_wallet') && !empty($this->request->data['Item']['is_purchase_via_wallet'])) {
                    $this->request->data['Item']['payment_gateway_id'] = ConstPaymentGateways::Wallet;
                }
                // Free item check
                if ($item['Item']['price'] != 0) {
                    //validation for credit card details
                    if ($this->request->data['Item']['payment_gateway_id'] == ConstPaymentGateways::CreditCard) {
                        $this->Item->validate = array_merge($this->Item->validate, $this->Item->validateCreditCard);
                    } else if (($this->request->data['Item']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet && isset($this->request->data['Item']['payment_profile_id']) && empty($this->request->data['Item']['payment_profile_id']))) {
                        $this->Item->validate = array_merge($this->Item->validate, $this->Item->validateCreditCard);
                        if ($this->request->data['Item']['is_show_new_card'] == 0) {
                            $payment_gateway_id_validate = array(
                                'payment_profile_id' => array(
                                    'rule1' => array(
                                        'rule' => 'notempty',
                                        'message' => __l('Required')
                                    )
                                )
                            );
                            $this->Item->validate = array_merge($this->Item->validate, $payment_gateway_id_validate);
                        }
                    } else if ($this->request->data['Item']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet && (!isset($this->request->data['Item']['payment_profile_id']))) {
                        $this->Item->validate = array_merge($this->Item->validate, $this->Item->validateCreditCard);
                    }
                } else {
                    $this->request->data['Item']['payment_gateway_id'] == ConstPaymentGateways::Wallet;
                }
                $is_valid_itemuser = true;
                $ItemUserPassValidationErrors = array();
                foreach($this->request->data['ItemUserPass'] as $key => $itemuser) {
                    if ($key != 0) {
                        $itemuserData['ItemUserPass']['guest_name'] = $itemuser['guest_name'];
                        $itemuserData['ItemUserPass']['guest_email'] = $itemuser['guest_email'];
                        $this->Item->ItemUser->ItemUserPass->set($itemuserData);
                        if (!$this->Item->ItemUser->ItemUserPass->validates()) {
                            $is_valid_itemuser = false;
                            $ItemUserPassValidationErrors[$key] = $this->Item->ItemUser->ItemUserPass->validationErrors;
                        }
                        unset($this->Item->ItemUser->ItemUserPass->validationErrors);
                        if (!empty($ItemUserPassValidationErrors)) {
                            $this->Item->ItemUser->ItemUserPass->validationErrors = $ItemUserPassValidationErrors;
                        }
                    }
                }
				$total_item_amount = $this->request->data['Item']['total_item_amount'] = $item['Item']['price']*$this->request->data['Item']['quantity'];
                $this->Item->set($this->request->data);
				$tmp_price = $item['Item']['price'];
				if ($item['Item']['is_be_next']) {
					$tmp_price += count($item['ItemUser']) *$item['Item']['be_next_increase_price'];
				}
				$total_item_amount = $tmp_price*$this->request->data['Item']['quantity'];
                $this->Item->validates();
                $user_details_updated = true;
                //for facebook users need to update email address at first time
                if (!empty($user['User']['fb_user_id']) && empty($user['User']['email'])) {
                    $this->request->data['User']['id'] = $this->Auth->user('id');
                    $this->Item->User->set($this->request->data['User']);
                    if ($this->Item->User->validates() && empty($this->Item->User->validationErrors)) {
                        $this->Item->User->save($this->request->data['User']);
                        if (empty($_SESSION['Auth']['User']['cim_profile_id'])) {
                            $this->Item->User->_createCimProfile($this->Auth->user('id'));
                        }
                    } else {
                        $user_details_updated = false;
                    }
                }
                // <-- For iPhone App code
                if ($this->RequestHandler->prefers('json') && $this->request->data['Item']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet && empty($this->request->data['Item']['payment_profile_id'])) {
                    $resonse = array(
                        'status' => 1,
                        'message' => __l('Your Purchase could not be completed.')
                    );
                    $this->view = 'Json';
                    $this->set('json', (empty($this->viewVars['iphone_response'])) ? $resonse : $this->viewVars['iphone_response']);
                }
                // For iPhone App code -->
                if (empty($this->Item->validationErrors) && $user_details_updated && $is_valid_itemuser) {
                    //for wallet payment if user have enough wallet amt send to _buyItem method
                    if ($this->Auth->user('id') && $this->request->data['Item']['payment_gateway_id'] == ConstPaymentGateways::Wallet && $user_available_balance >= $total_item_amount) {
                        $this->_buyItem($this->request->data);
                    } else {
                        //guset users and users who have less amount in wallet or credit card payment or paypal auth payment
                        $this->process_user($item);
                    }
                }
                // <-- For iPhone App code
                else {
                    if ($this->RequestHandler->prefers('json')) {
                        $resonse = array(
                            'status' => 1,
                            'message' => __l('Your Purchase could not be completed.')
                        );
                        $this->view = 'Json';
                        $this->set('json', (empty($this->viewVars['iphone_response'])) ? $resonse : $this->viewVars['iphone_response']);
                    } else {
                        $this->set('error', 1);
                        $this->Session->setFlash(__l('Your Purchase could not be completed.') , 'default', null, 'error');
                    }
                }
                // For iPhone App code -->
                //ehrn validation errors for user fields unset passwords
                if (!$this->Auth->user('id')) {
                    unset($this->request->data['User']['passwd']);
                    unset($this->request->data['User']['confirm_password']);
                }
            } else {
                $this->set('error', 1);
                $this->Session->setFlash(__l('Invalid data entered. Your purchase has been cancelled.') , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'items',
                    'action' => 'view',
                    $item['Item']['slug']
                ));
            }
        } else {
            $this->request->data['Item']['is_gift'] = (!empty($this->request->params['named']['type'])) ? 1 : 0;
            $this->request->data['Item']['quantity'] = 1;
			if ($item['Item']['is_be_next']) {
                $item['Item']['price']+= count($item['ItemUser']) *$item['Item']['be_next_increase_price'];
            }
            $this->request->data['Item']['item_amount'] = $item['Item']['price']*$this->request->data['Item']['quantity'];
            $this->request->data['Item']['total_item_amount'] = $this->request->data['Item']['item_amount'];
            $this->request->data['Item']['item_id'] = $item_id;
            $this->request->data['Item']['is_show_new_card'] = 0;
            $this->request->data['Item']['charity_id'] = $item['Item']['charity_id'];
            //if user logged in check whether user eligible to buy item
            if ($this->Auth->user('id')) {
                $this->request->data['ItemUserPass'][0]['guest_name'] = $this->Auth->user('username');
                $this->request->data['ItemUserPass'][0]['guest_email'] = $this->Auth->user('email');
                if (!$this->Item->isEligibleForBuy($item_id, $this->Auth->user('id') , $item['Item']['buy_max_quantity_per_user'])) {
                    $this->Session->setFlash(sprintf(__l('You can\'t buy this item. Your maximum allowed limit %s is over') , $item['Item']['buy_max_quantity_per_user']) , 'default', null, 'error');
                    $this->redirect(array(
                        'controller' => 'items',
                        'action' => 'view',
                        $item['Item']['slug']
                    ));
                }
            }
            //intially merge credit card validation array
            $this->Item->validate = array_merge($this->Item->validate, $this->Item->validateCreditCard);
        }
        $this->request->data['Item']['user_id'] = $this->Auth->user('id');
        // Checking payment settings enabled
        $payment_options = $this->Item->getGatewayTypes('is_enable_for_buy_a_item');
        // If 'handle like groupon' enabled, unset wallet. Since, all purchase should proceed through wallet first, coz it is compulsary.
        if (Configure::read('wallet.is_handle_wallet')) {
            unset($payment_options[ConstPaymentGateways::Wallet]);
        }
        if ($item['Item']['price'] != 0) {
            //credit card related fields
            if (!empty($payment_options[ConstPaymentGateways::CreditCard]) || !empty($payment_options[ConstPaymentGateways::AuthorizeNet])) {
                $gateway_options['cities'] = $this->Item->Merchant->City->find('list', array(
                    'conditions' => array(
                        'City.is_approved =' => 1
                    ) ,
                    'fields' => array(
                        'City.name',
                        'City.name'
                    ) ,
                    'order' => array(
                        'City.name' => 'asc'
                    )
                ));
                $gateway_options['states'] = $this->Item->Merchant->State->find('list', array(
                    'conditions' => array(
                        'State.is_approved =' => 1
                    ) ,
                    'fields' => array(
                        'State.code',
                        'State.name'
                    ) ,
                    'order' => array(
                        'State.name' => 'asc'
                    )
                ));
                $gateway_options['countries'] = $this->Item->Merchant->Country->find('list', array(
                    'fields' => array(
                        'Country.iso2',
                        'Country.name'
                    ) ,
                    'conditions' => array(
                        'Country.iso2 != ' => '',
                    ) ,
                    'order' => array(
                        'Country.name' => 'asc'
                    ) ,
                ));
                $gateway_options['creditCardTypes'] = array(
                    'Visa' => __l('Visa') ,
                    'MasterCard' => __l('MasterCard') ,
                    'Discover' => __l('Discover') ,
                    'Amex' => __l('Amex')
                );
                if (empty($this->request->data['Item']['payment_gateway_id'])) {
                    if (!empty($payment_options[ConstPaymentGateways::AuthorizeNet])) {
                        $this->request->data['Item']['payment_gateway_id'] = ConstPaymentGateways::AuthorizeNet;
                    } elseif (!empty($payment_options[ConstPaymentGateways::CreditCard])) {
                        $this->request->data['Item']['payment_gateway_id'] = ConstPaymentGateways::CreditCard;
                    }
                }
            } elseif (!empty($payment_options[ConstPaymentGateways::PayPalAuth]) && empty($this->request->data['Item']['payment_gateway_id'])) {
                $this->request->data['Item']['payment_gateway_id'] = ConstPaymentGateways::PayPalAuth;
            } elseif (!empty($payment_options[ConstPaymentGateways::Wallet]) && empty($this->request->data['Item']['payment_gateway_id'])) {
                $this->request->data['Item']['payment_gateway_id'] = ConstPaymentGateways::Wallet;
            }
        } else {
            $this->request->data['Item']['payment_gateway_id'] = ConstPaymentGateways::Wallet;
        }
        $gateway_options['paymentGateways'] = $payment_options;
        if (!$this->Auth->user()) {
            unset($gateway_options['paymentGateways'][ConstPaymentGateways::Wallet]);
        } else {
            $userPaymentProfiles = $this->Item->User->UserPaymentProfile->find('all', array(
                'fields' => array(
                    'UserPaymentProfile.masked_cc',
                    'UserPaymentProfile.cim_payment_profile_id',
                    'UserPaymentProfile.is_default'
                ) ,
                'conditions' => array(
                    'UserPaymentProfile.user_id' => $this->Auth->user('id')
                ) ,
            ));
            foreach($userPaymentProfiles as $userPaymentProfile) {
                $gateway_options['Paymentprofiles'][$userPaymentProfile['UserPaymentProfile']['cim_payment_profile_id']] = $userPaymentProfile['UserPaymentProfile']['masked_cc'];
                if (!empty($userPaymentProfile['UserPaymentProfile']['is_default'])) {
                    $this->request->data['Item']['payment_profile_id'] = $userPaymentProfile['UserPaymentProfile']['cim_payment_profile_id'];
                }
            }
        }
        $states = $this->Item->Merchant->State->find('list', array(
            'conditions' => array(
                'State.is_approved =' => 1
            ) ,
            'fields' => array(
                'State.code',
                'State.name'
            ) ,
            'order' => array(
                'State.name' => 'asc'
            )
        ));
        if (empty($gateway_options['Paymentprofiles'])) {
            $this->request->data['Item']['is_show_new_card'] = 1;
        }
        $this->set('states', $states);
        $this->set('gateway_options', $gateway_options);
        $this->set('item', $item);
        $this->set('user', $user);
        $this->set('user_quantity', $user_quantity);
        $this->set('user_available_balance', $user_available_balance);
        $this->request->data['Item']['cvv2Number'] = $this->request->data['Item']['creditCardNumber'] = '';
        if (Configure::read('charity.who_will_choose') == ConstCharityWhoWillChoose::Buyer) {
            $charities = $this->Item->Charity->find('list', array(
                'conditions' => array(
                    'Charity.is_active =' => 1
                ) ,
                'order' => array(
                    'Charity.name' => 'asc'
                )
            ));
            $this->set(compact('charities'));
        }
    }
    //for new users or who have low balance amount or credit card payment or paypal auth
    public function process_user($item)
    {
        $this->loadModel('TempPaymentLog');
        $this->loadModel('EmailTemplate');
        $is_purchase_with_wallet_amount = 0;
        $this->Session->write('Auth.last_bought_item_slug', $item['Item']['slug']);
        if (!empty($this->request->data)) {
            if ($item['Item']['is_be_next']) {
                $item['Item']['price']+= count($item['ItemUser']) *$item['Item']['be_next_increase_price'];
            }
            $total_item_amount = $item['Item']['price']*$this->request->data['Item']['quantity'];
            $valid_user = true;
            //already registered users
            if ($this->Auth->user('id')) {
                //already logged in user
                $user_available_balance = $this->Item->User->checkUserBalance($this->Auth->user('id'));
                $amount_needed = $total_item_amount;
                //when wallet amount less than total amount check needed amount
                if ($this->request->data['Item']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
                    $valid_user = false;
                    $is_show_credit_card = 0;
                    $this->set('is_show_credit_card', $is_show_credit_card);
                    // <-- For iPhone App code
                    if ($this->RequestHandler->prefers('json')) {
                        $resonse = array(
                            'status' => 1,
                            'message' => __l('Purchase via wallet not possible as the total purchase amount exceeded your wallet balance.')
                        );
                        $this->view = 'Json';
                        $this->set('json', (empty($this->viewVars['iphone_response'])) ? $resonse : $this->viewVars['iphone_response']);
                    } else {
                        $this->Session->setFlash(__l('Purchase via wallet not possible as the total purchase amount exceeded your wallet balance.') , 'default', null, 'error');
                    }
                    // For iPhone App code -->
                    //$amount_needed = $total_item_amount-$user_available_balance;

                }
            } else {
                //new users register process
                $amount_needed = $total_item_amount;
                $this->Item->User->create();
                $this->Item->User->set($this->request->data['User']);
                if ($this->Item->User->validates()) {
                    $this->request->data['User']['is_active'] = 1;
                    $this->request->data['User']['is_email_confirmed'] = 1;
                    $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['passwd']);
                    $this->request->data['User']['user_type_id'] = ConstUserTypes::User;
                    $this->request->data['User']['ip_id'] = $this->RequestHandler->getClientIP();
                    if ($this->Item->User->save($this->request->data['User'], false)) {
                        $user_id = $this->Item->User->getLastInsertId();
                        $this->Item->User->_createCimProfile($user_id);
                        $this->_sendWelcomeMail($user_id, $this->request->data['User']['email'], $this->request->data['User']['username']);
                        $this->request->data['UserProfile']['user_id'] = $user_id;
                        $this->Item->User->UserProfile->create();
                        $this->Item->User->UserProfile->save();
                        $this->Auth->login($this->request->data['User']);
						$this->setMaxmindInfo('login');
						$this->request->data['ItemUserPass'][0]['guest_name'] = $this->request->data['User']['username'];
						$this->request->data['ItemUserPass'][0]['guest_email'] = $this->request->data['User']['email'];
                        $this->request->data['Item']['user_id'] = $user_id;
                        // send to admin mail if is_admin_mail_after_register is true
                        if (Configure::read('user.is_admin_mail_after_register')) {
                            $email = $this->EmailTemplate->selectTemplate('New User Join');
                            $emailFindReplace = array(
                                '##SITE_URL##' => Router::url('/', true) ,
                                '##USERNAME##' => $this->request->data['User']['username'],
                                '##SITE_NAME##' => Configure::read('site.name') ,
                                '##SIGNUP_IP##' => $this->RequestHandler->getClientIP() ,
                                '##EMAIL##' => $this->request->data['User']['email'],
                                '##CONTACT_URL##' => Router::url(array(
                                    'controller' => 'contacts',
                                    'action' => 'add',
                                    'city' => $this->request->params['named']['city'],
                                    'admin' => false
                                ) , true) ,
                                '##FROM_EMAIL##' => $this->Item->User->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
                                '##SITE_LOGO##' => Router::url(array(
                                    'controller' => 'img',
                                    'action' => 'blue-theme',
                                    'logo-email.png',
                                    'admin' => false
                                ) , true) ,
                            );
                            // Send e-mail to users
                            $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
                            $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
                            $this->Email->to = Configure::read('site.contact_email');
                            $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                            $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                            $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                        }
                    }
                } else {
                    $valid_user = false;
                }
            }
            //payment process
            if ($valid_user) {
                if ($this->request->data['Item']['payment_gateway_id'] == ConstPaymentGateways::CreditCard) {
                    $this->_buyItem($this->request->data);
                } else if ($this->request->data['Item']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
                    $this->_buyItem($this->request->data);
                } else {
                    //paypal process
                    if ($this->request->data['Item']['payment_gateway_id'] == ConstPaymentGateways::CreditCard) {
                        $payment_gateway_id = ConstPaymentGateways::PayPalAuth;
                    } elseif ($this->request->data['Item']['payment_gateway_id'] == ConstPaymentGateways::AuthorizeNet) {
                        $payment_gateway_id = ConstPaymentGateways::AuthorizeNet;
                    } elseif ($this->request->data['Item']['payment_gateway_id'] == ConstPaymentGateways::PagSeguro) {
                        $payment_gateway_id = ConstPaymentGateways::PagSeguro;
                    } else {
                        $payment_gateway_id = ConstPaymentGateways::PayPalAuth;
                    }
                    $paymentGateway = $this->Item->User->Transaction->PaymentGateway->find('first', array(
                        'conditions' => array(
                            'PaymentGateway.id' => $payment_gateway_id,
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
                    $this->pageTitle.= ' - ' . sprintf(__l('Buy %s Item') , $item['Item']['name']);
                    $this->set('gateway_name', $paymentGateway['PaymentGateway']['name']);
                    if (empty($paymentGateway)) {
                        throw new NotFoundException(__l('Invalid request'));
                    }
                    $action = strtolower(str_replace(' ', '', $paymentGateway['PaymentGateway']['name']));
                    if ($paymentGateway['PaymentGateway']['name'] == 'PayPal') {
                        Configure::write('paypal.is_testmode', $paymentGateway['PaymentGateway']['is_test_mode']);
                        if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                            foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                                if ($paymentGatewaySetting['key'] == 'payee_account') {
                                    Configure::write('paypal.account', $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value']);
                                }
                                if ($paymentGatewaySetting['key'] == 'receiver_emails') {
                                    $this->Paypal->paypal_receiver_emails = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                                }
                            }
                        }
                        // If enabled, purchase amount is first taken with amount in wallet and then passed to CreditCard //
                        if (Configure::read('wallet.is_handle_wallet')) {
                            $user_available_balance = $this->Item->User->checkUserBalance($this->Auth->user('id'));
                            $amount_needed = $amount_needed-$user_available_balance;
                            $is_purchase_with_wallet_amount = 1;
                        }
                        $city = $this->Item->City->find('first', array(
                            'conditions' => array(
                                'City.slug' => $this->request->params['named']['city']
                            ) ,
                            'fields' => array(
                                'City.id'
                            ) ,
                            'recursive' => -1
                        ));
                        $cmd = '_xclick';
                        $cookie_value = $this->Cookie->read('referrer');
                        //gateway options set
						$lat = '';
						$long = '';
						if (!empty($_COOKIE['_geo'])) {
							$_geo = explode('|', $_COOKIE['_geo']);
							$lat = $_geo[3];
							$long = $_geo[4];
						}
                        // Currency Conversion Process //
                        $get_conversion = $this->_convertAmount($amount_needed);
                        // Storing the guest name in the temp payment table
                        $temp_payment['user_id'] = $this->Auth->user('id');
                        $temp_payment['item_id'] = $this->request->data['Item']['item_id'];
                        $temp_payment['sub_item_id'] = (!empty($this->request->data['Item']['sub_item_id'])) ? $this->request->data['Item']['sub_item_id'] : '';
                        $temp_payment['is_gift'] = $this->request->data['Item']['is_gift'];
                        $temp_payment['quantity'] = $this->request->data['Item']['quantity'];
                        $temp_payment['payment_gateway_id'] = $this->request->data['Item']['payment_gateway_id'];
                        $temp_payment['payment_type'] = 'Item Purchase';
                        $temp_payment['is_purchase_with_wallet_amount'] =  $is_purchase_with_wallet_amount;
                        $temp_payment['ip'] = $this->TempPaymentLog->toSaveIp();
                        $temp_payment['amount_needed'] =$get_conversion['amount'];
                        $temp_payment['currency_code'] = $get_conversion['currency_code'];
                        $temp_payment['message'] = !empty($this->request->data['Item']['message']) ? $this->request->data['Item']['message'] : '';
                        $temp_payment['referred_user_id ']=(!empty($cookie_value['refer_id'])) ? $cookie_value['refer_id'] : null;
                        $temp_payment['city_id'] = $city['City']['id'];
                        $temp_payment['latitude'] = $lat;
                        $temp_payment['longitude'] = $long;
                        $temp_payment['charity_id'] = !empty($this->request->data['Item']['charity_id']) ? $this->request->data['Item']['charity_id'] : '';
                        $temp_payment['original_amount_needed']=$amount_needed;
                        if (!empty($this->request->data['ItemUserPass'])) {
                            $guest_names = array();
                            $guest_emails = array();
                            foreach($this->request->data['ItemUserPass'] as $guest) {
                                array_push($guest_names, $guest['guest_name']);
                                array_push($guest_emails, $guest['guest_email']);
                            }
                            $temp_payment['guest_name'] = serialize($guest_names);
                            $temp_payment['guest_email'] = serialize($guest_emails);
                        }
                        $transaction_data['TempPaymentLog'] = $temp_payment;
                        $this->TempPaymentLog->save($transaction_data);
                        $temp_payment_id = $this->TempPaymentLog->getLastInsertId();
                        
                        $gateway_options = array(
                            'cmd' => $cmd,
                            'notify_url' => Router::url('/', true) . 'items/processpayment/paypal',
                            'cancel_return' => Router::url('/', true) . 'items/payment_cancel/' . $payment_gateway_id,
                            'return' => Router::url('/', true) . 'items/payment_success/' . $payment_gateway_id . '/' . $this->request->data['Item']['item_id'],
                            'item_name' => $item['Item']['name'],
                            'currency_code' => $get_conversion['currency_code'],
                            'amount' => $get_conversion['amount'],
                            'temp_payment_id'=>$temp_payment_id,
							 'user_defined' => array(
                                'user_id' => $this->Auth->user('id') ,
                                'item_id' => $this->request->data['Item']['item_id'],                                
                                'temp_payment_id' => $this->TempPaymentLog->getLastInsertId()
                            ) ,
                        );
                        //for paypal auth
                        if ($this->request->data['Item']['payment_gateway_id'] == ConstPaymentGateways::PayPalAuth) {
                            $gateway_options['paymentaction'] = 'authorization';
                        }
                        $this->set('gateway_options', $gateway_options);
                    } elseif ($paymentGateway['PaymentGateway']['name'] == 'AuthorizeNet') {
                        // If enabled, purchase amount is first taken with amount in wallet and then passed to CreditCard //
                        if (Configure::read('wallet.is_handle_wallet')) {
                            $user_available_balance = $this->Item->User->checkUserBalance($this->Auth->user('id'));
                            $amount_needed1 = $amount_needed-$user_available_balance;
                            $is_purchase_with_wallet_amount = 1;
                        }
                        if (Configure::read('wallet.is_handle_wallet')) {
                            $this->request->data['Item']['amount'] = $amount_needed1;
                            $this->request->data['Item']['wallet_amount'] = $user_available_balance;
                        } else {
                            $this->request->data['Item']['amount'] = $amount_needed;
                        }
                        $this->request->data['Item']['amount'] = $this->Item->_convertAuthorizeAmount($this->request->data['Item']['amount']);
                        $user = $this->Item->User->find('first', array(
                            'conditions' => array(
                                'User.id' => $this->Auth->user('id')
                            ) ,
                            'fields' => array(
                                'User.id',
                                'User.cim_profile_id'
                            )
                        ));
                        if (!empty($this->request->data['Item']['creditCardNumber'])) {
                            //create payment profile
                            $data = $this->request->data['Item'];
                            $data['expirationDate'] = $this->request->data['Item']['expDateYear']['year'] . '-' . $this->request->data['Item']['expDateMonth']['month'];
                            $data['customerProfileId'] = $user['User']['cim_profile_id'];
                            $payment_profile_id = $this->Item->User->_createCimPaymentProfile($data);
                            if (is_array($payment_profile_id) && !empty($payment_profile_id['payment_profile_id']) && !empty($payment_profile_id['masked_cc'])) {
                                $payment['UserPaymentProfile']['user_id'] = $this->Auth->user('id');
                                $payment['UserPaymentProfile']['cim_payment_profile_id'] = $payment_profile_id['payment_profile_id'];
                                $payment['UserPaymentProfile']['masked_cc'] = $payment_profile_id['masked_cc'];
                                $payment['UserPaymentProfile']['is_default'] = 0;
                                $this->Item->User->UserPaymentProfile->save($payment);
                                $this->request->data['Item']['payment_profile_id'] = $payment_profile_id['payment_profile_id'];
                            } else {
                                $this->Session->setFlash(sprintf(__l('Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.') , $payment_profile_id['message']) , 'default', null, 'error');
                                $this->redirect(array(
                                    'controller' => 'items',
                                    'action' => 'index'
                                ));
                            }
                        }
                        if (!empty($this->request->data['Item']['payment_profile_id'])) {
                            $data['customerProfileId'] = $user['User']['cim_profile_id'];
                            $data['customerPaymentProfileId'] = $this->request->data['Item']['payment_profile_id'];
                            $data['amount'] = $this->request->data['Item']['amount'];
                            $data['quantity'] = $this->request->data['Item']['quantity'];
                            $data['item_id'] = $this->request->data['Item']['item_id'];
                            $tmp_item = $this->Item->find('first', array(
                                'conditions' => array(
                                    'Item.id' => $this->request->data['Item']['item_id'],
                                    'Item.item_status_id' => array(
                                        ConstItemStatus::Open,
                                        ConstItemStatus::Tipped
                                    )
                                ) ,
                                'recursive' => -1
                            ));
                            if ($tmp_item['Item']['min_limit'] <= ($tmp_item['Item']['item_user_count']+$this->request->data['Item']['quantity'])) {
                                // is going to tipped or already tipped. so no need to authorize the transaction
                                $type = 'profileTransAuthCapture';
                            } else {
                                $type = 'profileTransAuthOnly';
                            }
                            $response = $this->Item->User->_createCustomerProfileTransaction($data, $type);
                            if (!empty($response['cim_approval_code'])) {
                                if (!empty($response['cim_approval_code'])) {
                                    $item_user['ItemUser']['cim_approval_code'] = $response['cim_approval_code'];
                                }
                                if (!empty($response['cim_transaction_id'])) {
                                    $item_user['ItemUser']['cim_transaction_id'] = $response['cim_transaction_id'];
                                }
                                $city = $this->Item->City->find('first', array(
                                    'conditions' => array(
                                        'City.slug' => $this->request->params['named']['city']
                                    ) ,
                                    'fields' => array(
                                        'City.id'
                                    ) ,
                                    'recursive' => -1
                                ));
                                $item_user['ItemUser']['city_id'] = $city['City']['id'];
								if (!empty($_COOKIE['_geo'])) {
									$_geo = explode('|', $_COOKIE['_geo']);
									$item_user['ItemUser']['latitude'] = $_geo[3];
									$item_user['ItemUser']['longitude'] = $_geo[4];
								}
                                $item_user['ItemUser']['quantity'] = $this->request->data['Item']['quantity'];
                                $item_user['ItemUser']['item_id'] = $this->request->data['Item']['item_id'];
                                if (!empty($this->request->data['Item']['sub_item_id'])) {
                                    $item_user['ItemUser']['sub_item_id'] = $this->request->data['Item']['sub_item_id'];
                                }
                                $item_user['ItemUser']['is_paid'] = (!empty($response['capture'])) ? 1 : 0;
                                $item_user['ItemUser']['is_gift'] = $this->request->data['Item']['is_gift'];
                                $item_user['ItemUser']['user_id'] = $this->Auth->user('id');
                                $item_user['ItemUser']['discount_amount'] = $amount_needed;
                                $item_user['ItemUser']['payment_gateway_id'] = !empty($this->request->data['Item']['payment_gateway_id']) ? $this->request->data['Item']['payment_gateway_id'] : ConstPaymentGateways::AuthorizeNet;
                                $item_user['ItemUser']['payment_profile_id'] = $this->request->data['Item']['payment_profile_id'];
                                $pass_code = $this->_uuid();
                                $item_user['ItemUser']['pass_code'] = $pass_code;
                                if ($this->request->data['Item']['is_gift']) {
                                    $item_user['ItemUser']['gift_email'] = $this->request->data['Item']['gift_email'];
                                    $item_user['ItemUser']['message'] = $this->request->data['Item']['message'];
                                    $item_user['ItemUser']['gift_to'] = $this->request->data['Item']['gift_to'];
                                    $item_user['ItemUser']['gift_from'] = $this->request->data['Item']['gift_from'];
                                }
                                // For affiliates ( //
                                $cookie_value = $this->Cookie->read('referrer');
                                $refer_id = (!empty($cookie_value)) ? $cookie_value['refer_id'] : null;
                                if (!empty($refer_id)) {
                                    $item_user['ItemUser']['referred_by_user_id'] = $refer_id;
                                }
                                // ) affiliates //
                                $this->Item->ItemUser->create();
                                $this->Item->ItemUser->set($item_user);
                                if ($this->Item->ItemUser->save($item_user)) {
                                    // For affiliates ( //
                                    $cookie_value = $this->Cookie->read('referrer');
                                    if (!empty($cookie_value)) {
                                        $this->Cookie->delete('referrer'); // Delete referer cookie

                                    }
                                    // ) affiliates //
                                    $last_inserted_id = $this->Item->ItemUser->getLastInsertId();
                                    if (!empty($this->request->data['Item']['charity_id'])) {
                                        $this->_set_charity_detail($this->request->data['Item']['charity_id'], $last_inserted_id);
                                    }
                                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['id'] = $response['pr_authorize_id'];
                                    $data_authorize_docapture_log['AuthorizenetDocaptureLog']['item_user_id'] = $last_inserted_id;
                                    $get_conversion = $this->getAuthorizeConversionCurrency();
                                    if (!empty($get_conversion)) {
                                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['currency_id'] = $get_conversion['CurrencyConversion']['currency_id'];
                                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['converted_currency_id'] = $get_conversion['CurrencyConversion']['converted_currency_id'];
                                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['original_amount'] = $this->request->data['Item']['amount'];
                                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['rate'] = $get_conversion['CurrencyConversion']['rate'];
                                    }
                                    if (empty($response['capture'])) {
                                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['payment_status'] = 'Pending';
                                    } else {
                                        $data_authorize_docapture_log['AuthorizenetDocaptureLog']['payment_status'] = 'Completed';
                                    }
                                    $this->Item->ItemUser->AuthorizenetDocaptureLog->save($data_authorize_docapture_log);
                                    if (!empty($response['capture'])) {
                                        $item_user['ItemUser']['is_gift'] = (!empty($this->request->data['Item']['is_gift'])) ? 1 : 0;
                                        $item_user['ItemUser']['id'] = $last_inserted_id;
                                        if (!empty($get_conversion)) {
                                            $item_user['ItemUser']['currency_id'] = $get_conversion['CurrencyConversion']['currency_id'];
                                            $item_user['ItemUser']['converted_currency_id'] = $get_conversion['CurrencyConversion']['converted_currency_id'];
                                            $item_user['ItemUser']['authorize_amt'] = $this->request->data['Item']['amount'];
                                            $item_user['ItemUser']['rate'] = $get_conversion['CurrencyConversion']['rate'];
                                        }
                                        $this->Item->_updateTransaction($item_user['ItemUser']);
                                    }
                                    $item_user_passes = array();
									$passes = $this->_getPasses($this->request->data['Item']['item_id'], $this->request->data['Item']['quantity']);
									$i = 0;
									foreach($passes as $key => $value) {
										$item_user_passes['id'] = '';
										$item_user_passes['item_user_id'] = $last_inserted_id;
										$item_user_passes['pass_code'] = $value;
										$item_user_passes['unique_pass_code'] = $this->_unum();
										if (!empty($this->request->data['ItemUserPass'])) {
											$item_user_passes['guest_name'] = $this->request->data['ItemUserPass'][$i]['guest_name'];
											$item_user_passes['guest_email'] = $this->request->data['ItemUserPass'][$i]['guest_email'];
										}
										$this->Item->ItemUser->ItemUserPass->save($item_user_passes);
										$i++;
									}
                                    // If enabled, and after purchase, deduct partial amount from wallet //
                                    if (Configure::read('wallet.is_handle_wallet') && (!empty($is_purchase_with_wallet_amount))) {
                                        // Deduct amount ( zero will be updated ) //
                                        $user_available_balance = $this->Item->User->checkUserBalance($this->Auth->user('id'));
                                        $this->Item->User->updateAll(array(
                                            'User.available_balance_amount' => 'User.available_balance_amount -' . $user_available_balance,
                                        ) , array(
                                            'User.id' => $item_user['ItemUser']['user_id']
                                        ));
                                        // Update transaction, This is firs transaction, to notify user that partial amount taken from wallet. Second transaction will be updated after item gets tipped.//
                                        if (!empty($user_available_balance) && $user_available_balance != '0.00') {
											if ($user_available_balance > $total_item_amount) {
	                                            $amount_taken_from_wallet = $user_available_balance - $total_item_amount;
											} else {
	                                            $amount_taken_from_wallet = $user_available_balance;
											}
                                            $transaction['Transaction']['user_id'] = $item_user['ItemUser']['user_id'];
                                            $transaction['Transaction']['foreign_id'] = $last_inserted_id;
                                            $transaction['Transaction']['class'] = 'ItemUser';
                                            $transaction['Transaction']['amount'] = $amount_taken_from_wallet;
                                            $transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::PartallyAmountTakenForItemPurchase;
                                            $transaction['Transaction']['payment_gateway_id'] = ConstPaymentGateways::Wallet;
                                            $this->Item->User->Transaction->log($transaction);
                                        }
                                    }
                                    $last_inserted_id = $this->Item->ItemUser->getLastInsertId();
                                    $this->_itemPurchaseViaAuthorizeNet($this->request->data, $last_inserted_id);
                                } else {
                                    $this->Session->setFlash(__l('Payment failed. Please try again.') , 'default', null, 'error');
                                    $this->redirect(array(
                                        'controller' => 'items',
                                        'action' => 'index'
                                    ));
                                }
                            } else {
                                $this->Session->setFlash(sprintf(__l('Gateway error: %s <br>Note: Due to security reasons, error message from gateway may not be verbose. Please double check your card number, security number and address details. Also, check if you have enough balance in your card.') , $response['message']) , 'default', null, 'error');
                                $this->redirect(array(
                                    'controller' => 'items',
                                    'action' => 'index'
                                ));
                            }
                        } else {
                            $this->Session->setFlash(__l('Credit card could not be updated. Please, try again.') , 'default', null, 'error');
                            $this->redirect(array(
                                'controller' => 'items',
                                'action' => 'index'
                            ));
                        }
                    } else if ($paymentGateway['PaymentGateway']['name'] == 'PagSeguro') {
                        Configure::write('PagSeguro.is_testmode', $paymentGateway['PaymentGateway']['is_test_mode']);
                        if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                            foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                                if ($paymentGatewaySetting['key'] == 'payee_account') {
                                    $email = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                                }
                                if ($paymentGatewaySetting['key'] == 'token') {
                                    $token = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                                }
                            }
                        }
                        //gateway options set
                        $ref = time();
						$converted_amount=0;
						if(!is_int($amount_needed)){	// Quick fix for float issue with pagse //
							$converted_amount = $amount_needed * 100;
						}else{
							$converted_amount = $amount_needed;
						}
                        $gateway_options['init'] = array(
                            'pagseguro' => array( // Array com informa��es pertinentes ao pagseguro
                                'email' => $email,
                                'token' => $token,
                                'type' => 'CBR', // Obrigat�rio passagem para pagseguro:tipo
                                'reference' => $ref, // Obrigat�rio passagem para pagseguro:ref_transacao
                                'freight_type' => 'EN', // Obrigat�rio passagem para pagseguro:tipo_frete
                                'theme' => 1, // Opcional Este parametro aceita valores de 1 a 5, seu efeito � a troca dos bot�es padr�es do pagseguro
                                'currency' => 'BRL', // Obrigat�rio passagem para pagseguro:moeda,
                                'extra' => 0
                                // Um valor extra que voc� queira adicionar no valor total da venda, obs este valor pode ser negativo

                            ) ,
                            'definitions' => array( // Array com informa��es para manusei das informa��es
                                'currency_type' => 'dolar', // Especifica qual o tipo de separador de decimais, suportados (dolar, real)
                                'weight_type' => 'kg', // Especifica qual a medida utilizada para peso, suportados (kg, g)
                                'encode' => 'utf-8'
                                // Especifica o encode n�o implementado

                            ) ,
                            'format' => array(
                                'item_id' => '0000' . $item['Item']['id'],
                                'item_descr' => 'Bought Item', //used to differ return array fron payment
                                'item_quant' => $this->request->data['Item']['quantity'],
                                'item_valor' => $converted_amount,
                                'item_frete' => '0',
                                'item_peso' => '20',
                            ) ,
                        );
                        $transaction_data['TempPaymentLog'] = array(
                            'trans_id' => $ref,
                            'payment_type' => 'Buy item',
                            'user_id' => $this->Auth->user('id') ,
                            'item_id' => $this->request->data['Item']['item_id'],
                            'is_gift' => $this->request->data['Item']['is_gift'],
                            'quantity' => $this->request->data['Item']['quantity'],
                            'payment_gateway_id' => $this->request->data['Item']['payment_gateway_id'],
                            'gift_to' => !empty($this->request->data['Item']['gift_to']) ? $this->request->data['Item']['gift_to'] : '',
                            'gift_from' => !empty($this->request->data['Item']['gift_from']) ? $this->request->data['Item']['gift_from'] : '',
                            'gift_email' => !empty($this->request->data['Item']['gift_email']) ? $this->request->data['Item']['gift_email'] : '',
                            'ip_id' => $this->TempPaymentLog->toSaveIp() ,
                            'amount_needed' => $amount_needed,
                            'currency_code' => Configure::read('paypal.currency_code') ,
                            'message' => !empty($this->request->data['Item']['message']) ? $this->request->data['Item']['message'] : '',
                        );
						if (!empty($_COOKIE['_geo'])) {
							$_geo = explode('|', $_COOKIE['_geo']);
							$transaction_data['TempPaymentLog']['latitude'] = $_geo[3];
							$transaction_data['TempPaymentLog']['longitude'] = $_geo[4];
						}
                        // For affiliates ( //
                        $cookie_value = $this->Cookie->read('referrer');
                        $refer_id = (!empty($cookie_value)) ? $cookie_value['refer_id'] : null;
                        if (!empty($refer_id)) {
                            $transaction_data['TempPaymentLog']['referred_user_id'] = $refer_id;
                        }
                        // ) affiliates //
                        if (!empty($this->request->data['ItemUserPass'])) {
                            $guest_names = array();
                            $guest_emails = array();
                            foreach($this->request->data['ItemUserPass'] as $guest) {
                                array_push($guest_names, $guest['guest_name']);
                                array_push($guest_emails, $guest['guest_email']);
                            }
                            $transaction_data['guest_name'] = serialize($guest_names);
                            $transaction_data['guest_email'] = serialize($guest_emails);
                        }
                        $this->TempPaymentLog->save($transaction_data);
                        //	$this->Session->write('transaction_data',$transaction_data);
                        $this->set('gateway_options', $gateway_options);
                    }
                    $this->set('action', $action);
                    $this->set('amount', $amount_needed);
                    $this->set('item', $item);
                    $this->render('do_payment');
                }
            }
        }
    }
    public function _itemPurchaseViaAuthorizeNet($data, $last_inserted_id)
    {
        $this->loadModel('EmailTemplate');
        if (!empty($data)) {
            $gateways = $this->Item->User->Transaction->PaymentGateway->find('first', array(
                'conditions' => array(
                    'PaymentGateway.id' => ConstPaymentGateways::AuthorizeNet
                ) ,
                'recursive' => -1
            ));
            //Process for items pay
            $item_id = $data['Item']['item_id'];
            $item = $this->Item->find('first', array(
                'conditions' => array(
                    'Item.id' => $data['Item']['item_id'],
                    'Item.item_status_id' => array(
                        ConstItemStatus::Open,
                        ConstItemStatus::Tipped
                    )
                ) ,
                'contain' => array(
                    'ItemStatus' => array(
                        'fields' => array(
                            'ItemStatus.name',
                        )
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
                    )
                ) ,
                'recursive' => 2
            ));
            if (empty($item)) {
                throw new NotFoundException(__l('Invalid request'));
            } else {
                $item_user['ItemUser']['quantity'] = $data['Item']['quantity'];
                if (!empty($data['Item']['is_gift'])) {
                    $item_user['ItemUser']['gift_to'] = $data['Item']['gift_to'];
                }
                $total_item_amount = $data['Item']['amount'];
                if (!empty($data['Item']['wallet_amount'])) {
                    $total_item_amount = $total_item_amount+$data['Item']['wallet_amount'];
                }
                //in paypal process we will not get Auth
                $user = $this->Item->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $this->Auth->user('id')
                    ) ,
                    'fields' => array(
                        'User.available_balance_amount',
                        'User.referred_by_user_id',
                        'User.username',
                        'User.email',
                        'User.created',
                        'User.id'
                    ) ,
                    'recursive' => -1
                ));
                $this->Item->updateAll(array(
                    'Item.item_user_count' => 'Item.item_user_count +' . $data['Item']['quantity'],
                ) , array(
                    'Item.id' => $item_id
                ));
                //update item is on
                if ($item['Item']['item_status_id'] == ConstItemStatus::Open) {
                    $db = $this->Item->getDataSource();
                    $this->Item->updateAll(array(
                        'Item.item_status_id' => ConstItemStatus::Tipped,
                        'Item.item_tipped_time' => '\'' . date('Y-m-d H:i:s') . '\''
                    ) , array(
                        'Item.item_status_id' => ConstItemStatus::Open,
                        'Item.item_user_count >=' => $db->expression('Item.min_limit') ,
                        'Item.id' => $item_id
                    ));
                    $this->Item->processItemStatus($item_id, $last_inserted_id = null);
                } else {
                    //send pass mail to users or close the item
                    $this->Item->processItemStatus($item_id, $last_inserted_id);
                }
				// after save fields //
				$data_for_aftersave = array();
				$data_for_aftersave['item_id'] = $item_id;
				$data_for_aftersave['item_user_id'] = $last_inserted_id;
				$data_for_aftersave['user_id'] = $user['User']['id'];
				$data_for_aftersave['merchant_id'] = $item['Merchant']['id'];
				$data_for_aftersave['payment_gateway_id'] = ConstPaymentGateways::AuthorizeNet;
				$this->Item->_updateAfterPurchase($data_for_aftersave);
                //pay to referer
                $referred_by_user_id = $user['User']['referred_by_user_id'];
				$this->_sendMailToReferredUser($referred_by_user_id, $this->Auth->user('id'), $item_id);
                if ((Configure::read('referral.referral_enabled_option') == ConstReferralOption::GrouponLikeRefer) && !empty($referred_by_user_id)) {
                    $this->_pay_to_referrer($item_id, $user['User']);
                }
                //item on end
                $merchant_address = ($item['Merchant']['address1']) ? $item['Merchant']['address1'] : '';
                $merchant_address.= ($item['Merchant']['address2']) ? ', ' . $item['Merchant']['address2'] : '';
                $merchant_address.= !empty($item['Merchant']['City']['name']) ? ', ' . $item['Merchant']['City']['name'] : '';
                $merchant_address.= !empty($item['Merchant']['State']['name']) ? ', ' . $item['Merchant']['State']['name'] : '';
                $merchant_address.= !empty($item['Merchant']['Country']['name']) ? ', ' . $item['Merchant']['Country']['name'] : '';
                $merchant_address.= '.';
                $language_code = $this->Item->getUserLanguageIso($this->Auth->user('id'));
                $email_message = $this->EmailTemplate->selectTemplate('Item Bought', $language_code);
                $emailFindReplace = array(
                    '##FROM_EMAIL##' => $this->Item->changeFromEmail(($email_message['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email_message['from']) ,
                    '##SITE_NAME##' => Configure::read('site.name') ,
                    '##USERNAME##' => $user['User']['username'],
                    '##ITEM_TITLE##' => $item['Item']['name'],
                    '##ITEM_AMOUNT##' => Configure::read('site.currency') . $total_item_amount,
                    '##SITE_URL##' => Router::url('/', true) ,
                    '##QUANTITY##' => $item_user['ItemUser']['quantity'],
                    '##PURCHASE_ON##' => strftime(Configure::read('site.datetime.format')) ,
                    '##ITEM_STATUS##' => $item['ItemStatus']['name'],
                    '##MERCHANT_NAME##' => $item['Merchant']['name'],
                    '##MERCHANT_ADDRESS##' => ($merchant_address) ? $merchant_address : '',
                    '##CONTACT_URL##' => Router::url(array(
                        'controller' => 'contacts',
                        'action' => 'add',
                        'city' => $this->request->params['named']['city'],
                        'admin' => false
                    ) , true) ,
                    '##GIFT_RECEIVER##' => !empty($item_user['ItemUser']['gift_to']) ? $item_user['ItemUser']['gift_to'] : '',
                    '##SITE_LOGO##' => Router::url(array(
                        'controller' => 'img',
                        'action' => 'blue-theme',
                        'logo-email.png',
                        'admin' => false
                    ) , true) ,
                );
                $this->_sendMail($emailFindReplace, $email_message, $user['User']['email']);
                $this->Session->setFlash(__l('You have bought a item sucessfully.') , 'default', null, 'success');
                $get_updated_status = $this->Item->find('first', array(
                    'conditions' => array(
                        'Item.id' => $item_id
                    ) ,
                    'recursive' => -1
                ));
                if ($this->RequestHandler->prefers('json')) {
                    $resonse = array(
                        'status' => 0,
                        'message' => __l('Success')
                    );
                    $this->view = 'Json';
                    $this->set('json', (empty($this->viewVars['iphone_response'])) ? $resonse : $this->viewVars['iphone_response']);
                } else {
                    if (Configure::read('Item.invite_after_item_add') && $get_updated_status['Item']['item_status_id'] != ConstItemStatus::Closed) {
                        $this->redirect(array(
                            'controller' => 'user_friends',
                            'action' => 'item_invite',
                            'type' => 'item',
                            'item' => $item['Item']['slug']
                        ));
                    } else {
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'my_stuff#My_Purchases'
                        ));
                    }
                }
            }
        } else {
            $this->Session->setFlash(__l('Payment failed.Please try again.') , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'items',
                'action' => 'index'
            ));
        }
    }
    //send welcome mail for new user
    public function _sendWelcomeMail($user_id, $user_email, $username)
    {
        $email = $this->EmailTemplate->selectTemplate('Welcome Email');
        $emailFindReplace = array(
            '##FROM_EMAIL##' => $this->Item->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
            '##SITE_URL##' => Router::url('/', true) ,
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##USERNAME##' => $username,
            '##SUPPORT_EMAIL##' => Configure::read('site.contact_email') ,
            '##SITE_URL##' => Router::url('/', true) ,
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
        $this->Email->to = $user_email;
        $this->Email->subject = strtr($email['subject'], $emailFindReplace);
        $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
        $this->Email->send(strtr($email['email_content'], $emailFindReplace));
    }
    public function processpayment($gateway_name, $return_details = null)
    {
        $this->loadModel('TempPaymentLog');
        //paypal ipn
        $return_details = $_REQUEST;
        $gateway = array(
            'paypal' => ConstPaymentGateways::PayPalAuth,
            'pagseguro' => ConstPaymentGateways::PagSeguro
        );
        //$gateway['paypal'] = ConstPaymentGateways::PayPalAuth;
        $gateway_id = (!empty($gateway[$gateway_name])) ? $gateway[$gateway_name] : 0;
        $paymentGateway = $this->Item->User->Transaction->PaymentGateway->find('first', array(
            'conditions' => array(
                'PaymentGateway.id' => $gateway_id
            ) ,
            'contain' => array(
                'PaymentGatewaySetting' => array(
                    'fields' => array(
                        'PaymentGatewaySetting.key',
                        'PaymentGatewaySetting.test_mode_value',
                        'PaymentGatewaySetting.live_mode_value',
                    )
                )
            ) ,
            'recursive' => 1
        ));
        switch ($gateway_name) {
            case 'paypal':
                $this->Paypal->initialize($this);
                if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                    foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                        if ($paymentGatewaySetting['key'] == 'payee_account') {
                            $this->Paypal->payee_account = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                        }
                        if ($paymentGatewaySetting['key'] == 'receiver_emails') {
                            $this->Paypal->paypal_receiver_emails = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                        }
                    }
                }
                $this->Paypal->sanitizeServerVars($_POST);
                $temp_ary = $this->TempPaymentLog->find('first', array(
                    'conditions' => array(
                        'TempPaymentLog.id' => $this->Paypal->paypal_post_arr['temp_payment_id']
                    )
                ));
                $transaction_data = $temp_ary['TempPaymentLog'];
                if(!empty($transaction_data['guest_name'])){
                $transaction_data['guest_name']= unserialize($transaction_data['guest_name']);
                }
                if(!empty($transaction_data['guest_email'])){
                $transaction_data['guest_email']=unserialize($transaction_data['guest_name']);
                }
                $this->Paypal->is_test_mode = $paymentGateway['PaymentGateway']['is_test_mode'];
                $allow_to_process = 0;
                $item_id = $this->Paypal->paypal_post_arr['item_id'];
                $sub_item_id = $this->Paypal->paypal_post_arr['sub_item_id'];
                $quantity = $transaction_data['quantity'];
                $paid_amount = $this->Paypal->paypal_post_arr['mc_gross'];
                $payer_user_id = $this->Paypal->paypal_post_arr['user_id'];
                $is_purchase_with_wallet_amount = $transaction_data['is_purchase_with_wallet_amount'];
                $conditions = array();
                $conditions['Item.id'] = $item_id;
                if (!empty($sub_item_id)) {
                    $conditions['Item.id'] = $sub_item_id;
                }
                $get_item = $item = $this->Item->find('first', array(
                        'conditions' => $conditions,
                        'contain'=>array(
                         'ItemUser'
                        ),
                        'recursive' => 2
                    ));
                $get_user = $this->Item->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $payer_user_id
                    ) ,
                    'recursive' => -1
                ));
                $payment_gateway_id = !empty($this->Paypal->paypal_post_arr['auth_id']) ? $transaction_data['payment_gateway_id'] : ConstPaymentGateways::Wallet;
                $is_supported = Configure::read('paypal.is_supported');
                if ($get_item['Item']['is_be_next']) {
                    $get_item['Item']['price']+= count($get_item['ItemUser']) *$get_item['Item']['be_next_increase_price'];
                    }
                if (isset($is_supported) && empty($is_supported)) {
                    $allow_to_process = 1; //**NEED TO FIX**//
                } else {
                    if ($payment_gateway_id == ConstPaymentGateways::Wallet) {
                        if ((($get_item['Item']['price']*$quantity) -$get_user['User']['available_balance_amount']) == ($paid_amount)) {
                            $allow_to_process = 1;
                        }
                    } elseif ($payment_gateway_id == ConstPaymentGateways::PayPalAuth) {
                        if (($get_item['Item']['price']*$quantity) == $paid_amount) {
                            $allow_to_process = 1;
                        } elseif (!empty($is_purchase_with_wallet_amount)) {
                            $allow_to_process = 1;
                        }
                    } elseif ($payment_gateway_id == ConstPaymentGateways::CreditCard) {
                        $allow_to_process = 1;
                    }
                }
                if (!empty($get_item) && !empty($allow_to_process)) {
                    $this->Paypal->amount_for_item = $transaction_data['amount_needed'];
                    if ($this->Paypal->process() || (!empty($this->Paypal->paypal_post_arr['auth_id']))) {
                        //for normal payment through wallet
                        if ($this->Paypal->paypal_post_arr['payment_status'] == 'Completed' && empty($this->Paypal->paypal_post_arr['auth_id'])) {
                            $id = $this->Paypal->paypal_post_arr['user_id'];
                            //add amount to wallet for normal paypal
                            $data['Transaction']['user_id'] = $id;
                            $data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                            $data['Transaction']['class'] = 'SecondUser';
                            $data['Transaction']['amount'] = $this->Paypal->paypal_post_arr['mc_gross'];
                            $data['Transaction']['payment_gateway_id'] = $paymentGateway['PaymentGateway']['id'];
                            $data['Transaction']['gateway_fees'] = $this->Paypal->paypal_post_arr['mc_fee'];
                            $data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
                            $transaction_id = $this->Item->User->Transaction->log($data);
                            if (!empty($transaction_id)) {
                                $this->Paypal->paypal_post_arr['transaction_id'] = $transaction_id;
                                $this->Item->User->updateAll(array(
                                    'User.available_balance_amount' => 'User.available_balance_amount +' . $this->Paypal->paypal_post_arr['mc_gross'],
                                ) , array(
                                    'User.id' => $id
                                ));
                            }
                            //buy item
                            $item_data['Item']['item_id'] = $item_id;
                            if (!empty($sub_item_id)) {
                                $item_data['Item']['sub_item_id'] = $sub_item_id;
                            }
                            $temp_ary = $this->TempPaymentLog->find('first', array(
                                'conditions' => array(
                                    'TempPaymentLog.id' => $this->Paypal->paypal_post_arr['temp_payment_id']
                                )
                            ));
                            $item_data['Item']['quantity'] = $transaction_data['quantity'];
                            $item_data['Item']['is_gift'] = $transaction_data['is_gift'];
                            $item_data['Item']['gift_to'] = $transaction_data['gift_to'];
                            $item_data['Item']['gift_from'] = $transaction_data['gift_from'];
                            $item_data['Item']['gift_email'] = $transaction_data['gift_email'];
                            $item_data['Item']['message'] = $transaction_data['message'];
                            $item_data['Item']['user_id'] = $transaction_data['user_id'];
                            $item_data['Item']['payment_gateway_id'] = !empty($this->Paypal->paypal_post_arr['auth_id']) ? $transaction_data['payment_gateway_id'] : ConstPaymentGateways::Wallet;
                            $paypal_transaction_log_id = $this->Paypal->logPaypalTransactions();
                            $item_data['Item']['paypal_transaction_log_id'] = $paypal_transaction_log_id;
                            $item_data['Item']['is_process_payment'] = 1;
                            if (!empty($transaction_data)) {
                                $item_data['Item']['guest_names'] = $transaction_data['guest_name'];
                                $item_data['Item']['guest_emails'] = $transaction_data['guest_emails'];
                            }
                            $this->_buyItem($item_data);
                        } else if ($this->Paypal->paypal_post_arr['payment_status'] == 'Pending' && !empty($this->Paypal->paypal_post_arr['auth_id']) && $this->Paypal->paypal_post_arr['pending_reason'] == 'authorization') {
                            //for paypal auth first time
                            //buy item
                            $is_duplicate_ipn = $this->Item->ItemUser->PaypalTransactionLog->find('first', array(
                                'conditions' => array(
                                    'PaypalTransactionLog.authorization_auth_id' => $this->Paypal->paypal_post_arr['auth_id']
                                ) ,
                                'recursive' => -1
                            ));
                            if (!empty($is_duplicate_ipn)) {
                                //for paypal duplicate IPN check
                                // Also, we're using auth_id instead of txt_id coz, txt_id varies for second duplicate ID in set of all Duplicate IPN's
                                exit;
                            }
                            $item_data['Item']['item_id'] = $item_id;
                            if (!empty($sub_item_id)) {
                                $item_data['Item']['sub_item_id'] = $sub_item_id;
                            }
                            $temp_ary = $this->TempPaymentLog->find('first', array(
                                'conditions' => array(
                                    'TempPaymentLog.id' => $this->Paypal->paypal_post_arr['temp_payment_id']
                                )
                            ));
                            $transaction_data = $temp_ary['TempPaymentLog'];
                            $item_data['Item']['quantity'] = $transaction_data['quantity'];
                            $item_data['Item']['is_gift'] = $transaction_data['is_gift'];
                            $item_data['Item']['gift_to'] = $transaction_data['gift_to'];
                            $item_data['Item']['gift_from'] = $transaction_data['gift_from'];
                            $item_data['Item']['gift_email'] = $transaction_data['gift_email'];
                            $item_data['Item']['message'] = $transaction_data['message'];
                            $item_data['Item']['user_id'] = $transaction_data['user_id'];
                            $item_data['Item']['payment_gateway_id'] = $transaction_data['payment_gateway_id'];
                            $paypal_transaction_log_id = $this->Paypal->logPaypalTransactions();
                            $item_data['Item']['is_purchase_with_wallet_amount'] = $transaction_data['is_purchase_with_wallet_amount'];
                            $item_data['Item']['paypal_transaction_log_id'] = $paypal_transaction_log_id;
                            $item_data['Item']['is_process_payment'] = 1;
                            if (!empty($transaction_data)) {
                                $item_data['Item']['guest_names'] = $transaction_data['guest_name'];
                                $item_data['Item']['guest_emails'] = $transaction_data['guest_email'];
                            }
                            // For affiliates ( //
                            $refer_id = $this->Paypal->paypal_post_arr['refer_id'];
                            if (!empty($refer_id)) {
                                $item_data['ItemUser']['referred_by_user_id'] = $refer_id;
                            }
                            $item_data['ItemUser']['city_id'] = $transaction_data['city_id'];
                            $item_data['ItemUser']['latitude'] = $transaction_data['latitude'];
                            $item_data['ItemUser']['longitude'] = $transaction_data['longitude'];
                            $item_data['Item']['charity_id'] = $transaction_data['charity_id'];
                            // ) affiliates //
                            //update item user id in PaypalTransactionLog table
                            $get_conversion = $this->getConversionCurrency();
                            $this->Item->ItemUser->PaypalTransactionLog->updateAll(array(
                                'PaypalTransactionLog.currency_id' => $get_conversion['CurrencyConversion']['currency_id'],
                                'PaypalTransactionLog.converted_currency_id' => $get_conversion['CurrencyConversion']['converted_currency_id'],
                                'PaypalTransactionLog.orginal_amount' =>$transaction_data['original_amount_needed'],
                                'PaypalTransactionLog.rate' => $get_conversion['CurrencyConversion']['rate'],
                            ) , array(
                                'PaypalTransactionLog.id' => $paypal_transaction_log_id
                            ));
                            $this->_buyItem($item_data);
                        } else if (!empty($this->Paypal->paypal_post_arr['auth_id'])) {
                            //for paypal auth second time ipn
                            exit;
                        }
                    }
                }
                $this->Paypal->logPaypalTransactions();
                break;

            case 'pagseguro':
                if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                    foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
                        if ($paymentGatewaySetting['key'] == 'payee_account') {
                            $email = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                        }
                        if ($paymentGatewaySetting['key'] == 'token') {
                            $token = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
                        }
                    }
                }
            $post_array = $_POST;
			if(empty($_POST)){
				$this->Session->setFlash(__l('Your transaction has been completed.') , 'default', null, 'success');
				$this->redirect(array(
					'controller' => 'users',
					'action' => 'my_stuff#My_Purchases'
				));
			}
            if (!empty($post_array) && $post_array['Referencia']) {
                $temp_ary = $this->TempPaymentLog->find('first', array(
                    'conditions' => array(
                        'TempPaymentLog.trans_id' => $post_array['Referencia']
                    )
                ));
                $transaction_data = $temp_ary['TempPaymentLog'];
            }
            $this->PagSeguro->init(array(
                'pagseguro' => array(
                    'email' => $email,
                    'token' => $token,
                ) ,
                'format' => array(
                        'item_id' => $transaction_data['item_id'],
                        'item_descr' => 'Bought Item',
                        'item_quant' => $transaction_data['quantity'],
                        'item_valor' => $transaction_data['amount_needed'],
                )
            ));
                $allow_to_process = 1;
                $verified = 0;
                $pagseguro_data = $return_details;
                $verificado = $this->PagSeguro->confirm();
                if ($verificado == 'VERIFICADO') {
                    $verified = 1;
                    $result = $this->PagSeguro->getDataPayment();
                    $log_data = array_merge($pagseguro_data, $transaction_data);
                    $pagseguro_transaction_log_id = $this->Item->PagseguroTransactionLog->logPagSeguroTransactions($log_data);
                } elseif ($verificado == 'FALSO') {
                    $verified = 0;
                    $log_data = array_merge($pagseguro_data, $transaction_data);
                    $pagseguro_transaction_log_id = $this->Item->PagseguroTransactionLog->logPagSeguroTransactions($log_data);
                }
			$transaction_data['pagseguro_transaction_log_id'] = $pagseguro_transaction_log_id;
			$paystatus = $post_array['StatusTransacao'];
			$transactionID = $post_array['TransacaoID'];
                if ($transaction_data['payment_type'] == 'Buy item') {
                    $conditions = array();
                    $conditions['Item.id'] = $transaction_data['item_id'];
                    if (!empty($transaction_data['sub_item_id'])) {
                        $conditions['Item.id'] = $sub_item_id;
                    }
                    $quantity = $transaction_data['quantity'];
                    $paid_amount = $transaction_data['amount_needed'];
                    $payer_user_id = $transaction_data['user_id'];
                    $get_item = $this->Item->find('first', array(
                        'conditions' => $conditions,
                        'recursive' => -1
                    ));
                    $get_user = $this->Item->User->find('first', array(
                        'conditions' => array(
                            'User.id' => $payer_user_id
                        ) ,
                        'recursive' => -1
                    ));
                    if (!empty($get_item) && !empty($allow_to_process)) {
						$paystatus_to_check = (!empty($paymentGateway['PaymentGateway']['is_test_mode']) ? 'Aguardando Pagto' : 'Aprovado');
						if($paystatus == $paystatus_to_check){
                            $id = $transaction_data['user_id'];
                            //buy item
                            $item_data['Item']['item_id'] = $transaction_data['item_id'];
                            $item_data['Item']['quantity'] = $transaction_data['quantity'];
                            $item_data['Item']['is_gift'] = $transaction_data['is_gift'];
                            $item_data['Item']['gift_to'] = $transaction_data['gift_to'];
                            $item_data['Item']['gift_from'] = $transaction_data['gift_from'];
                            $item_data['Item']['gift_email'] = $transaction_data['gift_email'];
                            $item_data['Item']['message'] = $transaction_data['message'];
                            $item_data['Item']['user_id'] = $transaction_data['user_id'];
                            $item_data['Item']['payment_gateway_id'] = ConstPaymentGateways::PagSeguro;
                            $item_data['Item']['pagseguro_transaction_log_id'] = $pagseguro_transaction_log_id;
                            $item_data['Item']['is_process_payment'] = 1;
                            if (!empty($transaction_data)) {
                                $item_data['Item']['guest_names'] = $transaction_data['guest_name'];
                                $item_data['Item']['guest_emails'] = $transaction_data['guest_emails'];
                            }
                            $this->TempPaymentLog->delete($transaction_data['id']);
                            // For affiliates ( //
                            if (!empty($transaction_data['referred_user_id'])) {
                                $item_data['ItemUser']['referred_user_id'] = $transaction_data['referred_user_id'];
                            }
                            // ) For affiliates //
                            $this->_buyItem($item_data);
                        }
                    }
                } else if ($transaction_data['payment_type'] == 'wallet' && $verified) {
				$id = $transaction_data['user_id'];
				//Send the email to the user when the payment status in "Awaiting PO"
				$paystatus_to_check = (!empty($paymentGateway['PaymentGateway']['is_test_mode']) ? 'Aguardando Pagto' : 'Aprovado');
				if($paystatus == $paystatus_to_check){
					$paid_amount = $transaction_data['amount_needed'];
					//add amount to wallet for normal paypal
					$data['Transaction']['user_id'] = $id;
					$data['Transaction']['foreign_id'] = ConstUserIds::Admin;
					$data['Transaction']['class'] = 'SecondUser';
					$data['Transaction']['amount'] = $transaction_data['amount_needed'];
					$data['Transaction']['payment_gateway_id'] = $paymentGateway['PaymentGateway']['id'];
					$data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddedToWallet;
					$data['Transaction']['gateway_fees'] = 0;
					$transaction_id = $this->Item->User->Transaction->log($data);
					if (!empty($transaction_id)) {
						$this->Item->User->updateAll(array(
							'User.available_balance_amount' => 'User.available_balance_amount + ' . '\''.$transaction_data['amount_needed'].'\'',
						) , array(
							'User.id' => $id
						));
					}
				}
				return true;
				} else {
                    $this->Session->setFlash(__l('Error in payment.') , 'default', null, 'error');
                    $this->redirect(array(
                        'controller' => 'transactions',
                        'action' => 'index',
                        'admin' => false
                    ));
                }
                break;

            default:
                throw new NotFoundException(__l('Invalid request'));
		} // switch
		$this->autoRender = false;
	}
	//before login item buy process
	public function _buyItem($data)
	{
		$this->loadModel('EmailTemplate');
		$is_purchase_with_wallet_amount = 0; // Used for 'handle with wallet like groupon //
		$item_id = $data['Item']['item_id'];
		$conditions = array();
		$sub_item_conditions = array();
		$conditions['Item.id'] = $data['Item']['item_id'];
		$conditions['Item.item_status_id'] = array(
			ConstItemStatus::Open,
			ConstItemStatus::Tipped
		);
		$item = $this->Item->find('first', array(
			'conditions' => $conditions,
			'contain' => array(
				'ItemStatus' => array(
					'fields' => array(
						'ItemStatus.name',
					)
				) ,
				'ItemUser' => array(
					'fields' => array(
						'ItemUser.id',
						'ItemUser.item_id',
						'ItemUser.discount_amount',
					)
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
				)
			) ,
			'recursive' => 2
		));
		if (empty($item)) {
			throw new NotFoundException(__l('Invalid request'));
		} else {
			if ($item['Item']['is_be_next']) {
				$item['Item']['price'] = $item['Item']['price']+($item['Item']['be_next_increase_price']*count($item['ItemUser']));
			}
			$total_item_amount = $item['Item']['price']*$data['Item']['quantity'];
			//in paypal process we will not get Auth
			$user = $this->Item->User->find('first', array(
				'conditions' => array(
					'User.id' => $data['Item']['user_id']
				) ,
				'fields' => array(
					'User.available_balance_amount',
					'User.referred_by_user_id',
					'User.username',
					'User.created',
					'User.email',
					'User.id'
				) ,
				'recursive' => -1
			));
			$paymentGateway = $this->Item->User->Transaction->PaymentGateway->find('first', array(
				'conditions' => array(
					'PaymentGateway.id' => ConstPaymentGateways::CreditCard,
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
			//item user table record add
			if (empty($data['ItemUser']['city_id'])) {
				$city = $this->Item->City->find('first', array(
					'conditions' => array(
						'City.slug' => $this->request->params['named']['city']
					) ,
					'fields' => array(
						'City.id'
					) ,
					'recursive' => -1
				));
				$item_user['ItemUser']['city_id'] = $city['City']['id'];
				if (!empty($_COOKIE['_geo'])) {
					$_geo = explode('|', $_COOKIE['_geo']);
                    $item_user['ItemUser']['latitude'] = $_geo[3];
                    $item_user['ItemUser']['longitude'] = $_geo[4];
                }
			} else {
				$item_user['ItemUser']['city_id'] = $data['ItemUser']['city_id'];
				$item_user['ItemUser']['latitude'] = $data['ItemUser']['latitude'];
				$item_user['ItemUser']['longitude'] = $data['ItemUser']['longitude'];
			}
			$item_user['ItemUser']['quantity'] = $data['Item']['quantity'];
			$item_user['ItemUser']['item_id'] = $data['Item']['item_id'];
			$item_user['ItemUser']['is_gift'] = $data['Item']['is_gift'];
			$item_user['ItemUser']['user_id'] = $data['Item']['user_id'];
			$item_user['ItemUser']['discount_amount'] = $total_item_amount;
			$item_user['ItemUser']['payment_gateway_id'] = !empty($data['Item']['payment_gateway_id']) ? $data['Item']['payment_gateway_id'] : ConstPaymentGateways::Wallet;
			if ($data['Item']['is_gift']) {
				$item_user['ItemUser']['gift_email'] = $data['Item']['gift_email'];
				$item_user['ItemUser']['message'] = $data['Item']['message'];
				$item_user['ItemUser']['gift_to'] = $data['Item']['gift_to'];
				$item_user['ItemUser']['gift_from'] = $data['Item']['gift_from'];
			}
			if (!empty($data['Item']['guest_names']) and !empty($data['Item']['guest_emails'])) {
				$guest_names = unserialize($data['Item']['guest_names']);
				$guest_emails = unserialize($data['Item']['guest_emails']);
			}
			//for credit card and paypal auth it should be 0
			if (($data['Item']['payment_gateway_id'] == ConstPaymentGateways::CreditCard) || ($data['Item']['payment_gateway_id'] == ConstPaymentGateways::PayPalAuth)) {
				$item_user['ItemUser']['is_paid'] = 0;
			}
			$this->Item->ItemUser->create();
			$this->Item->ItemUser->set($item_user);
			//for credit card doDirectPayment function call in paypal component
			if ($data['Item']['payment_gateway_id'] == ConstPaymentGateways::CreditCard) {
				if (!empty($paymentGateway['PaymentGatewaySetting'])) {
					foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting) {
						if ($paymentGatewaySetting['key'] == 'directpay_API_UserName') {
							$sender_info['API_UserName'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
						}
						if ($paymentGatewaySetting['key'] == 'directpay_API_Password') {
							$sender_info['API_Password'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
						}
						if ($paymentGatewaySetting['key'] == 'directpay_API_Signature') {
							$sender_info['API_Signature'] = $paymentGateway['PaymentGateway']['is_test_mode'] ? $paymentGatewaySetting['test_mode_value'] : $paymentGatewaySetting['live_mode_value'];
						}
					}
				}
				// If enabled, purchase amount is first taken with amount in wallet and then passed to CreditCard //
				if (Configure::read('wallet.is_handle_wallet')) {
					$user_available_balance = $this->Item->User->checkUserBalance($this->Auth->user('id'));
					$total_item_amount = $total_item_amount-$user_available_balance;
					$is_purchase_with_wallet_amount = 1;
				}
				// Currency Conversion Process //
				$get_conversion = $this->_convertAmount($total_item_amount);
				$sender_info['is_testmode'] = $paymentGateway['PaymentGateway']['is_test_mode'];
				$data_credit_card['firstName'] = $data['Item']['firstName'];
				$data_credit_card['lastName'] = $data['Item']['lastName'];
				$data_credit_card['creditCardType'] = $data['Item']['creditCardType'];
				$data_credit_card['creditCardNumber'] = $data['Item']['creditCardNumber'];
				$data_credit_card['expDateMonth'] = $data['Item']['expDateMonth'];
				$data_credit_card['expDateYear'] = $data['Item']['expDateYear'];
				$data_credit_card['cvv2Number'] = $data['Item']['cvv2Number'];
				$data_credit_card['address'] = $data['Item']['address'];
				$data_credit_card['city'] = $data['Item']['city'];
				$data_credit_card['state'] = $data['Item']['state'];
				$data_credit_card['zip'] = $data['Item']['zip'];
				$data_credit_card['country'] = $data['Item']['country'];
				$data_credit_card['paymentType'] = 'Authorization';
				$data_credit_card['amount'] = $get_conversion['amount'];
				$data_credit_card['currency_code'] = $get_conversion['currency_code'];
				//calling doDirectPayment fn in paypal component
				$payment_response = $this->Paypal->doDirectPayment($data_credit_card, $sender_info);
				//if not success show error msg as it received from paypal
				if (!empty($payment_response) && $payment_response['ACK'] != 'Success') {
					$this->Session->setFlash(sprintf(__l('%s') , $payment_response['L_LONGMESSAGE0']) , 'default', null, 'error');
					return;
				}
			}
			// For affiliates ( //
			if (!empty($data['ItemUser']['referred_by_user_id'])) { // For Wallet and Credit Card //
				$item_user['ItemUser']['referred_by_user_id'] = $data['ItemUser']['referred_by_user_id'];
			} else {
				$cookie_value = $this->Cookie->read('referrer');
				$refer_id = (!empty($cookie_value)) ? $cookie_value['refer_id'] : null;
				if (!empty($refer_id)) {
					$item_user['ItemUser']['referred_by_user_id'] = $refer_id;
				}
			}
			// ) affiliates //
			//save item user record
			if ($this->Item->ItemUser->save($item_user)) {
				$id = $this->Item->ItemUser->getLastInsertId();
				// For affiliates ( //
				$cookie_value = $this->Cookie->read('referrer');
				if (!empty($cookie_value)) {
					$this->Cookie->delete('referrer'); // Delete referer cookie

				}
				// ) affiliates //
				$last_inserted_id = $this->Item->ItemUser->getLastInsertId();
              
				if (!empty($data['Item']['charity_id'])) {
					$this->_set_charity_detail($data['Item']['charity_id'], $last_inserted_id);
				}
				// Multiple pass - Saving //
				$item_user_passes = array();
				$passes = $this->_getPasses($data['Item']['item_id'], $data['Item']['quantity']);
				$i = 0;
				foreach($passes as $key => $value) {
					$item_user_passes['id'] = '';
					$item_user_passes['item_user_id'] = $last_inserted_id;
					$item_user_passes['pass_code'] = $value;
					$item_user_passes['unique_pass_code'] = $this->_unum();
					if (!empty($data['ItemUserPass'])) {
						$item_user_passes['guest_name'] = $data['ItemUserPass'][$i]['guest_name'];
						$item_user_passes['guest_email'] = $data['ItemUserPass'][$i]['guest_email'];
					} elseif (!empty($guest_names) and !empty($guest_emails)) {
						$item_user_passes['guest_name'] = $guest_names[$i];
						$item_user_passes['guest_email'] = $guest_emails[$i];
					}
					$this->Item->ItemUser->ItemUserPass->save($item_user_passes);
					$i++;
				}
				if ($this->request->data['Item']['payment_gateway_id'] == ConstPaymentGateways::CreditCard && !empty($payment_response)) {
					$data_paypal_docapture_log['PaypalDocaptureLog']['authorizationid'] = $payment_response['TRANSACTIONID'];
					$data_paypal_docapture_log['PaypalDocaptureLog']['item_user_id'] = $last_inserted_id;
					$data_paypal_docapture_log['PaypalDocaptureLog']['dodirectpayment_correlationid'] = $payment_response['CORRELATIONID'];
					$data_paypal_docapture_log['PaypalDocaptureLog']['dodirectpayment_ack'] = $payment_response['ACK'];
					$data_paypal_docapture_log['PaypalDocaptureLog']['dodirectpayment_build'] = $payment_response['BUILD'];
					$data_paypal_docapture_log['PaypalDocaptureLog']['dodirectpayment_amt'] = $payment_response['AMT'];
					$data_paypal_docapture_log['PaypalDocaptureLog']['dodirectpayment_avscode'] = $payment_response['AVSCODE'];
					$data_paypal_docapture_log['PaypalDocaptureLog']['dodirectpayment_cvv2match'] = $payment_response['CVV2MATCH'];
					$data_paypal_docapture_log['PaypalDocaptureLog']['dodirectpayment_timestamp'] = $payment_response['TIMESTAMP'];
					$data_paypal_docapture_log['PaypalDocaptureLog']['dodirectpayment_response'] = serialize($payment_response);
					$data_paypal_docapture_log['PaypalDocaptureLog']['version'] = $payment_response['VERSION'];
					$data_paypal_docapture_log['PaypalDocaptureLog']['currencycode'] = $payment_response['CURRENCYCODE'];
					$data_paypal_docapture_log['PaypalDocaptureLog']['payment_status'] = 'Pending';
					//update item user id in PaypalDocaptureLog table
					$get_conversion = $this->getConversionCurrency();
					$data_paypal_docapture_log['PaypalDocaptureLog']['currency_id'] = $get_conversion['CurrencyConversion']['currency_id'];
					$data_paypal_docapture_log['PaypalDocaptureLog']['converted_currency_id'] = $get_conversion['CurrencyConversion']['converted_currency_id'];
					$data_paypal_docapture_log['PaypalDocaptureLog']['original_amount'] = $total_item_amount;
					$data_paypal_docapture_log['PaypalDocaptureLog']['rate'] = $get_conversion['CurrencyConversion']['rate'];
					//save do capture log records
					$this->Item->ItemUser->PaypalDocaptureLog->save($data_paypal_docapture_log);
				} else if ($data['Item']['payment_gateway_id'] == ConstPaymentGateways::PayPalAuth) {
					$is_purchase_with_wallet_amount = $data['Item']['is_purchase_with_wallet_amount'];
					//update item user id in PaypalTransactionLog table
					$this->Item->ItemUser->PaypalTransactionLog->updateAll(array(
						'PaypalTransactionLog.item_user_id' => $last_inserted_id
					) , array(
						'PaypalTransactionLog.id' => $data['Item']['paypal_transaction_log_id']
					));
				} else {
					if ($data['Item']['payment_gateway_id'] == ConstPaymentGateways::PagSeguro) {
						//update item user id in PaypalTransactionLog table
						$this->Item->PagseguroTransactionLog->updateAll(array(
							'PagseguroTransactionLog.item_user_id' => $last_inserted_id
						) , array(
							'PagseguroTransactionLog.id' => $data['Item']['pagseguro_transaction_log_id']
						));
					}
					//buy item through wallet
					$transaction['Transaction']['user_id'] = $item_user['ItemUser']['user_id'];
					$transaction['Transaction']['foreign_id'] = $last_inserted_id;
					$transaction['Transaction']['class'] = 'ItemUser';
					$transaction['Transaction']['amount'] = $total_item_amount;
					$transaction['Transaction']['transaction_type_id'] = (!empty($data['Item']['is_gift'])) ? ConstTransactionTypes::ItemGift : ConstTransactionTypes::BuyItem;
					//original_amount_needed
					$this->Item->User->Transaction->log($transaction);
					//user update
					$this->Item->User->updateAll(array(
						'User.available_balance_amount' => 'User.available_balance_amount -' . $total_item_amount,
					) , array(
						'User.id' => $item_user['ItemUser']['user_id']
					));
				}
				// If enabled, and after purchase, deduct partial amount from wallet //
				if (Configure::read('wallet.is_handle_wallet') && (!empty($is_purchase_with_wallet_amount))) {
					// Deduct amount ( zero will be updated ) //
					$user_available_balance = $this->Item->User->checkUserBalance($item_user['ItemUser']['user_id']);
					$this->Item->User->updateAll(array(
						'User.available_balance_amount' => 'User.available_balance_amount -' . $user_available_balance,
					) , array(
						'User.id' => $item_user['ItemUser']['user_id']
					));
					// Update transaction, This is firs transaction, to notify user that partial amount taken from wallet. Second transaction will be updated after item gets tipped.//
					if (!empty($user_available_balance) && $user_available_balance != '0.00') {
						$transaction['Transaction']['user_id'] = $item_user['ItemUser']['user_id'];
						$transaction['Transaction']['foreign_id'] = $last_inserted_id;
						$transaction['Transaction']['class'] = 'ItemUser';
						$transaction['Transaction']['amount'] = $user_available_balance;
						$transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::PartallyAmountTakenForItemPurchase;
						$transaction['Transaction']['payment_gateway_id'] = ConstPaymentGateways::Wallet;
						$this->Item->User->Transaction->log($transaction);
					}
				}
				//increasing item_user_count
				$this->Item->updateAll(array(
					'Item.item_user_count' => 'Item.item_user_count +' . $data['Item']['quantity'],
				) , array(
					'Item.id' => $item_id
				));
				//update item is on
				if ($item['Item']['item_status_id'] == ConstItemStatus::Open) {
					$db = $this->Item->getDataSource();
					$this->Item->updateAll(array(
						'Item.item_status_id' => ConstItemStatus::Tipped,
						'Item.item_tipped_time' => '\'' . date('Y-m-d H:i:s') . '\''
					) , array(
						'Item.item_status_id' => ConstItemStatus::Open,
						'Item.item_user_count >=' => $db->expression('Item.min_limit') ,
						'Item.id' => $item_id
					));
				}
				//send pass mail to users or close the item
				$this->Item->processItemStatus($item_id, $last_inserted_id);
				// after save fields //
				$data_for_aftersave = array();
				$data_for_aftersave['item_id'] = $item_id;
				$data_for_aftersave['item_user_id'] = $last_inserted_id;
				$data_for_aftersave['user_id'] = $user['User']['id'];
				$data_for_aftersave['merchant_id'] = $item['Merchant']['id'];
				$data_for_aftersave['payment_gateway_id'] = (!empty($data['Item']['payment_gateway_id']) ? $data['Item']['payment_gateway_id'] : ConstPaymentGateways::Wallet);
				$this->Item->_updateAfterPurchase($data_for_aftersave);
				//pay to referer
				$referred_by_user_id = $user['User']['referred_by_user_id'];
				//pay referral amount of referred users
				$this->_sendMailToReferredUser($referred_by_user_id, $item_user['ItemUser']['user_id'], $item_id);
				if ((Configure::read('referral.referral_enabled_option') == ConstReferralOption::GrouponLikeRefer) && !empty($referred_by_user_id)) {
					$this->_pay_to_referrer($item_id, $user['User']);
				}
				//item on end
				$merchant_address = ($item['Merchant']['address1']) ? $item['Merchant']['address1'] : '';
				$merchant_address.= ($item['Merchant']['address2']) ? ', ' . $item['Merchant']['address2'] : '';
				$merchant_address.= !empty($item['Merchant']['City']['name']) ? ', ' . $item['Merchant']['City']['name'] : '';
				$merchant_address.= !empty($item['Merchant']['State']['name']) ? ', ' . $item['Merchant']['State']['name'] : '';
				$merchant_address.= !empty($item['Merchant']['Country']['name']) ? ', ' . $item['Merchant']['Country']['name'] : '';
				$merchant_address.= '.';
				$language_code = $this->Item->getUserLanguageIso($item_user['ItemUser']['user_id']);
				$email_message = $this->EmailTemplate->selectTemplate('Item Bought', $language_code);
				$emailFindReplace = array(
					'##FROM_EMAIL##' => $this->Item->changeFromEmail(($email_message['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email_message['from']) ,
					'##SITE_NAME##' => Configure::read('site.name') ,
					'##USERNAME##' => $user['User']['username'],
					'##ITEM_TITLE##' => $item['Item']['name'],
					'##ITEM_AMOUNT##' => Configure::read('site.currency') . $total_item_amount,
					'##SITE_URL##' => Router::url('/', true) ,
					'##QUANTITY##' => $item_user['ItemUser']['quantity'],
					'##PURCHASE_ON##' => strftime(Configure::read('site.datetime.format')) ,
					'##ITEM_STATUS##' => $item['ItemStatus']['name'],
					'##MERCHANT_NAME##' => $item['Merchant']['name'],
					'##MERCHANT_ADDRESS##' => ($merchant_address) ? $merchant_address : '',
					'##CONTACT_URL##' => Router::url(array(
						'controller' => 'contacts',
						'action' => 'add',
						'city' => $this->request->params['named']['city'],
						'admin' => false
					) , true) ,
					'##GIFT_RECEIVER##' => !empty($item_user['ItemUser']['gift_to']) ? $item_user['ItemUser']['gift_to'] : '',
					'##SITE_LOGO##' => Router::url(array(
						'controller' => 'img',
						'action' => 'blue-theme',
						'logo-email.png',
						'admin' => false
					) , true) ,
				);
				$this->_sendMail($emailFindReplace, $email_message, $user['User']['email']);
				foreach($data['ItemUserPass'] as $tmp_pass) { // Item gift mail
					if ($tmp_pass['guest_email'] != $user['User']['email']) {
						$emailFindReplace['##USERNAME##'] = $tmp_pass['guest_name'];
						$emailFindReplace['##FRIEND_NAME##'] = $user['User']['username'];
						$language_code = $this->Item->getUserLanguageIso($item_user['ItemUser']['user_id']);
						$email_message = $this->EmailTemplate->selectTemplate('Item gift mail', $language_code);
						$this->_sendMail($emailFindReplace, $email_message, $tmp_pass['guest_email']);
					}
				}
				$userFriends = $this->Item->User->UserFriend->find('list', array(
					'conditions' => array(
						'UserFriend.friend_user_id' => $this->Auth->user('id')
					) ,
					'fields' => array(
						'UserFriend.user_id'
					) ,
					'recursive' => -1
				));
				if (!empty($userFriends)) {
					$userList = $this->Item->User->UserNotification->find('list', array(
						'conditions' => array(
							'UserNotification.user_id' => $userFriends,
							'UserNotification.when_user_booked_an_item_followed_by_me' => 1
						) ,
						'fields' => array(
							'UserNotification.user_id'
						) ,
						'recursive' => -1
					));
					if (!empty($userList)) {
						$users = $this->Item->User->find('all', array(
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
						if (!empty($users)) {
							foreach($users as $user) {
								$this->_sendAlertOnGroupUserEatPost1($user['User']['email'], $this->Auth->user('username') , $user['User']['username'], $item);
							}
						}
					}
				}
				$this->Session->setFlash(__l('You have bought an item successfully.') , 'default', null, 'success');
				$last_inserted_id = $this->Item->ItemUser->getLastInsertId();
				$find = $this->Item->ItemUser->find('first', array(
					'conditions' => array(
						'ItemUser.id' => $last_inserted_id
					)
				));
				$emailuser = $this->Item->User->find('first', array(
					'conditions' => array(
						'User.id' => $find['ItemUser']['user_id']
					)
				));
				$get_updated_status = $this->Item->find('first', array(
					'conditions' => array(
						'Item.id' => $item_id
					) ,
					'recursive' => -1
				));
				// <-- For iPhone App code
				if ($this->RequestHandler->prefers('json')) {
					$resonse = array(
						'status' => 0,
						'message' => __l('Success')
					);
					$this->view = 'Json';
					$this->set('json', (empty($this->viewVars['iphone_response'])) ? $resonse : $this->viewVars['iphone_response']);
					// For iPhone App code -->

				} else {
					if (empty($data['Item']['is_process_payment'])) {
						if (Configure::read('Item.invite_after_item_add') && $get_updated_status['Item']['item_status_id'] != ConstItemStatus::Closed) {
							$this->redirect(array(
								'controller' => 'user_friends',
								'action' => 'item_invite',
								'type' => 'item',
								'item' => $item['Item']['slug']
							));
						} else {
							$this->redirect(array(
								'controller' => 'users',
								'action' => 'my_stuff#My_Purchases'
							));
						}
					}
				}
			} else {
				if (empty($data['Item']['is_process_payment'])) {
					if ($this->RequestHandler->prefers('json')) {
						$resonse = array(
							'status' => 1,
							'message' => __l('You can\'t buy this item.')
						);
						$this->view = 'Json';
						$this->set('json', (empty($this->viewVars['iphone_response'])) ? $resonse : $this->viewVars['iphone_response']);
					} else {
						$this->Session->setFlash(__l('You can\'t buy this item.') , 'default', null, 'error');
						$this->redirect(array(
							'controller' => 'items',
							'action' => 'index'
						));
					}
				}
			}
		}
	}
	public function _sendMailToReferredUser($referred_by_user_id, $user_id, $item_id)
	{
		if (!empty($referred_by_user_id) && !empty($user_id)) {
			$user = $this->Item->User->find('first', array(
				'conditions' => array(
					'User.id' => $user_id
				) ,
				'fields' => array(
					'User.username',
					'User.email',
				) ,
				'recursive' => -1
			));
			$item = $this->Item->find('first', array(
				'conditions' => array(
					'Item.id' => $item_id
				) ,
				'fields' => array(
					'Item.name',
					'Item.slug',
				) ,
				'recursive' => -1
			));
			$userNotification = $this->Item->User->UserNotification->find('first', array(
				'conditions' => array(
					'UserNotification.user_id' => $referred_by_user_id,
					'UserNotification.when_user_book_an_item_after_your_invitation' => 1,
				) ,
				'contain' => array(
					'User' => array(
						'fields' => array(
							'User.username',
							'User.email',
						)
					)
				) ,
				'recursive' => 0
			));
			if (!empty($userNotification) && !empty($user) && !empty($item)) {
				$this->loadModel('EmailTemplate');
				$email = $this->EmailTemplate->selectTemplate('Referrer Booked Mail');
				$emailFindReplace = array(
					'##SITE_URL##' => Router::url('/', true) ,
					'##SITE_NAME##' => Configure::read('site.name'),
					'##USERNAME##' => $userNotification['User']['username'],
					'##FRIEND_USERNAME##' => $user['User']['username'],
					'##ITEM_TITLE##' => $item['Item']['name'],
					'##ITEM_LINK##' => Router::url(array(
                        'controller' => 'item',
                        'action' => 'view',
                        $item['Item']['slug'],
                        'admin' => false
                    ) , true),
					'##FROM_EMAIL##' => $this->Item->User->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
					'##CONTACT_URL##' => Router::url(array(
						'controller' => 'contacts',
						'action' => 'add',
						'city' => (!empty($this->request->params['named']['city'])) ? $this->request->params['named']['city'] : '',
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
				$this->Email->to = $userNotification['User']['email'];
				$this->Email->subject = strtr($email['subject'], $emailFindReplace);
				$this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
				if ($this->Email->send(strtr($email['email_content'], $emailFindReplace))) {
					return true;
				}
			}
		}
	}
	function _sendAlertOnGroupUserEatPost1($email, $username, $grabusername, $item)
	{
		$this->loadModel('EmailTemplate');
		$email_message = $this->EmailTemplate->selectTemplate('Grab User Alert');
		$email_replace = array(
			'##FROM_EMAIL##' => $this->Item->changeFromEmail(($email_message['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email_message['from']) ,
			'##SITE_URL##' => Router::url('/', true) ,
			'##PROFILEUSERNAME##' => $username,
			'##GRABUSER##' => $grabusername,
			'##SITE_NAME##' => Configure::read('site.name') ,
			'##PROFILE_LINK##' => Router::url(array(
				'controller' => 'users',
				'action' => 'view',
				$username,
				'#tabs-1',
				'admin' => false
			) , true) ,
			'##ITEM_NAME##' => !empty($item['Item']['name']) ? $item['Item']['name'] : '',
			'##MERCHANT##' => !empty($item['Merchant']['name']) ? $item['Merchant']['name'] : '',
			'##LINK##' => Router::url(array(
				'controller' => 'items',
				'action' => 'view',
				$item['Item']['slug'],
				'admin' => false
			) , true) ,
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
		// Send e-mail to users
		$this->Email->from = ($email_message['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email_message['from'];
		$this->Email->replyTo = ($email_message['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email_message['reply_to'];
		$this->Email->to = $this->Item->formatToAddress($email);
		$this->Email->subject = strtr($email_message['subject'], $email_replace);
		$this->Email->content = strtr($email_message['email_content'], $email_replace);
		$this->Email->sendAs = ($email_message['is_html']) ? 'html' : 'text';
		$this->Email->send($this->Email->content);
	}
	function _set_charity_detail($charity_id, $item_user_id)
	{
		if (!empty($charity_id)) {
			$ItemUser = $this->Item->ItemUser->find('first', array(
				'conditions' => array(
					'ItemUser.id' => $item_user_id
				) ,
				'contain' => array(
					'Item',
				) ,
				'recursive' => 2
			));
			$site_commission_amount = $seller_commission_amount = 0;
			$site_commission_amount = ($ItemUser['ItemUser']['discount_amount']*($ItemUser['Item']['commission_percentage']/100));
			$seller_commission_amount = $ItemUser['ItemUser']['discount_amount']-$site_commission_amount;
			if (Configure::read('charity.who_will_pay') == ConstCharityWhoWillPay::MerchantUser) {
				$site_commission_amount = 0;
			}
			if (Configure::read('charity.who_will_pay') == ConstCharityWhoWillPay::Admin) {
				$seller_commission_amount = 0;
			}
			$_data['CharitiesItemUser']['charity_id'] = $charity_id;
			$_data['CharitiesItemUser']['item_user_id'] = $item_user_id;
			$_data['CharitiesItemUser']['site_commission_amount'] = (empty($site_commission_amount)) ? 0 : ($ItemUser['Item']['charity_percentage'] * ($site_commission_amount / 100));
			$_data['CharitiesItemUser']['seller_commission_amount'] = (empty($seller_commission_amount)) ? 0 : ($ItemUser['Item']['charity_percentage'] * ($seller_commission_amount / 100));
			$_data['CharitiesItemUser']['amount'] = $_data['CharitiesItemUser']['site_commission_amount']+$_data['CharitiesItemUser']['seller_commission_amount'];
			$this->Item->ItemUser->CharitiesItemUser->save($_data);
			// Updating in ItemUser //
			$item_user_data = array();
			$item_user_data['ItemUser']['id'] = $item_user_id;
			$item_user_data['ItemUser']['charity_paid_amount'] = ($_data['CharitiesItemUser']['site_commission_amount'] + $_data['CharitiesItemUser']['seller_commission_amount']);
			$item_user_data['ItemUser']['charity_seller_amount'] =  $_data['CharitiesItemUser']['seller_commission_amount'];
			$item_user_data['ItemUser']['charity_site_amount'] = $_data['CharitiesItemUser']['site_commission_amount'];
            $this->Item->ItemUser->save($item_user_data);
		}
	}
	//pay referal amount to user when the new user buy his first item
	public function _pay_to_referrer($item_id, $item_buyer_data)
	{
		$ItemUserCount = $this->Item->ItemUser->find('count', array(
			'conditions' => array(
				'ItemUser.user_id' => $item_buyer_data['id']
			) ,
			'recursive' => -1
		));
		$today = strtotime(date('Y-m-d H:i:s'));
		$registered_date = strtotime($item_buyer_data['created']);
		$hours_diff = intval(($today-$registered_date) /60/60);
        $ref_user = $this->Item->User->find('first', array(
                'conditions' => array(
                    'User.id = ' => $item_buyer_data['referred_by_user_id'],
                ) ,
                'fields' => array(
                    'User.id',
                    'User.is_affiliate_user',
                ) ,
                'recursive' => -1
            ));
		//check whether this is user's first item and bought with in correct limit
		if (($ItemUserCount == 1) && $hours_diff <= Configure::read('user.referral_item_buy_time') && !$ref_user['User']['is_affiliate_user']) {
			//pay amount to referred user
			$transaction['Transaction']['user_id'] = $item_buyer_data['referred_by_user_id'];
			$transaction['Transaction']['foreign_id'] = ConstUserIds::Admin;
			$transaction['Transaction']['class'] = 'SecondUser';
			$transaction['Transaction']['amount'] = Configure::read('user.referral_amount');
			$transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::ReferralAmount;
			$this->Item->User->Transaction->log($transaction);
			$transaction = array();
			//admin record for referral amount
			$transaction['Transaction']['user_id'] = ConstUserIds::Admin;
			$transaction['Transaction']['foreign_id'] = $item_buyer_data['referred_by_user_id'];
			$transaction['Transaction']['class'] = 'SecondUser';
			$transaction['Transaction']['amount'] = Configure::read('user.referral_amount');
			$transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::ReferralAmountPaid;
			$transaction = array();
			//pay amount to referred user
			$transaction['Transaction']['user_id'] = $item_buyer_data['id'];
			$transaction['Transaction']['foreign_id'] = ConstUserIds::Admin;
			$transaction['Transaction']['class'] = 'SecondUser';
			$transaction['Transaction']['amount'] = Configure::read('user.referral_amount');
			$transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::ReferralAmount;
			$this->Item->User->Transaction->log($transaction);
			$transaction = array();
			//admin record for referral amount
			$transaction['Transaction']['user_id'] = ConstUserIds::Admin;
			$transaction['Transaction']['foreign_id'] = $item_buyer_data['id'];
			$transaction['Transaction']['class'] = 'SecondUser';
			$transaction['Transaction']['amount'] = Configure::read('user.referral_amount');
			$transaction['Transaction']['transaction_type_id'] = ConstTransactionTypes::ReferralAmountPaid;
			$this->Item->User->Transaction->log($transaction);
			$this->Item->User->updateAll(array(
				'User.available_balance_amount' => 'User.available_balance_amount +' . Configure::read('user.referral_amount'),
				'User.total_referral_earned_amount' => 'User.total_referral_earned_amount +' . Configure::read('user.referral_amount')
			) , array(
				'User.id' => $item_buyer_data['referred_by_user_id']
			));
			$this->Item->User->updateAll(array(
				'User.available_balance_amount' => 'User.available_balance_amount +' . Configure::read('user.referral_amount'),
				'User.total_referral_earned_amount' => 'User.total_referral_earned_amount +' . Configure::read('user.referral_amount')
			) , array(
				'User.id' => $item_buyer_data['id']
			));
			$this->Item->User->ItemUser->updateAll(array(
                'ItemUser.referral_commission_amount ' => Configure::read('user.referral_amount'),
				'ItemUser.is_referral_commission_sent ' => 1,
				'ItemUser.referral_commission_type ' => ConstReferralCommissionType::GrouponLikeRefer
            ) , array(
                'ItemUser.id' => $item_buyer_data['id']
            ));
		}
	}
	public function _sendMail($email_content_array, $template, $to, $sendAs = 'text')
	{
		$this->loadModel('EmailTemplate');
		$this->Email->from = ($template['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $template['from'];
		$this->Email->replyTo = ($template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $template['reply_to'];
		$this->Email->to = $to;
		$this->Email->subject = strtr($template['subject'], $email_content_array);
		$this->Email->content = strtr($template['email_content'], $email_content_array);
		$this->Email->sendAs = ($template['is_html']) ? 'html' : 'text';
		$this->Email->send($this->Email->content);
	}
	public function payment_success($gateway_id, $item_id = null)
	{
		$this->pageTitle = __l('Payment Success');
		$pay_pal_repsonse = $_POST;
		$item_slug = $this->Session->read('Auth.last_bought_item_slug');
		$this->Session->delete('Auth.last_bought_item_slug');
		if (!is_null($item_id)) {
			$item = $this->Item->find('first', array(
				'conditions' => array(
					'Item.id' => $item_id
				) ,
				'fields' => array(
					'Item.slug'
				) ,
				'recursive' => -1
			));
			if (!empty($item)) {
				$item_slug = $item['Item']['slug'];
			}
		}
		if (!empty($pay_pal_repsonse['auth_status'])) {
			$this->Session->write('Message.TransactionSuccessMessage', __l('Your payment has been successfully finished. We will update this transactions after item has been tipped.'));
			$this->Session->setFlash(__l('Your payment has been successfully finished. We will update this transactions after item has been tipped.') , 'default', null, 'success');
			$get_updated_status = $this->Item->find('first', array(
				'conditions' => array(
					'Item.id' => $item_id
				) ,
				'recursive' => -1
			));
			if (Configure::read('Item.invite_after_item_add') && $get_updated_status['Item']['item_status_id'] != ConstItemStatus::Closed) {
				$this->redirect(array(
					'controller' => 'user_friends',
					'action' => 'item_invite',
					'type' => 'item',
					'item' => $item_slug
				));
			} else {
				$this->redirect(array(
					'controller' => 'items',
					'action' => 'index'
				));
			}
		}
		$this->Session->write('Message.TransactionSuccessMessage', __l('Your payment has been successfully finished. We will update this transactions page after receiving the confirmation from PayPal'));
		$this->Session->setFlash(__l('Your payment has been successfully finished. We will update this transactions page after receiving the confirmation from PayPal') , 'default', null, 'success');
		if (Configure::read('Item.invite_after_item_add') && $get_updated_status['Item']['item_status_id'] != ConstItemStatus::Closed) {
			$this->redirect(array(
				'controller' => 'user_friends',
				'action' => 'item_invite',
				'type' => 'item',
				'item' => $item_slug
			));
		} else {
			$this->redirect(array(
				'controller' => 'users',
				'action' => 'my_stuff#My_Purchases'
			));
		}
	}
	public function payment_cancel()
	{
		$this->pageTitle = __l('Payment Cancel');
		$this->Session->setFlash(__l('Transaction failure. Please try once again.') , 'default', null, 'error');
		$this->redirect(array(
			'controller' => 'users',
			'action' => 'my_stuff',
			'#My_Transactions'
		));
	}
	//generate barcode
	public function barcode($barcode = null)
	{
		$this->autoRender = false;
		define(__TRACE_ENABLED__, false);
		define(__DEBUG_ENABLED__, false);
		include_once (APP . DS . 'vendors' . DS . 'barcode' . DS . 'barcode.php');
		include_once (APP . DS . 'vendors' . DS . 'barcode' . DS . Configure::read('barcode.symbology') . 'object.php');
		$output = "png";
		$width = Configure::read('barcode.width');
		$height = Configure::read('barcode.height');
		$xres = "2";
		$font = "5";
		$type = Configure::read('barcode.symbology');
		if (!empty($barcode)) {
			$style = BCS_ALIGN_CENTER;
			$style|= ($output == "png") ? BCS_IMAGE_PNG : 0;
			$style|= ($output == "jpeg") ? BCS_IMAGE_JPEG : 0;
			$style|= ($border == "on") ? BCS_BORDER : 0;
			$style|= ($drawtext == "on") ? BCS_DRAW_TEXT : 0;
			$style|= ($stretchtext == "on") ? BCS_STRETCH_TEXT : 0;
			$style|= ($negative == "on") ? BCS_REVERSE_COLOR : 0;
			switch ($type) {
				case "i25":
					$obj = new I25Object($width, $height, $style, $barcode);
					break;

				case "c39":
					$obj = new C39Object($width, $height, $style, $barcode);
					break;

				case "c128a":
					$obj = new C128AObject($width, $height, $style, $barcode);
					break;

				case "c128b":
					$obj = new C128BObject($width, $height, $style, $barcode);
					break;

				case "c128c":
					$obj = new C128CObject($width, $height, $style, $barcode);
					break;

				default:
					$obj = false;
			}
			if ($obj) {
				if ($obj->DrawObject($xres)) {
					$obj->SetFont($font);
					$obj->DrawObject($xres);
					$obj->FlushObject();
					$obj->DestroyObject();
					unset($obj);
				}
			}
		}
	}
	function widget()
	{
		$this->loadModel('AffiliateWidgetSize');
		$affiliateWidgetSize = $this->AffiliateWidgetSize->find('first', array(
			'conditions' => array(
				'AffiliateWidgetSize.id =' => $this->request->params['named']['size']
			) ,
			'recursive' => 1
		));
		$user = $this->Item->User->find('first', array(
			'conditions' => array(
				'User.username =' => $this->request->params['named']['user']
			) ,
			'fields' => array(
				'User.username'
			) ,
			'recursive' => -1
		));
		$conditions['Item.item_status_id'] = array(
			ConstItemStatus::Open,
			ConstItemStatus::Tipped,
		);
        $conditions['Item.end_date >='] = _formatDate('Y-m-d H:i:s', date('Y-m-d H:i:s') , true);
		$city = $this->Item->City->find('first', array(
			'conditions' => array(
				'City.slug' => $this->request->params['named']['city_name']
			) ,
			'fields' => array(
				'City.name',
				'City.id'
			) ,
			'recursive' => 1
		));
		$city_item_ids = array();
		foreach($city['Item'] as $item) {
			$city_item_ids[] = $item['id'];
		}
		$conditions['Item.id'] = $city_item_ids;
		$items = $this->Item->find('all', array(
			'conditions' => $conditions,
			'contain' => array(
				'Attachment',
			) ,
			'recursive' => 2
		));
		$content = '';
		if (!empty($city) && !empty($user) && !empty($affiliateWidgetSize)) {
			if (!empty($items)) {
				$template_content = $affiliateWidgetSize['AffiliateWidgetSize']['content'];
				$template_id = $affiliateWidgetSize['AffiliateWidgetSize']['id'];
				switch ($template_id) {
					case 2:
						$title_length = 15;
						break;

					case 3:
						$title_length = 15;
						break;

					case 4:
						$title_length = 25;
						break;

					case 5:
						$title_length = 35;
						break;

					case 6:
						$title_length = 30;
						break;

					case 7:
						$title_length = 30;
						break;

					case 8:
						$title_length = 30;
						break;

					case 9:
						$title_length = 50;
						break;

					case 10:
						$title_length = 20;
						break;

					default:
						$title_length = 15;
						break;
				}
				foreach($items as $item) {
					$image_options = array(
						'dimension' => 'original',
						'class' => '',
						'alt' => '',
						'title' => '',
						'type' => 'jpg'
					);
					$item_image_options = array(
						'dimension' => 'original',
						'class' => '',
						'alt' => '',
						'title' => '',
						'type' => 'jpg'
					);
					$adFindReplace = array(
						'##ITEM_LINK##' => Router::url(array(
							'controller' => 'items',
							'action' => 'view',
							$item['Item']['slug'],
							'city' => $this->request->params['named']['city_name'],
							'r' => $user['User']['username'],
							'admin' => false
						) , true) ,
						'##ITEM_MAIN_TITLE##' => (strlen($item['Item']['name']) > $title_length) ? substr($item['Item']['name'], 0, $title_length) . '...' : $item['Item']['name'],
						'##ITEM_TITLE##' => $item['Item']['name'],
						'##AD_IMAGE##' => Router::url('/',true).getImageUrl('AffiliateWidgetSize', $affiliateWidgetSize['Attachment'], $image_options) ,
						'##COLOR##' => '#' . $this->request->params['named']['color'],
						'##ITEM_HEADING##' => __l('Today\'s Item') ,
						'##ITEM_IMAGE##' => Router::url('/',true).getImageUrl('Item', $item['Attachment'][0], $item_image_options) ,
						'##ITEM_BOUGHT_COUNT##' => $item['Item']['item_user_count'],
						'##ITEM_PRICE##' => Configure::read('site.currency') . round($item['Item']['price']) ,
					);
					$TIME_LEFT = __l('Unlimited');
					$adFindReplace['##TIME_LEFT##'] = $TIME_LEFT;
					$content.= '<li>' . strtr($template_content, $adFindReplace) . '</li>';
					$skip_scroll = Configure::read('widget_no_scroll');
					if (in_array($affiliateWidgetSize['AffiliateWidgetSize']['id'], $skip_scroll)) {
						break;
					}
				}
			}
		}
		if (empty($content)) {
			$content = '<li>' . '<a class="no-item-found" target="_blank" href="' . Router::url('/', true) . $this->request->params['named']['city_name'] . '">No Item Found</a>' . '</li>';
			$content = "<div class='js-wiget js-wiget-" . $affiliateWidgetSize['AffiliateWidgetSize']['id'] . "'> <div><ul>" . $content . "</ul></div>";
		} else {
			$redirect_url = Router::url(array(
				'controller' => 'items',
				'action' => 'view',
				$item['Item']['slug'],
				'city' => $this->request->params['named']['city_name'],
				'r' => $user['User']['username'],
				'admin' => false
			) , true);
			if (in_array($affiliateWidgetSize['AffiliateWidgetSize']['id'], $skip_scroll)) {
				$content = "<div class='js-wiget js-widget-target {widget_redirect:\"$redirect_url\"} js-wiget-" . $affiliateWidgetSize['AffiliateWidgetSize']['id'] . "'> <div><ul>" . $content . "</ul></div>";
			} else {
				$content = "<div class='js-wiget js-widget-target {widget_redirect:\"$redirect_url\"} js-wiget-" . $affiliateWidgetSize['AffiliateWidgetSize']['id'] . "'> <button class='prev'><<</button><button class='next'>>></button> <div class='js-jcarousellite'><ul>" . $content . "</ul></div> </div>";
			}
		}
		$this->set('content', $content);
		$this->layout = 'affiliate';
	}
	function _getPasses($item_id, $quantity)
	{
		$passes = $this->Item->ItemPass->find('list', array(
			'conditions' => array(
				'ItemPass.item_id' => $item_id,
				'ItemPass.is_used' => 0
			) ,
			'fields' => array(
				'ItemPass.id',
				'ItemPass.pass_code',
			) ,
			'limit' => $quantity,
			'order' => array(
				'ItemPass.id' => 'asc'
			) ,
			'recursive' => -1
		));
		// If not sufficent, insert System generated passes //
		if (count($passes) < $quantity) {
			$remaining = $quantity-count($passes);
			for ($i = count($passes) +1; $i <= $quantity; $i++) {
				$system_gen_code = $this->_uuid() . '-' . $i;
				$system_pass_code[] = $system_gen_code;
				// Inserting System generated code in tables //
				$item_passes['id'] = '';
				$item_passes['item_id'] = $item_id;
				$item_passes['pass_code'] = $system_gen_code;
				$item_passes['is_system_generated'] = 1;
				$this->Item->ItemPass->save($item_passes);
			}
		}
		if (!empty($system_pass_code)) {
			$passes = array_merge($passes, $system_pass_code);
		}
		// Updating Used Codes //
		$this->Item->ItemPass->updateAll(array(
			'ItemPass.is_used' => 1
		) , array(
			'ItemPass.id' => array_keys($passes)
		));
		return $passes;
	}
	function purchased_user()
	{
		$conditions = array();
		if ($this->request->params['named']['type'] == "all_item") {
			$items = $this->Item->find('all', array(
				'conditions' => array(
					'Item.merchant_id' => $this->request->params['named']['merchant_id']
				) ,
				'recursive' => -1
			));
			$item_ids = array();
			foreach($items as $item) {
				$item_ids[] = $item['Item']['id'];
			}
			$conditions['ItemUser.item_id'] = $item_ids;
		} else {
			$conditions['ItemUser.item_id'] = $this->request->params['named']['item_id'];
		}
		$purchasedUsers = $this->Item->ItemUser->find('all', array(
			'conditions' => $conditions,
			'contain' => array(
				'User' => array(
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
							'UserProfile.first_name',
							'UserProfile.last_name',
							'UserProfile.middle_name',
							'UserProfile.gender_id',
							'UserProfile.about_me',
							'UserProfile.city_id',
							'UserProfile.dob',
							'UserProfile.language_id',
							'UserProfile.paypal_account',
							'UserProfile.user_id',
							'UserProfile.home_town',
							'UserProfile.interesting_fact',
							'UserProfile.url',
						) ,
						'City' => array(
							'fields' => array(
								'City.name'
							)
						)
					)
				) ,
			) ,
			'group' => array(
				'User.id'
			) ,
		));
		$this->set('purchasedUsers', $purchasedUsers);
		if ($this->request->params['named']['type'] == "current_item_view") {
			$this->render('purchased_user_index');
		}
	}
	function admin_item_stats()
	{
		$this->pageTitle = __l('Item Snapshot');
		$this->set('pageTitle', $this->pageTitle);
	}
}