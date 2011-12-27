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
					<?php if(isset($sidebar['sbt_extended'])) echo $sidebar['sbt_extended']; ?>
						<?php if($admin): ?>
						<div class="admin-change">
							<?=anchor('edit/feedbacks/sidebar','Редактировать',array('class'=>'editlink')); ?>
						</div>
						<?php endif;?>
						<div class="miniature mt305">
						<img title="Picasso Miniature" alt="Picasso Miniature" src="<?=$baseurl;?>images/about_miniature.png"/>
						</div>
					</div>
				</div>
				<div class="grid_9 alpha">
					<div class="main_content">
					<?php if($pager):?>
						<ul class="pages top_pages">
							<li class="title">Страницы:</li>
							<?=$pager;?>
						</ul>
					<?php endif; ?>
					<?php for($i=0;$i<count($feedbacks);$i++):?>
						<div class="testimonials <? if ($i == 0) { echo 'notmargin'; } ?>">
							<img src="<?=$baseurl;?>feedbackimage/<?=$feedbacks[$i]['fbk_id'];?>" alt="">
							<div class="author"><?=$feedbacks[$i]['fbk_fio'];?></div>
							<div class="city"><?=$feedbacks[$i]['fbk_region'];?></div>
							<?=$feedbacks[$i]['fbk_note'];?>
						</div>
					<?php endfor;?>
					<?php if($pager):?>
						<ul class="pages top_pages">
							<li class="title">Страницы:</li>
							<?=$pager;?>
						</ul>
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