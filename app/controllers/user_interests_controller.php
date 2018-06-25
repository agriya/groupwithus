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
class UserInterestsController extends AppController
{
    public $name = 'UserInterests';
    public function index($id = null)
    {
        $this->pageTitle = __l('Interest');
        $conditions = array();
        $id = !empty($id) ? $id : $this->Auth->user('id');
        if (!empty($id)) {
            $user_interests = $this->UserInterest->UserInterestFollower->find('list', array(
                'conditions' => array(
                    'UserInterestFollower.user_id' => $id
                ) ,
                'fields' => array(
                    'UserInterestFollower.user_interest_id'
                )
            ));
			 $user_interests_count = $this->UserInterest->UserInterestFollower->find('count', array(
                'conditions' => array(
                    'UserInterestFollower.user_id' => $id
                ) ,
				'recursive'=> -1,
            ));
			$this->set('user_interests',$user_interests_count );
            if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'myinterest') {
                $conditions['UserInterest.id'] = $user_interests;
            } else {
            }
        }
		$conditions_follower=array();
		if($this->Auth->user('id'))
		{
			$conditions_follower['UserInterestFollower.user_id']=$this->Auth->user('id');

		}
        $userInterests = $this->UserInterest->find('all', array(
            'conditions' => $conditions,
			'contain' => array(
				'UserInterestFollower' => array(
					'conditions' => $conditions_follower,
					'limit' => 1,
			   ),
				'User' => array(
					'UserAvatar',
				     'fields' => array(
                    'User.id',
					'User.username',
					'User.user_type_id',
					 ),
		           ),
			),
			'order' => array('UserInterest.user_interest_follower_count' => 'desc'),
            'recursive' => 2
        ));
        $this->set('userInterests', $userInterests);
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'profile') {
            $this->render('user_interest');
        }
    }
	public function view($slug = null)
    {
		if (empty($slug)) {
                throw new NotFoundException(__l('Invalid request'));
         }
        $this->pageTitle = __l('Interest - ').$slug;
        $conditions = array();
		$conditions['UserInterest.slug']=$slug;
		$conditions_follower=array();
		if($this->Auth->user('id'))
		{
			$conditions_follower['UserInterestFollower.user_id']=$this->Auth->user('id');

		}
        $userInterest = $this->UserInterest->find('first', array(
            'conditions' => $conditions,
			'contain' => array(
				'UserInterestFollower' => array(
						'conditions' => $conditions_follower,
						'limit' => 1,
				   ),				'User' => array(
					'UserAvatar',
					'UserProfile' => array(
					 'fields' => array(
						'UserProfile.id',
						'UserProfile.user_id',
						'UserProfile.home_town',
						),
					 ),
				   'fields' => array(
                    'User.id',
					'User.username',
					'User.user_type_id',
					 ),
		           ),
			),
			'order' => array('UserInterest.user_interest_follower_count' => 'desc'),
            'recursive' => 2
        ));
		if (empty($userInterest)) {
                throw new NotFoundException(__l('Invalid request'));
         }
				$cond=array();
				$cond['UserInterestFollower.user_interest_id']=$userInterest['UserInterest']['id'];
				if($this->Auth->user('id'))
				{
					$cond['UserInterestFollower.user_id']=$this->Auth->user('id');
				}
				$user_interest_follower_count = $this->UserInterest->UserInterestFollower->find('count', array(
                'conditions' =>$cond,
				'recursive'=> -1,
            ));

        $this->set('user_interest_follower_count', $user_interest_follower_count);
        $this->set('userInterest', $userInterest);
    }
    public function add($id = null)
    {
        $this->pageTitle = __l('Add Interest');
        if ($this->request->is('post')) {
            $this->UserInterest->create();
            if ($this->UserInterest->save($this->request->data)) {
                 $user_interestid=$this->UserInterest->getLastInsertId();
               	$user_interests_count = $this->UserInterest->UserInterestFollower->find('count', array(
                'conditions' => array(
                    'UserInterestFollower.user_interest_id' => $user_interestid
                ) ,
				'recursive'=> -1,
            ));
             $this->request->data = $this->UserInterest->read(null, $user_interestid);
             $this->request->data['UserInterest']['id']=$user_interestid;
             $this->request->data['UserInterest']['user_interest_follower_count']=$user_interests_count;
             $this->UserInterest->save($this->request->data);
                $this->Session->setFlash(__l('Interest has been added') , 'default', null, 'success');
                if ($this->RequestHandler->isAjax()) {
                    echo 'redirect*' . Router::url(array(
                        'controller' => 'user_interests',
                        'action' => 'index',
						'city' => $this->request->params['named']['city']
                    ) , true);
                    exit;
                } else {
                    $this->redirect(array(
                        'controller' => 'user_interests',
                        'action' => 'index'
                    ));
                }
            } else {
                $this->Session->setFlash(__l('Interest could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $users = $this->UserInterest->User->find('list');
        $this->set(compact('users'));
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Interests');
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
            $this->request->data['UserInterest']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->UserInterest->recursive = 1;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                ) ,
            ) ,
            'order' => array(
                'UserInterest.id' => 'desc'
            ) ,
        );
        if (isset($this->request->data['UserInterest']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->params['named']['q']
            ));
        }
        $this->UserInterest->recursive = 0;
        $this->set('userInterests', $this->paginate());
        $moreActions = $this->UserInterest->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Interest');
        if ($this->request->is('post')) {
            $this->UserInterest->create();
                if ($this->UserInterest->save($this->request->data)) {
                $user_interestid=$this->UserInterest->getLastInsertId();
               	$user_interests_count = $this->UserInterest->UserInterestFollower->find('count', array(
                'conditions' => array(
                    'UserInterestFollower.user_interest_id' => $user_interestid
                ) ,
				'recursive'=> -1,
            ));
             $this->request->data = $this->UserInterest->read(null, $user_interestid);
             $this->request->data['UserInterest']['id']=$user_interestid;
             $this->request->data['UserInterest']['user_interest_follower_count']=$user_interests_count;
             $this->UserInterest->save($this->request->data);
             $this->Session->setFlash(__l('Interest has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Interest could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $users = $this->UserInterest->User->find('list', array(
            'conditions' => array(
                'User.user_type_id' => ConstUserTypes::User
            )
        ));
        $this->set(compact('users'));
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Interest');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->UserInterest->id = $id;
        if (!$this->UserInterest->exists()) {
            throw new NotFoundException(__l('Invalid interest'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->UserInterest->save($this->request->data)) {
                $this->Session->setFlash(__l('Interest has been updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Interest could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->data = $this->UserInterest->read(null, $id);
            if (empty($this->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->data['UserInterest']['name'];
        $users = $this->UserInterest->User->find('list');
        $this->set(compact('users'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserInterest->delete($id)) {
            $this->Session->setFlash(__l('Interest  deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
