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
class UserNotificationsController extends AppController
{
    public $name = 'UserNotifications';
    public function edit($user_id = null) 
    {
		$this->pageTitle = __l('My Notifications');
        if (!empty($this->request->data)) {
            if ($this->UserNotification->save($this->request->data)) {
                $this->Session->setFlash(__l('User notification has been updated') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('User notification could not be updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
			$this->request->data = $this->UserNotification->find('first', array(
				'conditions'=>array(
					'UserNotification.user_id' => $user_id
				) ,
				'recursive' => -1
			));
            if (empty($this->request->data)) {
				$this->request->data['UserNotification']['user_id'] = $user_id;
            }
        }
    }
}
?>
