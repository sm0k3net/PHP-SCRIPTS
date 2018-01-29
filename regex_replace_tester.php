<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="sm0k3.net php regex testing">
    <meta name="author" content="sm0k3">
    <!-- <link rel="icon" href="../../favicon.ico"> -->

    <title>RegEx Testing: Проверка регулярных выражений в PHP</title>

    <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="sticky-footer.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../assets/js/ie-emulation-modes-warning.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<?php

$regex = $_POST['regex'];
$replace = $_POST['replace'];
$data = $_POST['data'];

$html = $_POST['html'];

$save = $_POST['save'];
$imp_exp = $_POST['impexp'];

if($html == 'on') { $status_on = "checked"; $status_off = ''; }
elseif($html == 'off') { $status_on = ""; $status_off = 'checked'; }
else { $status_on = ""; $status_off = 'checked'; }

$allowed_tags = '<a><p><li><ul><table><b><i><u><tr><td><h1><h2><h3><h4><h5><h6>';


if($imp_exp == 'exp' && !empty($regex) && !empty($data)) {
  $export_result = base64_encode(json_encode($regex."[cut]".$replace."[cut]".$data, JSON_UNESCAPED_UNICODE));
} elseif($imp_exp == 'imp') {
  $export_result = base64_decode($save);
  $export_result = json_decode($export_result, JSON_UNESCAPED_UNICODE);
  $splitData = explode("[cut]", $export_result);
  $regex = $splitData[0];
  $replace = $splitData[1];
  $data = $splitData[2];
  $export_result = '';
}

if(isset($regex) && isset($data)) {
  $result = preg_replace($regex, $replace, $data);
} else {
  $result = "Не достаточно данных!";
}

?>

  <body>
      <div class="container">
      <div class="page-header">
        <h1>RegEx Testing: Проверка регулярных выражений в PHP</h1>
      </div>
      <div class="col-lg-12"> 
      <form action="#" method="post">
      <div class="form-group">
        <p><b>Загрузить / Выгрузить результат:</b> <input type="text" name="save" value="<?echo $export_result;?>"> 
        <span class="label label-success">Загрузить <input type="radio" name="impexp" value="imp"></span> <span class="label label-warning">Выгрузить <input type="radio" name="impexp" value="exp"></span></p>
        <b>Включить вывод в HTML формате:</b> <span class="label label-primary">Допустимые теги: <?php echo htmlspecialchars($allowed_tags); ?> </span><br />
        <b>Да</b> <input type="radio" name="html" value="on" <?echo $status_on;?> /> &nbsp; <b>Нет</b> <input type="radio" name="html" value="off" <?echo $status_off;?> />
      </div>
        <h3>Регулярное выражение</h3>
        <textarea rows="6" cols="70" name="regex"><?php echo $regex; ?></textarea>
        <h3>На что заменить</h3>
        <textarea rows="6" cols="70" name="replace"><?php echo $replace; ?></textarea>
        <h3>Что тестируем</h3> 
        <textarea rows="6" cols="70" name="data"><?php echo $data; ?></textarea>

        <div class="form-group">
        <input class="btn btn-default" type="submit" value="Показать результат">
      </form>
      <br /><br />
      <p><textarea rows="6" cols="70" disabled><?php echo $result; ?></textarea></p>
      <hr>
      <?php if($html == 'on') {?>
      <p><b>HTML формат: <?php echo strip_tags($result, $allowed_tags); ?></b></p>
      <?php } ?>
      </div>
      </div> 
     </div>
    </div>
<hr />
    <footer class="footer">
      <div class="container">
        <p class="text-muted">Powered by <a href='//sm0k3.net'>sm0k3.net</a></p>
      </div>
    </footer>


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
   </body>
</html>

