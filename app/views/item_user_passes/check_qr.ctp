    <h2>Pass</h2>
    
    <?php 
       $expire = strtotime($ItemUserPass['ItemUser']['Item']['event_date']);
       $today = strtotime(date('Y-m-d H:i:s'));
       if($today>$expire): ?>
  
       <h3 class="pass-expired">This pass has been expired</h3>
  
    <?php endif; ?>
    <?php if(!empty($ItemUserPass['ItemUserPass']['is_used'])): ?>
        <h3 class="pass-used">This pass has been used</h3>
    <?php endif; ?>
   <div class="clearfix">
	  <table width='100%' cellpadding="5" cellspacing="3" border="0" class="list pass-expired">
           <tr>
            <th ><?php echo __l('Item:'); ?></th>
            <td ><?php echo $this->Html->cText($ItemUserPass['ItemUser']['Item']['name'],false);?></td>
          </tr>
		  <tr>
            <th ><?php echo __l('Pass code:'); ?></th>
            <td ><?php echo $this->Html->cText($ItemUserPass['ItemUserPass']['pass_code']);?></td>
          </tr>		  
          <tr>
            <th ><?php echo __l('Recipient:'); ?></th>
            <td ><?php echo $this->Html->cText($ItemUserPass['ItemUser']['User']['username']);?></td>
          </tr>
          <tr>
            <th ><?php echo __l('Purchased:'); ?></th>
            <td ><?php echo $this->Html->cDateTime($ItemUserPass['ItemUser']['created']);?></td>
          </tr>
          <tr>
            <th ><?php echo __l('Event Date:'); ?></th>
            <td ><?php echo $this->Html->cDateTime($ItemUserPass['ItemUser']['Item']['event_date']);?></td>
          </tr>
          <?php if(!empty($ItemUserPass['ItemUserPass']['is_used'])): ?>
          <tr>
            <th ><?php echo __l('Used on:')?></th>
            <td ><?php echo $this->Html->cDateTime($ItemUserPass['ItemUserPass']['modified']);?></td>
          </tr>
          <?php endif; ?>		 
        </table>
    
		<div class="pass-expired-left">
	      <?php
		      $barcode_width = Configure::read('barcode.width');
			  $barcode_height = Configure::read('barcode.height');
              $parsed_url = parse_url($this->Html->url('/', true));
              $qr_mobile_site_url = str_ireplace($parsed_url['host'], 'm.' . $parsed_url['host'], Router::url(array(
								'controller' => 'item_user_passes',
								'action' => 'check_qr',
								$ItemUserPass['ItemUserPass']['pass_code'],
								$ItemUserPass['ItemUserPass']['unique_pass_code'],
								'admin' => false
							) , true));
                            
		  ?>
		  <img src="http://chart.apis.google.com/chart?cht=qr&chs=<?php echo $barcode_width; ?>x<?php echo $barcode_height; ?>&chl=<?php echo $qr_mobile_site_url ?>" alt = "[Image: item qr code]"/>
		<p>
		  <?php echo $ItemUserPass['ItemUserPass']['unique_pass_code'] ?>
		  </p>
		  </div>
		  </div>
	<div class="clearfix">
	   <?php
	      if(empty($ItemUserPass['ItemUserPass']['is_used'])):
			   echo $this->Form->create('ItemUserPass', array('controller'=>'item_user_passes', 'action'=> 'check_qr', 'class' => 'normal clearfix'));
			   echo $this->Form->input('pass_code', array('type'=>'hidden'));
			   echo $this->Form->input('unique_pass_code', array('type'=>'hidden'));
			   echo $this->Form->submit(__l('Mark as Used'));
			   echo $this->Form->end();            
		  endif;
	   ?>
</div>