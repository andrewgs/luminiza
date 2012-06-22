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
						<div id="kontakt" class="formmailer">
							<p>Используйте форму для того, чтобы произвести оплату.</p>
							<FORM ACTION="https://pgw.ceca.es/cgi-bin/tpv" METHOD="POST" ENCTYPE="application/x-www-form-urlencoded"> 
								<INPUT NAME="MerchantID" TYPE="hidden" VALUE="102621166"> 
								<INPUT NAME="AcquirerBIN" TYPE="hidden" VALUE="0000554008"> 
								<INPUT NAME="TerminalID" TYPE="hidden" VALUE="00000003"> 
								<INPUT NAME="URL_OK" TYPE="hidden" VALUE="http://tpv.ceca.es:8000/cgi-bin/comunicacion-on-line"> 
								<INPUT NAME="URL_NOK" TYPE="hidden" VALUE="http://lum-tenerife.com"> 
								<INPUT NAME="Firma" TYPE="hidden" VALUE="3967a9ceb8024b252f80723991cbf0470663100a"> 
								<INPUT NAME="Cifrado" TYPE="hidden" VALUE="SHA1"> 
								<INPUT NAME="Num_operacion" TYPE="hidden" VALUE="000007">
								<div class="dd">
									<input type="text" id="priceval" class="digital inpval" value="" NAME="Importe">
								</div>							
								<div class="clear"></div> 
								<INPUT NAME="TipoMoneda" TYPE="hidden" VALUE="978"> 
								<INPUT NAME="Exponente" TYPE="hidden" VALUE="2"> 
								<INPUT NAME="Pago_soportado" TYPE="hidden" VALUE="SSL"> 
								<!--
								<p>Номер карты: <input name="PAN" type="text" value="5540500001000004"></p>
								<p>Срок действия: <input name="Caducidad" type="text" value="201112"></p>
								<p>CVV2/CVC2: <input name="CVV2" type="text" value="989"></p>
								-->
								<INPUT NAME="Idioma" TYPE="hidden" VALUE="6"> 
								<INPUT TYPE="submit" id="send" VALUE="Оплатить">
								<!--
								Key_encription+MerchantID+AcquirerBIN+TerminalID+No_operation+Amount+TypeCurrency+Exponent+ +String SHA1+URL_OK+URL_NOK
								64681300102621166000055400800000003000007100009782SHA1http://tpv.ceca.es:8000/cgi-bin/comunicacion-on-linehttp://lum-tenerife.com
								-->
							</FORM>
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
		
		$("#send").click(function(event){
			var err = false;
			$(".inpval").css('border-color','#00ff00');
			$(".inpval").each(function(i,element){if($(this).val()===''){$(this).css('border-color','#ff0000');err = true;}});
			if(err){$.jGrowl("Поле не может быть пустым",{header:'Форма заказа'});event.preventDefault();}
		});
		
		$(".digital").keypress(function(e){
			if(e.which!=8 && e.which!=46 && e.which!=0 && (e.which<48 || e.which>57)){return false;}
		});
	});
</script>
</body>
</html>