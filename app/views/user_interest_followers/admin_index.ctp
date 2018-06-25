<?php /* SVN: $Id: admin_index.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
	<?php 
		if(!empty($this->request->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<div class="sub-menu-block clearfix">
</div>
 <div class="admin-inner-block">
 <div class="round-5 admin-inner-section">
<div class="UserInterestFollowers index js-responses">

    <?php echo $this->Form->create('UserInterestFollower' , array('class' => 'normal','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<div class="overflow-block">

<?php echo $this->element('paging_counter');?>
<table class="list">
	<tr>
		<th><?php echo __l('User'); ?></th>
		<th><?php echo __l('User Interest'); ?></th>
	</tr>
<?php
if (!empty($userFollowers)):

$i = 0;
foreach ($userFollowers as $UserInterestFollower):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr <?php echo $class;?>>
		<td>
			<?php 
			echo $this->Html->getUserAvatarLink($UserInterestFollower['User'], 'micro_thumb',false);?>
			<?php echo $this->Html->getUserLink($UserInterestFollower['User']);?>
		</td>
		<td>
			<?php echo $this->Html->link($this->Html->cText($UserInterestFollower['UserInterest']['name'],false), array('controller' => 'user_interests', 'action' => 'view', $UserInterestFollower['UserInterest']['slug']), array('title' => $this->Html->cText($UserInterestFollower['UserInterest']['name'],false)));?>
        </td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td class="notice" colspan="9"><?php echo __l('No User Interest Comments available');?></td>
	</tr>
<?php endif; ?>
</table>
</div>
<?php
if (!empty($UserInterestFollowers)) { ?>
          <div class="admin-select-block">
            <div>
                <?php echo __l('Select:'); ?>
                <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
                <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
            </div>
            <div class="admin-checkbox-button"><?php echo $this->Form->input('more_action_id', array('options' => $moreActions, 'class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
        </div>
        <div class="hide">
            <?php echo $this->Form->submit('Submit'); ?>
        </div>
		<div class="js-pagination">
			<?php echo $this->element('paging_links');?>
		</div>
		<?php } ?>
<?php echo $this->Form->end(); ?>
</div>
</div>
</div>