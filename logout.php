<?php
/*
	Logout
*/
require_once 'global.inc.php';
$userTools = new UserTools();
$userTools->logout();

header("Location: login");

?>