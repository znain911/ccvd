<?php 
	$programmes = $this->Course_model->my_ece_programmes();
	foreach($programmes as $programme):
?>
<tr>
	<td class="text-left"><?php echo $programme['booking_application_id']; ?></td>
	<td class="text-center"><?php echo $programme['endmschedule_title']; ?></td>
	<td class="text-center"><?php echo $programme['center_location']; ?></td>
	<td class="text-center"><?php echo date("d F, Y", strtotime($programme['centerschdl_to_date'])).' '.$programme['centerschdl_to_time']; ?></td>
</tr>
<?php endforeach; ?>