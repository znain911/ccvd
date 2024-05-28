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
				<li><a href="javascript:;">Export Exam Results</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">End-Module Exam Results</h1>
			<button type="button" id="examdate" class="btn btn-primary btn-lg"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exam Date</button>
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12 mostak-mdl-box">
					<!-- begin widget -->
					<div class="widget p-0">
						<div class="table-responsive">
							<div id="getContents">
								<div style="width:500px; margin: 0px auto;">
									<div class="form-group">									
											<label class="control-label">Select Batch: &nbsp;</label>
											<select name="batch" id="batch" class="form-control">
												<?php 
													foreach($get_betch as $key => $batch):
												?>
														<option value="<?php echo $batch->batch_name; ?>"><?php echo $batch->batch_name; ?></option>
												<?php
													endforeach;
												?>
											</select>
										
									</div>	

									<div class="form-group">									
											<label class="control-label">Select Type: &nbsp;</label>
											<select name="etype" id="etype" class="form-control">
												<option value="1">Chapter 1</option>
												<option value="2">Chapter 2</option>
												<option value="3">Chapter 3</option>
												<option value="4">ECE</option>
											</select>
										
									</div>
								</div>
								<div style="width:500px; margin: 0px auto;">
									<h4>Export Excel</h4>
									<button type="button" id="summery" class="btn btn-primary btn-lg"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Summary Exl</button>

									<button type="button" id="pass" class="btn btn-success btn-lg"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Pass Exl</button>

									<button type="button" id="fail" class="btn btn-danger btn-lg"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Fail</button>

									<hr>
									<h4>Export PDF</h4>
									
									<button type="button" id="summerypdf" class="btn btn-primary btn-lg"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Summary PDF</button>

									<button type="button" id="passpdf" class="btn btn-success btn-lg"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pass Pdf</button>

									<button type="button" id="failpdf" class="btn btn-danger btn-lg"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Fail</button>
								</div>
								
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
		</div>
		<!-- end #content -->
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on('click', '#summery', function(){
					var bid = $('#batch').val();
					var type = $('#etype').val();
					window.location.href = baseUrl+'coordinator/results/result_summery/'+bid+'/'+type;					
				});
				$(document).on('click', '#pass', function(){
					var bid = $('#batch').val();
					var type = $('#etype').val();

					window.location.href = baseUrl+'coordinator/results/result_pass/'+bid+'/'+type;					
				});
				$(document).on('click', '#fail', function(){
					var bid = $('#batch').val();
					var type = $('#etype').val();
					window.location.href = baseUrl+'coordinator/results/result_fail/'+bid+'/'+type;					
				});
				
				$(document).on('click', '#summerypdf', function(){
					var bid = $('#batch').val();
					var type = $('#etype').val();
					window.location.href = baseUrl+'coordinator/results/result_summery_pdf/'+bid+'/'+type;					
				});

				$(document).on('click', '#passpdf', function(){
					var bid = $('#batch').val();
					var type = $('#etype').val();
					window.location.href = baseUrl+'coordinator/results/result_pass_pdf/'+bid+'/'+type;					
				});

				$(document).on('click', '#failpdf', function(){
					var bid = $('#batch').val();
					var type = $('#etype').val();
					window.location.href = baseUrl+'coordinator/results/result_fail_pdf/'+bid+'/'+type;					
				});

				$(document).on('click', '#examdate', function(){
					/*var bid = $('#batch').val();
					var type = $('#etype').val();*/
					window.location.href = baseUrl+'coordinator/results/examdate';					
				});
			});
		</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>