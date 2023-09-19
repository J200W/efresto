<?php
// Initialize the session
include ("includes/init.php");

 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    redirect("mainPage.php");
    exit;
}


$tblUser = "user";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($email_err) && empty($password_err)){

        

        //We fetch the hashed password from the DB
        $query1 = "SELECT * FROM $tblUser WHERE email='$email'";
        $result1 = mysqli_query($conn, $query1);
        $count1 = mysqli_num_rows($result1);

        if($count1 == 1){
            $infos = mysqli_fetch_array($result1);

            //compare the entered password with the hash from the DB
            if(password_verify($_POST['password'], $infos['password'])){
            // Password is correct, so start a new session
            session_start();
            
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["user_id"] = $infos['user_id'];
            $_SESSION["email"] = $infos['email'];    
            $_SESSION['firstname'] = $infos['firstname'];
            $_SESSION['lastname'] = $infos['lastname'];
            $_SESSION['status'] = $infos['status'];
    
            
            // Redirect user to welcome page
            header("location: mainPage.php");
        } else{
            // Password is not valid, display a generic error message
            $login_err = "Invalid email address or password";
        }
    }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/basic.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Efresto</title>
    <link rel="icon" href="<?php echo 'data:image;base64,' .$efresto_logo_blanc;?>">
</head>

<body>
    <div class="navbar">
        <input type="checkbox" id="check">
        <label for="check" id="checkbtn">
            <i class="fas fa-bars"><a href="#logoLink"></a></i>
        </label>
        <label class="logo"><a href="mainPage.php" id="logoLink">EFRESTO</a></label>
        <!--<ul class="navItems">
        <li><a class="navItem" href="login.php">Login</a></li>
        </ul>-->
    </div>
    <div id="space">
    </div>

    <div class="login-box">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Email Address</label>
                <input type="text" name="email"
                    class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password"
                    class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a class="signLink" href="register.php">Sign up now</a>.</p>
            <p>You forgot your password? <a class="signLink" href="forgotpassword.php">Reset password</a>.</p>
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