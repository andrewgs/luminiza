<?php
class Users_interface extends CI_Controller{

	var $admin = array('status'=>FALSE);
	var $months = array("00"=>"","01"=>"января","02"=>"февраля","03"=>"марта","04"=>"апреля","05"=>"мая",
						"06"=>"июня","07"=>"июля","08"=>"августа","09"=>"сентября","10"=>"октября","11"=>"ноября","12"=>"декабря");
	var $message = array('error'=>'','saccessfull'=>'','message'=>'','status'=>0);

	function __construct(){
	
		parent::__construct();
		$this->load->model('apartmentmodel');
		$this->load->model('authentication');
		$this->load->model('maillistmodel');
		$this->load->model('rentautomodel');		
		$this->load->model('othertextmodel');
		$this->load->model('imagesmodel');
		$this->load->model('sidebartextmodel');
		$this->load->model('tourlistmodel');		
		$this->load->model('feedbackmodel');		
		
		if($this->session->userdata('logon') == '0ddd2cf5b8929fcbd721f2365099c6e3')
			$this->admin['status'] = TRUE;
	}
	
	function index(){
		
		$pagevalue = array(
					'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
					'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
					'author' => 'RealityGroup',
					'title' => 'Недвижимость на Тенерифе | Аренда апартаментов и вилл | Ипотека в Испании | Экскурсии | Трансферы | Luminiza Property Tur S.L.',
					'baseurl' 		=> base_url(),
					'admin' 		=> $this->admin['status'],
					'text' 			=> '',
					'slideshow' 	=> array(),
					'apartment' 	=> array()
			);
		$this->session->set_userdata('backpage','');
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$slideshow = array();$text = array();$apartment = array();$islands = array();$islandstext = array();
		$text = $this->othertextmodel->get_record(8);
		$apart = $this->apartmentmodel->get_records_flag(2);
		if(isset($apart) and !empty($apart)):
			(count($apart) >= 4) ? $cnt = 4 : $cnt = count($apart);
			$keys = array_rand($apart,$cnt);
			if(count($keys) > 1):
				for($i = 0; $i < $cnt; $i++):
					$apart1[$i] = $apart[$keys[$i]];
				endfor;
			else:
				$apart1[0] = $apart[0];
			endif;
			if(count($apart1) > 0):
				for($i = 0; $i < count($apart1); $i++):
					$image = $this->imagesmodel->get_type_ones_image('apartment',$apart1[$i]['apnt_id']);
					$slideshow[$i]['link'] = 'retail/apartment/'.$apart1[$i]['apnt_id'];
					$slideshow[$i]['title'] = strip_tags($apart1[$i]['apnt_title'],'<sup>');
					$slideshow[$i]['extended'] = strip_tags($apart1[$i]['apnt_extended'],'<sup>');
					if (mb_strlen($slideshow[$i]['extended'],'UTF-8') > 250):
						$tmp = $slideshow[$i]['extended'];			
						$tmp = mb_substr($tmp,0,250,'UTF-8');	
						$pos = mb_strrpos($tmp,'.',0,'UTF-8');
						$tmp = mb_substr($tmp,0,$pos,'UTF-8');
						$slideshow[$i]['extended'] = $tmp.'. ...';
					endif;
					$slideshow[$i]['image'] = $image['img_id'];
					$slideshow[$i]['img_title'] = $image['img_title'];
					if(empty($slideshow[$i]['img_title'])) $slideshow[$i]['img_title'] = $slideshow[$i]['title'];
				endfor;
			endif;
		endif;
		$commercial = $this->apartmentmodel->get_comercial_flag(5);
		if(isset($commercial) and !empty($commercial)):
			(count($commercial) >= 4) ? $cnt = 4 : $cnt = count($commercial);
			$keys = array_rand($commercial,$cnt);
			if(count($keys) > 1):
				for($i = 0; $i < $cnt; $i++):
					$commercial1[$i] = $commercial[$keys[$i]];
				endfor;
			else:
				$commercial1[0] = $commercial[0];
			endif;
			if(count($commercial1) > 0):
				$count = count($slideshow);
				for($i = $count,$y = 0; $i < $count+count($commercial1); $i++,$y++):
					$image = $this->imagesmodel->get_type_ones_image('commercial',$commercial1[$y]['apnt_id']);
					$slideshow[$i]['link'] = 'retail/apartment/'.$commercial1[$y]['apnt_id'];
					$slideshow[$i]['title'] = strip_tags($commercial1[$y]['apnt_title'],'<sup>');
					$slideshow[$i]['extended'] = strip_tags($commercial1[$y]['apnt_extended'],'<sup>');
					if (mb_strlen($slideshow[$i]['extended'],'UTF-8') > 250):
						$tmp = $slideshow[$i]['extended'];			
						$tmp = mb_substr($tmp,0,250,'UTF-8');	
						$pos = mb_strrpos($tmp,'.',0,'UTF-8');
						$tmp = mb_substr($tmp,0,$pos,'UTF-8');
						$slideshow[$i]['extended'] = $tmp.'. ...';
					endif;
					$slideshow[$i]['image'] = $image['img_id'];
					$slideshow[$i]['img_title'] = $image['img_title'];
					if(empty($slideshow[$i]['img_title'])) $slideshow[$i]['img_title'] = $slideshow[$i]['title'];
				endfor;
			endif;
		endif;
		$island = $this->imagesmodel->get_type_ones_image('about',0);
		if(isset($island) and !empty($island))
			$islands = $this->imagesmodel->get_images_without('about',0,$island['img_id']);
		if(isset($islands) and !empty($islands)):
			(count($islands) >= 4) ? $cnt = 4 : $cnt = count($islands);
			$islandstext = $this->othertextmodel->limit_records($cnt,13);
			shuffle($islandstext);
			$count = count($slideshow);
			for($i = $count,$y = 0; $i < $count+$cnt; $i++,$y++):
				$slideshow[$i]['link'] = 'about';
				$slideshow[$i]['title'] = '';
				$slideshow[$i]['extended'] = $islandstext[$y]['txt_extended'];
				$slideshow[$i]['image'] = $islands[$y]['img_id'];
				$slideshow[$i]['img_title'] = $islands[$y]['img_title'];
			endfor;
			shuffle($slideshow);
		endif;
		$apart = $this->apartmentmodel->get_records_flag(1);
		if(isset($apart) and !empty($apart)){
			(count($apart) >= 3) ? $cnt = 3 : $cnt = count($apart);
			$keys = array_rand($apart,$cnt);
			if(count($keys) > 1) 
				for($i = 0; $i < $cnt; $i++)
					$apart2[$i] = $apart[$keys[$i]];
			else
				$apart2[0] = $apart[0];
			if(count($apart2) > 0)
				for($i = 0; $i < count($apart2); $i++){
					$image = $this->imagesmodel->get_type_ones_image('apartment',$apart2[$i]['apnt_id']);
					$apartment[$i]['id'] = $apart2[$i]['apnt_id'];
					$apartment[$i]['img_id'] = $image['img_id'];
					$apart2[$i]['apnt_title'] = $apart2[$i]['apnt_title'];
					$apart2[$i]['apnt_extended'] = strip_tags($apart2[$i]['apnt_extended'],'<sup>');
					if (mb_strlen($apart2[$i]['apnt_extended'],'UTF-8') > 250):	
						$apart2[$i]['apnt_extended'] = mb_substr($apart2[$i]['apnt_extended'],0,250,'UTF-8');	
						$pos = mb_strrpos($apart2[$i]['apnt_extended'],' ',0,'UTF-8');
						$apart2[$i]['apnt_extended'] = mb_substr($apart2[$i]['apnt_extended'],0,$pos,'UTF-8');
						$apart2[$i]['apnt_extended'] .= ' ...';
					endif;
					$apartment[$i]['title'] = $apart2[$i]['apnt_title'];
					$apartment[$i]['extended'] = $apart2[$i]['apnt_extended'];
					if(empty($apartment[$i]['img_title'])) $apartment[$i]['img_title'] = $apartment[$i]['title'];
				}
		}
		$pagevalue['text'] = $text;
		$pagevalue['slideshow'] = $slideshow;
		$pagevalue['apartment'] = $apartment;
		$this->load->view('user_interface/index',$pagevalue);
	}			//функция выводит информацию на главную страницу;
	
	function about(){
		
		$pagevalue = array(
			'description' =>'Описание острова Тенерифе с фотографиями. Климат на острове, погода. Описание праздников, парадов и карнавала. Недвижимость на Тенерифе. Продажа и аренда апартаментов. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' => 'RealityGroup',
			'title' => 'О Тенерифе | Достопримечательности Тенерифе | Недвижимость, аренда, экскурсии, трансферы | Luminiza Property Tur S.L.',
			'baseurl' => base_url(),
			'admin' => $this->admin['status'],
			'island' => array(),
			'sidebar' => array(),
			'images' => array()
		);
		$this->session->set_userdata('backpath',$this->uri->uri_string());
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$island = array();$sidebar = array();$images = array();		
		$island['first'] = $this->othertextmodel->get_record(9);
		$island['second'] = $this->othertextmodel->get_record(10);
		$sidebar = $this->sidebartextmodel->get_record(2);
		if(isset($island) and !empty($island)):
			$image = $this->imagesmodel->get_type_ones_image('about',0);
			if(isset($image) and !empty($image))
				$images = $this->imagesmodel->get_images_without('about',0,$image['img_id']);
			$island['img_id'] = $image['img_id'];
			$island['img_title'] = $image['img_title'];
		endif;
		$pagevalue['island'] = $island;
		$pagevalue['sidebar'] = $sidebar;
		$pagevalue['images'] = $images;
		$this->load->view('user_interface/about',$pagevalue);
	} //функция выводит информацию об острове;
	
	function retail(){
		
		if(isset($_POST['sortlink'])):
			$this->session->set_userdata('sortby',$_POST['sortvalue']);
		endif;
		$pagevalue = array(
			'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' 	=> 'RealityGroup',
			'title' 	=> 'Недвижимость на Тенерифе | Продажа апартаментов и вилл | Ипотека в Испании | Luminiza Property Tur S.L.',
			'baseurl' 	=> base_url(),
			'admin' 	=> $this->admin['status'],
			'formsort' 	=> $this->uri->uri_string(),
			'softvalue' => $this->session->userdata('sortby'),
			'selectvalue' => array(),
			'apartment' => array(),
			'text' 		=> array(),
			'countrecord' => array(),
			'lowprice'	=> min($this->apartmentmodel->get_min_price(2)),
			'topprice'	=> max($this->apartmentmodel->get_max_price(2)),
			'sname' 	=> $this->session->userdata('sname')
		);
		if(!$pagevalue['softvalue']) $pagevalue['softvalue'] = 0;
		$this->session->set_userdata('backpath',$this->uri->uri_string());
		$this->session->set_userdata('backpage',$this->uri->uri_string());
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$selectvalue = array();$apartment = array();$text = array();$countrecord = array();
		
		$selectvalue['object'] 		= $this->apartmentmodel->select_list('apnt_object');
		$selectvalue['location']	= $this->apartmentmodel->select_list('apnt_location');
		$selectvalue['region'] 		= $this->apartmentmodel->select_list('apnt_region');
		$selectvalue['count'] 		= $this->apartmentmodel->select_list('apnt_count');
		for($i=0;$i<count($selectvalue['count']);$i++):
			if(is_numeric($selectvalue['count'][$i]['apnt_count'])):
				$selectvalue['count'][$i]['apnt_count'] = intval($selectvalue['count'][$i]['apnt_count']);
			else:
				continue;
			endif;
		endfor;
		sort($selectvalue['count']);
		$countrecord['object'] 		= count($selectvalue['object']);
		$countrecord['location'] 	= count($selectvalue['location']);
		$countrecord['region'] 		= count($selectvalue['region']);
		$countrecord['count'] 		= count($selectvalue['count']);
		
		$text['sidebar'] = $this->sidebartextmodel->get_record(3);
		$text['head'] = $this->othertextmodel->get_record(1);
		
		$cntrec = $this->apartmentmodel->count_records_flag(2);
		
		$cfgpag['base_url'] = base_url().'/retail';
        $cfgpag['total_rows'] = $cntrec;
        $cfgpag['per_page'] =  10;
        $cfgpag['num_links'] = 4;
        $cfgpag['uri_segment'] = 2;
		$cfgpag['first_link'] = FALSE;
		$cfgpag['first_tag_open'] = '<li>';
		$cfgpag['first_tag_close'] = '</li>';
		$cfgpag['last_link'] = FALSE;
		$cfgpag['last_tag_open'] = '<li>';
		$cfgpag['last_tag_close'] = '</li>';
		$cfgpag['next_link'] = 'Далее &raquo;';
		$cfgpag['next_tag_open'] = '<li>';
		$cfgpag['next_tag_close'] = '</li>';
		$cfgpag['prev_link'] = '&laquo; Назад';
		$cfgpag['prev_tag_open'] = '<li>';
		$cfgpag['prev_tag_close'] = '</li>';
		$cfgpag['cur_tag_open'] = '<li><a class="active" href="#">';
		$cfgpag['cur_tag_close'] = '</a></li>';
		$cfgpag['num_tag_open'] = '<li>';
		$cfgpag['num_tag_close'] = '</li>';			
		
		$from = intval($this->uri->segment(2));	
		$sortby = $this->session->userdata('sortby');
		$apartment = $this->apartmentmodel->get_limit_records(10,$from,2,$sortby);
		for($i=0;$i<count($apartment);$i++):		
			if (mb_strlen($apartment[$i]['apnt_extended'],'UTF-8') > 325):									
				$apartment[$i]['apnt_extended'] = mb_substr($apartment[$i]['apnt_extended'],0,325,'UTF-8');	
				$pos = mb_strrpos($apartment[$i]['apnt_extended'],' ',0,'UTF-8');
				$apartment[$i]['apnt_extended'] = mb_substr($apartment[$i]['apnt_extended'],0,$pos,'UTF-8');
				$apartment[$i]['apnt_extended'] .= ' ...';
			endif;
			if(is_numeric($apartment[$i]['apnt_price'])):
				$apartment[$i]['apnt_price'] = number_format($apartment[$i]['apnt_price'],0,' ','.');
			endif;
			if(is_numeric($apartment[$i]['apnt_newprice'])):
				$apartment[$i]['apnt_newprice'] = number_format($apartment[$i]['apnt_newprice'],0,' ','.');
			endif;
		endfor;
		for($i=0;$i<count($apartment);$i++):
			$image[$i] = $this->imagesmodel->get_type_ones_image('apartment',$apartment[$i]['apnt_id']);
			$apartment[$i]['img_id'] = $image[$i]['img_id'];
			$apartment[$i]['img_title'] = $image[$i]['img_title'];
			if(empty($apartment[$i]['img_title'])) $apartment[$i]['img_title'] = $apartment[$i]['apnt_title'];
		endfor;
		
		$this->pagination->initialize($cfgpag);
		$text['pager'] = $this->pagination->create_links();
		$pagevalue['selectvalue'] = $selectvalue;
		$pagevalue['text'] = $text;
		$pagevalue['apartment'] = $apartment;
		$pagevalue['countrecord'] = $countrecord;
		$this->load->view('user_interface/retail',$pagevalue);
	} //функция выводит информацию на страницу продаж;
	
