<? session_start();include('process/connect.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/font.dwt.php" codeOutsideHTMLIsLocked="false" -->
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="robots" content="noodp, noydir"/>
        
		<?php
        if(isset($_SESSION['member'])){$member=$_SESSION['member'];}
        //ตกแต่ง
        $sqlDecoration="SELECT * FROM decoration";
        $resultDecoration=mysql_query($sqlDecoration)or die(mysql_error());
        $rowDecoration=mysql_fetch_array($resultDecoration);
        //ข้อมูลร้าน
        $sqlSetting="SELECT * FROM setting";
        $resultSetting=mysql_query($sqlSetting)or die(mysql_error());
        $rowSetting=mysql_fetch_array($resultSetting);
        //ส่วนเสริม
        $sqlPlus="SELECT * FROM plus";
        $resultPlus=mysql_query($sqlPlus)or die(mysql_error());
        $rowPlus=mysql_fetch_array($resultPlus);
        ?>
        
		<link rel="shortcut icon" href="image/<?=$rowDecoration['favicon']?>"/>
		<meta http-equiv="content-language" content="th"/>
        
		<!-- InstanceBeginEditable name="doctitle" -->
<?
//เช็คตะกร้า
if(!isset($_SESSION['cart'])){echo"<script>window.location='ตะกร้าสินค้า.html';</script>";exit();}
else if($_POST['fullname']==""||$_POST['address']==""||$_POST['zipcode']==""||$_POST['email']==""){
  echo"<script>alert('ยังกรอกข้อมูลไม่ครบ');window.location='จัดส่ง.html';</script>";exit();
}
else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){echo"<script>alert('รูปแบบอีเมลล์ผิด');history.back();</script>";exit();}
//สมาชิก
if(empty($_SESSION['member'])){
  $member_id=0;
  $fullname=$_POST['fullname'];
}
else{
  $member=$_SESSION['member'];
  $sqlMember="SELECT * FROM member WHERE username='$member'";
  $resultMember=mysql_query($sqlMember)or die(mysql_error());
  $rowMember=mysql_fetch_array($resultMember);
  $member_id=$rowMember['id'];
  $fullname=$rowMember['fullname'];
}
//จัดส่ง
$shipping=$_POST['shipping'];
$sqlShipping="SELECT * FROM shipping WHERE id=$shipping";
$resultShipping=mysql_query($sqlShipping)or die(mysql_error());
$rowShipping=mysql_fetch_array($resultShipping);
$shipping_price=$rowShipping['price'];
if($shipping==0){$shipping_price=0;}
$shipping_option=$rowShipping['option'];
//รับค่า
$cart=$_SESSION['cart'];
$address=mysql_escape_string(htmlspecialchars($_POST['address']));
$zipcode=mysql_escape_string(htmlspecialchars($_POST['zipcode']));
$email=mysql_escape_string($_POST['email']);
$tel=mysql_escape_string(htmlspecialchars($_POST['tel']));
$note=mysql_escape_string(htmlspecialchars($_POST['note']));
$sum=$_POST['sum'];
$shipping=$_POST['shipping'];
$total=$sum+$shipping_price;
//คำสั่งซื้อ
$sql="INSERT INTO `order`(member_id, fullname, address, zipcode, email, tel, total, shipping_option, shipping_price, status, note, insert_date, last_update) VALUES($member_id,'$_POST[fullname]','$address','$zipcode', '$email', '$tel', $total, '$shipping_option', $shipping_price, 'ยังไม่ชำระเงิน', '$note' ,now(), now())";
mysql_query($sql)or die(mysql_error());
//คืนค่าไอดี
$order_id=mysql_insert_id();
//รายละเอียดคำสั่งซื้อ
foreach($cart as $id=>$item){
  $sql="INSERT INTO order_detail(order_id, product_image, product_id, product_name, option_name, product_price, amount) VALUES($order_id, '$item[image]', $item[id], '$item[name]', '$item[option]', $item[price], $item[amount])";
  mysql_query($sql)or die(mysql_error());
}
//ชำระเงิน
$sqlPayment="SELECT * FROM bank";
$resultPayment=mysql_query($sqlPayment)or die(mysql_error());
$numPayment=mysql_num_rows($resultPayment);
?>
        <title>คำสั่งซื้อ | <?=$rowSetting['title']?></title>
        <meta name="description" content="<?=$rowSetting['description']?>"/>
        
        <style>
/*
table {
    border: 1px solid #ccc;
    width: 100%;
    margin:0;
    padding:0;
    border-collapse: collapse;
    border-spacing: 0;
}

table tr {
    border: 1px solid #ddd;
    padding: 5px;
}

table th, table td {
    padding: 10px;
    text-align: center;
}

table th {
    text-transform: uppercase;
    font-size: 14px;
    letter-spacing: 1px;
}*/
    .zcart-plus, .zcart-minus
	{
		display:block;
	}    
