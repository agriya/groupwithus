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
class Message extends AppModel
{
    var $name = 'Message';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'OtherUser' => array(
            'className' => 'User',
            'foreignKey' => 'other_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'MessageContent' => array(
            'className' => 'MessageContent',
            'foreignKey' => 'message_content_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'MessageFolder' => array(
            'className' => 'MessageFolder',
            'foreignKey' => 'message_folder_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
    );
    var $hasAndBelongsToMany = array(
        'Label' => array(
            'className' => 'Label',
            'joinTable' => 'labels_messages',
            'foreignKey' => 'message_id',
            'associationForeignKey' => 'label_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'message_content_id' => array(
                'numeric'
            ) ,
            'message_folder_id' => array(
                'numeric'
            ) ,
            'is_sender' => array(
                'numeric'
            )
        );
         $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }
    function myUsedSpace()
    {
        // to retreive my used mail space
        $size = $this->find('all', array(
            'conditions' => array(
                'is_deleted' => 0,
                'OR' => array(
                    array(
                        'Message.user_id' => $_SESSION['Auth']['User']['id']
                    ) ,
                    array(
                        'Message.other_user_id' => $_SESSION['Auth']['User']['id']
                    )
                )
            ) ,
            'fields' => 'SUM(Message.size) AS size',
            'recursive' => - 1,
        ));
        return $size[0][0]['size'];
    }
    function myMessagePageSize()
    {
        // it returns the user's imbox page size or default styel decide by config
        $message_page_size = $this->User->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $_SESSION['Auth']['User']['id']
            ) ,
            'fields' => array(
                'UserProfile.message_page_size'
            ) ,
            'recursive' => - 1
        ));
        if (!empty($message_page_size['UserProfile']['message_page_size'])) {
            $limit = $message_page_size['UserProfile']['message_page_size'];
        } else {
            $limit = Configure::read('messages.page_size');
        }
        return $limit;
    }
    function getMessageOptionArray($folder_type)
    {
        $options = array();
        $options['More actions'] = __l('---- More actions ----');
        $options['Mark as unread'] = __l('Mark as unread');
        //$options['Create Label'] = __l('Create Label');
        //$options['Add star'] = __l('Add star');
        //$options['Remove star'] = __l('Remove star');
        if ($folder_type != 'inbox' && $folder_type != 'sent') {
            $options['Move to inbox'] = 'Move to inbox';
        }
        $labels = $this->Label->LabelsUser->find('all', array(
            'conditions' => array(
                'LabelsUser.user_id' => $_SESSION['Auth']['User']['id']
            )
        ));
        if (!empty($labels)) {
            $options['Apply label'] = __l('----Apply label----');
            foreach($labels as $label) {
                $options['##apply##' . $label['Label']['slug']] = $label['Label']['name'];
            }
            $options['Remove label'] = __l('----Remove label----');
            foreach($labels as $label) {
                $options['##remove##' . $label['Label']['slug']] = $label['Label']['name'];
            }
        }
        return $options;
    }
    function checkValidateMail($data)
    {
        $validation_result = array(
            'status' => true,
            'message' => ''
        );
        if (isset($data['Message']['save']) && $data['Message']['save'] == 'Save') {
            $validation_result['message'] = 'Message Save in Draft.';
            return $validation_result;
        } elseif (isset($data['Message']['send']) && $data['Message']['send'] == 'Send') {
            if (empty($data['Message']['to'])) {
                $validation_result['message'] = 'Please specify atleast one recipient.';
                $validation_result['status'] = false;
                return $validation_result;
            } else {
                $size = strlen($data['Message']['message']) + strlen($data['Message']['subject']);
                $to_users = explode(',', $data['Message']['to']);
                foreach($to_users as $user_to) {
                    // To find the user id of the user
                    $user = $this->User->find('first', array(
                        'conditions' => array(
                            'User.username' => trim($user_to)
                        ) ,
                        'fields' => array(
                            'User.id',
                            'User.email',
                            'User.username',
                            'User.user_type_id',
                            'UserPermissionPreference.Message-is_allow_send'
                        ) ,
                        'recursive' => 0
                    ));
                    // to check for allowed message sizes
                    $allowed_size = higher_to_bytes(Configure::read('messages.allowed_message_size') , Configure::read('messages.allowed_message_size_unit'));
                    $total_used_size = $this->myUsedSpace();
                    $is_size_ok = (($total_used_size + ($size * 2)) <= $allowed_size) ? true : false;
                    if (!$is_size_ok) {
                        $validation_result['message'] = 'Your Message Box Full, please clean your message box';
                        $validation_result['status'] = false;
                        return $validation_result;
                    }
                    if (empty($user)) {
                        $validation_result['message'] = 'Please give valid username';
                        $validation_result['status'] = false;
                        return $validation_result;
                    } else {
                        // Check for block users
                        if ($this->User->BlockedUser->find('count', array(
                            'conditions' => array(
                                'BlockedUser.user_id' => $user['User']['id'],
                                'BlockedUser.blocked_user_id' => $_SESSION['Auth']['User']['id']
                            )
                        ))) {
                            $validation_result['message'] = $user['User']['username'] . ' has Blocked you';
                            $validation_result['status'] = false;
                            return $validation_result;
                        }
                        if (!empty($user['UserPermissionPreference'])) {
                            if ($user['UserPermissionPreference']['Message-is_allow_send'] == ConstPrivacySetting::Nobody) {
                                $validation_result['message'] = $user['User']['username'] . ' restricted  Your Message';
                                $validation_result['status'] = false;
                                return $validation_result;
                            } else if ($user['UserPermissionPreference']['Message-is_allow_send'] == ConstPrivacySetting::Friends) {
                                if (!$this->UserFriend->find('count', array(
                                    'conditions' => array(
                                        'UserFriend.user_id' => $this->Auth->user('id') ,
                                        'UserFriend.friend_user_id' => $user_id,
                                        'UserFriend.friend_status_id' => ConstUserFriendStatus::Approved
                                    )
                                ))) {
                                    $validation_result['message'] = $user['User']['username'] . ' Friend\'s only Send the message';
                                    $validation_result['status'] = false;
                                    return $validation_result;
                                }
                            } else if ($user['UserPermissionPreference']['Message-is_allow_send'] == ConstPrivacySetting::Users) {
                                if ($user['User']['user_type_id'] != ConstUserTypes::User) {
                                    $validation_result['message'] = 'Member\'s only Send the message';
                                    $validation_result['status'] = false;
                                    return $validation_result;
                                }
                            }
                        }
                    } // else end for if (!empty($user))
                    
                } // foreach
                
            } // else  for if(!empty($data['Message']['to']))
            
        } // end for elseif(isset($data['Message']['send']) && $data['Message']['save'] == 'Send')
        return $validation_result;
    }
}
?>