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
   	 	<title><?=$rowSetting['title']?></title>
    	<meta name="description" content="<?=$rowSetting['description']?>"/>
    	<?=$rowSetting['google_analytics']?>
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

        <!-- Pop Up -->
        <!--<script src="facefiles/jquery-1.2.2.pack.js" type="text/javascript"></script>-->
        <link href="facefiles/facebox.css" media="screen" rel="stylesheet" type="text/css" />
        <script src="facefiles/facebox.js" type="text/javascript"></script>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
              $('a[rel*=facebox]').facebox() 
            })
        </script>
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
<!-- InstanceBeginEditable name="Slideshow" -->



<?
if($rowPlus['html_1']!=""&&empty($_GET['page'])){
?>
<div class="container">
    <div class="row">
         <?php if ($rowSetting['show_slide'] == '1') { ?>
    	<div class="col-md-12 col-sm-12">

        	<div class="col-md-12 col-sm-12" id="slideshow">
				<? 
                $sqlSlideshow="SELECT * FROM slideshow ORDER BY last_update DESC";
                $resultSlideshow=mysql_query($sqlSlideshow)or die(mysql_error());
                $numSlideshow=mysql_num_rows($resultSlideshow);
                if($numSlideshow>0&&empty($_GET['page'])){
                ?>
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="max-height:500px;overflow:hidden">
                    <? #Indicators ?>
                    <?php /*<ol class="carousel-indicators">
                        <?php
                        for ($i = 0; $i <= $numSlideshow - 1; $i++) {
                        ?>
                        <li data-target="#carousel-example-generic" data-slide-to="<?=$i?>" <?php if ($i == 0) echo 'class="active"'; ?>></li>
                        <?
                        }
                        ?>
                    </ol>*/ ?>
            
                    <? #Wrapper for slides ?>
                    <div class="carousel-inner" role="listbox">
         
                        <?php
                        for ($i=1;$i<=$numSlideshow;$i++) {
                            $rowSlideshow=mysql_fetch_array($resultSlideshow);
                        ?>
                        <div class="item <?php if ($i == 1) echo 'active'; ?>">
                            <a href="<?=$rowSlideshow['link']?>" target="_blank" title="<?=$rowSlideshow['title']?>">
                                <img src="slideshow/<?=$rowSlideshow['image']?>" alt="<?=$rowSlideshow['title']?>" width="100%"/>
                                <!--<img src="http://placehold.it/1400x500" alt="<?=$rowSlideshow['title']?>"/>-->
                                
                            </a>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
        
                    <? #Controls ?>
                    <!-- <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a> -->
                </div>
                <? 
                }
                ?>
        	</div>
  		</div>
		<?php } #End SlideShow ?>
        
  
    
    	<div class="col-md-12 col-sm-12">
            <div class="col-md-12 col-sm-12 box">
                <div class="box-content">
                    <?=$rowPlus['html_1']?>     	
                </div>
            </div>
    	</div>
        
    </div><?php #Row ?>
</div><?php #Container ?>
<div style="clear:both"></div>
<?
}
?>


<!-- Pop Up -->
<a href="#mydiv" rel="facebox" id="zzzzz" style="display:none">View DIV with id="mydiv" on the page</a>
<div id="mydiv" style="display:none">
  <?php echo $rowPlus['pop_up']; ?>
</div>
<!---->
<!-- InstanceEndEditable -->


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
 <!--                   
<div class="fb-page" data-href="<?=$rowSetting['facebook_fanpage']?>" data-width="100%" data-height="300" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/facebook"><a href="https://www.facebook.com/facebook">Facebook</a></blockquote></div></div>-->

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
<?php 
if (empty($_GET['page'])) {
$sql="SELECT * FROM product WHERE status='ใหม่'";
$result=mysql_query($sql)or die(mysql_error());
$num=mysql_num_rows($result);
if($num>0){
?>
<div class="col-md-9 col-sm-8 search-product">
   <div class="col-md-12 col-sm-12 box" style="margin-bottom:20px;">
       <h3 class="box-header" style="text-align:left;">สินค้าใหม่</h3>
       <div class="box-content">
           <span style="float:left">ทั้งหมด <?=$num;?> รายการ</span>

             <form name="search" method="post" action="ค้นหาสินค้า.html" style="text-align:right;">
               <input type="text" name="search" pattern="[a-zA-Z0-9ก-๙]+" required title="ห้ามมีอักขระพิเศษ"/>
               <input type="submit" value="ค้นหา" />
           </form>
       </div>
   </div>
</div>
<div class="col-md-9 col-sm-8 product-list">
<?php
while($row=mysql_fetch_array($result)){
?>
	<div class="col-md-4 col-sm-6 col-xs-12" onmouseover="document.getElementById('product-<?=$row['id']?>').style.display='block';" onmouseout="document.getElementById('product-<?=$row['id']?>').style.display='none';">
	    <a href="process/wishlist.php?id=<?=$row['id']?>" class="favorite" id="product-<?=$row['id']?>" title="เก็บไว้ดูภายหลัง" target="_blank"><img src="image/icon-heart.gif" alt="wishlist"/></a>

	    <a  href="สินค้า-<?=$row['id']."-".rewrite_url($row['name'])?>.html" title="<?=$row['name']?>" class="thumbnail">
	        <img src="product/<?=$row['image']?>" alt="<?=$row['name']?>"/> <!-- style="height:250px;" -->
	        <strong><?=$row['name']?></strong>
	        <? 
	        if($row['normal_price']>0&&$row['status']!='หมด'){echo"<span class='discount'>".number_format($row['normal_price'])."</span>&nbsp;";} 
	        if($row['status']!='หมด'){echo"<span class='price'>".number_format($row['price'])." บาท</span>";} 
	        else{echo"<span class='out-of-stock'>สินค้าหมดชั่วคราว</span>";}
	        if($row['discount']>0){
	            echo"<img src='image/$rowDecoration[template_color]/ribbon-right.png' class='ribbon' alt='ลดราคา'/>";
	            echo"<span class='sale'>-$row[discount]%</span>";
	        }
	        ?>
	    </a>
	</div>
	<?php 
	if ($i % 2 == 0) { echo '<div class="clearfix2"></div>'; }
	if ($i % 3 == 0) { echo '<div class="clearfix3"></div>'; }
	} ?>
	<div class="clearfix"></div>
</div>
<?php 
  	}
} 
?>

<?php 
if (empty($_GET['page'])) {
$sql="SELECT * FROM product WHERE status='แนะนำ'";
$result=mysql_query($sql)or die(mysql_error());
$num=mysql_num_rows($result);
if($num>0){
?>
<div class="col-md-9 col-sm-8 search-product">
   <div class="col-md-12 col-sm-12 box" style="margin-bottom:20px;">
       <h3 class="box-header" style="text-align:left;">สินค้าใหม่</h3>
       <div class="box-content">
           <span style="float:left">ทั้งหมด <?=$num;?> รายการ</span>

             <form name="search" method="post" action="ค้นหาสินค้า.html" style="text-align:right;">
               <input type="text" name="search" pattern="[a-zA-Z0-9ก-๙]+" required title="ห้ามมีอักขระพิเศษ"/>
               <input type="submit" value="ค้นหา" />
           </form>
       </div>
   </div>
</div>
<div class="col-md-9 col-sm-8 product-list">
<?php
while($row=mysql_fetch_array($result)){
?>
	<div class="col-md-4 col-sm-6 col-xs-12" onmouseover="document.getElementById('product-<?=$row['id']?>').style.display='block';" onmouseout="document.getElementById('product-<?=$row['id']?>').style.display='none';">
	    <a href="process/wishlist.php?id=<?=$row['id']?>" class="favorite" id="product-<?=$row['id']?>" title="เก็บไว้ดูภายหลัง" target="_blank"><img src="image/icon-heart.gif" alt="wishlist"/></a>

	    <a  href="สินค้า-<?=$row['id']."-".rewrite_url($row['name'])?>.html" title="<?=$row['name']?>" class="thumbnail">
	        <img src="product/<?=$row['image']?>" alt="<?=$row['name']?>"/> <!-- style="height:250px;" -->
	        <strong><?=$row['name']?></strong>
	        <? 
	        if($row['normal_price']>0&&$row['status']!='หมด'){echo"<span class='discount'>".number_format($row['normal_price'])."</span>&nbsp;";} 
	        if($row['status']!='หมด'){echo"<span class='price'>".number_format($row['price'])." บาท</span>";} 
	        else{echo"<span class='out-of-stock'>สินค้าหมดชั่วคราว</span>";}
	        if($row['discount']>0){
	            echo"<img src='image/$rowDecoration[template_color]/ribbon-right.png' class='ribbon' alt='ลดราคา'/>";
	            echo"<span class='sale'>-$row[discount]%</span>";
	        }
	        ?>
	    </a>
	</div>
	<?php 
	if ($i % 2 == 0) { echo '<div class="clearfix2"></div>'; }
	if ($i % 3 == 0) { echo '<div class="clearfix3"></div>'; }
	} ?>
	<div class="clearfix"></div>
</div>
<?php 
  	}
} 
?>

<?php 
if (empty($_GET['page'])) {
$sql="SELECT * FROM product WHERE status='ขายดี'";
$result=mysql_query($sql)or die(mysql_error());
$num=mysql_num_rows($result);
if($num>0){
?>
<div class="col-md-9 col-sm-8 search-product">
   <div class="col-md-12 col-sm-12 box" style="margin-bottom:20px;">
       <h3 class="box-header" style="text-align:left;">สินค้าใหม่</h3>
       <div class="box-content">
           <span style="float:left">ทั้งหมด <?=$num;?> รายการ</span>

             <form name="search" method="post" action="ค้นหาสินค้า.html" style="text-align:right;">
               <input type="text" name="search" pattern="[a-zA-Z0-9ก-๙]+" required title="ห้ามมีอักขระพิเศษ"/>
               <input type="submit" value="ค้นหา" />
           </form>
       </div>
   </div>
</div>
<div class="col-md-9 col-sm-8 product-list">
<?php
while($row=mysql_fetch_array($result)){
?>
	<div class="col-md-4 col-sm-6 col-xs-12" onmouseover="document.getElementById('product-<?=$row['id']?>').style.display='block';" onmouseout="document.getElementById('product-<?=$row['id']?>').style.display='none';">
	    <a href="process/wishlist.php?id=<?=$row['id']?>" class="favorite" id="product-<?=$row['id']?>" title="เก็บไว้ดูภายหลัง" target="_blank"><img src="image/icon-heart.gif" alt="wishlist"/></a>

	    <a  href="สินค้า-<?=$row['id']."-".rewrite_url($row['name'])?>.html" title="<?=$row['name']?>" class="thumbnail">
	        <img src="product/<?=$row['image']?>" alt="<?=$row['name']?>"/> <!-- style="height:250px;" -->
	        <strong><?=$row['name']?></strong>
	        <? 
	        if($row['normal_price']>0&&$row['status']!='หมด'){echo"<span class='discount'>".number_format($row['normal_price'])."</span>&nbsp;";} 
	        if($row['status']!='หมด'){echo"<span class='price'>".number_format($row['price'])." บาท</span>";} 
	        else{echo"<span class='out-of-stock'>สินค้าหมดชั่วคราว</span>";}
	        if($row['discount']>0){
	            echo"<img src='image/$rowDecoration[template_color]/ribbon-right.png' class='ribbon' alt='ลดราคา'/>";
	            echo"<span class='sale'>-$row[discount]%</span>";
	        }
	        ?>
	    </a>
	</div>
	<?php 
	if ($i % 2 == 0) { echo '<div class="clearfix2"></div>'; }
	if ($i % 3 == 0) { echo '<div class="clearfix3"></div>'; }
	} ?>
	<div class="clearfix"></div>
</div>
<?php 
  	}
} 
?>


		<div class="col-md-9 col-sm-8" id="search-product">
            <div class="col-md-12 col-sm-12 box" style="margin-bottom:20px;">
                <h3 class="box-header" style="text-align:left;">รายการสินค้า</h3>
                <div class="box-content">
                &nbsp;
                   <!--  <form name="search" method="post" action="ค้นหาสินค้า.html" style="text-align:right;">
                        <input type="text" name="search" pattern="[a-zA-Z0-9ก-๙]+" required title="ห้ามมีอักขระพิเศษ"/>
                        <input type="submit" value="ค้นหา" />
                    </form> -->
                </div>
            </div>
     	</div>
        
        <div class="col-md-9 col-sm-8" id="product-list">	
			<?php
            //เพจที่แสดง
            $current_page=1;
            if(isset($_REQUEST['page'])){$current_page=intval($_REQUEST['page']);}
            //จำนวนแถว
            $rows_per_page=intval(24);
            $start_row=intval(($current_page-1)*$rows_per_page);
            $sql="SELECT SQL_CALC_FOUND_ROWS * FROM product ORDER BY pin DESC, id DESC LIMIT $start_row, $rows_per_page";
            $result=mysql_query($sql)or die(mysql_error());
            //แบ่งเพจ
            $found_rows=mysql_query("SELECT FOUND_ROWS();");
            $total_rows=mysql_result($found_rows,0,0);
            $total_pages=ceil($total_rows/$rows_per_page);
			$i = 1;
            while($row=mysql_fetch_array($result)){
            ?>
            <div class="col-md-4 col-sm-6 col-xs-12" onmouseover="document.getElementById('product-<?=$row['id']?>').style.display='block';" onmouseout="document.getElementById('product-<?=$row['id']?>').style.display='none';">
            
                <a href="process/wishlist.php?id=<?=$row['id']?>" class="favorite" id="product-<?=$row['id']?>" title="เก็บไว้ดูภายหลัง" target="_blank"><img src="image/icon-heart.gif" alt="wishlist"/></a>
            
                <a  href="สินค้า-<?=$row['id']."-".rewrite_url($row['name'])?>.html" title="<?=$row['name']?>" class="thumbnail">
                    <img src="product/<?=$row['image']?>" alt="<?=$row['name']?>"/> <!-- style="height:250px;" -->
                    <strong><?=$row['name']?></strong>
                    <? 
                    if($row['normal_price']>0&&$row['status']!='หมด'){echo"<span class='discount'>".number_format($row['normal_price'])."</span>&nbsp;";} 
                    if($row['status']!='หมด'){echo"<span class='price'>".number_format($row['price'])." บาท</span>";} 
                    else{echo"<span class='out-of-stock'>สินค้าหมดชั่วคราว</span>";}
                    if($row['discount']>0){
                        echo"<img src='image/$rowDecoration[template_color]/ribbon-right.png' class='ribbon' alt='ลดราคา'/>";
                        echo"<span class='sale'>-$row[discount]%</span>";
                    }
                    ?>
                </a>
            </div>
            <?php 
				if ($i % 2 == 0) { echo '<div class="clearfix2"></div>'; }
				if ($i % 3 == 0) { echo '<div class="clearfix3"></div>'; }
				$i++;
            } 
            ?>
            
            
            <div class="col-md-12 col-sm-12 col-xs-12" id="pagination">
				<?
                $page_range=2;
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
                ?>
				<hr/>
                <?
                //ย้อนกลับ
				if($current_page>1){$pg=$current_page-1;
				  	echo"<a href='รายการสินค้า-$pg.html' class='button' title='หน้า $pg'>ย้อนกลับ</a>"; //&nbsp;
				}
				if($page_start>1){$pg=$page_start-1;
				  	echo"<a href='รายการสินค้า-$pg.html' title='หน้า $pg'>...</a>";
				}
				//แสดงหมายเลขเพจ
				for($i=$page_start;$i<=$page_end;$i++){
				  	if($i==$current_page){echo"<span>$i</span>";}
				  	else{echo"<a href='รายการสินค้า-$i.html' title='หน้า $i'>$i</a>";}
				}
				
				//ถัดไป
				if($page_end<$total_pages){
				  	$pg=$page_end+1;
				  	echo"<a href='รายการสินค้า-$pg.html'  title='หน้า $pg'>...</a>";
				}
				if($current_page<$total_pages){
				  	$pg=$current_page+1;
				  	echo"<a href='รายการสินค้า-$pg.html' class='button' title='หน้า $pg'>ถัดไป</a>";
				}
				?>
				<hr style="margin-bottom:0px;"/>
			</div><!-- pagination -->　
            
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
<!--
<table class="box" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <th style="text-align:left;">รายการสินค้าทั้งหมด</th>
  </tr>
  <tr>
    <td>
<form name="search" method="post" action="ค้นหาสินค้า.html" style="text-align:right;">
<input type="text" name="search" pattern="[a-zA-Z0-9ก-๙]+" required title="ห้ามมีอักขระพิเศษ"/>
<input type="submit" value="ค้นหา" />
</form>
    </td>
  </tr>
</table>
-->
<!-- InstanceEndEditable -->

<!-- InstanceBeginEditable name="EditRegion_2" -->
<?
/*
//เพจที่แสดง
$current_page=1;
if(isset($_REQUEST['page'])){$current_page=intval($_REQUEST['page']);}
//จำนวนแถว
$rows_per_page=intval(24);
$start_row=intval(($current_page-1)*$rows_per_page);
$sql="SELECT SQL_CALC_FOUND_ROWS * FROM product ORDER BY pin DESC, id DESC LIMIT $start_row, $rows_per_page";
$result=mysql_query($sql)or die(mysql_error());
//แบ่งเพจ
$found_rows=mysql_query("SELECT FOUND_ROWS();");
$total_rows=mysql_result($found_rows,0,0);
$total_pages=ceil($total_rows/$rows_per_page);
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="js/blocksit.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $(window).load( function(){
    $('#container').BlocksIt({
      numOfCol:3,
      offsetX:10,
      offsetY:10
    });
  });
  //window resize
  var currentWidth=1100;
  $(window).resize(function(){
    var winWidth=$(window).width();
	var conWidth;
	if(winWidth<500){
	  conWidth=750;
	  col=3;
	}else{
	  conWidth=750;
	  col=3;
	}
    if(conWidth!=currentWidth){
      currentWidth=conWidth;
	  $('#container').width(conWidth);
	  $('#container').BlocksIt({
        numOfCol:col,
		offsetX:10,
	   offsetY:10
      });
    }
  });
});
</script>
  <div class="section"> 
<div id="container" style="display:none;">
<?
while($row=mysql_fetch_array($result)){
?>
  <div class="grid" <? if($row['display']>1){echo"data-size=$row[display]";}?> onmouseover="document.getElementById('product-<?=$row['id']?>').style.display='block';" onmouseout="document.getElementById('product-<?=$row['id']?>').style.display='none';">
    <div class="imgholder">
      <a href="process/wishlist.php?id=<?=$row['id']?>" class="favorite" id="product-<?=$row['id']?>" title="เก็บไว้ดูภายหลัง" target="_blank"><img src="image/icon-heart.gif" alt="wishlist"/></a>
      <a href="สินค้า-<?=$row['id']."-".rewrite_url($row['name'])?>.html" title="<?=$row['name']?>"><img src="product/<?=$row['image']?>" alt="<?=$row['name']?>" class="product"/></a>
    </div>
    <strong><?=$row['name']?></strong>
<? 
if($row['normal_price']>0&&$row['status']!='หมด'){echo"<span class='discount'>".number_format($row['normal_price'])."</span>&nbsp;";} 
if($row['status']!='หมด'){echo"<span class='price'>".number_format($row['price'])." บาท</span>";} 
else{echo"<span class='out-of-stock'>สินค้าหมดชั่วคราว</span>";}
if($row['discount']>0){
  echo"<img src='image/$rowDecoration[template_color]/ribbon-right.png' class='ribbon' alt='ลดราคา'/>";
  echo"<span class='sale'>-$row[discount]%</span>";
}
?>
  </div>
<?
}
?>
</div>
  </div>

<!-- InstanceEndEditable -->

<!-- InstanceBeginEditable name="EditRegion_3" -->
  <div id="page" style="display:none">
<hr style="margin-top:0;"/>
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
  echo"<a href='รายการสินค้า-$pg.html' class='button' title='หน้า $pg'>ย้อนกลับ</a>&nbsp;";
}
if($page_start>1){$pg=$page_start-1;
  echo"<a href='รายการสินค้า-$pg.html' class='number' title='หน้า $pg'>...</a>";
}
//แสดงหมายเลขเพจ
for($i=$page_start;$i<=$page_end;$i++){
  if($i==$current_page){echo"<span class='number-selected'>$i</span>";}
  else{echo"<a href='รายการสินค้า-$i.html' class='number' title='หน้า $i'>$i</a>";}
}
//ถัดไป
if($page_end<$total_pages){
  $pg=$page_end+1;
  echo"<a href='รายการสินค้า-$pg.html' class='number' title='หน้า $pg'>...</a>";
}
if($current_page<$total_pages){
  $pg=$current_page+1;
  echo"&nbsp;<a href='รายการสินค้า-$pg.html' class='button' title='หน้า $pg'>ถัดไป</a>";
}
?>
<hr style="margin-bottom:0;"/>
  </div>
<!--
<div class="addthis_toolbox addthis_floating_style addthis_counter_style" style="left:50px;bottom:50px;">
<a class="addthis_button_facebook_like" fb:like:layout="box_count"></a>
<a class="addthis_button_tweet" tw:count="vertical"></a>
<a class="addthis_button_google_plusone" g:plusone:size="tall"></a>
<a class="addthis_counter"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-509f293f694dcb74"></script>
-->
*/?>
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


<?php if($rowPlus['pop_up'] != '') : ?>
<script>
$(document).ready(function () {
   document.getElementById("zzzzz").click();
});
</script>
<?php endif; ?>