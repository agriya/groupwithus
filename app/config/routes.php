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
 
Router::parseExtensions('rss', 'csv', 'json', 'txt', 'pdf', 'kml', 'xml', 'mobile', 'js');
// REST support controllers
Router::mapResources(array(
    'items'
));
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
$site_name = Cache::read('site.name', 'long') ;
Router::connect('/img/:size/*', array(
	'controller' => 'images',
	'action' => 'view'
) , array(
	'size' => '(?:[a-zA-Z_]*)*'
));
Router::connect('/files/*', array(
	'controller' => 'images',
	'action' => 'view',
	'size' => 'original'
));
Router::connect('/img/*', array(
	'controller' => 'images',
	'action' => 'view',
	'size' => 'original'
));
Router::connect('/pages/*', array(
	'controller' => 'pages',
	'action' => 'display'
));
Router::connect('/css/*', array(
	'controller' => 'devs',
	'action' => 'asset_css'
));
Router::connect('/js/*', array(
	'controller' => 'devs',
	'action' => 'asset_js'
));
Router::connect('/welcome_to_'.$site_name, array(
	'controller' => 'items',
	'action' => 'index',
	'type' => 'geocity'
));
Router::connect('/interest/*', array(
		'controller' => 'user_interests',
		'action' => 'view',
    ));
