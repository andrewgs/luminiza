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
					<a class="crossing" href="<?=$baseurl.$backpath;?>">&larr; Вернуться</a>
					<div class="clear"></div>
					<div class="miniature">
						<img title="Picasso Miniature" alt="Picasso Miniature" src="<?=$baseurl;?>images/transfers_miniature.png"/>
					</div>
				</div>
			</div>
			<div class="grid_9 alpha">
				<div class="main_content">
					<p class="confirm-title"><?=$text;?></p>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<?php $this->load->view('user_interface/footer');?>
</div>
<?php $this->load->view('user_interface/scripts');?>
</body>
</html>