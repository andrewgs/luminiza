<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>  <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>  <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php $this->load->view('user_interface/head');?>
<body>
	<style type="text/css">
		html, body { height: 100%; width: 100%; overflow: hidden; }
	</style>
	<div id="kontakt" class="formmailer" style="margin: 20px;">
		<p>Используйте данную контакную форму, чтобы связаться с нами. Обратите внимание, что все поля обязательны для заполнения.</p>
		<p>Вы также можете позвонить нам по телефонам <strong><nobr>+7 909 836-36-66</nobr></strong> или <strong><nobr>+34 678-283-024</nobr></strong><br><br></p>
		<?php $this->load->view('forms/formsendcontact');?>
	</div>
	
	<table id="thanks" height="100%" width="100%" border="0" cellspacing="0" cellpadding="0" style="display: none;">
		<tr>
			<td align="center" style="vertical-align: middle;">
				<div style="width:300px;">
					<div style="margin-top:0; width:auto;" class="text">
						Большое спасибо за внимание к нашему агенству Luminiza Property Tur S.L.<br><br>
						В течение двух рабочих дней мы обязательно свяжемся с вами и уточним все необходимые детали.
					</div>
				</div>
			</td>
		</tr>
	</table>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
	<script defer src="<?=$baseurl;?>js/jquery.jgrowl.js"></script>
	<?php $this->load->view('user_interface/yandex');?>

	<script type="text/javascript">
		$(document).ready(function(){
			
			$("#send").click(function(e){
				e.preventDefault();
				
				var err = false;
				var name  = $("#name").val();
				var email = $("#email").val();
				var phone = $("#phone").val();
				var note  = $("#note").val();
				
				$(".inpval").css('border-color','#00ff00');
				$(".inpval").each(function() {
					if ( $(this).val() === '' ) {
						$(this).css('border-color','#ff0000');
						err = true;
					}
				});
				
				if (err) {
					$.jGrowl("Поля не могут быть пустыми");
				} 
				
				if( !isValidEmailAddress(email) ) {
					err = true;
					$("#email").css('border-color','#ff0000');
					$.jGrowl("Неверный адрес электронной почты");
				} 
				
				if ( !isValidPhone(phone) ) {
					err = true;
					$("#phone").css('border-color','#ff0000');
					$.jGrowl("Неверный номер телефона");
				}
				
				if (!err) {
					$.post('<?=$baseurl;?>contacts_popup', {
						"name"	: name,
						"email"	: email,
						"phone"	: phone,
						"note"	: note,
						"submit": 1,
						"rnd"	: (new Date).getTime()
					}, function(status) {
						$('#kontakt').hide();
						$(document.body).css('background-color', '#4D4D4D');
						if (status > 0) {
							// show thanks message
							$('#thanks').show();
						} else {
							// show error message
							$('div.text').html('К сожалению невозможно отправить ваше сообщение.<br><br>Вы можете связаться с нами по телефонам +7 909 836-36-66 или +34 678-283-024.');
							$('#thanks').show();
						}
					});
				}
				
				return false;
			});
			
			function isValidPhone(phoneNumber){
				var pattern = new RegExp(/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/i);
				return pattern.test(phoneNumber);
			};
			
			function isValidEmailAddress(emailAddress){
				var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
				return pattern.test(emailAddress);
			};
		});
	</script>
</body>
</html>