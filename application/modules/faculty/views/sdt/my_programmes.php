<?php 
	$programmes = $this->Course_model->my_sdt_programmes();
	foreach($programmes as $programme):
	$phase_array = array('1' => 'PCA-1', '2' => 'PCA-2', '3' => 'PCA-3');
?>
<tr>
	<td class="text-left"><?php echo $programme['booking_application_id']; ?></td>
	<td class="text-center"><?php echo $programme['endmschedule_title']; ?></td>
	<td class="text-center"><?php echo $phase_array[$programme['booking_phase_level']]; ?></td>
	<td class="text-center"><?php echo $programme['center_location']; ?></td>
	<td class="text-center"><?php echo date("d F, Y", strtotime($programme['centerschdl_to_date'])).' '.$programme['centerschdl_to_time']; ?></td>
	<td class="text-center">
		<a href="<?php echo base_url('faculty/schedules/sdtmarks/?gt_cntr='.$programme['centerschdl_id'].'&sdl='.$programme['centerschdl_parentschdl_id'].'&TYPE=sdt-sess'); ?>"><span class="upmrks">Upload Marks</span></a>
	</td>
</tr>
<?php endforeach; ?>