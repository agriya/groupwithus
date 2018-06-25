<?php if ($this->Html->isAllowed($this->Auth->user('user_type_id')) && $item['Item']['item_status_id'] != ConstItemStatus::Open && $item['Item']['item_status_id'] != ConstItemStatus::Tipped && $item['Item']['item_status_id'] != ConstItemStatus::Draft && $item['Item']['item_status_id'] != ConstItemStatus::PendingApproval): ?>
<div id="missed_item_announcement" class="announcement">
  <p id="txt_missed_groupon"><?php echo __l('Oh no... You\'re too late for this ').' '.Configure::read('site.name').'!';?></p>
  <div class="announcement_inner clearfix">
    <div class="left">
      <p><?php echo __l('Sign up for our daily email so you never miss another').' '.Configure::read('site.name').'!';?></p>
    </div>
  </div>
</div>
<?php endif; ?>
<div class="title-block">
  <h2 class="title"><?php echo $this->Html->link($item['Item']['name'] . $this->Html->cdatemonthtime($item['Item']['event_date']), array('controller' => 'items', 'action' => 'view', $item['Item']['slug']),array('title' =>sprintf(__l('%s'),$item['Item']['name'])));?></h2>
  <address>
  <?php if (!empty($item['Merchant']['name'])): ?>
  <span><?php echo !($item['Merchant']['is_merchant_profile_enabled']) ? $this->Html->cText($item['Merchant']['name'], false) : $this->Html->link($item['Merchant']['name'], array('controller' => 'merchants', 'action' => 'view', $item['Merchant']['slug'], $item['Item']['slug']), array('title' => $item['Item']['name'], 'escape' => false)); ?></span>
  <?php endif; ?>
  <?php if (!empty($item['Merchant']['address1']) || !empty($item['Merchant']['address2']) || !empty($item['Merchant']['City']['name']) || !empty($item['Merchant']['zip'])): ?>
  <span><?php echo $item['Merchant']['address1'] . ((!empty($item['Merchant']['address2']) ? ', ' . $item['Merchant']['address2'] : '')) . ((!empty($item['Merchant']['City']['name']) ? ', ' . $item['Merchant']['City']['name'] : '')) . ((!empty($item['Merchant']['zip']) ? ', ' . $item['Merchant']['zip'] : ''));?></span>
  <?php endif; ?>
  <?php if (!empty($item['Merchant']['phone'])): ?>
  <span><?php echo $item['Merchant']['phone']; ?></span>
  <?php endif; ?>
  </address>
  <?php if (!empty($item['Merchant']['latitude']) && $item['Merchant']['longitude']): ?>
  <a target='_blank' href="http://maps.google.com/maps?q=<?php echo $item['Merchant']['latitude']; ?>,<?php echo $item['Merchant']['longitude']; ?>" title="Map It!" class="map-it"><?php echo __l('Map It!'); ?></a>
  <?php endif; ?>
