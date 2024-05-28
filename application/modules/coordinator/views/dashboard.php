<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Dashboard</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Dashboard</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- begin col-4 -->
				<div class="col-md-3">
					<!-- begin widget -->
					<div class="widget widget-stat text-white bg-purple">
						<div class="widget-stat-btn"><a href="#" data-click="widget-reload"><i class="fa fa-repeat"></i></a></div>
						<div class="widget-stat-content">
							<div class="widget-stat-title">Current Pending Students</div>
							<div class="widget-stat-number m-b-10"><?php echo $this->Dashboard_model->pending_students(); ?></div>
							<div class="widget-stat-chart">
								<div id="flot-visitor-chart" data-height="105px" style="margin: 0 -10px -10px"></div>
							</div>
						</div>
					</div>
					<!-- end widget -->
				</div>
				<!-- end col-4 -->
				
				<div class="col-lg-3">
					<!-- begin widget -->
					<div class="widget widget-stat text-white bg-purple">
						<div class="widget-stat-btn"><a href="#" data-click="widget-reload"><i class="fa fa-repeat"></i></a></div>
						<div class="widget-stat-content">
							<div class="widget-stat-title">Current Enrolled Students</div>
							<div class="widget-stat-number m-b-10"><?php echo $this->Dashboard_model->enrolled_students(); ?></div>
							<div class="widget-stat-chart">
								<div id="flot-visitor-chart" data-height="105px" style="margin: 0 -10px -10px"></div>
							</div>
						</div>
					</div>
					<!-- end widget -->
				</div>
				
				<!-- begin col-4 -->
				<div class="col-md-3">
					<!-- begin widget -->
					<div class="widget widget-stat text-white bg-purple">
						<div class="widget-stat-btn"><a href="#" data-click="widget-reload"><i class="fa fa-repeat"></i></a></div>
						<div class="widget-stat-content">
							<div class="widget-stat-title">Current Pending Faculties</div>
							<div class="widget-stat-number m-b-10"><?php echo $this->Dashboard_model->pending_faculties(); ?></div>
							<div class="widget-stat-chart">
								<div id="flot-visitor-chart" data-height="105px" style="margin: 0 -10px -10px"></div>
							</div>
						</div>
					</div>
					<!-- end widget -->
				</div>
				<!-- end col-4 -->
				
				<div class="col-lg-3">
					<!-- begin widget -->
					<div class="widget widget-stat text-white bg-purple">
						<div class="widget-stat-btn"><a href="#" data-click="widget-reload"><i class="fa fa-repeat"></i></a></div>
						<div class="widget-stat-content">
							<div class="widget-stat-title">Current Enrolled Faculties</div>
							<div class="widget-stat-number m-b-10"><?php echo $this->Dashboard_model->enrolled_faculties(); ?></div>
							<div class="widget-stat-chart">
								<div id="flot-visitor-chart" data-height="105px" style="margin: 0 -10px -10px"></div>
							</div>
						</div>
					</div>
					<!-- end widget -->
				</div>
				
				<!-- begin col-4 -->
				<div class="col-md-3">
					<!-- begin widget -->
					<div class="widget widget-stat text-white bg-purple">
						<div class="widget-stat-btn"><a href="#" data-click="widget-reload"><i class="fa fa-repeat"></i></a></div>
						<div class="widget-stat-content">
							<div class="widget-stat-title">Collected Total Course Fee <?php echo date("Y"); ?></div>
							<div class="widget-stat-number m-b-10">BDT <?php echo $this->Dashboard_model->collected_course_fee(date("Y")); ?></div>
							<div class="widget-stat-chart">
								<div id="flot-visitor-chart" data-height="105px" style="margin: 0 -10px -10px"></div>
							</div>
						</div>
					</div>
					<!-- end widget -->
				</div>
				<!-- end col-4 -->
				
				<div class="col-lg-3">
					<!-- begin widget -->
					<div class="widget widget-stat text-white bg-purple">
						<div class="widget-stat-btn"><a href="#" data-click="widget-reload"><i class="fa fa-repeat"></i></a></div>
						<div class="widget-stat-content">
							<div class="widget-stat-title">Collected Total Retake Exam Fee <?php echo date("Y"); ?></div>
							<div class="widget-stat-number m-b-10">BDT <?php echo $this->Dashboard_model->collected_retake_fee(date("Y")); ?></div>
							<div class="widget-stat-chart">
								<div id="flot-visitor-chart" data-height="105px" style="margin: 0 -10px -10px"></div>
							</div>
						</div>
					</div>
					<!-- end widget -->
				</div>
				
				<div class="col-lg-3">
					<!-- begin widget -->
					<div class="widget widget-stat text-white bg-purple">
						<div class="widget-stat-btn"><a href="#" data-click="widget-reload"><i class="fa fa-repeat"></i></a></div>
						<div class="widget-stat-content">
							<div class="widget-stat-title">Total Students Joined - <?php echo date("Y"); ?></div>
							<div class="widget-stat-number m-b-10"><?php echo $this->Dashboard_model->total_students_joined(date("Y")); ?></div>
							<div class="widget-stat-chart">
								<div id="flot-visitor-chart" data-height="105px" style="margin: 0 -10px -10px"></div>
							</div>
						</div>
					</div>
					<!-- end widget -->
				</div>
				
				<div class="col-lg-3">
					<!-- begin widget -->
					<div class="widget widget-stat text-white bg-purple">
						<div class="widget-stat-btn"><a href="#" data-click="widget-reload"><i class="fa fa-repeat"></i></a></div>
						<div class="widget-stat-content">
							<div class="widget-stat-title">Total number of students passed - <?php echo date("Y"); ?></div>
							<div class="widget-stat-number m-b-10"><?php echo $this->Dashboard_model->total_students_passed(date("Y")); ?></div>
							<div class="widget-stat-chart">
								<div id="flot-visitor-chart" data-height="105px" style="margin: 0 -10px -10px"></div>
							</div>
						</div>
					</div>
					<!-- end widget -->
				</div>
				
				<div class="col-lg-3">
					<!-- begin widget -->
					<div class="widget widget-stat text-white bg-purple">
						<div class="widget-stat-btn"><a href="#" data-click="widget-reload"><i class="fa fa-repeat"></i></a></div>
						<div class="widget-stat-content">
							<div class="widget-stat-title">Total Students Failed - ECE <?php echo date("Y"); ?></div>
							<div class="widget-stat-number m-b-10"><?php echo $this->Dashboard_model->total_students_failed(date("Y")); ?></div>
							<div class="widget-stat-chart">
								<div id="flot-visitor-chart" data-height="105px" style="margin: 0 -10px -10px"></div>
							</div>
						</div>
					</div>
					<!-- end widget -->
				</div>
				
				<!-- begin col-4 -->
				<div class="col-md-3">
					<!-- begin widget -->
					<div class="widget widget-stat text-white bg-purple">
						<div class="widget-stat-btn"><a href="#" data-click="widget-reload"><i class="fa fa-repeat"></i></a></div>
						<div class="widget-stat-content">
							<div class="widget-stat-title">Current Total Students (Phase-A)</div>
							<div class="widget-stat-number m-b-10"><?php echo $this->Dashboard_model->total_students_phase($phase=1); ?></div>
							<div class="widget-stat-chart">
								<div id="flot-visitor-chart" data-height="105px" style="margin: 0 -10px -10px"></div>
							</div>
						</div>
					</div>
					<!-- end widget -->
				</div>
				<!-- end col-4 -->
				
				<!-- begin col-4 -->
				<div class="col-md-3">
					<!-- begin widget -->
					<div class="widget widget-stat text-white bg-purple">
						<div class="widget-stat-btn"><a href="#" data-click="widget-reload"><i class="fa fa-repeat"></i></a></div>
						<div class="widget-stat-content">
							<div class="widget-stat-title">Current Total Students (Phase-B)</div>
							<div class="widget-stat-number m-b-10"><?php echo $this->Dashboard_model->total_students_phase($phase=2); ?></div>
							<div class="widget-stat-chart">
								<div id="flot-visitor-chart" data-height="105px" style="margin: 0 -10px -10px"></div>
							</div>
						</div>
					</div>
					<!-- end widget -->
				</div>
				<!-- end col-4 -->
				
				<!-- begin col-4 -->
				<div class="col-md-3">
					<!-- begin widget -->
					<div class="widget widget-stat text-white bg-purple">
						<div class="widget-stat-btn"><a href="#" data-click="widget-reload"><i class="fa fa-repeat"></i></a></div>
						<div class="widget-stat-content">
							<div class="widget-stat-title">Current Total Students (Phase-C)</div>
							<div class="widget-stat-number m-b-10"><?php echo $this->Dashboard_model->total_students_phase($phase=3); ?></div>
							<div class="widget-stat-chart">
								<div id="flot-visitor-chart" data-height="105px" style="margin: 0 -10px -10px"></div>
							</div>
						</div>
					</div>
					<!-- end widget -->
				</div>
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-3">
					<!-- begin widget -->
					<div class="widget widget-stat text-white bg-purple">
						<div class="widget-stat-btn"><a href="#" data-click="widget-reload"><i class="fa fa-repeat"></i></a></div>
						<div class="widget-stat-content">
							<div class="widget-stat-title">Current Total Students (Phase-D)</div>
							<div class="widget-stat-number m-b-10"><?php echo $this->Dashboard_model->total_students_phase($phase=3); ?></div>
							<div class="widget-stat-chart">
								<div id="flot-visitor-chart" data-height="105px" style="margin: 0 -10px -10px"></div>
							</div>
						</div>
					</div>
					<!-- end widget -->
				</div>
				<!-- end col-4 -->
			</div>
			<!-- end row -->
			
            <!-- begin #footer -->
            <?php require_once APPPATH.'modules/coordinator/templates/copyright.php'; ?>
            <!-- end #footer -->
			<div id="online">
				
			</div>
		</div>
		<!-- end #content -->
		
		<script type="text/javascript">
			/*
				setTimeout(function(){
						checkOn()
					}, 5000);
				function checkOn()
				{
					setTimeout(function(){
						checkOnline()
					}, 5000);
				}
				function checkOnline()
				{
					$.ajax({
						type: 'POST',
						url: baseUrl+'coordinator/dashboard/checkonline',
						data:{_jwar_t_kn_:sqtoken_hash, check:1},
						dataType: 'json',
						success: function(data){
							if(data.status == "ok")
							{
								$('#online').html('Online');
								checkOn();
								sqtoken_hash = data._jwar_t_kn_;
							}else
							{
								$('#online').html('Offline');
								checkOn();
							}
						},
						error: function(){
							$('#online').html('Offline');
							checkOn();
						}
					});
				}
				*/
		</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>