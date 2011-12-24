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
						<?php if(isset($sidebar['sbt_extended'])) echo $sidebar['sbt_extended']; ?>
						<?php if($admin): ?>
						<div class="admin-change">
							<?=anchor('edit/aviabileti/sidebar','Редактировать',array('class'=>'editlink')); ?>
						</div>
						<?php endif;?>
						<div class="miniature mt305">
						<img title="Picasso Miniature" alt="Picasso Miniature" src="<?=$baseurl;?>images/about_miniature.png"/>
						</div>
					</div>
				</div>
				<div class="grid_9 alpha">
					<div class="main_content">
						<h1>Покупка недвижимости online</h1>
						<div class="clear"></div>
						<form action="http://tpv.ceca.es:8000/cgi-bin/tpv" method="POST" enctype="application/x-www-formurlencoded">
							<input name="MerchantID" TYPE="hidden" value="##MerchantID##">
							<input name="AcquirerBIN" TYPE="hidden" value="##AcquirerBIN##">
							<input name="TerminalID" type="hidden" value="##TerminalID##">
							<input name="URL_OK" type="hidden" value="##URL_OK##">
							<input name="URL_NOK" type="hidden" value="##URL_NOK##">
							<input name="Firma" type="hidden" value="##Firma##">
							<input name="Cifrado" type="hidden" value="SHA1">
							<input name="Num_operacion" type="hidden" value="##Num_operacion##">
							<input name="Importe" type="hidden" value="##Importe##">
							<input name="TipoMoneda" type="hidden" value="978">
							<input name="Exponente" type="hidden" value="2">
							<input name="Pago_soportado" type="hidden" value="SSL">
							<input name="Pago_elegido" type="hidden" value="SSL">
							Номер карты: <input name="PAN" type="text" value=""><br>
							Срок действия:<input name="Caducidad" type="text" value=""><br>
							CVV2/CVC2: <input name="CVV2" type="text" value=""><br>
							<input name="Idioma" type="hidden" value="1">
							<input type="submit" value="Оплатить">
						</form>
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