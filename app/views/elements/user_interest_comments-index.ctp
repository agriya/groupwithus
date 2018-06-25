<?php
	echo $this->requestAction(array('controller' => 'user_interest_comments', 'action' => 'index'), array('id'=>$interest), 'return');
?>