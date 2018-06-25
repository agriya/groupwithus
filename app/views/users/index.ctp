<div class="carousel main ">
            <div class="pre prev"><a href="#" class="prev">&nbsp;</a></div>
            <div class="js-jcarousellite">
                <ul class="slid-list">
<?php 
foreach($users as $user){
?>
<li>
<h2> <?php echo $this->Html->cText( $user['User']['username']); ?></h2>
								<p><?php echo $this->Html->cText($user['UserProfile']['about_me']); ?></p>
								<div class="login-page-banner"> 
        <?php echo $this->Html->showImage('UserAvatar', $user['UserAvatar'], array('dimension' => 'home_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($user['User']['username'], false)), 'title' => $this->Html->cText($user['User']['username'], false)));?>
								
								</div>
								<div class="banner-bottom">
									<?php if(!empty($user['UserJob'])): ?>
										<?php if(!empty($user['UserJob'][0]['Company']['name'])){echo $this->Html->cText($user['UserJob'][0]['Company']['name']); } ?>
										<p><?php echo $this->Html->cText($user['UserJob'][0]['position']); ?></p>
									<?php else: ?>
										<?php 
										if(!empty($user['UserSchool'])): 
											echo $this->Html->cText($user['UserSchool'][0]['College']['name']); ?>
											<p><?php echo $this->Html->cText($user['UserSchool'][0]['UserSchoolDegree']['name']); ?>, <?php echo $this->Html->cText($user['UserSchool'][0]['year']); ?></p>
										<?php endif; ?>
										<?php endif; ?>
										
								
								<div class="next"><a href="#" class="next">&nbsp;</a></div>
								</div>
</li>
<?php
		
}
?>
		</ul>
	</div>
	 <div class="next"><a href="#" class="next">&nbsp;</a></div>
	<div class="clear"></div>   
</div>     
