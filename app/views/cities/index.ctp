<?php /* SVN: $Id: index.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $  */ ?>
<ul class="city-list clearfix">
	<?php
		if (!empty($cities)):
		$count=count($cities);
			$i = 0;
			$j=0;
			foreach ($cities as $city):
				$class = null;
				if ($i++ % 2 == 0):
					$class = ' class="altrow"';
				endif;
				if($city['City']['slug'] == $city_slug) :
					$select_class = 'active';
				else:
					$select_class = '';
				endif;
				if($j<4){
			?>
				<li class="<?php echo $select_class;?>">
					<?php
						if (Cache::read('site.city_url', 'long') == 'prefix'):
							echo $this->Html->link($city['City']['name'], array('controller' => 'items', 'action' => 'index', 'city' => $city['City']['slug']), array('class' => "$select_class", 'title' => $city['City']['name'], 'escape' => false));
						elseif (Cache::read('site.city_url', 'long') == 'subdomain'):
							$subdomain = substr(env('HTTP_HOST'), 0, strpos(env('HTTP_HOST'), '.'));			
							$sitedomain = substr(env('HTTP_HOST'), strpos(env('HTTP_HOST'), '.'));
							$url = env('HTTP_HOST');
							switch($subdomain):
								case 'www':	
									$url = "http://".$city['City']['slug']. $sitedomain;
									break;
								case 'm':
									$url = "http://m.".$city['City']['slug']. $sitedomain;
									break;
								case Configure::read('site.domain');
										$url = "http://".$city['City']['slug'].'.'. env('HTTP_HOST');
									break;
								default:
									$url = "http://".$city['City']['slug']. $sitedomain;
							endswitch;		
						?>
						<a href="<?php echo $url;?>" title="<?php echo $city['City']['name']; ?>" class="<?php echo $select_class;?>"><?php echo $city['City']['name']; ?></a>
					<?php endif;?>
						<span class="callout"><?php echo $city['City']['active_item_count']; ?></span>
				</li>
				<?php } ?>
				<?php if($j==4){?>
        <li class="other"> <a href="#" class="submenu-link round-top-5" title="Others"><?php echo __l('Others');?></a>
            <ul class="city-more-list round-bottom shadow">
                <?php }
                if($j>=4){  ?>
						<li class="<?php echo $select_class;?>">                        	
					<?php
						if (Cache::read('site.city_url', 'long') == 'prefix'):
						?>
                        	<span class="callout"><?php echo $city['City']['active_item_count'];?></span>	

						<?php echo $this->Html->link($city['City']['name'], array('controller' => 'items', 'action' => 'index', 'city' => $city['City']['slug']), array('class' => "$select_class", 'title' => $city['City']['name'], 'escape' => false));
						elseif (Cache::read('site.city_url', 'long') == 'subdomain'):
							$subdomain = substr(env('HTTP_HOST'), 0, strpos(env('HTTP_HOST'), '.'));
							$sitedomain = substr(env('HTTP_HOST'), strpos(env('HTTP_HOST'), '.'));
							$url = env('HTTP_HOST');
							switch($subdomain):
								case 'www':
									$url = "http://".$city['City']['slug']. $sitedomain;
									break;
								case 'm':
									$url = "http://m.".$city['City']['slug']. $sitedomain;
									break;
								case Configure::read('site.domain');
										$url = "http://".$city['City']['slug'].'.'. env('HTTP_HOST');
									break;
								default:
									$url = "http://".$city['City']['slug']. $sitedomain;
							endswitch;
						?>
                    
						<a href="<?php echo $url;?>" title="<?php echo $city['City']['name']; ?>" class="<?php echo $select_class;?>"><?php echo $city['City']['name']; ?></a>
					
					<?php endif;?>
				
				</li>
                <?php if($i==$count){ ?>
                    </ul>
                    </li>
                <? }}?>

		<?php
		$j++;
		endforeach;
	endif;?>
</ul>
