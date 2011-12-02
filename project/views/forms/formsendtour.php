<?=form_open($this->uri->uri_string(),array('id'=>'frmRent'));?>
	<?=form_error('email').'<div class="clear"></div>'; ?>
		<label for="email">E-Mail <em class="bright">*</em></label>
		<div class="dd">
			<input type="text" size="45" maxlength="50" class="email inpval" id="email" value="" name="email">
		</div>
		<div class="clear"></div>
	<?=form_error('name').'<div class="clear"></div>'; ?>
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
		<?=form_error('number_people').'<div class="clear"></div>'; ?>
		<label for="number_people">Количество людей <em class="bright">*</em></label>
		<div class="dd">
		<input type="text" size="45" maxlength="50" class="number_people inpval" id="number_people" value="" name="number_people">
		</div>
		<div class="clear"></div>
		<?=form_error('number_children').'<div class="clear"></div>'; ?>
		<label for="number_children">Количество детей <em class="bright">*</em></label>
		<div class="dd">
		<input type="text" size="45" maxlength="50" class="number_children inpval" id="number_children" value="" name="number_children">
		</div>
		<div class="clear"></div>
		<?=form_error('date').'<div class="clear"></div>'; ?>
		<label for="rdate">Дата экскурсии <em class="bright">*</em></label>
		<div class="dd">
			<input type="text" size="45" maxlength="50" class="date inpval" id="date" value="" name="date">
		</div>
		<div class="clear"></div>
		<?=form_error('note').'<div class="clear"></div>'; ?>
		<label for="rdate">Примечания <em class="bright">*</em></label>
		<div class="dd">
			<textarea class="note inpval" id="note" name="note"></textarea>
		</div>
		<div class="clear"></div>
		<button type="submit" border="0" id="send" class="senden" value="send" name="submit">Отправить запрос</button>
<?=form_close(); ?>