@media screen and (max-width: 600px) {
	.zcart-plus, .zcart-minus 
	{
		display:none;
	}
    .ztable {
       border: 0;
    }

    .ztable thead {
        display: none;
    }

    .ztable tr {
        margin-bottom: 10px;
        display: block;
    }

    .ztable tr:after {
        content: "";
        display: table;
        clear: both;
    }
  
    .ztable tr:before {
        display: block;
        /*border-bottom: 2px solid #ddd;*/
    }

    .ztable td {
        box-sizing: border-box;
        display: block;
        float: left;
        clear: left;
        width: 100%;
        text-align: right;
        /*font-size: 13px;*/
        border-bottom: 1px solid #efefef;
    }

    .ztable td:last-child {
        border-bottom: 0;
    }

    .ztable td:before {
        content: attr(data-label);
        float: left;
        text-transform: uppercase;
        font-weight: normal;
		background-color:#efefef;
    }
}
</style>
		<!-- InstanceEndEditable -->
        
		<? 
        if(empty($keyword)){echo"<meta name=\"keywords\" content=\"$rowSetting[keyword]\"/>";}
        else if(!empty($keyword)){echo"<meta name=\"keywords\" content=\"$keyword\"/>";}
        ?>
		<?=$rowSetting['stats_meta']?>
		<meta name="author" content="<?=$rowSetting['author']?>"/>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/scrolltopcontrol.js"></script> 
        <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
        
		<?php if ($rowDecoration['template_color']=="" ){ ?> <link href="css/design.css" rel="stylesheet" type="text/css" media="screen"/>
		<?php } else { echo"<link href=\"css/$rowDecoration[template_color].css\" rel=\"stylesheet\" type=\"text/css\" media=\"screen\"/>"; } ?>
		<style type="text/css">
			#background{<? if($rowDecoration['background_image']!=""){echo"background-image:url(image/$rowDecoration[background_image]);";}?>
			background-color:<?=$rowDecoration['background_color']?>;
			background-attachment:<?=$rowDecoration['attachment']?>;
			background-repeat:<?=$rowDecoration['repeat']?>;
			background-position:<?=$rowDecoration['horizontal_position']." ".$rowDecoration['vertical_position']?>;}
			body {
				min-height: 1500px;
				padding-top: 50px; /*70px;*/
			}
        </style>
        
        <?php #Bootstrap ?>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="bootstrap/css/bootstrap-customize.css" rel="stylesheet">
		<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
	</head>
<body id="background">
<?php
//หน้า
$sqlPage="SELECT * FROM page WHERE display='แสดง' ORDER BY sort";
$resultPage=mysql_query($sqlPage)or die(mysql_error());
$numPage=mysql_num_rows($resultPage);
?>
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?=$rowSetting['website_name']?>" title="<?=$rowSetting['title']?>">
            	<img alt="<?=$rowSetting['title']?>" src="<?=$rowSetting['website_name']."/"?>image/<?=$rowDecoration['logo']?>"  title="<?=$rowSetting['title']?>">
          	</a>
		</div>
        <div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
               <li>
                    <a style="padding-left:12px;padding-right:12px" href="<?=$rowSetting['website_name']?>" title="หน้าแรก">หน้าแรก</a><!-- class="active" -->
                </li>
            	<?php for ($i=1;$i<=$numPage;$i++) { $rowPage=mysql_fetch_array($resultPage); ?>
				<li>
                	<a style="padding-left:12px;padding-right:12px" href="<?=$rowPage['link']?>" title="<?=$rowPage['title']?>"><?=$rowPage['name']?></a><!-- class="active" -->
                </li>
                <? } ?>
            </ul>
		</div>
    </div>
</nav>
<!-- InstanceBeginEditable name="Slideshow" --><!-- InstanceEndEditable -->


<?php
//ทั้งหมด
$sqlAll="SELECT * FROM product";
$resultAll=mysql_query($sqlAll)or die(mysql_error());
$numAll=mysql_num_rows($resultAll);
//หมวดสินค้า
//SELECT product_category.category_id AS id, category.name AS name, COUNT(category.id) AS num_product FROM category INNER JOIN product_category ON category.id=product_category.category_id WHERE category.id!=0 GROUP BY category.id ORDER BY category.id;

//$sqlCategory="SELECT category.id AS id, category.name AS name, COUNT(product.id) AS num_product FROM category LEFT JOIN product ON category.id=product.category_id WHERE category.id!=0 GROUP BY category.id ORDER BY category.".mysql_escape_string($rowSetting['sort_category']);

