<?php 
	$row_info = $this->Exambutton_model->get_info($id);
?>
<div class="form-cntnt form-number-<?php echo $id; ?>">
	<h2 class="frm-title-ms">Edit</h2>
	<?php 
		$attr = array('class' => 'form-horizontal', 'id' => 'updateData');
		$hidden = array('id' => $id);
		echo form_open('#', $attr, $hidden);
	?>
		<div id="loader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
		<div class="form-group">
			<div class="col-md-offset-6 col-md-6">
				<div id="alert"></div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label">Exam</label>
			<div class="col-md-4">
				<select name="etype" class="form-control" name="etype">
					<option value="1" <?php if ($row_info['exam_type'] == 1) { echo 'selected'; }?> >CCA-1</option>
					<option value="2" <?php if ($row_info['exam_type'] == 2) { echo 'selected'; }?> >CCA-2</option>
					<option value="3" <?php if ($row_info['exam_type'] == 3) { echo 'selected'; }?> >CCA-3</option>
					<option value="4" <?php if ($row_info['exam_type'] == 4) { echo 'selected'; }?> >ECE</option>				
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Batch</label>
			<div class="col-md-4">
				<select name="batch" class="form-control" id="batch">
					<option value="">Select Batch</option>
					<?php $get_btc = $this->Exambutton_model->get_all_batch();
						foreach($get_btc as $btcs){
					?>
					<option value="<?php echo $btcs['batch_name'];?>" <?php if ($row_info['batch'] == $btcs['batch_name']) { echo 'selected'; }?>><?php echo $btcs['batch_name'];?></option>
					<?php }?>				
				</select>
			</div>
		</div>
		
		
		
		<div class="form-group">
			<label class="col-md-8 control-label">Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" <?php echo ($row_info['btn_status'] === '1')? 'checked' : null; ?> />&nbsp;&nbsp;Active</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" <?php echo ($row_info['btn_status'] === '0')? 'checked' : null; ?> />&nbsp;&nbsp;Inactive</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Update</button>
			<button class="btn btn-danger m-b-5 retrive-create-again" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>