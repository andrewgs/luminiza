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
		
		if($this->session->userdata('logon') == '0ddd2cf5b8929fcbd721f2365099c6e3'){
			$this->admin['status'] = TRUE;
			$this->session->unset_userdata('ficha');
		}
	}
	
	function index(){
		
		$pagevalue = array(
					'description' =>'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Индивидуальные экскурсии и трансферы. Воспользовавшись услугами нашего агенства мы сможете купить недвижимость на Тенерифе или снять в аренду апартаменты с видом на океан.',
					'keywords' => 'тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
					'author' => 'RealityGroup',
					'title' => 'Недвижимость на Тенерифе | Аренда апартаментов и вилл | Прокат автомобилей | Индивидуальные экскурсии и трансферы Тенерифе',
					'baseurl' 	=> base_url(),
					'admin' 	=> $this->admin['status'],
					'feedback' 	=> $this->feedbackmodel->rnd_record()
			);
		$this->session->set_userdata('backpage','');
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
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
	
	function aviabileti(){
		
		$pagevalue = array(
			'description' =>'Покупка дешевых авиабилетов на Тенерифе на регулярные и чартерные рейсы из Москвы и Санкт-Петербурга. Индивидуальный трансфер из южного и северного аэропорта Тенерифе.',
			'keywords'	=> 'тенерифе, авиабилеты, дешевые авиабилеты, канарские острова, трансферы, тенерифе экскурсии',
			'author' 	=> 'RealityGroup',
			'title' 	=> 'Дешевые билеты на Тенерифе | Покупка авиабилетов на Тенерифе онлайн',
			'baseurl' 	=> base_url(),
			'admin' 	=> $this->admin['status'],
			'text' 		=> $this->othertextmodel->get_record(21),
			'sidebar' 	=> $this->sidebartextmodel->get_record(12)
		);
		$this->session->set_userdata('backpath',$this->uri->uri_string());
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$this->load->view('user_interface/aviabileti',$pagevalue);
	} //функция выводит информацию об Авиабилетах;
	
	function feedbacks(){
		
		$pagevalue = array(
			'description' =>'Покупка дешевых авиабилетов на Тенерифе на регулярные и чартерные рейсы из Москвы и Санкт-Петербурга. Индивидуальный трансфер из южного и северного аэропорта Тенерифе.',
			'keywords'	=> 'тенерифе, авиабилеты, дешевые авиабилеты, канарские острова, трансферы, тенерифе экскурсии',
			'author' 	=> 'RealityGroup',
			'title' 	=> 'Дешевые билеты на Тенерифе | Покупка авиабилетов на Тенерифе онлайн',
			'baseurl' 	=> base_url(),
			'admin' 	=> $this->admin['status'],
			'feedbacks'	=> array(),
			'sidebar' 	=> $this->sidebartextmodel->get_record(13),
			'pager'		=> array()
		);
		$this->session->set_userdata('backpath',$this->uri->uri_string());
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		
		$cntrec = $this->feedbackmodel->count_records();
		
		$cfgpag['base_url'] 	= base_url().'/feedbacks/page/';
        $cfgpag['total_rows']	= $cntrec;
        $cfgpag['per_page']		=  10;
        $cfgpag['num_links'] 	= 4;
        $cfgpag['uri_segment'] 	= 3;
		$cfgpag['first_link'] 	= FALSE;
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
		$pagevalue['feedbacks'] = $this->feedbackmodel->read_limit_records(10,$from);
		
		$this->pagination->initialize($cfgpag);
		$pagevalue['pager'] = $this->pagination->create_links();
		
		$this->load->view('user_interface/feedbacks',$pagevalue);
	} //функция выводит информацию об отзывах;
	
	function services_provided(){
		
		$pagevalue = array(
			'description' =>'Покупка дешевых авиабилетов на Тенерифе на регулярные и чартерные рейсы из Москвы и Санкт-Петербурга. Индивидуальный трансфер из южного и северного аэропорта Тенерифе.',
			'keywords'	=> 'тенерифе, авиабилеты, дешевые авиабилеты, канарские острова, трансферы, тенерифе экскурсии',
			'author' 	=> 'RealityGroup',
			'title' 	=> 'Дешевые билеты на Тенерифе | Покупка авиабилетов на Тенерифе онлайн',
			'baseurl' 	=> base_url(),
			'admin' 	=> $this->admin['status'],
			'text'		=> $this->othertextmodel->get_record(22),
			'sidebar' 	=> $this->sidebartextmodel->get_record(14)
		);
		$this->session->set_userdata('backpath',$this->uri->uri_string());
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$this->load->view('user_interface/services-provided',$pagevalue);
	} //функция выводит информацию об Список всех предоставляемых услуг;
	
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
			'segment'	=> 'retail/',
			'softvalue' => $this->session->userdata('sortby'),
			'selectvalue' => array(),
			'apartment' => array(),
			'text' 		=> array(),
			'countrecord' => array(),
			'lowprice'	=> min($this->apartmentmodel->get_min_price(2)),
			'topprice'	=> max($this->apartmentmodel->get_max_price(2)),
			'sname' 	=> $this->session->userdata('sname')
		);
		if(!$pagevalue['lowprice']) $pagevalue['lowprice'] = 0;
		if(!$pagevalue['topprice']) $pagevalue['topprice'] = 20000000;
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
			'ficha'			=> '',
			'msg'			=> $this->session->userdata('msg')
		);
		$this->session->unset_userdata('msg');
		$apart_id = $this->uri->segment(3);
		$pagevalue['ficha'] = 'retail/apartment/'.$apart_id.'/ficha';
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
				$this->email->to('info@lum-tenerife.com,admin@lum-tenerife.com');
				$this->email->bcc('');
				$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
				$textmail = strip_tags($_POST['msg']);
				$this->email->message($textmail);	
				if(!$this->email->send()):
					$this->session->set_userdata('msg','Сообщение не отправлено');
					redirect($this->uri->uri_string());
					return FALSE;
				else:
					$this->sendbackmail($_POST['name'],$_POST['email']);
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
		/*$image = $this->imagesmodel->get_type_ones_image('apartment',$retail['id']);
		if(isset($image) and !empty($image))
			$images = $this->imagesmodel->get_images_without('apartment',$retail['id'],$image['img_id']);
		$retail['img_id'] = $image['img_id'];
		$retail['img_title'] = $image['img_title'];*/
		$images = $this->imagesmodel->get_images_without('apartment',$retail['id'],0);
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
			'segment'		=> 'retail/',
			'softvalue' 	=> $this->session->userdata('sortby'),
			'selectvalue' 	=> array(),
			'apartment' 	=> array(),
			'text' 			=> array(),
			'countrecord' 	=> array(),
			'lowprice'		=> min($this->apartmentmodel->get_min_price(2)),
			'topprice'		=> max($this->apartmentmodel->get_max_price(2)),
			'sname' 		=> $this->session->userdata('sname')
		);
		if(!$pagevalue['lowprice']) $pagevalue['lowprice'] = 0;
		if(!$pagevalue['topprice']) $pagevalue['topprice'] = 20000000;
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
			'ficha'			=> '',
			'msg'			=> $this->session->userdata('msg')
		);
		$this->session->unset_userdata('msg');
		$apart_id = $this->uri->segment(4);
		$pagevalue['ficha'] = 'retail/commercial/extended/'.$apart_id.'/ficha';
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
				$this->email->to('info@lum-tenerife.com,admin@lum-tenerife.com');
				$this->email->bcc('');
				$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
				$textmail = strip_tags($_POST['msg']);
				$this->email->message($textmail);	
				if(!$this->email->send()):
					$this->session->set_userdata('msg','Сообщение не отправлено');
					redirect($this->uri->uri_string());
					return FALSE;
				else:
					$this->sendbackmail($_POST['name'],$_POST['email']);
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
		/*$image = $this->imagesmodel->get_type_ones_image('commercial',$retail['id']);
		if(isset($image) and !empty($image))
			$images = $this->imagesmodel->get_images_without('commercial',$retail['id'],$image['img_id']);
		$retail['img_id'] = $image['img_id'];
		$retail['img_title'] = $image['img_title'];*/
		$images = $this->imagesmodel->get_images_without('commercial',$retail['id'],0);
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
			'author' 	=> 'RealityGroup',
			'baseurl' 	=> base_url(),
			'page'		=> $this->uri->segment(2),
			'admin' 	=> $this->admin['status'],
			'segment'	=> 'rent/',
			'text'		=> array(),
			'rentlist'	=> array(),
			'countrecord' => array(),
			'softvalue' => $this->session->userdata('sortby'),
			'selectvalue' => array(),
			'lowprice'	=> min($this->apartmentmodel->get_min_price(2)),
			'topprice'	=> max($this->apartmentmodel->get_max_price(2)),
			'sname' 	=> $this->session->userdata('sname')
		);
		if(!$pagevalue['lowprice']) $pagevalue['lowprice'] = 0;
		if(!$pagevalue['topprice']) $pagevalue['topprice'] = 20000000;
		if(!$pagevalue['softvalue']) $pagevalue['softvalue'] = 0;
		$this->session->set_userdata('backpath',$this->uri->uri_string());
		$this->session->set_userdata('backpage',$this->uri->uri_string());
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$countrecord = array(); $text = array(); $rentlist = array();
		
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
		
		if($this->uri->segment(2) == 'auto'):
			$pagevalue['title'] = 'Аренда авто на Тенерифе | Прокат машин любого класса | Обслуживание на русском языке | Аренда новых автомобилей';
			$pagevalue['description'] = 'К вашим услугам аренда машин на Тенерифе. Наша компания предосталяет услуги проката авто от семейных минивэнов до стильных спорткаров. Мы предлагаем арендовать новые автомобили на любой срок, общение на родном языке и круглосуточную техническую поддержку.';  
		else:
			$pagevalue['title'] = 'Недвижимость на Тенерифе | Аренда апартаментов и вилл | Ипотека в Испании | Luminiza Property Tur S.L.';
			$pagevalue['description'] = 'Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.'; 
		endif;
		
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
		
		$pagevalue['countrecord'] = $countrecord;
		$pagevalue['selectvalue'] = $selectvalue;
		$pagevalue['rentlist'] = $rentlist;
		$pagevalue['pageslinks'] = $pageslinks;
		$pagevalue['text'] = $text;
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
			'ficha'			=> NULL,
			'msg'			=> $this->session->userdata('msg')
		);
		$this->session->unset_userdata('msg');
		if($rent_type == 'auto'):
			$pagevalue['title'] = 'Аренда автомобилей на Тенерифе | Luminiza Property Tur S.L.';
			$pagevalue['description'] = 'Аренда автомобилей от семейных минивэнов до престижных моделей представительского класса или стильных спорткаров. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.';  
		else:
			$pagevalue['ficha'] = 'rent/apartment/'.$rent_id.'/ficha';
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
						/*$image = $this->imagesmodel->get_type_ones_image('auto',$rent['id']);
						if(isset($image) and !empty($image))
							$images = $this->imagesmodel->get_images_without('auto',$rent['id'],$image['img_id']);
						$rent['img_id'] = $image['img_id'];
						$rent['img_title'] = $image['img_title'];*/
						$images = $this->imagesmodel->get_images_without('auto',$rent['id'],0);
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
						/*$image = $this->imagesmodel->get_type_ones_image('apartment',$rent['id']);
						if(isset($image) and !empty($image))
							$images = $this->imagesmodel->get_images_without('apartment',$rent['id'],$image['img_id']);
						$rent['img_id'] = $image['img_id'];
						$rent['img_title'] = $image['img_title'];*/
						$images = $this->imagesmodel->get_images_without('apartment',$rent['id'],0);
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
				$this->form_validation->set_rules('number_people','"Количество взлослых"','required|trim');
				$this->form_validation->set_rules('number_children','"Количество детей"','required|trim');
				$this->form_validation->set_rules('rdate','"Дата въезда"','required|trim');
				$this->form_validation->set_rules('bcdate','"Дата выезда"','required');
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
					$_POST['msg'] 	.= 'Количество взрослых - '.$_POST['number_people']."\n";
					$_POST['msg'] 	.= 'Количество детей - '.$_POST['number_children']."\n";
					$_POST['msg'] 	.= 'Дата въезда - '.$_POST['rdate']."\n";
					$_POST['msg'] 	.= 'Дата выезда - '.$_POST['bcdate']."\n";
					$this->email->clear(TRUE);
					$config['smtp_host'] = 'localhost';
					$config['charset'] = 'utf-8';
					$config['wordwrap'] = TRUE;
					$this->email->initialize($config);
					$this->email->from($_POST['email'],$_POST['name']);
					$this->email->to('info@lum-tenerife.com,admin@lum-tenerife.com');
					$this->email->bcc('');
					$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
					$textmail = strip_tags($_POST['msg']);
					$this->email->message($textmail);	
					if(!$this->email->send()):
						$this->session->set_userdata('msg','Сообщение не отправлено');
						redirect($this->uri->uri_string());
						return FALSE;
					else:
						$this->sendbackmail($_POST['name'],$_POST['email']);
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
				$this->form_validation->set_rules('number_people','"Количество взлослых"','required|trim');
				$this->form_validation->set_rules('number_children','"Количество детей"','required|trim');
				$this->form_validation->set_rules('permit','"Номер водительских прав"','required|trim');
				$this->form_validation->set_rules('pdate','"Дата получения"','required|trim');
				$this->form_validation->set_rules('country','"Страна получения"','required|trim');
				$this->form_validation->set_rules('rdate','"Дата въезда"','required|trim');
				$this->form_validation->set_rules('bcdate','"Дата выезда"','required');
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
					$_POST['msg'] 	.= 'Количество взлослых - '.$_POST['number_people']."\n";
					$_POST['msg'] 	.= 'Количество детей - '.$_POST['number_children']."\n";
					$_POST['msg'] 	.= 'Номер водительских прав - '.$_POST['permit']."\n";
					$_POST['msg'] 	.= 'Дата получения - '.$_POST['pdate']."\n";
					$_POST['msg'] 	.= 'Страна получения - '.$_POST['country']."\n";
					$_POST['msg'] 	.= 'Дата въезда - '.$_POST['rdate']."\n";
					$_POST['msg'] 	.= 'Дата выезда - '.$_POST['bcdate']."\n";
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
					$this->email->to('info@lum-tenerife.com,admin@lum-tenerife.com');
					$this->email->bcc('');
					$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
					$textmail = strip_tags($_POST['msg']);
					$this->email->message($textmail);	
					if(!$this->email->send()):
						$this->session->set_userdata('msg','Сообщение не отправлено');
						redirect($this->uri->uri_string());
						return FALSE;
					else:
						$this->sendbackmail($_POST['name'],$_POST['email']);
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
			'segment'		=> 'rent/',
			'text'			=> array(),
			'commercial'	=> array(),
			'pageslinks'	=> array(),
			'softvalue' 	=> $this->session->userdata('sortby'),
			'selectvalue' 	=> array(),
			'countrecord' 	=> array(),
			'lowprice'		=> min($this->apartmentmodel->get_min_price(2)),
			'topprice'		=> max($this->apartmentmodel->get_max_price(2)),
			'sname' 		=> $this->session->userdata('sname')
		);
		if(!$pagevalue['lowprice']) $pagevalue['lowprice'] = 0;
		if(!$pagevalue['topprice']) $pagevalue['topprice'] = 20000000;
		if(!$pagevalue['softvalue']) $pagevalue['softvalue'] = 0;
		$this->session->set_userdata('backpath',$this->uri->uri_string());
		$this->session->set_userdata('backpage',$this->uri->uri_string());
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');
		$selectvalue = array();$countrecord = array();$text = array(); $commercial = array();
		$text[1]['sidebar'] = $this->sidebartextmodel->get_record(11);	// раздел апартаменты;
		$text[1]['head'] = $this->othertextmodel->get_record(20);
		
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
		$pagevalue['selectvalue'] = $selectvalue;
		$pagevalue['countrecord'] = $countrecord;
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
			'ficha'			=> '',
			'msg'			=> $this->session->userdata('msg')
		);
		$this->session->unset_userdata('msg');
		$pagevalue['ficha'] = 'rent/commercial/extended/'.$rent_id.'/ficha';
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
			$this->form_validation->set_rules('number_people','"Количество взлослых"','required|trim');
			$this->form_validation->set_rules('number_children','"Количество детей"','required|trim');
			$this->form_validation->set_rules('rdate','"Дата въезда"','required|trim');
			$this->form_validation->set_rules('bcdate','"Дата выезда"','required');
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
				$_POST['msg'] 	.= 'Количество взрослых - '.$_POST['number_people']."\n";
				$_POST['msg'] 	.= 'Количество детей - '.$_POST['number_children']."\n";
				$_POST['msg'] 	.= 'Дата въезда - '.$_POST['rdate']."\n";
				$_POST['msg'] 	.= 'Дата выезда - '.$_POST['bcdate']."\n";
				$this->email->clear(TRUE);
				$config['smtp_host'] = 'localhost';
				$config['charset'] = 'utf-8';
				$config['wordwrap'] = TRUE;
				$this->email->initialize($config);
				$this->email->from($_POST['email'],$_POST['name']);
				$this->email->to('info@lum-tenerife.com,admin@lum-tenerife.com');
				$this->email->bcc('');
				$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
				$textmail = strip_tags($_POST['msg']);
				$this->email->message($textmail);	
				if(!$this->email->send()):
					$this->session->set_userdata('msg','Сообщение не отправлено');
					redirect($this->uri->uri_string());
					return FALSE;
				else:
					$this->sendbackmail($_POST['name'],$_POST['email']);
				endif;
				$this->session->set_userdata('msg','Сообщение отправлено');
				$_POST['extended'] = $_POST['msg'];
				$_POST['date'] = date("Y-m-d");
				$this->maillistmodel->insert_record($_POST);
				redirect($this->uri->uri_string());
			endif;
		endif;
		
		/*$image = $this->imagesmodel->get_type_ones_image('commercial',$rent['id']);
		if(isset($image) and !empty($image))
			$images = $this->imagesmodel->get_images_without('commercial',$rent['id'],$image['img_id']);
		$rent['img_id'] = $image['img_id'];
		$rent['img_title'] = $image['img_title'];*/
		$images = $this->imagesmodel->get_images_without('commercial',$rent['id'],0);
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
			$this->form_validation->set_rules('textmail','"Примечания"','trim');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if(!$this->form_validation->run()):
				$this->session->set_userdata('msg','Проверьте правильность заполеных полей');
				$_POST['submit'] = NULL;
				$this->tour_extended();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$price = 0;
				$people = $_POST['adults']+$_POST['children']+$_POST['infants'];
				if($people > 8):
					$_POST['submit'] = NULL;
					$this->session->set_userdata('msg','Превышено количество пасажиров.<br/>Макс: 8 человек');
					$this->tour_extended();
					return FALSE;
				endif;
				if($people < $tour['tour_people']):
					$_POST['submit'] = NULL;
					$this->session->set_userdata('msg','Минимальное количество человек равно '.$tour['tour_people']);
					$this->tour_extended();
					return FALSE;
				endif;
				$price = ($_POST['adults']+($_POST['children']*0.5)) * $tour['tour_price'];
				if($_POST['price'] != $price):
					$_POST['submit'] = NULL;
					$this->session->set_userdata('msg','Ошибка расчета стоимости.<br/>Повторите снова.');
					$this->tour_extended();
					return FALSE;
				endif;
				
				$this->session->set_userdata(array('torder'=>TRUE,'tprice'=>$_POST['price'],'tourid'=>$tour['tour_id'],'tour'=>$tour['tour_title'],'email'=>$_POST['email'],'name'=>$_POST['name'],'phone'=>$_POST['phone'],'date'=>$_POST['date'],'adults'=>$_POST['adults'],'children'=>$_POST['children'],'infants'=>$_POST['infants'],'note'=>$_POST['note']));
				redirect('tour/confirmation-of-order');
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
				$this->email->to('info@lum-tenerife.com,admin@lum-tenerife.com');
				$this->email->bcc('');
				$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
				$textmail = strip_tags($_POST['msg']);
				$this->email->message($textmail);	
				if(!$this->email->send()):
					$this->session->set_userdata('msg','Сообщение не отправлено');
					redirect($this->uri->uri_string());
					return FALSE;
				else:
					$this->sendbackmail($_POST['name'],$_POST['email']);
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
		$this->session->set_userdata('backpath',$this->uri->uri_string());
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
			$this->form_validation->set_rules('name','"Контактное лицо"','required|trim');
			$this->form_validation->set_rules('phone','"Номер телефона"','required|trim');
			$this->form_validation->set_rules('date','"Дата"','required|trim');
			$this->form_validation->set_rules('note','"Примечания"','trim');
			$this->form_validation->set_rules('price','','required|trim');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if(!$this->form_validation->run()):
				$_POST['submit'] = NULL;
				$this->session->set_userdata('msg','Проверьте правильность заполеных полей');
				$this->transfers();
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$mprice = array(0,90,120,30,60,150);
				$price = 0;
				$people = $_POST['adults'];
				if($people > 8):
					$_POST['submit'] = NULL;
					$this->session->set_userdata('msg','Превышено количество пасажиров.<br/>Макс: 8 человек');
					$this->transfers();
					return FALSE;
				endif;
				switch ($_POST['place']):
					case '1': $people <=4 ? $price = $mprice['1'] : $price = $mprice['2']; break;
					case '2': $people <=4 ? $price = $mprice['3'] : $price = $mprice['4']; break;
					case '3': $price = $mprice['5']; break;
				endswitch;
				if($_POST['price'] != $price):
					$_POST['submit'] = NULL;
					$this->session->set_userdata('msg','Ошибка расчета стоимости.<br/>Повторите снова.');
					$this->transfers();
					return FALSE;
				endif;
				
				$this->session->set_userdata(array('trorder'=>TRUE,'trprice'=>$_POST['price'],'place'=>$_POST['place'],'email'=>$_POST['email'],'name'=>$_POST['name'],'phone'=>$_POST['phone'],'date'=>$_POST['date'],'adults'=>$_POST['adults'],'children'=>$_POST['children'],'infants'=>$_POST['infants'],'flight'=>$_POST['flight'],'note'=>$_POST['note']));
				redirect('transfers/confirmation-of-order');
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
	
	function feedbackimage(){
		
		$id = $this->uri->segment(2);
		$image = $this->feedbackmodel->get_image($id);
		header('Content-type: image/gif');
		echo $image;
	}
	
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
				if($_POST['segment'] == 'rent'):
					$sql .= ' TRUE AND apnt_flag = 1 ORDER BY apnt_date DESC';
				else:
					$sql .= ' TRUE AND (apnt_flag = 0 OR apnt_flag = 2) AND ((apnt_price >= '.$_POST['lowprice'].' AND apnt_price <= '.$_POST['topprice'].') OR (apnt_newprice >= '.$_POST['lowprice'].' AND apnt_newprice <= '.$_POST['topprice'].')) ORDER BY apnt_price,apnt_newprice,apnt_date DESC';
					$this->session->set_userdata('shlowprice',$_POST['lowprice']);
					$this->session->set_userdata('shtopprice',$_POST['topprice']);
				endif;
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
				'segment'	=> $this->uri->segment(1).'/',
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
				$this->session->unset_userdata('msg');
