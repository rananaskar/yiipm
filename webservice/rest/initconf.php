<?php
error_reporting(0);
error_reporting(E_ERROR | E_PARSE);
$rootDirx= realpath(dirname(dirname(__FILE__)));
define('DS',DIRECTORY_SEPARATOR);
define('DIR_APP',$rootDirx.DS);



define('DB_DRIVER','mysql');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD', 'manager');
define('DB_DATABASE', 'sugarapp');



$conn= mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
mysql_select_db(DB_DATABASE, $conn);

/* Magic Quote GPC FIX */
// Magic Quotes Fix
//if (ini_get('magic_quotes_gpc')) {
function clean($data) {
        if (is_array($data)) {
                foreach ($data as $key => $value) {
                        $data[clean($key)] = clean($value);
                }
        } else {
                $data = mysql_real_escape_string($data);
        }

        return $data;
}

$_GET = clean($_GET);
$_POST = clean($_POST);
$_REQUEST = clean($_REQUEST);
$_COOKIE = clean($_COOKIE);


mysql_query("SET NAMES 'utf8'", $conn);
mysql_query("SET CHARACTER SET utf8", $conn);
mysql_query("SET CHARACTER_SET_CONNECTION=utf8", $conn);
mysql_query("SET SQL_MODE = ''", $conn);

//}
/* END Magic Quote GPC FIX */