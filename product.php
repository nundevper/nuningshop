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
        if(empty($_GET['id'])){echo"<script>window.location='".$rowSetting['website_name']."';</script>";exit();}
        $id=intval($_GET['id']);
		//เพิ่มจำนวนผู้เข้าชม
		if(!isset($_SESSION['username'])){
			$sql="UPDATE product SET view=(view+1) WHERE id=$id";
			mysql_query($sql)or die(mysql_error());
		}
		//สินค้า
		$sql="SELECT * FROM product WHERE id=$id";
		$result=mysql_query($sql)or die(mysql_error());
		$row=mysql_fetch_array($result);
		if(mysql_num_rows($result)==0){echo"<script>window.location='".$rowSetting['website_name']."';</script>";exit();}
		$keyword=$row['keyword'];
		
		$sqlCat = "SELECT * FROM product_category WHERE product_id = $id ORDER BY rand() LIMIT 0,1";
		$resultCat=mysql_query($sqlCat)or die(mysql_error());
		$rowCat=mysql_fetch_array($resultCat);
    	?>
        <title><? if($row['title']==""){echo $row['name'].' | '.$rowSetting['shop_name'];}else{echo $row['title'];}?></title>
        <meta name="description" content="<? if($row['description']==""){echo mb_substr(strip_tags($row['detail']),0,200,'UTF-8');}else{echo $row['description'];}?>"/>

        
        <link rel="stylesheet" href="css/style.css">
    	<!-- InstanceEndEditable -->
        
		<? 
