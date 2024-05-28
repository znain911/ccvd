<div class="dashboard-sidebar-left">
	<div class="profile-area">
		<?php 
			if($dashboard_info['spinfo_photo']): 
			$photo_url = attachment_url('students/'.$dashboard_info['student_entryid'].'/'.$dashboard_info['spinfo_photo']);
		?>
		<div class="img-profile-photo" style="background:url(<?php echo $photo_url; ?>) no-repeat 0 0;background-size:cover;"></div>
		<?php else: ?>
		<div class="img-profile-photo" style="background:url(<?php echo base_url('frontend/tools/default.png'); ?>) no-repeat 0 0;background-size:cover;"></div>
		<?php endif; ?>
		<div class="profile-info">
			<p class="profile-info-name">
				<strong><?php echo $this->session->userdata('full_name'); ?></strong> <br />
				Certificate Course on Cardiovascular Disease
			</p>
			<p class="profile-roll"><strong>ID : <?php echo $dashboard_info['student_entryid']; ?></strong></p>
		</div>
	</div>
	<ul class="main-sidebar-ul">
		<li class="main-li <?php echo student_item_activate('student', 'dashboard'); ?>"><a href="<?php echo base_url('student/dashboard'); ?>" class="main-anchor"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li class="main-li <?php echo student_item_activate('student', 'course'); ?>">
			<a href="<?php echo base_url('student/course'); ?>" class="main-anchor"><i class="fa fa-book"></i> Course <!--<i class="right-indc fa fa-angle-right"></i>--></a>
			<!--
			<ul class="second-level-ul">
				<li class="second-level-li">
					<a class="second-level-anchor" href="">PHASE - A <i class="fa fa-plus"></i></a>
				</li>
				<li class="second-level-li active">
					<a class="second-level-anchor" href="">PHASE - B <i class="fa fa-angle-right"></i></a>
					<ul class="third-level-ul">
						<li class="third-level-li"><a href="" class="third-level-anchor">Module - 4</a></li>
						<li class="third-level-li"><a href="" class="third-level-anchor">Module - 5</a></li>
						<li class="third-level-li active"><a href="" class="third-level-anchor">Module - 6</a></li>
						<li class="third-level-li"><a href="" class="third-level-anchor">Module - 7</a></li>
					</ul>
				</li>
				<li class="second-level-li">
					<a class="second-level-anchor" href="">PHASE - C <i class="fa fa-plus"></i></a>
				</li>
			</ul>
			-->
		</li>
		<li class="main-li <?php echo student_item_activate('student', 'results'); ?>"><a href="<?php echo base_url('student/results'); ?>" class="main-anchor"><i class="fa fa-calendar-check-o"></i> Result</a></li>
		<li class="main-li <?php echo student_item_activate('student', 'payments'); ?>"><a href="<?php echo base_url('student/payments'); ?>" class="main-anchor"><i class="fa fa-credit-card"></i> Payments</a></li>
		<li class="main-li <?php echo student_item_activate('student', 'apply'); ?>">
			<a href="javascript:;" class="main-anchor"><i class="fa fa-hand-o-right"></i> Apply <i class="right-indc fa fa-angle-right"></i></a>
			<ul class="second-level-ul">
				<?php 
					$check_ece_status = $this->Perm_model->check_student_ece_status();
					if($check_ece_status == false && $this->session->userdata('active_phase') == 2):
					$sidebar_sdt_schedules = $this->Perm_model->get_sdt_schedules($this->session->userdata('active_phase'));
					foreach($sidebar_sdt_schedules as $sdt):
				?>
				<li class="second-level-li">
					<?php 
						$sidebar_current_date = strtotime(date("Y-m-d"));
						$sidebar_sdl_from_date = strtotime($sdt['endmschedule_from_date']);
						if($sidebar_sdl_from_date > $sidebar_current_date): 
					?>
					<a class="second-level-anchor" href="<?php echo base_url('student/apply?type=SDT&to='.$sdt['endmschedule_id'].'&rdr=apply'); ?>"><?php echo $sdt['endmschedule_title']; ?></a>
					<?php else: ?>
					<a class="second-level-anchor" style="cursor:pointer"><?php echo $sdt['endmschedule_title']; ?></a>
					<?php endif; ?>
				</li>
				<?php 
					endforeach; 
					endif;
				?>
				
				<?php 
					if($check_ece_status == false && $this->session->userdata('active_phase') == 2):
					$sidebar_workshop_schedules = $this->Perm_model->get_workshop_schedules($this->session->userdata('active_phase'));
					foreach($sidebar_workshop_schedules as $workshop):
				?>
				<li class="second-level-li">
					<?php 
						$sidebar_workshop_current_date = strtotime(date("Y-m-d"));
						$sidebar_workshop_sdl_from_date = strtotime($workshop['endmschedule_from_date']);
						if($sidebar_workshop_sdl_from_date > $sidebar_workshop_current_date): 
					?>
					<a class="second-level-anchor" href="<?php echo base_url('student/apply?type=WORKSHOP&to='.$workshop['endmschedule_id'].'&rdr=apply'); ?>"><?php echo $workshop['endmschedule_title']; ?></a>
					<?php else: ?>
					<a class="second-level-anchor" style="cursor:pointer"><?php echo $workshop['endmschedule_title']; ?></a>
					<?php endif; ?>
				</li>
				<?php 
					endforeach;
					endif;
				?>
				
				<?php 
					if($check_ece_status == false && $this->session->userdata('active_phase') == 3):
					$sidebar_workshop_schedules = $this->Perm_model->get_workshop_schedules($this->session->userdata('active_phase'));
					foreach($sidebar_workshop_schedules as $workshop):
				?>
				<li class="second-level-li">
					<?php 
						$sidebar_workshop_current_date = strtotime(date("Y-m-d"));
						$sidebar_workshop_sdl_from_date = strtotime($workshop['endmschedule_from_date']);
						if($sidebar_workshop_sdl_from_date > $sidebar_workshop_current_date): 
					?>
					<a class="second-level-anchor" href="<?php echo base_url('student/apply?type=WORKSHOP&to='.$workshop['endmschedule_id'].'&rdr=apply'); ?>"><?php echo $workshop['endmschedule_title']; ?></a>
					<?php else: ?>
					<a class="second-level-anchor" style="cursor:pointer"><?php echo $workshop['endmschedule_title']; ?></a>
					<?php endif; ?>
				</li>
				<?php 
					endforeach; 
					endif;
				?>
				
				<?php 
					if($check_ece_status == true):
				?>
				<li class="second-level-li">
					<?php
						$check_ece_schedule = $this->Perm_model->check_ece_schedule();
						if($check_ece_status == true && $check_ece_schedule == true):
					?>
					<a class="second-level-anchor" href="<?php echo base_url('student/apply?type=ECE&to='.$check_ece_schedule['endmschedule_id'].'&rdr=apply'); ?>">ECE</a>
					<?php else: ?>
					<a class="second-level-anchor" style="cursor:pointer">ECE</a>
					<?php endif; ?>
				</li>
				<?php endif; ?>
			</ul>
		</li>
		<li class="main-li <?php echo student_item_activate('student', 'contact'); ?>"><a href="<?php echo base_url('student/contact'); ?>" class="main-anchor"><i class="fa fa-envelope"></i> Contact Us</a></li>
		<li class="main-li <?php echo student_item_activate('student', 'evaluation'); ?>">
			<a href="javascript:;" class="main-anchor"><i class="fa fa-star"></i> Evaluations <i class="right-indc fa fa-angle-right"></i></a>
			<ul class="second-level-ul">
				<li class="second-level-li">
					<a class="second-level-anchor" href="<?php echo base_url('student/evaluation'); ?>">Submit Evaluation <i class="fa fa-angle-right"></i></a>
				</li>
				<li class="second-level-li">
					<a class="second-level-anchor" href="<?php echo base_url('student/evaluation/lists'); ?>">View Evaluations <i class="fa fa-angle-right"></i></a>
				</li>
			</ul>
		</li>
		<li class="main-li <?php echo student_item_activate('student', 'profile'); ?>"><a href="<?php echo base_url('student/profile'); ?>" class="main-anchor"><i class="fa fa-user"></i> Profile</a></li>
		<li class="main-li <?php echo student_item_activate('student', 'changepassword'); ?>"><a href="<?php echo base_url('student/changepassword'); ?>" class="main-anchor"><i class="fa fa-key"></i> Change Password</a></li>
		<li class="main-li"><a href="<?php echo base_url('student/faqs'); ?>" class="main-anchor"><i class="fa fa-question-circle"></i> FAQS</a></li>
		<li class="main-li <?php echo student_item_activate('student', 'logout'); ?>"><a href="<?php echo base_url('student/logout'); ?>" class="main-anchor"><i class="fa fa-sign-out"></i> Logout</a></li>
	</ul>
</div>