<?php
class Rentautomodel extends CI_Model{

	var $rnta_id = 0;
	var $rnta_title = '';
	var $rnta_extended = '';
	var $rnta_properties = '';
	var $rnta_price = '';
	
	function __construct(){
    
		parent::__construct();
  }
	
	function get_records(){
		$this->db->order_by('rnta_id asc');
		$query = $this->db->get('rentauto');
		return $query->result_array();
	}	
	
	function get_record($id){
	
		$this->db->where('rnta_id',$id);
		$query = $this->db->get('rentauto',1);
		
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function count_records(){
	
		return $this->db->count_all('rentauto');
	}
	
	function insert_record($data){
	 
		$this->rnta_title = $data['title'];
		$this->rnta_extended = $data['extended'];
		$this->rnta_properties = $data['properties'];
		$this->rnta_price = $data['pricerent'];
		
		$this->db->insert('rentauto', $this);
	}
	
	function update_record($data){
		
		$this->rnta_id = $data['id'];
		$this->rnta_title = $data['title'];
		$this->rnta_extended = $data['extended'];
		$this->rnta_properties = $data['properties'];
		$this->rnta_price = $data['pricerent'];
		
		$this->db->where('rnta_id', $this->rnta_id);
		$this->db->update('rentauto', $this);
	}
	
	function delete_record($id){
		
		$this->db->delete('rentauto', array('rnta_id'=>$id));
	}
}
?>