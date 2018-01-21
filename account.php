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
        //เช็คล็อกอิน
        if(!isset($_SESSION['member'])){echo"<script>window.location='login.php';</script>";exit();}
        else if(isset($_SESSION['member'])){$member=$_SESSION['member'];}
        //ข้อมูลสมาชิก
        $sqlMember="SELECT * FROM member WHERE username='$member'";
        $resultMember=mysql_query($sqlMember)or die(mysql_error());
        $rowMember=mysql_fetch_array($resultMember);
        ?>
        <title>ข้อมูลสมาชิกคุณ <?=$rowMember['username']?> | <?=$rowSetting['shop_name']?></title>
        <meta name="description" content="<?=$rowSetting['description']?>"/>
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
		<script type="text/javascript" src="js/calendarDateInput.js"></script>
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
        

        <div class="col-md-9 col-sm-8" id="search-product">
            <div class="col-md-12 col-sm-12 box">
                <h3 class="box-header" style="text-align:left;">ข้อมูลผู้ใช้</h3>

		

                <form class="col-md-12 col-sm-12 col-xs-12 post-form" action="process/changePassword.php" method="post">

              
                    <div class="col-md-2 col-sm-3 col-xs-12">ชื่อผู้ใช้</div>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                    	<input type="text" name="username" readonly value="<?=$rowMember['username']?>" style="width:200px;"/>
                    </div>
                    <div style="clear:both"></div>
                    
                    <div class="col-md-2 col-sm-3 col-xs-12">เปลี่ยนรหัสผ่าน</div>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                    	<input type="password" name="password" pattern="\S{5,20}" required autofocus placeholder="6-20 ตัว และไม่มีช่องว่าง" style="width:200px;"/>
                    </div>
                    <div style="clear:both"></div>
                    
                    
                    <div class="col-md-2 col-sm-3 col-xs-12">ยืนยันรหัสผ่าน</div>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                    	<input type="password" name="confirm" required style="width:200px;"/>
                    </div>
                    <div style="clear:both"></div>
                    
                    
                    <div class="col-md-2 col-sm-3 col-xs-12">วันที่สมัคร</div>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                    	<input type="text" name="insert_date" readonly value="<?=substr($rowMember['insert_date'],0,16)?>" style="width:90px;"/>
                    </div>
                    <div style="clear:both"></div>
                    
                    <div class="col-md-2 col-sm-3 col-xs-12">แก้ไขล่าสุด</div>
                    <div class="col-md-10 col-sm-9 col-xs-12">
                    	<input type="text" name="last_update" readonly value="<?=substr($rowMember['last_update'], 0, 16)?>" style="width:90px;"/>
                    </div>
                    <div style="clear:both"></div>
                    
                    
                   <div class="col-md-2 col-sm-3 col-xs-12"></div>
                   <div class="col-md-10 col-sm-9 col-xs-12">
                   		<input class="button" type="submit" value="บันทึก"/>
                  		<input type="hidden" name="id" value="<?=base64_encode($rowMember['id'])?>"/>
                   </div>
                   <div style="clear:both"></div>
            	</form>
                <div style="clear:both"></div>
            </div>
            
            
            <div class="col-md-12 col-sm-12 col-xs-12 box">
                <h3 class="box-header" style="text-align:left;">ประวัติการสั่งซื้อ</h3>
                
                <div class="col-md-12 col-sm-12 col-xs-12" style="padding:15px;">
					<?
                    //เพจที่แสดง
                    $current_page=1;
                    if(isset($_REQUEST['page'])){$current_page=intval($_REQUEST['page']);}
                    //จำนวนแถว
                    $rows_per_page=intval(15);
                    $start_row=intval(($current_page-1)*$rows_per_page);
                    $sql="SELECT SQL_CALC_FOUND_ROWS * FROM `order` WHERE member_id=$rowMember[id] ORDER BY id DESC LIMIT $start_row, $rows_per_page";
                    $result=mysql_query($sql)or die(mysql_error());
                    //แบ่งเพจ
                    $found_rows=mysql_query("SELECT FOUND_ROWS();");
                    $total_rows=mysql_result($found_rows,0,0);
                    $total_pages=ceil($total_rows/$rows_per_page);
                    ?>
 

    				<div class="table-responsive" style="margin-bottom:0px">
						<a name="order" id="order"></a>

<table align="center" cellpadding="5" cellspacing="1" class="list" style="min-width:500px;">
    <tr>
        <th width="60">รหัส</th>
        <th width="120">จำนวนเงิน (บาท)</th>
        <th width="120">สถานะ</th>
        <th width="120">หมายเลขพัสดุ</th>
        <th width="120">วันที่สั่งซื้อ</th>
        <th class="list">จัดการ</th>
    </tr>
