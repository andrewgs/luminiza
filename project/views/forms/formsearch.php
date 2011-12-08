<h3>Поиск недвижимости</h3>
<p>
	<hr size="2"/>
	<table width="100%" border="0" class="retail-filter-table">
	<?php
		if(isset($selectvalue) and !empty($selectvalue))
			echo form_open('search',array('name'=>'frmsearch','id'=>'frmsearch'));
			echo form_hidden('cntrec',$countrecord);?>
		<tbody>
			<tr><td>Объект</td></tr>
			<tr>
				<td>
				<?php $options = array();
					for($i=0;$i<$countrecord['object'];$i++):
						$options[$i] = $selectvalue['object'][$i]['apnt_object'];
					endfor;
					$options[$countrecord['object']] = 'Любой объект';
					$attr = 'id="object" class="w215"';
					echo form_dropdown('object',$options,$countrecord['object'],$attr);	?>
				</td>
			</tr>
			<tr><td>Местонахождение</td></tr>
			<tr>
				<td>
				<?php
					$options = array();
					for($i = 0;$i < $countrecord['location'];$i++)
						$options[$i] = $selectvalue['location'][$i]['apnt_location'];
					$options[$countrecord['location']] = 'Любое местонахождение';
					$attr = 'id="location" class="w215"';
					echo form_dropdown('location',$options,$countrecord['location'],$attr);
				?>
				</td>
			</tr>
			<tr><td>Район</td></tr>
			<tr>
				<td>
					<?php
					$options = array();
					for($i = 0;$i < $countrecord['region'];$i++)
						$options[$i] = $selectvalue['region'][$i]['apnt_region'];
					$options[$countrecord['region']] = 'Любой район';
					$attr = 'id="region" class="w215"';
					echo form_dropdown('region',$options,$countrecord['region'],$attr);
				?>
				</td>
			</tr>
			<tr><td>Количество комнат</td></tr>
			<tr>
				<td>
					<table class="tbl">
						<tbody>
						<?php for($i=0;$i<count($selectvalue['count']);$i++):
		$attr = array('name'=>'rooms_'.$i,'id'=>'rooms_'.$i,'class'=>'rooms','value'=>$selectvalue['count'][$i]['apnt_count'],'checked'=>FALSE);
								if($i % 4 == 0):
									echo '<tr><td>'.form_checkbox($attr).$selectvalue['count'][$i]['apnt_count'].'</td>';
								else:
									echo '<td>'.form_checkbox($attr).$selectvalue['count'][$i]['apnt_count'].'</td>';
									if($i % 4 == 3) echo '</tr>';
								endif;
								if($i == count($selectvalue['count'])) echo '</tr>';
							endfor;?>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<button type="submit" border="0" class="senden" value="search" name="btsearch">Найти</button>
				</td>
			</tr>
		</tbody>
	</table>
	<?=form_close();?>
	<hr size="2"/>
	<table width="100%" border="0" class="retail-filter-table">
	<?=form_open('name-search',array('name'=>'frmLikeSearch','id'=>'frmLikeSearch'));?>
		<tbody>
		<tr><td>Номер по каталогу:</td></tr>
		<tr><td><input type="text" size="25"class="sname" id="sname" value="<?=$sname;?>" name="sname"></td></tr>
		<tr><td><button type="submit" border="0" class="senden" value="sname" id="btsname" name="btsname">Поиск</button></td></tr>
		</tbody>
	<?=form_close();?>
	</table>
	<hr size="2"/>
	<table width="100%" border="0" class="retail-filter-table">
	<?=form_open('price-search',array('name'=>'frmPriceSearch','id'=>'frmPriceSearch'));?>
		<tbody>
		<tr><td>Диапазон цен (&euro;):</td></tr>
		<tr>
			<td>
				от: <input type="text" size="5" class="rgprice" id="lowprice" value="" name="lowprice" disabled="disabled">
				до: <input type="text" size="5" class="rgprice" id="topprice" value="" name="topprice" disabled="disabled">
			</td>
		</tr>
		<tr><td><div id="RangePrice" style="width:200px;"></div></td></tr>
		<tr><td><button type="submit" border="0" class="senden" value="sname" id="btsprice" name="btsprice">Поиск</button></td></tr>
		</tbody>
	<?=form_close();?>
	</table>
	<hr size="2"/>
</p>
<p>&nbsp;</p>