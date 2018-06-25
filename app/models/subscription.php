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
class Subscription extends AppModel
{
    public $name = 'Subscription';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'city_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'email' => array(
                'rule2' => array(
                    'rule' => 'email',
                    'allowEmpty' => false,
                    'message' => __l('Please enter valid email address')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                )
            ) ,
            'width' => array(
                'rule' => 'numeric',
                'allowEmpty' => true,
                'message' => __l('Required')
            ) ,
            'height' => array(
                'rule' => 'numeric',
                'allowEmpty' => true,
                'message' => __l('Required')
            ) ,
        );
        $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete') ,
            ConstMoreAction::UnSubscripe => __l('Unsubscribe') ,
        );
    }
}
?>