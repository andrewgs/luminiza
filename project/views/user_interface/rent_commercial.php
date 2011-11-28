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
					<ul>
						<li><?=anchor('rent/retail','Жилая недвижимость');?></li>
						<li><?=anchor('rent/commercial','Коммерческая недвижимость');?></li>
						<li><?=anchor('rent/auto','Аренда автомобилей');?></li>
					</ul>
					<h3>Информация</h3>
					<?=$text[1]['sidebar']['sbt_extended']; ?>
					<?php if($admin):?>
						<div class="admin-change">
							<?php $link = 'edit/rent/sidebar/commercial'; ?>
							<?=anchor($link,'Редактировать',array('class'=>'editlink')); ?>
						</div>
					<?php endif; ?>
					<div class="miniature">
						<img title="Picasso Miniature" alt="Picasso Miniature" src="<?=$baseurl;?>images/rent_miniature.png"/>
					</div>
				</div>
			</div>
				<div class="grid_9 alpha">
					<div class="main_content">
						<h1><?=$text[1]['head']['txt_title'] ?></h1>
					<?php if($this->uri->total_segments()==2):?>
						<?=$text[1]['head']['txt_extended']; ?>
					<?php endif;?>
						<?php if($admin): ?>
							<div class="admin-change">
								<?php $link = 'edit/rent/commercial'; ?>
								<?=anchor($link,'Редактировать',array('class'=>'editlink')); ?>
							</div>
						<?php endif; ?>
						
						<?php if(isset($pageslinks) and !empty($pageslinks)):
								echo '<ul class="pages top_pages">';
									echo '<li class="title">Страницы:</li>';
									echo $pageslinks;
								echo '</ul>';
							endif; ?>
						
						<?php if($admin): ?>
							<div class="admin-change">
								<?php $link = 'rent/insert/commercial'; ?>
								<?=anchor($link,'Добавить недвижимость',array('class'=>'insertlink')); ?>
							</div>
						<?php endif; ?>
				<?php for($i=0;$i<count($commercial);$i++): ?>		
						<div class="missions_row">
						<?php
							if(isset($commercial[$i]['img_id']))
								echo '<img alt="'.$commercial[$i]['img_title'].'"
									title="'.$commercial[$i]['img_title'].'"
									src="'.$baseurl.'viewimage/'.$commercial[$i]['img_id'].'">';
						?>
							<div class="missions_right_panel">
							<?='<h2><a href="'.$baseurl.'rent/commercial/extended/'.$commercial[$i]['apnt_id'].'">'.$commercial[$i]['apnt_title'].'</a></h2>';
								echo '<div class="car_preferences notmargin">'.$commercial[$i]['apnt_extended'].'</div>';?>
								<br class="clear"/>
								<p> <a <?='href="'.$baseurl.'rent/commercial/extended/'.$commercial[$i]['apnt_id'].'"'; ?> class="retail_link">Подробнее &rarr;</a> </p>
							</div>
						</div>
						<?php if($admin):?>
							<div class="admin-change">
							<?php 
								$link = 'edit/commercial/'.$commercial[$i]['apnt_id'].'/rent';
								echo anchor($link,'Редактировать',array('class'=>'editlink'));
							?>
							</div>
							<div class="admin-change">
							<?php 
								$link = 'rent/photo/manage/commercial/'.$commercial[$i]['apnt_id'];
								echo anchor($link,'Доб./Удал. рисунки',array('class'=>'editlink'));
							?>
							</div>
							<div class="admin-change">
							<?php 
								$link = 'rent/commercial/delete/'.$commercial[$i]['apnt_id'];
								echo anchor($link,'Удалить недвижимость',array('class'=>'dellink'));
							?>
							</div>
					<?php endif; ?>
				<?php endfor; ?>
					<div class="clear"></div>
				<?php if(isset($pageslinks) and !empty($pageslinks)):
						echo '<ul class="pages top_pages">';
							echo '<li class="title">Страницы:</li>';
							echo $pageslinks;
						echo '</ul>';
					endif; ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
  </div>  
	<?php $this->load->view('user_interface/footer');?>
	</div>
<?php $this->load->view('user_interface/scripts');?>
 	<script type="text/javascript"> 
		$(document).ready(function(){
			$('a.dellink').confirm({timeout:5000,dialogShow:'fadeIn', dialogSpeed:'slow',buttons:{ok:'Подтвердить',cancel:'Отмена',wrapper:'<button></button>',separator:' '}});
		});
	</script>	
<?php $this->load->view('user_interface/yandex');?>
</body>
</html>