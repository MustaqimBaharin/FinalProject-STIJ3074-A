<?php
session_start();
include_once("dbconnect.php");
if (!isset($_COOKIE['email'])) {
    echo "<script>loadCookies()</script>";
} else {
    $email = $_COOKIE['email'];
    //add to cart button
    if (isset($_GET['op'])) {
        $prodid = $_GET['prodid'];
        $sqlcheckstock = "SELECT * FROM tbl_products WHERE prid = '$prodid' "; //check product in stock
        $stmt = $conn->prepare($sqlcheckstock);
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();
        foreach ($rows as $product) {
            $quantity = $product['prqty']; //check qty  in stock?
            if ($quantity == 0) {
                echo "<script>alert('Quantity not available');</script>";
                echo "<script> window.location.replace('menu.php')</script>";
            } else {
                //continue insert to cart
                $sqlcheckcart = "SELECT * FROM tbl_carts WHERE prid = '$prodid' AND email = '$email'";
                $stmt = $conn->prepare($sqlcheckcart);
                $stmt->execute();
                $number_of_result = $stmt->rowCount();
                if ($number_of_result == 0) { //insert cart if not in the cart
                    $sqladdtocart = "INSERT INTO tbl_carts (email, prid, qty) VALUES ('$email','$prodid','1')";
                    if ($conn->exec($sqladdtocart)) {
                        echo "<script>alert('Success')</script>";
                        echo "<script> window.location.replace('menu.php')</script>";
                    } else {
                        echo "<script>alert('Failed')</script>";
                        echo "<script> window.location.replace('menu.php')</script>";
                    }
                } else { //update cart if the item already in the cart
                    $sqlupdatecart = "UPDATE tbl_carts SET qty = qty +1 WHERE prid = '$prodid' AND email = '$email'";
                    if ($conn->exec($sqlupdatecart)) {
                        echo "<script>alert('Success')</script>";
                        echo "<script> window.location.replace('menu.php')</script>";
                    } else {
                        echo "<script>alert('Failed')</script>";
                        echo "<script> window.location.replace('menu.php')</script>";
                    }
                }
            }
        }
    }
}
//search and list products
if (isset($_GET['button'])) {
    $prname = $_GET['prname'];
    $prtype = $_GET['prtype'];
    if ($prtype == "all") {
        $sqlsearch = "SELECT * FROM tbl_products WHERE prname LIKE '%$prname%'";
    } else {
        $sqlsearch = "SELECT * FROM tbl_products WHERE prtype = '$prtype' AND prname LIKE '%$prname%'";
    }
} else {
    $sqlsearch = "SELECT * FROM tbl_products ORDER BY prid DESC"; //search and list by descending
}
$stmt = $conn->prepare($sqlsearch);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Fatimah Nasi Kandar</title> <!--Title-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/style.css"> <!--CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src='../js/myscript.js'></script> <!--JavaScript-->
</head>
<body onload="loadCookies()">
    <div class="header">
        <a href="menu.php" class="logo">FATIMAH NASI KANDAR</a> <!--click to Menu page-->
        <div class="header-right">
            <a class="active" href="menu.php">Menu</a> <!--active class-->
            <a href="cart.php">My Cart</a> <!--click to cart page-->
            <a href="profile.php">My Profile</a> <!--click to profile page-->
            <a href="javascript:cookiesdialog()">My Email</a> <!--insert email-->
            <a href="../index.html">Log Out</a>
        </div>
    </div>
    <center><h2>List of Menu</h2></center>
    <div class="container-src"> <!--container-->
        <form action="menu.php" method="get">
            <div class="row">
                <div class="column"> <!--search column-->
                    <input type="text" id="fprname" name="prname" placeholder="Menu name - e.g. (Ayam Goreng)">
                </div>
                <div class="column">
                    <select id="idprtype" name="prtype"> <!--menu type-->
                    <option value="all">All</option>
                        <option value="ayam">Ayam</option>
                        <option value="daging">Daging</option>
                        <option value="ikan">Ikan</option>
                        <option value="sotong">Sotong</option>
                        <option value="udang">Udang</option>
                    </select>
                </div>
                <div class="column"> <!--submit button-->
                    <input type="submit" name="button" value="Search">
                </div>
            </div>
        </form>
    </div>
    <?php
    echo "<div class='container'>";
    echo "<div class='card-row'>";
    foreach ($rows as $products) { //row of product//
        $prodid = $products['prid'];
        $qty = $products['prqty'];
        echo " <div class='card'>";
        $imgurl = "../images/" . $products['picture']; //menu image//
        echo "<img src='$imgurl' class='primage'>";
        echo "<h4 align='center' >" . ($products['prname']) . "</h3>"; //name of product//
        echo "<p align='center'> RM " . number_format($products['prprice'], 2) . "<br>"; //price of product//
        echo "Available:" . ($products['prqty']) . " order/s</p>"; //Available order status//
        echo "<a href='menu.php?op=cart&prodid=$prodid'><i class='fa fa-cart-plus'  onclick='return cartDialog()' style='font-size:24px;color:dodgerblue'></i></a>";
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    ?>
    <a href="newproduct.php" class="float"> <!--float button to new product-->
        <i class="fa fa-plus my-float"></i>
    </a>
</body>
</html>