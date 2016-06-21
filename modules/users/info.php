<?php

	$module_name = $lan["users"];
	$module_order = 1;
	$module_icon = "user";
	$module_url = BASE_URL ."/m/users/list";
	$module_script = "modules/users/scripts.php";
	$module_type = "multiple";
	$module_sublinks[0]["name"] = $lan["users_title"];
	$module_sublinks[0]["url"] = BASE_URL ."/m/users/list";
	$module_sublinks[1]["name"] = $lan["levels_title"];
	$module_sublinks[1]["url"] = BASE_URL ."/m/users/levels";


?>