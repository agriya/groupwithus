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
class CurrencyConversion extends AppModel
{
    public $name = 'CurrencyConversion';
    public $displayField = 'name';
    //$validate set in __construct for multi-language support
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'currency_id' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'converted_currency_id' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'rate' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
    }
    function cacheConversionCurrency($is_supported = null, $currency_id = null, $converted_currency_id = null)
    {
        $conditions = array();
        if (isset($currency_id) && isset($converted_currency_id)) {
            $conditions['CurrencyConversion.currency_id'] = $currency_id;
            $conditions['CurrencyConversion.converted_currency_id'] = $converted_currency_id;
        }
        $conversion_currencies = $this->find('first', array(
            'conditions' => $conditions,
            'recursive' => 1
        ));
        Cache::write('site_paypal_conversion_currency', $conversion_currencies);
        Cache::write('site_paypal_conversion_currency_rate', $conversion_currencies['CurrencyConversion']['rate']);
        return $conversion_currencies;
    }
}
?>