<?=form_open_multipart($this->uri->uri_string(),array('id'=>'frmRent'));?>
	<?=form_error('name').'<div class="clear"></div>'; ?>
	
	<div class="m-sangria">
		<label for="fecha">FECHA</label>
		<input type="text" class="inv" name="fecha" value="">
	</div>
	<div class="m-sangria">
		<label for="nombre">NOMBRE quien hizo la referencia</label>
		<input type="text" class="inv" name="nombre" value="">
		<label for="referencia">REFERENCIA</label>
		<input type="text" class="inv" name="referencia" value="">
	</div>
	<div class="m-sangria">
		<label for="direccion">DIRECCION</label>
		<input type="text" class="inv" name="direccion" value="">
	</div>
	<div class="m-sangria">
		<label for="propiatario">NOMBRE DEL PROPIETARIO</label>
		<input type="text" class="inv" name="propiatario" value="">
	</div>
	<div class="m-sangria">
		<label for="telefono">TELEFONO DE CONTACTO</label>
		<input type="text" class="inv" name="telefono" value="">
	</div>
	<div class="m-sangria">
		<label for="tipo">TIPO DE LA FINCA</label>
		<input type="text" class="inv" name="tipo" value="">
		<label for="planto">PLANTO</label>
		<input type="text" class="inv" name="planto" value="">
		<label for="ano">ANO</label>
		<input type="text" class="inv" name="ano" value="">
	</div>
	<div class="m-sangria">
		<label for="interior">SUPIRFICIE INTERIOR</label>
		<input type="text" class="inv" name="interior" value="">
		<label for="exterior">SUPERFICIO EXTERIOR</label>
		<input type="text" class="inv" name="exterior" value="">
		<label for="terreno">TERRENO</label>
		<input type="text" class="inv" name="terreno" value="">
	</div>
	<div class="m-sangria">
		<label for="dormitorios">DORMITORIOS</label>
		<input type="text" class="inv" name="dormitorios" value="">
		<label for="banos">BANOS</label>
		<input type="text" class="inv" name="banos" value="">
		<label for="aseos">ASEOS</label>
		<input type="text" class="inv" name="aseos" value="">
	</div>
	<div class="m-sangria">
		<label for="terraza">TERRAZA</label>
		<input type="text" class="inv" name="terraza" value="">
		<label for="patio">PATIO</label>
		<input type="text" class="inv" name="patio" value="">
		<label for="jardin">JARDIN</label>
		<input type="text" class="inv" name="jardin" value="">
	</div>
	<div class="m-sangria">
		<label for="cocina">COCINA</label>
		<input type="text" class="inv" name="cocina" value="">
		<label for="mueble">SE VENDE CON MUEBLE</label>
		<input type="text" class="inv" name="mueble" value="">
		<label for="armarios">ARMARIOS EMPOTRADOS</label>
		<input type="text" class="inv" name="armarios" value="">
	</div>
	<div class="m-sangria">
		<label for="solarium">SOLARIUM</label>
		<input type="text" class="inv" name="solarium" value="">
		<label for="garaje">GARAJE</label>
		<input type="text" class="inv" name="garaje" value="">
		<label for="trastero">TRASTERO</label>
		<input type="text" class="inv" name="trastero" value="">
	</div>
	<div class="m-sangria">
		<label for="piscina">PISCINA</label>
		<input type="text" class="inv" name="piscina" value="">
		<label for="tennis">TENNIS</label>
		<input type="text" class="inv" name="tennis" value="">
		<label for="comunidad">COMUNIDAD</label>
		<input type="text" class="inv" name="comunidad" value="">
	</div>
	<div class="m-sangria">
		<label for="vistas">VISTAS</label>
		<input type="text" class="inv" name="vistas" value="">
	</div>
	<div class="sangria">
		<label for="precio">PRECIO</label>
		<input type="text" class="inv" name="precio" value="">
		<label for="negosiable">NEGOSIABLE</label>
		<input type="text" class="inv" name="negosiable" value="">
		<label for="nuestro">NUESTRO PRECIO</label>
		<input type="text" class="inv" name="nuestro" value="">
	</div>
	<div class="sangria">
		<label for="observaciones">OBSERVACIONES</label>
		<div>
			<textarea class="inv" name="observaciones"></textarea>
		</div>
	</div>
	
	<div>
		<button type="submit" id="send" class="senden" value="send" name="submit">Entregar</button>
	</div>
	
<?=form_close(); ?>