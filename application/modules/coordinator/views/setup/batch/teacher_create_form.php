
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
		<!-- <div class="form-group">
			<label class="col-md-8 control-label">Batch Name</label>
			<div class="col-md-4">
				<input type="text" name="batch_name" placeholder="Enter Batch" class="form-control">
			</div>
		</div> -->
		<input type="hidden" name="batch_id" value="<?php echo $batchinfo->batch_id;?>" class="form-control">
		<div class="form-group">
			<label class="col-md-8 control-label">Teacher</label>
			<div class="col-md-4">
				<select name="teacher" id="" class="form-control">

					<option value="">-- Select Teacher --</option>
					<?php foreach ($teacherlist as $tlist) {
						$exists = $this->Batch_model->check_teacher($tlist->teacher_id);			
						if( $exists==0 ){?>

					<option value="<?php echo $tlist->teacher_id;?>"><?php echo $tlist->tpinfo_first_name.' '.$tlist->tpinfo_middle_name.' '.$tlist->tpinfo_last_name;?></option>
					<?php }else{?>
						<option value="<?php echo $tlist->teacher_id;?>" style="color: red;" disabled><?php echo $tlist->tpinfo_first_name.' '.$tlist->tpinfo_middle_name.' '.$tlist->tpinfo_last_name;?></option>
					<?php } }?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Chapter</label>
			<div class="col-md-4">
				<select name="chapter" id="chapter" class="form-control">

					<option value="">-- Select Chapter --</option>
					<?php $chptr = $this->Batch_model->get_chapter();
					foreach ($chptr as $cplist) {?>

					<option value="<?php echo $cplist->phase_id;?>"><?php echo $cplist->phase_name;?></option>
					<?php } ?>
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
<?php if(empty($getteachers)){ ?>
<div class="generate-buttons text-right display-crtbtn">
	<button class="btn btn-purple m-b-5 display-create-frm" type="button">Create New</button>
</div>
<?php } ?>