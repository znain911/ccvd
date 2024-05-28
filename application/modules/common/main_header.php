<header class="ms-header ms-header-primary">
	<!--ms-header-primary-->
	<div class="container container-full">
	  <div class="ms-title">
		<a href="<?php echo site_url(); ?>">
		  <img src="<?php echo base_url('frontend/tools/eccvd.png'); ?>" class="badas-logo" alt="BADAS">
		</a>
	  </div>
	  <div class="header-right-logo">
		<img src="<?php echo base_url('frontend/tools/badas.png'); ?>" class="dlp-logo" alt="DLP" width="100%">
	  </div>
	  <div class="header-right">
		<div class="login-header-container text-right">
			<a href="javascript:void(0)" data-toggle="modal" data-target="#myModalLoign" class="login-clickable-button">LOG IN</a>
		</div>
		<div class="navigation-header-container text-right">
			<div class="dlp-menu-item"><a href="<?php echo site_url(); ?>" class="main-nav-anchor">Home</a></div>
			<div class="dlp-menu-item set-position-relative">
				<a href="<?php echo base_url('page/about/dlp'); ?>" class="main-nav-anchor">About CCVD</a>
				<div class="dlp-dropdown">
					<div class="dlp-submenu-container">
						<?php 
							$header_pages = $this->Common_model->get_pages(1);
							foreach($header_pages as $page):
						?>
						<a href="<?php echo base_url('page/about/dlp/'); ?>#<?php echo $page['page_slug']; ?>" class="drop-nav-anchor enable-scroll"><?php echo $page['page_title']; ?></a>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="dlp-menu-item"><a href="<?php echo site_url(); ?>#landingFaqs" class="main-nav-anchor enable-scroll">FAQ</a></div>
			<div class="dlp-menu-item"><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal7" class="main-nav-anchor">Register For Account</a></div>
			<!--<div class="dlp-menu-item"><a href="#" class="main-nav-anchor" style="cursor: not-allowed;pointer-events: all !important; color: #f0828d; display: none;">Register For Account</a></div> -->
			<div class="dlp-menu-item"><a href="<?php echo base_url('notice'); ?>" class="main-nav-anchor">Notice</a></div>
			<div class="dlp-menu-item"><a href="<?php echo base_url('contact'); ?>" class="main-nav-anchor">Contact Us</a></div>
		</div>
	  </div>
	</div>
</header>