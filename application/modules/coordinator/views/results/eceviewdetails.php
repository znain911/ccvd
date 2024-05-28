
        <!-- <div class="exam-container">
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
		</div> -->
		
		<div class="simple-content-goes">
			<div class="container">
				<div class="col-lg-12">
					<div class="content-text-goes">						
						<table class="table">
						  <thead>
						    <tr>
						      <th scope="col">SL</th>
						      <th scope="col">Questions</th>
						      <th scope="col">Answers</th>
						    </tr>
						  </thead>
						  <tbody>
						  	<?php $sl = 1; foreach ($all_answers as $ans) {?>
						  		<?php if($ans->answer_status == 1){
							      	$fntclr = 'Green';
							      }else{
							      	$fntclr = 'Red';
							      } ?>
						  		<tr style="color:<?php echo $fntclr;?>">
							      <th scope="row"><?php echo $sl;?></th>
							      <td><?php echo $ans->question_title;?></td>
							      <td><?php if($ans->answer_status == 1){
							      	echo '<b>Correct</b>';
							      }else{
							      	echo '<b>Wrong</b>';
							      } ?></td>
							    </tr>
						  	<?php $sl++; }?>
						    
						  </tbody>
						</table>
						
					</div>
				</div>
			</div>
		</div>
 