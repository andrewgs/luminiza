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
						<?php if(!empty($retail['newprice'])):
							echo '<h1>'.$retail['title'].' (<strike>'.$retail['newprice'].'</strike> '.$retail['price'].' &euro;)</h1>';
						else:
							echo '<h1>'.$retail['title'].' ('.$retail['price'].' &euro;)</h1>';
						endif;
							echo '<div class="sell-date">Дата выставления на продажу: '.$retail['date'].'</div><div>'.$retail['extended'].'</div>';	?>
								<br class="clear"/>
								<div>
									<div class="car_preferences">
										<?=$retail['properties']['object'].'<br/>'; ?>
										<?=$retail['properties']['location'].'<br/>'; ?>
										<?=$retail['properties']['region'].'<br/>'; ?>
										<?=$retail['properties']['rooms'].'<br/>'; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="clear"></div>
						<?php if(isset($retail['img_id'])):
								echo '<img class="retail-preview" alt="'.$retail['img_title'].'"title="'.$retail['img_title'].'" src="'.$baseurl.'viewslideshow/'.$retail['img_id'].'">';
							endif; ?>
						<?php for($i=0;$i<count($images);$i++){							
							if(isset($images[$i]['img_id'])):			
								$text = '<img class="row_image thumb" alt="'.$images[$i]['img_title'].'" title="'.$images[$i]['img_title'].'" src="'.$baseurl.'viewimage/'.$images[$i]['img_id'].'">';
								$link = $baseurl.'viewslideshow/'.$images[$i]['img_id'];
								$attr = array('class'=>'pirobox_retail','title'=>$images[$i]['img_title']);
								echo anchor($link,$text,$attr);	
							endif;
							if(($i+1) == count($images)) echo '<br class="clear"/>';
						} ?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
	  </div>
 	</div>
<?php $this->load->view('user_interface/scripts');?>
</body>
</html>