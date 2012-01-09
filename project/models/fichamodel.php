<?php
class Fichamodel extends CI_Model{

	var $fch_id = 0; 			var $fch_fecha = ''; 		var $fch_nombre = ''; 		var $fch_referencia = '';	var $fch_direccion = '';
	var $fch_propiatario = '';	var $fch_telefono = '';		var $fch_tipo = '';			var $fch_planto = '';		var $fch_ano = '';
	var $fch_interior = '';		var $fch_exterior = '';		var $fch_terreno = '';		var $fch_dormitorios = '';	var $fch_banos = '';
	var $fch_aseos = '';		var $fch_terraza = '';		var $fch_patio = '';		var $fch_jardin = '';		var $fch_cocina = '';
	var $fch_mueble = '';		var $fch_armarios = '';		var $fch_solarium = '';		var $fch_garaje = '';		var $fch_trastero = '';
	var $fch_piscina = '';		var $fch_tennis = '';		var $fch_comunidad = '';	var $fch_vistas = '';		var $fch_precio = '';
	var $fch_negosiable = '';	var $fch_nuestro = '';		var $fch_observaciones = '';
	
	function __construct(){
    
		parent::__construct();
  	}
	
	function read_records(){
		$this->db->order_by('fch_id desc');
		$query = $this->db->get('ficha');
		$data = $query->result_array();
		if(count($data)) return $data;
		return FALSE;
	}	
	
	function read_record($id){
	
		$this->db->where('fch_id',$id);
		$query = $this->db->get('ficha',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function count_records(){
	
		return $this->db->count_all('ficha');
	}
	
	function insert_record($id,$data){
	 	
		$this->fch_id = $id;
		$this->fch_fecha = htmlspecialchars($data['fecha']);
		$this->fch_nombre = htmlspecialchars($data['nombre']);
		$this->fch_referencia = htmlspecialchars($data['referencia']);
		$this->fch_direccion = htmlspecialchars($data['direccion']);
		$this->fch_propiatario = htmlspecialchars($data['propiatario']);
		$this->fch_telefono = htmlspecialchars($data['telefono']);
		$this->fch_tipo = htmlspecialchars($data['tipo']);
		$this->fch_planto = htmlspecialchars($data['planto']);
		$this->fch_ano = htmlspecialchars($data['ano']);
		$this->fch_interior = htmlspecialchars($data['interior']);
		$this->fch_exterior = htmlspecialchars($data['exterior']);
		$this->fch_terreno = htmlspecialchars($data['terreno']);
		$this->fch_dormitorios = htmlspecialchars($data['dormitorios']);
		$this->fch_banos = htmlspecialchars($data['banos']);
		$this->fch_aseos = htmlspecialchars($data['aseos']);
		$this->fch_terraza = htmlspecialchars($data['terraza']);
		$this->fch_patio = htmlspecialchars($data['patio']);
		$this->fch_jardin = htmlspecialchars($data['jardin']);
		$this->fch_cocina = htmlspecialchars($data['cocina']);
		$this->fch_mueble = htmlspecialchars($data['mueble']);
		$this->fch_armarios = htmlspecialchars($data['armarios']);
		$this->fch_solarium = htmlspecialchars($data['solarium']);
		$this->fch_garaje = htmlspecialchars($data['garaje']);
		$this->fch_trastero = htmlspecialchars($data['trastero']);
		$this->fch_piscina = htmlspecialchars($data['piscina']);
		$this->fch_tennis = htmlspecialchars($data['tennis']);
		$this->fch_comunidad = htmlspecialchars($data['comunidad']);
		$this->fch_vistas = htmlspecialchars($data['vistas']);
		$this->fch_precio = htmlspecialchars($data['precio']);
		$this->fch_negosiable = htmlspecialchars($data['negosiable']);
		$this->fch_nuestro = htmlspecialchars($data['nuestro']);
		$this->fch_observaciones = strip_tags($data['observaciones'],'<br>');
		$this->db->insert('ficha',$this);
		return $this->db->insert_id();
	}
	
	function insert_empty($id){
	
		$this->fch_id = $id;
		$this->db->insert('ficha',$this);
		return $this->db->insert_id();
	}
	
	function update_record($id,$data){
		
		$this->db->set('fch_fecha',$data['fecha']);
		$this->db->set('fch_nombre',$data['nombre']);
		$this->db->set('fch_referencia',$data['referencia']);
		$this->db->set('fch_direccion',$data['direccion']);
		$this->db->set('fch_propiatario',$data['propiatario']);
		$this->db->set('fch_telefono',$data['telefono']);
		$this->db->set('fch_tipo',$data['tipo']);
		$this->db->set('fch_planto',$data['planto']);
		$this->db->set('fch_ano',$data['ano']);
		$this->db->set('fch_interior',$data['interior']);
		$this->db->set('fch_exterior',$data['exterior']);
		$this->db->set('fch_terreno',$data['terreno']);
		$this->db->set('fch_dormitorios',$data['dormitorios']);
		$this->db->set('fch_banos',$data['banos']);
		$this->db->set('fch_aseos',$data['aseos']);
		$this->db->set('fch_terraza',$data['terraza']);
		$this->db->set('fch_patio',$data['patio']);
		$this->db->set('fch_jardin',$data['jardin']);
		$this->db->set('fch_cocina',$data['cocina']);
		$this->db->set('fch_mueble',$data['mueble']);
		$this->db->set('fch_armarios',$data['armarios']);
		$this->db->set('fch_solarium',$data['solarium']);
		$this->db->set('fch_garaje',$data['garaje']);
		$this->db->set('fch_trastero',$data['trastero']);
		$this->db->set('fch_piscina',$data['piscina']);
		$this->db->set('fch_tennis',$data['tennis']);
		$this->db->set('fch_comunidad',$data['comunidad']);
		$this->db->set('fch_vistas',$data['vistas']);
		$this->db->set('fch_precio',$data['precio']);
		$this->db->set('fch_negosiable',$data['negosiable']);
		$this->db->set('fch_nuestro',$data['nuestro']);
		$this->db->set('fch_observaciones',$data['observaciones']);
		$this->db->where('fch_id',$id);
		$this->db->update('ficha');
		return $this->db->affected_rows();
	}
	
	function delete_record($id){
	
		$this->db->where('fch_id',$id);
		$this->db->delete('ficha');
		return $this->db->affected_rows();
	}
}
?>