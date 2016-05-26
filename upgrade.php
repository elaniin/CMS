<?php
/*
	Upgrade
*/

require_once 'config.php'; 
require_once 'version.php'; 
require_once 'credentials.php'; 

$key = $_SERVER["HTTP_KEY"];
$token = $_SERVER["HTTP_TOKEN"];

	function recurse_copy($src,$dst) { 
        $dir = opendir($src); 
        @mkdir($dst); 
        while(false !== ( $file = readdir($dir)) ) { 
            if (( $file != '.' ) && ( $file != '..' )) { 
                if ( is_dir($src . '/' . $file) ) { 
                    recurse_copy($src . '/' . $file,$dst . '/' . $file); 
                } 
                else { 
                    copy($src . '/' . $file,$dst . '/' . $file); 
                } 
            } 
        } 
        closedir($dir); 
    }  
	function rrmdir($dir) { 
	   if (is_dir($dir)) { 
	     $objects = scandir($dir); 
	     foreach ($objects as $object) { 
	       if ($object != "." && $object != "..") { 
	         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
	       } 
	     } 
	     reset($objects); 
	     rmdir($dir); 
	   } 
	}    

//classes needed
require_once 'classes/DB.class.php';
$db = new DB();  
$db->connect();  

if ($key == ACCOUNT_KEY && $token == SECRET_TOKEN) {
	$update = file_get_contents("http://toolboxsv.com/api/CMS/version.php");
	$update = json_decode($update);
	if ($update->id > CMS_VERSION_ID) {

		$file = "update.zip";
		$path = "tmp/";
		file_put_contents($file, fopen($update->url, 'r'));

		$zip = new ZipArchive;
		$res = $zip->open($file);
		if ($res === TRUE) {
		  $zip->extractTo($path);
		  $zip->close();
		  echo "WOOT! $file extracted to $path";
		} else {
		  echo "Doh! I couldn't open $file";
		}
		$here = pathinfo(realpath($file), PATHINFO_DIRNAME);
		recurse_copy("tmp/CMS-master",$here);
		rrmdir($path);
		echo "<br> Upgrade Completed";

	}else{
		echo "No updates available";
	}
}else{
	echo "Invalid token or key, please try again.";
}




?>