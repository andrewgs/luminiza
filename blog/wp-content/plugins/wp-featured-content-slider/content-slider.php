<?php
$direct_path =  get_bloginfo('wpurl')."/wp-content/plugins/wp-featured-content-slider";
?>

<script type="text/javascript">
	jQuery('#featured_slider ul').cycle({ 
		fx: '<?php $effect = get_option('effect'); if(!empty($effect)) {echo $effect;} else {echo "Fade";}?>',
		prev: '.feat_prev',
		next: '.feat_next',
		speed:  500, 
		timeout: <?php $timeout = get_option('timeout'); if(!empty($timeout)) {echo $timeout;} else {echo 3000;}?>, 
		pager:  null
	});
</script>

<style>
#featured_slider { float: left; position: relative; background-color: #<?php $bg = get_option('feat_bg'); if(!empty($bg)) {echo $bg;} else {echo "FFF";}?>; border: 1px solid #<?php $border = get_option('feat_border'); if(!empty($border)) {echo $border;} else {echo "FFF";}?>; width: <?php $width = get_option('feat_width'); if(!empty($width)) {echo $width;} else {echo "598";}?>px;}
#featured_slider .slide { list-style: none !important; border: none !important; float: left; margin: 0px; width: <?php $width = get_option('feat_width'); if(!empty($width)) {echo $width;} else {echo "598";}?>px; height: <?php $height = get_option('feat_height'); if(!empty($height)) {echo $height;} else {echo "230";}?>px; }
#featured_slider .img_right { float: right; overflow: hidden; margin-left: 25px; width: <?php $img_width = get_option('img_width'); if(!empty($img_width)) {echo $img_width;} else {echo "190";}?>px; height: <?php $img_height = get_option('img_height'); if(!empty($img_height)) {echo $img_height;} else {echo "190";}?>px;  }
#featured_slider .content_left { float: left; color: #<?php $text_color = get_option('text_color'); if(!empty($text_color)) {echo $text_color;} else {echo "333";}?>; width: <?php $text_width = get_option('text_width'); if(!empty($text_width)) {echo $text_width;} else {echo "598";}?>px; } 
#featured_slider .content_left p { color: #<?php $text_color = get_option('text_color'); if(!empty($text_color)) {echo $text_color;} else {echo "996633";}?>; line-height: 18px; }
#featured_slider .content_left h2 { font: bold 28px/30px 'Droid Sans', 'Trebuchet MS', sans-serif; letter-spacing: -1px; !important; margin-bottom: 10px; }
#featured_slider .feat_prev { background: transparent url(<?=$direct_path;?>/images/prev.png) no-repeat top; width: 25px; height: 25px; z-index: 10; position: absolute; left: 0px; cursor: pointer; bottom: 30px; float: left; }
#featured_slider .feat_prev:hover { background-position: bottom; }
#featured_slider .feat_next { background: transparent url(<?=$direct_path;?>/images/next.png) no-repeat top; width: 25px; height: 25px; z-index: 10; position: absolute; left: 35px; bottom: 30px; cursor: pointer; float: left; }
#featured_slider .feat_next:hover { background-position: bottom; }
</style>


<div id="featured_slider">
	<ul id="slider">
		<?php global $wpdb;		
		$querystr = "
			SELECT wposts.* 
			FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
			WHERE wposts.ID = wpostmeta.post_id 
			AND wpostmeta.meta_key = 'feat_slider' 
			AND wpostmeta.meta_value = '1' 
			AND wposts.post_status = 'publish' 
			AND (wposts.post_type = 'post' OR wposts.post_type = 'page')";		
		$pageposts = $wpdb->get_results($querystr, OBJECT);?>		
		<?php if ($pageposts): ?>			
			<?php global $post;?>			
			<?php foreach ($pageposts as $post): ?>			
			<?php setup_postdata($post);			
			$custom = get_post_custom($post->ID);?>		
		<div class="slide"><div class="content_left"><?php if ( has_post_thumbnail()) : ?><div class="img_right"><a href="<?php the_permalink();?>" title="<?php the_title_attribute();?>" ><?php the_post_thumbnail(array( 180,180 ));?></a></div><?php endif;?><h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2><?php the_excerpt();?></div></div>		
		<?php endforeach;?>		
		<?php endif;?>	
	</ul>	
   	<div class="feat_prev"></div>	
	<div class="feat_next"></div>
</div>
