<?php
	 $url= Router::url(array('controller'=>'items','action'=>'widget', 'user'=>$this->request->params['named']['user'], 'city_name'=>$this->request->params['named']['city'], 'size' => $this->request->params['named']['size'], 'color' => $this->request->params['named']['color']), true);
?>
document.write('<iframe src="<?php echo $url;?>" width="<?php echo $affiliateWidgetSize['AffiliateWidgetSize']['width']; ?>" scrolling="no" height="<?php echo $affiliateWidgetSize['AffiliateWidgetSize']['height']; ?>" class="widget-iframe widget-iframe-<?php echo $affiliateWidgetSize['AffiliateWidgetSize']['id']; ?>" style="border:none; margin:0 auto; width:100%;" /></iframe>');