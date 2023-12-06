<?php
@ini_set('display_errors', 'on');
include("includes/init.php");
$uid = $_SESSION["user_id"];



if (isset($_POST["btnSubmit"])) {
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
                $query_photo = "UPDATE `user` SET `user_photo`='$image' WHERE user_id = '$uid'";
            } else {
                $sizeMessage = "Your file is too big!";
            }
        } else {
            $errorMessage = "There was an error uploading your file!";
        }
    } else {
        $allowedMessage = "You cannot upload files of this type!";
    }
    if (mysqli_query($conn, $query_photo)) {
        $messagePhoto = '<div class="alert alert-success" role="success">Success: Your profile picture has been updated!</div>';
    } else {
        $messageErrorPhoto = 'Error in inserting information, please try again';
    }
}

if (isset($_POST["btnSubmitInfo"])) {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $query = "UPDATE `user` SET `firstname`='$fname',`lastname`='$lname',`email`='$email'WHERE `user_id` = '$uid'";
    if (mysqli_query($conn, $query)) {
        $messageInfo = '<div class="alert alert-success" role="alert">Success: Your information has been updated!</div>';
        $_SESSION["firstname"] = $fname;
        $_SESSION["lastname"] = $lname;
        $_SESSION["email"] = $email;
    } else {
        $messageErrorInfo = 'Error in inserting information, please try again';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/basic.css">
    <link rel="stylesheet" href="css/myProfile.css">
    <title>Efresto</title>
    <link rel="icon" href="efresto.png">
</head>
<div class="navbar">
    <input type="checkbox" id="check">
    <label for="check" id="checkbtn">
        <i class="fas fa-bars"><a href="#logoLink"></a></i>
    </label>
    <label class="logo"><a href="mainPage.php" id="logoLink">EFRESTO</a></label>
    <ul class="navItems">

        <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) { ?>
        <div class="dropdown">
            <button class="dropbtn">Account</button>
            <div class="dropdown-content">
                <li><a class="dropdown-item" href="myProfile.php">My profile</a></li>
                <?php if ($_SESSION["status"] == 'a' || $_SESSION["status"] == 'r') { ?>
                <li><a class="dropdown-item" href="myRestaurant.php">My restaurants</a></li>
                <?php } ?>
                <li><a class="dropdown-item" href="myFavorite.php">My favorites</a></li>
                <?php
                    if ($_SESSION["status"] == "a") { ?>
                <li><a class="dropdown-item" href="manage-user.php">Manage Users</a></li>
                <?php } ?>
                <div class="dropdown-divider"></div>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </div>
        </div>
        <?php } ?>

        <?php if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == false) { ?>
        <li><a class="navItem" href="login.php">Login</a></li>
        <?php } ?>

    </ul>
</div>
<div id="space">
</div>
<h1 class="titlePage">My Profile</h1>
<hr>
<div class="profile-box">
    <?php
    if (!empty($login_err)) {
        echo '<div class="alert alert-danger">' . $login_err . '</div>';
    }
    ?>
    <?php
    $sql_photo = "SELECT * FROM user where user_id = '$uid'";
    $result_photo = $conn->query($sql_photo);
    $count_photo = mysqli_num_rows($result_photo);
    $row = $result_photo->fetch_row();
    echo '<img  src="data:image;base64,' . $row[6] . ' " class="pdp " style="margin-top: 0 !important" id="frame">';
    ?>
    <form method="post" enctype="multipart/form-data">
        <p>Change profile picture</p>
        <div class="form-group">
            <input type="file" name="photo" required onchange="preview()"><br>
        </div>
        <div class="submit-button">
            <input type="submit" name="btnSubmit" value="Update Image" class="btn btn-primary">
        </div>
        <div class="form-group">
            <p class="succeed">
                <?php
                if (isset($messagePhoto))
                    echo $messagePhoto;
                if (isset($messageErrorPhoto))
                    echo $messageErrorPhoto;
                ?>
            </p>
        </div>
    </form>

    <form action="" method="post">
        <div class="restoTop">
            <div class="restoInfoBox">
                <div class="form-group">
                    <label>First name</label>
                    <input type="text" name="fname" required class="form-control"
                        value="<?php echo $_SESSION['firstname']; ?>">
                </div>
                <div class="form-group">
                    <label>Last name</label>
                    <input type="text" name="lname" required class="form-control"
                        value="<?php echo $_SESSION['lastname']; ?>">
                </div>
                <div class="form-group">
                    <label>Email address</label>
                    <input type="text" name="email" required class="form-control"
                        value="<?php echo $_SESSION['email']; ?>">
                </div>
            </div>
        </div>
        <div class="submit-button">
            <input type="submit" name="btnSubmitInfo" value="Update Info" class="btn btn-primary">
            <a class="btn btn-link ml-2" href="reset-password.php">Change password</a>
        </div>
        <div class="form-group">
            <p class="succeed">
                <?php
                if (isset($messageInfo))
                    echo $messageInfo;
                if (isset($messageErrorInfo))
                    echo $messageErrorInfo;
                ?>
            </p>
        </div>
    </form>
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