	function retail_extended(){
		
		$pagevalue = array(
			'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' => 'RealityGroup',
			'title' => 'Недвижимость на Тенерифе | Ипотека | Сопровождение сделки | Luminiza Property Tur S.L.',
			'baseurl' 		=> base_url(),
			'searchstatus'	=> FALSE,
			'searchback'	=> '',
			'backpath'		=> $this->session->userdata('backpage'),
			'admin' 		=> $this->admin['status'],
			'retail'		=> array(),
			'images'		=> array(),
			'text'			=> '',
			'msg'			=> $this->session->userdata('msg')
		);
		$this->session->unset_userdata('msg');
		$apart_id = $this->uri->segment(3);
		$retail = array();	$images = array();
		$status = $this->session->userdata('status');
//		$this->session->set_userdata('backpath',$this->uri->uri_string());
		$this->session->set_userdata('calc',TRUE);
		if(!empty($status)):
			$pagevalue['searchstatus'] = TRUE;
			$pagevalue['searchback'] = $this->session->userdata('searchback');
		endif;
		$apartament = $this->apartmentmodel->get_record($apart_id);
		$retail['id'] = $apartament['apnt_id'];
		$retail['title'] = $apartament['apnt_title'];
		$retail['extended'] = $apartament['apnt_extended'];
		if($this->input->post('submit')):
			$this->form_validation->set_rules('email','"E-Mail"','required|valid_email|trim');
			$this->form_validation->set_rules('name','"Ваше имя"','required|trim');
			$this->form_validation->set_rules('phone','"Контактный номер телефона"','required|trim');
			$this->form_validation->set_rules('max_budget','"Максимальный бюджет"','required|trim');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msg','Проверьте правильность заполеных полей');
				$_POST['submit'] = NULL;
				$this->retail_extended();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$_POST['msg'] 	 = 'Обект - "Недвижимость"'. "\n";
				$_POST['msg'] 	.= 'Название - '.$retail['title']."\n";
				$_POST['msg'] 	.= 'Идентификатор в таблице - '.$retail['id']."\n";
				$_POST['msg'] 	.= 'E-Mail клиента - '.$_POST['email']."\n";
				$_POST['msg'] 	.= 'Имя клиента - '.$_POST['name']."\n";
				$_POST['msg'] 	.= 'Контактный номер телефона - '.$_POST['phone']."\n";
				$_POST['msg'] 	.= 'Максимальный бюджет - '.$_POST['max_budget']."\n";
				$this->email->clear(TRUE);
				$config['smtp_host'] = 'localhost';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$this->email->initialize($config);
				$this->email->from($_POST['email'],$_POST['name']);
				$this->email->to('info@lum-tenerife.com');
				$this->email->bcc('');
				$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
				$textmail = strip_tags($_POST['msg']);
				$this->email->message($textmail);	
				if(!$this->email->send()):
					$this->session->set_userdata('msg','Сообщение не отправлено');
					redirect($this->uri->uri_string());
					return FALSE;
				endif;
				$this->session->set_userdata('msg','Сообщение отправлено');
				$_POST['extended'] = $_POST['msg'];
				$_POST['date'] = date("Y-m-d");
				$this->maillistmodel->insert_record($_POST);
				redirect($this->uri->uri_string());
			endif;
		endif;
		
		if(is_numeric($apartament['apnt_price'])):
			$retail['price'] = number_format($apartament['apnt_price'],0,' ','.');
		endif;
		if(is_numeric($apartament['apnt_newprice'])):
			$retail['newprice'] = number_format($apartament['apnt_newprice'],0,' ','.');
		endif;
		$image = $this->imagesmodel->get_type_ones_image('apartment',$retail['id']);
		if(isset($image) and !empty($image))
			$images = $this->imagesmodel->get_images_without('apartment',$retail['id'],$image['img_id']);
		$retail['img_id'] = $image['img_id'];
		$retail['img_title'] = $image['img_title'];
		$text['sidebar'] = $this->sidebartextmodel->get_record(5);
		$retail['object'] = 'apartment';
		$retail['date'] = $this->operation_date($apartament['apnt_date']);
		
		$retail['properties'] = array(
							'object' 	=> '<strong>Объект:</strong>&nbsp;&nbsp;'.$apartament['apnt_object'],
							'location' 	=> '<strong>Местонахождение:</strong>&nbsp;&nbsp;'.$apartament['apnt_location'],
							'region' 	=> '<strong>Район:</strong>&nbsp;&nbsp;'.$apartament['apnt_region'],
							'rooms' 	=> '<strong>Количество комнат:</strong>&nbsp;&nbsp;'.$apartament['apnt_count'],
							);
		$pagevalue['retail'] = $retail;
		$pagevalue['images'] = $images;
		$pagevalue['text'] = $text;
		$this->load->view('user_interface/retail_extended',$pagevalue);
	} //функция выводит полную информацию объекта продажи;
	
	function commercial(){
		
		if(isset($_POST['sortlink'])):
			$this->session->set_userdata('sortby',$_POST['sortvalue']);
		endif;
		$pagevalue = array(
			'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' 		=> 'RealityGroup',
			'title' 		=> 'Бизнес на Тенерифе | Коммерческая недвижимость | Ипотека в Испании | Luminiza Property Tur S.L.',
			'baseurl' 		=> base_url(),
			'admin' 		=> $this->admin['status'],
			'formsort' 		=> $this->uri->uri_string(),
			'softvalue' 	=> $this->session->userdata('sortby'),
			'selectvalue' 	=> array(),
			'apartment' 	=> array(),
			'text' 			=> array(),
			'countrecord' 	=> array(),
			'sname' 	=> $this->session->userdata('sname')
		);
		if(!$pagevalue['softvalue']) $pagevalue['softvalue'] = 0;
		$this->session->set_userdata('backpath',$this->uri->uri_string());
		$this->session->set_userdata('backpage',$this->uri->uri_string());
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$selectvalue = array();$apartment = array();$text = array();$countrecord = array();
		
		$selectvalue['object'] 		= $this->apartmentmodel->select_list('apnt_object');
		$selectvalue['location']	= $this->apartmentmodel->select_list('apnt_location');
		$selectvalue['region'] 		= $this->apartmentmodel->select_list('apnt_region');
		$selectvalue['count'] 		= $this->apartmentmodel->select_list('apnt_count');
		for($i=0;$i<count($selectvalue['count']);$i++):
			if(is_numeric($selectvalue['count'][$i]['apnt_count'])):
				$selectvalue['count'][$i]['apnt_count'] = intval($selectvalue['count'][$i]['apnt_count']);
			else:
				continue;
			endif;
		endfor;
		sort($selectvalue['count']);
		$countrecord['object'] 		= count($selectvalue['object']);
		$countrecord['location'] 	= count($selectvalue['location']);
		$countrecord['region'] 		= count($selectvalue['region']);
		$countrecord['count'] 		= count($selectvalue['count']);
		
		$text['sidebar'] = $this->sidebartextmodel->get_record(10);
		$text['head'] = $this->othertextmodel->get_record(19);
		
		$cntrec = $this->apartmentmodel->count_commercial_flag(5);

		$cfgpag['base_url'] = base_url().'/commercial';
        $cfgpag['total_rows'] = $cntrec;
        $cfgpag['per_page'] =  10;
        $cfgpag['num_links'] = 4;
        $cfgpag['uri_segment'] = 2;
		$cfgpag['first_link'] = FALSE;
		$cfgpag['first_tag_open'] = '<li>';
		$cfgpag['first_tag_close'] = '</li>';
		$cfgpag['last_link'] = FALSE;
		$cfgpag['last_tag_open'] = '<li>';
		$cfgpag['last_tag_close'] = '</li>';
		$cfgpag['next_link'] = 'Далее &raquo;';
		$cfgpag['next_tag_open'] = '<li>';
		$cfgpag['next_tag_close'] = '</li>';
		$cfgpag['prev_link'] = '&laquo; Назад';
		$cfgpag['prev_tag_open'] = '<li>';
		$cfgpag['prev_tag_close'] = '</li>';
		$cfgpag['cur_tag_open'] = '<li><a class="active" href="#">';
		$cfgpag['cur_tag_close'] = '</a></li>';
		$cfgpag['num_tag_open'] = '<li>';
		$cfgpag['num_tag_close'] = '</li>';			
		
		$from = intval($this->uri->segment(2));
		$sortby = $this->session->userdata('sortby');			
		$apartment = $this->apartmentmodel->get_limit_commercial(10,$from,5,$sortby);
		for($i = 0; $i < count($apartment); $i++):		
			if(mb_strlen($apartment[$i]['apnt_extended'],'UTF-8') > 325):									
				$apartment[$i]['apnt_extended'] = mb_substr($apartment[$i]['apnt_extended'],0,325,'UTF-8');	
				$pos = mb_strrpos($apartment[$i]['apnt_extended'],' ',0,'UTF-8');
				$apartment[$i]['apnt_extended'] = mb_substr($apartment[$i]['apnt_extended'],0,$pos,'UTF-8');
				$apartment[$i]['apnt_extended'] .= ' ...';
			endif;
			if(is_numeric($apartment[$i]['apnt_price'])):
				$apartment[$i]['apnt_price'] = number_format($apartment[$i]['apnt_price'],0,' ','.');
			endif;
			if(is_numeric($apartment[$i]['apnt_newprice'])):
				$apartment[$i]['apnt_newprice'] = number_format($apartment[$i]['apnt_newprice'],0,' ','.');
			endif;
		endfor;

		if(isset($from) and ! empty($from)) $this->session->set_userdata('backpage','commercial/'.$from);
		for($i = 0; $i < count($apartment); $i++):
			$image[$i] = $this->imagesmodel->get_type_ones_image('commercial',$apartment[$i]['apnt_id']);
			$apartment[$i]['img_id'] = $image[$i]['img_id'];
			$apartment[$i]['img_title'] = $image[$i]['img_title'];
			if(empty($apartment[$i]['img_title'])) $apartment[$i]['img_title'] = $apartment[$i]['apnt_title'];
		endfor;
		
		$this->pagination->initialize($cfgpag);
		$text['pager'] = $this->pagination->create_links();
		$pagevalue['selectvalue'] = $selectvalue;
		$pagevalue['text'] = $text;
		$pagevalue['apartment'] = $apartment;
		$pagevalue['countrecord'] = $countrecord;

		$this->load->view('user_interface/commercial',$pagevalue);
	} //функция выводит информацию о коммерческой недвижимости;
	