//				$this->session->set_userdata('msg','Не найдено ни одного апартамента');
				$pagevalue['msg'] = 'Не найдено ни одного апартамента';
				$this->load->view('user_interface/result',$pagevalue);
				return FALSE;
			endif;
			
			$cfgpag['base_url'] = base_url().$this->uri->segment(1).'/search';
	        $cfgpag['total_rows'] = count($result);
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
			$sqlimit = $sql.' LIMIT '.$from.',5';
			
			$result = $this->apartmentmodel->search_limit_apartment($sqlimit,10,$from);
			if(isset($from) and !empty($from)):
				$this->session->set_userdata('backpage',$this->uri->segment(1).'/search/'.$from);
				$this->session->set_userdata('searchback',$this->uri->segment(1).'/search/'.$from);
			else:
				$this->session->set_userdata('backpage',$this->uri->segment(1).'/search');
				$this->session->set_userdata('searchback',$this->uri->segment(1).'/search');
			endif;
			$apartment = $result;
			
			for($i=0;$i<count($apartment);$i++):
				if(mb_strlen($apartment[$i]['apnt_extended'],'UTF-8') > 325):
					$tmp = $apartment[$i]['apnt_extended'];			
					$tmp = mb_substr($tmp,0,325,'UTF-8');	
					$pos = mb_strrpos($tmp,' ',0,'UTF-8');
					$tmp = mb_substr($tmp,0,$pos,'UTF-8');
					$apartment[$i]['apnt_extended'] = $tmp.' ...';
				endif;
				if(is_numeric($apartment[$i]['apnt_price'])):
					$apartment[$i]['apnt_price'] = number_format($apartment[$i]['apnt_price'],0,' ','.');
				endif;
				if(is_numeric($apartment[$i]['apnt_newprice'])):
					$apartment[$i]['apnt_newprice'] = number_format($apartment[$i]['apnt_newprice'],0,' ','.');
				endif;
				$image[$i] = $this->imagesmodel->get_type_ones_image('apartment',$apartment[$i]['apnt_id']);
				if(!$image[$i]) $image[$i] = $this->imagesmodel->get_type_ones_image('commercial',$apartment[$i]['apnt_id']);
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
				if($_POST['segment'] == 'rent'):
					$sql = 'SELECT * FROM apartment WHERE apnt_title LIKE "%'.$_POST['sname'].'%" AND apnt_flag = 1 ORDER BY apnt_date DESC';
				else:
					$sql = 'SELECT * FROM apartment WHERE apnt_title LIKE "%'.$_POST['sname'].'%" AND (apnt_flag = 0 OR apnt_flag = 2) ORDER BY apnt_date DESC';
				endif;
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
				'segment'	=> $this->uri->segment(1).'/',
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
			
			if(!count($result)):
				$pagevalue['text'] = $text;
				$pagevalue['selectvalue'] = $selectvalue;
				$pagevalue['apartment'] = $apartment;
				$pagevalue['countrecord'] = $countrecord;
				$this->session->unset_userdata('msg');
