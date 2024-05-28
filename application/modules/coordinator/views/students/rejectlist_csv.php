<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=reject_students.xls");
?>

<table border="1">
	<thead>
		<tr>
			<th nowrap>#ID</th>
											<th class="text-center">Photo</th>
											<th class="text-center">Full Name</th>
											<th class="text-center">Home District</th>
											<th class="text-center">Present District</th>
											<th class="text-center">BMDC No</th>
											<th class="text-center">Designation</th>
											<th class="text-center">SSC Year</th>
											<th class="text-center">HSC Year</th>
											<th class="text-center">Note</th>
		</tr>										
	</thead>
	<tbody>
		<?php
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
										?>
										<tr class="items-row-<?php echo $item['student_id']; ?>">
											<td><?php echo $item['student_entryid']; ?></td>
											<?php if($item['spinfo_photo']): ?>
											<td class="text-center"><img src="<?php echo $photo; ?>" width="40" alt="Photo"></td>
											<?php else: ?>
											<td class="text-center"><img src="<?php echo base_url('backend/'); ?>assets/img/user_1.jpg" width="20" class="rounded-corner" alt=""></td>
											<?php endif; ?>
											<td class="text-center"><?php echo $full_name; ?></td>											
											<td class="text-center"><?php echo $item['pdis']; ?></td>
											<td class="text-center"><?php echo $item['name']; ?></td>
											<td class="text-center"><?php echo $item['spsinfo_bmanddc_number']; ?></td>
											<td class="text-center"><?php echo $item['spsinfo_designation']; ?></td>
											<?php $academyinfo = $this->Students_model->getStudentAcademyList($item['student_id']);
											if(!empty($academyinfo)){
			foreach($academyinfo as $acinfo){?>
			<td><?php echo $acinfo->sacinfo_year;?></td>
				<?php } }else{?>
					<td></td>
					<td></td>
				<?php }?>
			
					<td class="text-center"><?php echo $item['student_note']; ?></td>						
		</tr>
		<?php endforeach; ?>
		<?php else: ?>
		<tr>
			<td colspan="6"><span class="not-data-found">No Data Found!</span></td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>