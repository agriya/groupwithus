<?php /* SVN: $Id: admin_index.ctp 71620 2011-11-15 22:25:46Z arovindhan_144at11 $ */ ?>
<div class="js-response js-responses js-search-responses">
	<?php 
		if(!empty($this->request->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
	<?php 
        if(!empty($this->request->params['named']['merchant'])):
            $url= array(
                'controller' => 'items',
                'action' => 'index',
                'merchant' => $this->request->params['named']['merchant'],
            );
        elseif(!empty($this->request->params['named']['city_slug'])):
            $url= array(
                'controller' => 'items',
                'action' => 'index',
                'city_slug' => $this->request->params['named']['city_slug'],
            );
        else:
            $url= array(
                'controller' => 'items',
                'action' => 'index',
            );			
        endif;
		
    ?>
    <?php 
		$all = '';
		foreach($itemStatuses as $id => $itemStatus): 
        	$all += $itemStatusesCount[$id];
    	endforeach; 
	?>
<div class="clearfix">
<div class="grid_20 omega alpha">

<ul class="flow-chart clearfix">
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
  
    <div class="clearfix">
        <ul class="pending">
        <li class="pending">
           <div class="pending-bottom-block clearfix">
         <div class="pending-top-block clearfix">
            <div class="pending-block clearfix">
                <span class="pending-approval">
                <?php
                    $url['filter_id'] = ConstItemStatus::PendingApproval;
                    echo $this->Html->link(sprintf("%s", __l('Pending Approval').' ('.$itemStatusesCount[ConstItemStatus::PendingApproval].')'), $url, array('class' => 'all-item','title' => __l('Pending Approval')));
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
                        echo $this->Html->link(sprintf("%s", __l('Rejected').' ('.$itemStatusesCount[ConstItemStatus::Rejected].')'), $url, array('class' => 'all-item','title' => __l('Rejected')));
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
                        echo $this->Html->link(sprintf("%s", __l('Open').' ('.$itemStatusesCount[ConstItemStatus::Open].')'), $url, array('class' => 'all-item','title' => __l('Open')));
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
                                echo $this->Html->link(sprintf("%s", __l('Tipped').' ('.$itemStatusesCount[ConstItemStatus::Tipped].')'), $url, array('class' => 'all-item','title' => __l('Tipped')));
                                ?>
                        </span>
                        </li>
                         <li class="closed">
                              <span class="closed">
                    	            <?php
                                    $url['filter_id'] = ConstItemStatus::Closed;
                                    echo $this->Html->link(sprintf("%s", __l('Closed').' ('.$itemStatusesCount[ConstItemStatus::Closed].')'), $url, array('class' => 'all-item','title' => __l('Closed')));
                                    ?>
                               </span>
                          </li>
                          <li class="paid">
                              <span class="paid">
                           	            <?php
                                        $url['filter_id'] = ConstItemStatus::PaidToMerchant;
                                        echo $this->Html->link(sprintf("%s", __l('Paid to Merchant').' ('.$itemStatusesCount[ConstItemStatus::PaidToMerchant].')'), $url, array('class' => 'all-item','title' => __l('Paid to Merchant')));
                                        ?>
							
                                 </span>
                                 	 <span class="small-info" title="<?php echo __l('Merchant share for their items will be funded to their respective wallet account.
If the \'Paid to Merchant\' items has Charity & Affiliate, their share will be also funded to their respective charity and affiliate user wallet account.');?>"><?php echo __l('Merchant share for their items will be funded to their respective wallet account.
If the \'Paid to Merchant\' items has Charity & Affiliate, their share will be also funded to their respective charity and affiliate user wallet account.');?>
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
                echo $this->Html->link(sprintf("%s", __l('Expired').' ('.$itemStatusesCount[ConstItemStatus::Expired].')'), $url, array('class' => 'all-item','title' => __l('Expired')));
                ?>
                    
                        </span>
                      </li>
                            <li>
                             <span class="refunded">
                	          	<?php
                                $url['filter_id'] = ConstItemStatus::Refunded;
                                echo $this->Html->link(sprintf("%s", __l('Refunded').' ('.$itemStatusesCount[ConstItemStatus::Refunded].')'), $url, array('class' => 'all-item','title' => __l('Refunded')));
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
                        echo $this->Html->link(sprintf("%s", __l('Canceled').' ('.$itemStatusesCount[ConstItemStatus::Canceled].')'), $url, array('class' => 'all-item','title' => __l('Canceled')));
                        ?>
                        </span>
                      </li>
                            <li class="hidden-link">
                            <span class="refunded">
                            	<?php
                                $url['filter_id'] = ConstItemStatus::Refunded;
                                echo $this->Html->link(sprintf("%s", __l('Refunded').' ('.$itemStatusesCount[ConstItemStatus::Refunded].')'), $url, array('class' => 'all-item','title' => __l('Refunded')));
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
                echo $this->Html->link(sprintf("%s", __l('Draft').' ('.$itemStatusesCount[ConstItemStatus::Draft].')'), $url, array('class' => 'all-item','title' => __l('Draft')));
                ?>
            </span>
            </li>
        </ul>
        </div>
    </li>
