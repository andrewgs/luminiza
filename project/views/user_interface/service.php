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
					<h3>Список услуг</h3>
				<?=$text['sidebar']['sbt_extended']; ?>
				<?php if($admin): ?>
						<div class="admin-change">
							<?=anchor('edit/service/sidebar','Редактировать',array('class'=>'editlink'));?>
						</div>
				<?php endif; ?>
					<div class="miniature">
						<img title="Picasso Miniature" alt="Picasso Miniature" src="<?=$baseurl;?>images/service_miniature.png"/>
					</div>
				</div>
			</div>
			<div class="grid_9 alpha">
				<div class="main_content">
					<h1><?=$text['head']['txt_title']; ?></h1>
					<?=$text['head']['txt_extended'];
						if($admin): ?>
						<div class="admin-change">
							<?=anchor('edit/service','Редактировать',array('class'=>'editlink'));?>
						</div>
						<div class="admin-change">
							<?=anchor('service/photo/manage','Доб./Удал. рисунки',array('class'=>'editlink')); ?>
						</div>						
						<br class="clear"/>
					<?php endif; ?>
					<?php for($i=0;$i<count($service);$i++){							
							if(isset($service[$i]['img_id']))
								echo '<p><img class="row_image" alt="'.$service[$i]['img_title'].'"
									title="'.$service[$i]['img_title'].'"
									src="'.$baseurl.'viewimage/'.$service[$i]['img_id'].'">';
						
							if(($i+1) % 3 == 0)	echo '<br class="clear"/>';
							if(($i+1) == count($service)) echo '<br class="clear"/>';
						} ?>
					<br class="clear"/>
				<?php
					if($msg['status'] == 1):
							echo '<div class="message">';
								echo $msg['message'].'<br/>'.$msg['error'];
							echo '</div>';
							echo '<div class="clear"></div>';
						endif; ?>
				<?php if($this->uri->segment(1) == 'service'):?>
					<div id="kontakt" class="formmailer">
						<p>Используйте данную контакную форму, чтобы связаться с нами. Вы также можете написать нам напрямую по электронной почте. Для этого нажмите на ссылку: <?=safe_mailto('service@lum-tenerife.com','service@lum-tenerife.com'); ?><br><br></p>
						<?php $this->load->view('forms/formsendservice');?>
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
<?php $this->load->view('user_interface/yandex');?>
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
		function isValidEmailAddress(emailAddress){
			var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
			return pattern.test(emailAddress);
		};
	});
</script>
</body>
</html>