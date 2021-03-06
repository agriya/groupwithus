<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="userJobs index js-response">
<?php
	if(!empty($this->request->params['isAjax'])):
		echo $this->element('flash_message');
	endif;
?>
<div class="sub-menu-block clearfix">
</div>
<div class="admin-inner-block">
<div class="round-5 admin-inner-section">
         <div class="page-count-block clearfix">
            	<div class="grid_left">
	                <?php echo $this->element('paging_counter'); ?>
	             </div>
            <div class="grid_left">
                <?php
	echo $this->Form->create('UserJob' , array('action' => 'admin_index', 'type' => 'get', 'class' => 'normal search-form clearfix ')); //js-ajax-form
	echo $this->Form->input('UserJob.q', array('label' => __l('Keyword')));
	echo $this->Form->submit(__l('Search'));
	echo $this->Form->end();
?>
                </div>
                   <div class="clearfix grid_right add-block1">
                 <?php echo $this->Html->link(__l('Add'),array('controller'=>'user_jobs','action'=>'add'),array('title' => __l('Add'),	'class' =>'add admin-add'));?>
                  
	              </div>
            </div>
<?php echo $this->Form->create('UserJob' , array('class' => 'normal','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<div class="overflow-block">
<table class="list">
    <tr>
        <th><?php echo __l('Select');?></th>
        <th><?php echo __l('Action');?></th>
        <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('User'), 'User.username');?></div></th>
        <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Company Name'), 'Company.name');?></div></th>
        <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Position'), 'UserJob.position');?></div></th>
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
		<td class="select">
			<?php echo $this->Form->input('UserJob.'.$userJob['UserJob']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userJob['UserJob']['id'], 'class' => ' js-checkbox-list', 'label' => false)); ?>
		</td>
		<td class="actions">
			<div class="action-block">
				<span class="action-information-block">
					<span class="action-left-block">&nbsp;&nbsp;</span>
					<span class="action-center-block">
						<span class="action-info"><?php echo __l('Action');?></span>
					</span>
				</span>
				<div class="action-inner-block">
					<div class="action-inner-left-block">
						<ul class="action-link clearfix">
							<li><span><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $userJob['UserJob']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span></li>
							<li><span><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $userJob['UserJob']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></li>
						</ul>
					</div>
					<div class="action-bottom-block"></div>
				</div>
			</div>
		</td>
		<td class="dl">
		<?php echo $this->Html->getUserAvatarLink($userJob['User'], 'micro_thumb',false);?>
		<?php echo $this->Html->link($this->Html->cText($userJob['User']['username']), array('controller'=> 'users', 'action' => 'view', $userJob['User']['username'],'admin'=> false), array('escape' => false));?></td>
        <td class="dl"><?php echo $this->Html->cText($userJob['Company']['name']);?></td>
        <td class="dl"><?php echo $this->Html->cText($userJob['UserJob']['position']);?></td>
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
	<?php if (!empty($userJobs)) {?>
  <div class="admin-select-block">
            <div>
                <?php echo __l('Select:'); ?>
                <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
                <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
            </div>
            <div class="admin-checkbox-button"><?php echo $this->Form->input('more_action_id', array('options' => $moreActions, 'class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
        </div>
		<div class="js-pagination">
			<?php echo $this->element('paging_links');?>
		</div>
		<div class="hide">
			<?php echo $this->Form->submit(__l('Submit'));  ?>
		</div>
		<?php echo $this->Form->end(); ?>
	<?php }?>
</div>
</div>
</div>