	function commercial_extended(){
		
		$pagevalue = array(
			'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' => 'RealityGroup',
			'title' => 'Недвижимость на Тенерифе | Ипотека | Сопровождение сделки | Luminiza Property Tur S.L.',
			'baseurl' 		=> base_url(),
			'searchstatus'	=> FALSE,
			'searchback'	=> '',
			'backpath'		=> $this->session->userdata('backpage'),
			'admin' 		=> $this->admin['status'],
			'retail'		=> array(),
			'images'		=> array(),
			'text'			=> '',
			'msg'			=> $this->session->userdata('msg')
		);
		$this->session->unset_userdata('msg');
		$apart_id = $this->uri->segment(4);
		$retail = array();$images = array();
		$status = $this->session->userdata('status');
		$this->session->set_userdata('calc',TRUE);
		if(!empty($status)):
			$pagevalue['searchstatus'] = TRUE;
			$pagevalue['searchback'] = $this->session->userdata('searchback');
		endif;
//		$this->session->set_userdata('backpath',$this->uri->uri_string());		
		$apartament = $this->apartmentmodel->get_record($apart_id);
		$retail['id'] = $apartament['apnt_id'];
		$retail['title'] = $apartament['apnt_title'];
		$retail['extended'] = $apartament['apnt_extended'];
		
		if($this->input->post('submit')):
			$this->form_validation->set_rules('email','"E-Mail"','required|valid_email|trim');
			$this->form_validation->set_rules('name','"Ваше имя"','required|trim');
			$this->form_validation->set_rules('phone','"Контактный номер телефона"','required|trim');
			$this->form_validation->set_rules('max_budget','"Максимальный бюджет"','required|trim');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msg','Проверьте правильность заполеных полей');
				$_POST['submit'] = NULL;
				$this->commercial_extended();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$_POST['msg'] 	 = 'Обект - "Недвижимость"'. "\n";
				$_POST['msg'] 	.= 'Название - '.$retail['title']."\n";
				$_POST['msg'] 	.= 'Идентификатор в таблице - '.$retail['id']."\n";
				$_POST['msg'] 	.= 'E-Mail клиента - '.$_POST['email']."\n";
				$_POST['msg'] 	.= 'Имя клиента - '.$_POST['name']."\n";
				$_POST['msg'] 	.= 'Контактный номер телефона - '.$_POST['phone']."\n";
				$_POST['msg'] 	.= 'Максимальный бюджет - '.$_POST['max_budget']."\n";
				$this->email->clear(TRUE);
				$config['smtp_host'] = 'localhost';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$this->email->initialize($config);
				$this->email->from($_POST['email'],$_POST['name']);
				$this->email->to('info@lum-tenerife.com');
				$this->email->bcc('');
				$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
				$textmail = strip_tags($_POST['msg']);
				$this->email->message($textmail);	
				if(!$this->email->send()):
					$this->session->set_userdata('msg','Сообщение не отправлено');
					redirect($this->uri->uri_string());
					return FALSE;
				endif;
				$this->session->set_userdata('msg','Сообщение отправлено');
				$_POST['extended'] = $_POST['msg'];
				$_POST['date'] = date("Y-m-d");
				$this->maillistmodel->insert_record($_POST);
				redirect($this->uri->uri_string());
			endif;
		endif;
		
		if(is_numeric($apartament['apnt_price'])):
			$retail['price'] = number_format($apartament['apnt_price'],0,' ','.');
		endif;
		if(is_numeric($apartament['apnt_newprice'])):
			$retail['newprice'] = number_format($apartament['apnt_newprice'],0,' ','.');
		endif;
		$image = $this->imagesmodel->get_type_ones_image('commercial',$retail['id']);
		if(isset($image) and !empty($image))
			$images = $this->imagesmodel->get_images_without('commercial',$retail['id'],$image['img_id']);
		$retail['img_id'] = $image['img_id'];
		$retail['img_title'] = $image['img_title'];
		$text['sidebar'] = $this->sidebartextmodel->get_record(5);
		$retail['type'] = 'commercial';
		$retail['date'] = $this->operation_date($apartament['apnt_date']);
		
		$retail['properties'] = array(
							'object' 	=> '<strong>Объект:</strong>&nbsp;&nbsp;'.$apartament['apnt_object'],
							'location' 	=> '<strong>Местонахождение:</strong>&nbsp;&nbsp;'.$apartament['apnt_location'],
							'region' 	=> '<strong>Район:</strong>&nbsp;&nbsp;'.$apartament['apnt_region'],
							'rooms' 	=> '<strong>Количество комнат:</strong>&nbsp;&nbsp;'.$apartament['apnt_count'],
							);
		$pagevalue['retail'] = $retail;
		$pagevalue['images'] = $images;
		$pagevalue['text'] = $text;
		$this->load->view('user_interface/commercial_extended',$pagevalue);
	} //функция выводит полную информацию rоммерческой недвижимости продажи;
	
	function rent(){
		
		$pagevalue = array(
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' => 'RealityGroup',
			'baseurl' => base_url(),
			'page'	=> $this->uri->segment(2),
			'admin' => $this->admin['status'],
			'text'	=> array(),
			'rentlist'	=> array(),
			
		);
		if($this->uri->segment(2) == 'auto'):
			$pagevalue['title'] = 'Аренда автомобилей на Тенерифе | Luminiza Property Tur S.L.';
			$pagevalue['description'] = 'Аренда автомобилей от семейных минивэнов до престижных моделей представительского класса или стильных спорткаров. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.';  
		else:
			$pagevalue['title'] = 'Недвижимость на Тенерифе | Аренда апартаментов и вилл | Ипотека в Испании | Luminiza Property Tur S.L.';
			$pagevalue['description'] = 'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.'; 
		endif;
		
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$text = array(); $rentlist = array();
		
		$text[0]['sidebar'] = $this->sidebartextmodel->get_record(4);	// раздел авто;
		$text[0]['head'] = $this->othertextmodel->get_record(2);
		$text[1]['sidebar'] = $this->sidebartextmodel->get_record(5);	// раздел апартаменты;
		$text[1]['head'] = $this->othertextmodel->get_record(3);
		$rentlist['auto'] = $this->rentautomodel->get_records();
		for($i = 0; $i < count($rentlist['auto']); $i++):
			$image[$i] = $this->imagesmodel->get_type_ones_image('auto',$rentlist['auto'][$i]['rnta_id']);
			$rentlist['auto'][$i]['img_id'] = $image[$i]['img_id'];
			$rentlist['auto'][$i]['img_title'] = $image[$i]['img_title'];
			if(empty($rentlist['auto'][$i]['img_title']))
				$rentlist['auto'][$i]['img_title'] = $rentlist['auto'][$i]['rnta_title'];
		endfor;
		$cntrec = $this->apartmentmodel->count_records_flag(1);
		$cfgpag['base_url'] = base_url().'/rent/retail';
        $cfgpag['total_rows'] = $cntrec;
        $cfgpag['per_page'] =  10;
        $cfgpag['num_links'] = 4;
        $cfgpag['uri_segment'] = 3;
		$cfgpag['first_link'] = FALSE;
		$cfgpag['first_tag_open'] = '<li>';
		$cfgpag['first_tag_close'] = '</li>';
		$cfgpag['last_link'] = FALSE;
		$cfgpag['last_tag_open'] = '<li>';
		$cfgpag['last_tag_close'] = '</li>';
		$cfgpag['next_link'] = 'Далее &raquo;';
		$cfgpag['next_tag_open'] = '<li>';
		$cfgpag['next_tag_close'] = '</li>';
		$cfgpag['prev_link'] = '&laquo; Назад';
		$cfgpag['prev_tag_open'] = '<li>';
		$cfgpag['prev_tag_close'] = '</li>';
		$cfgpag['cur_tag_open'] = '<li><a class="active" href="#">';
		$cfgpag['cur_tag_close'] = '</a></li>';
		$cfgpag['num_tag_open'] = '<li>';
		$cfgpag['num_tag_close'] = '</li>';			
		
		$from = intval($this->uri->segment(3));	
		$rentlist['apartment'] = $this->apartmentmodel->get_limit_records(10,$from,1,0);
		
		for($i = 0; $i < count($rentlist['apartment']); $i++):		
			if (mb_strlen($rentlist['apartment'][$i]['apnt_extended'],'UTF-8') > 325):
				$tmp = $rentlist['apartment'][$i]['apnt_extended'];			
				$tmp = mb_substr($tmp,0,325,'UTF-8');	
				$pos = mb_strrpos($tmp,' ',0,'UTF-8');
				$tmp = mb_substr($tmp,0,$pos,'UTF-8');
				$rentlist['apartment'][$i]['apnt_extended'] = $tmp.' ...';
			endif;
		endfor;		
		for($i = 0; $i < count($rentlist['apartment']); $i++):
			$image[$i]=$this->imagesmodel->get_type_ones_image('apartment',$rentlist['apartment'][$i]['apnt_id']);
			$rentlist['apartment'][$i]['img_id'] = $image[$i]['img_id'];
			$rentlist['apartment'][$i]['img_title'] = $image[$i]['img_title'];
			if(empty($rentlist['apartment'][$i]['img_title']))
				$rentlist['apartment'][$i]['img_title'] = $rentlist['apartment'][$i]['apnt_title'];
		endfor;		
		$this->pagination->initialize($cfgpag);
		$pageslinks = $this->pagination->create_links();
		
		$pagevalue['rentlist'] = $rentlist;
		$pagevalue['pageslinks'] = $pageslinks;
		$pagevalue['text'] = $text;
		$this->session->set_userdata('backpath',$this->uri->uri_string());
		$this->session->set_userdata('backpage',$this->uri->uri_string());
		$this->load->view('user_interface/rent',$pagevalue);
	} //функция выводит информацию на страницу аренды;
	
