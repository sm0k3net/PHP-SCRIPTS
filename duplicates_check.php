<html>
 <head>
 	<meta charset="utf-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
 	<title>База данных валидированных и проверенных прокси</title>
 </head>
 <body>
 <div class="container">
 <div class="col-lg-12">
<form action="#" method="post">
<div class="form-group">
<h2>Вставьте текст для проверки на дубликаты <small>(проверка построчная)</small></h2>
<textarea name="data" rows="15" cols="100"></textarea>
</div>
<input type="submit" class="btn btn-info" value="Удалить дубликаты">
</form>
<?php
$data = $_POST['data'];
if(isset($data)) {
	echo "<textarea disabled rows='15' cols='100'>";
	$duplicates = explode("\n", str_replace("\r", "", $data));
	$clean = array_unique($duplicates);
	foreach($clean as $unique) {
		echo $unique."\n";
	}
	echo "</textarea>";
}

?>
<br />
<hr />
<p>Powered by <a href="//sm0k3.net">sm0k3</a></p>
</div>
</div>
</body>
</html>
