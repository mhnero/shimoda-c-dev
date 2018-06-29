<?php
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
	print ' 様　';
	print '<a href="member_logout.php">ログアウト</a><br />';
	print '<br />';
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ろくまる農園</title>
</head>
<body>

<?php

try
{

$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT code,name,price FROM mst_product WHERE 1';
$stmt=$dbh->prepare($sql);
$stmt->execute();

$sql='SELECT code,name,price,gazou FROM mst_product WHERE 1';
$stmt1=$dbh->prepare($sql);
$stmt1->execute();

$p_code=array();
$p_name=array();
$p_price=array();
$p_gazou=array();
$p_sum=array();

while(true)
{
 $rec=$stmt1->fetch(PDO::FETCH_ASSOC);
 if($rec==false)
 {
    break;
 }
 $p_code[]=$rec['code'];
 $p_name[]=$rec['name'];
 $p_price[]=$rec['price'];
 $p_sum[]=0;
 $p_gazou[]=$rec['gazou'];
}
$pro_num=count($p_code);

//注文データ
$sql='SELECT code,code_product,quantity FROM dat_sales_product WHERE 1';
$stmt2=$dbh->prepare($sql);
$stmt2->execute();

$s_code=array();
$s_pro_code=array();
$s_quantity=array();

while(true)
{
 $rec1=$stmt2->fetch(PDO::FETCH_ASSOC);
 if($rec1==false)
 {
	break;
 }
 $s_code[]=$rec1['code'];
 $s_pro_code[]=$rec1['code_product'];
 $s_quantity[]=$rec1['quantity'];
}
$sales_num=count($s_code);

$dbh=null;

print '商品一覧<br /><br />';

//集計
for ($i = 0; $i < $sales_num; $i++){
	for ($j = 0; $j < $pro_num; $j++){
		if($s_pro_code[$i] == $p_code[$j]){
			$p_sum[$j] = $p_sum[$j] + $s_quantity[$i];
		}
	}
}

//ソート
$array01 = $p_sum;
arsort($array01);

//売上1位
$key=key($array01);
print '<a href="shop_product.php?procode='.$p_code[$key].'">';
print '<br />';
if($p_gazou[$key]=='')
{
	$disp_gazou='';
}
else
{
	$disp_gazou='<img src="../product/gazou/'.$p_gazou[$key].'">';
}
        print $disp_gazou;
        print '</a>';
        print '<br />';
print $p_name[$key].'';
print '<br />';
print '人気No.1！';
print '<br /><br />';

//売上2位
next($array01);
$key=key($array01);
print '<a href="shop_product.php?procode='.$p_code[$key].'">';
print '<br />';
if($p_gazou[$key]=='')
{
	$disp_gazou='';
}
else
{
	$disp_gazou='<img src="../product/gazou/'.$p_gazou[$key].'">';
}
        print $disp_gazou;
        print '</a>';
        print '<br />';
print $p_name[$key].'';
print '<br />';
print '人気No.2！';
print '<br /><br />';

//売上3位
next($array01);
$key=key($array01);
print '<a href="shop_product.php?procode='.$p_code[$key].'">';
print '<br />';
if($p_gazou[$key]=='')
{
	$disp_gazou='';
}
else
{
	$disp_gazou='<img src="../product/gazou/'.$p_gazou[$key].'">';
}
        print $disp_gazou;
        print '</a>';
        print '<br />';
print $p_name[$key].'';
print '<br />';
print '人気No.3！';
print '<br /><br />';


 //TABLEの横幅（ピクセル）
define('TABLE_WIDTH', 600);
//2次元配列
$Items = array(
array(),
array(),
array(),
array(),
array(),
array());










//商品一覧
while(true)
{
	$rec2=$stmt->fetch(PDO::FETCH_ASSOC);
	if($rec2==false)
	{
		break;
	}
	print '<a href="shop_product.php?procode='.$rec2['code'].'">';
	print $rec2['name'].'---';
	print $rec2['price'].'円';
	print '</a>';
	print '<br />';

}

print '<br />';
print '<a href="shop_cartlook.php">カートを見る</a><br />';

}
catch (Exception $e)
{
	 print 'ただいま障害により大変ご迷惑をお掛けしております。';
	 exit();
}

?>
</body>
</html>