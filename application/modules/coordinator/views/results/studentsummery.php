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
				<li><a href="javascript:;">Export Student Summery</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Student Summery</h1>
			
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
								</div>
								<div style="width:500px; margin: 0px auto;">
									<h4>Export Excel</h4>
									<button type="button" id="summery" class="btn btn-primary btn-lg"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Summary Exl</button>									
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
					/*var type = $('#etype').val();*/
					window.location.href = baseUrl+'coordinator/results/student_summery_exl/'+bid;					
				});				
			});
		</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>