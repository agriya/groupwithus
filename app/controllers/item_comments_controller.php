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
class ItemCommentsController extends AppController
{
    public $name = 'ItemComments';
    public $components = array(
        'Email',
    );
    public function index()
    {
        $this->pageTitle = __l('Item Comments');
            $this->paginate = array(
			 'conditions' => array(
                    'Item.id' => $this->request->params['named']['item_id']
                ),
                'contain'=>array(
                    'PostedUser'=>array(
                        'UserAvatar'
                    ),
                    'Item'
                ),
				'order'=>'ItemComment.id desc',
				'recursive'=>1,
               );
        $this->set('ItemComments', $this->paginate());
    }
    public function view($id = null, $view_name = 'view')
    {
        $this->pageTitle = __l('Item Comment');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid item comment'));
        }
        $ItemComment = $this->ItemComment->find('first', array(
            'conditions' => array(
                'ItemComment.id = ' => $id,
            ) ,
            'contain' => array(
                'PostedUser' => array(
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.dir',
                            'UserAvatar.filename'
                        )
                    ) ,
                    'fields' => array(
                        'PostedUser.username',
                        'PostedUser.user_type_id',
                    )
                ) ,
                'Item' => array(
                    'fields' => array(
                        'Item.user_id'
                    )
                )
            ) ,
            'recursive' => 2,
        ));
        if (empty($ItemComment)) {
            $this->cakeError('error404');
        }
        $this->pageTitle.= ' - ' . $ItemComment['ItemComment']['id'];
        $this->set('ItemComment', $ItemComment);
        $this->render($view_name);
    }
    public function add() 
    {
        $this->pageTitle = __l('Add Item Comment');
        if ($this->request->is('post')) {
            $item = $this->ItemComment->Item->find('first', array(
                'conditions' => array(
                    'Item.id' => $this->request->data['ItemComment']['item_id']
                ),
                'recursive' => 1
            ));
         $this->request->data['ItemComment']['posted_user_id'] = $this->Auth->user('id');
         $postuser = $this->ItemComment->Item->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['ItemComment']['posted_user_id']
                ),
                'recursive' => 1
            ));
            //echo $postuser['User']['username'];
            $this->ItemComment->create();
            if ($this->ItemComment->save($this->request->data)) {
               //$userNotifications = $this->ItemComment->Item->User->UserNotification->find('first',array('conditions'=>array('UserNotification.user_id'=>$this->Auth->user('id'))));
                   //if ($userNotifications['UserNotification']['when_wall_post_of_booked_item']) {
                    $this->_sendAlertOnItemCommentPost($user,$item,$this->request->data['ItemComment']['comment'],  $this->Auth->user('username'));
                  // }
				                   $this->Session->setFlash(__l('Item comment has been added') , 'default', null, 'success');
				   if($this->RequestHandler->isAjax()){
					  $this->setAction('view', $this->ItemComment->id, 'view_ajax');
				   }else{
						$this->redirect(array(
							'controller'=>'items',
							'action' => 'view',
							$item['Item']['slug']
						));
				   }
            } else {
                $this->Session->setFlash(__l('item comment could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $items = $this->ItemComment->Item->find('list');
        $this->set(compact('items'));
    }
   function _sendAlertOnItemCommentPost($email,$item,$comment,$postusername)
    {
        $this->loadModel('EmailTemplate');
        $email_message = $this->EmailTemplate->selectTemplate('Item Comment');
        $email_replace = array(
            '##FROM_EMAIL##' => $this->ItemComment->changeFromEmail(($email_message['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email_message['from']) ,
            '##SITE_URL##' => Router::url('/', true) ,
            '##USERNAME##' => $postusername,
            '##ITEMCOMMENTUSER##' => $postusername,
            '##ITEMCOMMENT##' => $comment,
            '##ITEM_TITLE##' => $item['Item']['name'],
            '##ITEM_PRICE##' => Configure::read('site.currency') . $item['Item']['price'] ,
            '##SITE_URL##' => Router::url('/', true) ,
            '##ITEM_STATUS##' => $item['ItemStatus']['name'],
            '##MERCHANT_NAME##' => $item['Merchant']['name'],
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##PROFILE_LINK##' => Router::url(array(
                'controller' => 'users',
                'action' => 'view',
                $postusername,
                '#tabs-1',
                'admin' => false
            ) , true) ,
            '##CONTACT_URL##' => Router::url(array(
                'controller' => 'contacts',
                'action' => 'add',
                'city' => $this->request->params['named']['city'],
                'admin' => false
            ) , true) ,
            '##SITE_LOGO##' => Router::url(array(
                'controller' => 'img',
                'action' => 'blue-theme',
                'logo-email.png',
                'admin' => false
            ) , true) ,
        );
        // Send e-mail to users
        $this->Email->from = ($email_message['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email_message['from'];
        $this->Email->replyTo = ($email_message['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email_message['reply_to'];
        $this->Email->to = $this->ItemComment->formatToAddress($email);
        $this->Email->subject = strtr($email_message['subject'], $email_replace);
        $this->Email->content = strtr($email_message['email_content'], $email_replace);
        $this->Email->sendAs = ($email_message['is_html']) ? 'html' : 'text';
        $this->Email->send($this->Email->content);
    }
    public function edit($id = null) 
    {
        $this->pageTitle = __l('Edit Item Comment');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->ItemComment->id = $id;
        if (!$this->ItemComment->exists()) {
            throw new NotFoundException(__l('Invalid item comment'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->ItemComment->save($this->request->data)) {
                $this->Session->setFlash(__l('item comment has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('item comment could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->data = $this->ItemComment->read(null, $id);
            if (empty($this->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->data['ItemComment']['id'];
        $items = $this->ItemComment->Item->find('list');
        $this->set(compact('items'));
    }
    public function delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->ItemComment->id = $id;
        if (!$this->ItemComment->exists()) {
            throw new NotFoundException(__l('Invalid item comment'));
        }
        if ($this->ItemComment->delete()) {
            $this->Session->setFlash(__l('Item comment deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $this->Session->setFlash(__l('Item comment was not deleted') , 'default', null, 'error');
        $this->redirect(array(
            'action' => 'index'
        ));
    }
    public function admin_index() 
    {
        $this->pageTitle = __l('Item Comments');
        $this->ItemComment->recursive = 0;
        $ItemComments = $this->paginate();
        $this->set('ItemComments', $ItemComments);
        $moreActions = $this->ItemComment->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_view($id = null) 
    {
        $this->pageTitle = __l('Item Comment');
        $this->ItemComment->id = $id;
        if (!$this->ItemComment->exists()) {
            throw new NotFoundException(__l('Invalid item comment'));
        }
        $this->set('ItemComment', $this->ItemComment->read(null, $id));
    }
    public function admin_add() 
    {
        $this->pageTitle = __l('Add Item Comment');
        if ($this->request->is('post')) {
            $this->ItemComment->create();
            if ($this->ItemComment->save($this->request->data)) {
                $this->Session->setFlash(__l('item comment has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('item comment could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $items = $this->ItemComment->Item->find('list');
        $postedUsers = $this->ItemComment->PostedUser->find('list');
        $this->set(compact('items', 'postedUsers'));
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Edit Item Comment');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->ItemComment->id = $id;
        if (!$this->ItemComment->exists()) {
            throw new NotFoundException(__l('Invalid item comment'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->ItemComment->save($this->request->data)) {
                $this->Session->setFlash(__l('item comment has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('item comment could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->data = $this->ItemComment->read(null, $id);
            if (empty($this->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->data['ItemComment']['id'];
        $items = $this->ItemComment->Item->find('list');
        $postedUsers = $this->ItemComment->PostedUser->find('list');
        $this->set(compact('items', 'postedUsers'));
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ItemComment->delete($id)) {
            $this->Session->setFlash(__l('item comment  deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        }else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}