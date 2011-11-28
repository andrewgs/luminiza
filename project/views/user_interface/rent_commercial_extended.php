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
				<?php if($searchstatus): ?>
					<a class="crossing" href="<?=$baseurl.$searchback;?>">&larr; Вернуться к поиску</a>
					<div class="clear"></div>
				<?php endif; ?>
					<h3>Информация</h3>
					<?=$text['sidebar']['sbt_extended'] ?>
					<div class="miniature">
						<img title="Picasso Miniature" alt="Picasso Miniature" src="<?= $baseurl ?>images/auto_miniature.png"/>
					</div>
				</div>
			</div>
			<div class="grid_9 alpha">
				<div class="main_content">
						<div class="missions_row">
						<?php if(isset($rent['img_id'])):
								echo '<img alt="'.$rent['img_title'].'" title="'.$rent['img_title'].'" 
								src="'.$baseurl.'viewimage/'.$rent['img_id'].'">';
							endif; ?>
							<div class="missions_right_panel">
								<h1><?=$rent['title']; ?></h1>
							<?php if(isset($rent['extended']) and !empty($rent['extended'])): ?>
								<div> <?=$rent['extended'];?> </div>
							<?php endif; ?>
								<div class="car_preferences">
									<?=$rent['properties']; ?>
								</div>
								<div class="car_preferences">
									<?=$rent['price']; ?>
								</div>
							</div>
						</div>
					<?php for($i = 0;$i < count($images); $i++){							
						if(isset($images[$i]['img_id'])):
						
							$text = '<img class="row_image" alt="'.$images[$i]['img_title'].'" title="'.$images[$i]['img_title'].'" src="'.$baseurl.'viewimage/'.$images[$i]['img_id'].'">';
							$link = $baseurl.'viewslideshow/'.$images[$i]['img_id'];
							$attr = array('class'=>'pirobox_rent','title'=>$images[$i]['img_title']);
							echo anchor($link,$text,$attr);
						endif;
						
						if(($i+1) % 3 == 0)	echo '<br class="clear"/>';
						if(($i+1) == count($images)) echo '<br class="clear"/>';
					}
						if($msg['status'] == 1){
							echo '<div class="message">';
								echo $msg['message'].'<br/>'.$msg['error'];
							echo '</div>';
							echo '<div class="clear"></div>';
						}
					?>
					<div id="kontakt" class="formmailer">
						<p>Используйте данную контакную форму, чтобы связаться с нами и произвести заказ<br><br> 
						</p>
					<?php
						$attr = array(
									'id' => 'frmTransfer',
									'name' => 'frmTransfer',
									);
						echo form_open('mailsend',$attr);
							echo form_hidden('id',$rent['id']);
							echo form_hidden('type',$rent['type']);
							echo form_hidden('backuri',$this->uri->uri_string());
							echo form_hidden('title',$rent['title']);
						?>
						<?=form_error('email').'<div class="clear"></div>'; ?>
							<label for="email">E-Mail <em class="bright">*</em></label>
							<div class="dd">
								<input type="text" size="45" maxlength="50" class="y_email" id="email" value="" name="email">
							</div>
							<div class="clear"></div>
						<?=form_error('your_name').'<div class="clear"></div>'; ?>
							<label for="your_name">Ваше имя <em class="bright">*</em></label>
							<div class="dd">
								<input type="text" size="45" maxlength="50" class="y_name" id="your_name" value="" name="your_name">
							</div>
							<div class="clear"></div>
							<?=form_error('your_lastname').'<div class="clear"></div>'; ?>
							<label for="your_lastname">Ваша фамилия <em class="bright">*</em></label>
							<div class="dd">
								<input type="text" size="45" maxlength="50" class="y_lastname" id="your_lastname" value="" name="your_lastname">
							</div>
							<div class="clear"></div>
							<?=form_error('your_bdate').'<div class="clear"></div>'; ?>
							<label for="your_bdate">Дата рождения <em class="bright">*</em></label>
							<div class="dd">
								<input type="text" size="45" maxlength="50" class="y_bdate" id="your_bdate" value="" name="your_bdate">
							</div>
							<div class="clear"></div>
						<?=form_error('your_address').'<div class="clear"></div>'; ?>
							<label for="your_address">Домашний адрес <em class="bright">*</em></label>
							<div class="dd">
								<textarea class="y_address" id="your_address" rows="2" cols="40" name="your_address"></textarea>
							</div>
							<div class="clear"></div>
						<?=form_error('your_rdate').'<div class="clear"></div>'; ?>
							<label for="your_rdate">Дата начала аренды <em class="bright">*</em></label>
							<div class="dd">
								<input type="text" size="45" maxlength="50" class="y_rdate" id="your_rdate" value="" name="your_rdate">
							</div>
							<div class="clear"></div>
							<?=form_error('your_bcdate').'<div class="clear"></div>'; ?>
							<label for="your_bcdate">Дата возвращения <em class="bright">*</em></label>
							<div class="dd">
								<input type="text" size="45" maxlength="50" class="y_bcdate" id="your_bcdate" value="" name="your_bcdate">
							</div>
							<div class="clear"></div>
							<button type="submit" border="0" class="senden" value="" name="Submit">Отправить запрос</button>
						<?=form_close(); ?>
						<p>&nbsp;</p>
					</div>							
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