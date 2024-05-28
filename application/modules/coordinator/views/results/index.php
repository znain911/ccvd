<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Results</a></li>
				<li><a href="javascript:;">End-Module Exam Results</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">End-Module Exam Results</h1>
			<a href="<?php echo base_url('coordinator/results/result_export');?>" class="btn btn-info pull-right" style="margin-left: 2px;"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export All</a>
			<a href="<?php echo base_url('coordinator/results/result_export1');?>" class="btn btn-info pull-right" style="margin-left: 2px;"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Chaper 1</a>
			<a href="<?php echo base_url('coordinator/results/result_export2');?>" class="btn btn-info pull-right" style="margin-left: 2px;"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Chaper 2</a>
			<a href="<?php echo base_url('coordinator/results/result_export2');?>" class="btn btn-info pull-right" style="margin-left: 2px;"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Chaper 3</a>
			<a href="<?php echo base_url('coordinator/results/result_export2');?>" class="btn btn-info pull-right" style="margin-left: 2px;"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export ECE</a>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12 mostak-mdl-box">
					<div id="mdlBoxLoader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
					<div id="moduleLessonDisplay">
						<?php require_once APPPATH.'modules/coordinator/views/results/module/contents.php'; ?>
					</div>
				</div>
				<!-- end col-4 -->
			</div>
			<!-- end row -->
			
            <!-- begin #footer -->
            <?php require_once APPPATH.'modules/coordinator/templates/copyright.php'; ?>
            <!-- end #footer -->
		</div>
		<!-- end #content -->
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>