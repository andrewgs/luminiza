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
					<?php if($admin):?>
						<div class="admin-change">
							<?=anchor('edit/transfers/sidebar','Редактировать',array('class'=>'editlink'));?>
						</div>
					<?php endif; ?>
					<div class="miniature">
						<img title="Picasso Miniature" alt="Picasso Miniature" src="<?=$baseurl;?>images/transfers_miniature.png"/>
					</div>
				</div>
			</div>
			<div class="grid_9 alpha">
				<div class="main_content">
					<h1><?=$text['head']['txt_title']; ?></h1>
					<?=$text['head']['txt_extended'];
						if($admin): ?>
						<div class="admin-change">
							<?=anchor('edit/transfers','Редактировать текст',array('class'=>'editlink'));?>
						</div>
						<div class="admin-change">
							<?=anchor('transfers/photo/manage','Доб./Удал. рисунки',array('class'=>'editlink')); ?>
						</div>						
					<?php endif; ?>
					<br class="clear"/>
					<?php
						for($i=0;$i<count($transfer);$i++)
							if(isset($transfer[$i]['img_id']))
								echo '<img class="main_image" alt="'.$transfer[$i]['img_title'].'"
								title="'.$transfer[$i]['img_title'].'"
								src="'.$baseurl.'viewimage/'.$transfer[$i]['img_id'].'">';
						
						if($msg['status'] == 1):
							echo '<div class="message">';
								echo $msg['message'].'<br/>'.$msg['error'];
							echo '</div>';
							echo '<div class="clear"></div>';
						endif;?>
					<br class="clear"/>
					<div id="kontakt" class="formmailer">
						<p>Используйте данную контакную форму, чтобы связаться с нами. Вы также можете написать нам напрямую по электронной почте. Для этого нажмите на ссылку:
					<?=safe_mailto('info@lum-tenerife.com','info@lum-tenerife.com'); ?>
							<br><br>							
						</p>
					<?php	
						$attr = array(
									'id' => 'frmTransfer',
									'name' => 'frmTransfer',
									);
						echo form_open('mailsend',$attr);
							echo form_hidden('object','transfers');
							echo form_hidden('type','transfers');
							echo form_hidden('backuri','transfers');
							echo form_hidden('title','Трансферы');
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
							<?=form_error('your_arrival_date').'<div class="clear"></div>'; ?>
							<label for="your_arrival_date">Дата прилета <em class="bright">*</em></label>
							<div class="dd">
								<input type="text" size="45" maxlength="50" class="y_arrival_date inpval" id="your_arrival_date" value="" name="your_arrival_date">
							</div>							
							<div class="clear"></div>
							<?=form_error('textmail').'<div class="clear"></div>'; ?>
							<label for="msg">Сообщение <em class="bright">*</em></label>
							<div class="dd">
								<textarea class="y_msg inpval" id="msg" rows="5" cols="40" name="textmail"></textarea>
							</div>
							<div class="clear"></div>
							<label for="subject">Откуда Вы о нас узнали?</label>
							<div class="ddr">
								<input type="radio" value="0" name="your-subject" class="radio"/>Интернет <br/>
								<input type="radio" value="1" name="your-subject" class="radio"/>От друзей <br/>
								<input type="radio" value="2" name="your-subject" class="radio"/>Реклама <br/>
								<input type="radio" value="3" name="your-subject" class="radio"/>Другое 
								<input type="text" value="" id="your-subject_txt" name="your-subject_txt"/>
							</div>
							<div class="clear"></div>
							<button type="submit" border="0" id="send" class="senden" value="" name="Submit">Отправить</button>
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