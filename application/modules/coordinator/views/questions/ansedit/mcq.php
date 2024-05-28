<div id="answerDistributeEdit">
<?php 
	$get_answers = $this->Questions_model->get_answersby_question($row_info['question_id']);
	$ans_count = 1;
	foreach($get_answers as $answer):
?>
<?php 
	if($ans_count > 4): 
	$remve = '<span data-answer="'.$ans_count.'" class="rmv-row-mrksinp fa fa-times" style="position:absolute;right:-10px;top:0;"></span>';
	else:
	$remve = null;
	endif;
?>
	<div class="form-group">
		<label class="col-md-8 control-label"><strong>Stamp-<?php echo $ans_count; ?> :</strong></label>
		<div class="col-md-4">
			<textarea name="answer_<?php echo $ans_count; ?>" class="form-control" rows="3"><?php echo $answer['answer_title']; ?></textarea>
			<input type="hidden" name="answer_row[]" value="<?php echo $ans_count; ?>" />
			<span class="check-length-edit"></span>
			<?php echo $remve; ?>
		</div>
	</div>
<?php 
	$ans_count++;
	endforeach; 
?>
</div>
<?php
	$str = str_replace('[', '', $row_info['question_right_answerid']);
	$str = str_replace(']', '', $str);
	$str_array = explode(',', $str);
?>

<div class="add-more-answers" style="margin:30px 0 80px">
	<div class="col-lg-offset-8 col-lg-4 text-center">
		<span class="more-ans-edit" style="cursor:pointer;background: rgb(18, 16, 20) none repeat scroll 0% 0%; color: rgb(255, 255, 255); padding: 4px 9px; border-radius: 4px;"><span class="add-more-answer fa fa-plus-square"></span> Add More Answer</span>
		<input type="hidden" id="totalEditRow" value="<?php echo count($get_answers)+1; ?>" />
	</div>
</div>

<div class="form-group">
	<label class="col-md-8 control-label"><strong>True</strong></label>
	<div class="col-md-4" id="rightAnswerDistributeEdit">
		<?php 
		$ans_right_count = 1;
		foreach($get_answers as $answer): ?>
		<label style="display:block" class="right-asnwer-<?php echo $ans_right_count; ?>"><input type="checkbox" name="right_answer_<?php echo $ans_right_count; ?>" value="<?php echo $ans_right_count; ?>" <?php echo (in_array($answer['answer_id'], $str_array))? 'checked' : null; ?> /> &nbsp;&nbsp;<strong>Stamp-<?php echo $ans_right_count; ?></strong></label>
		<?php
			$ans_right_count++;
			endforeach; 
		?>
	</div>
</div>