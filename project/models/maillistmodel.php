<?php
class Maillistmodel extends CI_Model{

	var $ml_id = 0;
	var $ml_name = '';
	var $ml_extended = '';
	var $ml_email = '';
	var $ml_date_mail = '';
	
	function __construct(){
        
		parent::__construct();
    }
	
	function get_records(){
		$this->db->order_by('ml_id desc');
		$query = $this->db->get('maillist');
		return $query->result_array();
	}	
	
	function get_record($id){
	
		$this->db->where('ml_id',$id);
		$query = $this->db->get('maillist',1);
		
		$data = $query->result_array();
		return $data[0];
	}
	
	function count_records(){
	
		return $this->db->count_all('maillist');
	}
	
	function insert_record($data){
	 
		$this->ml_name =  $data['name'];
		$this->ml_extended = $data['extended'];
		$this->ml_email = $data['email'];
		$this->ml_date_mail = $data['date'];
		
		$this->db->insert('maillist', $this);
	}
	
	function update_record($data){
		
		$this->ml_id = $data['id'];
		$this->ml_name =  $data['name'];
		$this->ml_extended = $data['extended'];
		$this->ml_email = $data['email'];
		$this->ml_date_mail = $data['date'];
		
		$this->db->where('ml_id', $this->ml_id);
		$this->db->update('maillist', $this);
	}
	
	function delete_record($id){
		
		$this->db->delete('maillist', array('ml_id'=>$id));
	}
}
?>