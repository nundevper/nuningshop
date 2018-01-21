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
$free_shipping=1000;
?>
<title>ข้อมูลการจัดส่ง | <?=$rowSetting['title']?></title>
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
        <div class="col-md-9 col-sm-8 col-xs-12" id="cart-detail">
        	<div class="col-md-12 col-sm-12 col-xs-12 box">
                <h3 class="box-header" style="text-align:left;">เลือกวิธีจัดส่ง</h3>
                
                <div class="col-md-12 col-sm-12 col-xs-12" style="padding:15px;">
<? 
$cart=$_SESSION['cart'];
?>

<div class="table-responsive" style="margin-bottom:0px">
<table class="list ztable" width="100%" border="0" align="center" cellpadding="5" cellspacing="1" style="min-width:300px;">
    <thead>
    <tr>
        <th width="100" align="center">ภาพสินค้า</th>
        <th align="center">รายการสินค้า</th>
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
        <td data-label="ภาพสินค้า" align="center">
          	<a href="สินค้า-<?=$item['id']."-".rewrite_url($item['name'])?>.html" target="_blank"><img src="product/<?=$item['image']?>" width="90" border="0"/></a>
       	</td>
        <td data-label="รายการสินค้า" align="center"><?=$item['name']?><br/><?=$item['option']?></td>
        <td data-label="ราคา" align="center"><?=number_format($item['price'])?></td>
        <td data-label="จำนวน" align="center"><?=$item['amount']?></td>
        <td data-label="ราคารวม" align="right"><?=number_format($item["price"]*$item["amount"])?></td>
    </tr>
	<?
		$sum+=$item['price']*$item['amount'];
		$quantity+=$item['amount'];
		$i++;
	}
	?>
    <tr>
        <td class="total" colspan="4" style="text-align:right;">ราคารวม (บาท)</td>
        <td class="total" style="font-size:16px;background:#fafafa;text-align:right;" align="right"><?=number_format($sum)?></td>
    </tr>
  	<tr>
    	<td colspan="5" align="right" style="background:#ffc;">
			<?
            $sqlFreeShipping="SELECT * FROM shipping WHERE id=0";
            $resultFreeShipping=mysql_query($sqlFreeShipping)or die(mysql_error());
            $rowFreeShipping=mysql_fetch_array($resultFreeShipping);
            if($sum<=$rowFreeShipping['price']||$sum==0){
            ?>
            เลือกวิธีจัดส่ง
            <select id="_shipping" name="_shipping" onchange="select_shipping()">
				<?
				$shipping_default = 0;
				$sqlShipping="SELECT * FROM shipping WHERE id!=0";
				$resultShipping=mysql_query($sqlShipping)or die(mysql_error());
				$numShipping=mysql_num_rows($resultShipping);
				for($i=1;$i<=$numShipping;$i++){$rowShipping=mysql_fetch_array($resultShipping);
					if ($i == 1) { $shipping_default = $rowShipping['id'];  }
                ?>
              	<option value="<?=$rowShipping['id']?>">
			  		<?=$rowShipping['option']?> <? if($rowShipping['price']>0){echo $rowShipping['price'].'บาท';}?>
            	</option>
				<?
                }
                ?>
            </select>
			<?
            }
            else{echo"$rowFreeShipping[option] <input type='hidden' name='_shipping' value='0'/>";}
            ?>
    	</td>
  	</tr>
    </tbody>
</table>
</div><!-- table-responsive -->
<div align="center" style="padding:15px 0 0 0;">
    <input type="button"  onclick="window.location='ตะกร้าสินค้า.html'" value="กลับไปแก้ไข"/>
