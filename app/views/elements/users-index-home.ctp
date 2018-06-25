<?php
	echo $this->requestAction(array('controller' => 'users', 'action' => 'index'), array('type'=>'home','limit' => 8, 'return'));
?>