$sqlCategory="SELECT product_category.category_id AS id, category.name AS name, COUNT(category.id) AS num_product FROM category INNER JOIN product_category ON category.id=product_category.category_id WHERE category.id!=0 GROUP BY category.id ORDER BY category.".mysql_escape_string($rowSetting['sort_category']);
$resultCategory=mysql_query($sqlCategory)or die(mysql_error());
$numCategory=mysql_num_rows($resultCategory);
//สินค้าที่ไม่มีหมวดหมู่
$sqlUncategory="SELECT * FROM product_category WHERE category_id=0";
$resultUncategory=mysql_query($sqlUncategory)or die(mysql_error());
$numUncategory=mysql_num_rows($resultUncategory);
?>
<div class="container">
	<div class="row">
    	<div class="col-md-3 col-sm-4"> 
        
			<div class="col-md-12 col-sm-12 box" id="category">
                <h3 class="box-header">หมวดสินค้า</h3>
                <div class="box-content">
                    <a href="รายการสินค้า-1.html" title="ทั้งหมด" style="display:block;">ทั้งหมด (<?=$numAll?>)</a><hr/>
                    
                    
                    <?php 
                    for ($i=1;$i<=$numCategory;$i++) { 
                        $rowCategory = mysql_fetch_array($resultCategory); 
                    ?>
                    <a href="หมวดหมู่-<?=$rowCategory['id']."-".rewrite_url($rowCategory['name'])."-1"?>.html" title="<?=$rowCategory['name']?>" style="display:block;"><?=$rowCategory['name']?> (<?=$rowCategory['num_product']?>)</a>
                    <?php
                        if ($i<$numCategory) { echo "<hr/>"; }
                    } 
                    //Uncategory product
                    if($numUncategory>0){
                        echo "<hr/><a href='หมวดหมู่-0-สินค้าไม่มีหมวดหมู่-1.html' title='สินค้าไม่ม่หมวดหมู่' style='display:block;'>สินค้าไม่มีหมวดหมู่ ($numUncategory)</a>"; 
                    }
                    ?> 
            	</div>
            </div>
		

            <div class="col-md-12 col-sm-12 box" id="login">
                <? 
                $login_header = "";
                if (!isset($_SESSION['member'])) { $login_header = "เข้าสู่ระบบ"; }
                else if (isset($_SESSION['member'])) { $login_header = "บัญชีของคุณ"; }
                ?>
                <h3 class="box-header"><?php echo $login_header; ?></h3>
             
                <div class="box-content">
					<? 
                    if (!isset($_SESSION['member'])) {
                    ?>
                
                    <form action="process/login.php" method="post" name="login">
                        <div class="col-md-3 col-sm-3 col-xs-3">ชื่อผู้ใช้</div>
                        <div class="col-md-9 col-sm-9 col-xs-9">
                           <input name="member" type="text" pattern="[a-zA-Z0-9ก-๙_-]{3,20}" required/>
                        </div>
                        
                        <div style="clear:both;"></div>
                        <div class="col-md-3 col-sm-3 col-xs-3" style="margin-top:10px;">รหัสผ่าน</div>
                        <div class="col-md-9 col-sm-9 col-xs-9" style="margin-top:10px;">
                            <input type="password" name="password" pattern="\S{5,20}" required/>
                        </div>
                        
                        <div style="clear:both;"></div>
                        <div class="col-md-3 col-sm-3 col-xs-3" style="margin-top:10px;"></div>
                        <div class="col-md-9 col-sm-9 col-xs-9" style="margin-top:10px;">
                            <input type="submit" value="เข้าสู่ระบบ"/>
                        </div>
                       
                        <div style="clear:both;"></div>
                        <div class="col-md-3 col-sm-3 col-xs-3" style="margin-top:10px;"></div>
                        <div class="col-md-9 col-sm-9 col-xs-9" style="margin-top:10px;">
                            <a href="สมัครสมาชิก.html" title="สมัครสมาชิก">สมัครสมาชิก</a>
                        </div>
                                    
                        <div style="clear:both;"></div>
                        <div class="col-md-3 col-sm-3 col-xs-3" style="margin-top:5px;"></div>
                        <div class="col-md-9 col-sm-9 col-xs-9" style="margin-top:5px;">
                            <a href="ลืมรหัสผ่าน.html" title="ลืมรหัสผ่าน">ลืมรหัสผ่าน</a>
                        </div>
                    </form>
                	<div style="clear:both"></div>
                
					<?php 
                    } 
                    if (isset($_SESSION['member'])) {
                    ?>
                    <div style="text-align:center;">
                        ยินดีต้อนรับคุณ  <?=$member?>
                        <div style="margin-top:10px;clear:both;"/></div>
                        <input  type="button" value="ดูข้อมูล" onclick="window.location='account.php'"/>      
                        <input type="button" value="ออกจากระบบ" onclick="window.location='process/logout.php'"/>
                     </div>
                    <?php
                    }
                    ?>
            	</div>
            </div>
            
			<?php
            $sqlTop="SELECT * FROM product WHERE status='ขายดี' ORDER BY rand()  LIMIT 0,3";
            $resultTop=mysql_query($sqlTop)or die(mysql_error());
            $numTop=mysql_num_rows($resultTop);
            if ($numTop>0) {
            ?>
            <div class="col-md-12 col-sm-12 box" id="top-seller" style="text-align:center">
                <h3 class="box-header">สินค้าขายดี</h3>
                <div class="box-content">
                    <?
                    for ($i=1;$i<=$numTop;$i++) { 
                        $rowTop=mysql_fetch_array($resultTop);
                    ?>
                    <a href="สินค้า-<?=$rowTop['id']."-".rewrite_url($rowTop['name'])?>.html">
                    <?php
                        if($rowTop['discount']>0){
                            echo "<img src='image/$rowDecoration[template_color]/ribbon-left.png' class='ribbon-top-seller' alt='ลดราคา' title='ลดราคา'/>";
                            echo "<span class='sale-top-seller'>-$rowTop[discount]%</span>";
                        }
                    ?>
                        <img src="product/<?=$rowTop['image']?>" alt="<?=$rowTop['name']?>.html" title="<?=$rowTop['name']?>"/>

                    </a>
                    <strong><?=mb_substr($rowTop['name'],0,35,'UTF-8')?></strong>
                    <?php 
                        if($rowTop['normal_price']>0){echo"<span class='discount'>".number_format($rowTop['normal_price'])."</span>";} 
                    ?> 
                    <span class="price"><?=number_format($rowTop['price'])?> บาท</span>
                    <?php 
                       
                        if($i<$numTop){echo"<hr/>";}
                    }
                    ?>
                </div>
            </div>
            <?php 
            }
            ?>
                
            <div class="col-md-12 col-sm-12 box" id="newsletter">
                <h3 class="box-header">รับข่าวสารทางอีเมล</h3>
                <div class="box-content">
                     <form action="process/newsletter.php" method="post" name="email" style="text-align:center">
                        <input type="text" name="newsletter" placeholder="กรอกอีเมลของคุณ" required style="margin-bottom:10px;width:90%;text-align:center"/>
                        <input type="submit" value="ส่งข้อมูล"/>
                    </form>
                </div>
            </div>
                
            <div class="box col-md-12 col-sm-12" id="facebook">
                <h3 class="box-header">Facebook</h3>
                <div class="box-content">
                    <!--<div class="fb-like-box" data-href="<?=$rowSetting['facebook_fanpage']?>" data-width="185" data-height="290" data-show-faces="true" data-stream="false" data-header="false" data-border-color="#eee"></div>  -->
                    
