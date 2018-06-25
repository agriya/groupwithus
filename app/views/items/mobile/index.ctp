<?php if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='past') : ?>
<h2 class="ribbon-title clearfix">
<span class="ribbon-left">
	<span class="ribbon-right">
	<span class="ribbon-inner"><?php echo __('Past Items'); ?></span>
</span>
</span>
</h2>
<?php endif; ?>
<?php if (Configure::read('item.is_enable_item_category')): ?>
	<div class="filter-block clearfix">
		<span><?php echo __l('Filter By:');?></span>
		<?php echo $this->element('item_categories-index', array('category' => (!empty($this->request->params['named']['category']) ? $this->request->params['named']['category'] : ''))); ?>
	</div>
<?php endif; ?>
<div class="js-response">
	<?php $count = 1; ?>	
	<div class="merchant-block">
		<ol class="merchant-list">
			<?php
				if(!empty($items)):
					$display_date ='';
					foreach($items as $item):
			?>
			<li class="clearfix">
				<div class="merchant-img grid_4 alpha omega">
					<?php  echo $this->Html->link($this->Html->showImage('Item', $item['Attachment'][0], array('dimension' => 'normal_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($item['Item']['name'], false)), 'title' => $this->Html->cText($item['Item']['name'], false))),array('controller' => 'items', 'action' => 'view', $item['Item']['slug']),array('title'=>$item['Item']['name'],'escape' =>false));?>
				</div>
				<div class="merchant-user grid_10 alpha omega">
					<?php if(!empty($item['Merchant']['name'])){?>
						<?php if(!$item['Merchant']['is_merchant_profile_enabled']) : ?>
						<h2><?php echo $this->Html->link($item['Item']['name'], array('controller' => 'items', 'action' => 'view', $item['Item']['slug']),array('title' =>sprintf(__l('%s'),$item['Item']['name']))) . '<span> (' .$item['Merchant']['name'] . ')</span> ';?></h2>
						<?php else: ?>
						<h2><?php echo $this->Html->link($item['Item']['name'], array('controller' => 'items', 'action' => 'view', $item['Item']['slug']),array('title' =>sprintf(__l('%s'),$item['Item']['name']))) . ' <span>(' .$this->Html->link($item['Merchant']['name'],array('controller' => 'merchants', 'action' => 'view',$item['Merchant']['slug'], $item['Item']['slug']),array('title'=>$item['Merchant']['name'],'escape' =>false)) . ') </span>';?></h2>
						<?php endif; ?>
						<?php if(!empty($item['UserInterest'])): ?>
							<ul class="merchant-namelist clearfix">
								<?php foreach($item['UserInterest'] as $user_interest):?>
									<li><?php echo $this->Html->link($this->Html->cText($user_interest['name'], false),array('controller' => 'user_interest', 'action' => 'view', $user_interest['slug']), array('title' => $this->Html->cText($user_interest['name'], false), 'escape' => false));?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						<?php if(Configure::read('item.is_enable_item_category') && !empty($item['ItemCategory'])): ?>
							<ul class="merchant-namelist clearfix">
								<?php foreach($item['ItemCategory'] as $item_category):?>
									<li><?php echo $this->Html->link($this->Html->cText($item_category['name'], false),array('controller' => 'items', 'action' => 'index', 'category' => $item_category['slug'], 'admin' => false), array('title' => $this->Html->cText($item_category['name'], false), 'escape' => false));?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					<?php } ?>
					<?php
						$status_class = 'sold-green';
						$is_show_seat = 2;
						if (!empty($item['Item']['min_limit']) && $item['Item']['item_user_count'] < $item['Item']['min_limit']) {
							$status = $item['Item']['min_limit'] - $item['Item']['item_user_count'] . ' ' . __l('more needed!');
							if (!empty($item['Item']['max_limit'])) {
								if (($item['Item']['max_limit'] - $item['Item']['item_user_count']) > 2) {
									$is_show_seat = 2;
								} else {
									$is_show_seat = $item['Item']['max_limit'] - $item['Item']['item_user_count'];
								}
							}
						} elseif (!empty($item['Item']['max_limit']) && (($item['Item']['max_limit'] - $item['Item']['item_user_count']) == 0)) {
							$status = __l('Sold Out');
							$status_class = 'sold-red';
							$is_show_seat = 0;
						} elseif (!empty($item['Item']['min_limit']) && $item['Item']['item_user_count'] >= $item['Item']['min_limit']) {
							$status = __l('Item On!');
							if (!empty($item['Item']['max_limit'])) {
								if (($item['Item']['max_limit'] - $item['Item']['item_user_count']) > 2) {
									$is_show_seat = 2;
								} else {
									$is_show_seat = $item['Item']['max_limit'] - $item['Item']['item_user_count'];
								}
							}
						} elseif (empty($item['Item']['max_limit'])) {
							$status = __l('Unlimited');
						}
					?>
					<ol class="user-list clearfix">
						<?php
							if (!empty($item['Item']['slug'])) {
								$url = Router::url(array('controller' => 'items', 'action' => 'view', $item['Item']['slug']), true);
							}
							$item_user_count = 0;
							$total_user_display = 0;
							if (!empty($item['ItemUser'])) {
								$item_user_count = $item['Item']['item_user_count'];
								$i = 0;
								foreach ($item['ItemUser'] as $itemUser):
									if ($i == 5):
										break;
									endif;
									$total_user_display++;
									$i++;
						?>
						<li><?php echo $this->Html->getUserAvatarLink($itemUser['User'], 'reataurent_user_small_thumb', true);?></li>
						<?php
								endforeach;
							}
							if ($item_user_count <= 4 || empty($item_user_count)) {
								for ($i = $item_user_count+1; $i <= $item_user_count+$is_show_seat; $i++) {
									$price = $item['Item']['price'];
									if ($item['Item']['is_be_next']) {
										$price = $price + (($i-1) * $item['Item']['be_next_increase_price']);
									}
									$class = '';
									if ($i == $item_user_count+1) {
										$class = 'current';
									}
									$title = !empty($item['Item']['be_next_increase_price']) ? __l('Price up by ') . Configure::read('site.currency') . $item['Item']['be_next_increase_price'] : Configure::read('site.currency') . $price;
						?>
						<li><a class="seat-place-link <?php echo $class; ?>" href="<?php echo $url; ?>" title="<?php echo $title;?>"> <span class="seat-text"><?php echo $this->Html->ordinal($i).__l(' Seat'); ?></span> <span class="seat-price"><?php echo configure::read('site.currency').$this->Html->cCurrency($price); ?></span> </a></li>
						<?php 
								}
							} elseif ($item_user_count >= 5) {
								$more_count = $item_user_count - $total_user_display;
								if (!empty($more_count)) {
									$more_url = Router::url(array('controller' => 'items', 'action' => 'view', $item['Item']['slug']), true);
						?>
						<li>
						<a href="<?php echo $more_url; ?>" class='more'>
						<span><?php echo __l('+').$more_count; ?> </span>
						<?php echo __l('More'); ?>
						</a>
						</li>
						<?php
								}
							}
						?>
					</ol>
				</div>
				<div class="merchant-view grid_5 alpha omega">
					<div class="item-ribbon <?php echo $status_class; ?>"><span><?php echo $status; ?></span></div>
					<div class="grab-this">	
					<?php echo $this->Html->link(__l('Grab this'), array('controller' => 'items', 'action' => 'view', $item['Item']['slug']),array('title' => __l('Grab this'), 'class' => 'view-all'));?>
					</div>
					<div class="cta-date"><?php echo $this->Html->cDateTime($item['Item']['event_date']); ?></div>
				</div>
			</li>
			<?php
					endforeach;
				else:
			?>
			<?php if(!empty($this->request->params['named']['type']) &&  $this->request->params['named']['type']=='interest') : ?>
			<li class="no-items"><p class="notice"><?php echo __l('There are currently no ') . $this->Html->cText($interest, false) . __l(' items.'); ?></p></li>
			<?php else: ?>
			<li class="no-items"><p class="notice"><?php echo __l('No Items available'); ?></p></li>
			<?
			endif;
				endif;
			?>
		</ol>
		<?php if(!empty($items)):?>
			<div class="js-pagination"><?php echo $this->element('paging_links'); ?></div>
		<?php endif;?>
	</div>
</div>