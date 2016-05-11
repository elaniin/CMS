<?php
/*
	Cron Jobs
*/

require_once 'global.inc.php'; 
$time = time();


foreach ($allmodule as $key => $value) {
	if ($allmodule[$key]["cron"] > 0) {
		$folder = $allmodule[$key]["folder"];
		//check if module exist in cron table
			$datarow = $db->select("cron","module = '$folder' ");
			if ($datarow[0]['module'] == "$folder") {
            	$lastcron = $datarow[0]['lastcron'];
            	//run cron if is time to do it
            	$interval = $allmodule[$key]["cron"];
				$nexttime = $lastcron+$interval;
				if ($time >= $nexttime) {
					include_once("modules/$folder/cron.php");
					// update lastcron in DB
					$data = array( 
			        	"lastcron" => "'$time'",
			        );
	        		$db->update($data, "cron", "module = '$folder'");
				}
            }
            else{
            	include_once("modules/$folder/cron.php");
            	$data = array( 
				    "module" => "'$folder'",
				    "lastcron" => "'$time'",
				);
				$db->insert($data, "cron");
				$lastcron = $time;
            }
	}
}
?>