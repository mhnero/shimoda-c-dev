<?php
	session_start();
	session_regenerate_id(true);
	if(isset($_SESSION['member_login'])==false)
	{
		print 'ログインされていません。<br />';
		print '<a href="shop_list.php">商品一覧へ</a>';
		exit();
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

require_once('../common/common.php');

$post=sanitize($_POST);

$onamae=$post['onamae'];
$email=$post['email'];
$postal1=$post['postal1'];
$postal2=$post['postal2'];
$address=$post['address'];
$tel=$post['tel'];

print $onamae.'様<br />';
print '<br/>ご注文ありがとうござました。<br />';
//print $email.'にメールを送りましたのでご確認ください。<br />';
print 'お近くのファミリーマートでお支払い頂けます。<br />';
$nextWeek=time()+(7*24*60*60);
echo'お支払い期限:'.date('Y-m-d',$nextWeek).'　23:59'."\n";
print '<br />';

//print 'お支払い期限:平成30年8月20日 23:59<br />';
print '企業コード:50050<br />';

$str="";
for($i=0;$i<12;$i++){
    $str.=mt_rand(0,9);
}
print '注文番号:'.$str;
//echo sha1(uniqid(null,true));
//echo uniqid();

//echo str_pad($lastmembercode,12,0,STR_PAD_LEFT);
print '<br />';
print '引き続きショッピングをお楽しみ下さい。<br />';
//print $postal1.'-'.$postal2.'<br />';
//print $address.'<br />';
//print $tel.'<br />';

$honbun='';
$honbun.=$onamae."様\n\nこの度はご注文ありがとうございました。\n";
$honbun.="\n";
$honbun.="ご注文商品\n";
$honbun.="--------------------\n";

$cart=$_SESSION['cart'];
$kazu=$_SESSION['kazu'];
$max=count($cart);

$dsn='mysql:dbname=shop;host=localhost;charset=utf8';
$user='root';
$password='';
$dbh=new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

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

	$honbun.=$name.' ';
	$honbun.=$price.'円 x ';
	$honbun.=$suryo.'個 = ';
	$honbun.=$shokei."円\n";
}

//$sql='LOCK TABLES dat_sales,dat_sales_product WRITE';
//$stmt=$dbh->prepare($sql);
//$stmt->execute();

$lastmembercode=$_SESSION['member_code'];

$sql='INSERT INTO dat_sales (code_member,name,email,postal1,postal2,address,tel) VALUES (?,?,?,?,?,?,?)';
$stmt=$dbh->prepare($sql);
$data=array();
$data[]=$lastmembercode;
$data[]=$onamae;
$data[]=$email;
$data[]=$postal1;
$data[]=$postal2;
$data[]=$address;
$data[]=$tel;
$stmt->execute($data);

$sql='SELECT LAST_INSERT_ID()';
$stmt=$dbh->prepare($sql);
$stmt->execute();
$rec=$stmt->fetch(PDO::FETCH_ASSOC);
$lastcode=$rec['LAST_INSERT_ID()'];

for($i=0;$i<$max;$i++)
{
	$sql='INSERT INTO dat_sales_product (code_sales,code_product,price,quantity,paycode) VALUES (?,?,?,?,?)';
	$stmt=$dbh->prepare($sql);
	$data=array();
	$data[]=$lastcode;
	$data[]=$cart[$i];
	$data[]=$kakaku[$i];
	$data[]=$kazu[$i];
	$data[]=$str;
	$stmt->execute($data);
}

//$sql='UNLOCK TABLES';
//$stmt=$dbh->prepare($sql);
//$stmt->execute();

$dbh=null;

/*if($chumon=='chumontouroku')
{
	print '会員登録が完了いたしました。<br />';
	print '次回からメールアドレスとパスワードでログインしてください。<br />';
	print 'ご注文が簡単にできるようになります。<br />';
	print '<br />';
}

$honbun.="送料は無料です。\n";
$honbun.="--------------------\n";
$honbun.="\n";
$honbun.="代金は以下の口座にお振込ください。\n";
$honbun.="ろくまる銀行 やさい支店 普通口座 １２３４５６７\n";
$honbun.="入金確認が取れ次第、梱包、発送させていただきます。\n";
$honbun.="\n";

if($chumon=='chumontouroku')
{
	$honbun.="会員登録が完了いたしました。\n";
	$honbun.="次回からメールアドレスとパスワードでログインしてください。\n";
	$honbun.="ご注文が簡単にできるようになります。\n";
	$honbun.="\n";
}*/

$honbun.="□□□□□□□□□□□□□□\n";
$honbun.="　～安心野菜のろくまる農園～\n";
$honbun.="\n";
$honbun.="○○県六丸郡六丸村123-4\n";
$honbun.="電話 090-6060-xxxx\n";
$honbun.="メール info@rokumarunouen.co.jp\n";
$honbun.="□□□□□□□□□□□□□□\n";
//print '<br />';
//print nl2br($honbun);

$title='ご注文ありがとうございます。';
$header='From:info@rokumarunouen.co.jp';
$honbun=html_entity_decode($honbun,ENT_QUOTES,'UTF-8');
mb_language('Japanese');
mb_internal_encoding('UTF-8');
//mb_send_mail($email,$title,$honbun,$header);

$title='お客様からご注文がありました。';
$header='From:'.$email;
$honbun=html_entity_decode($honbun,ENT_QUOTES,'UTF-8');
mb_language('Japanese');
mb_internal_encoding('UTF-8');
//mb_send_mail('info@rokumarunouen.co.jp',$title,$honbun,$header);

}
catch (Exception $e)
{
	print 'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

<br />
<a href="shop_list.php">OK</a>

</body>
</html>