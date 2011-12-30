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
			<div class="grid_12">
				<div class="">
					<hr size="2"/>
					<div>Общее количество объектов: <?=$pagevalue['apartcount']['all'];?></div>
					<div>Количество объектов (только продажа): <?=$pagevalue['apartcount']['retail'];?></div>
					<div>Количество объектов (только аренда): <?=$pagevalue['apartcount']['rent'];?></div>
					<div>Количество объектов (продажа и аренда): <?=$pagevalue['apartcount']['retail_rent'];?></div>
					<div>Количество объектов (комерческая): <?=$pagevalue['apartcount']['comercial'];?></div>
					<div class="clear"></div>
					<button type="button" class="senden ApartsView" style="float:right;">Показать/Скрыть список</button>
					<div class="clear"></div>
				</div>
				<div class="" id="ApartListTable" style="display:none;">
					<?php $this->load->view('forms/apartlisttable');?>
					<div class="clear"></div>
				</div>
				<div class="">
					<hr size="2"/>
					<div>Кличество автомобилей: <?=$pagevalue['autocount'];?></div>
					<div class="clear"></div>
					<button type="button" class="senden AutoView" style="float:right;">Показать/Скрыть список</button>
					<div class="clear"></div>
				</div>
				<div class="" id="OutoListTable" style="display:none;">
					<?php $this->load->view('forms/autolisttable');?>
					<div class="clear"></div>
				</div>
				<div class="">
					<hr size="2"/>
					<div>Кличество специальных предложений: <?=$pagevalue['specials'];?></div>
					<div>Кличество проданных объектов: <?=$pagevalue['sold'];?></div>
					<div class="clear"></div>
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
		$(".ApartsView").click(function(){$("#ApartListTable").slideToggle('slow');});
		$(".AutoView").click(function(){$("#OutoListTable").slideToggle('slow');});
	});
</script>
</body>
</html>