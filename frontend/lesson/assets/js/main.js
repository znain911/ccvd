$(document).ready(function(){
	$("input[name$='answer']").click(function() {
        var test = $(this).val();

        $("div.desc").hide();
        $("#Cars" + test).show();
    });
	
	$(document).on('click', '.click-to-ans', function(){
		$('.anssubmit').removeClass('submit-disable');
		$('.anssubmit').removeAttr('disabled');
	});
});