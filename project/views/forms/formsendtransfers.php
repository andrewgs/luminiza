<?=form_open($this->uri->uri_string(),array('id'=>'frmTransfer'));?>
	<input type="hidden" value="" id="price" name="price"/>
	<div class="clear"></div>
	<?=form_error('name').'<div class="clear"></div>'; ?>
	<label for="name">Откуда/Куда</label>
	<div class="dd">
		<select class="name" id="place" name="place">
			<option value="1">Северный аэропорт (Los Rodeos)</option>
			<option value="2">Южный аэропорт (Reina Sofia)</option>
			<option value="3">Лоро Парк (Loro Parque)</option>
		</select>
	</div>
	<div class="clear"></div>
	<?=form_error('date').'<div class="clear"></div>'; ?>
	<label for="arrival_date">Дата</label>
	<div class="dd">
		<input type="text" size="45" class="date inpval" readonly="readonly" id="date" value="" name="date">
	</div>							
	<div class="clear"></div>
	<?=form_error('name').'<div class="clear"></div>'; ?>
	<label for="name">Пассажиры</label>
	<div class="dd">
		<div class="labelbox">
			<label class="minor">Взрослые</label>
			<select class="short ppl" id="adults" name="adults">
				<?php for ($i = 1; $i <= 8; $i++) : ?>
				<option value="<?=$i;?>"><?=$i;?></option>
				<?php endfor; ?>
			</select>
		</div>
		<div class="labelbox">
			<label class="minor">Дети от 5 до 10 лет</label>
			<select class="shorter ppl" id="children" name="children">
				<?php for ($i = 0; $i <= 4; $i++) : ?>
				<option value="<?=$i;?>"><?=$i;?></option>
				<?php endfor; ?>
			</select>
		</div>
		<div class="labelbox">
			<label class="minor">Дети до 5 лет</label>
			<select class="short ppl" id="infants" name="infants">
				<?php for ($i = 0; $i <= 4; $i++) : ?>
				<option value="<?=$i;?>"><?=$i;?></option>
				<?php endfor; ?>
			</select>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<?=form_error('name').'<div class="clear"></div>'; ?>
	<label for="name">Контактное лицо</label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="name inpval" id="name" value="" name="name">
	</div>
	<div class="clear"></div>
	<?=form_error('phone').'<div class="clear"></div>'; ?>
	<label for="phone">Номер телефона</label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="phone inpval" id="phone" value="" name="phone">
	</div>
	<div class="clear"></div>
	<?=form_error('email').'<div class="clear"></div>'; ?>
	<label for="email">E-Mail</label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="email inpval" id="email" value="" name="email">
	</div>
	<?=form_error('flight').'<div class="clear"></div>'; ?>
	<label for="email">Номер авиарейса</label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="flight" id="flight" value="" name="flight">
	</div>		
	<?=form_error('textmail').'<div class="clear"></div>'; ?>
	<label for="msg">Примечания</label>
	<div class="dd">
		<textarea class="note" id="note" rows="2" cols="40" name="note"></textarea>
		<label class="textarea-note">* Если вы желаете, чтобы никаких других пассажиров, кроме вашей семьи не было, пожалуйста укажите это в примечании.</label>
	</div>
	<div id="mastercard"></div>
	<div id="visa"></div>
	<div class="total-price">
		Всего: 
		<span id="TotalPrice">0.00</span>
		<span> &euro;</span>
	</div>
	<div class="clear"></div>
	<button type="submit" border="0" id="send" class="senden" value="send" name="submit">Перейти к оплате</button>
<?=form_close(); ?>