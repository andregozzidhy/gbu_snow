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
		echo "<div class='header-text'>Log in</div>";
		$attributes = array('id' => 'formLogin');
		echo form_open('gbusnow_controller/login',$attributes,'class="form-horizontal" id="formLogin"');
		
		echo "<div class='form-group'>";
			echo "<div class='col-sm-3'>";
				echo form_input('txtemail', '', 'class="form-control" placeholder="Email"');
			echo "</div>";
			echo "<div class='help-block with-errors'></div>";
		echo "</div>";
		
		echo "<div class='form-group'>";
			echo "<div class='col-sm-3'>";
				echo form_password('txtpassword', '', 'class="form-control" placeholder="Password" id="txtpassword"');
			echo "</div>";
			echo "<div class='help-block with-errors'></div>";
		echo "</div>";
		echo "<div class='form-group'>";
			echo form_submit('btnLogin','Login', 'class="btn btn-small btn-primary" id="btnLogin"') ;
			echo form_close();
		echo "</div>";
		echo "Not Registered User? Sign Up <a href='".site_url('gbusnow_controller/signup')."'>Here!</a>";
		echo validation_errors();
		echo "<br>". $msg;
	?>
		
			
	</div>
</div>
</body>
<script>
	
	
	
</script>
</html>