<?php

	//General Cron 

	//Generate New Backup
	$namebackup = $functions->backup_tables($db->db_name);
    $data = array( 
		"filename" => "'$namebackup'",
    );
  	$db->insert($data, "backups");
  	echo "New Backup Generated";

  	//upgrade if an update exist
  	$key = ACCOUNT_KEY;
  	$token = SECRET_TOKEN;
  	
  	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, BASE_URL."/upgrade");
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$headers = array(
	    "X-API-VERSION: 2",
	    "key: $key",
	    "token: $token",
	);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$resp = curl_exec($ch);
	if(!$resp) {
	  die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
	} else {
	  echo $resp;
	}
	// Close request to clear up some resources
	curl_close($ch);

?>