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
<title>勉強会</title>
</head>
<body>

<?php
require_once('../common/common.php');
?>

商品一覧<br />
<br />
<form method="post" action="shop_list.php"><br/>
<?php pulldown_type(); ?>&nbsp;
<?php pulldown_seisan(); ?>&nbsp;
<?php pulldown_pricelevel(); ?><br/><br/>
<input type="hidden" name="search" value="search"/><br />
<input type="text" name="keyword" style="width:300px">
<input type="submit"  value="検索" >
</form>

<?php

try
{
	require_once('../common/common.php');

//検索したことがない場合
	if(isset($_POST['search'])==false)
	{
//$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
/*$dsn='mysql:dbname=shop;host=localhost;charset=utf8';*/
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

$sql='SELECT code,name,price FROM mst_product WHERE 1';
$stmt=$dbh->prepare($sql);
$stmt->execute();


//帯川
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
?>
<table>
<tr>
<td>
<table border="1">
<tr><td>
  <?php
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

         print $disp_gazou.'</a><br />'; ?></tr><td>
         <tr><td><?php print $p_name[$key].'';?> </tr><td>
         <tr><td><?php print '人気No.1！';?></tr></td>
         
        </td>
        </table>
        <?php print '<br /><br />'; 
//売上2位
next($array01);
?>
<td>
<table border="1">
<tr><td>
  <?php
//売上2位
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

         print $disp_gazou.'</a><br />'; ?></tr><td>
         <tr><td><?php print $p_name[$key].'';?> </tr><td>
         <tr><td><?php print '人気No.2！';?></tr></td>
         
        </td>
        </table>
       
        <?php print '<br /><br />';        
//売上3位
next($array01);
?>
<td>
<table border="1">
<tr><td>
  <?php
//売上3位
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

         print $disp_gazou.'</a><br />'; ?></tr><td>
         <tr><td><?php print $p_name[$key].'';?> </tr><td>
         <tr><td><?php print '人気No.3！';?></tr></td>
         
        </td>
        </table>
        <?php print '<br /><br />';  ?>
        </td>
        </tr>
        </table>
<br /><br /> 



<?php


while(true)
{
	$rec=$stmt->fetch(PDO::FETCH_ASSOC);
	if($rec==false)
	{
		break;
	}
	print '<a href="shop_product.php?procode='.$rec['code'].'">';
	print $rec['name'].'─';
	print $rec['price'].'円';
	print '</a>';
	print '<br />';
}


print '<br />';
print '<a href="shop_cartlook.php">カートを見る</a><br />';
}
else{
//検索したことがある場合
$type=$_POST['type'];
$seisan=$_POST['seisan'];
$pricelevel=$_POST['pricelevel'];
$keyword=$_POST['keyword'];


//$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
/*$dsn='mysql:dbname=shop;host=localhost;charset=utf8';*/
/*$dsn='mysql:dbname=shop2;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT code,name,price,type,seisan,pricelevel
FROM mst_product WHERE 1';


$stmt=$dbh->prepare($sql);
$stmt->execute();
*/

//帯川
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
?>
<table>
<tr>
<td>
<table border="1">
<tr><td>
  <?php
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

         print $disp_gazou.'</a><br />'; ?></tr><td>
         <tr><td><?php print $p_name[$key].'';?> </tr><td>
         <tr><td><?php print '人気No.1！';?></tr></td>
         
        </td>
        </table>
        <?php print '<br /><br />'; 
//売上2位
next($array01);
?>
<td>
<table border="1">
<tr><td>
  <?php
//売上2位
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

         print $disp_gazou.'</a><br />'; ?></tr><td>
         <tr><td><?php print $p_name[$key].'';?> </tr><td>
         <tr><td><?php print '人気No.2！';?></tr></td>
         
        </td>
        </table>
       
        <?php print '<br /><br />';        
//売上3位
next($array01);
?>
<td>
<table border="1">
<tr><td>
  <?php
//売上3位
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

         print $disp_gazou.'</a><br />'; ?></tr><td>
         <tr><td><?php print $p_name[$key].'';?> </tr><td>
         <tr><td><?php print '人気No.3！';?></tr></td>
         
        </td>
        </table>
        <?php print '<br /><br />';  ?>
        </td>
        </tr>
        </table>
<br /><br /> 



<?php



$_x=0;

$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql='SELECT code,name,price,type,seisan,pricelevel
FROM mst_product WHERE 1';


$stmt=$dbh->prepare($sql);
$stmt->execute();


$dbh=null;

if($keyword==''){

	while(true)
	{
		$rec=$stmt->fetch(PDO::FETCH_ASSOC);
		if($rec==false)
		{
			if($_x==0){
				print '該当の商品はありません';	
			}
			break;
		}
		if((strpos($rec['type'],$type)!==false)
		&&(strpos($rec['seisan'],$seisan)!==false)
		&&(strpos($rec['pricelevel'],$pricelevel)!==false))
		{
		print '<a href="shop_product.php?procode='.$rec['code'].'">';
		print $rec['name'].'─';
		print $rec['price'].'円';
		print '</a>';
		print '<br />';
		$_x=1;
		}
	}
}

else{
	
while(true)
{
	$rec=$stmt->fetch(PDO::FETCH_ASSOC);
	if($rec==false)
	{
		if($_x==0){
			print '該当の商品はありません';			
		}
		break;
	}
	if((strpos($rec['type'],$type)!==false)
	&&(strpos($rec['seisan'],$seisan)!==false)
	&&(strpos($rec['pricelevel'],$pricelevel)!==false)
	&&(strpos($rec['name'],$keyword)!==false))
	{
	print '<a href="shop_product.php?procode='.$rec['code'].'">';
	print $rec['name'].'─';
	print $rec['price'].'円';
	print '</a>';
	print '<br />';
	$_x=1;
	}
}
}

print '<br />';
print '<a href="shop_cartlook.php">カートを見る</a><br />';

}
}
catch (Exception $e)
{
	 print 'ただいま障害により大変ご迷惑をお掛けしております。';
	 exit();
}

?>

</body>
</html>