<?php

	//General Cron 

	//Generate New Backup
	$namebackup = $functions->backup_tables($db->db_name);
    $data = array( 
		"filename" => "'$namebackup'",
    );
  	$db->insert($data, "backups");
  	echo "New Backup Generated";

?>