if(empty($keyword)){echo"<meta name=\"keywords\" content=\"$rowSetting[keyword]\"/>";}
//else if(!empty($keyword)){echo"<meta name=\"keywords\" content=\"$keyword\"/>";}
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
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/imagepanner.js"></script>
        <script type="text/javascript" src="js/sagscroller.js"></script>
        <script>var sagscroller2=new sagscroller({id:'mysagscroller2', mode:'auto', pause:2500, animatespeed:400})</script>
        <script type="text/javascript" src="js/featuredcontentglider.js"></script>
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
      	<div class="col-md-6 col-sm-4 zproduct"> 
			<div class="col-md-12 col-sm-12 col-xs-12 box"> 
            	<h3 class="box-header" style="text-align:left"><?=$row['name']?></h3>
           		<div class="box-content" style="padding:0">
                    <?
					//รูปภาพประกอบ
					$sqlImage="SELECT * FROM product_image WHERE product_id=$id ORDER BY last_update DESC";
					$resultImage=mysql_query($sqlImage)or die(mysql_error());
					$numImage=mysql_num_rows($resultImage);
					if($numImage>0){
					?>
					<script type="text/javascript">
					  featuredcontentglider.init({
						gliderid:"canadaprovinces", //ID of main glider container
						contentclass:"glidecontent", //Shared CSS class name of each glider content
						togglerid:"p-select", //ID of toggler container
						remotecontent:"", //Get gliding contents from external file on server? "filename" or "" to disable
						selected:0, //Default selected content index (0=1st)
						persiststate:false, //Remember last content shown within browser session (true/false)?
						speed:300, //Glide animation duration (in milliseconds)
						direction:"leftright", //set direction of glide: "updown", "downup", "leftright", or "rightleft"
						autorotate:false, //Auto rotate contents (true/false)?
						autorotateconfig: [60000*3, 0] //if auto rotate enabled, set [milliseconds_btw_rotations, cycles_before_stopping]
					})
					</script>
					<?
					}
					?>
                 	<div id="canadaprovinces" class="glidecontentwrapper">
						<?
                        for($i=1;$i<=$numImage;$i++){$rowImage=mysql_fetch_array($resultImage);
                        ?>
                        <div class="glidecontent">
                            <div class="pancontainer" data-orient="center" data-canzoom="yes">
                                <div id="move">เลื่อนดูรายละเอียดเพิ่มเติม</div> 
                                <img src="product/<?=$rowImage['image']?>" alt="<?=$row['name']?>"/>
                            </div>
                        </div>
                    <?
                    }
                    ?>
                    </div>
                                       
                </div>
            </div>
            
            <div class="col-md-12 col-sm-12 col-xs-12 box"> 
                <h3 class="box-header" style="text-align:left;">รายละเอียดสินค้า</h3>
           		<div class="box-content">
                    <?
					//สั่งซื้อ
					$sqlOrder="SELECT SUM(amount) AS sum_amount FROM order_detail WHERE product_id=$id";
					$resultOrder=mysql_query($sqlOrder)or die(mysql_error());
					$rowOrder=mysql_fetch_array($resultOrder);
					//wishlist
					$sqlWishlist="SELECT COUNT(*) AS num_wishlist FROM wishlist WHERE product_id=$id";
					$resultWishlist=mysql_query($sqlWishlist)or die(mysql_error());
					$rowWishlist=mysql_fetch_array($resultWishlist);
					?>      

                    <span style="display:block;font-size:12px;">
						เข้าชม : <?=$row['view']?> |  สั่งซื้อไปแล้ว : <? if($rowOrder['sum_amount']>0){echo $rowOrder['sum_amount'];}else{echo 0;}?> | Wishlist Rate : <? if($rowWishlist['num_wishlist']>0){echo $rowWishlist['num_wishlist'];}else{echo 0;}?> 
                      	<a href="process/wishlist.php?id=<?=$id?>" class="button" style="font-size:9px;padding:1px 5px 1px 5px;float:right;" target="_blank">เพิ่มลง Wishlist</a>    
                    </span>
                    <hr/><?=$row['detail']?><hr/>
                    <!-- AddThis Button BEGIN -->
                    <div class="addthis_toolbox addthis_default_style ">
                        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                        <a class="addthis_button_tweet"></a>
                        <a class="addthis_button_pinterest_pinit"></a>
                        <a class="addthis_counter addthis_pill_style"></a>
                    </div>
                    <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50aaed2e70c6314f"></script>
                    <!-- AddThis Button END -->
                    <div style="line-height:24px;">
                    <? 
                    if($row['keyword']!=""){
						echo "<hr/>ป้ายกำกับ : ";
					  	$tag=explode(',', $row['keyword']);
					  	foreach($tag as $keyword){
							echo"<a href='ค้นหาสินค้า-".rewrite_url(trim($keyword))."-1.html' title='".$keyword."' class='tag'>".$keyword."</a>";
						}
                    }
                    ?>
                    </div>

                </div>
            </div>
            
            <div class="col-md-12 col-sm-12 col-xs-12 box"> 
                <h3 class="box-header" style="text-align:left;">แสดงความคิดเห็น</h3>
                <div class="box-content ">
					<div class="fb-comments" data-href="<?='http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?>" data-num-posts="5" data-width="100%"></div>
                </div>
			</div>
       </div><!-- zproduct -->
       
       <!-- aside right -->
       <div class="col-md-3 col-sm-4 zproduct">
      		<div class="col-md-12 col-sm-12 col-xs-12 box"> 
            	<h3 class="box-header">ภาพ</h3>
           		<div class="box-content">
                    <div id="p-select" class="glidecontenttoggler" style="margin-top:-10px">
						<?
                        //รูป
                        $sqlImage="SELECT * FROM product_image WHERE product_id=$id ORDER BY last_update DESC";
                        $resultImage=mysql_query($sqlImage)or die(mysql_error());
                        $numImage=mysql_num_rows($resultImage);
                        for($i=1;$i<=$numImage;$i++){$rowImage=mysql_fetch_array($resultImage);
                        ?>
                            <a href="#" class="toc"><img src="product/<?=$rowImage['image']?>" alt="<?=$row['name']?>"/></a>
                        <?
                        }
                        ?>
                            
                        <div style="text-align:center;position:relative;">  
                            <hr/>      
                            <? if($row['normal_price']>0){echo"<span class='discount'>".number_format($row['normal_price'])."</span><br/>";}?>
                            <span class="price"><?=number_format($row['price'])?> บาท</span>
                            <? 
                            if($row['discount']>0){
                                echo"<img src='image/$rowDecoration[template_color]/ribbon-right.png' id='ribbon-product' alt='ลดราคา' title='ลดราคา'/>";
                                echo"<span id='sale-product'>-$row[discount]%</span>";
                            }
                            ?>
                            <hr/> 
                            <? if($row['status']=='หมด'){echo"<span class='out-of-stock'>สินค้าหมดชั่วคราว</span>";}?>
                            
                            <form action="process/cartInsert.php" method="post" <? if($row['status']=='หมด'){echo"style='display:none;'";}?> >  
                                <?
                                $sqlOption="SELECT * FROM `product_option` WHERE product_id=$id AND name!=''";
                                $resultOption=mysql_query($sqlOption)or die(mysql_error());
                                $numOption=mysql_num_rows($resultOption);
                                if($numOption>0){
                                ?>
                                เลือกแบบสินค้าที่ต้องการ<br/>
                                <select name="option" style="width:100%">
                                    <?
                                    for($i=1;$i<=$numOption;$i++){$rowOption=mysql_fetch_array($resultOption);
                                        echo"<option value=\"$rowOption[id]\">$rowOption[name]</option>";
                                    }
                                    ?>
                                </select>
                                <hr/>
                                <?
                                }
                                else if($numOption==0){
                                    $sqlOption="SELECT * FROM `product_option` WHERE product_id=$id";
                                    $resultOption=mysql_query($sqlOption)or die(mysql_error());
                                    $rowOption=mysql_fetch_array($resultOption);
                                    echo"<input name='option' type='hidden' value='$rowOption[id]'/>";
                                }
                                ?>    
                                <input name="amount" type="hidden" value="1"/>
                                <input name="id" type="hidden" value="<?=$id?>"/>
                                <input id="addtocart" type="submit" value="เพิ่มลงตระกร้า" style="width:100%;"/>
                            </form>
                        </div>   

                    </div>
                </div>
          	</div>
         
         
            <?
			$sqlRelate="SELECT p.* FROM product AS p INNER JOIN product_category AS c ON p.id = c.product_id AND c.category_id = $rowCat[category_id] WHERE p.status!='หมด' ORDER BY rand() LIMIT 0,9";

			//$sqlRelate="SELECT * FROM product WHERE category_id=$row[category_id] AND status!='หมด' ORDER BY rand() LIMIT 0,9";
			$resultRelate=mysql_query($sqlRelate)or die(mysql_error());
			$numRelate=mysql_num_rows($resultRelate);
			if($numRelate>=3){
			?>
	        <div class="col-md-12 col-sm-12 col-xs-12 box">
            	<h3 class="box-header">สินค้าที่เกี่ยวข้อง</h3> 
           		<div class="box-content">
                    <div id="mysagscroller2" class="sagscroller">
  						<ul>
                        <?
					    for($i=1;$i<=$numRelate;$i++){$rowRelate=mysql_fetch_array($resultRelate);
						?> 
    						<li>
                                <div>
									<a href="สินค้า-<?=$rowRelate['id']."-".rewrite_url($rowRelate['name'])?>.html">                                       <img src="product/<?=$rowRelate['image']?>" alt="<?=$rowRelate['name']?>" title="<?=$rowRelate['name']?>"/>
                                    </a>
                                    <strong><?=$rowRelate['name']?></strong>
									<? if($rowRelate['normal_price']>0){echo"<span class='discount'>".number_format($rowRelate['normal_price'])."</span>";}?> 
                                    <span class="price"><?=number_format($rowRelate['price'])?> บาท</span>
                                </div>     
								<hr/>
    						</li>
                            <? 
							} 
							?>
                         
    						
                  		</ul>
                    </div>

                </div>
     		</div>
        </div>
        <?
		}
		?>
    
    	<!-- Tablet & Smart Phone -->
        <div class="col-md-9 col-sm-8 col-xs-12 zproduct-2">
       		<div class="col-md-12 col-sm-12 box">
            	<h3 class="box-header" style="text-align:left"><?=$row['name']?></h3>
            	<div class="col-md-12 col-sm-12 box-content">
                                  
                 	<div class="col-md-5 col-sm-12" style="padding:0;">
                        <?
						if($row['discount']>0){
							echo "<img src='image/$rowDecoration[template_color]/ribbon-left.png' class='ribbon-top-seller' alt='ลดราคา' title='ลดราคา'/>";
							echo "<span class='sale-top-seller'>-$row[discount]%</span>";
						}
						?>
                        
						<div class="slider-padding"> 
							<div id="product-slider" class="royalSlider rsDefault"> <!-- -vertical -->
                        
								<?
                                //รูป
                                $sqlImage="SELECT * FROM product_image WHERE product_id=$id ORDER BY last_update DESC";
                                $resultImage=mysql_query($sqlImage)or die(mysql_error());
                                $numImage=mysql_num_rows($resultImage);
                                for($i=1;$i<=$numImage;$i++){$rowImage=mysql_fetch_array($resultImage);
                                ?>
								<img style="width:100%" class="rsImg" src="product/<?=$rowImage['image']?>" data-rsTmb="product/<?=$rowImage['image']?>" alt="<?=$row['name']?>" />
                                <?
                                }
                                ?>
								
							</div>
						</div>
						<div style="clear:both"></div>
					</div>   
                    
                    <div class="col-md-7 col-sm-12" style="padding:0px 0px 10px 10px;">
                    	<hr class="zhr"/>
                    	<span style="display:block;font-size:12px;">
						เข้าชม : <?=$row['view']?> |  สั่งซื้อไปแล้ว : <? if($rowOrder['sum_amount']>0){echo $rowOrder['sum_amount'];}else{echo 0;}?> | Wishlist Rate : <? if($rowWishlist['num_wishlist']>0){echo $rowWishlist['num_wishlist'];}else{echo 0;}?> 
                      	<a href="process/wishlist.php?id=<?=$id?>" class="button" style="font-size:9px;padding:1px 5px 1px 5px;float:right;" target="_blank">เพิ่มลง Wishlist</a>    
                    </span>
                    	<hr/>
                        
                    	<?=$row['detail']?>
                        
                        <hr/>
 
                        <? if($row['normal_price']>0){echo"<span class='discount'>".number_format($row['normal_price'])."</span>";} ?>
						<span class="price"><?php echo number_format($row['price']); ?> บาท</span>
                        
                        
                        
                        <? if($row['status']=='หมด'){echo"<span style='float:right' class='out-of-stock'>สินค้าหมดชั่วคราว</span>";}?>
                        
                        <form action="process/cartInsert.php" method="post" <? if($row['status']=='หมด'){echo"style='display:none;'";}?> >  
                        	<hr/>
							<?
                            $sqlOption="SELECT * FROM `product_option` WHERE product_id=$id AND name!=''";
                            $resultOption=mysql_query($sqlOption)or die(mysql_error());
                            $numOption=mysql_num_rows($resultOption);
                            if($numOption>0){
                            ?>
                            	
                                เลือกแบบสินค้าที่ต้องการ<br/>
                                <select name="option" style="width:100%;margin-bottom:15px;">
                            <?
                                for($i=1;$i<=$numOption;$i++){$rowOption=mysql_fetch_array($resultOption);
                                    echo"<option value=\"$rowOption[id]\">$rowOption[name]</option>";
                                }
                            ?>
                                </select>
                            <?
							}
							else if($numOption==0){
							  	$sqlOption="SELECT * FROM `product_option` WHERE product_id=$id";
							  	$resultOption=mysql_query($sqlOption)or die(mysql_error());
							  	$rowOption=mysql_fetch_array($resultOption);
							  	echo"<input name='option' type='hidden' value='$rowOption[id]'/>";
							}
                            ?>
                            <input name="amount" type="hidden" value="1"/>
                            <input name="id" type="hidden" value="<?=$id?>"/>
                            <input id="addtocart" type="submit" value="เพิ่มลงตระกร้า" style="width:100%;"/>
                      	</form>
                        
						<?php
                        if($row['keyword']!=""){
							echo "<hr/>ป้ายกำกับ : ";
							$tag=explode(',', $row['keyword']);
							foreach($tag as $keyword){
								echo"<a href='ค้นหาสินค้า-".rewrite_url(trim($keyword))."-1.html' title='".$keyword."' class='tag'>".$keyword."</a>";
							}
                        }
                        ?>
					</div>
                    
                    
                  	<div style="clear:both;""></div>  
               </div>
          	</div>
            
            
            <div class="col-md-12 col-sm-12 col-xs-12 box"> 
                <h3 class="box-header" style="text-align:left;">แสดงความคิดเห็น</h3>
                <div class="box-content ">
					<div class="fb-comments" data-href="<?='http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?>" data-num-posts="5" data-width="100%"></div>
                </div>
			</div>
            

			<?php
			//$sqlRelate="SELECT * FROM product WHERE category_id=$row[category_id] AND status!='หมด' ORDER BY rand() LIMIT 0,4";
			$sqlRelate="SELECT p.* FROM product AS p INNER JOIN product_category AS c ON p.id = c.product_id AND c.category_id = $rowCat[category_id] WHERE p.status!='หมด' ORDER BY rand() LIMIT 0,4";
			$resultRelate=mysql_query($sqlRelate)or die(mysql_error());
			$numRelate=mysql_num_rows($resultRelate);
			if($numRelate>=3){
			?>

            <div class="col-md-12 col-sm-12 col-xs-12 box" id="related-product"> 
                <h3 class="box-header" style="text-align:left;">สินค้าที่เกี่ยวข้อง</h3>
                <div class="box-content col-md-12 col-sm-12 col-xs-12">
                	<?
					for($i=1;$i<=$numRelate;$i++){$rowRelate=mysql_fetch_array($resultRelate);
					?> 
                	<div class="col-md-3 col-sm-6 col-xs-12 related-item">
                    	<a href="สินค้า-<?=$rowRelate['id']."-".rewrite_url($rowRelate['name'])?>.html">
                        	<img src="product/<?=$rowRelate['image']?>" alt="<?=$rowRelate['name']?>.html" title="<?=$rowRelate['name']?>" style="width:100%"/>
                    	</a>
                    	<strong><?=mb_substr($rowRelate['name'],0,35,'UTF-8')?></strong>
						<?php 
                            if($rowRelate['normal_price']>0){echo"<span class='discount'>".number_format($rowRelate['normal_price'])."</span>";} 
                        ?> 
                    	<span class="price"><?=number_format($rowRelate['price'])?> บาท</span>
						
                	</div>
                    <?
                    	if ($i == 4) { break; }
						if ($i == 2) { echo '<div class="clearfix2"></div>'; }
                   	}
                  	?>
				</div>
        	</div>
            <?
			}
			?>




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

    <div style="width:500px;float:left;">
