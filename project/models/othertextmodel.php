<?php
class Othertextmodel extends CI_Model{

	var $txt_id = 0;
	var $txt_title = '';
	var $txt_extended = '';
	
	function __construct(){
    
		parent::__construct();
  }
	
	function get_records(){
		$this->db->order_by('txt_id asc');
		$query = $this->db->get('othertext');
		return $query->result_array();
	}	
	
	function get_record($id){
	
		$this->db->where('txt_id',$id);
		$query = $this->db->get('othertext',1);
		
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function count_records(){
	
		return $this->db->count_all('othertext');
	}
	
	function insert_record($data){
	 
		$this->txt_title = $data['title'];
		$this->txt_extended = $data['extended'];
		
		$this->db->insert('othertext', $this);
	}
	
	function update_record($data){
		
		$this->txt_id = $data['id'];
		$this->txt_title = $data['title'];
		$this->txt_extended = $data['extended'];
		
		$this->db->where('txt_id', $this->txt_id);
		$this->db->update('othertext', $this);
	}
	
	function delete_record($id){
		
		$this->db->delete('othertext', array('txt_id'=>$id));
	}
	
	function limit_records($count,$from){
		
		$this->db->order_by('txt_id asc');
		$this->db->limit($count,$from);

		$query = $this->db->get('othertext');
		return $query->result_array();
	} 
}
?>