<html lang="en">
<?php
	require_once("includes.php")
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>Snow Project</title>
	<link rel="stylesheet" type="text/css" media="screen and (max-device-width: 1200px)" href="<?php echo base_url('assets/css/default_css_portrait.css'); ?>">
	
	<style type="text/css">
		.header-text {
			font-size: 20pt;
			margin-top: 30px;
			font-weight: bold;
			clear: both;
		}
		
		.form-group{
			margin-bottom: 10px;
			clear: both;
		}
		
		.col-sm-3{
			margin-bottom:10px;
		}
	</style>
</head>
<body>
	<div id="container">
	<?php
		echo "<div class='header-text'>HOMEPAGE</div>";
		echo "LET's GET STARTED! <a href='".site_url('gbusnow_controller/signup')."'> Click Here!</a><br>";
		echo "USER LOG IN  <a href='".site_url('gbusnow_controller/login')."'>HERE!</a><br>";
		echo "PROVIDER LOG IN  <a href='".site_url('gbusnow_controller/providerlogin')."'>HERE!</a><br>";
		echo "WORK WITH US <a href='".site_url('gbusnow_controller/providerSignUp')."'> Click Here!</a><br>";
		
	?>
		
			
	</div>
</div>
</body>
<script>
	

	
	
</script>
</html>