<?php 
	if(!empty($type) && $type == 'merchant'){
		$action = "merchant_register";
	}
	else{
		$action = "register";
		$type = '';
	}
?>
<div class="users form page-block pages register-block <?php echo !empty($this->request->data['User']['is_requested']) ? 'js-login-response ajax-login-block' : ''; ?>">
<h2 class="ribbon-title clearfix">
<span class="ribbon-left">
	<span class="ribbon-right">
	<span class="ribbon-inner"><?php echo __l('Sign Up'); ?></span>
</span>
</span>
</h2>
<?php if(empty($type) && empty($this->request->data['User']['is_requested'])): ?>
       <div class="clearfix">
	   <div class="openid-block clearfix">
            <h5><?php echo __l('Sign In using: '); ?></h5>
			<ul class="open-id-list clearfix">
				<?php if(Configure::read('facebook.is_enabled_facebook_connect')):  ?>
					<li class="facebook"><?php echo $this->Html->link(__l('Sign in with Facebook'), array('controller' => 'users', 'action' => 'login','type'=>'facebook'), array('title' => __l('Sign in with Facebook'), 'escape' => false)); ?></li>
				<?php endif; ?>
				<?php if(Configure::read('foursquare.is_enabled_foursquare_connect')):?>
					<li class="foursquare"><?php echo $this->Html->link(__l('Sign in with Foursquare'), array('controller' => 'users', 'action' => 'login',  'type'=> 'foursquare', 'admin'=>false), array('class' => 'Foursquare', 'title' => __l('Sign in with Foursquare')));?></li>
				<?php endif;?>
				<?php if(Configure::read('twitter.is_enabled_twitter_connect')):?>
					<li class="twitter"><?php echo $this->Html->link(__l('Sign in with Twitter'), array('controller' => 'users', 'action' => 'login',  'type'=> 'twitter', 'admin'=>false), array('class' => 'Twitter', 'title' => __l('Sign in with Twitter')));?></li>
				<?php endif;?>
				<?php if(Configure::read('user.is_enable_yahoo_openid')):?>
					<li class="yahoo"><?php echo $this->Html->link(__l('Sign in with Yahoo'), array('controller' => 'users', 'action' => 'login', 'type'=>'yahoo'), array('title' => __l('Sign in with Yahoo')));?></li>
				<?php endif;?>
                <?php if(Configure::read('user.is_enable_gmail_openid')):?>	
                    <li class="gmail"><?php echo $this->Html->link(__l('Sign in with Gmail'), array('controller' => 'users', 'action' => 'login', 'type'=>'gmail'), array('title' => __l('Sign in with Gmail')));?></li>
                <?php endif;?>   
                <?php if(Configure::read('user.is_enable_openid')):?>
					<li class="open-id"><?php 	echo $this->Html->link(__l('Sign in with Open ID'), array('controller' => 'users', 'action' => 'login','type'=>'openid'), array('class'=>'','title' => __l('Sign in with Open ID')));?></li>
                <?php endif;?>
			</ul>
		</div>
		</div>
<?php endif; ?>
<?php
  		$formClass = !empty($this->request->data['User']['is_requested']) ? 'js-ajax-login' : '';
