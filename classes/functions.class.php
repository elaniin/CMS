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
		
		$bname = NAME;
		$bemail = P_EMAIL;
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		$headers .= "From: $bname <$bemail>" . "\r\n";
		
		mail($email,$subject,$content,$headers);

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






}



?>