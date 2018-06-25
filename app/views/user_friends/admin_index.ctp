<?php /* SVN: $Id: admin_index.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
	<?php 
		if(!empty($this->request->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<div class="userFriends index js-response">
<?php echo $this->Form->create('UserFriend', array('type' => 'get', 'class' => 'normal', 'action'=>'index')); ?>
	<div class="filter-section">
		<div>
			<?php echo $this->Form->autocomplete('User.username', array('label' => __l('User'), 'acFieldKey' => 'UserFriend.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));?>
			<?php echo $this->Form->autocomplete('FriendUser.username', array('label' => __l('Friend User'), 'acFieldKey' => 'UserFriend.friend_user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));?>
            <?php echo $this->Form->input('filter_id',array('label' => __l('Filter'),'empty' => __l('Please Select'))); ?>
            <?php echo $this->Form->input('q', array('label' =>__l('Keyword'))); ?>
        </div>
		<div>
			<?php echo $this->Form->submit(__l('Search'));?>
		</div>
	</div>
<?php echo $this->Form->end(); ?>
<?php 
	echo $this->Form->create('UserFriend' , array('class' => 'normal','action' => 'update'));
	echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url));
	
?>
<?php echo $this->element('paging_counter');?>
<table class="list">
    <tr>
    	<th><?php echo __l('Select'); ?></th>
        <th><?php echo __l('actions'); ?></th>
        <th><?php echo $this->Paginator->sort(__l('User'), 'User.username');?></th>
        <th><?php echo $this->Paginator->sort(__l('Friend User'), 'FriendUser.username');?></th>
        <th><?php echo __l('Friends Status');?></th>
        <th><?php echo __l('Request');?></th>
    </tr>
<?php
if (!empty($userFriends)):

$i = 0;
foreach ($userFriends as $userFriend):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
	  	<td class="select">
            <?php echo $this->Form->input('UserFriend.'.$userFriend['UserFriend']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userFriend['UserFriend']['id'], 'label' => false, 'class' => ' js-checkbox-list')); ?>
		</td>
	      <td class="actions">
                      <div class="action-block">
                        <span class="action-information-block">
                            <span class="action-left-block">&nbsp;
                            </span>
                                <span class="action-center-block">
                                    <span class="action-info">
                                        <?php echo __l('Action');?>
                                     </span>
                                </span>
                            </span>
                            <div class="action-inner-block">
                            <div class="action-inner-left-block">
                                <ul class="action-link clearfix">
                                	<li> <span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $userFriend['UserFriend']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span> </li>
						       
        						</ul>
        					   </div>
        						<div class="action-bottom-block"></div>
							  </div>
						 </div>
  					</td>
		
		<td><?php echo $this->Html->getUserLink($userFriend['User']);?></td>
		<td><?php echo $this->Html->getUserLink($userFriend['FriendUser']);?></td>
		<td><?php echo $this->Html->cText($userFriend['FriendStatus']['name']);?></td>
		<td><?php echo $this->Html->cBool($userFriend['UserFriend']['is_requested']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="8" class="notice"><?php echo __l('No User Friends available');?></td>
	</tr>
<?php
endif;
?>
</table>
<?php
if (!empty($userFriends)):
?>
	<div>
		<?php echo __l('Select:'); ?>
		<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
		<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
	</div>
	<div class="js-pagination">
        <?php echo $this->element('paging_links'); ?>
    </div>
	<div class="admin-checkbox-button"><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
    <div class="hide">
	    <?php echo $this->Form->submit('Submit'); ?>
    </div>
<?php
endif;
echo $this->Form->end();
?>
</div>
