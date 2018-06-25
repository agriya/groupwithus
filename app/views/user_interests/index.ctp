<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>

<div class="userInterests index js-response js-response-main">
<h2 class="ribbon-title clearfix"><span class="ribbon-left"><span class="ribbon-right"><span class="ribbon-inner"><?php echo __l('Find your favorite interests!'); ?></span></span></span></h2>
<?php if($this->Auth->sessionValid()): ?>
 <div class="page-information clearfix">
	<div class="follow-info-block grid_7 alpha omega">
		<div class="followed">
			<p class="clearfix">
				<span class="interested-text"><?php echo __l('Interests followed:'); ?></span>
				<span class="interested-value"><?php echo $this->Html->cInt($user_interests,false); ?></span>
			</p>
		</div>
		<div class="myinterest">
		<?php echo $this->Html->link(__l('My Interests'), array('controller' => 'user_interests', 'action' => 'index','type' => 'myinterest'), array('title' => __l('My Interests')));?>  

		</div>
		<div class="popular-interest">
		<?php echo $this->Html->link(__l('Popular Interests'), array('controller' => 'user_interests', 'action' => 'index'), array('title' => __l('Popular Interests')));?> 
		</div>
	</div>
	<div class="follow-form-block grid_12 alpha omega">
	 <?php echo $this->element('../user_interests/add', array('config' => 'sec'));?>
	 </div>
</div>
<?php else: ?>
<div class="page-information ">
<?php echo $this->Html->link(__l('Signin'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Signin'),'class'=>'login-link'));?> <?php echo __l(' to follow interests so that you can get notified when items are created with your interests!'); ?>
</div>
<?php endif; ?>

 <div class="userInterests index js-response">
<?php if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='myinterest') : ?>
	<h2 class="ribbon-title clearfix"><span class="ribbon-left"><span class="ribbon-right"><span class="ribbon-inner"><?php echo __l('My Interests');?></span></span></span></h2>
<?php else: ?>
	<h2 class="ribbon-title clearfix"><span class="ribbon-left"><span class="ribbon-right"><span class="ribbon-inner"><?php echo __l('Popular Interests');?></span></span></span></h2>
<?php endif; ?>
<div class="overflow-block clearfix">
<?php
if (!empty($userInterests)):

$i = 0; ?>
<ol class="interest-list gris_19 clearfix">
<?php 
foreach ($userInterests as $userInterest):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
<li class="interest-box grid_6" id="interest">
	<div class="list-inner">
	<h3><?php echo $this->Html->link($this->Html->cText($userInterest['UserInterest']['name'], false), array('controller'=>'user_interest','action' => 'view', $userInterest['UserInterest']['slug']), array('escape' => false, 'title' => $this->Html->cText($userInterest['UserInterest']['name'], false)));?></h3>
	<?php if(!empty($userInterest['User'])): ?>
	<ol class="user-list clearfix">
	<?php 
	$i=1;
	foreach($userInterest['User'] as $user):?>
		<li>
		            <?php  echo $this->Html->link($this->Html->showImage('UserAvatar',!empty($user['UserAvatar'])?$user['UserAvatar']:'', array('dimension' => 'user_interest_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($user['username'], false)), 'title' => $this->Html->cText($user['username'], false))),array('controller'=> 'users', 'action'=>'view',$user['username']),array('title' => $this->Html->cText($user['username'],false),'escape' => false)); ?> 
		</li>
	<?php 
	$i++;
	if($i>4)
	{
		break;
	}
	endforeach; ?>
	</ol>
	<?php endif; ?>
	<?php if($this->Auth->sessionValid()): ?>
		<div class='js-follow-link'>
	<?php if(!empty($userInterest['UserInterestFollower'])) : ?>
          <?php echo $this->Html->link(__l('Unfollow'), array('controller'=>'user_interest_followers','action' => 'delete', $userInterest['UserInterest']['id'],$userInterest['User'][0]['id']), array('class' => 'unfollow js-link {"responseconatiner":"js-follow-link"}', 'title' => __l('Unfollow')));?>
		<?php else: ?>
		<?php echo $this->Html->link(__l('Follow'), array('controller'=>'user_interest_followers','action' => 'add', $userInterest['UserInterest']['id']), array('class' => 'follow js-link {"responseconatiner":"js-follow-link"}', 'title' => __l('Follow')));?>
		<?php endif; ?>
		</div>

<?php endif; ?>
	</div>
</li>
<?php
    endforeach;
?>
<?php
else:?>
<p class="notice"><?php  echo (!empty($this->params['named']['type']) && $this->params['named']['type']=='myinterest')? __l('No Interests Followed'):  __l('No Popular Interests Available')?></p>
</ol>
<?php
endif;
?>
</div>
</div>
</div>