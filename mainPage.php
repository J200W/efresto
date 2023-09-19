<?php
@ini_set('display_errors', 'on');
include("includes/init.php");
$africa = get_bg("africa");
$asia = get_bg("asia");
$europe = get_bg("europe");
$oceania = get_bg("oceania");
$northA = get_bg("northA");
$southA = get_bg("southA");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/basic.css">
    <link rel="stylesheet" href="css/mainPage.css">
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

    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) { ?>
    <h1 class="titlePage">Welcome to EFRESTO <span class="myName">
            <?php echo $_SESSION['firstname']; ?>
        </span> !</h1>
    <?php } ?>

    <?php if (!isset($_SESSION["loggedin"])) { ?>
    <h1 class="titlePage">Welcome to EFRESTO <span class="myName"></span> !</h1>
    <?php } ?>

    <hr>

    <div class="continent-grid">
        <a href="searchRestoAfrica.php" class="continent-box africa">
            <h2 class="continent-name">Africa</h2>
        </a>
        <a href="searchRestoNorthA.php" class="continent-box northA">
            <h2 class="continent-name">North America</h2>
        </a>
        <a href="searchRestoSouthA.php" class="continent-box southA">
            <h2 class="continent-name">South America</h2>
        </a>
        <a href="searchRestoAsia.php" class="continent-box asia">
            <h2 class="continent-name">Asia</h2>
        </a>
        <a href="searchRestoEurope.php" class="continent-box europe">
            <h2 class="continent-name">Europe</h2>
        </a>
        <a href="searchRestoOceania.php" class="continent-box oceania">
            <h2 class="continent-name">Oceania</h2>
        </a>
    </div>

    <style>
    .continent-box {
        text-decoration: none !important;
    }

    .africa {
        background-image: url(<?php echo 'data:image/jpeg;base64,' . base64_encode($africa) ?>);
        background-size: cover;
        background-position: center;
    }

    .africa:hover {
        background-image: url(<?php echo 'data:image/jpeg;base64,' . base64_encode($africa) ?>);
        background-size: cover;
        background-position: center;
        filter: brightness(80%);
        border-radius: 30px;
        text-decoration: none;
    }

    .asia {
        background-image: url(<?php echo 'data:image/jpeg;base64,' . base64_encode($asia) ?>);
        background-size: cover;
        background-position: center;
    }

    .asia:hover {
        background-image: url(<?php echo 'data:image/jpeg;base64,' . base64_encode($asia) ?>);
        background-size: cover;
        background-position: center;
        filter: brightness(80%);
        border-radius: 30px;
        text-decoration: none;
    }

    .europe {
        background-image: url(<?php echo 'data:image/jpeg;base64,' . base64_encode($europe) ?>);
        background-size: cover;
        background-position: center;
    }

    .europe:hover {
        background-image: url(<?php echo 'data:image/jpeg;base64,' . base64_encode($europe) ?>);
        background-size: cover;
        background-position: center;
        filter: brightness(80%);
        border-radius: 30px;
        text-decoration: none;
    }

    .northA {
        background-image: url(<?php echo 'data:image/jpeg;base64,' . base64_encode($northA) ?>);
        background-size: cover;
        background-position: center;
    }

    .northA:hover {
        background-image: url(<?php echo 'data:image/jpeg;base64,' . base64_encode($northA) ?>);
        background-size: cover;
        background-position: center;
        filter: brightness(80%);
        border-radius: 30px;
        text-decoration: none;
    }

    .southA {
        background-image: url(<?php echo 'data:image/jpeg;base64,' . base64_encode($southA) ?>);
        background-size: cover;
        background-position: center;
    }

    .southA:hover {
        background-image: url(<?php echo 'data:image/jpeg;base64,' . base64_encode($southA) ?>);
        background-size: cover;
        background-position: center;
        filter: brightness(80%);
        border-radius: 30px;
        text-decoration: none;
    }

    .oceania {
        background-image: url(<?php echo 'data:image/jpeg;base64,' . base64_encode($oceania) ?>);
        background-size: cover;
        background-position: center;
    }

    .oceania:hover {
        background-image: url(<?php echo 'data:image/jpeg;base64,' . base64_encode($oceania) ?>);
        background-size: cover;
        background-position: center;
        filter: brightness(80%);
        border-radius: 30px;
        text-decoration: none;
    }
    </style>

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