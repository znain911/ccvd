	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="<?php echo base_url('backend/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js'); ?>"></script>
	<script src="<?php echo base_url('backend/assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
	<!--[if lt IE 9]>
		<script src="<?php echo base_url('backend/assets/crossbrowserjs/html5shiv.js'); ?>"></script>
		<script src="<?php echo base_url('backend/assets/crossbrowserjs/respond.min.js'); ?>"></script>
	<![endif]-->
	<script src="<?php echo base_url('backend/assets/plugins/slimscroll/jquery.slimscroll.min.js'); ?>"></script>
	<script src="<?php echo base_url('backend/assets/plugins/jquery-cookie/jquery.cookie.js'); ?>"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js"></script>
	<script src="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url('backend/'); ?>assets/plugins/ionRangeSlider/js/ion-rangeSlider/ion.rangeSlider.min.js"></script>
	<script src="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
	<script src="<?php echo base_url('backend/'); ?>assets/plugins/masked-input/masked-input.min.js"></script>
	<script src="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
	<script src="<?php echo base_url('backend/'); ?>assets/plugins/strength-js/strength.js"></script>
	<script src="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
	<script src="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-select/bootstrap-select.min.js"></script>
	<script src="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
	<script src="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.js"></script>
	<script src="<?php echo base_url('backend/'); ?>assets/plugins/jquery-tag-it/js/tag-it.min.js"></script>
    <script src="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-daterangepicker/moment.js"></script>
    <script src="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url('backend/'); ?>assets/plugins/select2/dist/js/select2.min.js"></script>
    <script src="<?php echo base_url('backend/'); ?>assets/plugins/bootstrap-eonasdan-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?php echo base_url('backend/'); ?>assets/js/page-form-plugins.demo.min.js"></script>
    <!--
	<script src="<?php echo base_url('backend/'); ?>assets/js/demo.min.js"></script>
    <script src="<?php echo base_url('backend/'); ?>assets/js/apps.min.js"></script>
	-->
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="<?php echo base_url('backend/assets/plugins/DataTables/media/js/jquery.dataTables.js'); ?>"></script>
	<script src="<?php echo base_url('backend/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('backend/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js'); ?>"></script>
	<script src="<?php echo base_url('backend/assets/plugins/summernote/dist/summernote.min.js'); ?>"></script>
	<script src="<?php echo base_url('backend/assets/plugins/gritter/js/jquery.gritter.js'); ?>"></script>
    <script src="<?php echo base_url('backend/assets/js/demo.min.js'); ?>"></script>
    <script src="<?php echo base_url('backend/assets/js/apps.min.js'); ?>"></script>
    <script src="<?php echo base_url('backend/assets/js/custom/course.js'); ?>"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
	
	<script>
		$(document).ready(function() {
		    App.init();
		    Demo.init();
			PageDemo.init();
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.pace').remove();
		});
	</script>
	<script type="text/javascript">
		$('.summernote2').summernote({
			height: 350,                 // set editor height
			minHeight: null,             // set minimum height of editor
			maxHeight: null,             // set maximum height of editor
			focus: false,                // set focus to editable area after initializing summernote
			onImageUpload: function(files, editor, welEditable) {
				sendFile(files[0], editor, welEditable);
			}
		});
	</script>
	<script type="text/javascript">
		$("#data-table").DataTable();
	</script>
	<script type="text/javascript">
		for ( instance in CKEDITOR.instances )
        CKEDITOR.instances[instance].updateElement();
	</script>
</body>
</html>