</div>


       
                    
                </div>
         	</div><!-- box -->
      	</div>
        
        
        <div class="col-md-9 col-sm-8 col-xs-12" id="shipping-address">
        	<div class="col-md-12 col-sm-12 col-xs-12 box">
                <h3 class="box-header" style="text-align:left;">ที่อยู่ในการจัดส่ง</h3>
                
               <form class="col-md-12 col-sm-12 col-xs-12 post-form" action="คำสั่งซื้อ.html" method="post" name="order" > 
                  
                    <?
					if(isset($_SESSION['member'])){
						$sqlMember="SELECT * FROM member WHERE username='$member'";
						$resultMember=mysql_query($sqlMember)or die(mysql_error());
						$rowMember=mysql_fetch_array($resultMember);
						$fullname=$rowMember['fullname'];
						$address=$rowMember['address'];
						$zipcode=$rowMember['zipcode'];
						$tel=$rowMember['tel'];
						$email=$rowMember['email'];
					}
					else{
						$fullname="";
						$address="";
						$tel="";
						$zipcode="";
						$email="";   
					}
					?>
                    
                    <div class="col-md-2 col-sm-3 col-xs-12">ชื่อ -นามสกุล ผู้รับ</div>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <input type="text" name="fullname" maxlength="200" required autofocus value="<?=$fullname?>" style="width:40%;"/>
                    </div>
                    <div style="clear:both"></div>
                    
                    <div class="col-md-2 col-sm-3 col-xs-12">ที่อยู่</div>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <textarea name="address" rows="5" required style="width:40%;"><?=$address?></textarea>
                    </div>
                    <div style="clear:both"></div>
                    
                    <div class="col-md-2 col-sm-3 col-xs-12">รหัสไปรษณีย์</div>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <input type="text" name="zipcode" maxlength="10" required value="<?=$zipcode?>" style="width:20%;"/>
                    </div>
                    <div style="clear:both"></div>
                    
                    <div class="col-md-2 col-sm-3 col-xs-12">เบอร์ติดต่อ</div>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <input type="text" name="tel" maxlength="100" value="<?=$tel?>" style="width:40%;"/>
                    </div>
                    <div style="clear:both"></div>
                    
                    <div class="col-md-2 col-sm-3 col-xs-12">อีเมล</div>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                        <input type="text" name="email" maxlength="200" required value="<?=$email?>" style="width:40%"/>
                    </div>
                    <div style="clear:both"></div>
                    
                  
                   <div class="col-md-2 col-sm-3 col-xs-12">หมายเหตุ</div>
                   <div class="col-md-10 col-sm-9 col-xs-12">
                  		<textarea name="note" rows="5" style="width:40%"></textarea>
                   </div>
                   <div style="clear:both"></div>
                   
                   <div class="col-md-2 col-sm-3 col-xs-12"></div>
                   <div class="col-md-10 col-sm-9 col-xs-12">
                   		<input name="sum" type="hidden" value="<?=$sum?>"/>
                  		<input id="addtocart" type="submit" value="ยืนยันการสั่งซื้อ"/>
                   </div>
                   <div style="clear:both"></div>
                  	<? 
                    if($sum<=$rowFreeShipping['price']||$sum==0){
					?>
					<input id="shipping" type="hidden" name="shipping" value="<?=$shipping_default?>" />
                    
                    <?
					}
					else{echo"$rowFreeShipping[option] <input type='hidden' name='shipping' value='0'/>";}
					?>
                   
                </form>

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
<form action="คำสั่งซื้อ.html" method="post" name="order"> 
<table class="box" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <th style="text-align:left;">เลือกวิธีการจัดส่ง</th>
  </tr>
  <tr>
    <td>
<? 
$cart=$_SESSION['cart'];
?>
<table class="list" width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
  <tr>
    <th width="100" align="center">ภาพสินค้า</th>
    <th align="center">รายการสินค้า</th>
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
      <a href="สินค้า-<?=$item['id']."-".rewrite_url($item['name'])?>.html" target="_blank"><img src="product/<?=$item['image']?>" width="90" border="0"/></a>    </td>
    <td align="center"><?=$item['name']?><br/><?=$item['option']?></td>
    <td align="center"><?=number_format($item['price'])?></td>
    <td align="center"><?=$item['amount']?></td>
    <td align="right"><?=number_format($item["price"]*$item["amount"])?></td>
  </tr>
