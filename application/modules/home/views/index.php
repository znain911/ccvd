<?php require_once APPPATH.'modules/common/header.php'; ?>
	<?php $get_banner = $this->Common_model->get_option_banners(); ?>
	<div class="dlp-main-banner banner-orgns">
		<div class="left-portion-box">
			<div class="left-portion-top-container">
				<div class="banner-left-top">
					<a href=""><img src="<?php echo base_url('attachments/').$get_banner['option_one']; ?>" /></a>
					<!-- <a href=""><img src="<?php echo attachment_url($get_banner['option_one']); ?>" /></a> -->
				</div>
			</div>
		</div>
		<div class="right-portion-box">
			<div class="left-portion-bottom-container">
				<!-- <div class="banner-left-bottom-left"><a href=""><img src="<?php echo attachment_url($get_banner['option_two']); ?>" /></a></div>
				<div class="banner-left-bottom-right"><a href=""><img src="<?php echo attachment_url($get_banner['option_three']); ?>" /></a></div> -->


				<div class="banner-left-bottom-left"><a href=""><img src="<?php echo base_url('attachments/').$get_banner['option_two']; ?>" /></a></div>
				<div class="banner-left-bottom-right"><a href=""><img src="<?php echo base_url('attachments/').$get_banner['option_three']; ?>" /></a></div>


			</div>
		</div>
	</div>
	<div class="dlp-main-banner">
		<div class="left-portion-box">
			<div class="left-portion-top-container">
				<div class="banner-left-top">
					<a href=""><img src="<?php echo base_url('attachments/').$get_banner['option_four']; ?>" /></a>
				</div>
			</div>
			<div class="left-portion-bottom-container">
				<!--<div class="banner-left-bottom-left"><a href=""><img src="<?php echo base_url('attachments/').$get_banner['option_five']; ?>" /></a></div>
				<div class="banner-left-bottom-right"><a href=""><img src="<?php echo base_url('attachments/').$get_banner['option_six']; ?>" /></a></div>-->
				<a href=""><img src="<?php echo base_url('attachments/'); ?>2024-02-15 at 12.52.40.jpeg" /></a>
			</div>
		</div>
		<div class="right-portion-box">
			<div class="banner-right-portion" style="color: #ffffff!important;">
				<h3>ONLINE CCVD</h3>
				<div class="single-post set-position-relative">
					<p><a href="<?php echo base_url('page/about-ccvd'); ?>" style="color: #ffffff!important;">About CCVD</a></p>
					<p><?php echo $this->Common_model->short_descby_slug('about-ccvd'); ?></p>
					<a href="<?php echo base_url('page/about-ccvd'); ?>" class="read-more" style="color: #ffffff!important;">Read More <i class="fa fa-angle-double-right"></i></a>
				</div>
				<div class="single-post set-position-relative">
					<p><a href="<?php echo base_url('page/benifits'); ?>" style="color: #ffffff!important;">Online CCVD & Its benifits</a></p>
					<p><?php echo $this->Common_model->short_descby_slug('benifits'); ?></p>
					<a href="<?php echo base_url('page/benifits'); ?>" class="read-more" style="color: #ffffff!important;">Read More <i class="fa fa-angle-double-right"></i></a>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		
			<div class="row">
				<?php 
					$videos = $this->Home_model->get_video();
					foreach($videos as $vlist):
				?>
				<div class="col-lg-4">
					<iframe width="100%" height="200px" src="<?php echo $vlist->link; ?>"></iframe>
				</div>
				<?php endforeach; ?>
			</div>
		
	</div>

	<div class="dlp-home-container-head">
		<div class="row">
			<div class="col-lg-12">
				<h3 class="dlp-home-h3">DLP Organogram</h3>
			</div>
		</div>
	</div>
	<div class="dlp-management">
		<div class="">
			<div class="row">
				<?php 
					$organograms = $this->Home_model->get_dlp_organogramsnew();
					foreach($organograms as $organogram):
				?>
				<div class="col-lg-4">
					<div class="single-management">
						<div class="management-photo">
							<?php 
								if($organogram['owner_photo']):
							?>
							<!-- <img src="<?php echo attachment_url('coordinators/'.$organogram['owner_photo']); ?>"/> -->
							<img src="<?php echo base_url('attachments/coordinators/'.$organogram['owner_photo']); ?>"/>

							<?php else: ?>
							<img src="<?php echo base_url('backend/assets/tools/no_image.png'); ?>"/>
							<?php endif; ?>
						</div>
						<p class="management-name"><strong><?php echo $organogram['owner_name']; ?></strong></p>
						<p class="management-designation"><?php echo $organogram['owner_designation']; ?></p>
						<p class="management-designation"><?php echo $organogram['owner_designation2']; ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="dlp-home-container-head">
		<div class="row">
			<div class="col-lg-12">
				<h3 class="dlp-home-h3">Academic Adviser</h3>
			</div>
		</div>
	</div>
	<div class="dlp-management">
		<div class="">
			<div class="row">
				<?php 
					$acdmadv = $this->Home_model->get_dlp_acd_adviser();
					foreach($acdmadv as $organogram3):
				?>
				<div class="col-lg-4">
					<div class="single-management">
						<div class="management-photo">
							<?php 
								if($organogram3['owner_photo']):
							?>
							
							<img src="<?php echo base_url('attachments/coordinators/'.$organogram3['owner_photo']); ?>"/>

							<?php else: ?>
							<img src="<?php echo base_url('backend/assets/tools/no_image.png'); ?>"/>
							<?php endif; ?>
						</div>
						<p class="management-name"><strong><?php echo $organogram3['owner_name']; ?></strong></p>
						<p class="management-designation"><?php echo $organogram3['owner_designation']; ?></p>
						<p class="management-designation"><?php echo $organogram3['owner_designation2']; ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>


	<div class="dlp-home-container-head">
		<div class="row">
			<div class="col-lg-12">
				<h3 class="dlp-home-h3">Technical Team</h3>
			</div>
		</div>
	</div>
	<div class="dlp-management">
		<div class="">
			<div class="row">
				<?php 
					$techadv = $this->Home_model->get_dlp_tech_adviser();
					foreach($techadv as $organogram2):
				?>
				<div class="col-lg-4">
					<div class="single-management">
						<div class="management-photo">
							<?php 
								if($organogram2['owner_photo']):
							?>
							<!-- <img src="<?php echo attachment_url('coordinators/'.$organogram2['owner_photo']); ?>"/> -->
							<img src="<?php echo base_url('attachments/coordinators/'.$organogram2['owner_photo']); ?>"/>

							<?php else: ?>
							<img src="<?php echo base_url('backend/assets/tools/no_image.png'); ?>"/>
							<?php endif; ?>
						</div>
						<p class="management-name"><strong><?php echo $organogram2['owner_name']; ?></strong></p>
						<p class="management-designation"><?php echo $organogram2['owner_designation']; ?></p>
						<p class="management-designation"><?php echo $organogram2['owner_designation2']; ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<div class="dlp-home-container-head">
		<div class="row">
			<div class="col-lg-12">
				<h3 class="dlp-home-h3">Course Coordinators</h3>
			</div>
		</div>
	</div>
	<!-- <div class="dlp-management">
		<div class="">
			<div class="row">
				<?php 
					$coordinators = $this->Common_model->get_coordinator();
					foreach($coordinators as $coordinator):
				?>
				<div class="col-lg-15">
					<div class="single-management">
						<div class="management-photo">
							<?php 
								if($coordinator['owner_photo']):
							?>
							
							<img src="<?php echo base_url('attachments/coordinators/'.$coordinator['owner_photo']); ?>"/>

							<?php else: ?>
							<img src="<?php echo base_url('backend/assets/tools/no_image.png'); ?>"/>
							<?php endif; ?>
						</div>
						<p class="management-name"><strong><?php echo $coordinator['owner_name']; ?></strong></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div> -->
	<div class="dlp-management">
		<div class="">
			<div class="row">
				<?php 
					$coursecoordinators = $this->Home_model->get_dlp_course_coordinators();
					foreach($coursecoordinators as $organogram6):
				?>
				<div class="col-lg-4">
					<div class="single-management">
						<div class="management-photo">
							<?php 
								if($organogram6['owner_photo']):
							?>
							
							<img src="<?php echo base_url('attachments/coordinators/'.$organogram6['owner_photo']); ?>"/>

							<?php else: ?>
							<img src="<?php echo base_url('backend/assets/tools/no_image.png'); ?>"/>
							<?php endif; ?>
						</div>
						<p class="management-name"><strong><?php echo $organogram6['owner_name']; ?></strong></p>
						<p class="management-designation"><?php echo $organogram6['owner_designation']; ?></p>
						<p class="management-designation"><?php echo $organogram6['owner_designation2']; ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>


	

	<div class="dlp-home-container-head">
		<div class="row">
			<div class="col-lg-12">
				<h3 class="dlp-home-h3">National Faculty </h3>
			</div>
		</div>
	</div>
	<div class="dlp-management">
		<div class="">
			<div class="row">
				<?php 
					$facultylist = $this->Home_model->get_dlp_faculty();
					foreach($facultylist as $organogram5):
				?>
				<div class="col-lg-4">
					<div class="single-management">
						<div class="management-photo">
							<?php 
								if($organogram5['owner_photo']):
							?>
							
							<img src="<?php echo base_url('attachments/coordinators/'.$organogram5['owner_photo']); ?>"/>

							<?php else: ?>
							<img src="<?php echo base_url('backend/assets/tools/no_image.png'); ?>"/>
							<?php endif; ?>
						</div>
						<p class="management-name"><strong><?php echo $organogram5['owner_name']; ?></strong></p>
						<p class="management-designation"><?php echo $organogram5['owner_designation']; ?></p>
						<p class="management-designation"><?php echo $organogram5['owner_designation2']; ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>


	<div class="dlp-home-container-head">
		<div class="row">
			<div class="col-lg-12">
				<h3 class="dlp-home-h3">International Faculty </h3>
			</div>
		</div>
	</div>
	<div class="dlp-management">
		<div class="">
			<div class="row">
				<?php 
					$intfacultylist = $this->Home_model->get_dlp_int_faculty();
					foreach($intfacultylist as $intfaculty):
				?>
				<div class="col-lg-4">
					<div class="single-management">
						<div class="management-photo">
							<?php 
								if($intfaculty['owner_photo']):
							?>
							
							<img src="<?php echo base_url('attachments/coordinators/'.$intfaculty['owner_photo']); ?>"/>

							<?php else: ?>
							<img src="<?php echo base_url('backend/assets/tools/no_image.png'); ?>"/>
							<?php endif; ?>
						</div>
						<p class="management-name"><strong><?php echo $intfaculty['owner_name']; ?></strong></p>
						<p class="management-designation"><?php echo $intfaculty['owner_designation']; ?></p>
						<p class="management-designation"><?php echo $intfaculty['owner_designation2']; ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="dlp-home-container-head">
		<div class="row">
			<div class="col-lg-12">
				<h3 class="dlp-home-h3">Administration</h3>
			</div>
		</div>
	</div>
	<div class="dlp-management">
		<div class="">
			<div class="row">
				<?php 
					$adminmember = $this->Home_model->get_dlp_admin();
					foreach($adminmember as $organogram4):
				?>
				<div class="col-lg-4">
					<div class="single-management">
						<div class="management-photo">
							<?php 
								if($organogram4['owner_photo']):
							?>
							
							<img src="<?php echo base_url('attachments/coordinators/'.$organogram4['owner_photo']); ?>"/>

							<?php else: ?>
							<img src="<?php echo base_url('backend/assets/tools/no_image.png'); ?>"/>
							<?php endif; ?>
						</div>
						<p class="management-name"><strong><?php echo $organogram4['owner_name']; ?></strong></p>
						<p class="management-designation"><?php echo $organogram4['owner_designation']; ?></p>
						<p class="management-designation"><?php echo $organogram4['owner_designation2']; ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<div class="dlp-home-container-head">
		<div class="row">
			<div class="col-lg-12">
				<h3 class="dlp-home-h3">Resource Person</h3>
			</div>
		</div>
	</div>

	<div class="dlp-management">
		<div class="">
			<div class="row">
				<?php 
					$resource_per = $this->Home_model->get_dlp_resource();
					foreach($resource_per as $organogram5):
				?>
				<div class="col-lg-4">
					<div class="single-management">
						<div class="management-photo">
							<?php 
								if($organogram5['owner_photo']):
							?>
							
							<img src="<?php echo base_url('attachments/coordinators/'.$organogram5['owner_photo']); ?>"/>

							<?php else: ?>
							<img src="<?php echo base_url('backend/assets/tools/no_image.png'); ?>"/>
							<?php endif; ?>
						</div>
						<p class="management-name"><strong><?php echo $organogram5['owner_name']; ?></strong></p>
						<p class="management-designation"><?php echo $organogram5['owner_designation']; ?></p>
						<p class="management-designation"><?php echo $organogram5['owner_designation2']; ?></p>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="dlp-home-container-head" id="landingFaqs">
		<div class="row">
			<div class="col-lg-12">
				<h3 class="dlp-home-h3">FAQS</h3>
			</div>
		</div>
	</div>
	<div class="home-faq-containers">
		<div class="row">
			<div class="col-lg-4 text-center" style="padding:0">
				<div class="home-faq-title">Website FAQS</div>
			</div>
			<div class="col-lg-4 text-center" style="padding:0">
				<div class="home-faq-title">Students FAQS</div>
			</div>
			<div class="col-lg-4 text-center" style="padding:0">
				<div class="home-faq-title">Faculties FAQS</div>
			</div>
		</div>
	</div>
	<div class="home-faq-content-containers">
		<div class="row">
			<div class="col-lg-4">
				
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<?php 
						$get_faqs = $this->Faqs_model->get_all_faqs();
						foreach($get_faqs as $faq1):
						$inc1 = $faq1['faq_id'];
					?>
			        <div class="panel panel-default">
			            <div class="panel-heading" role="tab" id="heading<?php echo $inc1; ?>">
			                <h4 class="panel-title">
			                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $inc1; ?>" aria-expanded="true" aria-controls="collapse<?php echo $inc1; ?>" style="display: block;">
			                        <i class="more-less glyphicon glyphicon-plus"></i>
			                        <?php echo $faq1['faq_title']; ?>
			                    </a>
			                </h4>
			            </div>
			            <div id="collapse<?php echo $inc1; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $inc1; ?>">
			                <div class="panel-body">
			                      <?php echo $faq1['faq_description']; ?>
			                </div>
			            </div>
			        </div>
			    	<?php endforeach; ?>
			    </div><!-- panel-group -->

			</div>
			<div class="col-lg-4">
				
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<?php 
						$get_faqs = $this->Faqs_model->get_all_faqs('Student');
						foreach($get_faqs as $faq2):
						$inc2 = $faq2['faq_id'];
					?>
			        <div class="panel panel-default">
			            <div class="panel-heading" role="tab" id="heading<?php echo $inc2; ?>">
			                <h4 class="panel-title">
			                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $inc2; ?>" aria-expanded="true" aria-controls="collapse<?php echo $inc2; ?>" style="display: block;">
			                        <i class="more-less glyphicon glyphicon-plus"></i>
			                        <?php echo $faq2['faq_title']; ?>
			                    </a>
			                </h4>
			            </div>
			            <div id="collapse<?php echo $inc2; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $inc2; ?>">
			                <div class="panel-body">
			                      <?php echo $faq2['faq_description']; ?>
			                </div>
			            </div>
			        </div>
			    	<?php endforeach; ?>
			    </div><!-- panel-group -->
			</div>
			<div class="col-lg-4">
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<?php 
						$get_faqs = $this->Faqs_model->get_all_faqs('Faculty');
						foreach($get_faqs as $faq):
						$inc = $faq['faq_id'];
					?>
			        <div class="panel panel-default">
			            <div class="panel-heading" role="tab" id="heading<?php echo $inc; ?>">
			                <h4 class="panel-title">
			                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $inc; ?>" aria-expanded="true" aria-controls="collapse<?php echo $inc; ?>" style="display: block;">
			                        <i class="more-less glyphicon glyphicon-plus"></i>
			                        <?php echo $faq['faq_title']; ?>
			                    </a>
			                </h4>
			            </div>
			            <div id="collapse<?php echo $inc; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $inc; ?>">
			                <div class="panel-body">
			                      <?php echo $faq['faq_description']; ?>
			                </div>
			            </div>
			        </div>
			    	<?php endforeach; ?>
			    </div><!-- panel-group -->
			</div>
		</div>
	</div>
	
	
	<!--<div class="modal fade bs-example-modal-sm" id = "myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
			<div class="modal-dialog modal-sm" style = "    display: flex;justify-content: center;margin-top: 10%;">
				<img src="<?php echo base_url('attachments/'); ?>DLP-CCVD-EID-Banner-V-2-2023.png" alt="Girl in a jacket" width="800" height="500">
			</div>
		</div>-->
		
	<script type="text/javascript">
		// $(document).ready(function(){
			// $('#myModal').modal('show');
			// setTimeout(function(){ $('#myModal').modal('hide')}, 5000);
		// });
	</script>

<?php require_once APPPATH.'modules/common/footer.php'; ?>