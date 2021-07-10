<?php
session_start();
include_once("dbconnect.php");
if (!isset($_COOKIE['email'])) {
    echo "<script>loadCookies()</script>"; //start load cookies//
    echo "<script> window.location.replace('menu.php')</script>"; 
} else {
    $email = $_COOKIE["email"]; //cookies email//
    if (isset($_GET['button'])) {
        $op = $_GET["button"];
        if ($op == "delete") { //delete cart//
            $prid = $_GET['prid'];
            $sqldelete = "DELETE FROM tbl_carts WHERE email='$email' AND prid = '$prid'";
            $stmt = $conn->prepare($sqldelete);
            if ($stmt->execute()) {
                echo "<script> alert('Delete Success')</script>"; //success delete//
                echo "<script>window.location.replace('cart.php')</script>";
            } else {
                echo "<script> alert('Delete Failed')</script>"; //failed delete//
            }
        }
        if ($op == "addcart") { //add to cart//
            $prid = $_GET['prid'];
            $sqlupdatecart = "UPDATE tbl_carts SET qty = qty +1 WHERE prid = '$prid' AND email = '$email'";
            if ($conn->exec($sqlupdatecart)) {
                echo "<script>alert('Success')</script>";
                echo "<script> window.location.replace('cart.php')</script>"; //success add//
            } else {
                echo "<script>alert('Failed add')</script>";
                echo "<script> window.location.replace('cart.php')</script>"; //failed add//
            }
        }
        if ($op == "removecart") { //remove from cart//
            $prid = $_GET['prid'];
            $qty = $_GET['qty'];
            if ($qty == 1) {
                echo "<script>alert('Failed.')</script>"; //failed remove//
                echo "<script> window.location.replace('cart.php')</script>";
            } else {
                $sqlupdatecart = "UPDATE tbl_carts SET qty = qty - 1 WHERE prid = '$prid' AND email = '$email'";
                if ($conn->exec($sqlupdatecart)) {
                    echo "<script>alert('Success')</script>";
                    echo "<script> window.location.replace('cart.php')</script>"; //success remove//
                } else {
                    echo "<script>alert('Failed')</script>";
                    echo "<script> window.location.replace('cart.php')</script>"; //failed remove//
                }
            }
        }
        if ($op == "Pay") { //pay to sandbox bilpliz//
            $name = $_GET["name"];
            $mobile = $_GET["phone"];
            $pickup = $_GET['pickup'];
            $amount = $_GET['price'];

            $api_key = '98017c59-ab34-4450-b99b-d9e97edd1756'; //my api key//
            $collection_id = 'dap5ffmv'; //my collection id//
            $host = 'https://billplz-staging.herokuapp.com/api/v3/bills';

            $data = array(
                'collection_id' => $collection_id,
                'email' => $email,
                'mobile' => $mobile,
                'name' => $name,
                'amount' => $amount * 100, // RM20
                'description' => 'Payment for order',
                'callback_url' => "http://mustaqimbaharin.epizy.com/FNK/php/menu.php",
                'redirect_url' => "http://mustaqimbaharin.epizy.com/FNK/php/paymentupdate.php?userid=$email&mobile=$mobile&amount=$amount"
            );
            $process = curl_init($host);
            curl_setopt($process, CURLOPT_HEADER, 0);
            curl_setopt($process, CURLOPT_USERPWD, $api_key . ":");
            curl_setopt($process, CURLOPT_TIMEOUT, 30);
            curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($data));

            $return = curl_exec($process);
            curl_close($process);

            $bill = json_decode($return, true);

            //echo "<pre>".print_r($bill, true)."</pre>";
            header("Location: {$bill['url']}"); //to url//

        }
    }
    $sqlloadcart = "SELECT * FROM tbl_carts INNER JOIN tbl_products ON tbl_carts.prid = tbl_products.prid WHERE tbl_carts.email = '$email'";
    $stmt = $conn->prepare($sqlloadcart);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fatimah Nasi Kandar</title> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/style.css"> <!--reference CSS style-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src='../js/myscript.js'></script> <!--reference JavaScript-->
</head>
<body>
    <div class="header">
        <a href="menu.php" class="logo">FATIMAH NASI KANDAR</a> <!--Logo-->
        <div class="header-right">
            <a href="menu.php">Menu</a> <!--click to Menu page-->
            <a class="active" href="cart.php">My Cart</a> <!--active page-->
            <a href="profile.php">My Profile</a> <!--click to My Profile-->
            <a href="javascript:cookiesdialog()">My Email</a> <!--click to Insert Email -->
            <a href="../index.html">Log Out</a> <!--click to Log out-->
        </div>
    </div>
    <center>
        <h2>Your Menu Cart</h2>
    </center>
    <?php
    $sumtotal = 0.0; //total cart//
    echo "<div class='container'>";
    echo "<div class='card-row'>";
    foreach ($rows as $carts) {
        $prid = $carts['prid'];
        $qty = $carts['qty'];
        $total = 0.0;
        $total = $carts['prprice'] * $carts['qty']; //total price and quantity//
        $imgurl = "../images/" . $carts['picture']; //photo menu//
        echo " <div class='card'>";
        echo "<p align='right'><a href='cart.php?button=delete&prid=$prid' class='fa fa-remove' onclick='return deleteDialog()' style='text-decoration:none'></a></p>";
        echo "<img src='$imgurl' class='primage'>";
        echo "<h4 align='center' >" . ($carts['prname']) . "</h3>";
        echo "<p align='center'> RM " . number_format($carts['prprice'], 2) . "/unit<br>";
        echo "<table class='center'><tr><td><a href='cart.php?button=removecart&prid=$prid&qty=$qty'><i class='fa fa-minus' ' style='font-size:24px;color:dodgerblue'></i></a></td>";
        echo "<td>Qty " . $qty . "</td>";
        echo "<td>&nbsp<a href='cart.php?button=addcart&prid=$prid&qty=$qty'><i class='fa fa-plus' ' style='font-size:24px;color:dodgerblue'></i></a></td></tr></table>";
        echo "Total RM " . number_format($total, 2) . "<br>";
        echo "</div>";
        $sumtotal = $total + $sumtotal; //total cart//
    } 
    echo "</div>";
    echo "</div>";
    echo "<div class='container-src'>
    <h3>Total Price: RM " . number_format($sumtotal, 2) . "</h3></div>";
    ?>
    <div class="container">
        <h3>Payment Form</h3> <!--Payment Form-->
        <form action="cart.php" method="get">
            <div class="row">
                <div class="col-25">
                    <label for="lblemail">Your Email</label> <!--Email-->
                </div>
                <div class="col-75">
                    <input type="text" id="idemail" name="email" value="<?php echo $email ?>" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="lblname">Your Name</label> <!--Name-->
                </div>
                <div class="col-75">
                    <input type="text" id="idname" name="name" placeholder="Your Name" required>
                </div>
            </div>

            <div class="row">
                <div class="col-25">
                    <label for="lphone">Phone Number</label> <!--Phone Number-->
                </div>
                <div class="col-75">
                    <input type="text" id="idphone" name="phone" placeholder="Your phone" required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="ltime">Pickup Time</label> <!--Pickup Time-->
                </div>
                <div class="col-75">
                    <input type="time" id="idtime" name="pickup" min="11:00" max="9:30" required>
                </div>
            </div>
            <input type="hidden" id="idprice" name="price" value="<?php echo $sumtotal ?>">
            <div class="row">
                <div class="col-25">
                </div>
                <div class="col-75">
                    <input type="submit" name="button" value="Pay">
                </div>
            </div>
        </form>
    </div>
</body>
</html>