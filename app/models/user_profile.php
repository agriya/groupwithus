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
class UserProfile extends AppModel
{
    public $name = 'UserProfile';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Gender' => array(
            'className' => 'Gender',
            'foreignKey' => 'gender_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'country_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'state_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Language' => array(
            'className' => 'Language',
            'foreignKey' => 'language_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Language' => array(
            'className' => 'Language',
            'foreignKey' => 'language_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'dob' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
                'rule2' => array(
                    'rule' => 'date',
                    'message' => __l('Must be a valid date') ,
                    'allowEmpty' => true
                ) ,
                'rule3' => array(
                    'rule' => array(
                        '_checkCurrentDate'
                    ) ,
                    'message' => __l('DOB should be lesser than current date')
                )
            ) ,
            'paypal_account' => array(
                'rule' => 'email',
                'message' => __l('Must be a valid email') ,
                'allowEmpty' => true
            ),
            'url' => array(
                'rule2' => array(
                    'rule' => array(
                        'url'
                    ) ,
                    'message' => __l('Must be a valid URL, starting with http://') ,
                    'allowEmpty' => true
                ) ,
                'rule1' => array(
                    'rule' => array(
                        'custom',
                        '/^http:\/\//'
                    ) ,
                    'message' => __l('Must be a valid URL, starting with http://') ,
                    'allowEmpty' => true
                )
            )
        );
    }
    function _checkCurrentDate()
    {
        if (strtotime($this->data[$this->name]['dob']) <= strtotime(date('Y-m-d'))) return true;
        return false;
    }
}
?>