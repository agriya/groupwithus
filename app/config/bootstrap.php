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
/**
 *
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php is loaded
 * This is an application wide file to load any function that is not used within a class define.
 * You can also use this to include or require any files in your application.
 *
 */
/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * $modelPaths = array('full path to models', 'second full path to models', 'etc...');
 * $viewPaths = array('this path to views', 'second full path to views', 'etc...');
 * $controllerPaths = array('this path to controllers', 'second full path to controllers', 'etc...');
 *
 */
App::import('Core', 'config/PhpReader');
Configure::config('default', new PhpReader());
Configure::load('config');
define('DEFAULT_LANGUAGE', 'en');
$user_preferred_city = '';
// Chekcing whether user ahev alreday visited our site
$user_preferred_city = (!empty($_COOKIE['CakeCookie']['city_slug'])) ? $_COOKIE['CakeCookie']['city_slug'] : Cache::read('site.default_city', 'long');
// For Subdoamin concept
if (Cache::read('site.city_url', 'long') == 'subdomain') {
    $tmp_city = substr(env('HTTP_HOST') , 0, strpos(env('HTTP_HOST') , '.'));
    if (!isset($_GET['url'])) {
        $_GET['url'] = 'items/index';
    }
    if (strlen($tmp_city) > 0) {
        $site_domain = substr(env('HTTP_HOST') , strpos(env('HTTP_HOST') , '.'));
        ini_set('session.cookie_domain', $site_domain);
        if ($tmp_city == 'www' or $tmp_city == 'm' or $tmp_city == Configure::read('site.domain')) {
            $_GET['url'].= !empty($user_preferred_city) ? '/city:' . $user_preferred_city : '';
        } else {
            $_GET['url'].= '/city:' . $tmp_city;

        }
    } else {
        $_GET['url'].= !empty($user_preferred_city) ? '/city:' . $user_preferred_city : '';
    }
}
if (Cache::read('site.city_url', 'long') == 'prefix') {
	$GLOBALS['_city']['icm'] = 0;
    if (!isset($_GET['url'])) {
		if (!empty($user_preferred_city)) {
			$_GET['url'] = $user_preferred_city;
			$GLOBALS['_city']['icm'] = 1;
		}
    } else {
        $controllers = Cache::read('controllers_list', 'default');
        $controller_arr = explode('|', $controllers);
        // hardcoded for view pages
        array_push($controller_arr, 'interests', 'myinterests', 'past-items', 'merchant', 'cron', 'item', 'page', 'user', 'admin', 'item_user', 'contactus', 'sitemap', 'robots', 'sitemap.xml', 'yadis.xml', 'robots.txt');
        $url_arr = explode('/', $_GET['url']);
		$check_welcome_page = preg_match('/welcome_to_/', $_GET['url']);
        if (in_array($url_arr[0], $controller_arr) && empty($check_welcome_page)) {
            // quick fix. need to discuss.
            if (preg_match('/city:([^\/]*)(\/)*/', $_GET['url'], $matches)) {
                $current_tmp_city = $matches[1];
            }
            $tmp_url = $_GET['url'];
            unset($_GET['url']);
            if (!empty($current_tmp_city)) {
                $_GET['url'] = $current_tmp_city . '/' . $tmp_url;
            } else if (!empty($user_preferred_city)) {
                $_GET['url'] = $user_preferred_city . '/' . $tmp_url;
				$GLOBALS['_city']['icm'] = 1;
            }
        }
    }
}
require 'constants.php';
//EOF
?>