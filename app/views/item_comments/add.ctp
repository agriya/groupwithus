<?php /* SVN: $Id: add.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
<div class="ItemComments form js-ajax-form-container">
    <div class="ItemComments-add-block js-corner round-5">
        <?php echo $this->Form->create('ItemComment', array('class' => "normal comment-form clearfix js-comment-form {container:'js-ajax-form-container',responsecontainer:'js-responses'}"));?>
        	<fieldset>
        	<?php
        		//echo $this->Form->input('item_id', array('type' => 'hidden'));
                echo $this->Form->input('item_id', array('type' => 'hidden','value'=>!empty($this->params['named']['item_id']) ? $this->params['named']['item_id'] : $this->request->data['item']['id']));
        		echo $this->Form->input('comment', array('type' => 'textarea','label' => __l('Comment')));
        	?>
        	</fieldset>
<div class="submit-block clearfix">
<?php
	echo $this->Form->submit(__l('Add'));
?>
</div>
<?php
	echo $this->Form->end();
?>
    </div>
</div>