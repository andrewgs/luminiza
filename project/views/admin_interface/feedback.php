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
			<div class="grid_9 alpha">
				<div class="main_content">
					<a class="crossing" id="btnAdd" href="">Форма добавления отзыва</a>
					<div class="formmailer" id="frmAdd" style="display:none;">
					<?php $this->load->view('forms/formfeedbackadd');?>
<<<<<<< HEAD
					</div>
					<hr size="2"/>
					<?php if($pagevalue['feedback']):?>
					<div class="">
						<?php $this->load->view('forms/feedbacktable');?>
=======
>>>>>>> ea38c303cb31b6bf846a545803d179ee056395c6
					</div>
					<?php endif;?>
				</div>
			</div>
			<div class="clear"></div>
			<div class="grid_12">
				<?php $this->load->view('forms/feedbacktable');?>			
			</div>
			<div class="clear"></div>
		</div>
    </div>
	<?php $this->load->view('admin_interface/footer');?>
</div>
<?php $this->load->view('admin_interface/scripts');?>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if($pagevalue['msg']):?>
			$.jGrowl("<?=$pagevalue['msg'];?>",{header:'Добавление отзыва'});
		<?php endif;?>
		$("#send").click(function(event){
			var err = false;
			var email = $("#email").val();
			$(".inpval").css('border-color','#00ff00');
			$(".inpval").each(function(i,element){if($(this).val()===''){$(this).css('border-color','#ff0000');err = true;}});
			if(err){
				$.jGrowl("Поля не могут быть пустыми",{header:'Контакная форма'});
				event.preventDefault();
			}
		});
		$("#btnAdd").click(function(){$("#frmAdd").toggle(); return false;});
		$(".btndel").click(function(){
			if(!confirm('Удалить отзыв?')) return false;
			curID = $(this).attr("rID");
			var uID = $("td[rID='"+curID+"']").text();
			$.post("<?=$pagevalue['baseurl'];?>feedback/delete-record",{'id':uID},
			function(data){if(data.status){$("tr[rID='"+curID+"']").fadeOut("slow",function(){$("tr[rID='"+curID+"']").remove();$.jGrowl(data.message,{header:'Удаление отзыва'});});}else $.jGrowl(data.message,{header:'Удаление отзыва'});},"json");
		});
	});
</script>
</body>
</html>