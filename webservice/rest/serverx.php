<?php
header('Access-Control-Allow-Origin: *');
include_once('initconf.php');
include_once('functions.php');
$action = $_REQUEST['action'];
try {
    switch ($action) {
        case 'register':
            $return = register($_REQUEST);
            break;
        case 'login':
            $return = getUser($_REQUEST['username'], $_REQUEST['password']);
            break;
        case 'getallpage':
            $return = getPages();
            break;
        case 'getpage':
            $return = getPage($_REQUEST['page_name']);
            break;
        case 'addfooddata':
            $return = addFooddata($_REQUEST['food_id'],$_REQUEST['user_id']);
            break;
            
        default:
            $return = array('StatusCode' => 3, 'StatusMessage' => 'Sorry no action defined');
            break;
    }
} catch (Exception $exc) {
    $return = array('StatusCode' => 3, 'StatusMessage' => $exc->getMessage());
}
header('Content-type: application/json');
echo json_encode($return);
exit;