<div class="fb-page" data-href="<?=$rowSetting['facebook_fanpage']?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"></div>
                </div>
            </div>
            
			<?
            $sqlTag="SELECT * FROM tag ORDER BY id DESC";
            $resultTag=mysql_query($sqlTag)or die(mysql_error());
            $numTag=mysql_num_rows($resultTag);
            if($numTag>0){
            ?>
            <div class="box col-md-12 col-sm-12" id="tag">
                <h3 class="box-header">แท็ก</h3>
                <div class="box-content">
                    <?php
                    for($i=1;$i<=$numTag;$i++){$rowTag=mysql_fetch_array($resultTag);
                    ?>
                        <a href="<?=$rowTag['link']?>" title="<?=$rowTag['name']?>" class="tag" style="font-size:14px;" target="_blank"><?=$rowTag['name']?></a>
                    <?
                    }
                    ?>
                </div>
            </div>
            <?
            }
            ?>
    	</div><!-- aside -->
        
        
		<!-- InstanceBeginEditable name="EditRegion_Content_Responsive" -->
         <div class="col-md-9 col-sm-8 col-xs-12" id="payment">
        	<div class="col-md-12 col-sm-12 col-xs-12 box">
                <h3 class="box-header" style="text-align:left;">รายละเอียดคำสั่งซื้อ</h3>
                <div class="box-content">
					<?
                    if($rowPlus['notification']!=""){
                    ?>
                    <span class="register" style="padding:10px;margin:0 0 10px 0;width:100%;"><?=$rowPlus['notification']?></span><br/>
                    <?
                    }
                    ?>
                </div>
                
                <div class="col-md-12 col-sm-12 col-xs-12 post-form"> 
                    
                    <div class="col-md-2 col-sm-3 col-xs-12">รหัสคำสั่งซื้อ</div>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <?=$order_id?>
                    </div>
                    <div style="clear:both"></div>
                    
                    <div class="col-md-2 col-sm-3 col-xs-12">ชื่อ -นามสกุล ผู้รับ</div>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <?=$_POST['fullname']?>
                    </div>
                    <div style="clear:both"></div>
                    
                    <div class="col-md-2 col-sm-3 col-xs-12">ที่อยู่</div>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <?
						$address=str_replace('\r\n'," ",$address);
						echo $address;
						?>
                    </div>
                    <div style="clear:both"></div>
                    
                    <div class="col-md-2 col-sm-3 col-xs-12">รหัสไปรษณีย์</div>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <?=$zipcode?>
                    </div>
                    <div style="clear:both"></div>
                    
                    <div class="col-md-2 col-sm-3 col-xs-12">เบอร์ติดต่อ</div>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <?=$tel?>
                    </div>
                    <div style="clear:both"></div>
                    
                    <div class="col-md-2 col-sm-3 col-xs-12">อีเมล</div>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <?=$email?>
                    </div>
                    <div style="clear:both"></div>
                    
                    
                    <div class="col-md-2 col-sm-3 col-xs-12">หมายเหตุ</div>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <? 
						if($note==""){echo"-";}
						else{
						  $note=str_replace('\r\n'," ",$note);
						  echo $note;
						}
						?>
                    </div>
                    <div style="clear:both"></div>
                    
                    
                    <hr style="margin-top:20px;" />

                    <div class="table-responsive">
					<? 
                    $cart=$_SESSION['cart'];
                    ?>
