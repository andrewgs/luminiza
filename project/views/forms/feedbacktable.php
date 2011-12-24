<div class="">
	<table id="reviews" summary="Список отзывов">
		<thead>
			<tr class="odd">
				<th scope="col" abbr="ID">ID</th>
				<th scope="col" abbr="ФОТО">ФОТО</th>
				<th scope="col" abbr="ИМИЯ И ФАМИЛИЯ">Имя и Фамилия</th>	
				<th scope="col" abbr="ГОРОД">Город</th>
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
				<td width="2%" rID="<?=$i?>"><?=$pagevalue['feedback'][$i]['fbk_id'];?></td>
				<td><?=$i;?></td>
				<td width="16%" align="center"><?=$pagevalue['feedback'][$i]['fbk_fio'];?></td>
				<td width="10%" align="center"><?=$pagevalue['feedback'][$i]['fbk_region'];?></td>
				<td width="70%"><?=$pagevalue['feedback'][$i]['fbk_note'];?></td>
				<td width="2%">
					<div class="ButtonOperation">
			<input type="image" title="Удалить" id="d<?=$i?>" rID="<?=$i;?>" class="btndel" src="<?=$pagevalue['baseurl'];?>images/delete.png" />
					</div>
				</td> 
			</tr>
		<?php endfor; ?>	
		</tbody>
	</table>
</div>