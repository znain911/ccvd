<?php require_once APPPATH.'modules/common/header.php'; ?>
	<?php 
		$item = $this->Teacher_model->get_teacher_info();
	?>
	<div class="course-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/faculty/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9">
					<div class="result-table myac-container">
						<p class="result-tbl-head"><strong>Personal Information</strong></p>
						<div class="student-details-board">
							<a href="<?php echo base_url('faculty/edit/personal'); ?>" class="std-editinfo btn btn-danger pull-right">Edit</a>
							<table style="width:100%">
								<tr>
									<td class="text-right" style="width:50%"><strong>Full Name : </strong></td>
									<td>
										<?php 
											if($item['tpinfo_middle_name'])
											{
												$full_name = $item['tpinfo_first_name'].' '.$item['tpinfo_middle_name'].' '.$item['tpinfo_last_name'];
											}else
											{
												$full_name = $item['tpinfo_first_name'].' '.$item['tpinfo_last_name'];
											}
										?>
										<?php echo $full_name; ?>
									</td>
								</tr>
								<tr>
									<td class="text-right"><strong>Birth Date : </strong></td>
									<td>
										<?php
											if($item['tpinfo_birth_date']):
												$time = strtotime($item['tpinfo_birth_date']);
												$myFormatForView = date("d M, Y", $time);
												echo $myFormatForView;
											endif;
										?>
									</td>
								</tr>
								<tr>
									<td class="text-right"><strong>Gender : </strong></td>
									<td>
										<?php
											$gender = array('0' => 'Male', '1' => 'Female', '2' => 'Other');
											echo $gender[$item['tpinfo_gender']];
										?>
									</td>
								</tr>
								<tr>
									<td class="text-right"><strong>Nationality : </strong></td>
									<td><?php echo $item['country_name']; ?></td>
								</tr>
								<tr>
									<td class="text-right"><strong>Recent Photo : </strong></td>
									<td>
										<img src="<?php echo base_url('attachments/faculties/'.$item['teacher_entryid'].'/'.$item['tpinfo_photo']); ?>" width="40" alt="" />
									</td>
								</tr>
								<tr>
									<td class="text-right"><strong>Father's/Mother's/Spouse's Name : </strong></td>
									<td><?php echo $item['tpinfo_fmorspouse_name']; ?></td>
								</tr>
								<tr>
									<td class="text-right"><strong>National ID : </strong></td>
									<td><?php echo $item['tpinfo_national_id']; ?></td>
								</tr>
								<tr>
									<td class="text-right"><strong>Contact Email : </strong></td>
									<td><?php echo $item['teacher_email']; ?></td>
								</tr>
								<tr>
									<td class="text-right"><strong>Mobile Number : </strong></td>
									<td><?php echo $item['tpinfo_personal_phone']; ?></td>
								</tr>
								<tr>
									<td class="text-right"><strong>Office Phone : </strong></td>
									<td><?php echo $item['tpinfo_office_phone']; ?></td>
								</tr>
								<tr>
									<td class="text-right"><strong>Home Phone : </strong></td>
									<td><?php echo $item['tpinfo_home_phone']; ?></td>
								</tr>
								<tr>
									<td class="text-right"><strong>Current Address : </strong></td>
									<td><?php echo $item['tpinfo_current_address']; ?></td>
								</tr>
								<tr>
									<td class="text-right"><strong>Permanent Address : </strong></td>
									<td><?php echo $item['tpinfo_permanent_address']; ?></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="result-table">
						<p class="result-tbl-head"><strong>Professional Information</strong></p>
						<div class="student-details-board">
							<a href="<?php echo base_url('faculty/edit/professional'); ?>" class="std-editinfo btn btn-danger pull-right">Edit</a>
							<table style="width:100%">
								<tr>
									<td class="text-right" style="width:50%"><strong>Designation : </strong></td>
									<td><?php echo $item['tpsinfo_designation']; ?></td>
								</tr>
								<tr>
									<td class="text-right"><strong>Organization : </strong></td>
									<td><?php echo $item['tpsinfo_organization']; ?></td>
								</tr>
								<tr>
									<td class="text-right"><strong>Address of organization : </strong></td>
									<td><?php echo $item['tpsinfo_organization_address']; ?></td>
								</tr>
								<tr>
									<td class="text-right"><strong>Specialization : </strong></td>
									<td>
										<?php 
											$get_specializations = $this->Teacher_model->get_specializations();
											$specialization = '';
											foreach($get_specializations as $row){
												if($row['ts_specilzation_has_other'] == '1')
												{
													if(end($get_specializations)['ts_specilzation_other'] == $row['ts_specilzation_other'])
													{
														$specialization .= $row['ts_specilzation_other'];
													}else
													{
														$specialization .= $row['ts_specilzation_other'].', ';
													}
												}else
												{
													$spz_name = $this->Teacher_model->get_specialization_name($row['ts_specilzation_id']);
													if(end($get_specializations)['ts_specilzation_id'] == $row['ts_specilzation_id'])
													{
														$specialization .= $spz_name;
													}else
													{
														$specialization .= $spz_name.', ';
														
													}
												}
											}
											echo $specialization;
										?>
									</td>
								</tr>
								<tr>
									<td class="text-right"><strong>BM&DC Number : </strong></td>
									<td><?php echo $item['tpsinfo_bmanddc_number']; ?></td>
								</tr>
								<tr>
									<td class="text-right"><strong>DLP Category : </strong></td>
									<td>
										<?php 
											$get_dlpcats = $this->Teacher_model->get_dlp_categories();
											$cats = '';
											foreach($get_dlpcats as $dlpcat){
												if(end($get_dlpcats)['category_name'] == $dlpcat['category_name'])
												{
													$cats .= $dlpcat['category_name'];
												}else
												{
													$cats .= $dlpcat['category_name'].', ';
												}
											}
											echo $cats;
										?>
									</td>
								</tr>
								<tr>
									<td class="text-right"><strong>Types of practice : </strong></td>
									<td><?php echo $item['tpsinfo_typeof_practice']; ?></td>
								</tr>
								<tr>
									<td class="text-right"><strong>Years since passing MBBS : </strong></td>
									<td><?php echo $item['tpsinfo_sinceyear_mbbs']; ?></td>
								</tr>
								<tr>
									<td class="text-right"><strong>Years of experience : </strong></td>
									<td><?php echo $item['tpsinfo_experience']; ?></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="result-table">
						<p class="result-tbl-head"><strong>Academic Information</strong></p>
						<div class="student-details-board">
							<a href="<?php echo base_url('faculty/edit/academic'); ?>" class="std-editinfo btn btn-danger pull-right">Edit</a>
							<table style="width:100%">
								<thead>
									<tr>
										<th>Degree</th>
										<th>Year</th>
										<th>Institue/University</th>
										<th>Marks/CGPA</th>
										<th>Certificate</th>
									</tr>
								</thead>
								<?php 
									$get_academicinfo = $this->Teacher_model->get_academicinformation();
									foreach($get_academicinfo as $academic){
								?>
								<tr>
									<td><?php echo $academic['tacinfo_degree']; ?></td>
									<td><?php echo $academic['tacinfo_year']; ?></td>
									<td><?php echo $academic['tacinfo_institute']; ?></td>
									<td><?php echo $academic['tacinfo_cgpa']; ?></td>
									<td><a href="<?php echo base_url('attachments/faculties/'.$item['teacher_entryid'].'/'.$academic['tacinfo_certificate']); ?>" target="_blank">View Certificate</a></td>
								</tr>
								<?php } ?>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>