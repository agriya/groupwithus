<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>

<div class="userInterests index js-response js-response-main">
<div class="clearfix" id="interest-view-top-box">
    	<h2 class="ribbon-title clearfix"><span class="ribbon-left"><span class="ribbon-right"><span class="ribbon-inner"><?php echo $this->Html->cText($userInterest['UserInterest']['name'],false); ?></span></span></span></h2>
        <div class="clearfix follow-link-block">
	<?php if($this->Auth->sessionValid()): ?>
		<div class='follow-link js-follow-link grid_left'>
    	   <?php if(!empty($userInterest['UserInterestFollower'])) : ?>
             <?php echo $this->Html->link(__l('Unfollow'), array('controller'=>'user_interest_followers','action' => 'delete', $userInterest['UserInterest']['id'],$userInterest['User'][0]['id']), array('class' => 'follow js-link {"responseconatiner":"js-follow-link"}', 'title' => __l('Unfollow')));?>
    		<?php else: ?>
    		<?php echo $this->Html->link(__l('Follow'), array('controller'=>'user_interest_followers','action' => 'add', $userInterest['UserInterest']['id']), array('class' => 'follow js-add js-link {"responseconatiner":"js-follow-link"}', 'title' => __l('Follow')));?>
    		<?php endif; ?>
		</div>
        <?php endif; ?>
        <div class="grid_right">
		   <?php echo $this->Html->link(__l('Back to all Interests'), array('controller' => 'user_interests', 'action' => 'index'), array('title' => __l('Back to all Interests'), 'class'=>"back"));?>
        </div>
         </div>
	</div>

 <div class='interest-items-list'>
						<?php echo $this->element('items-index-interest', array('config' =>'sec','interest_id'=> $userInterest['UserInterest']['id'],'city'=>$this->params['named']['city']));?>
 </div>

 <div class='interest-bottom-box clearfix'>
	 <div class="grid_12 alpha">
		<h3><?php echo __l('Join the Conversation!'); ?></h3>
		<?php if($this->Auth->sessionValid()): ?>
           <?php echo $this->element('../user_interest_comments/add');?>
		  <?php endif; ?>
		  <?php if (!$this->Auth->sessionValid() || ($this->Auth->user('user_type_id') != ConstUserTypes::Merchant || Configure::read('user.is_merchant_actas_normal_user')) || $this->Auth->user('user_type_id') == ConstUserTypes::Admin): ?>
		   		<div class="js-responses">
						<?php echo $this->element('user_interest_comments-index', array('interest' => $userInterest['UserInterest']['id'], 'config' =>'sec'));?>
				</div>
<?php endif; ?>
	 </div>
	 <div class="follower-block grid_7 omega">
	 <h3><?php echo $this->Html->cText($userInterest['UserInterest']['name'], false) . __l(' Followers (').$this->Html->cInt($userInterest['UserInterest']['user_interest_follower_count']).__l(')'); ?></h3>
		<ol class="follower-list">
	 	<?php foreach($userInterest['User'] as $user):?>
		<?php 
								$user_details = array(
									'username' =>$user['username'],
									'user_type_id' => $user['user_type_id'],
									'id' =>  $user['id'],
									'UserAvatar' => $user['UserAvatar']
								);
								
							?>
			<li class="clearfix">
				<div class="follower-block-left grid_1 alpha">
				<?php echo $this->Html->getUserAvatarLink($user_details, 'micro_thumb').' '; ?>
				</div>
				<div class="follower-block-right grid_5 omega alpha">
				<h4 class="username"><?php echo $this->Html->cText($user['username'],false); ?></h4>
				<p><?php echo !empty($user['UserProfile']['home_town'])? $this->Html->cText($user['UserProfile']['home_town'],false):''; ?></p>
				</div>
			</li>
			<?php endforeach; ?>
        </ol>
	 </div>
 </div>

</div>