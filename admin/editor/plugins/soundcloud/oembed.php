<?
	$url = "https://soundcloud.com/oembed?url=".$_GET['u'];
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url
	));
	$response = curl_exec($curl);
	curl_close($curl);
	
	if( strlen($response) > 1 ){
		preg_match_all("'url=(.*?)&amp;show_artwork='si", $response, $iframe);
		$iframe = $iframe[1][0];
		echo urldecode($iframe);
	} else {
		echo "error";
	}
?>