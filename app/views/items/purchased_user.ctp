<ol class="user-list">
<?php if($this->request->params['named']['type']=="all_item"){
                                                    $dimension="medium_thumb";
                                                }
                                                else{
                                                    $dimension="micro_thumb";
                                                }

    if($purchasedUsers){
    foreach ($purchasedUsers as $purchasedUser):
    ?>
	<li>
    <?php echo $this->Html->getUserAvatarLink($purchasedUser['User'], $dimension,true);?></li>
	<?php
   endforeach;
   }
   else{
   ?>
   <li>
		<p  class="notice"><?php echo __l('No peoples available'); ?></p>
	</li>
   <?php } ?>
</ol>

 