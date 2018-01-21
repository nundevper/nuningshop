<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<?
if(!isset($_SESSION['member'])){echo"<script>alert('กรุณาเข้าสู่ระบบ');window.location='../login.php';</script>";exit();}
else if(isset($_SESSION['member'])){$member=$_SESSION['member'];}
//รับค่า
$id=intval($_GET['id']);
//เชื่อมต่อฐานข้อมูล
include('connect.php');
//อัพเดท     
$sql="UPDATE `order` SET status='ยกเลิก', last_update=now() WHERE id=$id";
mysql_query($sql)or die(mysql_error());
echo"<script>alert('ยกเลิกคำสั่งซื้อเรียบร้อย');document.location=document.referrer;</script>";
?>
</body>
</html>