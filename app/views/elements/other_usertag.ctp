<?php
echo $this->requestAction(array('controller' => 'user_interests', 'action' => 'index'), array('named' => array('type' => 'other'), 'return'));
?>