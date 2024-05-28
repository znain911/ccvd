<?php 
	$row_info = $this->Images_model->get_info($id);
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
			<label class="col-md-8 control-label">Title</label>
			<div class="col-md-4">
				<input type="text" name="title" class="form-control" placeholder="Enter Notice Title" value="<?php echo $row_info['title']; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Description</label>
			<div class="col-md-4">
				
				<textarea name="description" class="textarea form-control" rows="5" cols="30"><?php echo $row_info['description']; ?></textarea>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label">Notice File</label>
			<div class="col-md-4">
				<?php if($row_info['filename']): ?>
				<div class="old-photo">
					<img src="<?php echo attachment_url('lessons/'.$row_info['filename']); ?>" alt="Photo" />
					
				</div>
				<?php endif; ?>
				<input type="file" name="recent_photo">
			</div>
		</div>
		
		
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Update</button>
			<button class="btn btn-danger m-b-5 retrive-create-again" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>