if (Cache::read('site.city_url', 'long') == 'prefix') {
    $controllers = Cache::read('controllers_list', 'default');
    if ($controllers === false) {
        $controllers = App::objects('controller');
        foreach($controllers as &$value) {
            $value = Inflector::underscore($value);
        }
        array_push($controllers, 'interests', 'myinterests', 'past-items', 'merchant', 'cron', 'item', 'page', 'user', 'admin', 'item_user', 'contactus', 'sitemap', 'robots', 'sitemap.xml', 'yadis.xml', 'robots.txt','welcome_to_'.$site_name);
        $controllers = implode('|', $controllers);
        Cache::write('controllers_list', $controllers);
    }
	Router::connect('/:city', array(
		'controller' => 'items',
		'action' => 'index'
	) , array(
		'city' => '(?!' . $controllers . ')[^\/]*'
	));
    Router::connect('/:city/users/facebook/login', array(
		'controller' => 'users',
		'action' => 'login',
		'type' => 'facebook'
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/users/twitter/login', array(
        'controller' => 'users',
        'action' => 'login',
        'type' => 'twitter'
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/users/yahoo/login', array(
		'controller' => 'users',
		'action' => 'login',
		'type' => 'yahoo'
	), array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/users/gmail/login', array(
		'controller' => 'users',
		'action' => 'login',
		'type' => 'gmail'
	), array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/users/openid/login', array(
		'controller' => 'users',
		'action' => 'login',
		'type' => 'openid'
	), array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
	Router::connect('/:city/users/foursquare/login', array(
		'controller' => 'users',
		'action' => 'login',
		'type' => 'foursquare'
	), array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/interests', array(
		'controller' => 'user_interests',
		'action' => 'index',
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/interest/*', array(
		'controller' => 'user_interests',
		'action' => 'view',
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
	Router::connect('/:city/myinterests', array(
		'controller' => 'user_interests',
		'action' => 'index',
		'type' => 'myinterest',
	) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/merchant/facebook/login', array(
		'controller' => 'users',
		'action' => 'login',
		'type' => 'facebook',
		'user_type' => 'merchant'
	) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/merchant/twitter/login', array(
        'controller' => 'users',
        'action' => 'login',
        'type' => 'twitter',
        'user_type' => 'merchant'
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/merchant/yahoo/login', array(
		'controller' => 'users',
		'action' => 'login',
		'type' => 'yahoo',
		'user_type' => 'merchant'
	), array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/merchant/gmail/login', array(
		'controller' => 'users',
		'action' => 'login',
		'type' => 'gmail',
		'user_type' => 'merchant'
	), array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/merchant/openid/login', array(
		'controller' => 'users',
		'action' => 'login',
		'type' => 'openid',
		'user_type' => 'merchant'
	), array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
	Router::connect('/:city/merchant/foursquare/login', array(
		'controller' => 'users',
		'action' => 'login',
		'type' => 'foursquare',
		'user_type' => 'merchant'
	), array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
	Router::connect('/:city/past-items/*', array(
		'controller' => 'items',
		'action' => 'index',
		'type'=> 'past'
	) , array(
		'city' => '(?!' . $controllers . ')[^\/]*'
	));

    Router::connect('/:city/pages/*', array(
        'controller' => 'pages',
        'action' => 'display'
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
	Router::connect('/:city/admin/pages/tools', array(
		'controller' => 'pages',
		'action' => 'display',
		'tools',
		'admin' => true
	) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/merchant/user/register/*', array(
        'controller' => 'users',
        'action' => 'merchant_register'
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/contactus', array(
        'controller' => 'contacts',
        'action' => 'add'
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
	Router::connect('/:city/cron/main', array(
        'controller' => 'crons',
        'action' => 'main'
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/items/recent', array(
        'controller' => 'items',
        'action' => 'index',
        'type' => 'recent'
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
	Router::connect('/:city/items/near', array(
        'controller' => 'items',
        'action' => 'index',
        'type' => 'near'
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
	Router::connect('/:city/items/main', array(
        'controller' => 'items',
        'action' => 'index',
        'type' => 'main'
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
	Router::connect('/:city/items/side', array(
        'controller' => 'items',
        'action' => 'index',
        'type' => 'side'
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/items/merchant/:merchant', array(
        'controller' => 'items',
        'action' => 'index',
    ) , array(
        'merchant' => '[^\/]*',
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/items/category/:category', array(
        'controller' => 'items',
        'action' => 'index',
    ) , array(
        'category' => '[^\/]*',
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
	Router::connect('/:city/items/merchant/:merchant/:type', array(
        'controller' => 'items',
        'action' => 'index',
    ) , array(
        'merchant' => '[^\/]*',
		'type' => '[^\/]*',
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/subscribe', array(
        'controller' => 'subscriptions',
        'action' => 'add',
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/admin' , array(
        'controller' => 'users',
        'action' => 'stats',
        'prefix' => 'admin',
        'admin' => true
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/robots', array(
        'controller' => 'devs',
        'action' => 'robots',
        'ext' => 'txt'
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/sitemap', array(
        'controller' => 'devs',
        'action' => 'sitemap',
        'ext' => 'xml'
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
	Router::connect('/:city/yadis', array(
        'controller' => 'devs',
        'action' => 'yadis',
        'ext' => 'xml'
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/admin/:controller/:action/*', array(
        'admin' => true
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/admin/:controller/:action/*', array(
        'admin' => true
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/admin/:controller/*', array(
		'action' => 'index',
        'admin' => true
    ) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/:controller/:action/*', array() , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
    Router::connect('/:city/:controller/*', array(
		'action' => 'index'
	) , array(
        'city' => '(?!' . $controllers . ')[^\/]*'
    ));
}
if (Cache::read('site.city_url', 'long') == 'subdomain') {
    Router::connect('/city::city', array(
        'controller' => 'items',
        'action' => 'index'
    ) , array(
        'city' => '[^\/]*'
    ));
    Router::connect('/contactus/city::city', array(
        'controller' => 'contacts',
        'action' => 'add'
    ) , array(
        'city' => '[^\/]*'
    ));
    Router::connect('/merchant/user/register/city::city/*', array(
        'controller' => 'users',
        'action' => 'merchant_register'
    ) , array(
        'city' => '[^\/]*'
    ));
    Router::connect('/admin/city::city', array(
        'controller' => 'users',
        'action' => 'stats',
        'prefix' => 'admin' ,
        'admin' => 1
    ) , array(
        'city' => '[^\/]*'
    ));
    Router::connect('/robots', array(
        'controller' => 'devs',
        'action' => 'robots',
        'ext' => 'txt'
    ) , array(
        'city' => '[^\/]*'
    ));
    Router::connect('/items/recent/city::city', array(
        'controller' => 'items',
        'action' => 'index',
        'type' => 'recent'
    ) , array(
        'city' => '[^\/]*'
    ));
    Router::connect('/items/merchant/:merchant/city::city', array(
        'controller' => 'items',
        'action' => 'index',
    ) , array(
        'merchant' => '[^\/]*',
        'city' => '[^\/]*'
    ));
    Router::connect('/subscribe/city::city', array(
        'controller' => 'subscriptions',
        'action' => 'add',
    ) , array(
        'city' => '[^\/]*'
    ));
    Router::connect('/users/twitter/login/city::city', array(
        'controller' => 'users',
        'action' => 'login',
        'type' => 'twitter'
    ) , array(
        'city' => '[^\/]*'
    ));
    Router::connect('/sitemap/city::city', array(
        'controller' => 'devs',
        'action' => 'sitemap'
    ) , array(
        'city' => '[^\/]*'
    ));
}
?>