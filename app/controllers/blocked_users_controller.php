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
class BlockedUsersController extends AppController
{
    public $name = 'BlockedUsers';
    public function index()
    {
        $this->pageTitle = __l('Blocked Users');
        $this->BlockedUser->recursive = 0;
        $this->paginate = array(
            'conditions' => array(
                'BlockedUser.user_id' => $this->Auth->user('id')
            ) ,
            'contain' => array(
                'Blocked' => array(
                    'UserAvatar'
                )
            )
        );
        $this->set('blockedUsers', $this->paginate());
    }
    public function add($username = null)
    {
        $this->pageTitle = __l('Add Blocked User');
        // check is user exists
        $user = $this->BlockedUser->User->find('first', array(
            'conditions' => array(
                'User.username' => $username
            ) ,
            'fields' => array(
                'User.id'
            ) ,
            'recursive' => - 1
        ));
        if (empty($user)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        // Check is already added
        $blocked = $this->BlockedUser->find('first', array(
            'conditions' => array(
                'BlockedUser.user_id' => $this->Auth->user('id') ,
                'BlockedUser.blocked_user_id' => $user['User']['id']
            ) ,
            'fields' => array(
                'BlockedUser.id'
            ) ,
            'recursive' => - 1
        ));
        if (empty($blocked)) {
            $this->request->data['BlockedUser']['user_id'] = $this->Auth->user('id');
            $this->request->data['BlockedUser']['blocked_user_id'] = $user['User']['id'];
            $this->BlockedUser->create();
            if ($this->BlockedUser->save($this->request->data)) {
                $this->Session->setFlash(__l('User blocked successfully.') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'view',
                    $username
                ));
            } else {
            }
        } else {
            $this->Session->setFlash(__l('Already added') , 'default', null, 'error');
        }
    }
    public function edit($id = null)
    {
        $this->pageTitle = __l('Edit Blocked User');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->BlockedUser->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Blocked User has been updated') , $this->request->data['BlockedUser']['id']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Blocked User could not be updated. Please, try again.') , $this->request->data['BlockedUser']['id']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->BlockedUser->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['BlockedUser']['id'];
        $users = $this->BlockedUser->User->find('list');
        $this->set(compact('users'));
    }
    public function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $blocked = $this->BlockedUser->find('first', array(
            'conditions' => array(
                'BlockedUser.user_id' => $this->Auth->user('id') ,
                'BlockedUser.id' => $id
            ) ,
            'contain' => array(
                'Blocked' => array(
                    'fields' => array(
                        'Blocked.username'
                    ) ,
                )
            ) ,
            'fields' => array(
                'BlockedUser.blocked_user_id'
            ) ,
        ));
        if (!$blocked) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->BlockedUser->delete($id)) {
            $this->Session->setFlash(__l('Blocked User deleted') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'view',
                $blocked['Blocked']['username']
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'user_id',
            'blocked_user_id',
            'q'
        ));
        $conditions = array();
        if (isset($this->request->params['named']['user_id'])) {
            $this->request->data['BlockedUser']['user_id'] = $this->request->params['named']['user_id'];
            $conditions['BlockedUser.user_id'] = $this->request->params['named']['user_id'];
        }
        if (isset($this->request->params['named']['blocked_user_id'])) {
            $this->request->data['BlockedUser']['blocked_user_id'] = $this->request->params['named']['blocked_user_id'];
            $conditions['BlockedUser.blocked_user_id'] = $this->request->params['named']['blocked_user_id'];
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['BlockedUser']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->pageTitle = __l('Blocked Users');
        $this->BlockedUser->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'BlockedUser.id' => 'desc'
            )
        );
        if (isset($this->request->data['BlockedUser']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->params['named']['q']
            ));
        }
        $this->set('blockUsers', $this->paginate());
        $users = $this->BlockedUser->User->find('list', array(
            'conditions' => array(
                'User.user_type_id !=' => ConstUserTypes::Admin
            )
        ));
        $blockedUsers = $this->BlockedUser->User->find('list', array(
            'conditions' => array(
                'User.user_type_id !=' => ConstUserTypes::Admin
            )
        ));
        $moreActions = $this->BlockedUser->moreActions;
        $this->set(compact('users', 'blockedUsers', 'moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Blocked User');
        if (!empty($this->request->data)) {
            $this->BlockedUser->create();
            if ($this->BlockedUser->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Blocked User has been added') , $this->request->data['BlockedUser']['id']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Blocked User could not be added. Please, try again.') , $this->request->data['BlockedUser']['id']) , 'default', null, 'error');
            }
        }
        $users = $this->BlockedUser->User->find('list');
        $this->set(compact('users'));
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Blocked User');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->BlockedUser->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('"%s" Blocked User has been updated') , $this->request->data['BlockedUser']['id']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('"%s" Blocked User could not be updated. Please, try again.') , $this->request->data['BlockedUser']['id']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->BlockedUser->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['BlockedUser']['id'];
        $users = $this->BlockedUser->User->find('list');
        $this->set(compact('users'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->BlockedUser->delete($id)) {
            $this->Session->setFlash(__l('Blocked User deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_update()
    {
        if (!empty($this->request->data['BlockedUser'])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $blockedUserIds = array();
            foreach($this->request->data['BlockedUser'] as $user_id => $is_checked) {
                if ($is_checked['id']) {
                    $blockedUserIds[] = $user_id;
                }
            }
            if (!empty($blockedUserIds) && !empty($actionid)) {
                $this->BlockedUser->deleteAll(array(
                    'BlockedUser.id' => $blockedUserIds
                ));
                $this->Session->setFlash(__l('Checked blocked users has been deleted') , 'default', null, 'success');
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
}
?>