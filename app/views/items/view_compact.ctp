<?php if(!empty($item['Item']['name'])): ?>
<div class="side1 discussion-side1-block">
 <div class="side1-tl">
    <div class="side1-tr">
      <div class="side1-tm"> </div>
    </div>
 </div>
 <div class="side1-cl">
    <div class="side1-cr">
        <div class="block1-inner">
        <div class="clearfix">
           <div class="topic-share-block round-5 clearfix">
        		<span class="topic-share-item"><?php echo __l('Share This Item: '); ?></span>
        		<ul class="share-list">
        			<?php
						$get_current_city = $this->request->params['named']['city'];
						foreach($item['City'] as $item_city) {
							if($item_city['slug'] == $get_current_city) {
								if(Configure::read('site.city_url') == 'prefix'):
									$url = Router::url('/', true) . 'item/' . $item['Item']['slug'] . '/city:' . $get_current_city;
								else:
									$url = 'http://' . $get_current_city . '.' . $domain . 'item/' . $item['Item']['slug'];
								endif;
							}
						}
        			?>
                    <li class="quick"><?php echo $this->Html->link(__l('Quick! Email a friend!'), 'mailto:?body='.__l('Check out the great item on ').Configure::read('site.name').' - '.Router::url('/', true).$this->request->params['named']['city'].'/item/'.$item['Item']['slug'].'&amp;subject='.__l('I think you should get ').Configure::read('site.name').__l(': ').$item['Item']['discount_percentage'].__l('% off at ').$item['Item']['Merchant']['name'], array('target' => 'blank', 'title' => __l('Send a mail to friend about this item'), 'class' => 'quick'));?></li>
        			<li class="twitter-share"><a href="http://twitter.com/share?url=<?php echo $url;?>&amp;text=<?php echo urlencode_rfc3986($item['Item']['name']);?>&amp;lang=en" data-count="none" class="twitter-share-button"><?php echo __l('Tweet!');?></a></li>
        			<li class="share-list share-list1"><fb:like href="<?php echo Router::url('/', true).$this->request->params['named']['city'].'/item/'.$item['Item']['slug'];?>" layout="button_count" font="tahoma"></fb:like></li>
        		</ul>
          </div>
      </div>
    <div class="block1 topic-discussion-block clearfix">
         <div class="topic-discussion1">
            <div class="topic-discussion-tag clearfix">
    			<?php
    				if($this->Html->isAllowed($this->Auth->user('user_type_id')) && $item['Item']['item_status_id'] != ConstItemStatus::Draft ):
    					if($item['Item']['item_status_id'] == ConstItemStatus::Open || $item['Item']['item_status_id'] == ConstItemStatus::Tipped):
    						 echo $this->Html->link(__l('Buy Now'), array('controller'=>'items','action'=>'buy',$item['Item']['id']), array('title' => __l('Buy Now'),'class' =>'button'));
    					else:
    					?>
    						<span class="no-available" title="<?php echo __l('No Longer Available');?>"><?php echo __l('No Longer Available');?></span>
    					<?php
    					endif;
    				endif;
                ?>
		
			<div class="return-item"><?php echo $this->Html->link('<<< '.__l('Return to The Item'), array('controller' => 'items', 'action' => 'view', $item['Item']['slug']), array('title' => __l('Return to The Item')));?></div>
            </div>
    		  <h2 class="topic-discussion-title">
        		<?php if($item['Item']['item_status_id'] == ConstItemStatus::Open || $item['Item']['item_status_id'] == ConstItemStatus::Tipped):?>
        			<span class ="today-item">
        				<?php if($this->request->params['action'] =='index'):?>
        					<?php echo __l("Today's Item").': ';?>
        				<?php endif; ?>
        			</span>
        		<?php endif; ?>
        		<?php
        			echo $this->Html->link($this->Html->cText($item['Item']['name'],false), array('controller' => 'items', 'action' => 'view', $item['Item']['slug']),array('title' =>sprintf(__l('%s'),$this->Html->cText($item['Item']['name'],false))));
        		?>
    		</h2>
		 </div>
	</div>
	<div id="fb-root"></div>
	<script type="text/javascript">
	  window.fbAsyncInit = function() {
		FB.init({appId: '<?php echo Configure::read('facebook.app_id');?>', status: true, cookie: true,
				 xfbml: true});
	  };
	  (function() {
		var e = document.createElement('script'); e.async = true;
		e.src = document.location.protocol +
		  '//connect.facebook.net/en_US/all.js';
		document.getElementById('fb-root').appendChild(e);
	  }());
	</script>
		</div>
        </div>
       	</div>
        <div class="side1-bl">
            <div class="side1-br">
              <div class="side1-bm"> </div>
            </div>
      </div>
</div>
<?php endif; ?>