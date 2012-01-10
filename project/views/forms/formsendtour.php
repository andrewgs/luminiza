<?=form_open($this->uri->uri_string(),array('id'=>'frmRent'));?>
	<input type="hidden" value="" id="price" name="price"/>
	<div class="clear"></div>
	<?=form_error('date').'<div class="clear"></div>'; ?>
	<label for="rdate">Дата экскурсии</label>
	<div class="dd">
		<input type="text" size="45" maxlength="50" class="date inpval" readonly="readonly" id="date" value="" name="date">
	</div>
	<div class="clear"></div>	
	<?=form_error('number_people').'<div class="clear"></div>'; ?>
	<label for="number_people">Пассажиры</label>
	<div class="dd">
		<div class="labelbox">
			<label class="minor">Взрослые</label>
			<select class="short" id="adults" name="adults">
				<?php for ($i = 1; $i <= 8; $i++) : ?>
				<option value="<?=$i;?>"><?=$i;?></option>
				<?php endfor; ?>
			</select>
		</div>
		<div class="labelbox">
			<label class="minor">Дети</label>
			<select class="short" id="children" name="children">
				<?php for ($i = 0; $i <= 4; $i++) : ?>
				<option value="<?=$i;?>"><?=$i;?></option>
				<?php endfor; ?>
			</select>
		</div>
		<div class="labelbox">
			<label class="minor">Младенцы</label>
			<select class="short" id="infants" name="infants">
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
	<div class="clear"></div>
	<?=form_error('note').'<div class="clear"></div>'; ?>
	<label for="rdate">Примечания</label>
	<div class="dd">
		<textarea class="note" id="note" name="note"></textarea>
	</div>
	<div class="total-price">
		Всего: 
		<span id="TotalPrice">0.00</span>
		<span> &euro;</span>
	</div>	
	<div class="clear"></div>
	<button type="submit" border="0" id="send" class="senden" value="send" name="submit">Перейти к оплате</button>
<?=form_close(); ?>