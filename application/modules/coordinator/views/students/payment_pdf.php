<?php 
	$paidonlin = 0;
	$paidbank = 0;
	foreach($get_items as $itemcount){
		$onlinepayc = $this->Students_model->get_onlinepayment_info($itemcount['student_entryid']);
		$bankpayc = $this->Students_model->get_depositpayment_info($itemcount['student_entryid']);

		if(!empty($onlinepayc)){
			$paidonlin = $paidonlin + 1;
		}
		if(!empty($bankpayc)){
			$paidbank = $paidbank + 1;
		}
	}

?>

<h2 style="text-align: center;">IBRAHIM CARDIAC HOSPITAL & RESEARCH INSTITUTE</h2>
<h4 style="text-align: center;">122, Kazi Nazrul Islam Avenue, Shahbag, Dhaka–1000, Bangladesh</h4>
<h3 style="text-align: center;">CCVDE-DLP</h3>
<h3 style="text-align: center;">Payment Status of <?php echo $batchname; ?> Batch</h3>

<h4 style="text-align: center;">
	Total Applicants = <?php echo count($get_items) + count($get_applicant);?> <br>
	Short List = <?php echo count($get_items);?>
</h4>
<h4 style="text-align: center;">
	Online: <?php echo $paidonlin; ?> &nbsp; &nbsp; &nbsp; &nbsp;
	Bank: <?php echo $paidbank; ?>
	
</h4>
<h4 style="text-align: center;">
	Paid = <?php echo count($get_pay);?> &nbsp; &nbsp; &nbsp; &nbsp;
    Unpaid: <?php echo count($get_items) - count($get_pay); ?>
</h4>
<table border="1">
	<thead>
		
		

		<tr>
			<th nowrap>SL</th>
			<th nowrap>ID</th>
			<th class="text-center">Full Name</th>
			<th class="text-center">Phone No.</th>
			<th class="text-center">Email</th>
			<th class="text-center">Apply Date</th>
			<th class="text-center">Aprove Date</th>
			<th class="text-center">BM & DC No</th>
			<th class="text-center">Payment</th>
			<th class="text-center">Payment Mode</th>
			<th class="text-center">Transaction Id</th>
			<th class="text-center">Payment Date</th>
			<th class="text-center">Remarks</th>
		</tr>										
	</thead>
	<tbody>
		<?php
		$sl = 1;
										if(count($get_items) !== 0):
											foreach($get_items as $item):
											$photo = base_url('attachments/students/'.$item['spinfo_photo']);
											/*$photo = base_url('attachments/students/'.$item['student_entryid'].'/'.$item['spinfo_photo']);*/
											if($item['spinfo_middle_name'])
											{
												$full_name = $item['spinfo_first_name'].' '.$item['spinfo_middle_name'].' '.$item['spinfo_last_name'];
											}else
											{
												$full_name = $item['spinfo_first_name'].' '.$item['spinfo_last_name'];
											}
											if ($item['spinfo_gender'] == 0) {
												$gndr = 'Male';
											}else{
												$gndr = 'Female';
											}
										?>
										<tr class="items-row-<?php echo $item['student_id']; ?>">
											<td><?php echo $sl;?></td>
											<td><?php echo $item['student_entryid']; ?></td>
											
											<td class="text-center"><?php echo $full_name; ?></td>	
											
											<td class="text-center"><?php echo $item['spinfo_personal_phone']; ?></td>
											<td class="text-center"><?php echo $item['student_email']; ?></td>	
											<td class="text-center"><?php echo $item['student_regdate']; ?></td>
											<td class="text-center"><?php echo $item['student_approve_date']; ?></td>
											<td class="text-center"><?php echo $item['spsinfo_bmanddc_number']; ?></td>

											<?php $onlinepay = $this->Students_model->get_onlinepayment_info($item['student_entryid']);
										$bankpay = $this->Students_model->get_depositpayment_info($item['student_entryid']);
										if(!empty($onlinepay)){
											echo '<td><strong style="color:#0a0">Paid</strong></td><td><strong style="color:#0a0">Online</strong></td><td><strong style="color:#0a0">'.$onlinepay->onpay_transaction_id.'</strong></td><td class="text-center">'.$onlinepay->onpay_transaction_date.'</td>';
										}elseif (!empty($bankpay)) {
											echo '<td><strong style="color:#0a0">Paid</strong></td><td><strong style="color:#0a0">Bank</strong></td><td><strong style="color:#0a0">Bank</strong></td><td class="text-center">'.$bankpay->deposit_submit_date.'</td>';
										}else{
											$date1=date_create($item['student_approve_date']);
											$date2=date_create(date("Y-m-d"));
											$diff=date_diff($date1,$date2);
											$difdate = $diff->format("%a");
											if ($difdate > 7) {
												/*echo '<td class="text-center"><strong style="color:red">Unpaid</strong><br>Payment Time Over</td>';*/
												echo '<td class="text-center"><strong style="color:red">Unpaid</strong></td><td><strong style="color:red"></strong></td><td><strong style="color:#0a0"></strong></td><td class="text-center"><strong style="color:red">Unpaid</strong></td>';
											}else{
												echo '<td class="text-center"><strong style="color:red">Unpaid</strong></td><td><strong style="color:#0a0"></strong></td><td><strong style="color:#0a0"></strong></td><td class="text-center"><strong style="color:red">Unpaid</strong></td>';
											}
											
										}?>
										<td class="text-center"></td>	
										
		</tr>
		<?php $sl++; endforeach; ?>
		<?php else: ?>
		<tr>
			<td colspan="6"><span class="not-data-found">No Data Found!</span></td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>