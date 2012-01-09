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
					<?=$text['sidebar']['sbt_extended'] ?>
					<div class="miniature">
						<img title="Picasso Miniature" alt="Picasso Miniature" src="<?=$baseurl;?>images/tour_miniature.png"/>
					</div>
				</div>
			</div>
			<div class="grid_9 alpha">
				<div class="main_content">
					<h1><?=$tour['tour_title']; ?> <a href="#kontakt" class="senden">Купить экскурсию</a></h1>
					<!--
					<h1>
						<?= $tour['tour_title']; ?> 
						<? if ($tour['tour_id'] == 4):
								$Key		 = "64681300";
								$MerchantID  = "102621166";
								$AcquirerBIN = "0000554008";
								$TerminalID  = "00000003";
								$OperationID = time();
								$Amount = "100";
								$TypeCurrency = "978";
								$Exponent = "2";
								$URL_OK = 'http://tpv.ceca.es:8000/cgi-bin/comunicacion-on-line';
								$URL_NOK = 'http://lum-tenerife.ru/tour/extended/4';
								$firma = sha1($Key.$MerchantID.$AcquirerBIN.$TerminalID.$OperationID.$Amount.$TypeCurrency.$Exponent.'SHA1'.$URL_OK.$URL_NOK); 
						?>
						<FORM ACTION="https://pgw.ceca.es/cgi-bin/tpv" METHOD="POST" ENCTYPE="application/x-www-form-urlencoded"> 
							<INPUT NAME="MerchantID" TYPE="hidden" VALUE="<?= $MerchantID; ?>"> 
							<INPUT NAME="AcquirerBIN" TYPE="hidden" VALUE="<?= $AcquirerBIN; ?>"> 
							<INPUT NAME="TerminalID" TYPE="hidden" VALUE="<?= $TerminalID; ?>"> 
							<INPUT NAME="URL_OK" TYPE="hidden" VALUE="<?= $URL_OK; ?>"> 
							<INPUT NAME="URL_NOK" TYPE="hidden" VALUE="<?= $URL_NOK; ?>"> 
							<INPUT NAME="Firma" TYPE="hidden" VALUE="<?= $firma; ?>"> 
							<INPUT NAME="Cifrado" TYPE="hidden" VALUE="SHA1"> 
							<INPUT NAME="Num_operacion" TYPE="hidden" VALUE="<?= $OperationID; ?>"> 
							<INPUT NAME="Importe" TYPE="hidden" VALUE="<?= $Amount; ?>"> 
							<INPUT NAME="TipoMoneda" TYPE="hidden" VALUE="<?= $TypeCurrency; ?>"> 
							<INPUT NAME="Exponente" TYPE="hidden" VALUE="<?= $Exponent;  ?>"> 
							<INPUT NAME="Pago_soportado" TYPE="hidden" VALUE="SSL">
							<INPUT NAME="Idioma" TYPE="hidden" VALUE="6"> 
							<input type="submit" class="senden" value="Купить">
							Key_encription+MerchantID+AcquirerBIN+TerminalID+No_operation+Amount+TypeCurrency+Exponent+ +String SHA1+URL_OK+URL_NOK
						</FORM>
						<? endif; ?>
					</h1>
					-->
					<?php if(isset($tour['img_id'])):
						echo '<img class="main_image" alt="'.$tour['img_title'].'"title="'.$tour['img_title'].'" src="'.$baseurl.'viewimage/'.$tour['img_id'].'">';
					endif; ?>
					<?=$tour['tour_extended'];?>
					<?php for($i=0;$i<count($images);$i++):
						if(isset($images[$i]['img_id'])):
							$text = '<img class="row_image" alt="'.$images[$i]['img_title'].'" title="'.$images[$i]['img_title'].'" src="'.$baseurl.'viewimage/'.$images[$i]['img_id'].'">';
							$link = $baseurl.'viewslideshow/'.$images[$i]['img_id'];
							$attr = array('class'=>'pirobox_tour','title'=>$images[$i]['img_title']);
							echo anchor($link,$text,$attr);	
						endif;
						if(($i+1) % 3 == 0)	echo '<br class="clear"/>';
						if(($i+1) == count($images)) echo '<br class="clear"/>';
					endfor; ?>
				<div class="clear"></div>
				<?php if($admin): ?>
					<div class="admin-change">
						<?=anchor('edit/tour/'.$tour['tour_id'],'Редактировать',array('class'=>'editlink')); ?>
					</div>
					<div class="admin-change">
					<?=anchor('tour/photo/manage/list/'.$tour['tour_id'],'Доб./Удал. рисунки',array('class'=>'editlink'));?>
					</div>
					<div class="admin-change">
					<?=anchor('tour/delete/'.$tour['tour_id'],'Удалить экскурсию',array('class'=>'dellink'));?>
					</div>
					<div class="clear"></div>
				<?php endif;?>
				<div class="clear"></div>
				<?php if($this->uri->segment(1) == 'tour'):?>
					<div id="kontakt" class="formmailer">
						<p>Используйте данную контакную форму для того, чтобы оформить Ваш заказ. После оплаты заказа Вы получите на указанный Вами e-mail все платежные документы и ваучер, подтверждающий ваше право на место в экскурсионном автобусе. По всем вопросам Вы можете позвонить нам по телефону или написать по электронной почте.</p>
						<?php $this->load->view('forms/formsendtour');?>
					</div>
				<?php endif;?>
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