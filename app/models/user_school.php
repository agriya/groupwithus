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
class UserSchool extends AppModel
{
    public $name = 'UserSchool';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => false
        ) ,
        'UserSchoolDegree' => array(
            'className' => 'UserSchoolDegree',
            'foreignKey' => 'user_school_degree_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => false
        ),
        'College' => array(
            'className' => 'College',
            'foreignKey' => 'college_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => false
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'user_school_degree_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'college_id' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
             'school_year' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) 

        );
          $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }
}
