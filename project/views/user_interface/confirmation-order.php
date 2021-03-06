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
					<p class="confirm-title">Проверьте правильность отправляемых данных</p>
				<?php $type = $this->uri->segment(1);?>
				<?php if($type == 'transfers'):?>
					<?php $place = array('','Северный аэропорт (Los Rodeos)','Южный аэропорт (Reina Sofia)','Лоро Парк (Loro Parque)'); ?>
					<p class="confirm"><strong>Откуда/Куда:</strong> <?= $place[$this->session->userdata('place')]; ?></p>
					<? $price = $this->session->userdata('trprice'); ?>					
				<?php endif;?>
				<?php if($type == 'tour'):?>
					<p class="confirm"><strong>Экскурсия:</strong> <?= $this->session->userdata('tour');?></p>
					<? $price = $this->session->userdata('tprice'); ?>
				<?php endif;?>
					<p class="confirm"><strong>Дата:</strong> <?= $this->session->userdata('date'); ?></p>
					<p class="confirm"><strong>Стоимость:</strong> <?=$price;?> &euro;</p>
					<p class="confirm"><strong>Пассажиры:</strong><br/>
					Взрослых <u><?=$this->session->userdata('adults');?> чел.</u>
					<? if ($this->session->userdata('children')) { ?><br/> Детей от 5 до 10 лет <u><?=$this->session->userdata('children');?> чел.</u><? } ?>
					<? if ($this->session->userdata('infants')) { ?><br/> Младенцев <u><?=$this->session->userdata('infants');?> чел.</u><? } ?></p>
					<p class="confirm"><strong>Контактное лицо:</strong> <?=$this->session->userdata('name');?></p>
					<p class="confirm"><strong>Номер телефона:</strong> <?=$this->session->userdata('phone');?></p>
					<p class="confirm"><strong>E-Mail:</strong> <?=$this->session->userdata('email');?></p>
				<?php if($type == 'transfers'):?>
					<p class="confirm"><strong>Номер авиарейса:</strong> <?=$this->session->userdata('flight'); ?></p>
				<?php endif;?>
					<p class="confirm"><strong>Примечание:</strong> <?=$this->session->userdata('note');?></p>
					<p class="confirm">&nbsp;</p>
					<?php 
						$Key		 = "64681300";
						$MerchantID  = "102621166";
						$AcquirerBIN = "0000554008";
						$TerminalID  = "00000003";
						$OperationID = time();
						$Amount = $amountval;
						$TypeCurrency = "978";
						$Exponent = "2";
						$URL_OK = $baseurl.$type.'/confirmation-of-order/success';
						$URL_NOK = $baseurl.$type.'/confirmation-of-order/error';
						$firma = sha1($Key.$MerchantID.$AcquirerBIN.$TerminalID.$OperationID.$Amount.$TypeCurrency.$Exponent.'SHA1'.$URL_OK.$URL_NOK);
					?>
					<form class="pay-form" ACTION="https://pgw.ceca.es/cgi-bin/tpv" METHOD="POST" ENCtype="application/x-www-form-urlencoded"> 
						<input name="MerchantID" type="hidden" value="<?= $MerchantID; ?>"> 
						<input name="AcquirerBIN" type="hidden" value="<?= $AcquirerBIN; ?>"> 
						<input name="TerminalID" type="hidden" value="<?= $TerminalID; ?>"> 
						<input name="URL_OK" type="hidden" value="<?= $URL_OK; ?>"> 
						<input name="URL_NOK" type="hidden" value="<?= $URL_NOK; ?>"> 
						<input name="Firma" type="hidden" value="<?= $firma; ?>"> 
						<input name="Cifrado" type="hidden" value="SHA1"> 
						<input name="Num_operacion" type="hidden" value="<?= $OperationID; ?>"> 
						<input name="Importe" type="hidden" value="<?= $Amount; ?>"> 
						<input name="TipoMoneda" type="hidden" value="<?= $TypeCurrency; ?>"> 
						<input name="Exponente" type="hidden" value="<?= $Exponent;  ?>"> 
						<input name="Pago_soportado" type="hidden" value="SSL">
						<input name="Idioma" type="hidden" value="6"> 
						<input type="submit" id="next" class="senden" value="Продолжить">
					</form>
					или <a href="#" id="prev">Вернуться назад</a>
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
		$("#prev").click(function(){location.href="<?=$baseurl.$backpath;?>#kontakt";return true;});
	});
</script>
</body>
</html>