	function rent_extended(){
		
		$rent_type = $this->uri->segment(2);
		$rent_id = $this->uri->segment(3);
		
		$pagevalue = array(
			'keywords' 		=> 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' 		=> 'RealityGroup',
			'baseurl' 		=> base_url(),
			'id'			=> $rent_id,
			'type'			=> $rent_type,
			'searchstatus'	=> FALSE,
			'searchback'	=> '',
			'backpath'		=> $this->session->userdata('backpage'),
			'admin' 		=> $this->admin['status'],
			'rent'			=> array(),
			'images'		=> array(),
			'text'			=> array(),
			'msg'			=> $this->session->userdata('msg')
		);
		$this->session->unset_userdata('msg');
		if($rent_type == 'auto'):
			$pagevalue['title'] = 'Аренда автомобилей на Тенерифе | Luminiza Property Tur S.L.';
			$pagevalue['description'] = 'Аренда автомобилей от семейных минивэнов до престижных моделей представительского класса или стильных спорткаров. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.';  
		else:
			$pagevalue['title'] = 'Аренда апартаментов и вилл | Недвижимость на Тенерифе | Luminiza Property Tur S.L.';
			$pagevalue['description'] = 'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.'; 
		endif;
		
		$rent = array(); $images = array();
		$status = $this->session->userdata('status');
		if(!empty($status)):
			$pagevalue['searchstatus'] = TRUE;
			$pagevalue['searchback'] = $this->session->userdata('searchback');
			
		endif;
//		$this->session->set_userdata('backpath',$this->uri->uri_string());
		switch($rent_type):
			case 'auto':{
						$auto = $this->rentautomodel->get_record($rent_id);
						$rent['id'] = $auto['rnta_id'];
						$rent['title'] = $auto['rnta_title'];
						$rent['extended'] = $auto['rnta_extended'];
						$rent['properties'] = $auto['rnta_properties'];
						$rent['price'] = $auto['rnta_price'];
						$image = $this->imagesmodel->get_type_ones_image('auto',$rent['id']);
						if(isset($image) and !empty($image))
							$images = $this->imagesmodel->get_images_without('auto',$rent['id'],$image['img_id']);
						$rent['img_id'] = $image['img_id'];
						$rent['img_title'] = $image['img_title'];
						$text['sidebar'] = $this->sidebartextmodel->get_record(4);						
						$rent['object'] = 'auto';
						}; break;
			case 'apartment':{
						$apartament = $this->apartmentmodel->get_record($rent_id);
						$rent['id'] = $apartament['apnt_id'];
						$rent['title'] = $apartament['apnt_title'];
						$rent['extended'] = $apartament['apnt_extended'];
						$rent['properties'] = $apartament['apnt_properties'];
						$rent['price'] = $apartament['apnt_price_rent'];
						$image = $this->imagesmodel->get_type_ones_image('apartment',$rent['id']);
						if(isset($image) and !empty($image))
							$images = $this->imagesmodel->get_images_without('apartment',$rent['id'],$image['img_id']);
						$rent['img_id'] = $image['img_id'];
						$rent['img_title'] = $image['img_title'];
						$text['sidebar'] = $this->sidebartextmodel->get_record(5);
						$rent['object'] = 'apartment';
						}; break;
		endswitch;
		if($this->uri->segment(2) == 'apartment'):
			if($this->input->post('sapartment')):
				$this->form_validation->set_rules('email','"E-Mail"','required|valid_email|trim');
				$this->form_validation->set_rules('name','"Ваше имя и фамилия"','required|trim');
				$this->form_validation->set_rules('phone','"Контактный номер телефона"','required|trim');
				$this->form_validation->set_rules('max_budget','"Максимальный бюджет"','required|trim');
				$this->form_validation->set_rules('number_people','"Количество людей"','required|trim');
				$this->form_validation->set_rules('number_children','"Количество детей"','required|trim');
				$this->form_validation->set_rules('rdate','"Дата начала аренды"','required|trim');
				$this->form_validation->set_rules('bcdate','"Дата возвращения"','required');
				$this->form_validation->set_error_delimiters('<div class="message">','</div>');
				if(!$this->form_validation->run()):
					$this->session->set_userdata('msg','Проверьте правильность заполеных полей');
					$_POST['submit'] = NULL;
					$this->rent_extended();
					return FALSE;
				else:
					$_POST['submit'] = NULL;
					$_POST['msg'] 	 = 'Обект - " Аренда недвижимости"'. "\n";
					$_POST['msg'] 	.= 'Название - '.$rent['title']."\n";
					$_POST['msg'] 	.= 'Идентификатор в таблице - '.$rent['id']."\n";
					$_POST['msg'] 	.= 'E-Mail клиента - '.$_POST['email']."\n";
					$_POST['msg'] 	.= 'Имя клиента - '.$_POST['name']."\n";
					$_POST['msg'] 	.= 'Контактный номер телефона - '.$_POST['phone']."\n";
					$_POST['msg'] 	.= 'Максимальный бюджет - '.$_POST['max_budget']."\n";
					$_POST['msg'] 	.= 'Количество людей - '.$_POST['number_people']."\n";
					$_POST['msg'] 	.= 'Количество детей - '.$_POST['number_children']."\n";
					$_POST['msg'] 	.= 'Дата начала аренды - '.$_POST['rdate']."\n";
					$_POST['msg'] 	.= 'Дата возвращения - '.$_POST['bcdate']."\n";
					$this->email->clear(TRUE);
					$config['smtp_host'] = 'localhost';
					$config['charset'] = 'utf-8';
					$config['wordwrap'] = TRUE;
					$this->email->initialize($config);
					$this->email->from($_POST['email'],$_POST['name']);
					$this->email->to('info@lum-tenerife.com');
					$this->email->bcc('');
					$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
					$textmail = strip_tags($_POST['msg']);
					$this->email->message($textmail);	
					if(!$this->email->send()):
						$this->session->set_userdata('msg','Сообщение не отправлено');
						redirect($this->uri->uri_string());
						return FALSE;
					endif;
					$this->session->set_userdata('msg','Сообщение отправлено');
					$_POST['extended'] = $_POST['msg'];
					$_POST['date'] = date("Y-m-d");
					$this->maillistmodel->insert_record($_POST);
					redirect($this->uri->uri_string());
				endif;
			endif;
		else:
			if($this->input->post('sauto')):
				$this->form_validation->set_rules('email','"E-Mail"','required|valid_email|trim');
				$this->form_validation->set_rules('name','"Ваше имя и фамилия"','required|trim');
				$this->form_validation->set_rules('phone','"Контактный номер телефона"','required|trim');
				$this->form_validation->set_rules('max_budget','"Максимальный бюджет"','required|trim');
				$this->form_validation->set_rules('number_people','"Количество людей"','required|trim');
				$this->form_validation->set_rules('number_children','"Количество детей"','required|trim');
				$this->form_validation->set_rules('permit','"Номер водительских прав"','required|trim');
				$this->form_validation->set_rules('pdate','"Дата получения"','required|trim');
				$this->form_validation->set_rules('country','"Страна получения"','required|trim');
				$this->form_validation->set_rules('car','"Модель автомобиля"','required|trim');
				$this->form_validation->set_rules('rdate','"Дата начала аренды"','required|trim');
				$this->form_validation->set_rules('bcdate','"Дата возвращения"','required');
				$this->form_validation->set_error_delimiters('<div class="message">','</div>');
				if(!$this->form_validation->run()):
					$this->session->set_userdata('msg','Проверьте правильность заполеных полей');
					$_POST['submit'] = NULL;
					$this->rent_extended();
					return FALSE;
				else:
					$_POST['submit'] = NULL;
					$_POST['msg'] 	 = 'Обект - "Аренда авто"'. "\n";
					$_POST['msg'] 	.= 'Название - '.$rent['title']."\n";
					$_POST['msg'] 	.= 'Идентификатор в таблице - '.$rent['id']."\n";
					$_POST['msg'] 	.= 'E-Mail клиента - '.$_POST['email']."\n";
					$_POST['msg'] 	.= 'Имя клиента - '.$_POST['name']."\n";
					$_POST['msg'] 	.= 'Контактный номер телефона - '.$_POST['phone']."\n";
					$_POST['msg'] 	.= 'Максимальный бюджет - '.$_POST['max_budget']."\n";
					$_POST['msg'] 	.= 'Количество людей - '.$_POST['number_people']."\n";
					$_POST['msg'] 	.= 'Количество детей - '.$_POST['number_children']."\n";
					$_POST['msg'] 	.= 'Номер водительских прав - '.$_POST['permit']."\n";
					$_POST['msg'] 	.= 'Дата получения - '.$_POST['pdate']."\n";
					$_POST['msg'] 	.= 'Страна получения - '.$_POST['country']."\n";
					$_POST['msg'] 	.= 'Модель автомобиля - '.$_POST['car']."\n";
					$_POST['msg'] 	.= 'Дата начала аренды - '.$_POST['rdate']."\n";
					$_POST['msg'] 	.= 'Дата возвращения - '.$_POST['bcdate']."\n";
					if(isset($_POST['place'])):
						$sub = array('','к аэропорту','к отелю');
						$_POST['msg'] 	.= 'Подать авто - '.$sub[$_POST['place']];
					else:
						$_POST['msg'] 	.= 'Пользователь не уточнил куда подать авто';
					endif;
					$this->email->clear(TRUE);
					$config['smtp_host'] = 'localhost';
					$config['charset'] = 'utf-8';
					$config['wordwrap'] = TRUE;
					$this->email->initialize($config);
					$this->email->from($_POST['email'],$_POST['name']);
					$this->email->to('info@lum-tenerife.com');
					$this->email->bcc('');
					$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
					$textmail = strip_tags($_POST['msg']);
					$this->email->message($textmail);	
					if(!$this->email->send()):
						$this->session->set_userdata('msg','Сообщение не отправлено');
						redirect($this->uri->uri_string());
						return FALSE;
					endif;
					$this->session->set_userdata('msg','Сообщение отправлено');
					$_POST['extended'] = $_POST['msg'];
					$_POST['date'] = date("Y-m-d");
					$this->maillistmodel->insert_record($_POST);
					redirect($this->uri->uri_string());
				endif;
			endif;
		endif;
		$pagevalue['rent'] = $rent;
		$pagevalue['images'] = $images;
		$pagevalue['text'] = $text;
		$this->load->view('user_interface/rent_extended',$pagevalue);
	} //функция выводит полную информацию объекта аренды;

	function rent_commercial(){
		
		$pagevalue = array(
			'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' 		=> 'RealityGroup',
			'title' 		=> 'Бизнес на Тенерифе | Аренда коммерческой недвижимости | Сопровождение сделки | Luminiza Property Tur S.L.',
			'baseurl' 		=> base_url(),
			'admin' 		=> $this->admin['status'],
			'text'			=> array(),
			'commercial'	=> array(),
			'pageslinks'	=> array(),
			
		);
		$this->session->set_userdata('backpath',$this->uri->uri_string());
		$this->session->set_userdata('backpage',$this->uri->uri_string());
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$text = array(); $commercial = array();
		$text[1]['sidebar'] = $this->sidebartextmodel->get_record(11);	// раздел апартаменты;
		$text[1]['head'] = $this->othertextmodel->get_record(20);

		$cntrec = $this->apartmentmodel->count_commercial_flag(4);

		$cfgpag['base_url'] = base_url().'/rent/commercial';
        $cfgpag['total_rows'] = $cntrec;
        $cfgpag['per_page'] =  10;
        $cfgpag['num_links'] = 4;
        $cfgpag['uri_segment'] = 3;
		$cfgpag['first_link'] = FALSE;
		$cfgpag['first_tag_open'] = '<li>';
		$cfgpag['first_tag_close'] = '</li>';
		$cfgpag['last_link'] = FALSE;
		$cfgpag['last_tag_open'] = '<li>';
		$cfgpag['last_tag_close'] = '</li>';
		$cfgpag['next_link'] = 'Далее &raquo;';
		$cfgpag['next_tag_open'] = '<li>';
		$cfgpag['next_tag_close'] = '</li>';
		$cfgpag['prev_link'] = '&laquo; Назад';
		$cfgpag['prev_tag_open'] = '<li>';
		$cfgpag['prev_tag_close'] = '</li>';
		$cfgpag['cur_tag_open'] = '<li><a class="active" href="#">';
		$cfgpag['cur_tag_close'] = '</a></li>';
		$cfgpag['num_tag_open'] = '<li>';
		$cfgpag['num_tag_close'] = '</li>';			
		
		$from = intval($this->uri->segment(3));			
		$commercial = $this->apartmentmodel->get_limit_commercial(10,$from,4,0);
		
		for($i = 0; $i < count($commercial); $i++):		
			if (mb_strlen($commercial[$i]['apnt_extended'],'UTF-8') > 325):
				$tmp = $commercial[$i]['apnt_extended'];			
				$tmp = mb_substr($tmp,0,325,'UTF-8');	
				$pos = mb_strrpos($tmp,' ',0,'UTF-8');
				$tmp = mb_substr($tmp,0,$pos,'UTF-8');
				$commercial[$i]['apnt_extended'] = $tmp.' ...';
			endif;
		endfor;		
		
		if(isset($from) and ! empty($from)) $this->session->set_userdata('backpage','rent/commercial/'.$from);
		for($i = 0; $i < count($commercial); $i++):
			$image[$i]=$this->imagesmodel->get_type_ones_image('commercial',$commercial[$i]['apnt_id']);
			$commercial[$i]['img_id'] = $image[$i]['img_id'];
			$commercial[$i]['img_title'] = $image[$i]['img_title'];
			if(empty($commercial[$i]['img_title']))
				$commercial[$i]['img_title'] = $commercial[$i]['apnt_title'];
		endfor;		
		$this->pagination->initialize($cfgpag);
		$pageslinks = $this->pagination->create_links();
		
		$pagevalue['commercial'] = $commercial;
		$pagevalue['pageslinks'] = $pageslinks;
		$pagevalue['text'] = $text;
		$this->load->view('user_interface/rent_commercial',$pagevalue);
	} //функция выводит информацию об аренде коммерческой недвижимости;
	
