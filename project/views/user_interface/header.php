<header>
	<div class="container_12 clearfix">
		<div class="grid_6">
			<?=anchor('','Luminiza Property - Продажа и аренда недвижимости на Тенерифе', 'id="logo"');?>
		</div>
		<div class="grid_3 top-phone">8 (499) 703-00-78<span>Москва и Московская область</span></div>
		<div class="grid_3 top-phone last">8 10 34 678-283-024<span>Тенерифе (Канарские острова)</span></div>
	</div>
	<?php if($admin):?>
		<div style="position:absolute; top:75px;left:90%;">
			<span><?=anchor('feedback','Отзывы');?></span>
			<br/>
			<span><?=anchor('profile','Сменить пароль');?></span>
			<br/>
			<span><?=anchor('logoff','Завершить сеанс');?></span>
		</div>
		<?php endif;?>
</header>