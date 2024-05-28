<div id="answerDistribute">
	<div class="form-group">
		<label class="col-md-8 control-label"></label>
		<div class="col-md-4">
			<label><input type="radio" name="justify_answer" value="TRUE" <?php echo ($row_info['question_justify_answer'] == 'TRUE')? 'checked' : null; ?> /><strong style="margin-left:10px">TRUE</strong></label>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-8 control-label"></label>
		<div class="col-md-4">
			<label><input type="radio" name="justify_answer" value="FALSE" <?php echo ($row_info['question_justify_answer'] == 'FALSE')? 'checked' : null; ?> /><strong style="margin-left:10px">FALSE</strong></label>
		</div>
	</div>
</div>