<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="userInterests index js-response js-search-responses">
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
	echo $this->Form->create('UserInterest' , array('action' => 'admin_index', 'type' => 'get', 'class' => 'normal search-form clearfix  {"container" : "js-search-responses"}')); //js-ajax-form
	echo $this->Form->input('q', array('label' => __l('Keyword')));
	echo $this->Form->submit(__l('Search'));
	echo $this->Form->end();
?>
                </div>
                   <div class="clearfix grid_right add-block1">
                 <?php echo $this->Html->link(__l('Add'),array('controller'=>'user_interests','action'=>'add'),array('title' => __l('Add'),	'class' =>'add admin-add'));?>
                  
	              </div>
            </div>

<?php echo $this->Form->create('UserInterest' , array('class' => 'normal','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<div class="overflow-block">
<table class="list">
    <tr>
        <th><?php echo __l('Select');?></th>
        <th><?php echo __l('Action');?></th>
        <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Interests'), 'UserInterest.name');?></div></th>
        <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Followers count'), 'UserInterest.user_interest_follower_count');?></div></th>
        <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Comments count'), 'UserInterest.user_interest_comment_count');?></div></th>
    </tr>
<?php
if (!empty($userInterests)):

$i = 0;
foreach ($userInterests as $userInterest):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
         <td class="select">
			<?php echo $this->Form->input('UserInterest.'.$userInterest['UserInterest']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userInterest['UserInterest']['id'], 'class' => ' js-checkbox-list', 'label' => false)); ?>
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
						<li><span><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $userInterest['UserInterest']['id']), array('class' => 'delete js-edit', 'title' => __l('Edit')));?></span></li>
							<li><span><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $userInterest['UserInterest']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></li>
						</ul>
					</div>
					<div class="action-bottom-block"></div>
				</div>
			</div>
		</td>
        <td class="dl"><?php echo $this->Html->cText($userInterest['UserInterest']['name'],false);?></td>
        <td class="dc"><?php echo $this->Html->link($this->Html->cInt($userInterest['UserInterest']['user_interest_follower_count'],false),array('controller'=>'user_interest_followers','action'=>'index','id'=>$userInterest['UserInterest']['id']),array('title' =>  $this->Html->cInt($userInterest['UserInterest']['user_interest_follower_count'],false),	'class' =>'admin-add'));?></td>
        <td class="dc"><?php echo $this->Html->link($this->Html->cInt($userInterest['UserInterest']['user_interest_comment_count'],false),array('controller'=>'user_interest_comments','action'=>'index','id'=>$userInterest['UserInterest']['id']),array('title' =>  $this->Html->cInt($userInterest['UserInterest']['user_interest_comment_count'],false),	'class' =>'admin-add'));?>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="7" class="notice"><?php echo __l('No User Interests available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
	<?php if (!empty($userInterests)) {?>
<div class="clearfix select-block-bot">
        <div class="admin-select-block grid_left">
        	<div>
        		<?php echo __l('Select:'); ?>
        		<?php echo $this->Html->link(__l('All'), '#', array('class' => 'select js-admin-select-all', 'title' => __l('All'))); ?>
                <?php echo $this->Html->link(__l('None'), '#', array('class' => 'select js-admin-select-none', 'title' => __l('None'))); ?>
            </div>

        <div class="admin-checkbox-button"><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
        </div>
        <div class="js-pagination"><?php
if (!empty($userInterests)) {
    echo $this->element('paging_links');
}
?></div>
</div>
		<div class="hide">
			<?php echo $this->Form->submit(__l('Submit'));  ?>
		</div>
		<?php echo $this->Form->end(); ?>
	<?php }?>
</div>
</div>
</div>