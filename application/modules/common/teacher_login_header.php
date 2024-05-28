<?php 
	$dashboard_info = $this->Common_model->get_teacher_information();
?>
<header class="ms-header ms-header-primary student-lgg-hdr">
	<!--ms-header-primary-->
	<div class="container container-full">
	  <div class="ms-title">
		<a href="<?php echo site_url(); ?>">
		  <img src="<?php echo base_url('frontend/tools/badas.png'); ?>" class="badas-logo" alt="BADAS">
		  <span class="ccd-lg-txt">CCD Online</span>
		</a>
	  </div>
	  <div class="header-right student-header-right">
		<div class="notofication-bel">
			<span class="fa fa-bell"></span>
		</div>
		<div class="profile-link">
			<a href="<?php echo base_url('faculty/dashboard'); ?>" class="profile-link-anchor">Dashboard</a>
		</div>
		<div class="log-in-out-btn">
			<a href="<?php echo base_url('faculty/logout'); ?>" class="auth-link-anchor">Log Out</a>
		</div>
	  </div>
	</div>
</header>