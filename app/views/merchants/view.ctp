<?php /* SVN: $Id: view.ctp 54451 2011-05-24 12:26:17Z arovindhan_144at11 $ */ ?>
<div class="merchants view">
	<h2 class="ribbon-title clearfix"><span class="ribbon-left"><span class="ribbon-right"><span class="ribbon-inner"><?php echo $this->Html->cText($merchant['Merchant']['name']);?></span></span></span></h2>
	<div class="clearfix viewpage-content">
		<div class="clearfix users-view-block merchant-left-block other-info-content grid_10">
			<div class="user-avatar user-view-image">
				<?php $merchant['User']['UserAvatar'] = !empty($merchant['User']['UserAvatar']) ? $merchant['User']['UserAvatar'] : array(); ?>
				<?php echo $this->Html->showImage('UserAvatar', $merchant['User']['UserAvatar'], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($merchant['Merchant']['name'], false)), 'title' => $this->Html->cText($merchant['Merchant']['name'], false), 'escape' => false));?>
			</div>
			<?php if (!empty($merchant['Merchant']['merchant_profile'])): ?>
				<div class="merchanet-profile-block">
					<h3><?php echo __l('Merchant Profile'); ?></h3>
					<?php echo $this->Html->cHtml($merchant['Merchant']['merchant_profile']); ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="clearfix merchant-right-block other-info-content grid_9 omega">
			<div class="clearfix">
				<dl class="list merchant-list clearfix round-5">
					<?php if(!empty($merchant['Merchant']['email'])):?>
						<dt><?php echo __l('Email');?></dt>
							<dd><?php echo $this->Html->cText($merchant['Merchant']['email']);?></dd>
					<?php endif; ?>
					<dt><?php echo __l('Address');?></dt>
						<dd>
    						<address>
    							<?php echo $this->Html->cText($merchant['Merchant']['address1']);?>
    							<?php echo $this->Html->cText($merchant['Merchant']['address2']);?>
    							<?php echo $this->Html->cText($merchant['City']['name']);?>
    							<?php echo $this->Html->cText($merchant['State']['name']);?>
    							<?php echo $this->Html->cText($merchant['Country']['name']);?>
    							<?php echo $this->Html->cText($merchant['Merchant']['zip']);?>
    						</address>
    					</dd>
					<?php if(!empty($merchant['Merchant']['url'])): ?>
						<dt><?php echo __l('URL');?></dt>
							<dd><a href="<?php echo $merchant['Merchant']['url'];?>" title="<?php echo $this->Html->cText($merchant['Merchant']['url'],false);?>" target="_blank"><?php echo $this->Html->cText($merchant['Merchant']['url'],false);?></a></dd>
					<?php endif; ?>
					<?php if(!empty($merchant['Merchant']['phone'])): ?>
						<dt><?php echo __l('Phone');?></dt>
							<dd><?php echo $this->Html->cText($merchant['Merchant']['phone']);?></dd>
					<?php endif; ?>
				</dl>
				<?php if (Configure::read('Profile-is_show_address')  || $this->Auth->user('user_type_id') == ConstUserTypes::Admin): ?>
					<?php if(!empty($merchant['Merchant']['MerchantAddress'])):?>
						<h4><?php echo __l('Branch Address'); ?></h4>
						<div class="map-info clearfix">
							<dl class="address-list clearfix">
								<?php
									if(!empty($merchant['Merchant']['MerchantAddress'])):
										foreach($merchant['Merchant']['MerchantAddress'] as $address):
								?>
								<dt><?php echo __l('Address');?></dt>
									<dd>
										<address class="address<?php echo (!empty($count) ? $count : '');?>">
											<span class="street-name"><?php echo $address['address1']. ' '.$address['address2']; ?></span>
											<span><?php echo sprintf('%s %s %s', $this->Html->cText($address['City']['name']), $this->Html->cText($address['State']['name']), $this->Html->cText($address['Country']['name'])); ?></span>
											<span><?php echo $address['zip']; ?></span>
										</address>
									</dd>
								<dt><?php echo __l('Phone');?></dt>
									<dd class="phone"><?php echo  !empty($address['phone'])? $this->Html->cText($address['phone']) : '&nbsp;';?></dd>
								<dt><?php echo __l('URL');?></dt>
									<dd class="url"><?php echo  !empty($address['url'])? $this->Html->cText($address['url']) : '&nbsp;';?></dd>
								<?php
										endforeach;
									endif;
								?>
							</dl>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<?php if (Configure::read('merchant.is_show_merchant_statistics')):?>
				<div class="statistics-count clearfix">
					<span class="referred-users statistics-title-info"><?php echo __l('Item Owned');?></span>
					<span><?php echo $this->Html->cInt($statistics['item_created']);?></span>
					<?php if (Configure::read('user.is_merchant_actas_normal_user')) {?>
						<?php if (Configure::read('merchant.is_show_referred_friends') && Configure::read('referral.referral_enable')) { ?>
							<span class="referred-users statistics-title-info"><?php echo __l('Referred Users');?></span>
							<span><?php echo $this->Html->cInt($statistics['referred_users']);?></span>
						<?php } ?>
						<?php if (Configure::read('merchant.is_show_friend') && Configure::read('friend.is_enabled')) {?>
							<span class="friends statistics-title-info" ><?php echo __l('Friends');?></span>
							<span><?php echo $this->Html->cInt($statistics['user_friends']);?></span>
						<?php } ?>
						<span class="item-purchased statistics-title-info"><?php echo __l('Item Purchased');?></span>
						<span><?php echo $this->Html->cInt($statistics['item_purchased']);?></span>
					<?php } ?>
				</div>
			<?php endif; ?>
			<div class="clearfix map-block">
				<?php if (Configure::read('Profile-is_show_address')  || $this->Auth->user('user_type_id') == ConstUserTypes::Admin): ?>
					<?php if(!empty($merchant['Merchant']['latitude']) and !empty($merchant['Merchant']['longitude'] )): ?>
						<?php $map_zoom_level = !empty($item['Merchant']['map_zoom_level']) ? $item['Merchant']['map_zoom_level'] : Configure::read('GoogleMap.static_map_zoom_level');?>
						<?php if(env('HTTPS')) { ?>
							<a href="https://maps-api-ssl.google.com/maps?q=<?php echo $this->Html->url(array('controller' => 'merchants', 'action' => 'view',$merchant['Merchant']['slug'],'ext' => 'kml'),true).'&amp;z='.$map_zoom_level ?>" title="<?php echo $merchant['Merchant']['name'] ?>" target="_blank">
						<?php } else { ?>
							<a href="http://maps.google.com/maps?q=<?php echo $this->Html->url(array('controller' => 'merchants', 'action' => 'view',$merchant['Merchant']['slug'],'ext' => 'kml'),true).'&amp;z='.$map_zoom_level ?>" title="<?php echo $merchant['Merchant']['name'] ?>" target="_blank">
								<?php
									if(Configure::read('GoogleMap.embed_map') == 'Static'):
										echo $this->Html->image($this->Html->formGooglemap($merchant['Merchant'],'285x170'));
									else:
										echo $this->Html->formGooglemap($merchant);
									endif;
								?>
							</a>
						<?php } ?>
						<?php if(Configure::read('GoogleMap.embed_map') != 'Static'): ?>
							<small>
								<?php if(env('HTTPS')) { ?>
									<a href="https://maps-api-ssl.google.com/maps?q=<?php echo $this->Html->url(array('controller' => 'merchants', 'action' => 'view',$merchant['Merchant']['slug'],'ext' => 'kml'),true).'&amp;z='.$map_zoom_level.'&amp;source=embed' ?>" title="<?php echo $merchant['Merchant']['name'] ?>" target="_blank" style="color:#0000FF;text-align:left"><?php echo __l('View Larger Map');?></a>
								<?php } else { ?>
									<a href="http://maps.google.com/maps?q=<?php echo $this->Html->url(array('controller' => 'merchants', 'action' => 'view',$merchant['Merchant']['slug'],'ext' => 'kml'),true).'&amp;z='.$map_zoom_level.'&amp;source=embed' ?>" title="<?php echo $merchant['Merchant']['name'] ?>" target="_blank" style="color:#0000FF;text-align:left"><?php echo __l('View Larger Map');?></a>
								<?php } ?>	
							</small>
						<?php endif;?>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="main-content-block">
		<div class="js-tabs">
			<ul class="clearfix">
				<?php
                if (Configure::read('user.is_merchant_actas_normal_user') &&  $this->Html->isAllowed($this->Auth->user('user_type_id'))): ?>
					<li><?php echo $this->Html->link(__l('Comments'), '#tabs-1');?></li>
				<?php endif; ?>
				<?php if (Configure::read('merchant.is_show_item_owned')) :?>
					<li><?php echo $this->Html->link(__l('Items Owned'), array('controller' => 'items', 'action' => 'merchant_items', 'merchant_id' =>  $merchant['Merchant']['id']),array('title' => __l('Items Owned'))); ?></li>
				<?php endif; ?>
				<?php if (Configure::read('user.is_merchant_actas_normal_user')) {?>
					<?php if (Configure::read('merchant.is_show_item_purchased')) {?>
						<li><?php echo $this->Html->link(__l('Items Purchased'), array('controller' => 'item_users', 'action' => 'user_items', 'user_id' =>$merchant['Merchant']['user_id']),array('title' => __l('Items Purchased'))); ?></li>
					<?php } ?>
					<?php if (Configure::read('merchant.is_show_friend') && Configure::read('friend.is_enabled') && $this->Auth->user('id') ) {?>
						<li><?php echo $this->Html->link(__l('Friends'), array('controller' => 'user_friends', 'action' => 'myfriends', 'user_id' =>$merchant['Merchant']['user_id']),array('title' => __l('Friends'))); ?></li>
					<?php } ?>
				<?php } ?>
					<?php if (Configure::read('merchant.is_show_referred_friends') && (Configure::read('referral.referral_enabled_option') == ConstReferralOption::GrouponLikeRefer)  && Configure::read('referral.referral_enable')) {?>
						<li><?php echo $this->Html->link(__l('Referred Users'), array('controller' => 'users', 'action' => 'referred_users', 'user_id' =>$merchant['Merchant']['user_id']),array('title' => __l('Referred Users'))); ?></li>
					<?php } ?>
			</ul>
			<?php if (Configure::read('user.is_merchant_actas_normal_user') && $this->Html->isAllowed($this->Auth->user('user_type_id'))): ?>
				<div id="tabs-1">
					<div class="main-content-block js-corner round-5">
						<div class="js-responses">
							<?php echo $this->element('user_comments-index', array('username' => $merchant['User']['username'], 'config' => 'sec', 'key' => $merchant['User']['username']));?>
						</div>
					</div>
					<?php if($this->Auth->user('id') and $this->Auth->user('id')!= $merchant['User']['id']): ?>
						<div class="main-content-block js-corner round-5">
							<h2><?php echo __l('Add Your comments'); ?></h2>
							<?php echo $this->element('../user_comments/add');?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>