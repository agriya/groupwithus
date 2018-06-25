<?php /* SVN: $Id: $ */ ?>
<?php 
		if(!empty($this->request->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
<div class="itemCategories index js-response js-responses">
	<div class="page-count-block clearfix">
		<div class="grid_left">
			<?php echo $this->element('paging_counter'); ?>
		</div>
		<div class="grid_left">
			<?php echo $this->Form->create('ItemCategory' , array('type' => 'get', 'class' => 'normal search-form clearfix','action' => 'index')); ?>
			<?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>
			<?php echo $this->Form->submit(__l('Search'));?>
			<?php echo $this->Form->end(); ?>
		</div>
		<div class="clearfix grid_right add-block1">
			<?php echo $this->Html->link(__l('Add'),array('controller'=>'item_categories','action'=>'add'),array('class' => 'add admin-add', 'title' => __l('Add Category')));?>
		</div>
	</div>
    <?php echo $this->Form->create('ItemCategory' , array('class' => 'normal js-ajax-form','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<table class="list">
    <tr>
        <th><?php echo __l('Select'); ?></th>
        <th><?php echo __l('Actions');?></th>
        <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort('name');?></div></th>
		<th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Added On'),'created');?></div></th>
    </tr>
<?php
if (!empty($itemCategories)):

$i = 0;
foreach ($itemCategories as $itemCategory):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td class="select">
			<?php echo $this->Form->input('ItemCategory.'.$itemCategory['ItemCategory']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$itemCategory['ItemCategory']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?>
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
							<li><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $itemCategory['ItemCategory']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></li>
							<li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $itemCategory['ItemCategory']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
						</ul>
					</div>
					<div class="action-bottom-block"></div>
				</div>
			</div>
		</td>
		<td class="dl"><?php echo $this->Html->cText($itemCategory['ItemCategory']['name']);?></td>
		<td><?php echo $this->Html->cDateTimeHighlight($itemCategory['ItemCategory']['created']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="5" class="notice"><?php echo __l('No item Categories available');?></td>
	</tr>
<?php
endif;
?>
</table>

<?php
if (!empty($itemCategories)):
    ?>
	<div class="admin-select-block">
        <div>
            <?php echo __l('Select:'); ?>
            <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
            <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
        </div>
         <div class="admin-checkbox-button">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
        </div>
         <div class="js-pagination">
            <?php echo $this->element('paging_links'); ?>
        </div>
        <div class = "hide">
            <?php echo $this->Form->submit('Submit');  ?>
        </div>
        <?php
    echo $this->Form->end();
endif;
?>
</div>
</div>
</div>