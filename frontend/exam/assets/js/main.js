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
	
	
	$('.example').jdSlider({

	  // enable/disable the carousel
	  isUse: true,

	  // wrapper element
	  wrap: null,

	  // default CSS selectors
	  slide: '.slide-area',
	  prev: '.prv-nav',
	  next: '.prv-nxt', // 다음 버튼 선택자
	  indicate: '.indicate-area',
	  auto: '.auto', 
	  playClass: 'play',
	  pauseClass: 'pause',
	  noSliderClass: 'slider--none', 
	  willFocusClass: 'will-focus', 
	  unusedClass: 'hidden', 

	  // how many slides to display at a time
	  slideShow: 1,

	  // how many slides to scroll at a time
	  slideTo: 1,

	  // start slide
	  slideStart: 1,

	  // margin property
	  margin: null, 

	  // animation speed
	  speed: 500, 

	  // easing
	  timingFunction: 'ease',
	  easing: 'swing',

	  // autoplay interval
	  interval: 4000, 

	  // touch throttle
	  touchDistance: 20, 

	  // resistance ratio
	  resistanceRatio: .5,

	  // is overflow
	  isOverflow: false,

	  // shows indicator
	  isIndicate: true,

	  // is autoplay
	  isAuto: false,

	  // is infinite loop
	  isLoop: false,

	  // false: use fade animation instead
	  isSliding: true,

	  // pause on hover
	  isCursor: false,

	  // enable touch event
	  isTouch: false,

	  // enable drag event
	  isDrag: false,

	  // enable swipe resistance
	  isResistance: true,

	  // auto playback
	  isCustomAuto: false, 

	  // auto playback
	  autoState: 'auto',

	  // custom indicator
	  indicateList: function (i) {
		  return '<a href="#">' + i + '</a>'; 
	  },

	  // progress function
	  progress: function () {}

	});
	
});