<?
if($total_rows==0){
?>
    <tr>
    	<td align="center" colspan="6">ไม่มีข้อมูล (0 รายการ)</td>
    </tr>
<?
}
while($row=mysql_fetch_array($result)){
?>
    <tr>
        <td align="center"><?=$row['id']?></td>
        <td align="center"><?=number_format($row['total'],2)?></td>
        <td align="center"><?=$row['status']?></td>
        <td align="center"><? if($row['ems']!=""){echo $row['ems'];}else{echo "-";}?></td>
        <td align="center"><?=substr($row['insert_date'],0,16)?></td>
        <td align="center">
         <a href="payment.php?order_id=<?=$row['id']?>" target="_blank"><img src="image/icon-money.png" title="แจ้งการชำระเงิน" border="0"/></a>
         <a href="process/orderCancle.php?id=<?=$row['id']?>" onclick="return confirm('ต้องการยกเลิกรหัสคำสั่งซื้อ <?=$row['id']?> ?')"><img src="image/icon-cancle.png" class="action" title="ยกเลิก" border="0"/></a></td>
    </tr>
    <?
    }
    ?>
    <tr>
    	<td colspan="6" align="right" style="font-size:12px;background:#fafafa;"><div style="float:left"><?=$total_rows?> รายการ</div>
		<?
        $page_range=5;
        $page_start=$current_page-$page_range;
        $page_end=$current_page+$page_range;
        if($page_start<1){
          	$page_end+=1-$page_start;
          	$page_start=1;
        }
        if($page_end>$total_pages){
          	$diff=$page_end-$total_pages;
          	$page_start-=$diff;
          	if($page_start<1){
            	$page_start=1;  
          	}
         	$page_end=$total_pages;
        }
        //ย้อนกลับ
        if($current_page>1){$pg=$current_page-1;
          echo"&nbsp;<a href='?page=$pg#order' title='หน้า $pg'>ย้อนกลับ</a>&nbsp;";
        }
        if($page_start>1){$pg=$page_start-1;
          echo"&nbsp;<a href='?page=$pg#order' title='หน้า $pg'>...</a>&nbsp;";
        }
        //แสดงหมายเลขเพจ
        for($i=$page_start;$i<=$page_end;$i++){
          if($i==$current_page){echo"[$i]";}
          else{echo"&nbsp;<a href='?page=$i#order' title='หน้า $i'>$i</a>&nbsp;";}
        }
        //ถัดไป
        if($page_end<$total_pages){
          $pg=$page_end+1;
          echo"&nbsp;<a href='?page=$pg#order' title='หน้า $pg'>...</a>&nbsp;";
        }
        if($current_page<$total_pages){
          $pg=$current_page+1;
          echo"&nbsp;<a href='?page=$pg#order' title='หน้า $pg'>ถัดไป</a>&nbsp;";
        }
        ?>
    	</td>
  	</tr>
</table>       
    
					</div><!-- table-responsive -->


       
                    
                </div>
         	</div><!-- box -->
            
            
			 <?
            $sql="SELECT wishlist.member_id AS member_id, wishlist.product_id AS product_id, product.image AS product_image, product.name AS product_name, product.display AS product_display FROM wishlist, product WHERE wishlist.member_id=$rowMember[id] AND product.id=wishlist.product_id AND product.status!='หมด' ORDER BY wishlist.id";
            $result=mysql_query($sql)or die(mysql_error());
            $num=mysql_num_rows($result);
            ?>
         	<a name="wishlist" id="wishlist"></a>
            <div class="col-md-12 col-sm-12 col-xs-12 box" id="member-wishlist">
                <h3 class="box-header" style="text-align:left;">รายการสินค้าที่เก็บไว้ (<?=$num?> รายการ)</h3>
                <div class="box-content col-md-12 col-sm-12 col-xs-12">
					<?
                    for($i=1;$i<=$num;$i++){$row=mysql_fetch_array($result);
                    ?>
                    <div class="col-md-3 col-sm-4 col-xs-12 favorite-item" onmouseover="document.getElementById('<?=$i?>').style.display='block';" onmouseout="document.getElementById('<?=$i?>').style.display='none';">
                    
                        <a href="process/wishlistDelete.php?id=<?=$row['product_id']?>" onclick="return confirm('ลบ <?=$row['product_name']?> ออกจากรายการ ?')" id="<?=$i?>" title="ลบ" class="trash"><img src="image/icon-trash.gif"/></a>
                        <a href="สินค้า-<?=$row['product_id']."-".rewrite_url($row['product_name'])?>.html" title="<?=$row['product_name']?>" target="_blank"><img src="product/<?=$row['product_image']?>" alt="<?=$row['product_name']?>" width="100%"/></a>
                        
                    </div>
                    <?
                    }
                	?>	
            	</div>
         	</div><!-- box -->
           	
            
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
    <th style="text-align:left;">ข้อมูลสมาชิก</th>
  </tr>
  <tr>
    <td>