<table class="list ztable" style="margin-top:10px;min-width:300px;" width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
    <thead>
    <tr>
        <th width="100" align="center">ภาพสินค้า</th>
        <th align="center" class="list">รายการสินค้า</th>
        <th width="65" align="center">ราคา</th>
        <th width="65" align="center">จำนวน</th>
        <th width="75" align="center">ราคารวม</th>
    </tr>
    </thead>
    <tbody>

	<? 
    $i=0; 
    $sum=0;
    $quantity=0;
    foreach($cart as $id=>$item){ 
    ?>
  	<tr>
    	<td data-label="ภาพ" align="center">
      		<a href="สินค้า-<?=$item['id']."-".rewrite_url($item['name'])?>.html" target="_blank"><img src="product/<?=$item['image']?>" width="90" border="0"/></a></td>
        <td data-label="รายการ" align="center"><?=$item['name']?><br/><?=$item['option']?></td>
        <td data-label="ราคา" align="center"><?=number_format($item['price'])?></td>
        <td data-label="จำนวน" align="center"><?=$item['amount']?></td>
        <td data-label="รวม" align="right"><?=number_format($item['price']*$item['amount'])?></td>
  	</tr>
	<? 	
    $sum+=$item['price']*$item['amount'];
    $quantity+=$item['amount'];
    $i++;
    }
    ?>
	<tr>
        <td colspan="4" align="right" style="background:#fafafa;"><?=$shipping_option?></td>
        <td align="right" style="background:#fafafa;"><?=number_format($shipping_price)?></td>
  	</tr>
  	<tr>
        <td colspan="4" align="right" style="background:#fafafa;">ราคารวมทั้งหมด (บาท)</td>
        <td style="font-size:16px;background:#fafafa;" align="right">
          <input type="hidden" name="total" id="<?=$sum+$shipping_price?>"/>
          <?=number_format($sum+$shipping_price)?>
        </td>
 	 </tr>
     </tbody>
</table>
</div><!-- table-responsive -->

<div align="center" style="padding:15px 0 0 0;">
  <input type="button"  onclick="window.location='<?=$rowSetting['website_name']?>'" value="กลับไปหน้าหลัก" />
</div>
                    
                </div>
                
            </div>
        </div>
        
       

        <!-- InstanceEndEditable -->
        
        
        <?php # Category - Display on Moblie ?>
        <?php
		//ทั้งหมด
		$sqlAll="SELECT * FROM product";
		$resultAll=mysql_query($sqlAll)or die(mysql_error());
		$numAll=mysql_num_rows($resultAll);
		
		$sqlCategory="SELECT product_category.category_id AS id, category.name AS name, COUNT(category.id) AS num_product FROM category INNER JOIN product_category ON category.id=product_category.category_id WHERE category.id!=0 GROUP BY category.id ORDER BY category.".mysql_escape_string($rowSetting['sort_category']);
		$resultCategory=mysql_query($sqlCategory)or die(mysql_error());
		$numCategory=mysql_num_rows($resultCategory);
 		?>
		
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-12 col-sm-12 box" id="zcategory2">
                <h3 class="box-header">หมวดสินค้า</h3>
                <div class="box-content">
                    <a href="รายการสินค้า-1.html" title="ทั้งหมด" style="display:block;">ทั้งหมด (<?=$numAll?>)</a><hr/>
                    
                    
                    <?php 
                    for ($i=1;$i<=$numCategory;$i++) { 
                        $rowCategory = mysql_fetch_array($resultCategory); 
                    ?>
                    <a href="หมวดหมู่-<?=$rowCategory['id']."-".rewrite_url($rowCategory['name'])."-1"?>.html" title="<?=$rowCategory['name']?>" style="display:block;"><?=$rowCategory['name']?> (<?=$rowCategory['num_product']?>)</a>
                    <?php
                        if ($i<$numCategory) { echo "<hr/>"; }
                    } 
                    //Uncategory product
                    if($numUncategory>0){
                        echo "<hr/><a href='หมวดหมู่-0-สินค้าไม่มีหมวดหมู่-1.html' title='สินค้าไม่ม่หมวดหมู่' style='display:block;'>สินค้าไม่มีหมวดหมู่ ($numUncategory)</a>"; 
                    }
                    ?> 
                </div>
            </div>
    	</div>     
        
        
        
        <?php # Start HTML2 ?>
        <div class="col-md-3 col-sm-4 col-xs-12"></div>
        <div class="col-md-9 col-sm-8 col-xs-12" id="html2">
            <div class="col-md-12 col-sm-12 box">
            	<div class="html2"><?php echo $rowPlus['html_2']?></div>	
            </div>
        </div>
        
   
    
    
  	</div><!-- row -->
    

      
    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12" id="footer">
            <div class="col-lg-9 col-md-9 col-sm-12"><h1>ของขวัญ ของขวัญวันเกิด ของขวัญให้แฟน ของขวัญปีใหม่ ของขวัญวันวาเลนไทน์ ของขวัญน่ารัก</h1></div>
            <div class="col-lg-3 col-md-3 col-sm-12 contact-info"><h6><?=$rowSetting['tel'];?> <?=$rowSetting['email'];?></h6></div>
            <div class="col-md-12 col-sm-12">
                <hr/>
            </div>
            
            <div class="col-md-9 col-sm-12 menu-footer">
            
            <?php 
            $sqlPage="SELECT * FROM page WHERE display='แสดง' ORDER BY sort";
            $resultPage=mysql_query($sqlPage)or die(mysql_error());
            $numPage=mysql_num_rows($resultPage);
            for ($i=1;$i<=$numPage;$i++) { $rowPage=mysql_fetch_array($resultPage); 
            ?>
                <a href="<?=$rowPage['link']?>" title="<?=$rowPage['title']?>"><?=$rowPage['name']?></a>
            <?php } ?>

            </div>
            <div class="col-md-3 col-sm-12 footer-logo">
                 <a href="<?=$rowSetting['website_name']?>" title="<?=$rowSetting['title']?>">
                    <img src="<?=$rowSetting['website_name']."/"?>image/<?=$rowDecoration['logo']?>" alt="<?=$rowSetting['title']?>" title="<?=$rowSetting['title']?>"/>
                </a>
            </div>
            
            <?
            if (trim($rowSetting['stats_display']) != 'none') {
            ?>
            <div class="col-md-12 col-sm-12" style="text-align:center;margin-top:20px">
                 <?=$rowSetting['stats_script']?>
            </div>
            <? 
            } 
            ?>

        </div>
	</div>
