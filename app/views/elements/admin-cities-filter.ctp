<div class="js-auto-submit-over-block grid_10 language-block grid_right">
<?php
		$cities = $this->Html->getCity();
		$selected_city = $this->Session->read('city_filter_id');
		if(!empty($cities)) :
			echo $this->Form->create('City', array('url' => array('action' => 'change_city'), 'class' => 'language-form'));
			echo $this->Form->input('city_id', array('label' => __l('City'),'empty' => __l('All'), 'class' => 'js-autosubmit', 'options' => $cities,'value' => $selected_city));
			echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url));
			?>
			<span class="small-info" title='<?php echo __l('Selecting the city will filter the following items: Admin stat - items and total commission amount earned, Items, Item Passes, Subscriptions.');?>'>
				<?php echo __l('Selecting the city will filter the following items: Admin stat - items and total commission amount earned, Items, Item Passes, Subscriptions.');?>
			</span>
			<div class="hide">
				<?php echo $this->Form->submit('Submit');  ?>
			</div>
			<?php
			echo $this->Form->end();
		endif;
?>
</div>