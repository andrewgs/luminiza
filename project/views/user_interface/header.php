<?php if($admin):?>
	<div class="admin-panel">
		<div class="container_12 clearfix">
			<div class="grid_12">
			<?php if(isset($ficha)):?>
				<?=anchor($ficha,'Ficha');?>
			<?php endif;?>
				<?=anchor('feedback','Отзывы');?>
				<?=anchor('profile','Сменить пароль');?>
				<?=anchor('logoff','Завершить сеанс');?>
			</div>
		</div>
	</div>
<?php endif;?>
<header>
	<div class="container_12 clearfix">
		<div class="grid_6">
			<?=anchor('','Luminiza Property - Продажа и аренда недвижимости на Тенерифе','id="logo"');?>
		</div>
		<div class="grid_3 top-phone">8 (499) 703-37-25<span>Москва и Московская область</span></div>
		<div class="grid_3 top-phone last">8 10 34 678-283-024<span>Тенерифе (Канарские острова)</span></div>
	</div>
</header>