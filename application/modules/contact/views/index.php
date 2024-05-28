<?php require_once APPPATH.'modules/common/header.php'; ?>
      <div class="container">
		<div style="padding-top:50px;"></div>
        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="" style="background-color:#83C9EB !important;">
                <h3 class="color-white index-1 text-center pb-2 pt-2 no-mb no-mt">Contact Us</h3>
              </div>
              <div class="card-body">
				<div id="alert"></div>
                <?php 
					$attr = array('id' => 'mainContactForm');
					$ticket = $this->Contact_model->get_ticket();
					echo form_open('', $attr);
				?>
				  <div id="scheduleLoader"><img src="<?php echo base_url('frontend/exam/tools/loader.gif'); ?>" /></div>
                  <div class="form-group label-floating">
                    <label class="control-label">Ticket</label>
                    <input type="text" class="form-control" value="<?php echo date("dmY").str_pad($ticket, 4, '0', STR_PAD_LEFT);?>" disabled /> 
                    <input type="hidden" class="form-control" name="application_ID" value="<?php echo date("dmY").str_pad($ticket, 4, '0', STR_PAD_LEFT);?>"> 
				  </div>
				  <div class="form-group label-floating">
                    <label class="control-label">Name</label>
                    <input type="text" class="form-control" name="name"> 
				  </div>
				  <div class="row">
					<div class="col-lg-6">
						<div class="form-group label-floating">
							<label for="inputEmail" class="control-label">Email</label>
							<input type="text" class="form-control" name="email"> 
						 </div>
					</div>
					<div class="col-lg-6">
						<div class="form-group label-floating">
							<label for="inputEmail" class="control-label">Phone</label>
							<input type="text" class="form-control" name="phone"> 
						 </div>
					</div>
				  </div>
                  <div class="form-group label-floating">
                    <label for="inputSubject" class="control-label">Subject</label>
                    <input type="text" class="form-control" name="subject"> </div>
                  <div class="form-group label-floating">
                    <label for="textArea" class="control-label">Message</label>
                    <textarea class="form-control" name="description" rows="5" id="textArea"></textarea>
                  </div>
                  <div class="form-group text-right">
                    <button type="reset" class="btn btn-primary btn-raised">Reset</button>
                    <button type="submit" class="btn btn-raised btn-primary">Submit</button>
                  </div>
                <?php echo form_close(); ?>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
			<?php 
				$get_contactinfo = $this->Contact_model->contact_infos();
			?>
            <div class="card card-primary">
              <div class="" style="background-color:#83C9EB !important;">
                <h3 class="color-white index-1 text-center pb-2 pt-2 no-mb no-mt">Contact info</h3>
              </div>
              <div class="card-body">
                <address class="no-mb">
                  <p><i class="color-danger-light zmdi zmdi-pin mr-1"></i> <?php echo $get_contactinfo['config_address']; ?></p>
                  <p>
                    <i class="color-info-light zmdi zmdi-email mr-1"></i>
                    <a href="mailto:<?php echo $get_contactinfo['config_email']; ?>"><?php echo $get_contactinfo['config_email']; ?></a>
                  </p>
                  <p>
                    <i class="color-royal-light zmdi zmdi-phone mr-1"></i>+<?php echo $get_contactinfo['config_phone']; ?> </p>
                </address>
              </div>
            </div>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="zmdi zmdi-map"></i>Map</h3>
              </div>
			  <?php echo $get_contactinfo['config_google_map']; ?>
			</div>
          </div>
        </div>
      </div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>