<?php
class Feedbackmodel extends CI_Model{

	var $fbk_id = 0;
	var $fbk_fio = '';
	var $fbk_note = '';
	var $fbk_region = '';
	var $fbk_image = '';
	
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
	
	function read_limit_records($count,$from){
		
		$this->db->select('fbk_id,fbk_fio,fbk_note,fbk_region');
		$this->db->limit($count,$from);
		$query = $this->db->get('feedback');
		$data = $query->result_array();
		if(count($data)) return $data;
		return NULL;
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
		$this->fbk_image = $data['image'];
		$this->db->insert('feedback',$this);
		return $this->db->insert_id();
	}
	
	function update_record($id,$data){
		
		$this->db->set('fbk_fio',$data['fio']);
		$this->db->set('fbk_note',$data['note']);
		$this->db->set('fbk_region',$data['region']);
		if($data['image']):
			$this->db->set('fbk_image',$data['image']);
		endif;
		$this->db->where('fbk_id',$id);
		$this->db->update('feedback', $this);
		return $this->db->affected_rows();
	}
	
	function delete_record($id){
	
		$this->db->where('fbk_id',$id);
		$this->db->delete('feedback');
		return $this->db->affected_rows();
	}

	function get_image($id){
		
		$this->db->where('fbk_id',$id);
		$query = $this->db->get('feedback',1);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0]['fbk_image'];
		return NULL;
	}

	function rnd_record(){
		
		$query = "SELECT fbk_id,fbk_fio,fbk_note,fbk_region FROM feedback ORDER BY RAND() LIMIT 0,1;";
		$query = $this->db->query($query);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return null;
	}
}
?>