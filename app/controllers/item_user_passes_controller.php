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
class ItemUserPassesController extends AppController
{
    public $name = 'ItemUserPasses';
    public function update_status($item_user_id = null, $field = 'is_used')
    {
        $action = 1;
        if (!empty($item_user_id) && !empty($this->request->params['named']['pass_id'])) {
            $ItemUserPass = $this->ItemUserPass->find('first', array(
                'conditions' => array(
                    'ItemUserPass.id' => $this->request->params['named']['pass_id'],
                    'ItemUserPass.item_user_id' => $item_user_id
                ) ,
                'contain' => array(
                    'ItemUser' => array(
                        'Item'
                    ) ,
                ) ,
                'recursive' => 2
            ));
        }
        $user = $this->ItemUserPass->ItemUser->Item->User->Merchant->find('first', array(
            'conditions' => array(
                'Merchant.user_id' => $this->Auth->User('id')
            ) ,
            'fields' => array(
                'Merchant.id'
            ) ,
            'recursive' => - 1
        ));
        if ($ItemUserPass['ItemUserPass'][$field] == 1) {
            $status = 0;
            if (($ItemUserPass['ItemUser']['Item']['merchant_id'] != $user['Merchant']['id']) && !empty($user['Merchant']['id'])) {
                $action = 0;
            }
        } else {
            $status = 1;
        }
        if (!empty($action)) {
            $ItemUserPass = array();
            $ItemUserPass['id'] = $this->request->params['named']['pass_id'];
            $ItemUserPass['is_used'] = $status;
            $this->ItemUserPass->save($ItemUserPass);
        }
        if ($this->RequestHandler->prefers('json')) {
            $resonse = array(
                'status' => 0,
                'message' => __l('Success')
            );
            $this->view = 'Json';
            $this->set('json', (empty($this->viewVars['iphone_response'])) ? $resonse : $this->viewVars['iphone_response']);
        } else {
            $this->autoRender = false;
            echo $action;
        }
    }
    public function pass_update_status($item_user_id = null, $field = 'use')
    {
        $action = 1;
        if (!empty($item_user_id) && !empty($this->request->params['named']['pass_id'])) {
            $conditions = array();
            $conditions['ItemUserPass.id'] = $this->request->params['named']['pass_id'];
            $conditions['ItemUserPass.item_user_id'] = $item_user_id;
            if ($field == 'use') {
                $conditions['ItemUserPass.is_used'] = 0;
            } else {
                $conditions['ItemUserPass.is_used'] = 1;
            }
            $code_type = (Configure::read('item.item_pass_code_show_type') == 'top') ? 'unique_pass_code' : 'pass_code';
            $conditions['ItemUserPass.unique_pass_code'] = $this->request->params['named']['code'];
            $ItemUserPass = $this->ItemUserPass->find('first', array(
                'conditions' => $conditions,
                'contain' => array(
                    'ItemUser' => array(
                        'Item'
                    ) ,
                ) ,
                'recursive' => 2
            ));
        }
        $status = ($field == 'use') ? 1 : 0;
        $ItemUserPassdata = $ItemUserPass;
        if (!empty($ItemUserPass)) {
            $ItemUserPass = array();
            $ItemUserPass['id'] = $this->request->params['named']['pass_id'];
            $ItemUserPass['is_used'] = $status;
            $this->ItemUserPass->save($ItemUserPass);
			$this->ItemUserPass->ItemUser->Item->ItemPass->updateAll(array(
				'ItemPass.is_used' => $status
			) , array(
				'ItemPass.pass_code' => $ItemUserPassdata['ItemUserPass']['pass_code']
			));
            $this->autoRender = false;
            echo 'suceess';
        } else {
            $this->autoRender = false;
            echo 'fail';
        }
    }
    public function check_qr()
    {
        if (!empty($this->request->data)) {
            $pass_code = $this->request->data['ItemUserPass']['pass_code'];
            $unique_pass_code = $this->request->data['ItemUserPass']['unique_pass_code'];
        } else {
            $pass_code = $this->request->params['pass'][0];
            $unique_pass_code = $this->request->params['pass'][1];
        }
        if (is_null($pass_code) || is_null($unique_pass_code)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle = __l('Item user Pass');
        $conditions['ItemUserPass.pass_code'] = $pass_code;
        $conditions['ItemUserPass.unique_pass_code'] = $unique_pass_code;
        $ItemUserPass = $this->ItemUserPass->find('first', array(
            'conditions' => $conditions,
            'contain' => array(
                'ItemUser' => array(
                    'User' => array(
                        'fields' => array(
                            'User.username'
                        ) ,
                    ) ,
                    'Item' => array(
                        'Merchant' => array(
                            'fields' => array(
                                'Merchant.user_id'
                            ) ,
                        ) ,
                        'fields' => array(
                            'Item.id',
                            'Item.name',
                            'Item.end_date'
                        ) ,
                    ) ,
                )
            ) ,
            'recursive' => 3
        ));
        if (empty($ItemUserPass)) {
            $this->Session->setFlash(__l('Invalid Pass code') , 'default', null, 'error');
            $this->redirect(Router::url('/', true));
        }
        if (($this->Auth->user('user_type_id') == ConstUserTypes::User) || ($this->Auth->user('user_type_id') != ConstUserTypes::Admin) && ($this->Auth->user('id') != $ItemUserPass['ItemUser']['Item']['Merchant']['user_id'])) {
            $this->Session->setFlash(__l('You have no authorized to view this page') , 'default', null, 'error');
            $this->redirect(Router::url('/', true));
        }
        if ($ItemUserPass['ItemUserPass']['is_used'] == 1) {
            $this->Session->setFlash(__l('This Pass used already') , 'default', null, 'error');
        }
        if (!empty($this->request->data)) {
            $item_user_pass_id = $ItemUserPass['ItemUserPass']['id'];
            $item_update_data['ItemUserPass']['is_used'] = $this->Auth->user('id');
            $item_update_data['ItemUserPass']['user_id'] = 1;
            $item_update_data['ItemUserPass']['id'] = $item_user_pass_id;
            if ($this->ItemUserPass->save($item_update_data)) {
                $ItemUserPass['ItemUserPass']['is_used'] = 1;
                $this->Session->setFlash(__l('Pass used successfully') , 'default', null, 'success');
            }
        }
        $this->request->data['ItemUserPass']['id'] = $pass_code;
        $this->request->data['ItemUserPass']['pass_code'] = $pass_code;
        $this->request->data['ItemUserPass']['unique_pass_code'] = $unique_pass_code;
        $this->set('ItemUserPass', $ItemUserPass);
    }
}
?>