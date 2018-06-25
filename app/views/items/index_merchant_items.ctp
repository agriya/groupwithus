<?php /* SVN: $Id: index_merchant_items.ctp 71781 2011-11-18 04:05:53Z anandam_023ac09 $ */?>
<div class="js-response js-responses js-search-responses">
    <h2><?php echo __l('My Items'); ?></h2>

    <?php
		$all = '';
		foreach($itemStatuses as $id => $itemStatus):
        	$all += $itemStatusesCount[$id];
    	endforeach;
	?>
	<div class="clearfix filter-block">

<div class="grid_19 omega alpha">

<ul class="flow-chart merchant-chart clearfix">
<li>

<div class="newitem-top-block clearfix">
<div class="newitem-bottom-block clearfix">
<div class="newitem-block clearfix">
  <span class="new-item">
	 <span class="new-item-r">
    	<?php
        echo __l('New Item');
        ?>
     </span>
    </span>
    </div>
    </div>
    </div>

    <div class="clearfix chart-overblock">
        <ul class="pending">
        <li class="pending">
           <div class="pending-bottom-block clearfix">
         <div class="pending-top-block clearfix">
            <div class="pending-block clearfix">
                <span class="pending-approval">
                  <?php
                $url['filter_id'] = ConstItemStatus::PendingApproval;
                echo $this->Html->link(sprintf("%s", __l('Pending Approval').' ('.$itemStatusesCount[ConstItemStatus::PendingApproval].')'), array('controller' => 'items', 'action' => 'index', 'filter_id' => ConstItemStatus::PendingApproval, 'merchant' => $merchant_slug), array('class' => 'all-item','title' => __l('Pending Approval')));
                ?>
                </span>
            </div>
            </div>
            </div>
            <div class="clearfix">
            <ul class="rejected-link clearfix">
                <li class="rejected">
                <span class="rejected">
                         <?php
                $url['filter_id'] = ConstItemStatus::Rejected;
                echo $this->Html->link(sprintf("%s", __l('Rejected').' ('.$itemStatusesCount[ConstItemStatus::Rejected].')'), array('controller' => 'items', 'action' => 'index', 'filter_id' => ConstItemStatus::Rejected, 'merchant' => $merchant_slug), array('class' => 'all-item','title' => __l('Rejected')));
                ?>
                </span>
                </li>
                <li class="open">
                <div class="clearfix">
                   <ul class="open clearfix">
                       <li>
                       <div class="open-top1-block">
                          <div class="open-top-block">
                          <div class="open-bottom-block">
                        <div class="open-block">
                        <span class="open">
                           	<?php
                $url['filter_id'] = ConstItemStatus::Open;
                echo $this->Html->link(sprintf("%s", __l('Open').' ('.$itemStatusesCount[ConstItemStatus::Open].')'), array('controller' => 'items', 'action' => 'index', 'filter_id' => ConstItemStatus::Open, 'merchant' => $merchant_slug), array('class' => 'all-item','title' => __l('Open')));
                ?>
                        </span>
                        </div>
                        </div>
                        </div>
                        </div>
                    </li>
                </ul>
                </div>
                <div class="clearfix">
                <ul class="tipped clearfix">

                    <li class="tipped1 clearfix">
                        <span class="tipped">
                               <?php
                        $url['filter_id'] = ConstItemStatus::Tipped;
                        echo $this->Html->link(sprintf("%s", __l('Tipped').' ('.$itemStatusesCount[ConstItemStatus::Tipped].')'), array('controller' => 'items', 'action' => 'index', 'filter_id' => ConstItemStatus::Tipped, 'merchant' => $merchant_slug), array('class' => 'all-item','title' => __l('Tipped')));
                        ?>
                        </span>
                        </li>
                         <li class="closed">
                              <span class="closed">
                    	               <?php
                            $url['filter_id'] = ConstItemStatus::Closed;
                            echo $this->Html->link(sprintf("%s", __l('Closed').' ('.$itemStatusesCount[ConstItemStatus::Closed].')'), array('controller' => 'items', 'action' => 'index', 'filter_id' => ConstItemStatus::Closed, 'merchant' => $merchant_slug), array('class' => 'all-item','title' => __l('Closed')));
                            ?>
                               </span>
                          </li>
                          <li class="paid">
                              <span class="paid">
                           	               <?php
                                    $url['filter_id'] = ConstItemStatus::PaidToMerchant;
                                    echo $this->Html->link(sprintf("%s", __l('Paid to Merchant').' ('.$itemStatusesCount[ConstItemStatus::PaidToMerchant].')'), array('controller' => 'items', 'action' => 'index', 'filter_id' => ConstItemStatus::PaidToMerchant, 'merchant' => $merchant_slug), array('class' => 'all-item','title' => __l('Paid to Merchant')));
                                    ?>
                                 </span>
                       </li>
                              </ul>
                   </div>
                   <div class="clearfix">

                  <ul class="refunded">
                    <li class="expired">
                        <span class="expired">
                    	  <?php
                            $url['filter_id'] = ConstItemStatus::Expired;
                            echo $this->Html->link(sprintf("%s", __l('Expired').' ('.$itemStatusesCount[ConstItemStatus::Expired].')'), array('controller' => 'items', 'action' => 'index', 'filter_id' => ConstItemStatus::Expired, 'merchant' => $merchant_slug), array('class' => 'all-item','title' => __l('Expired')));
                            ?>

                        </span>
                      </li>
                            <li>
                             <span class="refunded">
                	           	<?php
                                $url['filter_id'] = ConstItemStatus::Refunded;
                                echo $this->Html->link(sprintf("%s", __l('Refunded').' ('.$itemStatusesCount[ConstItemStatus::Refunded].')'), array('controller' => 'items', 'action' => 'index', 'filter_id' => ConstItemStatus::Refunded, 'merchant' => $merchant_slug), array('class' => 'all-item','title' => __l('Refunded')));
                                ?>
                             </span>
                            </li>
                        </ul>
                        </div>
                        <div class="clearfix">
                   <ul  class="canceled">
                    <li class="canceled">
                        <span class="canceled">
                	         	<?php
                    $url['filter_id'] = ConstItemStatus::Canceled;
                    echo $this->Html->link(sprintf("%s", __l('Canceled').' ('.$itemStatusesCount[ConstItemStatus::Canceled].')'), array('controller' => 'items', 'action' => 'index', 'filter_id' => ConstItemStatus::Canceled, 'merchant' => $merchant_slug), array('class' => 'all-item','title' => __l('Canceled')));
                    ?>
                        </span>
                      </li>
                            <li class="hidden-link">
                            <span class="refunded">
                            	<?php
                                $url['filter_id'] = ConstItemStatus::Refunded;
                                echo $this->Html->link(sprintf("%s", __l('Refunded').' ('.$itemStatusesCount[ConstItemStatus::Refunded].')'), array('controller' => 'items', 'action' => 'index', 'filter_id' => ConstItemStatus::Refunded, 'merchant' => $merchant_slug), array('class' => 'all-item','title' => __l('Refunded')));
                                ?>
                             </span>
                            </li>
                        </ul>

                </div>

                </li>
                <li class="upcoming1">
                 <ul  class="hidden-link">
                 <li>
                    <span class="open">
                      <?php
                $url['filter_id'] = ConstItemStatus::Open;
                echo $this->Html->link(sprintf("%s", __l('Open').' ('.$itemStatusesCount[ConstItemStatus::Open].')'), $url, array('class' => 'all-item','title' => __l('Open')));
                ?>
                </span>
                 </li>
                 </ul>

                </li>
            </ul>
            </div>
        </li>
        </ul>
        </div>
        <div class="clearfix">
        <ul class="draft">
          <li class="draft clearfix">
            <span class="draft-link">
               <?php
                $url['filter_id'] = ConstItemStatus::Draft;
                echo $this->Html->link(sprintf("%s", __l('Draft').' ('.$itemStatusesCount[ConstItemStatus::Draft].')'), array('controller' => 'items', 'action' => 'index', 'filter_id' => ConstItemStatus::Draft, 'merchant' => $merchant_slug), array('class' => 'all-item','title' => __l('Draft')));
                ?>
            </span>
            </li>
        </ul>
        </div>
    </li>
