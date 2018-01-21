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
if(strlen($_POST['password'])<5){echo"<script>alert('รหัสผ่านต้องมีอย่างน้อย 6 ตัวขึ้นไป');history.back();</script>";exit();}
else if($_POST['password']==""){echo"<script>alert('ยังไม่กรอกรหัสผ่าน');history.back();</script>";exit();}
else if($_POST['confirm']==""){echo"<script>alert('ยังไม่กรอกยืนยันรหัสผ่าน');history.back();</script>";exit();}
else if($_POST['password']!=$_POST['confirm']){echo"<script>alert('ยืนยันรหัสผ่านไม่ตรงกัน');history.back();</script>";exit();}
//รับค่า
$password=sha1($_POST['password']);
//เชื่อมต่อฐานข้อมูล
include('connect.php');
//อัพเดท     
$sql="UPDATE member SET password='$password', last_update=now() WHERE username='$member'";
mysql_query($sql)or die(mysql_error());
echo"<script>alert('เปลี่ยนรหัสผ่านเรียบร้อย');document.location=document.referrer;</script>";
?>
</body>
</html>