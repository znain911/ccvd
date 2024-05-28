<?php 
	$row_info = $this->Batch_model->get_batch_info_tchr($id);

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
		<input type="hidden" name="batch_id" value="<?php echo $row_info->batch_id;?>" class="form-control">
		<div class="form-group">
			<label class="col-md-8 control-label">Teacher</label>
			<div class="col-md-4">
				<select name="teacher" id="" class="form-control">

					<option value="">-- Select Teacher --</option>
					<?php foreach ($teacherlist as $tlist) {?>
					<option value="<?php echo $tlist->teacher_id;?>" <?php if($row_info->teacher_id == $tlist->teacher_id){ echo 'selected'; } ?>><?php echo $tlist->tpinfo_first_name.' '.$tlist->tpinfo_middle_name.' '.$tlist->tpinfo_last_name;?></option>
					<?php } ?>
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

					<option value="<?php echo $cplist->phase_id;?>" <?php if($row_info->chapter_id == $cplist->phase_id){ echo 'selected'; } ?>><?php echo $cplist->phase_name;?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-8 control-label">Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" <?php echo ($row_info->bt_status === '1')? 'checked' : null; ?> />&nbsp;&nbsp;Active</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" <?php echo ($row_info->bt_status === '0')? 'checked' : null; ?> />&nbsp;&nbsp;Inactive</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Update</button>
			<button class="btn btn-danger m-b-5 retrive-create-again" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>