	function rent_commercial_extended(){
		
		$msg = $this->setmessage('','','',0);
		$rent_id = $this->uri->segment(4);
		
		$pagevalue = array(
			'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' => 'RealityGroup',
			'title' => 'Аренда бизнеса | Коммерческая недвижимость на Тенерифе | Luminiza Property Tur S.L.',
			'baseurl' 		=> base_url(),
			'id'			=> $rent_id,
			'searchstatus'	=> FALSE,
			'searchback'	=> '',
			'admin' 		=> $this->admin['status'],
			'backpath'		=> $this->session->userdata('backpage'),
			'rent' 			=> array(),
			'images' 		=> array(),
			'text' 			=> array(),
			'msg'			=> $this->session->userdata('msg')
		);
		$this->session->unset_userdata('msg');
		$rent = array();$images = array();
		$status = $this->session->userdata('status');
		$text = array();
		if(!empty($status)):
			$pagevalue['searchstatus'] = TRUE;
			$pagevalue['searchback'] = $this->session->userdata('searchback');
		endif;
//		$this->session->set_userdata('backpath',$this->uri->uri_string());
		$apartament = $this->apartmentmodel->get_record($rent_id);
		$rent['id'] = $apartament['apnt_id'];
		$rent['title'] = $apartament['apnt_title'];
		$rent['extended'] = $apartament['apnt_extended'];
		$rent['properties'] = $apartament['apnt_properties'];
		$rent['price'] = $apartament['apnt_price_rent'];
		
		if($this->input->post('submit')):
			$this->form_validation->set_rules('email','"E-Mail"','required|valid_email|trim');
			$this->form_validation->set_rules('name','"Ваше имя"','required|trim');
			$this->form_validation->set_rules('phone','"Контактный номер телефона"','required|trim');
			$this->form_validation->set_rules('max_budget','"Максимальный бюджет"','required|trim');
			$this->form_validation->set_rules('number_people','"Количество людей"','required|trim');
			$this->form_validation->set_rules('number_children','"Количество детей"','required|trim');
			$this->form_validation->set_rules('rdate','"Дата начала аренды"','required|trim');
			$this->form_validation->set_rules('bcdate','"Дата возвращения"','required');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msg','Проверьте правильность заполеных полей');
				$_POST['submit'] = NULL;
				$this->rent_commercial_extended();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$_POST['msg'] 	 = 'Обект - "Недвижимость"'. "\n";
				$_POST['msg'] 	.= 'Название - '.$rent['title']."\n";
				$_POST['msg'] 	.= 'Идентификатор в таблице - '.$rent['id']."\n";
				$_POST['msg'] 	.= 'E-Mail клиента - '.$_POST['email']."\n";
				$_POST['msg'] 	.= 'Имя клиента - '.$_POST['name']."\n";
				$_POST['msg'] 	.= 'Контактный номер телефона - '.$_POST['phone']."\n";
				$_POST['msg'] 	.= 'Максимальный бюджет - '.$_POST['max_budget']."\n";
				$_POST['msg'] 	.= 'Количество людей - '.$_POST['number_people']."\n";
				$_POST['msg'] 	.= 'Количество детей - '.$_POST['number_children']."\n";
				$_POST['msg'] 	.= 'Дата начала аренды - '.$_POST['rdate']."\n";
				$_POST['msg'] 	.= 'Дата возвращения - '.$_POST['bcdate']."\n";
				$this->email->clear(TRUE);
				$config['smtp_host'] = 'localhost';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$this->email->initialize($config);
				$this->email->from($_POST['email'],$_POST['name']);
				$this->email->to('info@lum-tenerife.com');
				$this->email->bcc('');
				$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
				$textmail = strip_tags($_POST['msg']);
				$this->email->message($textmail);	
				if(!$this->email->send()):
					$this->session->set_userdata('msg','Сообщение не отправлено');
					redirect($this->uri->uri_string());
					return FALSE;
				endif;
				$this->session->set_userdata('msg','Сообщение отправлено');
				$_POST['extended'] = $_POST['msg'];
				$_POST['date'] = date("Y-m-d");
				$this->maillistmodel->insert_record($_POST);
				redirect($this->uri->uri_string());
			endif;
		endif;
		
		$image = $this->imagesmodel->get_type_ones_image('commercial',$rent['id']);
		if(isset($image) and !empty($image))
			$images = $this->imagesmodel->get_images_without('commercial',$rent['id'],$image['img_id']);
		$rent['img_id'] = $image['img_id'];
		$rent['img_title'] = $image['img_title'];
		$text['sidebar'] = $this->sidebartextmodel->get_record(5);
		$rent['type'] = 'commercial';
		$pagevalue['rent'] = $rent;
		$pagevalue['images'] = $images;
		$pagevalue['text'] = $text;
		$this->load->view('user_interface/rent_commercial_extended',$pagevalue);
	} //функция выводит полную информацию rоммерческой недвижимости аренда;
	
	function ipoteka(){
		
		$price = $this->uri->segment(2);
		$pagevalue = array(
			'description' =>'Воспользуйтесь нашим калькулятором для расчета ипотеки. Юридическое сопровождение сделок, оформление ипотеки. Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' => 'RealityGroup',
			'title' => 'Перечень документов для оформления ипотеки в Испании | Ипотечный калькулятор | Недвижимость на Тенерифе | Аренда апартаментов и вилл | Luminiza Property Tur S.L.',
			'price' 		=> '',
			'retailback'	=> '',
			'retailstatus'	=> FALSE,
			'baseurl' 		=> base_url(),
			'admin' 		=> $this->admin['status'],
			'text'			=>'',
			'price'			=> ''
		);
		if(isset($price) and !empty($price)):
			$pagevalue['price'] = $price;
			$status = $this->session->userdata('calc');
			if(!empty($status)):
				$pagevalue['retailstatus'] = TRUE;
				$pagevalue['retailback'] = $this->session->userdata('backpage');
			else:
				$this->session->unset_userdata('query');
				$this->session->unset_userdata('status');
				$this->session->unset_userdata('searchback');
			endif;
		endif;
		if(!isset($status)):
			$this->session->unset_userdata('query');
			$this->session->unset_userdata('status');
			$this->session->unset_userdata('searchback');
		endif;
		$text = array();
		$text['title'] 	= $this->othertextmodel->get_record(11);
		$text['fiz'] 	= $this->othertextmodel->get_record(12);
		$text['ur'] 	= $this->othertextmodel->get_record(13);
		
		$this->session->set_userdata('backpage','ipoteka');
		$pagevalue['text'] = $text;
		$pagevalue['price'] = $price;
		$this->load->view('user_interface/ipoteka',$pagevalue);
	}		//функция выводит информацию на страницу ипотеки;
	
	function tour(){
		
		$pagevalue = array(
			'description' =>'Организация индивидуальных экскурсий и туров на Тенерифе, Гран Канария, Ла Гомера. Обзорные экскурсии, вулкан Тейде, Лоро Парк. Недвижимость на Тенерифе. Индивидуальные трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, гран канария, индивидуальные экскурсии, лоро парк, вулкан тейде, ла гомера, недвижимость на тенерифе, лас америкас, luminiza',
			'author' => 'RealityGroup',
			'title' => 'Индивидуальные экскурсии | Тенерифе, Гран Канария, Ла Гомера | Вулкан Тейде, Лоро Парк | Luminiza Property Tur S.L.',
			'baseurl' => base_url(),
			'admin' => $this->admin['status'],
			'tour' => array(),
			'text' => array()
		);
		$this->session->set_userdata('backpath',$this->uri->uri_string());
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$tour = array();
		$text = array();
		$text['sidebar'] = $this->sidebartextmodel->get_record(6);
		$text['head'] = $this->othertextmodel->get_record(4);
		$tour = $this->tourlistmodel->get_records();
		
		for($i = 0; $i < count($tour); $i++):		
			if (mb_strlen($tour[$i]['tour_extended'],'UTF-8') > 325):
				$tmp = $tour[$i]['tour_extended'];			
				$tmp = mb_substr($tmp,0,325,'UTF-8');	
				$pos = mb_strrpos($tmp,' ',0,'UTF-8');
				$tmp = mb_substr($tmp,0,$pos,'UTF-8');
				$tour[$i]['tour_extended'] = $tmp.' ...';
			endif;
		endfor;	
		
		for($i = 0; $i < count($tour); $i++):
			$image[$i] = $this->imagesmodel->get_type_ones_image('tour',$tour[$i]['tour_id']);
			$tour[$i]['img_id'] = $image[$i]['img_id'];
			$tour[$i]['img_title'] = $image[$i]['img_title'];
			if(empty($tour[$i]['img_title'])) $tour[$i]['img_title'] = $tour[$i]['tour_id'];
		endfor;
		$pagevalue['text'] = $text;
		$pagevalue['tour'] = $tour;
		$this->load->view('user_interface/tour',$pagevalue);
	} //функция выводит информацию на страницу экскурсий;
	
	function tour_extended(){
		
		$pagevalue = array(
				'description' 	=>'Организация индивидуальных экскурсий и туров на Тенерифе, Гран Канария, Ла Гомера. Обзорные экскурсии, вулкан Тейде, Лоро Парк. Недвижимость на Тенерифе. Индивидуальные трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
				'keywords' 		=> 'тенерифе, гран канария, индивидуальные экскурсии, лоро парк, вулкан тейде, ла гомера, недвижимость на тенерифе, лас америкас, luminiza',
				'author' 		=> 'RealityGroup',
				'title' 		=> 'Индивидуальные экскурсии | Luminiza Property Tur S.L.',
				'baseurl' 		=> base_url(),
				'admin' 		=> $this->admin['status'],
				'tour' 			=> array(),
				'text' 			=> array(),
				'images'		=> array(),
				'msg'			=> $this->session->userdata('msg')
			);
//		$this->session->set_userdata('backpath',$this->uri->uri_string());
		$this->session->unset_userdata('msg');
		$tour_id = $this->uri->segment(3);
		$tour = array();$text = array();$images = array();
		$text['sidebar'] = $this->sidebartextmodel->get_record(6);
		$tour = $this->tourlistmodel->get_record($tour_id);
		$image = $this->imagesmodel->get_type_ones_image('tour',$tour_id);
		if(isset($image) and !empty($image)):
			$images = $this->imagesmodel->get_images_without('tour',$tour_id,$image['img_id']);
		endif;
		$tour['img_id'] = $image['img_id'];
		$tour['img_title'] = $image['img_title'];
		$pagevalue['text'] = $text;
		$pagevalue['tour'] = $tour;
		$pagevalue['images'] = $images;
		if($this->input->post('submit')):
			$this->form_validation->set_rules('email','"E-Mail"','required|valid_email|trim');
			$this->form_validation->set_rules('name','"Ваше имя"','required|trim');
			$this->form_validation->set_rules('phone','"Контактный номер телефона"','required|trim');
			$this->form_validation->set_rules('date','"Дата экскурсии"','required|trim');
			$this->form_validation->set_rules('number_people','"Количество людей"','required|trim');
			$this->form_validation->set_rules('number_children','"Количество детей"','required|trim');
			$this->form_validation->set_rules('note','"Примечания"','required|trim');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msg','Проверьте правильность заполеных полей');
				$_POST['submit'] = NULL;
				$this->tour_extended();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$_POST['msg'] 	 = 'Обект - "Экскурсия"'. "\n";
				$_POST['msg'] 	.= 'Название - '.$pagevalue['tour']['tour_title']."\n";
				$_POST['msg'] 	.= 'Идентификатор в таблице - '.$pagevalue['tour']['tour_id']."\n";
				$_POST['msg'] 	.= 'E-Mail клиента - '.$_POST['email']."\n";
				$_POST['msg'] 	.= 'Имя клиента - '.$_POST['name']."\n";
				$_POST['msg'] 	.= 'Контактный номер телефона - '.$_POST['phone']."\n";
				$_POST['msg'] 	.= 'Количество людей - '.$_POST['number_people']."\n";
				$_POST['msg'] 	.= 'Количество детей - '.$_POST['number_children']."\n";
				$_POST['msg'] 	.= 'Дата экскурсии - '.$_POST['date']."\n";
				$_POST['msg'] 	.= "Примечания:\n".$_POST['note']."\n";
				$this->email->clear(TRUE);
				$config['smtp_host'] = 'localhost';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$this->email->initialize($config);
				$this->email->from($_POST['email'],$_POST['name']);
				$this->email->to('info@lum-tenerife.com');
				$this->email->bcc('');
				$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
				$textmail = strip_tags($_POST['msg']);
				$this->email->message($textmail);	
				if(!$this->email->send()):
					$this->session->set_userdata('msg','Сообщение не отправлено');
					redirect($this->uri->uri_string());
					return FALSE;
				endif;
				$this->session->set_userdata('msg','Сообщение отправлено');
				$_POST['extended'] = $_POST['msg'];
				$_POST['date'] = date("Y-m-d");
				$this->maillistmodel->insert_record($_POST);
				redirect($this->uri->uri_string());
			endif;
		endif;
		
		$this->load->view('user_interface/tour_extended',$pagevalue);
	} //функция выводит подробную информацию об экскурсии;	
	
