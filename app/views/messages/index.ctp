<div class="message-section clearfix">
<div class="clearfix message-section-left grid_5">
<h3 class="mail-header">Mail</h3>
<?php echo $this->element('message_message-left_sidebar', array('config' => 'sec')); ?>
</div>
<div class="messages index message-section-right grid_14">
<?php //echo $this->element('mail-search');?>
<div class="inbox-mgs-block">
<h2 class="title">
<?php
    if ($is_starred == 1) :
    	$folder_type = 'Starred';
    endif;
?>
<?php echo __l('My ') . ' ' .  ucfirst($folder_type) .  ' ' .__l(' Messages');?>
</h2> 
<div class="inbox-msg">
	<p><?php echo __l('You\'ve used');?> <?php echo $size_percentage; ?><?php echo __l('% of your');?> <?php echo Configure::read('messages.allowed_message_size'); ?><?php echo Configure::read('messages.allowed_message_size_unit'); ?> <?php echo __l('message limit');?></p>
	<?php
	if ($size  == Configure::read('messages.allowed_message_size') * 1024 * 1024) :
	?>
		p><?php echo __l('You are exceeding the allowed messages quoto. Please delete some messages from your inbox/sent/trash folders'); ?></p>
	<?php
	endif;
	?>
</div></div>
<?php echo $this->Form->create('Message', array('action' => 'move_to', 'class' => 'normal')); ?>
<?php
$refresh_folder_type = $folder_type;
if ($folder_type == 'draft') $refresh_folder_type = 'drafts';
if ($folder_type == 'sent') $refresh_folder_type = 'sentmail';
echo $this->Form->hidden('folder_type', array('value' => $folder_type, 'name' => 'data[Message][folder_type]'));
echo $this->Form->hidden('is_starred', array('value' => $is_starred, 'name' => 'data[Message][is_starred]'));
echo $this->Form->hidden('label_slug', array('value' => $label_slug, 'name' => 'data[Message][label_slug]'));
?>
<div class="message-block clearfix">
<div class="message-block-left" >
<?php

	echo $this->Form->input('more_action_1', array('type' => 'select',
	        'options' => $mail_options,
	        'label' => false,
	        'class' => 'js-apply-message-action'
	        ));

?>
</div>
<div class="message-block-right">
<?php
	echo $this->Form->submit(__l('Archive'), array('name' => 'data[Message][Archive]'));
	if ($folder_type == 'spam'){
		echo $this->Form->submit(__l('Notspam'), array('name' => 'data[Message][NotSpam]'));
	}else{
		echo $this->Form->submit(__l('Spam'), array('name' => 'data[Message][ReportSpam]'));
	}
	echo $this->Form->submit(__l('Delete'), array('name' => 'data[Message][Delete]'));
?>
</div>
</div>
<div class="inbox-option">
<?php echo __l('Select:'); ?>
<?php echo $this->Html->link(__l('All,'), '#', array('class' => 'js-select-all', 'title' => __l('All'))); ?>
<?php echo $this->Html->link(__l('None,'), '#', array('class' => 'js-select-none', 'title' => __l('None'))); ?>
<?php echo $this->Html->link(__l('Read,'), '#', array('class' => 'js-select-read', 'title' => __l('Read'))); ?>
<?php echo $this->Html->link(__l('Unread'), '#', array('class' => 'js-select-unread', 'title' => __l('Unread'))); ?>
</div>
<table class="list">
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
	$is_starred_class = "star";
	$starred_class= "star-select";
    if ($message['Message']['is_read']) :
        $message_class .= " checkbox-read ";
    else :
        $message_class .= " checkbox-unread ";
        $is_read_class .= "unread-message-bold";
        $row_class=$row_class.' unread-row';
    endif;
if ($message['Message']['is_starred']):
        $message_class .= " checkbox-starred ";
        $is_starred_class = "star-select";
		$starred_class= "star";
    else:
        $message_class .= " checkbox-unstarred ";
    endif;
	$row_class='class="'.$row_class.'"';
	$row_three_class='w-three';
	 if (!empty($message['MessageContent']['Attachment'])):
			$row_three_class.=' has-attachment';
	endif;
if ($folder_type == 'draft'):
	$view_url=array('controller' => 'messages','action' => 'compose',$message['Message']['id'],'draft');
else:
	$view_url=array('controller' => 'messages','action' => 'v',$message['Message']['id']);
endif;

