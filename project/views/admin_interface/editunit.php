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
						echo '</div>';
						echo '<div class="clear"></div>';
					}
					echo form_open('updateunit',array('id'=>'editunitform'));
						echo form_hidden('id',$pagevalue['id']);
						echo form_hidden('auto',$pagevalue['auto']);
						echo form_hidden('backpath',$pagevalue['backpath']);
						echo '<div>'.form_label('Навание: ','textlabel');
						$attr = array(
							'name' 		=> 'title',
							'id'   		=> 'texttitle',
						    'value'		=> $unitinfo['title'],
							'class'		=> 'textfield',
						    'maxlength'	=> '100',
						    'size' 		=> '75'
						);
						echo form_input($attr);
						if(!$pagevalue['auto']){
							echo form_label(' Дата: ','textlabel');
							$attr = array(
								'name' 		=> 'date',
								'id'   		=> 'unitdate',
							    'value'		=> $unitinfo['date'],
								'class'		=> 'textfield',
							    'maxlength'	=> '50',
							    'size' 		=> '10',
								'readonly'  => TRUE
							);
							echo form_input($attr).'</div>';
						}else
							echo '</div>';
						echo '<div>'.form_label('Раcширенная информация: ','textlabel').'</div>';
						$attr =array(
								'name' 	=> 'extended',
						        'value'	=> $unitinfo['extended'],
								'class'	=> 'textfield textextended',
						        'cols'	=> '81',
						        'rows' 	=> '10'
						);
						echo '<div>'.form_textarea($attr).'</div>';
						if(!$pagevalue['auto']){
							echo '<hr>';
							echo '<div>'.form_label('Цена без скидки (&euro;): ','textlabel');
							$attr = array(
								'name' 		=> 'price',
								'id'   		=> 'textprice',
							    'value'		=> $unitinfo['price1'],
								'class'		=> 'textfield',
							    'maxlength'	=> '40',
							    'size' 		=> '10'
							);
							echo form_input($attr);
							echo form_label('Новая цена (&euro;): ','textlabel');
							$attr = array(
								'name' 		=> 'newprice',
								'id'   		=> 'textnewprice',
							    'value'		=> $unitinfo['price2'],
								'class'		=> 'textfield',
							    'maxlength'	=> '40',
							    'size' 		=> '10'
							);
							echo form_input($attr);
							echo form_label(' Объект: ','textlabel');
							$attr = array(
								'name' 		=> 'object',
								'id'   		=> 'textobject',
							    'value'		=> $unitinfo['object'],
								'class'		=> 'textfield',
							    'maxlength'	=> '100',
							    'size' 		=> '45'
							);
							echo form_input($attr);
							echo form_label(' Местонахождение: ','textlabel');
							$attr = array(
								'name' 		=> 'location',
								'id'   		=> 'textlocation',
							    'value'		=> $unitinfo['location'],
								'class'		=> 'textfield',
							    'maxlength'	=> '100',
							    'size' 		=> '45'
							);
							echo form_input($attr);
							echo form_label(' Район: ','textlabel');
							$attr = array(
								'name' 		=> 'region',
								'id'   		=> 'textregion',
							    'value'		=> $unitinfo['region'],
								'class'		=> 'textfield',
							    'maxlength'	=> '100',
							    'size' 		=> '45'
							);
							echo form_input($attr);
							echo form_label(' Количество комнат: ','textlabel');
							$attr = array(
								'name' 		=> 'count',
								'id'   		=> 'textcount',
							    'value'		=> $unitinfo['count'],
								'class'		=> 'textfield',
							    'maxlength'	=> '10',
							    'size' 		=> '5'
							);
							echo form_input($attr).'</div>';
							echo '<hr>';
							$value = array(FALSE,FALSE,FALSE);
							$value[$unitinfo['flag']] = TRUE;
							echo form_label('Раздел: ','textlabel');
							$attr = array(
				            	'name'        => 'flag',
				            	'id'          => 'radio1',
				            	'value'       => '0',
								'checked'     => $value[0]
				            );
							echo form_radio($attr).' Продажа ';
							$attr = array(
				            	'name'        => 'flag',
				            	'id'          => 'radio2',
				            	'value'       => '1',
								'checked'     => $value[1]
				            );
							echo form_radio($attr).' Аренда ';
							$attr = array(
				              	'name'        => 'flag',
				            	'id'          => 'radio3',
				            	'value'       => '2',
				            	'checked'     => $value[2]
				            );
							echo form_radio($attr).' Продажа и аренда ';
						}
						echo '<hr>';
						echo '<div id="rentinput">';
							echo '<div>'.form_label('Цена за аренду: ','textlabel').'</div>';
							$attr =array(
									'name' 	=> 'pricerent',
							        'value'	=> $unitinfo['pricerent'],
									'class'	=> 'textfield textextended',
							        'cols'	=> '81',
							        'rows' 	=> '10',
							);
							echo '<div>'.form_textarea($attr).'</div>';
							if($pagevalue['auto']){									
								echo '<div>'.form_label('Свойства: ','textlabel').'</div>';
								$attr =array(
										'name' 	=> 'properties',
								        'value'	=> $unitinfo['properties'],
										'class'	=> 'textfield textextended',
								        'cols'	=> '81',
								        'rows' 	=> '10',
								);
								echo '<div>'.form_textarea($attr).'</div>';
							}
						echo '</div>';
						echo '<hr>';
						$attr =array(
								'name' => 'btsabmit',
								'id'   => 'btnsabmit',
								'value'=> 'Сохранить',
								'class'=> 'senden'
							);
						echo form_submit($attr);
					echo form_close();
				?>
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
		var config = {
			skin : 'v2',
			removePlugins : 'scayt',
			resize_enabled: false,
			height: '150px',
			toolbar:
			[
				['Source','-','Preview','-','Templates'],
				['Cut','Copy','Paste','PasteText'],
				['Undo','Redo','-','SelectAll','RemoveFormat'],
				'/',
				['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
				['NumberedList','BulletedList','-','Outdent','Indent'],
				['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
				['Link','Unlink'],
				'/',
				['TextColor','Format','FontSize'],
				['Table','HorizontalRule','SpecialChar','-'],
				['Maximize', 'ShowBlocks']
			]
		};
		$('textarea.textextended').ckeditor(config);
		var editor = $('textarea.textextended').ckeditorGet();
		CKFinder.setupCKEditor(editor,'<?=$pagevalue['baseurl'].'ckfinder/'; ?>');
		$("input#unitdate").datepicker($.datepicker.regional['ru']);
	});
</script>
</body>
</html>