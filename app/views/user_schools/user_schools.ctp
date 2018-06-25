<div>
<?php if(!empty($userSchools)){ ?>
	<ol class="item-user-list">
		<?php foreach($userSchools as $userSchool){ ?>
			<li class = "clearfix ">
				<div class="merchant-list-content">
					<h3><?php echo $userSchool['UserSchoolDegree']['name'];?></h3>
					<dl class="list statistics-list">
						<dt><?php echo __l('College: ');?></dt>
						<dd><?php echo $userSchool['UserSchool']['college'];?></dd>
					</dl>
					<dl class="list statistics-list">
						<dt><?php echo __l('Year: ');?></dt>
						<dd><?php echo $userSchool['UserSchool']['year'];?></dd>
					</dl>
					<dl class="list statistics-list">
						<dt><?php echo __l('Major1: ');?></dt>
						<dd><?php echo $userSchool['UserSchool']['major1'];?></dd>
					</dl>
					<dl class="list statistics-list">
						<dt><?php echo __l('Major2: ');?></dt>
						<dd><?php echo $userSchool['UserSchool']['major2'];?></dd>
					</dl>
					<dl class="list statistics-list">
						<dt><?php echo __l('Major3: ');?></dt>
						<dd><?php echo $userSchool['UserSchool']['major3'];?></dd>
					</dl>
				</div>
			</li>
		<?php } ?>
	</ol>
<?php } else { ?>
	<p class="notice"><?php echo __l('No Schools available');?></p>
<?php } ?>
</div>