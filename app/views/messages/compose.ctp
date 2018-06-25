<div class="message-section clearfix">
<div class="clearfix message-section-left grid_5">
 <?php echo $this->element('message_message-left_sidebar',array('config' => 'sec')); ?>
 </div>
<div class="messages index message-section-right grid_14">
<h2 class="title"><?php echo __l('Compose') ?></h2>
<?php // echo $this->element('mail-search'); ?>
<?php echo $this->Form->create('Message', array('action' => 'compose', 'class' => 'compose normal', 'enctype' => 'multipart/form-data')); ?>
<?php
	if (!empty($all_parents)) :
    	foreach($all_parents as $parent_message) : ?>
			<h1><?php echo $this->Html->cText($parent_message['OtherUser']['username']); ?></h1>
			<p><?php echo __l('to me'); ?></p>
            <p><?php echo $this->Html->cText($parent_message['MessageContent']['message']); ?></p>
            <?php
        endforeach;
    endif;
?>
<div class="compose-block clearfix">
<div class="message-block-right" >
 <?php echo $this->Form->submit(__l('Send'), array('class' => 'js-without-subject', 'name' => 'data[Message][send]')); ?>
 <?php echo $this->Form->submit(__l('Save'), array('value' => 'draft', 'name' => 'data[Message][save]')); ?>
 <div class="compose-link cancel-block"><?php echo $this->Html->link(__l('Discard') , array('controller' => 'messages', 'action' => 'inbox') , array('class' => 'js-compose-delete compose-delete','title' => __l('Discard')) , null, false); ?></div>
  <div class="compose-link cancel-block">
 <?php echo $this->Html->link(__l('Cancel'), array('controller' => 'messages', 'action' => 'inbox') , array('title' => __l('Cancel'))); ?>
 </div></div>
 </div>
 <div class="compose-box">
	<fieldset>
			<?php
				echo $this->Form->autocomplete('to', array('type' => 'text', 'id' => 'message-to', 'acFieldKey' => 'User.id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));
				echo $this->Form->input('parent_message_id', array('type' => 'hidden'));
				echo $this->Form->input('type', array('type' => 'hidden'));
			?>
			<?php
				echo $this->Form->input('subject', array('id' => 'MessSubject', 'maxlength' => '100', 'label'=>__l('Subject')));
            ?>
            <div class="atachment">
			<?php echo $this->Form->input('Attachment.filename. ', array('type' => 'file', 'label' => '','size' => '33', 'class' => 'multi file attachment browse-field')); ?>
			</div>
			<p class="more-attachment clearfix"><?php echo $this->Html->link(__l('Add more attachment'),array('#'),array('class'=>'add js-attachmant','title' => __l('Add more attachment')));?></p>
			<div class="js-attachment-list">
				<?php 
					if(!empty($parent_message['MessageContent']['Attachment'])) {
				?>
						 <ol class="clearfix attachment-list">
				<?php
						foreach($parent_message['MessageContent']['Attachment'] as $attachment) {
				?>
						<li>
							<div class="js-old-attachmant-div-<?php echo $attachment['id']; ?>">
							<?php 
								echo $attachment['filename'];
								echo $this->Form->input('OldAttachment.'.$attachment['id'].'.id', array('type' => 'hidden'));
								echo $this->Html->link(__l('Remove attachment'), array('#'), array('class'=>'delete js-old-attachmant {"id" : "'.$attachment['id'].'"}','title' => __l('Remove attachment')));
							?>
							</div>
						</li>
				<?php
						}
				?>
						</ol>
				<?php
					}
				?>
			</div>

			<?php
			if(!empty($this->params['named']['project_id'])):
				echo $this->Form->input('project_id', array('type' => 'hidden','value'=>$this->params['named']['project_id']));
			endif;
			echo $this->Form->input('message', array('type' => 'textarea', 'label' => 'Message'));
			 echo $this->Form->input('message_content_id', array('type' => 'hidden')); ?>
	</fieldset>
    </ol>
</div>
<div class="compose-block clearfix">
<div class="message-block-right" >
	<?php echo $this->Form->submit(__l('Send'), array('class' => 'js-without-subject')); ?>
	<?php echo $this->Form->submit(__l('Save'), array('value' => 'draft', 'name' => 'data[Message][save]')); ?>
	<div class="compose-link cancel-block"><?php echo $this->Html->link(__l('Discard') , array('controller' => 'messages', 'action' => 'inbox') , array('class' => 'js-compose-delete compose-delete','title' => __l('Discard')) , null, false); ?></div>
    <div class="compose-link cancel-block"><?php echo $this->Html->link(__l('Cancel'), array('controller' => 'messages', 'action' => 'inbox') , array('title' => __l('Cancel'))); ?>
</div></div>
</div>
<?php echo $this->Form->end(); ?>
</div>
</div>