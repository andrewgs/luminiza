<div class="">
	<table id="reviews" summary="Список авто">
		<thead>
			<tr class="odd">
				<th scope="col" abbr="ID">ID</th>
				<th scope="col" abbr="Название">Название</th>	
				<th scope="col" abbr="Свойтва">Свойтва</th>	
			</tr>	
		</thead>
	    <tfoot>	
		 	&nbsp;
		</tfoot>
		<tbody>
		<?php for($i=0;$i<count($pagevalue['auto']);$i++):?>
			<tr rID="<?=$i?>">
				<td width="2%"><?=$pagevalue['auto'][$i]['rnta_id'];?></td> 
				<td width="30%"><?=$pagevalue['auto'][$i]['rnta_title'];?></td>
				<td width="68%"><?=$pagevalue['auto'][$i]['rnta_properties'];?></td>
			</tr>
		<?php endfor; ?>	
		</tbody>
	</table>
</div>
<button type="button" class="senden AutoView" style="float:right;">Скрыть список</button>