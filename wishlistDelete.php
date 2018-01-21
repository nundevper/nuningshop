<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?
//เช็คค่า
if(empty($_GET['id'])||$_GET['id']==""){echo"<script>../account.php</script>";exit();}
if(!isset($_SESSION['member'])){echo"<script>alert('กรุณาเข้าสู่ระบบ');window.location='../login.php;</script>";exit();}
else if(isset($_SESSION['member'])){$member=$_SESSION['member'];}
//รับค่า
$product_id=intval($_GET['id']);
include('connect.php');
//ข้อมูลสมาชิก
$sql="SELECT * FROM member WHERE username='$member'";
$result=mysql_query($sql)or die(mysql_error());
$row=mysql_fetch_array($result);
$member_id=$row['id'];
//ลบ
$sql="DELETE FROM wishlist WHERE member_id='$member_id' AND product_id=$product_id";
mysql_query($sql)or die(mysql_error());
echo"<script>window.location='../account.php#wishlist';</script>";
?>
</body>
</html>