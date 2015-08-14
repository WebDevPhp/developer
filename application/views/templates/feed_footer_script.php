<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script> 
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug --> 
<script src="<?php echo base_url(); ?>js/ie10-viewport-bug-workaround.js"></script> 
<!-- Script to Activate the Carousel --> 


<script type="text/javascript" src="<?php echo base_url() ?>assets/jquery.bxslider.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/jquery.bxslider.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/jquery.bxslider.css">
<script>
$(document).ready(function(){
	var slider = $('.slider2').bxSlider({
		minSlides: 1,
		maxSlides: 1,
		pager: false,
		slideMargin: 0,
		auto:true,
		pause:10000,
		autoHover: true,
		autoDelay:10000
	});
 
	$(".bx-controls-direction a").click(function () {
		slider.stopAuto();
		slider.startAuto();
	});
})
$(window).load(function () {
	
});

</script>


<script>
    /* $('.carousel').carousel({
        interval: 5000 //changes the speed
    }) */
</script> 

<!--tooltip js-->
<script src="<?php echo base_url(); ?>js/custom-bootstrap.js"></script>  
<script type="text/javascript">//<![CDATA[ 
$(window).load(function(){

var isVisible = true;
var clickedAway = true;

$('.popoverThis').popover({
    html: true,
    trigger: 'manual'
})
 //$('.popover-title').append('<a class="close" style="position: absolute; top: 0; right: 6px;">&times;</a>')
.click(function (e) {
    $(this).popover('show');
    clickedAway = true
    isVisible = true
	e.preventDefault()
});

$(document).click(function (e) {
    if (isVisible & clickedAway) {
        $('.popoverThis').popover('hide')
        isVisible = clickedAway = true
    } else {
        clickedAway = true
    }
});
});//]]>  

</script>

<!--add class js--> 
<script type="text/javascript">
$(window).scroll(function() {    
    var scroll = $(window).scrollTop();

    if (scroll >= 300) {
        $(".navbar-fixed-top").addClass("darkHeader");
    } else {
        $(".navbar-fixed-top").removeClass("darkHeader");
    }
});
</script> 
<script type="text/javascript">
	$(document).ready(function () {

    $('.btn-vertical-slider').on('click', function () {
        
        if ($(this).attr('data-slide') == 'next') {
            $('#myCarousel2').carousel('next');
        }
        if ($(this).attr('data-slide') == 'prev') {
            $('#myCarousel2').carousel('prev')
        }
    });
});
	</script>
	
</body>
</html>
