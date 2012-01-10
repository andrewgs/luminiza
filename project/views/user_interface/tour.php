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
					<?=$text['sidebar']['sbt_extended'];?>
					<?php if($admin): ?>
						<div class="admin-change">
							<?=anchor('edit/tour/sidebar','Редактировать',array('class'=>'editlink'));?>
						</div>
					<?php endif; ?>
					<div class="miniature">
						<img title="Picasso Miniature" alt="Picasso Miniature" src="<?=$baseurl;?>images/tour_miniature.png"/>
					</div>					
				</div>
			</div>
			<div class="grid_9 alpha">
				<div class="main_content">
					<h1><?= $text['head']['txt_title']; ?></h1>
					<?= $text['head']['txt_extended'];?>
					<br class="clear"/>
					<? if ($admin) : ?>
						<br class="clear"/>
						<div class="admin-change">
							<?= anchor('edit/tour','Редактировать текст',array('class'=>'editlink'));?>
						</div>
						<div class="admin-change">
							<?php $link = 'tour/insert'; ?>
							<?=anchor($link,'Добавить экскурсию',array('class'=>'insertlink')); ?>
						</div>
						<br class="clear"/>
					<? endif; ?>
					<table class="transfers tour">
					<? for ($i = 0; $i < count($tour); $i++): ?>
						<tr>
							<? if(isset($tour[$i]['img_id'])) : ?>
							<!--td><img alt="<?= $tour[$i]['img_title'] ?>" title="<?= $tour[$i]['img_title'] ?>" src="<?= $baseurl.'viewimage/'.$tour[$i]['img_id'] ?>" width="50px" /></td-->
							<? endif; ?>
							<td><?= anchor('tour/extended/'.$tour[$i]['tour_id'], $tour[$i]['tour_title'], array('title' => strip_tags($tour[$i]['tour_extended'])));?></td>
							<!--td><strong><?= $tour[$i]['tour_price']; ?> &euro;</strong></td-->
							<?php if($admin): ?>
							<td><?=anchor('edit/tour/'.$tour[$i]['tour_id'],'Ред.',array('class'=>'editlink')); ?></td>
							<td><?=anchor('tour/photo/manage/list/'.$tour[$i]['tour_id'],'Изм. рисунки',array('class'=>'editlink'));?></td>
							<td><?=anchor('tour/delete/'.$tour[$i]['tour_id'],'Удалить',array('class'=>'dellink'));?></td>
							<?php endif; ?>
						</tr>
					<?php endfor; ?>
					</table>
					<p>На нашем сайте вы можете заказать и оплатить экскурсии онлайн. После оплаты вам будут отправлены все платежные документы 
					и ваучер, подтверждающий ваше право на посещение экскурсии. Мы будем рады ответить на все возникшие вопросы по контактному телефону 
					<strong>(+34) 922-712-237</strong> или по электронной почте <?= safe_mailto('info@lum-tenerife.com', 'info@lum-tenerife.com'); ?></p>
					<p>Мы желаем Вам отличного отдыха на Тенерифе и ждём новых встреч с Вами.</p>
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
			$('div.missions_row:first').css('border-top', 'none').css('padding-top', 0);
			$('div.missions_row:last').css('border-bottom', 'none').css('padding-bottom', 0);
		});
	</script>	
<?php $this->load->view('user_interface/yandex');?>
</body>
</html>