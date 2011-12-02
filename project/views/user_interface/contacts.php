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
					<h2>Контактная информация</h2>
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
					<h1><?=$text['head']['txt_title']; ?></h1>
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
								<input type="text" size="45" maxlength="50" class="y_name inpval" id="your_name" value="" name="your_name">
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
								<input type="text" size="45" maxlength="50" class="y_email inpval" id="email" value="" name="email">
							</div>
							<div class="clear"></div>
							<?=form_error('textmail').'<div class="clear"></div>'; ?>
							<label for="msg">Сообщение <em class="bright">*</em></label>
							<div class="dd">
								<textarea class="y_msg inpval" id="msg" rows="5" cols="40" name="textmail"></textarea>
							</div>
							<div class="clear"></div>
							<input type="submit" border="0" id="send" class="senden" value="Отправить" name="Submit">
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
<?php $this->load->view('user_interface/yandex');?>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if($msg):?>
			$.jGrowl("<?=$msg;?>",{header:'Контакная форма'});
		<?php endif;?>
		$("#send").click(function(event){
			var err = false;
			var email = $("#email").val();
			$(".inpval").css('border-color','#00ff00');
			$(".inpval").each(function(i,element){if($(this).val()===''){$(this).css('border-color','#ff0000');err = true;}});
			if(err){
				$.jGrowl("Поля не могут быть пустыми",{header:'Контакная форма'});
				event.preventDefault();
			}else if(!isValidEmailAddress(email)){
				$("#email").css('border-color','#ff0000');
				$.jGrowl("Не верный адрес E-Mail",{header:'Форма обратной связи'});
				event.preventDefault();
			}
		});
		function isValidEmailAddress(emailAddress){
			var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
			return pattern.test(emailAddress);
		};
	});
</script>
</body>
</html>