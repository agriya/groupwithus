<?php /* SVN: $Id: edit.ctp 47854 2011-03-23 11:24:58Z aravindan_111act10 $ */ ?>
<span class="info">Uncheck your branch locations, where you dont want this item to be redeemed.</span>
<div class="clearfix">
<?php 
echo $this->Form->input('MerchantAddressesItem.merchant_address_id',array('label' =>false,'multiple'=>'checkbox', 'checked' => true, 'options' => $branch_addresses));
?>
</div>