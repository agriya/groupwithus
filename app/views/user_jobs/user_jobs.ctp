<div>
<?php if(!empty($userJobs)){ ?>
	<ol class="item-user-list">
		<?php foreach($userJobs as $userJob){
        ?>
			<li class = "clearfix ">
				<div class="merchant-list-content">
					<h3><?php echo $userJob['UserJob']['position'];?></h3>
					<dl class="list statistics-list clearfix">
						<dt><?php echo __l('Company Name: ');?></dt>
						<dd><?php echo $userJob['Company']['name'];?></dd>
					</dl>
				</div>
			</li>
		<?php } ?>
	</ol>
<?php } else { ?>
	<p class="notice"><?php echo __l('No Jobs available');?></p>
<?php } ?>
</div>