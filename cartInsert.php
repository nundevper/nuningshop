<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<?
//รับค่า
$id=intval($_POST['id']);
$option=mysql_escape_string($_POST['option']);
$amount=intval($_POST['amount']);
//เช็คค่า       
if($amount==""){echo"<script>alert('ยังไม่ระบุจำนวน');history.back();</script>";exit();}
else if(!is_numeric($amount)){echo"<script>alert('จำนวนไม่เป็นตัวเลข');history.back();</script>";exit();}
//เชื่อมต่อฐานข้อมูล
include('connect.php');
$sql="SELECT product.id AS id, product.name AS name, product.price AS price, product.image AS image, product_option.id AS option_id, product_option.name AS `option` FROM product, product_option WHERE product.id=$id AND product_option.id=$option";
$result=mysql_query($sql)or die(mysql_error());
$row=mysql_fetch_array($result);
if(!isset($_SESSION['cart'])){$_SESSION['cart']=array();}	
$_SESSION['cart'][$option]=array('id'=>$row['id'], 'name'=>$row['name'], 'image'=>$row['image'], 'price'=>$row['price'], 'option'=>$row['option']  ,'amount'=>$amount);
echo"<script>window.location='../ตะกร้าสินค้า.html';</script>";
?>
</body>
</html>