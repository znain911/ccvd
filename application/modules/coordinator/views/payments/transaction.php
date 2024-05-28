<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Payments</a></li>
				<li><a href="javascript:;">SSL Commerz Transaction</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">SSL Commerz Transaction</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12">
					<!-- begin widget -->
					<div id="onPgaeLoadingForm"></div>
					<div class="widget p-0">
						<div class="table-responsive">
							<div id="postList">
								<table id="data-table" class="table table-td-valign-middle m-b-0">
									<thead>
										<tr>
											<th nowrap>SL.</th>
											<th nowrap>Student ID</th>
											<th nowrap>Name</th>
											<th nowrap>Payment For</th>
											<th nowrap>Payment Status</th>
											<th nowrap>Transaction ID</th>
											<th nowrap>Paid Amount</th>
											<th nowrap>Paid Date</th>
										</tr>
									</thead>
									<tbody>
										<?php  
											$get_payments = $this->Payments_model->get_payment_details('COURSE');
											$inc_sl = 1;
											foreach($get_payments as $payment):
											if($payment['spinfo_middle_name'])
											{
												$nameid = $payment['spinfo_first_name'].' '.$payment['spinfo_middle_name'].' '.$payment['spinfo_last_name'].' ('.$payment['student_entryid'].')';
											}else
											{
												$nameid = $payment['spinfo_first_name'].' '.$payment['spinfo_last_name'].' ('.$payment['student_entryid'].')';
											}
										?>
										<tr>
											<td><?php echo $inc_sl; ?></td>
											<td><?php echo $nameid; ?></td>
											<td><?php echo $payment['payment_type']; ?></td>
											<td><?php echo $payment['status']; ?></td>
											<td><?php echo $payment['transaction_id']; ?></td>
											<td><?php echo ($payment['amount'])? 'BDT '.$payment['amount']: null; ?></td>
											<td class="text-center">
												<?php
													$time = strtotime($item['paid_date']);
													$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
													echo $myFormatForView;
												?>
											</td>
										</tr>
										<?php 
											$inc_sl++;
											endforeach; 
										?>
									</tbody>
								</table>
								<div class="page-contr">
									
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
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>