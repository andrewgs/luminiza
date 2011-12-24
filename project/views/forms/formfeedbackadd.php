<?=form_open_multipart($this->uri->uri_string(),array('id'=>'frmRent'));?>
	<?=form_error('name').'<div class="clear"></div>'; ?>
	<label for="fio">Имя и фамилия <em class="bright">*</em></label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="fio inpval" id="fio" value="" name="fio">
	</div>
	<div class="clear"></div>
	<?=form_error('region').'<div class="clear"></div>'; ?>
	<label for="region">Город <em class="bright">*</em></label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="region inpval" id="region" value="" name="region">
	</div>
	<div class="clear"></div>
	<hr size="2"/>
	<label class="label-input">Фото: </label>
	<input class="textfield" type="file" name="userfile" accept="image/jpeg,png,gif" size="32"/> 
	<div class="">Поддерживаемые форматы: JPG, GIF, PNG</div>
	<hr size="2"/>
	<div class="clear"></div>
	<?=form_error('note').'<div class="clear"></div>'; ?>
	<label for="note">Отзыв <em class="bright">*</em></label>
	<div class="dd">
		<textarea class="note inpval" id="note" name="note"></textarea>
	</div>
	<button type="submit" border="0" id="send" class="senden" value="send" name="submit">Добавить отзыв</button>
<?=form_close(); ?>