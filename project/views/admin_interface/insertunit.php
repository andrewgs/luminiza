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
				<?php if($msg['status'] == 1):
						echo '<div class="message">';
							echo $msg['message'].'<br/>'.$msg['error'];
						echo '</div>';
						echo '<div class="clear"></div>';
					endif;
					echo form_error('title').'<div class="clear"></div>';
					echo form_error('extended').'<div class="clear"></div>';
					if(!$pagevalue['auto']):
						echo form_error('price').'<div class="clear"></div>';
						echo form_error('object').'<div class="clear"></div>';
						echo form_error('location').'<div class="clear"></div>';
						echo form_error('region').'<div class="clear"></div>';
						echo form_error('count').'<div class="clear"></div>';
					endif;	
					echo form_open_multipart($this->uri->uri_string(),array('id'=>'insertform'));
						echo form_hidden('auto',$pagevalue['auto']);
						echo form_hidden('type',$pagevalue['unit']);
						echo '<div>'.form_label('Навание: ','textlabel');
						$attr = array(
							'name' 		=> 'title',
							'id'   		=> 'texttitle',
							'value'		=> set_value('title'),
							'class'		=> 'textfield inpval',
							'maxlength'	=> '100',
							'size' 		=> '75'
						);
						echo form_input($attr).'</div>';
						if(!$pagevalue['auto']){
							echo '<div>'.form_label(' Дата: ','textlabel');
							$attr = array(
								'name' 		=> 'date',
								'id'   		=> 'unitdate',
								'value'		=> set_value('date'),
								'class'		=> 'textfield inpval',
								'maxlength'	=> '50',
								'size' 		=> '4',
								'readonly'  => TRUE
							);
							if(empty($attr['value'])) $attr['value'] = date('d/m/Y');
							echo form_input($attr).'</div>';
						}else
						echo '<div>'.form_label('Раcширенная информация: ','textlabel').'</div>';
						$attr =array(
								'name' 	=> 'extended',
								'value'	=> set_value('extended'),
								'class'	=> 'textfield textextended inpval',
								'cols'	=> '81',
								'rows' 	=> '10'
						);
						echo '<div>'.form_textarea($attr).'</div>';
						if(!$pagevalue['auto']){
							echo '<hr>';
							echo '<div>'.form_label('Цена без скидки (&euro;): ','textlabel', array('class'=>'inline'));
							$attr = array(
								'name' 		=> 'price',
								'id'   		=> 'textprice',
								'value'		=> set_value('price'),
								'class'		=> 'textfield inpval',
								'maxlength'	=> '40',
								'size' 		=> '10'
							);
							echo form_input($attr).'</div>';
							echo '<div>'.form_label('Новая цена (&euro;): ','textlabel', array('class'=>'inline'));
							$attr = array(
								'name' 		=> 'newprice',
								'id'   		=> 'textprice',
								'value'		=> set_value('newprice'),
								'class'		=> 'textfield inpval',
								'maxlength'	=> '40',
								'size' 		=> '10'
							);
							echo form_input($attr).'</div>';
							echo '<div>'.form_label(' Объект: ','textlabel', array('class'=>'inline'));
							$attr = array(
								'name' 		=> 'object',
								'id'   		=> 'textobject',
								'value'		=> set_value('object'),
								'class'		=> 'textfield inpval',
								'maxlength'	=> '100',
								'size' 		=> '45'
							);
							echo form_input($attr).'</div>';
							echo '<div>'.form_label(' Местонахождение: ','textlabel', array('class'=>'inline'));
							$attr = array(
								'name' 		=> 'location',
								'id'   		=> 'textlocation',
								'value'		=> set_value('location'),
								'class'		=> 'textfield inpval',
								'maxlength'	=> '100',
								'size' 		=> '45'
							);
							echo form_input($attr).'</div>';
							echo '<div>'.form_label(' Район: ','textlabel', array('class'=>'inline'));
							$attr = array(
								'name' 		=> 'region',
								'id'   		=> 'textregion',
								'value'		=> set_value('region'),
								'class'		=> 'textfield inpval',
								'maxlength'	=> '100',
								'size' 		=> '45'
							);
							echo form_input($attr).'</div>';
							echo '<div>'.form_label(' Количество комнат: ','textlabel', array('class'=>'inline'));
							$attr = array(
								'name' 		=> 'count',
								'id'   		=> 'textcount',
								'value'		=> set_value('count'),
								'class'		=> 'textfield inpval',
								'maxlength'	=> '10',
								'size' 		=> '5'
							);
							echo form_input($attr).'</div>';?>
							<hr>
							<label class="label-input">Фото: </label>
							<input class="textfield inpval" type="file" name="userfile" accept="image/jpeg,png,gif" size="30"/> 
							<div class="">Поддерживаемые форматы: JPG, GIF, PNG</div>
							<hr>
							<div><label class="label-input">Дополнительные пареметры:</label></div>
							<div>
								<input type="checkbox" name="sold" title="Продано" value="1" <?=set_checkbox('sold','1'); ?> />Продано
								<input type="checkbox" name="recommended" title="Рекомендуемое предложение" value="1" <?=set_checkbox('recommended','1'); ?> />Рекомендуемое предложение
								<input type="checkbox" name="special" title="Специальное предложение" value="1" <?=set_checkbox('special','1'); ?> />Специальное предложение
							</div>
							<hr>
							<?php $status = array(FALSE,FALSE,FALSE);
							if(empty($status[0])&&empty($status[1])&&empty($status[2]))
								if($pagevalue['backpath'] == 'retail'):
									$status[0] = TRUE;
								else:
									$status[1] = TRUE;
								endif;
							echo '<div>'.form_label('Раздел для размещения: ','textlabel').'</div>';
							$attr = array(
								'name'        => 'flag',
								'id'          => 'radio1',
								'value'       => '0',
								'checked'	  => set_radio('flag','0',$status[0])
							);
							echo form_radio($attr).' Продажа ';
							$attr = array(
								'name'        => 'flag',
								'id'          => 'radio2',
								'value'       => '1',
								'checked'	  => set_radio('flag','1',$status[1])
							);
							echo form_radio($attr).' Аренда ';
							$attr = array(
								'name'        => 'flag',
								'id'          => 'radio3',
								'value'       => '2',
								'checked'	  => set_radio('flag','2',$status[2])
							);
							echo form_radio($attr).' Продажа и аренда ';
						}
						echo '<hr>';
						echo '<div id="rentinput">';
							echo '<div>'.form_label('Цена за аренду: ','textlabel').'</div>';
							$attr =array(
									'name' 	=> 'pricerent',
									'value'	=> set_value('pricerent'),
									'class'	=> 'textfield textextended',
									'cols'	=> '81',
									'rows' 	=> '10',
							);
							echo '<div>'.form_textarea($attr).'</div>';
							if($pagevalue['auto']){									
								echo '<div>'.form_label('Свойства: ','textlabel').'</div>';
								$attr =array(
										'name' 	=> 'properties',
										'value'	=> set_value('properties'),
										'class'	=> 'textfield textextended',
										'cols'	=> '81',
										'rows' 	=> '10',
								);
								echo '<div>'.form_textarea($attr).'</div>';
							}
						echo '</div>';
						echo '<hr>';
						echo form_submit(array('name'=>'btsabmit','id'=>'send','value'=>'Сохранить','class'=>'senden'));
					echo form_close(); ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
    </div>
    <?php $this->load->view('admin_interface/footer');?>
  </div>
