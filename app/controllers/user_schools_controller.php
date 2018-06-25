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
class UserSchoolsController extends AppController
{
    public $name = 'UserSchools';
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'College',
            'UserSchoolDegree',
            'User',
            'UserSchool.year',
            'UserSchool.major1',
            'UserSchool.major2',
            'UserSchool.major3'
        );
        parent::beforeFilter();
    }
    public function index()
    {
        $this->pageTitle = __l('User Schools');
        $userSchool = $this->UserSchool->find('all', array(
            'conditions' => array(
                'UserSchool.user_id' => $this->Auth->user('id')
            )
        ));
        $moreActions = $this->UserSchool->moreActions;
        $this->set('userSchools', $userSchool);
        $this->set('moreActions', $moreActions);
    }
    public function add()
    {
        $this->pageTitle = __l('Add User School');
        $this->UserSchool->College->set($this->request->data);
        $this->UserSchool->set($this->request->data);
        if ($this->request->is('post')) {
            if (!empty($this->request->data['College']['name'])) {
                $this->request->data['UserSchool']['college_id'] = !empty($this->request->data['College']['id']) ? $this->request->data['College']['id'] : $this->UserSchool->College->findOrSaveAndGetId($this->request->data['College']['name']);
            }
            $this->UserSchool->create();
			if(!empty($this->request->data['UserSchool']['passout']['year']))
			{
				$this->request->data['UserSchool']['year']=$this->request->data['UserSchool']['passout']['year'];
			}
            $this->UserSchool->set($this->request->data);
            if ($this->UserSchool->validates() &$this->UserSchool->College->validates()) {
                if ($this->UserSchool->save($this->request->data)) {
                    $this->Session->setFlash(__l('user school has been added') , 'default', null, 'success');
                    $this->redirect(array(
                        'action' => 'index',
                        $this->request->data['UserSchool']['user_id']
                    ));
                } else {
                    $this->Session->setFlash(__l('user school could not be added. Please, try again.') , 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(__l('user school could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $users = $this->UserSchool->User->find('list');
        $userSchoolDegrees = $this->UserSchool->UserSchoolDegree->find('list');
        $this->set(compact('users', 'userSchoolDegrees'));
    }
    public function edit($id = null)
    {
        $this->pageTitle = __l('Edit User School');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->UserSchool->id = $id;
        if (!$this->UserSchool->exists()) {
            throw new NotFoundException(__l('Invalid user school'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['UserSchool']['college_id'] = !empty($this->request->data['College']['id']) ? $this->request->data['College']['id'] : $this->UserSchool->College->findOrSaveAndGetId($this->request->data['College']['name']);
            $this->request->data['UserSchool']['year'] = $this->request->data['UserSchool']['year']['year'];
            if ($this->UserSchool->save($this->request->data)) {
                $this->Session->setFlash(__l('user school has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index',
                    $this->request->data['UserSchool']['user_id']
                ));
            } else {
                $this->Session->setFlash(__l('user school could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->data = $this->UserSchool->read(null, $id);
            if (empty($this->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->data['UserSchool']['id'];
        $users = $this->UserSchool->User->find('list');
        $userSchoolDegrees = $this->UserSchool->UserSchoolDegree->find('list');
        $this->set(compact('users', 'userSchoolDegrees'));
    }
    public function delete($id = null, $user_id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserSchool->delete($id)) {
            $this->Session->setFlash(__l('User School deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index',
                $user_id
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_index()
    {
        $this->pageTitle = __l('User Schools');
        $this->_redirectGET2Named(array(
            'user_id',
            'q'
        ));
        $conditions = array();
        if (!empty($this->request->params['named']['username']) || !empty($this->request->params['named']['user_id'])) {
            $userConditions = !empty($this->request->params['named']['username']) ? array(
                'User.username' => $this->request->params['named']['username']
            ) : array(
                'User.id' => $this->request->params['named']['user_id']
            );
            $user = $this->{$this->modelClass}->User->find('first', array(
                'conditions' => $userConditions,
                'fields' => array(
                    'User.user_type_id',
                    'User.username',
                    'User.id',
                    'User.fb_user_id',
                ) ,
                'recursive' => -1
            ));
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['User.id'] = $this->request->data[$this->modelClass]['user_id'] = $user['User']['id'];
            $this->pageTitle.= ' - ' . $user['User']['username'];
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['UserSchool']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->UserSchool->recursive = 1;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                ) ,
                'UserSchoolDegree',
                'College'
            ) ,
            'order' => array(
                'UserSchool.id' => 'desc'
            ) ,
        );
        if (isset($this->request->data['UserSchool']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->params['named']['q']
            ));
        }
        $this->set('userSchools', $this->paginate());
        $moreActions = $this->UserSchool->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add User School');
        $this->UserSchool->College->set($this->request->data);
        $this->UserSchool->set($this->request->data);
        if ($this->UserSchool->validates() &$this->UserSchool->College->validates()) {
            if ($this->request->is('post')) {
                if (!empty($this->request->data['College']['name'])) {
                    $this->request->data['UserSchool']['college_id'] = !empty($this->request->data['College']['id']) ? $this->request->data['College']['id'] : $this->UserSchool->College->findOrSaveAndGetId($this->request->data['College']['name']);
                }
                $this->UserSchool->create();
                $this->UserSchool->College->set($this->request->data);
                if ($this->UserSchool->save($this->request->data)) {
                    $this->Session->setFlash(__l('user school has been added') , 'default', null, 'success');
                    $this->redirect(array(
                        'action' => 'index'
                    ));
                } else {
                    $this->Session->setFlash(__l('user school could not be added. Please, try again.') , 'default', null, 'error');
                }
            }
        }
        $users = $this->UserSchool->User->find('list');
        $userSchoolDegrees = $this->UserSchool->UserSchoolDegree->find('list');
        $this->set(compact('users', 'userSchoolDegrees'));
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit User School');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->UserSchool->id = $id;
        if (!$this->UserSchool->exists()) {
            throw new NotFoundException(__l('Invalid user school'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['UserSchool']['college_id'] = !empty($this->request->data['College']['id']) ? $this->request->data['College']['id'] : $this->UserSchool->College->findOrSaveAndGetId($this->request->data['College']['name']);
            $this->request->data['UserSchool']['year'] = $this->request->data['UserSchool']['year']['year'];
            $this->UserSchool->College->set($this->request->data);
            if ($this->UserSchool->save($this->request->data)) {
                $this->Session->setFlash(__l('user school has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('user school could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->data = $this->UserSchool->read(null, $id);
            if (empty($this->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->data['College']['name'];
        $users = $this->UserSchool->User->find('list');
        $userSchoolDegrees = $this->UserSchool->UserSchoolDegree->find('list');
        $this->set(compact('users', 'userSchoolDegrees'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserSchool->delete($id)) {
            $this->Session->setFlash(__l('User school  deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function user_schools()
    {
        $userSchool = $this->UserSchool->find('all', array(
            'conditions' => array(
                'UserSchool.user_id' => $this->request->params['named']['user_id'],
            )
        ));
        $this->set('userSchools', $userSchool);
    }
}
