<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=panding_students".$batchname.".xls");
?>

<table border="1">
	<thead>
		<tr>
			<th class="text-center" style="font-size: 26px; padding: 15px 0px" colspan="23">IBRAHIM CARDIAC HOSPITAL & RESEARCH INSTITUTE</th>
		</tr>
		<tr>
			<th class="text-center" style="font-size: 16px" colspan="23">122, Kazi Nazrul Islam Avenue, Shahbag, Dhaka &#8208; 1000, Bangladesh</th>
		</tr>
		<tr>
			<th class="text-center" style="font-size: 22px" colspan="23">CCVDE-DLP</th>
		</tr>
		<tr>
			<th class="text-center" style="font-size: 20px" colspan="23">Applicant List for <?php echo $batchname; ?> Batch</th>
		</tr>
		<tr  border="0">
			<th class="text-center" style="font-size: 20px; text-align: left;" colspan="23">Total Applicants = <?php echo count($get_items);?></th>
		</tr>

		<tr>
			<th class="text-center">SL</th>
			<th class="text-center">Batch</th>
			<th nowrap>Student ID</th>
			<th class="text-center">Full Name</th>
			<th class="text-center">Gender</th>
			<th class="text-center">Date of Birth</th>
			<th class="text-center">Contact Email</th>
			<th class="text-center">Mobile Number</th>
			<th class="text-center">BM & DC Number</th>
			<th class="text-center">Designation</th>
			<th class="text-center">Organization</th>
			<th class="text-center">Address of organization</th>
			<th class="text-center">Types of practice</th>
			<th class="text-center">Years since passing MBBS</th>
			<th class="text-center">Years of experience</th>
			<th class="text-center">Specialization</th>
			<th class="text-center">Registration Date</th>
			<th class="text-center">SSC Passing Year</th>
			<th class="text-center">SSC Marks/CGPA</th>
			<th class="text-center">HSC Passing Year</th>
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
			<td><?php echo $item['batch_name'];?></td>
			<td><?php echo $item['student_entryid']; ?></td>
			<td class="text-center"><?php echo $full_name; ?></td>
			<td><?php echo $gndr; ?></td>
			<td><?php echo $item['spinfo_birth_date']; ?></td>
			<td><?php echo $item['student_email']; ?></td>
			<td><?php echo $item['spinfo_personal_phone']; ?></td>
			<td><?php echo $item['spsinfo_bmanddc_number']; ?></td>
			<td><?php echo $item['spsinfo_designation']; ?></td>
			<td><?php echo $item['spsinfo_organization']; ?></td>
			<td><?php echo $item['spsinfo_organization_address']; ?></td>
			<td><?php echo $item['spsinfo_typeof_practice']; ?></td>
			<td><?php echo $item['spsinfo_sinceyear_mbbs']; ?></td>
			<td><?php echo $item['spsinfo_experience']; ?></td>

			<td><?php $spinfo = $this->Students_model->getStudentSpe($item['student_id']);
			foreach($spinfo as $sp){
				echo $sp->specialize_name.',';
			}?></td>
			<td><?php echo $item['student_regdate']; ?></td>
			<?php $academyinfo = $this->Students_model->getStudentAcademy($item['student_id']);
			foreach($academyinfo as $acinfo){?>
			<td><?php echo $acinfo->sacinfo_year;?></td>
			<td><?php echo $acinfo->sacinfo_cgpa;?></td>
			<?php }?>

			
											
		</tr>
		<?php $sl++; endforeach; ?>
		<?php else: ?>
		<tr>
			<td colspan="6"><span class="not-data-found">No Data Found!</span></td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>