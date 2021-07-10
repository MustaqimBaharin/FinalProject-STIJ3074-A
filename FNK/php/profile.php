<!DOCTYPE html>
<html>
<head>
<title>Fatimah Nasi Kandar</title> <!--Title-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../js/myscript.js"></script> <!--javascript-->
    <link rel="stylesheet" href="../css/style.css"> <!--css-->
    </style>
</head>
<body>
    <div class="header">
        <a href="menu.php" class="logo">FATIMAH NASI KANDAR</a> <!--click to menu page-->
        <div class="header-right">
            <a href="menu.php">Menu</a> <!--click to menu page-->
            <a href="cart.php">My Cart</a> <!--click to cart page-->
            <a class="active" href="profile.php">My Profile</a> <!--active page-->
            <a href="javascript:cookiesdialog()">My Email</a> <!--inser email-->
            <a href="../index.html">Log Out</a>
        </div>
    </div>
    <center><h2>Update Profile</h2></center>
    <div class="container">
  
            <div class="row">
                <div class="col-25">
                    <label for="fprname">Name</label> <!--name-->
                </div>
                <div class="col-75">
                    <input type="text" id="fprname" name="prname" placeholder="Enter name">
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="fprname">Email</label> <!--email-->
                </div>
                <div class="col-75">
                    <input type="text" id="fprname" name="prname" placeholder="Enter valid email">
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="fprname">Phone</label> <!--phone-->
                </div>
                <div class="col-75">
                    <input type="text" id="fprname" name="prname" placeholder="Your phone number without (-)">
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="prtype">District</label> <!--district-->
                </div>
                <div class="col-75">
                    <select id="idprtype" name="prtype">
                                <option value="noselection">Please select your district</option>
                                <option value="Abi">Abi</option>
                                <option value="Arau">Arau</option>
                                <option value="Beseri">Beseri</option>
                                <option value="Chuping">Chuping</option>
                                <option value="Jejawi">Jejawi</option>
                                <option value="Kaki Bukit">Kaki Bukit</option>
                                <option value="Kayang">Kayang</option>
                                <option value="Kechor">Kechor</option>
                                <option value="Kuala Perlis">Kuala Perlis</option>
                                <option value="Kurong Anai">Kurong Anai</option>
                                <option value="Kurong Batang">Kurong Batang</option>
                                <option value="Ngulang">Ngulang</option>
                                <option value="Oran">Oran</option>
                                <option value="Padang Pauh">Padang Pauh</option>
                                <option value="Sanglang">Sanglang</option>
                                <option value="Sena">Sena</option>
                                <option value="Seriab">Seriab</option>
                                <option value="Sungai Adam">Sungai Adam</option>
                                <option value="Titi Tinggi (Padang Besar)">Titi Tinggi</option>
                                <option value="Utan Aji">Utan Aji</option>
                                <option value="Wang Bintong">Wang Bintong</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="lprice">Password</label> <!--password form for Register-->
                </div>
                <div class="col-75">
                    <input type="text" id="idprice" name="prprice" placeholder="Enter password" >
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label for="lqty">Password</label> <!--password form for Register-->
                </div>
                <div class="col-75">
                    <input type="text" id="idqty" name="prqty" placeholder="Confirmation password">
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                </div>
                <div class="col-75"> <!--submit-->
                    <input type="submit" name="button" value="Submit">
                </div>
            </div>
        </form>
    </div>
</body>
</html>