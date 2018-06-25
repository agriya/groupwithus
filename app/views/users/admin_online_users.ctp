<div class="main-tl">
				<div class="main-tr">
					<div class="main-tm"> </div>
				</div>
			</div>     		 
                        
                     
               <div class="main-left-shadow">
				<div class="main-right-shadow">
					<div class="main-inner clearfix">
            <h2 class="ribbon-title clearfix"><span class="ribbon-right">
	<span class="ribbon-inner"><?php echo __l('Online Users') . ' (' . $this->Html->cInt(count($onlineUsers), false) . ')'?></span></span></h2>
<?php
	if (!empty($onlineUsers)):
        $users = '';
        $i=0;
        foreach ($onlineUsers as $user):
            $users .= sprintf('%s, ',$this->Html->link($this->Html->cText($user['User']['username'], false), array('controller'=> 'users', 'action' => 'view', $user['User']['username'], 'admin' => false)));
        if($i > 10){
            break;
        }
        $i++;
        endforeach;
        echo substr($users, 0, -2);
    else:
?>
	<p class="notice"><?php echo __l('No users online');?></p>
<?php
	endif;
?>
</div>
                      </div>
               	</div>
				<div class="main-bl">
				<div class="main-br">
					<div class="main-bm"> </div>
				</div>
			</div>