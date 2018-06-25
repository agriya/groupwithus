<?php /* SVN: $Id: add.ctp 55147 2011-05-31 11:13:31Z aravindan_111act10 $ */ ?>
<?php echo $this->element('js_tiny_mce_setting', array('cache' => array('config' => 'site_element_cache')));?>
<div class="items form js-responses">
<?php 
if(empty($this->request->data['CloneAttachment'][0])) 
	echo $this->Form->create('Item', array('action' => 'add', 'class' => 'normal js-upload-form {is_required:"true"}', 'enctype' => 'multipart/form-data'));
else
	echo $this->Form->create('Item', array('action' => 'add', 'class' => 'normal js-upload-form {is_required:"false"}', 'enctype' => 'multipart/form-data'));
?>

	<div class="js-validation-part">
		<?php if ($this->Auth->user('user_type_id') == ConstUserTypes::Merchant): ?>
			<h2 class="ribbon-title clearfix"><span class="ribbon-left"><span class="ribbon-right"><span class="ribbon-inner"><?php echo __l('Add Item');?></span></span></span></h2>
		<?php endif; ?>
		<?php if($this->Auth->user('user_type_id') == ConstUserTypes::Merchant):?>
			<div class="additem-img-block"><?php echo $this->Html->image('company-item-flow.jpg', array('height'=>'181','width'=>'640','alt'=> __l('[Image: Merchant Item Flow]'), 'title' => __l('Merchant Item Flow'))); ?></div>
		<?php else: ?>
			<div class="additem-img-block"> <?php echo $this->Html->image('admin-item-flow.jpg', array('height'=>'164','width'=>'523','alt'=> __l('[Image: Administrator Item Flow]'), 'title' => __l('Administrator Item Flow'))); ?></div>
		<?php endif; ?>
		<fieldset class="form-block">
			<legend><?php echo __l('General'); ?></legend>
			<?php
				echo $this->Form->input('user_id', array('type' => 'hidden'));
				echo $this->Form->input('clone_item_id', array('type' => 'hidden'));
				echo $this->Form->input('name',array('label' => __l('Name')));
				if($this->Auth->user('user_type_id') == ConstUserTypes::Admin):
					$url=Router::url(array('controller'=>'merchants','action'=>'commission'),true);
					echo $this->Form->input('merchant_id', array('label' => __l('Merchant'),'empty' =>__l('Please Select'),'class'=>'js-merchant-select {"url":"'.$url.'"}'));
					echo $this->Form->input('merchant_slug', array('type' => 'hidden'));
				else:
					echo $this->Form->input('merchant_id', array('type' => 'hidden'));
					echo $this->Form->input('merchant_slug', array('type' => 'hidden'));
				endif;
				if (Configure::read('item.is_enable_item_category')):
					echo $this->Form->input('ItemCategory', array('label' => 'Category', 'multiple' => 'checkbox'));
				endif;
				echo $this->Form->input('menu',array('label' => __l('Menu'),'type' =>'textarea', 'class' => 'js-editor {"width":"300px"}'));
				if(Configure::read('site.currency_symbol_place') == 'left'):
					$currecncy_place = 'between';
				else:
					$currecncy_place = 'after';
				endif;

				echo $this->Form->input('price',array('label' => __l('Price'), $currecncy_place => '<span class="currency">'.Configure::read('site.currency'). '</span>'));
			?>
			<div class="clearfix date-time-block">
				<div class="input date-time clearfix required">
					<div class="js-datetime">
						<?php echo $this->Form->input('end_date', array('label' => __l('End Date'),'minYear' => date('Y'), 'maxYear' => date('Y') + 10, 'div' => false, 'empty' => __l('Please Select'), 'orderYear' => 'asc')); ?>
					</div>
				</div>
			</div>
			<div class="clearfix date-time-block">
				<div class="input date-time clearfix required">
					<div class="js-datetime">
						<?php echo $this->Form->input('event_date', array('label' => __l('Event Date'),'minYear' => date('Y'), 'maxYear' => date('Y') + 10, 'div' => false, 'empty' => __l('Please Select'), 'orderYear' => 'asc')); ?>
					</div>
				</div>
			</div>
			<?php echo $this->Form->input('is_be_next', array('label'=>__l('Is there be next?'),'class'=>'js-box-show {"container":"js-next-price"}'));
			     $price_class=empty($this->request->data['Item']['is_be_next']) ? "hide" : '';
			?>
			<div class="<?php echo $price_class; ?> js-next-price"> 
			<?php echo $this->Form->input('be_next_increase_price',array('label' => __l('Be next increase price')));?>
			</div>
			<?php echo $this->Form->input('is_tipped_item', array('label'=>__l('Is there tipping point?'),'class'=>'js-box-show {"container":"js-min-qty"}')); ?>


		</fieldset>
		<fieldset class="form-block">
			<legend><?php echo __l('Passes & Quantities'); ?></legend>
			<div class="clearfix">
				<div class="clearfix input-blocks">
	<?php 			$tipped_class=empty($this->request->data['Item']['is_tipped_item']) ? "hide" : ''; ?>
					<div class=" input-block-left  <?php echo $tipped_class; ?>  js-min-qty">
						<?php

							echo $this->Form->input('min_limit', array('label'=>__l('No of Min Passes'), 'info' => __l('Minimum limit of passes to be bought by users, in order for the item to get tipped.')));
						?>
					</div>
					<div >
						<div class="input-block-right">
							<?php	echo $this->Form->input('max_limit', array('label'=>__l('No of Max Passes'), 'info' => __l('Maximum limit of passes can be bought for this item. Leave blank for no limit.'))); ?>
						</div>
					</div>
				</div>
				<div class="clearfix input-blocks">
					<div class=" input-block-left">
						<?php
							echo $this->Form->input('buy_min_quantity_per_user', array('label'=>__l('Minimum Buy Quantity'),'info' => __l('Minimum purchase per user including gifts.')));
						?>
					</div>
					<div class="input-block-right ">
						<?php
							echo $this->Form->input('buy_max_quantity_per_user', array('label'=>__l('Maximum Buy Quantity'),'info' => __l('Maximum purchase per user including gifts. Leave blank for no limit.')));
						?>
				   </div>
			   </div>
			</div>
		</fieldset>
		<fieldset class="form-block round-5 ">
			<legend><?php echo __l('Commission'); ?></legend>
		<div class="js-subitem-not-need">
		
				<h3><?php echo __l('Commission'); ?></h3>
				<div class="page-info">
					<?php
						echo __l('Total Commission Amount = Bonus Amount + ((Total Purchased Amount) * Commission Percentage/100))');
					 ?>
				</div>
				<div class="clearfix">
					<div class="commision-form-block">
						<?php
							echo $this->Form->input('bonus_amount', array('label' => __l('Bonus Amount'),$currecncy_place => '<span class="currency">'.Configure::read('site.currency'). '</span>'));
						?>
						<span class="info"> <?php echo __l('This is the flat fee that the merchant will pay for the whole item.');?></span>
						<?php if(($this->Auth->user('user_type_id') != ConstUserTypes::Admin) && (Configure::read('item.is_admin_enable_commission')) && Configure::read('item.commission_amount_type') == 'fixed'):
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
		<fieldset class="form-block round-5 ">
			<legend><?php echo __l('Item Interests'); ?></legend>
			<div class="input cities-block required">
				<label><?php echo __l('Interests');?></label>
			</div>


					<div class="cities-checkbox-block clearfix">
						<?php
					echo $this->Form->input('UserInterest',array('label' => false,'multiple'=>'checkbox')); ?>
					</div>
					
		</fieldset>  		<fieldset class="form-block round-5 js-item-cities">
			<legend><?php echo __l('Item Cities'); ?></legend>
			<div class="input cities-block required">
				<label><?php echo __l('Cities');?></label>
			</div>
			<?php
				if(empty($this->request->data['Item']['City']) && empty($city_id)): ?>
					<div class="cities-checkbox-block clearfix">
						<?php
						echo $this->Form->input('City',array('label' =>false,'multiple'=>'checkbox')); ?>
					</div>
					<?php
				else:
				 ?>
				 <div class="cities-checkbox-block clearfix">
				 <?php
					echo $this->Form->input('City',array('label' => false,'multiple'=>'checkbox','value'=>$city_id));
				?>
					</div>
				<?php
				endif;
			?>
		</fieldset>  
	    <fieldset class="form-block">
			<legend><?php echo __l('Description'); ?></legend>
			<?php
				echo $this->Form->input('description', array('label' => __l('Description'),'type' =>'textarea', 'class' => 'js-editor'));
			?>
	   </fieldset>
    	 <?php if(Configure::read('charity.is_enabled') == 1):?>
			<fieldset class="form-block round-5 js-item-cities">
			<legend><?php echo __l('Charity'); ?></legend>
			<div class="page-info">
				<?php echo __l('You can decide whether you want to give amount to charity');?>
				<?php if($this->Auth->user('user_type_id') == ConstUserTypes::Admin):?>
					<p><?php echo __l('Amount to the charity will be given from the commission amount you have earned.');?></p>
				<?php else:?>
					<p><?php echo __l('Amount to the charity will be given from admin commission amount. Your profit wont be affected.');?></p>
				<?php endif;?>
			</div>
			<?php if(Configure::read('charity.who_will_choose') == ConstCharityWhoWillChoose::MerchantUser): ?>
				<?php echo $this->Form->input('charity_id', array('empty' =>__l('Please Select'))); ?>
			<?php endif; ?>
			<?php echo $this->Form->input('charity_percentage', array('label' => __l('Charity Percentage (%)'),'info' =>__l('Percentage of amount you would like to give for charity.'))); ?>
			<?php if(Configure::read('charity.who_will_pay') == ConstCharityWhoWillPay::Admin || Configure::read('charity.who_will_pay') == ConstCharityWhoWillPay::AdminMerchantUser): ?>
			<div class="page-info">
			<?php
				echo __l('Admin also pay same percentage of amount from his commission');
			 ?>
			 </div>
			 <?php endif; ?>
			</fieldset>
		  <?php endif; ?>
		  </div>
		  	<!-- End of validation part div -->
   <fieldset class="form-block">
		<legend><?php echo __l('Item Image'); ?></legend>
			<div class="required">
			<div class="input required gig-img-label">
					<label><?php echo __l('Item Images');?></label>
			
				<?php
					$redirect_check = (!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') ? "true" : "false";
					if($this->Auth->user('user_type_id') == ConstUserTypes::Admin):
						$redirect_array = array('controller' => 'items', 'action' => 'index', 'type' => 'success','admin' => true);
					else:
						$redirect_array = array('controller' => 'items', 'action' => 'merchant', $this->request->data['Item']['merchant_slug'], 'success','admin' => false);
					endif;
					echo $this->Form->uploader('Attachment.filename', array('type'=>'file', 'uController' => 'items', 'uRedirectURL' => $redirect_array, 'uId' => 'itemID', 'uFiletype' => Configure::read('photo.file.allowedExt')));
				?>
		
				</div>
                <div class="clearfix attachment-delete-outer-block">
				<?php
				 if(!empty($this->request->data['CloneAttachment'][0])) {?>
                 	<ul>
					<?php
						
                	$i =0;
                	foreach($this->request->data['CloneAttachment'] as $CloneAttachment){ ?>
                    	<li>	
							<div class="attachment-delete-block">
							  <span class="delete-photo"> <?php echo __l('Delete Photo'); ?></span>
                    <?php 
                    echo $this->Form->input('OldAttachment.'.$CloneAttachment['id'].'.id', array('type' => 'checkbox', 'class'=>'','id' => "gig_checkbox_".$CloneAttachment['id'], 'label' => false));
                    echo $this->Form->input('CloneAttachment.'.$i.'.id', array('type' => 'hidden', 'value' => $CloneAttachment['id']));
					echo $this->Html->showImage('Item', $CloneAttachment, array('dimension' => 'normal_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($this->request->data['Item']['name'], false)), 'title' => $this->Html->cText($this->request->data['Item']['name'], false), 'escape' => false));
					$i++;?>
					</div>
                    </li>
                    
					<?php 
					}?>
                    </ul>
                <?php }	?>
                </div>
			</div>
		</fieldset>
	    
         
		<fieldset class="form-block">
			<legend><?php echo __l('Item Passes'); ?></legend>
				<div class="page-info"><?php echo __l('Users can use this pass code at the time of purchase irrespective of types of users. If you leave this field be free or else entered the less passes than the users can possible to purchase then system will automatically generate the passes to compensate the total no of passes users has purchased.');?></div>
					<?php echo $this->Form->input('pass_code', array('type' => 'textarea', 'info' => __l('Comma seperated for multiple passes. <br />e.g., 000781b0-1, 0004e1b0-6, 00a481b0-8')));?>
		</fieldset>
	<div class="submit-block clearfix">
		<?php echo $this->Form->input('is_save_draft', array('type' => 'hidden', 'id' => 'js-save-draft'));?>
		<div class="submit-button-sec">
			<?php
				echo $this->Form->submit(__l('Add'), array('class' => 'js-update-order-field'));
				echo $this->Form->submit(__l('Save as Draft'), array('name' => 'data[Item][save_as_draft]', 'class' => 'js-update-order-field'));
			?>
		</div>
		<div class=" hide">
			<?php 			
				echo $this->Form->submit(__l('Continue'), array('name' => 'data[Item][continue]', 'class' => 'js-update-order-field'));
			?>		
		</div>
   </div>
   	<?php if($this->Auth->user('user_type_id') == ConstUserTypes::Admin):?>
       	<div class="info-details"><?php echo __l('Save this item as draft and make changes until you send it to open status. Use the update button in edit page to send it to open status.'); ?></div>
    <?php else:?>
        <div class="info-details"><?php echo __l('Save this item as draft and make changes until you send it to pending status. Use the update button in edit page to send it to pending status.'); ?></div>
    <?php endif;?>
<?php echo $this->Form->end();
?>
</div>