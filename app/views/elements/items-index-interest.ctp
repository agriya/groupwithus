<?php
echo $this->requestAction(array('controller' => 'items', 'action' => 'index','limit'=>7), array('type' => 'interest','interest_id'=>$interest_id,'city'=>$city,'return'));
?>