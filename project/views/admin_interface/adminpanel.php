<!doctype html>
<html lang="en" class="no-js">
<head>
  <meta charset="utf-8">
  <meta name="description" content="<?=$pagevalue['description'] ?>">
  <meta name="author" content="<?=$pagevalue['author'] ?>">
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
  
  <title>Luminiza Property Tur S.L. | <?=$pagevalue['title'] ?></title>
  <?php
    define("CRLT", "\n");
	echo '<link rel="shortcut icon" href="'.$pagevalue['baseurl'].'favicon.ico">'.CRLT;
	echo '<link rel="stylesheet" href="'.$pagevalue['baseurl'].'css/style.css?v=1">'.CRLT;
	echo '<link rel="stylesheet" media="screen" href="'.$pagevalue['baseurl'].'css/1200.css"/>'.CRLT;
	echo '<link rel="stylesheet" media="handheld" href="'.$pagevalue['baseurl'].'css/handheld.css?v=1">'.CRLT;
	
	echo '<script src="'.$pagevalue['baseurl'].'js/modernizr-1.5.min.js"></script>'.CRLT;
  ?>
</head>

<!--[if lt IE 7 ]> <body class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <body class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body> <!--<![endif]-->
<body>
  <div id="container">
	<header>
		<div id="header_box">
			<div class="container_12">
				<div id="logo" class="grid_5">
				<?php
					echo anchor('admin','<img src="'.$pagevalue['baseurl'].'images/logo.png" alt="'.$pagevalue['title'].'">'); 
				?>
				</div>
				<div class="grid_7 omega">
					<ul class="header_nav">
						<li>Администрирование</li>
					</ul>
				</div>
				<div class="clear"></div>
			</div>
		</div>
    </header>
    
    <div id="content_box">
		<div class="content container_12">
			<div class="grid_3">
				<div class="sidebar">
					<ol>
					<?php
						echo '<li><a class="" href="'.$pagevalue['baseurl'].
							'admin/profile">Смена пароля администратора</a></li>';
						echo '<li><a class="" href="'.$pagevalue['baseurl'].
							'admin/logoff">Завершить сеанс</a></li>';
						echo '<li><a class="" href="'.$pagevalue['baseurl'].
							'">На главную страницу</a></li>';
					?>
					</ol>
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
					if(!empty($pagevalue['submenu'])){
						echo '<div class="formmailer">';
							echo $pagevalue['submenu'];
							echo '<hr>';
							echo '<hr>';
						echo '</div>';
					}
					if(!empty($pagevalue['menu'])){
						echo '<div class="formmailer">';
							echo $pagevalue['menu'];
					?>
							<hr>
							<table border="0" cellspacing="0" cellpadding="0" style="width:100%;">';
								<tr> 
									<td class='tableHeading' style='width:40%;'> 
										Название / Редактировать
									</td> 
									<td class='tableHeading' style='width:15%;'> 
										Счетчик
									</td> 
									<td  class='tableHeading'  style='width:15%;'> 
										Просмотр
									</td> 
									<td  class='tableHeading'  style='width:15%;'> 
										Доступ
									</td> 
									<td  class='tableHeading'  style='width:15%;'> 
										Удалить
									</td> 
								</tr> 
							</table>
							<hr>
					<?php
						echo '</div>';
					}
				?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
    </div>
	<footer>
    	<div id="footer_box"></div>	
		<div id="copyright_box">
			<div class="footer">
				<div class="copyright">
				  	<h2>
				  		<a class="devlink" href="http://realitygroup.ru" title="Сайт разработан творческой группой Реальность" target="_blank" >Разработано творческой группой Реальность</a>
		  			</h2>
					<p class="last">&copy; Copyright 2010 Luminiza Property Tur S.L. Все права защищены.</p>					</div>
				<div class="clear"></div>
			</div>
		</div>
	</footer>
</div>

	<!-- Javascript at the bottom for fast page loading -->
	<?php
		echo '<script src="'.$pagevalue['baseurl'].'js/jquery-1.4.2.min.js"></script>'.CRLT;
		echo '<script src="'.$pagevalue['baseurl'].'js/plugins.js?v=1"></script>'.CRLT;
		echo '<script src="'.$pagevalue['baseurl'].'js/script.js?v=1"></script>'.CRLT;
	?>

	<!--[if lt IE 7 ]>
	<?php
		echo '<script src="'.$pagevalue['baseurl'].'js/dd_belatedpng.js?v=1"></script>'.CRLT;
	?>
	<![endif]-->
</body>
</html>