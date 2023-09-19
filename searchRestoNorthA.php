<?php
@ini_set('display_errors', 'on');
include("includes/init.php");

if (isset($_POST["submit"])) {
    $country = $_POST["country"];
    $city = $_POST["city"];
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
    <link rel="stylesheet" href="css/searchResto.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
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
    <h1 class="titlePage">Find your restaurant in <span>North America</span> !</h1>
    <style>
        span {
            color: #23c2a7;
        }
    </style>
    <hr>
    <div class="search-box">
        <form action="resultRestaurant.php" method="post">
            <div class="form-group">
                <label for="country">Select a country</label>
                <select class="form-control" name="country" id="country">
                    <option value="Anguilla" selected="selected">Anguilla</option>
                    <option value="Antigua and Barbuda">Antigua & Barbuda</option>
                    <option value="Aruba">Aruba</option>
                    <option value="Bahamas">Bahamas</option>
                    <option value="Barbados">Barbados</option>
                    <option value="Belize">Belize</option>
                    <option value="Bermuda">Bermuda</option>
                    <option value="Bonaire, Sint Eustatius and Saba">Caribbean Netherlands</option>
                    <option value="Canada">Canada</option>
                    <option value="Cayman Islands">Cayman Islands</option>
                    <option value="Costa Rica">Costa Rica</option>
                    <option value="Cuba">Cuba</option>
                    <option value="Curacao">Curaçao</option>
                    <option value="Dominica">Dominica</option>
                    <option value="Dominican Republic">Dominican Republic</option>
                    <option value="El Salvador">El Salvador</option>
                    <option value="Greenland">Greenland</option>
                    <option value="Grenada">Grenada</option>
                    <option value="Guadeloupe">Guadeloupe</option>
                    <option value="Guatemala">Guatemala</option>
                    <option value="Haiti">Haiti</option>
                    <option value="Honduras">Honduras</option>
                    <option value="Jamaica">Jamaica</option>
                    <option value="Martinique">Martinique</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Netherlands Antilles">Curaçao</option>
                    <option value="Nicaragua">Nicaragua</option>
                    <option value="Panama">Panama</option>
                    <option value="Puerto Rico">Puerto Rico</option>
                    <option value="Saint Barthelemy">St. Barthélemy</option>
                    <option value="Saint Kitts and Nevis">St. Kitts & Nevis</option>
                    <option value="Saint Lucia">St. Lucia</option>
                    <option value="Saint Martin">St. Martin</option>
                    <option value="Saint Pierre and Miquelon">St. Pierre & Miquelon</option>
                    <option value="Saint Vincent and the Grenadines">St. Vincent & Grenadines</option>
                    <option value="Sint Maarten">Sint Maarten</option>
                    <option value="Trinidad and Tobago">Trinidad & Tobago</option>
                    <option value="Turks and Caicos Islands">Turks & Caicos Islands</option>
                    <option value="United States">United States</option>
                    <option value="United States Minor Outlying Islands">U.S. Outlying Islands</option>
                    <option value="Virgin Islands, British">British Virgin Islands</option>
                    <option value="Virgin Islands, U.s.">U.S. Virgin Islands</option>
                </select>
            </div>
            <div class="form-group">
                <label for="city">Select a city</label>
                <input class="form-control" type="text" id="city" name="city">
            </div>

            <input class="btn btn-primary" type="submit" value="Search" name="submit">

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