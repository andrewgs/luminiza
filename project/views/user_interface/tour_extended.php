<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>  <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>  <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php $this->load->view('user_interface/head');?>
<body>
	<div id="container">
 	<?php $this->load->view('user_interface/header');?>
	<?php $this->load->view('user_interface/navigation');?>
  <div id="content_box">
		<div class="content container_12">
			<div class="grid_3">
				<div class="sidebar">
					<h3>Информация</h3>
					<?=$text['sidebar']['sbt_extended'] ?>
					<div class="miniature">
						<img title="Picasso Miniature" alt="Picasso Miniature" src="<?=$baseurl;?>images/tour_miniature.png"/>
					</div>
				</div>
			</div>
			<div class="grid_9 alpha">
				<div class="main_content">
					<h1><?= $tour['tour_title']; ?></h1>
					<?php if(isset($tour['img_id'])):						
						echo '<img class="main_image" alt="'.$tour['img_title'].'"title="'.$tour['img_title'].'" src="'.$baseurl.'viewimage/'.$tour['img_id'].'">';
					endif; ?>
					<?= $tour['tour_extended'];?>
					<?php for($i=0;$i<count($images);$i++):							
						if(isset($images[$i]['img_id'])):			
							$text = '<img class="row_image" alt="'.$images[$i]['img_title'].'" title="'.$images[$i]['img_title'].'" src="'.$baseurl.'viewimage/'.$images[$i]['img_id'].'">';
							$link = $baseurl.'viewslideshow/'.$images[$i]['img_id'];
							$attr = array('class'=>'pirobox_tour','title'=>$images[$i]['img_title']);
							echo anchor($link,$text,$attr);	
						endif;
						if(($i+1) % 3 == 0)	echo '<br class="clear"/>';
						if(($i+1) == count($images)) echo '<br class="clear"/>';
					endfor; ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
  </div>
  <?php $this->load->view('user_interface/footer'); ?>
 	</div>
<?php $this->load->view('user_interface/scripts');?>
<?php $this->load->view('user_interface/yandex');?>
<?php $this->load->view('user_interface/pirobox');?>
</body>
</html>