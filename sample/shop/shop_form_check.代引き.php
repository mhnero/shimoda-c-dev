<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>スマートフォンアクセサリー販売システム</title>
</head>
<body>

<?php

/*require_once('../common/common.php');

$post=sanitize($_POST);

$onamae=$post['onamae'];
$email=$post['email'];
$postal1=$post['postal1'];
$postal2=$post['postal2'];
$address=$post['address'];
$tel=$post['tel'];
$chumon=$post['chumon'];
$pass=$post['pass'];
$pass2=$post['pass2'];
$danjo=$post['danjo'];
$birth=$post['birth'];

$okflg=true;*/

if(isset($_POST['daibiki'])==true)
{
  $pro_name=$_POST['onamae'];
  header('Location:check.php?name='.$pro_name);
  exit();
}

if(isset($_POST['konbini'])==true)
{
	$pro_name=$_POST['onamae'];
	header('Location:check1.php?name='.$pro_name);
  exit();
}

?>

</body>
</html>