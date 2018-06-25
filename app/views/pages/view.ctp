<div class="pages">
	<?php if(empty($this->request->params['prefix'])) : ?>
		<h2 class="ribbon-title clearfix">
			<span class="ribbon-left">
				<span class="ribbon-right">
					<span class="ribbon-inner"><?php echo $page['Page']['title']; ?></span>
				</span>
			</span>
		</h2>
	<?php endif; ?>
<?php
if($this->request->params['pass'][0]=='home'){ ?>
	<div class="static-pages-block" id="static-content">
	<?php echo $page['Page']['content']; ?>
	</div>

<?php }else if($this->request->params['pass'][0]=='about-us'){ ?>
	<div class="static-pages-block" id="static-content">
	<?php echo $page['Page']['content']; ?>
	</div>

<?php }else if($this->request->params['pass'][0]=='career'){ ?>
	<div class="static-pages-block" id="static-content">
		<?php echo $page['Page']['content']; ?>
	</div>
<?php }elseif($this->request->params['pass'][0]=='distributor'){ ?>
	<div class="static-pages-block" id="static-content">
		<?php echo $page['Page']['content']; ?>
	</div>
<?php }else if($this->request->params['pass'][0]=='pre-launch'){ ?>
<div class="pre-launch-block">
<div class="pre-launch-inner-block" style="<?php echo 'background:url('.$this->Html->url(getImageUrl('PageLogo', $background_attachment['Attachment'], array('dimension' => 'original'))).') no-repeat center center'; ?>">
	<?php 
		$str = $this->element('subscriptions-add', array('is_from_pages' => 'pages'));
		$contents = str_replace("##FORM##", $str, $page['Page']['content']);
		echo $contents;
	?>
</div>
</div>
<?php }elseif($this->request->params['pass'][0]=='distributor'){ ?>
	<div class="static-pages-block" id="static-content">
		<?php echo $page['Page']['content']; ?>
	</div>
<?php }elseif($this->request->params['pass'][0]=='contactus'){ ?>
		<div class="static-pages-block" id="static-content">
			<?php echo $page['Page']['content']; ?>
		</div>
<?php }elseif($this->request->params['pass'][0]=='privacy-policy'){ ?>	
		<div class="static-pages-block" id="static-content">
			<?php echo $page['Page']['content']; ?>
		</div>
<?php }elseif($this->request->params['pass'][0]=='disclaimer'){ ?>
		<div class="static-pages-block" id="static-content">
			<?php echo $page['Page']['content']; ?>	
		</div>
<?php }elseif($this->request->params['pass'][0]=='terms-of-use'){ ?>
		<div class="static-pages-block" id="static-content">
			<?php echo $page['Page']['content']; ?>
		</div>
<?php }elseif($this->request->params['pass'][0]=='merchant'){
?>
    <div class="static-pages-block clearfix">
    			<?php if(!$this->Auth->sessionValid()):?>
    <div class="register-block">
        <div class="item-side2 login-side2 item">
            <div class="item-inner-block item-bg round-15 clearfix">
              <h3><?php echo __l('Business'); ?></h3>
              <h3><?php echo __l('Sign Up / Sign In'); ?></h3>
              <p> <?php echo $this->Html->link(__l('Login'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Login')));?></p>
               <p> <?php echo $this->Html->link(__l('Register'), array('controller' => 'merchant', 'action' => 'user', 'register'), array('title' => __l('Register')));?>
              </p>
              <div class="openid-block">
    			<ul class="open-id-list clearfix">
					<?php if(Configure::read('facebook.is_enabled_facebook_connect')):?>
	    			     <li class="facebook"><?php echo $this->Html->link(__l('Sign in with Facebook'), array('controller' => 'users', 'action' => 'login','type'=>'facebook', 'user_type' => 'merchant'), array('title' => __l('Sign in with Facebook'), 'escape' => false)); ?></li>
					<?php endif;?>
					 <?php if(Configure::read('foursquare.is_enabled_foursquare_connect')):?>
						<li class="foursquare"><?php echo $this->Html->link(__l('Sign in with Foursquare'), array('controller' => 'users', 'action' => 'login',  'type'=> 'foursquare', 'user_type' => 'merchant', 'admin'=>false), array('class' => 'Foursquare', 'title' => __l('Sign in with Foursquare')));?></li>
					<?php endif;?>
    				<?php if(Configure::read('twitter.is_enabled_twitter_connect')):?>
    					<li class="twitter"><?php echo $this->Html->link(__l('Sign in with Twitter'), array('controller' => 'users', 'action' => 'login',  'type'=> 'twitter', 'user_type' => 'merchant', 'admin'=>false), array('class' => 'Twitter', 'title' => __l('Sign in with Twitter')));?></li>
    				<?php endif;?>
    				<?php if(Configure::read('user.is_enable_yahoo_openid')):?>
    					<li class="yahoo"><?php echo $this->Html->link(__l('Sign in with Yahoo'), array('controller' => 'users', 'action' => 'login', 'type'=>'yahoo', 'user_type' => 'merchant'), array('alt'=> __l('[Image: Yahoo]'),'title' => __l('Sign in with Yahoo')));?></li>
    				<?php endif;?>
					<?php if(Configure::read('user.is_enable_gmail_openid')):?>	
                        <li class="gmail"><?php echo $this->Html->link(__l('Sign in with Gmail'), array('controller' => 'users', 'action' => 'login', 'type'=>'gmail', 'user_type' => 'merchant'), array('alt'=> __l('[Image: Gmail]'),'title' => __l('Sign in with Gmail')));?></li>
    				<?php endif;?>
					<?php if(Configure::read('user.is_enable_openid')):?>
                        <li class="openid"><?php echo $this->Html->link(__l('Sign in with OpenID'), array('controller' => 'users', 'action' => 'login','type'=>'openid', 'user_type' => 'merchant'), array('class'=>'js-ajax-colorbox-openid {source:"js-dialog-body-open-login"}','title' => __l('Sign in with OpenID')));?></li>
    				<?php endif;?>
				</ul>
              <div class="item-bot-bg"> </div>
            </div>
          </div>
     </div>
     </div>
     <?php endif; ?>
		<?php echo $page['Page']['content']; ?>
	</div>

<?php
}else if($this->request->params['pass'][0]=='api' || $this->request->params['pass'][0]=='api-terms-of-use' || $this->request->params['pass'][0]=='api-branding-requirements' || $this->request->params['pass'][0]=='api-instructions'){ ?>
		<div class="static-pages-block" id="static-content">
			<?php echo $page['Page']['content']; ?>
		</div>
	<ul class="api-list">
			<li><?php echo $this->Html->link(__l('Terms of Use'), array('controller' => 'pages', 'action' => 'view', 'api-terms-of-use'), array('title' => __l('Terms of Use'), 'target' => '_blank'));?></li>
			<li><?php echo $this->Html->link(__l('Branding Requirements'), array('controller' => 'pages', 'action' => 'view', 'api-branding-requirements'), array('title' => __l('Branding Requirements'), 'target' => '_blank'));?></li>
			<li><?php echo $this->Html->link(__l('API Instructions'), array('controller' => 'pages', 'action' => 'view', 'api-instructions'), array('title' => __l('API Instructions'), 'target' => '_blank'));?></li>
	</ul>

<?php } elseif($this->request->params['pass'][0]=='how_it_works') { ?>
	<?php if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']): ?>
	    <span><?php echo $this->Html->link(__l('Continue Editing'), array('action' => 'edit', $page['Page']['id']), array('class' => 'edit js-edit', 'title' => __l('Continue Editing')));?></span>
		<?php endif; ?>
		<div id="static-content" class="static-pages-block about-content js-page-content {'user_type':'<?php echo $this->Auth->user('user_type_id');?>'}">
			<?php echo $page['Page']['content']; ?>
		</div>
<?php } else { ?>
	<?php if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type']): ?>
	    <span><?php echo $this->Html->link(__l('Continue Editing'), array('action' => 'edit', $page['Page']['id']), array('class' => 'edit js-edit', 'title' => __l('Continue Editing')));?></span>
		<?php endif; ?>
		<div id="static-content" class="static-pages-block about-content">
			<?php echo $page['Page']['content']; ?>
		</div>
	
<?php } ?>
</div>
