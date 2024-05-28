<div class="ste-wizard-flow">
	<div class="step-absolute-container">
		<div class="single-step-flow one <?php echo ($template == 'account')? 'active' : null; ?>">
			<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
			<div class="step-name-intext">
				<span class="bold-text">STEP 1</span>
				<span class="normal-text">Account</span>
			</div>
		</div>
		<div class="single-step-flow two <?php echo ($template == 'personal')? 'active' : null; ?>">
			<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
			<div class="step-name-intext">
				<span class="bold-text">STEP 2</span>
				<span class="normal-text">Personal</span>
			</div>
		</div>
		<div class="single-step-flow three <?php echo ($template == 'academic')? 'active' : null; ?>">
			<div class="bullet-check-mark"><i class="ion-checkmark-circled"></i></div>
			<div class="step-name-intext">
				<span class="bold-text">STEP 3</span>
				<span class="normal-text">Academic</span>
			</div>
		</div>
		<div class="single-step-flow four active">
			<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
			<div class="step-name-intext">
				<span class="normal-text">
					Administration verification & approval
				</span>
			</div>
		</div>
		<div class="single-step-flow five <?php echo ($template == 'payment')? 'active' : null; ?>">
			<div class="bullet-check-mark"><i class="zmdi zmdi-circle"></i></div>
			<div class="step-name-intext">
				<span class="bold-text">STEP 5</span>
				<span class="normal-text">Payment</span>
			</div>
		</div>
	</div>
</div>