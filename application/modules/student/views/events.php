<?php require_once APPPATH.'modules/common/header.php'; ?>
	<?php 
		$data = array(
			3  => '',
			7  => '',
			13 => '',
			26 => ''
	);

echo $this->calendar->generate(2006, 6, $data);
	?>
<?php require_once APPPATH.'modules/common/footer.php'; ?>