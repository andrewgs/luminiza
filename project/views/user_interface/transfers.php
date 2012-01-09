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
					<h1><?=$text['head']['txt_title']; ?> <a href="#kontakt" class="colorful">Заказать трансфер</a></h1>
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
				<?php if($this->uri->segment(1) == 'transfers'):?>
					<div id="kontakt" class="formmailer">
						<p>Используйте данную контакную форму для того, чтобы оформить Ваш заказ. После оплаты заказа Вы получите на указанный Вами e-mail все платежные документы и ваучер, подтверждающий ваше право на трансфер. По всем вопросам Вы можете позвонить нам по телефону или написать по электронной почте.</p>
						<?php $this->load->view('forms/formsendtransfers');?>
					</div>
				<?php endif;?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
  </div>
  <?php $this->load->view('user_interface/footer');?>
	</div>
<?php $this->load->view('user_interface/scripts');?>
<?php $this->load->view('user_interface/datepicker');?>
<?php $this->load->view('user_interface/yandex');?>
<script type="text/javascript">
	$(document).ready(function(){
		var price = 0;
		$("#TotalPrice").html(pricing(1,1));
		$("#date").datepicker({minDate: 0,maxDate: "+1M"});
		<?php if($msg):?>
			$.jGrowl("<?=$msg;?>",{header:'Форма заказа'});
		<?php endif;?>
		$("#send").click(function(event){
			var err = false;
			var email = $("#email").val();
			var phone = $("#phone").val();
			$(".inpval").css('border-color','#00ff00');
			$(".inpval").each(function(i,element){if($(this).val()===''){$(this).css('border-color','#ff0000');err = true;}});
			if(err){
				$.jGrowl("Поля не могут быть пустыми",{header:'Форма заказа'});
				event.preventDefault();
			}else if(!isValidEmailAddress(email)){
				$("#email").css('border-color','#ff0000');
				$.jGrowl("Не верный адрес E-Mail",{header:'Форма заказа'});
				event.preventDefault();
			}else if(!isValidPhone(phone)){
				$("#phone").css('border-color','#ff0000');
				$.jGrowl("Не верный номер телефона",{header:'Форма заказа'});
				event.preventDefault();
			}else if(people > 8){
				$.jGrowl("Превышено количество пасажиров. Макс: 8 человек",{header:'Форма заказа'});
				event.preventDefault();
			}
		});
		
		$("#place").change(function(){
			var place = $("#place").val();
			var people = parseFloat($("#adults").val())+parseFloat($("#children").val())+parseFloat($("#infants").val());
			var price = pricing(place,people);
			$("#TotalPrice").html(price);
		});
		
		$(".short").change(function(){
			var curVal = $(this).val();
			var cAdults = parseFloat($("#adults").val());
			var cChildren = parseFloat($("#children").val());
			var cInfants = parseFloat($("#infants").val());
			var people = cAdults+cChildren+cInfants;
			if(people > 8){
				$.jGrowl("Превышено количество пасажиров. Макс: 8 человек",{header:'Форма заказа'});
				var subPeople = 8-people;
				if(subPeople < 0) $(this).val(curVal-Math.abs(subPeople)).attr('selected','selected');
				return false;
			}else{
				var place = $("#place").val();
				var price = pricing(place,people);
				$("#TotalPrice").html(price);
			}
			
		});
		
		function pricing(place,people){
			var price = "0.00";
			if(place == 1 && people <= 4) price = "90.00";
			if(place == 1 && people > 4) price = "120.00";
			if(place == 2 && people <= 4) price = "30.00";
			if(place == 2 && people > 4) price = "60.00";
			if(place == 3) price = "150.00";
			return price;
		}
		function isValidEmailAddress(emailAddress){
			var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
			return pattern.test(emailAddress);
		};
		function isValidPhone(phoneNumber){
			var pattern = new RegExp(/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/i);
			return pattern.test(phoneNumber);
		};
	});
</script>
</body>
</html>