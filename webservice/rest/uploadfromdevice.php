<?php
ob_start();
session_start();


define('DB_DRIVER','mysql');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD', 'manager@123');
define('DB_DATABASE', 'projectloaf');

$conn= mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
mysql_select_db(DB_DATABASE, $conn) or die(mysql_error());


require_once("simpleImageresize.php");

$domRoot = 'C:/inetpub/wwwroot/htdocs/simqadmin';
$target_path = '../../product_image/';


if(isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name']!="")
		{
						
						
			$userfile_name = $_FILES['file']['name'];
			$userfile_tmp = $_FILES['file']['tmp_name'];
									
			$img_name =uniqid().".".end(explode('.',$userfile_name)); //original path
			$img=$target_path.$img_name;
		
			move_uploaded_file($userfile_tmp, $img); //image upload
			
			mysql_query("insert into `deals_product_img` (`pfile`) values('".$img_name."')");
			
			$fullpathImage = $domRoot."/product_image/".$img_name;
			if (file_exists($fullpathImage)){
				 $appfilepath = $domRoot."/app_product_image/".$img_name;
				if (!file_exists($appfilepath)){
                                   
                           
					$image = new SimpleImage();
					$image->load($fullpathImage);
					$image->resize(150,150);
					$image->save($appfilepath);
				}
			}
			
			 $imgid=mysql_insert_id();		
                        
                     
			//echo mysql_insert_id()."~"."http://54.187.12.17/htdocs/simqadmin/app_product_image/".$img_name;
			
		
			
		}
		
$postData=$_POST;
$action=$postData['actiontype'];
$pid=$postData['pid'];
//$imgid=$postData['imgid'];
$location=$postData['location'];
$name=addslashes($postData['name']);
$description=addslashes($postData['description']);
$type=addslashes($postData['type']);
$subtype=addslashes($postData['subtype']);
$stone_of=addslashes($postData['stone_of']);
$catname=addslashes(trim($postData['catname']));
$subcatname=addslashes(trim($postData['subcatname']));
$color=addslashes($postData['color']);
$benefits=addslashes($postData['benefits']);
$healing=addslashes($postData['healing']);
$fengshui=addslashes($postData['fengshui']);
$chakra=addslashes($postData['chakra']);
$origin=addslashes($postData['origin']);
$history=addslashes($postData['history']);
$mineral=addslashes($postData['mineral']);
$weight=addslashes($postData['weight']);
$size=addslashes($postData['size']);
$quantity=$postData['quantity'];
$price=$postData['price'];
$cost=$postData['cost'];
$supplier=addslashes($postData['supplier']);
$year=$postData['year'];
$qrcode=$postData['qrcode'];
$status=1;
$added_date=date("Y-m-d h:i:s");
$modify_date=date("Y-m-d h:i:s");
$agent=$postData['agent'];

///////////////// Retrieving Category ID /////////////////////////////////////
$categorySQL=mysql_query("SELECT cat_id FROM `deals_category_master` WHERE `cat_name`='".$catname."' and `user_id`='".$agent."' and `cat_parent` IS NULL");
if(mysql_num_rows($categorySQL)>0){ 
$fetchCategory=mysql_fetch_array($categorySQL);
$cat_id       = $fetchCategory['cat_id'];
}else{
$insertCategory=mysql_query("INSERT  INTO `deals_category_master` (`user_id`,`cat_name`,`cat_desc`,`cat_parent`,`cat_status`) VALUES ('".$agent."','".$catname."','', NULL, 'Active')");    
$cat_id       = mysql_insert_id();

}

///////////////// Retrieving SubCategory ID /////////////////////////////////////
$subCategorySQL=mysql_query("SELECT cat_id FROM `deals_category_master` WHERE `cat_name`='".$subcatname."' and `user_id`='".$agent."' and `cat_parent`='".$cat_id."'");
if(mysql_num_rows($subCategorySQL)>0){ 
$fetchSubCategory=mysql_fetch_array($subCategorySQL);
$subcat_id       = $fetchSubCategory['cat_id'];
}else{
$insertSubCategory=mysql_query("INSERT  INTO `deals_category_master` (`user_id`,`cat_name`,`cat_desc`,`cat_parent`,`cat_status`) VALUES ('".$agent."','".$subcatname."','','".$cat_id."','Active')");    
$subcat_id       = mysql_insert_id();



}

////////////////////////////Product Add/Update ////////////////////////////////////
        
 if($pid!="" &&  $action=="Edit") { 
      
 $sql="UPDATE `deals_product` SET  `location`= '".$location."', `name` ='".$name."', `description`='".$description."', `type`='".$type."', `subtype`='".$subtype."', `stone_of`='".$stone_of."', `catid`= '".$cat_id."', `subcat_id`= '".$subcat_id."', `color`='".$color."', `benefits`='".$benefits."', `healing`='".$healing."', `fengshui`='".$fengshui."', `chakra`= '".$chakra."', `origin`='".$origin."', `history`= '".$history."', `mineral`='".$mineral."', `weight`='".$weight."', `size`='".$size."', `quantity`='".$quantity."', `price`='".$price."', `cost`='".$cost."', `supplier`='".$supplier."', `year`='".$year."', `status`='".$status."' ,`modified_date`='".$modify_date."', `pro_sync`='2' WHERE  `qrcode`='".$qrcode."' AND `pid`='".$pid."' ";
	
$res=mysql_query($sql);   
//if(mysql_affected_rows()==1){
    
if($imgid>0){
mysql_query("DELETE FROM `deals_product_img`  WHERE `pro_id`='".$pid."' AND `imgid`<>'".$imgid."'");    
mysql_query("UPDATE `deals_product_img`  SET `pro_id`='".$pid."' WHERE `imgid`='".$imgid."'");
}
    
			     $StatusCode=1;
			     $StatusMessage='Product updated successfully';
			    
     
 } else{
  
          
$sql="INSERT INTO `deals_product`  ( `location`, `name`, `description`, `type`, `subtype`, `stone_of`, `catid`, `subcat_id`, `color`, `benefits`, `healing`, `fengshui`, `chakra`, `origin`, `history`, `mineral`, `weight`, `size`, `quantity`, `price`, `cost`, `supplier`, `year`, `qrcode`, `status`, `agent` ,`added_date`,`modified_date`)VALUES( '".$location."', '".$name."', '".$description."', '".$type."', '".$subtype."', '".$stone_of."', '".$cat_id."', '".$subcat_id."', '".$color."', '".$benefits."', '".$healing."', '".$fengshui."', '".$chakra."', '".$origin."', '".$history."', '".$mineral."', '".$weight."', '".$size."', '".$quantity."', '".$price."', '".$cost."', '".$supplier."', '".$year."', '".$qrcode."', '".$status."', '".$agent."' ,'".$added_date."','".$added_date."')";
	
$res=mysql_query($sql); 
$proid=mysql_insert_id();

if(mysql_affected_rows()==1){

if($imgid>0){
mysql_query("DELETE FROM `deals_product_img`  WHERE `pro_id`='".$proid."' AND `imgid`<>'".$imgid."'");    
mysql_query("UPDATE `deals_product_img`  SET `pro_id`='".$proid."' WHERE `imgid`='".$imgid."'");
}  

    
			     $StatusCode=1;
			     $StatusMessage='Product added successfully';
			     
		           
                             }else{
                             $StatusCode=0;
			     $StatusMessage='Something went wrong.Please try agin.';
			    
                             }
                             
         }   



 echo $StatusCode."~".$StatusMessage;


?>