<?php
	echo $this->requestAction(array('controller' => 'users', 'action' => 'index'), array('named' => array('admin' => false, 'city' => $city_slug), 'return'));
?>