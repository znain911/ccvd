<style type="text/css">
#example_paginate{
  float: right !important;
  margin-top: 10px;
}
#example_paginate span{
  margin: 7px;
 
}
#example_paginate span a{
  padding: 0 5px;
    border: 1px solid;
    margin: 5px;
}
</style>
<?php require_once APPPATH.'modules/common/header.php'; ?>
      <div class="container">
		<div style="padding-top:50px;"></div>
        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="" style="background-color:#83C9EB !important;">
                <h3 class="color-white index-1 text-center pb-2 pt-2 no-mb no-mt">Notice Board</h3>
              </div>
              <div class="card-body p-0">
				       
              
                <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr style="display:none;">
                        <th></th>
                        <th></th>
                        
                    </tr>
                </thead>
        
       
        <tbody> 

              <?php $sn= 1; foreach($notice_list as $nlist){ ?> 

                  <tr> 
				  <td> <?php //echo date("d-m-Y", strtotime($nlist->create_date)); ?></td> 
					<?php if ( $nlist->id === '89'):?>
					<td>  <a href= "https://docs.google.com/forms/d/e/1FAIpQLSf3wsb9cE3F-6Uv-s6Oct7Qbzm2CTpmxzw1J3YV2rTiLCvq8w/viewform"
                                class="list-group-item">
                                <p class="float-right"> 10-09-2022</p>
                                &nbsp  1st Convocation Registration, CCVD-DLP</a></td>
					<?php else:?>
                  <td>  <a href="<?php echo base_url('notice/details/').$nlist->id;?>" 
                                class="list-group-item">
                                <p class="float-right"><?php echo date("d-m-Y", strtotime($nlist->create_date)); ?> </p>
                                &nbsp   <?php echo $nlist->title;?> </a></td> 
                  <!--<td> <?php //echo date("d-m-Y", strtotime($nlist->create_date)); ?></td> 

                  <td>  <a href="<?php echo base_url('notice/details/').$nlist->id;?>" 
                                class="list-group-item">
                                <p class="float-right"><?php echo date("d-m-Y", strtotime($nlist->create_date)); ?> </p>
                                &nbsp   <?php echo $nlist->title;?> </a></td> -->

                  </tr> 

              <?php endif; 
			  $sn++; }  ?> 

     </tbody> 

</table> 
    
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js">
    </script>
    <script>
       $(document).ready(function() {
            var table = $('#example').DataTable({ 
                  select: false,
                  info: false,
                  searching: false,
                  lengthChange: false,
                  "columnDefs": [{
                      className: "Name", 
                      "targets":[0],
                      "visible": false,
                      "searchable":false,
                  }]
              });//End of create main table

           
            $('#example tbody').on( 'click', 'tr', function () {
            
             // alert(table.row( this ).data()[0]);

          } );
          });
    </script>
       
     
              </div>
            </div>
          </div>
          <div class="col-lg-4">
			<?php 
				$get_contactinfo = $this->Notice_model->contact_infos();
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