<div class="dashboard-sidebar-left">
	<div class="profile-area">
		<?php 
			if($dashboard_info['tpinfo_photo']): 
			$photo_url = attachment_url('faculties/'.$dashboard_info['teacher_entryid'].'/'.$dashboard_info['tpinfo_photo']);
		?>
		<div class="img-profile-photo" style="background:url(<?php echo $photo_url; ?>) no-repeat 0 0;background-size:cover;"></div>
		<?php else: ?>
		<div class="img-profile-photo" style="background:url(<?php echo base_url('frontend/tools/default.png'); ?>) no-repeat 0 0;background-size:cover;"></div>
		<?php endif; ?>
		<div class="profile-info">
			<p class="profile-info-name">
				<strong><?php echo $this->session->userdata('full_name'); ?></strong> <br />
				Certificate course in diabetology
			</p>
			<p class="profile-roll"><strong>ID : <?php echo $dashboard_info['teacher_entryid']; ?></strong></p>
		</div>
	</div>
	<ul class="main-sidebar-ul">
		<li class="main-li <?php echo student_item_activate('faculty', 'dashboard'); ?>"><a href="<?php echo base_url('faculty/dashboard'); ?>" class="main-anchor"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li class="main-li <?php echo student_item_activate('faculty', 'schedules'); ?>"><a href="<?php echo base_url('faculty/schedules'); ?>" class="main-anchor"><i class="fa fa-clock-o"></i> Course Schedule</a></li>
		<li class="main-li <?php echo student_item_activate('faculty', 'contact'); ?>"><a href="<?php echo base_url('faculty/contact'); ?>" class="main-anchor"><i class="fa fa-envelope"></i> Contact Us</a></li>
		
		<li class="main-li <?php echo student_item_activate('faculty', 'evaluation'); ?>">
			<a href="javascript:;" class="main-anchor"><i class="fa fa-star"></i> Evaluations <i class="right-indc fa fa-angle-right"></i></a>
			<ul class="second-level-ul">
				<li class="second-level-li">
					<a class="second-level-anchor" href="<?php echo base_url('faculty/evaluation'); ?>">Submit Evaluation <i class="fa fa-angle-right"></i></a>
				</li>
				<li class="second-level-li">
					<a class="second-level-anchor" href="<?php echo base_url('faculty/evaluation/lists'); ?>">View Evaluations <i class="fa fa-angle-right"></i></a>
				</li>
			</ul>
		</li>
		<li class="main-li <?php echo student_item_activate('faculty', 'profile'); ?>"><a href="<?php echo base_url('faculty/profile'); ?>" class="main-anchor"><i class="fa fa-user"></i> Profile</a></li>
		<li class="main-li <?php echo student_item_activate('faculty', 'changepassword'); ?>"><a href="<?php echo base_url('faculty/changepassword'); ?>" class="main-anchor"><i class="fa fa-key"></i> Change Password</a></li>
		<li class="main-li"><a href="<?php echo base_url('faculty/faqs'); ?>" class="main-anchor"><i class="fa fa-question-circle"></i> FAQS</a></li>
		<li class="main-li <?php echo student_item_activate('faculty', 'logout'); ?>"><a href="<?php echo base_url('faculty/logout'); ?>" class="main-anchor"><i class="fa fa-sign-out"></i> Logout</a></li>
	</ul>
</div>