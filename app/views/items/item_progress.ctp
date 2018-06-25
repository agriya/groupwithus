
<?php 
    if(!empty($item) && $item['Item']['min_limit'] > $item['Item']['item_user_count']):
		$pixels = round(($item['Item']['item_user_count']/$item['Item']['min_limit']) * 100);
	?>
		<div class="">
			<?php if($item['Item']['item_user_count'] != 0): ?>
				<span class=""><?php echo $item['Item']['item_user_count'];?></span><?php echo __l('bought'); ?>
			<?php else: ?>
				<span class=""><?php echo __l('Be the first to buy!') ?></span>
			<?php endif; ?>
		</div>
		<div class="">
			<div style="left: <?php echo $pixels; ?>px;" class=""></div>
			<div class=""><div class=""></div>
			<div style="width: <?php echo $pixels; ?>px;" class=""></div>
			</div>
				<span class="">0</span>
				<span class=""><?php echo $item['Item']['min_limit'];?></span>
			</div>
			<p class=""><span class=""><?php echo  $item['Item']['min_limit']-$item['Item']['item_user_count'];?></span> <?php echo __l('more needed to get the item'); ?></p>
	<?php else: ?>
			<div class="item-bought-block">
				<h5 class="item-bought"><span><?php echo $item['Item']['item_user_count'];?></span><?php echo __l('bought'); ?></h5>
				<p class="item-start"><?php echo __l('The item is on!'); ?></p>
				<p class="tipped-info"><?php echo __l('Tipped at ') . $this->Html->cDateTimeHighlight($item['Item']['item_tipped_time']) . __l(' with '). $item['Item']['min_limit'] .__l('  bought'); ?></p>
			</div>
<?php  endif; ?>