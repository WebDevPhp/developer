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
<script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
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
// $('.popover-title').append('<a class="close" style="position: absolute; top: 0; right: 6px;">&times;</a>')
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

    if (scroll >= 100) {
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

<!--<script src="<?php echo base_url();?>js/jquery.mCustomScrollbar.concat.min.js"></script>
<script>
		(function($){
			$(window).load(function(){
				
				$(".content").mCustomScrollbar({
					scrollButtons:{
						enable:true
					},
					callbacks:{
						onScrollStart:function(){ myCallback(this,"#onScrollStart") },
						onScroll:function(){ myCallback(this,"#onScroll") },
						onTotalScroll:function(){ myCallback(this,"#onTotalScroll") },
						onTotalScrollOffset:60,
						onTotalScrollBack:function(){ myCallback(this,"#onTotalScrollBack") },
						onTotalScrollBackOffset:50,
						whileScrolling:function(){ 
							myCallback(this,"#whileScrolling"); 
							$("#mcs-top").text(this.mcs.top);
							$("#mcs-dragger-top").text(this.mcs.draggerTop);
							$("#mcs-top-pct").text(this.mcs.topPct+"%");
							$("#mcs-direction").text(this.mcs.direction);
							$("#mcs-total-scroll-offset").text("60");
							$("#mcs-total-scroll-back-offset").text("50");
						},
						alwaysTriggerOffsets:false
					}
				});
				
				function myCallback(el,id){
					if($(id).css("opacity")<1){return;}
					var span=$(id).find("span");
					clearTimeout(timeout);
					span.addClass("on");
					var timeout=setTimeout(function(){span.removeClass("on")},350);
				}
				
				$(".callbacks a").click(function(e){
					e.preventDefault();
					$(this).parent().toggleClass("off");
					if($(e.target).parent().attr("id")==="alwaysTriggerOffsets"){
						var opts=$(".content").data("mCS").opt;
						if(opts.callbacks.alwaysTriggerOffsets){
							opts.callbacks.alwaysTriggerOffsets=false;
						}else{
							opts.callbacks.alwaysTriggerOffsets=true;
						}
					}
				});
				
			});
		})(jQuery);
	</script>-->
	
</body>
</html>