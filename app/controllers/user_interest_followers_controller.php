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
class UserInterestFollowersController extends AppController
{
    public $name = 'UserInterestFollowers';
	public function add($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $userInterestFollower = $this->UserInterestFollower->find('first', array(
            'conditions' => array(
                'UserInterestFollower.user_interest_id' => $id,
                'UserInterestFollower.user_id' => $this->Auth->user('id')
            ) ,
        ));
        if (!empty($userInterestFollower)) {
            $this->redirect(array(
                'controller' => 'user_interests',
                'action' => 'index',
                $userInterestFollower['UserInterestFollower']['user_id']
            ));
        }
        $userInterestFollower['UserInterestFollower']['user_interest_id'] = $id;
        $userInterestFollower['UserInterestFollower']['user_id'] = $this->Auth->user('id');
        if ($this->UserInterestFollower->save($userInterestFollower['UserInterestFollower'])) {
			// Saving record in MailChimp Server //
			if (Configure::read('mailchimp.is_enabled')) {
				$this->loadModel('MailChimpList');
				$user_interest_list_id = $this->MailChimpList->find('first', array(
					'conditions' => array(
						'MailChimpList.user_interest_id' => $id
					) ,
					'fields' => array(
						'MailChimpList.list_id'
					)
				));
				include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'MCAPI.class.php');
				include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'config.inc.php');
				$api = new MCAPI(Configure::read('mailchimp.api_key'));
				$email = $this->Auth->user('email');
				$unsub_link = Cache::read('site_url_for_shell', 'long') . preg_replace('/\//', '', Router::url(array(
					'controller' => 'user_interest_followers',
					'action' => 'delete',
					$this->UserInterestFollower->getLastInsertId() ,
					'admin' => false
				) , false) , 1);
				$merge_vars = array(
					'UNSUBSCRIB' => $unsub_link
				);
				$retval = $api->listSubscribe($user_interest_list_id['MailChimpList']['list_id'], $email, $merge_vars, 'html', false);
				$retval = $api->listUpdateMember($user_interest_list_id['MailChimpList']['list_id'], $email, $merge_vars, 'html', false);
			}
            if ($this->RequestHandler->isAjax()) {
                $userInterestFollowerCount = $this->UserInterestFollower->find('count', array(
                    'conditions' => array(
                        'UserInterestFollower.user_id' => $this->Auth->user('id')
                    ) ,
                ));
                echo "followed|" . Router::url(array(
                    'controller' => 'user_interest_followers',
                    'action' => 'delete',
                    $this->UserInterestFollower->getLastInsertId()
                ) , true) . '|' . $userInterestFollowerCount;
                exit;
            } else {
                $this->Session->setFlash(__l('Interest has added ') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'user_interests',
                    'action' => 'index',
                    $userInterestFollower['UserInterestFollower']['user_id']
                ));
            }
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $userInterestFollower = $this->UserInterestFollower->find('first', array(
            'conditions' => array(
                'UserInterestFollower.user_interest_id' => $id,
                'UserInterestFollower.user_id' => $this->Auth->user('id')
            ) ,
        ));
        if (empty($userInterestFollower)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserInterestFollower->delete($userInterestFollower['UserInterestFollower']['id'])) {
			// unsubscribe the email in mail chimp
			if (Configure::read('mailchimp.is_enabled')) {
				$this->loadModel('MailChimpList');
				$user_interest_list_id = $this->MailChimpList->find('first', array(
					'conditions' => array(
						'MailChimpList.user_interest_id' => $id
					) ,
					'fields' => array(
						'MailChimpList.list_id'
					)
				));
				include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'MCAPI.class.php');
				include_once (APP . DS . 'vendors' . DS . 'mailchimp' . DS . 'config.inc.php');
				$api = new MCAPI(Configure::read('mailchimp.api_key'));
				$retval = $api->listUnsubscribe($user_interest_list_id['MailChimpList']['list_id'], $this->Auth->user('email'));
			}
            $userInterestFollowerCount = $this->UserInterestFollower->find('count', array(
                'conditions' => array(
                    'UserInterestFollower.user_interest_id' => $id,
                ) ,
            ));
            if ($this->RequestHandler->isAjax()) {
                $userInterestFollowerCount = $this->UserInterestFollower->find('count', array(
                    'conditions' => array(
                        'UserInterestFollower.user_id' => $this->Auth->user('id')
                    ) ,
                ));
                echo "unfollowed|" . Router::url(array(
                    'controller' => 'user_interest_followers',
                    'action' => 'add',
                    $id
                ) , true) . '|' . $userInterestFollowerCount;
                exit;
            } else {
                $this->Session->setFlash(__l('Interest deleted') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'my_stuff#Interests',
                ));
            }
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Interest Followers');
		 $this->_redirectGET2Named(array(
            'user_id',
            'q'
        ));
		$conditions =array();
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
                'recursive' => - 1
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
		if(!empty($this->request->params['named']['id']))
		{
			 $conditions['UserInterestFollower.user_interest_id'] = $this->request->params['named']['id'];
		}
        $this->UserInterestFollower->recursive = 1;
		$this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                ) ,
				'UserInterest',
            ) ,
            'order' => array(
                'UserInterestFollower.id' => 'desc'
            ) ,
        );
        $this->set('userFollowers', $this->paginate());
        $moreActions = $this->UserInterestFollower->moreActions;
        $this->set(compact('moreActions'));
    }
}
