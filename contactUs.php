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
        <title>ติดต่อเรา | <?=$rowSetting['title']?></title>
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
        <?
		if(isset($_SESSION['member'])){
		  $sqlMember="SELECT * FROM member WHERE username='$member'";
		  $resultMember=mysql_query($sqlMember)or die(mysql_error());
		  $rowMember=mysql_fetch_array($resultMember);
		  $username=$rowMember['username'];
		  $email=$rowMember['email'];
		}
		else{
		  $username="";
		  $email=""; 
		}
		?>

        <div class="col-md-9 col-sm-8 col-xs-12" id="contact-us">
        	<div class="col-md-12 col-sm-12 col-xs-12 box">
                <h3 class="box-header" style="text-align:left;">ติดต่อเรา</h3>
                
                <form class="col-md-12 col-sm-12 col-xs-12 pay-form" action="process/contactUs.php" method="post">
                    <div class="col-md-2 col-sm-3 col-xs-4">หัวข้อ</div>
                    <div class="col-md-10 col-sm-9 col-xs-8">
                        <input type="text" name="subject" maxlength="100" autofocus required style="width:70%;"/>
      					<input type="text" name="topic" style="display:none;"/>
                    </div>
                    <div style="clear:both"></div>
                    
                    
                    <div class="col-md-2 col-sm-3 col-xs-4">รายละเอียด</div>
                    <div class="col-md-10 col-sm-9 col-xs-8">
                        <textarea name="detail" rows="5" required style="width:70%"></textarea>
                    </div>
                    <div style="clear:both"></div>
                    
                     <div class="col-md-2 col-sm-3 col-xs-4">อีเมล</div>
                    <div class="col-md-10 col-sm-9 col-xs-8">
                        <input type="text" name="email" maxlength="100" required value="<?=$email?>" style="width:50%;"/>
                    </div>
                    <div style="clear:both"></div>
                    
                    <div class="col-md-2 col-sm-3 col-xs-4">ชื่อผู้ติดต่อ</div>
                    <div class="col-md-10 col-sm-9 col-xs-8">
                    	<input type="text" name="username" maxlength="50" required value="<?=$username?>" style="width:50%;"/>
	      				<input type="text" name="name" style="display:none;"/>
                    </div>
                    <div style="clear:both"></div>
                    

                   <div class="col-md-2 col-sm-3 col-xs-4"></div>
                   <div class="col-md-10 col-sm-9 col-xs-8">
                  		<input type="submit" value="ส่งข้อมูล"/>
                   </div>
                   <div style="clear:both"></div>
                   
                </form>
				<?
				$sqlDetail="SELECT * FROM page WHERE name='ติดต่อเรา'";
				$resultDetail=mysql_query($sqlDetail)or die(mysql_error());
				$rowDetail=mysql_fetch_array($resultDetail);
				if($rowDetail['detail']!=""){echo"<hr/>".$rowDetail['detail'];}
				?>
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
<?
if(isset($_SESSION['member'])){
  $sqlMember="SELECT * FROM member WHERE username='$member'";
  $resultMember=mysql_query($sqlMember)or die(mysql_error());
  $rowMember=mysql_fetch_array($resultMember);
  $username=$rowMember['username'];
  $email=$rowMember['email'];
}
else{
  $username="";
  $email=""; 
}
?>
<table class="box" border="0" cellspacing="0" cellpadding="10" style="display:none">
  <tr>
    <th style="text-align:left;">ติดต่อเรา</th>
  </tr>
  <tr>
    <td>
<form method="post" action="process/contactUs.php">
<table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td width="100">หัวข้อ</td>
    <td>
      <input type="text" name="subject" maxlength="100" autofocus required style="width:450px;max-width:450px;"/>
      <input type="text" name="topic" style="display:none;"/>
    </td>
  </tr>
  <tr>
    <td>รายละเอียด</td>
    <td>
      <textarea name="detail" rows="5" required style="width:450px;max-width:450px;"></textarea>
    </td>
  </tr>
  <tr>
    <td>อีเมล</td>
    <td><input type="text" name="email" maxlength="100" required value="<?=$email?>" style="width:200px;"/></td>
  </tr>
  <tr>
    <td>ชื่อผู้ติดต่อ</td>
    <td>
      <input type="text" name="username" maxlength="50" required value="<?=$username?>" style="width:200px;"/>
      <input type="text" name="name" style="display:none;"/>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" value="ส่งข้อมูล"/></td>
  </tr>
</table>
</form> 
<?
$sqlDetail="SELECT * FROM page WHERE name='ติดต่อเรา'";
$resultDetail=mysql_query($sqlDetail)or die(mysql_error());
$rowDetail=mysql_fetch_array($resultDetail);
if($rowDetail['detail']!=""){echo"<hr/>".$rowDetail['detail'];}
?>
    </td>
  </tr>
</table>
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