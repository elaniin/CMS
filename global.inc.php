<?php  
/*
	Global.inc
*/
if (file_exists('config.php')) {
	require_once 'config.php'; 
	require_once 'version.php'; 
}else{
	header("Location: installation");
	exit();
}
date_default_timezone_set(TIMEZONE);
if (FORCE_HTTPS == 1) {
	if($_SERVER["HTTPS"] != "on")
	{
	    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
	    exit();
	}
}

//classes needed
require_once 'classes/DB.class.php';
require_once 'classes/User.class.php';  
require_once 'classes/UserTools.class.php';
require_once 'classes/functions.class.php';  
require_once 'custom/custom.class.php';  


session_start(); 

//get language array
$lan_sele = LANGUAGE;
include("language/$lan_sele.php");


//connect to the database  
$db = new DB();  
$db->connect(); 

//mysql_query("SET NAMES 'utf8'"); 
  
//initialize UserTools object  
$userTools = new UserTools();  

//initialize Functions object  
$functions = new Functions();  

//initialize Custom Functions object  
$customfunc = new CustomFunctions(); 

//get user loggin info
if ($_SESSION['user']) {
	$user = $_SESSION['user']; 
	$userid = $user->id;
	$useremail = $user->email;
	
	if (!empty($user->google_picture)) {
		$avatar = $user->google_picture; 
	}elseif (!empty($user->facebook_picture)) {
		$avatar = $user->facebook_picture;
	}else{
		$avatar = BASE_URL."/img/avatar_default.jpg";
	}
	

	$datarow = $db->select("levels","id = $user->level");
	$modulesthislevel = json_decode($datarow[0]['modules']);
}

//get modules with settings and languages of each one
$modulesdirectory = scandir('modules/');
$allmodule = array();

foreach ($modulesdirectory as $key => $value) {
	
	if (is_dir("modules/$value") AND $key > 1) {
		$module_cron = "";
		$module_sublinks = "";
		include_once("modules/$value/language/$lan_sele.php");
		include_once("modules/$value/info.php");

		$allmodule[$module_name]["folder"]	=	$value;
		$allmodule[$module_name]["icon"]	=	$module_icon;
		$allmodule[$module_name]["order"]	=	$module_order;
		$allmodule[$module_name]["url"]		=	$module_url;
		$allmodule[$module_name]["type"]	=	$module_type;
		$allmodule[$module_name]["sublinks"]	=	$module_sublinks;
		$allmodule[$module_name]["cron"]	=	$module_cron;
		$allmodule[$module_name]["script"]	=	$module_script;

	}
}

$allmodule = $functions->array_sort($allmodule, 'order', SORT_ASC);


?>