<?php
$name=$_REQUEST['name'];
$email=$_REQUEST['email'];
$phone=$_REQUEST['phone'];
$reference=$_REQUEST['reference'];
?>
<div style="background:#ededed; border:1px solid #ededed;"><div style="padding:17px 0 11px 0; margin:0; text-align:center;"><img src="http://mydedicatedresource.com/wp-content/themes/web_dreamers/img/home/logo.png"/></div>
    <div style="width:50%; margin:0 auto; padding:25px 0;">
        <div style="background:#fff; box-shadow:0 0 2px #ccc;  border-left:12px solid #c42c66; padding:36px; margin:0 0 15px 0; overflow:hidden; font:normal 16px/normal Arial; color:#373636; text-align:left;">
            <div style="width:40%; float:left; color:#c42c66;">Name:</div>
            <div style="width:60%; float:left;"><?=$name?></div>
        </div>

        <div style="background:#fff; box-shadow:0 0 2px #ccc;  border-left:12px solid #589a0a; padding:36px; margin:0 0 15px 0; overflow:hidden; font:normal 16px/normal Arial; color:#373636; text-align:left;">
            <div style="width:40%; float:left; color:#589a0a;">Email:</div>
            <div style="width:60%; float:left;"><?=$email?></div>
        </div>

        <div style="background:#fff;  box-shadow:0 0 2px #ccc;   border-left:12px solid #f28209; padding:36px; margin:0 0 15px 0; overflow:hidden; font:normal 16px/normal Arial; color:#373636; text-align:left;">
            <div style="width:40%; float:left; color:#f28209;">Phone Number:</div>
            <div style="width:60%; float:left;"><?=$phone?></div>
        </div>
        
        <div style="background:#fff; box-shadow:0 0 2px #ccc;  border-left:12px solid #589a0a; padding:36px; margin:0 0 15px 0; overflow:hidden; font:normal 16px/normal Arial; color:#373636; text-align:left;">
            <div style="width:40%; float:left; color:#589a0a;">IP:</div>
            <div style="width:60%; float:left;"><?php echo $_SERVER['REMOTE_ADDR']; ?></div>
        </div>
        
        <div style="background:#fff;  box-shadow:0 0 2px #ccc;   border-left:12px solid #f28209; padding:36px; margin:0 0 15px 0; overflow:hidden; font:normal 16px/normal Arial; color:#373636; text-align:left;">
            <div style="width:40%; float:left; color:#f28209;">Reference Page:</div>
            <div style="width:60%; float:left;">
                <a href="<?=$reference?>"><?=$reference?></a>
            </div>
        </div>

    </div>
</div>