	function service(){
	
		$msg = $this->setmessage('','','',0);		
		$pagevalue = array(
			'description' =>'Быстрый и качественный официальный перевод документов на испанский, английский и русский языки. Организация свадеб, вечеринок и детских праздников. Полный комплекс SPA услуг. Недвижимость на Тенерифе. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, канарские острова, перевод документов, организация свадеб, spa услуги, недвижимость на тенерифе, лас америкас, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' => 'RealityGroup',
			'title' 	=> 'Перевод документов | Организация свадеб | SPA услуги | Свадебные путешествия | Luminiza Property Tur S.L.',
			'baseurl' 	=> base_url(),
			'admin'		=> $this->admin['status'],
			'service' 	=> array(),
			'text' 		=> array(),
			'msg'		=> $this->session->userdata('msg')
		);
		$this->session->unset_userdata('msg');
		$this->session->set_userdata('backpath',$this->uri->uri_string());
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$service = array();	$text = array();
		
		if($this->input->post('submit')):
			$this->form_validation->set_rules('email','"E-Mail"','required|valid_email|trim');
			$this->form_validation->set_rules('name','"Ваше имя и фамилия"','required|trim');
			$this->form_validation->set_rules('phone','"Контактный номер телефона"','required|trim');
			$this->form_validation->set_rules('date','"Дата прилета"','required|trim');
			$this->form_validation->set_rules('note','"Сообщение"','required|trim');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->session->set_userdata('msg','Проверьте правильность заполеных полей');
				$this->service();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$_POST['msg'] 	 = 'Обект - "Услуги"'. "\n";
				$_POST['msg'] 	.= 'E-Mail клиента - '.$_POST['email']."\n";
				$_POST['msg'] 	.= 'Имя клиента - '.$_POST['name']."\n";
				$_POST['msg'] 	.= 'Контактный номер телефона - '.$_POST['phone']."\n";
				$_POST['msg'] 	.= 'Дата прилета - '.$_POST['date']."\n";
				$_POST['msg'] 	.= "Сообщение:\n".$_POST['note'];
				$this->email->clear(TRUE);
				$config['smtp_host'] = 'localhost';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$this->email->initialize($config);
				$this->email->from($_POST['email'],$_POST['name']);
				$this->email->to('info@lum-tenerife.com');
				$this->email->bcc('');
				$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
				$textmail = strip_tags($_POST['msg']);
				$this->email->message($textmail);	
				if(!$this->email->send()):
					$this->session->set_userdata('msg','Сообщение не отправлено');
					redirect($this->uri->uri_string());
					return FALSE;
				endif;
				$this->session->set_userdata('msg','Сообщение отправлено');
				$_POST['extended'] = $_POST['msg'];
				$_POST['date'] = date("Y-m-d");
				$this->maillistmodel->insert_record($_POST);
				redirect($this->uri->uri_string());
			endif;
		endif;
		$text['sidebar'] = $this->sidebartextmodel->get_record(8);
		$text['head'] = $this->othertextmodel->get_record(6);
		$service = $this->imagesmodel->get_type_data('service');
		$pagevalue['text'] = $text;
		$pagevalue['service'] = $service;
		$this->load->view('user_interface/service',$pagevalue);
	} //функция выводит информацию на страницу услуг;
	
	function transfers(){
		
		$msg = $this->setmessage('','','',0);
		
		$pagevalue = array(
			'description' =>'Организация индивидуальных трансферов из северного и южного аэропорта Тенерифе. Трансферы в Лоро Парк. Организация и проведение экскурсий и туров на комфортабельных автомобилях с профессиональными водителями. Недвижимость на Тенерифе. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, индивидуальные экскурсии, трансфер, Северный Аэропорт Тенерифе, Южный Аэропорт Тенерифе, лоро парк, недвижимость на тенерифе, лас америкас, luminiza',
			'author' => 'RealityGroup',
			'title' => 'Индивидуальный трансфер Тенерифе | Северный и Южный Аэропорт Тенерифе | Транспортные услуги | Luminiza Property Tur S.L.',
			'baseurl' 	=> base_url(),
			'admin' 	=> $this->admin['status'],
			'transfer' 	=> array(),
			'text' 		=> array(),
			'msg'		=> $this->session->userdata('msg')
		);
		$this->session->unset_userdata('msg');
		$this->session->set_userdata('backpage','transfers');
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$transfer = array();
		$text = array();
		$text['sidebar'] = $this->sidebartextmodel->get_record(7);
		$text['head'] = $this->othertextmodel->get_record(5);
		$transfer = $this->imagesmodel->get_type_data('transfers');
		
		if($this->input->post('submit')):
			$this->form_validation->set_rules('email','"E-Mail"','required|valid_email|trim');
			$this->form_validation->set_rules('name','"Ваше имя и фамилия"','required|trim');
			$this->form_validation->set_rules('phone','"Контактный номер телефона"','required|trim');
			$this->form_validation->set_rules('date','"Дата прилета"','required|trim');
			$this->form_validation->set_rules('textmail','"Сообщение"','required|trim');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->tour_extended();
				$this->session->set_userdata('msg','Проверьте правильность заполеных полей');
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$_POST['msg'] 	 = 'Обект - "Трансферы"'. "\n";
				$_POST['msg'] 	.= 'E-Mail клиента - '.$_POST['email']."\n";
				$_POST['msg'] 	.= 'Имя клиента - '.$_POST['name']."\n";
				$_POST['msg'] 	.= 'Контактный номер телефона - '.$_POST['phone']."\n";
				$_POST['msg'] 	.= 'Дата прилета - '.$_POST['date']."\n";
				$_POST['msg'] 	.= 'Сообщение - '.$_POST['textmail']."\n";
				$_POST['msg'] 	.= 'Дата экскурсии - '.$_POST['date']."\n";
				if(isset($_POST['subject'])):
					$sub = array('Интернет','От друзей','Реклама');
					if($_POST['subject'] < 3):
						$_POST['msg'] 	.= 'О нас узнал через - '.$sub[$_POST['subject']];
					elseif(!empty($_POST['subject_txt'])):
						$_POST['msg'] 	.= 'О нас узнал через - '.$_POST['subject_txt'];
					else:
						$_POST['msg'] 	.= 'Пользователь не уточнил откуда узнал о нас.';
					endif;
				else:
					$_POST['msg'] 	.= 'Пользователь не уточнил откуда узнал о нас.';
				endif;
				$this->email->clear(TRUE);
				$config['smtp_host'] = 'localhost';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$this->email->initialize($config);
				$this->email->from($_POST['email'],$_POST['name']);
				$this->email->to('info@lum-tenerife.com');
				$this->email->bcc('');
				$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
				$textmail = strip_tags($_POST['msg']);
				$this->email->message($textmail);	
				if(!$this->email->send()):
					$this->session->set_userdata('msg','Сообщение не отправлено');
					redirect($this->uri->uri_string());
					return FALSE;
				endif;
				$this->session->set_userdata('msg','Сообщение отправлено');
				$_POST['extended'] = $_POST['msg'];
				$_POST['date'] = date("Y-m-d");
				$this->maillistmodel->insert_record($_POST);
				redirect($this->uri->uri_string());
			endif;
		endif;
		
		
		$pagevalue['text'] = $text;
		$pagevalue['transfer'] = $transfer;
		$this->load->view('user_interface/transfers',$pagevalue);
	}		//функция выводит информацию на страницу трансферов;

	function viewimage(){
		
		$id = $this->uri->segment(2);
		$image = $this->imagesmodel->get_only_image($id);
		header('Content-type: image/gif');
		echo $image;
	}		//функция выводит малый рисунок на страницы;
	
	function viewslideshow(){
		
		$id = $this->uri->segment(2);
		$image = $this->imagesmodel->get_only_big_image($id);
		header('Content-type: image/gif');
		echo $image;
	}	//функция выводит большой рисунок на страницы;
	
	function operation_date($field){
			
		$list = preg_split("/-/",$field);
		$nmonth = $this->months[$list[1]];
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5 $nmonth \$1 г."; 
		return preg_replace($pattern, $replacement,$field);
	}		//функция преобразует вид даты;
	
	function search(){
		
		$status = $this->session->userdata('status');
		if(!empty($status)):
			$sql = $this->session->userdata('query');
		endif;
		if($this->input->post('btsearch') || !empty($status)):
			$param = array(); $selectvalue = array(); $apartment = array(); $text = array();$countrecord = array();
			if($this->input->post('btsearch')):
				$selectvalue['object'] 		= $this->apartmentmodel->select_list('apnt_object');
				$selectvalue['location']	= $this->apartmentmodel->select_list('apnt_location');
				$selectvalue['region'] 		= $this->apartmentmodel->select_list('apnt_region');
				$selectvalue['count'] 		= $this->apartmentmodel->select_list('apnt_count');
				for($i=0;$i<count($selectvalue['count']);$i++):
					if(is_numeric($selectvalue['count'][$i]['apnt_count'])):
						$selectvalue['count'][$i]['apnt_count'] = intval($selectvalue['count'][$i]['apnt_count']);
					else:
						continue;
					endif;
				endfor;
				sort($selectvalue['count']);
				$this->session->set_userdata('shobject',$_POST['object']);
				$this->session->set_userdata('shlocation',$_POST['location']);
				$this->session->set_userdata('shregion',$_POST['region']);
				
				if($_POST['cntrec']['object'] == $_POST['object']) $param['object'] = null;
				else $param['object'] = $selectvalue['object'][$_POST['object']]['apnt_object'];
					
				if($_POST['cntrec']['location'] == $_POST['location']) $param['location'] = null;
				else $param['location'] = $selectvalue['location'][$_POST['location']]['apnt_location'];
					
				if($_POST['cntrec']['region'] == $_POST['region']) $param['region'] = null;
				else $param['region'] = $selectvalue['region'][$_POST['region']]['apnt_region'];
				
				$param['room'] = array();	
				$param['roomid'] = array();	
				for($i=0,$j=0;$i<=$_POST['cntrec']['count'];$i++):
					if(!empty($_POST["rooms_$i"])):
						$param['room'][$j] = $_POST["rooms_$i"];
						$param['roomid'][$j] = "rooms_$i";
						$j++;
					endif;
				endfor;
				$this->session->set_userdata('shroom',$param['roomid']);
				
				$sql = 'SELECT * FROM apartment WHERE ';
				if($param['object']) $sql .= 'apnt_object = "'.$param['object'].'" AND ';
				if($param['location']) $sql .= 'apnt_location = "'.$param['location'].'" AND ';
				if($param['region'])  $sql .= 'apnt_region = "'.$param['region'].'" AND ';
				
				if(count($param['room'])):
					if(count($param['room']) > 1):
						$sql .= 'apnt_count IN (';
						for($i = 0;$i < count($param['room']);$i++):
							$sql .= $param['room'][$i];
							if($i < count($param['room'])-1)
								$sql .=',';
						endfor;
						$sql .=') AND';
					else:
						$sql .= 'apnt_count = '.$param['room'][0].' AND';
					endif;
				endif;
				
				$sql .= ' TRUE ORDER BY apnt_date DESC';
				$this->session->set_userdata('query',$sql);
				$this->session->set_userdata('status',TRUE);
				redirect($this->uri->uri_string());
			endif;
			$result = $this->apartmentmodel->search_apartment($sql);		
			$pagevalue = array(
				'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
				'keywords' 	=> 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
				'author' 	=> 'RealityGroup',
				'title' 	=> 'Результаты поиска | Недвижимость на Тенерифе | Аренда апартаментов и вилл | Ипотека в Испании | Экскурсии | Трансферы | Luminiza Property Tur S.L.',
				'baseurl' 	=> base_url(),
				'admin' 	=> $this->admin['status'],
				'msg'		=> $this->session->userdata('msg'),
				'sname' 	=> $this->session->userdata('sname'),
				'lowprice'	=> min($this->apartmentmodel->get_min_price(2)),
				'topprice'	=> max($this->apartmentmodel->get_max_price(2)),
				'lowpricev'	=> $this->session->userdata('shlowprice'),
				'toppricev'	=> $this->session->userdata('shtopprice'),
				'sobject'	=> $this->session->userdata('shobject'),
				'slocation'	=> $this->session->userdata('shlocation'),
				'sregion'	=> $this->session->userdata('shregion'),
				'sroom'		=> $this->session->userdata('shroom')
			);
			$this->session->unset_userdata('msg');
			
			$selectvalue['object'] 		= $this->apartmentmodel->select_list('apnt_object');
			$selectvalue['location']	= $this->apartmentmodel->select_list('apnt_location');
			$selectvalue['region'] 		= $this->apartmentmodel->select_list('apnt_region');
			$selectvalue['count'] 		= $this->apartmentmodel->select_list('apnt_count');
			
			$countrecord['object'] 		= count($selectvalue['object']);
			$countrecord['location'] 	= count($selectvalue['location']);
			$countrecord['region'] 		= count($selectvalue['region']);
			$countrecord['count'] 		= count($selectvalue['count']);
			for($i=0;$i<count($selectvalue['count']);$i++):
				if(is_numeric($selectvalue['count'][$i]['apnt_count'])):
					$selectvalue['count'][$i]['apnt_count'] = intval($selectvalue['count'][$i]['apnt_count']);
				else:
					continue;
				endif;
			endfor;
			sort($selectvalue['count']);
			$text['sidebar'] = $this->sidebartextmodel->get_record(3);
			
			if(!count($result)):
				$pagevalue['text'] = $text;
				$pagevalue['selectvalue'] = $selectvalue;
				$pagevalue['apartment'] = $apartment;
				$pagevalue['countrecord'] = $countrecord;
//				$this->session->set_userdata('msg','Не найдено ни одного апартамента');
				$pagevalue['msg'] = 'Не найдено ни одного апартамента';
				$this->load->view('user_interface/result',$pagevalue);
				return FALSE;
			endif;
			
			$cfgpag['base_url'] = base_url().'/search';
	        $cfgpag['total_rows'] = count($result);
	        $cfgpag['per_page'] =  10;
	        $cfgpag['num_links'] = 4;
	        $cfgpag['uri_segment'] = 2;
			$cfgpag['first_link'] = FALSE;
			$cfgpag['first_tag_open'] = '<li>';
			$cfgpag['first_tag_close'] = '</li>';
			$cfgpag['last_link'] = FALSE;
			$cfgpag['last_tag_open'] = '<li>';
			$cfgpag['last_tag_close'] = '</li>';
			$cfgpag['next_link'] = 'Далее &raquo;';
			$cfgpag['next_tag_open'] = '<li>';
			$cfgpag['next_tag_close'] = '</li>';
			$cfgpag['prev_link'] = '&laquo; Назад';
			$cfgpag['prev_tag_open'] = '<li>';
			$cfgpag['prev_tag_close'] = '</li>';
			$cfgpag['cur_tag_open'] = '<li><a class="active" href="#">';
			$cfgpag['cur_tag_close'] = '</a></li>';
			$cfgpag['num_tag_open'] = '<li>';
			$cfgpag['num_tag_close'] = '</li>';			
			
			$from = intval($this->uri->segment(2));
			$sqlimit = $sql.' LIMIT '.$from.',5';
			
			$result = $this->apartmentmodel->search_limit_apartment($sqlimit,10,$from);
			if(isset($from) and !empty($from)):
				$this->session->set_userdata('backpage','search/'.$from);
				$this->session->set_userdata('searchback','search/'.$from);
			else:
				$this->session->set_userdata('backpage','search');
				$this->session->set_userdata('searchback','search');
			endif;
			$apartment = $result;
			
			for($i = 0; $i < count($apartment);$i++):
				if (mb_strlen($apartment[$i]['apnt_extended'],'UTF-8') > 325):
					$tmp = $apartment[$i]['apnt_extended'];			
					$tmp = mb_substr($tmp,0,325,'UTF-8');	
					$pos = mb_strrpos($tmp,' ',0,'UTF-8');
					$tmp = mb_substr($tmp,0,$pos,'UTF-8');
					$apartment[$i]['apnt_extended'] = $tmp.' ...';
				endif;				
				$image[$i] = $this->imagesmodel->get_type_ones_image('apartment',$apartment[$i]['apnt_id']);
				if(!$image[$i])	 $image[$i] = $this->imagesmodel->get_type_ones_image('commercial',$apartment[$i]['apnt_id']);
				$apartment[$i]['img_id'] = $image[$i]['img_id'];
				$apartment[$i]['img_title'] = $image[$i]['img_title'];
				
				if(empty($apartment[$i]['img_title'])) $apartment[$i]['img_title'] = $apartment[$i]['apnt_title'];
			endfor;
			$this->pagination->initialize($cfgpag);
			$text['pager'] = $this->pagination->create_links();
			
			$pagevalue['text'] = $text;
			$pagevalue['selectvalue'] = $selectvalue;
			$pagevalue['apartment'] = $apartment;
			$pagevalue['countrecord'] = $countrecord;
			$this->load->view('user_interface/result',$pagevalue);
		else:
			redirect($this->session->userdata('backpath'));
		endif;
	}			//функция производит выборку апартаментов по задыннм критериям;
	
