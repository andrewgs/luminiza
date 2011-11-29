<?php

class Admin_interface extends CI_Controller{

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
		
		$this->load->library('image_lib');
		
		if ($this->session->userdata('logon') == '0ddd2cf5b8929fcbd721f2365099c6e3') return;
		if ($this->uri->segment(1)==='login') return;
		if ($this->uri->segment(1)==='admin') return;
		redirect('login');
	}
	
	function index(){
		
		$pagevalue = array(
					'description' =>'',
					'author' => '',
					'title' => "Администрирование",
					'baseurl' => base_url(),
					'menu' => '',
					'submenu' => ''
					
				);
		$msg = $this->setmessage('','','',0);
		
		$flashmsg = $this->session->flashdata('operation_saccessfull');
		if(isset($flashmsg) and !empty($flashmsg))
			$msg = $this->setmessage('','',$flashmsg,1);

		$this->load->view('admin_interface/adminpanel',array('pagevalue'=>$pagevalue,'msg'=>$msg));
	}				//функция показывает панель администрирования;
	
	function feedback(){
	
		$backpage = $this->session->userdata('backpage');
		$pagevalue = array(
				'description'	=> '',
				'author' 		=> '',
				'title'			=> "Отзывы клиентов",
				'backpage' 		=> $backpage,
				'admin' 		=> FALSE,
				'baseurl' 		=> base_url(),
				'feedback'		=> $this->feedbackmodel->read_records(),
				'msg'			=> $this->session->userdata('msg')
		);
		$this->session->unset_userdata('msg');
		if($this->input->post('submit')):
			$this->form_validation->set_rules('region','"Город"','required|trim');
			$this->form_validation->set_rules('fio','"Имя и фамилия"','required|trim');
			$this->form_validation->set_rules('note','"Отзыв"','required|trim');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if(!$this->form_validation->run()):
				$this->feedback();
				$this->session->set_userdata('msg','Проверьте правильность заполеных полей');
				$_POST['submit'] = NULL;
				return FALSE;
			else:
				$_POST['submit'] = NULL;
				$this->session->set_userdata('msg','Отзыв добавлен');
				$this->feedbackmodel->insert_record($_POST);
				redirect($this->uri->uri_string());
			endif;
		endif;
		$this->load->view('admin_interface/feedback',array('pagevalue'=>$pagevalue));
	}
	
	function delete_feedback(){
		$statusval = array('status'=>FALSE,'message'=>'Ошибка при закрытии');
		$id = trim($this->input->post('id'));
		if(!$id) show_404();
		$success = $this->feedbackmodel->delete_record($id);
		if($success):
			$statusval['status'] = TRUE;
			$statusval['message'] = "Отзыв удален";
		endif;
		echo json_encode($statusval);
	}
	
	function login(){
		
		$backpage = $this->session->userdata('backpage');
		$pagevalue = array(
				'description'	=>	'',
				'author' 		=> 	'',
				'title'			=> 	"Аутентификация пользователя",
				'backpage' 		=> $backpage,
				'admin' 		=> FALSE,
				'baseurl' 		=> 	base_url()
			);
		$this->setmessage('','','',0);
		if (isset($_POST['password']) and isset($_POST['login'])){
			if (empty($_POST['password']) or empty($_POST['login'])){
				$msg = $this->setmessage('Поля "Логин" и "Пароль" не могут быть пустымы!','','Ошибка авторизации!',1);
				$this->load->view('admin_interface/login',array('pagevalue'=>$pagevalue,'login'=>'','msg'=>$msg));
				return FALSE;
			}
			$userinfo = $this->authentication->get_users_info($_POST['login']);
			if(empty($userinfo)){
				$text = 'Пользователь '.$_POST['login'].' не зарегистрирован в системе!';
				$msg = $this->setmessage($text,'','Ошибка авторизации!',1);
				
				$this->load->view('admin_interface/login',array('pagevalue'=>$pagevalue,'login'=>'','msg'=>$msg));
				return FALSE;
			}else{
				if ($userinfo['usr_password'] === md5($_POST['password'])){
					$session_data = array('logon' => '0ddd2cf5b8929fcbd721f2365099c6e3','login'=>$userinfo['usr_login']);
                   	$this->session->set_userdata($session_data);
                   	redirect($backpage);	
				}else{
					$msg = $this->setmessage('Введен не верный пароль.','','Ошибка авторизации!',1);
					$this->load->view('admin_interface/login',array('pagevalue'=>$pagevalue,'login'=>$_POST['login'],'msg'=>$msg));
					return FALSE;
				}
			}
			$this->load->view('admin_interface/login',array('pagevalue'=>$pagevalue,'login'=>'','msg'=>$this->message));
			return;
		}
		$msg = $this->setmessage('','','Введите логин и пароль для авторизации',1);
		
		$this->load->view('admin_interface/login',array('pagevalue'=>$pagevalue,'login'=>'','msg'=>$msg));
	}

	function logoff(){
	
		$backpage = $this->session->userdata('backpage');
		$this->session->unset_userdata('backpage');
    	$this->session->sess_destroy();
        redirect($backpage,'refresh');
    }				//функция завершения сеанса администрирования;
	
	function oldpass_check($pass){
			
			$login = $this->session->userdata('login');
			$userinfo = $this->authentication->get_users_info($login);
			
			if(md5($pass) == $userinfo['usr_password']):
				return TRUE;
			else:
				$this->form_validation->set_message('oldpass_check','Введен не верный пароль!');
				return FALSE;
			endif;
		}	//функция проверяет старый пароль перед изменением;
	
	function profile(){
		
		$backpage = $this->session->userdata('backpage');
		
		$pagevalue = array(
					'description' 	=> '',
					'author' 		=> '',
					'title' 		=> "Администрирование | Редактирование профиля",
					'backpage' 		=> $backpage,
					'admin' 		=> TRUE,
					'baseurl' 		=> base_url()
				);
		
		$msg = $this->setmessage('','','Форма изменения пароля администратора',1);
						
		if(isset($_POST['btsabmit'])){
			
			$this->form_validation->set_rules('oldpass','"Старый пароль"','required|callback_oldpass_check|trim');
			$this->form_validation->set_rules('newpass','"Новый пароль"','required|min_length[6]|matches[confirmpass]|trim');
			$this->form_validation->set_rules('confirmpass','"Подтверждение пароля"','required|trim');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			$this->form_validation->set_message('min_length', 'Минимальная длина пароля — 6 символов.');
			$this->form_validation->set_message('matches', 'Поля "Новый пароль" и "Подтверждение пароля" должны совпадать');
			
			if ($this->form_validation->run() == FALSE){
				
				$msg = $this->setmessage('Не выполнены условия.','','Ошибка при изменении профиля.',1);
				
				$login = $this->session->userdata('login');
				$userinfo = $this->authentication->get_users_info($login);
			
        		$this->load->view('admin_interface/profile',array('pagevalue'=>$pagevalue,'userinfo'=>$userinfo,'msg'=>$msg));
				return FALSE;
			}else{
				$_POST['pass_crypt'] = $this->encrypt->encode($_POST['newpass']);
				$this->authentication->changepassword($_POST);
				$this->session->set_flashdata('operation_saccessfull','Пароль администратора изменен.');
				redirect('profile');
				return TRUE;
			}
		}
		$login = $this->session->userdata('login');
		$userinfo = $this->authentication->get_users_info($login);
		
		$flashmsg = $this->session->flashdata('operation_saccessfull');
		if(isset($flashmsg) and !empty($flashmsg))
			$msg = $this->setmessage('','',$flashmsg,1);
		
        $this->load->view('admin_interface/profile',array('pagevalue'=>$pagevalue,'userinfo'=>$userinfo,'msg'=>$msg));
	}				//функция производит смену пароля администратора;
	
	function setmessage($error,$saccessfull,$message,$status){
			
			$this->message['error'] = $error;
			$this->message['saccessfull'] = $saccessfull;
			$this->message['message'] = $message;
			$this->message['status'] = $status;
			
			return $this->message;
		}		//установка сообщения;
	
	function uploadimage(){
			
		if(!isset($_POST['btsabmit']))
			show_404();
		
		if(!$_POST['imagetitle']){
				
			$this->session->set_flashdata('operation_error','Не указано описание');
			$this->session->set_flashdata('operation_message','Ошибка при загрузке фото');
			$this->session->set_flashdata('operation_saccessfull',' ');
			redirect($_POST['fulluri']);
		}
		if ($_FILES['userfile']['error'] == 0 && $_FILES['userfile']['size'] > 0){
			if(empty($_POST['imageheight']) or empty($_POST['imagewight'])):
				$wigimg = 200;
				$higimg = 170;
			else:
				$wigimg = $_POST['imagewight'];
				$higimg = $_POST['imageheight'];
			endif;
			
			if($_POST['imgtype'] != 'apartment' and $_POST['imgtype'] != 'commercial' and $_POST['imgtype'] != 'about'):
				$wight[0] = 640; $height[0] = 480;
				($wigimg > 640) ? $wight[1] = 640: $wight[1] = $wigimg; 
				($higimg > 480) ? $height[1] = 480: $height[1] = $higimg; 
			else:
				$wight[0] = 752; $height[0] = 336;
				($wigimg > 752) ? $wight[1] = 752: $wight[1] = $wigimg; 
				($higimg > 336) ? $height[1] = 336: $height[1] = $higimg;
				$wight[2] = 640; $height[2] = 480;
			endif;
			
			if($_POST['imgtype'] == 'apartment' || $_POST['imgtype'] == 'commercial'):
				$images = $this->imagesmodel->get_data($_POST['imgtype'],$_POST['object']);
				if(!count($images))
					$img['bigimages'] = $this->resize_slide_img($_FILES,$wight[0],$height[0],FALSE);
				else
					$img['bigimages'] = $this->resize_img($_FILES,$wight[2],$height[2],FALSE);
			else:
				$img['bigimages'] = $this->resize_img($_FILES,$wight[0],$height[0],FALSE);
			endif;
			$img['images'] 		= $this->resize_img($_FILES,$wight[1],$height[1],FALSE);
			$_POST['bigimages'] = $img['bigimages']['image'];
			$_POST['images'] 	= $img['images']['image'];
			$_POST['type'] 		= $_POST['imgtype'];
			$_POST['file'] 		= $_FILES['userfile']['name'];
	      	$this->imagesmodel->insert_record($_POST);
			$this->session->set_flashdata('operation_error',' ');
			$this->session->set_flashdata('operation_message','Имя загруженого файла - '.$_POST['file']);
			$this->session->set_flashdata('operation_saccessfull','Фотография загружена успешно');
		 	redirect($_POST['fulluri']);
		}else{			
			$this->session->set_flashdata('operation_error','Картинка не загружена!<p>Вы не выбрали картинку.</p>Повторите загрузку снова.</b>');
			$this->session->set_flashdata('operation_message','Ошибка при загрузке фото');
			$this->session->set_flashdata('operation_saccessfull',' ');
			redirect($_POST['fulluri']);
		}
	}		//функция добавляет рисунок в указанный объект;
	
	function imagedestroy(){
		
		if($this->uri->total_segments() == 4):
			$img_id = $this->uri->segment(3);
			$obj_id = $this->uri->segment(4);
			$backpath = $this->uri->segment(1).'/photo/manage/list/'.$obj_id;
		elseif($this->uri->total_segments() == 5):
			$img_id = $this->uri->segment(4);
			$obj_id = $this->uri->segment(5);
			$type_rent = $this->uri->segment(3);
			$backpath = $this->uri->segment(1).'/photo/manage/'.$type_rent.'/'.$obj_id;
		else:
			$img_id = $this->uri->segment(3);
			$backpath = $this->uri->segment(1).'/photo/manage';
		endif;
		$image = $this->imagesmodel->get_image($img_id);
		if($image and count($image)):			
			$this->imagesmodel->image_delete($img_id);
			redirect($backpath);
		else:
			show_404();
		endif;
	}		//функция удаляет рисунок с указанного объекта;

	function edittext(){
		
		$text_object = $this->uri->segment(2);
		if($text_object == 'rent'):
			if($this->uri->total_segments() == 3)
				$type_object = $this->uri->segment(3);
			else
				$type_object = $this->uri->segment(4);
		endif;
		$pagevalue = array(
					'description' 	=>'',
					'author' 		=> '',
					'title'			=> 'Редактирование текста',
					'baseurl' 		=> base_url(),
					'backpath' 		=> $text_object,
					'id' 			=> 0,
					'sidebar'		=> FALSE,
					'admin' 		=> TRUE
				);
		if(isset($type_object) and !empty($type_object))
			$pagevalue['backpath'] .= '/'.$type_object;
		if($this->uri->total_segments() >= 3){
			
			$text_sidebar = $this->uri->segment(3);
			if($text_sidebar == 'sidebar')
				$pagevalue['sidebar'] = TRUE;
		}
			
		$msg = $this->setmessage('','','',0);
		$text = array();
		
		switch($text_object){
			case 'index': 	$pagevalue['id'] = 8;
							$pagevalue['backpath'] = '';
							break;
			case 'about':	if($pagevalue['sidebar'])
								$pagevalue['id'] = 2;
							break;
			case 'about-top'    :	$pagevalue['id'] = 9;
									$pagevalue['backpath'] = 'about';
									break;
			case 'about-buttom' :	$pagevalue['id'] = 10;
									$pagevalue['backpath'] = 'about';
									break;
			case 'retail':	if($pagevalue['sidebar'])
								$pagevalue['id'] = 3;
							else
								$pagevalue['id'] = 1;
							break;
			case 'rent':	
							if($pagevalue['sidebar']){
								$type_rent = $this->uri->segment(4);
								if($type_rent == 'auto'):
									$pagevalue['id'] = 4;
								elseif($type_rent == 'retail'):
									$pagevalue['id'] = 5;
								else:
									$pagevalue['id'] = 11;
								endif;
							}else{
								$type_rent = $this->uri->segment(3);
								if($type_rent == 'auto'):
									$pagevalue['id'] = 2;
								elseif($type_rent == 'retail'):
									$pagevalue['id'] = 3;
								else:
									$pagevalue['id'] = 20;
								endif;
							}
							break;
			case 'tour':	if($pagevalue['sidebar'])
								$pagevalue['id'] = 6;
							else
								$pagevalue['id'] = 4;
							break;
			case 'transfers':if($pagevalue['sidebar'])
								$pagevalue['id'] = 7;
							else
								$pagevalue['id'] = 5;
							break;
			case 'service':if($pagevalue['sidebar'])
								$pagevalue['id'] = 8;
							else
								$pagevalue['id'] = 6;
							break;
			case 'contacts':if($pagevalue['sidebar'])
								$pagevalue['id'] = 9;
							else
								$pagevalue['id'] = 7;
							break;
			case 'ipoteka' :$type_ipoteka = $this->uri->segment(3);
							if($type_ipoteka == 'title')
								$pagevalue['id'] = 11;
							elseif($type_ipoteka == 'fiz')
								$pagevalue['id'] = 12;
							else
								$pagevalue['id'] = 13;
							break;
			case 'commercial':	if($pagevalue['sidebar']):
									$pagevalue['id'] = 10; //продажи сайдбар
								else:
									$pagevalue['id'] = 19; //продажи текст
								endif;
								break;
			default : 		show_404();
							break;
		}
		
		if($pagevalue['sidebar']){
			$quary = $this->sidebartextmodel->get_record($pagevalue['id']);
			$text['title'] = null;
			$text['extended'] = $quary['sbt_extended'];
			
		}else{
			$quary = $this->othertextmodel->get_record($pagevalue['id']);
			$text['title'] = $quary['txt_title'];
			$text['extended'] = $quary['txt_extended'];
			if($text_object == 'ipoteka' and isset($type_ipoteka)):
				if($type_ipoteka == 'title')
					$text['title'] = NULL;
			endif;
			$msg = $this->setmessage('','','Редактирование текста "'.$text['title'].'"',1);
			if($text_object == 'about-buttom'):
				$text['title'] = NULL;
				$msg = $this->setmessage('','','Редактирование текста',1);
			endif;
		}
		if(!count($text)) show_404();
		$this->load->view('admin_interface/edittext',array('pagevalue'=>$pagevalue,'text'=>$text,'msg'=>$msg));
	}			//функция выводит редактируемый текст;
	
	function updatetext(){
	
		if(isset($_POST['btsabmit'])):
		
			if($_POST['sidebar']):
				$this->sidebartextmodel->update_record($_POST);
			else:
				if(!isset($_POST['title']) or empty($_POST['title'])) $_POST['title'] = '';
				$this->othertextmodel->update_record($_POST);
			endif;
			redirect($_POST['backpath']);
		else:
			show_404();
		endif;
	}		//функция обновляет текст;

	function updateunit(){
	
		if(isset($_POST['btsabmit'])):
			if(!$_POST['auto']):				
				if($_POST['flag'] == 0)	$_POST['pricerent'] = '';
				if(!empty($_POST['newprice'])):
					$price = $_POST['price'];
					$_POST['price'] = $_POST['newprice'];
					$_POST['newprice'] = $price;
				endif;
				if($_POST['flag'] == 1):
					$_POST['price'] = '';
					$_POST['newprice'] = '';
				endif;
				$_POST['properties'] = '';
				if(!isset($_POST['sold'])) $_POST['sold'] = 0;
				if(!isset($_POST['recommended'])) $_POST['recommended'] = 0;
				if(!isset($_POST['special'])) $_POST['special'] = 0;
				$this->apartmentmodel->update_record($_POST);
			else:
				$this->rentautomodel->update_record($_POST);
			endif;
			redirect($_POST['backpath']);
		else:
			show_404();
		endif;
	}		//функция вобновляет информацию об объекте;
	
	function editunit(){
		
		$name_object = $this->uri->segment(2);
		$id_object = $this->uri->segment(3);
		$type = $this->uri->segment(4);
		$unitinfo = array();
		$msg = $this->setmessage('','','',0);
		
		$pagevalue = array(
					'description' 	=> '',
					'author' 		=> '',
					'title'			=> 'Редактирование информации',
					'baseurl' 		=> base_url(),
					'backpath' 		=> '',
					'unit' 			=> $name_object,
					'id' 			=> $id_object,
					'auto'			=> FALSE,
					'admin' 		=> TRUE
				);
		if($this->input->post('btsabmit')):
			if(!$_POST['auto']):				
				if($_POST['flag'] == 0)	$_POST['pricerent'] = '';
				if(!empty($_POST['newprice'])):
					$price = $_POST['price'];
					$_POST['price'] = $_POST['newprice'];
					$_POST['newprice'] = $price;
				endif;
				if($_POST['flag'] == 1):
					$_POST['price'] = '';
					$_POST['newprice'] = '';
				endif;
				$_POST['properties'] = '';
				if(!isset($_POST['sold'])) $_POST['sold'] = 0;
				if(!isset($_POST['recommended'])) $_POST['recommended'] = 0;
				if(!isset($_POST['special'])) $_POST['special'] = 0;
				$this->apartmentmodel->update_record($_POST);
				redirect($type.'/apartment/'.$id_object);
			else:
				$this->rentautomodel->update_record($_POST);
				redirect($type.'/auto/'.$id_object);
			endif;
		endif;
		switch($type){
			case 'retail': 		$query = $this->apartmentmodel->get_record($id_object);
								$pagevalue['auto'] = FALSE;
								$pagevalue['backpath'] = $type;
								$unitinfo['title'] 		= $query['apnt_title'];
								$unitinfo['extended'] 	= $query['apnt_extended'];
								$unitinfo['price1'] 	= $query['apnt_price'];
								$unitinfo['price2'] 	= $query['apnt_newprice'];
								if(!empty($unitinfo['price2'])):
									$unitinfo['price2'] 	= $query['apnt_price'];
									$unitinfo['price1'] 	= $query['apnt_newprice'];
								endif;
								$unitinfo['object'] 	= $query['apnt_object'];
								$unitinfo['location'] 	= $query['apnt_location'];
								$unitinfo['region'] 	= $query['apnt_region'];
								$unitinfo['flag'] 		= $query['apnt_flag'];
								$unitinfo['count'] 		= $query['apnt_count'];
								$unitinfo['pricerent'] 	= $query['apnt_price_rent'];
								$unitinfo['properties'] = $query['apnt_properties'];
								$unitinfo['date'] 		= $this->operation_date_slash($query['apnt_date']);
								$unitinfo['sold'] 		= $query['apnt_sold'];
								$unitinfo['recommended']= $query['apnt_recommended'];
								$unitinfo['special'] 	= $query['apnt_special'];
								break;
			case 'rent': 		if($name_object == 'auto'){
									$query = $this->rentautomodel->get_record($id_object);
									$pagevalue['auto'] 		= TRUE;
									$pagevalue['backpath'] 	= $type.'/'.$name_object;
									$unitinfo['title'] 		= $query['rnta_title'];
									$unitinfo['extended'] 	= $query['rnta_extended'];
									$unitinfo['object'] 	= null;
									$unitinfo['location'] 	= null;
									$unitinfo['region'] 	= null;
									$unitinfo['flag'] 		= null;
									$unitinfo['count'] 		= null;
									$unitinfo['sold'] 		= null;
									$unitinfo['recommended']= null;
									$unitinfo['special'] 	= null;
									$unitinfo['pricerent'] 	= $query['rnta_price'];
									$unitinfo['properties'] = $query['rnta_properties'];
								}elseif($name_object == 'apartment'){
									$query = $this->apartmentmodel->get_record($id_object);
									$pagevalue['auto'] = FALSE;
									$pagevalue['backpath'] 	= $type.'/retail';
									$unitinfo['title'] 		= $query['apnt_title'];
									$unitinfo['extended'] 	= $query['apnt_extended'];
									$unitinfo['price1'] 	= $query['apnt_price'];
									$unitinfo['price2'] 	= $query['apnt_newprice'];
									if(!empty($unitinfo['price2'])):
										$unitinfo['price2'] 	= $query['apnt_price'];
										$unitinfo['price1'] 	= $query['apnt_newprice'];
									endif;
									$unitinfo['object'] 	= $query['apnt_object'];
									$unitinfo['location'] 	= $query['apnt_location'];
									$unitinfo['region'] 	= $query['apnt_region'];
									$unitinfo['flag'] 		= $query['apnt_flag'];
									$unitinfo['count'] 		= $query['apnt_count'];
									$unitinfo['pricerent'] 	= $query['apnt_price_rent'];
									$unitinfo['properties'] = $query['apnt_properties'];
									$unitinfo['date'] 		= $this->operation_date_slash($query['apnt_date']);
									$unitinfo['sold'] 		= $query['apnt_sold'];
									$unitinfo['recommended']= $query['apnt_recommended'];
									$unitinfo['special'] 	= $query['apnt_special'];
								}else
									show_404();
								break;
			default : 			show_404();
								break;
		}
		if(!count($unitinfo)) show_404();
		$msg = $this->setmessage('','','Редактирование информации "'.$unitinfo['title'].'" ',1);
		$this->load->view('admin_interface/editunit',array('pagevalue'=>$pagevalue,'unitinfo'=>$unitinfo,'msg'=>$msg));
	}			//функция выводит информацию об объекте для редактирования;
	
	function insertunit(){
		
		$unit = $this->uri->segment(3);
		$type = $this->uri->segment(1);
		$name_unit = array('apartment' => 'Апартаменты','auto'=> 'Автомобили');
		$pagevalue = array(
					'description' 	=> '',
					'author' 		=> '',
					'title'			=> 'Добавление информации',
					'baseurl' 		=> base_url(),
					'backpath' 		=> $type,
					'unit' 			=> $unit,
					'auto'			=> FALSE,
					'admin' 		=> TRUE
				);
		$msg = $this->setmessage('','','',0);
		if($type == 'rent' and $unit == 'auto'):
			$pagevalue['auto'] = TRUE;
			$pagevalue['backpath'] .= '/auto';
		elseif($type == 'rent' and $unit == 'apartment'):
			$pagevalue['auto'] = FALSE;
			$pagevalue['backpath'] .= '/retail';
		endif;
		if($this->input->post('btsabmit')):
			$this->form_validation->set_rules('title','"Навание"','required|trim');
			$this->form_validation->set_rules('extended','"Раcширенная информация"','required|trim');
			if($_POST['type'] == 'apartment'):
				if(isset($_POST['flag'])):
					if($_POST['flag'] != 1):
						$this->form_validation->set_rules('price','"Цена без скидки"','required|numeric|trim');
						$this->form_validation->set_rules('newprice','"Новая цена"','numeric|trim');
					endif;
				endif;
				$this->form_validation->set_rules('object','"Объект"','required|trim');
				$this->form_validation->set_rules('location','"Местонахождение"','required|trim');
				$this->form_validation->set_rules('region','"Район"','required|trim');
				$this->form_validation->set_rules('count','"Количество комнат"','required|numeric|trim');
				$this->form_validation->set_rules('flag','"Тип"','required|trim');
				$this->form_validation->set_rules('sold',' ','');
				$this->form_validation->set_rules('recommended',' ','');
				$this->form_validation->set_rules('special',' ','');
			endif;
			$this->form_validation->set_rules('pricerent','"Цена за аренду"','');
			$this->form_validation->set_rules('properties','"Свойства"','');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if(!$this->form_validation->run()):
				$_POST['btsabmit'] = NULL;
				$this->insertunit();
				return FALSE;
			endif;
			switch($_POST['type']){
				case 'apartment' 	:	$_POST['properties'] = '';
										if(!empty($_POST['newprice'])):
											$price = $_POST['price'];
											$_POST['price'] = $_POST['newprice'];
											$_POST['newprice'] = $price;
										endif;
										if(!isset($_POST['sold'])) $_POST['sold'] = 0;
										if(!isset($_POST['recommended'])) $_POST['recommended'] = 0;
										if(!isset($_POST['special'])) $_POST['special'] = 0;
										$ret_id = $this->apartmentmodel->insert_record($_POST);
										if($_FILES['userfile']['error'] == 0 && $_FILES['userfile']['size'] > 0):
											$img['bigimages'] 	= $this->resize_slide_img($_FILES,752,336,FALSE);
											$img['images'] 		= $this->resize_img($_FILES,200,170,FALSE);
											$_POST['bigimages'] = $img['bigimages']['image'];
											$_POST['images'] 	= $img['images']['image'];
											$_POST['imagetitle']= $_POST['title'];
											$_POST['file'] 		= $_FILES['userfile']['name'];
											$_POST['object']	= $ret_id;
									      	$this->imagesmodel->insert_record($_POST);
										endif;
									 	break;
				case 'auto' 		:	$ret_id = $this->rentautomodel->insert_record($_POST);
									 	break;
				
				default				: 	show_404();
										break;	
			}
			redirect($type.'/'.$_POST['type'].'/'.$ret_id);
		endif;
		$msg = $this->setmessage('','','Добавление информации - "'.$name_unit[$unit].'" ',1);
		$this->load->view('admin_interface/insertunit',array('pagevalue'=>$pagevalue,'msg'=>$msg));
	}
	
	function inserttour($param = ''){
	
		$msg = $this->setmessage('','','',0);
		$type = $this->uri->segment(1);
		
		if(!empty($param)) $type = $param;
		
		$pagevalue = array(
					'description' 	=> '',
					'author' 		=> '',
					'title'			=> 'Добавление информации',
					'baseurl' 		=> base_url(),
					'backpath' 		=> $type,
					'admin' 		=> TRUE
				);
		$msg = $this->setmessage('','','Добавление информации - "Экскурсии"',1);
		$this->load->view('admin_interface/inserttour',array('pagevalue'=>$pagevalue,'msg'=>$msg));
	}		//функция выводит форму для вставки новой экскурсии;
	
	function insertunitvalue(){
		
		if($this->input->post('btsabmit')):
			$this->form_validation->set_rules('title','"Навание"','required|trim');
			$this->form_validation->set_rules('extended','"Раcширенная информация"','required|trim');
			if($_POST['type'] == 'apartment'):
				if(isset($_POST['flag'])):
					if($_POST['flag'] != 1):
						$this->form_validation->set_rules('price','"Цена без скидки"','required|numeric|trim');
						$this->form_validation->set_rules('newprice','"Новая цена"','numeric|trim');
					endif;
				endif;
				$this->form_validation->set_rules('object','"Объект"','required|trim');
				$this->form_validation->set_rules('location','"Местонахождение"','required|trim');
				$this->form_validation->set_rules('region','"Район"','required|trim');
				$this->form_validation->set_rules('count','"Количество комнат"','required|numeric|trim');
				$this->form_validation->set_rules('flag','"Тип"','required|trim');
				$this->form_validation->set_rules('sold',' ','');
				$this->form_validation->set_rules('recommended',' ','');
				$this->form_validation->set_rules('special',' ','');
			endif;
			$this->form_validation->set_rules('pricerent','"Цена за аренду"','');
			$this->form_validation->set_rules('properties','"Свойства"','');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			if (!$this->form_validation->run()):
				$_POST['btsabmit'] = NULL;
				$this->insertunit($_POST['backpath'],$_POST['type']);
				return FALSE;
			endif;
			switch($_POST['type']){
				case 'apartment' 	:	$_POST['properties'] = '';
										if(!empty($_POST['newprice'])):
											$price = $_POST['price'];
											$_POST['price'] = $_POST['newprice'];
											$_POST['newprice'] = $price;
										endif;
										if(!isset($_POST['sold'])) $_POST['sold'] = 0;
										if(!isset($_POST['recommended'])) $_POST['recommended'] = 0;
										if(!isset($_POST['special'])) $_POST['special'] = 0;
										$ret_id = $this->apartmentmodel->insert_record($_POST);
										if($_FILES['userfile']['error'] == 0 && $_FILES['userfile']['size'] > 0):
											$img['bigimages'] 	= $this->resize_slide_img($_FILES,752,336,FALSE);
											$img['images'] 		= $this->resize_img($_FILES,200,170,FALSE);
											$_POST['bigimages'] = $img['bigimages']['image'];
											$_POST['images'] 	= $img['images']['image'];
											$_POST['imagetitle']= $_POST['title'];
											$_POST['file'] 		= $_FILES['userfile']['name'];
											$_POST['object']	= $ret_id;
									      	$this->imagesmodel->insert_record($_POST);
										endif;
									 	break;
				case 'auto' 		:	$ret_id = $this->rentautomodel->insert_record($_POST);
									 	break;
				
				default				: 	show_404();
										break;	
			}
			redirect($_POST['backpath'].$ret_id);
		else:
			show_404();
		endif;
	}
	
	function inserttourvalue(){
		
		if(isset($_POST['btsabmit'])):
			
			$this->form_validation->set_rules('title','"Навание"','required|trim');
			$this->form_validation->set_rules('extended','"Раcширенная информация"','required|trim');

			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			
			if (!$this->form_validation->run()){
				$this->inserttour($_POST['backpath']);
				return FALSE;
			}
			$this->tourlistmodel->insert_record($_POST);
			redirect($_POST['backpath']);
		else:
			show_404();
		endif;
	}			//функция вставляет новую экскурсию;

	function deleteunit(){
		if($this->uri->total_segments() == 4):
			$backpath = $this->uri->segment(1);
			$id = $this->uri->segment(4);
			$type = $this->uri->segment(2);
			if($backpath == 'rent' and $type == 'auto'):
				$backpath .=  '/auto';
			elseif($backpath == 'rent' and $type == 'apartment'):
				$backpath .=  '/retail';
			endif;
		else:
			$backpath = $this->uri->segment(1);
			$id = $this->uri->segment(3);
			$type = $backpath;
		endif;
		switch($type){
			
				case 'apartment' 	:	$this->imagesmodel->image_type_delete($type,$id);
										$this->apartmentmodel->delete_record($id);
									 	break;
				case 'auto' 		:	$this->imagesmodel->image_type_delete($type,$id);
										$this->rentautomodel->delete_record($id);
									 	break;
				case 'tour' 		:	$this->imagesmodel->image_type_delete($type,$id);
										$this->tourlistmodel->delete_record($id);
									 	break;
				
				default				: 	show_404();
										break;	
			}
			redirect($backpath);
	}				//функция удаляет указанный объект;
	
	function operation_date_slash($field){
			
		$pattern = "/(\d+)(-)(\w+)(-)(\d+)/i";
		$replacement = "\$5/\$3/\$1"; 
		return preg_replace($pattern, $replacement,$field);
	}	//функция меняет внешний вид даты;
	
	function edittour(){
		
		$tour_id = $this->uri->segment(3);
		$tourinfo = array();
		$msg = $this->setmessage('','','',0);
		
		$pagevalue = array(
					'description' 	=> '',
					'author' 		=> '',
					'title'			=> 'Редактирование информации',
					'baseurl' 		=> base_url(),
					'backpath' 		=> 'tour',
					'id' 			=> $tour_id,
					'admin' 		=> TRUE
				);
				
		$tourinfo = $this->tourlistmodel->get_record($tour_id);
		if(!count($tourinfo)) show_404();
		
		$msg = $this->setmessage('','','Редактирование информации "'.$tourinfo['tour_title'].'" ',1);
		$this->load->view('admin_interface/edittour',array('pagevalue'=>$pagevalue,'tourinfo'=>$tourinfo,'msg'=>$msg));
	}					//функция выводит форму для редактировния экскурсии;

	function updatetour(){
		
		if(isset($_POST['btsabmit'])){
		
			$this->tourlistmodel->update_record($_POST);
			redirect($_POST['backpath']);
		}else
			show_404();
	}					//функция обновляет информацию об экскурсии;

	function photomanipulation(){
		
		$page = $this->uri->segment(1);
		$type_manipulation = $this->uri->segment(3);
		$obj_id = 0;
		$msg = $this->setmessage('','','',0);
		$image = array();
		$images = array();
		
		$pagevalue = array(
					'description' 	=>'',
					'author' 		=> '',
					'title' 		=> "Работа с Фотографиями",
					'baseurl' 		=> base_url(),
					'backpath' 		=> $page,
					'imgtype'		=> $page,
					'page'			=> $page,
					'type' 			=> $type_manipulation,
					'multi' 		=> FALSE,
					'object'		=> $obj_id,
					'admin' 		=> TRUE,
					'script'		=> 'photochange',
					'fulluri'		=> $this->uri->uri_string()
				);
		
		if($this->uri->total_segments() == 4){			
			$img_id = $this->uri->segment(4);
			$image = $this->imagesmodel->get_image($img_id);
			$msg = $this->setmessage('','','Замена фото "'.$image['img_title'].'"',1);
			if($page == 'transfers') $pagevalue['backpath'] = 'transfers/photo/manage';
			if($page == 'about') $pagevalue['backpath'] = 'about/photo/manage';
			if($page == 'service') $pagevalue['backpath'] = 'service/photo/manage';			
		}elseif($this->uri->total_segments() == 5 and $type_manipulation == 'manage'){
			$obj_id = $this->uri->segment(5);
			if($page == 'retail'):
				$page = 'apartment'; $pagevalue['imgtype'] = $page;
			endif;
			if($page == 'rent'):
				$page = $this->uri->segment(4);
				$pagevalue['imgtype'] = $page;
				if($page == 'auto')
					$pagevalue['backpath'] .= '/auto'; 
				elseif($page == 'apartment')
					$pagevalue['backpath'] .= '/retail';
				else
					$pagevalue['backpath'] .= '/commercial';
			endif;
			$images = $this->imagesmodel->get_data($page,$obj_id);
			$msg = $this->setmessage('','','Добавление/Удаление фотографий',1);
			$pagevalue['multi'] = TRUE;
			$pagevalue['script'] = 'uploadimage';
			$pagevalue['object'] = $obj_id;
			
		}elseif($this->uri->total_segments() == 5 and $type_manipulation == 'change'){
			$obj_id = $this->uri->segment(5);
			$pagevalue['object'] = $obj_id;
			$img_id = $this->uri->segment(4);
			$image = $this->imagesmodel->get_image($img_id);
			$msg = $this->setmessage('','','Замена фото "'.$image['img_title'].'"',1);
			$pagevalue['backpath'] = $page.'/photo/manage/list/'.$obj_id;
			if($page == 'retail'):
				$page = 'apartment'; $pagevalue['imgtype'] = $page;
			endif;
			if($page == 'rent'):
				$pagevalue['backpath'] = $page.'/photo/manage/';
				$page = $this->uri->segment(4);
				$pagevalue['imgtype'] = $page;					
				$pagevalue['backpath'] .= $page.'/'.$obj_id;
			endif;
		}elseif($this->uri->total_segments() == 6 and $type_manipulation == 'change'){
			$obj_id = $this->uri->segment(6);
			$pagevalue['object'] = $obj_id;
			$img_id = $this->uri->segment(5);
			$type_img = $this->uri->segment(4);
			$image = $this->imagesmodel->get_image($img_id);
			$msg = $this->setmessage('','','Замена фото "'.$image['img_title'].'"',1);
			$pagevalue['backpath'] = $page.'/photo/manage/'.$type_img.'/'.$obj_id;
			$pagevalue['imgtype'] = $type_img;					
		}else{
			$images = $this->imagesmodel->get_type_data($page);
			$msg = $this->setmessage('','','Добавление/Удаление фотографий',1);
			$pagevalue['multi'] = TRUE;
			$pagevalue['script'] = 'uploadimage';
		};
			
		$flasherr = $this->session->flashdata('operation_error');
		$flashmsg = $this->session->flashdata('operation_message');
		$flashsaf = $this->session->flashdata('operation_saccessfull');
		if($flasherr && $flashmsg && $flashsaf){
			$msg = $this->setmessage($flasherr,$flashsaf,$flashmsg,1);
		}
		
		$this->load->view('admin_interface/imagesmanipulation',array('pagevalue'=>$pagevalue,'image'=>$image,'images'=>$images,'msg'=>$msg));
	}			//функция выводит форму для замены фотографии;
	
	function imagesaving(){

		if(isset($_POST['btsabmit'])){
			
			if(!$_POST['imagetitle']){
				
				$this->session->set_flashdata('operation_error','Не указано описание');
				$this->session->set_flashdata('operation_message','Ошибка при загрузке фото');
				$this->session->set_flashdata('operation_saccessfull',' ');
				redirect($_POST['fulluri']);
			}
			
			if (!ctype_digit($_POST['imagewight']) or !ctype_digit($_POST['imageheight'])){
				
				$this->session->set_flashdata('operation_error','Ширина и высота должны быть целыми числами');
				$this->session->set_flashdata('operation_message','Ошибка при загрузке фото');
				$this->session->set_flashdata('operation_saccessfull',' ');
				redirect($_POST['fulluri']);
			}
			
			if ($_FILES['userfile']['error'] == 0 && $_FILES['userfile']['size'] > 0){
				
				if(empty($_POST['imageheight']) or empty($_POST['imagewight'])):
					$wigth = 200;
					$height = 170;
				else:
					$wigth = $_POST['imagewight'];
					$height = $_POST['imageheight'];
					if($wigth > 640) $wigth = 640;
					if($height > 480) $height = 480; 	
				endif;
				
				if($_POST['imgtype'] == 'apartment' || $_POST['imgtype'] == 'commercial'):
					$image = $this->imagesmodel->get_type_ones_image($_POST['imgtype'],$_POST['object']);
					if($_POST['id'] === $image['img_id'])
						$bigimage = $this->resize_slide_img($_FILES,752,336,FALSE);
					else
						$bigimage = $this->resize_img($_FILES,640,480,FALSE);
				elseif($_POST['imgtype'] == 'about'):
					$image = $this->imagesmodel->get_type_ones_image($_POST['imgtype'],$_POST['object']);
					if($_POST['id'] != $image['img_id']):
						$bigimage = $this->resize_slide_img($_FILES,752,336,FALSE);
					else:
						$bigimage = $this->resize_img($_FILES,640,480,FALSE);
					endif;
				else:
					$bigimage = $this->resize_img($_FILES,640,480,FALSE);
				endif;
				$image = $this->resize_img($_FILES,$wigth,$height,FALSE);
				if(!count($image)){
					$this->session->set_flashdata('operation_error','Невозможно изменить размер');
					$this->session->set_flashdata('operation_message','Ошибка при загрузке фото');
					$this->session->set_flashdata('operation_saccessfull',' ');
					redirect($_POST['fulluri']);
				}
				$_POST['file'] 		= $image['filename'];
				$_POST['type'] 		= $_POST['imgtype'];
				$_POST['bigimages'] = $bigimage['image'];
				$_POST['images'] 	= $image['image'];
				$this->imagesmodel->update_record($_POST);
				redirect($_POST['backpath']);
			}else{
				$this->session->set_flashdata('operation_error','Картинка не загружена!<p>Вы не выбрали картинку.</p>Повторите загрузку снова.</b>');
				$this->session->set_flashdata('operation_message','Ошибка при загрузке фото');
				$this->session->set_flashdata('operation_saccessfull',' ');
				redirect($_POST['fulluri']);
			}
		}else
			show_404();
	}					//функция производит замену фотографии;
	
	function resize_img($image,$wgt,$hgt,$ratio){
			
		$img['filename'] = $image['userfile']['name'];
		$tmpName  = $image['userfile']['tmp_name'];
		$fileSize = $image['userfile']['size'];
		
		if(!$this->case_image($tmpName)):
			$this->session->set_flashdata('operation_error','Картинка не загружена!<p>Формат картинки не поддерживается.</p><b>Проверьте формат и повторите загрузку снова.</b>');
			$this->session->set_flashdata('operation_message','Ошибка при загрузке фото');
			$this->session->set_flashdata('operation_saccessfull',' ');
			redirect($_POST['fulluri']);
		endif;
		if($fileSize > 10485760):
			$this->session->set_flashdata('operation_error','Картинка не загружена!<p>Размер картинки более 10 Мб.</p><b>Проверьте формат и повторите загрузку снова.</b>');
			$this->session->set_flashdata('operation_message','Ошибка при загрузке фото');
			$this->session->set_flashdata('operation_saccessfull',' ');
			redirect($_POST['fulluri']);
		endif;
		chmod($tmpName, 0777);
		$this->resize_image($tmpName,$wgt,$hgt,$ratio);
		$file = fopen($tmpName,'rb');
		$img['image'] = fread($file,filesize($tmpName));
		fclose($file);
		return $img;
	}	//функция меняет размер фотографии;
	
	function case_image($file){
			
		$info = getimagesize($file);
		switch ($info[2]):
			case 1	: return TRUE;
			case 2	: return TRUE;
			case 3	: return TRUE;
			default	: return FALSE;	
		endswitch;
	}			//функция проверяет, является файл - картинкой;
	 
	function resize_slide_img($picture,$wgt,$hgt,$ratio){
	
		$image['filename'] 	= $picture['userfile']['name'];
		$tmpName  			= $picture['userfile']['tmp_name'];
		$fileSize 			= $picture['userfile']['size'];
		
		if(!$this->case_image($tmpName)):
			$this->session->set_flashdata('operation_error','Картинка не загружена!<p>Формат картинки не поддерживается.</p><b>Проверьте формат и повторите загрузку снова.</b>');
			$this->session->set_flashdata('operation_message','Ошибка при загрузке фото');
			$this->session->set_flashdata('operation_saccessfull',' ');
			redirect($_POST['fulluri']);
		endif;
		if($fileSize > 10485760):
			$this->session->set_flashdata('operation_error','Картинка не загружена!<p>Размер картинки более 10 Мб.</p><b>Проверьте формат и повторите загрузку снова.</b>');
			$this->session->set_flashdata('operation_message','Ошибка при загрузке фото');
			$this->session->set_flashdata('operation_saccessfull',' ');
			redirect($_POST['fulluri']);
		endif;
		chmod($tmpName, 0777);
		$img = getimagesize($tmpName);		
		$size_x = $img[0];
		$size_y = $img[1];
		
		$wight = $wgt;
		$height = $hgt; 
		
		if($size_x < $size_y):
			$this->resize_image($tmpName,$wgt,$hgt,FALSE);
			$file = fopen($tmpName,'rb');
			$image['image'] = fread($file,filesize($tmpName));
			fclose($file);
			return $image;
		endif;
		
		$this->resize_image($tmpName,$wgt,round($hgt*1.40),TRUE);
		$img = getimagesize($tmpName);		
		$size_x = $img[0];
		$size_y = $img[1];
		
		if($size_x < $wgt):				
			$this->resize_image($tmpName,$wgt,$size_y,FALSE);
			$img = getimagesize($tmpName);		
			$size_x = $img[0];
			$size_y = $img[1];
		elseif($size_y < $hgt):
			$this->resize_image($image,$wgt,$hgt,FALSE);
			$img = getimagesize($tmpName);		
			$size_x = $img[0];
			$size_y = $img[1];
		endif;
		
		switch ($img[2]){
			case 1: $image_src = imagecreatefromgif($tmpName); break;
			case 2: $image_src = imagecreatefromjpeg($tmpName); break;
			case 3:	$image_src = imagecreatefrompng($tmpName); break;
			default: return FALSE;	
		}
		
		$x = round(($size_x/2)-($wgt/2));
		$y = round(($size_y/2)-($hgt/2));
		
		if($x < 0 ):
			$x =0;	$wight = $size_x;
		endif;
		if($y < 0 ):
			$y =0; $height = $size_y;
		endif;
		
		$image_dst = ImageCreateTrueColor($wight,$height);
		imageCopy($image_dst,$image_src,0,0,$x,$y,$wgt,$hgt);
		imagePNG($image_dst,$tmpName);
		imagedestroy($image_dst);
		imagedestroy($image_src);
		
		$file = fopen($tmpName,'rb');
		$image['image'] = fread($file,filesize($tmpName));
		fclose($file);
		/*header('Content-Type: image/jpeg' );
		echo $image['image'];
		exit();*/
		return $image;
	}
		
	function resize_image($image,$wgt,$hgt,$ratio){
			
		$this->image_lib->clear();
		$config['image_library'] = 'gd2';
		$config['source_image']	= $image; 
		$config['create_thumb'] = FALSE;
		$config['maintain_ratio'] = $ratio;
		$config['width'] = $wgt;
		$config['height'] = $hgt;
				
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
	}

	function insertcommercial(){

		$pagevalue = array(
					'description' 	=> '',
					'author' 		=> '',
					'title'			=> 'Добавление информации',
					'baseurl' 		=> base_url(),
					'backpath' 		=> $this->session->userdata('backpage'),
					'admin' 		=> TRUE
				);
		
		if($this->input->post('btsabmit')):
			$this->form_validation->set_rules('title','"Навание"','required|trim');
			$this->form_validation->set_rules('extended','"Раcширенная информация"','required|trim');
			$this->form_validation->set_rules('price','"Цена без скидки"','required|numeric|trim');
			$this->form_validation->set_rules('newprice','"Новая цена"','numeric|trim');
			$this->form_validation->set_rules('object','"Объект"','required|trim');
			$this->form_validation->set_rules('location','"Местонахождение"','required|trim');
			$this->form_validation->set_rules('region','"Район"','required|trim');
			$this->form_validation->set_rules('count','"Количество комнат"','required|numeric|trim');
			$this->form_validation->set_rules('flag','"Тип"','required|trim');
			$this->form_validation->set_rules('pricerent','"Цена за аренду"','');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			$this->form_validation->set_rules('sold',' ','');
			$this->form_validation->set_rules('recommended',' ','');
			$this->form_validation->set_rules('special',' ','');
			if (!$this->form_validation->run()):
				$_POST['btsabmit'] = NULL;
				$this->insertcommercial();
				return FALSE;
			endif;
			$_POST['properties'] = '';
			if(!empty($_POST['newprice'])):
				$price = $_POST['price'];
				$_POST['price'] = $_POST['newprice'];
				$_POST['newprice'] = $price;
			endif;
			if(!isset($_POST['sold'])) $_POST['sold'] = 0;
			if(!isset($_POST['recommended'])) $_POST['recommended'] = 0;
			if(!isset($_POST['special'])) $_POST['special'] = 0;
			$ret_id = $this->apartmentmodel->insert_record($_POST);
			if ($_FILES['userfile']['error'] == 0 && $_FILES['userfile']['size'] > 0):
				$img['bigimages'] 	= $this->resize_slide_img($_FILES,752,336,FALSE);
				$img['images'] 		= $this->resize_img($_FILES,200,170,FALSE);
				$_POST['bigimages'] = $img['bigimages']['image'];
				$_POST['images'] 	= $img['images']['image'];
				$_POST['imagetitle']= $_POST['title'];
				$_POST['file'] 		= $_FILES['userfile']['name'];
				$_POST['type']		= 'commercial';
				$_POST['object']	= $ret_id;
		      	$this->imagesmodel->insert_record($_POST);
			endif;
			redirect($this->uri->segment(3).'/'.$this->uri->segment(1).'/extended/'.$ret_id);
		endif;
		$msg = $this->setmessage('','','Добавление информации - "Коммерческая недвижимость" ',1);
		$this->load->view('admin_interface/insertcommercial',array('pagevalue'=>$pagevalue,'msg'=>$msg));
	}
	
	function insertcommercialvalue(){
		
		if(isset($_POST['btsabmit'])):
			$this->form_validation->set_rules('title','"Навание"','required|trim');
			$this->form_validation->set_rules('extended','"Раcширенная информация"','required|trim');
			$this->form_validation->set_rules('price','"Цена без скидки"','required|numeric|trim');
			$this->form_validation->set_rules('newprice','"Новая цена"','numeric|trim');
			$this->form_validation->set_rules('object','"Объект"','required|trim');
			$this->form_validation->set_rules('location','"Местонахождение"','required|trim');
			$this->form_validation->set_rules('region','"Район"','required|trim');
			$this->form_validation->set_rules('count','"Количество комнат"','required|numeric|trim');
			$this->form_validation->set_rules('flag','"Тип"','required|trim');
			$this->form_validation->set_rules('pricerent','"Цена за аренду"','');
			$this->form_validation->set_error_delimiters('<div class="message">','</div>');
			$this->form_validation->set_rules('sold',' ','');
			$this->form_validation->set_rules('recommended',' ','');
			$this->form_validation->set_rules('special',' ','');
			if(!$this->form_validation->run()):
				$this->insertcommercial();
				return FALSE;
			endif;
			$_POST['properties'] = '';
			if(!empty($_POST['newprice'])):
				$price = $_POST['price'];
				$_POST['price'] = $_POST['newprice'];
				$_POST['newprice'] = $price;
			endif;
			if(!isset($_POST['sold'])) $_POST['sold'] = 0;
			if(!isset($_POST['recommended'])) $_POST['recommended'] = 0;
			if(!isset($_POST['special'])) $_POST['special'] = 0;
			$ret_id = $this->apartmentmodel->insert_record($_POST);
			if ($_FILES['userfile']['error'] == 0 && $_FILES['userfile']['size'] > 0):
				$img['bigimages'] 	= $this->resize_slide_img($_FILES,752,336,FALSE);
				$img['images'] 		= $this->resize_img($_FILES,200,170,FALSE);
				$_POST['bigimages'] = $img['bigimages']['image'];
				$_POST['images'] 	= $img['images']['image'];
				$_POST['imagetitle']= $_POST['title'];
				$_POST['file'] 		= $_FILES['userfile']['name'];
				$_POST['type']		= 'commercial';
				$_POST['object']	= $ret_id;
		      	$this->imagesmodel->insert_record($_POST);
			endif;
			redirect($_POST['backpath'].$ret_id);
		else:
			show_404();
		endif;
	}
	
	function editrentcommercial(){
		
		$id_object = $this->uri->segment(3);
		$type = $this->uri->segment(4);
		$unitinfo = array();
		$msg = $this->setmessage('','','',0);
		
		$pagevalue = array(
					'description' 	=> '',
					'author' 		=> '',
					'title'			=> 'Редактирование информации',
					'baseurl' 		=> base_url(),
					'backpath' 		=> $this->session->userdata('backpage'),
					'unit' 			=> 'commercial',
					'id' 			=> $id_object,
					'auto'			=> FALSE,
					'admin' 		=> TRUE
				);
		if($this->input->post('btsabmit')):
			if($_POST['flag'] == 0)	$_POST['pricerent'] = '';
			if(!empty($_POST['newprice'])):
				$price = $_POST['price'];
				$_POST['price'] = $_POST['newprice'];
				$_POST['newprice'] = $price;
			endif;
			if($_POST['flag'] == 1):
				$_POST['price'] = '';
				$_POST['newprice'] = '';
			endif;
			$_POST['properties'] = '';
			if(!isset($_POST['sold'])) $_POST['sold'] = 0;
			if(!isset($_POST['recommended'])) $_POST['recommended'] = 0;
			if(!isset($_POST['special'])) $_POST['special'] = 0;
			$this->apartmentmodel->update_record($_POST);
			redirect($this->uri->segment(4).'/'.$this->uri->segment(2).'/extended/'.$id_object);
		endif;
		switch($type){
			case 'retail': 		$query = $this->apartmentmodel->get_record($id_object);
								$unitinfo['title'] 		= $query['apnt_title'];
								$unitinfo['extended'] 	= $query['apnt_extended'];
								$unitinfo['price1'] 	= $query['apnt_price'];
								$unitinfo['price2'] 	= $query['apnt_newprice'];
								if(!empty($unitinfo['price2'])):
									$unitinfo['price2'] 	= $query['apnt_price'];
									$unitinfo['price1'] 	= $query['apnt_newprice'];
								endif;
								$unitinfo['object'] 	= $query['apnt_object'];
								$unitinfo['location'] 	= $query['apnt_location'];
								$unitinfo['region'] 	= $query['apnt_region'];
								$unitinfo['flag'] 		= $query['apnt_flag']-3;
								$unitinfo['count'] 		= $query['apnt_count'];
								$unitinfo['pricerent'] 	= $query['apnt_price_rent'];
								$unitinfo['properties'] = $query['apnt_properties'];
								$unitinfo['date'] 		= $this->operation_date_slash($query['apnt_date']);
								$unitinfo['sold'] 		= $query['apnt_sold'];
								$unitinfo['recommended']= $query['apnt_recommended'];
								$unitinfo['special'] 	= $query['apnt_special'];
								break;
			case 'rent': 		$query = $this->apartmentmodel->get_record($id_object);
								$pagevalue['auto'] = FALSE;
								$unitinfo['title'] 		= $query['apnt_title'];
								$unitinfo['extended'] 	= $query['apnt_extended'];
								$unitinfo['price1'] 	= $query['apnt_price'];
								$unitinfo['price2'] 	= $query['apnt_newprice'];
								if(!empty($unitinfo['price2'])):
									$unitinfo['price2'] 	= $query['apnt_price'];
									$unitinfo['price1'] 	= $query['apnt_newprice'];
								endif;
								$unitinfo['object'] 	= $query['apnt_object'];
								$unitinfo['location'] 	= $query['apnt_location'];
								$unitinfo['region'] 	= $query['apnt_region'];
								$unitinfo['flag'] 		= $query['apnt_flag']-3;
								$unitinfo['count'] 		= $query['apnt_count'];
								$unitinfo['pricerent'] 	= $query['apnt_price_rent'];
								$unitinfo['properties'] = $query['apnt_properties'];
								$unitinfo['date'] 		= $this->operation_date_slash($query['apnt_date']);
								$unitinfo['sold'] 		= $query['apnt_sold'];
								$unitinfo['recommended']= $query['apnt_recommended'];
								$unitinfo['special'] 	= $query['apnt_special'];
								break;
			default : 			show_404();
								break;
		}
		if(!count($unitinfo)) show_404();
		$msg = $this->setmessage('','','Редактирование информации "'.$unitinfo['title'].'" ',1);
		$this->load->view('admin_interface/editcommercial',array('pagevalue'=>$pagevalue,'unitinfo'=>$unitinfo,'msg'=>$msg));
	}
	
	function updatecommercial(){
		
		if(isset($_POST['btsabmit'])):
			if($_POST['flag'] == 0)	$_POST['pricerent'] = '';
			if(!empty($_POST['newprice'])):
				$price = $_POST['price'];
				$_POST['price'] = $_POST['newprice'];
				$_POST['newprice'] = $price;
			endif;
			if($_POST['flag'] == 1):
				$_POST['price'] = '';
				$_POST['newprice'] = '';
			endif;
			$_POST['properties'] = '';
			if(!isset($_POST['sold'])) $_POST['sold'] = 0;
			if(!isset($_POST['recommended'])) $_POST['recommended'] = 0;
			if(!isset($_POST['special'])) $_POST['special'] = 0;
			$this->apartmentmodel->update_record($_POST);
			redirect($_POST['backpath']);
		else:
			show_404();
		endif;
	}

	function deletecommercial(){
		
		$backpath = $this->session->userdata('backpage');
		$id = $this->uri->segment(4);
		$type = $this->uri->segment(2);
		$this->imagesmodel->image_type_delete($type,$id);
		$this->apartmentmodel->delete_record($id);
		redirect($backpath);
	}
}
?>