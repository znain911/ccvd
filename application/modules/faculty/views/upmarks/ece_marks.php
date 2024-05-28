<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="course-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/faculty/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9 myac-container">
					<div class="result-table">
						<div id="ftwofScheduleLoader"><img src="<?php echo base_url('frontend/exam/tools/loader.gif'); ?>" /></div>
						<p class="result-tbl-head"><strong>Applied Students</strong></p>
						<table class="table" style="font-size:12px;">
							<thead>
								<tr>
									<th class="text-left">Student ID</th>
									<th class="text-left">Name</th>
									<th class="text-left">Application ID</th>
									<th class="text-center">Phase Level</th>
									<th class="text-center">Exam Center</th>
									<th class="text-center">Score</th>
									<th class="text-center">Total Score</th>
									<th class="text-center">Activity</th>
									<th class="text-center">Upload Marks</th>
								</tr>
							</thead>
							<tbody id="appliedUsersContent">
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>