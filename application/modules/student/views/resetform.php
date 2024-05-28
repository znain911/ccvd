<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="container dlp-login">
        <div class="row justify-content-md-center">
          <div class="col-lg-6">
            <div class="card card-hero card-primary">
              <div class="card-body">
                <h1 class="color-primary text-center">New Password</h1>
                <?php 
					$attr = array('class' => 'form-horizontal', 'id' => 'newPassSet');
					echo form_open('', $attr);
				?>
                  <div id="alert"></div>
				  <fieldset>
                    <div class="form-group row">
                      <label class="col-md-3 control-label">Enter New Password</label>
                      <div class="col-md-9">
                        <input type="password" name="password" class="form-control" id="newPassword" placeholder="New password"> </div>
                    </div>
					<div class="form-group row">
                      <label class="col-md-3 control-label">Confirm Password</label>
                      <div class="col-md-9">
                        <input type="password" name="password_confirm" class="form-control" placeholder="Confirm password"> </div>
                    </div>
                  </fieldset>
                  <button class="btn btn-raised btn-primary btn-block" type="submit">Update Password
                    <i class="zmdi zmdi-long-arrow-right no-mr ml-1"></i>
                  </button>
				  <p class="p-forget-pass"><a href="<?php echo base_url('student/login'); ?>"><strong>Back to login.</strong></a></p>
                <?php echo form_close(); ?>
              </div>
            </div>
          </div>
        </div>
    </div>
    <!-- container -->
<?php require_once APPPATH.'modules/common/footer.php'; ?>