<form action="process/memberUpdate.php" method="post" name="memberUpdate">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="100">ชื่อ - นามสกุล</td>
    <td><input name="fullname" type="text" required value="<?=$rowMember['fullname']?>" style="width:200px;"/></td>
  </tr>
  <tr>
    <td>ที่อยู่</td>
    <td><textarea name="address" rows="4" required style="width:300px;max-width:500px;"><?=$rowMember['address']?></textarea>
    </td>
  </tr>
  <tr>
    <td>รหัสไปรษณีย์</td>
    <td><input type="text" name="zipcode" required value="<?=$rowMember['zipcode']?>" style="width:60px;"/></td>
  </tr>
  <tr>
    <td>วันเกิด</td>
    <td>
	  <script>DateInput('birthdate',true,'YYYY-MM-DD','<?=$rowMember['birthdate']?>')</script>
      <!--<input type="button" onClick="alert(this.form.birthdate.value)" value="แสดงรูปแบบวันที่">-->
    </td>
  </tr>
  <tr>
    <td width="100">เบอร์ติดต่อ</td>
    <td><input type="text" name="tel" required value="<?=$rowMember['tel']?>" style="width:200px;"/></td>
  </tr>
  <tr>
    <td width="100">อีเมล</td>
    <td><input name="email" type="text" required value="<?=$rowMember['email']?>" readonly="readonly" style="background:#fafafa;width:200px;"/></td>
  </tr>
  <tr>
    <td><input type="hidden" name="id" value="<?=base64_encode($rowMember['id'])?>"/></td>
    <td><input type="submit" value="บันทึก"/></td>
  </tr>
</table>
</form>  
    </td>
  </tr>
