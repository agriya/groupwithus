<ol class="user-list clearfix">
	<?php
		if ($this->request->params['named']['item_type'] == "all_item") {
			$dimension="reataurent_user_medium_thumb";
		} else {
			$dimension="reataurent_user_small_thumb";
		}
		if ($itemUsers) {
			foreach ($itemUsers as $ItemUser):
		if (!empty($ItemUser['Item']['slug'])) {
			$url = Router::url(array('controller' => 'items', 'action' => 'view', $ItemUser['Item']['slug']), true);
		}
			$item_count= $ItemUser['Item']['item_user_count'];
	?>
	<li><?php echo $this->Html->getUserAvatarLink($ItemUser['User'], $dimension,true);?></li>
	<?php
			endforeach;
	?>
	<?php 
		if ($item_count < 4) {
			for ($i = $item_count+1; $i < $item_count+2; $i++) {
				$price = $ItemUser['Item']['price'];
				if ($ItemUser['Item']['is_be_next']) {
					$price = $price + ($item_count *$ItemUser['Item']['be_next_increase_price']);
				}
				$class = '';
				if ($i == $item_count+1) {
					$class = 'current';
				}
				$title = !empty($be_next_increase_price) ? __l('Price up by ') . Configure::read('site.currency') . $be_next_increase_price : Configure::read('site.currency') . $price;
	?>
	<li><a class="seat-place-link <?php echo $class; ?>" href="<?php echo $url; ?>" title="<?php echo $title;?>"> <span class="seat-text"><?php echo $this->Html->ordinal($i).__l(' Seat'); ?></span> <span class="seat-price"><?php echo configure::read('site.currency').$this->Html->cCurrency($price,false); ?></span> </a></li>
	<?php 
			}
		} elseif ($item_count == 4) {
			if($ItemUser['Item']['max_limit'] > 1): 
				$no_of_seat = $this->Html->cInt($ItemUser['Item']['max_limit'] - $item_count, false);
	?>
	<li><?php echo $this->Html->link(__l('+').$no_of_seat,array('controller' => 'items', 'action' => 'view', $item_slug), array('title' => __l('+').$no_of_seat,'class'=>'more')); ?><?php echo __l('More'); ?></li>
  <?php 
			endif;
		}
	} else {
		$item_user_count=1;
		$price=$item['Item']['price'];
		$url = Router::url(array('controller' => 'items', 'action' => 'view', $item['Item']['slug']), true);
		for ($i = 1; $i < 3; $i++) {
			if ($item['Item']['is_be_next']) {
				$price = $price + ($item_user_count * $item['Item']['be_next_increase_price']);
			}
			$class = '';
			if ($i == 1) {
				$class = 'current';
			}
			$title = !empty($item['Item']['be_next_increase_price']) ? __l('Price up by ') . Configure::read('site.currency') . $item['Item']['be_next_increase_price'] : Configure::read('site.currency') . $price;
	?>
	<li> <a class="seat-place-link <?php echo $class; ?>" href="<?php echo $url; ?>" title="<?php echo $title; ?>"> <span class="seat-text"><?php echo $this->Html->ordinal($i).__l(' Seat'); ?></span> <span class="seat-price"><?php echo configure::read('site.currency').$this->Html->cCurrency($price); ?></span> </a></li>
	<?php
		$item_user_count++;
		}
	}
	?>
</ol>