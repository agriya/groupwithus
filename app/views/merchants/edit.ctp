<?php /* SVN: $Id: edit.ctp 54767 2011-05-27 05:55:26Z aravindan_111act10 $ */ ?>
<?php if($this->Auth->user('user_type_id') == ConstUserTypes::Merchant):?>
	<?php if(empty($this->request->params['isAjax']) or !$this->request->params['isAjax']):?>		 
		 <?php echo $this->element('js_tiny_mce_setting', array('config' => 'sec'));?>
   <?php endif; ?>
<?php endif; ?>
<div class="merchants form js-responses">
<div class="js-tabs">
	<ul class="clearfix">
		<li><?php echo $this->Html->link(__l('My Profile'), '#my-profile'); ?></li>
		<?php if ($this->Html->isAllowed($this->Auth->user('user_type_id'))): ?>
			<?php $is_show_credit_cards = $this->Html->isAuthorizeNetEnabled(); ?>
			<?php if (!empty($is_show_credit_cards)): ?>
				<li><?php echo $this->Html->link(__l('Credit Cards'), array('controller' => 'user_payment_profiles', 'action' => 'index', 'admin' => false), array('title' => 'Credit Cards', 'rel' => '#Credit_cards')); ?></li>
			<?php endif; ?>
			<?php if(!$this->Auth->user('is_twitter_register') && !$this->Auth->user('is_facebook_register') && !$this->Auth->user('is_gmail_register') && !$this->Auth->user('is_yahoo_register') && !$this->Auth->user('is_foursquare_register') && !$this->Auth->user('is_openid_register')){?>
				<li><?php  echo $this->Html->link(__l('Change Password'),array('controller'=> 'users', 'action'=>'change_password'),array('title' => 'Change Password', 'rel' => '#Change_Password')); ?></li>
			<?php } ?>
			<li><?php echo $this->Html->link(__l('Job Info'), array('controller' => 'user_jobs', 'action' => 'index', 'admin' => false), array('title' => 'Job Info', 'rel'=> '#Job_Info')); ?></li>
			<li><?php echo $this->Html->link(__l('School Info'), array('controller' => 'user_schools', 'action' => 'index', 'admin' => false), array('title' => 'School Info', 'rel'=> '#School_Info')); ?></li>
		<?php endif; ?>
	</ul>
	<div id="my-profile" class="clearfix">
    <h2 class="ribbon-title clearfix">
		<span class="ribbon-left">
			<span class="ribbon-right">
				<span class="ribbon-inner">
					<?php echo __l('Edit Merchant');?>
				</span>
			</span>
		</span>
	</h2>
	
		<?php echo $this->Form->create('Merchant', array('class' => 'normal js-merchant-map js-ajax-form', 'enctype' => 'multipart/form-data'));?>
		
           <fieldset class="form-block">
               <legend><?php echo __l('Account'); ?></legend>
                <?php
                    echo $this->Form->input('id');
                    echo $this->Form->input('name',array('label' => __l('Merchant Name')));
                    echo $this->Form->input('phone',array('label' => __l('Phone')));
                    echo $this->Form->input('url',array('label' => __l('URL'), 'info' => __l('eg. http://www.example.com')));
				?>
			</fieldset>
           <fieldset class="form-block">
               <legend><?php echo __l('Address'); ?></legend>
					<?php
                        echo $this->Form->input('address1',array('label' => __l('Address1')));
                        echo $this->Form->input('address2',array('label' => __l('Address2')));
                        echo $this->Form->input('country_id',array('label' => __l('Country')));
                        echo $this->Form->autocomplete('State.name', array('label' => __l('State'), 'acFieldKey' => 'State.id', 'acFields' => array('State.name'), 'acSearchFieldNames' => array('State.name'), 'maxlength' => '255'));
						echo $this->Form->error('state_id');
                        echo $this->Form->autocomplete('City.name', array('label' => __l('City'), 'acFieldKey' => 'City.id', 'acFields' => array('City.name'), 'acSearchFieldNames' => array('City.name'), 'maxlength' => '255'));
						echo $this->Form->error('city_id');						
                        echo $this->Form->input('zip',array('label' => __l('Zip')));
					?>	
           </fieldset>
           <fieldset class="form-block">
               <legend><?php echo __l('Logo'); ?></legend>
                <div class="merchant-profile-image clearfix">
					<div class="profile-image"><?php echo $this->Html->getUserAvatarLink($this->request->data['User'], 'normal_thumb'); ?></div>
					<?php echo $this->Form->input('UserProfile.language_id', array('empty' => __l('Please Select'),'label' => __l('Profile Language'), 'value' => $this->request->data['User']['UserProfile']['language_id'], 'info'=>__l('This will be the default site languge after logged in')));
					?>
                </div>               
				<?php 
                    echo $this->Form->input('UserAvatar.filename', array('type' => 'file','size' => '33', 'label' => __l('Upload Logo'),'class' =>'browse-field'));
                    echo $this->Form->input('User.id',array('type' => 'hidden'));
                ?>
           </fieldset>
        <div >
		<fieldset class="form-block">
			 <?php
					echo $this->Form->input('latitude',array('type' => 'hidden', 'id'=>'latitude'));
					echo $this->Form->input('longitude',array('type' => 'hidden', 'id'=>'longitude'));
			?>
			
			<legend><?php echo __l('Locate Yourself on Google Maps'); ?></legend>
				<div class="show-map">
					<div id="js-map-container"><?php echo __l('Please update address info to generate location Map'); ?></div>
				</div>
				<?php
				$map_zoom_level = !empty($this->request->data['Merchant']['map_zoom_level']) ? $this->request->data['Merchant']['map_zoom_level'] : Configure::read('GoogleMap.static_map_zoom_level');
				echo $this->Form->input('Merchant.map_zoom_level',array('type' => 'hidden','value' => $map_zoom_level,'id'=>'zoomlevel'));
			?>
		</fieldset>
		</div>
	    <div class="submit-block clearfix">
        <?php
        	echo $this->Form->submit(__l('Update'));
        ?>
        </div>
        <?php
        	echo $this->Form->end();
        ?>
	</div>
</div>
</div>