<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/student/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9">
					<div class="result-crtft-cgp-panel">
						<h4 class="rslt-cgp-title">PAYMENT DETAILS</h4>
						<div class="row">
							<div class="col-lg-4"></div>
							<div class="col-lg-8 text-right">
								<div class="download-crtft-button pay-now">
									<strong>Pay Now</strong>
								</div>
								<div class="pay-now">
									<strong>or</strong>
								</div>
								<div class="download-crtft-button deposit-slip">
									<strong>Upload Deposit Slip</strong>
								</div>
							</div>
						</div>
					</div>
					<div class="result-table">
						<div class="tabbable-panel">
							<div class="tabbable-line">
								<ul class="nav std-payment-tb nav-tabs">
									<li class="active">
										<a href="#tab_default_1" data-toggle="tab" class="active">
										Online Payments </a>
									</li>
									<li>
										<a href="#tab_default_2" data-toggle="tab">
										Bank Deposit </a>
									</li>
								</ul>
								<div class="tab-content" id="paymentContents">
								<?php 
									$entryid = $this->Student_model->get_entryid();
									$online_payments = $this->Student_model->get_onlinepayment_info($entryid);
									$deposit_payments = $this->Student_model->get_depositpayment_info($entryid);
									
									$content = '
										<div class="tab-pane active" id="tab_default_1">
											<div class="near_by_hotel_wrapper">
												<div class="near_by_hotel_container">
												  <table class="table rslt-tbl-row no-border custom_table no-footer dtr-inline">
													<colgroup>
														<col width="20%">
														<col width="30%">
														<col width="20%">
														<col width="20%">
														<col width="10%">
													</colgroup>
													<thead>
													  <tr>
														<th>Payment</th>
														<th class="text-center">Transaction ID</th>
														<th class="text-center">Transaction Date</th>
														<th class="text-center">Amount</th>
														<th class="text-center">Status</th>
													  </tr>
													</thead>
													<tbody>
													';
													foreach($online_payments as $online):
														$content .= '<tr>';
															$content .= '<td>'.$online['onpay_account'].'</td>';
															$content .= '<td class="text-center">'.$online['onpay_transaction_id'].'</td>';
															$content .= '<td class="text-center">'.date("d F, Y", strtotime($online['onpay_transaction_date'])).'</td>';
															$content .= '<td class="text-center">BDT '.$online['onpay_transaction_amount'].'</td>';
															$content .= '<td class="text-center"><strong style="color:#0a0">Paid</strong></td>';
														$content .= '</tr>';
													endforeach;
													  
									$content .= '
													</tbody>
												  </table>
												</div>
											</div>
										</div>
										<div class="tab-pane" id="tab_default_2">
											<div class="near_by_hotel_wrapper">
												<div class="near_by_hotel_container">
												  <table class="table rslt-tbl-row no-border custom_table no-footer dtr-inline">
													<colgroup>
														<col width="10%">
														<col width="10%">
														<col width="20%">
														<col width="10%">
														<col width="10%">
														<col width="10%">
														<col width="20%">
													</colgroup>
													<thead>
													  <tr>
														<th>Payment</th>
														<th>Amount</th>
														<th>Bank</th>
														<th class="text-center">Branch</th>
														<th class="text-center">Account Number</th>
														<th class="text-center">Status</th>
														<th class="text-center">Deposit Slip</th>
													  </tr>
													</thead>
													<tbody>
													';
													foreach($deposit_payments as $deposit):
														$content .= '<tr>';
															$content .= '<td>'.$deposit['deposit_payment'].'</td>';
															$content .= '<td>BDT '.$deposit['deposit_amount'].'</td>';
															$content .= '<td>'.$deposit['deposit_bank'].'</td>';
															$content .= '<td class="text-center">'.$deposit['deposit_branch'].'</td>';
															$content .= '<td class="text-center">'.$deposit['deposit_account_number'].'</td>';
															if($deposit['deposit_slip_status'] === '0')
															{
																$content .= '<td class="text-center"><strong style="color:#0aa">Under Review</strong></td>';
															}elseif($deposit['deposit_slip_status'] === '1')
															{
																$content .= '<td class="text-center"><strong style="color:#0a0">Paid</strong></td>';
															}elseif($deposit['deposit_slip_status'] === '2')
															{
																$content .= '<td class="text-center"><strong style="color:#F00">Unpaid</strong></td>';
															}
															$content .= '<td class="text-center"><a href="'.attachment_url('students/'.$entryid.'/'.$deposit['deposit_slip_file']).'" target="_blank"><i class="fa fa-eye"></i> View</a></td>';
														$content .= '</tr>';
													endforeach;
										$content .= '
													</tbody>
												  </table>
												</div>
											</div>
										</div>
									';
									
									echo $content;
								?>
								
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>