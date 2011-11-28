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
						<h3>Поиск недвижимости</h3>
						<p>
							<table width="100%" border="0" class="retail-filter-table">
							<?php
								$attr = array('name'=>'frmsearch','id'=>'frmsearch');
								if(isset($selectvalue) and !empty($selectvalue))
									echo form_open('search',$attr);
									echo form_hidden('cntrec',$countrecord);
							?>
								<tbody>
									<tr><td>Объект</td></tr>
									<tr>
										<td>
										<?php
											$options = array();
											for($i = 0;$i < $countrecord['object'];$i++)
												$options[$i] = $selectvalue['object'][$i]['apnt_object'];
											$options[$countrecord['object']] = 'Любой объект';
											$attr = 'id="object" class="w215"';
											echo form_dropdown('object',$options,$countrecord['object'],$attr);
										?>
										</td>
									</tr>
									<tr><td>Местонахождение</td></tr>
									<tr>
										<td>
										<?php
											$options = array();
											for($i = 0;$i < $countrecord['location'];$i++)
												$options[$i] = $selectvalue['location'][$i]['apnt_location'];
											$options[$countrecord['location']] = 'Любое местонахождение';
											$attr = 'id="location" class="w215"';
											echo form_dropdown('location',$options,$countrecord['location'],$attr);
										?>
										</td>
									</tr>
									<tr><td>Район</td></tr>
									<tr>
										<td>
											<?php
											$options = array();
											for($i = 0;$i < $countrecord['region'];$i++)
												$options[$i] = $selectvalue['region'][$i]['apnt_region'];
											$options[$countrecord['region']] = 'Любой район';
											$attr = 'id="region" class="w215"';
											echo form_dropdown('region',$options,$countrecord['region'],$attr);
										?>
										</td>
									</tr>
									<tr><td>Количество комнат</td></tr>
									<tr>
										<td>
											<table class="tbl">
												<tbody>
												<?php for($i = 1;$i <= count($selectvalue['count']); $i++):
														$attr = array(
															'name'  => 'rooms_'.($i-1),
															'class' => 'rooms',
															'value' => $selectvalue['count'][$i-1]['apnt_count'],
															'checked'=> FALSE,
														);
														if($i % 2 == 0):
															echo '<td>';
															echo form_checkbox($attr).
																	$selectvalue['count'][$i-1]['apnt_count'];
															echo '</td></tr>';
														else:
															echo '<tr><td>';
															echo form_checkbox($attr).
																	$selectvalue['count'][$i-1]['apnt_count'];
															echo '</td>';
														endif;
														if($i == count($selectvalue['count'])) echo '</tr>';
													endfor; ?>
												</tbody>
											</table>
										</td>
									</tr>
									<tr>
										<td>
											<button type="submit" border="0" class="senden" value="" name="btsearch">Найти</button>
										</td>
									</tr>
								</tbody>
							<?= form_close();?>
							</table>
						</p>
						<p>&nbsp;</p>
						<h3>Информация</h3>
						<?=$text['sidebar']['sbt_extended'];
						if($admin):	?>
							<div class="admin-change">
								<?=anchor('edit/commercial/sidebar','Редактировать',array('class'=>'editlink'));?>
							</div>
						<?php endif; ?>
						<div class="miniature mt100">
							<img title="Picasso Miniature" alt="Picasso Miniature" src="<?=$baseurl;?>images/retail_miniature.png"/>
						</div>
					</div>
				</div>
				<div class="grid_9 alpha">
					<div class="main_content">
						<h1><?=$text['head']['txt_title']; ?></h1>
					<?php if($this->uri->total_segments()==1):?>
						<?=$text['head']['txt_extended'];?>
					<?php endif;?>
						<?php if($admin): ?>
							<div class="admin-change">
								<?= anchor('edit/commercial','Редактировать',array('class'=>'editlink'));?>
							</div>
						<?php endif; 
						if(isset($text['pager']) and !empty($text['pager'])){
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
						} ?>
					<?php if($admin): ?>
						<div class="admin-change">
							<?php $link = 'commercial/insert/retail'; ?>
							<?=anchor($link,'Добавить недвижимость',array('class'=>'insertlink')); ?>
						</div>
					<?php endif; ?>
					<?php for($i=0;$i<count($apartment);$i++): ?>		
							<div class="missions_row">
							<?php
								if(isset($apartment[$i]['img_id']))
									echo '<img alt="'.$apartment[$i]['img_title'].'"
										title="'.$apartment[$i]['img_title'].'"
										src="'.$baseurl.'viewimage/'.$apartment[$i]['img_id'].'">';
							?>
								<div class="missions_right_panel">
							<?php
								if(!empty($apartment[$i]['apnt_newprice'])):
									echo '<h2><a href="'.$baseurl.'retail/commercial/extended/'.$apartment[$i]['apnt_id'].'">'.$apartment[$i]['apnt_title'].' (<strike>'.$apartment[$i]['apnt_newprice'].'</strike> '.$apartment[$i]['apnt_price'].' &euro;)</a></h2>';
								else:
									echo '<h2><a href="'.'retail/commercial/extended/'.$apartment[$i]['apnt_id'].'">'.$apartment[$i]['apnt_title'].' ('.$apartment[$i]['apnt_price'].' &euro;)</a></h2>';
								endif;
									echo '<div class="car_preferences notmargin">'.$apartment[$i]['apnt_extended'].'</div>';
							?>
									<br class="clear"/>
									<p>
										<?=anchor('retail/commercial/extended/'.$apartment[$i]['apnt_id'],'Подробнее &rarr;',array('class'=>'retail_link'));?>
									</p>
									<br class="clear"/>
								</div>
							</div>
							<?php if($admin): ?>
								<div class="admin-change">
									<?php $link = 'edit/commercial/'.$apartment[$i]['apnt_id'].'/retail'; ?>
									<?=anchor($link,'Редактировать',array('class'=>'editlink')); ?>
								</div>
								<div class="admin-change">
									<?php $link = 'commercial/photo/manage/list/'.$apartment[$i]['apnt_id']; ?>
									<?=anchor($link,'Доб./Удал. рисунки',array('class'=>'imagelink')); ?>
								</div>
								<div class="admin-change">
									<?php $link = 'retail/commercial/delete/'.$apartment[$i]['apnt_id']; ?>
									<?=anchor($link,'Удалить недвижимость',array('class'=>'dellink')); ?>
								</div>
							<?php endif; ?>
					<?php endfor; ?>
						<div class="clear"></div>
					<?php if(isset($text['pager']) and !empty($text['pager'])):
							echo '<ul class="pages top_pages">';
								echo '<li class="title">Страницы:</li>';
								echo $text['pager'];
							echo '</ul>';
						endif; ?>
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
		});
	</script>	
<?php $this->load->view('user_interface/yandex');?>
</body>
</html>