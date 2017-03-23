<?php
/* 

	Functions Class 

*/
class Functions
{
	/*
		Send Email
	*/
	public function sendemail($email,$subject,$content){
		$lan_sele = LANGUAGE;
		include("language/$lan_sele.php");

		$bname = NAME;
		$bemail = P_EMAIL;
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		$headers .= "From: $bname <$bemail>" . "\r\n";

		$date = date("F d, Y");

		$template = "
		<table width='100%' border='0' cellspacing='0' cellpadding='0' bgcolor='#f5f5f5'>
		  <tbody><tr>
		    <td>

		<table align='center' bgcolor='#f5f5f5'>
		      <tbody><tr>
		    <td width='640'>
		    <table width='100%' border='0' cellspacing='20' cellpadding='0' align='center'>
		      <tbody><tr>
		        <td width='70' valign='bottom'><div style='min-height:45px'><a href='".BASE_URL."' target='_blank'><img src='".LOGO."' height='45' border='0' alt='".NAME."' style='display:block'></a></div></td>
		        <td width='570' style='padding-bottom:5px'><div align='right'><font style='font-size:14px;font-weight:bold;' face='Helvetica Neue Light, Helvetica Neue Regular, Helvetica, Arial' color='#666666'>".$lan["notification"]."</font><br><font style='font-size:14px;' face='Helvetica Neue Light, Helvetica Neue Regular, Helvetica, Arial' color='#666666'>$date</font>
		        </div></td>
		      </tr>
		    </tbody></table>
		    
		    <table width='100%' border='0' cellspacing='0' cellpadding='0' bgcolor='".COLOR."'>
		<tbody><tr>
		<td align='left' style='padding:25px'><font style='font-size:30px' color='#ffffff' face='Helvetica Neue Light, Helvetica Neue Regular, Helvetica, Arial'>$subject</font></td>
		</tr>

		<tr>
		<td align='left' valign='top' bgcolor='#ffffff' style='line-height:16px'><div style='min-height:16px'><img src='".BASE_URL."/img/email_arrow.png' border='0' width='60' height='16' style='display:block'></div></td>
		</tr>

		          <tr>
		           <td width='100%' align='left' style='padding:20px' bgcolor='#ffffff'>
		     <font style='font-size:14px;line-height:20px' face='Helvetica Neue Regular, Helvetica, Arial' color='#666666'>
		            $content
		        
		     </font>

		     </td>
		          </tr>

		        </tbody></table>

		        <table width='100%' border='0' align='center' cellpadding='20' cellspacing='0'>
		          <tbody><tr>
		            <td align='center' style='padding-top:20px'><font style='font-size:12px' face='Arial, Helvetica, sans-serif' color='#999999'>
		              ".$lan["sent_by"]." <a href='".BASE_URL."' style='color:#999999; text-decoration:none;'>".NAME."</a></font></td>
		          </tr>
		        </tbody></table></td>
		  </tr>
		</tbody></table></td>
		  </tr>
		</tbody></table>";		
		if (MAIL_TYPE == 1) { //DEFAULT
			mail($email,$subject,$template,$headers);
		}
		if (MAIL_TYPE == 2) { //MANDRILL
			require_once('libs/Mandrill.php');
			try {
		    $mandrill = new Mandrill(MAIL_MANDRILL_KEY);
		    $contenttext = strip_tags($template);
		    $message = array(
		        'html' => $template,
		        'text' => $contenttext,
		        'subject' => $subject,
		        'from_email' => $bemail,
		        'from_name' => $bname,
		        'to' => array(
		            array(
		                'email' => $email,
		                'type' => 'to'
		            )
		        ),
		        'headers' => array('Reply-To' => $bemail),
		        'track_opens' => 1,
		        'track_clicks' => 1,
		        'auto_text' => null,
		        'auto_html' => null,
		        'inline_css' => 1,
		    );
		    $result = $mandrill->messages->send($message);

			} catch(Mandrill_Error $e) {
			    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
			    throw $e;
			}
		}
		if (MAIL_TYPE == 3) { //SENDGRID
			
		}
		

	}

