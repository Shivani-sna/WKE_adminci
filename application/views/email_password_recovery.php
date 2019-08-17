<!DOCTYPE html>
<html>
<head>
	<title>WKE</title>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<style type="text/css">
		
		body{
			
			 background-repeat: no-repeat;
			 background-size: cover;
		}
		#design
		{
			
			height: 409px;
 			width: 500px;
  			border: 4px solid black;
  			padding: 50px;
  			margin: 20px;
  			box-shadow: 10px 10px 10px rgba(0,0,0,0.3);

  			
		}
		a,
		a:hover
		{
			color: #ffc04c;
			text-decoration: none;
		}
		.color{
			color: black;
		}
		h3{
			color:#00468b;
			
		}
		p,h3
		{
		text-align: left;
		}
	</style>
</head>
<body>
	<center>

		<div id="design">
			<h3>Don't worry, we all forget sometimes</h3>
			<hr>
			<p> Hi, <?php echo $user['firstname'].''.$user['lastname']; ?></br>
			</br>
			You've recently asked to reset the password for this WKE account:<?php echo $user['email']; ?>
		</br></br>
		To update your password, click the button below:

  
		</br></br>
  		<center><a href="<?php echo base_url("authentication/reset_password/$key"); ?>" class="w3-button w3-blue">Reset Password</a></center>

		</p>
			
			
			<!-- <p>For Password Recovery</p> -->
			
		</div>
	</center>
</body>
</html>