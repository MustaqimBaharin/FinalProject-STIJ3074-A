<?php
include_once("dbconnect.php");
if (isset($_POST['button'])) {
    $prname = $_POST['prname'];
    $prtype = $_POST['prtype'];
    $prprice = $_POST['prprice'];
    $prqty = $_POST['prqty'];
    $picture = uniqid() . '.png';
    if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
        $sqlinsertprod =  "INSERT INTO tbl_products(prname, prtype, prprice, prqty,picture) VALUES('$prname','$prtype','$prprice','$prqty','$picture')";
        if ($conn->exec($sqlinsertprod)) {
            uploadImage($picture);
            echo "<script>alert('Success')</script>";
            echo "<script>window.location.replace('menu.php')</script>";
        } else {
            echo "<script>alert('Failed')</script>";
            return;
        }
    } else {
        echo "<script>alert('Image not available')</script>";
        return;
    }
}
function uploadImage($picture)
{
    $target_dir = "../images/";
    $target_file = $target_dir . $picture;
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Fatimah Nasi Kandar</title> <!--Title-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../js/myscript.js"></script> <!--JavaScript-->
    <link rel="stylesheet" href="../css/style.css"> <!--CSS-->
    </style>
</head>
<body>
    <div class="header">
        <a href="menu.php" class="logo">FATIMAH NASI KANDAR</a> <!--click to Menu page-->
        <div class="header-right">
        <a class="active" href="newproduct.php">Upload Menu</a> <!--active class-->
            <a href="menu.php">Menu</a> <!--click to menu page-->
            <a href="cart.php">My Cart</a> <!--click to cart page-->
           <a href="profile.php">My Profile</a> <!--click to profile page-->
            <a href="javascript:cookiesdialog()">My Email</a> <!--insert email-->
            <a href="../index.html">Log Out</a>
        </div>
    </div>
    <center><h2>Upload Menu</h2></center> <!--upload menu title-->
    <div class="container">
        <form action="newproduct.php" method="post" enctype="multipart/form-data">
            <div class="row" align="center">
                <img class="imgselection" src="images.png"><br> <!--image menu-->
                <input type="file" onchange="previewFile()" name="fileToUpload" id="fileToUpload" accept="image/*"><br>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="fprname">Menu Name</label> <!--menu name-->
                </div>
                <div class="col-75">
                    <input type="text" id="fprname" name="prname" placeholder="Enter menu name.">
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="prtype">Menu Type </label> <!--menu type-->
                </div>
                <div class="col-75">
                    <select id="idprtype" name="prtype">
                    <option value="ayam">Ayam</option>
                            <option value="daging">Daging</option>
                            <option value="ikan">Ikan</option>
                            <option value="sotong">Sotong</option>
                            <option value="udang">Udang</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="lprice">Price (RM)</label> <!--menu price-->
                </div>
                <div class="col-75">
                    <input type="text" id="idprice" name="prprice" placeholder="Enter Price." >
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="lqty">Quantity</label> <!--menu quantity-->
                </div>
                <div class="col-75">
                    <input type="text" id="idqty" name="prqty" placeholder="Enter Available Quantity.">
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                </div>
                <div class="col-75"> <!--submit button-->
                    <input type="submit" name="button" value="Submit">
                </div>
            </div>
        </form>
    </div>
</body>
</html>