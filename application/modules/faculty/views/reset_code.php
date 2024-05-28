<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="container dlp-login">
        <div class="row justify-content-md-center">
          <div class="col-lg-6">
            <div class="card card-hero card-primary">
              <div class="card-body">
                <h1 class="color-primary text-center">Reset Code</h1>
                <?php 
					$attr = array('class' => 'form-horizontal', 'id' => 'restFrmTeacher');
					echo form_open('', $attr);
				?>
                  <div id="alert"><div class="alert alert-success">We have sent you an email with reset code.</div></div>
				  <fieldset>
                    <div class="form-group row">
                      <label class="col-md-3 control-label">Enter Reset Code</label>
                      <div class="col-md-9">
                        <input type="text" name="resetcd" class="form-control" placeholder="Enter reset code"> 
					  </div>
                    </div>
                  </fieldset>
                  <button class="btn btn-raised btn-primary btn-block" type="submit">Submit Reset Code
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