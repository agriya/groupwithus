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

class AppModel extends Model
{
    public $actsAs = array(
        'Containable',
        'Affiliate',
        'Timezone',
    );
    function beforeSave($options = array())
    {
        $this->useDbConfig = 'master';
        return true;
    }
    function afterSave($created)
    {
        $this->useDbConfig = 'default';
        return true;
    }
    function beforeDelete($cascade = true)
    {
        $this->useDbConfig = 'master';
        return true;
    }
    function afterDelete()
    {
        $this->useDbConfig = 'default';
        return true;
    }
    function getIdHash($ids = null)
    {
        return md5($ids . Configure::read('Security.salt'));
    }
    function isValidIdHash($ids = null, $hash = null)
    {
        return (md5($ids . Configure::read('Security.salt')) == $hash);
    }
    function findOrSaveAndGetId($data)
    {
        $findExist = $this->find('first', array(
            'conditions' => array(
                'name' => $data
            ) ,
            'fields' => array(
                'id'
            ) ,
            'recursive' => -1
        ));
        if (!empty($findExist)) {
            return $findExist[$this->name]['id'];
        } else {
            $this->data[$this->name]['name'] = $data;
            $this->save($this->data[$this->name]);
            return $this->getLastInsertId();;
        }
    }
    function getImageUrl($model, $attachment, $options, $path = 'absolute')
    {
        $default_options = array(
            'dimension' => 'original',
            'class' => '',
            'alt' => 'alt',
            'title' => 'title',
            'type' => 'jpg'
        );
        $options = array_merge($default_options, $options);
        $image_hash = $options['dimension'] . '/' . $model . '/' . $attachment['id'] . '.' . md5(Configure::read('Security.salt') . $model . $attachment['id'] . $options['type'] . $options['dimension'] . Configure::read('site.name')) . '.' . $options['type'];
        if ($path == 'absolute') return Cache::read('site_url_for_shell', 'long') . 'img/' . $image_hash;
        else return 'img/' . $image_hash;
    }
    function _isValidCaptcha()
    {
        include_once VENDORS . DS . 'securimage' . DS . 'securimage.php';
        $img = new Securimage();
        return $img->check($this->data[$this->name]['captcha']);
    }
    function changeFromEmail($from_address = null)
    {
        if (!empty($from_address)) {
            if (preg_match('|<(.*)>|', $from_address, $matches)) {
                return $matches[1];
            } else {
                return $from_address;
            }
        }
    }
    function get_languages()
    {
        App::import('Model', 'Translation');
        $this->Translation = new Translation();
        $languages = $this->Translation->find('all', array(
            'conditions' => array(
                'Language.id !=' => 0,
                'Language.iso2 != ' => ''
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
        $languageList = array();
        if (!empty($languages)) {
            foreach($languages as $language) {
                $languageList[$language['Language']['iso2']] = $language['Language']['name'];
            }
        }
        return $languageList;
    }
    function formatToAddress($user = null)
    {
		if(is_array($user))
		{
			if (!empty($user['UserProfile']['first_name']) && !empty($user['UserProfile']['last_name'])) {
				return $user['UserProfile']['first_name'] . ' ' . $user['UserProfile']['first_name'] . ' <' . $user['User']['email'] . '>';
			} elseif (!empty($user['UserProfile']['first_name'])) {
				return $user['UserProfile']['first_name'] . ' <' . $user['User']['email'] . '>';
			} else {
				return $user['User']['email'];
			}
		}
		else
		{
			return $user;
		}
    }
    public function formGooglemap($merchantdetails = array() , $size = '320x320')
    {
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
        if (!empty($merchantdetails['latitude'])) {
            $mapcenter[] = str_replace(' ', '+', $merchantdetails['latitude']) . ',' . $merchantdetails['longitude'];
            $mapcenter[] = 'markers=color:pink|label:M|' . $merchantdetails['latitude'] . ',' . $merchantdetails['longitude'];
        }
        $mapcenter[] = 'zoom=' . (!empty($merchantdetails['map_zoom_level']) ? $merchantdetails['map_zoom_level'] : Configure::read('GoogleMap.static_map_zoom_level'));
        $mapcenter[] = 'size=' . $size;
        $mapcenter[] = 'sensor=false';
        return $mapurl . implode('&amp;', $mapcenter);
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
        return $city;
    }
    function getGatewayTypes($field = null)
    {
        App::import('Model', 'PaymentGateway');
        $this->PaymentGateway = new PaymentGateway();
        $payment_gateway_types = array();
        $is_wallet_enabled = 0;
        $is_master_wallet_enabled = 0;
        $paymentGateways = $this->PaymentGateway->find('all', array(
            'conditions' => array(
                'PaymentGateway.is_active' => 1
            ) ,
            'contain' => array(
                'PaymentGatewaySetting' => array(
                    'conditions' => array(
                        'PaymentGatewaySetting.key' => array(
                            $field,
                            'is_enable_wallet'
                        ) ,
                        'PaymentGatewaySetting.test_mode_value' => 1
                    ) ,
                ) ,
            ) ,
            'order' => array(
                'PaymentGateway.display_name' => 'asc'
            ) ,
            'recursive' => 1
        ));
        foreach($paymentGateways as $paymentGateway) {
            if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                if ($paymentGateway['PaymentGateway']['id'] == ConstPaymentGateways::Wallet) {
                    foreach($paymentGateway['PaymentGatewaySetting'] as $PaymentGatewaySetting) {
                        if ($PaymentGatewaySetting['key'] == 'is_enable_wallet') {
                            $is_master_wallet_enabled = 1;
                        }
                        if ($PaymentGatewaySetting['key'] == $field) {
                            $is_wallet_enabled = 1;
                        }
                    }
                    if (!empty($is_master_wallet_enabled) && !empty($is_wallet_enabled)) {
                        $payment_gateway_types[$paymentGateway['PaymentGateway']['id']] = $paymentGateway['PaymentGateway']['display_name'];
                    }
                } else {
                    $payment_gateway_types[$paymentGateway['PaymentGateway']['id']] = $paymentGateway['PaymentGateway']['display_name'];
                }
            }
        }
        return $payment_gateway_types;
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
    function getUserLanguageIso($user_id)
    {
        App::import('Model', 'UserProfile');
        $this->UserProfile = new UserProfile();
        $user = $this->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $user_id
            ) ,
            'contain' => array(
                'Language'
            ) ,
            'recursive' => 3
        ));
        return !empty($user['Language']['iso2']) ? $user['Language']['iso2'] : '';
    }
    function _convertAmount($amount)
	{
		$converted = array();
		$_paypal_conversion_currency = Cache::read('site_paypal_conversion_currency');
		$is_supported = Configure::read('paypal.is_supported');
		if (isset($is_supported) && empty($is_supported)) {
			$converted['amount'] = $amount * $_paypal_conversion_currency['CurrencyConversion']['rate'];
			$converted['currency_code'] = Configure::read('paypal.conversion_currency_code');
		} else {
			$converted['amount'] = $amount;
			$converted['currency_code'] = Configure::read('paypal.currency_code');		
		}
		return $converted;
	}
	function getConversionCurrency()
	{
		if (Configure::read('paypal.is_supported') == 0) {
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
	function _convertAuthorizeAmount($amount, $rate = 0)
	{
		$_currencies = Cache::read('site_currencies');
		$converted = array();
		$_authorizenet_conversion_currency = Cache::read('site_authorizenet_conversion_currency');
		if (($_currencies[Configure::read('site.currency_id')]['Currency']['id'] != ConstCurrencies::USD) || (!empty($rate))) {
			$rate = !empty($rate)? $rate : $_authorizenet_conversion_currency['CurrencyConversion']['rate'];
			$converted['amount'] = round($amount * $rate,2);			
		} else {
			$converted['amount'] = $amount;
		}
		return $converted['amount'];
	}
	public function toSaveIp()
    {
		App::import('Model', 'Ip');
		$this->Ip = new Ip();
		$this->data['Ip']['ip'] = RequestHandlerComponent::getClientIP();
		$this->data['Ip']['host'] = RequestHandlerComponent::getReferer();
        $ip = $this->Ip->find('first', array(
            'conditions' => array(
                'Ip.ip' => $this->data['Ip']['ip']
            ) ,
            'fields' => array(
                'Ip.id'
            ) ,
            'recursive' => -1
        ));
		if (empty($ip)) {
			if (!empty($_COOKIE['_geo'])) {
				$_geo = explode('|', $_COOKIE['_geo']);
				$country = $this->Ip->Country->find('first', array(
					'conditions' => array(
						'Country.iso2' => $_geo[0]
					) ,
					'fields' => array(
						'Country.id'
					) ,
					'recursive' => -1
				));
				if (empty($country)) {
					$this->data['Ip']['country_id'] = 0;
				} else {
					$this->data['Ip']['country_id'] = $country['Country']['id'];
				}
				$state = $this->Ip->State->find('first', array(
					'conditions' => array(
						'State.name' => $_geo[1]
					) ,
					'fields' => array(
						'State.id'
					) ,
					'recursive' => -1
				));
				if (empty($state)) {
					$this->data['State']['name'] = $_geo[1];
					$this->Ip->State->create();
					$this->Ip->State->save($this->data['State']);
					$this->data['Ip']['state_id'] = $this->Ip->State->getLastInsertId();
				} else {
					$this->data['Ip']['state_id'] = $state['State']['id'];
				}
				$city = $this->Ip->City->find('first', array(
					'conditions' => array(
						'City.name' => $_geo[2]
					) ,
					'fields' => array(
						'City.id'
					) ,
					'recursive' => -1
				));
				if (empty($city)) {
					$this->data['City']['name'] = $_geo[2];
					$this->Ip->City->create();
					$this->Ip->City->save($this->data['City']);
					$this->data['Ip']['city_id'] = $this->Ip->City->getLastInsertId();
				} else {
					$this->data['Ip']['city_id'] = $city['City']['id'];
				}
				$this->data['Ip']['latitude'] = $_geo[3];
				$this->data['Ip']['longitude'] = $_geo[4];
			}
			$this->Ip->create();			
			$this->Ip->save($this->data['Ip']);
			return $this->Ip->getLastInsertId();
		} else {
	        return $ip['Ip']['id'];
		}
	}
}
?>