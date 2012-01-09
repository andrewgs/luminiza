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
	  			<h1>Недвижимость на Тенерифе. Продажа и аренда апартаментов эконом и премиум класса.</h1>
				<!--
	  			<p>Компания Luminiza Property Tur S.L. является одним из ведущих агентств недвижимости в Испании на Канарском архипелаге. 
				Головной офис компании расположен на живописнейшем острове Тенерифе, в престижном курортном городе Адехе. Компания 
				работает на рынке недвижимости уже длительное время и успела зарекомендовать себя как надежный и стабильный партнер, 
				имея исключительно положительные рекомендации от довольных клиентов.</p>
				-->
				<p>Жить на Канарских островах, а, тем более, отдохнуть на Канарах желают многие, но не все могут себе это позволить. 
				Вы прикоснетесь к сказке, если приобретете в собственность апартаменты на Тенерифе, одном из красивейших островов Канарского 
				архипелага. Недвижимость на Тенерифе сказочно красива и столь же сказочно разнообразна. Здесь Вы найдете все, что душа 
				пожелает, и, что не менее важно, кошелек позволит.</p>
				<p>На нашем сайте Вы можете купить недвижимость на Тенерифе недорого, потому что на нашем сайте концентрируются предложения 
				рынка со значительными скидками. Это нисколько не умоляет качества предложения, просто так складываются обстоятельства у 
				продавца. Быстрая продажа – это тоже наш сайт, предлагаем активно пользоваться продавцам открывшимися возможностями.</p>
				<p>Если купить недвижимость Вам пока не по средствам или Вы еще не готовы к этому шагу, то к вашим услугам аренда 
				недвижимости на Тенерифе на любой срок. Цены здесь тоже самые различные, как и сами предложения.</p>
				<p>И, конечно же, к Вашим услугам аренда автомобилей на Тенерифе, что весьма актуально для отдыхающих. На машине Вы сможете 
				полнее увидеть и оценить те красоты, которыми изобилует остров.</p>
	  		</div>
	  		<div class="grid_4">
		  		<h2>Справочная служба</h2>
					<div class="side-phone"><span>Москва</span>8 (918) 591-33-37</div>
					<div class="side-phone"><span>Тенерифе (Испания)</span>8 10 34 678-283-024</div>
					<div class="side-phone"><span>Электронная почта</span>info@lum-tenerife.com</div>
					<ul id="social-links">
						<li><a target="_blank" class="skype" href="#">lum-tenerife</a></li>
						<li><a target="_blank" class="facebook" href="http://www.facebook.com/pages/Luminiza-Property-Tur-SL/279976642024849">Facebook</a></li>
						<li><a target="_blank" class="vkontakte" href="http://vkontakte.ru/public31290203">Вконтакте</a></li>
						<li><a target="_blank" class="twitter" href="https://twitter.com/lumtenerife_ru">Twitter</a></li>
					</ul>
	  		</div>
	  		<div class="clear"></div>
			<div class="grid_8">
	  			<h2 class="margin">Приемущества работы с нами</h2>
	  		</div>
			<div class="grid_4">
	  			<h2 class="margin">Отзывы клиентов</h2>
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
					<?=anchor('services-provided','Узнайте о всех предоставляемых услугах');?>
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
		<?php if($feedback):?>
	  		<div class="grid_4 testimonials">
				<img src="<?=$baseurl;?>feedbackimage/<?=$feedback['fbk_id'];?>" alt="">
	  			<div class="author"><?=$feedback['fbk_fio'];?></div>
	  			<div class="city"><?=$feedback['fbk_region'];?></div>
					<?=$feedback['fbk_note'];?>
				<div><?=anchor('feedbacks','Посмотреть еще отзывы');?></div>
	  		</div>
		<?php endif;?>
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
