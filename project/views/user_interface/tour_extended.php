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
					<h1><?=$tour['tour_title']; ?> <a href="#kontakt" class="colorful">Купить экскурсию</a></h1>
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
<?php $this->load->view('user_interface/datepicker');?>
<?php $this->load->view('user_interface/yandex');?>
<?php $this->load->view('user_interface/pirobox');?>
<script src="<?=$baseurl;?>js/tours.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var price = 0;
		var tprice = <?=$tour['tour_price'];?>;
		var adults = parseFloat($("#adults").val());
		var children = parseFloat($("#children").val());
		var infants = parseFloat($("#infants").val());
		$("#TotalPrice").html(tours[<?=$tour['tour_id'];?>].cprice(tprice,adults,children,infants));
		$("#price").val(tours[<?=$tour['tour_id'];?>].cprice(tprice,adults,children,infants));
		
		<?php if($msg):?>
			$.jGrowl("<?=$msg;?>",{header:'Контакная форма'});
		<?php endif;?>
		$("#date").datepicker({minDate: 0,maxDate: "+1M"});
		
		$("#send").click(function(event){
			var err = false;
			var mpeople = <?=$tour['tour_people'];?>;
			var email = $("#email").val();
			var phone = $("#phone").val();
			var tpeople = parseFloat($("#adults").val())+parseFloat($("#children").val())+parseFloat($("#infants").val());
			$(".ppl").css('border-color','#00ff00');
			$(".inpval").css('border-color','#00ff00');
			$(".inpval").each(function(i,element){if($(this).val()===''){$(this).css('border-color','#ff0000');err = true;}});
			if(err){
				$.jGrowl("Поля не могут быть пустыми",{header:'Контакная форма'});
				event.preventDefault();
			}else if(!isValidEmailAddress(email)){
				$("#email").css('border-color','#ff0000');
				$.jGrowl("Не верный адрес E-Mail",{header:'Форма обратной связи'});
				event.preventDefault();
			}else if(isValidPeople(tpeople)){
				people = parseFloat($("#adults").val())+parseFloat($("#children").val())*0.5;
//				var price = pricing(tprice,people);
				var price = tours[<?=$tour['tour_id'];?>].cprice(tprice,people);
				$("#TotalPrice").html(price);
				$("#price").val(price);
			}
			if(!err && !isValidPhone(phone)){
				$("#phone").css('border-color','#ff0000');
				$.jGrowl("Не верный номер телефона",{header:'Форма заказа'});
				event.preventDefault();
			}
			if(!err && tpeople==mpeople){
				$(".ppl").css('border-color','#ff0000');
				$.jGrowl("Минимальное количество человек равно "+mpeople,{header:'Форма заказа'});
				event.preventDefault();
			}
		});
		
		$(".ppl").change(function(){
			var curVal = $(this).val();
			var adults = parseFloat($("#adults").val());
			var children = parseFloat($("#children").val());
			var infants = parseFloat($("#infants").val());
			var tpeople = adults+children+infants;
			if(tpeople > 8){
				$.jGrowl("Превышено количество пасажиров. Макс: 8 человек",{header:'Форма заказа'});
				var subPeople = 8-tpeople;
				if(subPeople < 0) $(this).val(curVal-Math.abs(subPeople)).attr('selected','selected');
				adults = parseFloat($("#adults").val()); children = parseFloat($("#children").val()); infants = parseFloat($("#infants").val());
				var price = tours[<?=$tour['tour_id'];?>].cprice(tprice,adults,children,infants);
//				var price = pricing(tprice,people);
				$("#TotalPrice").html(price);
				$("#price").val(price);
				return false;
			}else{
				adults = parseFloat($("#adults").val()); children = parseFloat($("#children").val()); infants = parseFloat($("#infants").val());
				var price = tours[<?=$tour['tour_id'];?>].cprice(tprice,adults,children,infants);
//				var price = pricing(tprice,people);
				$("#TotalPrice").html(price);
				$("#price").val(price);
			}
			
		});
		function pricing(tprice,people){return parseFloat(tprice*people);}
		
		$('a.dellink').confirm({timeout:5000,dialogShow:'fadeIn', dialogSpeed:'slow',buttons:{ok:'Подтвердить',cancel:'Отмена',wrapper:'<button></button>',separator:' '}});
		function isValidPhone(phoneNumber){
			var pattern = new RegExp(/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/i);
			return pattern.test(phoneNumber);
		};
		function isValidPeople(tpeople){
			if(tpeople > 8){
				$("#ppl").css('border-color','#ff0000');
				$.jGrowl("Превышено количество пасажиров. Макс: 8 человек",{header:'Форма заказа'});
				return false;
			}else{
				return true;
			}
		}
		function isValidEmailAddress(emailAddress){
			var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
			return pattern.test(emailAddress);
		};
		
		<?php if($this->session->userdata('torder')):?>
			$("#price").val("<?=$this->session->userdata('tprice');?>");
			$("#TotalPrice").html("<?=$this->session->userdata('tprice');?>"+".00");
			$("#date").val("<?=$this->session->userdata('date');?>");
			$("#adults").val(<?=$this->session->userdata('adults');?>);
			$("#children").val(<?=$this->session->userdata('children');?>);
			$("#infants").val(<?=$this->session->userdata('infants');?>);
			$("#name").val("<?=$this->session->userdata('name');?>");
			$("#phone").val("<?=$this->session->userdata('phone');?>");
			$("#email").val("<?=$this->session->userdata('email');?>");
			$("#note").val("<?=$this->session->userdata('note');?>");
		<?php endif;?>
		
	});
</script>
</body>
</html>