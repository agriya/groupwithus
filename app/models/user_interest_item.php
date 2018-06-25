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
class UserInterestItem extends AppModel
{
    public $name = 'UserInterestItem';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'Item' => array(
            'className' => 'Item',
            'foreignKey' => 'item_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => false
        ) ,
        'UserInterest' => array(
            'className' => 'UserInterest',
            'foreignKey' => 'user_interest_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        )
    );
}
?>
