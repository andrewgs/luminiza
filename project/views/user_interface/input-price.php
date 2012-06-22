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
						<?=form_open($this->uri->uri_string(),array('id'=>'frmTransfer'));?>
							<label for="name">Сумма</label>
							<div class="dd">
								<input type="text" size="45" maxlength="50" class="digital inpval" id="price" value="" name="price">
							</div>
							<div class="clear"></div>
							<button type="submit" id="send" class="senden" value="send" name="submit">Оплатить</button>
						<?=form_close(); ?>
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
		$("#price").val('');
		<?php if($msg):?>
			$.jGrowl("<?=$msg;?>",{header:'Форма заказа'});
		<?php endif;?>
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