<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="container dlp-login">
        <div class="row justify-content-md-center">
          <div class="col-lg-6">
            <div class="card card-hero card-primary">
              <div class="card-body student-login">
				<div class="loader disable-select" id="proccessLoader"><img src="<?php echo base_url('frontend/tools/loader.gif'); ?>" class="disable-select" alt="" /></div>
                <h1 class="color-primary text-center">Student Login</h1>
				<div id="alert"></div>
				<?php 
					$attr = array('class' => 'form-horizontal', 'id' => 'studentLogin');
					echo form_open('', $attr);
				?>
                  <fieldset>
                    <div class="form-group row">
                      <label for="inputEmail" class="col-md-3 control-label">Email Or ID</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" id="inputEmail" name="email_or_id" placeholder="Email Or ID"> </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputPassword" class="col-md-3 control-label">Password</label>
                      <div class="col-md-9">
                        <input type="password" class="form-control" name="password" id="mainPass" placeholder="Password">
						<label class="pass-visibility-method"><input type="checkbox" onclick="displayMainPassword()"> Show password</label>
					  </div>
                    </div>
                  </fieldset>
                  <button class="btn btn-raised btn-primary btn-block">Login
                    <i class="zmdi zmdi-long-arrow-right no-mr ml-1"></i>
                  </button>
				  <p class="p-forget-pass"><a href="<?php echo base_url('student/login/forget'); ?>"><strong>Forget your password?</strong></a></p>
                <?php echo form_close(); ?>
              </div>
            </div>
          </div>
        </div>
    </div>
    <!-- container -->
<?php require_once APPPATH.'modules/common/footer.php'; ?>