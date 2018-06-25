<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php
	if(!empty($this->request->params['isAjax'])): ?>
	<div class="js-flash-message flash-message-block">
	<?php
		echo $this->element('flash_message'); ?>
	</div>
	<?php 
	endif;
?>
<div class="userJobs index js-response js-response-main">
<h2 class="ribbon-title clearfix"><span class="ribbon-left"><span class="ribbon-right"><span class="ribbon-inner"><?php echo __l('User Jobs');?></span></span></span></h2>
<?php if($this->Auth->user('id')): ?>
	<div class="add-block">
		<?php echo $this->Html->link(__l('Add'),array('controller'=>'user_jobs','action'=>'add',$this->Auth->user('id')),array('title' => __l('Add'),	'class' =>'add js-add {"responseconatiner":"js-response-main"}'));?>
	</div>
<?php endif; ?>
<?php echo $this->Form->create('UserJob' , array('class' => 'normal','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<div class="overflow-block">
<table class="list">
    <tr>
        <th><?php echo __l('Select');?></th>
        <th><?php echo __l('Action');?></th>
        <th class="dl"><div class="js-pagination"><?php echo __l('Company Name');?></div></th>
        <th><div class="js-pagination"><?php echo __l('Position');?></div></th>
    </tr>
<?php
if (!empty($userJobs)):

$i = 0;
foreach ($userJobs as $userJob):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Form->input('UserJob.'.$userJob['UserJob']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userJob['UserJob']['id'], 'class' => ' js-checkbox-list', 'label' => false)); ?>
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
						<li><span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $userJob['UserJob']['id']), array('class' => 'edit js-edit  {"responseconatiner":"js-response-main"}', 'title' => __l('Edit')));?></span></li>
						<li><span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $userJob['UserJob']['id'],$userJob['UserJob']['user_id']), array('class' => 'delete js-delete  {"responseconatiner":"js-response-main"}', 'title' => __l('Delete')));?></span></li>
					</ul>
				   </div>
					<div class="action-bottom-block"></div>
				  </div>
			 </div>
		</td>
        <td class="dl"><?php echo $this->Html->cText($userJob['Company']['name']);?></td>
        <td><?php echo $this->Html->cText($userJob['UserJob']['position']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="7" class="notice"><?php echo __l('No User Jobs available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<div class="admin-select-block user-select-block">
            <div class="select-section">
                <?php echo __l('Select:'); ?>
                <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
                <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
            </div>
            <div class="admin-checkbox-button"><?php echo $this->Form->input('more_action_id', array('options' => $moreActions, 'class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
</div>
	<?php if (!empty($userJobs)) {?>

		
		<div class="hide">
			<?php echo $this->Form->submit(__l('Submit'));  ?>
		</div>
	<?php }?>
	<?php echo $this->Form->end(); ?>
</div>