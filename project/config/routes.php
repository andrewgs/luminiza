<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "users_interface";
$route['scaffolding_trigger'] = "";

		/***********************************	USERS INTRERFACE	***********************************************/

$route['index'] 						= "users_interface/index";
$route['about'] 						= "users_interface/about";
$route['retail'] 						= "users_interface/retail";
$route['retail/:num'] 					= "users_interface/retail";
$route['retail/apartment/:num'] 		= "users_interface/retail_extended";

$route['commercial']					= "users_interface/commercial";
$route['commercial/:num']				= "users_interface/commercial";
$route['retail/commercial/extended/:num'] = "users_interface/commercial_extended";

$route['rent/retail'] 					= "users_interface/rent";
$route['rent/retail/:num'] 				= "users_interface/rent";
$route['rent/auto'] 					= "users_interface/rent";
$route['rent/auto/:num'] 				= "users_interface/rent_extended";
$route['rent/apartment/:num'] 			= "users_interface/rent_extended";

$route['rent/commercial']				= "users_interface/rent_commercial";
$route['rent/commercial/:num']			= "users_interface/rent_commercial";
$route['rent/commercial/extended/:num']	= "users_interface/rent_commercial_extended";

$route['tour'] 							= "users_interface/tour";
$route['tour/extended/:num']			= "users_interface/tour_extended";
$route['transfers'] 					= "users_interface/transfers";
$route['service'] 						= "users_interface/service";
$route['contacts'] 						= "users_interface/contacts";
$route['search'] 						= "users_interface/search";
$route['search/:num'] 					= "users_interface/search";
$route['viewimage/:num'] 				= "users_interface/viewimage";
$route['viewslideshow/:num'] 			= "users_interface/viewslideshow";
$route['mailsend'] 						= "users_interface/mailsending";
$route['ipoteka'] 						= "users_interface/ipoteka";
$route['ipoteka/([0-9]+)\.([0-9]+)'] 	= "users_interface/ipoteka";
$route['ipoteka/:num'] 					= "users_interface/ipoteka";

		/************************************	ADMIN INTRERFACE	***********************************************/

$route['admin'] = "admin_interface/login";
$route[':any/admin'] = "admin_interface/login";
$route['profile'] = "admin_interface/profile";
$route['login'] = "admin_interface/login";
$route[':any/login'] = "admin_interface/login";
$route['logoff'] = "admin_interface/logoff";

$route['about/photo/change/:num'] = "admin_interface/photomanipulation";
$route['contacts/photo/change/:num'] = "admin_interface/photomanipulation";
$route['transfers/photo/change/:num'] = "admin_interface/photomanipulation";
$route['service/photo/change/:num'] = "admin_interface/photomanipulation";
$route['tour/photo/change/:num'] = "admin_interface/photomanipulation";
$route['tour/photo/change/:num/:num'] = "admin_interface/photomanipulation";
$route['retail/photo/change/:num/:num'] = "admin_interface/photomanipulation";
$route['commercial/photo/change/:num/:num'] = "admin_interface/photomanipulation";
$route['rent/photo/change/auto/:num/:num'] = "admin_interface/photomanipulation";
$route['rent/photo/change/apartment/:num/:num'] = "admin_interface/photomanipulation";
$route['rent/photo/change/commercial/:num/:num'] = "admin_interface/photomanipulation";

$route['transfers/photo/manage'] = "admin_interface/photomanipulation";
$route['service/photo/manage'] = "admin_interface/photomanipulation";
$route['about/photo/manage'] = "admin_interface/photomanipulation";
$route['tour/photo/manage/list/:num'] = "admin_interface/photomanipulation";
$route['retail/photo/manage/list/:num'] = "admin_interface/photomanipulation";

$route['commercial/photo/manage/list/:num'] = "admin_interface/photomanipulation";

$route['rent/photo/manage/auto/:num'] = "admin_interface/photomanipulation";
$route['rent/photo/manage/apartment/:num'] = "admin_interface/photomanipulation";
$route['rent/photo/manage/commercial/:num'] = "admin_interface/photomanipulation";

