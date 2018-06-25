<?php if($this->Auth->user('user_type_id') == ConstUserTypes::Merchant):?>
   <?php echo $this->element('js_tiny_mce_setting', array('config' => 'sec'));?>
<?php endif; ?>
<?php
$user_setting_id = (!empty($userSettings[0]['UserSetting']['id'])? $userSettings[0]['UserSetting']['id'] : '');
$user_notification_id = (!empty($userNotifications[0]['UserNotification']['id'])? $userNotifications[0]['UserNotification']['id'] : '');
 ?>
	<div class="js-mystuff-tabs">
    <ul class="clearfix">
        <?php if($this->Auth->user('user_type_id') == ConstUserTypes::Merchant):?>
        	<?php $user = $this->Html->getMerchant($this->Auth->user('id')); ?>
            <li><?php echo $this->Html->link(__l('My Account'), array('controller' => 'merchants', 'action' => 'edit', $user['Merchant']['id']), array('title' => 'My Account')); ?></li>
        <?php else: ?>
            <li><?php echo $this->Html->link(__l('My Account'), array('controller' => 'user_profiles', 'action' => 'my_account', $this->Auth->user('id')), array('title' => 'My Account', 'rel' => 'address:/' . __l('My_Account'))); ?></li>
        <?php endif; ?>
        <?php if($this->Auth->sessionValid() && $this->Html->isAllowed($this->Auth->user('user_type_id'))):?>
              <li><?php  echo $this->Html->link(sprintf(__l('My %s'), Configure::read('site.name')), array('controller' => 'item_users', 'action' => 'index'), array('title' => 'My Purchases'));?></li>
              <li><?php echo $this->Html->link(__l('My Transactions'), array('controller' => 'transactions', 'action' => 'index', 'admin' => false), array('title' => 'My Transactions'));?></li>
              <?php if(Configure::read('friend.is_enabled')): ?>
              <li><?php echo $this->Html->link(__l('My Friends'), array('controller' => 'user_friends', 'action' => 'lst', 'admin' => false), array('title' => 'My Friends'));?></li>
               <li><?php echo $this->Html->link(__l('Import Friends'), array('controller' => 'user_friends', 'action' => 'import', 'admin' => false), array('title' => 'Import Friends')); ?></li>
              <?php endif; ?>
        <?php endif; ?>
    </ul>
</div>