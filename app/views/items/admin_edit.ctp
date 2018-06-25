<?php /* SVN: $Id: admin_edit.ctp 54983 2011-05-28 12:18:42Z aravindan_111act10 $ */?>
<?php echo $this->element('js_tiny_mce_setting', array('cache' => array('config' => 'site_element_cache')));?>
<div class="items form js-responses">
<?php echo $this->Form->create('Item', array('class' => 'normal js-upload-form {is_required:"false"}', 'enctype' => 'multipart/form-data'));?>
	<fieldset>
    <h2><?php echo __l('Edit Item');?></h2>
	<div class="js-validation-part">
	    <fieldset class="form-block round-5">
			<legend class="round-5"><?php echo __l('General'); ?></legend>
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('name',array('label' => __l('Name')));
				$url=Router::url(array('controller'=>'merchants','action'=>'commission'),true);
				echo $this->Form->input('merchant_id', array('label' => __l('Merchant'),'empty' =>__l('Please Select'),'class'=>'js-merchant-select {"url":"'.$url.'"}'));
				if (Configure::read('item.is_enable_item_category')):
					echo $this->Form->input('ItemCategory', array('label' => 'Category', 'multiple' => 'checkbox'));
				endif;
				echo $this->Form->input('menu',array('label' => __l('Menu'),'type' =>'textarea', 'class' => 'js-editor'));
				if(Configure::read('site.currency_symbol_place') == 'left'):
					$currecncy_place = 'between';
				else:
					$currecncy_place = 'after';
				endif;
				echo $this->Form->input('price',array('label' => __l('Price'),'class' => 'js-price', $currecncy_place => '<span class="currency">'.Configure::read('site.currency'). '</span>'));
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
							<?php echo $this->Form->input('event_date', array('label' => __l('Event Date'),'minYear' => date('Y', strtotime($this->request->data['Item']['event_date'])), 'maxYear' => date('Y') + 10, 'div' => false, 'empty' => __l('Please Select'), 'orderYear' => 'asc')); ?>
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
			<?php //echo $this->Form->input('be_next_increase_price',array('label' => __l('Be next increase price')));?>
		</fieldset>
		<fieldset class="form-block round-5">
			<legend class="round-5"><?php echo __l('Passes & Quantities'); ?></legend>
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
<fieldset class="form-block round-5 js-item-cities">
			<legend class="round-5"><?php echo __l('Commission'); ?></legend>
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
			<legend class="round-5"><?php echo __l('Item Interests'); ?></legend>
			<div class="input cities-block required">
				<label><?php echo __l('Interests');?></label>
			</div>


					<div class="cities-checkbox-block clearfix">
						<?php
					echo $this->Form->input('UserInterest',array('label' => false,'multiple'=>'checkbox')); ?>
					</div>
					
		</fieldset>  
	
	<fieldset class="form-block round-5 js-item-cities">
			<legend class="round-5"><?php echo __l('Item Cities'); ?></legend>
			<div class="input cities-block required">
				<label><?php echo __l('Cities');?></label>
			</div>
			<?php if(empty($this->request->data['Item']['City'])): ?>
				<div class="cities-checkbox-block">
					<?php
						echo $this->Form->input('City',array('label' =>false,'multiple'=>'checkbox'));
					?>
				</div>
				<?php else:?>
				<div class="cities-checkbox-block">
					<?php echo $this->Form->input('City',array('label' =>false,'multiple'=>'checkbox','value'=>$city_id));?>
				</div>
			<?php endif;?>
		</fieldset>  
	   <fieldset class="form-block round-5">
			<legend class="round-5"><?php echo __l('Description'); ?></legend>
			<?php echo $this->Form->input('description', array('label' => __l('Description'),'type' =>'textarea', 'class' => 'js-editor'));?>
       </fieldset>
    </div> 
    <!--validation div close-->
	   <fieldset class="form-block round-5">
		<legend class="round-5"><?php echo __l('Item Image'); ?></legend>
		<div class="clearfix attachment-delete-outer-block">
			<ul>
				<?php 
					foreach($this->request->data['Attachment'] as $attachment){ 
				?>
					<li>	
					<div class="attachment-delete-block">
					  <span class="delete-photo"> <?php echo __l('Delete Photo'); ?></span>

					<?php	
						echo $this->Form->input('OldAttachment.'.$attachment['id'].'.id', array('type' => 'checkbox', 'class'=>'js-gig-photo-checkbox','id' => "gig_checkbox_".$attachment['id'], 'label' => false));
						echo $this->Html->showImage('Item', $attachment, array('dimension' => 'normal_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($this->request->data['Item']['name'], false)), 'title' => $this->Html->cText($this->request->data['Item']['name'], false)));
					?>
					</div>
					</li>
				<?php } ?>
			</ul>
        </div>        
		<?php
			echo $this->Form->uploader('Attachment.filename', array('type'=>'file', 'uController' => 'items', 'uRedirectURL' => array('controller' => 'items', 'action' => 'index', 'admin' => true), 'uId' => 'itemID', 'uFiletype' => Configure::read('photo.file.allowedExt')));
		?>
		</fieldset>
        	<?php if(Configure::read('charity.is_enabled') == 1):?>
			<fieldset class="form-block round-5 js-item-cities">
			<legend class="round-5"><?php echo __l('Charity'); ?></legend>			
			<div class="page-info">
				<?php echo __l('You can decide whether you want to give amount to charity');?>
				<?php if($this->Auth->user('user_type_id') == ConstUserTypes::Admin): ?>
					<span><?php echo __l('Amount to the charity will be given from the commission amount you have earned.');?></span>
				<?php else:?>
					<span><?php echo __l('Amount to the charity will be given from admin commission amount. Your profit wont be affected.');?></span>
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
           	<fieldset class="form-block round-5">
			<legend class="round-5"><?php echo __l('Item Passes'); ?></legend>
				<span><?php echo $this->Html->link(__l('List Existing Passes'), array('controller' => 'item_passes', 'action' => 'index', 'item_id' =>  $this->request->data['Item']['id']), array('target' => '_blank', 'title' => __l('List Existing Passes')));?></span>
				<div class="page-info"><?php echo __l("Users can use this pass code at the time of purchase irrespective of types of users. If you leave this field be free or else entered the less passes than the users can possible to purchase then system will automatically generate the passes to compensate the total no of passes users has purchased.<br/>(Passes entered will be updated with existing.)");?></div>
					<?php 
						if(!empty($manual_pass_codes)):
							echo $this->Form->input('old_pass_code', array('type' => 'textarea', 'disabled' => true, 'value' => $manual_pass_codes));
						endif;
					?>
					<?php echo $this->Form->input('pass_code', array('type' => 'textarea', 'info' => __l('Comma seperated for multiple passes. <br />e.g., 000781b0-1, 0004e1b0-6, 00a481b0-8')));?>
		</fieldset>
	</fieldset>
    <div class="submit-block clearfix">
<?php echo $this->Form->submit(__l('Update'),array('name' => 'data[Item][send_to_admin]')); ?>
    
		<?php
			if($item['Item']['item_status_id'] == ConstItemStatus::Draft):
				echo $this->Form->submit(__l('Update Draft'));
			endif;
			?>
			<div class="cancel-block">
			<?php
			echo $this->Html->link(__l('Cancel'), array('controller' => 'items', 'action' => 'index', 'admin' => true), array('class' => 'cancel-button'));

		?>
    </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>