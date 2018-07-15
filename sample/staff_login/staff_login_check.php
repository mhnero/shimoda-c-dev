<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>スマートフォンアクセサリー販売システム</title>
</head>
<body>

<?php

try
{

require_once('../common/common.php');

$post=sanitize($_POST);
$staff_code=$post['code'];
$staff_pass=$post['pass'];

$staff_pass=md5($staff_pass);

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

$sql='SELECT name FROM mst_staff WHERE code=? AND password=?';
$stmt=$dbh->prepare($sql);
$data[]=$staff_code;
$data[]=$staff_pass;
$stmt->execute($data);

$dbh=null;

$rec=$stmt->fetch(PDO::FETCH_ASSOC);

if($rec==false)
{
	print 'スタッフコードかパスワードが間違っています。<br />';
	print '<a href="staff_login.html"> 戻る</a>';
}
else
{
	session_start();
	$_SESSION['login']=1;
	$_SESSION['staff_code']=$staff_code;
	$_SESSION['staff_name']=$rec['name'];
	header('Location:staff_top.php');
	exit();
}

}
catch(Exception $e)
{
	print 'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

</body>
</html>