//				$this->session->set_userdata('msg','Не найдено ни одного апартамента');
				$pagevalue['msg'] = 'Не найдено ни одного апартамента';
				$this->load->view('user_interface/result',$pagevalue);
				return FALSE;
			endif;
			
			$cfgpag['base_url'] = base_url().$this->uri->segment(1).'/name-search';
	        $cfgpag['total_rows'] = count($result);
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
			$sqlimit = $sql.' LIMIT '.$from.',5';
			
			$result = $this->apartmentmodel->search_limit_apartment($sqlimit,10,$from);
			if(isset($from) and !empty($from)):
				$this->session->set_userdata('backpage',$this->uri->segment(1).'/name-search/'.$from);
				$this->session->set_userdata('searchback',$this->uri->segment(1).'/name-search/'.$from);
			else:
				$this->session->set_userdata('backpage',$this->uri->segment(1).'/name-search');
				$this->session->set_userdata('searchback',$this->uri->segment(1).'/name-search');
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
		$this->session->set_userdata('backpath',$this->uri->uri_string());
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
				$this->email->to('info@lum-tenerife.com,admin@lum-tenerife.com');
				$this->email->bcc('');
				$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
				$textmail = strip_tags($_POST['msg']);
				$this->email->message($textmail);	
				if(!$this->email->send()):
					$this->session->set_userdata('msg','Сообщение не отправлено');
					redirect($this->uri->uri_string());
					return FALSE;
				else:
					$this->sendbackmail($_POST['name'],$_POST['email']);
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
	
	function contacts_popup() {
		
		if ( $this->input->post('submit') ) 
		{
			$status = 0;
			$email = @$_POST['email'];
			$name  = @$_POST['name'];
			$phone = @$_POST['phone'];
			$note  = @$_POST['note'];
			
			$textmail = "Поступило новое сообщение от пользователя веб-сайта {$name}.\n\nТелефонный номер клиента: {$phone}\n\nСообщение пользователя:\n{$note}";
			
			$this->email->clear(TRUE);
			$config['smtp_host'] = 'localhost';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$this->email->initialize($config);
			$this->email->from($_POST['email'], $_POST['name']);
			$this->email->to('admin@lum-tenerife.com');
			$this->email->bcc('');
			$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
			$this->email->message($textmail);	
			
			if ( !$this->email->send() ) {
				$status = -1;
			} else {
				$this->sendbackmail($_POST['name'], $_POST['email']);
				$status = 1;
			}
			
			echo $status;
		} else {
			$pagevalue = array(
				'description' 	=> 'Форма обратной связи с агентством недвижимости Luminiza Property Tur S.L.',
				'keywords' 		=> '',
				'author' 		=> 'RealityGroup',
				'title' 		=> 'Форма обратной связи :: Luminiza Property Tur S.L.',
				'baseurl' 		=> base_url()
			);
		
			$this->load->view('user_interface/contacts_popup', $pagevalue);
		}
	} //функция выводит контактную информацию компании;
	
	function sendbackmail($name,$email){
		
		$msg = "Здравствуйте, {$name}. Спасибо за Ваш интерес к нашему агенству. Ваше письмо доставлено и мы обязательно Вам ответим в течение одного рабочего дня\n\n.--\nС уважением,\nДемченко Светлана\n(+34) 922-712-237\nwww.lum-tenerife.ru\nАгентство недвижимости Luminiza Property Tur S.L.";
		$this->email->clear(TRUE);
		$config['smtp_host'] = 'localhost';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		$this->email->from('info@lum-tenerife.com','Luminiza Property Tur S.L.');
		$this->email->to($email);
		$this->email->bcc('');
		$this->email->subject('Заявка принята. Агентство недвижимости Luminiza Property Tur S.L.');
		$textmail = strip_tags($msg);
		$this->email->message($textmail);	
		$this->email->send();
	}
		   
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
		/*$image = $this->imagesmodel->get_type_ones_image('apartment',$retail['id']);
		if(isset($image) and !empty($image))
			$images = $this->imagesmodel->get_images_without('apartment',$retail['id'],$image['img_id']);
		$retail['img_id'] = $image['img_id'];
		$retail['img_title'] = $image['img_title'];*/
		$images = $this->imagesmodel->get_images_without('apartment',$retail['id'],0);
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
		/*$image = $this->imagesmodel->get_type_ones_image('commercial',$retail['id']);
		if(isset($image) and !empty($image))
			$images = $this->imagesmodel->get_images_without('commercial',$retail['id'],$image['img_id']);
		$retail['img_id'] = $image['img_id'];
		$retail['img_title'] = $image['img_title'];*/
		$images = $this->imagesmodel->get_images_without('commercial',$retail['id'],0);
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
		/*$image = $this->imagesmodel->get_type_ones_image('apartment',$rent['id']);
		if(isset($image) and !empty($image))
			$images = $this->imagesmodel->get_images_without('apartment',$rent['id'],$image['img_id']);
		$rent['img_id'] = $image['img_id'];
		$rent['img_title'] = $image['img_title'];*/
		$images = $this->imagesmodel->get_images_without('apartment',$rent['id'],0);
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
		/*$image = $this->imagesmodel->get_type_ones_image('commercial',$rent['id']);
		if(isset($image) and !empty($image))
			$images = $this->imagesmodel->get_images_without('commercial',$rent['id'],$image['img_id']);
		$rent['img_id'] = $image['img_id'];
		$rent['img_title'] = $image['img_title'];*/
		$images = $this->imagesmodel->get_images_without('commercial',$rent['id'],0);
		$pagevalue['rent'] = $rent;
		$pagevalue['images'] = $images;
		$this->load->view('user_interface/rent_print_view',$pagevalue);
	}

