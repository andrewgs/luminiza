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
						<?=$text['sidebar']['sbt_extended'];?>
						<?php if($admin):?>
							<div class="admin-change">
								<?=anchor('edit/retail/sidebar','Редактировать',array('class'=>'editlink'));?>
							</div>
						<?php endif; ?>
						<div class="miniature mt100">
						<img title="Picasso Miniature" alt="Picasso Miniature" src="<?=$baseurl?>images/retail_miniature.png"/>
						</div>
					</div>
				</div>
				<div class="grid_9 alpha">
					<div class="main_content">
						<h1><?=$text['head']['txt_title'];?></h1>
					<?php if($this->uri->total_segments()==1):?>
						<?=$text['head']['txt_extended'];?>
					<?php endif;?>
						<?php if($admin): ?>
							<div class="admin-change">
								<?=anchor('edit/retail','Редактировать',array('class'=>'editlink'));?>
							</div>
						<?php endif;?>
						<?php if(isset($text['pager']) and !empty($text['pager'])):
							echo '<ul class="pages top_pages">';
								echo '<li class="title">Страницы:</li>';
								echo $text['pager'];
								echo form_open($formsort,array('id'=>'sort-price'));
									echo form_hidden('sortlink',TRUE);
									$options = array();
									$options[0] = 'Без сортировки';
									$options[1] = 'Цены по возрастанию';
									$options[2] = 'Цены по убыванию';
									$attr = 'id="sort" class="ml10"';
									echo form_dropdown('sortvalue',$options,$softvalue,$attr);
									echo '<a class="action-sort" href="#">Изменить</a>';
								echo form_close();
							echo '</ul>';
						endif; ?>
					<?php if($admin): ?>
						<div class="admin-change">
							<?php $link = 'retail/insert/apartment'; ?>
							<?=anchor($link,'Добавить апартаменты',array('class'=>'insertlink')); ?>
						</div>
					<?php endif; ?>
					<?php for($i=0;$i<count($apartment);$i++): ?>		
							<div class="missions_row">
							<?php if(isset($apartment[$i]['img_id'])):?>
								<img alt="<?=$apartment[$i]['img_title'];?>" title="<?=$apartment[$i]['img_title'];?>" src="<?=$baseurl;?>viewimage/<?=$apartment[$i]['img_id'];?>">
							<?php endif;?>
								<div class="missions_right_panel">
							<?php if(!empty($apartment[$i]['apnt_newprice'])):?>
									<h2><a href="<?=$baseurl;?>retail/apartment/<?=$apartment[$i]['apnt_id'];?>"><?=$apartment[$i]['apnt_title'];?> (<strike><?=$apartment[$i]['apnt_newprice'];?></strike> <?=$apartment[$i]['apnt_price'];?> &euro;)</a></h2>
							<?php else:?>
									<h2><a href="<?=$baseurl;?>retail/apartment/<?=$apartment[$i]['apnt_id'];?>"><?=$apartment[$i]['apnt_title'];?> (<?=$apartment[$i]['apnt_price'];?> &euro;)</a></h2>
							<?php endif;?>
									<div class="car_preferences notmargin"><?=$apartment[$i]['apnt_extended'];?></div>
									<br class="clear"/>
									<p>
									<?=anchor('retail/apartment/'.$apartment[$i]['apnt_id'],'Подробнее &rarr;',array('class'=>'retail_link'));?>
									</p>
									<br class="clear"/>
								</div>
							</div>
							<?php if($admin): ?>
								<div class="admin-change">
									<?php $link = 'edit/apartment/'.$apartment[$i]['apnt_id'].'/retail'; ?>
									<?=anchor($link,'Редактировать',array('class'=>'editlink')); ?>
								</div>
								<div class="admin-change">
									<?php $link = 'retail/photo/manage/list/'.$apartment[$i]['apnt_id']; ?>
									<?=anchor($link,'Доб./Удал. рисунки',array('class'=>'imagelink')); ?>
								</div>
								<div class="admin-change">
									<?php $link = 'retail/apartment/delete/'.$apartment[$i]['apnt_id']; ?>
									<?=anchor($link,'Удалить апартаменты',array('class'=>'dellink')); ?>
								</div>
							<?php endif; ?>
					<?php endfor; ?>
						<div class="clear"></div>
					<?php if(isset($text['pager']) and !empty($text['pager'])):?>
							<ul class="pages top_pages">
								<li class="title">Страницы:</li>
								<?=$text['pager'];?>
							</ul>
					<?php endif; ?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
	  </div>
  <?php $this->load->view('user_interface/footer');?>
	</div>
<?php $this->load->view('user_interface/scripts');?>
	<script type="text/javascript"> 
		$(document).ready(function(){
			$('a.dellink').confirm({timeout:5000,dialogShow:'fadeIn', dialogSpeed:'slow',buttons:{ok:'Подтвердить',cancel:'Отмена',wrapper:'<button></button>',separator:' '}});
			$('a.action-sort').click(function(){$("#sort-price")[0].submit();});
			$("#btsname").click(function(event){
				var strsearch = $("#sname").val();
				$("#sname").css('border-color','#00ff00');
				if(strsearch == ''){
					event.preventDefault();
					$("#sname").css('border-color','#ff0000');
					$.jGrowl("Поле не може быть пустым",{header:'Форма поиска'});
				}
			});
			
			$('div.missions_row:first').css('border-top', 'none').css('padding-top', 0);
			$('div.missions_row:last').css('border-bottom', 'none').css('padding-bottom', 0);
		});
	</script>	
<?php $this->load->view('user_interface/yandex');?>
</body>
</html>