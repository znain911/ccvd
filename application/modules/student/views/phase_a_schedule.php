<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="course-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h2 class="course-page-title">Booking (Phase-A Examination)</h2>
					<div class="course-content-start">
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="module-lesson-lists">
									<?php 
										$attr = array('id'=>'phaseExamBooking', 'class' => '');
										echo form_open('', $attr);
									?>
									<div class="form-group row">
										<label for="" class="col-lg-4">Exam Phase Level</label>
										<div class="col-lg-8">
											<input type="text" class="form-control" value="Phase A" disabled />
										</div>
									</div>
									<div class="form-group row">
										<label for="" class="col-lg-4">Select Center</label>
										<div class="col-lg-8">
											<select name="center" class="form-control">
												<option value="">Select Center</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<div class="col-lg-12" id="centerDetails"></div>
									</div>
									<div class="form-group row">
										<label for="" class="col-lg-3"></label>
										<div class="col-lg-9 text-right">
											<button type="submit" class="btn btn-raised btn-success" >Booking Now </button>
										</div>
									</div>
									<?php echo form_close(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>