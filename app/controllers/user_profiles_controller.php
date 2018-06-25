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
class UserProfilesController extends AppController
{
    public $name = 'UserProfiles';
    public $components = array(
        'Email'
    );
    public function beforeFilter()
    {

        $this->Security->disabledFields = array(
            'UserAvatar.filename',
            'City.id',
            'State.id'
        );
        parent::beforeFilter();
    }
    public function edit($user_id = null)
    {
        $this->pageTitle = __l('Edit Profile');
        $this->loadModel('EmailTemplate');
        $this->loadModel('Attachment');
        $this->UserProfile->User->UserAvatar->Behaviors->attach('ImageUpload', Configure::read('avatar.file'));
        if (!empty($this->request->data)) {
            if (empty($this->request->data['User']['id'])) {
                $this->request->data['User']['id'] = $this->Auth->user('id');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id',
                            'UserProfile.language_id',
                        )
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            if (!empty($user)) {
                $this->request->data['UserProfile']['id'] = $user['UserProfile']['id'];
                if (!empty($user['UserAvatar']['id'])) {
                    $this->request->data['UserAvatar']['id'] = $user['UserAvatar']['id'];
                }
            }
            $this->request->data['UserProfile']['user_id'] = $this->request->data['User']['id'];
            if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                $this->request->data['UserAvatar']['filename']['type'] = get_mime($this->request->data['UserAvatar']['filename']['tmp_name']);
            }
            if (!empty($this->request->data['UserAvatar']['filename']['name']) || (!Configure::read('avatar.file.allowEmpty') && empty($this->request->data['UserAvatar']['id']))) {
                $this->UserProfile->User->UserAvatar->set($this->request->data);
            }
            $this->UserProfile->set($this->request->data);
            $this->UserProfile->User->set($this->request->data);
            $this->UserProfile->City->set($this->request->data);
            $ini_upload_error = 1;
            if (!empty($this->request->data['UserAvatar']['filename']) && $this->request->data['UserAvatar']['filename']['error'] == 1) {
                $ini_upload_error = 0;
            }
            unset($this->UserProfile->City->validate['City']);
            if ($this->UserProfile->User->validates() & $this->UserProfile->validates() & $this->UserProfile->User->UserAvatar->validates() & $this->UserProfile->City->validates()  && $ini_upload_error) {
                if ($this->UserProfile->save($this->request->data)) {
                    $this->UserProfile->User->save($this->request->data['User']);
                    if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                        $this->Attachment->create();
                        $this->request->data['UserAvatar']['class'] = 'UserAvatar';
                        $this->request->data['UserAvatar']['foreign_id'] = $this->request->data['User']['id'];
                        $this->Attachment->save($this->request->data['UserAvatar']);
                    }
                    if ($this->request->data['UserProfile']['language_id'] != $user['UserProfile']['language_id']) {
                        $this->UserProfile->User->UserLogin->updateUserLanguage();
                    }
                }
                $this->Session->setFlash(__l('User Profile has been updated') , 'default', null, 'success');
                if ($this->Auth->user('user_type_id') == ConstUserTypes::Admin and $this->Auth->user('id') != $this->request->data['User']['id'] and Configure::read('user.is_mail_to_user_for_profile_edit')) {
                    // Send mail to user to activate the account and send account details
                    $language_code = $this->UserProfile->getUserLanguageIso($user['User']['id']);
                    $email = $this->EmailTemplate->selectTemplate('Admin User Edit', $language_code);
                    $emailFindReplace = array(
                        '##FROM_EMAIL##' => $this->UserProfile->changeFromEmail(($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from']) ,
                        '##SITE_URL##' => Router::url('/', true) ,
                        '##USERNAME##' => $user['User']['username'],
                        '##SITE_NAME##' => Configure::read('site.name') ,
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
                    $this->Email->from = ($email['from'] == '##FROM_EMAIL##') ? Configure::read('EmailTemplate.from_email') : $email['from'];
                    $this->Email->replyTo = ($email['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $email['reply_to'];
                    $this->Email->to = $user['User']['email'];
                    $this->Email->subject = strtr($email['subject'], $emailFindReplace);
                    $this->Email->sendAs = ($email['is_html']) ? 'html' : 'text';
                    $this->Email->send(strtr($email['email_content'], $emailFindReplace));
                }
            } else {
                if (!empty($this->request->data['UserAvatar']['filename']) && $this->request->data['UserAvatar']['filename']['error'] == 1) {
                    $this->UserProfile->User->UserAvatar->validationErrors['filename'] = sprintf(__l('The file uploaded is too big, only files less than %s permitted') , ini_get('upload_max_filesize'));
                }
                $this->Session->setFlash(__l('User Profile could not be updated. Please, try again.') , 'default', null, 'error');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id'
                        )
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            if (!empty($user['User'])) {
                unset($user['UserProfile']);
                $this->request->data['User'] = array_merge($user['User'], $this->request->data['User']);
                $this->request->data['UserAvatar'] = $user['UserAvatar'];
            }
            //Setting ajax layout when submitting through iframe with jquery ajax form plugin
            if (!empty($this->request->params['form']['is_iframe_submit'])) {
                $this->layout = 'ajax';
            }
        } else {
            unset($this->UserProfile->City->validate['City']);
            if (empty($user_id)) {
                $user_id = $this->Auth->user('id');
            }
            $this->request->data = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id,
                    'User.user_type_id !=' => ConstUserTypes::Merchant
                ) ,
                'fields' => array(
                    'User.user_type_id',
                    'User.username',
                    'User.id',
                    'User.email',
                    'User.user_type_id',
                    'User.user_login_count',
                    'User.user_view_count',
                    'User.is_active',
                    'User.is_email_confirmed',
                    'User.fb_user_id',
                ) ,
                'contain' => array(
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.dir',
                            'UserAvatar.filename',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    ) ,
                    'UserProfile' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name'
                            )
                        ) 
                    )
                ) ,
                'recursive' => 2
            ));
            $this->request->data['UserProfile']['user_id'] = $user_id;
            if (!empty($this->request->data['UserProfile']['City'])) {
                $this->request->data['City']['name'] = $this->request->data['City']['name'] = $this->request->data['City']['name'] = $this->request->data['UserProfile']['City']['name'];
            }
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['User']['username'];
        $genders = $this->UserProfile->Gender->find('list');
        $languageLists = $this->UserProfile->Language->Translation->find('all', array(
            'conditions' => array(
                'Language.id !=' => 0
            ) ,
            'fields' => array(
                'DISTINCT(Translation.language_id)',
                'Language.name',
                'Language.id'
            ) ,
            'order' => array(
                'Language.name' => 'ASC'
            )
        ));
        $languages = array();
        if (!empty($languageLists)) {
            foreach($languageLists as $languageList) {
                $languages[$languageList['Language']['id']] = $languageList['Language']['name'];
            }
        }
        $cities = $this->UserProfile->City->find('list', array(
			'conditions' => array(
				'City.is_approved' => 1
			) ,
			'recursive' => -1
		));
        $this->set(compact('genders', 'languages', 'cities'));
    }
    public function admin_edit($id = null)
    {
        if (is_null($id) && empty($this->request->data)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->setAction('edit', $id);
    }
    public function admin_user_account($user_id = null)
    {
        if (is_null($user_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
		$this->pageTitle = __l('My Account');
        $this->setAction('my_account', $user_id);
    }
    public function my_account($user_id = null,$user_setting_id = null,$user_notification_id = null)
    {
        if (is_null($user_id)) {
			throw new NotFoundException(__l('Invalid request'));
        }
		$this->pageTitle = __l('My Profile');
        $this->set('user_id', $user_id);
        $this->set('user_setting_id', $user_setting_id);
        $this->set('user_notification_id', $user_notification_id);
        $user = $this->UserProfile->User->find('first',array('conditions'=>array('User.is_twitter_register'=> 1,'User.id'=>$user_id)));
        $this->set('user', $user);
    }
}
?>