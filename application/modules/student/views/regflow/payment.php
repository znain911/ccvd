<?php  
	$attr = array('id' => 'regStepFiveStudent', 'class' => 'position-relative');
	echo form_open('', $attr);
	
	$fee_info = $this->Registration_model->get_payment_config();
	$student_info = $this->Registration_model->student_basic_info(html_escape($_GET['SID']));
?>
<input type="hidden" name="SID" value="<?php echo (isset($_GET['PORT']))? $_GET['PORT'] : null; ?>" />
<input type="hidden" name="port" value="<?php echo (isset($_GET['SID']))? $_GET['SID'] : null; ?>" />
<input type="hidden" name="status" value="pay" />
<input type="hidden" name="rdr" value="online" />
<input type="hidden" name="confirm" value="1" />
<div class="loader disable-select" id="proccessLoader"><img src="<?php echo base_url('frontend/tools/loader.gif'); ?>" class="disable-select" alt="" /></div>
<?php
$paymnt = 1;
	if ($paymnt == 1) {
?>
<div class="payment-crsfee-focus">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="crs-fee-bx">
					<p class="crs-fee-dplay"><strong><?php echo $student_info['spinfo_first_name'].' '.$student_info['spinfo_middle_name'].' '.$student_info['spinfo_last_name']; ?> your course fee is : <?php echo ($fee_info['pconfig_course_fee'])? number_format($fee_info['pconfig_course_fee'],0) : null; ?> BDT</strong></p>
					<p>Upon payment you will receive a further SMS and Email. After processing your payment you will obtain your Student ID and be able to enroll in this course.</p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="std-payment-tabs">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 text-center">
				<div class="std-online-payment-tb">
					<h3 class="pmnt-tb-title">Online Payment</h3>
					<button type="submit" class="pay-to-online-btn">Pay Now</button>
					<div class="pay-with-tt">
						<img src="<?php echo base_url('frontend/tools/epw-payment-instrmnt.png'); ?>" alt="Payment Methods" />
					</div>
				</div>
				<!--<div class="crs-fee-bx">
					<p class="crs-fee-dplay"><strong> Due to some technical problem, we can't take MasterCard or VISA at present for online payment, but you can pay through our bKash number: 01313753319 or bank Account.We are sorry for this inconvenience.</strong></p>
				</div>
				<div class="std-online-payment-tb">
					<h3 class="pmnt-tb-title">Online Payment</h3>
					
					<div class="pay-with-tt-bank">
						<strong> Due to some technical problem, we can't take MasterCard or 
						VISA at present for online payment, but you 
						can pay through our bKash number: 01313753319 
						or bank Account.<br>We are sorry for this inconvenience.</strong>
					</div>
				</div>-->
			</div>
			<div class="col-lg-6 text-center">
				<div class="std-bank-payment-tb">
					<h3 class="pmnt-tb-title">Bank Payment</h3>
					<span class="pay-to-online-btn" data-target="#myModalDeposit" data-toggle="modal">Upload Deposit Slip</span>
					<div class="pay-with-tt-bank">
						<?php 
							$banks = $this->Registration_model->get_banks_details();
							foreach($banks as $bank):
							$photo = attachment_url('banks/'.$bank['bank_photo_icon']);
						?>
						<div class="bank-pay-details">
							<div class="bnk-logo">
								<img src="<?php echo $photo; ?>" alt="" />
							</div>
							<div class="bnk-details">
								<p><strong>Bank Name : </strong> <?php echo $bank['bank_name']; ?></p>
								<p><strong>Branch Name : </strong><?php echo $bank['bank_branch_name']; ?></p>
								<p><strong>Account Name : </strong> <?php echo $bank['bank_account_name']; ?></p>
								<p><strong>Account No : </strong><?php echo $bank['bank_account_number']; ?></p>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }else{?>
	<div class="payment-crsfee-focus">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="crs-fee-bx">
					<p class="crs-fee-dplay"><strong><?php echo $student_info['spinfo_first_name'].' '.$student_info['spinfo_middle_name'].' '.$student_info['spinfo_last_name']; ?> Your payment link is expire</strong></p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
<?php echo form_close(); ?>
