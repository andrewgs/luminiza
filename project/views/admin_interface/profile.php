<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>  <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>  <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<?php $this->load->view('admin_interface/head');?>
<body>
  <div id="container">
	<?php $this->load->view('admin_interface/header');?>   
    <div id="content_box">
		<div class="content container_12">
			<div class="grid_3">
				<div class="sidebar">
					<a class="crossing" href="<?=$pagevalue['baseurl'].$pagevalue['backpage']; ?>">&larr; Вернуться назад</a>
				</div>
			</div>
			<div class="grid_9 alpha">
				<div class="main_content">
					<?php
						if($msg['status'] == 1){
							echo '<div class="message">';
								echo $msg['message'].'<br/>'.$msg['error'];
							echo '</div>';
							echo '<div class="clear"></div>';
						}
					?>
					<div class="formmailer">
					<?php
						echo form_open('profile');
						echo form_hidden('id',$userinfo['usr_id']);
						
						echo form_error('oldpass').'<div class="clear"></div>';
						echo form_label('Старый пароль','userslabel');
						$attr = array(
								'name'		 => 'oldpass',
								'id'  		 => 'oldpass',
								'value'		 => '',
								'class'		=> 'inpval',
								'maxlength'	 => '70',
             					'size' 		 => '40'
								);
						echo '<div class="dd">'.form_password($attr).'</div>';
						echo form_error('newpass').'<div class="clear"></div>';
						echo form_label('Новый пароль','userslabel');
						$attr =array(
								'name'	 	=> 'newpass',
								'id'  		=> 'newpass',
								'value'		=> '',
								'class'		=> 'inpval',
								'maxlength'	=> '70',
             					'size' 		=> '40'
								);
						echo '<div class="dd">'.form_password($attr).'</div>';
						echo form_error('confirmpass').'<div class="clear"></div>';
						echo form_label('Подтверждение пароля','userslabel');
						$attr =array(
								'name'	 	=> 'confirmpass',
								'id'  		=> 'confirmpass',
								'value'		=> '',
								'maxlength'	=> '70',
								'class'		=> 'inpval',
             					'size' 		=> '40'
								);
						echo '<div class="dd">'.form_password($attr).'</div>';
					?>
					<button type="submit" border="0" id="save" class="senden" value="" name="btsabmit">Сохранить</button>
				<?=form_close();?>			
				</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
    </div>
	<?php $this->load->view('admin_interface/footer');?>
</div>
<?php $this->load->view('admin_interface/scripts');?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#save").click(function(event){
			var oldpass = $("#oldpass").val();
			var newpass = $("#newpass").val();
			var comfpass = $("#confirmpass").val();
			var err = false;
			$(".inpval").css('border-color','#00ff00');
			$(".inpval").each(function(i,element){if($(this).val()===''){$(this).css('border-color','#ff0000');err = true;}});
			if(err){
				$.jGrowl("Пароль не может быть пустым",{header:'Авторизация'});
				event.preventDefault();
			}
			if(newpass != comfpass &&!err){
				$("#newpass").css('border-color','#ff0000');
				$("#confirmpass").css('border-color','#ff0000');
				event.preventDefault();
				$.jGrowl("Пароли не совпадают",{header:'Авторизация'});
			}
		});
	});
</script>
</body>
</html>