<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="course-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/faculty/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9">
					<div class="f2f-booking-form myac-container">
						<div class="endmodule-exm-title">Write Evaluation Report</div>
							<?php 
								$attr = array('id' => 'evaluationSubmissionFaculty');
								echo form_open('', $attr);
							?>
							<div id="scheduleLoader"><img src="<?php echo base_url('frontend/exam/tools/loader.gif'); ?>" /></div>
							<div class="form-group row">
								<div class="col-lg-12"><div id="alert"></div></div>
							</div>
							<div class="form-group row">
								<label for="" class="col-lg-3 text-right">Select Student</label>
								<div class="col-lg-6">
									<input type="text" name="student" class="form-control src-students" placeholder="Search Student" />
									<input type="hidden" name="student_id" id="hiddenStudent" />
								</div>
							</div>
							<div class="form-group row">
								<label for="" class="col-lg-3 text-right">Title</label>
								<div class="col-lg-6">
									<input type="text" name="title" class="form-control" placeholder="Enter evaluation title" />
								</div>
							</div>
							<div class="form-group row">
								<label for="" class="col-lg-3 text-right">Description</label>
								<div class="col-lg-9">
									<textarea name="description" style="border:1px solid #ddd;width:100%;padding:7px;" cols="30" rows="10"></textarea>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-lg-12">
									<?php 
										$ratings = $this->Evaluation_model->get_ratings();
										$evl_row = 1;
										foreach($ratings as $rating):
									?>
									<table class="table table-bordered">
										<thead>
											<tr>
												<th style="width:22%">&nbsp;</th>
												<th style="width:15%" class="text-center"><?php echo $rating['eval_rating_type_one']; ?></th>
												<th style="width:15%" class="text-center"><?php echo $rating['eval_rating_type_two']; ?></th>
												<th style="width:18%" class="text-center"><?php echo $rating['eval_rating_type_three']; ?></th>
												<th style="width:15%" class="text-center"><?php echo $rating['eval_rating_type_four']; ?></th>
												<th style="width:15%" class="text-center"><?php echo $rating['eval_rating_type_five']; ?></th>
											</tr>
											<tr>
												<th><?php echo $rating['eval_label']; ?></th>
												<th><label class="rating-radio"><input type="radio" name="rating_type_colunm_<?php echo $evl_row; ?>" value="eval_rating_type_one" /></label></th>
												<th><label class="rating-radio"><input type="radio" name="rating_type_colunm_<?php echo $evl_row; ?>" value="eval_rating_type_two" /></label></th>
												<th><label class="rating-radio"><input type="radio" name="rating_type_colunm_<?php echo $evl_row; ?>" value="eval_rating_type_three" /></label></th>
												<th><label class="rating-radio"><input type="radio" name="rating_type_colunm_<?php echo $evl_row; ?>" value="eval_rating_type_four" /></label></th>
												<th><label class="rating-radio"><input type="radio" name="rating_type_colunm_<?php echo $evl_row; ?>" value="eval_rating_type_five" /></label></th>
											</tr>
										</thead>
										<input type="hidden" name="rating_type_eval_rating_type_one_<?php echo $evl_row; ?>" value="<?php echo $rating['eval_rating_type_one']; ?>" />
										<input type="hidden" name="rating_type_eval_rating_type_two_<?php echo $evl_row; ?>" value="<?php echo $rating['eval_rating_type_two']; ?>" />
										<input type="hidden" name="rating_type_eval_rating_type_three_<?php echo $evl_row; ?>" value="<?php echo $rating['eval_rating_type_three']; ?>" />
										<input type="hidden" name="rating_type_eval_rating_type_four_<?php echo $evl_row; ?>" value="<?php echo $rating['eval_rating_type_four']; ?>" />
										<input type="hidden" name="rating_type_eval_rating_type_five_<?php echo $evl_row; ?>" value="<?php echo $rating['eval_rating_type_five']; ?>" />
										
										<input type="hidden" name="rating_eval_rating_type_one_<?php echo $evl_row; ?>" value="<?php echo $rating['eval_rating_one']; ?>" />
										<input type="hidden" name="rating_eval_rating_type_two_<?php echo $evl_row; ?>" value="<?php echo $rating['eval_rating_two']; ?>" />
										<input type="hidden" name="rating_eval_rating_type_three_<?php echo $evl_row; ?>" value="<?php echo $rating['eval_rating_three']; ?>" />
										<input type="hidden" name="rating_eval_rating_type_four_<?php echo $evl_row; ?>" value="<?php echo $rating['eval_rating_four']; ?>" />
										<input type="hidden" name="rating_eval_rating_type_five_<?php echo $evl_row; ?>" value="<?php echo $rating['eval_rating_five']; ?>" />
										
										<input type="hidden" name="eval_id_<?php echo $evl_row; ?>" value="<?php echo $rating['eval_id']; ?>" />
										<input type="hidden" name="eval_label_<?php echo $evl_row; ?>" value="<?php echo $rating['eval_label']; ?>" />
									</table>
									<input type="hidden" name="rating_rows[]" value="<?php echo $evl_row; ?>" />
									<?php 
										$evl_row++;
										endforeach; 
									?>
								</div>
							</div>
							<div class="form-group row">
								<label for="" class="col-lg-3 text-right"></label>
								<div class="col-lg-9 text-right">
									<button type="submit" class="btn btn-raised btn-success" >Submit Evaluation </button>
								</div>
							</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.src-students').autocomplete({
			  source: function( request, response ) {
				$.ajax({
				  type: "GET",
				  url: baseUrl + "faculty/evaluation/get_students",
				  dataType: "json",
				  data: {
					q: request.term
				  },
				  success: function( data ) {
					response( data.content);
				  }
				});
			  },
			  select: function (event, ui) {
						$(this).val(ui.item.label); // display the selected text
						$('#hiddenStudent').val(ui.item.value);
						//console.log(ui.item.label);
						//console.log(ui.item.value);
						//$("#txtAllowSearchID").val(ui.item.value); // save selected id to hidden input
						return false;
			  },
			  minLength: 1,
			  open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			  },
			  close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			  }
			});
		});
	</script>
<?php require_once APPPATH.'modules/common/footer.php'; ?>