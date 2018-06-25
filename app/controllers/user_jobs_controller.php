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
class UserJobsController extends AppController
{
    public $name = 'UserJobs';
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Company',
            'User',
            'UserSchool.position',
            'UserType',
        );
        parent::beforeFilter();
    }
    public function index()
    {
        $this->pageTitle = __l('User Jobs');
        $userJob = $this->UserJob->find('all', array(
            'conditions' => array(
                'UserJob.user_id' => $this->Auth->user('id')
            )
        ));
        $this->set('userJobs', $userJob);
        $moreActions = $this->UserJob->moreActions;
        $this->set(compact('moreActions'));
    }
    public function add()
    {
        $this->pageTitle = __l('Add User Job');
        $this->UserJob->Company->set($this->request->data);
        $this->UserJob->set($this->request->data);
        if ($this->UserJob->validates() &$this->UserJob->Company->validates()) {
            if ($this->request->is('post')) {
                if (!empty($this->request->data['Company']['name'])) {
                    $this->request->data['UserJob']['company_id'] = !empty($this->request->data['Company']['id']) ? $this->request->data['Company']['id'] : $this->UserJob->Company->findOrSaveAndGetId($this->request->data['Company']['name']);
                }
                $this->UserJob->create();
                if ($this->UserJob->save($this->request->data)) {
                    $this->Session->setFlash(__l('user job has been added') , 'default', null, 'success');
                    $this->redirect(array(
                        'action' => 'index',
                        $this->request->data['UserJob']['user_id']
                    ));
                } else {
                    $this->Session->setFlash(__l('user job could not be added. Please, try again.') , 'default', null, 'error');
                }
            }
        }
        $users = $this->UserJob->User->find('list');
        $this->set(compact('users'));
    }
    public function edit($id = null)
    {
        $this->pageTitle = __l('Edit User Job');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->UserJob->id = $id;
        if (!$this->UserJob->exists()) {
            throw new NotFoundException(__l('Invalid user job'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['UserJob']['company_id'] = !empty($this->request->data['Company']['id']) ? $this->request->data['Company']['id'] : $this->UserJob->Company->findOrSaveAndGetId($this->request->data['Company']['name']);
            if ($this->UserJob->save($this->request->data)) {
                $this->Session->setFlash(__l('user job has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index',
                    $this->request->data['UserJob']['user_id']
                ));
            } else {
                $this->Session->setFlash(__l('user job could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->data = $this->UserJob->read(null, $id);
            if (empty($this->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->data['UserJob']['user_id'];
        $users = $this->UserJob->User->find('list');
        $this->set(compact('users'));
    }
    public function delete($id = null, $user_id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserJob->delete($id)) {
            $this->Session->setFlash(__l('User job deleted') , 'default', null, 'success');
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
        $this->pageTitle = __l('User Jobs');
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
            $this->request->data['UserJob']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->UserJob->recursive = 1;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                ) ,
                'Company'
            ) ,
            'order' => array(
                'UserJob.id' => 'desc'
            ) ,
        );
        if (isset($this->request->data['UserJob']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->params['named']['q']
            ));
        }
        $this->set('userJobs', $this->paginate());
        $moreActions = $this->UserJob->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add User Job');
        $this->UserJob->Company->set($this->request->data);
        $this->UserJob->set($this->request->data);
        if ($this->UserJob->validates() &$this->UserJob->Company->validates()) {
            if ($this->request->is('post')) {
                if (!empty($this->request->data['Company']['name'])) {
                    $this->request->data['UserJob']['company_id'] = !empty($this->request->data['Company']['id']) ? $this->request->data['Company']['id'] : $this->UserJob->Company->findOrSaveAndGetId($this->request->data['Company']['name']);
                }
                $this->UserJob->create();
                if ($this->UserJob->save($this->request->data)) {
                    $this->Session->setFlash(__l('user job has been added') , 'default', null, 'success');
                    $this->redirect(array(
                        'action' => 'index'
                    ));
                } else {
                    $this->Session->setFlash(__l('user job could not be added. Please, try again.') , 'default', null, 'error');
                }
            }
        }
        $users = $this->UserJob->User->find('list',array(
             'conditions' => array(
               'User.user_type_id !=' => ConstUserTypes::Merchant
            ))
        );
      $this->set(compact('users'));
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit User Job');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->UserJob->id = $id;
        if (!$this->UserJob->exists()) {
            throw new NotFoundException(__l('Invalid user job'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['UserJob']['company_id'] = !empty($this->request->data['Company']['id']) ? $this->request->data['Company']['id'] : $this->UserJob->Company->findOrSaveAndGetId($this->request->data['Company']['name']);
            if ($this->UserJob->save($this->request->data)) {
                $this->Session->setFlash(__l('user job has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('user job could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->data = $this->UserJob->read(null, $id);
            if (empty($this->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->data['Company']['name'];
        $users = $this->UserJob->User->find('list');
        $this->set(compact('users'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserJob->delete($id)) {
            $this->Session->setFlash(__l('User job deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function user_jobs()
    {
        $userJob = $this->UserJob->find('all', array(
            'conditions' => array(
                'UserJob.user_id' => $this->request->params['named']['user_id'],
            )
        ));
        $this->set('userJobs', $userJob);
    }
}
?>
