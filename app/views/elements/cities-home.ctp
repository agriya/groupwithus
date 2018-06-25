<?php
	if(!empty($city_slug)):
		echo $this->requestAction(array('controller' => 'cities', 'action' => 'index'), array('named' => array('admin' => false, 'city' => $city_slug,'type'=>'home'), 'return'));
	else:
		echo $this->requestAction(array('controller' => 'cities', 'action' => 'index'), array('named' => array('admin' => false,'type'=>'home'), 'return'));
	endif;
?>