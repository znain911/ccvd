<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="course-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/faculty/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9">
					<div class="all-available-schedules myac-container">
						<div class="row">
							<div class="col-lg-4">
								<div class="card card-primary-inverse">
									<div class="card-header">
									  <h3 class="card-title">SDT Schedules</h3>
									</div>
									<div class="card-body">
									  <p>See all available schedules to join at SDT</p>
									  <a class="btn btn-raised btn-info" href="<?php echo base_url('faculty/schedules/sdt'); ?>">
											<i class="fa fa-eye"></i> View Schedules<div class="ripple-container"></div>
									  </a>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="card card-primary-inverse">
									<div class="card-header">
									  <h3 class="card-title">Workshop Schedules</h3>
									</div>
									<div class="card-body">
									  <p>See all available schedules to join at Workshop</p>
									  <a class="btn btn-raised btn-info" href="<?php echo base_url('faculty/schedules/workshop'); ?>">
											<i class="fa fa-eye"></i> View Schedules<div class="ripple-container"></div>
									  </a>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="card card-primary-inverse">
									<div class="card-header">
									  <h3 class="card-title">ECE Examination Schedules</h3>
									</div>
									<div class="card-body">
									  <p>See all available schedules to join at ECE Examination</p>
									  <a class="btn btn-raised btn-info" href="<?php echo base_url('faculty/schedules/ece'); ?>">
											<i class="fa fa-eye"></i> View Schedules<div class="ripple-container"></div>
									  </a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>