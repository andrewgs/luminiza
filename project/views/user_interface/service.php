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
					<h3>Список услуг</h3>
				<?=$text['sidebar']['sbt_extended']; ?>
				<?php if($admin): ?>
						<div class="admin-change">
							<?=anchor('edit/service/sidebar','Редактировать',array('class'=>'editlink'));?>
						</div>
				<?php endif; ?>
					<div class="miniature">
						<img title="Picasso Miniature" alt="Picasso Miniature" src="<?=$baseurl;?>images/service_miniature.png"/>
					</div>
				</div>
			</div>
			<div class="grid_9 alpha">
				<div class="main_content">
					<h1><?=$text['head']['txt_title']; ?></h1>
					<?=$text['head']['txt_extended'];
						if($admin): ?>
						<div class="admin-change">
							<?=anchor('edit/service','Редактировать',array('class'=>'editlink'));?>
						</div>
						<div class="admin-change">
							<?=anchor('service/photo/manage','Доб./Удал. рисунки',array('class'=>'editlink')); ?>
						</div>						
						<br class="clear"/>
					<?php endif; ?>
					<?php for($i=0;$i<count($service);$i++){							
							if(isset($service[$i]['img_id']))
								echo '<p><img class="row_image" alt="'.$service[$i]['img_title'].'"
									title="'.$service[$i]['img_title'].'"
									src="'.$baseurl.'viewimage/'.$service[$i]['img_id'].'">';
						
							if(($i+1) % 3 == 0)	echo '<br class="clear"/>';
							if(($i+1) == count($service)) echo '<br class="clear"/>';
						} ?>
					<br class="clear"/>
				<?php
					if($msg['status'] == 1):
							echo '<div class="message">';
								echo $msg['message'].'<br/>'.$msg['error'];
							echo '</div>';
							echo '<div class="clear"></div>';
						endif; ?>
					<div id="kontakt" class="formmailer">
						<p>Используйте данную контакную форму, чтобы связаться с нами. Вы также можете написать нам напрямую по электронной почте. Для этого нажмите на ссылку:
							<?=safe_mailto('service@lum-tenerife.com','service@lum-tenerife.com'); ?>
							<br><br>							
						</p>
						
				<?php $attr = array('id' => 'frmTransfer','name' => 'frmTransfer');
						echo form_open('mailsend',$attr);
							echo form_hidden('object','service');
							echo form_hidden('type','service');
							echo form_hidden('backuri','service');
							echo form_hidden('title','Услуги');
							echo form_hidden('id','Отсутствует');
				?>
							<?=form_error('your_name').'<div class="clear"></div>'; ?>
							<label for="your_name">Ваше имя <em class="bright">*</em></label>
							<div class="dd">
								<input type="text" size="45" maxlength="50" class="y_name" id="your_name" value="" name="your_name">
							</div>
							<div class="clear"></div>
							<label for="your_phone">Телефон</label>
							<div class="dd">
								<input type="text" size="45" maxlength="50" class="y_phone" id="your_phone" value="" name="your_phone">
							</div>							
							<div class="clear"></div>
							<?=form_error('email').'<div class="clear"></div>'; ?>
							<label for="email">E-Mail <em class="bright">*</em></label>
							<div class="dd">
								<input type="text" size="45" maxlength="50" class="y_email" id="email" value="" name="email">
							</div>
							<div class="clear"></div>
							<?=form_error('your_arrival_date').'<div class="clear"></div>'; ?>
							<label for="your_arrival_date">Дата прилета <em class="bright">*</em></label>
							<div class="dd">
								<input type="text" size="45" maxlength="50" class="y_arrival_date" id="your_arrival_date" value="" name="your_arrival_date">
							</div>							
							<div class="clear"></div>
							<?=form_error('textmail').'<div class="clear"></div>'; ?>						
							<label for="msg">Сообщение <em class="bright">*</em></label>
							<div class="dd">
								<textarea class="y_msg" id="msg" rows="5" cols="40" name="textmail"></textarea>
							</div>
							<div class="clear"></div>
							<button type="submit" border="0" class="senden" value="" name="Submit">Заказать</button>					
					<?php	form_close(); ?>						
						<p>&nbsp;</p>
					</div>					
				</div>
			</div>
			<div class="clear"></div>
		</div>
    </div>
    <?php $this->load->view('user_interface/footer');?>
	</div>
<?php $this->load->view('user_interface/scripts');?>
<?php $this->load->view('user_interface/yandex');?>
</body>
</html>