</ul>
<div class="all-item-links">
        	<?php
        	    $url['type'] ='all';
                echo $this->Html->link(sprintf("%s", __l('All Items').' ('.$all.')'), array('controller'=> 'items', 'action'=>'index', 'merchant' => $merchant_slug), array('class' => 'all-item','title' => __l('All item')));
                unset($url['type']); ?>
        </div>
</div>

	<div class="grid_4 all-item-block all-item-block1">
           <?php
				$item_percentage = '';
				$item_stat = '';
				$all = 0;
				foreach($itemStatuses as $id => $itemStatus){
					$all += $itemStatusesCount[$id] ;
				}
				unset($itemStatuses[1]);
				foreach($itemStatuses as $id => $itemStatus){
					$item_percentage .= ($item_percentage != '') ? ',' : '';
					$item_stat .= (!empty($item_stat)) ? '|'.$itemStatus : $itemStatus;
					$item_percentage .= round((empty($itemStatusesCount[$id])) ? 0 : ( ($itemStatusesCount[$id] / $all) * 100 ));
				}
			?>
             <?php echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$item_percentage.'&amp;chs=120x120&amp;chco=74b732|fd66b5|929292|3f83b2|444444|deb700|e21e1e|fa9116|00b0c6|be7125&amp;chf=bg,s,FF000000'); ?>
        
    </div>
  </div>
     <?php if(!empty($this->request->params['named']['filter_id']) && (!empty($itemStatusesCount[$this->request->params['named']['filter_id']]))){
        $id = $this->request->params['named']['filter_id'];
     }else if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'all')){
        $id = $this->request->params['named']['type'];
     }
     ?>

	<div class="">
    <div class="page-count-block clearfix">
        <div class="grid_left">
         <?php echo $this->element('paging_counter'); ?>
      </div>
      <div class="grid_left">
       <?php echo $this->Form->create('Item', array('url' => array('controller' => 'items', 'action' => 'index','filter_id' => (!empty($this->request->params['named']['filter_id'])) ? $this->request->params['named']['filter_id'] : '', 'merchant' => $merchant_slug) ,'class' => 'search-form normal js-ajax-form {"container" : "js-search-responses"} clearfix'));?>
	   <?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>
	   <?php echo $this->Form->hidden('filter_id', array('value' => (!empty($this->request->params['named']['filter_id'])) ? $this->request->params['named']['filter_id'] : '')); ?>
	   <?php echo $this->Form->hidden('type', array('value' => (!empty($this->request->params['named']['type'])) ? $this->request->params['named']['type'] :'')); ?>
	   <?php echo $this->Form->hidden('merchant_slug', array('value' => $merchant_slug)); ?>
		<?php
		echo $this->Form->end(__l('Search')); ?>
		</div>
    </div>

  <table class="list" id="js-expand-table">
    <tr class="js-even">
      <th rowspan="2" class="select"><?php echo __l('Action'); ?></th>
      <th rowspan="2"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Item'),'Item.name'); ?></div></th>
      <th rowspan="2" class="quantity-sold"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Date Start/End'), 'Item.start_date'); ?></div></th>
      <th rowspan="2" class="quantity-sold"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Quantities Sold'),'Item.item_user_count'); ?></div></th>
      <th rowspan="2"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Sales'),'Item.total_purchased_amount').' ('.Configure::read('site.currency').')'; ?></div></th>
      <th colspan="4"><?php echo __l('Share'); ?></th>
	  
    </tr>
	<tr class="js-even">
			<th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Merchant'),'Item.total_merchant_earned_amount').' ('.Configure::read('site.currency').')'; ?></div></th>
		  <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Charity'),'Item.total_charity_amount').' ('.Configure::read('site.currency').')'; ?></div></th>
		  <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Affiliate'),'Item.total_affiliate_amount').' ('.Configure::read('site.currency').')'; ?></div></th>
		  <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Site / Revenue'),'Item.total_commission_amount').' ('.Configure::read('site.currency').')'; ?></div></th>
	</tr>
    <?php if(!empty($items)): ?>
      <?php foreach($items as $item):
			$original_price = $item['Item']['price'];
			$bonus_amount = $item['Item']['bonus_amount'];
			$commission_percentage = $item['Item']['commission_percentage'];
			$total_commission_amount = $item['Item']['total_commission_amount'];
			$max_limit = $item['Item']['max_limit'];
	  ?>
                    <tr class="expand-row js-odd">
                       <td class="select">
                          		<div class="arrow"></div>
                      </td>
                      <td class="dl item-name">
                        <div class="clearfix">
                            <span title="<?php echo $item['ItemStatus']['name']; ?>" class="<?php echo 'item-atatus-info  item-status-'.strtolower(str_replace(" ","",$item['ItemStatus']['name']));?>"><?php echo $this->Html->cText($item['ItemStatus']['name']); ?>&nbsp;</span>
                            <?php echo $this->Html->truncate($item['Item']['name'],90, array('ending' => '...')); ?>
                        </div>
                      </td>
                      <td  class="quantity-sold">
						<div class="clearfix">
                               <div class="item-bought-info item-date-info  omega alpha">
                       <?php
							$item_progress_precentage = 0;
							if(strtotime($item['Item']['start_date']) < strtotime(date('Y-m-d H:i:s'))) {
								if($item['Item']['end_date'] !== null) {
									$days_till_now = (strtotime(date("Y-m-d")) - strtotime(date($item['Item']['start_date']))) / (60 * 60 * 24);
									$total_days = (strtotime(date($item['Item']['end_date'])) - strtotime(date($item['Item']['start_date']))) / (60 * 60 * 24);
									$item_progress_precentage = round((($days_till_now/$total_days) * 100));
									if($item_progress_precentage > 100)
									{
										$item_progress_precentage = 100;
									}
								} else {
									$item_progress_precentage = 100;
								}
							}	
						?>

                        <p class="progress-bar round-5">
                           <span class="<?php echo (!empty($item['Item']['is_anytime_item']))? ' any-time-item-progress': 'progress-status '; ?> round-5" style="width:<?php echo $item_progress_precentage; ?>%" title="<?php echo $item_progress_precentage; ?>%">&nbsp;</span>
                        </p>
                        <?php
							
						?>
                        <p class="progress-value clearfix"><span class="progress-from"><?php echo ($item['Item']['item_status_id'] == ConstItemStatus::PendingApproval || $item['Item']['item_status_id'] == ConstItemStatus::Draft || $item['Item']['item_status_id'] == ConstItemStatus::Rejected) ? '-' :$this->Html->cDateFormat($item['Item']['start_date']);?></span>/<span class="progress-to"><?php echo (!is_null($item['Item']['end_date']))? $this->Html->cDateFormat($item['Item']['end_date']): ' - ';?></span></p>
                       </div>
                     </div>
                      </td>
					  <td class="quantity-sold">
                         <div class="clearfix">
                       <div class=" item-bought-count"><?php echo $this->Html->cInt($item['Item']['item_user_count']);?></div>
                       <div class="item-bought-info">
                        <?php
							$pixels = 0;
                            $pixels = round(($item['Item']['item_user_count']/$item['Item']['min_limit']) * 100);
                        ?>
                        <p class="progress-bar round-5">
                           <span class="progress-status round-5" style="width:<?php echo $pixels; ?>%" title="<?php echo $pixels; ?>%">&nbsp;</span>
                        </p>
                        <p class="progress-value clearfix"><span class="progress-from">0</span><span class="progress-to"><?php echo $this->Html->cInt($item['Item']['min_limit']); ?></span></p>
                       </div>
                     </div>
					  </td>
                      <td class="dr site-amount"><?php echo $this->Html->cCurrency($item['Item']['total_purchased_amount']); ?></td>
                      <td class="dr"><?php echo $this->Html->cCurrency($item['Item']['total_merchant_earned_amount']); ?></td>
                      <td class="dr"><?php echo $this->Html->cCurrency($item['Item']['total_charity_amount']); ?></td>
                      <td class="dr"><?php echo $this->Html->cCurrency($item['Item']['total_affiliate_amount']); ?></td>
					  <td class="dr site-amount"><?php echo $this->Html->cCurrency($item['Item']['total_commission_amount']); ?></td>
                    </tr>
                    <tr class="hide">
                    <td colspan="9" class="action-block">
                    <div class="action-info-block clearfix">
                    <div class="action-left-block">
                     <h3><?php echo __l('Actions'); ?></h3>
                    <?php if(!empty($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == ConstItemStatus::PendingApproval || $this->request->params['named']['filter_id'] == ConstItemStatus::Rejected || $this->request->params['named']['filter_id'] == ConstItemStatus::Canceled || $this->request->params['named']['filter_id'] == ConstItemStatus::Draft)){?>
						<?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstItemStatus::Draft):?>
                                <ul>
                                     <li><?php echo $this->Html->link(__l('Edit'), array('controller' => 'items', 'action'=>'edit', $item['Item']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></li>
                                     <li><?php echo $this->Html->link(__l('Delete'), array('controller' => 'items', 'action'=>'delete', $item['Item']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
                                     <li><?php echo $this->Html->link(__l('Save and send to admin approval'), array('controller' => 'items', 'action'=>'update_status', $item['Item']['id']), array('class' => 'add js-delete', 'title' => __l('Save and send to admin approval')));?></li>
                                     <li><?php echo $this->Html->link(__l('Preview'), array('controller' => 'items', 'action' => 'view', $item['Item']['slug'], 'city' => (!empty($city_new_slug) ? $city_new_slug : ''), 'admin' => false), array('title'=>__l('Preview'), 'escape' => false));?></li>
                                </ul>
                    	<?php elseif(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstItemStatus::PendingApproval):?>
							<ul>
								 <li><?php echo $this->Html->link(__l('Clone Item'),array('controller'=>'items', 'action'=>'add', 'clone_item_id'=>$item['Item']['id']), array('class' => 'add', 'title' => __l('Clone Item')));?></li>
							</ul>
                        <?php endif; ?>
                    <?php } else { ?>
                                <ul>
                                    <?php if(in_array($item['Item']['item_status_id'], array(ConstItemStatus::Tipped,ConstItemStatus::Closed,ConstItemStatus::PaidToMerchant))):?>
                                        <li><?php echo $this->Html->link(__l('Pass CSV'), array('controller' => 'items', 'action' => 'passes_export', 'item_id' =>  $item['Item']['id'], 'city' => $city_slug, 'filter_id' => $id, 'ext' => 'csv'), array('class' => 'export', 'title' => __l('Pass CSV')));?></li>
                                        <li> <?php echo $this->Html->link(__l('Print of Pass'),array('controller' => 'items', 'action' => 'items_print', 'filter_id' => !empty($this->request->params['named']['filter_id'])?$this->request->params['named']['filter_id']:'','page_type' => 'print', 'item_id' => $item['Item']['id'], 'merchant' => $merchant_slug),array('title' => __l('Print of Pass'), 'target' => '_blank', 'class'=>'print-icon'));?></li>
                                    <?php endif; ?>
                                        <li><?php echo $this->Html->link(__l('List Pass'), array('controller' => 'item_passes', 'action' => 'index', 'item_id' =>  $item['Item']['id']), array('class'=>'list-pass','target' => '_blank', 'title' => __l('List Pass')));?></li>
                                    <?php if(in_array($item['Item']['item_status_id'], array(ConstItemStatus::Open, ConstItemStatus::Tipped,ConstItemStatus::Closed,ConstItemStatus::PaidToMerchant))):?>
                                       
											<?php if($item['Item']['item_status_id'] == ConstItemStatus::Open):?>
											 <li>	<?php echo $this->Html->link(__l('Quantities Sold').' ('.$this->Html->cInt($item['Item']['item_user_count'], false).')',array('controller'=>'item_users', 'action'=>'index', 'item_id'=>$item['Item']['id'], 'view' => 'merchant_view'),array('class' => 'quantity-sold js-thickbox'));?>		 </li>									
											<?php else:?>
												<li><?php echo $this->Html->link(__l('Quantities Sold').' ('.$this->Html->cInt($item['Item']['item_user_count'], false).')',array('controller'=>'item_users', 'action'=>'index', 'item_id'=>$item['Item']['id'], 'item_user_view' => 'list', 'view' => 'merchant_view'),array('class' => 'quantity-sold js-thickbox'));?> </li>
												<li><?php echo $this->Html->link(__l('Used'), array('controller'=>'item_users', 'action'=>'index', 'item_id'=>$item['Item']['id'], 'view' => 'merchant_view', 'type' => 'used', 'item_user_view' => 'pass'),array('class' => 'quantity-sold js-thickbox'));?> </li>
												<li><?php echo $this->Html->link(__l('Available'), array('controller'=>'item_users', 'action'=>'index', 'item_id'=>$item['Item']['id'], 'view' => 'merchant_view', 'type' => 'available', 'item_user_view' => 'pass'),array('class' => 'quantity-sold js-thickbox'));?> </li>
											<?php endif?>
                                       
                                    <?php endif; ?>
									<li><?php echo $this->Html->link(__l('Clone Item'),array('controller'=>'items', 'action'=>'add', 'clone_item_id'=>$item['Item']['id']), array('class' => 'add', 'title' => __l('Clone Item')));?></li>
                                </ul>
					<?php  } ?>
                    		<ul>
                            	<li><?php echo $this->Html->link(__l('Stats'), array('controller'=>'charts', 'action'=>'chart_item_stats', $item['Item']['id'], 'admin' => false),array('class' => 'item-stats', 'target' => '_blank'));?></li>
                            </ul>
                        </div>
                        <div class="action-right-block item-action-right-block clearfix">
                             <div class="clearfix">
                               <div class="action-right action-right1">
                                   <h3><?php echo __l('Price'); ?></h3>
                                    <dl class="clearfix">
                                       <dt><?php echo __l('Original Price').' ('.Configure::read('site.currency').')';?></dt>
										<dd><?php echo $this->Html->cCurrency($original_price); ?></dd>
                                   </dl>
								   <?php if($item['Item']['is_be_next']) : ?>
								   <dl class="clearfix">
                                       <dt><?php echo __l('Be Next Increase Price').' ('.Configure::read('site.currency').')';?></dt>
										<dd><?php echo $this->Html->cCurrency($item['Item']['be_next_increase_price']); ?></dd>
                                   </dl>
								   <?php endif; ?>
                               </div>
                               <div class="action-right">
                                   <h3><?php echo __l('Commission'); ?></h3>
                                   <dl class="clearfix">
                                       <dt><?php echo __l('Bonus').' ('.Configure::read('site.currency').')';?></dt>
                                       <dd><?php echo $this->Html->cCurrency($bonus_amount); ?></dd>
                                       <dt><?php echo __l('Commission').' (%)';?></dt>
                                       <dd><?php echo $this->Html->cFloat($commission_percentage); ?></dd>
                                       <dt><?php echo __l('Total Commission').' ('.Configure::read('site.currency').')';?></dt>
                                       <dd><?php  echo $this->Html->cCurrency($total_commission_amount); ?></dd>
                                   </dl>
                               </div>
                              <div class="action-right action-right3">
                                   <h3><?php echo __l('User Limit'); ?></h3>
                                   <dl class="clearfix">
                                       <dt><?php echo __l('Minimum');?></dt>
                                       <dd><?php echo $this->Html->cInt($item['Item']['min_limit']); ?></dd>
                                       <dt><?php echo __l('Maximum');?></dt>
                                       <dd><?php echo $this->Html->cInt($max_limit); ?></dd>
                                   </dl>
                               </div>
                               </div>

                             <div class="action-right city-action">
                                <?php
								$cities_list =array();
								if(isset($item['City']) && !empty($item['City'])):
								foreach($item['City'] as $city_sub):
									$cities_list[] =  $this->Html->link($city_sub['name'], array('controller' => 'items', 'action'=>'index', 'city_slug' => $city_sub['slug']),array('title' => sprintf(__l('%s'),$city_sub['name'])));
								endforeach;
								endif;
								?>
                                    <?php if(!empty($cities_list)) :?>
                                    <dl class="clearfix">
                                        <dt><?php echo __l('City').': ';?></dt>
                                   <dd><?php echo implode(', ', $cities_list); ?></dd>
                                    </dl>
                                    <?php endif; ?>
                                </div>
                              
								</div>
								<div class="action-right action-right-block action-right4">
    							<div class="item-img-block">
                                    <?php echo $this->Html->link($this->Html->showImage('Item', (!empty($item['Attachment'][0]) ? $item['Attachment'][0] : ''), array('dimension' => 'normal_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($item['Item']['name'], false)), 'title' => $this->Html->cText($item['Item']['name'], false))), array('controller' => 'items', 'action' => 'view', $item['Item']['slug'], 'city' => (!empty($city_new_slug) ? $city_new_slug : ''), 'admin' => false), array('title'=>$this->Html->cText($item['Item']['name'],false),'escape' => false));?>
                                </div>
                               <dl class="clearfix">
                                   <dt><?php echo __l('Added 0n');?></dt>
                                   <dd><?php echo $this->Html->cDateTimeHighlight($item['Item']['created']); ?></dd>
                                   <dt><?php echo __l('Status: '); ?></dt>
                                   <dd>
                                    <span title="<?php echo $item['ItemStatus']['name']; ?>" class="<?php echo 'item-atatus-info item-status-'.strtolower(str_replace(" ","",$item['ItemStatus']['name']));?>">&nbsp;</span>
                                    <?php echo $this->Html->cText($item['ItemStatus']['name']); ?>
                                    </dd>
                                   <dt><?php echo __l('User');?></dt>
                                   <dd><?php echo $this->Html->getUserAvatarLink($item['User'], 'micro_thumb',false).' '.$this->Html->getUserLink($item['User']); ?></dd>
                               </dl>
                         </div>
                         </div>
                    </td>
                    </tr>
      <?php endforeach; ?>
    <?php else: ?>
        <tr class="js-odd"><td class="notice" colspan="11"><?php echo __l('No items available');?></td></tr>
    <?php endif; ?>
    </table>
	<?php
    if (!empty($items)) {
        ?>
            <div class="js-pagination">
                <?php echo $this->element('paging_links'); ?>
            </div>
        <?php
    }
    ?>
    </div>
 </div>