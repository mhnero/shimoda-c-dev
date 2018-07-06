<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>勉強会</title>
</head>
<body>

<?php

try
{

require_once('../common/common.php');

$post=sanitize($_POST);
$pro_name=$post['name'];
$pro_price=$post['price'];
$pro_gazou_name=$post['gazou_name'];

if (DEBUG) {
  $dsn='mysql:dbname=shop;host=localhost;charset=utf8';
  $user='root';
  $password='';
  $dbh=new PDO($dsn,$user,$password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  }
  else{
  $dbServer = '127.0.0.1';
  $dbUser = $_SERVER['MYSQL_USER'];
  $dbPass = $_SERVER['MYSQL_PASSWORD'];
  $dbName = $_SERVER['MYSQL_DB'];
  $dsn = "mysql:host={$dbServer};dbname={$dbName};charset=utf8";
  $dbh = new PDO($dsn, $dbUser, $dbPass);
  }

$sql='INSERT INTO mst_product(name,price,gazou)VALUES(?,?,?)';
$stmt=$dbh->prepare($sql);
$data[]=$pro_name;
$data[]=$pro_price;
$data[]=$pro_gazou_name;
$stmt->execute($data);

$dbh=null;

print $pro_name;
print 'を追加しました。<br/>';

}
catch(Exception$e)
{
  print'ただいま障害により大変ご迷惑をお掛けしております。';
  exit();
}

?>
</body>