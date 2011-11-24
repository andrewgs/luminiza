<?php
class Sidebartextmodel extends CI_Model{

	var $sbt_id = 0;
	var $sbt_extended = '';
	
	function __construct(){
        
		parent::__construct();
    }
	
	function get_records(){
		$this->db->order_by('sbt_id desc');
		$query = $this->db->get('sidebartext');
		return $query->result_array();
	}	
	
	function get_record($id){
	
		$this->db->where('sbt_id',$id);
		$query = $this->db->get('sidebartext',1);
		
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function count_records(){
	
		return $this->db->count_all('sidebartext');
	}
	
	function insert_record($data){
	 
		$this->sbt_extended =  $data['extended'];
		
		$this->db->insert('sidebartext', $this);
	}
	
	function update_record($data){
		
		$this->sbt_id = $data['id'];
		$this->sbt_extended =  $data['extended'];
		
		$this->db->where('sbt_id', $this->sbt_id);
		$this->db->update('sidebartext', $this);
	}
	
	function delete_record($id){
		
		$this->db->delete('sidebartext', array('sbt_id'=>$id));
	}
}
?>