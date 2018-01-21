<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<?
//เช็คค่า
if(empty($_POST['newsletter'])||$_POST['newsletter']==""){echo"<script>alert('ยังไม่กรอกอีเมล์');history.back();</script>";exit();}
else if(!filter_var($_POST['newsletter'], FILTER_VALIDATE_EMAIL)){echo"<script>alert('รูปแบบอีเมลไม่ถูกต้อง');history.back();</script>";exit();}
//รับค่า
$newsletter=$_POST['newsletter'];
include('connect.php');
$sql="INSERT INTO email(email, insert_date, last_update) VALUES('$newsletter', now(), now())";
mysql_query($sql)or die(mysql_error());
echo"<script>alert('รับข้อมูลเรียบร้อย');document.location=document.referrer;</script>";
?>
</body>
</html>