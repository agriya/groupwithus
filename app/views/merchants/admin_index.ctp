<?php /* SVN: $Id: admin_index.ctp 71613 2011-11-15 21:27:42Z josephine_065at09 $ */ ?>
<div class="js-response js-responses js-search-responses">
<?php 
	if(!empty($this->request->params['isAjax'])):
		echo $this->element('flash_message');
	endif;
?>
		<div class="clearfix">
             <ul class="filter-list-block clearfix">
            	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? 'active-filter' : null; ?>
            	<li class="green <?php echo $class; ?>" title="<?php echo __l('Active Merchants');?>"><?php echo $this->Html->link( $this->Html->cInt($active ,false). '<span>' . __l('Active Merchants') . '</span>', array('controller' => 'merchants', 'action' => 'index', 'filter_id' => ConstMoreAction::Active), array('escape' => false));?>
            	</li>
            	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? 'active-filter' : null; ?>
            	<li class="gray <?php echo $class; ?>" title="<?php echo __l('Inactive Merchants');?>"><?php echo $this->Html->link( $this->Html->cInt($inactive  ,false). '<span>' . __l('Inactive Merchants'). '</span>', array('controller' => 'merchants', 'action' => 'index', 'filter_id' => ConstMoreAction::Inactive), array('escape' => false));?>
                </li>
                <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::OpenID) ? 'active-filter' : null; ?>
            	<li class="light-orange <?php echo $class; ?>" title ="<?php  echo __l('Online Merchants');?>"><?php echo $this->Html->link( $this->Html->cInt($online ,false). '<span>'.__l('Online Merchants'). '</span>', array('controller' => 'merchants', 'action' => 'index', 'main_filter_id' => ConstMoreAction::Online), array('escape' => false));?>
                </li>

                <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Gmail) ? 'active-filter' : null; ?>
            	<li class="gmail-user <?php echo $class; ?>" title ="<?php echo __l('Offline Merchants');?>"><?php echo $this->Html->link( $this->Html->cInt($offline ,false). '<span>'.__l('Offline Merchants'). '</span>', array('controller' => 'merchants', 'action' => 'index', 'main_filter_id' => ConstMoreAction::Offline), array('escape' => false));?>
                </li>

            	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::FaceBook) ? 'active-filter' : null; ?>
            	<li class="light-blue <?php echo $class; ?>" title ="<?php echo __l('Affiliate Merchants');?>"><?php echo $this->Html->link( $this->Html->cInt($affiliate_user_count ,false). '<span>'.__l('Affiliate Merchants'). '</span>', array('controller' => 'merchants', 'action' => 'index', 'main_filter_id' => ConstMoreAction::AffiliateUser), array('escape' => false));?>
                 </li>

                <?php $class = (empty($this->request->params['named']['filter_id'])) ? 'active-filter' : null; ?>
            	<li class="black <?php echo $class; ?>" title ="<?php echo __l('Total Merchants');?>"><?php echo $this->Html->link($this->Html->cInt($all ,false). '<span>'.__l('Total Merchants'). '</span>', array('controller'=> 'merchants', 'action'=>'index', 'main_filter_id' => 'all'), array('escape' => false));?>
            	</li>
            </ul>
		</div>
				<?php if(!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::Online): ?>
					<div class="info-details">
						<p>
							<?php echo __l('"online" merchants accounts are managed by merchants themselves and they\'ll have login details.');?>
							<?php echo $this->Html->link(__l('Click here'), 'http://dev1products.dev.agriya.com/doku.php?id=groupwithus#frequently_asked_questions' , array('target' => '_blank', 'title' => 'Click here', 'class' => 'merchant')).' '.__l('for info.');?>
						</p>
					</div>
				<?php elseif(!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::Offline): ?>
					<div class="info-details">
						<p>
							<?php echo __l('"offline" merchants accounts cannot login into the site. To set amount the money paid for a offline merchants, use \'Set as Paid\'.');?>
							<?php echo $this->Html->link(__l('Click here'), 'http://dev1products.dev.agriya.com/doku.php?id=groupwithus#frequently_asked_questions' , array('target' => '_blank', 'title' => 'Click here', 'class' => 'merchant')).' '.__l('for info.');?>
						</p>
					</div>
				<?php endif;?>
				
				
					<div class=" page-count-block  clearfix">
                    <div class="grid_left">
                        <?php echo $this->element('paging_counter');?>
					</div>
					<div class="grid_left">
					<?php echo $this->Form->create('Merchant' , array('type' => 'post', 'class' => 'normal search-form clearfix','action' => 'index')); ?>
							<?php echo $this->Form->input('q', array('label' => __l('Keyword')));?>
							<?php echo $this->Form->input('main_filter_id', array('type' => 'hidden', 'value' => !empty($this->request->params['named']['main_filter_id'])? $this->request->params['named']['main_filter_id']:'')); ?>
							<?php echo $this->Form->input('filter_id', array('type' => 'hidden', 'value' => !empty($this->request->params['named']['filter_id'])?$this->request->params['named']['filter_id']:'')); ?>
      							<?php echo $this->Form->submit(__l('Search'));?>
							
						<?php echo $this->Form->end(); ?>
					 </div>   
					<div class="clearfix grid_right add-block1">
						<?php echo $this->Html->link(__l('Add'), array('controller' => 'merchants', 'action' => 'add'), array('class' => 'add','title'=>__l('Add'))); ?>
                    <?php
							echo $this->Html->link(__l('CSV'), array_merge(array('controller' => 'merchants', 'action' => 'index','city' => $city_slug, 'ext' => 'csv', 'admin' => true), $this->request->params['named']), array('title' => __l('CSV'), 'class' => 'export'));
						?>
                	</div>
                	</div>
						<div class="merchant-list">
						
						<?php   echo $this->Form->create('Merchant' , array('class' => 'normal','action' => 'update'));?>
						<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
					
				
						<table class="list" id="js-expand-table">
							<tr class="js-even">
								<th rowspan="2" class="select"></th>
								<th rowspan="2" class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Merchant'), 'Merchant.name');?></div></th>
								<th rowspan="2" class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('User'), 'User.username');?></div></th>
								<th rowspan="2" class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Item'), 'Merchant.item_count');?></div></th>
								<th rowspan="2" class="dr"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Sales'), 'Merchant.total_sales_cleared_amount').' ('.Configure::read('site.currency').')';?></div></th>
								<th rowspan="2" class="dr"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Site Revenue'), 'Merchant.total_site_revenue_amount').' ('.Configure::read('site.currency').')';?></div></th>
								<th rowspan="2"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Views'), 'Merchant.merchant_view_count');?></div></th>
                                <th colspan="3"><?php echo __l('Logins'); ?></th>
								<th rowspan="2"><?php echo __l('Registered on'); ?></th>
								
							</tr>
                             <tr class="js-even">
                                <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Count'), 'User.user_login_count'); ?></div></th>
                                <th><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Time'), 'User.last_logged_in_time'); ?></div></th>
                                <th class="dl"><div class="js-pagination"><?php echo __l('IP'); ?></div></th>
                             </tr>
						<?php
						if (!empty($merchants)):
						$i = 0;
						foreach ($merchants as $merchant):
							$class = null;
							$active_class = '';
							if ($i++ % 2 == 0) {
								$class = 'altrow';
							}
							if(!$merchant['User']['is_active']){
								$active_class = ' inactive-record';
							}
							$email_active_class = ' email-not-comfirmed';
							if($merchant['User']['is_email_confirmed']):
								$email_active_class = ' email-comfirmed';
							endif;							
							if($merchant['Merchant']['is_merchant_profile_enabled']):
								$status_class = 'js-checkbox-active';
							else:
								$status_class = 'js-checkbox-inactive';
							endif;
						?>
							<tr class="<?php echo $class;?><?php echo $active_class; ?> expand-row js-odd">
    							<td class="select-block">
                                		<div class="arrow"></div>
                                    	<?php echo $this->Form->input('Merchant.'.$merchant['Merchant']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$merchant['Merchant']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?>
    							</td>
								<td class="dl">
								<p> <?php echo $this->Html->cText($merchant['Merchant']['name']);?>
								</p>
								<div class="clearfix merchant-info-block">
                                    <?php if (!empty($merchant['Merchant']['url'])):
    										$this->Html->cText($merchant['Merchant']['url']);
    									 endif;
    								?>
                                	<?php if (!empty($merchant['Merchant']['phone'])): ?><span class="phone"><?php echo $this->Html->cText($merchant['Merchant']['phone']);?></span><?php endif; ?>
                                </div>
                                </td>
                                <td class="dl">
								<?php echo $this->Html->cText($merchant['User']['username']);?>                        
                                <p class="user-img-right clearfix">
									<?php if($merchant['User']['is_affiliate_user']):?>
                                            <span class="affiliate"> <?php echo __l('Affiliate'); ?> </span>
                                    <?php endif; ?>
                                </p>
                                <div class="clearfix user-status-block user-info-block">
								<?php 					
								if(!empty($merchant['UserProfile']['Country'])):
									?>
                                    <span class="flags flag-<?php echo strtolower($merchant['UserProfile']['Country']['iso2']); ?>" title ="<?php echo $merchant['UserProfile']['Country']['name']; ?>">
                                        <?php echo $merchant['UserProfile']['Country']['name']; ?>
                                    </span>
									<?php
								endif; 
								?>
                                <?php if($merchant['User']['is_openid_register']):?>
                                        <span class="open_id" title="OpenID"> <?php echo __l('OpenID'); ?> </span>
                                <?php endif; ?>
                                <?php if($merchant['User']['is_gmail_register']):?>
                                        <span class="gmail" title="Gmail"> <?php echo __l('Gmail'); ?> </span>
                                <?php endif; ?>
                                <?php if($merchant['User']['is_yahoo_register']):?>
                                        <span class="yahoo" title="Yahoo"> <?php echo __l('Yahoo'); ?> </span>
                                <?php endif; ?>
                                <?php if($merchant['User']['is_facebook_register']):?>
                                        <span class="facebook" title="Facebook"> <?php echo __l('Facebook'); ?> </span>
                                <?php endif; ?>
                                <?php if($merchant['User']['is_twitter_register']):?>
                                        <span class="twitter" title="Twitter"> <?php echo __l('Twitter'); ?> </span>
                                <?php endif; ?>
                                <?php if($merchant['User']['is_foursquare_register']):?>
                                        <span class="foursquare" title="Foursquare"> <?php echo __l('Foursquare'); ?> </span>
                                <?php endif; ?>
                                <?php if(!empty($merchant['User']['email'])):?>
                                        <span class="email <?php echo $email_active_class; ?>" title="<?php echo $merchant['User']['email'];?>"> <?php echo '..' . substr($merchant['User']['email'], strlen($merchant['User']['email'])-15, strlen($merchant['User']['email']));  ?> </span>
                                <?php endif; ?>
                                </div>
                                </td>
								<td class="dc"><?php echo $this->Html->cInt($merchant['Merchant']['item_count']);?></td>
								<td class="dr">
							     	<?php echo $this->Html->cCurrency($merchant['Merchant']['total_sales_cleared_amount']);?>
                               </td>
								<td class="site-amount dr">
							      	<?php echo $this->Html->cCurrency($merchant['Merchant']['total_site_revenue_amount']);?>
                               </td>
							   <td class="dc">
							   	     <?php echo $this->Html->cInt($merchant['Merchant']['merchant_view_count']);?>
                               </td>                                
                               <td class="dc">
                                    <?php echo $this->Html->cInt($merchant['User']['user_login_count']);?>
                                </td>
                                <td>
                                    <?php if($merchant['User']['last_logged_in_time'] == '0000-00-00 00:00:00' || empty($merchant['User']['last_logged_in_time'])){
                                        echo '-';
                                    }else{
                                        echo $this->Html->cDateTimeHighlight($merchant['User']['last_logged_in_time']);
                                    }?>
                                </td>
                                <td class="dl">
                                <?php if(!empty($merchant['User']['LastLoginIp']['ip'])): ?>
                                   <?php echo  $this->Html->link($merchant['User']['LastLoginIp']['ip'], array('controller' => 'users', 'action' => 'whois', $merchant['User']['LastLoginIp']['ip'], 'admin' => false), array('target' => '_blank', 'title' => 'whois '.$merchant['User']['LastLoginIp']['host'], 'escape' => false));
                                    ?>
                                    <p>
								<?php 					
								if(!empty($merchant['User']['LastLoginIp']['Country'])):
									?>
                                    <span class="flags flag-<?php echo strtolower($merchant['User']['LastLoginIp']['Country']['iso2']); ?>" title ="<?php echo $merchant['User']['LastLoginIp']['Country']['name']; ?>">
                                        <?php echo $merchant['User']['LastLoginIp']['Country']['name']; ?>
                                    </span>
									<?php
								endif; 
								?>                                    
								<?php 					
								if(!empty($merchant['User']['LastLoginIp']['City'])):
									?>
                                    <span>
                                        <?php echo $merchant['User']['LastLoginIp']['City']['name']; ?>
                                    </span>
									<?php
								endif; 
								?>                                    
                                 </p>
                                <?php else: ?>
                                    <?php echo __l('N/A'); ?>
                                <?php endif; ?>    
                                </td>
                                <td><?php if($merchant['User']['created'] == '0000-00-00 00:00:00'){
                                        echo '-';
                                    }else{
                                        echo $this->Html->cDateTimeHighlight($merchant['User']['created']);
                                    }?>
                                </td>
                             </tr>
                            <tr class="hide">
                            	<td colspan="12" class="action-block">
                                <div class="action-info-block clearfix">
                                    <div class="action-left-block">
                                    	<h3> <?php echo __l('Action'); ?> </h3>
                                        <ul class="clearfix">
                                            <li><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $merchant['Merchant']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></li>
                                            <li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $merchant['Merchant']['id']), array('class' => 'delete js-delete', 'title' => __l('Delete')));?></li>
                                            <?php if(!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] != ConstMoreAction::Offline) { ?>
                                            <?php
                                            if(Configure::read('user.is_email_verification_for_register') and (!$merchant['User']['is_active'] or !$merchant['User']['is_email_confirmed'])):
                                            ?>
                                            <li>
                                            <?php
                                            echo $this->Html->link(__l('Resend Activation'), array('controller' => 'users', 'action'=>'resend_activation', $merchant['User']['id'],'type' => 'merchant', 'admin' => false),array('title' => __l('Resend Activation'),'class' =>'recent-activation'));
                                            ?>
                                            </li>
                                            <?php endif;
                                            ?>
                                            <li><?php echo $this->Html->link(__l('Change Password'), array('controller' => 'users', 'action'=>'admin_change_password', $merchant['User']['id']), array('title' => __l('Change Password'),'class' => 'password'));?></li>
                                            <?php }?>
                                            <li><?php echo $this->Html->link(__l('Transactions'), array('controller' => 'transactions', 'action'=>'admin_index','user_id' => $merchant['User']['id']), array('title' => __l('Transactions'),'class' => 'transaction'));?></li>
                                        </ul>
                                    </div>
                                    <div class="action-right-block clearfix">
                                    
                                        <div class="clearfix">
                                        <div class="action-right action-right1">
                                         <h3> <?php echo __l('Item'); ?> </h3>
                                            <dl class="clearfix">
                                                <dt>
                                                <span><?php echo __l('Pending Approval');?></span>
                                                </dt>
                                                <dd>
                                                <?php echo $this->Html->cInt($merchant['Merchant']['total_pending_approval_count']);?>
                                                </dd>
                                                 <dt>
                                            	 <span><?php echo __l('Open');?></span>
                                            	 </dt>
                                            	 <dd>
                                                  <?php echo $this->Html->cInt($merchant['Merchant']['total_open_count'] + $merchant['Merchant']['total_tipped_count']);?>
                                                  </dd>
                                            	 
                                                <dt><span><?php echo __l('Successful');?></span></dt>
                                                <dd>
                                                <?php echo $this->Html->cInt($merchant['Merchant']['total_closed_count'] + $merchant['Merchant']['total_paid_to_merchant_count'] );?>
                                                </dd>
                                                <dt>
                                            	 <span><?php echo __l('Unsuccessful');?></span>
                                                </dt>
                                                <dd>
                                                 <?php echo $this->Html->cInt($merchant['Merchant']['total_canceled_count'] + $merchant['Merchant']['total_expired_count']+ $merchant['Merchant']['total_refunded_count'] );?>
                                                </dd>
                                            </dl>
                                        	<div class="chart-item">
                                        <?php
										$item_statuses = array('total_draft_count', 'total_pending_approval_count', 'total_open_count', 'total_tipped_count', 'total_closed_count', 'total_paid_to_merchant_count', 'total_refunded_count', 'total_rejected_count', 'total_canceled_count', 'total_expired_count' );
										$all = 0;
										$item_percentage = '';
										foreach($item_statuses as $item_status){
											$all += $merchant['Merchant'][$item_status];
										}
										foreach($item_statuses as $item_status){
											$item_percentage .= ($item_percentage != '') ? ',' : '';
											$item_percentage .= round((empty($merchant['Merchant'][$item_status])) ? 0 : ( ($merchant['Merchant'][$item_status] / $all) * 100 ));
										}
										echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$item_percentage.'&amp;chs=50x50&amp;chco=fa9116|be7125|74b732|3f83b2|444444|00b0c6|deb700|e21e1e|fd66b5|929292&amp;chf=bg,s,FF000000'); ?>
                                        </div>
                                            
                                        </div>
                                        <div class="action-right">
                                        	<h3> <?php echo __l('Sales') ; ?> </h3>
                                            <dl class="clearfix">
                                            	 <dt><span><?php echo __l('Paid');?></span></dt>
                                                 <dd> <?php echo $this->Html->cInt($merchant['Merchant']['total_paid_to_merchant_count']);?></dd>
                                                <dt>
                                                <span><?php echo __l('Pipeline');?></span>
                                                </dt>
                                                <dd>
                                                <?php echo $this->Html->cInt($merchant['Merchant']['total_open_count'] + $merchant['Merchant']['total_tipped_count']+ $merchant['Merchant']['total_closed_count']);?>
                                                </dd>
                                                <dt>
                                                <span><?php echo __l('Wallet').' ('.Configure::read('site.currency').')';?></span>
                                                </dt>
                                                <dd>
                                                <?php echo $this->Html->cCurrency($merchant['User']['available_balance_amount'],'', true);?>
                                                </dd>
                                            <dt>
                                             <span><?php echo __l('Withdrawn').' ('.Configure::read('site.currency').')';?></span>
                                             </dt>
                                             <dd>
                                              <?php echo  $this->Html->cCurrency($merchant['User']['total_amount_withdrawn'],'', true);?>
                                              </dd>
                                                
                                            </dl>
                                        </div>
                                        <div class="action-right action-right3 ">
                                        	<h3> <?php echo __l('Share') ; ?> </h3>
                                          <dl class="clearfix">
                                            <dt>
                                             <span><?php echo __l('Charity').' ('.Configure::read('site.currency').')';?></span>
                                             </dt>
                                             <dd> <?php echo  $this->Html->cCurrency($merchant['Merchant']['total_paid_for_charity_amount'],'', true);?>  </dd>
                                                <dt>
                                                <span><?php echo __l('Site Revenue').' ('.Configure::read('site.currency').')';?></span>
                                                </dt>
                                                <dd>
                                              <?php echo  $this->Html->cCurrency($merchant['Merchant']['total_site_revenue_amount'],'', true);?>
                                              </dd>
                                            </dl>
                                       
                                        </div>
                                        </div>
                                        <div class="clearfix">
                                          <div class="action-right city-action">
                                            <dl class="clearfix">
                                               <dt class="merchant"><?php echo __l('Merchant');?></dt>
                                                <dd>
                                                 <?php
            										$chnage_user_info = $merchant['User'];
            										$chnage_user_info['UserAvatar'] = $merchant['User']['UserAvatar'];
            										$merchant['User']['full_name'] = (!empty($merchant['User']['UserProfile']['first_name']) || !empty($merchant['User']['UserProfile']['last_name'])) ? $merchant['User']['UserProfile']['first_name'] . ' ' . $merchant['User']['UserProfile']['last_name'] :  $merchant['User']['username'];
            										echo $this->Html->getUserAvatarLink($chnage_user_info, 'micro_thumb',false);
                                            		?>
            										<?php echo $this->Html->link($this->Html->cText($merchant['Merchant']['name'], false), array('controller' => 'merchants', 'action' => 'view', $merchant['Merchant']['slug'], 'admin' => false), array('title' => $this->Html->cText($merchant['Merchant']['name'], false) ,'escape' => false, 'class' => 'user-name'));?>
                                                </dd>
                                            </dl>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                </td>
                            </tr>
						<?php
							endforeach;
						else:
						?>
							<tr class="js-odd">
								<td colspan="10" class="notice"><?php echo __l('No Merchants available');?></td>
							</tr>
						<?php
						endif;
						?>
						</table>
					
					
						<?php
						if (!empty($merchants)):
						?>
							<div class="clearfix">
							<div class="admin-select-block grid_left">
							<div>
								<?php echo __l('Select:'); ?>
								<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
								<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
								<?php echo $this->Html->link(__l('Disabled'), '#', array('class' => 'js-admin-select-pending', 'title' => __l('Disabled'))); ?>
								<?php echo $this->Html->link(__l('Enabled'), '#', array('class' => 'js-admin-select-approved', 'title' => __l('Enabled'))); ?>
							</div>
								<div class="admin-checkbox-button">
                                <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
								</div>
							<div class="js-pagination grid_right">
								<?php echo $this->element('paging_links'); ?>
							</div>
							</div>
							<div class="hide">
								<?php echo $this->Form->submit('Submit'); ?>
							</div>
						<?php
						endif;
						echo $this->Form->end();?>
					</div>
</div>