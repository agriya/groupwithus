<?php /* SVN: $Id: admin_index.ctp 54577 2011-05-25 10:39:06Z arovindhan_144at11 $ */ ?>
<div class="sub-menu-block clearfix">
	</div>
 <div class="admin-inner-block">
  <div class="round-5 admin-inner-section">
 <h2><?php echo __l('Pages');?></h2>
<div class="pages index">
<div class="staticpage index">
<div class="admin-inner-top2 clearfix">
<div class="grid_left">
    <?php echo $this->element('paging_counter');?>
</div>
<div class="add-block grid_left clearfix">
    <?php echo $this->Html->link(__l('Add'), array('controller' => 'pages', 'action' => 'add'), array('class' => 'add admin-add','title' => __l('Add'))); ?>
</div>
</div>
<div class="overflow-block">
<table class="list">
    <tr>
        <th><?php echo __l('Action');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('Title'),'title');?></th>
        <th class="dl"><?php echo $this->Paginator->sort(__l('Content'),'content');?></th>
    </tr>
<?php
if (!empty($pages)):

$i = 0;
foreach ($pages as $page):
	$class = null;
	if ($i++ % 2 == 0) :
		$class = ' class="altrow"';
    endif;
?>
	<tr<?php echo $class;?>>
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
						<?php if($page['Page']['slug'] != 'pre-launch'): ?>
							<li><span><?php echo $this->Html->link(__l('View'), array('controller' => 'pages', 'action' => 'view', $page['Page']['slug']), array('class' => 'view', 'title' => __l('View')));?></span></li>
						<?php endif; ?>
						<li><span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $page['Page']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span></li>
						<li><span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $page['Page']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></span></li>
					</ul>
				   </div>
					<div class="action-bottom-block"></div>
				  </div>
			 </div>
		</td>
        <td class="dl">
        <?php echo $this->Html->cText($page['Page']['title']);?></td>
        </td>
		<td class="dl"><?php echo $this->Html->cText($this->Text->truncate($page['Page']['content'], 100, array('ending' => '...')));?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="17" class="notice"><?php echo __l('No Pages available');?></td>
	</tr>
<?php
endif;
?>
</table>
</div>
<?php
if (!empty($pages)) :
    echo $this->element('paging_links');
endif;
?>

</div>
</div>
</div>
</div>
