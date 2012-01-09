<?=form_open($this->uri->uri_string(),array('id' => 'frmTransfer','name' => 'frmTransfer'));?>
	<?=form_error('email').'<div class="clear"></div>'; ?>
	<label for="email">E-Mail <em class="bright">*</em></label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="email inpval" id="email" value="" name="email">
	</div>
	<div class="clear"></div>
	<?=form_error('name').'<div class="clear"></div>'; ?>
	<label for="name">Контактное лицо <em class="bright">*</em></label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="name inpval" id="name" value="" name="name">
	</div>
	<div class="clear"></div>
	<?=form_error('phone').'<div class="clear"></div>'; ?>
	<label for="phone">Номер телефона <em class="bright">*</em></label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="phone inpval" id="phone" value="" name="phone">
	</div>
	<div class="clear"></div>
	<?=form_error('max_budget').'<div class="clear"></div>'; ?>
	<label for="max_budget">Макс. бюджет <em class="bright">*</em></label>
	<div class="dd">
	<input type="text" size="45" maxlength="50" class="max_budget inpval" id="max_budget" value="" name="max_budget">
	</div>
	<div class="clear"></div>
	<?=form_error('number_people').'<div class="clear"></div>'; ?>
	<label for="number_people">Кол-во взрослых <em class="bright">*</em></label>
	<div class="dd">
	<input type="text" size="45" maxlength="50" class="number_people inpval" id="number_people" value="" name="number_people">
	</div>
	<div class="clear"></div>
	<?=form_error('number_children').'<div class="clear"></div>'; ?>
	<label for="number_children">Кол-во детей <em class="bright">*</em></label>
	<div class="dd">
	<input type="text" size="45" maxlength="50" class="number_children inpval" id="number_children" value="" name="number_children">
	</div>
	<div class="clear"></div>
	<?=form_error('permit').'<div class="clear"></div>';?>
	<label for="permit">Номер водит. прав <em class="bright">*</em></label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="permit inpval" id="permit" value="" name="permit">
	</div>
	<div class="clear"></div>
	<?=form_error('pdate').'<div class="clear"></div>';?>
	<label for="pdate">Дата получения <em class="bright">*</em></label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="pdate inpval" id="pdate" value="" name="pdate">
	</div>
	<div class="clear"></div>
	<?=form_error('country').'<div class="clear"></div>';?>
	<label for="country">Страна получения <em class="bright">*</em></label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="country inpval" id="country" value="" name="country">
	</div>
	<div class="clear"></div>
	<?=form_error('rdate').'<div class="clear"></div>';?>
	<label for="rdate">Дата въезда <em class="bright">*</em></label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="rdate inpval" id="rdate" value="" name="rdate">
	</div>
	<div class="clear"></div>
	<?=form_error('bcdate').'<div class="clear"></div>'; ?>
	<label for="bcdate">Дата выезда <em class="bright">*</em></label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="bcdate inpval" id="bcdate" value="" name="bcdate">
	</div>
	<div class="clear"></div>
	<label for="place">Где должен быть автомобиль? </label>
	<div class="ddr">
		<input type="radio" value="1" name="place" class="radio"/>В аэропорту <br/>
		<input type="radio" value="2" name="place" class="radio"/>В отеле
	</div>
	<div class="clear"></div>
	<button type="submit" border="0" id="send" class="senden" value="send" name="sauto">Отправить запрос</button>
<?=form_close();?>