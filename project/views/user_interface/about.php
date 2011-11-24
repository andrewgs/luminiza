<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
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
					<?php if(isset($sidebar['sbt_extended'])) echo $sidebar['sbt_extended']; ?>
						<?php if($admin): ?>
						<div class="admin-change">
							<?=anchor('edit/about/sidebar','Редактировать',array('class'=>'editlink')); ?>
						</div>
						<?php endif;?>
						<div class="miniature mt305">
						<img title="Picasso Miniature" alt="Picasso Miniature" src="<?=$baseurl;?>images/about_miniature.png"/>
						</div>
					</div>
				</div>
				<div class="grid_9 alpha">
					<div class="main_content">
						<h1> <?=$island['first']['txt_title'] ?></h1>
				<?php if(!empty($island['img_id'])): ?>
						<img class="main_image" title="<?=$island['img_title'] ?>" alt="<?=$island['img_title'] ?>" src="<?=$baseurl.'viewimage/'.$island['img_id']; ?>">
				<?php endif; ?>
						<?=$island['first']['txt_extended']; ?>
						<div class="clear"></div>
						<?php if($admin){?>
							<div class="admin-change">
								<?=anchor('edit/about-top','Редактировать текст'); ?>
							</div>
							<div class="admin-change">
							<?php $link = 'about/photo/manage'; ?>
							<?=anchor($link,'Доб./Удал. рисунки',array('class'=>'imagelink')); ?>
							</div>			
							<div class="clear"></div>
						<?php } ?>
					<?php for($i=0;$i<count($images);$i++):							
						if(isset($images[$i]['img_id'])):			
							$text = '<img class="row_image" alt="'.$images[$i]['img_title'].'" title="'.$images[$i]['img_title'].'" src="'.$baseurl.'viewimage/'.$images[$i]['img_id'].'">';
							$link = $baseurl.'viewslideshow/'.$images[$i]['img_id'];
							$attr = array('class'=>'pirobox_about','title'=>$images[$i]['img_title']);
							echo anchor($link,$text,$attr);	
						endif;
						if(($i+1) % 3 == 0)	echo '<br class="clear"/>';
						if(($i+1) == count($images)) echo '<br class="clear"/>';
					endfor; ?>
						
						<div class="clear"></div>
						<?=$island['second']['txt_extended']; ?>
						<?php if($admin):?>
							<div class="clear"></div>
							<div class="admin-change">
								<?=anchor('edit/about-buttom','Редактировать текст'); ?>
							</div>
						<?php endif; ?>
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