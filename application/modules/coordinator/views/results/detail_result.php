<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Certificate Course on Cardiovascular Disease (CCVD)</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="manifest" href="site.webmanifest">
        <link rel="apple-touch-icon" href="icon.png">
        <!-- Place favicon.ico in the root directory -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
		<link rel="stylesheet" href="<?php echo base_url('frontend/exam/'); ?>assets/css/jquery.jdSlider.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url('frontend/exam/'); ?>assets/css/normalize.css" />
        <link rel="stylesheet" href="<?php echo base_url('frontend/exam/'); ?>assets/css/main.css" />
		<script src="<?php echo base_url('frontend/exam/'); ?>assets/js/vendor/modernizr-3.5.0.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="<?php echo base_url('frontend/exam/'); ?>assets/js/vendor/jquery-3.2.1.min.js"><\/script>')</script>
		<script src="<?php echo base_url('frontend/exam/assets/js/jquery.validate.js'); ?>"></script>
		<script type="text/javascript">
			var baseUrl = "<?php echo base_url(); ?>";
			var sqtoken_hash = "<?php echo $this->security->get_csrf_hash(); ?>";
		</script>
	</head>
    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <div class="exam-container">
			<div class="container-logo-bar">
				<div class="top-bar-with-logo container">
					<div class="row">
						<div class="col-lg-12">
							<div class="logo"><img src="<?php echo base_url('frontend/tools/dlp.png'); ?>" alt="Logo" /></div>
							<div class="org-title">Certificate Course on Cardiovascular Disease (CCVD)</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="simple-content-goes">
			<div class="container">
				<div class="col-lg-12">
					<div class="content-text-goes">						
						
						<table class="table">
						  <thead>
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Date</th>
						      <th scope="col">Correct Ans</th>
						      <th scope="col">Wrong Ans</th>
						      <th scope="col">View</th>
						    </tr>
						  </thead>
						  <tbody>
						  	<?php $sl = 1; foreach ($gotexams as $examlst) {?>
						  		<?php $total_right_answers = $this->Results_model->get_right_answers($examlst->examcnt_id);
						$total_wrong_answers = $this->Results_model->get_wrong_answers($examlst->examcnt_id);

						/*print_r($total_wrong_answers);*/
						if(count($total_right_answers) != 0 && count($total_wrong_answers) != 0){
			?>
						  		<tr>
							      <th scope="row"><?php echo $sl;?></th>
							      <td><?php echo $examlst->examcnt_date;?></td>
							      <td><?php echo count($total_right_answers);?></td>
							      <td><?php echo count($total_wrong_answers);?></td>
								  <!-- <td><a href="<?php echo base_url('coordinator/results/detailresult/').$examlst->examcnt_date; ?>" class="btn btn-info btn-xs p-l-10 p-r-10">View Deteil</a></td> -->

								  <td>
                                      <a href="javascript:void(0);" class="btn btn-info btn-xs p-l-10 p-r-10" data-toggle="modal" data-target="#myModal" onclick="data_view('<?php echo $examlst->examcnt_id; ?>')">View</a>
                                   </td>
							    </tr>
						  	<?php $sl++; } }?>
						    
						  </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>


		     <!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Result Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" id="qsndata">
        Modal body..
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

		<script type="text/javascript">
			function data_view(id){ 
			   var loader='<div style="text-align: center;"><i class="fa fa-refresh fa-spin fa-4x fa-fw"></i></div>';

			 $('#qsndata').html(loader);         
			            
			    $.ajax({
			        url:"<?php echo base_url(); ?>/coordinator/results/viewdetails",  
			        method:"POST",  
			        data:{id:id},  
			        success:function(data)  
			            {  
			                
			                $("#qsndata").html(data);
			            }  
			                
			    });
			            
			}
		</script>
        
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url('frontend/exam/'); ?>assets/js/jquery.jdSlider-latest.js"></script>
		<script src="<?php echo base_url('frontend/exam/'); ?>assets/js/main.js"></script>
    </body>
</html>
