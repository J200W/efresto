<?php
include("includes/init.php");

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate new password
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Please enter the new password.";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "Password must have atleast 6 characters.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm the password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    //Check the old password before updating

    if (empty(trim($_POST['old_password']))) {
        $old_password_err = "Please enter yout old password";
    } else {
        $uid = $_SESSION['user_id'];
        $query1 = "SELECT password FROM user WHERE user_id='$uid'";
        $result = mysqli_query($conn, $query1);
        $pass = mysqli_fetch_row($result);
        if (!password_verify($_POST['old_password'], $pass[0])) {
            $old_password_err = "The old password is wrong";
        }
    }

    // Check input errors before updating the database
    if (empty($new_password_err) && empty($confirm_password_err) && empty($old_password_err)) {

        // Prepare an update statement

        $sql = "UPDATE user SET password = ? WHERE user_id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["user_id"];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
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
    <link rel="stylesheet" href="css/login.css">
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
    <div class="login-box">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="old_password"
                    class="form-control <?php echo (!empty($old_password_err)) ? 'is-invalid' : ''; ?>" value="">
                <span class="invalid-feedback">
                    <?php echo $old_password_err; ?>
                </span>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password"
                    class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $new_password; ?>">
                <span class="invalid-feedback">
                    <?php echo $new_password_err; ?>
                </span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password"
                    class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback">
                    <?php echo $confirm_password_err; ?>
                </span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link ml-2" href="welcome.php">Cancel</a>
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