<?=form_open($this->uri->uri_string(),array('id'=>'frmRent'));?>
	<div class="m-sangria">
		<label for="fecha">FECHA</label>
		<input type="text" class="inv inpval" name="fecha" value="<?=$pagevalue['ficha']['fch_fecha'];?>">
	</div>
	<div class="m-sangria">
		<label for="nombre">NOMBRE quien hizo la referencia</label>
		<input type="text" class="inv" name="nombre" value="<?=$pagevalue['ficha']['fch_nombre'];?>">
		<label for="referencia">REFERENCIA</label>
		<input type="text" class="inv inpval" name="referencia" value="<?=$pagevalue['ficha']['fch_referencia'];?>">
	</div>
	<div class="m-sangria">
		<label for="direccion">DIRECCION</label>
		<input type="text" class="inv" name="direccion" value="<?=$pagevalue['ficha']['fch_direccion'];?>">
	</div>
	<div class="m-sangria">
		<label for="propiatario">NOMBRE DEL PROPIETARIO</label>
		<input type="text" class="inv" name="propiatario" value="<?=$pagevalue['ficha']['fch_propiatario'];?>">
	</div>
	<div class="m-sangria">
		<label for="telefono">TELEFONO DE CONTACTO</label>
		<input type="text" class="inv" name="telefono" value="<?=$pagevalue['ficha']['fch_telefono'];?>">
	</div>
	<div class="m-sangria">
		<label for="tipo">TIPO DE LA FINCA</label>
		<input type="text" class="inv" name="tipo" value="<?=$pagevalue['ficha']['fch_tipo'];?>">
		<label for="planto">PLANTO</label>
		<input type="text" class="inv" name="planto" value="<?=$pagevalue['ficha']['fch_planto'];?>">
		<label for="ano">ANO</label>
		<input type="text" class="inv" name="ano" value="<?=$pagevalue['ficha']['fch_ano'];?>">
	</div>
	<div class="m-sangria">
		<label for="interior">SUPIRFICIE INTERIOR</label>
		<input type="text" class="inv" name="interior" value="<?=$pagevalue['ficha']['fch_interior'];?>">
		<label for="exterior">SUPERFICIO EXTERIOR</label>
		<input type="text" class="inv" name="exterior" value="<?=$pagevalue['ficha']['fch_exterior'];?>">
		<label for="terreno">TERRENO</label>
		<input type="text" class="inv" name="terreno" value="<?=$pagevalue['ficha']['fch_terreno'];?>">
	</div>
	<div class="m-sangria">
		<label for="dormitorios">DORMITORIOS</label>
		<input type="text" class="inv" name="dormitorios" value="<?=$pagevalue['ficha']['fch_dormitorios'];?>">
		<label for="banos">BANOS</label>
		<input type="text" class="inv" name="banos" value="<?=$pagevalue['ficha']['fch_banos'];?>">
		<label for="aseos">ASEOS</label>
		<input type="text" class="inv" name="aseos" value="<?=$pagevalue['ficha']['fch_aseos'];?>">
	</div>
	<div class="m-sangria">
		<label for="terraza">TERRAZA</label>
		<input type="text" class="inv" name="terraza" value="<?=$pagevalue['ficha']['fch_terraza'];?>">
		<label for="patio">PATIO</label>
		<input type="text" class="inv" name="patio" value="<?=$pagevalue['ficha']['fch_patio'];?>">
		<label for="jardin">JARDIN</label>
		<input type="text" class="inv" name="jardin" value="<?=$pagevalue['ficha']['fch_jardin'];?>">
	</div>
	<div class="m-sangria">
		<label for="cocina">COCINA</label>
		<input type="text" class="inv" name="cocina" value="<?=$pagevalue['ficha']['fch_cocina'];?>">
		<label for="mueble">SE VENDE CON MUEBLE</label>
		<input type="text" class="inv" name="mueble" value="<?=$pagevalue['ficha']['fch_mueble'];?>">
		<label for="armarios">ARMARIOS EMPOTRADOS</label>
		<input type="text" class="inv" name="armarios" value="<?=$pagevalue['ficha']['fch_armarios'];?>">
	</div>
	<div class="m-sangria">
		<label for="solarium">SOLARIUM</label>
		<input type="text" class="inv" name="solarium" value="<?=$pagevalue['ficha']['fch_solarium'];?>">
		<label for="garaje">GARAJE</label>
		<input type="text" class="inv" name="garaje" value="<?=$pagevalue['ficha']['fch_garaje'];?>">
		<label for="trastero">TRASTERO</label>
		<input type="text" class="inv" name="trastero" value="<?=$pagevalue['ficha']['fch_trastero'];?>">
	</div>
	<div class="m-sangria">
		<label for="piscina">PISCINA</label>
		<input type="text" class="inv" name="piscina" value="<?=$pagevalue['ficha']['fch_piscina'];?>">
		<label for="tennis">TENNIS</label>
		<input type="text" class="inv" name="tennis" value="<?=$pagevalue['ficha']['fch_tennis'];?>">
		<label for="comunidad">COMUNIDAD</label>
		<input type="text" class="inv" name="comunidad" value="<?=$pagevalue['ficha']['fch_comunidad'];?>">
	</div>
	<div class="m-sangria">
		<label for="vistas">VISTAS</label>
		<input type="text" class="inv" name="vistas" value="<?=$pagevalue['ficha']['fch_vistas'];?>">
	</div>
	<div class="sangria">
		<label for="precio">PRECIO</label>
		<input type="text" class="inv" name="precio" value="<?=$pagevalue['ficha']['fch_precio'];?>">
		<label for="negosiable">NEGOSIABLE</label>
		<input type="text" class="inv" name="negosiable" value="<?=$pagevalue['ficha']['fch_negosiable'];?>">
		<label for="nuestro">NUESTRO PRECIO</label>
		<input type="text" class="inv" name="nuestro" value="<?=$pagevalue['ficha']['fch_nuestro'];?>">
	</div>
	<div class="sangria">
		<label for="observaciones">OBSERVACIONES</label>
		<div>
			<textarea class="inv" name="observaciones"><?=$pagevalue['ficha']['fch_observaciones'];?></textarea>
		</div>
	</div>
	<div>
		<button type="submit" id="send" class="senden" value="send" name="submit">Entregar</button>
	</div>
<?=form_close(); ?>