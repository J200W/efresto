<?php
include("includes/init.php");
$rname = $_SESSION['restaurant_name'];
$raddress = $_SESSION['restaurant_address'];

$query = "SELECT * FROM restaurant WHERE name='$rname' AND address='$raddress'";
$result = mysqli_query($conn, $query);
$rows = mysqli_num_rows($result);
if ($rows == 1) {
    $data = mysqli_fetch_array($result);
    $id = $data['restaurant_id'];


    //check that the data are sent to the database when btnSubmit pressed
    if (isset($_POST['btnSubmit'])) {
        //this is all the information abour the first image
        $imageName = $_FILES['photo']['name'];
        $imageType = $_FILES['photo']['type'];
        $imageTempLoc = $_FILES['photo']['tmp_name'];
        $imageSize = $_FILES['photo']['size'];
        $imageError = $_FILES['photo']['error'];
        //separate in the name of the image the two part separated by a point "image.jpg" 
        //in order to get the type of the image
        $fileExt = explode('.', $imageName);
        //if the type of the image in the name of the image is in upercase we transform it in lowercase
        $fileActualExt = strtolower(end($fileExt));
        //allow only some type of image file
        $allowed = array('jpg', 'jpeg', 'png');
        //convert our image in base64 format
        $image = base64_encode(file_get_contents($imageTempLoc));

        if (in_array($fileActualExt, $allowed)) {
            if ($imageError === 0) {
                if ($imageSize < 1000000000) {
                    //insert all the informations about a restaurant in the database
                    $query = "INSERT INTO photo(restaurant_id,image_bin) VALUES('$id','$image')";
                } else {
                    $sizeMessage = "Your file is too big!";
                }
            } else {
                $errorMessage = "There was an error uploading your file!";
            }
        } else {
            $allowedMessage = "You cannot upload files of this type!";
        }

        if (mysqli_query($conn, $query)) {
            $message = 'Your image has been added to your restaurant';
        } else {
            $message1 = 'Error in inserting information, please try again';
        }
    }
} else {
    echo "error";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/addImage.css">
    <link rel="stylesheet" href="css/basic.css">
    <title>Add Image to Restaurant </title>
    <link rel="icon" href="efresto.png">
</head>

<body>
    <div class="navbar">
        <input type="checkbox" id="check">
        <label for="check" id="checkbtn">
            <i class="fas fa-bars"><a href="#logoLink"></a></i>
        </label>
        <label class="logo"><a href="mainPage.php" id="logoLink">EFRESTO</a></label>
    </div>
    <div id="space"></div>

    <div class="createResto-box">
        <h2>Here is all the images related to your restaurant!</h2>
        <?php
        $sql_photo = "SELECT * FROM photo where restaurant_id = '$id'";
        $result_photo = $conn->query($sql_photo);
        $count_photo = mysqli_num_rows($result_photo);
        ?>

        <?php while ($row = $result_photo->fetch_row()) { ?>
            <?php echo '<img  src="data:image;base64,' . $row[2] . ' " width="400px";>' ?><br>
            <?php $photo_id = $row[0]; ?>
            <br>
            <div class="delete_button">
                <a class="btn btn-primary" href="deleteRestaurantImage.php?id=<?php echo $photo_id; ?>">Delete Image</a>
                <br>
            </div>
            <br>
        <?php } ?>
    </div>

    <div class="createResto-box">
        <form method="post" enctype="multipart/form-data">
            <h2>Add Photo to
                <?php echo $rname; ?>
            </h2><br>
            <div class="form-group">
                <input type="file" name="photo" required onchange="preview()"><br>
                <br>
                <img src="" width="400px" id="frame">
            </div>
            <div class="submit-button">
                <input type="submit" name="btnSubmit" value="Add Image" class="btn btn-primary">
            </div>
            <div class="form-group">
                <p class="succeed">
                    <?php
                    if (isset($message))
                        echo $message;
                    if (isset($message1))
                        echo $message1;
                    ?>
                </p>
            </div>
        </form>
    </div>
    <div class="submit-button">
        <input type="button" name="myRestaurant" value="My Restaurant" class="btn btn-primary"
            onClick="document.location.href='myRestaurant.php'">
    </div>
</body>
<script type="text/javascript">
    function preview() {
        frame.src = URL.createObjectURL(event.target.files[0]);
    }
</script>
<footer>
    <div class="logo">
        <a href="https://www.instagram.com/efresto_official/" class="social_link">Instagram</a>
        <img src="efresto.png" alt="Efresto Logo" width="150px" height="150px">
        <a href="https://www.facebook.com/profile.php?id=100088349090401" class="social_link">Facebook</a>
    </div>
    <hr>
    <p>© 2022 Efresto</p>
</footer>

</html>