	function name_search(){
		
		$status = $this->session->userdata('status');
		if(!empty($status)):
			$sql = $this->session->userdata('query');
		endif;
		if($this->input->post('btsname') || !empty($status)):
			$param = array(); $selectvalue = array(); $apartment = array(); $text = array();$countrecord = array();
			if($this->input->post('btsname')):
				$_POST['btsname'] = NULL;
				$this->session->set_userdata('sname',$_POST['sname']);
				$sql = 'SELECT * FROM apartment WHERE apnt_title LIKE "%'.$_POST['sname'].'%" ORDER BY apnt_date DESC';
				$this->session->set_userdata('query',$sql);
				$this->session->set_userdata('status',TRUE);
				redirect($this->uri->uri_string());
			endif;
			$result = $this->apartmentmodel->search_apartment($sql);
			
			$pagevalue = array(
				'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
				'keywords' 	=> 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
				'author' 	=> 'RealityGroup',
				'title' 	=> 'Результаты поиска | Недвижимость на Тенерифе | Аренда апартаментов и вилл | Ипотека в Испании | Экскурсии | Трансферы | Luminiza Property Tur S.L.',
				'baseurl' 	=> base_url(),
				'admin' 	=> $this->admin['status'],
				'msg'		=> $this->session->userdata('msg'),
				'sname' 	=> $this->session->userdata('sname'),
				'lowprice'	=> min($this->apartmentmodel->get_min_price(2)),
				'topprice'	=> max($this->apartmentmodel->get_max_price(2)),
				'lowpricev'	=> $this->session->userdata('shlowprice'),
				'toppricev'	=> $this->session->userdata('shtopprice'),
				'sobject'	=> $this->session->userdata('shobject'),
				'slocation'	=> $this->session->userdata('shlocation'),
				'sregion'	=> $this->session->userdata('shregion'),
				'sroom'		=> $this->session->userdata('shroom')
			);
			$this->session->unset_userdata('msg');
			
			$selectvalue['object'] 		= $this->apartmentmodel->select_list('apnt_object');
			$selectvalue['location']	= $this->apartmentmodel->select_list('apnt_location');
			$selectvalue['region'] 		= $this->apartmentmodel->select_list('apnt_region');
			$selectvalue['count'] 		= $this->apartmentmodel->select_list('apnt_count');
			
			$countrecord['object'] 		= count($selectvalue['object']);
			$countrecord['location'] 	= count($selectvalue['location']);
			$countrecord['region'] 		= count($selectvalue['region']);
			$countrecord['count'] 		= count($selectvalue['count']);
			
			$text['sidebar'] = $this->sidebartextmodel->get_record(3);
			
			if(!count($result)):
				$pagevalue['text'] = $text;
				$pagevalue['selectvalue'] = $selectvalue;
				$pagevalue['apartment'] = $apartment;
				$pagevalue['countrecord'] = $countrecord;
				$this->session->set_userdata('msg','Не найдено ни одного апартамента');
				$this->load->view('user_interface/result',$pagevalue);
				return FALSE;
			endif;
			
			$cfgpag['base_url'] = base_url().'/name-search';
	        $cfgpag['total_rows'] = count($result);
	        $cfgpag['per_page'] =  10;
	        $cfgpag['num_links'] = 4;
	        $cfgpag['uri_segment'] = 2;
			$cfgpag['first_link'] = FALSE;
			$cfgpag['first_tag_open'] = '<li>';
			$cfgpag['first_tag_close'] = '</li>';
			$cfgpag['last_link'] = FALSE;
			$cfgpag['last_tag_open'] = '<li>';
			$cfgpag['last_tag_close'] = '</li>';
			$cfgpag['next_link'] = 'Далее &raquo;';
			$cfgpag['next_tag_open'] = '<li>';
			$cfgpag['next_tag_close'] = '</li>';
			$cfgpag['prev_link'] = '&laquo; Назад';
			$cfgpag['prev_tag_open'] = '<li>';
			$cfgpag['prev_tag_close'] = '</li>';
			$cfgpag['cur_tag_open'] = '<li><a class="active" href="#">';
			$cfgpag['cur_tag_close'] = '</a></li>';
			$cfgpag['num_tag_open'] = '<li>';
			$cfgpag['num_tag_close'] = '</li>';			
			
			$from = intval($this->uri->segment(2));
			$sqlimit = $sql.' LIMIT '.$from.',5';
			
			$result = $this->apartmentmodel->search_limit_apartment($sqlimit,10,$from);
			if(isset($from) and !empty($from)):
				$this->session->set_userdata('backpage','name-search/'.$from);
				$this->session->set_userdata('searchback','name-search/'.$from);
			else:
				$this->session->set_userdata('backpage','name-search');
				$this->session->set_userdata('searchback','name-search');
			endif;
			$apartment = $result;
			
			for($i=0;$i<count($apartment);$i++):
				if (mb_strlen($apartment[$i]['apnt_extended'],'UTF-8') > 325):
					$tmp = $apartment[$i]['apnt_extended'];			
					$tmp = mb_substr($tmp,0,325,'UTF-8');	
					$pos = mb_strrpos($tmp,' ',0,'UTF-8');
					$tmp = mb_substr($tmp,0,$pos,'UTF-8');
					$apartment[$i]['apnt_extended'] = $tmp.' ...';
				endif;				
				$image[$i] = $this->imagesmodel->get_type_ones_image('apartment',$apartment[$i]['apnt_id']);
				if(!$image[$i])	 $image[$i] = $this->imagesmodel->get_type_ones_image('commercial',$apartment[$i]['apnt_id']);
				$apartment[$i]['img_id'] = $image[$i]['img_id'];
				$apartment[$i]['img_title'] = $image[$i]['img_title'];
				
				if(empty($apartment[$i]['img_title'])) $apartment[$i]['img_title'] = $apartment[$i]['apnt_title'];
			endfor;
			$this->pagination->initialize($cfgpag);
			$text['pager'] = $this->pagination->create_links();
			
			$pagevalue['text'] = $text;
			$pagevalue['selectvalue'] = $selectvalue;
			$pagevalue['apartment'] = $apartment;
			$pagevalue['countrecord'] = $countrecord;
			$this->load->view('user_interface/result',$pagevalue);
		else:
			redirect($this->session->userdata('backpath'));
		endif;
	}
	
	function price_search(){
	
		$status = $this->session->userdata('status');
		if(!empty($status)):
			$sql = $this->session->userdata('query');
		endif;
		if($this->input->post('btsprice') || !empty($status)):
			$param = array(); $selectvalue = array(); $apartment = array(); $text = array();$countrecord = array();
			if($this->input->post('btsprice')):
				$this->session->set_userdata('shlowprice',$_POST['lowprice']);
				$this->session->set_userdata('shtopprice',$_POST['topprice']);
				$_POST['btsprice'] = NULL;
				$sql = 'SELECT * FROM apartment WHERE (apnt_price >= '.$_POST['lowprice'].' AND apnt_price <= '.$_POST['topprice'].') OR (apnt_newprice >= '.$_POST['lowprice'].' AND apnt_newprice <= '.$_POST['topprice'].') ORDER BY apnt_date DESC';
				$this->session->set_userdata('query',$sql);
				$this->session->set_userdata('status',TRUE);
				redirect($this->uri->uri_string());
			endif;
			$result = $this->apartmentmodel->search_apartment($sql);
			$pagevalue = array(
				'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
				'keywords' 	=> 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
				'author' 	=> 'RealityGroup',
				'title' 	=> 'Результаты поиска | Недвижимость на Тенерифе | Аренда апартаментов и вилл | Ипотека в Испании | Экскурсии | Трансферы | Luminiza Property Tur S.L.',
				'baseurl' 	=> base_url(),
				'admin' 	=> $this->admin['status'],
				'msg'		=> $this->session->userdata('msg'),
				'sname' 	=> $this->session->userdata('sname'),
				'lowprice'	=> min($this->apartmentmodel->get_min_price(2)),
				'topprice'	=> max($this->apartmentmodel->get_max_price(2)),
				'lowpricev'	=> $this->session->userdata('shlowprice'),
				'toppricev'	=> $this->session->userdata('shtopprice'),
				'sobject'	=> $this->session->userdata('shobject'),
				'slocation'	=> $this->session->userdata('shlocation'),
				'sregion'	=> $this->session->userdata('shregion'),
				'sroom'		=> $this->session->userdata('shroom')
			);
			$this->session->unset_userdata('msg');
			$selectvalue['object'] 		= $this->apartmentmodel->select_list('apnt_object');
			$selectvalue['location']	= $this->apartmentmodel->select_list('apnt_location');
			$selectvalue['region'] 		= $this->apartmentmodel->select_list('apnt_region');
			$selectvalue['count'] 		= $this->apartmentmodel->select_list('apnt_count');
			
			$countrecord['object'] 		= count($selectvalue['object']);
			$countrecord['location'] 	= count($selectvalue['location']);
			$countrecord['region'] 		= count($selectvalue['region']);
			$countrecord['count'] 		= count($selectvalue['count']);
			
			$text['sidebar'] = $this->sidebartextmodel->get_record(3);
			
			if(!count($result)):
				$pagevalue['text'] = $text;
				$pagevalue['selectvalue'] = $selectvalue;
				$pagevalue['apartment'] = $apartment;
				$pagevalue['countrecord'] = $countrecord;
				$this->session->set_userdata('msg','Не найдено ни одного апартамента');
				$this->load->view('user_interface/result',$pagevalue);
				return FALSE;
			endif;
			
			$cfgpag['base_url'] = base_url().'/price-search';
	        $cfgpag['total_rows'] = count($result);
	        $cfgpag['per_page'] =  10;
	        $cfgpag['num_links'] = 4;
	        $cfgpag['uri_segment'] = 2;
			$cfgpag['first_link'] = FALSE;
			$cfgpag['first_tag_open'] = '<li>';
			$cfgpag['first_tag_close'] = '</li>';
			$cfgpag['last_link'] = FALSE;
			$cfgpag['last_tag_open'] = '<li>';
			$cfgpag['last_tag_close'] = '</li>';
			$cfgpag['next_link'] = 'Далее &raquo;';
			$cfgpag['next_tag_open'] = '<li>';
			$cfgpag['next_tag_close'] = '</li>';
			$cfgpag['prev_link'] = '&laquo; Назад';
			$cfgpag['prev_tag_open'] = '<li>';
			$cfgpag['prev_tag_close'] = '</li>';
			$cfgpag['cur_tag_open'] = '<li><a class="active" href="#">';
			$cfgpag['cur_tag_close'] = '</a></li>';
			$cfgpag['num_tag_open'] = '<li>';
			$cfgpag['num_tag_close'] = '</li>';			
			
			$from = intval($this->uri->segment(2));
			$sqlimit = $sql.' LIMIT '.$from.',5';
			
			$result = $this->apartmentmodel->search_limit_apartment($sqlimit,10,$from);
			if(isset($from) and !empty($from)):
				$this->session->set_userdata('backpage','price-search/'.$from);
				$this->session->set_userdata('searchback','price-search/'.$from);
			else:
				$this->session->set_userdata('backpage','price-search');
				$this->session->set_userdata('searchback','price-search');
			endif;
			$apartment = $result;
			
			for($i=0;$i<count($apartment);$i++):
				if (mb_strlen($apartment[$i]['apnt_extended'],'UTF-8') > 325):
					$tmp = $apartment[$i]['apnt_extended'];			
					$tmp = mb_substr($tmp,0,325,'UTF-8');	
					$pos = mb_strrpos($tmp,' ',0,'UTF-8');
					$tmp = mb_substr($tmp,0,$pos,'UTF-8');
					$apartment[$i]['apnt_extended'] = $tmp.' ...';
				endif;				
				$image[$i] = $this->imagesmodel->get_type_ones_image('apartment',$apartment[$i]['apnt_id']);
				if(!$image[$i])	 $image[$i] = $this->imagesmodel->get_type_ones_image('commercial',$apartment[$i]['apnt_id']);
				$apartment[$i]['img_id'] = $image[$i]['img_id'];
				$apartment[$i]['img_title'] = $image[$i]['img_title'];
				
				if(empty($apartment[$i]['img_title'])) $apartment[$i]['img_title'] = $apartment[$i]['apnt_title'];
			endfor;
			$this->pagination->initialize($cfgpag);
			$text['pager'] = $this->pagination->create_links();
			
			$pagevalue['text'] = $text;
			$pagevalue['selectvalue'] = $selectvalue;
			$pagevalue['apartment'] = $apartment;
			$pagevalue['countrecord'] = $countrecord;
			$this->load->view('user_interface/result',$pagevalue);
		else:
			redirect($this->session->userdata('backpath'));
		endif;
	}
	
