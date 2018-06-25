<div>
<?php if(!empty($user_items)){ ?>
	<ol class="merchant-list">
		<?php foreach($user_items as $user_item){
		$display_date =''; ?>
			<?php
				if(!empty($user_item['ItemUser']['is_used']) && ($user_item['ItemUser']['is_used'] == 1)) {
					$class = 'used';
				} else {
					$class = 'not-used';
				}
			?>
			<li class = "clearfix <?php echo $class;?>">
			<div class="grid_2 merchant-left">
										<?php if(date('y-m-d',strtotime($user_item['Item']['event_date'])) != $display_date):
											$display_date = date('y-m-d',strtotime($user_item['Item']['event_date']));

											?>
											<div class="calander-block"> <?php echo $this->Html->cmonthdateday($user_item['Item']['event_date']);?> </div>
										<?php endif; ?>
										</div>
                <div class="clearfix grid_10 merchant-right">
                	<div class="merchant-img">
											<?php if($user_item['Item']['item_status_id']==ConstItemStatus::Closed){?>
												<span class="sold-out">&nbsp;</span>
											  <?php } ?>
												       <?php  echo $this->Html->link($this->Html->showImage('Item', $user_item['Item']['Attachment'][0], array('dimension' => 'normal_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($user_item['Item']['name'], false)), 'title' => $this->Html->cText($user_item['Item']['name'], false))),array('controller' => 'items', 'action' => 'view', $user_item['Item']['slug']),array('title'=>$user_item['Item']['name'],'escape' =>false));?>

						                    </div>
						                    <div class="merchant-user">
															<ul class="merchant-namelist clearfix"> 
												<li>
												<?php  echo $this->Html->link($user_item['Item']['Merchant']['name'],array('controller' => 'merchants', 'action' => 'view',$user_item['Item']['Merchant']['slug'], $user_item['Item']['slug']),array('title'=>$user_item['Item']['name'],'escape' =>false));?>
												</li>
											</ul>

												<p><?php echo $this->Html->link($this->Html->cText($user_item['Item']['name'],false), array('controller' => 'items', 'action' => 'view', $user_item['Item']['slug']),array('title' =>sprintf(__l('%s'),$user_item['Item']['name']))) . __l(' at ') . $this->Html->ctimenew($user_item['Item']['event_date']) . ' (' .$user_item['Item']['Merchant']['address1'] . ') ';?></p>
                                               
											</div>
											<div class="grid_2 merchant-view"> <div class="grab-this"><?php echo $this->Html->link(__l('View Item'), array('controller' => 'items', 'action' => 'view', $user_item['Item']['slug']),array('title' =>__l('View Item'),'class'=>'view-all'));?></div>
												<div class="item-ribbon sold-green"><span><?php echo $this->Html->cInt($user_item['ItemUser']['quantity'], false). __l(' Quantity'); ?></span></div>
											  </div>
										
          </div>
		
			</li>
		<?php } ?>
	</ol>
<?php } else { ?>
	<p class="notice"><?php echo __l('No passes available');?></p>
<?php } ?>
</div>