<?php

require_once('fatsecret/config.php');
require_once('fatsecret/FatSecretAPI.php');
$API = new FatSecretAPI(API_KEY, API_SECRET);

function register($postData) {

    $return = array('StatusCode' => 0, 'StatusMessage' => 'Internal Error');
    $name = $postData['name'];
    $email = $postData['email'];
    $username = $postData['username'];
    $password = $postData['password'];
    $dob = $postData['dob'];
    $gender = $postData['gender'];

    $username_taken = false;
    $email_taken = false;

    if (isset($email) && !empty($email)) {
        $userss = mysql_query("select * from sugar_users where email='$email'");

        if (mysql_num_rows($userss) > 0) {
            $email_taken = true;
        }
    }

    if (isset($username) && !empty($username)) {
        $user = mysql_query("select * from sugar_users where username='$username'");

        if (mysql_num_rows($user) > 0) {
            $username_taken = true;
        }
    }

    if (!isset($name) || empty($name)) {
        $StatusCode = 0;
        $StatusMessage = 'Please provide name.';
        $return = array('StatusCode' => $StatusCode, 'StatusMessage' => $StatusMessage);
    } else if (!isset($email) || empty($email)) {
        $StatusCode = 0;
        $StatusMessage = 'Please provide email.';
        $return = array('StatusCode' => $StatusCode, 'StatusMessage' => $StatusMessage);
    } else if ($email_taken == true) {
        $StatusCode = 0;
        $StatusMessage = 'Email is already registered.';
        $return = array('StatusCode' => $StatusCode, 'StatusMessage' => $StatusMessage);
    } else if (!isset($username) || empty($username)) {
        $StatusCode = 0;
        $StatusMessage = 'Please provide your username.';
        $return = array('StatusCode' => $StatusCode, 'StatusMessage' => $StatusMessage);
    } else if ($username_taken == true) {
        $StatusCode = 0;
        $StatusMessage = 'Username is already taken.';
        $return = array('StatusCode' => $StatusCode, 'StatusMessage' => $StatusMessage);
    } else if (!isset($dob) || empty($dob)) {
        $StatusCode = 0;
        $StatusMessage = 'Please provide your date of birth.';
        $return = array('StatusCode' => $StatusCode, 'StatusMessage' => $StatusMessage);
    } else if (!isset($gender) || empty($gender)) {
        $StatusCode = 0;
        $StatusMessage = 'Please select your gender.';
        $return = array('StatusCode' => $StatusCode, 'StatusMessage' => $StatusMessage);
    } else {

        $sql = "INSERT INTO `sugar_users` set fullname='$name',email='$email',username='$username',password='" . md5($password) . "',joined_date='" . date("Y-m-d H:i:s") . "',dob='$dob',gender='$gender',user_type='U'";

        $res = mysql_query($sql) or die(mysql_error());
        if (mysql_affected_rows() == 1) {
            $StatusCode = 1;
            $StatusMessage = 'Success';
            $return = getUser($username, $password);
        } else {
            $StatusCode = 2;
            $StatusMessage = 'Some internal error occour. Please try again.';
            $return = array('StatusCode' => $StatusCode, 'StatusMessage' => $StatusMessage);
        }
    }

    //$return=array('StatusCode'=>$StatusCode,'StatusMessage'=>$StatusMessage);

    return $return;
}

function isValidEmail($emailAddress) {

    if (filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

////////////// Login Functionality ////////////////////
function getUser($username, $password) {
    $return = array('StatusCode' => 0, 'StatusMessage' => 'Internal Error');

    $username = mysql_real_escape_string($username);
    $password = mysql_real_escape_string($password);

    $sql = "SELECT * FROM `sugar_users` WHERE `username`='" . $username . "' AND `password`=MD5('" . $password . "')";

    $res = mysql_query($sql);
    if (mysql_num_rows($res) == 1) {
        $user = mysql_fetch_assoc($res);
        $return = array('StatusCode' => 1, 'StatusMessage' => 'Success', 'Result' => $user);
    } else {
        $return = array('StatusCode' => 0, 'StatusMessage' => 'Provided Username and Password does not match.');
    }
    return $return;
}

function getPages() {
    $return = array('StatusCode' => 0, 'StatusMessage' => 'Internal Error');
    $sql = "SELECT * FROM `sugar_cms` WHERE `status`='1'";

    $res = mysql_query($sql);
    if (mysql_num_rows($res) > 0) {
        $data = array();

        while ($row = mysql_fetch_array($res)) {
            $data[] = $row;
        }

        $return = array('StatusCode' => 1, 'StatusMessage' => 'Success', 'Result' => $data);
    } else {
        $return = array('StatusCode' => 0, 'StatusMessage' => 'No data found.');
    }
    return $return;
}

function getPage($page_name) {
    $return = array('StatusCode' => 0, 'StatusMessage' => 'Internal Error');
    $sql = "SELECT * FROM `sugar_cms` WHERE `pagename`='" . $page_name . "' and `status`='1'";

    $res = mysql_query($sql);
    if (mysql_num_rows($res) == 1) {
        $data = mysql_fetch_assoc($res);
        $return = array('StatusCode' => 1, 'StatusMessage' => 'Success', 'Result' => $data);
    } else {
        $return = array('StatusCode' => 0, 'StatusMessage' => 'No data found.');
    }
    return $return;
}

function addFooddata($food_id, $user_id = null) {
    global $API;

    if ($user_id != null) {

        $data = $API->getFoods($food_id);

        $food_id = $data->food_id;
        $food_name = $data->food_name;
        $food_type = $data->food_type;
        $food_url = $data->food_url;

        if (mysql_num_rows(mysql_query("select * from sugar_foods where food_id='$food_id'")) == 0) {
            mysql_query("insert into sugar_foods set food_id='$food_id',food_name='$food_name',food_type='$food_type',food_url='$food_url'") or die(mysql_error());
        }

//        mysql_query("delete from sugar_food_intake where userid='$user_id' and date_consume='".date("Y-m-d")."'");

        foreach ($data->servings->serving as $key => $srv) {
            mysql_query("insert into sugar_food_intake set userid='$user_id',serving_name='$srv->serving_description',food_id='$food_id',foodname='$food_name',calorie_consume='$srv->calories',sugar_consume='$srv->sugar',fat_consume='$srv->fat',protein_consume='$srv->protein',date_consume='" . date("Y-m-d H:i:s") . "'");
        }

        $return = array('StatusCode' => 1, 'StatusMessage' => 'Success');
    } else {
        $return = array('StatusCode' => 0, 'StatusMessage' => 'Provide user_id as parameter');
    }
    return $return;
}

?>