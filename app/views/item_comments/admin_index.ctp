<?php /* SVN: $Id: admin_index.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
	<?php 
		if(!empty($this->request->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<div class="sub-menu-block clearfix">
</div>
<div class="admin-inner-block">
<h2><?php echo __l('Item Comments');?></h2>
<div class="round-5 admin-inner-section">
<div class="ItemComments index js-responses">
<div class="admin-top-inner-block clearfix">
</div>
    <?php echo $this->Form->create('ItemComment' , array('class' => 'normal js-ajax-form','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<?php echo $this->element('paging_counter');?>
<table class="list">
	<tr>
		<th><?php echo __l('Select'); ?></th>
		<th><?php echo __l('Actions');?></th>
		<th><?php echo __l('Item'); ?></th>
		<th><?php echo __l('Commented User'); ?></th>
		<th><?php echo __l('Comments'); ?></th>
		<th><?php echo __l('Date'); ?></th>
	</tr>
<?php
if (!empty($ItemComments)):

$i = 0;
foreach ($ItemComments as $ItemComment):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr <?php echo $class;?>>
		<td>
		<?php echo $this->Form->input('ItemComment.' . $ItemComment['ItemComment']['id'] . '.id', array('type' => 'checkbox', 'id' => 'admin_checkbox_' . $ItemComment['ItemComment']['id'], 'class' => 'js-checkbox-list', 'label' => false)); ?>
		</td>
		<td>
            <div class="actions-block">
		<div class="actions round-5-left">
        <span><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $ItemComment['ItemComment']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span>
        <span><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $ItemComment['ItemComment']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span>
		</div>
		</div>
		</td>
		<td>
        <span><?php echo $this->Html->link($this->Html->cText($ItemComment['Item']['name'],false), array('controller' => 'items', 'action' => 'view', $ItemComment['Item']['slug'], 'admin' => false), array('title'=>$this->Html->cText($ItemComment['Item']['name'],false),'escape' => false));?></span></td>
		<td><?php echo $this->Html->getUserLink($ItemComment['PostedUser']);?></td>
		<td class=""><?php echo $this->Html->cText($ItemComment['ItemComment']['comment']);?></td>
		<td><?php echo $this->Html->cDateTime($ItemComment['ItemComment']['created']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td class="notice" colspan="9"><?php echo __l('No item Comments available');?></td>
	</tr>
<?php endif; ?>
</table>
<?php
if (!empty($ItemComments)) { ?>
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
 <?php   echo $this->element('paging_links'); }?>
<?php echo $this->Form->end(); ?>
</div>
</div>
</div>