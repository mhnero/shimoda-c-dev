<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>勉強会</title>
</head>
<body>

<?php 

try
{

    $pro_code=$_GET['procode']; 

    $dsn='mysql:dbname=shop;host=localhost;charset=utf8'; 
    $user='root'; 
    $password=''; 
    $dbh=new PDO($dsn,$user,$password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql='SELECT name,price,gazou FROM mst_product WHERE code=?';
    $stmt=$dbh->prepare($sql); 
    $data[]=$pro_code; 
    $stmt->execute($data);

    $rec=$stmt->fetch(PDO::FETCH_ASSOC); 
    $pro_name=$rec['name']; 
    $pro_price=$rec['price']; 
    $pro_gazou_name=$rec['gazou'];

    $dbh=null; 

</body>
</html>