</ul>

</div>
<div class="grid_4 all-item-block">


           <?php
				$item_percentage = '';
				$item_stat = '';
				$all = 0;
				foreach($itemStatuses as $id => $itemStatus){
					$all += $itemStatusesCount[$id] ;
				}
				unset($itemStatuses[1]);
				foreach($itemStatuses as $id => $itemStatus) {
					$item_percentage .= ($item_percentage != '') ? ',' : '';
					$item_stat .= (!empty($item_stat)) ? '|'.$itemStatus : $itemStatus;
					$item_percentage .= round((empty($itemStatusesCount[$id])) ? 0 : ( ($itemStatusesCount[$id] / $all) * 100 ));
				}
			?>           
             <?php echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$item_percentage.'&amp;chs=120x120&amp;chco=74b732|fd66b5|929292|3f83b2|444444|deb700|e21e1e|fa9116|00b0c6|be7125&amp;chf=bg,s,FF000000'); ?> 
            <div class="item-links">
            <?php
            $url['type'] ='all';
            unset($url['filter_id']);
            echo $this->Html->link(sprintf("%s", __l('All Items').' ('.$all.')'), $url, array('class' => 'all-item','title' => __l('All Items')));
            unset($url['type']);
            ?>
            </div>
    </div>
    </div>
	 <?php //if(empty($this->request->data)): ?>
		 <?php if(!empty($this->request->params['named']['filter_id']) && (!empty($itemStatusesCount[$this->request->params['named']['filter_id']]))){
            $id = $this->request->params['named']['filter_id'];
         }else if(!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'all')){
            $id = $this->request->params['named']['type'];
         }
         ?>    
        <div class="">
            <?php /*?><h2>
			<?php 
			if(!empty($this->request->params['named']['merchant'])) {
				echo  ' - ' . ucfirst($this->request->params['named']['merchant']);
			} elseif(!empty($this->request->params['named']['city_slug'])) {
				echo  ' - ' . ucfirst($this->request->params['named']['city_slug']);
			} else {
				echo '';
			}
			?>
            </h2><?php */?>
            <div class="page-count-block clearfix">
            	<div class="grid_left">
                <?php echo $this->element('paging_counter');?>
                </div>
                	<div class="grid_left">
              <?php echo $this->Form->create('Item' , array('type' => 'post', 'class' => 'normal search-form clearfix','action' => 'index','url' => $this->request->params['named'])); ?>
                   <?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>
					<?php echo $this->Form->input('filter_id', array('type' => 'hidden', 'value' => (!empty($this->request->params['named']['filter_id']) ? $this->request->params['named']['filter_id'] : ''))); ?>
                    <?php
                    echo $this->Form->submit(__l('Search'));
                    echo $this->Form->end();
                ?>
                </div>
            <div class="clearfix grid_right add-block1">
                <?php echo $this->Html->link(__l('Add'), array('controller' => 'items', 'action' => 'add'), array('class' => 'add','title' => __l('Add'))); ?>
            </div>
            </div>
    <?php //endif; ?>   
    		<div class="">   
				  <?php echo $this->Form->create('Item' , array('class' => 'normal','action' => 'update')); ?>
                  <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
                
                   <div class="overflow-block">
                  <table class="list" id="js-expand-table">
                    <tr class="js-even">
                      <th rowspan="2" class="select admin-select"></th>
					  <th rowspan="2" class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Item'),'Item.name'); ?></div></th>
                      <th rowspan="2" class="quantity-sold"><div class="js-pagination"><?php echo __l('Date'); ?><div><?php echo $this->Paginator->sort(__l('Start'), 'Item.start_date'); ?><?php echo '/'.$this->Paginator->sort(__l('End'), 'Item.end_date'); ?></div></div></th>
                      <th rowspan="2" class="quantity-sold"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Quantities Sold'),'Item.item_user_count'); ?></div></th>
                      <th rowspan="2" class="dr"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Sales'),'Item.total_purchased_amount').' ('.Configure::read('site.currency').')'; ?></div></th>
                      <th colspan="4"><?php echo __l('Share'); ?></th>
					</tr>
                    <tr class="js-even">                      
                      <th class="dr"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Merchant'),'Item.total_merchant_earned_amount').' ('.Configure::read('site.currency').')'; ?></div></th>
                      <th class="dr"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Charity'),'Item.total_charity_amount').' ('.Configure::read('site.currency').')'; ?></div></th>
                      <th class="dr"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Affiliate'),'Item.total_affiliate_amount').' ('.Configure::read('site.currency').')'; ?></div></th>
                      <th class="dr"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Site / Revenue'),'Item.total_commission_amount').' ('.Configure::read('site.currency').')'; ?></div></th>
                    </tr>
                    <?php
                        if (!empty($items)):
                            $i = 0;
                            foreach ($items as $item):
                            $status_class = '';
                                 $class = null;
                                if ($i++ % 2 == 0):
                                    $class = 'altrow';
                                endif;
                                if($item['Item']['item_status_id'] == ConstItemStatus::Open):
                                    $status_class = ' js-checkbox-active';
                                endif;
                                if($item['Item']['item_status_id'] == ConstItemStatus::PendingApproval):
                                    $status_class = ' js-checkbox-inactive';
                                endif;
								$original_price = $item['Item']['price'];
								$be_next_increase_price = $item['Item']['be_next_increase_price'];
								$bonus_amount = $item['Item']['bonus_amount'];
								$commission_percentage = $item['Item']['commission_percentage'];
								$total_commission_amount = $item['Item']['total_commission_amount'];
								$max_limit = $item['Item']['max_limit'];
                                ?>
                    <tr class="<?php echo $class;?> expand-row js-odd">
					  
                       <td class="<?php echo $class;?> select admin-select">
                          		<div class="arrow"></div>
                       <?php if(!empty($moreActions)): ?>
                              <?php echo $this->Form->input('Item.'.$item['Item']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$item['Item']['id'], 'label' => false, 'class' => 'js-checkbox-list '. $status_class. '' )); ?>
                       <?php endif; ?> 
                      </td>
                      <td class="dl item-name">
                        <div class="clearfix">
                             <span title="<?php echo $item['ItemStatus']['name']; ?>" class="<?php echo 'item-atatus-info item-status-'.strtolower(str_replace(" ","",$item['ItemStatus']['name']));?>">
    						 <?php echo $this->Html->cText($item['ItemStatus']['name'],false); ?></span>
    						 <?php echo $this->Html->truncate($this->Html->cText($item['Item']['name'],false),90, array('ending' => '...')); ?>
                        </div>
                      </td>
                      <td class="quantity-sold">
					  <div class="clearfix">
                       <div class="grid_2 omega alpha item-bought-count"></div>
                       <div class="item-bought-info item-date-info omega alpha">
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
                           <span class="round-5 <?php echo ($item['Item']['end_date'] === null)? ' any-time-item-progress': 'progress-status '; ?>" style="width:<?php echo $item_progress_precentage; ?>%" title="<?php echo $item_progress_precentage; ?>%">&nbsp;</span>
                        </p>
                        <p class="progress-value clearfix"><span class="progress-from"><?php echo ($item['Item']['item_status_id'] == ConstItemStatus::PendingApproval || $item['Item']['item_status_id'] == ConstItemStatus::Draft || $item['Item']['item_status_id'] == ConstItemStatus::Rejected)? '-' :$this->Html->cDateTimeHighlight($item['Item']['start_date']);?></span><span class="progress-to"><?php echo (!is_null($item['Item']['end_date']))? $this->Html->cDateTimeHighlight($item['Item']['end_date']): ' - ';?></span></p>
                       </div>
                        </div>
					   </td>
					  <td  class="quantity-sold">
                         <div class="clearfix">
                       <div class="item-count">
                       <?php echo $this->Html->cInt($item['Item']['item_user_count']);?>
                       </div>
                       <div class="clearfix">
                       <div class="item-bought-info grid_4 omega alpha">
                        <?php
							$pixels = 0;
                            $pixels = round(($item['Item']['item_user_count']/$item['Item']['min_limit']) * 100);
							if($pixels > 100)
							{
								$pixels = 100;
							}
                        ?>
                        <p class="progress-bar round-5">
                           <span class="progress-status round-5" style="width:<?php echo $pixels; ?>%" title="<?php echo $pixels; ?>%">&nbsp;</span>
                        </p>
                        <p class="progress-value clearfix"><span class="progress-from">0</span><span class="progress-to"><?php echo $this->Html->cInt($item['Item']['min_limit']); ?></span></p>
                       </div>
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
                     	<h3> <?php echo __l('Action'); ?> </h3>
                                <ul>
                                <li><?php echo $this->Html->link(__l('Preview'), array('controller' => 'items', 'action' => 'view', $item['Item']['slug'], 'city' => (!empty($city_new_slug) ? $city_new_slug : ''), 'admin' => false), array('class'=>'preview','title'=>__l('Preview'), 'escape' => false));?></li>
                                    <?php if(!empty($this->request->params['named']['filter_id']) && (($this->request->params['named']['filter_id'] == ConstItemStatus::Tipped) || ($this->request->params['named']['filter_id'] == ConstItemStatus::Closed) || ($this->request->params['named']['filter_id'] == ConstItemStatus::PaidToMerchant))):?>
                                            <li><?php echo $this->Html->link(__l('CSV'), array('controller' => 'items', 'action' => 'passes_export', 'admin' => false,'item_id:'.$item['Item']['id'],'ext' => 'csv'), array('class' => 'export', 'title' => __l('CSV')));?></li>
                                            <li> <?php echo $this->Html->link(__l('Print'),array('controller' => 'items', 'action' => 'items_print', 'filter_id' => $this->request->params['named']['filter_id'],'page_type' => 'print', 'item_id' => $item['Item']['id']),array('title' => __l('Print'), 'target' => '_blank', 'class'=>'print-icon'));?></li>
                                       <?php endif; ?>
									<?php if(!empty($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == ConstItemStatus::Draft)):?>
										<li><?php echo $this->Html->link(__l('Preview'), array('controller' => 'items', 'action' => 'view', $item['Item']['slug'], 'city' => (!empty($city_new_slug) ? $city_new_slug : ''), 'admin' => false), array('class'=>'preview','title'=>__l('Preview'), 'escape' => false));?></li>
								   <?php endif; ?>
                                      <?php if(!empty($item['Item']['item_status_id']) && $item['Item']['item_status_id'] != ConstItemStatus::PendingApproval && $item['Item']['item_status_id'] != ConstItemStatus::Rejected && $item['Item']['item_status_id'] != ConstItemStatus::Draft) {?>
                                       <li><?php echo $this->Html->link(sprintf(__l('Quantities Sold  (%s)'),$this->Html->cInt($item['Item']['item_user_count'], false)),array('controller'=>'item_users', 'action'=>'index', 'item_id'=>$item['Item']['id']), array('class' => 'sold js-edit pass-sold', 'title' => __l('Quantity Sold')));?></li>
                                        <?php } ?>
                                        <li>
                                        <?php
                                            echo $this->Html->link(__l('Edit'), array('controller' => 'items', 'action'=>'edit', $item['Item']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));
                                        ?>
                                        </li>
										<li>
                                      <?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $item['Item']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?>
                                        </li>
									  <li><?php echo $this->Html->link(__l('Clone Item'),array('controller'=>'items', 'action'=>'add', 'clone_item_id'=>$item['Item']['id']), array('class' => 'add', 'title' => __l('Clone Item')));?></li>
									  <li>
                                        <?php echo $this->Html->link(__l('Stats'), array('controller'=>'charts', 'action'=>'chart_item_stats', $item['Item']['id'], 'admin' => true),array('class' => 'item-stats', 'target' => '_blank'));?>
                                        </li>
                                        <li>
                                            <?php echo $this->Html->link(__l('List Allocated Pass'), array('controller' => 'item_passes', 'action' => 'index', 'item_id' =>  $item['Item']['id']), array('class' =>'list-pass', 'target' => '_blank', 'title' => __l('List Allocated Pass')));?>
                                        </li>
        							 </ul>
        						
							   </div>
							     <div class="action-right-block item-action-right-block clearfix">
							      <?php if(!empty($item['Item']['private_note'])) : ?>
							      <div class="clearfix">
    							        <h3 class="private-note-title"><?php echo __l('Private Note');?></h3>
                                        <div class="private-note">
                                              <?php echo $item['Item']['private_note'];?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                  
                               	  <div class="clearfix">
                                   	  <div class="action-right action-right1">
                                       <h3><?php echo __l('Price'); ?></h3>
                                       <dl class="clearfix">
        								   <dt><?php echo __l('Original Price').' ('.Configure::read('site.currency') . ')'; ?></dt><dd><?php echo $this->Html->cCurrency($original_price); ?></dd>
        								   <dt><?php echo __l('Be Next Increase Price').' ('.Configure::read('site.currency') . ')'; ?></dt><dd><?php echo $this->Html->cCurrency($be_next_increase_price); ?></dd>
                                       </dl>
                                   </div>
                                     <div class="action-right">
                                       <h3><?php echo __l('Commission'); ?></h3>
                                       <dl class="clearfix">
        								   <dt><?php echo __l('Bonus Amount').' ('.Configure::read('site.currency') . ')'; ?></dt><dd><?php echo $this->Html->cCurrency($bonus_amount); ?></dd>
        								   <dt><?php echo __l('Commission').' (%)'; ?></dt><dd><?php echo $this->Html->cFloat($commission_percentage); ?></dd>
        								   <dt><?php echo __l('Total Commission Amount').' ('.Configure::read('site.currency') . ')'; ?></dt><dd><?php echo $this->Html->cCurrency($total_commission_amount); ?></dd>
                                       </dl>
                                   </div>
                                     <div class="action-right action-right3">
                                        <h3><?php echo __l('Item Limit'); ?></h3>
                                       <dl class="clearfix">
                                           <dt><?php echo __l('Minimum'); ?></dt><dd><?php echo $this->Html->cInt($item['Item']['min_limit']); ?></dd>
                                           <dt><?php echo __l('Maximum'); ?></dt><dd><?php echo $this->Html->cInt($max_limit); ?></dd>
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
                                         <dt><?php echo __l('City');?></dt>
                                         <dd><?php echo implode(', ', $cities_list); ?></dd>
                                    </dl>
                                    <?php endif; ?>
                                </div>
								<div class="city-action">
                                   <?php
    								$interests_list =array();
    								if(isset($item['UserInterest']) && !empty($item['UserInterest'])):
    								foreach($item['UserInterest'] as $interest_sub):
    									$interests_list[] =  $this->Html->link($interest_sub['name'], array('controller' => 'items', 'action'=>'index', 'interest_slug' => $interest_sub['slug']),array('title' => sprintf(__l('%s'), $interest_sub['name'])));
    								endforeach;
    								endif;
    								?>
                                    <?php if(!empty($interests_list)) :?>
                                    <dl class="clearfix">
                                         <dt><?php echo __l('Interests');?></dt>
                                         <dd><?php echo implode(', ', $interests_list); ?></dd>
                                    </dl>
                                    <?php endif; ?>
                                </div>
								<?php if (Configure::read('item.is_enable_item_category')): ?>
								<div class="city-action">
                                   <?php
    								$categories_list =array();
    								if(isset($item['ItemCategory']) && !empty($item['ItemCategory'])):
    								foreach($item['ItemCategory'] as $category_sub):
    									$categories_list[] =  $this->Html->link($category_sub['name'], array('controller' => 'items', 'action'=>'index', 'category_slug' => $category_sub['slug']),array('title' => sprintf(__l('%s'), $category_sub['name'])));
    								endforeach;
    								endif;
    								?>
                                    <?php if(!empty($categories_list)) :?>
                                    <dl class="clearfix">
                                         <dt><?php echo __l('Categories');?></dt>
                                         <dd><?php echo implode(', ', $categories_list); ?></dd>
                                    </dl>
                                    <?php endif; ?>
                                </div>
								<?php endif; ?>
                                </div>
                                <div class="action-right action-right-block action-right4">
                                 
    								<div class="item-img-block">
                                        <?php echo $this->Html->link($this->Html->showImage('Item', (!empty($item['Attachment'][0]) ? $item['Attachment'][0] : ''), array('dimension' => 'normal_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($item['Item']['name'], false)), 'title' => $this->Html->cText($item['Item']['name'], false))), array('controller' => 'items', 'action' => 'view', $item['Item']['slug'], 'city' => (!empty($city_new_slug) ? $city_new_slug : ''), 'admin' => false), array('title'=>$this->Html->cText($item['Item']['name'],false),'escape' => false));?>
                                    </div>
                                   <dl class="clearfix">
                                            <dt><?php echo __l('Added 0n').': '?>  </dt>
                                            <dd><?php echo $this->Html->cDateTimeHighlight($item['Item']['created']); ?> </dd>
                                            <dt><?php echo __l('Status: '); ?> </dt>
                                            <dd>
                                            <div class="clearfix">
                                            <span title="<?php echo $item['ItemStatus']['name']; ?>" class="<?php echo 'item-atatus-info item-status-'.strtolower(str_replace(" ","",$item['ItemStatus']['name']));?>">&nbsp;
                                             </span>
                                            <?php echo $this->Html->cText($item['ItemStatus']['name']); ?>
                                           </div>
                                            </dd>
											 <dt><?php echo __l('Merchant').': '?></dt>
                                            <dd> <?php echo $this->Html->link($this->Html->cText($item['Merchant']['name'], false), array('controller' => 'merchants', 'action' => 'view', $item['Merchant']['slug'], 'admin' => false),array('title' =>$this->Html->cText($item['Merchant']['name'],false)), null, false); ?> </dd>
                                    </dl>
                               </div>
                              
                             
                               </div>
                    </td>
                    </tr>
                    <?php
                            endforeach;
                        else:
                            ?>
                    <tr class="js-odd">
                      <td colspan="9" class="notice"><?php echo __l('No Items available');?></td>
                    </tr>
                    <?php
                        endif;
                        ?>
                  </table>
                  </div>
                  <?php if (!empty($items)):?>
                  	<div class="clearfix">
                      <div class="admin-select-block grid_left">
                      <?php
                      if(!empty($this->request->params['named']['filter_id'])) { ?>
                        <div>
                        	<?php if(!empty($moreActions)): ?>
								<?php echo __l('Select:'); ?>
                                <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
                                <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
                            <?php endif; ?>
                        </div>
                       <?php } ?>
                        <div class="admin-checkbox-button"><?php 
                            if(!empty($moreActions)):
                                echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --')));
                            endif;
                             ?></div>
                                       </div>
                      <div class="grid_right"> <?php echo $this->element('paging_links'); ?> </div>
                      </div>
                  <?php endif; ?>
                  <?php echo $this->Form->end(); ?>
             </div>
    </div>
</div>