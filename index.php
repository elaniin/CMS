<?php 
/*
  Index
*/
require_once 'global.inc.php'; 


$module = $_GET["module"];
$page = $_GET["page"];
if ($module == "" OR $page == "") {
  $module = DEFAULT_MODULE;
  $page = DEFAULT_PAGE;
}
$current_page = $page;

//check if is logged_in
if(!isset($_SESSION['logged_in'])) { 
    
    header("Location: ".BASE_URL."/login"); 
}
//check if have permissions to that module
$permission = 0;
foreach ($allmodule as $key => $value) {
	if (in_array($key, $modulesthislevel)) {
		if ($module == $allmodule[$key]["folder"]) {
			$permission = 1;
		}
	}
}

if (($page == "api" OR $page == "configuration") AND !(in_array("Admin", $modulesthislevel))) {
	$permission = 0;
}
if ($permission == 0) {
	echo "You do not have permission.";
	exit();
}

include_once("header.php");
include_once("sidebar.php");

//get POST variables all, to avoid declaration
if ($_POST) {
  foreach ($_POST as $param_name => $param_val) {
      $$param_name = $param_val;
  }
}

include_once("modules/$module/$page.php");

include_once("footer.php");

?>