<? /*
<table class="box" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <th style="text-align:left;"><?=$row['name']?>&nbsp;</th>
    </tr>
  <tr>
    <td style="padding:0;">
<?
//รูปภาพประกอบ
$sqlImage="SELECT * FROM product_image WHERE product_id=$id ORDER BY last_update DESC";
$resultImage=mysql_query($sqlImage)or die(mysql_error());
$numImage=mysql_num_rows($resultImage);
if($numImage>0){
?>
<script type="text/javascript">
  featuredcontentglider.init({
    gliderid:"canadaprovinces", //ID of main glider container
    contentclass:"glidecontent", //Shared CSS class name of each glider content
    togglerid:"p-select", //ID of toggler container
    remotecontent:"", //Get gliding contents from external file on server? "filename" or "" to disable
    selected:0, //Default selected content index (0=1st)
    persiststate:false, //Remember last content shown within browser session (true/false)?
    speed:300, //Glide animation duration (in milliseconds)
    direction:"leftright", //set direction of glide: "updown", "downup", "leftright", or "rightleft"
    autorotate:false, //Auto rotate contents (true/false)?
    autorotateconfig: [60000*3, 0] //if auto rotate enabled, set [milliseconds_btw_rotations, cycles_before_stopping]
})
</script>
<?
}
?>
<div id="canadaprovinces" class="glidecontentwrapper">
<?
for($i=1;$i<=$numImage;$i++){$rowImage=mysql_fetch_array($resultImage);
?>
  <div class="glidecontent">
    <div class="pancontainer" data-orient="center" data-canzoom="yes">
      <div id="move">เลื่อนดูรายละเอียดเพิ่มเติม</div> 
      <img src="product/<?=$rowImage['image']?>" alt="<?=$row['name']?>"/>
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

<? /*
<table class="box" width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <th style="text-align:left;">รายละเอียดสินค้า</th>
    </tr>
  <tr>
    <td>
<?
//สั่งซื้อ
$sqlOrder="SELECT SUM(amount) AS sum_amount FROM order_detail WHERE product_id=$id";
$resultOrder=mysql_query($sqlOrder)or die(mysql_error());
$rowOrder=mysql_fetch_array($resultOrder);
//wishlist
$sqlWishlist="SELECT COUNT(*) AS num_wishlist FROM wishlist WHERE product_id=$id";
$resultWishlist=mysql_query($sqlWishlist)or die(mysql_error());
$rowWishlist=mysql_fetch_array($resultWishlist);
?>      
<span style="display:block;font-size:12px;">
  เข้าชม : <?=$row['view']?> |  สั่งซื้อไปแล้ว : <? if($rowOrder['sum_amount']>0){echo $rowOrder['sum_amount'];}else{echo 0;}?> | Wishlist Rate : <? if($rowWishlist['num_wishlist']>0){echo $rowWishlist['num_wishlist'];}else{echo 0;}?> 
  <a href="process/wishlist.php?id=<?=$id?>" class="button"  style="font-size:9px;padding:1px 5px 1px 5px;float:right;" target="_blank">เพิ่มลง Wishlist</a>    
</span>
<hr/><?=$row['detail']?><hr/>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<a class="addthis_button_pinterest_pinit"></a>
<a class="addthis_counter addthis_pill_style"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50aaed2e70c6314f"></script>
<!-- AddThis Button END -->
<div style="line-height:24px;">
<? 
if($row['keyword']!=""){
  echo "<hr/>ป้ายกำกับ : ";
  $tag=explode(',', $row['keyword']);
  foreach($tag as $keyword){
    echo"<a href='ค้นหาสินค้า-".rewrite_url(trim($keyword))."-1.html' title='".$keyword."' class='tag'>".$keyword."</a>";
   }
}
?>
</div>
    </td>
  </tr>
</table> 

<table class="box" width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <th style="text-align:left;">แสดงความคิดเห็น</th>
    </tr>
  <tr>
    <td>
<div class="fb-comments" data-href="<?='http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?>" data-num-posts="10" data-width="482"></div>
    </td>
    </tr>
</table> 
    </div>
    <div style="width:200px;float:right;">
<table class="box" width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <th>ภาพสินค้า</th>
  </tr>
  <tr>
    <td>
<div id="p-select" class="glidecontenttoggler">
<?
//รูป
$sqlImage="SELECT * FROM product_image WHERE product_id=$id ORDER BY last_update DESC";
$resultImage=mysql_query($sqlImage)or die(mysql_error());
$numImage=mysql_num_rows($resultImage);
for($i=1;$i<=$numImage;$i++){$rowImage=mysql_fetch_array($resultImage);
?>
<a href="#" class="toc"><img src="product/<?=$rowImage['image']?>" alt="<?=$row['name']?>"/></a>
<?
}
?>
</div>
<?
      echo"<hr/>";
?>
<div style="text-align:center;position:relative;">        
  <? if($row['normal_price']>0){echo"<span class='discount'>".number_format($row['normal_price'])."</span><br/>";}?>
  <span class="price"><?=number_format($row['price'])?> บาท</span>
  <? 
  if($row['discount']>0){
    echo"<img src='image/$rowDecoration[template_color]/ribbon-right.png' id='ribbon-product' alt='ลดราคา' title='ลดราคา'/>";
    echo"<span id='sale-product'>-$row[discount]%</span>";
  }
  ?>
  <hr/> 
  <? if($row['status']=='หมด'){echo"<span class='out-of-stock'>สินค้าหมดชั่วคราว</span>";}?>
<form action="process/cartInsert.php" method="post" <? if($row['status']=='หมด'){echo"style='display:none;'";}?> >  
<?
$sqlOption="SELECT * FROM `product_option` WHERE product_id=$id AND name!=''";
$resultOption=mysql_query($sqlOption)or die(mysql_error());
$numOption=mysql_num_rows($resultOption);
if($numOption>0){
?>
  เลือกแบบสินค้าที่ต้องการ<br/>
  <select name="option" style="width:100%">
<?
  for($i=1;$i<=$numOption;$i++){$rowOption=mysql_fetch_array($resultOption);
    echo"<option value=\"$rowOption[id]\">$rowOption[name]</option>";
  }
?>
  </select>
  <hr/>
<?
}
else if($numOption==0){
  $sqlOption="SELECT * FROM `product_option` WHERE product_id=$id";
  $resultOption=mysql_query($sqlOption)or die(mysql_error());
  $rowOption=mysql_fetch_array($resultOption);
  echo"<input name='option' type='hidden' value='$rowOption[id]'/>";
}
?>    
  <input name="amount" type="hidden" value="1"/>
  <input name="id" type="hidden" value="<?=$id?>"/>
  <input id="addtocart" type="submit" value="เพิ่มลงตระกร้า" style="width:100%;"/>
</form>
</div>
    </td>
    </tr>
</table>
<?
$sqlRelate="SELECT * FROM product WHERE category_id=$row[category_id] AND status!='หมด' ORDER BY rand() LIMIT 0,9";
$resultRelate=mysql_query($sqlRelate)or die(mysql_error());
$numRelate=mysql_num_rows($resultRelate);
if($numRelate>=3){
?>
<table class="box" width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <th>สินค้าที่เกี่ยวข้อง</th>
    </tr>
  <tr>
    <td>
<div id="mysagscroller2" class="sagscroller">
  <ul>
<?
  for($i=1;$i<=$numRelate;$i++){$rowRelate=mysql_fetch_array($resultRelate);
?>  
    <li>
<div>
  <a href="สินค้า-<?=$rowRelate['id']."-".rewrite_url($rowRelate['name'])?>.html">
    <img src="product/<?=$rowRelate['image']?>" alt="<?=$rowRelate['name']?>" title="<?=$rowRelate['name']?>"/>
  </a>
  <strong><?=$rowRelate['name']?></strong>
  <? if($rowRelate['normal_price']>0){echo"<span class='discount'>".number_format($rowRelate['normal_price'])."</span>";}?>   
  <span class="price"><?=number_format($rowRelate['price'])?> บาท</span>
</div>     
<hr/>
    </li>
<?
  }
?>
  </ul>
</div>
      </td>
    </tr>
</table>
<?
}
?>
*/ ?>
    </div>   
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
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="scripts/jquery.themepunch.revolution.min.js"></script>
<script src="scripts/jquery.themepunch.showbizpro.min.js"></script>
<script src="scripts/jquery.royalslider.min.js"></script>
<script src="scripts/custom.js"></script>
<?
if(isset($_SESSION['username'])){
?>
<a href="admin/productEdit.php?id=<?=base64_encode($id)?>" id="edit" target="_blank" title="แก้ไข"><img src="admin/image/edit.png"/></a>
<?	
}
?>