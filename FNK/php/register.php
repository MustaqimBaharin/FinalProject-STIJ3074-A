<?php
    include_once("dbconnect.php"); // connect to database
     $name = $_GET["name"]; // post the name
     $email = $_GET["email"]; // post the email
     $phone = $_GET["phone"]; // post the phone number
     $district = $_GET["district"]; // post the district
     $passa = $_GET["passworda"]; // post the password
     $passb = $_GET["passwordb"]; // post the confirmation password
     $shapass = sha1($passa);  // password with encryption sha1
	 
        $sqlregister = "INSERT INTO tbl_user(email,phone,name,district,password) VALUES('$email','$phone','$name','$district','$shapass')"; // tbl_user in MySQL
        try{
            $conn->exec($sqlregister);
            echo "<script> alert('Registration successful')</script>"; // show, if register to Database success
            echo "<script> window.location.replace('../php/menu.php')</script>"; // return the login page after success
        }catch(PDOException $e){
            echo "<script> alert('Registration failed')</script>"; // show, if register to Database fail
            echo "<script> window.location.replace('../php/login.php')</script>"; // stay at register page if register failed
        }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration Form</title> <!--Title Registration Form-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="../js/login.js"></script> <!--reference JavaScript-->
	<link rel="stylesheet" href=".../css/login.css"> <!--reference CSS style-->
</head>
<body>
	<div class="header"> <!--Header content with web name-->
		<h1>Fatimah Nasi Kandar Self-Pickup</h1>
		<p>Origin from Perlis, Since 1996</p>
	</div>
	<div class="topnavbar"> <!--Top Navigation Bar-->
		<a href="login.php" class="right">Login</a> <!--Navigation to Login Page-->
	</div>
	<div class="main">
		<center><img src="../images/fatimahlogo.png"></center> <!--Front logo for Web-->
		<div class="container"> <!--Container class for Register-->
			<form name="registerForm" action="../php/register.php" onsubmit="return validateRegForm()" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-25">
						<label for="fname">Name</label> <!--name form for Register-->
					</div>
					<div class="col-75">
						<input type="text" id="idname" name="name" placeholder="Enter name">
					</div>
				</div>
				<div class="row">
					<div class="col-25">
						<label for="lname">Email</label> <!--email form for Register-->
					</div>
					<div class="col-75">
						<input type="text" id="idemail" name="email" placeholder="Enter valid email">
					</div>
				</div>
				<div class="row">
					<div class="col-25">
						<label for="lphone">Phone</label> <!--phone number form for Register-->
					</div>
					<div class="col-75">
						<input type="tel" id="idphone" name="phone" placeholder="Your phone number without (-)">
					</div>
				</div>
				<div class="row">
					<div class="col-25">
						<label for="district">Districts</label> <!--district in Perlis form for Register-->
					</div>
					<div class="col-75">
						<select name="district" id="iddistrict">
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
						<label for="lpassword">Password</label> <!--password form for Register-->
					</div>
					<div class="col-75">
						<input type="password" id="idpass" name="passworda" placeholder="Enter password">
					</div>
				</div>
				<div class="row">
					<div class="col-25">
						<label for="lpassword">Password</label> <!--password form for Register-->
					</div>
					<div class="col-75">
						<input type="password" id="idpassb" name="passwordb" placeholder="Confirmation password">
					</div>
				</div>
				<div class="row">
					<div><input type="submit" name="submit" value="Submit"></div> <!--submit button for Register-->
				</div>
			</form>
		</div>
	</div>
	<br>
	<div class="bottomnavbar"> <!--Bottom Navigation Bar-->
		<a href="../index.html">Home</a> <!--Navigation to Landing Page-->
		<a href="contact.html">Contact Us</a> <!--Navigation to Contact Us Page-->
	</div>
</body>
</html>