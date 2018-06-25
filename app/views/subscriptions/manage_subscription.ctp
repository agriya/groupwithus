<?php 
echo $this->requestAction(array('controller' => 'subscriptions','action' => 'unsubscribes'), array('return'));
echo $this->requestAction(array('controller' => 'subscriptions','action' => 'subscribes'), array('return'));
?>