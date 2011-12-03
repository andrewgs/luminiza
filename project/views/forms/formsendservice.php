<?=form_open($this->uri->uri_string(),array('id'=>'frmTransfer','name'=>'frmTransfer'));?>
	<?=form_error('name').'<div class="clear"></div>'; ?>
	<label for="email">E-Mail <em class="bright">*</em></label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="email inpval" id="email" value="" name="email">
	</div>
	<div class="clear"></div>
	<label for="name">Ваше имя и фамилия <em class="bright">*</em></label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="name inpval" id="name" value="" name="name">
	</div>
	<div class="clear"></div>
	<?=form_error('phone').'<div class="clear"></div>'; ?>
	<label for="phone">Контактный номер телефона <em class="bright">*</em></label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="phone inpval" id="phone" value="" name="phone">
	</div>
	<div class="clear"></div>
	<?=form_error('date').'<div class="clear"></div>'; ?>
	<label for="date">Дата прилета <em class="bright">*</em></label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="date inpval" id="date" value="" name="date">
	</div>							
	<div class="clear"></div>
	<?=form_error('note').'<div class="clear"></div>'; ?>						
	<label for="note">Сообщение <em class="bright">*</em></label>
	<div class="dd">
		<textarea class="note inpval" id="note" rows="5" cols="40" name="note"></textarea>
	</div>
	<div class="clear"></div>
	<button type="submit" border="0" id="send" class="senden" value="send" name="submit">Заказать</button>
<?=form_close(); ?>