/*================================================== END PRINT ======================================================*/

	function pay(){
		
		$pagevalue = array(
			'description' =>'Покупайте недвижимость online, невыходя из дома. Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' => 'купить online, тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' => 'RealityGroup',
			'title' => 'Купить недвижимость Online | Недвижимость в Испании на Тенерифе | Luminiza Property Tur S.L.',
			'baseurl' 	=> base_url(),
			'admin' 	=> $this->admin['status'],
			'text' 		=> $this->othertextmodel->get_record(21),
			'sidebar' 	=> $this->sidebartextmodel->get_record(12)
		);
		$this->session->set_userdata('backpath',$this->uri->uri_string());
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');	
		
		$this->load->view('user_interface/pay',$pagevalue);
	}

	function confirmation_order(){
		
		$type = $this->uri->segment(1);
		switch($type):
			case 'transfers' : 	{$order = $this->session->userdata('trorder');
								$price =  $this->session->userdata('trprice');
								$backpath = $this->session->userdata('backpath');
								}; break;
			case 'tour' 	: 	{$order = $this->session->userdata('torder');
								$price =  $this->session->userdata('tprice');
								$backpath = 'tour/extended/'.$this->session->userdata('tourid');
								}; break;
		endswitch;
		if(!$order): 
			redirect($backpath);
		endif;
		
		$pagevalue = array(
			'description' =>'Покупайте недвижимость online, невыходя из дома. Недвижимость на Тенерифе. Продажа и аренда апартаментов, вил и коммерческой недвижимости на Канарских островах. Юридическое сопровождение сделок, оформление ипотеки. Индивидуальные экскурсии и трансферы. Агенство недвижимости Luminiza Property Tur S.L.',
			'keywords' 	=> 'купить online, тенерифе, канарские острова, аренда тенерифе, недвижимость на тенерифе, лас америкас, ипотека, апартаменты, виллы, тенерифе экскурсии, лоро парк, вулкан тейде, luminiza',
			'author' 	=> 'RealityGroup',
			'title' 	=> 'Купить недвижимость Online | Недвижимость в Испании на Тенерифе | Luminiza Property Tur S.L.',
			'baseurl' 	=> base_url(),
			'admin' 	=> $this->admin['status'],
			'sidebar' 	=> array(),
			'backpath'	=> $backpath,
			'amountval'	=> ''
		);
		if(!$price):
			$this->session->set_userdata('msg','Ошибка расчета стоимости.<br/>Повторите снова.');
			redirect($backpath);
		else:
			$pagevalue['amountval'] = $price.'00';
		endif;
		$this->session->unset_userdata('query');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('calc');
		$this->session->unset_userdata('searchback');	
		$this->load->view('user_interface/confirmation-order',$pagevalue);
	}

	function confirmation_error(){
		
		$type = $this->uri->segment(1);
		switch($type):
			case 'transfers' : 	{$order = $this->session->userdata('trorder');
								$backpath = $this->session->userdata('backpath');
								}; break;
			case 'tour' 	: 	{$order = $this->session->userdata('torder');
								$backpath = 'tour/extended/'.$this->session->userdata('tourid');
								}; break;
		endswitch;
		if(!$order): 
			redirect($backpath);
		endif;
		
		$this->session->set_userdata('msg','Операция оплаты произведена с ошибкой или отменена');
		redirect($backpath.'#kontakt');
	}

	function confirmation_transfers_success(){
		
		$order = $this->session->userdata('trorder');
		if(!$order) redirect($this->session->userdata('backpath'));
		
		if(isset($_SERVER['HTTP_REFERER'])):
			if($_SERVER['HTTP_REFERER'] != 'http://tpv.ceca.es:8000/cgi-bin/tpv'):
				redirect($this->session->userdata('backpath'));
			endif;
		else:
			redirect($this->session->userdata('backpath'));
		endif;
		
		$place = array('','Северный аэропорт (Los Rodeos)','Южный аэропорт (Reina Sofia)','Лоро Парк (Loro Parque)');
		ob_start();
		?>
Поступил новый заказ на трансфер из <?=$place[$this->session->userdata('place')]?> на <?=$this->session->userdata('date')?>.

Имя клиента: <?=$this->session->userdata('name')?> 
Контактный номер телефона: <?=$this->session->userdata('phone')?> 
Пассажиры: <?=$this->session->userdata('adults')?> взрослых, <?=$this->session->userdata('children')?> детей и <?=$this->session->userdata('infants')?> детей до 2 лет.

Номер авиарейса: <?=$this->session->userdata('flight');?>
Клиент добавил к запросу следующее примечание: <?=$this->session->userdata('note')?>
		<?
		$mess['msg'] = ob_get_clean();

		$this->email->clear(TRUE);
		$config['smtp_host'] = 'localhost';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		$this->email->from($this->session->userdata('email'),$this->session->userdata('name'));
		$this->email->to('info@lum-tenerife.com,admin@lum-tenerife.com');
		//$this->email->to('admin@lum-tenerife.com');
		$this->email->bcc('');
		$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
		$textmail = strip_tags($mess['msg']);
		$this->email->message($textmail);	
		$this->email->send();
		$this->sendbackmail($this->session->userdata('email'),$this->session->userdata('email'));
		$mas['extended'] = $mess['msg'];
		$mas['date'] = date("Y-m-d");
		$mas['name'] = $this->session->userdata('name');
		$mas['email'] = $this->session->userdata('email');
		$this->maillistmodel->insert_record($mas);
		
		$this->session->unset_userdata(array('torder'=>'','trorder'=>'','trprice'=>'','place'=>'','tprice'=>'','tourid'=>'','tour'=>'','email'=>'','name'=>'','phone'=>'','date'=>'','adults'=>'','children'=>'','infants'=>'','flight'=>'','note'=>''));
		
		$pagevalue = array(
			'description' =>'',
			'keywords' 	=> '',
			'author' 	=> 'RealityGroup',
			'title' 	=> 'Операция оплаты произведена успешно',
			'baseurl' 	=> base_url(),
			'admin' 	=> $this->admin['status'],
			'sidebar' 	=> array(),
			'backpath'	=> $this->session->userdata('backpath'),
			'text'		=> 'Операция оплаты произведена успешно'
		);
		$this->load->view('user_interface/confirmation-successful',$pagevalue);
	}

	function confirmation_tour_success(){
		
		$order = $this->session->userdata('torder');
		if(!$order):
			redirect($this->session->userdata('backpath'));
		endif;
		
		if(isset($_SERVER['HTTP_REFERER'])):
			if($_SERVER['HTTP_REFERER'] != 'http://tpv.ceca.es:8000/cgi-bin/tpv'):
				redirect($this->session->userdata('backpath'));
			endif;
		else:
			redirect($this->session->userdata('backpath'));
		endif;
		
		ob_start();
		?>
Поступил новый заказ на экскурсию  <?=$this->session->userdata('tour');?> на <?=$this->session->userdata('date')?>.

Имя клиента: <?=$this->session->userdata('name')?> 
Контактный номер телефона: <?=$this->session->userdata('phone')?> 
Пассажиры: <?=$this->session->userdata('adults')?> взрослых, <?=$this->session->userdata('children')?> детей и <?=$this->session->userdata('infants')?> детей до 2 лет.

Клиент добавил к запросу следующее примечание: <?=$this->session->userdata('note')?>
		<?
		$mess['msg'] = ob_get_clean();
		
		$this->email->clear(TRUE);
		$config['smtp_host'] = 'localhost';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		$this->email->from($this->session->userdata('email'),$this->session->userdata('name'));
		$this->email->to('info@lum-tenerife.com,admin@lum-tenerife.com');
		//$this->email->to('admin@lum-tenerife.com');
		$this->email->bcc('');
		$this->email->subject('Сообщение от пользователя Luminiza Property Tur S.L.');
		$textmail = strip_tags($mess['msg']);
		$this->email->message($textmail);	
		$this->email->send();
		$this->sendbackmail($this->session->userdata('email'),$this->session->userdata('email'));
		$mas['extended'] = $mess['msg'];
		$mas['date'] = date("Y-m-d");
		$mas['name'] = $this->session->userdata('name');
		$mas['email'] = $this->session->userdata('email');
		$this->maillistmodel->insert_record($mas);
		
		$pagevalue = array(
			'description' =>'',
			'keywords' 	=> '',
			'author' 	=> 'RealityGroup',
			'title' 	=> 'Операция оплаты произведена успешно',
			'baseurl' 	=> base_url(),
			'admin' 	=> $this->admin['status'],
			'sidebar' 	=> array(),
			'backpath'	=> 'tour/extended/'.$this->session->userdata('tourid'),
			'text'		=> 'Операция оплаты произведена успешно'
		);
		
		$this->session->unset_userdata(array('torder'=>'','trorder'=>'','trprice'=>'','place'=>'','tprice'=>'','tourid'=>'','tour'=>'','email'=>'','name'=>'','phone'=>'','date'=>'','adults'=>'','children'=>'','infants'=>'','flight'=>'','note'=>''));
		
		$this->load->view('user_interface/confirmation-successful',$pagevalue);
	}
}
?>