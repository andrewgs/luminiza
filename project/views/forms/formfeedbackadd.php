<?=form_open($this->uri->uri_string(),array('id'=>'frmRent'));?>
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
	<?=form_error('note').'<div class="clear"></div>'; ?>
	<label for="note">Отзыв <em class="bright">*</em></label>
	<div class="dd">
		<textarea class="note inpval" id="note" name="note"></textarea>
	</div>
	<button type="submit" border="0" id="send" class="senden" value="send" name="submit">Добавить отзыв</button>
<?=form_close(); ?>