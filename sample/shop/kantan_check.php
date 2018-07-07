<?php
session_start();
session_regenerate_id(true);
/*if(isset($_SESSION['member_login'])==false)
{
	print 'ようこそゲスト様　';
	print '<a href="member_login.html">会員ログイン</a><br />';
	print '<br />';
}
else
{
	print 'ようこそ';
	print $_SESSION['member_name'];
	print '様　';
	print '<a href="member_logout.php">ログアウト</a><br />';
	print '<br />';
}*/
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ろくまる農園</title>
</head>
<body>

<?php

require_once('../common/common.php');
$post=sanitize($_POST);

$onamae=$post['onamae'];
$email=$post['email'];
$postal1=$post['postal1'];
$postal2=$post['postal2'];
$address=$post['address'];
$tel=$post['tel'];

$okflg=true;

print '注文内容をご確認ください<br />';

/*if($onamae=='')
{
	print '名前が入力されていません。<br />';
}
else
{
	print '名前:';
	print $onamae;
	print '<br />';
}

if($email=='')
{
	print 'メールアドレスが入力されていません。<br />';
}
else
{
	print 'メールアドレス:';
	print $email;
	print '<br />';
}*/

	if(isset($_SESSION['cart'])==true)
	{
		$cart=$_SESSION['cart'];
		$kazu=$_SESSION['kazu'];
		$max=count($cart);
	}

	
	$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
	$user='root';
	$password='';
	$dbh=new PDO($dsn,$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	
	$Gokei=0;
			print '<br/>';
	for($i=0;$i<$max;$i++)
	{
		$sql='SELECT name,price FROM mst_product WHERE code=?';
		$stmt=$dbh->prepare($sql);
		$data[0]=$cart[$i];
		$stmt->execute($data);
	
		$rec=$stmt->fetch(PDO::FETCH_ASSOC);
	
		$name=$rec['name'];
		$price=$rec['price'];
		$kakaku[]=$price;
		$suryo=$kazu[$i];
		$shokei=$price*$suryo;
		$Gokei=$Gokei+$shokei;
		print $name.'　';
		print '<br/>';
		print '¥';
		print $price.' - ';
		print '数量:';				
		//print '  ';
		print $suryo.'<br/>';
		//print '';
		//print $shokei.'円<br/>';
		//print '';
		
	}
	print '<br/>';
	print '合計￥';
	print $Gokei.'<br/><br/>';

if(preg_match('/^[0-9]+$/',$postal1)==0)
{
	print '郵便番号をきちんと入力してください。<br />';
}
else
{
	//print '郵便番号:';
	print 'お届け先';
	print '<br/>〒';
	print $postal1;
}
	print '-';

if(preg_match('/^[0-9]+$/',$postal2)==0)
{
	print '郵便番号をきちんと入力してください。<br />';
}
else
{
	print $postal2;
	print '<br />';
}

if($address=='')
{
	print '住所が入力されていません。<br />';
}
else
{
	//print '住所:';
	print $address;
	print '<br />';
}

if(preg_match('/^[0-9]+$/',$tel)==0)
{
	print '電話番号をきちんと入力してください。<br />';
}
else
{
	//print '電話番号:';
	print $tel;
	print '<br />';
}
	/*print '性別<br />';
	if($danjo=='dan')
	{
		print '男性';
	}
	else
	{
		print '女性';
	}
	print '<br /><br />';

	print '生まれ年<br />';
	print $birth;
	print '年代';
	print '<br /><br />';*/

print '<br />';

if($okflg=true){
	print '<form method="post" action="shop_kantan_done.php">';
	print '<input type="hidden" name="onamae" value="'.$onamae.'">';
	print '<input type="hidden" name="email" value="'.$email.'">';
	print '<input type="hidden" name="postal1" value="'.$postal1.'">';
	print '<input type="hidden" name="postal2" value="'.$postal2.'">';
	print '<input type="hidden" name="address" value="'.$address.'">';
	print '<input type="hidden" name="tel" value="'.$tel.'">';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '<input type="submit" value="ＯＫ"><br />';
	print '</form>';

	
}
else
{
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
}


?>

</body>
</html>