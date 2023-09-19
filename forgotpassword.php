<?php
@ini_set('display_errors', 'on');
include("includes/init.php");

//Include required PHPMailer files
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';
//Define name spaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Efresto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/basic.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" href="<?php echo 'data:image;base64,' . $efresto_logo_blanc; ?>">
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
        <hr>
        <form action="#" method="post">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="txtEmail" class="form-control">
            </div>
            <input type="submit" value="Send mail" class="btn btn-primary" name="forgetpwd"></input>
            <?php

            if (isset($_POST['forgetpwd'])) {
                //Create instance of PHPMailer
                $mail = new PHPMailer();
                //Set mailer to use smtp
                $mail->isSMTP();
                //Define smtp host
                $mail->Host = "smtp.gmail.com";
                //Enable smtp authentication
                $mail->SMTPAuth = true;
                //Set smtp encryption type (ssl/tls)
                $mail->SMTPSecure = "tls";
                //Port to connect smtp
                $mail->Port = "587";
                //Set gmail username
                $mail->Username = "julienenmalaisie@gmail.com";

                // Met le mot de passe de l'adresse mail bidon
                $mail->Password = "atfkieikgknumdtg";

                // Met l'entête du mail, genre le titre
                $mail->Subject = "EFRESTO Reset Password";

                // Remet l'adresse email bidon
                $mail->setFrom('julienenmalaisie@gmail.com');

                // Copie tous ça sans réfléchir
                $mail->isHTML(true);
                $noncodedtemppwd = generateRandomString();
                $temporarypwd = password_hash($noncodedtemppwd, PASSWORD_DEFAULT);

                // Le contenu du mail, genre le corps. Par contre ça s'écrit en HTML, donc faut mettre des balises HTML, 
                // je t'ai mis un exemple
                $mail->Body = "Hi, <br/> Your passeword have been reset, here is your temporary password : <strong>$noncodedtemppwd</strong> <br/> Don't forget to modify your password to secure your account.";

                //Add recipient
                $sendTo = $_POST["txtEmail"];
                $mail->addAddress($sendTo);
                //Finally send email
                $query = "SELECT password FROM user WHERE email = '$sendTo'";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $count = mysqli_num_rows($result);
                if ($count == 1) {
                    if ($mail->send()) {
                        echo '<div class="alert alert-success" role="alert">Success: Email Sent !</div>';
                        // Update password
                        $updatequery = "UPDATE `user` SET `password`='$temporarypwd' WHERE email = '$sendTo'";
                        mysqli_query($conn, $updatequery);
                        header("refresh:1;url=login.php");
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Error: Message could not be sent. Try again...</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error: No account found with this email !</div>';
                }

                //Closing smtp connection
                $mail->smtpClose();
            }
            ?>
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