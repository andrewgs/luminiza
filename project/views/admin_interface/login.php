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
						$attr = array('name' => 'formlogin','id' => 'formlogin', 'accept-charset' => 'UTF-8');
						echo form_open('login',$attr);
							echo form_label('Логин:','login');
							$attr = array(
								'name' 		=> 'login',
								'id'   		=> 'usrlogin',
								'value'		=> $login,
								'maxlength'	=> '60',
								'size'		=> '30',
								);
							echo '<div class="dd">'.form_input($attr).'</div>';					
							echo form_label('Пароль: ','password');
							$attr = array(
								'name' 		=> 'password',
								'id'   		=> 'usrpassword',
								'value'		=> '',
								'maxlength'	=> '64',
								'size' 		=> '30',
								);
							echo '<div class="dd">'.form_password($attr).'</div>';
							?>
							<button type="submit" border="0" id="auth" class="senden" value="" name="btsabmit">Авторизация</button>
							<?php
						echo form_close(); 							
					?>
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
		$("#auth").click(function(event){
			var login = $("#usrlogin").val();
			var pass = $("#usrpassword").val();
			if(login == ''){
				event.preventDefault();
				$.jGrowl("Логин не может быть пустым",{header:'Авторизация'});
			}
			if(pass == ''){
				event.preventDefault();
				$.jGrowl("Пароль не может быть пустым",{header:'Авторизация'});
			}
		});
	});
</script>
</body>
</html>