<?php
@ini_set('display_errors', 'on');
include("includes/init.php");

$id = $_GET["id"];

if (!check_restaurant($id)) {
    header("location: mainPage.php");
    exit;
}
$_SESSION['restaurant_id'] = $id;

update_rate($id);
$sql_resto = "SELECT * FROM restaurant where restaurant_id = '$id'";
$result_resto = $conn->query($sql_resto);
$count_resto = mysqli_num_rows($result_resto);
$rname = $rcountry = $rcity = $raddress = $rtype = $rplaceorder = $rwebsite = $rmenu = $rbooktable = $rphonenumber = $rrating = "";
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
        $rrating = $row[11];
        $monday = $row[12];
        $tuesday = $row[13];
        $wednesday = $row[14];
        $thursday = $row[15];
        $friday = $row[16];
        $saturday = $row[17];
        $sunday = $row[18];
    }
    $_SESSION['restaurant_name'] = $rname;
}
if (isset($_SESSION["loggedin"])) {
    $uid = $_SESSION['user_id'];
    $sql_comment = "SELECT * FROM comment where restaurant_id = '$id' ORDER BY user_id = '$uid' DESC, date DESC";
} else {
    $sql_comment = "SELECT * FROM comment where restaurant_id = '$id' ORDER BY date DESC";
}
$result_comment = $conn->query($sql_comment);
$count_comment = mysqli_num_rows($result_comment);
$uid = $comment = $crating = $cdate = "";

$sql_photo = "SELECT image_bin FROM photo WHERE restaurant_id = '$id'";
$result_photo = $conn->query($sql_photo);
$count_photo = mysqli_num_rows($result_photo);

if (isset($_POST["adminDelete"])) {
    $commentID = $_POST["commentID"];
    $sql_admin = "DELETE FROM `comment` WHERE comment_id = '$commentID'";
    if (mysqli_query($conn, $sql_admin)) {
        header("location: restaurant.php?id=$id");
        exit;
    } else
        echo "error deleting the comment as admin";
}


if (isset($_POST["favorite"])) {
    $uid = $_SESSION["user_id"];
    if (!isset($_SESSION["loggedin"])) {
        header("location: login.php");
        exit;
    } else {
        if (is_favorite($uid, $id)) {
            delete_fav($uid, $id);
            header("location: restaurant.php?id=$id");
            exit;
        } else {
            add_fav($uid, $id);
            header("location: restaurant.php?id=$id");
            exit;
        }
    }
}