<? 	
$sum+=$item['price']*$item['amount'];
$quantity+=$item['amount'];
$i++;
}
?>
  <tr>
    <td colspan="4" align="right" style="background:#fafafa;">ราคารวม (บาท)</td>
    <td style="font-size:16px;background:#fafafa;" align="right"><input name="sum" type="hidden" value="<?=$sum?>"/><?=number_format($sum)?></td>
  </tr>
  <tr>
    <td colspan="5" align="right" style="background:#ffc;">
<?
$sqlFreeShipping="SELECT * FROM shipping WHERE id=0";
$resultFreeShipping=mysql_query($sqlFreeShipping)or die(mysql_error());
$rowFreeShipping=mysql_fetch_array($resultFreeShipping);
if($sum<=$rowFreeShipping['price']||$sum==0){
?>
เลือกวิธีจัดส่ง
<select id="shipping" name="shipping">
<?
  $sqlShipping="SELECT * FROM shipping WHERE id!=0";
  $resultShipping=mysql_query($sqlShipping)or die(mysql_error());
  $numShipping=mysql_num_rows($resultShipping);
  for($i=1;$i<=$numShipping;$i++){$rowShipping=mysql_fetch_array($resultShipping);
?>
  <option value="<?=$rowShipping['id']?>"><?=$rowShipping['option']?> <? if($rowShipping['price']>0){echo $rowShipping['price'].'บาท';}?></option>
<?
}
?>
</select>
<?
}
else{echo"$rowFreeShipping[option] <input type='hidden' name='shipping' value='0'/>";}
?>
    </td>
  </tr>
</table>
<div align="center" style="padding:15px 0 0 0;">
  <input type="button"  onclick="window.location='ตะกร้าสินค้า.html'" value="กลับไปแก้ไข"/>
</div>
    </td>
  </tr>
</table>
<?
if(isset($_SESSION['member'])){
  $sqlMember="SELECT * FROM member WHERE username='$member'";
  $resultMember=mysql_query($sqlMember)or die(mysql_error());
  $rowMember=mysql_fetch_array($resultMember);
  $fullname=$rowMember['fullname'];
  $address=$rowMember['address'];
  $zipcode=$rowMember['zipcode'];
  $tel=$rowMember['tel'];
  $email=$rowMember['email'];
}
else{
  $fullname="";
  $address="";
  $tel="";
  $zipcode="";
  $email="";   
}
?>
<table class="box" width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <th style="text-align:left;">ข้อมูลในการจัดส่ง</th>
  </tr>
  <tr>
    <td>

<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="120">ชื่อ -นามสกุล ผู้รับ</td>
    <td><input type="text" name="fullname" maxlength="200" required autofocus value="<?=$fullname?>" style="width:200px;"/></td>
  </tr>
  <tr>
    <td>ที่อยู่</td>
    <td><textarea name="address" rows="5" required style="width:300px;max-width:500px;"><?=$address?></textarea></td>
  </tr>
  <tr>
    <td>รหัสไปรษณีย์</td>
    <td><input type="text" name="zipcode" maxlength="10" required value="<?=$zipcode?>" style="width:60px;"/></td>
  </tr>
  <tr>
    <td>เบอร์ติดต่อ</td>
    <td><input type="text" name="tel" maxlength="100" value="<?=$tel?>" style="width:200px;"/></td>
  </tr>
  <tr>
    <td>อีเมล</td>
    <td><input type="text" name="email" maxlength="200" required value="<?=$email?>" style="width:200px;"/></td>
  </tr>
  <tr>
    <td>หมายเหตุ</td>
    <td><textarea name="note" rows="5" style="width:300px;max-width:500px;"></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input id="addtocart" type="submit" value="ยืนยันการสั่งซื้อ"/></td>
  </tr>
</table>
    </td>
  </tr>
</table>
</form>
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

function select_shipping() {
    var x = document.getElementById("_shipping").value;
	document.getElementById ("shipping").value = x;
}
</script>