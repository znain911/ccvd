<header class="ms-header ms-header-primary">
	<!--ms-header-primary-->
	<div class="container container-full">
	  <div class="ms-title">
		<a href="<?php echo site_url(); ?>">
		  <img src="<?php echo base_url('frontend/tools/badas.png'); ?>" class="badas-logo" alt="BADAS">
		  <img src="<?php echo base_url('frontend/tools/dlp.png'); ?>" class="dlp-logo" alt="DLP">
		</a>
	  </div>
	  <div class="header-right">
		<div class="top-link-pg user-hdr">
			<a href="<?php echo base_url('faculty/dashboard'); ?>" class="act-usr">
			  <span class="wlcm">Welcome</span> <span class="fa fa-user"></span>&nbsp; <?php echo $this->session->userdata('full_name'); ?>
			</a>
			<a href="<?php echo base_url('faculty/myaccount'); ?>" class="<?php echo ($activate_link == 'myaccount')? 'top-link-active' : null; ?>">
			  My Account
			</a>
			<a href="<?php echo base_url('faculty/faqs'); ?>" class="<?php echo ($activate_link == 'faqs')? 'top-link-active' : null; ?>">
			  FAQs
			</a>
			<!--
			<a href="<?php echo base_url('faculty/support'); ?>" class="<?php echo ($activate_link == 'support')? 'top-link-active' : null; ?>">
			  Support
			</a>
			-->
			<a href="<?php echo base_url('faculty/logout'); ?>">
			  Logout <i class="fa fa-sign-out"></i>
			</a>
		</div>
		<a href="<?php echo base_url('faculty/dashboard'); ?>" class="<?php echo ($activate_link == 'dashboard')? 'top-link-active' : null; ?>">
		  Dashboard
		</a>
		<a href="<?php echo base_url('faculty/schedules'); ?>" class="<?php echo ($activate_link == 'schedules')? 'top-link-active' : null; ?>">
		  Schedules
		</a>
		<a href="<?php echo base_url('faculty/ftwof'); ?>" class="<?php echo ($activate_link == 'ftwof')? 'top-link-active' : null; ?>">
		  F2F Session
		</a>
		<a href="<?php echo base_url('faculty/evaluations'); ?>" class="<?php echo ($activate_link == 'evaluations')? 'top-link-active' : null; ?>">
		  Evaluation
		</a>
		<a href="<?php echo base_url('faculty/discussion'); ?>" class="<?php echo ($activate_link == 'discussion')? 'top-link-active' : null; ?>">
		  Discussion
		</a>
		<!--
		<a href="javascript:void(0)" style="padding-right:0" class="btn-ms-menu btn-circle btn-circle-primary ms-toggle-left">
		  <i class="zmdi zmdi-menu"></i>
		</a>
		-->
	  </div>
	</div>
</header>