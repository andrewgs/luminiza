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
					<div class="miniature">
						<img title="Picasso Miniature" alt="Picasso Miniature" src="<?=$baseurl;?>images/transfers_miniature.png"/>
					</div>
				</div>
			</div>
			<div class="grid_9 alpha">
				<div class="main_content">
					<h1>Проверьте правильность отправляемых данных</h1>
					<?php $place = array('','Северный аэропорт (Los Rodeos)','Южный аэропорт (Reina Sofia)','Лоро Парк (Loro Parque)'); ?><br/>
					<?= '<h4>Откуда/Куда: '.$place[$this->session->userdata('place')].'</h4>'; ?><br/>
					<?= '<h4>Дата: '.$this->session->userdata('date').'</h4>';?><br/>
					<?= '<h4>Пассажиры: </h4>';?><br/>
					<?= '<h4> - Взрослые: '.$this->session->userdata('adults').'</h4>';?><br/>
					<?= '<h4> - Дети: '.$this->session->userdata('children').'</h4>';?><br/>
					<?= '<h4> - Младенцы: '.$this->session->userdata('infants').'</h4>';?><br/>
					<?= '<h4>Контактное лицо: '.$this->session->userdata('name').'</h4>';?><br/>
					<?= '<h4>Номер телефона: '.$this->session->userdata('phone').'</h4>';?><br/>
					<?= '<h4>E-Mail: '.$this->session->userdata('email').'</h4>';?><br/>
					<?= '<h4>Примечания: </h4>'.$this->session->userdata('textmail');?><br/>
					<hr size="2"/>
					<button type="submit" border="0" id="prev" class="senden" value="prev" name="prev">Вернуться назад</button>
					<button type="submit" border="0" id="next" class="senden" value="next" name="next">Перейти к оплате</button>
					<br class="clear"/>
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
		$("#prev").click(function(){location.href="<?=$baseurl.$this->session->userdata('backpath');?>";return true;});
		$("#next").click(function(){location.href="http://bank.ru/";return true;});
	});
</script>
</body>
</html>