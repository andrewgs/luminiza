<!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
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
				<?php if($retailstatus): ?>
					<a class="crossing" href="<?=$baseurl.$retailback; ?>">&larr; Вернуться назад</a>
					<div class="clear"></div>
				<?php endif; ?>
					<ul>
						<li><?=anchor('retail','Жилая недвижимость');?></li>
						<li><?=anchor('commercial','Коммерческая недвижимость');?></li>
						<li><?=anchor('ipoteka','Ипотечный калькулятор');?></li>
					</ul>
					<h3>Рассчет ипотеки</h3>
					<form id="calc_2">
						<table class="retail-filter-table" border="0" width="100%">
							<tbody>
								<tr>
									<td>Стоимость недвижимости, €</td>
								</tr>
								<tr>									
									<td><input class="fld-mortgage" value="<?=$price;?>"id="calc_st"type="text" size="25" maxlength="9"></td>
								</tr>
								<tr>
									<td>Первоначальный взнос, €</td>
								</tr>
								<tr>
									<td><input class="fld-mortgage" id="calc_fir" type="text" size="25" maxlength="9"></td>
								</tr>
								<tr>
									<td>Годовая ставка, %</td>
								</tr>
								<tr>
									<td><input class="fld-mortgage" value="4" id="calc_per" type="text" size="25" maxlength="5"></td>
								</tr>
								<tr>
									<td>Срок кредита, мес</td>
								</tr>
								<tr>
									<td>
									<select class="fld-mortgage" id="calc_sr">
										<option value="60">60 (5 лет)</option>
										<option value="72">72 (6 лет)</option>
										<option value="84">84 (7 лет)</option>
										<option value="96">96 (8 лет)</option>
										<option value="108">108 (9 лет)</option>
										<option selected="selected" value="120">120 (10 лет)</option>
										<option value="180">180 (15 лет)</option>
										<option value="240">240 (20 лет)</option>
										<option value="300">300 (25 лет)</option>
										<option value="360">360 (30 лет)</option>
										<option value="420">420 (35 лет)</option>
									</select>
									</td>
								</tr>
								<tr>
									<td>
										<button id="calc_final_res" class="senden">Расcчитать</button>
									</td>
								</tr>
								<tr>
									<td>Сумма кредита, € <span id="calc_sum">&nbsp;</span></td>
								</tr>
								<tr>
									<td>Ежемесячный платеж, € <span id="calc_ej">&nbsp;</span></td>
								</tr>
							</tbody>
						</table>
					</form>
					<div class="miniature">
						<img title="Picasso Miniature" alt="Picasso Miniature" src="<?=$baseurl;?>images/service_miniature.png"/>
					</div>
				</div>
			</div>
			<div class="grid_9 alpha">
				<div class="main_content">
					<?=$text['title']['txt_extended']; ?>
					<?php if($admin){?>
						<div class="admin-change">
							<?=anchor('edit/ipoteka/title','Редактировать текст'); ?>
						</div>
						<div class="clear"></div>
					<?php } ?>
					<div class="clear"></div>
					<p class="section-header"><?=$text['fiz']['txt_title']; ?></p> 
					<?=$text['fiz']['txt_extended']; ?>
					<?php if($admin){?>
						<div class="admin-change">
							<?=anchor('edit/ipoteka/fiz','Редактировать текст'); ?>
						</div>
						<div class="clear"></div>
					<?php } ?>
					<div class="clear"></div>
					<p class="section-header"><?=$text['ur']['txt_title']; ?></p> 
					<?=$text['ur']['txt_extended']; ?>
					<?php if($admin){?>
						<div class="admin-change">
							<?=anchor('edit/ipoteka/ur','Редактировать текст'); ?>
						</div>
						<div class="clear"></div>
					<?php } ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
    </div>
    <?php $this->load->view('user_interface/footer');?>
	</div>
<?php $this->load->view('user_interface/scripts');?>
<?php $this->load->view('user_interface/yandex');?>
</body>
</html>