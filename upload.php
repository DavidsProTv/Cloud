<?php
session_start();
require("db.php");
if($_SESSION['code']){
  $code = $_SESSION['code'];
  $saftycode = $db_link->real_escape_string($code);
  $check = 0;
  $db_res = mysqli_query($db_link, "SELECT * FROM user WHERE code = '$saftycode'");
  while($row = mysqli_fetch_array($db_res)){
    $check = 1;
  }
  if($check != 1){
    $_SESSION['code'] = "";
    header('Location: index.php');
  }
}else{
  $_SESSION['code'] = "";
  header('Location: index.php');
}
?>
<html>
<head>
  <title>Cloud</title>
  <meta name="viewport" content="width=device-width; initial-scale=1;  user-scalable=0;" />
</head>
<body>
  <form action="upload.php" method="post" enctype="multipart/form-data">
    <input id="datei" type="file" name="datei" size="60" maxlength="255"/><br /><br />
    <input type="submit" value="Datei hochladen" Onclick="uploadFile()"/>
  </form>
  <?php
  if($_FILES['datei']){
    $name = $_FILES['datei']['name'];
    $endung = explode(".",  $_FILES['datei']['name']);
    $endung = $endung[count($endung) - 1];
    $speicherort = "datei/". $code. md5($name).md5(time()).".davidsprotv";
    if(move_uploaded_file($_FILES['datei']['tmp_name'], $speicherort)){

    }else{
      echo 'Wähle eine Datei aus.';
    }
  }
  ?>
  <script>
  function uploadFile(){
        var file = _("datei").files[0];
        var formdata = new FormData();
        formdata.append("datei", file);
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "fupload.php");
        ajax.send(formdata);
  }
  </script>
</body>
</html>
