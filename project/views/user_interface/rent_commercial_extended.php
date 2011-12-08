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
				<?php else:?>
					<a class="crossing" href="<?=$baseurl.$backpath;?>">&larr; Вернуться к списку</a>
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
							<h1><?=$rent['title']; ?></h1>
						<?php if(isset($rent['extended']) and !empty($rent['extended'])): ?>
							<div><?=$rent['extended'];?> </div>
						<?php endif; ?>
							<div class="car_preferences"><?=$rent['properties'];?></div>
							<div class="car_preferences"><?=$rent['price'];?></div>
						</div>
					</div>
				<?php if($admin):?>
					<div class="admin-change">
						<?=anchor('edit/commercial/'.$rent['id'].'/rent','Редактировать',array('class'=>'editlink'));?>
					</div>
					<div class="admin-change">
						<?=anchor('rent/photo/manage/commercial/'.$rent['id'],'Доб./Удал. рисунки',array('class'=>'editlink'));?>
					</div>
					<div class="admin-change">
						<?=anchor('rent/commercial/delete/'.$rent['id'],'Удалить недвижимость',array('class'=>'dellink'));?>
					</div>
				<?php endif; ?>
					<div class="photo-wrapper">
						<div id="photo-slider">
							<?php for($i=0;$i<count($images);$i++) : ?>
								<img alt="<?=$images[$i]['img_title'] ?>" width="520px" height="390px" title="<?=$images[$i]['img_title'] ?>" src="<?=$baseurl.'viewslideshow/'.$images[$i]['img_id'] ?>">
							<?php endfor; ?>
						</div>
						<div id="photo-thumbs"> </div>
						<div class="clear"></div>
					</div>
				<div>
	<?=anchor('rent/commercial/extended/'.$rent['id'].'/print-view','Версия для печати',array('class'=>'retail_link','target'=>'_blank'));?>
				</div>
				<?php if($this->uri->segment(1) == 'rent'):?>
					<div id="kontakt" class="formmailer">
						<p>Используйте данную контакную форму, чтобы связаться с нами и произвести заказ<br><br></p>
					<?php $this->load->view('forms/formsendrentapart');?>
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
<?php $this->load->view('user_interface/cycle');?>
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
		$('div.missions_row:first').css('border-top', 'none').css('padding-top', 0);
		$('div.missions_row:last').css('border-bottom', 'none').css('padding-bottom', 0);
	});
</script>
</body>
</html>