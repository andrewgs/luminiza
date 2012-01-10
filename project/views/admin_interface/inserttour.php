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

					echo form_open('inserttour',array('id'=>'inserttourform'));
						echo form_hidden('backpath',$pagevalue['backpath']);
						echo '<div>'.form_label('Навание экскурсии: ','textlabel');
						$attr = array(
							'name' 		=> 'title',
							'id'   		=> 'texttitle',
							'value'		=> set_value('title'),
							'class'		=> 'textfield inpval',
							'maxlength'	=> '100',
							'size' 		=> '75'
						);
						echo form_input($attr).'</div>';
						echo '<div>'.form_label('Цена для одного человека: ','textlabel');
						$attr = array(
							'name' 		=> 'price',
							'id'   		=> 'textprice',
							'value'		=> set_value('price'),
							'class'		=> 'textfield inpval',
							'maxlength'	=> '100',
							'style' 	=> 'min-width: 50px;'
						);
						echo form_input($attr).'</div>';
						echo '<div>'.form_label('Раcширенная информация: ','textlabel').'</div>';
						$attr =array(
								'name' 	=> 'extended',
								'value'	=> set_value('extended'),
								'class'	=> 'textfield textextended inpval',
								'cols'	=> '81',
								'rows' 	=> '10'
						);
						echo '<div>'.form_textarea($attr).'</div>';
						echo '<hr>';
						echo form_submit(array('name'=>'btsabmit','id'=>'send','value'=>'Сохранить','class'=>'senden'));
					echo form_close();?>
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