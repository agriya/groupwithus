<div class="subscription form">      
        <fieldset>
		<div class="admin-top-inner-block clearfix">
           </div>     
			<div class="page-info">
				<?php echo __l('You can change the background image for the "Two Step Subscription" page.');?><br />
                <?php echo __l('If background image is uploaded, background color will not appear.');?><br />
                <?php echo __l('If height and width is not specified, original image will be set as background image.');?>
			</div>
            <?php
				echo $this->Form->create('Subscription', array('url'=>array('action'=>'admin_subscription_customise'),'class' => 'normal', 'enctype' => 'multipart/form-data')); 
			?>
  			<fieldset class="form-block round-5">
			<legend class="round-5"><?php echo __l('Background Color'); ?></legend>

    
			<?php 
				echo $this->Form->input('default_color', array('type' => 'hidden', 'value' => $this->request->data['Subscription']['bgcolor']));
				echo $this->Form->input('Subscription.bgcolor', array('label' => __l('Background Color'), 'class'=>'js_colorpick', 'style' => 'background:#'.$this->request->data['Subscription']['bgcolor'])); 				
				echo $this->Form->input('Subscription.c_id',array('type' => 'hidden','value' => $background[1]['Setting']['id']));
			?>
            </fieldset>
  			<fieldset class="form-block round-5">
			<legend class="round-5"><?php echo __l('Background Image'); ?></legend>
            <?php	
				echo $this->Form->input('PageLogo.subscription_logo', array('type' => 'file','size' => '33', 'label' => __l('Upload Background Image'), 'class' =>'browse-field'));
				echo $this->Form->input('Subscription.width', array('label' => __l('Background Image Width'), 'class' =>''));
				echo $this->Form->input('Subscription.height', array('label' => __l('Background Image Height'), 'class' =>''));
				echo $this->Form->input('Subscription.is_bg_image_center',array('label' => __l('Background image center?'), 'type'=>'checkbox')); 
				if(!empty($logo['Attachment'])){
				?>
				<div class="bgimg-input-block">
				<?php	echo $this->Form->input('PageLogo.'.$logo['Attachment']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$logo['Attachment']['id'], 'label' => __l('Delete?'), 'class' => ' js-checkbox-list'));
				 ?>
                 
                    <div class="bg-img-subscription">
                    <?php
                        echo $this->Html->showImage('PageLogo', $logo['Attachment'], array('dimension' => 'medium_thumb', 'alt' => $logo['Attachment']['description'] , 'title' => 'Two Step Subscription Background'));
                    ?></div> 
                 </div>
                

                <?php 
				} ?>	
                </fieldset>
                <div class="submit-block clearfix">
                <?php echo $this->Form->submit(__l('Update')); ?>
                    <div class = "cancel-block">
                        <?php  echo  $this->Html->link(__l('Cancel'), array('controller' => 'subscriptions', 'action' => 'index' ), array('title' => 'Cancel'));?>
                     </div>
               </div>
            	<?php echo $this->Form->end(); ?>
        </fieldset>
    </div>
    <br />
    
    <div class="clearfix" style="display:none">
        <img src="<?php echo $large_image_url;?>" />
        <img src="<?php echo $original_thumb_url;?>" />
    </div> 