</div>
<div class="block1">
  <div class="session1">
    <div class="gallery-block">
      <div id="js-gallery" style="height: 205px;overflow: hidden;width: 270px;">
        <?php foreach($item['Attachment'] as $attachment){?>
        <a><?php echo $this->Html->showImage('Item', $attachment, array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($item['Item']['name'], false)), 'title' => $this->Html->cText($item['Item']['name'], false)));?></a>
        <?php } ?>
      </div>
      <!-- <div class="name-list-block">
					<?php if(!empty($item['UserInterest'])): ?>
						<?php foreach($item['UserInterest'] as $user_interest):?>
							<span><?php  echo $this->Html->link($this->Html->cText($user_interest['name'], false), array('controller' => 'user_interest', 'action' => 'view', $user_interest['slug']), array('title' => $this->Html->cText($user_interest['name'], false), 'escape' => false));?></span>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>-->
    </div>
      <?php
      	if(!empty($item['Item']['menu']	)):?>
      	<div id="item_description" >
			<h4> <?php echo __l('Menu'); ?> </h4>
			<?php echo $this->Html->cHtml($item['Item']['menu'], false); ?>
          </div>
		<?php endif;?>
  </div>
  <div class="session2">
    <div class="grab-block">
      <?php if($item['Item']['item_status_id']==ConstItemStatus::Closed) { ?>
      <?php echo $this->Html->link(__l('Sold out'), '#', array('title' => __l('Sold out'),'class' =>'reserve-now js-unlink sold-green')); ?>
      <?php } elseif($item['Item']['item_status_id'] == ConstItemStatus::Open || $item['Item']['item_status_id'] == ConstItemStatus::Tipped) { ?>
      <?php
						if (!empty($item['Item']['max_limit']) && (($item['Item']['max_limit'] - $item['Item']['item_user_count']) == 0)):
							echo $this->Html->link(__l('Sold out'), '#', array('title' => __l('Sold out'),'class' =>'reserve-now js-unlink sold-green'));
						else:
							$allow=true;
							if($this->Auth->user('user_type_id')==ConstUserTypes::Merchant):
								if($this->Html->checkOwnItem($item['Item']['merchant_id'],$this->Auth->user('id'))):
									$allow=false;
								endif; 
							endif; 
							if($allow): 
								echo $this->Html->link(__l('Grab Now!'), array('controller'=>'items','action'=>'buy',$item['Item']['id']), array('title' => __l('Grab Now!'),'class' =>'reserve-now sold-green'));
							endif;
						endif;
					?>
      <?php } ?>
    </div>
    <?php
				if (!empty($item['Item']['min_limit']) && $item['Item']['item_user_count'] < $item['Item']['min_limit']) {
					$status =  '<span class="numeric">'.($item['Item']['min_limit'] - $item['Item']['item_user_count']).'</span>' . __l('more needed!');
				} elseif (!empty($item['Item']['max_limit']) && (($item['Item']['max_limit'] - $item['Item']['item_user_count']) == 0)) {
					$status = '<span class="time-left1">'.__l('Sold Out').'</span>';
				} elseif (!empty($item['Item']['min_limit']) && $item['Item']['item_user_count'] >= $item['Item']['min_limit']) {
					$status = '<span class="time-left1">'.__l('Item On!').'</span>';
				} elseif (empty($item['Item']['max_limit'])) {
					$status = '<span class="time-left1">'.__l('Unlimited').'</span>';
				}
				if($item['Item']['is_be_next']) {
					$item['Item']['price'] += count($item['ItemUser']) * $item['Item']['be_next_increase_price'];
				}
			?>
    <?php 
				if($item['Item']['item_status_id']==ConstItemStatus::Closed) {
					$no_of_seat= __l('Sold Out');
			?>
    <div class="progress-block clearfix">
      <div class="progress-left">
        <div class="progress-left-inner"> <span class="time-left sold-red"><?php echo $status; ?></span> </div>
      </div>
      <div class="progress-right"> <span class="price"><?php echo $this->Html->siteCurrencyFormat($item['Item']['price']);?></span> <span class="price-text"><?php echo __l('current price'); ?></span> </div>
    </div>
    <?php } else { ?>
    <div class="progress-block clearfix">
      <div class="progress-left">
        <div class="progress-left-inner"> <span class="time-left sold-green"><?php echo $status; ?></span> </div>
      </div>
      <div class="progress-right"> <span class="price"><?php echo $this->Html->siteCurrencyFormat($item['Item']['price']);?></span> <span class="price-text"><?php echo __l('current price'); ?></span> </div>
    </div>
    <?php } ?>
    <div class="reserve-date-block"> <?php echo $this->Html->cDateTime($item['Item']['event_date']); ?> </div>
    <?php if ($item['Item']['is_be_next'] and $item['Item']['be_next_increase_price'] !=0) { ?>
    <div class="benext-block clearfix">
      <h4 class="grid_2 alpha"><?php echo __l('Be Next');?></h4>
      <p class="grid_5 alpha">
        <?php
							echo __l('The price goes up '). $this->Html->siteCurrencyFormat($item['Item']['be_next_increase_price']) .__l(' with each reservation.');
							if ($item['Item']['item_status_id']==ConstItemStatus::Open) {
								$allow=true;
								if($this->Auth->user('user_type_id')==ConstUserTypes::Merchant):
									if($this->Html->checkOwnItem($item['Item']['merchant_id'],$this->Auth->user('id'))):
										$allow=false;
									endif; 
								endif; 
								if($allow): 
									echo $this->Html->link(__l('Reserve Now'), array('controller'=>'items','action'=>'buy',$item['Item']['id']), array('title' => __l('Reserve Now')));
								endif;
							}
						?>
      </p>
    </div>
    <?php } ?>
    <div class="item-desc-block">
      <h3><?php echo __l('Description'); ?></h3>
      <?php echo $this->Html->cHtml($item['Item']['description']); ?> </div>
  </div>
</div>