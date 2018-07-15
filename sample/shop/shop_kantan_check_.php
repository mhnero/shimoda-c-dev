<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>スマートフォンアクセサリー販売システム</title>
</head>
<body>
<br/>
<span style="border: 2px solid #000000;padding:8px 5px 5px 5px;">支払い方法選択画面</span>
<div style="bo">

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

if($okflg==true)
{
	print '<form method="post" action="kantan_check.php">';
	print '<input type="hidden" name="onamae" value="'.$onamae.'">';
	print '<input type="hidden" name="onamae" value="'.$onamae.'">';
	print '<input type="hidden" name="email" value="'.$email.'">';
	print '<input type="hidden" name="postal1" value="'.$postal1.'">';
	print '<input type="hidden" name="postal2" value="'.$postal2.'">';
	print '<input type="hidden" name="address" value="'.$address.'">';
	print '<input type="hidden" name="tel" value="'.$tel.'">';
	
	print '<input type="submit" name="daibiki" value="代引き支払い"style="margin:50px; float:left; width:400px;height:400px">';//new
	print '</form>';

	print '<form method="post" action="kantan_check1.php">';
	print '<input type="hidden" name="onamae" value="'.$onamae.'">';
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

else
{
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
}

?>

</body>
</html>