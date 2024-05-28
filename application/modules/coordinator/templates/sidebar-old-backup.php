<div id="sidebar" class="sidebar">
	<!-- begin sidebar scrollbar -->
	<div data-scrollbar="true" data-height="100%">
		<!-- begin sidebar nav -->
		<ul class="nav">
			<li class="<?php echo menu_item_activate('dashboard'); ?>">
				<a href="<?php echo base_url('coordinator/dashboard'); ?>">
					<i class="fa fa-home"></i>
					<span>Dashboard</span>
				</a>
			</li>
			<li class="has-sub <?php echo menu_item_activate('faculties'); ?>">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="fa fa-folder"></i>
					<span>Manage Faculties</span> 
				</a>
				<ul class="sub-menu">
					<li><a href="<?php echo base_url('coordinator/faculties/pending'); ?>">Pending Faculties</a></li>
					<li><a href="<?php echo base_url('coordinator/faculties/enrolled'); ?>">Enrolled Faculties</a></li>
				</ul>
			</li>
			<li class="has-sub <?php echo menu_item_activate('students'); ?>">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="fa fa-folder"></i>
					<span>Manage Students</span> 
				</a>
				<ul class="sub-menu">
					<li><a href="<?php echo base_url('coordinator/students/pending'); ?>">Pending Students</a></li>
					<li><a href="<?php echo base_url('coordinator/students/enrolled'); ?>">Enrolled Students</a></li>
				</ul>
			</li>
			<li class="has-sub <?php echo menu_item_activate('course'); ?>">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="fa fa-folder"></i>
					<span>Manage Course</span> 
				</a>
				<ul class="sub-menu">
					<li><a href="<?php echo base_url('coordinator/course/phase?step=A&module=1-3'); ?>">Phase A (Books/Modules)</a></li>
					<li><a href="<?php echo base_url('coordinator/course/phase?step=B&module=4-7'); ?>">Phase B (Books/Modules)</a></li>
					<li><a href="<?php echo base_url('coordinator/course/phase?step=C&module=8-10'); ?>">Phase C (Books/Modules)</a></li>
				</ul>
			</li>
			<li class="has-sub <?php echo menu_item_activate('payments'); ?>">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="fa fa-folder"></i>
					<span>Payments</span> 
				</a>
				<ul class="sub-menu">
					<li><a href="<?php echo base_url('coordinator/payments/coursefee'); ?>">Payments (Course Fee)</a></li>
					<li><a href="<?php echo base_url('coordinator/payments/retakefee'); ?>">Payments (Retake exam)</a></li>
				</ul>
			</li>
			<li class="has-sub <?php echo menu_item_activate('discussion'); ?>">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="fa fa-folder"></i>
					<span>Manage Discussion</span> 
				</a>
				<ul class="sub-menu">
					<li><a href="<?php echo base_url('coordinator/discussion/withfaculty'); ?>">Discussions With Faculties</a></li>
					<li><a href="<?php echo base_url('coordinator/discussion/withstudent'); ?>">Discussions With Students</a></li>
				</ul>
			</li>
			<li class="has-sub <?php echo menu_item_activate('questions'); ?>">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="fa fa-folder"></i>
					<span>Exams Questions</span> 
				</a>
				<ul class="sub-menu">
					<li><a href="<?php echo base_url('coordinator/questions/module'); ?>">Module Exam Questions</a></li>
				</ul>
			</li>
			<li class="has-sub <?php echo menu_item_activate('schedules'); ?>">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="fa fa-folder"></i>
					<span>Manage Schedules</span> 
				</a>
				<ul class="sub-menu">
					<li><a href="<?php echo base_url('coordinator/schedules/moduleexam'); ?>">Module Exam Schedules</a></li>
					<li><a href="<?php echo base_url('coordinator/schedules/ftwofsession'); ?>">F2F Session Schedules</a></li>
					<li><a href="<?php echo base_url('coordinator/schedules/phaseexam'); ?>">Phase Exam Schedules</a></li>
					<li><a href="<?php echo base_url('coordinator/schedules/sdt'); ?>">SDT Schedules</a></li>
					<li><a href="<?php echo base_url('coordinator/schedules/workshop'); ?>">Workshop Schedules</a></li>
					<li><a href="<?php echo base_url('coordinator/schedules/eceexam'); ?>">ECE Exam Schedules</a></li>
				</ul>
			</li>
			<li class="has-sub <?php echo menu_item_activate('booking'); ?>">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="fa fa-folder"></i>
					<span>Applicants Booking</span> 
				</a>
				<ul class="sub-menu">
					<li><a href="<?php echo base_url('coordinator/booking/ftwof?type=Faculties'); ?>">F2F Session (Faculties)</a></li>
					<li><a href="<?php echo base_url('coordinator/booking/ftwof?type=Students'); ?>">F2F Session (Students)</a></li>
					<li><a href="<?php echo base_url('coordinator/booking/sdt'); ?>">SDT Applicants</a></li>
					<li><a href="<?php echo base_url('coordinator/booking/workshop'); ?>">Workshop Applicants</a></li>
					<li><a href="<?php echo base_url('coordinator/booking/phaseexam'); ?>">Phase Exam Applicants</a></li>
					<li><a href="<?php echo base_url('coordinator/booking/eceexam'); ?>">ECE Exam Applicants</a></li>
				</ul>
			</li>
			<li class="has-sub <?php echo menu_item_activate('results'); ?>">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="fa fa-folder"></i>
					<span>Manage Results</span> 
				</a>
				<ul class="sub-menu">
					<li><a href="<?php echo base_url('coordinator/results/module'); ?>">Module Exam Results</a></li>
					<li><a href="<?php echo base_url('coordinator/results/phase'); ?>">Results</a></li>
					<li><a href="<?php echo base_url('coordinator/results/ece'); ?>">ECE Exam Results</a></li>
				</ul>
			</li>
			<li class="has-sub <?php echo menu_item_activate('certificates'); ?>">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="fa fa-folder"></i>
					<span>Manage Certificates</span> 
				</a>
				<ul class="sub-menu">
					<li><a href="<?php echo base_url('coordinator/certificates'); ?>">View Certificates</a></li>
					<li><a href="<?php echo base_url('coordinator/certificates/upload'); ?>">Upload Certificate</a></li>
				</ul>
			</li>
			<li class="has-sub <?php echo menu_item_activate('faqs'); ?>">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="fa fa-folder"></i>
					<span>Manage FAQs</span> 
				</a>
				<ul class="sub-menu">
					<li><a href="<?php echo base_url('coordinator/faqs?type=Website'); ?>">Website FAQs</a></li>
					<li><a href="<?php echo base_url('coordinator/faqs?type=Students'); ?>">Students FAQs</a></li>
					<li><a href="<?php echo base_url('coordinator/faqs?type=Faculties'); ?>">Faculties FAQs</a></li>
				</ul>
			</li>
			<li class="has-sub <?php echo menu_item_activate('page'); ?>">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="fa fa-folder"></i>
					<span>Manage Web Pages</span> 
				</a>
				<ul class="sub-menu">
					<li><a href="<?php echo base_url('coordinator/page'); ?>">Manage Web Pages</a></li>
					<li><a href="<?php echo base_url('coordinator/page/create'); ?>">Create Page</a></li>
				</ul>
			</li>
			<li class="has-sub <?php echo menu_item_activate('contacts'); ?>">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="fa fa-folder"></i>
					<span>Supports / Contacts</span> 
				</a>
				<ul class="sub-menu">
					<li><a href="<?php echo base_url('coordinator/contacts'); ?>">View Contact Messages</a></li>
				</ul>
			</li>
			<li class="has-sub <?php echo menu_item_activate('setup'); ?>">
				<a href="javascript:;">
					<b class="caret pull-right"></b>
					<i class="fa fa-folder"></i>
					<span>Setup</span> 
				</a>
				<ul class="sub-menu">
					<li><a href="<?php echo base_url('coordinator/setup/coordinators'); ?>">Coordinators</a></li>
					<li><a href="<?php echo base_url('coordinator/setup/roles'); ?>">Coordinator's Role</a></li>
					<li><a href="<?php echo base_url('coordinator/setup/specialization'); ?>">Specialization</a></li>
					<li><a href="<?php echo base_url('coordinator/setup/categories'); ?>">DLP Categories</a></li>
					<li><a href="<?php echo base_url('coordinator/setup/centers'); ?>">Center Lists</a></li>
					<li><a href="<?php echo base_url('coordinator/setup/smsconfig'); ?>">SMS Configuration</a></li>
					<li><a href="<?php echo base_url('coordinator/setup/emailconfig'); ?>">Email Configuration</a></li>
					<li><a href="<?php echo base_url('coordinator/setup/paymentconfig'); ?>">Payment Configuration</a></li>
				</ul>
			</li>
		</ul>
		<!-- end sidebar nav -->
	</div>
	<!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->