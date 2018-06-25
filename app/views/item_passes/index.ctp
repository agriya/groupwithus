<?php /* SVN: $Id: $ */ ?>
<div class="itemPasses index js-response js-responses">
<h2><?php echo __l('Item Passes') . ' - ' . $this->Html->cText($item['Item']['name'],false);?></h2>
<?php echo $this->element('paging_counter');?>
<table class="list">
    <tr>
        <th><div class="js-pagination"><?php echo __l('Actions');?></div></th>
        <th><div class="js-pagination"><?php echo $this->Paginator->sort('pass_code');?></div></th>
		<th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Used?'), 'is_used');?></div></th>
		<th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('System generated?'), 'is_system_generated');?></div></th>
    </tr>
<?php
if (!empty($itemPasses)):

$i = 0;
foreach ($itemPasses as $itemPass):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<?php if(empty($itemPass['ItemPass']['is_used'])):?>
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
							<li><span><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $itemPass['ItemPass']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></li>
						</ul>
					   </div>
						<div class="action-bottom-block"></div>
					  </div>
				 </div>
			</td>
		<?php else: ?>
			<td>-</td>
		<?php endif; ?>
		<td><?php echo $this->Html->cText($itemPass['ItemPass']['pass_code']);?></td>
		<td><?php echo $this->Html->cBool($itemPass['ItemPass']['is_used']);?></td>
		<td><?php echo $this->Html->cBool($itemPass['ItemPass']['is_system_generated']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="6" class="notice"><?php echo __l('No item Passes available');?></td>
	</tr>
<?php
endif;
?>
</table>
	<?php if (!empty($itemPasses)):?>
		<div class="js-pagination">
			<?php echo $this->element('paging_links'); ?>
		</div>    
	<?php endif;?>
</div>