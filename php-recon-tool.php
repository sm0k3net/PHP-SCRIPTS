<?php
set_time_limit(0);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//For this article: https://www.scanforsecurity.com/articles/automated-recon-tool-with-php-curl-wafw00f-whatweb-whois.html

function progress($item) {
echo $item;
ob_flush();
flush();
}

function url($target) {
	$find_url = shell_exec("curl -I -L $target | awk '/Location/{print $2}'");
	$res = explode("\n", trim($find_url));
	$url = end($res);
	if($url) {
		$result = $url;
	} else {
		$result = "http://".$target;
	}
	return $result;
}

function whois($target) {
	$whois = shell_exec("whois $target");
	return $whois;
}

function firewall($url) {
	$check_firewall = shell_exec("/usr/bin/wafw00f $url");
	preg_match("/is\sbehind\sa\s(.+?)\n/", $check_firewall, $result);
	if($result[1]) {
		$firewall = $result[1];
	} else {
		$firewall = 'None';
	}
	return $firewall;
}

function debug($url) {
	$debug = shell_exec("curl -I $url");
	return $debug;
}

function whatweb($url) {
	$check_stack = shell_exec("whatweb --no-errors $url --log-xml=/var/www/html/ww/tmp/temp.xml");
	$filepath = "/var/www/html/ww/tmp/temp.xml";
	$content =  utf8_encode(file_get_contents($filepath));
	$xml = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_COMPACT | LIBXML_PARSEHUGE);
	foreach($xml->target as $target) {
		$array = array();
		foreach($target->plugin as $key => $data) {
			$array[] = array(
					$key => $data
			);		
		}
		$res[] = array(
		'target' => $target->uri,
		'data' => $array
		);

	}
	$result = $res;
	unlink($filepath);
	return $result;
}

$target = trim($_POST['target']);
$submit = $_POST['submit'];
?>
<html>
<head><meta charset="utf-8"><meta name="referrer" content="no-referrer"></head>
<body>
		<h3>Techologies stack, firewall and whois test</h3>
			<form action="" method="post">
				<input type="text" value="" placeholder="domain.com" name="target" />
				<input type="submit" value="Search" name="submit" />
			</form>
			<hr>
			<?php
				if(!empty($target) && isset($submit)) {
					echo "<pre>";
					$url = url($target);
					progress("<p><b>URL:</b> <a href='$url' target=_blank rel='nofollow'>$url</a></p>");
					$debug = debug($url);
					progress("<p>$debug</p><hr>");
					$whatweb = whatweb($url);
					foreach($whatweb[0] as $ww) {
						foreach(array_slice($ww, 1) as $item) {
							if(isset($item['plugin']->string)) {
								$val = urldecode($item['plugin']->string);
							} else {
								$val = urldecode($item['plugin']->version);
							}
							progress("<li><b>".$item['plugin']->name."</b>  ".$val."</li>");
						}
					}
					$firewall = firewall($url);
					progress("<p><b>Firewall detected:</b> $firewall</p><hr>");
					$whois = whois($target);
					progress("<p>$whois</p>");
					echo "</pre>";

				}
			?>
</body>
</html>
