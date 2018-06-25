<?php
$view = '';
if(!empty($view_type)):
	$view = $view_type;
endif;
echo $this->requestAction(array('controller' => 'item_users', 'action' => 'index',$item_id), array('named' => array('limit'=>$limit,'admin' => false, 'item_id' => $item_id,'item_type'=>$type,'merchant_id'=>$merchant_id),'return'));
?>