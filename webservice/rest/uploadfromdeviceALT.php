<?php
ob_start();
session_start();


define('DB_DRIVER','mysql');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD', 'manager@123');
define('DB_DATABASE', 'projectloaf');

$conn= mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
mysql_select_db(DB_DATABASE, $conn);

require_once("simpleImageresize.php");

$domRoot = 'C:/inetpub/wwwroot/htdocs/simqadmin';
$target_path = '../../product_image/';
 if(isset($_FILES['file']['name']) && $_FILES['file']['name']!="")
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
			
									
			echo mysql_insert_id()."~"."http://54.187.12.17/htdocs/simqadmin/app_product_image/".$img_name;
			
		
			
		}
		
		


?>