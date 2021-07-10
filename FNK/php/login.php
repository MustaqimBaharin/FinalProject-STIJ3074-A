<?php
session_start();
include_once("dbconnect.php"); // connect to database
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']); // post the email
    $password = trim(sha1($_POST['password'])); // password with encryption sha1
    $sqllogin = "SELECT * FROM tbl_user WHERE email = '$email' AND password = '$password'";// tbl_user in MySQL

$select_stmt = $conn->prepare($sqllogin);
$select_stmt->execute();
$row = $select_stmt->fetch(PDO::FETCH_ASSOC);
if ($select_stmt->rowCount() > 0) {
    $_SESSION["session_id"] = session_id();
    $_SESSION["email"] = $email;
    $_SESSION["name"] = $row['name'];
    $_SESSION["district"] = $row['district'];
    $_SESSION["phone"] = $row['phone'];
    $_SESSION["datereg"] = $row['date_reg'];
    $_SESSION["pass"] = $row['password'];
    echo "<script> alert('Login Successful')</script>"; // show, if login to Database success
    echo "<script> window.location.replace('menu.php')</script>"; // enter the next page (Menu) after success
} else {
    session_unset();
    session_destroy();
    echo "<script> alert('Login Wrong')</script>"; // show, if login to Database failed
    echo "<script> window.location.replace('login.php')</script>";
 } // stay at login page if login fail
}
if (isset($_GET["status"])) { // logout status
    if (($_GET["status"] == "logout")) {
        session_unset();
        session_destroy();
        echo "<script> alert('Session Cleared')</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <!--Title Login Form-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../js/login.js"></script>
    <!--reference JavaScript-->
    <link rel="stylesheet" href="../css/login.css">
    <!--reference CSS style-->
</head>
<body onload="loadCookies()">
    <div class="header">
        <!--Header content with web name-->
        <h1>Fatimah Nasi Kandar Self-Pickup</h1>
        <p>Origin from Perlis, Since 1996</p>
    </div>
    <div class="topnavbar">
        <!--Top Navigation Bar-->
        <a href="register.php" class="right">Register</a>
        <!--Navigation to Register Page-->
    </div>
    <div class="main">
        <center>
            <img src="../images/fatimahlogo.png">
            <!--Front logo for Web-->
        </center>
        <div class="container">
            <!--Container class for Login-->
            <form name="loginForm" action="menu.php" onsubmit="" method="post">
                <div class="row">
                    <div class="col-25">
                        <label for="femail">Email</label>
                        <!--email form for Login-->
                    </div>
                    <div class="col-75">
                        <input type="text" id="idemail" name="email" placeholder="Enter valid email">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="lname">Password</label>
                        <!--password form for Login-->
                    </div>
                    <div class="col-75">
                        <input type="password" id="idpass" name="password" placeholder="Enter password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="lname">Remember</label>
                        <!--remember checkbox cookies for Login-->
                    </div>
                    <div class="col-25" align="left">
                        <div>
                            <label>
                                <input type="checkbox" id="idremember" name="rememberme">
                            </label>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <input type="submit" name="submit" href="menu.php">
                    <!--submit button for Login-->
                </div>
            </form>
        </div>
        <br><br>
    </div>
    <div class="bottomnavbar">
        <!--Bottom Navigation Bar-->
        <a href="../index.html">Home</a>
        <!--Navigation to Landing Page-->
        <a href="../html/contact.html">Contact Us</a>
        <!--Navigation to Contact Us Page-->
    </div>
</body>
</html>