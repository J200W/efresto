<?php
include("includes/init.php");
$restaurant_id = $_GET['id'];

$qry_resto = "SELECT * FROM restaurant WHERE restaurant_id = '$restaurant_id'";
$result_resto = $conn->query($qry_resto);
$count_resto = mysqli_num_rows($result_resto);
if ($count_resto == 1) {
    while ($row = $result_resto->fetch_row()) {
        $rname = $row[1];
        $rcountry = $row[2];
        $rcity = $row[3];
        $raddress = $row[4];
        $rtype = $row[5];
        $rplaceorder = $row[6];
        $rwebsite = $row[7];
        $rmenu = $row[8];
        $rbooktable = $row[9];
        $rphonenumber = $row[10];
        $rmonday = $row[12];
        $rtuesday = $row[13];
        $rwednesday = $row[14];
        $rthursday = $row[15];
        $rfriday = $row[16];
        $rsaturday = $row[17];
        $rsunday = $row[18];
    }
}

//check that the data are sent to the database when btnSubmit pressed
if (isset($_POST['btnSubmit'])) {
    //we retrieve the restaurant's name
    $name = $_POST['name'];
    $_SESSION['restaurant_name'] = $name;
    //we retrieve the restaurant's country
    $country = $_POST['country'];
    //we retrieve the restaurant's city
    $city = $_POST['city'];
    //we retrieve the restaurant's address
    $address = $_POST['address'];
    $_SESSION['restaurant_address'] = $address;
    //we retrieve the restaurant's type
    $type = $_POST['type'];
    //we retrieve the restaurant's contacts
    $placeOrder = $_POST['placeOrder'];
    $website = $_POST['website'];
    $menu = $_POST['menu'];
    $bookTable = $_POST['bookTable'];
    $phoneNumber = $_POST['phoneNumber'];

    //we retrieve the restaurant's schedule
    $monday = $_POST['monday'];
    $tuesday = $_POST['tuesday'];
    $wednesday = $_POST['wednesday'];
    $thursday = $_POST['thursday'];
    $friday = $_POST['friday'];
    $saturday = $_POST['saturday'];
    $sunday = $_POST['sunday'];

    $query = "UPDATE `restaurant` SET `name`='$name',`country`='$country',`city`='$city',
        `address`='$address',`type`='$type',`placeOrder`='$placeOrder',`website`='$website',
        `menu`='$menu',`bookTable`='$bookTable',`phoneNumber`='$phoneNumber',`monday`='$monday',
        `tuesday`='$tuesday',`wednesday`='$wednesday',`thursday`='$thursday',`friday`='$friday',
        `saturday`='$saturday',`sunday`='sunday' WHERE `restaurant_id` = '$restaurant_id'";

    if (mysqli_query($conn, $query)) {
        $message = 'Your restaurant has been added';
        header("refresh:1;url=restaurant.php?id=$restaurant_id");
    } else {
        $message1 = 'Error in inserting information, please try again';
    }

}
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/basic.css">
    <link rel="stylesheet" href="css/createRestaurant.css">
    <title>Efresto</title>
    <link rel="icon" href="efresto.png">
</head>

<body>
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

    <div class="createResto-box">
        <div class="title">
            <h2>Update Restaurant Information</h2>
            <p>To modify your restaurant information you simply have to modify the desired section !</p>
        </div>
        <form method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col">
                    <h2>Informations</h2>
                    <div class="form-group">
                        <label>Enter the name of your restaurant</label>
                        <input type="text" name="name" required="required" class="form-control"
                            value="<?php echo $rname ?>">
                    </div>
                    <div class="form-group">
                        <label>Enter the restaurant's country</label>
                        <input type="text" name="country" required="required" class="form-control"
                            value="<?php echo $rcountry ?>">
                    </div>
                    <div class="form-group">
                        <label>Enter the restaurant's City</label>
                        <input type="text" name="city" required="required" class="form-control"
                            value="<?php echo $rcity ?>">
                    </div>
                    <div class="form-group">
                        <label>Enter the restaurant's Address</label>
                        <input type="text" name="address" required="required" class="form-control"
                            value="<?php echo $raddress ?>">
                    </div>
                    <div class="form-group">
                        <label>Enter the type of restaurant (ex: Asian restaurant, Pizza restaurant, Fast food
                            restaurant, etc.)</label>
                        <input type="text" name="type" required="required" class="form-control"
                            value="<?php echo $rtype ?>">
                    </div>
                    <div class="form-group">
                        <label>Enter the restaurant's contacts</label>
                        <input type="text" name="placeOrder" class="form-control"
                            placeholder="Enter link to place an order" value="<?php echo $rplaceorder ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" name="website" class="form-control"
                            placeholder="Enter restaurant's website link" value="<?php echo $rwebsite ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" name="menu" class="form-control" placeholder="Enter restaurant's menu link"
                            value="<?php echo $rmenu ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" name="bookTable" class="form-control"
                            placeholder="Enter the link to book a table" value="<?php echo $rbooktable ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" name="phoneNumber" class="form-control"
                            placeholder="Enter restaurant's phone number" value="<?php echo $rphonenumber ?>">
                    </div>
                </div>
                <div class="col">
                    <h2>Hours</h2><br>
                    <div class="form-group">
                        <label>Monday</label>
                        <input type="text" name="monday" class="form-control" value="<?php echo $rmonday ?>"><br>
                        <label>Tuesday</label>
                        <input type="text" name="tuesday" class="form-control" value="<?php echo $rtuesday ?>"><br>
                        <label>Wednesday</label>
                        <input type="text" name="wednesday" class="form-control" value="<?php echo $rwednesday ?>"><br>
                        <label>Thursday</label>
                        <input type="text" name="thursday" class="form-control" value="<?php echo $rthursday ?>"><br>
                        <label>Friday</label>
                        <input type="text" name="friday" class="form-control" value="<?php echo $rfriday ?>"><br>
                        <label>Saturday</label>
                        <input type="text" name="saturday" class="form-control" value="<?php echo $rsaturday ?>"><br>
                        <label>Sunday</label>
                        <input type="text" name="sunday" class="form-control" value="<?php echo $rsunday ?>">
                    </div>
                </div>
            </div>
            <div class="submit-button">
                <input type="submit" name="btnSubmit" value="Modify Information" class="btn btn-primary">
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
</body>
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