</div>

<!-- InstanceBeginEditable name="EditRegion_1" -->
<? /*
<table class="box" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <th style="text-align:left;">รายละเอียดคำสั่งซื้อ</th>
  </tr>
  <tr>
    <td>
<?
if($rowPlus['notification']!=""){
?>
<span class="register" style="padding:10px;margin:0 0 10px 0;width:685px;"><?=$rowPlus['notification']?></span><br/>
<?
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="120">รหัสคำสั่งซื้อ</td>
    <td><?=$order_id?></td>
  </tr>
  <tr>
    <td width="100">ชื่อ -นามสกุล ผู้รับ</td>
    <td><?=$_POST['fullname']?></td>
  </tr>
  <tr>
    <td>ที่อยู่</td>
    <td>
<?
$address=str_replace('\r\n'," ",$address);
echo $address;
?>
    </td>
  </tr>
  <tr>
    <td>รหัสไปรษณีย์</td>
    <td><?=$zipcode?></td>
  </tr>
  <tr>
    <td>เบอร์ติดต่อ</td>
    <td><?=$tel?></td>
  </tr>
  <tr>
    <td>อีเมล</td>
    <td><?=$email?></td>
  </tr>
  <tr>
    <td>หมายเหตุ</td>
    <td>
<? 
if($note==""){echo"-";}
else{
  $note=str_replace('\r\n'," ",$note);
  echo $note;
}
?> 
    </td>
  </tr>
</table>
<hr />
<? 
$cart=$_SESSION['cart'];
?>
<table class="list" style="margin-top:20px;" width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
  <tr>
    <th width="100" align="center">ภาพสินค้า</th>
    <th align="center" class="list">รายการสินค้า</th>
    <th width="65" align="center">ราคา</th>
    <th width="65" align="center">จำนวน</th>
    <th width="75" align="center">ราคารวม</th>
  </tr>
<? 
$i=0; 
$sum=0;
$quantity=0;
foreach($cart as $id=>$item){ 
?>
  <tr>
    <td align="center">
      <a href="สินค้า-<?=$item['id']."-".rewrite_url($item['name'])?>.html" target="_blank"><img src="product/<?=$item['image']?>" width="90" border="0"/></a></td>
    <td align="center"><?=$item['name']?><br/><?=$item['option']?></td>
    <td align="center"><?=number_format($item['price'])?></td>
    <td align="center"><?=$item['amount']?></td>
    <td align="right"><?=number_format($item['price']*$item['amount'])?></td>
  </tr>
<? 	
$sum+=$item['price']*$item['amount'];
$quantity+=$item['amount'];
$i++;
}
?>
<tr>
    <td colspan="4" align="right" style="background:#fafafa;"><?=$shipping_option?></td>
    <td align="right" style="background:#fafafa;"><?=number_format($shipping_price)?></td>
  </tr>
  <tr>
    <td colspan="4" align="right" style="background:#fafafa;">ราคารวมทั้งหมด (บาท)</td>
    <td style="font-size:16px;background:#fafafa;" align="right">
      <input type="hidden" name="total" id="<?=$sum+$shipping_price?>"/>
	  <?=number_format($sum+$shipping_price)?>
    </td>
  </tr>
</table>
<div align="center" style="padding:15px 0 0 0;">
  <input type="button"  onclick="window.location='<?=$rowSetting['website_name']?>'" value="กลับไปหน้าหลัก" />
</div>
    </td>
  </tr>
</table>
    </td>
  </tr>
</table>
*/ ?>
<!-- InstanceEndEditable -->

<!-- InstanceBeginEditable name="EditRegion_2" -->
<!-- InstanceEndEditable -->

<!-- InstanceBeginEditable name="EditRegion_3" -->
<!-- InstanceEndEditable -->
</div>


