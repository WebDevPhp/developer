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
    clickedAway = false
    isVisible = false
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
</body>
</html>