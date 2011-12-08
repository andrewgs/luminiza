<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>  <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>  <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php $this->load->view('user_interface/head');?>
<body>
	<div id="container">
		<div id="content_box">
			<div class="content container_12">
				<div class="grid_9 alpha">
					<div class="main_content">
						<div class="missions_row">
							<div class="missions_right_panel extended">
								<h1><?=$rent['title']; ?></h1>
							<?php if(isset($rent['extended']) and !empty($rent['extended'])): ?>
								<div><?=$rent['extended'];?></div>
							<?php endif; ?>
							<?php if(isset($rent['properties']) and !empty($rent['properties'])): ?>
								<div class="car_preferences"><?= $rent['properties'];?></div>
							<?php endif; ?>
								<div class="car_preferences"><?=$rent['price'];?></div>
							</div>
						</div>
						<?php for($i=0;$i<count($images); $i++):							
							if(isset($images[$i]['img_id'])):
								echo '<img class="print-preview" alt="'.$images[$i]['img_title'].'" title="'.$images[$i]['img_title'].'" src="'.$baseurl.'viewslideshow/'.$images[$i]['img_id'].'">';
							endif;
							if(($i+1) == count($images)) echo '<br class="clear"/>';
						endfor;?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
<?php $this->load->view('user_interface/scripts');?>
<script type="text/javascript">
	$(document).ready(function(){
		$('div.missions_row:first').css('border-top', 'none').css('padding-top', 0);
		$('div.missions_row:last').css('border-bottom', 'none').css('padding-bottom', 0);
	});
</script>
</body>
</html>