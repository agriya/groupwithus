<div class="sub-menu-block clearfix">
</div>
<div class="admin-inner-block">
<div class="round-5 admin-inner-section">
<div class="messages index js-response js-responses">
	<div class="page-count-block clearfix">
		<div class="grid_left">
			<?php echo $this->element('paging_counter'); ?>
		</div>
		<div class="grid_left">
			<?php
				echo $this->Form->create('Message' , array('action' => 'admin_index', 'type' => 'post', 'class' => 'normal search-form clearfix ')); //js-ajax-form
				echo $this->Form->input('filter_id', array('type' =>'hidden'));
				echo $this->Form->autocomplete('Message.username', array('label' => __l('From'), 'acFieldKey' => 'Message.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));
				echo $this->Form->autocomplete('Message.other_username', array('label' => __l('To'), 'acFieldKey' => 'Message.other_user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));
				echo $this->Form->submit(__l('Filter'));
				echo $this->Form->end();
			?>
		</div>
	</div>
<?php echo $this->Form->create('Message' , array('class' => 'normal','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => !empty($this->request->params['url']['url'])?$this->request->params['url']['url']:'')); ?>
<table class="list">
<tr>
	<th><?php echo __l('Select');?></th>
	<th><?php echo __l('Action');?></th>
	<th class="dl"><?php echo __l('Subject'); ?></th>
	<th class="dl"><?php echo __l('From'); ?></th>
	<th class="dl"><?php echo __l('To'); ?></th>
	<th><?php echo __l('Date'); ?></th>
</tr>
<?php
if (!empty($messages)) :
$i = 0;
foreach($messages as $message):
   // if empty subject, showing with (no suject) as subject as like in gmail
    if (!$message['MessageContent']['subject']) :
		$message['MessageContent']['subject'] = '(no subject)';
    endif;
	if ($i++ % 2 == 0) :
		$row_class = 'row';
	else :
		$row_class = 'altrow';
    endif;
	
	$message_class = "checkbox-message ";
	
	$is_read_class = "";
	
    if ($message['Message']['is_read']) :
        $message_class .= "js-checkbox-active";
    else :
        $message_class .= "js-checkbox-inactive";
        $is_read_class .= "unread-message-bold";
        $row_class=$row_class.' unread-row';
    endif;
	$row_class='class="'.$row_class.'"';

	$row_three_class='w-three';
	 if (!empty($message['MessageContent']['Attachment'])):
			$row_three_class.=' has-attachment';
	endif;
	
	if($message['MessageContent']['admin_suspend']):
		$message_class.= ' js-checkbox-suspended';
	else:
		$message_class.= ' js-checkbox-unsuspended';
	endif;
	if($message['MessageContent']['is_system_flagged']):
		$message_class.= ' js-checkbox-flagged';
	else:
		$message_class.= ' js-checkbox-unflagged';
	endif;
	
		$view_url=array('controller' => 'messages','action' => 'v',$message['Message']['id'], 'admin' => false);
?>
    <tr <?php echo $row_class;?>>

		<td class="select">
				<?php echo $this->Form->input('Message.'.$message['Message']['id'], array('type' => 'checkbox', 'id' => 'admin_checkbox_'.$message['Message']['id'], 'label' => false, 'class' => $message_class.' js-checkbox-list'));?>
		</td>
		<td class="actions">
			<div class="action-block">
				<span class="action-information-block">
					<span class="action-left-block">&nbsp;</span>
					<span class="action-center-block">
						<span class="action-info">
							<?php echo __l('Action');?>
						 </span>
					</span>
				</span>
				<div class="action-inner-block">
					<div class="action-inner-left-block">
						<ul class="action-link clearfix">
							<li><?php echo $this->Html->link(__l('Delete'), array('action'=>'admin_updatestatus', $message['MessageContent']['id'], 'flag' => 'delete'), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
						</ul>
					</div>
					<div class="action-bottom-block"></div>
				</div>
			</div>
		</td>
         <td  class="dl <?php echo $row_three_class;?>">
             <?php
               if (!empty($message['Label'])):
					?>
					<ul class="message-label-list">
						<?php foreach($message['Label'] as $label): ?>
							<li>
								<?php echo $this->Html->cText($this->Html->truncate($label['name'],35,array('ending' => '...','exact' => false)), false);?>
							</li>
						<?php
						endforeach;
					?>					
					</ul>
					<?php
                endif;
			?>
					<?php echo $this->Html->link($this->Html->truncate($message['MessageContent']['subject'] . ' - ' . substr($message['MessageContent']['message'], 0, 50)) ,$view_url);?>
						<?php
			if($message['MessageContent']['admin_suspend']):
					echo '<span class="suspended">'.__l('Admin Suspended').'</span>';
				endif;
				if($message['MessageContent']['is_system_flagged']):
					echo '<span class="system-flagged">'.__l('System Flagged').'</span>';
				endif;
			?>
        </td>
	    <td class="dl w-two <?php  echo $is_read_class;?>">
				<span class="user-name-block c1">
					<?php echo $this->Html->link($this->Html->cText($message['User']['username']), array('controller' => 'users', 'action' => 'view', $message['User']['username'], 'admin' => false), array('title' => $message['User']['username'], 'escape' => false));?>
				</span>
                <div class="clear"></div>
            </td>
			        <td class="dl w-two <?php  echo $is_read_class;?>">
				<span class="user-name-block c1">
					<?php echo $this->Html->link($this->Html->cText($message['OtherUser']['username']), array('controller' => 'users', 'action' => 'view', $message['OtherUser']['username'], 'admin' => false), array('title' => $message['OtherUser']['username'], 'escape' => false));?>
				</span>
                <div class="clear"></div>
            </td>

        <td  class="w-four <?php echo $is_read_class;?>"><?php echo $this->Html->cDateTimeHighlight($message['Message']['created']);?></td>
    </tr>
<?php
    endforeach;
else :
?>
<tr>
    <td colspan="8"><p class="notice"><?php echo __l('No messages available') ?></p></td>
</tr>
<?php
endif;
?>
</table>
<?php
if (!empty($messages)):
        ?>
        <div class="admin-select-block">
        <div>
			<?php echo __l('Select:'); ?>
			<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
        </div>
        
        <div class="admin-checkbox-button">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
        </div>
        <div class="js-pagination">
            <?php echo $this->element('paging_links'); ?>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit('Submit');  ?>
        </div>
        <?php
    endif;
    echo $this->Form->end();
    ?>
</div>
</div>
</div>