<div class="">
	<table id="reviews" summary="Список объектов">
		<thead>
			<tr class="odd">
				<th scope="col" abbr="ID">ID</th>
				<th scope="col" abbr="Название">Название</th>	
				<th scope="col" abbr="Цена">Цена</th>	
				<th scope="col" abbr="Объект">Объект</th>
				<th scope="col" abbr="Местонахождение">Местонахождение</th>
				<th scope="col" abbr="Район">Район</th>
			</tr>	
		</thead>
	    <tfoot>	
		 	&nbsp;
		</tfoot>
		<tbody>
		<?php for($i=0;$i<count($pagevalue['apartments']);$i++):?>
			<tr rID="<?=$i?>"> 
				<td width="2%"><?=$pagevalue['apartments'][$i]['apnt_id'];?></td>
				<td width="50%"><?=$pagevalue['apartments'][$i]['apnt_title'];?></td>
				<td width="10%" align="center"><?=$pagevalue['apartments'][$i]['apnt_price'];?></td>
				<td width="10%" align="center"><?=$pagevalue['apartments'][$i]['apnt_object'];?></td>
				<td width="10%" align="center"><?=$pagevalue['apartments'][$i]['apnt_location'];?></td>
				<td width="18%" align="center"><?=$pagevalue['apartments'][$i]['apnt_region'];?></td>
			</tr>
		<?php endfor; ?>	
		</tbody>
	</table>
</div>
<button type="button" class="senden ApartsView" style="float:right;">Скрыть список</button>