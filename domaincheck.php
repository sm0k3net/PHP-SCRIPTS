<?php
function domainCheck($domain) {
	$detect_zone = preg_match("/.+\.(\w{2,5})/", $domain, $zoneMatch);
	$validate_domain = preg_match("/([a-z0-9\-]+\.[a-z]{2,6})$/i", strtolower($domain), $match);

if($zoneMatch[1] == 'by' || $zoneMatch == 'бел') {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"http://cctld.by/check/?domain=".$match[1]);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$lookup = curl_exec($ch);
	curl_close ($ch);
	$get_mail = preg_match("/(\D+[-a-z0-9]+\@.+?\.\w{2,5})/", $lookup, $emailMatch);
	$phone_match = preg_match("/\>(\+\d{12})/", $lookup, $phoneMatch);
	$data = $emailMatch[1].";".$phoneMatch[1];
} else {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"http://www.freewhois.us/index.php?query=".$match[1]."&submit=Whois");
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$lookup = curl_exec($ch);
	curl_close ($ch);
	$get_mail = preg_match("/([-a-z0-9]+\@.+?\.\w{2,5})/", $lookup, $emailMatch);
	$phone_match = preg_match("/.+(\+\d{3}\.\d+)/", $lookup, $phoneMatch);
	$data = $emailMatch[1].";".$phoneMatch[1];
	}
$error = 'none';
	if($emailMatch[1] && $phoneMatch[1]) {
		return $data;
	} else {
		return $error;
	}
	
}
?>
