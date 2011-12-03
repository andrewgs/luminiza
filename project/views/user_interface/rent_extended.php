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
					<ul>
						<li><?=anchor('rent/retail','Жилая недвижимость');?></li>
						<li><?=anchor('rent/commercial','Коммерческая недвижимость');?></li>
						<li><?=anchor('rent/auto','Аренда автомобилей');?></li>
					</ul>
					<h3>Информация</h3>
					<?=$text['sidebar']['sbt_extended'] ?>
					<div class="miniature">
						<img title="Picasso Miniature" alt="Picasso Miniature" src="<?=$baseurl;?>images/auto_miniature.png"/>
					</div>
				</div>
			</div>
			<div class="grid_9 alpha">
				<div class="main_content">
					<div class="missions_row">
						<div class="missions_right_panel extended">
							<h1><?= $rent['title']; ?></h1>
						<?php if(isset($rent['extended']) and !empty($rent['extended'])): ?>
							<div> <?= $rent['extended'];?> </div>
						<?php endif; ?>
						<?php if(isset($rent['properties']) and !empty($rent['properties'])): ?>
							<div class="car_preferences">
								<?= $rent['properties']; ?>
							</div>
						<? endif; ?>
							<div class="car_preferences">
								<?=$rent['price']; ?>
							</div>
						</div>
					</div>
				<?php if($admin):?>
					<?php if($this->uri->segment(2) == 'apartment'):?>
						<?php $link1 = 'edit/apartment/'.$rent['id'].'/rent';?>
						<?php $link2 = 'rent/photo/manage/apartment/'.$rent['id'];?>
						<?php $link3 = 'rent/apartment/delete/'.$rent['id']; ?>
					<?php else:?>
						<?php $link1 = 'edit/auto/'.$rent['id'].'/rent';?>
						<?php $link2 = 'rent/photo/manage/auto/'.$rent['id'];?>
						<?php $link3 = 'rent/auto/delete/'.$rent['id']; ?>
					<?php endif; ?>
					<div class="admin-change"><?=anchor($link1,'Ред.',array('class'=>'editlink'));?></div>
					<div class="admin-change"><?=anchor($link2,'Изм. фото',array('class'=>'editlink'));?></div>
					<div class="admin-change"><?=anchor($link3,'Удалить',array('class'=>'dellink'));?></div>
				<?php endif; ?>
					<div class="clear"></div>
					<?php
						if(isset($rent['img_id'])){
							echo '<img class="retail-preview" alt="'.$rent['img_title'].'" title="'.$rent['img_title'].'" src="'.$baseurl.'viewslideshow/'.$rent['img_id'].'">';
						}
					?>
					<?php for($i = 0;$i < count($images); $i++){							
						if(isset($images[$i]['img_id'])):
						
							$text = '<img class="row_image thumb" alt="'.$images[$i]['img_title'].'" title="'.$images[$i]['img_title'].'" src="'.$baseurl.'viewimage/'.$images[$i]['img_id'].'">';
							$link = $baseurl.'viewslideshow/'.$images[$i]['img_id'];
							$attr = array('class'=>'pirobox_rent','title'=>$images[$i]['img_title']);
							echo anchor($link,$text,$attr);
						endif;
						
						//if(($i+1) % 3 == 0)	echo '<br class="clear"/>';
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
						<p>Используйте данную контакную форму, чтобы связаться с нами и заказать <?=($rent['object'] == 'auto')? 'понравившийся Вам автомобиль.': 'понравившиеся апартаменты';?><br><br> 
						</p>
					<?=form_open('mailsend',array('id' => 'frmTransfer','name' => 'frmTransfer'));
							if($rent['object'] == 'apartment'):
								echo form_hidden(array('object'=>'apartment','id'=>$rent['id']));
							endif;
							echo form_hidden('id',$id);
							echo form_hidden('type',$type);
							echo form_hidden('backuri',$this->uri->uri_string());
							echo form_hidden('title',$rent['title']);
						?>
						<?=form_error('email').'<div class="clear"></div>'; ?>
							<label for="email">E-Mail <em class="bright">*</em></label>
							<div class="dd">
								<input type="text" size="45" maxlength="50" class="y_email inpval" id="email" value="" name="email">
							</div>
							<div class="clear"></div>
						<?=form_error('your_name').'<div class="clear"></div>'; ?>
							<label for="your_name">Ваше имя <em class="bright">*</em></label>
							<div class="dd">
								<input type="text" size="45" maxlength="50" class="y_name inpval" id="your_name" value="" name="your_name">
							</div>
							<div class="clear"></div>
							<?=form_error('your_lastname').'<div class="clear"></div>'; ?>
							<label for="your_lastname">Ваша фамилия <em class="bright">*</em></label>
							<div class="dd">
								<input type="text" size="45" maxlength="50" class="y_lastname inpval" id="your_lastname" value="" name="your_lastname">
							</div>
							<div class="clear"></div>
							<?=form_error('max_budget').'<div class="clear"></div>'; ?>
							<label for="max_budget">Максимальный бюджет <em class="bright">*</em></label>
							<div class="dd">
							<input type="text" size="45" maxlength="50" class="max_budget inpval" id="max_budget" value="" name="max_budget">
							</div>
							<div class="clear"></div>
							<?=form_error('number_people').'<div class="clear"></div>'; ?>
							<label for="number_people">Количество людей <em class="bright">*</em></label>
							<div class="dd">
							<input type="text" size="45" maxlength="50" class="number_people inpval" id="number_people" value="" name="number_people">
							</div>
							<div class="clear"></div>
							<?=form_error('number_children').'<div class="clear"></div>'; ?>
							<label for="number_children">Количество детей <em class="bright">*</em></label>
							<div class="dd">
							<input type="text" size="45" maxlength="50" class="number_children inpval" id="number_children" value="" name="number_children">
							</div>
							<div class="clear"></div>
						<?php if($rent['object'] == 'auto'):
								$data = array('object'=>'auto','id'=>$rent['id']);
								echo form_hidden($data).
								form_error('your_permit').'<div class="clear"></div><label for="your_permit">Номер водительских прав <em class="bright">*</em></label><div class="dd"><input type="text" size="45" maxlength="50" class="y_permit inpval" id="your_permit" value="" name="your_permit"></div><div class="clear"></div>'.form_error('your_pdate').'<div class="clear"></div><label for="your_pdate">Дата получения <em class="bright">*</em></label><div class="dd"><input type="text" size="45" maxlength="50" class="y_pdate inpval" id="your_pdate" value="" name="your_pdate"></div><div class="clear"></div>'.form_error('your_country').'<div class="clear"></div><label for="your_country">Страна получения <em class="bright">*</em></label><div class="dd"><input type="text" size="45" maxlength="50" class="y_country inpval" id="your_country" value="" name="your_country"></div><div class="clear"></div>';
							endif; ?>
						<?php if ($rent['object'] == 'auto'):
								echo form_error('your_car').'<div class="clear"></div><label for="your_car">Модель автомобиля <em class="bright">*</em></label><div class="dd"><input type="text" size="45" maxlength="50" class="y_car inpval" id="your_car" value="" name="your_car"></div><div class="clear"></div>';
							endif; ?>
						<?=form_error('your_rdate').'<div class="clear"></div>'; ?>
							<label for="your_rdate">Дата начала аренды <em class="bright">*</em></label>
							<div class="dd">
								<input type="text" size="45" maxlength="50" class="y_rdate inpval" id="your_rdate" value="" name="your_rdate">
							</div>
							<div class="clear"></div>
							<?=form_error('your_bcdate').'<div class="clear"></div>'; ?>
							<label for="your_bcdate">Дата возвращения <em class="bright">*</em></label>
							<div class="dd">
								<input type="text" size="45" maxlength="50" class="y_bcdate inpval" id="your_bcdate" value="" name="your_bcdate">
							</div>
							<div class="clear"></div>
						<?php if ($rent['object'] == 'auto'):
								echo '<label for="place">Где Вы собираетесь забрать автомобиль? </label><div class="ddr"><input type="radio" value="0" name="place" class="radio"/>В аэропорту <br/><input type="radio" value="1" name="place" class="radio"/>В отеле</div><div class="clear"></div>';
							endif; ?>
							<button type="submit" border="0" id="send" class="senden" value="" name="Submit">Отправить запрос</button>
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
		$('a.dellink').confirm({timeout:5000,dialogShow:'fadeIn', dialogSpeed:'slow',buttons:{ok:'Подтвердить',cancel:'Отмена',wrapper:'<button></button>',separator:' '}});
		function isValidEmailAddress(emailAddress){
			var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
			return pattern.test(emailAddress);
		};
	});
</script>
</body>
</html>