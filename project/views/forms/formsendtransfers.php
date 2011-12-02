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
		
		<?=form_error('date').'<div class="clear"></div>'; ?>
		<label for="arrival_date">Дата прилета <em class="bright">*</em></label>
		<div class="dd">
			<input type="text" size="45" class="date inpval" id="date" value="" name="date">
		</div>							
		<div class="clear"></div>
		<?=form_error('textmail').'<div class="clear"></div>'; ?>
		<label for="msg">Сообщение <em class="bright">*</em></label>
		<div class="dd">
			<textarea class="textmail inpval" id="textmail" rows="5" cols="40" name="textmail"></textarea>
		</div>
		<div class="clear"></div>
		<label for="subject">Откуда Вы о нас узнали?</label>
		<div class="ddr">
			<input type="radio" value="0" name="subject" class="radio"/>Интернет <br/>
			<input type="radio" value="1" name="subject" class="radio"/>От друзей <br/>
			<input type="radio" value="2" name="subject" class="radio"/>Реклама <br/>
			<input type="radio" value="3" name="subject" class="radio"/>Другое 
			<input type="text" value="" id="subject_txt" name="subject_txt"/>
		</div>
		<div class="clear"></div>
		<button type="submit" border="0" id="send" class="senden" value="send" name="submit">Отправить</button>
<?=form_close(); ?>