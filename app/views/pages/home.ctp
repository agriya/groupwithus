<div class="pre prev">&nbsp;</div>
<div class="next">&nbsp;</div>
<div class="container_12 main-content">
<div class="main-inner clearfix">
	<div class="clearfix">
		<div class="left-block">
			<div class="img-top"></div>
			<div class="img-middle"> 
			<?php echo $this->Html->image('login-image.jpg',array("width"=>"348","height"=>"325")); ?>
			
				 </div>
			<div class="img-bottom"></div>
		</div>
		<div class="right-block">
			<?php	echo $this->element('users-index', array('cache' => array('config' => 'site_element_cache_20_min'))); ?>
		</div>
	</div>
	<?php
    if(Configure::read('site.is_enable_comment_home') == 1){
    	echo $this->element('user_comments-index', array('type'=>'home','cache' => array('config' => 'site_element_cache_20_min')));
    }?>
</div>
</div>
