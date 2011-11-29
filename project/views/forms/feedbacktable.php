<div class="">
	<table summary="Список отзывов">
		<thead>
			<tr class="odd">
				<th scope="col" abbr="ID">ID</th>
				<th scope="col" abbr="ИМИЯ И ФАМИЛИЯ">Имя и фамилия</th>	
				<th scope="col" abbr="ГОРОД">Город</th>
				<th scope="col" abbr="ТЕЛЕФОН">ТЕЛ.</th>
				<th scope="col" abbr="ОТЗЫВ">Отзыв</th>
				<th scope="col" abbr="ДЕЙСТВИЯ">&nbsp;</th>
			</tr>	
		</thead>
	    <tfoot>	
		 	&nbsp;
		</tfoot>
		<tbody>
		<?php for($i=0;$i<count($pagevalue['feedback']);$i++):?>
			<tr rID="<?=$i?>"> 
				<td rID="<?=$i?>"><?=$pagevalue['feedback'][$i]['fbk_id'];?></td>
				<td><?=$pagevalue['feedback'][$i]['fbk_fio'];?></td>
				<td><?=$pagevalue['feedback'][$i]['fbk_region'];?></td>
				<td><?=$pagevalue['feedback'][$i]['fbk_note'];?></td>
				<td>
					<div class="ButtonOperation">
			<input type="image" title="Удалить" id="d<?=$i?>" rID="<?=$i;?>" class="btndel" src="<?=$pagevalue['baseurl'];?>images/delete.png" />
					</div>
				</td> 
			</tr>
		<?php endfor; ?>	
		</tbody>
	</table>
</div>