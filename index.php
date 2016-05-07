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

include_once("header.php");
include_once("sidebar.php");

include_once("modules/$module/$page.php");

include_once("footer.php");

?>

