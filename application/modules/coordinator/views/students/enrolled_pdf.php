<h2 style="text-align: center;">IBRAHIM CARDIAC HOSPITAL & RESEARCH INSTITUTE</h2>
<h4 style="text-align: center;">122, Kazi Nazrul Islam Avenue, Shahbag, Dhaka–1000, Bangladesh</h4>
<h3 style="text-align: center;">CCVDE-DLP</h3>
<h3 style="text-align: center;">Enrolled Status of <?php echo $batchname; ?> Batch</h3>
<h4 style="text-align: center;">Total Applicants = <?php echo count($get_items);?></h4>
<table border="1">
	<thead>
		
		<tr>
			<th nowrap>SL</th>
			<th nowrap>ID</th>
			<th class="text-center">Full Name</th>
			<th class="text-center">Gender</th>
			<th class="text-center">Date of Birth</th>
			<th class="text-center">Phone No.</th>
			<th class="text-center">Email</th>
			<th class="text-center">Apply Date</th>
			<th class="text-center">Aprove Date</th>
			<th class="text-center">BM & DC No</th>
			<th class="text-center">Payment Status</th>
			<th class="text-center">Payment Mode</th>
			<th class="text-center">Transaction Id</th>
			<th class="text-center">Payment Date</th>
			<th class="text-center">Batch</th>
			<th class="text-center">NID</th>
			<th class="text-center">Designation</th>
			<th class="text-center">Organization</th>
			<th class="text-center">Address of organization</th>
			<th class="text-center">Types of practice</th>
			<th class="text-center">Years since passing MBBS</th>
			<th class="text-center">Years of experience</th>
			<th class="text-center">Specialization</th>
			<!-- <th class="text-center">Home District</th>
			<th class="text-center">Present District</th> -->
			
			
			
			<th class="text-center">SSC Year</th>
			<th class="text-center">SSC Marks/CGPA</th>
			<th class="text-center">HSC Year</th>
			<th class="text-center">HSC Marks/CGPA</th>
			<th class="text-center">MBBS Passing Year</th>
			<th class="text-center">MBBS Marks/CGPA</th>
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
											<?php //if($item['spinfo_photo']): ?>
											<!-- <td class="text-center"><img src="<?php echo $photo; ?>" width="40" alt="Photo"></td> -->
											<?php //else: ?>
											<!-- <td class="text-center"><img src="<?php echo base_url('backend/'); ?>assets/img/user_1.jpg" width="20" class="rounded-corner" alt=""></td> -->
											<?php //endif; ?>
											<td class="text-center"><?php echo $full_name; ?></td>	
											<td><?php echo $gndr; ?></td>
											<td><?php echo $item['spinfo_birth_date']; ?></td>
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
											<td class="text-center"><?php echo $item['batch_name']; ?></td>
											<td class="text-center"><?php echo $item['spinfo_national_id']; ?></td>
											<td class="text-center"><?php echo $item['spsinfo_designation']; ?></td>
<td class="text-center"><?php echo $item['spsinfo_organization']; ?></td>
<td class="text-center"><?php echo $item['spsinfo_organization_address']; ?></td>
<td class="text-center"><?php echo $item['spsinfo_typeof_practice']; ?></td>
<td class="text-center"><?php echo $item['spsinfo_sinceyear_mbbs']; ?></td>
<td class="text-center"><?php echo $item['spsinfo_experience']; ?></td>
<td><?php $spinfo = $this->Students_model->getStudentSpe($item['student_id']);
			foreach($spinfo as $sp){
				echo $sp->specialize_name.',';
			}?></td>



											<!-- <td class="text-center"><?php echo $item['pdis']; ?></td>
											<td class="text-center"><?php echo $item['name']; ?></td> -->
											
											
											
											<?php $academyinfo = $this->Students_model->getStudentAcademyList($item['student_id']);
											if(!empty($academyinfo)){
			foreach($academyinfo as $acinfo){?>
			<td><?php echo $acinfo->sacinfo_year;?></td>
			<td><?php echo $acinfo->sacinfo_cgpa;?></td>
				<?php } }else{?>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				<?php }?>
										
		</tr>
		<?php endforeach; ?>
		<?php else: ?>
		<tr>
			<td colspan="6"><span class="not-data-found">No Data Found!</span></td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>