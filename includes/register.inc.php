<?php
include ("guestImage.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$firstname				= $_POST['firstname'];
	$lastname				= $_POST['lastname'];
	$email					= $_POST['email'];
	$password				= password_hash($_POST['password'], PASSWORD_DEFAULT);
	
	if (isset($_POST['status'])){
		$status 				= 'r';
	}else{
		$status 				= 'u';
	}
	$confirm_password		= $_POST['confirm_password'];

	$errors = [];

	if (email_exists($email))
	{
		$errors[] = "$email is already registered.";
	}
	if ($_POST['password'] !== $_POST['confirm_password']){
		$errors[] = "The two password don't match";
	}

	if (!empty($errors)) {
		foreach ($errors as $error) {
			validation_errors($error);
		}
	}else{
		$sql = "INSERT INTO user (firstname, lastname, email, password, status,user_photo)
		VALUES ('$firstname', '$lastname', '$email', '$password', '$status', '$user_photo')";


		if ($conn->query($sql) === TRUE) {
			redirect("login.php");
			exit;

		} else {
			set_message("<p>Error: " . $sql . "<br>" . $conn->error . "</p>");
		}

		$conn->close();
	}
}
?>