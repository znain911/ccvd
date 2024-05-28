<div id="answerDistribute">
	<div class="form-group">
		<label class="col-md-8 control-label"><strong>Stamp-1 :</strong></label>
		<div class="col-md-4">
			<textarea name="answer_1" class="form-control" rows="3"></textarea>
			<input type="hidden" name="answer_row[]" value="1" />
			<span class="check-length"></span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-8 control-label"><strong>Stamp-2 :</strong></label>
		<div class="col-md-4">
			<textarea name="answer_2" class="form-control" rows="3"></textarea>
			<input type="hidden" name="answer_row[]" value="2" />
			<span class="check-length"></span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-8 control-label"><strong>Stamp-3 :</strong></label>
		<div class="col-md-4">
			<textarea name="answer_3" class="form-control" rows="3"></textarea>
			<input type="hidden" name="answer_row[]" value="3" />
			<span class="check-length"></span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-8 control-label"><strong>Stamp-4 :</strong></label>
		<div class="col-md-4">
			<textarea name="answer_4" class="form-control" rows="3"></textarea>
			<input type="hidden" name="answer_row[]" value="4" />
			<span class="check-length"></span>
		</div>
	</div>
</div>
<div class="add-more-answers" style="margin:30px 0 80px">
	<div class="col-lg-offset-8 col-lg-4 text-center">
		<span class="more-ans-add-blanks" style="cursor:pointer;background: rgb(18, 16, 20) none repeat scroll 0% 0%; color: rgb(255, 255, 255); padding: 4px 9px; border-radius: 4px;"><span class="add-more-answer fa fa-plus-square"></span> Add More Answer</span>
	</div>
</div>
<?php 
	$gaps = array(
				'0' => 'a',
				'1' => 'b',
				'2' => 'c',
				'3' => 'd',
				'4' => 'e',
				'5' => 'f',
				'6' => 'g',
				'7' => 'h',
				'8' => 'i',
				'9' => 'j',
			);
?>
<div class="form-group">
	<label class="col-md-8 control-label"><strong>True</strong></label>
	<div class="col-md-4" id="rightAnswerDistribute">
		<label style="display:block">
			<input type="checkbox" name="right_answer_1" value="1" /> &nbsp;&nbsp;<strong class="ans-margin">Stamp-1</strong> &nbsp;&nbsp;
			<select class="custom-sel-style" name="right_answer_gapid_1">
				<option value="" selected="selected">Select Blank</option>
				<?php foreach($gaps as $key => $gap): ?>
				<option value="<?php echo $key; ?>"><?php echo $gap; ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label style="display:block">
			<input type="checkbox" name="right_answer_2" value="2" /> &nbsp;&nbsp;<strong class="ans-margin">Stamp-2</strong> &nbsp;&nbsp;
			<select class="custom-sel-style" name="right_answer_gapid_2">
				<option value="" selected="selected">Select Blank</option>
				<?php foreach($gaps as $key => $gap): ?>
				<option value="<?php echo $key; ?>"><?php echo $gap; ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label style="display:block">
			<input type="checkbox" name="right_answer_3" value="3" /> &nbsp;&nbsp;<strong class="ans-margin">Stamp-3</strong> &nbsp;&nbsp;
			<select class="custom-sel-style" name="right_answer_gapid_3">
				<option value="" selected="selected">Select Blank</option>
				<?php foreach($gaps as $key => $gap): ?>
				<option value="<?php echo $key; ?>"><?php echo $gap; ?></option>
				<?php endforeach; ?>
			</select>
		</label> 
		<label style="display:block">
			<input type="checkbox" name="right_answer_4" value="4" /> &nbsp;&nbsp;<strong class="ans-margin">Stamp-4</strong> &nbsp;&nbsp;
			<select class="custom-sel-style" name="right_answer_gapid_4">
				<option value="" selected="selected">Select Blank</option>
				<?php foreach($gaps as $key => $gap): ?>
				<option value="<?php echo $key; ?>"><?php echo $gap; ?></option>
				<?php endforeach; ?>
			</select>
		</label>
	</div>
</div>