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
class AppController extends Controller
{
    public $components = array(
        'RequestHandler',
        'Session',
        'Security',
        'Auth',
        'XAjax',
        'DebugKit.Toolbar',
        'Cookie',
        'Pdf'
    );
    public $helpers = array(
        'Html',
        'Session',
        'Javascript',
        'Form',
        'Auth',
        'Time',
        'Text',
        'RestXml',
        'RestJson',
    );
    var $cookieTerm = '+4 weeks';
    //    var $view = 'Theme';
    //    var $theme = 'default';
    function beforeRender()
    {
        $this->set('meta_for_layout', Configure::read('meta'));
        $this->set('js_vars_for_layout', (isset($this->js_vars)) ? $this->js_vars : '');
        if (Configure::read('site.is_api_enabled')) {
            if (!empty($this->request->query['api_key']) && !empty($this->request->query['api_token'])) {
                if (!empty($this->viewVars['api_response'])) {
                    $this->set('response', $this->viewVars['api_response']);
                } else {
                    $this->set('response', array(
                        'status' => 404,
                        'message' => __l('Unknown Error') ,
                        'items' => array()
                    ));
                }
            }
        }
        parent::beforeRender();
    }
    function __construct($request = null)
    {
        parent::__construct($request);
        include_once (APP . DS . 'vendors' . DS . 'mobileDeviceDetect.php');
        // <-- For iPhone App code
        if (empty($_GET['key']) and !empty($this->request->params['controller']) and $this->request->params['controller'] != 'images') {
            _mobile_device_detect();
        }
        // For iPhone App code -->
        //Setting cache related code
        $setting_key_value_pairs = Cache::read('setting_key_value_pairs');
        if (empty($setting_key_value_pairs)) {
            App::import('Model', 'Setting');
            $setting_model_obj = new Setting();
            $setting_key_value_pairs = $setting_model_obj->getKeyValuePairs();
            Cache::write('setting_key_value_pairs', $setting_key_value_pairs);
        }
        Configure::write($setting_key_value_pairs);
        // languages are set in globals
        $current_city_slug = Configure::read('site.city');
        if (!empty($_GET['url'])) {
            $city_slug = explode('/', $_GET['url']);
            $current_city_slug = (!empty($city_slug[0])) ? $city_slug[0] : Configure::read('site.city');
        }
        $lang_code = Configure::read('site.language');
        if (!empty($_COOKIE['CakeCookie']['user_language'])) {
            $lang_code = $_COOKIE['CakeCookie']['user_language'];
        } else if (!empty($current_city_slug)) {
            $cookie_city_slug = !empty($_COOKIE['CakeCookie']['city_slug']) ? $_COOKIE['CakeCookie']['city_slug'] : '';
            if (empty($cookie_city_slug) || ($current_city_slug != $cookie_city_slug)) {
                // This cache file will delete, in city model after save
                $city = Cache::read('site_cities_languages_' . $current_city_slug);
                if (empty($city)) {
                    $this->loadModel('City');
                    $city = $this->City->find('first', array(
                        'conditions' => array(
                            'City.slug' => $current_city_slug,
                            'City.is_approved' => 1,
							'City.is_enable' => 1
                        ) ,
                        'contain' => array(
                            'Language' => array(
                                'fields' => array(
                                    'Language.iso2'
                                )
                            )
                        ) ,
                        'fields' => array(
                            'City.language_id'
                        ) ,
                        'recursive' => 1
                    ));
                    // This cache file will delete, in city model after save
                    Cache::write('site_cities_languages_' . $current_city_slug, $city);
                }
                if (!empty($city['Language']['iso2'])) {
                    setcookie('CakeCookie[city_language]', $city['Language']['iso2']);
                    $lang_code = $city['Language']['iso2'];
                } else {
                    setcookie('CakeCookie[city_language]', $lang_code);
                }
            } elseif (!empty($_COOKIE['CakeCookie']['city_language'])) {
                $lang_code = $_COOKIE['CakeCookie']['city_language'];
            }
        }
        Configure::write('lang_code', $lang_code);
        Cache::set(array(
            'duration' => '+100 days'
        ));
        $translations = Cache::read($lang_code . '_translations');
        if (empty($translations) and $translations === false) {
            $this->loadModel('Translation');
            $translations = $this->Translation->find('all', array(
                'conditions' => array(
                    'Language.iso2' => $lang_code
                ) ,
                'fields' => array(
                    'Translation.key',
                    'Translation.lang_text'
                ) ,
                'contain' => array(
                    'Language' => array(
                        'fields' => array(
                            'Language.iso2'
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            Cache::set(array(
                'duration' => '+100 days'
            ));
            Cache::write($lang_code . '_translations', $translations);
        }
        if (!empty($translations)) {
            foreach($translations as $translation) {
                $GLOBALS['_langs'][$translation['Language']['iso2']][$translation['Translation']['key']] = $translation['Translation']['lang_text'];
            }
        }
        $this->js_vars = array();
        $js_trans_array = array(
            'Are you sure you want to ',
            'Please select atleast one record!',
            'Are you sure you want to do this action?',
            'Please enter valid original price.',
            'Discount percentage should be less than 100.',
            'Discount amount should be less than original price.',
            'Are you sure do you want to change the status? Once the status is changed you cannot undo the status.',
            'By clicking this button you are confirming your purchase. Once you confirmed amount will be deducted from your wallet and you can not undo this process. Are you sure you want to confirm this purchase?',
            'Since you don\'t have sufficent amount in wallet, your purchase process will be proceeded to PayPal. Are you sure you want to confirm this purchase?',
            'Google map could not find your location, please enter known location to google',
            'Invalid extension, Only csv, txt are allowed',
            'Enter your email address'
        );
        foreach($js_trans_array as $trans) {
            if (!empty($GLOBALS['_langs'][$lang_code][$trans])) {
                $this->js_vars['cfg']['lang'][$trans] = $GLOBALS['_langs'][$lang_code][$trans];
            }
        }
        // Writing Currency in cache
        $this->_cacheWriteCurrency();
        // affiliate type write cache
        $this->_cacheWriteAffiliateType();
        // Writing site name in cache, required for getting sitename retrieving in routes
        Cache::write('site.name', strtolower(Inflector::slug(Configure::read('site.name'))) , 'long');
        if (!(Cache::read('site_url_for_shell', 'long'))) {
            Cache::write('site_url_for_shell', Router::url('/', true) , 'long');
        }
           // Writing city routing url in cache
        if (($city_url = Cache::read('site.city_url', 'long')) === false) {
            Cache::write('site.city_url', Configure::read('site.city_url') , 'long');
        }
        // Writing default city name in cache
        $default_city = Cache::read('site.default_city', 'long');
        if (($default_city = Cache::read('site.default_city', 'long')) === false) {
            Cache::write('site.default_city', Configure::read('site.city') , 'long');
            $this->redirect(Router::url('/', true));
        }
    }
    function beforeFilter()
    {
        // Coding done to disallow demo user to change the admin settings
        if ($this->request->params['action'] != 'flashupload') {
            $cur_page = $this->request->params['controller'] . '/' . $this->request->params['action'];
            $admin_demomode_updation_not_allowed_array = Configure::read('site.admin_demomode_updation_not_allowed_array');
            if ($this->Auth->user('user_type_id') && $this->Auth->user('user_type_id') == ConstUserTypes::Admin && !Configure::read('site.is_admin_settings_enabled') && (!empty($this->request->data) || $this->request->params['action'] == 'admin_delete' || $this->request->params['action'] == 'admin_update') && in_array($cur_page, $admin_demomode_updation_not_allowed_array)) {
                $this->Session->setFlash(__l('Sorry. You cannot update or delete in demo mode') , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => $this->request->params['controller'],
                    'action' => 'index',
                ));
            }
        }
        // End of Code
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'geocity') {
            $this->loadModel('City');
            $city = $this->City->find('first', array(
                'conditions' => array(
                    'City.name' => $_COOKIE['city_name'],
                    'City.is_approved' => 1,
					'City.is_enable' => 1
                ) ,
                'contain' => array(
                    'Language' => array(
                        'fields' => array(
                            'Language.iso2'
                        )
                    )
                ) ,
                'fields' => array(
                    'City.language_id',
                    'City.slug'
                ) ,
                'recursive' => 1
            ));
            if (!empty($city)) {
                $this->request->params['named']['city'] = $city['City']['slug'];
                if (!empty($city['Language']['iso2'])) {
					Configure::write('lang_code', $city['Language']['iso2']);
                }
				$requested_url = $_COOKIE['_requested_url'];
				if (!empty($requested_url)) {
					$this->redirect(Router::url($requested_url, false));
				}
            } else {
                $this->request->params['named']['city'] = Configure::read('site.city');
            }
        }
        // check site is under maintenance mode or not. admin can set in settings page and then we will display maintenance message, but admin side will work.
		$maintenance_exception_array = array(
			'devs/asset_js',
			'devs/asset_css',
			'devs/robots',
			'devs/sitemap',
		);
        if (Configure::read('site.maintenance_mode') && $this->Auth->user('user_type_id') != ConstUserTypes::Admin && empty($this->request->params['prefix']) && !in_array($cur_page, $maintenance_exception_array)) {
            throw new MaintenanceModeException(__l('Maintenance Mode'));
        }
        $timezone_code = Configure::read('site.timezone_offset');
        if (!empty($timezone_code)) {
            date_default_timezone_set($timezone_code);
        }
        if (Configure::read('site.is_ssl_for_item_buy_enabled')) {
            $secure_array = array(
                'items/buy',
                'users/add_to_wallet',
                'users/login',
                'users/admin_login',
                'users/register',
                'users/merchant_register',
                'users/show_captcha',
            );
            $cur_page = $this->request->params['controller'] . '/' . $this->request->params['action'];
            if (in_array($cur_page, $secure_array) && $this->request->params['action'] != 'flashupload') {
                $this->Security->blackHoleCallback = 'forceSSL';
                $this->Security->requireSecure($this->request->params['action']);
            } else if (env('HTTPS') && !$this->RequestHandler->isAjax()) {
                $this->_unforceSSL();
            }
        }
        if ($this->request->params['controller'] != 'images' && $this->request->params['action'] != 'flashupload') {
            $_SESSION['city_attachment'] = '';
            $city_slug = !empty($this->request->params['named']['city']) ? $this->request->params['named']['city'] : Configure::read('site.city');
            // This cache file will delete, in city model after save
            $city = Cache::read('site_city_detail_' . $city_slug);
            if (empty($city)) {
                $this->loadModel('City');
                $city = $this->City->find('first', array(
                    'conditions' => array(
                        'City.slug' => !empty($this->request->params['named']['city']) ? $this->request->params['named']['city'] : Configure::read('site.city') ,
                        'City.is_approved' => 1
                    ) ,
                    'contain' => array(
                        'Attachment'
                    ) ,
                    'recursive' => 0
                ));
                // city based background image width and height set
                //$dir = WWW_ROOT . 'img' . DS . 'city_background_thumb' . DS . 'City';
                //$this->_traverse_directory($dir, 0);
                // This cache file will delete, in city model after save
                if (!empty($city)) {
                    Cache::write('site_city_detail_' . $city['City']['slug'], $city);
                }
            }
            // setting table to update current city thumb size
            if ((!empty($city['City']['thumb_width']) && (Configure::read('thumb_size.city_background_thumb.width') != $city['City']['thumb_width'])) || (!empty($city['City']['thumb_height']) && (Configure::read('thumb_size.city_background_thumb.height') != $city['City']['thumb_height']))) {
                $this->loadModel('Setting');
                $background = $this->Setting->find('all', array(
                    'conditions' => array(
                        'Setting.setting_category_id' => array(
                            7
                        )
                    ) ,
                    'recursive' => -1
                ));
                foreach($background as $value) {
                    if ($value['Setting']['name'] == 'thumb_size.city_background_thumb.width') {
                        $_data['Setting']['id'] = $value['Setting']['id'];
                        $_data['Setting']['value'] = $city['City']['thumb_width'];
                        $this->Setting->save($_data);
                        Configure::write('thumb_size.city_background_thumb.width', $city['City']['thumb_width']);
                    } elseif ($value['Setting']['name'] == 'thumb_size.city_background_thumb.height') {
                        $_data['Setting']['id'] = $value['Setting']['id'];
                        $_data['Setting']['value'] = $city['City']['thumb_height'];
                        $this->Setting->save($_data);
                        Configure::write('thumb_size.city_background_thumb.height', $city['City']['thumb_height']);
                    }
                }
            }
            if (!empty($this->request->params['named']['city']) and empty($city)) {
                $this->Session->setFlash(sprintf(__l('City you have requested is not available in %s.'), Configure::read('site.name')), 'default', null, 'error');
				if (empty($this->request->params['requested'])) {
					$this->redirect(array(
						'controller' => 'items',
						'action' => 'index',
						'city' => Cache::read('site.default_city', 'long')
					));
                    throw new NotFoundException(__l('Invalid request'));
                }
            }
            $this->set('city_id', $city['City']['id']);
            $this->set('city_name', $city['City']['name']);
            $this->set('city_slug', $city['City']['slug']);
            $this->set('city_attachment', $city['Attachment']);
            if (!empty($city['City']['is_bg_image_center'])):
                $this->set('is_bg_image_center', $city['City']['is_bg_image_center']);
            endif;
            if (!empty($city['City']['bgcolor'])):
                $this->set('bgcolor', $city['City']['bgcolor']);
            endif;
            // user avail balance
            if ($this->Auth->user('id')) {
                $this->loadModel('User');
                $this->set('user_available_balance', $this->User->checkUserBalance($this->Auth->user('id')));
            }
        }
        if (isset($this->request->data['Subscription']['city_id'])) {
            $this->loadModel('City');
            $city_info = $this->City->find('first', array(
                'conditions' => array(
                    'City.id' => $this->request->data['Subscription']['city_id'],
                    'City.is_approved' => 1
                ) ,
                'recursive' => -1
            ));
            setcookie('CakeCookie[city_slug]',$city_info['City']['slug'],time()+60*60*24*30,'/');
        } else if (!empty($this->request->params['named']['city']) && empty($this->request->params['isAjax']) && empty($this->request->params['requested'])) {
            setcookie('CakeCookie[city_slug]', $this->request->params['named']['city'], time() +60*60*24*30, '/');
        }
        if (!empty($this->request->params['named']['city'])) {
            setcookie('CakeCookie[city_slug]', $this->request->params['named']['city'],time()+60*60*24*30,'/');
        }
        // check ip is banned or not. redirect it to 403 if ip is banned
        $this->loadModel('BannedIp');
        $bannedIp = $this->BannedIp->checkIsIpBanned($this->RequestHandler->getClientIP());
        if (empty($bannedIp)) {
            $bannedIp = $this->BannedIp->checkRefererBlocked(env('HTTP_REFERER'));
        }
        if (!empty($bannedIp)) {
            if (!empty($bannedIp['BannedIp']['redirect'])) {
                header('location: ' . $bannedIp['BannedIp']['redirect']);
            } else {
                throw new ForbiddenException(__l('Invalid request'));
            }
        }
        $cur_page = $this->request->params['controller'] . '/' . $this->request->params['action'];
         //Fix to upload the file through the flash multiple uploader
        if ((isset($_SERVER['HTTP_USER_AGENT']) and ((strtolower($_SERVER['HTTP_USER_AGENT']) == 'shockwave flash') or (strpos(strtolower($_SERVER['HTTP_USER_AGENT']) , 'adobe flash player') !== false))) and isset($this->request->params['pass'][0]) and ($this->action == 'flashupload')) {
            $this->Session->id($this->request->params['pass'][0]);
        }
        if ($this->Auth->user('fb_user_id') || (!$this->Auth->user() && Configure::read('facebook.is_enabled_facebook_connect')) || ($this->request->params['controller'] == 'cities' && ($this->request->params['action'] == 'admin_index' || $this->request->params['action'] == 'admin_edit' || $this->request->params['action'] == 'fb_update')) || $this->request->params['controller'] == 'settings') {
            App::import('Vendor', 'facebook/facebook');
            // Prevent the 'Undefined index: facebook_config' notice from being thrown.
            $GLOBALS['facebook_config']['debug'] = NULL;
            // Create a Facebook client API object.
            $this->facebook = new Facebook(array(
                'appId' => Configure::read('facebook.app_id') ,
                'secret' => Configure::read('facebook.fb_secrect_key') ,
                'cookie' => true
            ));
            $this->set('facebookObj', $this->facebook);
            if ($this->Auth->user('id')) {
                $this->set('fb_logout_url', $this->facebook->getLogoutUrl(array(
                    'next' => (Router::url(array(
                        'controller' => !empty($city) ? $city['City']['slug'] : $this->request->params['named']['city'],
                        'action' => 'users',
                        'logout',
                        'admin' => false
                    ) , true))
                )));
            } else {
                if (!empty($this->request->params['named']['city'])) {
                    $this->set('fb_login_url', $this->facebook->getLoginUrl(array(
                        'cancel_url' => Router::url(array(
                            'controller' => $this->request->params['named']['city'],
                            'action' => 'users',
                            'register',
                            'admin' => false
                        ) , true) ,
                        'next' => Router::url(array(
                            'controller' => $this->request->params['named']['city'],
                            'action' => 'users',
                            'register',
                            'admin' => false
                        ) , true) ,
                        'req_perms' => 'email,publish_stream'
                    )));
                } else {
                    $this->set('fb_login_url', $this->facebook->getLoginUrl(array(
                        'cancel_url' => Router::url(array(
                            'controller' => 'users',
                            'action' => 'register',
                            'admin' => false
                        ) , true) ,
                        'next' => Router::url(array(
                            'controller' => 'users',
                            'action' => 'register',
                            'admin' => false
                        ) , true) ,
                        'req_perms' => 'email,publish_stream'
                    )));
                }
            }
        }
        if (strpos($this->here, '/view/') !== false) {
            trigger_error('*** dev1framework: Do not view page through /view/; use singular/slug', E_USER_ERROR);
        }
        // check the method is exist or not in the controller
        $methods = array_flip($this->methods);
        if (!isset($methods[strtolower($this->request->params['action']) ])) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (Configure::read('site.is_api_enabled')) {
            // check rest action or not
            $this->_handleRest();
        }
        // <-- For iPhone App code
        $this->Auth->fields = array(
            'username' => Configure::read('user.using_to_login') ,
            'password' => 'password'
        );
        if (!empty($_GET['key'])) {
            $this->_handleIPhoneApp();
        }
        // For iPhone App code -->
        $this->_affiliate_referral();
        $this->_checkAuth();
        //$this->js_vars = array();
        $this->js_vars['cfg']['icm'] = $GLOBALS['_city']['icm'];
        $this->js_vars['cfg']['path_relative'] = Router::url('/');
        $this->js_vars['cfg']['path_absolute'] = Router::url('/', true);
        $this->js_vars['cfg']['timezone'] = date('Z') / (60 * 60);
        $this->js_vars['cfg']['date_format'] = 'M d, Y';
        $this->js_vars['cfg']['today_date'] = date('Y-m-d');
        $this->js_vars['cfg']['site_name'] = strtolower(Inflector::slug(Configure::read('site.name')));
        $this->js_vars['cfg']['small_big_thumb.width'] = Configure::read('thumb_size.small_big_thumb.width');
        $this->js_vars['cfg']['small_big_thumb.height'] = Configure::read('thumb_size.small_big_thumb.height');
        $this->js_vars['cfg']['medium_big_thumb.width'] = Configure::read('thumb_size.medium_big_thumb.width');
        $this->js_vars['cfg']['medium_big_thumb.height'] = Configure::read('thumb_size.medium_big_thumb.height');
        $this->js_vars['cfg']['big_thumb.width'] = Configure::read('thumb_size.big_thumb.width');
        $this->js_vars['cfg']['big_thumb.height'] = Configure::read('thumb_size.big_thumb.height');
        $this->js_vars['cfg']['item.is_admin_enable_commission'] = Configure::read('item.is_admin_enable_commission');
        $this->js_vars['cfg']['item.commission_amount_type'] = Configure::read('item.commission_amount_type');
        $this->js_vars['cfg']['item.commission_amount'] = Configure::read('item.commission_amount');
        $this->js_vars['cfg']['user_type_id'] = $this->Auth->user('user_type_id');
        $_paypal_conversion_currency = Cache::read('site_paypal_conversion_currency');
        if (!empty($_paypal_conversion_currency)) {
            $this->js_vars['cfg']['site_paypal_conversion_currency'] = $_paypal_conversion_currency;
        }
        $this->loadModel('PaymentGateway');
        $massPayEnableCount = $this->PaymentGateway->find('count', array(
            'conditions' => array(
                'PaymentGateway.is_active' => 1,
                'PaymentGateway.is_mass_pay_enabled' => 1,
            ) ,
            'recursive' => 0
        ));
        $this->set('massPayEnableCount', $massPayEnableCount);
        parent::beforeFilter();
    }
    function _checkAuth()
    {
		$exception_array = Configure::read('site.exception_array');
        $cur_page = $this->request->params['controller'] . '/' . $this->request->params['action'];
        if (!in_array($cur_page, $exception_array) && $this->request->params['action'] != 'flashupload') {
            if (!$this->Auth->user('id')) {
                // check cookie is present and it will auto login to account when session expires
                $cookie_hash = $this->Cookie->read('User.cookie_hash');
                if (!empty($cookie_hash)) {
                    if (is_integer($this->cookieTerm) || is_numeric($this->cookieTerm)) {
                        $expires = time() +intval($this->cookieTerm);
                    } else {
                        $expires = strtotime($this->cookieTerm, time());
                    }
                    $this->loadModel('User');
                    $this->request->data = $this->User->find('first', array(
                        'conditions' => array(
                            'User.cookie_hash =' => md5($cookie_hash) ,
                            'User.cookie_time_modified <= ' => date('Y-m-d h:i:s', $expires) ,
                        ) ,
                        'fields' => array(
                            'User.' . Configure::read('user.using_to_login') ,
                            'User.password'
                        ) ,
                        'recursive' => -1
                    ));
                    // auto login if cookie is present
                    if ($this->Auth->login($this->request->data)) {
						$this->setMaxmindInfo('login');
                        $this->loadModel('User');
                        $user_model_obj->UserLogin->insertUserLogin($this->Auth->user('id'));
                        $this->redirect(Router::url('/', true) . $this->request->url);
                    }
                }
                $this->Session->setFlash(__l('You need to Log-In or Sign-Up to do that!'));
                $is_admin = false;
                if (isset($this->request->params['prefix']) and $this->request->params['prefix'] == 'admin') {
                    $is_admin = true;
                }
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login',
                    'admin' => $is_admin,
                    '?f=' . $this->request->url
                ));
            }
            if (isset($this->request->params['prefix']) and $this->request->params['prefix'] == 'admin' and $this->Auth->user('user_type_id') != ConstUserTypes::Admin) {
                $this->redirect(Router::url('/', true));
            }
        } else {
            $this->Auth->allow('*');
        }
        $this->Auth->autoRedirect = false;
        $this->Auth->userScope = array(
            'User.is_active' => 1,
            'User.is_email_confirmed' => 1
        );
        if (isset($this->Auth)) {
            $this->Auth->loginError = sprintf(__l('Sorry, login failed.  Either your %s or password are incorrect or admin deactivated your account.'), Configure::read('user.using_to_login'));
        }
        $this->layout = 'default';
        if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin && (isset($this->request->params['prefix']) and $this->request->params['prefix'] == 'admin')) {
            $this->layout = 'admin';
        }
        if (!empty($this->request->query['api_key']) && !empty($this->request->query['api_token'])) {
            $this->layout = false;
            $this->viewPath = 'api';
        }
        // if the site is accessed with m.domain; e.g., m.videomyne.com
        if (Configure::read('site.is_mobile_app') and stripos(getenv('HTTP_HOST') , 'm.') === 0) {
            // different layout and view for mobile application
            $this->layoutPath = 'mobile';
            //If mobile views folder and necessary .ctp file exist then using that, otherwise using the normal view folder ctp
            if (file_exists(VIEWS . $this->viewPath . DS . 'mobile' . DS . $this->request->params['action'] . $this->ext)) {
                $this->viewPath.= DS . 'mobile';
            }
        }
        // Layout Changes for API
        if (Configure::read('site.is_api_enabled')) {
            if (!empty($this->request->query['api_key']) && !empty($this->request->query['api_token'])) {
                $this->layout = false;
                $this->viewPath = 'api';
            }
        }
        	if (Configure::read('site.maintenance_mode') && !$this->Auth->user('user_type_id')) {
			$this->layout = 'maintenance';
		}
    }
    function autocomplete($param_encode = null, $param_hash = null)
    {
        $modelClass = Inflector::singularize($this->name);
        $conditions = false;
        if (isset($this->{$modelClass}->_schema['is_approved'])) {
            $conditions['is_approved'] = '1';
        }
		if (isset($this->{$modelClass}->_schema['is_active'])) {
            $conditions['is_active'] = '1';
        }
		if ($modelClass == 'User') {
			$conditions['user_type_id != '] = ConstUserTypes::Admin;
		}
        $this->XAjax->autocomplete($param_encode, $param_hash, $conditions);
    }
    function show_captcha()
    {
        include_once VENDORS . DS . 'securimage' . DS . 'securimage.php';
        $img = new securimage();
        $img->show(); // alternate use:  $img->show('/path/to/background.jpg');
        $this->autoRender = false;
    }
    function captcha_play()
    {
        App::import('Vendor', 'securimage/securimage');
        $img = new Securimage();
        $this->disableCache();
        $this->RequestHandler->respondAs('mp3', array(
            'attachment' => 'captcha.mp3'
        ));
        $img->audio_format = 'mp3';
        echo $img->getAudibleCode('mp3');
    }
    function _uuid()
    {
        return sprintf('%07x%1x', mt_rand(0, 0xffff) , mt_rand(0, 0x000f));
    }
    function _unum()
    {
        $acceptedChars = '0123456789';
        $max = strlen($acceptedChars) -1;
        $unique_code = '';
        for ($i = 0; $i < 8; $i++) {
            $unique_code.= $acceptedChars{mt_rand(0, $max) };
        }
        return $unique_code;
    }
    function _redirectGET2Named($whitelist_param_names = null)
    {
        $query_strings = array();
        $ajax_query_strings = '';
        if (is_array($whitelist_param_names)) {
            foreach($whitelist_param_names as $param_name) {
                if (!empty($this->request->query[$param_name])) { // querystring
                    if ($this->request->params['isAjax']) {
                        $ajax_query_strings.= $param_name . ':' . $this->request->query[$param_name] . '/';
                    } else {
                        $query_strings[$param_name] = $this->request->query[$param_name];
                    }
                }
            }
        } else {
            $query_strings = $this->request->query;
            unset($query_strings['url']); // Can't use ?url=foo

        }
        if (!empty($query_strings) || !empty($ajax_query_strings)) {
            if ($this->request->params['isAjax']) {
                $this->redirect(array(
                    'controller' => $this->request->params['controller'],
                    'action' => $this->request->params['action'],
                    $ajax_query_strings
                ) , null, true);
            } else {
                $query_strings = array_merge($this->request->params['named'], $query_strings);
                $this->redirect($query_strings, null, true);
            }
        }
    }
    public function redirect($url, $status = null, $exit = true)
    {
        if (Cache::read('site.city_url', 'long') == 'prefix') {
            parent::redirect(router_url_city($url, $this->request->params['named']) , $status, $exit);
        }
        parent::redirect($url, $status, $exit);
    }
    public function flash($message, $url, $pause = 1, $layout = 'flash')
    {
        if (Cache::read('site.city_url', 'long') == 'prefix') {
            parent::flash($message, router_url_city($url, $this->request->params['named']) , $pause);
        }
        parent::redirect($message, $url, $pause);
    }
    //Force a secure connection
    function forceSSL()
    {
        if (!env('HTTPS')) {
            $this->redirect('https://' . env('SERVER_NAME') . $this->here);
        }
    }
    function _unforceSSL()
    {
        if (empty($this->request->params['requested'])) $this->redirect('http://' . $_SERVER['SERVER_NAME'] . $this->here);
    }
    function _handleRest()
    {
        if (!empty($this->request->query['api_key']) && !empty($this->request->query['api_token'])) {
            $this->Security->enabled = false;
            $this->loadModel('User');
            $this->request->data = $this->User->find('first', array(
                'conditions' => array(
                    'User.api_key' => $this->request->query['api_key'],
                    'User.api_token' => $this->request->query['api_token'],
                ) ,
                'fields' => array(
                    'User.' . Configure::read('user.using_to_login') ,
                    'User.password'
                ) ,
                'recursive' => -1
            ));
            // auto login if api key and token is present
            if (!$this->Auth->login($this->request->data)) {
                $this->Session->setFlash(__l('Your API authorization request failed. Please try again'));
                throw new NotFoundException(__l('Invalid request'));
            }
        }
    }
    // <-- For iPhone App code
    function _handleIPhoneApp()
    {
        $this->Security->enabled = false;
        if (!empty($this->request->params['form'])) {
            foreach($this->request->params['form'] as $controller => $values) {
                $this->request->data[Inflector::camelize(Inflector::singularize($controller)) ] = $values;
            }
        }
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') === false) {
            $this->set('iphone_response', array(
                'status' => 1,
                'message' => __l('Unknown Application')
            ));
        } elseif (Configure::read('site.iphone_app_key') != $_GET['key']) {
            $this->set('iphone_response', array(
                'status' => 2,
                'message' => __l('Invalid App key')
            ));
        } elseif (!empty($_GET['username']) && $this->request->params['action'] != 'validate_user') {
            $this->request->data['User'][Configure::read('user.using_to_login') ] = trim($_GET['username']);
            $this->request->data['User']['password'] = $_GET['passwd'];
            $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);
            if (!$this->Auth->login($this->request->data)) {
                $this->set('iphone_response', array(
                    'status' => 1,
                    'message' => sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login'))
                ));
            }
        }
        if ($this->request->params['action'] == 'buy') {
            $this->request->data['Item']['user_id'] = $this->Auth->user('id');
            $this->request->data['Item']['payment_gateway_id'] = 4;
            $this->request->data['Item']['is_gift'] = 0;
        } elseif ($this->request->params['controller'] == 'user_payment_profiles' && $this->request->params['action'] == 'add') {
            $this->request->data['UserPaymentProfile']['user_id'] = $this->Auth->user('id');
        }
    }
    // For iPhone App code -->
    function _cacheWriteCurrency(){
		// write currency in cache
		$_currencies = Cache::read('site_currencies');
		$_supported_currencies = Cache::read('site_supported_currencies');
		$_paypal_conversion_currency = Cache::read('site_paypal_conversion_currency');	
        if(empty($_currencies)) {
            App::import('Model', 'Currency');
            $this->Currency = new Currency();
			$_currencies = $this->Currency->cacheCurrency();                        
            Cache::write('site_currencies', $_currencies);
        } 		
		if(empty($_supported_currencies)) {
            App::import('Model', 'Currency');
            $this->Currency = new Currency();
			$_currencies_2 = $this->Currency->cacheCurrency(1);                        
            Cache::write('site_supported_currencies', $_currencies_2);
        } 		
		if(empty($_paypal_conversion_currency)) {
            App::import('Model', 'CurrencyConversion');
            $this->CurrencyConversion = new CurrencyConversion();
			$selected_currency = $_currencies[Configure::read('site.currency_id')]['Currency']['id'];
			$c_selected_currency = $_currencies[Configure::read('site.paypal_currency_converted_id')]['Currency']['id'];
			$_currencies_3 = $this->CurrencyConversion->cacheConversionCurrency(0, $selected_currency, $c_selected_currency);                        
            Cache::write('site_paypal_conversion_currency', $_currencies_3);
        }
		$is_supported = (!empty($_currencies[Configure::read('site.currency_id')]['Currency']['is_paypal_supported']) ? $_currencies[Configure::read('site.currency_id')]['Currency']['is_paypal_supported'] : 0);
		Configure::write('paypal.is_supported', $is_supported);
		Configure::write('paypal.conversion_currency_code', $_currencies[Configure::read('site.paypal_currency_converted_id')]['Currency']['code']);
		Configure::write('paypal.currency_code', $_currencies[Configure::read('site.currency_id')]['Currency']['code']);
		Configure::write('site.currency', $_currencies[Configure::read('site.currency_id')]['Currency']['symbol']);	
		Configure::write('paypal.conversion_currency_symbol', $_currencies[Configure::read('site.paypal_currency_converted_id')]['Currency']['symbol']);			
		$_authorize_net_currency = Cache::read('site_authorizenet_conversion_currency');		
		if(empty($_authorize_net_currency) && $_currencies[Configure::read('site.currency_id')]['Currency']['id'] != ConstCurrencies::USD){
			App::import('Model', 'CurrencyConversion');
            $this->CurrencyConversion = new CurrencyConversion();
			$_authorize_net_currency = $this->CurrencyConversion->cacheConversionCurrency(0, $_currencies[Configure::read('site.currency_id')]['Currency']['id'], ConstCurrencies::USD);
			Cache::write('site_authorizenet_conversion_currency', $_authorize_net_currency);
		}
		$_pagseguro_net_currency = Cache::read('site_pagseguro_conversion_currency');		
		if(empty($_pagseguro_net_currency)){
			App::import('Model', 'CurrencyConversion');
            $this->CurrencyConversion = new CurrencyConversion();
			$_pagseguro_net_currency = $this->CurrencyConversion->cacheConversionCurrency(0, $_currencies[Configure::read('site.currency_id')]['Currency']['id'], ConstCurrencies::BRL);
			Cache::write('site_pagseguro_conversion_currency', $_pagseguro_net_currency);
		}		
	}
    // affiliate type write in cache file: cake_affiliate_type_affiliate_model
    function _cacheWriteAffiliateType()
    {
        $affiliate_model = Cache::read('affiliate_model', 'affiliatetype');
        if (empty($affiliate_model) and $affiliate_model === false) {
            $this->loadModel('AffiliateType');
            $affiliateType = $this->AffiliateType->find('list', array(
                'conditions' => array(
                    'AffiliateType.is_active' => 1
                ) ,
                'fields' => array(
                    'AffiliateType.model_name',
                    'AffiliateType.id'
                ) ,
                'recursive' => -1
            ));
            foreach($affiliateType as $key => $value) {
                $splited = explode(',', $key);
                if (count($splited) > 1) {
                    unset($affiliateType[$key]);
                    $affiliate_type_id = $value;
                    foreach($splited as $key => $value) {
                        $affiliateType[$value] = $affiliate_type_id;
                    }
                }
            }
            Cache::write('affiliate_model', $affiliateType, 'affiliatetype');
            $affiliate_model = Cache::read('affiliate_model', 'affiliatetype');
        }
    }
    function _affiliate_referral()
    {
        if (!empty($this->request->params['named']['r'])) {
            $this->loadModel('User');
            $referrer = array();
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.username' => $this->request->params['named']['r'],
                ) ,
                'fields' => array(
                    'User.username',
                    'User.id'
                ) ,
                'recursive' => -1
            ));
            if (!empty($user)) {
                // not check for particular url or page, so that set in refer_id in common, future apply for specific url
                $referrer['refer_id'] = $user['User']['id'];
                if (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'items') {
                    if (!empty($this->request->params['named']['category'])) {
                        $referrer['refer_id'] = $user['User']['id'];
                        $referrer['type'] = 'category';
                        $referrer['slug'] = $this->request->params['named']['category'];
                    } else if (!empty($this->request->params['action']) && $this->request->params['action'] == 'view') {
                        $referrer['refer_id'] = $user['User']['id'];
                        $referrer['type'] = 'view';
                        $referrer['slug'] = $this->request->params['pass']['0'];
                    }
                } else if (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'users') {
                    $referrer['refer_id'] = $user['User']['id'];
                    $referrer['type'] = 'user';
                    $referrer['slug'] = '';
                }
                $this->Cookie->delete('referrer');
                $this->Cookie->write('referrer', $referrer, false, sprintf('+%s hours', Configure::read('affiliate.referral_cookie_expire_time')));
                unset($this->request->params['named']['r']);
                $params = '';
                foreach($this->request->params['pass'] as $value) {
                    $params.= $value . '/';
                }
                foreach($this->request->params['named'] as $key => $value) {
                    $params.= $key . ':' . $value . '/';
                }
                $this->redirect(array(
                    'controller' => $this->request->params['controller'],
                    'action' => $this->request->params['action'],
                    $params
                ));
            }
        }
    }
    function _convertAmount($amount){
		$converted = array();
		$_paypal_conversion_currency = Cache::read('site_paypal_conversion_currency');
		$is_supported = Configure::read('paypal.is_supported');
		if(isset($is_supported) && empty($is_supported)){
			$converted['amount'] = round($amount * $_paypal_conversion_currency['CurrencyConversion']['rate'],2);
			$converted['currency_code'] = Configure::read('paypal.conversion_currency_code');
		}else{
			$converted['amount'] = $amount;
			$converted['currency_code'] = Configure::read('paypal.currency_code');		
		}		
		return $converted;
	}
	function _convertPagseguroAmount($amount, $rate = 0){
		$_currencies = Cache::read('site_currencies');
		$converted = array();
		$_pagseguro_net_currency = Cache::read('site_pagseguro_conversion_currency');
		if(($_currencies[Configure::read('site.currency_id')]['Currency']['id'] != ConstCurrencies::BRL) || (!empty($rate))){
			$rate = !empty($rate)? $rate : $_pagseguro_net_currency['CurrencyConversion']['rate'];
			$converted['amount'] = round($amount * $rate,2);
			$converted['rate'] = round($rate,2);
		}else{
			$converted['amount'] = $amount;			
			$converted['rate'] = '0';
		}		
		$converted['currency_id'] = ConstCurrencies::BRL;
		$converted['converted_currency_id'] = $_currencies[Configure::read('site.currency_id')]['Currency']['id'];
		return $converted;
	}	
	function getConversionCurrency(){
		if(Configure::read('paypal.is_supported') == 0){
			$_paypal_conversion_currency = Cache::read('site_paypal_conversion_currency');
			$_paypal_conversion_currency['supported_currency'] = Configure::read('paypal.is_supported');
			$_paypal_conversion_currency['conv_currency_code'] = Configure::read('paypal.conversion_currency_code');
			$_paypal_conversion_currency['currency_code'] = Configure::read('paypal.currency_code');
			$_paypal_conversion_currency['conv_currency_symbol'] = Configure::read('paypal.conversion_currency_symbol');
		} else {
			$_currencies = Cache::read('site_currencies');
			$_paypal_actual_currency = $_currencies[Configure::read('site.currency_id')]['Currency'];
			$_paypal_conversion_currency['CurrencyConversion']['currency_id'] = $_paypal_actual_currency['id'];
			$_paypal_conversion_currency['CurrencyConversion']['converted_currency_id'] = $_paypal_actual_currency['id'];
			$_paypal_conversion_currency['CurrencyConversion']['rate'] = '0';
			$_paypal_conversion_currency['supported_currency'] = Configure::read('paypal.is_supported');
			$_paypal_conversion_currency['conv_currency_code'] = $_paypal_actual_currency['code'];
			$_paypal_conversion_currency['currency_code'] = $_paypal_actual_currency['code'];
			$_paypal_conversion_currency['conv_currency_symbol'] = $_paypal_actual_currency['symbol'];
		}
		return $_paypal_conversion_currency;
	}	
	function getAuthorizeConversionCurrency(){
		$_paypal_conversion_currency = Cache::read('site_authorizenet_conversion_currency');
		$_currencies = Cache::read('site_currencies');
		if($_currencies[Configure::read('site.currency_id')]['Currency']['id'] == ConstCurrencies::USD){
			App::import('Model', 'CurrencyConversion');
            $this->CurrencyConversion = new CurrencyConversion();
			$_paypal_conversion_currency = $this->CurrencyConversion->cacheConversionCurrency(0, $_currencies[Configure::read('site.currency_id')]['Currency']['id'], ConstCurrencies::USD);
		}
		return $_paypal_conversion_currency;
	}
    function _traverse_directory($dir, $dir_count)
    {
        @$handle = opendir($dir);
        while (false !== ($readdir = @readdir($handle))) {
            if ($readdir != '.' && $readdir != '..') {
                $path = $dir . '/' . $readdir;
                if (is_dir($path)) {
                    @chmod($path, 0777);
                    ++$dir_count;
                    $this->_traverse_directory($path, $dir_count);
                }
                if (is_file($path)) {
                    @chmod($path, 0777);
                    @unlink($path);
                    //so that page wouldn't hang
                    flush();
                }
            }
        }
        @closedir($handle);
        @rmdir($dir);
        return true;
    }
	function isAllowed($user_type = null)
    {
        if ($user_type == ConstUserTypes::Merchant && !Configure::read('user.is_merchant_actas_normal_user')) {
            return false;
        }
        return true;
    }
	function update()
	{
		if (!empty($this->request->data[$this->modelClass])) {
			// Detach the model for message and message content, so to disable flagging for admin functions
			if ($this->modelClass == 'Message' || $this->modelClass == 'MessageContent') {
				$this->Message->MessageContent->Behaviors->detach('SuspiciousWordsDetector');
			}
			$r = $this->request->data[$this->modelClass]['r'];
			$actionid = $this->request->data[$this->modelClass]['more_action_id'];
			unset($this->request->data[$this->modelClass]['r']);
			unset($this->request->data[$this->modelClass]['more_action_id']);
			$ids = array();
			foreach($this->request->data[$this->modelClass] as $id => $is_checked) {
				if (!empty($is_checked['id'])) {
					$ids[] = $id;
				}
			}
			if ($actionid && !empty($ids)) {
				switch ($actionid) {
					case ConstMoreAction::Delete:
						foreach($ids as $id) {
							$this->{$this->modelClass}->delete($id);
						}
						$this->Session->setFlash(__l('Checked records has been deleted') , 'default', null, 'success');
						break;
					}
			}
		}
		$this->redirect(Router::url('/', true) . $r);
	}
    function admin_update_status($id = null)
    {
        $this->loadModel('PropertyUser');
        $this->loadModel('EmailTemplate');
        $this->loadModel('Message');
        $ajax_repsonse = '';
        $success_message = '';
        $error_message = '';
        if (!empty($this->request->params['named']['show']) && ($this->request->params['named']['show'] == 'deactivate')) {
            $field = 'is_show_in_home_page';
            $value = '0';
            $ajax_repsonse = 'show_in_home_page';
            $url = Router::url(array(
                'controller' => 'properties',
                'action' => 'admin_update_status',
                'status' => 'activate',
                $id
            ) , true);
            $success_message = __l('Show in home page deactivated successfully');
            @unlink(APP . WEBROOT_DIR . DS . 'index.html');
        } elseif (!empty($this->request->params['named']['show']) && ($this->request->params['named']['show'] == 'activate')) {
            $model = $this->modelClass;
            $product_count = $this->$model->find('count', array(
                'conditions' => array(
                    $model . '.is_show_in_home_page' => 1
                ) ,
            ));
            if ($product_count < Configure::read('properties.max_limit_to_home_slider')) {
                $field = 'is_show_in_home_page';
                $value = '1';
                $success_message = __l('Show in home page activated successfully');
            } else {
                $error_message = __l('Only ') . Configure::read('properties.max_limit_to_home_slider') . __l(' properties allowed to show in home page slider');
            }
            $ajax_repsonse = 'hide_in_home_page';
            $url = Router::url(array(
                'controller' => 'properties',
                'action' => 'admin_update_status',
                'status' => 'deactivate',
                $id
            ) , true);
            @unlink(APP . WEBROOT_DIR . DS . 'index.html');
        } elseif (!empty($this->request->params['named']['featured']) && ($this->request->params['named']['featured'] == 'deactivate')) {
            $field = 'is_featured';
            $value = '0';
            $ajax_repsonse = 'property_featured';
            $url = Router::url(array(
                'controller' => 'properties',
                'action' => 'admin_update_status',
                'status' => 'activate',
                $id
            ) , true);
            $success_message = __l('Featured deactivated successfully');
        } elseif (!empty($this->request->params['named']['featured']) && ($this->request->params['named']['featured'] == 'activate')) {
            $field = 'is_featured';
            $value = '1';
            $ajax_repsonse = 'property_not_featured';
            $url = Router::url(array(
                'controller' => 'properties',
                'action' => 'admin_update_status',
                'status' => 'deactivate',
                $id
            ) , true);
            $success_message = __l('Featured activated successfully');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'deactivate')) {
            $field = 'is_active';
            $value = '0';
            $ajax_repsonse = 'user_blocked';
            $url = Router::url(array(
                'controller' => 'users',
                'action' => 'admin_update_status',
                'status' => 'activate',
                $id
            ) , true);
            $success_message = __l('User blocked successfully');
            $this->_sendAdminActionMail($id, 'Admin User Deactivate');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'activate')) {
            $field = 'is_active';
            $value = '1';
            $ajax_repsonse = 'user_unblocked';
            $url = Router::url(array(
                'controller' => 'users',
                'action' => 'admin_update_status',
                'status' => 'deactivate',
                $id
            ) , true);
            $success_message = __l('User activated successfully');
        } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'suspend')) {
            $field = 'admin_suspend';
            $value = '1';
            if ($this->modelClass == 'Request') {
                $ajax_repsonse = 'request_suspend';
                $url = Router::url(array(
                    'controller' => 'requests',
                    'action' => 'admin_update_status',
                    'flag' => 'unsuspend',
                    $id
                ) , true);
            } else {
                $ajax_repsonse = 'property_suspend';
                if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) {
                    $get_orders = $this->Property->find('first', array(
                        'conditions' => array(
                            'Property.id' => $id,
                        ) ,
                        'contain' => array(
                            'PropertyUser' => array(
                                'conditions' => array(
                                    'PropertyUser.property_user_status_id' => array(
                                        ConstPropertyUserStatus::WaitingforAcceptance,
                                        ConstPropertyUserStatus::Arrived,
                                        ConstPropertyUserStatus::WaitingforReview,
                                    )
                                )
                            )
                        ) ,
                        'recursive' => 1
                    ));
                    if (!empty($get_orders['PropertyUser'])) {
                        foreach($get_orders['PropertyUser'] as $property_users) {
                            $this->PropertyUser->processOrder($property_users['id'], 'admin_cancel');
                        }
                    }
                }
                $url = Router::url(array(
                    'controller' => 'properties',
                    'action' => 'admin_update_status',
                    'flag' => 'unsuspend',
                    $id
                ) , true);
            }
            $success_message = $this->modelClass . ' ' . __l('suspended successfully');
        } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'unsuspend')) {
            $field = 'admin_suspend';
            $value = '0';
            $ajax_repsonse = 'property_unsuspend';
            $url = Router::url(array(
                'controller' => 'properties',
                'action' => 'admin_update_status',
                'flag' => 'suspend',
                $id
            ) , true);
            if ($this->modelClass == 'Request') {
                $ajax_repsonse = 'request_unsuspend';
                $url = Router::url(array(
                    'controller' => 'requests',
                    'action' => 'admin_update_status',
                    'flag' => 'suspend',
                    $id
                ) , true);
            }
            $success_message = $this->modelClass . ' ' . __l('unsuspended successfully');
        } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'active')) {
            $field = 'is_system_flagged';
            $value = '1';
            $ajax_repsonse = 'flagged';
            $url = Router::url(array(
                'controller' => 'properties',
                'action' => 'admin_update_status',
                'flag' => 'deactivate',
                $id
            ) , true);
            if ($this->modelClass == 'Request') {
                $ajax_repsonse = 'request_flagged';
                $url = Router::url(array(
                    'controller' => 'requests',
                    'action' => 'admin_update_status',

                    'flag' => 'deactivate',
                    $id
                ) , true);
            }
            $success_message = $this->modelClass . ' ' . __l('flagged successfully');
        } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'deactivate')) {
            $field = 'is_system_flagged';
            $value = '0';
            $ajax_repsonse = 'flag_cleared';
            $url = Router::url(array(
                'controller' => 'properties',
                'action' => 'admin_update_status',
                'flag' => 'active',
                $id
            ) , true);
            if ($this->modelClass == 'Request') {
                $ajax_repsonse = 'request_flag_cleared';
                $url = Router::url(array(
                    'controller' => 'requests',
                    'action' => 'admin_update_status',
                    'flag' => 'active',
                    $id
                ) , true);
            }
            $success_message = $this->modelClass . ' ' . __l('flag cleared successfully');
        } elseif (!empty($this->request->params['named']['verify']) && ($this->request->params['named']['verify'] == 'active')) {
            $field = 'is_verified';
            $value = '1';
            $ajax_repsonse = 'verified';
            $url = Router::url(array(
                'controller' => 'properties',
                'action' => 'admin_update_status',
                'verify' => 'deactivate',
                $id
            ) , true);
            if ($this->modelClass == 'Request') {
                $ajax_repsonse = 'request_verified';
                $url = Router::url(array(
                    'controller' => 'requests',
                    'action' => 'admin_update_status',
                    'verify' => 'deactivate',
                    $id
                ) , true);
            }
            $success_message = $this->modelClass . ' ' . __l('verified successfully');
        } elseif (!empty($this->request->params['named']['verify']) && ($this->request->params['named']['verify'] == 'deactivate')) {
            $field = 'is_verified';
            $value = '0';
            $ajax_repsonse = 'verify_cleared';
            $url = Router::url(array(
                'controller' => 'properties',
                'action' => 'admin_update_status',
                'verify' => 'active',
                $id
            ) , true);
            if ($this->modelClass == 'Request') {
                $ajax_repsonse = 'request_flag_cleared';
                $url = Router::url(array(
                    'controller' => 'requests',
                    'action' => 'admin_update_status',
                    'verify' => 'active',
                    $id
                ) , true);
            }
            $success_message = $this->modelClass . ' ' . __l('unverified successfully');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'disapproved')) {
            $field = 'is_approved';
            $value = '0';
            $ajax_repsonse = 'property_approved';
            $url = Router::url(array(
                'controller' => 'properties',
                'action' => 'admin_update_status',
                'status' => 'approved',
                $id
            ) , true);
            if ($this->modelClass == 'Request') {
                $ajax_repsonse = 'request_approved';
                $url = Router::url(array(
                    'controller' => 'requests',
                    'action' => 'admin_update_status',
                    'status' => 'approved',
                    $id
                ) , true);
            }
            $success_message = $this->modelClass . ' ' . __l('disapproved successfully');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'approved')) {
            $field = 'is_approved';
            $value = '1';
            $ajax_repsonse = 'property_disapproved';
            $url = Router::url(array(
                'controller' => 'properties',
                'action' => 'admin_update_status',
                'status' => 'disapproved',
                $id
            ) , true);
            if ($this->modelClass == 'Request') {
                $ajax_repsonse = 'request_disapproved';
                $url = Router::url(array(
                    'controller' => 'requests',
                    'action' => 'admin_update_status',
                    'status' => 'disapproved',
                    $id
                ) , true);
                $request = $this->Request->find('first', array(
                    'conditions' => array(
                        'Request.id' => $id,
                    ) ,
                    'recursive' => -1
                ));
            }
            if ($this->modelClass == 'Property') {
                $property = $this->Property->find('first', array(
                    'conditions' => array(
                        'Property.id' => $id,
                    ) ,
                    'contain' => array(
                        'User'
                    ) ,
                    'recursive' => 0
                ));
                $mail_template = 'New Property Activated';
                if (!empty($mail_template)) {
                    $template = $this->EmailTemplate->selectTemplate($mail_template);
                    $emailFindReplace = array(
                        '##USERNAME##' => $property['User']['username'],
                        '##PROPERTY_NAME##' => $property['Property']['title'],
                        '##PROPERTY_URL##' => Router::url(array(
                            'controller' => 'properties',
                            'action' => 'view',
                            $property['Property']['slug'],
                            'admin' => false,
                        ) , true) ,
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##SITE_LINK##' => Router::url('/', true) ,
                        '##FROM_EMAIL##' => ($template['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $template['from'],
                        '##CONTACT_URL##' => Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add'
                        ) , true) ,
                        '##SITE_LOGO##' => Router::url(array(
                            'controller' => 'img',
                            'action' => 'logo.png',
                            'admin' => false
                        ) , true) ,
                    );
                    $host_email = $property['User']['email'];
                    $email_message = __l('Your property has been activated');
                    $message = strtr($template['email_content'], $emailFindReplace);
                    $subject = strtr($template['subject'], $emailFindReplace);
                    if (Configure::read('messages.is_send_internal_message')) {
                        $message_id = $this->Message->sendNotifications($property['User']['id'], $subject, $message, 0, $is_review = 0, $property['Property']['id'], 0);
                        if (Configure::read('messages.is_send_email_on_new_message')) {
                            $content['subject'] = $subject;
                            $content['message'] = $message;
                            if (!empty($host_email)) {
                                $this->Property->_sendAlertOnNewMessage($host_email, $content, $message_id, 'Booking Alert Mail');
                            }
                        }
                    }
                }
            }
            $success_message = $this->modelClass . ' ' . __l('approved successfully');
        } else {
            $ajax_repsonse = 'failed';
        }
        if ($this->modelClass == 'Message' && !empty($this->request->params['named']['flag'])) {
            $this->Message->MessageContent->updateAll(array(
                $field => $value
            ) , array(
                'MessageContent.id' => $id
            ));
            if (!empty($this->request->params['named']['flag']) == 'deactivate') {
                if (Configure::read('messages.is_send_email_on_new_message')) {
                    $this->_reSendMail($id);
                }
            }
            if (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'active')) {
                $ajax_repsonse = 'message_flagged';
                $url = Router::url(array(
                    'controller' => 'messages',
                    'action' => 'admin_update_status',
                    'flag' => 'deactivate',
                    $id
                ) , true);
                $success_message = __l('Message flagged successfully');
            } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'deactivate')) {
                $ajax_repsonse = 'message_flag_cleared';
                $url = Router::url(array(
                    'controller' => 'messages',
                    'action' => 'admin_update_status',
                    'flag' => 'active',
                    $id
                ) , true);
                $success_message = __l('Message flag cleared successfully');
            }
        } elseif ($this->modelClass == 'Property' && (isset($this->request->params['named']['verify']) && $this->request->params['named']['verify'] == 'active')) {
            $this->{$this->modelClass}->updateAll(array(
                $this->modelClass . '.' . $field => $value,
                $this->modelClass . '.verified_date' => '\'' . date('Y-m-d h:i:s') . '\''
            ) , array(
                $this->modelClass . '.id' => $id
            ));
            $this->Session->setFlash($success_message, 'default', null, 'success');
        } else {
            if ($error_message == '') {
                $data[$this->modelClass]['id'] = $id;
                $data[$this->modelClass][$field] = $value;
                $this->{$this->modelClass}->save($data, false);
                // Quickfix, since above doesn't work for flagged alone //
                $this->{$this->modelClass}->updateAll(array(
                    $this->modelClass . '.' . $field => $value
                ) , array(
                    $this->modelClass . '.id' => $id
                ));
                if ($this->modelClass == 'Property' && (isset($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'approved')) {
                    //update into facebook
                    $this->update_social_networking($property['Property']['id']);
                } else if ($this->modelClass == 'Request' && (isset($this->request->params['named']['status']) && $this->request->params['named']['status'] == 'approved')) {
                    $this->update_request_in_social_networking($request['Request']['id']);
                }
                $this->Session->setFlash($success_message, 'default', null, 'success');
            } else {
                $this->Session->setFlash($error_message, 'default', null, 'error');
            }
        }
        if ($this->RequestHandler->isAjax() && !empty($ajax_repsonse)) {
            echo $ajax_repsonse . '|' . $url;
            exit;
        } else {
            $this->redirect(array(
                'action' => 'index',
            ));
        }
    }
	function admin_update()
	{
		if (!empty($this->request->data[$this->modelClass])) {
			// Detach the model for message and message content, so to disable flagging for admin functions
			if ($this->modelClass == 'Message' || $this->modelClass == 'MessageContent') {
				$this->Message->MessageContent->Behaviors->detach('SuspiciousWordsDetector');
			}
			$r = $this->request->data[$this->modelClass]['r'];
			$actionid = $this->request->data[$this->modelClass]['more_action_id'];
			unset($this->request->data[$this->modelClass]['r']);
			unset($this->request->data[$this->modelClass]['more_action_id']);
			$ids = array();
			foreach($this->request->data[$this->modelClass] as $id => $is_checked) {
				if (!empty($is_checked['id'])) {
					$ids[] = $id;
				}
			}
			if ($actionid && !empty($ids)) {
				switch ($actionid) {
					case ConstMoreAction::Inactive:
						$this->{$this->modelClass}->updateAll(array(
							$this->modelClass . '.is_active' => 0
						) , array(
							$this->modelClass . '.id' => $ids
						));
						$this->Session->setFlash(__l('Checked records has been disabled') , 'default', null, 'success');
						break;

					case ConstMoreAction::Active:
						$this->{$this->modelClass}->updateAll(array(
							$this->modelClass . '.is_active' => 1
						) , array(
							$this->modelClass . '.id' => $ids
						));
						$this->Session->setFlash(__l('Checked records has been enabled') , 'default', null, 'success');
						break;

					case ConstMoreAction::Disapproved:
						$this->{$this->modelClass}->updateAll(array(
							$this->modelClass . '.is_approved' => 0
						) , array(
							$this->modelClass . '.id' => $ids
						));
						$this->Session->setFlash(__l('Checked records has been disapproved') , 'default', null, 'success');
						break;

					case ConstMoreAction::Approved:
						$this->{$this->modelClass}->updateAll(array(
							$this->modelClass . '.is_approved' => 1
						) , array(
							$this->modelClass . '.id' => $ids
						));
						$this->Session->setFlash(__l('Checked records has been approved') , 'default', null, 'success');
						break;

					case ConstMoreAction::Suspend:
						$this->{$this->modelClass}->updateAll(array(
							$this->modelClass . '.admin_suspend' => 1
						) , array(
							$this->modelClass . '.id' => $ids
						));
						$this->Session->setFlash(__l('Checked records has been Suspended') , 'default', null, 'success');
						break;

					case ConstMoreAction::Unsuspend:
						$this->{$this->modelClass}->updateAll(array(
							$this->modelClass . '.admin_suspend' => 0
						) , array(
							$this->modelClass . '.id' => $ids
						));
						$this->Session->setFlash(__l('Checked records has been changed to Unsuspended') , 'default', null, 'success');
						break;

					case ConstMoreAction::Unflagged:
						if ($this->modelClass == 'Message' || $this->modelClass == 'MessageContent') {
							foreach($ids as $id) {
								if (!empty($id)) {
									$messageUserId = $this->Message->find('first', array(
										'conditions' => array(
											'Message.id' => $id
										) ,
										'recursive' => -1
									));
									$saveMessage['id'] = $messageUserId['Message']['message_content_id'];
									if (Configure::read('messages.is_send_email_on_new_message')) {
										$this->_reSendMail($messageUserId['Message']['message_content_id']); // RESEND CLEARED MESSAGES //

									}
									$saveMessage['is_system_flagged'] = 0;
									$this->Message->MessageContent->save($saveMessage);
								}
							}
						} else {
							$this->{$this->modelClass}->updateAll(array(
								$this->modelClass . '.is_system_flagged' => 0
							) , array(
								$this->modelClass . '.id' => $ids
							));
						}
						$this->Session->setFlash(__l('Checked records has been changed to Unflagged') , 'default', null, 'success');
						break;

					case ConstMoreAction::Flagged:
						if ($this->modelClass == 'Message' || $this->modelClass == 'MessageContent') {
							foreach($ids as $id) {
								if (!empty($id)) {
									$messageUserId = $this->{$this->modelClass}->Message->find('first', array(
										'conditions' => array(
											'Message.id' => $id
										) ,
										'recursive' => -1
									));
									$saveMessage['id'] = $messageUserId['Message']['message_content_id'];
									$saveMessage['is_system_flagged'] = 1;
									$this->{$this->modelClass}->Message->MessageContent->save($saveMessage);
								}
							}
						} else {
							$this->{$this->modelClass}->updateAll(array(
								$this->modelClass . '.is_system_flagged' => 1
							) , array(
								$this->modelClass . '.id' => $ids
							));
						}
						$this->Session->setFlash(__l('Checked records has been changed to flagged') , 'default', null, 'success');
						break;

					case ConstMoreAction::Delete:
						foreach($ids as $id) {
							$this->{$this->modelClass}->delete($id);
						}
						$this->Session->setFlash(__l('Checked records has been deleted') , 'default', null, 'success');
						break;
					}
			}
		}
		$this->redirect(Router::url('/', true) . $r);
	}
	function setMaxmindInfo($type = 'geo')
	{
		if (!empty($_COOKIE['_geo'])) {
			$_geo = explode('|', $_COOKIE['_geo']);
			if ($type == 'login') {
				App::import('Model', 'UserProfile');
				$this->UserProfile = new UserProfile();
				$this->UserProfile->updateAll(array(
					'UserProfile.latitude' => $_geo[3],
					'UserProfile.longitude' => $_geo[4],
					'UserProfile.last_access' => "'" . date("Y-m-d H:i:s") . "'"
				) , array(
					'UserProfile.user_id' => $this->Auth->user('id')
				));
			}
		}
		if (Configure::read('deal.find_near_deal_by') == 'location') {
			$data_max['maxmaind_latitude'] = '';
			$data_max['maxmaind_longitude'] = '';
			if (!empty($_COOKIE['_geo'])) {
				$_geo = explode('|', $_COOKIE['_geo']);
				$data_max['maxmaind_latitude'] = $_geo[3];
				$data_max['maxmaind_longitude'] = $_geo[4];
			}
			return $data_max;
		} else {
			$this->loadModel('City');
			$city = $this->City->find('first', array(
				'conditions' => array(
					'City.slug' => $this->request->params['named']['city']
				) ,
				'fields' => array(
					'City.latitude',
					'City.longitude'
				) ,
				'recursive' => -1
			));
			$data_max['maxmaind_latitude'] = $city['City']['latitude'];
			$data_max['maxmaind_longitude'] = $city['City']['longitude'];
			return $data_max;
		}
	}
}
?>