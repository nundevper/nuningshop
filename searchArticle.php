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
<title>บทความ | <?=$rowSetting['title']?></title>
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
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="js/sagscroller.js"></script>
<script>var sagscroller2=new sagscroller({id:'mysagscroller2', mode:'auto', pause:2500, animatespeed:400})</script>
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
         <div class="col-lg-6 col-md-9 col-sm-8" id="article"> 
        
			<?
			//เพจที่แสดง
			$current_page=1;
			if(isset($_REQUEST['page'])){$current_page=intval($_REQUEST['page']);}
			if(empty($_REQUEST['search'])){echo"<script>window.location='บทความ-1.html';</script>";exit();}
			$search=str_replace("_"," ",htmlspecialchars($_REQUEST['search']));
			//จำนวนแถว
			$rows_per_page=intval(10);
			$start_row=intval(($current_page-1)*$rows_per_page);
			$sql="SELECT SQL_CALC_FOUND_ROWS * FROM article WHERE subject LIKE '%".mysql_escape_string($search)."%' OR keyword LIKE '%".$search."%' ORDER BY id DESC LIMIT $start_row, $rows_per_page";
			$result=mysql_query($sql)or die(mysql_error());
			//แบ่งเพจ
			$found_rows=mysql_query("SELECT FOUND_ROWS();");
			$total_rows=mysql_result($found_rows,0,0);
			$total_pages=ceil($total_rows/$rows_per_page);
			while($row=mysql_fetch_array($result)){
            ?>
			<div class="col-md-12 col-sm-12 col-xs-12 box"> 
            	<h3 class="box-header" style="text-align:left;"><?=$row['subject']?></h3>
           		<div class="box-content">
                    <div style="text-align:left;font-size:12px;">
                    	โดย : <?=$row['username']?> | เมื่อ : <?=substr($row['insert_date'],0,16)?> | เข้าชม : <?=$row['view']?>
                    </div>     
                    <hr/>
                    <? if($row['image']!=""){?>
                    <img src="article/<?=$row['image']?>" style="max-width:210px; float:left; margin:0 10px 10px 0;" alt="<?=$row['subject']?>" title="<?=$row['subject']?>"/>
                    <?
                    }
                    ?>
                    <?=strip_tags(mb_substr($row['detail'],0,800,"UTF-8"),"<p><a><br><u><strong><em>")?><? if(strlen(utf8_decode($row['detail']))>800){echo"...";}?>
                    &nbsp;&nbsp;<a href="บทความ-<?=$row['id']."-".rewrite_url($row['subject'])?>.html" title="อ่านต่อ" class="read-more">อ่านต่อ</a>
                </div>
            </div>
            <?
			}
			?>
            
            
            
           	<div class="col-md-12 col-sm-12 col-xs-12" id="pagination" style="margin-top:20px;padding-left:0;padding-righr:0;">
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
                  echo"<a href='บทความ-$pg.html' class='button' title='หน้า $pg'>ย้อนกลับ</a>&nbsp;";
                }
                if($page_start>1){$pg=$page_start-1;
                  echo"<a href='บทความ-$pg.html' class='number' title='หน้า $pg'>...</a>";
                }
                //แสดงหมายเลขเพจ
                for($i=$page_start;$i<=$page_end;$i++){
                  if($i==$current_page){echo"<span class='number-selected'>$i</span>";}
                  else{echo"<a href='บทความ-$i.html' class='number' title='หน้า $i'>$i</a>";}
                }
                //ถัดไป
                if($page_end<$total_pages){
                  $pg=$page_end+1;
                  echo"<a href='บทความ-$pg.html' class='number' title='หน้า $pg'>...</a>";
                }
                if($current_page<$total_pages){
                  $pg=$current_page+1;
                  echo"&nbsp;<a href='บทความ-$pg.html' class='button' title='หน้า $pg'>ถัดไป</a>";
                }
                ?>
                <hr style="margin-bottom:0;"/>
  			</div>
  
  
        </div>
        
        <div class="col-md-3 col-sm-4 zproduct">
        	<div class="col-md-12 col-sm-12 col-xs-12 box"> 
            	<h3 class="box-header">สินค้าแนะนำ</h3>
           		<div class="box-content">
		            <form action="ค้นหาบทความ.html" method="post" style="text-align:center;">
            			<input type="text" name="search" pattern="[a-zA-Z0-9ก-๙]+" required title="ห้ามมีอักขระพิเศษ" style="width:100%;margin-bottom:10px;"/>
			            <input type="submit" value="ค้นหา"/>
            		</form>
            	</div>
        	</div>
        </div>

        <div class="col-md-3 col-sm-4 zproduct">
			<?
            $sqlRecommend="SELECT * FROM product WHERE status!='หมด' ORDER BY rand() LIMIT 0,9";
            $resultRecommend=mysql_query($sqlRecommend)or die(mysql_error());
            $numRecommend=mysql_num_rows($resultRecommend);
            if($numRecommend>=3){
            ?>
      		<div class="col-md-12 col-sm-12 col-xs-12 box"> 
            	<h3 class="box-header">สินค้าแนะนำ</h3>
           		<div class="box-content">
                	<div id="mysagscroller2" class="sagscroller">
  						<ul>
                        <?
						
					    for($i=1;$i<=$numRecommend;$i++){$rowRecommend=mysql_fetch_array($resultRecommend);
						?> 
    						<li>
                                <div>
									<a href="สินค้า-<?=$rowRecommend['id']."-".rewrite_url($rowRecommend['name'])?>.html">                                       <img src="product/<?=$rowRecommend['image']?>" alt="<?=$rowRecommend['name']?>" title="<?=$rowRecommend['name']?>"/>
                                    </a>
                                    <strong><?=$rowRecommend['name']?></strong>
									<? if($rowRecommend['normal_price']>0){echo"<span class='discount'>".number_format($rowRecommend['normal_price'])."</span>";}?> 
                                    <span class="price"><?=number_format($rowRecommend['price'])?></span>
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
<? /*
    <div style="width:500px;float:left;">
<?
//เพจที่แสดง
$current_page=1;
if(isset($_REQUEST['page'])){$current_page=intval($_REQUEST['page']);}
if(empty($_REQUEST['search'])){echo"<script>window.location='บทความ-1.html';</script>";exit();}
$search=str_replace("_"," ",htmlspecialchars($_REQUEST['search']));
//จำนวนแถว
$rows_per_page=intval(10);
$start_row=intval(($current_page-1)*$rows_per_page);
$sql="SELECT SQL_CALC_FOUND_ROWS * FROM article WHERE subject LIKE '%".mysql_escape_string($search)."%' OR keyword LIKE '%".$search."%' ORDER BY id DESC LIMIT $start_row, $rows_per_page";
$result=mysql_query($sql)or die(mysql_error());
//แบ่งเพจ
$found_rows=mysql_query("SELECT FOUND_ROWS();");
$total_rows=mysql_result($found_rows,0,0);
$total_pages=ceil($total_rows/$rows_per_page);
while($row=mysql_fetch_array($result)){
?>
<table class="box" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <th style="text-align:left;"><?=$row['subject']?></th>
  </tr>
  <tr>
    <td>
<div style="text-align:left;font-size:12px;">
  โดย : <?=$row['username']?> | เมื่อ : <?=substr($row['insert_date'],0,16)?> | เข้าชม : <?=$row['view']?>
</div>     
<hr/>
<? 
if($row['image']!=""){
?>
<img src="article/<?=$row['image']?>" style="max-width:210px;float:left;margin:0 10px 10px 0;" alt="<?=$row['subject']?>"/>
<?
}
?>
<?=strip_tags(mb_substr($row['detail'],0,800,'UTF-8'),'<p><a><br><i><u>')?><? if (strlen(utf8_decode($row['detail']))>800){echo"...";}?>
&nbsp;&nbsp;<a href="บทความ-<?=$row['id']."-".rewrite_url($row['subject'])?>.html" class="read-more">อ่านต่อ</a>
    </td>
  </tr>
</table>
<?
}
if($total_rows==0){
?>
<table class="box" cellpadding="10">
  <tr>
    <th style="text-align:left;">0 ผลการค้นหา</th>
  </tr>
  <tr>
    <td style="text-align:center;">
      ไม่พบบทความที่ต้องการค้นหา<br/>
      <input type="button" onclick="window.location='บทความ-1.html';" value="กลับไปหน้าบทความ" style="margin-top:15px;"/>
    </td>
  </tr>
</table>
<?
}
?>
      <div style="clear:both;"></div>  
    </div>
    <div style="width:200px;float:right;">
<table class="box" width="100%" cellpadding="10">
  <tr>
    <th>ค้นหาบทความ</th>
  </tr>
  <tr>
    <td>
<form action="ค้นหาบทความ.html" method="post" style="text-align:center;">
<input type="text" name="search" pattern="[a-zA-Z0-9ก-๙]+" required autofocus title="ห้ามมีอักขระพิเศษ" value="<?=$search?>" style="width:165px;margin-bottom:10px;"/>
<input type="submit" value="ค้นหา"/>
</form>
    </td>
  </tr>
</table>  
<?
$sqlRecommend="SELECT * FROM product WHERE status!='หมด' ORDER BY rand() LIMIT 0,9";
$resultRecommend=mysql_query($sqlRecommend)or die(mysql_error());
$numRecommend=mysql_num_rows($resultRecommend);
if($numRecommend>=3){
?>
<table class="box" width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <th>สินค้าแนะนำ</th>
    </tr>
  <tr>
    <td>
<div id="mysagscroller2" class="sagscroller">
  <ul>
<?
  for($i=1;$i<=$numRecommend;$i++){$rowRecommend=mysql_fetch_array($resultRecommend);
?>  
    <li>
<div>
  <a href="สินค้า-<?=$rowRecommend['id']."-".rewrite_url($rowRecommend['name'])?>.html">
    <img src="product/<?=$rowRecommend['image']?>" alt="<?=$rowRecommend['name']?>" title="<?=$rowRecommend['name']?>"/>
  </a>
  <strong><?=$rowRecommend['name']?></strong>
  <? if($rowRecommend['normal_price']>0){echo"<span class='discount'>".number_format($rowRecommend['normal_price'])."</span>";}?>   
  <span class="price"><?=number_format($rowRecommend['price'])?> บาท</span>
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
    </div>
*/ ?>
<!-- InstanceEndEditable -->

<!-- InstanceBeginEditable name="EditRegion_2" -->
<? /*
  <div id="page" style="margin-top:20px;">
<hr style="margin-top:0;"/>
<?
$s=rewrite_url($search);
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
  echo"<a href='ค้นหาบทความ-$s-$pg.html' class='button' title='หน้า $pg'>ย้อนกลับ</a>&nbsp;";
}
if($page_start>1){$pg=$page_start-1;
  echo"<a href='ค้นหาบทความ-$s-$pg.html' class='number' title='หน้า $pg'>...</a>";
}
//แสดงหมายเลขเพจ
for($i=$page_start;$i<=$page_end;$i++){
  if($i==$current_page){echo"<span class='number-selected'>$i</span>";}
  else{echo"<a href='ค้นหาบทความ-$s-$i.html' class='number' title='หน้า $i'>$i</a>";}
}
//ถัดไป
if($page_end<$total_pages){
  $pg=$page_end+1;
  echo"<a href='ค้นหาบทความ-$s-$pg.html' class='number' title='หน้า $pg'>...</a>";
}
if($current_page<$total_pages){
  $pg=$current_page+1;
  echo"&nbsp;<a href='ค้นหาบทความ-$s-$pg.html' class='button' title='หน้า $pg'>ถัดไป</a>";
}
?>
<hr style="margin-bottom:0;"/>  
    </div>
*/ ?>
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