?>
<?php echo $this->Form->create('User', array('action' => $action, 'class' => 'normal js-merchant-map js-register-form '.$formClass)); ?>
	<fieldset>
    	<?php if(!empty($type)): ?>
    		   <fieldset class="form-block">
               <legend><?php echo __l('Account'); ?></legend>
        <?php endif; ?>
	<?php
		echo $this->Form->input('username',array('info' => __l('Must start with an alphabet. <br/> Must be minimum of 3 characters and <br/> Maximum of 20 characters <br/> No special characters and spaces allowed'),'label' => __l('Username')));
		echo $this->Form->input('email',array('label' => __l('Email')));
		echo $this->Form->input('referred_by_user_id',array('type' => 'hidden',));
		if(empty($this->request->data['User']['openid_url']) && empty($this->request->data['User']['fb_user_id']) && empty($this->request->data['User']['twitter_user_id'])):
			echo $this->Form->input('passwd', array('label' => __l('Password')));
			echo $this->Form->input('confirm_password', array('type' => 'password', 'label' => __l('Password Confirmation')));
			  echo $this->Form->input('type',array('type' => 'hidden', 'value' => $type));
		endif;
		if(!empty($this->request->data['User']['openid_url'])):
			  echo $this->Form->input('openid_url',array('type' => 'hidden'));
		endif;
        if(!empty($type)):
    		echo $this->Form->input('Merchant.name',array('label' => __l('Merchant Name')));
			echo $this->Form->input('Merchant.phone',array('label' => __l('Phone')));
    		echo $this->Form->input('Merchant.url',array('label' => __l('URL'), 'help' => __l('eg. http://www.example.com')));
		endif;
		if(!empty($this->request->data['User']['is_requested'])):
			echo $this->Form->input('is_requested', array('type' => 'hidden'));
		endif;
		if (!empty($this->request->data['User']['f'])):
			echo $this->Form->input('f', array('type' => 'hidden'));
		endif;
		?>
    	<?php if(!empty($type)): ?>
    		   </fieldset>
        <?php endif; ?>
    	<?php if(!empty($type)): ?>
    		   <fieldset class="form-block">
               <legend><?php echo __l('Address'); ?></legend>
        <?php endif; ?>
        <?php
        if(!empty($type))
        {
    		echo $this->Form->input('Merchant.address1',array('label' => __l('Address1')));
    		echo $this->Form->input('Merchant.address2',array('label' => __l('Address2')));
    		echo $this->Form->input('Merchant.country_id',array('empty'=> __l('Please Select'), 'label' => __l('Country')));
			echo $this->Form->autocomplete('State.name', array('label' => __l('State'), 'acFieldKey' => 'State.id', 'acFields' => array('State.name'), 'acSearchFieldNames' => array('State.name'), 'maxlength' => '255'));
    	    echo $this->Form->autocomplete('City.name', array('label' => __l('City'), 'acFieldKey' => 'City.id', 'acFields' => array('City.name'), 'acSearchFieldNames' => array('City.name'), 'maxlength' => '255'));
			echo $this->Form->input('Merchant.zip',array('label' => __l('Zip')));
		}else{
			echo $this->Form->input('country_iso_code', array('type' => 'hidden','id' => 'country_iso_code'));
			echo $this->Form->input('State.name', array('type' => 'hidden'));
			echo $this->Form->input('City.name', array('type' => 'hidden'));
		}
		if(!empty($refer)){
    		if(isset($_GET['refer']) && ($_GET['refer']!='')) {
    			$refer = $_GET['refer'];
    		}
    		echo $this->Form->input('referer_name', array('value' => $refer, 'label'=>__l('Reference Code')));
    	}else{
    		echo $this->Form->input('referer_name', array('type' => 'hidden'));
    	}
		?>
    	<?php if(!empty($type)): ?>
    		   </fieldset>
        <?php endif; ?>
	
	<?php  	if(!empty($type)):  ?>
	   <fieldset class="form-block">
               <legend><?php echo __l('Locate Yourself on Google Maps'); ?></legend>
		<?php 		
			echo $this->Form->input('Merchant.latitude',array('type' => 'hidden', 'id'=>'latitude'));
			echo $this->Form->input('Merchant.longitude',array('type' => 'hidden', 'id'=>'longitude'));
		?>
		<?php
				$map_zoom_level = !empty($this->request->data['Merchant']['map_zoom_level']) ? $this->request->data['Merchant']['map_zoom_level'] : Configure::read('GoogleMap.static_map_zoom_level');
				echo $this->Form->input('Merchant.map_zoom_level',array('type' => 'hidden','value' => $map_zoom_level,'id'=>'zoomlevel'));
			?>
			<div class="show-map show-map-block1" style="">
				<div id="js-map-container"></div>
			</div>
		 </fieldset>
   <?php endif; ?>


		<?php
		if(empty($this->request->data['User']['openid_url'])): ?>
    		<div class="input captcha-block clearfix js-captcha-container">
    			<div class="captcha-left">
    	           <?php echo $this->Html->image(Router::url(array('controller' => 'users', 'action' => 'show_captcha', md5(uniqid(time()))), true), array('alt' => __l('[Image: CAPTCHA image. You will need to recognize the text in it; audible CAPTCHA available too.]'), 'title' => __l('CAPTCHA image'), 'class' => 'captcha-img'));?>
    	        </div>
    	        <div class="captcha-right">
        	        <?php echo $this->Html->link(__l('Reload CAPTCHA'), '#', array('class' => 'js-captcha-reload captcha-reload', 'title' => __l('Reload CAPTCHA')));?>
        			<div>
		              <?php echo $this->Html->link(__l('Click to play'), Router::url('/', true)."flash/securimage/play.swf?audio=". $this->Html->url(array('controller' => 'users', 'action'=>'captcha_play'), true) ."&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5&height=19&width=19&wmode=transparent", array('class' => 'js-captcha-play')); ?>
			      </div>
    	        </div>
            </div>
        	<?php 
				echo $this->Form->input('captcha', array('label' => __l('Security Code'), 'class' => 'js-captcha-input'));
				$terms = $this->Html->link(__l('Terms & Policies'), array('controller' => 'pages', 'action' => 'view', 'term-and-conditions'), array('target' => '_blank'));
			?>
    		<?php echo $this->Form->input('is_agree_terms_conditions', array('label' => __l('I have read, understood &amp; agree to the ') .' ' . $terms)); ?>
		<?php endif; ?>
		<?php
			if(!empty($this->request->data['User']['foursquare_user_id'])):
				echo $this->Form->input('foursquare_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['foursquare_user_id']));
			endif;
			if(!empty($this->request->data['User']['foursquare_access_token'])):
				echo $this->Form->input('foursquare_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['foursquare_access_token']));
			endif;
			if(!empty($this->request->data['User']['fb_user_id'])):
				echo $this->Form->input('fb_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['fb_user_id']));
			endif;
			if(!empty($this->request->data['User']['fb_access_token'])):
				echo $this->Form->input('fb_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['fb_access_token']));
			endif;
			if(!empty($this->request->data['User']['twitter_user_id'])) :
				echo $this->Form->input('twitter_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['twitter_user_id']));
			endif;		 
			if(!empty($this->request->data['User']['twitter_avatar_url'])) :
				echo $this->Form->input('twitter_avatar_url', array('type' => 'hidden', 'value' => $this->request->data['User']['twitter_avatar_url']));
			endif;		 
			if(!empty($this->request->data['User']['twitter_access_token'])) :
				echo $this->Form->input('twitter_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['twitter_access_token']));
			endif;		 
			if(!empty($this->request->data['User']['twitter_access_key'])) :
				echo $this->Form->input('twitter_access_key', array('type' => 'hidden', 'value' => $this->request->data['User']['twitter_access_key']));
			endif;
			if(!empty($this->request->data['User']['is_yahoo_register'])) :
				echo $this->Form->input('is_yahoo_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_yahoo_register']));
			endif;
			if(!empty($this->request->data['User']['is_gmail_register'])) :
				echo $this->Form->input('is_gmail_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_gmail_register']));
			endif;
			if(!empty($this->request->data['User']['is_facebook_register'])) :
				echo $this->Form->input('is_facebook_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_facebook_register']));
			endif;
			if(!empty($this->request->data['User']['is_twitter_register'])) :
				echo $this->Form->input('is_twitter_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_twitter_register']));
			endif;
			if(!empty($this->request->data['User']['is_foursquare_register'])) :
				echo $this->Form->input('is_foursquare_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_foursquare_register']));
			endif;
		?>
   	<div class="submit-block clearfix">
		<?php
		echo $this->Form->submit(__l('Submit'));?>
    </div>
</fieldset>
 <?php  echo $this->Form->end();?>
</div>