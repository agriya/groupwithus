<?php /* SVN: $Id: $ */ ?>
<div class="userSchools view">
<h2><?php echo __l('User School');?></h2>
	<dl class="list"><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($userSchool['UserSchool']['id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Created');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($userSchool['UserSchool']['created']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Modified');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($userSchool['UserSchool']['modified']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('User');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->link($this->Html->cText($userSchool['User']['username']), array('controller' => 'users', 'action' => 'view', $userSchool['User']['username']), array('escape' => false));?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('User School Degree');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->link($this->Html->cText($userSchool['UserSchoolDegree']['name']), array('controller' => 'user_school_degrees', 'action' => 'view', $userSchool['UserSchoolDegree']['id']), array('escape' => false));?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('College');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($userSchool['UserSchool']['college']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Year');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($userSchool['UserSchool']['year']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Major1');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($userSchool['UserSchool']['major1']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Major2');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($userSchool['UserSchool']['major2']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Major3');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($userSchool['UserSchool']['major3']);?></dd>
	</dl>
</div>