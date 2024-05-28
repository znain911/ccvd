<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<?php require_once APPPATH.'modules/student/templates/sidebar.php'; ?>
			</div>
			<div class="col-lg-9">
				<div class="student-dashboard-progress-tracker">
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<h3 class="progress-title" style="position:relative">PROGRESS TRACKER
									<span class="clr-declaration">
										<span class="green-clr"><span class="grn"></span> Completed</span>
										<span class="blue-clr"><span class="blu"></span> In-Progress</span>
									</span>
								</h3>
								<div class="progress-bar-li-ms">
									<div class="progress">
										<?php 
											$tracker = '';
											if($dashboard_info['student_phaselevel_id'] == 1){
												
												$tracker .= '<span class="proccessing-one-phase"></span>';
											}
											if($dashboard_info['student_phaselevel_id'] == 2){
												
												$tracker .= '
															<span class="complete-one-phase"></span>
															<span class="proccessing-two-phase"></span>
															';
											}			
											if($dashboard_info['student_phaselevel_id'] == 3){
												
												$tracker .= '
															<span class="complete-one-phase"></span>
															<span class="complete-two-phase"></span>
															<span class="proccessing-three-phase"></span>
															';
															
											}
											
											if($dashboard_info['student_phaselevel_id'] == 0 && $dashboard_info['student_ece_status'] == 1){
												
												$tracker .= '
															<span class="complete-one-phase"></span>
															<span class="complete-two-phase"></span>
															<span class="complete-three-phase"></span>
															<span class="proccessing-eca"></span>
															';
															
											}
											if($dashboard_info['student_phaselevel_id'] == 0 && $dashboard_info['student_ece_status'] == 0){
												
												$tracker .= '
																<span class="complete-one-phase"></span>
																<span class="complete-two-phase"></span>
																<span class="complete-three-phase"></span>
																<span class="complete-eca"></span>
															';
												
											}
											
											echo $tracker;
										?>
									</div>
									<span class="phase phase-a">Chapter 1</span>
									<span class="phase phase-b">Chapter 2 <span class="pca-exam pce-one">CCA 1</span></span>
									<span class="phase phase-c">Chapter 3 <span class="pca-exam pce-two">CCA 2</span></span>
									<span class="phase ece">ECE <span class="pca-exam pce-three">CCA 3</span></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="student-dashboard-notification">
					<div class="row">
						<div class="col-lg-7">
							<div class="admin-notification-title">
								<h2>
									<span class="top-tt">ADMINISTRATION</span> <br />
									<span class="bottom-tt">NOTIFICATION</span>
								</h2>
							</div>
							<div class="jsVerSlidr">
								<?php 
									$notifications = $this->Dashboard_model->get_dahboard_notifications();
									foreach($notifications as $notification):
									$crnt_date = strtotime(date("Y-m-d"));
									$notice_date = strtotime(date("Y-m-d", strtotime($notification['notif_create_date'])));
								?>
								<div class="single-notification">
									<span class="new-or-op-nt pull-right"><?php echo ($notice_date == $crnt_date)? 'NEW' : 'OLD'; ?></span>
									<div class="coordinator-nt-date">
										<span class="nt-date"><?php echo date("d F Y", strtotime($notification['notif_create_date'])); ?>, </span>
										<span class="nt-time"><?php echo date("H:i:s A", strtotime($notification['notif_create_date'])); ?></span>
									</div>
									<div class="coordinator-nt-description">
										<?php echo $notification['notif_content']; ?>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
							<h2>Download</h2>
							<hr>
							<a href="<?php echo base_url('attachments/blood-pressure-measurment.pdf');?>" class="btn btn-info" style="background-color: green; float: left; color: #ffffff" target="_blank">Blood Pressure Measurment</a>
							<a href="<?php echo base_url('attachments/HTN-new.pdf');?>" class="btn btn-info" style="background-color: green; float: left; color: #ffffff" target="_blank">HTN Lecture</a>
						</div>
						<div class="col-lg-5 evnts">
							<h2>
								<span class="top-tt">SCHEDULED</span> <br />
								<span class="bottom-tt">EVENTS</span>
							</h2>
							<div class="events-calender">
								<?php 
									
									if($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->uri->segment(5) && is_numeric($this->uri->segment(5)))
									{
										echo $this->calendar->generate($this->uri->segment(4), $this->uri->segment(5));
									}else
									{
										echo $this->calendar->generate(date("Y"), date("m"));
									}
								?>
							</div>
							<div class="schdl-indicator">
								<?php 
									$get_sdt_schedule_dates      = $this->Dashboard_model->get_sdt_schedule_dates();
									$get_workshop_schedule_dates = $this->Dashboard_model->get_workshop_schedule_dates();
									$get_ece_schedule_dates      = $this->Dashboard_model->get_ece_schedule_dates();
								?>
							
								<?php foreach($get_sdt_schedule_dates as $sdt): ?>
								<span class="indicator indicator-two"><i class="fa fa-star"></i> &nbsp; <?php echo $sdt['endmschedule_title']; ?> schedule available from <?php echo date("d F, Y", strtotime($sdt['endmschedule_from_date'])).' - '.date("d F, Y", strtotime($sdt['endmschedule_to_date'])); ?></span>
								<?php endforeach; ?>
								
								<?php foreach($get_workshop_schedule_dates as $workshop): ?>
								<span class="indicator indicator-three"><i class="fa fa-star"></i> &nbsp; <?php echo $workshop['endmschedule_title']; ?> schedule available from <?php echo date("d F, Y", strtotime($workshop['endmschedule_from_date'])).' - '.date("d F, Y", strtotime($workshop['endmschedule_to_date'])); ?></span>
								<?php endforeach; ?>
								
								<?php foreach($get_ece_schedule_dates as $ece): ?>
								<span class="indicator indicator-four"><i class="fa fa-star"></i> &nbsp; <?php echo $ece['endmschedule_title']; ?> schedule available from <?php echo date("d F, Y", strtotime($ece['endmschedule_from_date'])).' - '.date("d F, Y", strtotime($ece['endmschedule_to_date'])); ?></span>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>