<?php $this->load->view('admin_interface/scripts');?>
<script src="<?=$pagevalue['baseurl'];?>ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?=$pagevalue['baseurl'];?>ckeditor/adapters/jquery.js" type="text/javascript"></script>
<script src="<?=$pagevalue['baseurl'];?>ckfinder/ckfinder.js" type="text/javascript"></script>
<script src="<?=$pagevalue['baseurl'];?>js/datepicker/jquery.bgiframe-2.1.1.js" type="text/javascript"></script>
<script src="<?=$pagevalue['baseurl'];?>js/datepicker/jquery.ui.core.js" type="text/javascript" ></script>
<script src="<?=$pagevalue['baseurl'];?>js/datepicker/jquery.ui.datepicker-ru.js" type="text/javascript" ></script>
<script src="<?=$pagevalue['baseurl'];?>js/datepicker/jquery.ui.datepicker.js" type="text/javascript" ></script>
<script src="<?=$pagevalue['baseurl'];?>js/datepicker/jquery.ui.widget.js" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function(){
		var config = {skin : 'v2',removePlugins : 'scayt',resize_enabled: false,height: '350px',toolbar:[['Source','-','Preview','-','Templates'],['Cut','Copy','Paste','PasteText'],['Undo','Redo','-','SelectAll','RemoveFormat'],'/',['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],['NumberedList','BulletedList','-','Outdent','Indent'],['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],['Link','Unlink'],'/',['TextColor','Format','FontSize'],['Table','HorizontalRule','SpecialChar','-'],['Maximize', 'ShowBlocks']]};
		$('textarea.textextended').ckeditor(config);
		var editor = $('textarea.textextended').ckeditorGet();
		CKFinder.setupCKEditor(editor,'<?=$pagevalue['baseurl'].'ckfinder/'; ?>');
		$("input#unitdate").datepicker($.datepicker.regional['ru']);
		$("#send").click(function(event){var err = false;var email = $("#email").val();$(".inpval").css('border-color','#00ff00');$(".inpval").each(function(i,element){if($(this).val()===''){$(this).css('border-color','#ff0000');err = true;}});if(err){$.jGrowl("Поля не могут быть пустыми",{header:'Форма добавления'});event.preventDefault();}});
	});
</script>
</body>
</html>