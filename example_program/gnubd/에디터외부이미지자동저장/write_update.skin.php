<?php
//ver1.0 150410 @_untitle_d


function save_remote_image($url, $save_path)
{
    $ch = curl_init ($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $data=curl_exec($ch);
    curl_close ($ch);
	
	$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));
	$filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", basename($url));
	shuffle($chars_array);
	$shuffle = implode("", $chars_array);
	$change_filename = abs(ip2long($_SERVER[REMOTE_ADDR])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode(str_replace(' ', '_', $filename))); 
	$out_path = $save_path.$change_filename;
	
    if(file_exists($out_path)) @unlink($out_path);
    $fp = fopen($out_path,'x');
    fwrite($fp, $data);
    fclose($fp);
	
	return $change_filename;
}



if ($w == '' || $w == 'r'){

	$data_dir = G5_DATA_PATH.'/file/'.$bo_table.'/';
	$data_url = G5_DATA_URL.'/file/'.$bo_table.'/';
	
	$img_content = str_replace("&gt;", ">", str_replace("&lt;", "<", stripslashes($_POST[wr_content])));
	$patten = "/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i";
	preg_match_all($patten, $img_content, $match); 
	
	if ($match[1]) {
		foreach ($match[1] as $link) {
			$url = parse_url($link);
			if ($url[host] && $url[host] != $_SERVER[HTTP_HOST]) {
				$img_content = str_replace($link, ($data_url.save_remote_image($link, $data_dir)), $img_content);
			}
		}
		
		$sql = "update ".$write_table." set wr_content = '".mysql_real_escape_string(trim($img_content))."' where wr_id = '".$wr_id."'";
		sql_query($sql);
	}
	
}



?>