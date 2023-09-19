<?php
include("includes/init.php");

// Check if the user is already logged in, if no then redirect him to login

if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"] === true) {
    redirect("login.php");
    exit;
}

if (!($_SESSION["status"] === "a")) {
    redirect("mainPage.php");
    exit;
}

$query = "SELECT * from `user`";
$result = mysqli_query($conn, $query);


if (isset($_POST['delete'])) {
    $uid = $_POST['id'];
    $query3 = "DELETE FROM `comment` WHERE user_id = '$uid'";
    $query4 = "DELETE FROM `restaurant` WHERE user_id = '$uid'";
    $query2 = "DELETE FROM `user` WHERE user_id = '$uid'";

    if (mysqli_query($conn, $query2)) {
        if (mysqli_query($conn, $query3)) {
            if (mysqli_query($conn, $query4)) {
                redirect("manage-user.php");
            } else {
                echo "error deleting from restaurant table";
            }
        } else {
            echo "error deleting from comment table";
        }
    } else {
        echo "error deleting from user table";
    }
}

if (isset($_POST['update'])) {
    $option = $_POST['option'];
    $uid = $_POST['upid'];
    $sql_update = "UPDATE user SET status = '$option' WHERE user_id = '$uid'";
    if (mysqli_query($conn, $sql_update)) {
        redirect("manage-user.php");
    } else {
        echo "status not updated";
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
    <link rel="stylesheet" href="css/manage-user.css">
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

    <h1 align=center>List of users</h1>
    <hr>
    <?php
    if (isset($message))
        echo $message;
    ?>
    <table border='1' cellpadding=5 cellspacing=2>
        <tr>
            <th>ID</th>
            <th>Firstname</th>
            <th>Last name</th>
            <th>Email Adress</th>
            <th>Status</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td>
                    <?php echo $row['user_id'] ?>
                </td>
                <td>
                    <?php echo $row["firstname"] ?>
                </td>
                <td>
                    <?php echo $row["lastname"] ?>
                </td>
                <td>
                    <?php echo $row["email"] ?>
                </td>
                <td>
                    <?php echo $row["status"] ?>
                </td>
                <form method="post">
                    <td>
                        <select name="option" class="sel form-select" aria-label="Default select example">
                            <option disabled>Change status</option>
                            <option value="a" <?php if ($row["status"] == 'a')
                                echo "selected"; ?>>Admin</option>
                            <option value="r" <?php if ($row["status"] == 'r')
                                echo "selected"; ?>>Restorer</option>
                            <option value="u" <?php if ($row["status"] == 'u')
                                echo "selected"; ?>>User</option>
                        </select>
                        <input type="hidden" name="upid" value="<?php echo $row['user_id']; ?>">
                        <input type="submit" value="Update" name="update" class="btn btn-primary btn-sm"></input>
                </form>
                </td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">
                        <input type="submit" value="Delete" name="delete" class="btn btn-danger btn-sm"></input>
                    </form>
                </td>
            </tr>

        <?php } ?>

    </table>
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