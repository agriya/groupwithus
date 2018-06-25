<?php $this->pageTitle = __l('Refer a Friend'); ?>
<div class="pages">
<h2 class="ribbon-title clearfix">
		<span class="ribbon-left">
			<span class="ribbon-right">
				<span class="ribbon-inner">
					<?php echo sprintf(__l('Refer Friends and Get %s %s Bucks! '),$this->Html->siteCurrencyFormat(Configure::read('user.referral_amount')),Configure::read('site.name'));?>
				</span>
			</span>
		</span>
	</h2>
<div class="static-page-block clearfix">
<p><?php echo sprintf(__l('Get %s in %s Bucks when someone you invite gets their first %s. There is no limit on how much you can earn!'),$this->Html->siteCurrencyFormat(Configure::read('user.referral_amount')),Configure::read('site.name'),Configure::read('site.name')); ?></p>
	<?php if ($this->Auth->sessionValid()){ ?>
    <?php if(Configure::read('referral.referral_enabled_option') != ConstReferralOption::Disabled):?>
	<p><?php echo __l('Share your unique referral link'); ?></p>
	<p>	<input type="text" class="refer-box" readonly="readonly" value="<?php echo Router::url(array('controller' => 'users', 'action' => 'refer', 'r' =>$this->Auth->user('username')), true);?>" onclick="this.select()"/>
	</p>
    <?php endif;?>
	<div class="clearfix">
    <?php if(Configure::read('referral.referral_enabled_option') != ConstReferralOption::Disabled):?>
	<ul class="share-list clearfix">
		<li class="quick"><?php echo $this->Html->link(__l('Mail it'), 'mailto:?body='.sprintf(__l('Check out %s daily item for coolest stuff in your city. '),Configure::read('site.name')).'-'.Router::url(array('controller' => 'users', 'action' => 'refer', 'r' =>$this->Auth->user('username')), true).'&subject='.__l('I think you should get ').Configure::read('site.name'), array('class' => 'quick', 'target' => 'blank'));?></li>
		<li class="face"><?php echo $this->Html->link(__l('Share it on Facebook'), 'http://www.facebook.com/share.php?u='.Router::url(array('controller' => 'users', 'action' => 'refer', 'r' =>$this->Auth->user('username')), true), array('class' => 'face','target' => 'blank'));?></li>
		<li><a href="http://twitter.com/share?url=<?php echo Router::url(array('controller' => 'users', 'action' => 'refer', 'r' =>$this->Auth->user('username')), true);?>&amp;lang=en" data-count="none" class="twitter-share-button"><?php echo __l('Tweet it');?></a></li>
	</ul>
    <?php endif;?>
	</div>
	<?php }else { ?>
	<p class="sign-in-block"> <?php echo $this->Html->link(__l('Sign In'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Sign In'))); ?> <span><?php echo __l(' or ') ;?></span> <?php echo $this->Html->link(__l('Setup Your Account') , array('controller' => 'users',	'action' => 'register'),array('title' => __l('Signup')));?> <span> <?php echo __l(' to get your personal referral link.') ;?></span> </p>
	<?php } ?>
<h3><?php echo __l('Referral FAQ');?> <?php echo __l('What is this?'); ?></h3>
<p><?php echo sprintf(__l('We are giving %s in %s Bucks for every friend you refer when they make their first purchase. It is our way of saying "thanks" for spreading the word and increasing our collective buying power! %s Bucks can be used toward any %s purchase, and they never expire.'),$this->Html->siteCurrencyFormat(Configure::read('user.referral_amount')),Configure::read('site.name'),Configure::read('site.name'),Configure::read('site.name')); ?></p>
<h3><?php echo __l('How do I participate?'); ?></h3>
<p><?php echo __l('Share your personalized referral link using the tools to your left. When someone clicks that link, we will know you sent them.'); ?></p>
<h3><?php echo __l('What are the rules?'); ?></h3>
<p><?php echo sprintf(__l('If someone joins %s within %s hours after clicking your link, we will notify you within %s hours of their first purchase and automatically add %s %s Bucks to your account. You can refer as many people as you like. Check your balance by clicking My Stuff > My Transactions.'),Configure::read('site.name'),Configure::read('user.referral_cookie_expire_time'),Configure::read('user.referral_item_buy_time'),$this->Html->siteCurrencyFormat(Configure::read('user.referral_amount')),Configure::read('site.name')); ?></p>
</div>
</div>