	function setmessage($error,$saccessfull,$message,$status){
			
		$this->message['error'] = $error;
		$this->message['saccessfull'] = $saccessfull;
		$this->message['message'] = $message;
		$this->message['status'] = $status;
		
		return $this->message;
	}	//установка сообщения;
	
	function contacts(){
		
		$msg = $this->setmessage('','','',0);		
		$pagevalue = array(
			'description' =>'Агенство недвижимости Luminiza Property Tur S.L. Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы.',
			'keywords' 	=> 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' 	=> 'RealityGroup',
			'title' 	=> 'Контакты Luminiza Property Tur S.L. | Недвижимость на Тенерифе',
			'baseurl' 	=> base_url(),
			'admin' 	=> $this->admin['status'],
			'image' 	=> array(),
			'text' 		=> array(),
			'msg'		=> $this->session->userdata('msg')
		);
		$this->session->unset_userdata('msg');
		$this->session->set_userdata('backpage','contacts');
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$text = array();
		if($this->input->post('submit')):
			$this->form_validation->set_rules('email','"E-Mail"','required|valid_email|trim');
			$this->form_validation->set_rules('name','"Ваше имя"','required|trim');
			$this->form_validation->set_rules('phone','"Контактный номер телефона"','required|trim');
			$this->form_validation->set_rules('note','"Сообщение"','required|trim');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->session->set_userdata('msg','Проверьте правильность заполеных полей');
				$this->contacts();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$_POST['msg'] 	 = 'Обект - "Контакты"'. "\n";
				$_POST['msg'] 	.= 'E-Mail клиента - '.$_POST['email']."\n";
				$_POST['msg'] 	.= 'Имя клиента - '.$_POST['name']."\n";
				$_POST['msg'] 	.= 'Контактный номер телефона - '.$_POST['phone']."\n";
				$_POST['msg'] 	.= "Сообщение:\n".$_POST['note']."\n";
				$this->email->clear(TRUE);
				$config['smtp_host'] = 'localhost';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$this->email->initialize($config);
				$this->email->from($_POST['email'],$_POST['name']);
				$this->email->to('info@lum-tenerife.com');
				$this->email->bcc('');
				$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
				$textmail = strip_tags($_POST['msg']);
				$this->email->message($textmail);	
				if(!$this->email->send()):
					$this->session->set_userdata('msg','Сообщение не отправлено');
					redirect($this->uri->uri_string());
					return FALSE;
				endif;
				$this->session->set_userdata('msg','Сообщение отправлено');
				$_POST['extended'] = $_POST['msg'];
				$_POST['date'] = date("Y-m-d");
				$this->maillistmodel->insert_record($_POST);
				redirect($this->uri->uri_string());
			endif;
		endif;
		$text['sidebar'] = $this->sidebartextmodel->get_record(9);
		$text['head'] = $this->othertextmodel->get_record(7);		
		$image = $this->imagesmodel->get_type_ones_image('contacts',0);
		
		$pagevalue['text'] = $text;
		$pagevalue['image'] = $image;
		$this->load->view('user_interface/contacts',$pagevalue);
	} //функция выводит контактную информацию компании;
						   
	/*==================================================  PRINT  ======================================================*/

	function retail_print(){
		
		$pagevalue = array(
			'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' => 'RealityGroup',
			'title' => 'Недвижимость на Тенерифе | Ипотека | Сопровождение сделки | Luminiza Property Tur S.L.',
			'baseurl' 		=> base_url(),
			'retail'		=> array(),
			'images'		=> array(),
		);
		$apart_id = $this->uri->segment(3);
		$retail = array();	$images = array();
		$apartament = $this->apartmentmodel->get_record($apart_id);
		$retail['id'] = $apartament['apnt_id'];
		$retail['title'] = $apartament['apnt_title'];
		$retail['extended'] = $apartament['apnt_extended'];
		
		if(is_numeric($apartament['apnt_price'])):
			$retail['price'] = number_format($apartament['apnt_price'],0,' ','.');
		endif;
		if(is_numeric($apartament['apnt_newprice'])):
			$retail['newprice'] = number_format($apartament['apnt_newprice'],0,' ','.');
		endif;
		$image = $this->imagesmodel->get_type_ones_image('apartment',$retail['id']);
		if(isset($image) and !empty($image))
			$images = $this->imagesmodel->get_images_without('apartment',$retail['id'],$image['img_id']);
		$retail['img_id'] = $image['img_id'];
		$retail['img_title'] = $image['img_title'];
		$retail['object'] = 'apartment';
		$retail['date'] = $this->operation_date($apartament['apnt_date']);
		
		$retail['properties'] = array(
							'object' 	=> '<strong>Объект:</strong>&nbsp;&nbsp;'.$apartament['apnt_object'],
							'location' 	=> '<strong>Местонахождение:</strong>&nbsp;&nbsp;'.$apartament['apnt_location'],
							'region' 	=> '<strong>Район:</strong>&nbsp;&nbsp;'.$apartament['apnt_region'],
							'rooms' 	=> '<strong>Количество комнат:</strong>&nbsp;&nbsp;'.$apartament['apnt_count'],
							);
		$pagevalue['retail'] = $retail;
		$pagevalue['images'] = $images;
		$this->load->view('user_interface/retail_print_view',$pagevalue);
	}
	
	function retail_commercial_print(){
	
		$pagevalue = array(
			'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' => 'RealityGroup',
			'title' => 'Недвижимость на Тенерифе | Ипотека | Сопровождение сделки | Luminiza Property Tur S.L.',
			'baseurl' 		=> base_url(),
			'admin' 		=> $this->admin['status'],
			'retail'		=> array(),
			'images'		=> array(),
		);
		$apart_id = $this->uri->segment(4);
		$retail = array();$images = array();
		$apartament = $this->apartmentmodel->get_record($apart_id);
		$retail['id'] = $apartament['apnt_id'];
		$retail['title'] = $apartament['apnt_title'];
		$retail['extended'] = $apartament['apnt_extended'];
		if(is_numeric($apartament['apnt_price'])):
			$retail['price'] = number_format($apartament['apnt_price'],0,' ','.');
		endif;
		if(is_numeric($apartament['apnt_newprice'])):
			$retail['newprice'] = number_format($apartament['apnt_newprice'],0,' ','.');
		endif;
		$image = $this->imagesmodel->get_type_ones_image('commercial',$retail['id']);
		if(isset($image) and !empty($image))
			$images = $this->imagesmodel->get_images_without('commercial',$retail['id'],$image['img_id']);
		$retail['img_id'] = $image['img_id'];
		$retail['img_title'] = $image['img_title'];
		$retail['type'] = 'commercial';
		$retail['date'] = $this->operation_date($apartament['apnt_date']);
		
		$retail['properties'] = array(
							'object' 	=> '<strong>Объект:</strong>&nbsp;&nbsp;'.$apartament['apnt_object'],
							'location' 	=> '<strong>Местонахождение:</strong>&nbsp;&nbsp;'.$apartament['apnt_location'],
							'region' 	=> '<strong>Район:</strong>&nbsp;&nbsp;'.$apartament['apnt_region'],
							'rooms' 	=> '<strong>Количество комнат:</strong>&nbsp;&nbsp;'.$apartament['apnt_count'],
							);
		$pagevalue['retail'] = $retail;
		$pagevalue['images'] = $images;
		$this->load->view('user_interface/retail_print_view',$pagevalue);
	}
	
	function rent_print(){
	
		$pagevalue = array(
			'title'			=> 'Аренда апартаментов и вилл | Недвижимость на Тенерифе | Luminiza Property Tur S.L.',
			'description' 	=> 'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' 		=> 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' 		=> 'RealityGroup',
			'baseurl' 		=> base_url(),
			'admin' 		=> $this->admin['status'],
			'rent'			=> array(),
			'images'		=> array(),
		);
		$rent = array(); $images = array();
		$apartament = $this->apartmentmodel->get_record($this->uri->segment(3));
		$rent['id'] = $apartament['apnt_id'];
		$rent['title'] = $apartament['apnt_title'];
		$rent['extended'] = $apartament['apnt_extended'];
		$rent['properties'] = $apartament['apnt_properties'];
		$rent['price'] = $apartament['apnt_price_rent'];
		$image = $this->imagesmodel->get_type_ones_image('apartment',$rent['id']);
		if(isset($image) and !empty($image))
			$images = $this->imagesmodel->get_images_without('apartment',$rent['id'],$image['img_id']);
		$rent['img_id'] = $image['img_id'];
		$rent['img_title'] = $image['img_title'];
		$pagevalue['rent'] = $rent;
		$pagevalue['images'] = $images;
		$this->load->view('user_interface/rent_print_view',$pagevalue);
	}
	
	function rent_commercial_print(){
		
		$pagevalue = array(
			'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' => 'RealityGroup',
			'title' => 'Аренда бизнеса | Коммерческая недвижимость на Тенерифе | Luminiza Property Tur S.L.',
			'baseurl' 		=> base_url(),
			'admin' 		=> $this->admin['status'],
			'rent' 			=> array(),
			'images' 		=> array(),
		);
		$rent = array();$images = array();
		$apartament = $this->apartmentmodel->get_record($this->uri->segment(4));
		$rent['id'] = $apartament['apnt_id'];
		$rent['title'] = $apartament['apnt_title'];
		$rent['extended'] = $apartament['apnt_extended'];
		$rent['properties'] = $apartament['apnt_properties'];
		$rent['price'] = $apartament['apnt_price_rent'];
		$image = $this->imagesmodel->get_type_ones_image('commercial',$rent['id']);
		if(isset($image) and !empty($image))
			$images = $this->imagesmodel->get_images_without('commercial',$rent['id'],$image['img_id']);
		$rent['img_id'] = $image['img_id'];
		$rent['img_title'] = $image['img_title'];
		$pagevalue['rent'] = $rent;
		$pagevalue['images'] = $images;
		$this->load->view('user_interface/rent_print_view',$pagevalue);
	}

/*================================================== END PRINT ======================================================*/
}
?>