<?php /* SVN: $Id: add.ctp 54285 2011-05-23 10:16:38Z aravindan_111act10 $ */ ?>
<?php 
  if(!empty($userInterest['UserInterest']['id']))
  {
	  $interest_id=$userInterest['UserInterest']['id'];
  }
  elseif(!empty($this->request->data['UserInterestComment']['user_interest_id']))
  {
	  $interest_id=$this->request->data['UserInterestComment']['user_interest_id'];
  }
 ?>
<div class="userComments form js-ajax-form-container">
    <div class="userComments-add-block js-corner round-5">
        <?php echo $this->Form->create('UserInterestComment', array('class' => "normal comment-form clearfix  js-ajax-form  {container:'js-ajax-form-container',responsecontainer:'js-responses'}"));?>
        	<fieldset>
        	<?php
        		echo $this->Form->input('user_id', array('type' => 'hidden'));
        		echo $this->Form->input('user_interest_id', array('type' => 'hidden','value'=>$interest_id));
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