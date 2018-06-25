<?php /* SVN: $Id: admin_index.ctp 71610 2011-11-15 21:16:00Z josephine_065at09 $ */ ?>
	<div class="itemUsers index js-response js-responses">
    <div class="js-search-responses">
	<?php 
		if(!empty($this->request->params['isAjax'])):
			echo $this->element('flash_message');
		endif;
	?>
	<div class="clearfix">
        <div class="grid_15 omega alpha">
        
        <ul class="pass-chart clearfix">
        <li class="common-link clearfix">
        <div class="pass-top-block clearfix">
          <div class="pass-bottom-block clearfix">
          <div class="pass-inner-block clearfix">
          <span class="pending-approval">
                <?php echo $this->Html->link(sprintf(__l('Pending (%s)'),$open),array('controller' => 'item_users', 'action' => 'index', 'filter_id' => 'open'), array('title' => __l('Pending'))); ?>
            </span>
           
         <ul class="pass-cancel clearfix">
         <li>
            <div class="clearfix">
            <ul class="pass-canceled">
                <li class="canceled clearfix">
                <span class="canceled">
                    <?php echo $this->Html->link(sprintf(__l('Canceled (%s)'),$canceled),array('controller' => 'item_users', 'action' => 'index', 'filter_id' => 'canceled'), array('title' => __l('Canceled'))); ?>
                </span>
                </li>
                </ul>
                </div>
                </li>
        <li>
            <div class="clearfix">
            <ul class="pass-available">
                <li class="open clearfix">
                <div class="pass-top-block clearfix">
          <div class="pass-bottom-block clearfix">
                    <span class="open">
                      <?php echo $this->Html->link(sprintf(__l('Available (%s)'), $available), array('controller' => 'item_users', 'action' => 'index', 'filter_id' => 'available'), array('title' => __l('Available')));?>
                    </span>
                    <ul class="expired-block">
                        <li class="expired clearfix">
                            <span class="expired">
                            	<?php echo $this->Html->link(sprintf(__l('Expired (%s)'), $expired), array('controller' => 'item_users', 'action' => 'index', 'filter_id' => 'expired'), array('title' => __l('Expired')));?>
                            </span>
                        </li>
                        <li class="closed clearfix">
                            <span class="used">
                               <?php echo $this->Html->link(sprintf(__l('Used (%s)'), $used), array('controller' => 'item_users', 'action' => 'index', 'filter_id' => 'used'), array('title' => __l('Used'))); ?>
                            </span>
                        </li>
                    </ul>
                    </div>
                    </div>

                </li>
                </ul>
                </div>
                </li>
                   <li>
            <div class="clearfix">
            <ul class="pass-refunded">
                <li class="refunded clearfix">
                
                 <span class="refunded">
                   <?php echo $this->Html->link(sprintf(__l('Refunded (%s)'),$refunded),array('controller' => 'item_users', 'action' => 'index', 'filter_id' => 'refunded'), array('title' => __l('Refunded'))); ?>
                 </span>
                </li>
                </ul>
                </div>
                </li>

            </ul>
             </div>
            </div>
            </div>
              </li>
           </ul>

           

