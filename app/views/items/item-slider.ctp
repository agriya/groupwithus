
<?php if (!empty($items)): ?>
<div class="sliders-block item-slider-block">
<div class ='js-response'>
  <h3 class="ribbon-title clearfix"><span class="ribbon-left"><span class="ribbon-right"><span class="ribbon-inner">
  <?php if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='all_item'):  ?>
  <?php echo __l('Check out these other items'); ?>
  <?php else: ?>
    <?php echo __l('Check out these past items'); ?>
<?php endif; ?>
  </span></span></span></h3>
	<ol class="items-list-scroller clearfix gallery" id="mycarousel">
				<?php
if (!empty($items)):
$i = 0;
foreach ($items as $item):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
<li>

						<p><?php echo $this->Html->cDateTime($item['Item']['event_date']); ?></p>
					   <?php  echo $this->Html->link($this->Html->showImage('Item', $item['Attachment'][0], array('dimension' => 'small_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($item['Item']['name'], false)), 'title' => $this->Html->cText($item['Item']['name'], false))),array('controller' => 'items', 'action' => 'view', $item['Item']['slug']),array('title'=>$item['Item']['name'],'escape' =>false));?>
                       <h4><?php echo $this->Html->link($this->Html->cText($item['Item']['name'],false), array('controller' => 'items', 'action' => 'view', $item['Item']['slug']),array('title' =>sprintf(__l('%s'),$item['Item']['name'])));?></h4>
					   <p class="subtitle"><?php echo $this->Html->cText($item['Merchant']['name'],false); ?></p>
					   <?php if(!empty($item['ItemUser'])): ?>
					   <ol class="user-list clearfix">
					     <?php
						 $dimension="micro_thumb";
						 foreach ($item['ItemUser'] as $ItemUser):  ?>
					     <li> <?php echo $this->Html->getUserAvatarLink($ItemUser['User'], $dimension,true);?></li>
						<?php endforeach; ?>
						<?php if(count($item['ItemUser'])<6): 
	if($item['Item']['max_limit'] > 1): 
	$no_of_seat = $this->Html->cInt($item['Item']['max_limit'] - $item['Item']['item_user_count'],false);
	?>
		  <li class="more-users">
			<?php echo $this->Html->link(__l('+').$no_of_seat,array('controller' => 'items', 'action' => 'view', $item['Item']['slug']), array('title' => __l('+').$no_of_seat)); ?><?php echo __l(' MORE'); ?>
		  </li>
  <?php endif; ?>
  <?php endif; ?>
   </ol>			  
 <?php endif; ?>

						  </li>
					<?php
			endforeach;
		else:
		?>
			<li>
				<p class="notice"><?php echo __l('No items available');?></p>
			</li>
		<?php
		endif;
		?>
                </ol>
</div>
</div>
<?php endif; ?>