    /*
		Function to Generate Backup Database
    */
    public function backup_tables($name,$tables = '*')
	{
		mysql_select_db($name);
		
		//get all of the tables
		if($tables == '*')
		{
			$tables = array();
			$result = mysql_query('SHOW TABLES');
			while($row = mysql_fetch_row($result))
			{
				$tables[] = $row[0];
			}
		}
		else
		{
			$tables = is_array($tables) ? $tables : explode(',',$tables);
		}
		
		//cycle through
		foreach($tables as $table)
		{
			$result = mysql_query('SELECT * FROM '.$table);
			$num_fields = mysql_num_fields($result);
			
			$return.= 'DROP TABLE '.$table.';';
			$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
			$return.= "\n\n".$row2[1].";\n\n";
			
			for ($i = 0; $i < $num_fields; $i++) 
			{
				while($row = mysql_fetch_row($result))
				{
					$return.= 'INSERT INTO '.$table.' VALUES(';
					for($j=0; $j<$num_fields; $j++) 
					{
						$row[$j] = addslashes($row[$j]);
						$row[$j] = ereg_replace("\n","\\n",$row[$j]);
						if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
						if ($j<($num_fields-1)) { $return.= ','; }
					}
					$return.= ");\n";
				}
			}
			$return.="\n\n\n";
		}
		
		//save file
		$namebackup = 'db-backup-'.time().'.sql';
		$handle = fopen('backups/db-backup-'.time().'.sql','w+');
		fwrite($handle,$return);
		fclose($handle);
		return $namebackup;
	}


	/*
		Function to Restore Backup
    */
	public function restore($filename){
		$db = new DB(); 
		$mysqli = new mysqli($db->db_host, $db->db_user, $db->db_pass, $db->db_name);
		if (mysqli_connect_error()) {
		    die('Connect Error (' . mysqli_connect_errno() . ') '
		            . mysqli_connect_error());
		}
		$sql = file_get_contents("backups/$filename");
		if (!$sql){
			return "Error opening file";
		}
		mysqli_multi_query($mysqli,$sql);

	}	

	/*
		Function to shortertext
    */
	public function shorter($text, $maxchar, $end='...') {
	    if (strlen($text) > $maxchar || $text == '') {
	        $words = preg_split('/\s/', $text);      
	        $output = '';
	        $i      = 0;
	        while (1) {
	            $length = strlen($output)+strlen($words[$i]);
	            if ($length > $maxchar) {
	                break;
	            } 
	            else {
	                $output .= " " . $words[$i];
	                ++$i;
	            }
	        }
	        $output .= $end;
	    } 
	    else {
	        $output = $text;
	    }
	    return $output;
	}


	/*
		Function to post without wait
    */

	function post_without_wait($url, $params)
	{
	    foreach ($params as $key => &$val) {
	      if (is_array($val)) $val = implode(',', $val);
	        $post_params[] = $key.'='.urlencode($val);
	    }
	    $post_string = implode('&', $post_params);

	    $parts=parse_url($url);

	    $fp = fsockopen($parts['host'],isset($parts['port'])?$parts['port']:80,$errno, $errstr, 30);

	    $out = "POST ".$parts['path']." HTTP/1.1\r\n";
	    $out.= "Host: ".$parts['host']."\r\n";
	    $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
	    $out.= "Content-Length: ".strlen($post_string)."\r\n";
	    $out.= "Connection: Close\r\n\r\n";
	    if (isset($post_string)) $out.= $post_string;

	    fwrite($fp, $out);
	    fclose($fp);
	}
	/*

		Function Array Sort
    
    */	
	public	function array_sort($array, $on, $order=SORT_ASC)
		{
		    $new_array = array();
		    $sortable_array = array();

		    if (count($array) > 0) {
		        foreach ($array as $k => $v) {
		            if (is_array($v)) {
		                foreach ($v as $k2 => $v2) {
		                    if ($k2 == $on) {
		                        $sortable_array[$k] = $v2;
		                    }
		                }
		            } else {
		                $sortable_array[$k] = $v;
		            }
		        }

		        switch ($order) {
		            case SORT_ASC:
		                asort($sortable_array);
		            break;
		            case SORT_DESC:
		                arsort($sortable_array);
		            break;
		        }

		        foreach ($sortable_array as $k => $v) {
		            $new_array[$k] = $array[$k];
		        }
		    }

		    return $new_array;
		}		    

	/*

		Function Array Sort
    
    */	
	public	function randomString()
		{
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $randomString = '';
		    for ($i = 0; $i < 32; $i++) {
		        $randomString .= $characters[rand(0, strlen($characters) - 1)];
		    }
		    return $randomString;
		}
	



}



?>