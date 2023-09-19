<?php
include ("includes/init.php");

//checking
$photo_id = $_GET['id'];
$query = "DELETE FROM `photo` WHERE photo_id='$photo_id'";

if(mysqli_query($conn, $query)){
    header("Location:modifyRestaurantImage.php");
} else{
    echo "error in deleting the record";
}