?>
    <tr <?php echo $row_class;?>>
        <td class="w-one">
				<?php echo $this->Form->input("Message.Id." . $message['Message']['id'], array('type' => 'checkbox', 'id' => "Message_" . $message['Message']['id'], 'label' => false, 'class' => $message_class));?>
		</td>
		<td class="w-two <?php  echo $is_read_class;?>">
				<span  class="<?php echo $starred_class;?>">
					<?php echo $this->Html->link(__l('Star') , array('controller' => 'messages', 'action' => 'star', $message['Message']['id'], $is_starred_class) , array('class' => "js-change-star-unstar {'message':'Message has been starred'}"));?>
				</span>
				<span class="user-name-block c1">
                    <?php
                    if ($message['Message']['is_sender'] == 1) :
                        echo $this->Html->link(__l('To: ') . $this->Html->cText($this->Html->truncate($message['OtherUser']['username']), false) , $view_url);
                    elseif ($message['Message']['is_sender'] == 2) :
                        echo $this->Html->link(__l('Me   : ') , $view_url);
                    else:
                        echo $this->Html->link($this->Html->cText($this->Html->truncate($message['OtherUser']['username']), false), $view_url);
                    endif;
                    ?>
				</span>
                <div class="clear"></div>
            </td>
        <td  class=" <?php echo $row_three_class;?>">
              <?php
               if (!empty($message['Label'])):
					?>
					<ul class="message-label-list">
						<?php foreach($message['Label'] as $label): ?>
							<li>
								<?php echo $this->Html->cText($this->Html->truncate($label['name']), false);?>
							</li>
						<?php
						endforeach;
					?>					
					</ul>
					<?php
                endif;
			?>
			<?php 
				echo $this->Html->link($this->Html->truncate($message['MessageContent']['subject'] . ' - ' . substr($message['MessageContent']['message'], 0 ,20)) ,$view_url);?>
        </td>
        <td  class="w-four <?php echo $is_read_class;?>"><?php echo $this->Html->cDateTimeHighlight($message['Message']['created']);?></td>
    </tr>
<?php
    endforeach;
else :
?>
<tr>
    <td><p><?php echo __l('No') ?> <?php echo $folder_type; ?> <?php echo __l('messages available') ?></p><td>
</tr>
<?php
endif;
?>
</table>
<div class="inbox-option">
<?php echo __l('Select:'); ?>
<?php echo $this->Html->link(__l('All,'), '#', array('class' => 'js-select-all', 'title' => __l('All'))); ?>
<?php echo $this->Html->link(__l('None,'), '#', array('class' => 'js-select-none', 'title' => __l('None'))); ?>
<?php echo $this->Html->link(__l('Read,'), '#', array('class' => 'js-select-read', 'title' => __l('Read'))); ?>
<?php echo $this->Html->link(__l('Unread'), '#', array('class' => 'js-select-unread', 'title' => __l('Unread'))); ?>
</div>
<?php
if (!empty($messages)) :
    echo $this->element('paging_links');
endif;
?>
<div class="message-block clearfix">
<div class="message-block-left ">
<?php
echo $this->Form->input('more_action_2', array('type' => 'select',
    'options' => $mail_options,
    'label' => false,
    'class' => 'js-apply-message-action'
    ));
?>
</div>
<div class="message-block-right ">
<?php
echo $this->Form->submit(__l('Archive'), array('name' => 'data[Message][Archive]'));
if ($folder_type == 'spam'){
	echo $this->Form->submit(__l('Notspam'), array('name' => 'data[Message][NotSpam]'));
}else{
	echo $this->Form->submit(__l('Spam'), array('name' => 'data[Message][ReportSpam]'));
}
echo $this->Form->submit(__l('Delete'), array('name' => 'data[Message][Delete]'));
?>
</div>
</div>
<div class="refersh-block">
<?php
if (!empty($label_slug) && $label_slug != 'null') :
    echo $this->Html->link(__l('Refresh') , array('controller' => 'messages',
            'action' => 'label',
            $label_slug
            ),array('class' => 'refresh', 'title' => __l('Refresh')));
 elseif (!empty($is_starred)) :
    echo $this->Html->link(__l('Refresh') , array('controller' => 'messages',
            'action' => 'starred'
            ),array('class' => 'refresh', 'title' => __l('Refresh')));
 else:
    echo $this->Html->link(__l('Refresh') , array('controller' => 'messages',
            'action' => $refresh_folder_type
            ),array('class' => 'refresh', 'title' => __l('Refresh')));
endif;
?>
</div>

<?php echo $this->Form->end();?>
</div>
</div>