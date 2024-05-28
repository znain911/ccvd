<div id="sidebar" class="sidebar">
	<!-- begin sidebar scrollbar -->
	<div data-scrollbar="true" data-height="100%">
		<!-- begin sidebar nav -->
		<ul class="nav">
			<?php 
				$active_user = $this->session->userdata('active_user');
				$check_permission9 = $this->Perm_model->check_permissionby_admin($active_user, 9);
				if($check_permission9 == true):
			?>
			<li class="main-itm-li <?php echo menu_item_activate('booking'); ?>">
				<a href="javascript:;" class="main-menu-itm" data-itm="8">
					<i class="fa fa-folder"></i>
					<span>Applicants Booking</span> 
				</a>
			</li>
			<?php endif; ?>
			<li class="main-itm-li <?php echo menu_item_activate('dashboard'); ?>">
				<a href="<?php echo base_url('coordinator/dashboard'); ?>">
					<i class="fa fa-home"></i>
					<span>Dashboard</span>
				</a>
			</li>
			
			<?php 
				$check_permission14 = $this->Perm_model->check_permissionby_admin($active_user, 14);
				if($check_permission14 == true):
			?>
			<li class="main-itm-li <?php echo menu_item_activate('evaluation'); ?>">
				<a href="javascript:;" class="main-menu-itm" data-itm="15">
					<i class="fa fa-folder"></i>
					<span>Evaluation</span> 
				</a>
			</li>
			<?php endif; ?>

			<?php 
				$check_permission7 = $this->Perm_model->check_permissionby_admin($active_user, 7);
				if($check_permission7 == true):
			?>
			<li class="main-itm-li <?php echo menu_item_activate('questions'); ?>">
				<a href="javascript:;" class="main-menu-itm" data-itm="6">
					<i class="fa fa-folder"></i>
					<span>Exams Questions</span> 
				</a>
			</li>
			<?php endif; ?>
			<?php 
				$check_permission11 = $this->Perm_model->check_permissionby_admin($active_user, 11);
				if($check_permission11 == true):
			?>
			<li class="main-itm-li <?php echo menu_item_activate('certificates'); ?>">
				<a href="javascript:;" class="main-menu-itm" data-itm="10">
					<i class="fa fa-folder"></i>
					<span>Manage Certificates</span> 
				</a>
			</li>
			<?php endif; ?>

			<?php 
				$check_permission4 = $this->Perm_model->check_permissionby_admin($active_user, 4);
				if($check_permission4 == true):
			?>
			<li class="main-itm-li <?php echo menu_item_activate('course'); ?>">
				<a href="javascript:;" class="main-menu-itm" data-itm="3">
					<i class="fa fa-folder"></i>
					<span>Manage Course</span> 
				</a>
			</li>
			<?php endif; ?>

			<?php 
				$check_permission6 = $this->Perm_model->check_permissionby_admin($active_user, 6);
				if($check_permission6 == true):
			?>
			<li class="main-itm-li <?php echo menu_item_activate('discussion'); ?>">
				<a href="javascript:;" class="main-menu-itm" data-itm="5">
					<i class="fa fa-folder"></i>
					<span>Manage Discussion</span> 
				</a>
			</li>
			<?php endif; ?>

			<?php
				
				$check_permission2 = $this->Perm_model->check_permissionby_admin($active_user, 2);
				if($check_permission2 == true):
			?>
			<li class="main-itm-li <?php echo menu_item_activate('faculties'); ?>">
				<a href="javascript:;" class="main-menu-itm" data-itm="1">
					<i class="fa fa-folder"></i>
					<span>Manage Faculties</span> 
				</a>
			</li>
			<?php endif; ?>
			
			<?php 
				$check_permission10 = $this->Perm_model->check_permissionby_admin($active_user, 10);
				if($check_permission10 == true):
			?>
			<li class="main-itm-li <?php echo menu_item_activate('results'); ?>">
				<a href="javascript:;" class="main-menu-itm" data-itm="9">
					<i class="fa fa-folder"></i>
					<span>Manage Results</span> 
				</a>
			</li>
			<?php endif; ?>

			<?php 
				$check_permission8 = $this->Perm_model->check_permissionby_admin($active_user, 8);
				if($check_permission8 == true):
			?>
			<li class="main-itm-li <?php echo menu_item_activate('schedules'); ?>">
				<a href="javascript:;" class="main-menu-itm" data-itm="7">
					<i class="fa fa-folder"></i>
					<span>Manage Schedules</span> 
				</a>
			</li>
			<?php endif; ?>

			<?php 
				$check_permission3 = $this->Perm_model->check_permissionby_admin($active_user, 3);
				if($check_permission3 == true):
			?>
			<li class="main-itm-li <?php echo menu_item_activate('students'); ?>">
				<a href="javascript:;" class="main-menu-itm" data-itm="2">
					<i class="fa fa-folder"></i>
					<span>Manage Students</span> 
				</a>
			</li>
			<?php endif; ?>
			
			
			
			<?php 
				$check_permission5 = $this->Perm_model->check_permissionby_admin($active_user, 5);
				if($check_permission5 == true):
			?>
			<li class="main-itm-li <?php echo menu_item_activate('payments'); ?>">
				<a href="javascript:;" class="main-menu-itm" data-itm="4">
					<i class="fa fa-folder"></i>
					<span>Payments</span> 
				</a>
			</li>
			<?php endif; ?>

			<?php 
				$check_permission12 = $this->Perm_model->check_permissionby_admin($active_user, 12);
				if($check_permission12 == true):
			?>
			<li class="main-itm-li <?php echo menu_item_activate('contacts'); ?>">
				<a href="javascript:;" class="main-menu-itm" data-itm="13">
					<i class="fa fa-folder"></i>
					<span>Supports / Contacts</span> 
				</a>
			</li>
			<?php endif; ?>
			
			<?php 
				$check_permission13 = $this->Perm_model->check_permissionby_admin($active_user, 13);
				if($check_permission13 == true):
			?>
			<li class="main-itm-li <?php echo ($this->uri->segment(2) == 'setup' || $this->uri->segment(2) == 'page' || $this->uri->segment(2) == 'faqs')? 'active' : null; ?>">
				<a href="javascript:;" class="main-menu-itm" data-itm="14">
					<i class="fa fa-folder"></i>
					<span>Setup</span> 
				</a>
			</li>
			<?php endif; ?>
			
			
		</ul>
		<!-- end sidebar nav -->
	</div>
	<!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->
<div id="dispSubItem">
	<?php require_once APPPATH.'modules/coordinator/templates/subitems.php'; ?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '.main-menu-itm', function(){
			var item_number = $(this).attr('data-itm');
			$('.main-itm-li').removeClass('active');
			$(this).parent().addClass('active');
			$('.sub-menu-itm-mostak').hide();
			$('.sb-item-'+item_number).show();
		});
	});
</script>