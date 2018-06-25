<div class="js-response">
	<?php if (!empty($referredFriends)): 
	?>
			<ol class="item-user-list">
			
			<?php foreach ($referredFriends as $referredFriend): ?>
				<li class="clearfix">
					<div class="merchant-list-image">
                    
					<?php 
					$user_details = array(
						'username' => $referredFriend['User']['username'],
						'user_type_id' =>  $referredFriend['User']['user_type_id'],
						'id' =>  $referredFriend['User']['id'],
						'UserAvatar' => $referredFriend['UserAvatar']
					);
					echo $this->Html->getUserAvatarLink($user_details,'medium_thumb', false); ?>
                    </div>
                      <div class="merchant-list-content">
                	<p><?php echo $this->Html->getUserLink($referredFriend['User']);?></p>
                    <dl class="list statistics-list clearfix">
                        <dt><?php echo __l('Member Since:');?></dt>
                            <dd><?php echo $this->Html->cDate($referredFriend['User']['created']);?></dd>
							</dl>
						<dl class="list statistics-list clearfix">
                         <?php if($referredFriend['User']['item_count']) { ?>
                            <dt><?php echo __l('Total Item Purchase:');?></dt>
                                <dd><?php echo $this->Html->cInt($referredFriend['User']['item_count']);?></dd>
                         <?php } ?>
                    </dl>
                    </div>
				</li>
			<?php endforeach; ?>
		</ol>
		<div class="js-pagination">
			<?php echo $this->element('paging_links'); ?>
		</div>  
	<?php else: ?>
        <p class="notice"><?php echo __l('No Referred Users Available');?></p>
    <?php endif; ?>
</div>