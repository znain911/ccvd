<?php require_once APPPATH.'modules/common/header.php'; ?>
      <div class="page-container">
  <div class="container">
    
    <div class="row about-rows">
      <div class="col-lg-12">
        <h2 class="section-title"><?php echo $notice_dtl->title; ?></h2>
        <div class="section-content">
		 <?php echo $notice_dtl->description; ?>
		 <br>
		 <?php if($notice_dtl->id == 42){
			 echo '<a style="color: red; font-size: 2rem;" href="https://docs.google.com/forms/d/e/1FAIpQLScH2uF-IU3b92qdhfhFREGOClvpvldu9W45GCFXTIHTJu-Dgw/viewform" target="_blank">Click Here</a>';
		 }?>
		</div>
		<?php if($notice_dtl->id == 42){
			
		}else{?>
			<a href="<?php echo attachment_url('notice/'.$notice_dtl->filename); ?>" class="btn btn-info" role="button" target="_blank">Download Notice</a>
		<?php }?>
        
      </div>
    </div>
    
  </div>
</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>