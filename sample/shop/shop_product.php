<?php
session_cache_limiter('none');
session_start();
session_regenerate_id(true);
if(isset($_SESSION['member_login'])==false)
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
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link href="img.css" rel="stylesheet" type="text/css">
<link href="pro.css" rel="stylesheet" type="text/css">
<title>アクセサリ販売システム</title>
</head>
<body>

<?php

try
{
	require_once('../common/common.php');

$pro_code=$_GET['procode'];

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

$data[]=$pro_code;
$sql='SELECT name,price,gazou,type,seisan FROM mst_product WHERE code=?';
$stmt=$dbh->prepare($sql);
$stmt->execute($data);

$sql2='SELECT name,score,comment FROM mst_review WHERE code=?';
$stmt2=$dbh->prepare($sql2);
$stmt2->execute($data);

$rec=$stmt->fetch(PDO::FETCH_ASSOC);
$pro_name=$rec['name'];
$pro_price=$rec['price'];
$pro_gazou_name=$rec['gazou'];
$pro_type=$rec['type'];
$pro_seisan=$rec['seisan'];

$dbh=null;

if($pro_gazou_name=='')
{
	$disp_gazou='';
}
else
{
	$disp_gazou='<img src="../product/gazou/'.$pro_gazou_name.'">';
}
print '<a href="shop_cartin.php?procode='.$pro_code.'">カートに入れる</a><br /><br />';
}
catch(Exception $e)
{
	print'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}
?>

商品情報参照<br />
<br />
<div id="king">
商品コード<br />
商品名<br />
価格<br />
種類<br />
生産国<br />
</div>

<div id="queen">
 : <?php print $pro_code; ?><br />
 : <?php print $pro_name; ?><br />
 : <?php print $pro_price; ?>円<br/>
 : <?php print $pro_type; ?><br />
 : <?php print $pro_seisan; ?>
<br />
</div>
<?php print $disp_gazou; ?>
<br />
<br />
<?php print '<a href="shop_add.php?procode='.$pro_code.'">レビューを入力する</a>'?>
<br />
レビュー一覧<br/>
<?php
while(true)
{
	$rec2=$stmt2->fetch(PDO::FETCH_ASSOC);
	if($rec2==false)
	{
		break;
	}
	print '●';
	print $rec2['name'].'---';
	print $rec2['score'].'点<br/>';
	print $rec2['comment'].'<br/>';
	print '<br />';
}
?>
<form>
<a href="shop_list.php">戻る</a>
</form>

</body>
</html>