<?php
class Apartmentmodel extends CI_Model{

	var $apnt_id = 0;
	var $apnt_title = '';
	var $apnt_extended = '';
	var $apnt_price = 0;
	var $apnt_newprice = 0;
	var $apnt_price_rent = '';
	var $apnt_object = '';
	var $apnt_location = '';
	var $apnt_region = '';
	var $apnt_count = '';
	var $apnt_flag = 0;
	var $apnt_properties = '';
	var $apnt_date = '';
	var $apnt_sold = 0;
	var $apnt_recommended = 0;
	var $apnt_special = 0;
	
	function __construct(){
    
		parent::__construct();
  }
	
	function get_records(){
		$this->db->order_by('apnt_id desc');
		$query = $this->db->get('apartment');
		return $query->result_array();
	}	
	
	function get_record($id){
	
		$this->db->where('apnt_id',$id);
		$query = $this->db->get('apartment',1);
		
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		return NULL;
	}
	
	function get_min_price($flag){
		
		if($flag == 2):
			$query = "SELECT MIN(apnt_price) AS apnt_price, MIN(apnt_newprice) AS apnt_newprice FROM apartment WHERE (apnt_flag = 0 OR apnt_flag = 2) AND (apnt_price > 0 AND apnt_newprice > 0)";
		else:
			$query = "SELECT MIN(apnt_price) AS apnt_price, MIN(apnt_newprice) AS apnt_newprice FROM apartment WHERE (apnt_flag = 1) AND (apnt_price > 0 AND apnt_newprice > 0)";
		endif;
		$query = $this->db->query($query);
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		else return null;
	}
	
	function get_max_price($flag){
	
		$this->db->select_max('apnt_price');
		$this->db->select_max('apnt_newprice');
		if($flag == 2):
			$this->db->where('apnt_flag',0);
		else:
			$this->db->where('apnt_flag',1);
		endif;
		$this->db->or_where('apnt_flag',2);
		$query = $this->db->get('apartment');
		$data = $query->result_array();
		if(isset($data[0])) return $data[0];
		else return null;
	}
	
	function get_records_flag($flag){
	
		$this->db->order_by('apnt_id desc');
		if ($flag == 2)
			$this->db->where('apnt_flag',0);
		else
			$this->db->where('apnt_flag',1);
		$this->db->or_where('apnt_flag',2);
		$query = $this->db->get('apartment');
		return $query->result_array();
	}
	
	function get_comercial_flag($flag){
	
		$this->db->order_by('apnt_id desc');
		if ($flag == 5)
			$this->db->where('apnt_flag',3);
		else
			$this->db->where('apnt_flag',4);
		$this->db->or_where('apnt_flag',5);
		$query = $this->db->get('apartment');
		return $query->result_array();
	}
	
	function get_limit_records($count,$from,$flag,$sortby){
		//flag = [0]- продажа,[1] - аренда,[2] - продажа/аренда
		$this->db->select('apnt_id,apnt_title,apnt_extended,(apnt_price)*1 AS apnt_price,(apnt_newprice)*1 AS apnt_newprice,apnt_price_rent,apnt_object,apnt_location,apnt_region,apnt_count,apnt_flag,apnt_properties,apnt_date,apnt_sold,apnt_recommended,apnt_special');
		$this->db->limit($count,$from);
		if ($flag == 2)
			$this->db->where('apnt_flag',0);
		else
			$this->db->where('apnt_flag',1);
		$this->db->or_where('apnt_flag',2);
		if($sortby):
			if($sortby == 1)
				$this->db->order_by("apnt_price","ASC");
			else
				$this->db->order_by("apnt_price","DESC");
		else:
			$this->db->order_by("apnt_price","ASC");
//				$this->db->order_by('apnt_id desc');
		endif;
		$query = $this->db->get('apartment');
		return $query->result_array();
	} 
	
	function get_limit_commercial($count,$from,$flag,$sortby){
		//flag = [3]- продажа,[4] - аренда,[5] - продажа/аренда
		$this->db->select('apnt_id,apnt_title,apnt_extended,(apnt_price)*1 AS apnt_price,(apnt_newprice)*1 AS apnt_newprice, apnt_price_rent,apnt_object,apnt_location,apnt_region,apnt_count,apnt_flag,apnt_properties,apnt_date,apnt_sold,apnt_recommended,apnt_special');
		$this->db->limit($count,$from);
		if ($flag == 5)
			$this->db->where('apnt_flag',3);
		else
			$this->db->where('apnt_flag',4);
		$this->db->or_where('apnt_flag',5);
		if($sortby):
			if($sortby == 1)
				$this->db->order_by("apnt_price","ASC");
			else
				$this->db->order_by("apnt_price","DESC");
		else:
			$this->db->order_by("apnt_price","DESC");
		endif;
		$query = $this->db->get('apartment');
		return $query->result_array();
	} 
	
