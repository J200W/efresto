<?php
include("includes/init.php");
include("includes/register.inc.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/basic.css">
    <link rel="stylesheet" href="css/register.css">
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
    </div>
    <div id="space">
    </div>
    <div class="login-box">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <?php if (!empty($error)) {
            foreach ($errors as $er) {
                echo $er . ' ';
            }
        } ?>
        <form action="" method="post">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="firstname" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lastname" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="status">
                <label class="form-check-label" name="status" for="flexCheckDefault">Click here if you are a
                    restorer</label>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>

            <p>Already have an account? <a class="signLink" href="login.php">Login here</a>.</p>
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