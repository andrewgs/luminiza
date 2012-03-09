<?=form_open($this->uri->uri_string(),array('id'=>'frmRent'));?>
	<?=form_error('email').'<div class="clear"></div>'; ?>
		<label for="email">Укажите адрес вашей электронной почты <em class="bright">*</em></label>
		<div class="dd">
			<input type="text" size="45" maxlength="50" class="email inpval" id="email" value="" name="email">
		</div>
		<div class="clear"></div>
	<?=form_error('name').'<div class="clear"></div>'; ?>
		<label for="name">Укажите ваше имя <em class="bright">*</em></label>
		<div class="dd">
			<input type="text" size="45" maxlength="50" class="name inpval" id="name" value="" name="name">
		</div>
		<div class="clear"></div>
		<?=form_error('phone').'<div class="clear"></div>'; ?>
		<label for="phone">Ваш номер телефона <em class="bright">*</em></label>
		<div class="dd">
			<input type="text" size="45" maxlength="50" class="phone inpval" id="phone" value="" name="phone">
		</div>
		<div class="clear"></div>
		<?=form_error('max_budget').'<div class="clear"></div>'; ?>
		<label for="max_budget">Максимально возможный бюджет <em class="bright">*</em></label>
		<div class="dd">
		<input type="text" size="45" maxlength="50" class="max_budget inpval" id="max_budget" value="" name="max_budget">
		</div>
		<div class="clear"></div>
		<button type="submit" border="0" id="send" class="senden" value="send" name="submit">Отправить запрос</button>
<?=form_close(); ?>