</div>
    <div class="grid_right filter-list-info omega alpha">
		<ul class="clearfix filter-list">
            <li class="all"><?php  echo $this->Html->link(sprintf(__l('All (%s)'), $all),array('controller' => 'item_users', 'action' => 'index', 'filter_id' => 'all'), array('title' => __l('All'))); ?></li>
        </ul>
        </div>
     </div>
        <div class="page-count-block clearfix">
        	<div class="grid_left">
              <?php echo $this->element('paging_counter');?>
          </div>
         	<div class="grid_left">
              <?php echo $this->Form->create('ItemUser', array('type' => 'post', 'class' => 'normal search-form clearfix', 'action'=>'index')); ?>
                    <div class="mapblock-info">
                        <?php echo $this->Form->autocomplete('item_name', array('label' => __l('Item'), 'acFieldKey' => 'Item.id', 'acFields' => array('Item.name'), 'acSearchFieldNames' => array('Item.name'), 'maxlength' => '255')); ?>
                        <div class="autocompleteblock">            
                        </div>
                    </div>               
					<?php if (!empty($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == 'available' || $this->request->params['named']['filter_id'] == 'used')): ?>
						<?php echo $this->Form->input('pass_code', array('label' => __l('Pass code')));?>
					<?php endif;?>
                    <?php if(!empty($this->request->data['ItemUser']['filter_id'])): ?>
						<?php echo $this->Form->input('filter_id', array('type' => 'hidden'));?>
                    <?php elseif(!empty($this->request->data['ItemUser']['item_id'])): ?>
						<?php echo $this->Form->input('item_id', array('type' => 'hidden'));?>
                    <?php endif; ?>
                    <?php echo $this->Form->submit(__l('Search'),array('name' => 'data[ItemUser][search]'));?>
                <?php echo $this->Form->end(); ?>
                </div>
        </div>
		<?php echo $this->Form->create('ItemUser' , array('class' => 'normal js-ajax-form','action' => 'update'));?>
        <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url.$param_string)); ?>
      
        <div class="overflow-block">
        <table class="list">
            <tr>
				<?php if(!empty($this->request->params['named']['filter_id'])  && ($this->request->params['named']['filter_id'] != 'expired')): ?>
					<th rowspan="2" class="select"></th>
					<th rowspan="2" class="actions"><?php echo __l('Actions');?></th>
				<?php endif;?>
                <th rowspan="2"><div class=""><?php echo $this->Paginator->sort(__l('Purchased Date'),'ItemUser.created');?></div></th>
				<?php if(!empty($this->request->params['named']['filter_id'])  && ($this->request->params['named']['filter_id'] == 'canceled')): ?>
	                <th rowspan="2"><div class=""><?php echo $this->Paginator->sort(__l('Canceled Date'),'ItemUser.modified');?></div></th>
				<?php endif;?>
                <th rowspan="2" class="dl"><div class=""><?php echo $this->Paginator->sort(__l('User'),'User.username');?></div></th>
                <th rowspan="2" class="dl item-name"><div class=""><?php echo $this->Paginator->sort(__l('Item'), 'Item.name');?></div></th>
				<?php if ((!empty($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == 'available' || $this->request->params['named']['filter_id'] == 'used')) || (empty($this->request->params['named']['filter_id']) && !empty($is_show_pass_code))): ?>
					<th rowspan="2" class="dc"><div class=""><?php echo __l('Pass Code');?><div><?php echo __l('Top/Bottom');?></div></div></th>
				<?php endif;?>
                <th rowspan="2" class="dc"><div class=""><?php echo $this->Paginator->sort(__l('Quantities'), 'ItemUser.quantity');?></div></th>
                <th rowspan="2" class="dr"><div class=""><?php echo $this->Paginator->sort(__l('Price'), 'ItemUser.discount_amount').' ('.Configure::read('site.currency').')';?></div></th>
                <th rowspan="2" class="dr"><div class=""><?php echo $this->Paginator->sort(__l('Be Next Increase Price'), 'Item.be_next_increase_price').' ('.Configure::read('site.currency').')';?></div></th>
                <th rowspan="2" class="dr"><div class=""><?php echo __l('Total').' ('.Configure::read('site.currency').')';?></div></th>       
				<?php if(Configure::read('charity.is_enabled') == 1):?>
				<th colspan="4"><?php echo __l('Charity Contributions');?></th>
				<?php endif; ?>
            </tr>
			<tr>
				<?php if(Configure::read('charity.is_enabled') == 1):?>
				<th class="dr"><div class=""><?php echo __l('From');?><div><?php echo __l('Site').' ('.Configure::read('site.currency').')';?></div></div></th>
                <th class="dr"><div class=""><?php echo __l('From');?><div><?php echo __l('Merchant').' ('.Configure::read('site.currency').')';?></div></div></th>
                <th class="dr"><div class=""><?php echo __l('Total').' ('.Configure::read('site.currency').')';?></div></th>
                <th class="dl"><div class=""><?php echo __l('Charity');?><div><?php echo __l('Name');?></div></div></th>
				<?php endif; ?>
			</tr>
	<?php
        if (!empty($itemUsers)):
        
        $i = 0;
        foreach ($itemUsers as $itemUser):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
			if($itemUser['ItemUser']['item_user_pass_count'] == $itemUser['ItemUser']['quantity']):
                $status_class = 'js-checkbox-active';
            else:
                $status_class = 'js-checkbox-inactive';
            endif;
        ?>
            <tr<?php echo $class;?>>
				<?php if(!empty($this->request->params['named']['filter_id'])  && ($this->request->params['named']['filter_id'] != 'expired')): ?>
                <td class="select">
                    <?php echo $this->Form->input('ItemUser.'.$itemUser['ItemUser']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$itemUser['ItemUser']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?>
				</td>
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
                                <li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $itemUser['ItemUser']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
                                <?php if(!$itemUser['ItemUser']['is_repaid'] && !$itemUser['ItemUser']['is_canceled']): ?>
                                <li><?php echo $this->Html->link(__l('Print'),array('controller' => 'item_users', 'action' => 'view',$itemUser['ItemUser']['id'],'type' => 'print', 'filter_id' => $this->request->params['named']['filter_id'], 'admin' => false),array('title' => __l('Print'), 'class'=>'print-icon','target' => '_blank'));?></li>
                                 <li><?php echo $this->Html->link(__l('View Pass'),array('controller' => 'item_users', 'action' => 'view',$itemUser['ItemUser']['id'], 'filter_id' => $this->request->params['named']['filter_id'],'admin' => false),array('title' => __l('View Pass'), 'class'=>'view-icon js-thickbox','target' => '_blank'));?></li>
                                <?php endif; ?>
        					</ul>
        					</div>
        						<div class="action-bottom-block"></div>
							  </div>

							 </div>
    			</td>
				<?php endif;?>
                <td class="dc"><?php echo $this->Html->cDateTime($itemUser['ItemUser']['created']);?></td>
				<?php if(!empty($this->request->params['named']['filter_id'])  && ($this->request->params['named']['filter_id'] == 'canceled')): ?>
					<td class="dc"><?php echo $this->Html->cDateTime($itemUser['ItemUser']['modified']);?></td>
				<?php endif; ?>
                <td class="dl">
                <?php echo $this->Html->getUserAvatarLink($itemUser['User'], 'micro_thumb',false);?>
                <?php echo $this->Html->getUserLink($itemUser['User']);?></td>
                <td class="dl item-name">
					<?php echo $this->Html->showImage('Item', $itemUser['Item']['Attachment'][0], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($itemUser['Item']['name'], false)), 'title' => $this->Html->cText($itemUser['Item']['name'], false)));?>
					<span>
						<?php echo $this->Html->link($this->Html->cText($itemUser['Item']['name'],false), array('controller' => 'items', 'action' => 'view', $itemUser['Item']['slug'], 'admin' => false), array('title'=>$this->Html->cText($itemUser['Item']['name'],false),'escape' => false));?>
					</span>
				</td>
				<?php if ((!empty($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == 'available' || $this->request->params['named']['filter_id'] == 'used')) || (empty($this->request->params['named']['filter_id']) && !empty($is_show_pass_code))): ?>
                <td class="dl">
					<ul>
					<?php foreach($itemUser['ItemUserPass'] as $itemUserPass){?>
						<?php if ((!empty($pass_find_id) && in_array($itemUserPass['id'], $pass_find_id)) || (empty($pass_find_id) && !empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'available' && $itemUserPass['is_used'] == 0) || (empty($pass_find_id) && !empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'used' && $itemUserPass['is_used'] == 1) || !isset($this->request->params['named']['filter_id']) || (empty($pass_find_id) && $this->request->params['named']['filter_id'] != 'used' && $this->request->params['named']['filter_id'] != 'available')) { ?>
							<?php 
								if(!empty($itemUserPass['is_used'])):
									$image = 'icon-used.png';
								else:
									$image = 'icon-not-used.png';
								endif;
							?>
							<li>
								<?php echo $this->Html->cText($itemUserPass['pass_code']).'/'.$this->Html->cText($itemUserPass['unique_pass_code']);?>
								<?php if(!empty($this->request->params['named']['filter_id'])  && ($this->request->params['named']['filter_id'] != 'used') && ($this->request->params['named']['filter_id'] != 'available')): ?>
									<?php echo $this->Html->image($image);?>
								<?php endif;?>
							</li>
						<?php } ?>
					<?php } ?>
					</ul>
				</td>
				<?php endif;?>
				<td class="dc"><?php echo $this->Html->cInt($itemUser['ItemUser']['quantity']);?></td>
				<td class="dr"><?php echo $this->Html->cFloat($itemUser['Item']['price']);?></td>
				<?php
					$is_next = ($itemUser['ItemUser']['discount_amount'] / $itemUser['ItemUser']['quantity']) - $itemUser['Item']['price'];
				?>
				<td class="dr"><?php echo !empty($is_next) ? $this->Html->cFloat($is_next) : '-';?></td>
				<td class="dr"><?php echo $this->Html->cFloat($itemUser['ItemUser']['discount_amount']);?></td>  
				<?php if(Configure::read('charity.is_enabled') == 1):?>
				<td class="dr"><?php echo (!empty($itemUser['CharitiesItemUser']['Charity']['name']) ? $this->Html->cCurrency($itemUser['CharitiesItemUser']['site_commission_amount']) : '-');?></td>		
				<td class="dr"><?php echo (!empty($itemUser['CharitiesItemUser']['Charity']['name']) ? $this->Html->cCurrency($itemUser['CharitiesItemUser']['seller_commission_amount']) : '-');?></td>	
				<td class="dr"><?php echo (!empty($itemUser['CharitiesItemUser']['Charity']['name']) ? $this->Html->cCurrency($itemUser['CharitiesItemUser']['site_commission_amount'] + $itemUser['CharitiesItemUser']['seller_commission_amount']) : '-');?></td>		
				<td class="dl"><?php echo $this->Html->cText((!empty($itemUser['CharitiesItemUser']['Charity']['name']) ? $itemUser['CharitiesItemUser']['Charity']['name'] : '-'));?></td>		
				<?php endif ?>
            </tr>
        <?php
            endforeach;
        else:
        ?>
            <tr>
                <td colspan="14" class="notice"><?php echo __l('No pass available');?></td>
            </tr>
        <?php
        endif;
        ?>
        </table>
        </div>
		<?php if (!empty($itemUsers)):?>
        	<div class="clearfix">
			<?php if(!empty($this->request->params['named']['filter_id'])  && ($this->request->params['named']['filter_id'] != 'expired')): ?>
            <div class="admin-select-block grid_left">
            <div>
                <?php echo __l('Select:'); ?>
                <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
                <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
                <?php if($this->request->params['named']['filter_id'] == 'all' || (!empty($this->request->params['named']['item_id']))) { ?>
                    <?php echo $this->Html->link(__l('Use Now'), '#', array('class' => 'js-admin-select-approved', 'title' => __l('Use Now'))); ?>
                    <?php echo $this->Html->link(__l('Not Used'), '#', array('class' => 'js-admin-select-pending', 'title' => __l('Not Used'))); ?>
                <?php } ?>
            </div>
            <div class="admin-checkbox-button"><?php echo $this->Form->input('more_action_id', array('options' => $moreActions, 'type'=>'select','class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
            </div>
			<?php endif; ?>
            <div class=" grid_right">
            <?php echo $this->element('paging_links'); ?>
            </div>    
            </div>
        <?php  endif;  ?>
        <div class="hide">
            <?php echo $this->Form->end('Submit'); ?>
        </div>
        </div>
        </div>
