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
<title>レビュー登録</title>
</head>
<body>

<?php

$pro_code=$_GET['procode'];

require_once('../common/common.php');

$post=sanitize($_POST);
$pro_name=$post['name'];
$pro_score=$post['score'];
$pro_comment=$post['comment'];

if($pro_name=='')
{
	print '名前が入力されていません。<br />';
}
else
{
	print '名前<br/> ';
	print $pro_name;
	print '<br />';
}

if(preg_match('/^[0-9]+$/',$pro_score)==0)
{
	print '評価をきちんと入力してください。<br />';
}
else
{
	print '評価:';
	print $pro_score;
	print '<br />';
}

if($pro_comment=='')
{
	print '内容を入力してください。<br/>';
}
else
{
	print '内容<br/>';
	print $pro_comment;
	print '<br />';
}

if($pro_name=='' || preg_match('/^[0-9]+$/',$pro_score)==0 || $pro_comment=='')
{
	print '<form>';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '</form>';
}
else
{
	print '上記の内容を追加します<br />';
	print '<form method="post" action="shop_done.php?procode='.$pro_code.'">';
	print '<input type="hidden" name="name" value="'.$pro_name.'">';
	print '<input type="hidden" name="score" value="'.$pro_score.'">';
	print '<input type="hidden" name="comment" value="'.$pro_comment .'">';
	print '<br />';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '<input type="submit" value="OＫ">';
	print '</form>';
}

?>
</body>
</html>