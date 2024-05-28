<div class="form-cntnt" style="display:none">
	<h2 class="frm-title-ms">Create New</h2>
	<?php 
		$attr = array('class' => 'form-horizontal', 'id' => 'createData');
		echo form_open('#', $attr);
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
					<option value="">Select Exam</option>
					<option value="1">CCA-1</option>
					<option value="2">CCA-2</option>
					<option value="3">CCA-3</option>
					<option value="4">ECE</option>				
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
					<option value="<?php echo $btcs['batch_name'];?>"><?php echo $btcs['batch_name'];?></option>
					<?php }?>				
				</select>
			</div>
		</div>
				
		<div class="form-group">
			<label class="col-md-8 control-label">Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" checked />&nbsp;&nbsp;Active</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" />&nbsp;&nbsp;Inactive</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Create</button>
			<button class="btn btn-danger m-b-5 btn-remove-form" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>
<div class="generate-buttons text-right display-crtbtn">
	<button class="btn btn-purple m-b-5 display-create-frm" type="button">Create New</button>
</div>