<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="container dlp-login">
        <div class="row justify-content-md-center">
          <div class="col-lg-6">
            <div class="card card-hero card-primary">
              <div class="card-body">
                <h1 class="color-primary text-center">Reset Password</h1>
                <?php 
					$attr = array('class' => 'form-horizontal', 'id' => 'recoverform');
					echo form_open('', $attr);
				?>
                  <div id="alert"></div>
				  <fieldset>
                    <div class="form-group row">
                      <label for="inputEmail" class="col-md-3 control-label">Enter Email</label>
                      <div class="col-md-9">
                        <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email"> </div>
                    </div>
                  </fieldset>
                  <button class="btn btn-raised btn-primary btn-block" type="submit">Get Reset Code
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