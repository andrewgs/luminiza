<script src="<?=$baseurl;?>js/jquery.cycle.js"></script>
<script src="<?=$baseurl;?>js/jquery.easing.js"></script>
<script type="text/javascript">
 	$(document).ready(function(){
		$('div#photo-slider').cycle({
			fx: 'scrollLeft',
			// speed: '3000',
			// easing: 'easeInOutExpo',
			speed: 'fast',
			timeout: 5000,
			pager: "#photo-thumbs", 
     
		    // callback fn that creates a thumbnail to use as pager anchor 
		    pagerAnchorBuilder: function(idx, slide) { 
		        return '<a href="#"><img src="' + slide.src + '" width="30px" height="30px" class="row_image thumb" /></a>';
		    } 
		}); 
	});
</script>