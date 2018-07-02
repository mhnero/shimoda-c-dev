<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>登録完了</title>
</head>
<body>

<?php

try
{
$pro_code=$_GET['procode'];

require_once('../common/common.php');

$post=sanitize($_POST);
$pro_name=$post['name'];
$pro_score=$post['score'];
$pro_comment=$post['comment'];

$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='INSERT INTO mst_review(code,name,score,comment) VALUES (?,?,?,?)';
$stmt=$dbh->prepare($sql);
$data[]=$pro_code;
$data[]=$pro_name;
$data[]=$pro_score;
$data[]=$pro_comment;
$stmt->execute($data);

$dbh=null;

print $pro_name;
print 'を追加しました。<br />';

}
catch(Exception$e)
{
	print'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

<?php print '<a href="shop_product.php?procode='.$pro_code.'">商品情報参照</a>'?>

</body>
</html>