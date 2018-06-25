<?php /* SVN: $Id: admin_add.ctp 54451 2011-05-24 12:26:17Z arovindhan_144at11 $ */ ?>
<?php echo $this->element('js_tiny_mce_setting', array('cache' => array('config' => 'site_element_cache')));?>
<div class="merchants form clearfix">
	<?php echo $this->Form->create('Merchant', array('class' => 'normal js-merchant-map','enctype' => 'multipart/form-data')); ?>
	<fieldset class="form-block">
		<legend><?php echo __l('Account'); ?></legend>
		<?php
			echo $this->Form->input('User.username',array('label' => __l('Username')));
			echo $this->Form->input('User.passwd',array('label' => __l('Password')));
			echo $this->Form->input('name',array('label' => __l('Merchant Name')));
			echo $this->Form->input('phone',array('label' => __l('Phone')));
			echo $this->Form->input('url',array('label' => __l('URL'), 'info' => __l('eg. http://www.example.com')));
			echo $this->Form->input('User.email',array('label' => __l('Email')));
		?>
		<?php echo $this->Form->input('is_online_account',array('label' =>__l('Online Account'), 'info' => __l('Only online merchant can login and make payment via site. Offline merchant can process manually. ')));?>
	</fieldset>
	<fieldset class="form-block">
		<legend><?php echo __l('Address'); ?></legend>
		<?php
			echo $this->Form->input('address1',array('label' => __l('Address1')));
			echo $this->Form->input('address2',array('label' => __l('Address2')));
			echo $this->Form->input('country_id',array('label' => __l('Country'),'empty' => __l('Please Select')));
			echo $this->Form->autocomplete('State.name', array('label' => __l('State'), 'acFieldKey' => 'State.id', 'acFields' => array('State.name'), 'acSearchFieldNames' => array('State.name'), 'maxlength' => '255'));
			echo $this->Form->autocomplete('City.name', array('label' => __l('City'), 'acFieldKey' => 'City.id', 'acFields' => array('City.name'), 'acSearchFieldNames' => array('City.name'), 'maxlength' => '255'));		
			echo $this->Form->input('zip',array('label' => __l('Zip')));					
		?>
	</fieldset>
	<fieldset class="form-block">
		<legend><?php echo __l('Merchant Profile'); ?></legend>
		<?php
			echo $this->Form->input('is_merchant_profile_enabled', array('label' => __l('Enable merchant profile'), 'class' => 'js_merchant_profile js_merchant_profile_enable', 'info' => __l('Whether other users can view the merchant profile or not')));
		?>
		<div class="js-merchant_profile_show">		 		
			<?php echo $this->Form->input('merchant_profile', array('label' => __l('Merchant Profile'), 'type' => 'textarea', 'class' => 'js-editor'));?>
		</div>
	</fieldset>
	<fieldset class="form-block round-5 js-item-cities">
		<legend><?php echo __l('Commission'); ?></legend>
		<div class="js-subitem-not-need">
			<h3><?php echo __l('Commission'); ?></h3>
			<div class="page-info">
				<?php echo __l('Total Commission Amount = Bonus Amount + ((Total Purchased Amount) * Commission Percentage/100))'); ?>
			</div>
			<div class="clearfix">
				<div class="commision-form-block">
					<?php
						if(Configure::read('site.currency_symbol_place') == 'left'):
							$currecncy_place = 'between';
						else:
							$currecncy_place = 'after';
						endif;
						echo $this->Form->input('bonus_amount', array('label' => __l('Bonus Amount'), $currecncy_place => '<span class="currency">'.Configure::read('site.currency'). '</span>'));
					?>
					<span class="info"> <?php echo __l('This is the flat fee that the merchant will pay for the whole item.');?></span>
					<?php
						if(($this->Auth->user('user_type_id') != ConstUserTypes::Admin) && (Configure::read('item.is_admin_enable_commission')) && Configure::read('item.commission_amount_type') == 'fixed'):
							echo $this->Form->input('commission_percentage', array('Readonly' =>'Readonly', 'info' => __l('This is the commission that merchant will pay for the whole item in percentage.'), 'label' => __l('Commission (%)')));
						else:
							if($this->Auth->user('user_type_id') != ConstUserTypes::Admin && Configure::read('item.is_admin_enable_commission') && Configure::read('item.commission_amount_type') == 'minimum'):
								$comm_info = sprintf(__l('This is the commission that merchant will pay for the whole item in percentage. The Commission set must be greater than %s'), $this->Html->siteCurrencyFormat(Configure::read('item.commission_amount')));
							else:
								$comm_info = __l('This is the commission that merchant will pay for the whole item in percentage.');
							endif;
							echo $this->Form->input('commission_percentage', array('info' => $comm_info, 'label' => __l('Commission (%)')));
						endif; 
					?>
				</div>
			</div>
		</div>
	</fieldset>
	<fieldset class="form-block">
		<legend><?php echo __l('Paypal Account'); ?></legend>
		<?php echo $this->Form->input('User.UserProfile.paypal_account');?>
	</fieldset>
	<fieldset class="form-block">
		<legend><?php echo __l('Locate yourself on google maps'); ?></legend>
		<div class="show-map">
			<div id="js-map-container"></div>
				<p><?php echo __l('You can change the google map zooming level here, else default zooming level will be taken.'); ?></p>
			</div>
			<?php
				echo $this->Form->input('latitude',array('type' => 'hidden', 'id'=>'latitude'));
				echo $this->Form->input('longitude',array('type' => 'hidden', 'id'=>'longitude'));
				$map_zoom_level = !empty($this->request->data['Merchant']['map_zoom_level']) ? $this->request->data['Merchant']['map_zoom_level'] : Configure::read('GoogleMap.static_map_zoom_level');
				echo $this->Form->input('Merchant.map_zoom_level',array('value' => $map_zoom_level,'id'=>'zoomlevel'));
			?>
	</fieldset>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Add')); ?>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<?php 
	if (!empty($this->request->data['Merchant']['is_merchant_profile_enabled'])) {
		$show_merchant_profile = 1;
	} else {
		$show_merchant_profile = 0;
	}
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.js_merchant_profile').merchantprofile(<?php echo $show_merchant_profile; ?>);
	});
</script>