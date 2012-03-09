<nav>
	<div class="container_12 clearfix">
		<div class="grid_6">
			<ul class="main-nav left">
				<li><?=anchor('/','Главная', 'id="ref-index"');?></li>
				<li><?=anchor('retail','Продажа', 'id="ref-sell"');?></li>
				<li><?=anchor('rent/retail','Аренда', 'id="ref-rent"');?></li>
				<li><?=anchor('rent/auto','Прокат авто', 'id="ref-rent-auto"');?></li>
				<li class="last"><?=anchor('tour','Экскурсии', 'id="ref-excursion"');?></li>
			</ul>
		</div>
		<div class="grid_6">
			<ul class="main-nav right">
				<li class="last"><?=anchor('blog','Блог', 'id="ref-blog" target="_blank"');?></li>
				<li><?=anchor('contacts','Контакты', 'id="ref-contacts"');?></li>
				<li><?=anchor('transfers','Трансферы', 'id="ref-transfers"');?></li>
				<li><?=anchor('service','Услуги', 'id="ref-services"');?></li>
				<li><?=anchor('aviabileti','Авиабилеты', 'id="ref-avia"');?></li>
			</ul>
		</div>
	</div>
</nav>