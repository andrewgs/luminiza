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
					<a class="crossing" href="<?=$pagevalue['baseurl'].$pagevalue['backpath']; ?>">&larr; Вернуться назад</a>
				</div>
			</div>
			<div class="grid_9 alpha">
				<div class="main_content">
					<?php
					if($msg['status'] == 1){
						echo '<div class="message">';
							echo $msg['message'].'<br/>'.$msg['error'];
							echo $msg['saccessfull'];
						echo '</div>';
						echo '<div class="clear"></div>';
					}
					if(!$pagevalue['multi'] and $image){ ?>
					<img class="main_image" title="<?=$image['img_title'] ?>" alt="<?=$image['img_title'] ?>" src="<?=$pagevalue['baseurl'].'viewimage/'.$image['img_id']; ?>">
				<?php } ?>
					<div class="form-fileload">
					<?= '<fieldset class="field-upload">';
							echo '<legend><strong> Загрузка фотографии </strong></legend>';
							echo form_open_multipart($pagevalue['script'],array('id'=>'uploadform'));
								
								echo form_hidden('type',$pagevalue['type']);
								echo form_hidden('object',$pagevalue['object']);
								echo form_hidden('backpath',$pagevalue['backpath']);
								echo form_hidden('imgtype',$pagevalue['imgtype']);
								echo form_hidden('multi',$pagevalue['multi']);
								echo form_hidden('fulluri',$pagevalue['fulluri']);
								echo '<div>'.form_label('Описание: ','slidelabel');
								$attr = array('name'=>'imagetitle','id'=>'newslidertitle','value'=>'','class'=>'textfield inpval','maxlength'=>'100','size'=>'50');
							if(!$pagevalue['multi'] and $image){
								$attr['value'] = $image['img_title'];
								echo form_hidden('id',$image['img_id']);
								echo form_input($attr).'</div>';
							}else{
								$attr['value'] = '';
								echo form_input($attr).'</div>';
							}
								echo '<div>'.form_label('Выбирите фото: ','slidelabel');
								$attr = array('type'=>'file','name'=>'userfile','id'=>'uploadimage','class'=>'inpval','accept'=>'image/jpeg,png,gif','size'=>33);
								echo form_input($attr).'</div>';
								echo '<hr>';
								echo '<div>'.form_label('Ширина рисунка (в пикселях): ','slidelabel');
								$attr = array('name'=>'imagewight','id'=>'newslidertitle','value'=>'200','class'=>'textfield inpval','maxlength'=>'3','size'=>5);
								echo form_input($attr).'</div>';
								echo '<div>'.form_label('Высота рисунка (в пикселях): ','slidelabel');
								$attr = array('name'=>'imageheight','id'=>'newslidertitle','value'=>'170','class'=>'textfield inpval','maxlength'=>'3','size'=>'5');
								echo form_input($attr).'</div>';
								/*echo '<i>Примечание 1: Максимальный размер фотографий недвижимости 752х336, других - 640х480</i><br/>';
								echo '<i>Примечание 2: Только первый рисунок для недвижимости подвергается обработке (crop image)</i>';*/
								echo '<hr>';
							?>
								<button type="submit" border="0" class="senden" id="send" value="send" name="btsabmit">Загрузить</button>
							<?php
							echo form_close();
						echo '</fieldset>';
					?>
					</div>
					<div class="clear"></div>
				<?php 
					if($pagevalue['multi'] and $images and count($images)){					
						for($i = 0;$i < count($images);$i++){							
							echo '<fieldset class="field-upload">'.
								'<legend><strong>Фотография - '.$images[$i]['img_title'].'</strong></legend>';
								echo '<img title=""	src="'.$pagevalue['baseurl'].'viewimage/'.
										$images[$i]['img_id'].'">';?>
								<br class="clear">
								<?php 
								if($this->uri->total_segments() == 3):
									echo anchor($pagevalue['page'].'/photo/change/'.$images[$i]['img_id'],
										' Сменить фото ',array('class'=>'changelink'));
									if($pagevalue['imgtype'] != 'about'):
										echo anchor($pagevalue['backpath'].'/imagedelete/'.$images[$i]['img_id'],
											'| Удалить',array('class'=>'delimage'));
									elseif($pagevalue['imgtype'] == 'about' and $i > 0):
										echo anchor($pagevalue['backpath'].'/imagedelete/'.$images[$i]['img_id'],
											'| Удалить',array('class'=>'delimage'));
									endif;
								else:
									if ($this->uri->segment(4) != 'list'){
										$link = $pagevalue['page'].'/photo/change/'.
											$pagevalue['imgtype'].'/'.$images[$i]['img_id'].'/'.
											$pagevalue['object'];
										echo anchor($link,' Сменить фото ',array('class'=>'changelink'));
									}else{
										echo anchor($pagevalue['page'].'/photo/change/'.
										$images[$i]['img_id'].'/'.$pagevalue['object'],
										' Сменить фото ',array('class'=>'changelink'));
									}
									if ($this->uri->segment(4) != 'list'){
										
									   if($pagevalue['imgtype'] == 'apartment'):
										if(($i == 0 and count($images) == 1) or ($i > 0 and count($images) > 1)):
											$link = $pagevalue['page'].'/imagedelete/'.$pagevalue['imgtype'].'/'.
											$images[$i]['img_id'].'/'.$pagevalue['object'];
											echo anchor($link,'|  Удалить',array('class'=>'delimage'));
										endif;
									  else:
									  		$link = $pagevalue['page'].'/imagedelete/'.$pagevalue['imgtype'].'/'.
											$images[$i]['img_id'].'/'.$pagevalue['object'];
											echo anchor($link,'|  Удалить',array('class'=>'delimage'));
									  endif;
									}else{
										if($pagevalue['imgtype'] == 'apartment'):
										
										  if(($i == 0 and count($images) == 1)or($i > 0 and count($images) > 1)):
											echo anchor($pagevalue['page'].'/imagedelete/'.
												$images[$i]['img_id'].'/'.$pagevalue['object'],
												'|  Удалить',array('class'=>'delimage'));
										  endif;
										else:
											echo anchor($pagevalue['page'].'/imagedelete/'.
												$images[$i]['img_id'].'/'.$pagevalue['object'],
												'|  Удалить',array('class'=>'delimage'));
										endif;
									}
								endif;
							echo '</fieldset>';
						}
					}
				?>
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
		$('a.delimage').confirm({timeout:5000,dialogShow:'fadeIn',dialogSpeed:'slow',buttons:{ok:'Подтвердить',cancel:'Отмена',wrapper:'<button></button>',separator:'  '}});
		$("#send").click(function(event){var err = false;var email = $("#email").val();$(".inpval").css('border-color','#00ff00');$(".inpval").each(function(i,element){if($(this).val()===''){$(this).css('border-color','#ff0000');err = true;}});if(err){$.jGrowl("Поля не могут быть пустыми",{header:'Контакная форма'});event.preventDefault();};});
	});
	</script>
</body>
</html>