<?php /* SVN: $Id: index.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $  */ ?>
<ul class="clearfix">
	<?php
		if (!empty($city_slug)):
	?>
				<li>
					<?php
						if (Cache::read('site.city_url', 'long') == 'prefix'):
							echo $this->Html->link($city_name, array('controller' => 'items', 'action' => 'index', 'city' => $city_slug), array( 'title' => $city_name, 'escape' => false));
						elseif (Cache::read('site.city_url', 'long') == 'subdomain'):
							$subdomain = substr(env('HTTP_HOST'), 0, strpos(env('HTTP_HOST'), '.'));			
							$sitedomain = substr(env('HTTP_HOST'), strpos(env('HTTP_HOST'), '.'));
							$url = env('HTTP_HOST');
							switch($subdomain):
								case 'www':	
									$url = "http://".$city_slug. $sitedomain;
									break;
								case 'm':
									$url = "http://m.".$city_slug. $sitedomain;
									break;
								case Configure::read('site.domain');
										$url = "http://".$city_slug.'.'. env('HTTP_HOST');
									break;
								default:
									$url = "http://".$city_slug. $sitedomain;
							endswitch;		
						?>
						<a href="<?php echo $url;?>" title="<?php echo $city_name; ?>" ><?php echo $city_name; ?></a>
					<?php endif;?>
				</li>

		<?php
	endif;?>
	<?php
		if (!empty($cities)):
			foreach ($cities as $city):
				if($city['City']['slug'] != $city_slug):
			?>
				<li>
					<?php
						if (Cache::read('site.city_url', 'long') == 'prefix'):
							echo $this->Html->link($city['City']['name'], array('controller' => 'items', 'action' => 'index', 'city' => $city['City']['slug']), array( 'title' => $city['City']['name'], 'escape' => false));
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
						<a href="<?php echo $url;?>" title="<?php echo $city['City']['name']; ?>" ><?php echo $city['City']['name']; ?></a>
					<?php endif;?>
				</li>

		<?php
			endif;
		endforeach;
	endif;?>
</ul>
