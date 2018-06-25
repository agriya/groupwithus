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

// site actions that needs random attack protection...
if (!defined('DEBUG')) {
    define('DEBUG', 0);
    // permanent cache re1ated settings
    define('PERMANENT_CACHE_CHECK', (!empty($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] != '127.0.0.1') ? true : false);
    // site default language
    define('PERMANENT_CACHE_DEFAULT_LANGUAGE', 'en');
    // cookie variable name for site language
    define('PERMANENT_CACHE_COOKIE', '');
    // salt used in setcookie
    define('PERMANENT_CACHE_GZIP_SALT', 'e9a556134534545ab47c6c81c14f06c0b8sdfsdf');
    // sub admin is available in site or not
    define('PERMANENT_CACHE_HAVE_SUB_ADMIN', false);
    // Enable support for HTML5 History/State API
    // By enabling this, users will not see full page load
    define('IS_ENABLE_HTML5_HISTORY_API', false);
    // Force hashbang based URL for all browsers
    // When this is disabled, browsers that don't support History API (IE, etc) alone will use hashbang based URL. When enabled, all browsers--including links in Google search results will use hashbang based URL (similar to new Twitter).
    define('IS_ENABLE_HASHBANG_URL', false);
    $_is_hashbang_supported_bot = (!empty($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Googlebot') !== false);
    define('IS_HASHBANG_SUPPORTED_BOT', $_is_hashbang_supported_bot);
}
$config['debug'] = DEBUG;
$config['site']['_hashSecuredActions'] = array(
    'edit',
    'delete',
    'update',
    'unsubscribe',
    'barcode',
    'update_status',
    'resend',
    'my_account',
    'confirmation'
);
$config['site']['domain'] = 'groupwithus';
$config['photo']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
		'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
	'allowEmpty' => true
);
$config['image']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => false
);
$config['avatar']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => true
);
$config['pagelogo']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => true
);
$config['widget_no_scroll'] = array(1, 2, 3, 4);
$config['site']['search_distance'] = 30000;
$config['cdn']['images'] = null; // 'http://images.localhost/';
$config['cdn']['css'] = null; // 'http://static.localhost/';
$config['sitemap']['models'] = array(
    'Item' => array(
        'conditions' => array(
            'item_status_id' => array(
				2,
				5
			) ,
        ) ,
		'contain' => array(
			'CitiesItem' => array(
				'City' => array(
					'fields' => array(
						'City.id',
						'City.name',
						'City.slug',
					)
				)
			)
		) ,
		'fields' => array(
			'slug',
			'id',
		)
    )
);
$config['site']['exception_array'] = array(
	'cities/check_city',
	'countries/index',
	'countries/change_country',
	'pages/view',
	'pages/display',
	'pages/home',
	'items/index',
	'items/view',
	'users/processpayment',
	'subscriptions/add',
	'subscriptions/confirmation',
	'cities/index',
	'merchants/view',
	'contacts/show_captcha',
	'users/register',
	'users/merchant_register',
	'users/login',
	'users/logout',
	'users/reset',
	'users/forgot_password',
	'users/openid',
	'users/activation',
	'users/resend_activation',
	'users/view',
	'users/show_captcha',
	'users/oauth_callback',
	'users/fs_oauth_callback',
	'users/captcha_play',
	'users/oauth_facebook',
	'user_interests/index',
	'user_interests/view',
	'user_interest_comments/index',
	'images/view',
	'devs/robots',
	'contacts/add',
	'contacts/show_captcha',
	'contacts/captcha_play',
	'images/view',
	'cities/autocomplete',
	'states/autocomplete',
	'colleges/autocomplete',
	'companies/autocomplete',
	'users/admin_login',
	'users/admin_logout',
	'languages/change_language',
	'subscriptions/add',
	'subscriptions/index',
	'subscriptions/unsubscribe',
	'users/referred_users',
	'users/resend_activemail',
	'subscriptions/home',
	'subscriptions/unsubscribe_mailchimp',
	'subscriptions/city_suggestions',
	'subscriptions/skip',
	'pages/refer_a_friends',
	'users/refer',
	'mass_pay_paypals/process_masspay_ipn',
	'items/barcode',
	'city_suggestions/add',
	'cities/twitter_facebook',
	'topics/index',
	'topic_discussions/index',
	'user_comments/index',
	'items/buy',
	'items/process_user',
	'items/processpayment',
	'items/_buyItem',
	'items/payment_success',
	'items/payment_cancel',
	'merchants/view',
	'page/learn',
	'items/merchant_items',
	'devs/sitemap',
	'devs/robotos',
	'devs/asset_css',
	'devs/asset_js',
	'business_suggestions/add',
	'crons/main',
	'crons/currency_conversion',
	'users/validate_user',
	'affiliates/widget',
	'items/widget',
	'items/purchased_user',
	'item_users/index',
	'item_comments/index',
	'item_categories/index',
	'users/index',
	'cities/change_city',
);
$config['site']['is_admin_settings_enabled'] = true;
if ($_SERVER['HTTP_HOST'] == 'groupwithus.dev.agriya.com' && !in_array($_SERVER['REMOTE_ADDR'], array('118.102.143.2', '119.82.115.146', '122.183.135.202', '122.183.136.34','122.183.136.36'))) {
	$config['site']['is_admin_settings_enabled'] = false;
	$config['site']['admin_demomode_updation_not_allowed_array'] = array(
		'cities/admin_delete',
		'cities/admin_update',
		'cities/admin_edit',
		'cities/admin_update_status',
		'countries/admin_update',
		'countries/admin_delete',
		'countries/admin_edit',
		'countries/admin_update_status',
		'states/admin_update',
		'states/admin_delete',
		'states/admin_edit',
		'states/admin_update_status',
		'pages/admin_edit',
		'pages/admin_delete',
		'subscriptions/admin_subscription_customise',
	);
}
$config['action']['cache_duration'] = 86400;
$config['barcode']['symbology'] = 'qr';
?>