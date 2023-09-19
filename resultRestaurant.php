<?php
@ini_set('display_errors', 'on');
include("includes/init.php");

if (isset($_POST["submit"])) {
    if (isset($_POST["country"])) {
        $country = $_POST["country"];
    }

    $city = $_POST["city"];
    $sql = "SELECT * FROM restaurant where country like '%$country%' and city like '%$city%' ORDER BY rating DESC";
}
$result = $conn->query($sql);
$count = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/basic.css">
    <link rel="stylesheet" href="css/resultRestaurant.css">
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

    <h1 class="titlePageResult">Restaurants in
        <span class="cityName">
            <?php
            if (!isset($country) && isset($city)) {
                echo $city;
            } else if (isset($country) && $city == "") {
                echo $country;
            } else if (isset($country) && isset($city)) {
                echo $city;
            } ?>
        </span> (<span>
            <?php echo $count; ?>
        </span>)
    </h1>
    <hr>

    <div class="result-box">

        <?php
        while ($row = $result->fetch_row()) {
            $id = $row[0];
            ?>
            <a href="restaurant.php?id=<?php echo $row[0]; ?>">
                <div class="result">
                    <div class="image-space">
                        <?php echo '<img class="result-photo" src="data:image;base64,' . get_photo($id) . '" alt="' . $row[1] . ' photo">'; ?>
                    </div>
                    <div class="result-text">
                        <h3 class="result-name">
                            <?php echo $row[1]; ?>
                        </h3>
                        <p class="result-rating"><span>
                                <?php echo $row[11]; ?>
                            </span> /5</p>
                        <p class="result-address">
                            <?php echo $row[5]; ?>
                        </p>
                    </div>
                </div>
            </a>
        <?php
        }
        ?>
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