<?php
class Tourlistmodel extends CI_Model{

	var $tour_id = 0;
	var $tour_title = '';
	var $tour_extended = '';
	
	function __construct(){
    
		parent::__construct();
  }
	
	function get_records(){
		$this->db->order_by('tour_id asc');
		$query = $this->db->get('tourlist');
		return $query->result_array();
	}	
	
	function get_record($id){
	
		$this->db->where('tour_id',$id);
		$query = $this->db->get('tourlist',1);
		
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function count_records(){
	
		return $this->db->count_all('tourlist');
	}
	
	function insert_record($data){
	 
		$this->tour_title = $data['title'];
		$this->tour_extended = $data['extended'];
		
		$this->db->insert('tourlist', $this);
	}
	
	function update_record($data){
		
		$this->tour_id = $data['id'];
		$this->tour_title = $data['title'];
		$this->tour_extended = $data['extended'];
		
		$this->db->where('tour_id', $this->tour_id);
		$this->db->update('tourlist', $this);
	}
	
	function delete_record($id){
		
		$this->db->delete('tourlist', array('tour_id'=>$id));
	}
}
?>