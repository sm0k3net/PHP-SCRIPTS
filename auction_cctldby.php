<?php

//PHP script to detect auction.cctld.by auction date and convert it into numeric date format
//Requires PHP cURL

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://auction.cctld.by/");
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.37');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec ($ch);
curl_close ($ch);
$find_date = preg_match("/.+состоится (.+?)\./", $output, $auctionData);
if($find_date) {
	$nextAuction = $auctionData[1];
	echo $auctionData[1];
} else {
	echo "Error!";
}
echo "<br><br>";

$compDates = array(
		"1" => "января",
		"2" => "февраля",
		"3" => "марта",
		"4" => "апреля",
		"5" => "мая",
		"6" => "июня",
		"7" => "июля",
		"8" => "августа",
		"9" => "сентября",
		"10" => "октября",
		"11" => "ноября",
		"12" => "декабря"
	);
  
$compareDate = preg_match("/по\s\d+\s(.+)/", $auctionData[1], $match);
$findDay = preg_match("/по\s(\d{1,2})\s/", $auctionData[1], $dmatch);
$when = array_search($match[1], $compDates);

echo ($dmatch[1]-2).$when.date('Y')." - ".$dmatch[1].$when.date('Y');
?>