$route['photochange'] = "admin_interface/imagesaving";
$route['transfers/imagedelete/:num'] = "admin_interface/imagedestroy";
$route['about/imagedelete/:num'] = "admin_interface/imagedestroy";
$route['service/imagedelete/:num'] = "admin_interface/imagedestroy";
$route['tour/imagedelete/:num/:num'] = "admin_interface/imagedestroy";
$route['retail/imagedelete/:num/:num'] = "admin_interface/imagedestroy";
$route['commercial/imagedelete/:num/:num'] = "admin_interface/imagedestroy";
$route['rent/imagedelete/auto/:num/:num'] = "admin_interface/imagedestroy";
$route['rent/imagedelete/apartment/:num/:num'] = "admin_interface/imagedestroy";
$route['rent/imagedelete/commercial/:num/:num'] = "admin_interface/imagedestroy";
$route['uploadimage'] = "admin_interface/uploadimage";
$route['imagesave/:num'] = "admin_interface/imagesaving";

$route['edit/index'] = "admin_interface/edittext";
$route['edit/about-top'] = "admin_interface/edittext";
$route['edit/about-buttom'] = "admin_interface/edittext";

$route['edit/ipoteka/title'] = "admin_interface/edittext";
$route['edit/ipoteka/fiz'] = "admin_interface/edittext";
$route['edit/ipoteka/ur'] = "admin_interface/edittext";

$route['edit/retail'] = "admin_interface/edittext";
$route['edit/tour'] = "admin_interface/edittext";
$route['edit/commercial'] = "admin_interface/edittext";
$route['edit/transfers'] = "admin_interface/edittext";
$route['edit/service'] = "admin_interface/edittext";
$route['edit/contacts'] = "admin_interface/edittext";
$route['edit/about/sidebar'] = "admin_interface/edittext";
$route['edit/commercial/sidebar'] = "admin_interface/edittext";
$route['edit/retail/sidebar'] = "admin_interface/edittext";
$route['edit/rent/sidebar/auto'] = "admin_interface/edittext";
$route['edit/rent/sidebar/retail'] = "admin_interface/edittext";

$route['edit/rent/sidebar/commercial'] = "admin_interface/edittext";

$route['edit/tour/sidebar'] = "admin_interface/edittext";
$route['edit/transfers/sidebar'] = "admin_interface/edittext";
$route['edit/service/sidebar'] = "admin_interface/edittext";
$route['edit/contacts/sidebar'] = "admin_interface/edittext";
$route['edit/rent/auto'] = "admin_interface/edittext";
$route['edit/rent/retail'] = "admin_interface/edittext";
$route['edit/rent/commercial'] = "admin_interface/edittext";
$route['updatetext'] = "admin_interface/updatetext";
$route['updateunit'] = "admin_interface/updateunit";
$route['updatecommercial'] = "admin_interface/updatecommercial";
$route['updatetour'] = "admin_interface/updatetour";
$route['edit/apartment/:num/retail'] = "admin_interface/editunit";
$route['edit/apartment/:num/rent'] = "admin_interface/editunit";
$route['edit/commercial/:num/rent'] = "admin_interface/editrentcommercial";
$route['edit/auto/:num/rent'] = "admin_interface/editunit";
$route['edit/tour/:num'] = "admin_interface/edittour";

$route['edit/commercial/:num/rent'] = "admin_interface/editrentcommercial";
$route['edit/commercial/:num/retail'] = "admin_interface/editrentcommercial";

$route['retail/apartment/delete/:num'] = "admin_interface/deleteunit";
$route['retail/commercial/delete/:num'] = "admin_interface/deletecommercial";
$route['rent/apartment/delete/:num'] = "admin_interface/deleteunit";
$route['rent/commercial/delete/:num'] = "admin_interface/deletecommercial";
$route['rent/auto/delete/:num'] = "admin_interface/deleteunit";
$route['tour/delete/:num'] = "admin_interface/deleteunit";

$route['retail/insert/apartment'] = "admin_interface/insertunit";

$route['commercial/insert/retail'] = "admin_interface/insertcommercial";

$route['rent/insert/apartment'] = "admin_interface/insertunit";
$route['commercial/insert/rent'] = "admin_interface/insertcommercial";
$route['rent/insert/auto'] = "admin_interface/insertunit";
$route['tour/insert'] = "admin_interface/inserttour";
$route['insertvalue'] = "admin_interface/insertunitvalue";
$route['insertcommercialvalue'] = "admin_interface/insertcommercialvalue";
$route['inserttour'] = "admin_interface/inserttourvalue";