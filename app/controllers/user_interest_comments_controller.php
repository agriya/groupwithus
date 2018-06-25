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
class UserInterestCommentsController extends AppController
{
    public $name = 'UserInterestComments';
    public $components = array(
        'Email'
    );
    public function beforeFilter()
    {
        if (!$this->UserInterestComment->User->isAllowed($this->Auth->user('user_type_id'))) {
            throw new NotFoundException(__l('Invalid request'));
        }
        parent::beforeFilter();
    }
    public function index($id = null)
    {
        $this->pageTitle = __l('Interest Comments');
		if(!empty($this->request->params['named']['id']))
		{
			$id=$this->request->params['named']['id'];
		}
        if (empty($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
		$conditions =array();
		$conditions['UserInterestComment.user_interest_id'] = $id;
        $this->paginate = array(
            'conditions' =>$conditions,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.user_type_id',
                        'User.username',
                        'User.id',
                        'User.fb_user_id',
                    )
                ),
            ) ,
            'order' => array(
                'UserInterestComment.id DESC'
            )
        );
	 $userInterest = $this->UserInterestComment->User->UserInterest->find('first', array(
            'conditions' => array(
                'UserInterest.id = ' => $id
            ) ,
            'recursive' => -1,
        ));
        $this->UserInterestComment->recursive = 0;
        $this->set('userInterestComments', $this->paginate());
		$this->set('userInterest',$userInterest);

		$this->render('index');
    }
    public function view($id = null, $view_name = 'view')
    {
        $this->pageTitle = __l('Interest Comment');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $userInterestComment = $this->UserInterestComment->find('first', array(
            'conditions' => array(
                'UserInterestComment.id = ' => $id
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
                        'PostedUser.user_type_id',
                        'PostedUser.username',
                        'PostedUser.id',
                        'PostedUser.fb_user_id',
                    )
                )
            ) ,
            'recursive' => 2,
        ));
        if (empty($userInterestComment)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $userInterestComment['UserInterestComment']['id'];
        $this->set('userInterestComment', $userInterestComment);
        $this->render($view_name);
    }
    public function add()
    {
        $this->pageTitle = __l('Add Interest Comment');
        if (!empty($this->request->data)) {
            $this->request->data['UserInterestComment']['user_id'] = $this->Auth->user('id');
		$userInterest = $this->UserInterestComment->User->UserInterest->find('first', array(
            'conditions' => array(
                'UserInterest.id' => $this->request->data['UserInterestComment']['user_interest_id'],
            ) ,
			'recursive' => -1
        ));

            $this->UserInterestComment->create();
			$this->request->data['UserInterestComment']['ip_id'] = $this->UserInterestComment->toSaveIp();
            if ($this->UserInterestComment->save($this->request->data)) {
				if ($this->RequestHandler->isAjax()) {
				 echo 'redirect*' . Router::url(array(
                    'controller' => 'user_interests',
                    'action' => 'view',
                    $userInterest['UserInterest']['slug']
                ) , true);
                    exit;
				}
				else
				{
					echo 'hai';
					exit;
                $this->Session->setFlash(__l('Interest Comment has been added') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'user_interests',
                    'action' => 'view',
                    $userInterest['UserInterest']['slug']
                ));
				}

            } else {
                $this->Session->setFlash(__l('Interest Comment could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    function _sendAlertOnCommentPost($email, $comment, $username, $user_id)
    {
        $this->loadModel('EmailTemplate');
        $language_code = $this->UserInterestComment->getUserLanguageIso($user_id);
        $email_message = $this->EmailTemplate->selectTemplate('New Comment Profile', $language_code);
        $email_replace = array(
            '##FROM_EMAIL##' => $this->UserInterestComment->changeFromEmail(($email_message['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email_message['from']) ,
            '##SITE_URL##' => Router::url('/', true) ,
            '##PROFILEUSERNAME##' => $username,
            '##USERNAME##' => $this->Auth->user('username') ,
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##PROFILE_LINK##' => Router::url(array(
                'controller' => 'users',
                'action' => 'view',
                $username,
                '#tabs-1',
                'admin' => false
            ) , true) ,
            '##COMMENT##' => $comment,
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
        $this->Email->to = $this->UserInterestComment->formatToAddress($email);
        $this->Email->subject = strtr($email_message['subject'], $email_replace);
        $this->Email->content = strtr($email_message['email_content'], $email_replace);
        $this->Email->sendAs = ($email_message['is_html']) ? 'html' : 'text';
        $this->Email->send($this->Email->content);
    }
    public function edit($id = null)
    {
        $this->pageTitle = __l('Edit Interest Comment');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->UserInterestComment->save($this->request->data)) {
                $this->Session->setFlash(__l('Interest Comment has been updated') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('Interest Comment could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->UserInterestComment->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['UserInterestComment']['id'];
        $users = $this->UserInterestComment->User->find('list');
        $this->set(compact('users'));
    }
    public function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        // Check is user allow to delete
        $userInterestComment = $this->UserInterestComment->find('first', array(
            'conditions' => array(
                'UserInterestComment.id' => $id,
            ) ,
			'recursive' => -1
        ));
		$userInterest = $this->UserInterestComment->User->UserInterest->find('first', array(
            'conditions' => array(
                'UserInterest.id' => $userInterestComment['UserInterestComment']['user_interest_id'],
            ) ,
			'recursive' => -1
        ));

        if ($this->UserInterestComment->delete($id)) {
            $this->Session->setFlash(__l('Interest Comment deleted') , 'default', null, 'success');
           
                $this->redirect(array(
                    'controller' => 'user_interests',
                    'action' => 'view',
                    $userInterest['UserInterest']['slug']
                ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Interest Comments');
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
			 $conditions['UserInterestComment.user_interest_id'] = $this->request->params['named']['id'];
		}
        $this->UserInterestComment->recursive = 1;
		$this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                ) ,
				'UserInterest',
				'Ip',
            ) ,
            'order' => array(
                'UserInterestComment.id' => 'desc'
            ) ,
        );
        $this->set('userInterestComments', $this->paginate());
        $moreActions = $this->UserInterestComment->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add User Comment');
        if (!empty($this->request->data)) {
            $this->UserInterestComment->create();
            if ($this->UserInterestComment->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('Interest Comment has been added') , $this->request->data['UserInterestComment']['id']) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('Interest Comment could not be added. Please, try again.') , $this->request->data['UserInterestComment']['id']) , 'default', null, 'error');
            }
        }
        $users = $postedUsers = $this->UserInterestComment->User->find('list');
        $this->set(compact('users', 'postedUsers'));
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Interest Comment');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->UserInterestComment->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('Interest Comment has been updated') , $this->request->data['UserInterestComment']['id']) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('Interest Comment could not be updated. Please, try again.') , $this->request->data['UserInterestComment']['id']) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->UserInterestComment->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['UserInterestComment']['id'];
        $users = $postedUsers = $this->UserInterestComment->User->find('list');
        $this->set(compact('users', 'postedUsers'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserInterestComment->delete($id)) {
            $this->Session->setFlash(__l('Interest Comment deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>