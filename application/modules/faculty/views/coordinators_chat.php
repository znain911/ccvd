<ul class="cnv-lists-step-ul">
<?php 
	
	$get_messages = $this->Discussion_model->get_chathistory($chat_id);
	
	foreach($get_messages as $message):
	if($message['ctof_user_type'] === 'Faculty')
	{
		$class_style = 'sent-by-me text-right';
		$class_img_style = 'cnv-usr-me-photo';
	}else
	{
		$class_style = 'sent-by-user text-left';
		$class_img_style = 'cnv-usr-by-photo';
	}
?>

<li class="cnv-lists-step-li <?php echo $class_style; ?>">
	<div class="cnv-txt">
		<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="<?php echo $class_img_style; ?>" />
		<span><?php echo $message['ctof_messages']; ?></span>
		<span class="chtdate">
			<?php
				$time = strtotime($message['ctof_date']);
				$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
				echo $myFormatForView;
			?>
		</span>
	</div>
</li>
<?php endforeach; ?>
</ul>
<input type="hidden" id="selChatHist" name="selected_chat" value="<?php echo $chat_id; ?>" />