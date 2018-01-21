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
else if($_POST['fullname']==""){echo"<script>alert('ยังไม่กรอกชื่อ-นามสกุล');history.back();</script>";exit();}
else if($_POST['zipcode']==""){echo"<script>alert('ยังไม่กรอกรหัสไปรษณีย์');history.back();</script>";exit;}
//รับค่า
$fullname=mysql_escape_string(htmlspecialchars($_POST['fullname']));
$address=mysql_escape_string(htmlspecialchars($_POST['address']));
$zipcode=mysql_escape_string($_POST['zipcode']);
$birthdate=$_POST['birthdate'];
$tel=mysql_escape_string(htmlspecialchars($_POST['tel']));
//เชื่อมต่อฐานข้อมูล
include('connect.php');
//อัพเดท     
$sql="UPDATE member SET fullname='$fullname', address='$address', zipcode=$zipcode, birthdate='$birthdate', tel='$tel', last_update=now() WHERE username='$member'";
mysql_query($sql)or die(mysql_error());
echo"<script>alert('เปลี่ยนข้อมูลเรียบร้อย');document.location=document.referrer;</script>";
?>
</body>
</html>