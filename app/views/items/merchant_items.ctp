<div class="js-response js-responses">
	<?php if(!empty($merchant_items)){ ?>
		<?php echo $this->element('paging_counter'); ?>
		<ol class="item-user-list">
		<?php 
		$display_date='';
		foreach($merchant_items as $item){ ?>
			<li class="clearfix">
			<?php if(date('y-m-d',strtotime($item['Item']['event_date'])) != $display_date):?>
			<div class="grid_2 merchant-left calander-block">
			
			<?php $display_date = date('y-m-d',strtotime($item['Item']['event_date']));

				?>
				<?php echo $this->Html->cmonthdateday($item['Item']['event_date']);?>
  			</div>
  	    	<?php else:?>
  				<div class="grid_2 merchant-left">
  				</div>
			<?php endif; ?>
			<div class="clearfix grid_10 merchant-right">
 
										
											<div class="merchant-img">
											<?php if($item['Item']['item_status_id']==ConstItemStatus::Closed){?>
												<span class="sold-out">&nbsp;</span>
											  <?php } ?>
												       <?php  echo $this->Html->link($this->Html->showImage('Item', $item['Attachment'][0], array('dimension' => 'normal_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($item['Item']['name'], false)), 'title' => $this->Html->cText($item['Item']['name'], false))),array('controller' => 'items', 'action' => 'view', $item['Item']['slug']),array('title'=>$item['Item']['name'],'escape' =>false));?>
												 
						                    </div>
											<div class="merchant-user"> 
											<ul class="merchant-namelist clearfix"> 
														<?php if(!empty($item['UserInterest'])): ?>
												<?php foreach($item['UserInterest'] as $user_interest):?>
												<li><?php  echo $this->Html->link($user_interest['name'],array('controller' => 'user_interest', 'action' => 'view', $user_interest['slug']),array('title'=>$user_interest['name'],'escape' =>false));?></li>
												<?php endforeach; ?>
													<?php endif; ?>
											</ul>
											 
          									<p><?php echo $this->Html->link($this->Html->cText($item['Item']['name'],false), array('controller' => 'items', 'action' => 'view', $item['Item']['slug']),array('title' =>sprintf(__l('%s'),$item['Item']['name']))) . __l(' at ') . $this->Html->ctimenew($item['Item']['event_date']) . ' (' .$item['Merchant']['address1'] . ') ';?></p>
											</div>
												<div class="grid_2 merchant-view"> 
												<div class="grab-this">	
												<?php 
													 if($item['Item']['item_status_id']==ConstItemStatus::Closed){
														echo $this->Html->link(__l('Closed'), array('controller' => 'items', 'action' => 'view', $item['Item']['slug']),array('title' =>__l('Closed'),'class'=>'view-all'));
												}else{
												
												echo $this->Html->link(__l('View Item'), array('controller' => 'items', 'action' => 'view', $item['Item']['slug']),array('title' =>__l('View Item'),'class'=>'view-all'));
												}?>
												</div>
											<?php
							if($item['Item']['is_be_next']){
								$item['Item']['price'] += count($item['ItemUser']) * $item['Item']['be_next_increase_price'];
							}		
                            if(empty($item['Item']['max_limit'])){
								 $price = $item['Item']['price'];
                            }
                            else{
                                $no_of_seat = ($item['Item']['max_limit'] - $item['Item']['item_user_count']);
                                if($no_of_seat>0){
                                    $price = $item['Item']['price'];
                                }
                                else{
                                    $price = __l('Sold Out');
                                }
                            }?>
                            	<?php
					if (!empty($item['Item']['min_limit']) && $item['Item']['item_user_count'] < $item['Item']['min_limit']) {
							$status = $item['Item']['min_limit'] - $item['Item']['item_user_count'] . ' ' . __l('more needed!');
							
						} elseif ((!empty($item['Item']['max_limit']) && (($item['Item']['max_limit'] - $item['Item']['item_user_count']) == 0)) || $item['Item']['item_status_id']==ConstItemStatus::Closed || $item['Item']['item_status_id']==ConstItemStatus::PaidToMerchant ) {
							$status = __l('Sold Out');
						} elseif (!empty($item['Item']['min_limit']) && $item['Item']['item_user_count'] >= $item['Item']['min_limit']) {
							$status = __l('Item On!');
						} elseif (empty($item['Item']['max_limit'])) {
							$status = __l('Unlimited');
						}?>
                            <?php  if($item['Item']['item_status_id']==ConstItemStatus::Closed || $item['Item']['item_status_id']==ConstItemStatus::Tipped || $item['Item']['item_status_id']==ConstItemStatus::PaidToMerchant){ ?>
								<div class="item-ribbon sold-red"><span><?php echo $this->Html->cText($status);?></span></div>
                            <?php }else{ ?>
								<div class="item-ribbon sold-green"><span><?php echo $status; ?></span></div>		
								<div class="item-price"><?php echo $this->Html->siteCurrencyFormat($price);?></div>
                            <?php }?>
                                
            		                         </div>
             </div>
            </li>
		<?php } ?>
		</ol>
		<div class="js-pagination"> <?php echo $this->element('paging_links'); ?> </div>
	<?php }else{ ?>
        <p class="notice "><?php echo __l('No items available');?></p>
    <?php } ?>
</div>