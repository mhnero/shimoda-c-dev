<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ろくまる農園</title>
</head>
<body>
<br/>
<span style="border: 2px solid #000000;padding:8px 5px 5px 5px;">支払い方法選択画面</span>
<div style="bo">

<?php

require_once('../common/common.php');



	if(isset($_SESSION["member_login"])==false)
{
	$post=sanitize($_POST);
	
$onamae=$post['onamae'];
$email=$post['email'];
$postal1=$post['postal1'];
$postal2=$post['postal2'];
$address=$post['address'];
$tel=$post['tel'];
$chumon=$post['chumon'];
$pass1=$post['pass1'];
$pass2=$post['pass2'];
$danjo=$post['danjo'];
$birth=$post['birth'];

$okflg=true;
}
if($okflg==true)
{
	print '<form method="post" action="check.php">';
	print '<input type="hidden" name="onamae" value="'.$onamae.'">';
	print '<input type="hidden" name="onamae" value="'.$onamae.'">';
	print '<input type="hidden" name="email" value="'.$email.'">';
	print '<input type="hidden" name="postal1" value="'.$postal1.'">';
	print '<input type="hidden" name="postal2" value="'.$postal2.'">';
	print '<input type="hidden" name="address" value="'.$address.'">';
	print '<input type="hidden" name="tel" value="'.$tel.'">';
	print '<input type="hidden" name="chumon" value="'.$chumon.'">';
	print '<input type="hidden" name="pass1" value="'.$pass1.'">';
	print '<input type="hidden" name="pass2" value="'.$pass2.'">';
	print '<input type="hidden" name="danjo" value="'.$danjo.'">';
	print '<input type="hidden" name="birth" value="'.$birth.'">';
	
	print '<input type="submit" name="daibiki" value="代引き支払い"style="margin:50px; float:left; width:400px;height:400px">';//new
	print '</form>';

	print '<form method="post" action="check1.php">';
	print '<input type="hidden" name="onamae" value="'.$onamae.'">';
	print '<input type="hidden" name="onamae" value="'.$onamae.'">';
	print '<input type="hidden" name="email" value="'.$email.'">';
	print '<input type="hidden" name="postal1" value="'.$postal1.'">';
	print '<input type="hidden" name="postal2" value="'.$postal2.'">';
	print '<input type="hidden" name="address" value="'.$address.'">';
	print '<input type="hidden" name="tel" value="'.$tel.'">';
	print '<input type="hidden" name="chumon" value="'.$chumon.'">';
	print '<input type="hidden" name="pass1" value="'.$pass1.'">';
	print '<input type="hidden" name="pass2" value="'.$pass2.'">';
	print '<input type="hidden" name="danjo" value="'.$danjo.'">';
	print '<input type="hidden" name="birth" value="'.$birth.'">';


	print '<input type="submit" name="konbini" value="コンビニ支払い"style="margin:50px; float:left; width:400px;height:400px">';
	print '<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>';
	print '<input type="button" onclick="history.back()" value="戻る"style="margin:50px">';
	//print '<input type="submit" value="OK"><br />';
	print '</form>';
}

else
{

	$code=$_SESSION['member_code'];

$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT name,email,postal1,postal2,address,tel FROM dat_member WHERE code=?';
$stmt=$dbh->prepare($sql);
$data[]=$code;
$stmt->execute($data);
$rec=$stmt->fetch(PDO::FETCH_ASSOC);

$dbh=null;

$onamae=$rec['name'];
$email=$rec['email'];
$postal1=$rec['postal1'];
$postal2=$rec['postal2'];
$address=$rec['address'];
$tel=$rec['tel'];

	print '<form method="post" action="check.php">';
	print '<input type="hidden" name="onamae" value="'.$onamae.'">';
	print '<input type="hidden" name="email" value="'.$email.'">';
	print '<input type="hidden" name="postal1" value="'.$postal1.'">';
	print '<input type="hidden" name="postal2" value="'.$postal2.'">';
	print '<input type="hidden" name="address" value="'.$address.'">';
	print '<input type="hidden" name="tel" value="'.$tel.'">';
	
	print '<input type="submit" name="daibiki" value="代引き支払い"style="margin:50px; float:left; width:400px;height:400px">';//new
	print '</form>';

	print '<form method="post" action="check1.php">';
	print '<input type="hidden" name="onamae" value="'.$onamae.'">';
	print '<input type="hidden" name="email" value="'.$email.'">';
	print '<input type="hidden" name="postal1" value="'.$postal1.'">';
	print '<input type="hidden" name="postal2" value="'.$postal2.'">';
	print '<input type="hidden" name="address" value="'.$address.'">';
	print '<input type="hidden" name="tel" value="'.$tel.'">';


	print '<input type="submit" name="konbini" value="コンビニ支払い"style="margin:50px; float:left; width:400px;height:400px">';
	print '<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>';
	print '<input type="button" onclick="history.back()" value="戻る"style="margin:50px">';
	//print '<input type="submit" value="OK"><br />';
	print '</form>';
}

?>

</body>
</html>