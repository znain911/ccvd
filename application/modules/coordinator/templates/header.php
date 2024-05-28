<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Coordinator</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,700" rel="stylesheet" id="fontFamilySrc" />
	<link href="<?php echo base_url('backend/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('backend/assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('backend/assets/plugins/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('backend/assets/css/animate.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('backend/assets/css/style.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('backend/assets/css/customstyle.css'); ?>" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
    <link href="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/plugins/ionRangeSlider/css/ion.rangeSlider.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/plugins/ionRangeSlider/css/ion.rangeSlider.skinNice.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/plugins/strength-js/strength.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-combobox/css/bootstrap-combobox.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/plugins/jquery-tag-it/css/jquery.tagit.css" rel="stylesheet" />
    <link href="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
    <link href="<?php echo base_url('backend/'); ?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-eonasdan-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL CSS STYLE ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
    <link href="<?php echo base_url('backend/assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css'); ?>" rel="stylesheet" />
	<!-- ================== BEGIN PAGE LEVEL CSS STYLE ================== -->
    <link href="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/'); ?>assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url('backend/assets/plugins/summernote/dist/summernote.css'); ?>" rel="stylesheet" />
	<!-- ================== END PAGE LEVEL CSS STYLE ================== -->
    
	<!-- ================== BEGIN BASE JS ================== -->
	<!--<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>-->
	<script src="<?php echo base_url('backend/assets/js/vendor/jquery-3.2.1.min.js'); ?>"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="<?php echo base_url('backend/assets/plugins/jquery/jquery-migrate-1.1.0.min.js'); ?>"></script>
	<script src="https://cdn.ckeditor.com/4.11.1/full/ckeditor.js"></script>
	<script type="text/javascript">
		var baseUrl = "<?php echo base_url(); ?>";
		var sqtoken = "<?php echo $this->security->get_csrf_token_name(); ?>";
		var sqtoken_hash = "<?php echo $this->security->get_csrf_hash(); ?>";
	</script>
	
	<script src="<?php echo base_url('backend/assets/js/custom/jquery.validate.js'); ?>"></script>
	<script src="<?php echo base_url('backend/assets/plugins/pace/pace.min.js'); ?>"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!--[if lt IE 9]>
	    <script src="assets/crossbrowserjs/excanvas.min.js"></script>
	<![endif]-->
</head>
<body class="font-roboto pace-done">
	<!-- begin #page-container -->
	<div id="page-container" class="page-container page-header-fixed page-sidebar-fixed page-with-two-sidebar page-with-footer">
		<!-- begin #header -->
		<div id="header" class="header navbar navbar-default navbar-fixed-top">
			<!-- begin container-fluid -->
			<div class="container-fluid">
				<!-- begin mobile sidebar expand / collapse button -->
				<div class="navbar-header">
					<a href="<?php echo base_url('coordinator/dashboard'); ?>" class="navbar-brand"><img src="<?php echo base_url('backend/assets/img/eccvd.png'); ?>" class="logo" alt="" /> Certificate Course on Cardiovascular Disease (CCVD)</a>
				</div>
				<!-- end mobile sidebar expand / collapse button -->
				
				<!-- begin navbar-right -->
				<ul class="nav navbar-nav navbar-right">
					<?php 
						$total_phone_change_request = $this->Perm_model->total_phone_change_request();
						if($total_phone_change_request !== 0):
					?>
					<li>
						<a href="<?php echo base_url('coordinator/students/pchanged'); ?>" style="postion:relative !important;color: #F00;">
							Phone number change request
							<span class="sp-counting"><?php echo $total_phone_change_request; ?></span>
						</a>
					</li>
					<?php endif; ?>
					<li>
						<a href="<?php echo site_url(); ?>" target="_blank">
							<i class="fa fa-globe"></i> Back to Website
						</a>
					</li>
					<li class="dropdown">
						<a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle has-notify" data-click="toggle-notify">
							<i class="fa fa-bell"></i>
						</a>
						<ul class="dropdown-menu dropdown-notification pull-right">
                            <li class="dropdown-header">Notifications (5)</li>
                            <li class="notification-item">
                                <a href="javascript:;">
                                    <div class="media"><i class="fa fa-exclamation-triangle"></i></div>
                                    <div class="message">
                                        <h6 class="title">Server Error Reports</h6>
                                        <div class="time">3 minutes ago</div>
                                    </div>
                                    <div class="option" data-toggle="tooltip" data-title="Mark as Read" data-click="set-message-status" data-status="unread" data-container="body">
                                        <i class="fa fa-circle-o"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="notification-item">
                                <a href="javascript:;">
                                    <div class="media"><img src="assets/img/user_1.jpg" alt="" /></div>
                                    <div class="message">
                                        <h6 class="title">Solvia Smith</h6>
                                        <p class="desc">Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
                                        <div class="time">25 minutes ago</div>
                                    </div>
                                    <div class="option read" data-toggle="tooltip" data-title="Mark as Unread" data-click="set-message-status" data-status="read" data-container="body">
                                        <i class="fa fa-circle-o"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="notification-item">
                                <a href="javascript:;">
                                    <div class="media"><img src="assets/img/user_2.jpg" alt="" /></div>
                                    <div class="message">
                                        <h6 class="title">Olivia</h6>
                                        <p class="desc">Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
                                        <div class="time">35 minutes ago</div>
                                    </div>
                                    <div class="option read" data-toggle="tooltip" data-title="Mark as Unread" data-click="set-message-status" data-status="read" data-container="body">
                                        <i class="fa fa-circle-o"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="notification-item">
                                <a href="javascript:;">
                                    <div class="media"><i class="fa fa-user-plus media-object"></i></div>
                                    <div class="message">
                                        <h6 class="title"> New User Registered</h6>
                                        <div class="time">1 hour ago</div>
                                    </div>
                                    <div class="option read" data-toggle="tooltip" data-title="Mark as Unread" data-click="set-message-status" data-status="read" data-container="body">
                                        <i class="fa fa-circle-o"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="notification-item">
                                <a href="javascript:;">
                                    <div class="media bg-success"><i class="fa fa-credit-card"></i></div>
                                    <div class="message">
                                        <h6 class="title"> New Item Sold</h6>
                                        <div class="time">2 hour ago</div>
                                    </div>
                                    <div class="option read" data-toggle="tooltip" data-title="Mark as Read" data-click="set-message-status" data-status="read" data-container="body">
                                        <i class="fa fa-circle-o"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-footer text-center">
                                <a href="javascript:;">View more</a>
                            </li>
						</ul>
					</li>
					<li class="dropdown navbar-user">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<span class="image">
								<?php if($this->session->userdata('admin_photo') !== null): ?>
								<img src="<?php echo attachment_url('coordinators/'.$this->session->userdata('admin_photo')); ?>" alt="Avatar" />
								<?php else: ?>
								<img src="<?php echo base_url('backend/assets/tools/default_avatar.png'); ?>" alt="Avatar" />
								<?php endif; ?>
							</span>
							<span class="hidden-xs"><?php echo $this->session->userdata('full_name'); ?></span> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu pull-right">
							<li><a href="<?php echo base_url('coordinator/profile'); ?>">Edit Profile</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo base_url('coordinator/logout'); ?>">Log Out</a></li>
						</ul>
					</li>
				</ul>
				<!-- end navbar-right -->
			</div>
			<!-- end container-fluid -->
		</div>