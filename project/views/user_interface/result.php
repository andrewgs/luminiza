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
		<div id="content_box">
			<div class="content container_12">
				<div class="grid_3">
					<div class="sidebar">
						<ul>
							<li><?=anchor('retail','Жилая недвижимость');?></li>
							<li><?=anchor('commercial','Коммерческая недвижимость');?></li>
							<li><?=anchor('ipoteka','Ипотечный калькулятор');?></li>
						</ul>
						<?php $this->load->view('forms/formsearch');?>
						<h3>Информация</h3>
						<?php echo $text['sidebar']['sbt_extended']; ?>
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
						if(isset($text['pager']) and !empty($text['pager'])){
							echo '<ul class="pages top_pages">';
								echo '<li class="title">Страницы:</li>';
								echo $text['pager'];
							echo '</ul>';
						} ?>
					<?php for($i = 0;$i < count($apartment); $i++){ ?>
							<div class="missions_row">
							<?php
								if(!$apartment[$i]['apnt_flag']):
									echo '<div class="sell-date">Апартаменты выставлены на продажу</div>';
								elseif($apartment[$i]['apnt_flag'] == 1):
									echo '<div class="sell-date">Апартаменты сдаются в аренду</div>';
								else:
									echo '<div class="sell-date">Апартаменты сдаются в аренду и выставлены на продажу</div>';
								endif;
								if(isset($apartment[$i]['img_id']))
									echo '<img alt="'.$apartment[$i]['img_title'].'"
										title="'.$apartment[$i]['img_title'].'"
										src="'.$baseurl.'viewimage/'.$apartment[$i]['img_id'].'">';?>
								<div class="missions_right_panel">
									<?php if(!$apartment[$i]['apnt_flag']):
										$link = 'retail/apartment/'.$apartment[$i]['apnt_id'];
									elseif($apartment[$i]['apnt_flag'] == 1):
										$link = 'rent/apartment/'.$apartment[$i]['apnt_id'];
									else:
										$link = 'retail/apartment/'.$apartment[$i]['apnt_id'];
									endif;?>
								<?php if($apartment[$i]['apnt_flag'] != 1):?>
									<?php if(!empty($apartment[$i]['apnt_newprice'])):?>
									
									<h2><a href="<?=$baseurl.$link;?>"><?=$apartment[$i]['apnt_title'];?> (<strike><?=$apartment[$i]['apnt_newprice'];?></strike> <?=$apartment[$i]['apnt_price'];?> &euro;)</a></h2>
									<?php else:?>
									<h2><a href="<?=$baseurl.$link;?>"><?=$apartment[$i]['apnt_title'];?> (<?=$apartment[$i]['apnt_price'];?> &euro;)</a></h2>
									<?php endif;?>
								<?php else:?>
										<h2><a href="<?=$baseurl.$link;?>"><?=$apartment[$i]['apnt_title'];?></a></h2>
								<?php endif;?>
									<div class="car_preferences"><?=$apartment[$i]['apnt_extended'];?></div>
									<br class="clear"/>
									<p>
										<?=anchor($link,'Подробнее &rarr;',array('class'=>'retail_link'));?>
									</p>
								</div>
							</div>
					<?php } ?>
						<div class="clear"></div>
						<?php
						if(isset($text['pager']) and !empty($text['pager'])){
							echo '<ul class="pages top_pages">';
								echo '<li class="title">Страницы:</li>';
								echo $text['pager'];
							echo '</ul>';
						}
						?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
	    </div>
	    <?php $this->load->view('user_interface/footer');?>
	</div>
<?php $this->load->view('user_interface/scripts');?>
<?php $this->load->view('user_interface/yandex');?>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if($msg):?>
			$.jGrowl("<?=$msg;?>",{header:'Результат поиска'});
		<?php endif;?>
		$("#btsname").click(function(event){var strsearch = $("#sname").val();$("#sname").css('border-color','#00ff00');if(strsearch == ''){event.preventDefault();$("#sname").css('border-color','#ff0000');$.jGrowl("Поле не може быть пустым",{header:'Форма поиска'});}});
		$("#RangePrice").slider({range: true,min: <?=$lowprice;?>,max: <?=$topprice;?>,values:[<?=$lowpricev;?>,<?=$toppricev;?>],step: 50000,slide: function(event,ui){$("#lowprice").val(ui.values[0]);$("#topprice").val(ui.values[1]);}});
		$("#lowprice").val("<?=$lowpricev;?>");
		$("#topprice").val("<?=$toppricev;?>");
		$("#object").val(<?=$sobject;?>);
		$("#location").val(<?=$slocation;?>);
		$("#region").val(<?=$sregion;?>);
		<?php for($i=0;$i<count($sroom);$i++):?>
			$("#<?=$sroom[$i];?>").attr('checked','checked');
		<?php endfor;?>
	});
</script>
</body>
</html>