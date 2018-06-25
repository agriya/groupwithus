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
App::import('Core', 'Helper');
/**
 * This is a placeholder class.
 * Create the same file in app/app_helper.php
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake
 */
class AppHelper extends Helper
{
    function getUserAvatar($user_id)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
            ) ,
            'fields' => array(
                'UserAvatar.id',
                'UserAvatar.dir',
                'UserAvatar.filename'
            ) ,
            'recursive' => 0
        ));
        return $user['UserAvatar'];
    }
    function cDateTime1($str, $date)
    {
        $title = ' title="' . strftime(Configure::read('site.datetime.tooltip') , strtotime($str)) . '"';
        $str = '<span' . ' class="posted-date round-5"' . $title . '>' . $date . '</span>';
        return $str;
    }
	function cDateTimeHighlight($str, $wrap = 'span', $title = false)
    {
        if (strtotime(_formatDate('Y-m-d', strtotime($str))) == strtotime(date('Y-m-d'))) {
            $str = strftime('%I:%M %p', strtotime($str . ' GMT'));
        } else if (strtotime(date('Y-m-d', strtotime(_formatDate('Y-m-d', strtotime($str))))) > strtotime(date('Y-m-d')) || mktime(0, 0, 0, 0, 0, date('Y', strtotime(_formatDate('Y-m-d', strtotime($str))))) < mktime(0, 0, 0, 0, 0, date('Y'))) {
            $str = strftime('%b %d, %Y', strtotime($str . ' GMT'));
        } else {
            $str = strftime('%b %d', strtotime($str . ' GMT'));
        }
        $changed = (($r = $this->htmlPurifier->purify($str)) != $str);
        if ($wrap) {
            if (!$title) {
                $title = ' title="' . strftime(Configure::read('site.datetime.tooltip') , strtotime($str . ' GMT')) . ' ' . Configure::read('site.timezone_offset') . '"';
            }
            $r = '<' . $wrap . ' class="c' . $changed . '"' . $title . '>' . $r . '</' . $wrap . '>';
        }
        return $r;
    }
    function getLanguage()
    {
        $languages = Cache::read('site_languages');
        if (empty($languages)) {
            App::import('Model', 'Translation');
            $this->Translation = new Translation();
            $languages = $this->Translation->find('all', array(
                'conditions' => array(
                    'Language.id !=' => 0,
                    'Language.is_active' => 1
                ) ,
                'fields' => array(
                    'DISTINCT(Translation.language_id)',
                    'Language.name',
                    'Language.iso2'
                ) ,
                'order' => array(
                    'Language.name' => 'ASC'
                )
            ));
            // we delete cache file in translation and language model in afterSave and afterDelete
            // we delete in languages/admin_update also.
            Cache::write('site_languages', $languages);
        }
        $languageList = array();
        if (!empty($languages)) {
            foreach($languages as $language) {
                $languageList[$language['Language']['iso2']] = $language['Language']['name'];
            }
        }
        return $languageList;
    }
	function ordinal($number) {

    // when fed a number, adds the English ordinal suffix. Works for any
    // number, even negatives

    if ($number % 100 > 10 && $number %100 < 14):
        $suffix = "th";
    else:
        switch($number % 10) {

            case 0:
                $suffix = "th";
                break;

            case 1:
                $suffix = "st";
                break;

            case 2:
                $suffix = "nd";
                break;

            case 3:
                $suffix = "rd";
                break;

            default:
                $suffix = "th";
                break;
        }

    endif;

    return "${number}$suffix";

	}
	function checkOwnItem($restuarant_id,$user_id)
	{
        App::import('Model', 'Merchant');
        $modelObj = new Merchant();
        $user = $modelObj->find('first', array(
            'conditions' => array(
                'Merchant.user_id' => $user_id,
            ) ,
            'fields' => array(
                'Merchant.id',
            ) ,
            'recursive' => -1
        ));
		if($restuarant_id==$user['Merchant']['id'])
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function getCityDetails($slug)
    {
		App::import('Model', 'City');
		$this->City = new City();
		$city = $this->City->find('first', array(
            'conditions' => array(
                'City.slug' => $slug
            ) ,
			'contain' => array(
				'Attachment'
			) ,
            'recursive' => 0
        ));
        return $city;
    }
    function getCity()
    {
        App::import('Model', 'City');
        $this->City = new City();
        $cities = $this->City->find('all', array(
            'conditions' => array(
                'City.is_approved' => 1,
				'City.is_enable' => 1
            ) ,
            'fields' => array(
                'City.id',
                'City.name',
                'City.slug',
                'City.active_item_count'
            ) ,
            'order' => array(
                'City.name' => 'asc'
            ) ,
            'recursive' => -1
        ));
        $cityList = array();
        if (!empty($cities)) {
            foreach($cities as $city) {
                $cityList[$city['City']['id']] = $city['City']['name'];
            }
        }
        return $cityList;
    }
	function getCities()
    {
        App::import('Model', 'City');
        $this->City = new City();
        $cities = $this->City->find('all', array(
            'conditions' => array(
                'City.is_approved' => 1,
				'City.is_enable' => 1
            ) ,
            'fields' => array(
                'City.id',
                'City.name',
                'City.slug',
                'City.active_item_count'
            ) ,
            'order' => array(
                'City.name' => 'asc'
            ) ,
            'recursive' => -1
        ));
        $cityList = array();
        if (!empty($cities)) {
            foreach($cities as $city) {
                $cityList[$city['City']['id']] = $city['City']['name'];
            }
        }
        return $cities;
    }
    function getMerchant($user_id = null)
    {
        App::import('Model', 'Merchant');
        $this->Merchant = new Merchant();
        $merchant = $this->Merchant->find('first', array(
            'conditions' => array(
                'Merchant.user_id' => $user_id,
            ) ,
            'fields' => array(
                'Merchant.id',
                'Merchant.name',
                'Merchant.slug',
                //'Merchant.is_merchant_profile_enabled',
                'Merchant.is_online_account'
            ) ,
            'recursive' => -1
        ));
        return $merchant;
    }
    function isAllowed($user_type = null)
    {
        if ($user_type == ConstUserTypes::Merchant && !Configure::read('user.is_merchant_actas_normal_user')) {
            return false;
        }
        return true;
    }
    function getCityTwitterFacebookURL($slug = null)
    {
        App::import('Model', 'City');
        $this->City = new City();
        $city = $this->City->find('first', array(
            'conditions' => array(
                'City.slug' => $slug
            ) ,
            'fields' => array(
                'City.twitter_url',
                'City.facebook_url'
            ) ,
            'recursive' => -1
        ));
        if (empty($city['City']['facebook_url'])) {
            $city['City']['facebook_url'] = (env('HTTPS')) ? str_replace("http://", "https://", Configure::read('facebook.site_facebook_url')) : Configure::read('facebook.site_facebook_url');
        } else {
            $city['City']['facebook_url'] = (env('HTTPS')) ? str_replace("http://", "https://", $city['City']['facebook_url']) : $city['City']['facebook_url'];
        }
        if (empty($city['City']['twitter_url'])) {
            $city['City']['twitter_url'] = (env('HTTPS')) ? str_replace("http://", "https://", Configure::read('twitter.site_twitter_url')) : Configure::read('twitter.site_twitter_url');
        } else {
            $city['City']['twitter_url'] = (env('HTTPS')) ? str_replace("http://", "https://", $city['City']['twitter_url']) : $city['City']['twitter_url'];
        }
        return $city;
    }
    public function url($url = null, $full = false)
    {
        if (Cache::read('site.city_url', 'long') == 'prefix') {
            return parent::url(router_url_city($url, $this->params['named']) , $full);
        }
        return parent::url($url, $full);
    }
    function total_saved()
    {
        App::import('Model', 'ItemUser');
        $this->ItemUser = new ItemUser();
        $total_bought = $this->ItemUser->find('first', array(
            'fields' => array(
                'SUM(ItemUser.quantity) as total_bought'
            ) ,
            'recursive' => -1
        ));
        $total_array = array(
            'total_bought' => (!empty($total_bought[0]['total_bought'])) ? $total_bought[0]['total_bought'] : 0,
        );
        return $total_array;
    }
    function cCurrency($str, $wrap = 'span', $title = false)
    {
        $_precision = 2;
        $_currencies = Cache::read('site_currencies');
        $changed = (($r = floatval($str)) != $str);
        $rounded = (($rt = round($r, $_precision)) != $r);
        $r = $rt;
        if ($wrap) {
            if (!$title) {
                $title = ucwords(Numbers_Words::toCurrency($r, 'en_US', Configure::read('paypal.currency_code')));
            }
            $r = '<' . $wrap . ' class="c' . $changed . ' cr' . $rounded . '" title="' . $title . '">' . number_format($r, $_precision, $_currencies[Cache::read('site.currency_id') ]['Currency']['dec_point'], $_currencies[Cache::read('site.currency_id') ]['Currency']['thousands_sep']) . '</' . $wrap . '>';
        }
        return $r;
    }
	// Used for PayPal Conversion Purpose //
    function pCurrency($str, $wrap = 'span', $title = false)
    {
        $getCurr = $this->getConversionCurrency();
        $_precision = 2;
        $_currencies = Cache::read('site_currencies');
        $changed = (($r = floatval($str)) != $str);
        $rounded = (($rt = round($r, $_precision)) != $r);
        $r = $rt;
        if ($wrap) {
            if (!$title) {
                $title = ucwords(Numbers_Words::toCurrency($r, 'en_US', $getCurr['conv_currency_code']));
            }
            $r = '<' . $wrap . ' class="c' . $changed . ' cr' . $rounded . '" title="' . $title . '">' . number_format($r, $_precision, $_currencies[$getCurr['CurrencyConversion']['converted_currency_id']]['Currency']['dec_point'], $_currencies[$getCurr['CurrencyConversion']['converted_currency_id']]['Currency']['thousands_sep']) . '</' . $wrap . '>';
        }
        return $r;
    }
    function cInt($str, $wrap = 'span', $title = false)
    {
        $_currencies = Cache::read('site_currencies');
        $changed = (($r = intval($str)) != $str);
        if ($wrap) {
            if (!$title) {
                $title = $this->_num2words($r, 'en_US');
            }
            $r = '<' . $wrap . ' class="c' . $changed . '" title="' . $title . '">' . number_format($r, 0, '', $_currencies[Cache::read('site.currency_id') ]['Currency']['thousands_sep']) . '</' . $wrap . '>';
        }
        return $r;
    }
    function cFloat($str, $wrap = 'span', $title = false)
    {
        $_precision = 2;
        $_currencies = Cache::read('site_currencies');
        $changed = (($r = floatval($str)) != $str);
        $rounded = (($rt = round($r, $_precision)) != $r);
        $r = $rt;
        if ($wrap) {
            if (!$title) {
                $title = $this->_num2words($r, 'en_US', $_precision);
            }
            $r = '<' . $wrap . ' class="c' . $changed . ' cr' . $rounded . '" title="' . $title . '">' . number_format($r, $_precision, $_currencies[Cache::read('site.currency_id') ]['Currency']['dec_point'], $_currencies[Cache::read('site.currency_id') ]['Currency']['thousands_sep']) . '</' . $wrap . '>';
        }
        return $r;
    }
    function cdateday($str)
    {
        $month = strftime('%b', strtotime($str));
        $date = strftime('%d', strtotime($str));
        $day = strftime('%a', strtotime($str));
        $cdateday_format = '<span class="month">' . $month . '</span>' . '<span class="date">' . $date . '</span>' . '<span class="day">' . $day . '</span>';
        return $cdateday_format;
    }
    function cDateFormat($str)
    {
        $month = strftime('%b', strtotime($str));
        $date = strftime('%d', strtotime($str));
        $cdateday_format = '<span class="month">' . $month . '</span>' . '<span class="date">' . $date . '</span>' ;
        return $cdateday_format;
    }
    function cdatemonthtime($str)
    {
        $date = strftime('%d', strtotime($str));
        $month = strftime('%b', strtotime($str));
        $time = strftime('%I:%M%p', strtotime($str));
        $cdatemonthtime_format = " -" . $month . " " . $date . ' @ ' . $time;
        return $cdatemonthtime_format;
    }
    function cmonthdateday($str)
    {
        $month = strftime('%b', strtotime($str));
        $date = strftime('%d', strtotime($str));
        $day = strftime('%a', strtotime($str));
        $cmonthdateday_format = '<span class="month">' . $month . '</span>' . '<span class="date">' . $date . '</span>' . '<span class="day">' . $day . '</span>';
        return $cmonthdateday_format;
    }
    function ctimenew($str)
    {
        $time = strftime('%I:%M%p', strtotime($str . ' GMT'));
        return $time;
    }
    function getUserLink($user_details)
    {
        if ($user_details['user_type_id'] == ConstUserTypes::Admin || $user_details['user_type_id'] == ConstUserTypes::User) {
            return $this->link($this->cText($user_details['username']) , array(
                'controller' => 'users',
                'action' => 'view',
                $user_details['username'],
                'admin' => false
            ) , array(
                'title' => $this->cText($user_details['username'], false) ,
                'escape' => false
            ));
        }
        //for merchant
        if ($user_details['user_type_id'] == ConstUserTypes::Merchant) {
            $merchantDetails = $this->getMerchant($user_details['id']);
            if (!$merchantDetails['Merchant']['is_online_account']) {
                return $this->cText($merchantDetails['Merchant']['name']);
            }
            return $this->link($this->cText($merchantDetails['Merchant']['name'], false) , array(
                'controller' => 'merchants',
                'action' => 'view',
                $merchantDetails['Merchant']['slug'],
                'admin' => false
            ) , array(
                'title' => $this->cText($merchantDetails['Merchant']['name'], false) ,
                'escape' => false
            ));
        }
    }
    function getUserAvatarLink($user_details, $type = 'medium_thumb', $is_link = true)
    {
        App::import('Model', 'Setting');
        $this->Setting = new Setting();
        App::import('Model', 'User');
        $modelObj = new User();
        $user = $modelObj->find('first', array(
            'conditions' => array(
                'User.id' => $user_details['id'],
            ) ,
            'fields' => array(
                'UserAvatar.id',
                'UserAvatar.dir',
                'UserAvatar.filename',
                'UserAvatar.height',
                'UserAvatar.width',
                'User.fb_user_id',
                'User.twitter_avatar_url',
                'User.username',
                'User.profile_image_id',
                'User.id',
            ) ,
            'recursive' => 0
        ));
        $user_image = '';
        // Setting Default Profile Image //
        $width = $this->Setting->find('first', array(
            'conditions' => array(
                'Setting.name' => 'thumb_size.' . $type . '.width'
            ) ,
            'recursive' => -1
        ));
        $height = $this->Setting->find('first', array(
            'conditions' => array(
                'Setting.name' => 'thumb_size.' . $type . '.height'
            ) ,
            'recursive' => -1
        ));
        if (!empty($user['User']['fb_user_id'])) {
            $user_image = $this->getFacebookAvatar($user['User']['fb_user_id'], $height['Setting']['value'], $width['Setting']['value']);
        } elseif (!empty($user['User']['twitter_avatar_url'])) {
            $user_image = $this->image($user['User']['twitter_avatar_url'], array(
                'title' => $this->cText($user['User']['username'], false) ,
                'width' => $width['Setting']['value'],
                'height' => $height['Setting']['value']
            ));
        }
        if (!empty($user['User']['twitter_avatar_url']) and $user['User']['profile_image_id'] == ConstProfileImage::Twitter) {
            $user['User']['twitter_avatar_url'] = str_replace('_normal', '_bigger', $user['User']['twitter_avatar_url']);
            return $this->link($this->image($user['User']['twitter_avatar_url'], array(
                'title' => $this->cText($user['User']['username'], false) ,
                'width' => $width['Setting']['value'],
                'height' => $height['Setting']['value']
            )) , array(
                'controller' => 'users',
                'action' => 'view',
                $user['User']['username'],
                'admin' => false
            ) , array(
                'escape' => false
            ));
        } elseif (!empty($user['User']['fb_user_id']) and $user['User']['profile_image_id'] == ConstProfileImage::Facebook) {
            return $this->link($this->image('http://graph.facebook.com/' . $user['User']['fb_user_id'] . '/picture?type=large', array(
                'title' => $this->cText($user['User']['username'], false) ,
                'width' => $width['Setting']['value'],
                'height' => $height['Setting']['value']
            )) , array(
                'controller' => 'users',
                'action' => 'view',
                $user['User']['username'],
                'admin' => false
            ) , array(
                'escape' => false
            ));
        } elseif ($user['User']['profile_image_id'] == ConstProfileImage::Upload || empty($user_image)) {
            return $this->link($this->showImage('UserAvatar', $user['UserAvatar'], array(
                'dimension' => $type,
                'alt' => sprintf(__l('[Image: %s]') , $this->cText($user['User']['username'], false)) ,
                'title' => $this->cText($user['User']['username'], false)
            ) , null, null, false) , array(
                'controller' => 'users',
                'action' => 'view',
                $user['User']['username'],
                'admin' => false
            ) , array(
                'escape' => false
            ));
        } else {
            return $this->link($this->showImage('UserAvatar', $user['UserAvatar'], array(
                'dimension' => $type,
                'alt' => sprintf(__l('[Image: %s]') , $this->cText($user['User']['username'], false)) ,
                'title' => $this->cText($user['User']['username'], false) ,
            ) , null, null, false) , array(
                'controller' => 'users',
                'action' => 'view',
                $user['User']['username'],
                'admin' => false
            ) , array(
                'escape' => false
            ));
        }
    }
    function getFacebookAvatar($fbuser_id, $height = 35, $width = 35)
    {
        return $this->image("http://graph.facebook.com/{$fbuser_id}/picture", array(
            'height' => $height,
            'width' => $width
        ));
    }
    function transactionDescription($transaction)
    {
        $item_name = $item_slug = $friend_link = $user_link = '';
        if ($transaction['Transaction']['class'] == 'ItemUser') {
            $item_name = (!empty($transaction['ItemUser']['Item']['name'])) ? $transaction['ItemUser']['Item']['name'] : '';
            $item_slug = (!empty($transaction['ItemUser']['Item']['slug'])) ? $transaction['ItemUser']['Item']['slug'] : '';
            if ($transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::ItemGift) {
                $friend_link = $this->cText($transaction['ItemUser']['gift_email'], false);
            }
        } elseif ($transaction['Transaction']['class'] == 'Item') {
            $item_name = (!empty($transaction['Item']['display_field'])) ? $transaction['Item']['display_field'] : '';
            $item_slug = (!empty($transaction['Item']['slug'])) ? $transaction['Item']['slug'] : '';
            if (!empty($transaction['Item']['Merchant'])) {
                $merchant_name = $transaction['Item']['Merchant']['name'];
                $merchant_slug = $transaction['Item']['Merchant']['slug'];
            }
        }
        if ($transaction['Transaction']['class'] == 'SecondUser') {
            if ($transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::AmountRefundedForRejectedWithdrawalRequest || $transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::AdminRejecetedWithdrawalRequest || $transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::UserWithdrawalRequest || $transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::AmountApprovedForUserCashWithdrawalRequest || $transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::FailedWithdrawalRequestRefundToUser || $transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::AdminApprovedWithdrawalRequest || $transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::AcceptCashWithdrawRequest || $transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::DeductedAmountForOfflineMerchant || $transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::FailedWithdrawalRequest) {
                $user_link = $this->getUserLink($transaction['User']);
            } else {
                $user_link = $this->getUserLink($transaction['SecondUser']);
            }
        }
        if ($transaction['Transaction']['class'] == 'User') {
            $user_link = $this->getUserLink($transaction['User']);
        }
        if (!empty($transaction['ItemUser']['payment_gateway_id']) && !empty($transaction['PaymentGateway']['name'])) {
            $payment_gateway_used = $transaction['PaymentGateway']['display_name'];
        }
        $transactionReplace = array(
            '##ITEM_LINK##' => (!empty($item_slug) && !empty($item_name)) ? $this->link($this->cText($item_name) , array(
                'controller' => 'items',
                'action' => 'view',
                $item_slug,
                'admin' => false
            ) , array(
                'escape' => false,
                'title' => $this->cText($item_name, false)
            )) : '',
            '##ITEM_NAME##' => (!empty($item_slug) && !empty($item_name)) ? $this->link($this->cText($item_name) , array(
                'controller' => 'items',
                'action' => 'view',
                $item_slug,
                'admin' => false
            ) , array(
                'escape' => false,
                'title' => __l('View this item')
            )) : '',
            '##MERCHANT_NAME##' => (!empty($merchant_slug) && !empty($merchant_name)) ? $this->link($this->cText($merchant_name) , array(
                'controller' => 'merchant',
                'action' => 'view',
                $merchant_slug,
                'admin' => false
            ) , array(
                'escape' => false,
                'title' => __l('View this merchant')
            )) : '',
            '##AFFILIATE_USER##' => $this->link($transaction['User']['username'], array(
                'controller' => 'users',
                'action' => 'view',
                $transaction['User']['username'],
                'admin' => false
            )) ,
            '##CHARITY_USER##' => $this->link((!empty($transaction['Charity']['name']) ? $transaction['Charity']['name'] : '') , array(
                'controller' => 'charities',
                'action' => 'view',
                (!empty($transaction['Charity']['name']) ? $transaction['Charity']['name'] : '') ,
                'admin' => false
            )) ,
            '##FRIEND_LINK##' => $friend_link,
            '##USER_LINK##' => $user_link,
            '##GATEWAY##' => (!empty($payment_gateway_used) ? __l('using') . ' ' . $payment_gateway_used : '')
        );
        if ((!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') && !empty($transaction['TransactionType']['message_for_admin'])) {
            return strtr($transaction['TransactionType']['message_for_admin'], $transactionReplace);
        } else {
            return strtr($transaction['TransactionType']['message'], $transactionReplace);
        }
    }
    public function formGooglemap($merchantdetails = array() , $size = '320x320')
    {
        $merchantfulldetails = $merchantdetails;
        $merchantdetails = !empty($merchantdetails['Merchant']) ? $merchantdetails['Merchant'] : $merchantdetails;
        if ((Configure::read('GoogleMap.embed_map') == 'Static') || (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'print')) {
            if ((!(is_array($merchantdetails))) || empty($merchantdetails)) {
                return false;
            }
            $color_array = array(
                array(
                    'A',
                    'green'
                ) ,
                array(
                    'B',
                    'orange'
                ) ,
                array(
                    'C',
                    'blue'
                ) ,
                array(
                    'D',
                    'yellow'
                )
            );
            $mapurl = 'http://maps.google.com/maps/api/staticmap?center=';
            if (env('HTTPS')) {
                $mapurl = 'https://maps.googleapis.com/maps/api/staticmap?center=';
            }
            $mapcenter[] = str_replace(' ', '+', $merchantdetails['latitude']) . ',' . $merchantdetails['longitude'];
            $mapcenter[] = 'zoom=' . (!empty($merchantdetails['map_zoom_level']) ? $merchantdetails['map_zoom_level'] : Configure::read('GoogleMap.static_map_zoom_level'));
            $mapcenter[] = 'size=' . $size;
            $mapcenter[] = 'markers=color:pink|label:M|' . $merchantdetails['latitude'] . ',' . $merchantdetails['longitude'];
            $mapcenter[] = 'sensor=false';
            return $mapurl . implode('&amp;', $mapcenter);
        } else {
            $map_size = explode('x', $size);
            $embedmapurl[] = 'http://maps.google.com/maps?f=q&amp;hl=en&amp;geocode=;';
            if (env('HTTPS')) {
                $mapurl = 'https://maps.google.com/maps?f=q&amp;hl=en&amp;geocode=;';
            }
            if ((isset($merchantfulldetails['is_redeem_in_main_address']) && !empty($merchantfulldetails['is_redeem_in_main_address'])) || (!isset($merchantfulldetails['is_redeem_in_main_address']))) {
                $merchant_address = !empty($merchantfulldetails['address1']) ? $merchantfulldetails['address1'] . '+' : '';
                $merchant_address.= !empty($merchantfulldetails['address2']) ? $merchantfulldetails['address2'] . '+' : '';
                $merchant_address.= !empty($merchantfulldetails['City']['name']) ? $merchantfulldetails['City']['name'] . '+' : '';
                $merchant_address.= !empty($merchantfulldetails['State']['name']) ? $merchantfulldetails['State']['name'] . '+' : '';
                $merchant_address.= !empty($merchantfulldetails['Country']['name']) ? $merchantfulldetails['Country']['name'] . '+' : '';
                $merchant_address.= !empty($merchantfulldetails['Merchant']['zip']) ? $merchantfulldetails['Merchant']['zip'] : '';
            } else {
                // Quickfix: showing only first address, since multplie address couldn't be show in iframe based map(for now) //

            }
            $embedmapurl[] = 'z=' . (!empty($merchantdetails['map_zoom_level']) ? $merchantdetails['map_zoom_level'] : Configure::read('GoogleMap.static_map_zoom_level'));
            //$embedmapurl[] = 'markers=color:pink|label:M|' . $merchantdetails['latitude'] . ',' . $merchantdetails['longitude'];
            $embedmapurl[] = 'output=embed';
            //$embedmapurl[] = '&amp;iwloc=near';
            $embedmapurl = implode('&amp;', $embedmapurl);
            $embbedd = "<iframe width='" . $map_size['0'] . "' height='" . $map_size['1'] . "' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='" . $embedmapurl . "'></iframe>";
            return $embbedd;
        }
    }
    function isWalletEnabled($field = null)
    {
        App::import('Model', 'PaymentGatewaySetting');
        $this->PaymentGatewaySetting = new PaymentGatewaySetting();
        $paymentGatewaySetting = $this->PaymentGatewaySetting->find('first', array(
            'conditions' => array(
                'PaymentGatewaySetting.key' => 'is_enable_wallet',
                'PaymentGatewaySetting.payment_gateway_id' => ConstPaymentGateways::Wallet
            ) ,
            'contain' => array(
                'PaymentGateway'
            ) ,
            'recursive' => 1
        ));
        if (!empty($paymentGatewaySetting['PaymentGatewaySetting']['test_mode_value']) && !empty($paymentGatewaySetting['PaymentGateway']['is_active'])) {
            return true;
        }
        return false;
    }
    function isAuthorizeNetEnabled()
    {
        App::import('Model', 'PaymentGateway');
        $this->PaymentGateway = new PaymentGateway();
        $paymentGateway = $this->PaymentGateway->find('first', array(
            'conditions' => array(
                'PaymentGateway.id' => ConstPaymentGateways::AuthorizeNet,
                'PaymentGateway.is_active' => 1
            ) ,
            'recursive' => -1
        ));
        if (!empty($paymentGateway)) {
            return true;
        }
        return false;
    }
    function siteCurrencyFormat($amount, $wrap = 'span')
    {
        // @todo "Currency Conversions"
        if (Configure::read('site.currency_symbol_place') == 'left') {
            return Configure::read('site.currency') . $this->cCurrency($amount, $wrap);
        } else {
            return $this->cCurrency($amount, $wrap) . Configure::read('site.currency');
        }
    }
    function getAffiliateCount($user_id = null)
    {
        App::import('Model', 'Affiliate');
        $this->Affiliate = new Affiliate();
        $affiliate_count = $this->Affiliate->find('count', array(
            'conditions' => array(
                'Affiliate.affliate_user_id' => $user_id
            ) ,
        ));
        return $affiliate_count;
    }
    function getCurrencies()
    {
        $currencies = Cache::read('site_currencies');
        if (empty($currencies)) {
            App::import('Model', 'Currency');
            $this->Currency = new Currency();
            $currencies = $this->Currency->cacheCurrency();
            Cache::write('site_currencies', $currencies);
        }
        $currencyList = array();
        if (!empty($currencies)) {
            $s = 0;
            foreach($currencies as $currency) {
                $currencyList[$s] = $currency['Currency']['code'];
                $s++;
            }
        }
        return $currencyList;
    }
    function getSupportedCurrencies()
    {
        $supported_currencies = Cache::read('site_supported_currencies');
        if (empty($supported_currencies)) {
            App::import('Model', 'Currency');
            $this->Currency = new Currency();
            $supported_currencies = $this->Currency->cacheCurrency(1);
            Cache::write('site_supported_currencies', $supported_currencies);
        }
        $currencyList = array();
        if (!empty($supported_currencies)) {
            $s = 0;
            foreach($supported_currencies as $currency) {
                $currencyList[$s] = $currency['Currency']['code'];
                $s++;
            }
        }
        return $currencyList;
    }
    function getSubscriptionAttachment()
    {
        $attachment = Cache::read('subscription_attachment');
        if (empty($attachment)) {
            App::import('Model', 'Attachment');
            $this->Attachment = new Attachment();
            $attachment = $this->Attachment->find('first', array(
                'conditions' => array(
                    'Attachment.foreign_id' => 2,
                    'Attachment.class' => 'PageLogo'
                ) ,
                'order' => array(
                    'Attachment.id DESC'
                )
            ));
            Cache::write('subscription_attachment', $attachment);
        }
        return $attachment;
    }
    function getConversionCurrency()
    {
        $_paypal_conversion_currency = Cache::read('site_paypal_conversion_currency');
        $_paypal_conversion_currency['supported_currency'] = Configure::read('paypal.is_supported');
        $_paypal_conversion_currency['conv_currency_code'] = Configure::read('paypal.conversion_currency_code');
        $_paypal_conversion_currency['currency_code'] = Configure::read('paypal.currency_code');
        $_paypal_conversion_currency['conv_currency_symbol'] = Configure::read('paypal.conversion_currency_symbol');
        return $_paypal_conversion_currency;
    }
	 function getUserUnReadMessages($user_id = null)
        {
            App::import('Model', 'Message');
            $this->Message = new Message();
            $unread_count = $this->Message->find('count', array(
                'conditions' => array(
                    'Message.is_read' => '0',
                    'Message.user_id' => $user_id,
                    'Message.is_sender' => '0',
                    'Message.message_folder_id' => ConstMessageFolder::Inbox,
                    'MessageContent.is_system_flagged' => 0
                ) ,
                'recursive' => 1
            ));
            return $unread_count;
        }
    function getReferredUsername($user_id)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
            ) ,
            'fields' => array(
                'User.username',
            ) ,
            'recursive' => -1
        ));
        return $user['User']['username'];
    }
}
?>