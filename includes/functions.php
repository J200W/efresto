<?php
function email_exists($email) 
{
	global $conn;

	$sql = "SELECT user_id FROM user WHERE email = '$email'";

	$result = $conn->query($sql);

	if($result->num_rows == 1 ) {
		return true;
	} else {
		return false;
	}
}

function get_name($email) {
	global $conn;

	$sql = "SELECT firstname FROM user WHERE email = '$email'";

	$result = $conn->query($sql);

	$row = $result->fetch_assoc();

	return $row["firstname"];
}

function set_message($message) 
{
	if(!empty($message)){
		$_SESSION['message'] = $message;
	}else {
		$message = "";
	}
}

function display_message()
{
	if(isset($_SESSION['message'])) {
		echo $_SESSION['message'];

		unset($_SESSION['message']);
	}
}

function redirect($location){
	return header("Location: {$location}");
}

function validation_errors($error_message) 
{
$error_message = <<<DELIMITER

<div class="alert alert-danger alert-dismissible" role="alert">
  	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  	<strong>Warning!</strong> $error_message
 </div>
DELIMITER;

set_message($error_message);
}

function logged_in(){
	if(isset($_SESSION['email']) || isset($_COOKIE['email'])){
		return true;
	} else {
		return false;
	}
}

function get_photo($id) {
	global $conn;
	
	$query = "SELECT image_bin FROM photo where restaurant_id = '$id'";
    $result = $conn->query($query);
	$row=$result->fetch_row();
	if (isset($row[0])) return $row[0];
	return "";
}

function check_user($uid, $rid) {
	global $conn;

	if (isset($_SESSION["status"])) {
		if ($_SESSION["status"] == "a"){
			return true;
		}

		if ($_SESSION["status"] == "r"){
			$query = "SELECT * FROM restaurant where user_id = '$uid' and restaurant_id = '$rid'";
			$result = $conn->query($query);
			if (mysqli_num_rows($result) != 0) {
				return true;
			}
			else {
				return false;
			}
		}
	}
	return false;
}

function check_commentator($uid, $rid, $cid) {
	global $conn;

	if (isset($_SESSION["status"])) {
		if ($_SESSION["status"] == "a"){
			return true;
		}
			$query = "SELECT * FROM comment where user_id = '$uid' and restaurant_id = '$rid' and comment_id = '$cid'";
			$result = $conn->query($query);
			if (mysqli_num_rows($result) != 0) {
				return true;
			}
			else {
				return false;
			}
		
	}
	return false;
}

function get_bg($name){
	global $conn;
	
	$query = "SELECT bg_bin FROM bg where bg_name = '$name'";
    $result = $conn->query($query);
	$row=$result->fetch_row();
	if (isset($row[0])) return $row[0];
	return "";
}

function update_rate($id){
	global $conn;

	$sql_comment = "SELECT `rating` FROM `comment` where `restaurant_id` = '$id'";
    $result_comment = $conn->query($sql_comment);
    $count_comment = mysqli_num_rows($result_comment);
	if ($count_comment == 0) $count_comment = 1;
	$avg = 0;
	while($row=$result_comment->fetch_row()) {
		$avg = $avg + $row[0];
	}
	$avg = $avg / $count_comment;
	$avg = round($avg, 1);
	$sql = "UPDATE `restaurant` SET `rating`='$avg' WHERE `restaurant_id`= '$id'";
	$result = $conn->query($sql);
}

function many_comment($uid, $rid){
	global $conn;

	$sql = "SELECT * FROM comment WHERE user_id = '$uid' AND restaurant_id = '$rid'";
	$result = $conn->query($sql);
	$count = mysqli_num_rows($result);
	if ($count != 0) {
		return true;
	}
	return false;
}

function put_favorite($uid, $rid){
	global $conn;

	$sql = "INSERT INTO `favorite`(`restaurant_id`, `user_id`) 
	VALUES ('$rid','$uid')";

	$result = $conn->query($sql);
}

function is_favorite($uid, $rid){
	global $conn;

	$sql = "SELECT * FROM favorite WHERE user_id = '$uid' AND restaurant_id = '$rid'";
	$result = $conn->query($sql);
	$count = mysqli_num_rows($result);
	if ($count == 0){
		return false;
	}
	return true;
}

function add_fav($uid, $rid) {
	global $conn;

	$sql = "INSERT INTO `favorite`(`restaurant_id`, `user_id`) 
	VALUES ('$rid','$uid')";
	$result = $conn->query($sql);
}

function delete_fav($uid, $rid){
	global $conn;

	$sql = "DELETE FROM favorite WHERE restaurant_id = '$rid' AND user_id = '$uid'";
	$result = $conn->query($sql);
}

function delete_restaurant($rid){
	global $conn;

	$sql = "DELETE FROM restaurant WHERE restaurant_id = '$rid'";
	$result = $conn->query($sql);

	if ($result === TRUE){
		header("location: mainPage.php");
		exit;
	}
}


function generateRandomString($length = 14) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function check_restaurant($id){
	global $conn;

	$sql = "SELECT * FROM restaurant WHERE `restaurant_id` = '$id'";
	$result = $conn->query($sql);
    $count = mysqli_num_rows($result);
	if ($count == 0){
		return false;
	}
	if ($count > 1) return false;
	return true;
}

?>