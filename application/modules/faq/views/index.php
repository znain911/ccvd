<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="">
        <div class="container">
          <div class="text-center">
            <div style="padding-top:50px;"></div>
            <h1 class="no-m" style="">Frequently Asked Questions</h1>
          </div>
        </div>
      </div>
      <div class="container margin-btm-50">
        <div class="row">
          <div class="col-lg-12 faqs-bootstrap">
            <div class="panel-group" style="padding-top:30px;" id="accordion" role="tablist" aria-multiselectable="true">
				
				<?php 
					$get_faqs = $this->Faqs_model->get_all_faqs();
					$inc = 1;
					foreach($get_faqs as $faq):
				?>
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="heading<?php echo $inc; ?>">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $inc; ?>" aria-expanded="true" aria-controls="collapseOne">
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
				<?php 
				$inc++;
				endforeach; ?>
				
			</div><!-- panel-group -->
          </div>
        </div>
      </div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>