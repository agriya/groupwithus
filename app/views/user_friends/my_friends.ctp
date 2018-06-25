<div>
	<?php if (!empty($myFriends)): ?>
		<ol class="item-user-list">
			<?php foreach ($myFriends as $myFriend): ?>
			<li class="clearfix">
				<div class="merchant-list-image">
					<?php
						echo $this->Html->showImage('UserAvatar', $myFriend['FriendUser']['Attachment'], array('dimension' => 'medium_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($myFriend['FriendUser']['username'], false)), 'title' => $this->Html->cText($myFriend['FriendUser']['username'], false)));
                        ?>
                   </div>
                      <div class="merchant-list-content">
                        <?php 	echo $this->Html->getUserLink($myFriend['FriendUser']);
					?>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>
	<?php else: ?>
        <p class="notice"><?php echo __l('No Friends Available');?></p>
    <?php endif ?>
</div>