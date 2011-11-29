<?php
class Feedbackmodel extends CI_Model{

	var $fbk_id = 0;
	var $fbk_fio = '';
	var $fbk_note = '';
	var $fbk_region = '';
	
	function __construct(){
    
		parent::__construct();
  }
	
	function read_records(){
		$this->db->order_by('fbk_id desc');
		$query = $this->db->get('feedback');
		$data = $query->result_array();
		if(count($data)) return $data;
		return FALSE;
	}	
	
	function read_record($id){
	
		$this->db->where('fbk_id',$id);
		$query = $this->db->get('feedback',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function count_records(){
	
		return $this->db->count_all('feedback');
	}
	
	function insert_record($data){
	 
		$this->fbk_fio = htmlspecialchars($data['fio']);
		$this->fbk_note = strip_tags($data['note'],'<br>');
		$this->fbk_region = htmlspecialchars($data['region']);
		$this->db->insert('feedback',$this);
		return $this->db->insert_id();
	}
	
	function update_record($id,$data){
		
		$this->db->set('fbk_fio',$data['fio']);
		$this->db->set('fbk_note',$data['note']);
		$this->db->set('fbk_region',$data['region']);
		$this->db->where('fbk_id',$id);
		$this->db->update('feedback', $this);
		return $this->db->affected_rows();
	}
	
	function delete_record($id){
		$this->db->where('fbk_id',$id);
		$this->db->delete('feedback');
		return $this->db->affected_rows();
	}
}
?>