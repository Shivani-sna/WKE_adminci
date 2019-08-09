<!DOCTYPE html>
<html>
<head>
	<title>WKE</title>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
	<style type="text/css">
		
		body{
			
			 background-repeat: no-repeat;
			 background-size: cover;
		}
		#design
		{
			
			height: 209px;
 			width: 300px;
  			border: 4px solid black;
  			padding: 50px;
  			margin: 20px;
  			box-shadow: 10px 10px 10px rgba(0,0,0,0.3);

  			color: #ffc04c;
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
		.h3{
			float: left;
		}
	</style>
</head>
<body>
	<center>
		<div id="design">
			<h3>Password Recovery Mail</h3>
			<h2>WKE</h2>
			<!-- <p>For Password Recovery</p> -->
			<a href="<?php echo base_url('authentication/reset_password/').$key; ?>">Click Here</a>
		</div>
	</center>
</body>
</html>