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
					<h1>Контактная информация</h1>
					<?=$text['sidebar']['sbt_extended'];?>
				<?php if($admin):	?>
					<div class="admin-change">
						<?=anchor('edit/contacts/sidebar','Редактировать',array('class'=>'editlink')); ?>
					</div>
				<?php endif; ?>	
					<div class="miniature mt230">
						<img title="Picasso Miniature" alt="Picasso Miniature" src="<?=$baseurl;?>images/contacts_miniature.png"/>
					</div>
				</div>
			</div>
			<div class="grid_9 alpha">
				<div class="main_content">
					<h3><?=$text['head']['txt_title']; ?></h3>					
					<?php if($admin):?>
						<br class="clear"/>
						<div class="admin-change">
							<?=anchor('contacts/photo/change/'.$image['img_id'],'Изменить фото'); ?>
						</div>
						<div class="admin-change">
							<?=anchor('edit/contacts','Редактировать текст'); ?>
						</div>						
						<div class="clear"></div>
					<?php endif; ?>
					
					<!-- Display geocoding information and map -->
					<?php if(!empty($image['img_id'])): ?>		
					<img class="main_image" title="<?=$image['img_title'] ?>" alt="<?=$image['img_title'] ?>" src="<?=$baseurl.'viewimage/'.$image['img_id']; ?>">
					<?php endif; ?>
					<!--
					<div class="main_image" id="map_canvas" style="width:500px; height:300px;"></div>
					-->
					<?=$text['head']['txt_extended'];?>
					<div class="clear"></div>
					<?php if($msg['status'] == 1):
							echo '<div class="message">';
							echo $msg['message'].'<br/>'.$msg['error'];
							echo '</div>';
							echo '<div class="clear"></div>';
						endif; ?>
					
					<!-- Begin MailChimp Signup Form -->
					<div id="mc_embed_signup">
					<form action="http://lum-tenerife.us2.list-manage.com/subscribe/post?u=1233aa73a3d329972e903fe7c&amp;id=c7f9f8a222" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" style="padding: 10px 0;">
						<label for="mce-EMAIL">Подпишитесь на нашу рассылку и получайте по почте новые и специальные предложения</label>
						<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Email" required>
						<div class="clearfix"><input type="submit" value="Подписаться" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
					</form>
					</div>
					<!--End mc_embed_signup-->
					
					<div id="kontakt" class="formmailer">
						<p>Используйте данную контакную форму, чтобы связаться с нами. Вы также можете написать нам напрямую по электронной почте. Для этого нажмите на ссылку:
						<?=safe_mailto('info@lum-tenerife.com','info@lum-tenerife.com');?>
							<br/><br/>
						</p>
						<?php	
							$attr = array('id' => 'frmTransfer','name' => 'frmTransfer');
							echo form_open('mailsend',$attr);
							echo form_hidden('object','contacts');
							echo form_hidden('type','contacts');
							echo form_hidden('backuri','contacts');
							echo form_hidden('title','Контакты');
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
							<?=form_error('textmail').'<div class="clear"></div>'; ?>
							<label for="msg">Сообщение <em class="bright">*</em></label>
							<div class="dd">
								<textarea class="y_msg" id="msg" rows="5" cols="40" name="textmail"></textarea>
							</div>
							<div class="clear"></div>
							<input type="submit" border="0" class="senden" value="Отправить" name="Submit">
						<?php form_close(); ?>							
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
	<script type="text/javascript">
		function initialize(){var latlng = new google.maps.LatLng(28.0867700, -16.7352700);
		  var myOptions = {zoom: 17,center: latlng,mapTypeId: google.maps.MapTypeId.HYBRID};
		  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		  var marker = new google.maps.Marker({position: latlng,map: map,title:"Luminiza Property Tur S.L."});
		  setInterval(function() {if (marker.getAnimation() != null) {marker.setAnimation(null);}else{marker.setAnimation(google.maps.Animation.BOUNCE);}},10000);}
		function loadGoogleMapsAPI() {var script = document.createElement("script");script.type = "text/javascript";script.src = "http://maps.googleapis.com/maps/api/js?sensor=false&language=ru&callback=initialize";document.body.appendChild(script);}
	</script>
<?php $this->load->view('user_interface/yandex');?>
</body>
</html>