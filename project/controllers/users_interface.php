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
		$this->session->set_userdata('backpage','about');
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
			'author' => 'RealityGroup',
			'title' => 'Недвижимость на Тенерифе | Продажа апартаментов и вилл | Ипотека в Испании | Luminiza Property Tur S.L.',
			'baseurl' => base_url(),
			'admin' => $this->admin['status'],
			'formsort' => $this->uri->uri_string(),
			'softvalue' => $this->session->userdata('sortby'),
			'selectvalue' => array(),
			'apartment' => array(),
			'text' => array(),
			'countrecord' => array(),
			
		);
		if(!$pagevalue['softvalue']) $pagevalue['softvalue'] = 0;
		$this->session->set_userdata('backpage','retail');
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$selectvalue = array();$apartment = array();$text = array();$countrecord = array();
		
		$selectvalue['object'] 		= $this->apartmentmodel->select_list('apnt_object');
		$selectvalue['location']	= $this->apartmentmodel->select_list('apnt_location');
		$selectvalue['region'] 		= $this->apartmentmodel->select_list('apnt_region');
		$selectvalue['count'] 		= $this->apartmentmodel->select_list('apnt_count');
		
		$countrecord['object'] 		= count($selectvalue['object']);
		$countrecord['location'] 	= count($selectvalue['location']);
		$countrecord['region'] 		= count($selectvalue['region']);
		$countrecord['count'] 		= count($selectvalue['count']);
		
		$text['sidebar'] = $this->sidebartextmodel->get_record(3);
		$text['head'] = $this->othertextmodel->get_record(1);
		
		$cntrec = $this->apartmentmodel->count_records_flag(2);
		
		$cfgpag['base_url'] = base_url().'/retail';
        $cfgpag['total_rows'] = $cntrec;
        $cfgpag['per_page'] =  4;
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
		$apartment = $this->apartmentmodel->get_limit_records(4,$from,2,$sortby);
		for($i = 0; $i < count($apartment); $i++):		
			if (mb_strlen($apartment[$i]['apnt_extended'],'UTF-8') > 650):									
				$apartment[$i]['apnt_extended'] = mb_substr($apartment[$i]['apnt_extended'],0,650,'UTF-8');	
				$pos = mb_strrpos($apartment[$i]['apnt_extended'],'.',0,'UTF-8');
				$apartment[$i]['apnt_extended'] = mb_substr($apartment[$i]['apnt_extended'],0,$pos,'UTF-8');
				$apartment[$i]['apnt_extended'] .= '. ...';
			endif;
			if(is_numeric($apartment[$i]['apnt_price'])):
				$apartment[$i]['apnt_price'] = number_format($apartment[$i]['apnt_price'],0,' ','.');
			endif;
			if(is_numeric($apartment[$i]['apnt_newprice'])):
				$apartment[$i]['apnt_newprice'] = number_format($apartment[$i]['apnt_newprice'],0,' ','.');
			endif;
		endfor;

		if(isset($from) && ! empty($from)) $this->session->set_userdata('backpage','retail/'.$from);
		
		for($i = 0; $i < count($apartment); $i++):
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
	
	function commercial(){
		
		if(isset($_POST['sortlink'])):
			$this->session->set_userdata('sortby',$_POST['sortvalue']);
		endif;
		$pagevalue = array(
			'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' => 'RealityGroup',
			'title' => 'Бизнес на Тенерифе | Коммерческая недвижимость | Ипотека в Испании | Luminiza Property Tur S.L.',
			'baseurl' => base_url(),
			'admin' => $this->admin['status'],
			'formsort' => $this->uri->uri_string(),
			'softvalue' => $this->session->userdata('sortby'),
			'selectvalue' => array(),
			'apartment' => array(),
			'text' => array(),
			'countrecord' => array()
		);
		if(!$pagevalue['softvalue']) $pagevalue['softvalue'] = 0;
		$this->session->set_userdata('backpage','commercial');
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$selectvalue = array();$apartment = array();$text = array();$countrecord = array();
		
		$selectvalue['object'] 		= $this->apartmentmodel->select_list('apnt_object');
		$selectvalue['location']	= $this->apartmentmodel->select_list('apnt_location');
		$selectvalue['region'] 		= $this->apartmentmodel->select_list('apnt_region');
		$selectvalue['count'] 		= $this->apartmentmodel->select_list('apnt_count');
		
		$countrecord['object'] 		= count($selectvalue['object']);
		$countrecord['location'] 	= count($selectvalue['location']);
		$countrecord['region'] 		= count($selectvalue['region']);
		$countrecord['count'] 		= count($selectvalue['count']);
		
		$text['sidebar'] = $this->sidebartextmodel->get_record(10);
		$text['head'] = $this->othertextmodel->get_record(19);
		
		$cntrec = $this->apartmentmodel->count_commercial_flag(5);

		$cfgpag['base_url'] = base_url().'/commercial';
        $cfgpag['total_rows'] = $cntrec;
        $cfgpag['per_page'] =  4;
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
		$apartment = $this->apartmentmodel->get_limit_commercial(4,$from,5,$sortby);
		for($i = 0; $i < count($apartment); $i++):		
			if (mb_strlen($apartment[$i]['apnt_extended'],'UTF-8') > 650):									
				$apartment[$i]['apnt_extended'] = mb_substr($apartment[$i]['apnt_extended'],0,650,'UTF-8');	
				$pos = mb_strrpos($apartment[$i]['apnt_extended'],'.',0,'UTF-8');
				$apartment[$i]['apnt_extended'] = mb_substr($apartment[$i]['apnt_extended'],0,$pos,'UTF-8');
				$apartment[$i]['apnt_extended'] .= '. ...';
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
	
	function retail_extended(){
		
		$pagevalue = array(
			'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' => 'RealityGroup',
			'title' => 'Недвижимость на Тенерифе | Ипотека | Сопровождение сделки | Luminiza Property Tur S.L.',
			'baseurl' 		=> base_url(),
			'searchstatus'	=> FALSE,
			'searchback'	=> '',
			'admin' 		=> $this->admin['status'],
			'retail'		=> array(),
			'images'		=> array(),
			'text'			=> ''
		);
		$apart_id = $this->uri->segment(3);
		$retail = array();	$images = array();
		$status = $this->session->userdata('status');
		$this->session->set_userdata('calc',TRUE);
		if(!empty($status)):
			$pagevalue['searchstatus'] = TRUE;
			$pagevalue['searchback'] = $this->session->userdata('searchback');
		endif;
		$this->session->set_userdata('backpage','retail/apartment/'.$apart_id);		
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
	
	function commercial_extended(){
		
		$pagevalue = array(
			'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' => 'RealityGroup',
			'title' => 'Недвижимость на Тенерифе | Ипотека | Сопровождение сделки | Luminiza Property Tur S.L.',
			'baseurl' 		=> base_url(),
			'searchstatus'	=> FALSE,
			'searchback'	=> '',
			'admin' 		=> $this->admin['status'],
			'retail'		=> array(),
			'images'		=> array(),
			'text'			=> ''
		);
		$apart_id = $this->uri->segment(3);
		$retail = array();$images = array();
		$status = $this->session->userdata('status');
		$this->session->set_userdata('calc',TRUE);
		if(!empty($status)):
			$pagevalue['searchstatus'] = TRUE;
			$pagevalue['searchback'] = $this->session->userdata('searchback');
		endif;
		$this->session->set_userdata('backpage','commercial/retail/'.$apart_id);		
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
		
		$this->session->set_userdata('backpage','rent/'.$pagevalue['page']);
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
        $cfgpag['per_page'] =  4;
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
		$rentlist['apartment'] = $this->apartmentmodel->get_limit_records(4,$from,1,0);
		
		for($i = 0; $i < count($rentlist['apartment']); $i++):		
			if (mb_strlen($rentlist['apartment'][$i]['apnt_extended'],'UTF-8') > 650):
				$tmp = $rentlist['apartment'][$i]['apnt_extended'];			
				$tmp = mb_substr($tmp,0,650,'UTF-8');	
				$pos = mb_strrpos($tmp,'.',0,'UTF-8');
				$tmp = mb_substr($tmp,0,$pos,'UTF-8');
				$rentlist['apartment'][$i]['apnt_extended'] = $tmp.'. ...';
			endif;
		endfor;		
		if(isset($from) and ! empty($from)) $this->session->set_userdata('backpage','rent/retail/'.$from);
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
		$this->load->view('user_interface/rent',$pagevalue);
	} //функция выводит информацию на страницу аренды;
	
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
		$this->session->set_userdata('backpage','rent/commercial');
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
        $cfgpag['per_page'] =  4;
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
		$commercial = $this->apartmentmodel->get_limit_commercial(4,$from,4,0);
		
		for($i = 0; $i < count($commercial); $i++):		
			if (mb_strlen($commercial[$i]['apnt_extended'],'UTF-8') > 650):
				$tmp = $commercial[$i]['apnt_extended'];			
				$tmp = mb_substr($tmp,0,650,'UTF-8');	
				$pos = mb_strrpos($tmp,'.',0,'UTF-8');
				$tmp = mb_substr($tmp,0,$pos,'UTF-8');
				$commercial[$i]['apnt_extended'] = $tmp.'. ...';
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
	
	function rent_extended($firstparam = '',$secondparam = ''){
		
		$msg = $this->setmessage('','','',0);
		$rent_type = $this->uri->segment(2);
		$rent_id = $this->uri->segment(3);
		
		if(!empty($firstparam) and !empty($secondparam)):
			$rent_type = $secondparam;
			$rent_id = $firstparam;
			$msg = $this->setmessage('','','',0);
		endif;
		
		$pagevalue = array(
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' => 'RealityGroup',
			'baseurl' 		=> base_url(),
			'id'			=> $rent_id,
			'type'			=> $rent_type,
			'searchstatus'	=> FALSE,
			'searchback'	=> '',
			'admin' 		=> $this->admin['status'],
			'rent'			=> array(),
			'images'		=> array(),
			'text'			=> array(),
			'msg'			=> ''
		);
		
		if ($rent_type == 'auto'):
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
		$this->session->set_userdata('backpage','rent/'.$rent_type.'/'.$rent_id);
		switch($rent_type){
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
		}
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf):
			$msg = $this->setmessage($flasherr,$flashsaf,$flashmsg,1);
		endif;
		
		$pagevalue['rent'] = $rent;
		$pagevalue['images'] = $images;
		$pagevalue['text'] = $text;
		$pagevalue['msg'] = $msg;
		$this->load->view('user_interface/rent_extended',$pagevalue);
	} //функция выводит полную информацию объекта аренды;

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
			'rent' 			=> array(),
			'images' 		=> array(),
			'text' 			=> array(),
			'msg'			=> $msg
		);
		
		$rent = array();
		$images = array();
		$status = $this->session->userdata('status');
		$text = array();
		if(!empty($status)):
			$pagevalue['searchstatus'] = TRUE;
			$pagevalue['searchback'] = $this->session->userdata('searchback');
		endif;
		$this->session->set_userdata('backpage','rent/commercial/extended/'.$rent_id);
		$apartament = $this->apartmentmodel->get_record($rent_id);
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
		$text['sidebar'] = $this->sidebartextmodel->get_record(5);
		$rent['type'] = 'commercial';
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf):
			$msg = $this->setmessage($flasherr,$flashsaf,$flashmsg,1);
		endif;
		$pagevalue['rent'] = $rent;
		$pagevalue['images'] = $images;
		$pagevalue['text'] = $text;
		$pagevalue['msg'] = $msg;
		$this->load->view('user_interface/rent_commercial_extended',$pagevalue);
	} //функция выводит полную информацию rоммерческой недвижимости аренда;
	
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
		$this->session->set_userdata('backpage','tour');
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
			if (mb_strlen($tour[$i]['tour_extended'],'UTF-8') > 650):
				$tmp = $tour[$i]['tour_extended'];			
				$tmp = mb_substr($tmp,0,650,'UTF-8');	
				$pos = mb_strrpos($tmp,'.',0,'UTF-8');
				$tmp = mb_substr($tmp,0,$pos,'UTF-8');
				$tour[$i]['tour_extended'] = $tmp.'. ...';
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
			'msg'		=> $msg
		);
		$this->session->set_userdata('backpage','service');
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$service = array();
		$text = array();
		$text['sidebar'] = $this->sidebartextmodel->get_record(8);
		$text['head'] = $this->othertextmodel->get_record(6);
		$service = $this->imagesmodel->get_type_data('service');
		
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf):
			$msg = $this->setmessage($flasherr,$flashsaf,$flashmsg,1);
		endif;
		$pagevalue['text'] = $text;
		$pagevalue['service'] = $service;
		$pagevalue['msg'] = $msg;
		$this->load->view('user_interface/service',$pagevalue);
	} //функция выводит информацию на страницу услуг;
	
	function tour_extended(){
		
		$pagevalue = array(
			'description' =>'Организация индивидуальных экскурсий и туров на Тенерифе, Гран Канария, Ла Гомера. Обзорные экскурсии, вулкан Тейде, Лоро Парк. Недвижимость на Тенерифе. Индивидуальные трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, гран канария, индивидуальные экскурсии, лоро парк, вулкан тейде, ла гомера, недвижимость на тенерифе, лас америкас, luminiza',
			'author' => 'RealityGroup',
			'title' => 'Индивидуальные экскурсии | Luminiza Property Tur S.L.',
			'baseurl' => base_url(),
			'backpath' => $this->session->userdata('backpage'),
			'admin' => $this->admin['status'],
			'tour' 	=> array(),
			'text' 	=> array(),
			'images'=> $msg
		);
		$tour_id = $this->uri->segment(3);
		$tour = array();
		$text = array();
		$images = array();
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
		$this->load->view('user_interface/tour_extended',$pagevalue);
	} //функция выводит подробную информацию об экскурсии;	
	
	function transfers(){
		
		$msg = $this->setmessage('','','',0);
		
		$pagevalue = array(
			'description' =>'Организация индивидуальных трансферов из северного и южного аэропорта Тенерифе. Трансферы в Лоро Парк. Организация и проведение экскурсий и туров на комфортабельных автомобилях с профессиональными водителями. Недвижимость на Тенерифе. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'тенерифе, индивидуальные экскурсии, трансфер, Северный Аэропорт Тенерифе, Южный Аэропорт Тенерифе, лоро парк, недвижимость на тенерифе, лас америкас, luminiza',
			'author' => 'RealityGroup',
			'title' => 'Индивидуальный трансфер Тенерифе | Северный и Южный Аэропорт Тенерифе | Транспортные услуги | Luminiza Property Tur S.L.',
			'baseurl' => base_url(),
			'admin' => $this->admin['status'],
			'transfer' 	=> array(),
			'text' 		=> array(),
			'msg'		=> $msg
		);
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
		
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf):
			$msg = $this->setmessage($flasherr,$flashsaf,$flashmsg,1);
		endif;
		$pagevalue['text'] = $text;
		$pagevalue['transfer'] = $transfer;
		$pagevalue['msg'] = $msg;
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
		if(isset($_POST['btsearch']) or !empty($status)):
			$param = array();
			$selectvalue = array();
			$apartment = array();
			$text = array();
			$countrecord = array();
			$msg = $this->setmessage('','','',0);
		if(isset($_POST['btsearch'])):
			$selectvalue['object'] 		= $this->apartmentmodel->select_list('apnt_object');
			$selectvalue['location']	= $this->apartmentmodel->select_list('apnt_location');
			$selectvalue['region'] 		= $this->apartmentmodel->select_list('apnt_region');
			$selectvalue['count'] 		= $this->apartmentmodel->select_list('apnt_count');
			
			if($_POST['cntrec']['object'] == $_POST['object'])
				$param['object'] = null;
			else
				$param['object'] = $selectvalue['object'][$_POST['object']]['apnt_object'];
				
			if($_POST['cntrec']['location'] == $_POST['location'])
				$param['location'] = null;
			else
				$param['location'] = $selectvalue['location'][$_POST['location']]['apnt_location'];
				
			if($_POST['cntrec']['region'] == $_POST['region'])
				$param['region'] = null;
			else
				$param['region'] = $selectvalue['region'][$_POST['region']]['apnt_region'];
			
			$param['room'] = array();			
			for($i = 0,$j = 0;$i <= $_POST['cntrec']['count'];$i++):
				if(!empty($_POST["rooms_$i"])):
					$param['room'][$j] = $_POST["rooms_$i"];
					$j++;
				endif;
			endfor;
			
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
		endif;
			
			$result = $this->apartmentmodel->search_apartment($sql);		
			$this->session->set_userdata('query',$sql);
			$this->session->set_userdata('status',TRUE);
			
			$pagevalue = array(
				'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
				'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
				'author' => 'RealityGroup',
				'title' => 'Результаты поиска | Недвижимость на Тенерифе | Аренда апартаментов и вилл | Ипотека в Испании | Экскурсии | Трансферы | Luminiza Property Tur S.L.',
				'baseurl' => base_url(),
				'admin' => $this->admin['status']
			);
			
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
				
				$msg = $this->setmessage('','','Не найдено ни одного апартамента, соответствующего Вашему запросу',1);
				$this->load->view('result',array('pagevalue'=>$pagevalue,'selectvalue'=>$selectvalue,'text'=>$text,'apartment'=>$result,'countrecord'=>$countrecord,'msg'=>$msg));
				return FALSE;
			endif;
			
			$cfgpag['base_url'] = base_url().'/search';
	        $cfgpag['total_rows'] = count($result);
	        $cfgpag['per_page'] =  5;
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
			
			$result = $this->apartmentmodel->search_limit_apartment($sqlimit,5,$from);
			if(isset($from) and !empty($from)):
				$this->session->set_userdata('backpage','search/'.$from);
				$this->session->set_userdata('searchback','search/'.$from);
			else:
				$this->session->set_userdata('backpage','search');
				$this->session->set_userdata('searchback','search');
			endif;
			$apartment = $result;
			
			for($i = 0; $i < count($apartment);$i++):
			
				if (mb_strlen($apartment[$i]['apnt_extended'],'UTF-8') > 250):
					$tmp = $apartment[$i]['apnt_extended'];			
					$tmp = mb_substr($tmp,0,250,'UTF-8');	
					$pos = mb_strrpos($tmp,'.',0,'UTF-8');
					$tmp = mb_substr($tmp,0,$pos,'UTF-8');
					$apartment[$i]['apnt_extended'] = $tmp.'. ...';
				endif;				
				$image[$i] = $this->imagesmodel->get_type_ones_image('apartment',$apartment[$i]['apnt_id']);
				if(!$image[$i])	 $image[$i] = $this->imagesmodel->get_type_ones_image('commercial',$apartment[$i]['apnt_id']);
				$apartment[$i]['img_id'] = $image[$i]['img_id'];
				$apartment[$i]['img_title'] = $image[$i]['img_title'];
				
				if(empty($apartment[$i]['img_title'])) $apartment[$i]['img_title'] = $apartment[$i]['apnt_title'];
			endfor;
			$this->pagination->initialize($cfgpag);
			$text['pager'] = $this->pagination->create_links();
			
			$msg = $this->setmessage('','','Результат поиска: ',1);
			$this->load->view('result',array('pagevalue'=>$pagevalue,'selectvalue'=>$selectvalue,'text'=>$text,'apartment'=>$apartment,'countrecord'=>$countrecord,'msg'=>$msg));
		else:
			redirect('retail');
		endif;
		
	}			//функция производит выборку апартаментов по задыннм критериям;

	function setmessage($error,$saccessfull,$message,$status){
			
		$this->message['error'] = $error;
		$this->message['saccessfull'] = $saccessfull;
		$this->message['message'] = $message;
		$this->message['status'] = $status;
		
		return $this->message;
	}	//установка сообщения;
	
	function mailsending(){
		
		if(!isset($_POST['Submit'])) show_404();
		$object = $_POST['object'];
		
		$this->form_validation->set_rules('email','"E-Mail"','required|valid_email|trim');
		$this->form_validation->set_rules('your_name','"Ваше имя"','required|trim');
		
		if($object == 'transfers' or $object == 'service')
			$this->form_validation->set_rules('your_arrival_date','"Дата прилета"','required|trim');
			
		if($object == 'transfers' or $object == 'service' or $object == 'contacts')
			$this->form_validation->set_rules('textmail','"Сообщение"','required|trim');
			
		if($object == 'apartment' or $object == 'auto'):
			$this->form_validation->set_rules('your_lastname','"Ваша фамилия"','required|trim');
			$this->form_validation->set_rules('your_bdate','"Дата рождения"','required|trim');
			$this->form_validation->set_rules('your_address','"Домашний адрес"','required|trim');			
			$this->form_validation->set_rules('your_rdate','"Дата начала аренды"','required|trim');
			$this->form_validation->set_rules('your_bcdate','"Дата возвращения"','required');
		endif;
		
		if ($object == 'auto'):
			$this->form_validation->set_rules('your_permit','"Номер водительских прав"','required|trim');
			$this->form_validation->set_rules('your_pdate','"Дата получения"','required|trim');
			$this->form_validation->set_rules('your_country','"Страна получения"','required|trim');
			$this->form_validation->set_rules('your_car','"Модель автомобиля"','required|trim');
		endif;
		
		$this->form_validation->set_error_delimiters('<div class="message">','</div>');
		
		if($this->form_validation->run() == FALSE):
			
			if($object == 'apartment' or $object == 'auto'):
				$this->rent_extended($_POST['id'],$_POST['type']);
			elseif($object == 'transfers'):
				$this->transfers();
			elseif($object == 'service'):
				$this->service();
			elseif($object == 'contacts'):
				$this->contacts();
			endif;
			return FALSE;
		else:
			$data[0] = array('В аэропорту ','В отеле');
			$data[1] = array(	'apartment' 	=> 'Обект - "Недвижимость"',
								'auto' 			=> 'Обект - "Автомобиль"',
								'transfers' 	=> 'Обект - "Трансферы"',
								'service' 		=> 'Обект - "Услуги"',
								'contacts' 		=> 'Обект - "Контакты"');
								
			$data[2] = array('Интернет','От друзей','Реклама','Не указано');
			
			if($object == 'transfers')
				$data[2][3] = $_POST['your-subject_txt'];
			
			$_POST['msg'] 		 = $data[1][$_POST['type']]. "\n";
			$_POST['msg'] 		.= 'Название - '.$_POST['title']."\n";
			$_POST['msg'] 		.= 'Идентификатор в таблице - '.$_POST['id']."\n";
			$_POST['msg'] 		.= 'E-Mail клиента - '.$_POST['email']."\n";
			
			if($object == 'apartment' or $object == 'auto'):
				$_POST['msg'] 	.= 'Имя клиента - '.$_POST['your_name'].' '.$_POST['your_lastname']."\n";
				$_POST['msg'] 	.= 'Дата рождения - '.$_POST['your_bdate']."\n";
			endif;
			
			if($object == 'transfers' or $object == 'service' or $object == 'contacts'):
				$_POST['msg'] 	.= 'Имя клиента - '.$_POST['your_name']."\n";
				
				if(!empty($_POST['your_phone']))
					$_POST['msg'] 	.= 'Телефон клиента - '.$_POST['your_phone']."\n";
				else
					$_POST['msg'] 	.= 'Телефон клиента - Не указан.'."\n";
					
				if($object != 'contacts')
					$_POST['msg'] 	.= 'Дата прилета - '.$_POST['your_arrival_date']."\n";
				$_POST['msg'] 	.= 'Сообщение: <br/>'.$_POST['textmail']."\n";				
			endif;
			if($object == 'transfers')
				$_POST['msg'] 	.= 'Узнали от - '.$data[2][$_POST['your-subject']]."\n";
			
			if($_POST['object'] == 'auto'):
				$_POST['msg'] 	.= 'Номер водительских прав - '.$_POST['your_permit']."\n";
				$_POST['msg'] 	.= 'Дата получения - '.$_POST['your_pdate']."\n";
				$_POST['msg'] 	.= 'Страна получения - '.$_POST['your_country']."\n";
			endif;
			
			if($object == 'apartment' or $object == 'auto')
				$_POST['msg'] 	.= 'Домашний адрес - '.$_POST['your_address']."\n";
			
			if($_POST['object'] == 'auto')
				$_POST['msg'] 	.= 'Модель автомобиля - '.$_POST['your_car']."\n";
				
			if($object == 'apartment' or $object == 'auto'):
				$_POST['msg'] 	.= 'Дата начала аренды - '.$_POST['your_rdate']."\n";
				$_POST['msg'] 	.= 'Дата возвращения - '.$_POST['your_bcdate']."\n";
			endif;
			
			if($_POST['object'] == 'auto')
				$_POST['msg'] 	.= 'Место сдачи в аренду - '.$data[0][$_POST['place']];

			$config['smtp_host'] = 'localhost';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;

			$this->email->initialize($config);
			
			if($object == 'apartment' or $object == 'auto'):
				$this->email->from($_POST['email'], $_POST['your_name'].' '.$_POST['your_lastname']);
			else:
				$this->email->from($_POST['email'], $_POST['your_name']);
			endif;
			if($object == 'service')
				$this->email->to('service@lum-tenerife.com');
			else
				$this->email->to('info@lum-tenerife.com');
				
			$this->email->bcc('');
			$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
			
			$textmail = strip_tags($_POST['msg']);
			$this->email->message($textmail);	
			
			if (!$this->email->send()):
				$this->session->set_flashdata('operation_error',$this->email->print_debugger());
				$this->session->set_flashdata('operation_message','');
				$this->session->set_flashdata('operation_saccessfull','Сообщение не отправлено');
				redirect($_POST['backuri']);
				return FALSE;
			endif;
			
			$this->session->set_flashdata('operation_error',' ');
			$this->session->set_flashdata('operation_message','Ваше сообщение отправлено!');
			$this->session->set_flashdata('operation_saccessfull','Сообщение отправлено');
			
			$_POST['name'] = $_POST['your_name'];
			$_POST['extended'] = $_POST['msg'];
			$_POST['date'] = date("Y-m-d");
			
			$this->maillistmodel->insert_record($_POST);
			redirect($_POST['backuri']);
		endif;
	}
	
	function contacts(){
		
		$msg = $this->setmessage('','','',0);		
		$pagevalue = array(
			'description' =>'Агенство недвижимости Luminiza Property Tur S.L. Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы.',
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' => 'RealityGroup',
			'title' => 'Контакты Luminiza Property Tur S.L. | Недвижимость на Тенерифе',
			'baseurl' => base_url(),
			'admin' => $this->admin['status'],
			'image' 	=> array(),
			'text' 		=> array(),
			'msg'		=> $msg
		);
		$this->session->set_userdata('backpage','contacts');
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$text = array();
		$text['sidebar'] = $this->sidebartextmodel->get_record(9);
		$text['head'] = $this->othertextmodel->get_record(7);		
		$image = $this->imagesmodel->get_type_ones_image('contacts',0);
		
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf):
			$msg = $this->setmessage($flasherr,$flashsaf,$flashmsg,1);
		endif;
		$pagevalue['text'] = $text;
		$pagevalue['image'] = $image;
		$pagevalue['msg'] = $msg;
		$this->load->view('user_interface/contacts',$pagevalue);
	} //функция выводит контактную информацию компании;
	
	function page404(){
		
		$data = array(
			'description' =>'Страница не найдена',
			'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' => 'RealityGroup',
			'title' => 'Страница не найдена | Недвижимость на Тенерифе | Аренда апартаментов и вилл | Ипотека в Испании | Экскурсии | Трансферы | Luminiza Property Tur S.L.',
			'baseurl' => base_url()
		);
		$this->load->view('page404',array('data' => $data));
	}	//функция выводит 404-ю ошибку;
}
?>