<?php
function rewrite_url($url="url"){
  $url=strtolower(str_replace(" ","_",$url));
  $url=strtolower(preg_replace('~[^a-z0-9ก-๙\.\-\_]~iu','',$url));
  return $url;
}
mysql_close($conn);
?>

<?php #jQuery (necessary for Bootstrap's JavaScript plugins) ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<?php #Include all compiled plugins (below), or include individual files as needed ?>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
(function(d,s,id){
  var js,fjs=d.getElementsByTagName(s)[0];
  if(d.getElementById(id))return;
  js=d.createElement(s);js.id=id;
  js.src="//connect.facebook.net/th_TH/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document,'script','facebook-jssdk'))
</script>
</body>
<!-- InstanceEnd --></html>
<script type="text/javascript">
(function(d,s,id){
  var js,fjs=d.getElementsByTagName(s)[0];
  if(d.getElementById(id))return;
  js=d.createElement(s);js.id=id;
  js.src="//connect.facebook.net/th_TH/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document,'script','facebook-jssdk'))
</script>
<?
//ข้อความ
$header="MIME-Version: 1.0\r\n";  
$header.="Content-type: text/html; charset=utf-8\r\n";
$header.="From: $rowSetting[shop_name] <$rowSetting[email]>\r\n";
$header.="Reply-To: $rowSetting[email]";
$subject="รายละเอียดคำสั่งซื้อสินค้าจาก $rowSetting[shop_name]";
$message="เรียนคุณ $_POST[fullname]<br/>";
$message.="คุณได้ทำการสั่งซื้อสินค้าจาก $rowSetting[shop_name] โดยมีรายละเอียดดังนี้<br/><br/>";
$message.="<b>รหัสคำสั่งซื้อ $order_id</b><br/><br/>";
$message.="
<table bgcolor='#e5e5e5' width='100%' border='0' align='center' cellpadding='5' cellspacing='1'>
  <tr>
    <th width='90' bgcolor='#fafafa'>ภาพสินค้า</th>
    <th bgcolor='#fafafa'>รายการสินค้า</th>
    <th width='65' bgcolor='#fafafa'>ราคา</th>
    <th width='65' bgcolor='#fafafa'>จำนวน</th>
    <th width='75' bgcolor='#fafafa'>ราคารวม</th>
  </tr>
";
$i=1; 
$sum=0;
$quantity=0;
foreach($cart as $id=>$item){ 
  $price=number_format($item['price']);
  $amount=number_format($item['amount']);
  $sum_list=number_format($item['price']*$item['amount']); 
  $message.="
  <tr>
    <td bgcolor='#fff'><img src='$rowSetting[website_name]/product/$item[image]' width='90' border='0'/></td>
    <td align='center' bgcolor='#fff'>$item[name]<br/>$item[option]</td>
    <td align='center' bgcolor='#fff'>$price</td>
    <td align='center' bgcolor='#fff'>$amount</td>
    <td align='right' bgcolor='#fff'>$sum_list</td>
  </tr>";   
  $quantity+=$item['amount'];
  $sum+=$item['price']*$item['amount'];
  $total=number_format($sum+$shipping_price);
  $i++;
} 
$message.="
  <tr>
    <td colspan='4' align='right' bgcolor='#fff'>$shipping_option</td>
    <td align='right' bgcolor='#fff'>$shipping_price</td>
  </tr>
  <tr>
    <td colspan='4' align='right' bgcolor='#fff'>ราคารวมทั้งหมด (บาท)</td>
    <td style='font-weight:bold' align='right' bgcolor='#fff'>$total</td>
  </tr>
</table><br/><br/>
";
//จัดส่ง
$message.="<b>ข้อมูลในการจัดส่ง</b><br/><br/>";
$message.="
<table bgcolor='#e5e5e5' width='100%' border='0' align='center' cellpadding='5' cellspacing='1'>
  <tr>
    <th width='150' align='left' bgcolor='#fafafa'>ชื่อ-นามสกุล ผู้รับ</th>
    <td align='left' bgcolor='#fff'>$fullname</td>
  </tr>
  <tr>
    <th align='left' bgcolor='#fafafa'>ที่อยู่ในการจัดส่ง</th>
    <td align='left' bgcolor='#fff'>$address $zipcode</td>
  </tr>
  <tr>
    <th align='left' bgcolor='#fafafa'>เบอร์ติดต่อ</th>
    <td align='left' bgcolor='#fff'>$tel</td>
  </tr>
  <tr>
    <th align='left' bgcolor='#fafafa'>หมายเหตุ</th>
    <td align='left' bgcolor='#fff'>$note</td>
  </tr>
</table><br/><br/>
";
//ชำระเงิน
$message.="<b>วิธีการชำระเงิน</b><br/>";
$message.="สามารถชำระเงินโดยโอนเข้าบัญชีธนาคารของร้านดังต่อไปนี้<br/><br/>";
$message.="
<table bgcolor='#e5e5e5' width='100%' border='0' align='center' cellpadding='5' cellspacing='1'>
  <tr>
    <th width='120' bgcolor='#fafafa'>ธนาคาร</th>
    <th bgcolor='#fafafa'>ชื่อบัญชี</th>
    <th width='120' bgcolor='#fafafa'>เลขที่บัญชี</th>
    <th width='120' bgcolor='#fafafa'>สาขา</th>
  </tr>
";
for($i=1;$i<=$numPayment;$i++){
  $rowPayment=mysql_fetch_array($resultPayment);
  $message.="  
  <tr>
    <td align='center' bgcolor='#fff'>$rowPayment[name]</td>
    <td align='center' bgcolor='#fff'>$rowPayment[account_name]</td>
    <td align='center' bgcolor='#fff'>$rowPayment[account_number]</td>
    <td align='center' bgcolor='#fff'>$rowPayment[branch]</td>
  </tr>
  ";
}
$message.="</table><br/><br/>";
$message.="<a href='$rowSetting[website_name]/payment.php?order_id=$order_id' target='_blank'>คลิกที่นี่</a> เพื่อแจ้งการชำระเงิน<br/><br/>";
$message.="ขอขอบคุณที่อุดหนุนและใช้บริการกับเรา<br/>";
$message.="$rowSetting[shop_name]";
//ส่งเมล์
mail($email, $subject, $message, $header);

//อีเมล์ผู้ขาย
$header="MIME-Version: 1.0\r\n";  
$header.="Content-type: text/html; charset=utf-8\r\n";
if(strpos($email,'@yahoo') === false){
  $header.="From: $fullname <$email>\r\n";
}
//$header.="From: $fullname <$email>\r\n";
$header.="Reply-To: $email";
$subject="มีรายการคำสั่งซื้อใหม่จาก $rowSetting[shop_name]";
$message="มีรายการคำสั่งซื้อใหม่จากคุณ $_POST[fullname] โดยมีรายละเอียดดังนี้<br/><br/>";
$message.="<strong>รหัสคำสั่งซื้อ $order_id</strong><br/><br/>";
$message.="
<table bgcolor='#e5e5e5' width='100%' border='0' align='center' cellpadding='5' cellspacing='1'>
  <tr>
    <th width='90' bgcolor='#fafafa'>ภาพสินค้า</th>
    <th bgcolor='#fafafa'>รายการสินค้า</th>
    <th width='65' bgcolor='#fafafa'>ราคา</th>
    <th width='65' bgcolor='#fafafa'>จำนวน</th>
    <th width='75' bgcolor='#fafafa'>ราคารวม</th>
  </tr>
";
$i=1; 
$sum=0;
$quantity=0;
foreach($cart as $id=>$item){ 
  $price=number_format($item['price']);
  $amount=number_format($item['amount']);
  $sum_list=number_format($item['price']*$item['amount']); 
  $message.="
  <tr>
    <td bgcolor='#fff'><img src='$rowSetting[website_name]/product/$item[image]' width='90' border='0'/></td>
    <td align='center' bgcolor='#fff'>$item[name]<br/>$item[option]</td>
    <td align='center' bgcolor='#fff'>$price</td>
    <td align='center' bgcolor='#fff'>$amount</td>
    <td align='right' bgcolor='#fff'>$sum_list</td>
  </tr>";   
  $quantity+=$item['amount'];
  $sum+=$item['price']*$item['amount'];
  $total=number_format($sum+$shipping_price);
  $i++;
} 
$message.="
  <tr>
    <td colspan='4' align='right' bgcolor='#fff'>$shipping_option</td>
    <td align='right' bgcolor='#fff'>$shipping_price</td>
  </tr>
  <tr>
    <td colspan='4' align='right' bgcolor='#fff'>ราคารวมทั้งหมด (บาท)</td>
    <td style='font-weight:bold' align='right' bgcolor='#fff'>$total</td>
  </tr>
</table><br/><br/>
";
//จัดส่ง
$message.="<strong>ข้อมูลในการจัดส่ง</strong><br/><br/>";
$message.="
<table bgcolor='#e5e5e5' width='100%' border='0' align='center' cellpadding='5' cellspacing='1'>
  <tr>
    <th width='150' align='left' bgcolor='#fafafa'>ชื่อ-นามสกุล ผู้รับ</th>
    <td align='left' bgcolor='#fff'>$fullname</td>
  </tr>
  <tr>
    <th align='left' bgcolor='#fafafa'>ที่อยู่ในการจัดส่ง</th>
    <td align='left' bgcolor='#fff'>$address $zipcode</td>
  </tr>
  <tr>
    <th align='left' bgcolor='#fafafa'>เบอร์ติดต่อ</th>
    <td align='left' bgcolor='#fff'>$tel</td>
  </tr>
  <tr>
    <th align='left' bgcolor='#fafafa'>อีเมล</th>
    <td align='left' bgcolor='#fff'>$email</td>
  </tr>
  <tr>
    <th align='left' bgcolor='#fafafa'>หมายเหตุ</th>
    <td align='left' bgcolor='#fff'>$note</td>
  </tr>
</table><br/><br/>
";
$message.="จัดการคำสั่งซื้อได้ที่ระบบหลังร้าน <a href='$rowSetting[website_name]/admin' target='_blank'>คลิกที่นี่</a>";
mail($rowSetting['email'], $subject, $message, $header);
//ยกเลิกเซสชัน
unset($_SESSION['cart']);
?>