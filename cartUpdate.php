<? session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?
$removes=isset($_POST['remove'])?$_POST['remove']:array();
$amounts=$_POST['amount'];
$cart=&$_SESSION['cart']; 
$error="";
foreach($amounts as $amount){
  if($amount==""){$error.="ไม่ระบุจำนวน";break;}
  else if(!is_numeric($amount)||$amount<=0){$error.="รูปแบบจำนวนผิด";break;}
}
if($error==""){
  //อัพเดทจำนวนและราคา
  foreach($amounts as $id=>$amount){$cart[$id]['amount']=$amount;}
  //ลบ
  foreach($removes as $id){unset($cart[$id]);}
}
//กลับไปที่ตะกร้าสิยค้า
//if($error==""){header("location:../ตะกร้าสินค้า.html");return;}
if($error==""){echo"<script>window.location='../ตะกร้าสินค้า.html';</script>";return;}
else{echo"<script>alert('$error');history.back();</script>";}
?>
</body>
</html>