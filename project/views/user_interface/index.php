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
	  <div class="cycle-blocks">
	  	<div class="container_12 clearfix">
	  		<div class="grid_12">
					<div class="slider-links">
						<ul>
							<li><?=anchor('retail','Продажа жилой и коммерческой недвижимости', 'id="property-sale"');?></li>
							<li><?=anchor('rent/retail','Аренда авто, апартаментов и вилл', 'id="property-rent"');?></li>
						</ul>
					</div>
				</div>
			</div>
	  </div>
	  <div id="subscription">
	  	<div class="container_12 clearfix">
	  		<div class="grid_12">
					<!-- Begin MailChimp Signup Form -->
					<form action="http://lum-tenerife.us2.list-manage.com/subscribe/post?u=1233aa73a3d329972e903fe7c&id=c7f9f8a222" method="post" name="mc-embedded-subscribe-form" target="_blank" id="mailchimp-form">
						<label for="mce-EMAIL">Получите <u>Исследование рынка недвижимости 2010/2011 бесплатно!</u></label>
						<input class="input" type="email" value="" name="EMAIL" class="email" placeholder="Введите ваш email" required>
						<input class="button" type="submit" value="Заказать" name="subscribe">
					</form>
					<!--End mc_embed_signup-->
				</div>
			</div>
	  </div>
	  <div id="main" role="main">
	  	<div class="container_12 clearfix">
	  		<div class="grid_8">
	  			<h1>Мировой уровень обслуживания клиентов на рынке недвижимости премиум класса</h1>
	  			Компания Luminiza Property Tur S.L. является одним из ведущих агентств недвижимости в Испании, 
	  			на Канарском архипелаге. Головной офис компании расположен на живописнейшем острове Тенерифе, 
	  			в престижном курортном городе Адехе. Компания работает на рынке недвижимости уже длительное время 
	  			и успела зарекомендовать себя как надежный и стабильный партнер, имея исключительно положительные 
	  			рекомендации от довольных клиентов. Сотрудники фирмы в полной мере владеют ситуацией на рынке 
	  			недвижимости и непрерывно держат руку на пульсе такого динамично развивающегося сегмента, как 
	  			рынок жилья! Наша компания поможет Вам оформить ипотеку на приобретение недвижимости на острове Тенерифе. 
	  		</div>
	  		<div class="grid_4">
		  		<h2>Справочная служба</h2>
					<!--
					<div class="side-phone"><span>Москва</span>8 (499) 245-33-44</div>
					<div class="side-phone"><span>Санкт-Петербург</span>8 (812) 427-12-20</div>
					-->
					<div class="side-phone"><span>Москва</span>8 (499) 703-37-25</div>
					<div class="side-phone"><span>Ростов-на-Дону</span>8 (918) 591-33-37</div>
					<div class="side-phone"><span>Тенерифе</span>8 10 34 678-283-024</div>
					<ul id="social-links">
						<li><a target="_blank" class="skype" href="#">lum-tenerife</a></li>
						<li><a target="_blank" class="facebook" href="http://www.facebook.com/pages/Luminiza-Property-Tur-SL/279976642024849">Facebook</a></li>
						<li><a target="_blank" class="vkontakte" href="http://vkontakte.ru/public31290203">Вконтакте</a></li>
						<li><a target="_blank" class="twitter" href="https://twitter.com/lumtenerife_ru">Twitter</a></li>
					</ul>
	  		</div>
	  		<div class="clear"></div>
	  		<div class="grid_4">
	  			<div class="chapter">
						<img src="<?=$baseurl;?>img/plus.png" />
						Совершать сделки с недвижимостью можно из любой точки мира и с любого компьютера, подключенного к Интернету.</div>
	  			<div class="chapter">
						<img src="<?=$baseurl;?>img/plus.png" />  				
						Оценка и определение рыночной стоимости недвижимости любого класса. Юридическое сопровождение сделок.<br/>
	  			</div> 
					<div class="chapter">
						<!--<a href="#">Узнайте о всех предоставляемых услугах</a>-->
					</div>
	  		</div>
	  		<div class="grid_4">
	  			<div class="chapter">
						<img src="<?=$baseurl;?>img/plus.png" />
						По любому возникшему у Вас вопросу обращайтесь за экспертной консультацией 24 часа в сутки 7 дней в неделю.</div>
	  			<div class="chapter">
						<img src="<?=$baseurl;?>img/plus.png" />
						Открытие банковских счетов и вкладов различного типа, оформление дебетовых и кредитных карточек.
					</div> 
	  		</div>
	  		<div id="testimonials" class="grid_4">
					<img src="<?=$baseurl;?>img/testimonials/1.png" alt=""/>
	  			<div class="author">Николай Пивоваров</div>
	  			<div class="city">Москва</div>
					«Процесс покупки Виллы на сайте компании занял у меня 15 минут. По прибытии на Тенерифе нас 
					встретили и разместили в отеле, все документы были уже готовы. Сразу же заключили договор о 
					долгосрочной аренде. Все деньги поступают мне на московский счет в банке.»
					<div>
						<!--<a href="#">Посмотреть еще отзывы</a>-->
					</div>
	  		</div>
			</div>
	  </div>
	  <div class="featured">
	  	<div class="container_12 clearfix">
	  		<div class="grid_8">
	  			<h2>Рекомендуемые предложения</h2>		
	  		</div>
	  		<div class="grid_4">
	  			<h2>Полезные материалы</h2>
	  		</div>
	  		<div class="clear"></div>
	  		<div class="grid_4">
	  			<a class="featured-link" href="#"><img alt="" src="<?=$baseurl;?>img/featured-1.png"></a>
	  		</div>
	  		<div class="grid_4">
	  			<a class="featured-link" href="#"><img alt="" src="<?=$baseurl;?>img/featured-2.png"></a>
	  		</div>
	  		<div id="usefull-links" class="grid_4">
	  			<ul>
	  				<li><a href="#">FAQ по покупке недвижимости</a></li>
	  				<!--
	  				<li><a href="#">Договор купли-продажи</a></li>
	  				<li><a href="#">Передаточный акт</a></li>
	  				-->
	  			</ul>
	  		</div>
	  	</div>
	  </div>
	  <?php $this->load->view('user_interface/footer');?>
	</div>
<?php $this->load->view('user_interface/scripts');?>
<?php $this->load->view('user_interface/yandex');?>
</body>
</html>