	function count_records(){
	
		return $this->db->count_all('apartment');
	}
	
	function count_records_flag($flag){
	
		if ($flag == 2)
			$this->db->where('apnt_flag',0);
		else
			$this->db->where('apnt_flag',1);
		$this->db->or_where('apnt_flag',2);
		$query = $this->db->get('apartment');
		return $query->num_rows();
	}
	
	function count_commercial_flag($flag){
	
		if ($flag == 5)
			$this->db->where('apnt_flag',3);
		else
			$this->db->where('apnt_flag',4);
		$this->db->or_where('apnt_flag',5);
		$query = $this->db->get('apartment');
		return $query->num_rows();
	}
	
	function insert_record($data){
	 
		$this->apnt_title = $data['title'];
		$this->apnt_extended = $data['extended'];
		$this->apnt_price = preg_replace("/\./","",$_POST['price']);
		$this->apnt_newprice = preg_replace("/\./","",$_POST['newprice']);
		$this->apnt_price_rent = $data['pricerent'];
		$this->apnt_object = $data['object'];
		$this->apnt_location = $data['location'];
		$this->apnt_region = $data['region'];
		$this->apnt_count = $data['count'];
		$this->apnt_flag = $data['flag'];
		$this->apnt_properties = $data['properties'];
		$this->apnt_sold = $data['sold'];
		$this->apnt_recommended = $data['recommended'];
		$this->apnt_special = $data['special'];

		$pattern = "/(\d+)\/(\w+)\/(\d+)/i";
		$replacement = "\$3-\$2-\$1";
		$this->apnt_date = preg_replace($pattern, $replacement, $_POST['date']);
		
		$this->db->insert('apartment', $this);
		return $this->db->insert_id();
	}
	
	function update_record($data){
		
		$this->apnt_id = $data['id'];
		$this->apnt_title = $data['title'];
		$this->apnt_extended = $data['extended'];
		$this->apnt_price = $data['price'];
		$this->apnt_newprice = $data['newprice'];
		$this->apnt_price_rent = $data['pricerent'];
		$this->apnt_object = $data['object'];
		$this->apnt_location = $data['location'];
		$this->apnt_region = $data['region'];
		$this->apnt_count = $data['count'];
		$this->apnt_flag = $data['flag'];
		$this->apnt_properties = $data['properties'];
		$this->apnt_sold = $data['sold'];
		$this->apnt_recommended = $data['recommended'];
		$this->apnt_special = $data['special'];
		
		$pattern = "/(\d+)\/(\w+)\/(\d+)/i";
		$replacement = "\$3-\$2-\$1";
		$this->apnt_date = preg_replace($pattern, $replacement, $_POST['date']);
		
		$this->db->where('apnt_id', $this->apnt_id);
		$this->db->update('apartment', $this);
	}
	
	function delete_record($id){
		
		$this->db->delete('apartment', array('apnt_id'=>$id));
	}
	
	function select_list($field){
		
		$this->db->group_by($field);
		$this->db->order_by($field);
		$this->db->select($field);
		$query = $this->db->get('apartment');
		
		return $query->result_array();
	}
	
	function search_apartment($sql){
		
		$query = mysql_query($sql) or die(mysql_error());
		$i = 0;
		$result = array();
		  while($line = mysql_fetch_array($query,MYSQL_ASSOC)):
		    foreach ($line as $key => $col_value)
					$result[$i][$key] = $col_value;
					$i++;
			endwhile;
			
		  mysql_free_result($query);
		if(!empty($result)) return $result;
		return NULL;		
	}
	
	function search_limit_apartment($sql,$count,$from){
		
		$query = mysql_query($sql) or die(mysql_error());
		
		$i = 0;
		$result = array();
	  while($line = mysql_fetch_array($query,MYSQL_ASSOC)):
	    foreach ($line as $key => $col_value)
				$result[$i][$key] = $col_value;
				$i++;
		endwhile;
		
	  mysql_free_result($query);
		if(!empty($result)) return $result;
		return NULL;		
	}
}
?>