</table>
*/ ?>
<? /*
<? 
//เพจที่แสดง
$current_page=1;
if(isset($_REQUEST['page'])){$current_page=intval($_REQUEST['page']);}
//จำนวนแถว
$rows_per_page=intval(15);
$start_row=intval(($current_page-1)*$rows_per_page);
$sql="SELECT SQL_CALC_FOUND_ROWS * FROM `order` WHERE member_id=$rowMember[id] ORDER BY id DESC LIMIT $start_row, $rows_per_page";
$result=mysql_query($sql)or die(mysql_error());
//แบ่งเพจ
$found_rows=mysql_query("SELECT FOUND_ROWS();");
$total_rows=mysql_result($found_rows,0,0);
$total_pages=ceil($total_rows/$rows_per_page);
?>
<a name="order" id="order"></a>
<table class="box" border="0" cellspacing="0" cellpadding="10">
    <tr>
      <th style="text-align:left;">ประวัติการสั่งซื้อ</th>
    </tr>
    <tr>
      <td>
<table align="center" cellpadding="5" cellspacing="1" class="list" >
  <tr>
    <th width="60">รหัส</th>
    <th width="120">จำนวนเงิน (บาท)</th>
    <th width="120">สถานะ</th>
    <th width="120">หมายเลขพัสดุ</th>
    <th width="120">วันที่สั่งซื้อ</th>
    <th class="list">จัดการ</th>
  </tr>
<?
if($total_rows==0){
?>
  <tr>
    <td align="center" colspan="6">ไม่มีข้อมูล (0 รายการ)</td>
  </tr>
<?
}
while($row=mysql_fetch_array($result)){
?>
  <tr>
   <td align="center"><?=$row['id']?></td>
   <td align="center"><?=number_format($row['total'],2)?></td>
   <td align="center"><?=$row['status']?></td>
   <td align="center"><? if($row['ems']!=""){echo $row['ems'];}else{echo "-";}?></td>
   <td align="center"><?=substr($row['insert_date'],0,16)?></td>
   <td align="center">
     <a href="payment.php?order_id=<?=$row['id']?>" target="_blank"><img src="image/icon-money.png" title="แจ้งการชำระเงิน" border="0"/></a>
     <a href="process/orderCancle.php?id=<?=$row['id']?>" onclick="return confirm('ต้องการยกเลิกรหัสคำสั่งซื้อ <?=$row['id']?> ?')"><img src="image/icon-cancle.png" class="action" title="ยกเลิก" border="0"/></a></td>
  </tr>
<?
}
?>
  <tr>
    <td colspan="6" align="right" style="font-size:12px;background:#fafafa;"><div style="float:left"><?=$total_rows?> รายการ</div>
<?
$page_range=5;
$page_start=$current_page-$page_range;
$page_end=$current_page+$page_range;
if($page_start<1){
  $page_end+=1-$page_start;
  $page_start=1;
}
if($page_end>$total_pages){
  $diff=$page_end-$total_pages;
  $page_start-=$diff;
  if($page_start<1){
    $page_start=1;  
  }
  $page_end=$total_pages;
}
//ย้อนกลับ
if($current_page>1){$pg=$current_page-1;
  echo"&nbsp;<a href='?page=$pg#order' title='หน้า $pg'>ย้อนกลับ</a>&nbsp;";
}
if($page_start>1){$pg=$page_start-1;
  echo"&nbsp;<a href='?page=$pg#order' title='หน้า $pg'>...</a>&nbsp;";
}
//แสดงหมายเลขเพจ
for($i=$page_start;$i<=$page_end;$i++){
  if($i==$current_page){echo"[$i]";}
  else{echo"&nbsp;<a href='?page=$i#order' title='หน้า $i'>$i</a>&nbsp;";}
}
//ถัดไป
if($page_end<$total_pages){
  $pg=$page_end+1;
  echo"&nbsp;<a href='?page=$pg#order' title='หน้า $pg'>...</a>&nbsp;";
}
if($current_page<$total_pages){
  $pg=$current_page+1;
  echo"&nbsp;<a href='?page=$pg#order' title='หน้า $pg'>ถัดไป</a>&nbsp;";
}
?>
    </td>
  </tr>
</table>       
    </td>
  </tr>
</table>
*/ ?>
<? /*
<a name="wishlist" id="wishlist"></a>
<?
$sql="SELECT wishlist.member_id AS member_id, wishlist.product_id AS product_id, product.image AS product_image, product.name AS product_name, product.display AS product_display FROM wishlist, product WHERE wishlist.member_id=$rowMember[id] AND product.id=wishlist.product_id AND product.status!='หมด' ORDER BY wishlist.id";
$result=mysql_query($sql)or die(mysql_error());
$num=mysql_num_rows($result);
?>

<table class="box" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <th style="text-align:left;">รายการสินค้าที่เก็บไว้ (<?=$num?> รายการ)</th>
  </tr>
  <tr>
    <td style="padding:0;">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="js/blocksit.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $(window).load( function(){
    $('#favorite').BlocksIt({
      numOfCol:5,
      offsetX:5,
      offsetY:5
    });
  });
  //window resize
  var currentWidth=1100;
  $(window).resize(function(){
    var winWidth=$(window).width();
	var conWidth;
	if(winWidth<660){
	  conWidth=440;
	  col=5
    }else if(winWidth<880){
	  conWidth=660;
	  col=5
	}else if(winWidth<1100){
	  conWidth=880;
	  col=5;
	}else{
	  conWidth=1100;
	  col=5;
	}
    if(conWidth!=currentWidth){
      currentWidth=conWidth;
	  $('#favorite').width(conWidth);
	  $('#favorite').BlocksIt({
        numOfCol:col,
		offsetX:5,
	   offsetY:5
      });
    }
  });
});
</script>
<div id="favorite">  
<?
for($i=1;$i<=$num;$i++){$row=mysql_fetch_array($result);
?>
  <div class="grid-favorite" <? if($row['product_display']>1){echo"data-size=$row[product_display]";}?> onmouseover="document.getElementById('<?=$i?>').style.display='block';" onmouseout="document.getElementById('<?=$i?>').style.display='none';">
    <div class="imgholder-favorite">
      <a href="process/wishlistDelete.php?id=<?=$row['product_id']?>" onclick="return confirm('ลบ <?=$row['product_name']?> ออกจากรายการ ?')" id="<?=$i?>" title="ลบ" style="display:none;" class="trash"><img src="image/icon-trash.gif"/></a>
      <a href="สินค้า-<?=$row['product_id']."-".rewrite_url($row['product_name'])?>.html" title="<?=$row['product_name']?>" target="_blank"><img src="product/<?=$row['product_image']?>" alt="<?=$row['product_name']?>"/></a>
    </div>
  </div>
<?
}
?>
</div>
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