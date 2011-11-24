/*  Author: Reality Group
 *  http://realitygroup.ru/
 */

var calc_st, calc_fir, calc_per, calc_sr, calc_sum, calc_ej;

function getval(e) {
	var v = parseFloat(e.val());
	if (!v) v = 0;
	return v;
}

function calc() {
	var cost = getval(calc_st);
	var first = getval(calc_fir);
	var percent = getval(calc_per);
	var months = getval(calc_sr);
	var paid = (cost-first)*(percent/12*0.01)/(1-Math.pow(1+percent/12*0.01,months*-1));
	if (!paid) paid = 0;
	calc_sum.html((cost-first).toFixed(2));
	calc_ej.html(paid.toFixed(2));
}
 
(function($){
	
	setTimeout(function(){ // --andrewg Hack to avoid layout break on first page load
		$('#slider').nivoSlider({
			effect: 'fold, fade', //Specify sets like: 'fold,fade,sliceDown'
			slices: 10,
			//animSpeed: 500, //Slide transition speed
			pauseTime: 5000,
			//startSlide: 0, //Set starting Slide (0 index)
			//directionNav: true, //Next & Prev
			//directionNavHide: true, //Only show on hover
			controlNav: true //1,2,3...
			//controlNavThumbs: false, //Use thumbnails for Control Nav
			//controlNavThumbsFromRel: false, //Use image rel for thumbs
			//controlNavThumbsSearch: '.jpg', //Replace this with...
			//controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
			//keyboardNav: true, //Use left & right arrows
			//pauseOnHover: true, //Stop animation while hovering
			//manualAdvance: false, //Force manual transitions
			//captionOpacity: 0.8, //Universal caption opacity
			//beforeChange: function(){},
			//afterChange: function(){},
			//slideshowEnd: function(){} //Triggers after all slides have been shown
		});
	}, 2000);
	

	var timeout	= 500;
	var closetimer_rent   = 0
		closetimer_retail = 0;
	
	$('#mi-rent, a.mi_rent')
	.mouseover(function(){
		if (closetimer_rent) {
			window.clearTimeout(closetimer_rent);
			closetimer_rent = null;
		}		
		if ($('div#popup-menu-rent').length) {
			$('div#popup-menu-rent').css({
				top: $('#mi-rent').offset().top + 20 + "px",
				left: $('#mi-rent').offset().left
			}).fadeIn();
		}
	})
	.mouseout(function(){ 
		closetimer_rent = window.setTimeout(function(){
			if ($('div#popup-menu-rent').length) $('div#popup-menu-rent').fadeOut();
		}, timeout);
	});
	
	$('#mi-retail, a.mi_retail')
	.mouseover(function(){
		if (closetimer_retail) {
			window.clearTimeout(closetimer_retail);
			closetimer_retail = null;
		}		
		if ($('div#popup-menu-retail').length) {
			$('div#popup-menu-retail').css({
				top: $('#mi-retail').offset().top + 20 + "px",
				left: $('#mi-retail').offset().left
			}).fadeIn();
		}
	})
	.mouseout(function(){ 
		closetimer_retail = window.setTimeout(function(){
			if ($('div#popup-menu-retail').length) $('div#popup-menu-retail').fadeOut();
		}, timeout);
	});	
	
	
	calc_st = $('#calc_st');
	calc_fir = $('#calc_fir');
	calc_per = $('#calc_per');
	calc_sr = $('#calc_sr');
	calc_sum = $('#calc_sum');
	calc_ej = $('#calc_ej');
	calc_st.keyFilter();
	calc_fir.keyFilter();
	calc_per.keyFilter();	
	
	$('#calc_final_res').click(function(e){
		e.preventDefault;
		calc();
		return false;
	});

})(window.jQuery);























