<?php require_once APPPATH.'modules/common/header.php'; ?>
	<?php 
		$dashboard_info = $this->Dashboard_model->get_student_information();
	?>
	<div class="student-dashboard-header">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<div class="user-information">
						<div class="user-hpoto">
							<?php 
								if($dashboard_info['spinfo_photo']): 
								$photo_url = attachment_url('students/'.$dashboard_info['student_username'].'/'.$dashboard_info['spinfo_photo']);
							?>
							<img src="<?php echo $photo_url; ?>" class="user-profile-photo" alt="Profile Photo" />
							<?php else: ?>
							<img src="<?php echo base_url('frontend/tools/default.png'); ?>" class="user-profile-photo" alt="Profile Photo" />
							<?php endif; ?>
						</div>
						<div class="user-account-short">
							<?php
								$time = strtotime($dashboard_info['student_regdate']);
								$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
								
								$logintime = strtotime($dashboard_info['student_last_login']);
								$myLoignFormatForView = date("M d, Y", $logintime).'&nbsp;&nbsp;'.date("g:i A", $logintime);
								
								$status_array = array('0' => 'Pending', '1' => 'Enrolled');
							?>
							<h2><?php echo $dashboard_info['spinfo_first_name'].' '.$dashboard_info['spinfo_middle_name'].' '.$dashboard_info['spinfo_last_name']; ?></h2>
							<p><strong>Joined On : </strong> <?php echo $myFormatForView; ?></p>
							<p><strong>Status : </strong> <?php echo $status_array[$dashboard_info['student_status']] ?></p>
							<p><strong>Course : </strong> <?php echo $dashboard_info['phase_name']; ?></p>
							<p><strong>Last Login : </strong> <?php echo $myLoignFormatForView; ?></p>
							<p><strong>Login From (IP Address) : </strong> <?php echo $dashboard_info['student_login_ip']; ?></p>
							<p><a href="<?php echo base_url('student/myaccount'); ?>" class="button-my-account"><span class="ion-person"></span> My Account</a></p>
						</div>
					</div>
				</div>
				<div class="col-lg-4 text-right">
					<!--
					<div class="st-progress">
						<p><strong>PROGRESS</strong></p>
						<p><strong>37</strong><span>%</span></p>
						<p><a href="" class="continue-button">CONTINUE</a></p>
					</div>
					-->
				</div>
			</div>
		</div>
	</div>
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
												<span class="proccessing-three-phase"></span>
												';
												
								}
								if($dashboard_info['student_phaselevel_id'] == 0 && $dashboard_info['student_ece_status'] == 0){
									
									$tracker .= '
													<span class="complete-one-phase"></span>
													<span class="complete-two-phase"></span>
													<span class="complete-three-phase"></span>
												';
									
								}
								
								echo $tracker;
							?>
						</div>
						<span class="phase phase-a">Phase A </span>
						<span class="phase phase-b">Phase B <span class="pca-exam pce-one">PCA 1</span></span>
						<span class="phase phase-c">Phase C <span class="pca-exam pce-two">PCA 2</span></span>
						<span class="phase phase-c">ECE <span class="pca-exam pce-three">PCA 3</span></span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="student-dashboard-notification">
		<div class="container">
			<div class="row">
				<div class="col-lg-7">
					<div class="admin-notification-title">
						<h2>
							<span class="top-tt">ADMINISTRATION</span> <br />
							<span class="bottom-tt">NOTIFICATION</span>
						</h2>
					</div>
					<div class="single-notification">
						<div class="coordinator-nt-icon"><i class="fa fa-calendar"></i></div>
						<div class="coordinator-nt-date">
							<span class="nt-date">12 NOVEMBER 2018</span>
							<span class="nt-time">04:45:PM</span>
						</div>
						<div class="coordinator-nt-description">
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
							Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus
							et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies 
							nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede 
							justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, 
						</div>
					</div>
					<div class="single-notification">
						<div class="coordinator-nt-icon"><i class="fa fa-calendar"></i></div>
						<div class="coordinator-nt-date">
							<span class="nt-date">12 NOVEMBER 2018</span>
							<span class="nt-time">04:45:PM</span>
						</div>
						<div class="coordinator-nt-description">
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
							Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus
							et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies 
							nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede 
							justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, 
						</div>
					</div>
					<div class="single-notification">
						<div class="coordinator-nt-icon"><i class="fa fa-calendar"></i></div>
						<div class="coordinator-nt-date">
							<span class="nt-date">12 NOVEMBER 2018</span>
							<span class="nt-time">04:45:PM</span>
						</div>
						<div class="coordinator-nt-description">
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
							Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus
							et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies 
							nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede 
							justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, 
						</div>
					</div>
					<div class="single-notification">
						<div class="coordinator-nt-icon"><i class="fa fa-calendar"></i></div>
						<div class="coordinator-nt-date">
							<span class="nt-date">12 NOVEMBER 2018</span>
							<span class="nt-time">04:45:PM</span>
						</div>
						<div class="coordinator-nt-description">
							Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
							Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus
							et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies 
							nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede 
							justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, 
						</div>
					</div>
				</div>
				<div class="col-lg-5">
					<h2>
						<span class="top-tt">SCHEDULED</span> <br />
						<span class="bottom-tt">EVENTS</span>
					</h2>
					<div class="events-calender">
						<?php echo $this->calendar->generate(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>