if (isset($_POST["deleteRestaurant"])) {
    $sql_admin_com = "DELETE FROM `comment` WHERE restaurant_id = '$id'";
    $sql_admin = "DELETE FROM `restaurant` WHERE restaurant_id = '$id'";
    if (mysqli_query($conn, $sql_admin_com)) {
        if (mysqli_query($conn, $sql_admin)) {
            redirect("mainPage.php");
        } else
            echo "error deleting the restaurant";
    } else {
        echo "Couldn't delete the comments";
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
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
        </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
        </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
        </script>
    <link rel="stylesheet" href="css/basic.css">
    <link rel="stylesheet" href="css/restaurant.css">
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

    <h1 class="titlePage">
        <?php echo $rname; ?>
    </h1>

    <hr>
    <div class="restoBox">
        <div class="restoTop">

            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php
                    for ($i = 0; $i < $count_photo; $i++) {
                        if ($i == 0) {
                            echo "<li data-target='#carouselExampleIndicators' data-slide-to='$i' class='active'></li>";
                        } else
                            echo "<li data-target='#carouselExampleIndicators' data-slide-to='$i'></li>";
                    }
                    ?>
                </ol>

                <div class="carousel-inner">
                    <?php
                    $i = 0;
                    while ($row = $result_photo->fetch_row()) {
                        ?>
                        <div class="carousel-item <?php if ($i == 0)
                            echo "active" ?>">
                                <img class="resto-photo" <?php echo 'src="data:image;base64,' . $row[0] . '" alt="photo ' . $i . ' photo"' ?>>
                        </div>
                        <?php
                        $i++;
                    }
                    ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <div class="restoInfoBox">
                <?php
                if (isset($_SESSION["loggedin"])) {
                    $uid = $_SESSION["user_id"];
                    if (!is_favorite($uid, $id)) {
                        echo '<form method="post">
                            <input type="submit" name="favorite" value="♥ Add to favorites" class="fav btn btn-danger">
                        </form>';
                    } else {
                        echo '<form method="post">
                            <input type="submit" name="favorite" value="♥ Remove from favorites" class="fav btn btn-danger">
                        </form>';
                    }
                }
                ?>

                <h3 class="titleInfo">Location</h3>

                <p>City:
                    <?php echo $rcity . ', ' . $rcountry; ?>
                </p>

                <p>Address: <span>
                        <?php echo $raddress; ?>
                    </span></p>

                <h3 class="titleInfo">Contact</h3>

                <p>Place order: <span class="orange"><a href="<?php echo $rplaceorder; ?>">
                            <?php echo $rname . " Place Order"; ?>
                        </a></span></p>
                <p>Website: <span class="orange"><a href="<?php echo $rwebsite; ?>">
                            <?php echo $rname . " Website"; ?>
                        </a></span></p>
                <p>Menu: <span class="orange"><a href="<?php echo $rmenu; ?>">
                            <?php echo $rname . " Menu"; ?>
                        </a></span>
                </p>
                <p>Book table: <span class="orange"><a href="<?php echo $rbooktable; ?>">
                            <?php echo $rname . " Book Table"; ?>
                        </a></span></p>
                <p>Phone number: <span class="orange">
                        <?php echo $rphonenumber; ?>
                    </span></p>

                <h3 class="titleInfo">Cuisine(s)</h3>
                <p class="textInfo">
                    <?php echo $rtype; ?>
                </p>
            </div>
        </div>
        <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
            if (check_user($_SESSION["user_id"], $id) == true) { ?>
                <div class="modify">
                    <form method="post">
                        <input type="button" name="modifyRestaurantInfo" value="Modify Restaurant Information"
                            class="btn btn-primary"
                            onClick="document.location.href='modifyRestaurantInfo.php?id=<?php echo $id; ?>'">
                        <input type="button" name="modifyRestaurantImage" value="Modify Restaurant Image"
                            class="btn btn-primary" onClick="document.location.href='modifyRestaurantImage.php'">
                        <input type="submit" name="deleteRestaurant" value="Delete Restaurant" class="btn btn-primary">
                    </form>
                </div>
            <?php }
        } ?>
        <hr>
        <div class="commentSection">
            <form id="commForm" name="commForm" method="post">
                <p>
                    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button"
                        aria-expanded="false" aria-controls="collapseExample">See opening hours</a>
                </p>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Monday</th>
                                    <th scope="col">Tuesday</th>
                                    <th scope="col">Wednesday</th>
                                    <th scope="col">Thursday</th>
                                    <th scope="col">Friday</th>
                                    <th scope="col">Saturday</th>
                                    <th scope="col">Sunday</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php echo $monday ?>
                                    </td>
                                    <td>
                                        <?php echo $tuesday ?>
                                    </td>
                                    <td>
                                        <?php echo $wednesday ?>
                                    </td>
                                    <td>
                                        <?php echo $thursday ?>
                                    </td>
                                    <td>
                                        <?php echo $friday ?>
                                    </td>
                                    <td>
                                        <?php echo $saturday ?>
                                    </td>
                                    <td>
                                        <?php echo $sunday ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <h3>Average score: <span class="orange" style="font-size: larger;">
                        <?php echo $rrating; ?>
                    </span> /5
                </h3>
                <p>Based on <span class="orange">
                        <?php echo $count_comment; ?>
                    </span> review(s)</p>
                <div class="rating">
                    <label>
                        <input type="radio" name="stars" value="0" checked="checked" />
                    </label>
                    <label>
                        <input type="radio" name="stars" value="1" />
                        <span class="icon">★</span>
                    </label>
                    <label>
                        <input type="radio" name="stars" value="2" />
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                    </label>
                    <label>
                        <input type="radio" name="stars" value="3" />
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                    </label>
                    <label>
                        <input type="radio" name="stars" value="4" />
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                    </label>
                    <label>
                        <input type="radio" name="stars" value="5" />
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                        <span class="icon">★</span>
                    </label>
                </div>
                <?php
                if (isset($_SESSION["loggedin"])) {
                    if (!many_comment($_SESSION["user_id"], $id)) {
                        echo "<label for='comment'></label><br>
                                <textarea id='comment' class='form-control' name='comment' placeholder='Leave a comment...' required></textarea><br>
                                <input type='submit' class='btn btn-primary' value='Add a review' name='submitComm'>";
                    } else {
                        echo "<label for='comment'></label><br>
                                <textarea id='comment' class='form-control' name='comment' placeholder='Edit my comment...' required></textarea><br>
                                <input type='submit' class='btn btn-primary ' value='Edit my review' name='submitComm'>";
                    }
                } else {
                    echo "<label for='comment'></label><br>
                                <textarea id='comment' class='form-control' name='comment' placeholder='Leave a comment...' required></textarea><br>
                                <input type='submit' class='btn btn-primary' value='Add a review' name='submitComm'>";
                }
                if (isset($_POST["submitComm"])) {
                    if (!isset($_SESSION["loggedin"])) {
                        header("location: login.php");
                        exit;
                    }
                    if ($_POST["stars"] == "0") {
                        echo "<div class='alert alert-danger' role='alert'>Error: Please, give us your rating on this restaurant.</div>";
                        echo "<script>document.commForm.stars[0].checked=true; document.getElementById('comment').value = '';</script>";
                    } else if (many_comment($_SESSION["user_id"], $id)) {
                        $uid = $_SESSION["user_id"];
                        $comment = $_POST["comment"];
                        $comment = str_replace("'", "\'", $comment);
                        $crating = $_POST["stars"];
                        $cdate = date("Y-m-d");
                        $sql_updComm = "UPDATE `comment` SET `message`='$comment',`rating`= '$crating',`date`='$cdate' 
                                WHERE `user_id` = '$uid' AND `restaurant_id` = '$id'";
                        if ($conn->query($sql_updComm) === TRUE) {
                            update_rate($id);
                            header("location: restaurant.php?id=$id");
                            exit;
                        }
                        echo "<script>document.commForm.stars[0].checked=true; document.getElementById('comment').value = '';</script>";
                        echo '<div class="alert alert-success" role="alert">Success: Your comment has been updated on this restaurant!</div>';
                    } else {
                        $uid = $_SESSION["user_id"];
                        $comment = $_POST["comment"];
                        $crating = $_POST["stars"];
                        $cdate = date("Y-m-d");
                        $sql_addComm = "INSERT INTO `comment`(`user_id`, `restaurant_id`, `message`, `rating`, `date`) 
                                VALUES ('$uid','$id','$comment','$crating','$cdate')";
                        if ($conn->query($sql_addComm) === TRUE) {
                            update_rate($id);

                            header("location: restaurant.php?id=$id");
                            exit;
                        }
                    }
                }
                ?>


            </form>
            <?php
            if (isset($_SESSION["loggedin"])) {
                if (many_comment($_SESSION["user_id"], $id)) {
                    if (isset($_POST["deleteComm"])) {
                        $uid = $_SESSION["user_id"];
                        $sql_delComm = "DELETE FROM `comment` WHERE user_id = '$uid' AND restaurant_id = '$id'";
                        if ($conn->query($sql_delComm) === TRUE) {
                            header("location: restaurant.php?id=$id");
                            echo '<div class="alert alert-success" role="alert">Success: Your comment has been deleted on this restaurant!</div>';
                            exit;
                        } else {
                            header("location: restaurant.php?id=$id");
                            echo '<div class="alert alert-danger" role="alert">Error: Your comment has not been deleted!</div>';
                            exit;
                        }
                    }
                }
            }
            ?>

            <div class="clear"></div>
            <?php
            while ($row = $result_comment->fetch_row()) {
                $cid = $row[0];
                $uid = $row[1];
                $rid = $row[2];
                $comment = $row[3];
                $crating = $row[4];
                $cdate = $row[5];
                ?>
                <div class="commentBox">
                    <div class="leftPanelImg">
                        <?php
                        $sql_name = "SELECT firstname, lastname, user_photo 
                                        FROM user where user_id = '$uid'";
                        $result_name = $conn->query($sql_name);
                        $fname = $lname = "";
                        while ($row2 = $result_name->fetch_row()) {
                            $fname = $row2[0];
                            $lname = $row2[1];
                            $uphoto = $row2[2];
                        }
                        ?>
                        <?php echo '<img src="data:image;base64,' . $uphoto . '" alt="Profile Picture">'; ?>
                        <div class="rightPanel">
                            <span>
                                <?php echo $fname . ' ' . $lname; ?>
                            </span>
                            <div class="date">
                                <?php echo $cdate[8] . $cdate[9] . '/' . $cdate[5] . $cdate[6] . '/' . $cdate[0] . $cdate[1] . $cdate[2] . $cdate[3]; ?>
                            </div>
                            <div class="ratingnumber">
                                <span>
                                    <?php echo $crating; ?>
                                </span> /5
                            </div>
                            <hr>
                            <p class="theComment">
                                <?php echo $comment; ?>
                            </p>
                        </div>
                    </div>
                    <?php
                    if (isset($_SESSION["loggedin"])) {
                        if (check_commentator($_SESSION['user_id'], $id, $cid)) {
                            $table = '<form action="" method="post">
                                        <input type="hidden" name="commentID" value="';
                            $table2 = '"><input type="submit" value="Delete" name="adminDelete" class="btn btn-danger btn-sm"></input>
                                    </form>';
                            echo ($table . $cid . $table2);
                        }
                    }
                    ?>
                </div>

            <?php } ?>

        </div>
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