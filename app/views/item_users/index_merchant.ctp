<?php /* SVN: $Id: index.ctp 71610 2011-11-15 21:16:00Z josephine_065at09 $ */ ?>
<div class="itemUsers index js-response js-responses js-update-status-over-block">
<?php if(!empty($pageTitle)): ?>
        <h2><?php echo $pageTitle;?></h2>
<?php endif; ?>
<?php if(!empty($show_tab) || Configure::read('user.is_merchant_actas_normal_user') && empty($this->request->params['isAjax'])){?>
<div class="clearfix">
        <div class="pass-list-block omega alpha">
  <ul class="pass-chart clearfix">
        <li class="common-link clearfix">
        <div class="pass-top-block clearfix">
          <div class="pass-bottom-block clearfix">
          <div class="pass-inner-block clearfix">
          <span class="pending-approval">
              <div class="js-pagination"><?php echo $this->Html->link(sprintf(__l('Pending (%s)'),$open),array('controller' => 'item_users', 'action' => 'index', 'item_id' => $item_id, 'type' => 'open'), array('title' => 'Pending-'.$open)); ?></div>
            </span>

         <ul class="pass-cancel clearfix">
         <li>
            <div class="clearfix">
            <ul class="pass-canceled">
                <li class="canceled clearfix">
                <span class="canceled">
                    <div class="js-pagination"><?php echo $this->Html->link(sprintf(__l('Canceled (%s)'),$canceled),array('controller' => 'item_users', 'action' => 'index', 'item_id' => $item_id, 'type' => 'canceled'), array('title' => 'Canceled-'.$canceled)); ?></div>
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
                      <div class="js-pagination"><?php echo $this->Html->link(sprintf(__l('Available (%s)'),$available),array('controller' => 'item_users', 'action' => 'index', 'item_id' => $item_id, 'type' => 'available'), array('title' => 'Available-'.$available)); ?></div>
                    </span>
                    <ul class="expired-block">
                        <li class="expired clearfix">
                            <span class="expired">
                            	<div class="js-pagination"><?php echo $this->Html->link(sprintf(__l('Expired (%s)'),$expired),array('controller' => 'item_users', 'action' => 'index', 'item_id' => $item_id, 'type' => 'expired'), array('title' => 'Expired-'.$expired)); ?></div>
                            </span>
                        </li>
                        <li class="closed clearfix">
                            <span class="used">
                                <div class="js-pagination"><?php echo $this->Html->link(sprintf(__l('Used (%s)'),$used),array('controller' => 'item_users', 'action' => 'index', 'item_id' => $item_id, 'type' => 'used'), array('title' => 'Used-'.$used)); ?></div>
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
                   <div class="js-pagination"><?php echo $this->Html->link(sprintf(__l('Refund (%s)'),$refund),array('controller' => 'item_users', 'action' => 'index', 'item_id' => $item_id, 'type' => 'refund'), array('title' => 'Refund-'.$refund)); ?></div>
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

            <li class="all"><div class="js-pagination"><?php echo $this->Html->link(sprintf(__l('All (%s)'),$all_items),array('controller'=> 'item_users','item_id'=>$item_id, 'action'=>'index','type' => 'all'),array('title' => 'All-'.$all_items)); ?></div></li>
 		</ul>
 		</div>
 		</div>
		<?php } ?>
		<?php if (($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) && (!empty($this->request->params['named']['item_id']) && (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'available' || $this->request->params['named']['type'] == 'used')) ||  (!empty($show_pass_code) && (!empty($this->request->params['named']['item_user_view']) && $this->request->params['named']['item_user_view'] == 'pass')))) { ?>
			<?php echo $this->Form->create('ItemUser', array('type' => 'post', 'class' => 'normal search-form clearfix js-ajax-form', 'action'=>'index')); ?>
				<div>
					<?php 
						echo $this->Form->input('pass_code', array('label' => __l('Pass code')));
						echo $this->Form->input('item_id', array('type' => 'hidden', 'value' => $this->request->params['named']['item_id']));
						echo $this->Form->input('item_user_view', array('type' => 'hidden', 'value' => $this->request->params['named']['item_user_view']));
						if(!empty($this->request->data['ItemUser']['type'])):
							echo $this->Form->input('type', array('type' => 'hidden'));
						endif;
						echo $this->Form->submit(__l('Search'));
					?>
				</div>
			<?php echo $this->Form->end(); ?>
		<?php } ?>
		<?php
			echo $this->Form->create('ItemUser' , array('class' => 'normal','action' => 'update'));
			echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url));
			if (!empty($this->request->params['named']['item_id'])):
				echo $this->Form->input('item_id', array('type' => 'hidden', 'value' => $this->request->params['named']['item_id']));
			elseif (!empty($this->request->params['named']['type'])):
				echo $this->Form->input('type', array('type' => 'hidden', 'value' => $this->request->params['named']['type']));
			endif;
		?>
        <div class="grid_left">
              <?php echo $this->element('paging_counter');?>
          </div>
		<table class="list">
			<tr>
				<?php
                if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'open' && ($this->Auth->user('user_type_id') == ConstUserTypes::User || ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant && empty($this->request->params['named']['item_id'])))) { ?>
                    <th rowspan="2" class="actions"><?php echo __l('Action'); ?></th>
                    <?php
                } ?>
				<?php if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'available' || $this->request->params['named']['type'] == 'used')) { ?>
				  <th rowspan="2" class="select"></th>
				<?php } ?>
                <?php if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'available' || $this->request->params['named']['type'] == 'used') || (!empty($show_pass_code) && (!empty($this->request->params['named']['item_user_view']) && $this->request->params['named']['item_user_view'] == 'pass'))) { ?>
					<th rowspan="2" class="actions"><?php echo __l('Action');?></th>
				<?php } ?>
				<th rowspan="2"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Purchased Date'), 'created');?></div></th>
				<?php if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'canceled') { ?>
					<th rowspan="2"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Canceled Date'), 'modified');?></div></th>
				<?php } ?>
                <?php if(($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) && !empty($this->request->params['named']['item_id'])): ?>
					<th rowspan="2"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Username'), 'User.username');?></div></th>
                <?php endif; ?>
                <?php if(!empty($item_id) || !empty($this->request->params['named']['item_id'])): ?>
					<th rowspan="2"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Amount'), 'discount_amount') . ' ('.Configure::read('site.currency').')';?></div></th>
				<?php else: ?>					
					<th rowspan="2"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Item'), 'item_id');?></div></th>
				<?php endif; ?>
				<?php if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'available' || $this->request->params['named']['type'] == 'used') ||  (!empty($show_pass_code) && (!empty($this->request->params['named']['item_user_view']) && $this->request->params['named']['item_user_view'] == 'pass'))): ?>
					<?php if(($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) ||  ($this->Auth->user('user_type_id') == ConstUserTypes::Admin)):?>
						<th colspan='3'><div class="js-pagination"><?php echo __l('Pass code');?></div></th>
					<?php elseif(($this->Auth->user('user_type_id') == ConstUserTypes::User)):?>
						<th colspan='3'><div class="js-pagination"><?php echo __l('Pass code');?></div></th>
					<?php else:?>
						<th rowspan="2" ><div class="js-pagination"><?php echo __l('Pass code');?></div></th>
					<?php endif;?>
				<?php endif;?>
				<th rowspan="2"><?php echo __l('Quantities');?></th>				
				<?php if(Configure::read('charity.is_enabled') == 1):?>
				<th rowspan="2"><?php echo __l('Charity Contributions');?></th>
				<?php endif; ?>
            </tr>
			<tr>
			<?php if(($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) ||  ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) ||  ($this->Auth->user('user_type_id') == ConstUserTypes::User)):?>
				<?php if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'available' || $this->request->params['named']['type'] == 'used') ||  (!empty($show_pass_code) && (!empty($this->request->params['named']['item_user_view']) && $this->request->params['named']['item_user_view'] == 'pass'))): ?>
					<th class='actions'><div class="js-pagination"><?php echo __l('Action');?></div></th>
                    <th><div class="js-pagination"><?php echo __l('Bottom Code');?></div></th>
					<th><div class="js-pagination"><?php echo __l('Top Code');?></div></th>
				<?php endif;?>
			<?php endif;?>	
			</tr>				
			<?php
				if (!empty($itemUsers)):
					$i = 0;
					foreach ($itemUsers as $itemUser):
						$class = null;
						if ($i++ % 2 == 0) {
							$class = ' class="altrow"';
						}
						if($itemUser['ItemUser']['item_user_pass_count'] != 0):
							$status_class = 'js-checkbox-active';
						else:
							$status_class = 'js-checkbox-inactive';
						endif;
			?>
			<tr<?php echo $class;?>>
                <?php
                if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'open' && ($this->Auth->user('user_type_id') == ConstUserTypes::User || ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant && empty($this->request->params['named']['item_id'])))) { ?>
                    <td>
                        <?php
							if(!empty($itemUser['ItemUser']['is_canceled'])):
                                echo __l('Canceled');
                            else :
                                echo $this->Html->link(__l('Cancel'), array('controller' => 'item_users', 'action' => 'cancel_item', $itemUser['ItemUser']['id']), array('title' => __l('Cancel'), 'class' => 'js-item-cancel item-cancel'));
                            endif;
                            ?>
                    </td>
                    <?php
                }
                ?>
				<?php if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'available' || $this->request->params['named']['type'] == 'used')) { ?>
					<td class="select">
					<?php if(($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) && (Configure::read('item.item_pass_used_type') == 'submit')&& (!empty($itemUser['Item']['event_date']) && date('Y-m-d H:i:s') <= _formatDate('Y-m-d H:i:s', strtotime($itemUser['Item']['event_date'])))): ?>
						<?php echo $this->Form->input('ItemUser.'.$itemUser['ItemUser']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$itemUser['ItemUser']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?>
					</td>
					<?php endif; ?>
				<?php } ?>
				<?php if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'available' || $this->request->params['named']['type'] == 'used') || (!empty($show_pass_code) && (!empty($this->request->params['named']['item_user_view']) && $this->request->params['named']['item_user_view'] == 'pass'))) { ?>
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
                                      <li>
                                        <?php
                							echo $this->Html->link(__l('View Pass'),array('controller' => 'item_users', 'action' => 'view', 'filter_id' => (!empty($this->request->params['named']['type'])) ? $this->request->params['named']['type'] : '', $itemUser['ItemUser']['id'],'admin' => false),array('title' => __l('View Pass'), 'class'=>'js-thickbox','target' => '_blank', 'class'=>'view-icon js-thickbox'));
                                        ?>
                                        </li>
                                        <li>
                                        <?php
                                        	echo $this->Html->link(__l('Print'),array('controller' => 'item_users', 'action' => 'view', 'filter_id' => (!empty($this->request->params['named']['type'])) ? $this->request->params['named']['type'] : '', $itemUser['ItemUser']['id'],'type' => 'print'),array('target'=>'_blank', 'title' => __l('Print'), 'class'=>'print-icon'));
                						?>
                						</li>
        							 </ul>
        							</div>
        						<div class="action-bottom-block"></div>
							  </div>

							 </div>
                      
					</td>
                <?php } ?>
				<td><?php echo $this->Html->cDateTime($itemUser['ItemUser']['created']);?></td>
				<?php if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'canceled'): ?>
					<td><?php echo $this->Html->cDateTime($itemUser['ItemUser']['modified']);?></td>
				<?php endif;?>
                <?php if(($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) && !empty($this->request->params['named']['item_id'])): ?>
                    <td class="dl"><?php echo $this->Html->cText($itemUser['User']['username']);?></td>
                <?php endif; ?>
                <?php if(!empty($item_id) || !empty($this->request->params['named']['item_id'])): ?>
                    <td class="dr"><?php echo $this->Html->cCurrency($itemUser['ItemUser']['discount_amount']);?></td>
                <?php else: ?>
                    <td class="item-user-gift">
						<?php echo $this->Html->link($this->Html->showImage('Item', (!empty($itemUser['Item']['Attachment'][0]) ? $itemUser['Item']['Attachment'][0] :''), array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($itemUser['Item']['name'], false)), 'title' => $this->Html->cText($itemUser['Item']['name'], false))),array('controller' => 'items', 'action' => 'view', $itemUser['Item']['slug']), array('title' => $itemUser['Item']['name'], 'escape' => false)); ?>
					</td>
				<?php endif; ?>
				<?php if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'available' || $this->request->params['named']['type'] == 'used') ||  (!empty($show_pass_code) && (!empty($this->request->params['named']['item_user_view']) && $this->request->params['named']['item_user_view'] == 'pass')) ):?>
						<?php if(($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) ||  ($this->Auth->user('user_type_id') == ConstUserTypes::Admin) ||  ($this->Auth->user('user_type_id') == ConstUserTypes::User)):?>
						<td class='actions'>
						<?php if (empty($itemUser['ItemUser']['is_gift']) || (!empty($itemUser['ItemUser']['is_gift']) && $itemUser['ItemUser']['gift_email'] == $this->Auth->user('email')) || !empty($this->request->params['named']['item_id'])):?>
                                <ul class="action-link clearfix">
								<?php foreach ($itemUser['ItemUserPass'] as $itemUserPass) { ?>
									<?php if ((!empty($pass_find_id) && in_array($itemUserPass['id'], $pass_find_id)) || (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'available' && empty($itemUserPass['is_used'])) || (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'used' && !empty($itemUserPass['is_used'])) ||  (!empty($show_pass_code) && $this->request->params['named']['item_user_view'] == 'pass')) { ?>
									
											<?php
                                        	$uselink = Router::url(array('controller' => 'item_user_passes', 'action' => 'pass_update_status', $itemUser['ItemUser']['id'], 'pass_id' => $itemUserPass['id'],'use'), true);
                                        	$undolink = Router::url(array('controller' => 'item_user_passes', 'action' => 'pass_update_status', $itemUser['ItemUser']['id'], 'pass_id' => $itemUserPass['id'],'undo'), true);

												if($itemUserPass['is_used'] == 1) {
													$class = 'used';
													$statusMessage = 'Change status to not used';
												} else {
													$class = 'not-used';
													$statusMessage = 'Change status to used';
												}
												if($itemUser['Item']['merchant_id'] == $user['Merchant']['id']) {
													$confirmation_message =  "{'divClass':'js-merchant-confirmation', }";
												} else {
													$confirmation_message = "{'divClass':'js-user-confirmation'}";
												}
											?>
											<li><?php echo $this->Html->link(__l('Print'),array('controller' => 'item_users', 'action' => 'view',$itemUser['ItemUser']['id'],'pass_id' => $itemUserPass['id'],'type' => 'print'),array('target'=>'_blank', 'title' => __l('Print'), 'class'=>'print-icon'));?></li>
											<li>	<?php echo $this->Html->link(__l('View Pass'),array('controller' => 'item_users', 'action' => 'view',$itemUser['ItemUser']['id'],'pass_id' => $itemUserPass['id'],'admin' => false),array('title' => __l('View Pass'), 'class'=>'js-thickbox','target' => '_blank', 'class'=>'view-icon js-thickbox'));?></li>
											<?php
												$user = $this->Html->getMerchant($this->Auth->user('id'));
												if ((!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='available') || !empty($this->request->params['named']['item_id'])) {
													if (!empty($itemUserPass['is_used']) && $itemUser['Item']['merchant_id'] == $user['Merchant']['id']) {
												?>
                                                 	<?php
                                                            if(!empty($itemUserPass['is_used'])){
                                                                $use_now = __l('Used');
																$types = Configure::read('item.item_pass_used_type');
                                                                																
																if($types == 'click'){ ?>
													     	<li>
													     	<span class="<?php echo 'status-'.$itemUserPass['is_used']?>">
																<?php echo $use_now;
                                                                	echo $this->Html->link(__l('Undo'), array('controller' => 'item_user_passes', 'action' => 'update_status', $itemUser['ItemUser']['id'], 'pass_id' => $itemUserPass['id'],'is_used'), array('class' => $class.' js-update-status','title' => $statusMessage)); ?>
                                                                </span>
                                                                </li>
                                                                <?php }
																// pass code submit type
																if($types == 'submit' && $this->Auth->user('user_type_id') == ConstUserTypes::Merchant){
																	if(empty($code_type)) :
																		$code_type = null;
																	endif;
																	$code_type = (Configure::read('item.item_pass_code_show_type') == 'top')? 'UniquePassCode' : 'PassCode';
																	if($itemUser['Item']['merchant_id'] == $user['Merchant']['id']) {
																		$confirmation_message =  "{'divClass':'js-merchant-confirmation', 'uselink':'".$uselink."', 'undolink':'".$undolink."', 'code_get':'".'ItemUserPass'.$itemUserPass['id'].$code_type."', 'process':'undo'}";
																	} else {
																		$confirmation_message = "{'divClass':'js-user-confirmation', 'uselink':'".$uselink."', 'undolink':'".$undolink."', 'code_get':'".'ItemUserPass'.$itemUserPass['id'].$code_type."', 'process':'undo'}";
																	} ?>
														        <li>
														        <span class="<?php echo 'status-'.$itemUserPass['is_used']?>">
																<?php echo $this->Html->link(__l('Undo'), array('controller' => 'item_user_passes', 'action' => 'pass_update_status', $itemUser['ItemUser']['id'], 'pass_id' => $itemUserPass['id'],'undo'), array('class' => $class.' '.$confirmation_message.' js-pass-update-status','title' => $statusMessage)); ?>
																</span>
																</li>
															<?php }
                                                            }else{
																if(!empty($itemUser['Item']['event_date'])):
																	if (date('Y-m-d H:i:s') >= _formatDate('Y-m-d H:i:s', strtotime($itemUser['Item']['event_date']))):
																		$use_now = __l('Use Now');
																		 $confirmation_message =  "{'divClass':'js-merchant-confirmation', 'uselink':'".$uselink."', 'undolink':'".$undolink."', 'code_get':'".'ItemUserPass'.$itemUserPass['id'].$code_type."', 'process':'used'}";
                                                                        ?>
                                                                  <li>
													        	<span class="<?php echo 'status-'.$itemUserPass['is_used']?>">
																	<?php echo $this->Html->link($use_now, array('controller' => 'item_user_passes', 'action' => 'update_status', $itemUser['ItemUser']['id'], 'pass_id' => $itemUserPass['id'],'is_used'), array('class' => $class.' '.$confirmation_message.' js-update-status','title' => $statusMessage)); ?>
																	</span>
																	</li> <?php
																	endif;
																endif;
                                                            }
															
?>													<?php } ?>
													<?php if ($class == 'not-used')  { ?>
                                                  		
														<?php
                                                            if(!empty($itemUserPass['is_used'])){
                                                                $use_now = __l('Used');
                                                                ?>
                                                           <li>
													     	<span class="<?php echo 'status-'.$itemUserPass['is_used']?>">
                                                                <?php echo $use_now;
															    echo $this->Html->link(__l('Undo'), array('controller' => 'item_user_passes', 'action' => 'update_status', $itemUser['ItemUser']['id'], 'pass_id' => $itemUserPass['id'], 'is_used'), array('class' => $class.' '.$confirmation_message.' js-update-status', 'title' => $statusMessage));
															    ?>
															    </span>
															    </li>
														<?php }else { ?>

															<?php
																 if(!empty($itemUser['Item']['event_date'])):
																	if((date('Y-m-d H:i:s') <= _formatDate('Y-m-d H:i:s', strtotime($itemUser['Item']['event_date'])))):

																		$types = Configure::read('item.item_pass_used_type');
																		$user_check = true;
																		if(!Configure::read('item.is_user_can_change_pass_type') && $this->Auth->user('user_type_id') == ConstUserTypes::User){
																			$user_check = false;
																		}
																		if($types == 'click' && $user_check){
																			$use_now = __l('Use Now');
																			if(empty($code_type)) :
																				$code_type = null;
																			endif;
																			 $confirmation_message =  "{'divClass':'js-merchant-confirmation', 'uselink':'".$uselink."', 'undolink':'".$undolink."', 'code_get':'".'ItemUserPass'.$itemUserPass['id'].$code_type."', 'process':'used'}";
                                                                            ?>
																       <li>
													     	            <span class="<?php echo 'status-'.$itemUserPass['is_used']?>">
                                                                        <?php echo $this->Html->link($use_now, array('controller' => 'item_user_passes', 'action' => 'update_status', $itemUser['ItemUser']['id'], 'pass_id' => $itemUserPass['id'], 'is_used'), array('class' => $class.' '.$confirmation_message.' js-update-status', 'title' => $statusMessage)); ?>
												                    	</span>
																		</li>
                                                                     <?php } ?>
					                 								<?php
																		// pass code submit type
																		if($types == 'submit' && $this->Auth->user('user_type_id') == ConstUserTypes::Merchant){
																			if(empty($code_type)) :
																				$code_type = null;
																			endif;
																			$code_type = (Configure::read('item.item_pass_code_show_type') == 'top')? 'UniquePassCode' : 'PassCode';
																			if($itemUser['Item']['merchant_id'] == $user['Merchant']['id']) {
																				$confirmation_message =  "{'divClass':'js-merchant-confirmation', 'uselink':'".$uselink."', 'undolink':'".$undolink."', 'code_get':'".'ItemUserPass'.$itemUserPass['id'].$code_type."', 'process':'used '}";
																			} else {
																				$confirmation_message = "{'divClass':'js-user-confirmation', 'uselink':'".$uselink."', 'undolink':'".$undolink."', 'code_get':'".'ItemUserPass'.$itemUserPass['id'].$code_type."', 'process':'used'}";
																			} ?>
																	       <li>
													                    	<span class="<?php echo 'status-'.$itemUserPass['is_used']?>">
																			<?php echo $this->Html->link(__l('Use Now'), array('controller' => 'item_user_passes', 'action' => 'pass_update_status', $itemUser['ItemUser']['id'], 'pass_id' => $itemUserPass['id'],'use'), array('class' => $class.' '.$confirmation_message.' js-pass-update-status','title' => $statusMessage)); ?>
														             	  </span>
																	    	</li>
            												      	<?php }	?>
																			<?php endif;
																endif;
                                                            }
														?>
												
													<?php } ?>
												<?php } ?>
										<?php } ?>
										
									<?php }?>
								
								</ul>
							<?php else: ?>
								<?php echo '-';?>
							<?php endif;?>
						</td>
                        <td class="actions dc">
						<?php if (empty($itemUser['ItemUser']['is_gift']) || (!empty($itemUser['ItemUser']['is_gift']) && $itemUser['ItemUser']['gift_email'] == $this->Auth->user('email')) || !empty($this->request->params['named']['item_id'])):?>
					       <ul class="action-link action-block-list clearfix">
								<?php foreach ($itemUser['ItemUserPass'] as $itemUserPass) { ?>
									<?php if ((!empty($pass_find_id) && in_array($itemUserPass['id'], $pass_find_id)) || (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'available' && empty($itemUserPass['is_used'])) || (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'used' && !empty($itemUserPass['is_used'])) ||  (!empty($show_pass_code) && $this->request->params['named']['item_user_view'] == 'pass')) { ?>
										<li class="clearfix">
                                        	<?php if(Configure::read('item.item_pass_used_type') == 'click'){ ?>
														<span class="pass-code"><?php echo $itemUserPass['unique_pass_code']; ?></span>
                                            <?php } else { ?>
												 <?php  
												 	if( $this->Auth->user('user_type_id') == ConstUserTypes::Merchant ){
														if( Configure::read('item.item_pass_code_show_type') == 'top' and !empty($itemUser['Item']['event_date']) and date('Y-m-d H:i:s') <= _formatDate('Y-m-d H:i:s', strtotime($itemUser['Item']['event_date']))) {
															 echo $this->Form->input('ItemUserPass.'.$itemUserPass['id'].'.unique_pass_code', array('type' => 'text', 'label' => false, 'div' => false)); 
														}
														else{
												?>
	                                                		<span class="pass-code"><?php echo $itemUserPass['unique_pass_code']; ?></span>
                                                	
														<?php } 
													}	
													else{		
											?>
                                                      <span class="pass-code"><?php echo $itemUserPass['unique_pass_code']; ?></span>  
											<?php	}
											} ?>
										</li>
										<?php } ?>
									<?php }?>
								</ul>
								
							<?php else: ?>
								<?php echo '-';?>
							<?php endif;?>
						</td>
						<?php endif;?>
					<td class="actions dc">
					
						<?php if (empty($itemUser['ItemUser']['is_gift']) || (!empty($itemUser['ItemUser']['is_gift']) && $itemUser['ItemUser']['gift_email'] == $this->Auth->user('email')) || !empty($this->request->params['named']['item_id'])):?>
					          <ul class="pass-code action-block-list clearfix">
								<?php foreach ($itemUser['ItemUserPass'] as $itemUserPass) { ?>
									<?php if ((!empty($pass_find_id) && in_array($itemUserPass['id'], $pass_find_id)) || (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'available' && empty($itemUserPass['is_used'])) || (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'used' && !empty($itemUserPass['is_used'])) || (!empty($show_pass_code) && $this->request->params['named']['item_user_view'] == 'pass')) { ?>
										<li class="clearfix">
                                        <?php if(Configure::read('item.item_pass_used_type') == 'click'){ ?>
														<span class="pass-code"><?php echo $itemUserPass['pass_code']; ?></span>
                                            <?php } else { ?>
												 <?php  
												 	if( $this->Auth->user('user_type_id') == ConstUserTypes::Merchant ){
														if( Configure::read('item.item_pass_code_show_type') == 'bottom' and !empty($itemUser['Item']['event_date']) and date('Y-m-d H:i:s') <= _formatDate('Y-m-d H:i:s', strtotime($itemUser['Item']['event_date']))) {
															 echo $this->Form->input('ItemUserPass.'.$itemUserPass['id'].'.pass_code', array('type' => 'text', 'label' => false, 'div' => false));
														}
														else{
												?>
                                                		<span class="pass-code"><?php echo $itemUserPass['pass_code']; ?></span>
                                                	
											<?php 		}
													}
													else{
											?>
                                            		<span class="pass-code"><?php echo $itemUserPass['pass_code']; ?></span>
                                            <?php
													}	
												} ?>
											
										</li>
										<?php } ?>
									<?php }?>
								</ul>
							
							<?php else: ?>
								<?php echo '-';?>
							<?php endif;?>
						</td>
						<?php endif; ?>
					<td>
						<?php if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='available'):?>
							<?php echo $itemUser['ItemUser']['quantity'] - $itemUser['ItemUser']['item_user_pass_count'];?>
						<?php elseif(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='used'):?>
							<?php echo $itemUser['ItemUser']['item_user_pass_count'];?>
						<?php else:?>
							<?php echo $itemUser['ItemUser']['quantity'];?>
						<?php endif;?>
					</td>					
					<?php if(Configure::read('charity.is_enabled')):?>
					<td><?php 
					if(empty($itemUser['CharitiesItemUser']['Charity']['name']) && $itemUser['CharitiesItemUser']['amount'] == 0.00):
						echo '-';
					else:	
						echo Configure::read('site.currency') . $this->Html->cCurrency($itemUser['CharitiesItemUser']['site_commission_amount'] + $itemUser['CharitiesItemUser']['seller_commission_amount']); echo (!empty($itemUser['CharitiesItemUser']['Charity']['name']))? ' '.'for'.' '.$itemUser['CharitiesItemUser']['Charity']['name']:'';?>
                    <?php endif ?>
                    </td>		
					<?php endif ?>
				</tr>
			<?php
			endforeach;
		else:
	?>
			<tr>
				<td colspan="14" class="notice"><?php echo sprintf(__l('No pass available'));?></td>
			</tr>
	<?php
		endif;
	?>
	</table>


        <?php if (!empty($itemUsers) && !empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'available' || $this->request->params['named']['type'] == 'used')):?>
            <?php if(!empty($itemUser['Item']['item_status_id']) && ($itemUser['Item']['item_status_id'] != ConstItemStatus::PendingApproval || $itemUser['Item']['item_status_id'] != ConstItemStatus::Expired) && ((!empty($this->request->params['named']['type']) && ($this->request->params['named']['type']!='gifted_items'))) && Configure::read('item.item_pass_used_type') == 'submit' && (!empty($itemUser['Item']['event_date']) && date('Y-m-d H:i:s') <= _formatDate('Y-m-d H:i:s', strtotime($itemUser['Item']['event_date'])))){?>
				<div class="admin-select-block clearfix">
					<div class="grid_left">
						<?php echo __l('Select:'); ?>
						<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
						<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
					</div>
				<div class="admin-checkbox-button grid_left"><?php echo $this->Form->input('more_action_id', array('options' => $moreActions, 'type' => 'select', 'class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
				</div>
            <?php } ?>    
            <div class="hide">
                <?php echo $this->Form->submit('Submit'); ?>
            </div>
        <?php elseif (!empty($itemUsers) && !empty($this->request->params['named']['item_user_view']) && $this->request->params['named']['item_user_view'] == 'pass' && ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant) && (Configure::read('item.item_pass_used_type') == 'submit')):?>
       	<?php if(!empty($itemUser['Item']['item_status_id']) && ($itemUser['Item']['item_status_id'] == ConstItemStatus::Tipped || $itemUser['Item']['item_status_id'] == ConstItemStatus::Closed && $itemUser['Item']['item_status_id'] == ConstItemStatus::PaidToMerchant)){?>
        		<div class="admin-select-block celarfix">
				<div class="admin-checkbox-button grid_left"><?php echo $this->Form->input('more_action_id', array('options' => $moreActions, 'type' => 'select', 'class' => 'js-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
				</div>

        <?php } ?>
        <div class="hide">
                <?php echo $this->Form->submit('Submit'); ?>
            </div>
        <?php endif;?>
		<?php if (!empty($itemUsers)):?>
			<div class="js-pagination">
				<?php echo $this->element('paging_links'); ?>
			</div>    
		<?php endif;?>
        <?php echo $this->Form->end();?>
    </div>
