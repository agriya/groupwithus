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
class ItemCategoriesItem extends AppModel
{
    public $name = 'ItemCategoriesItem';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'ItemCategory' => array(
            'className' => 'ItemCategory',
            'foreignKey' => 'item_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'Item' => array(
            'className' => 'Item',
            'foreignKey' => 'item_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'item_category_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'item_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            )
        );
    }
}
?>