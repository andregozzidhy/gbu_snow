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
		echo "<div class='header-text'>Tell Us About Yourself</div>";
		$attributes = array('id' => 'formSignUp');
		echo form_open('gbusnow_controller/signup',$attributes,'class="form-horizontal" id="formSignUp"');
		
		echo "<div class='form-group'>";
			echo "<div class='col-sm-3'>";
				echo form_input('txtname', $name, 'class="form-control" placeholder="Name"');
			echo "</div>";
			echo "<div class='help-block with-errors'></div>";
		echo "</div>";
		
		echo "<div class='form-group'>";
			echo "<div class='col-sm-3'>";
				echo form_input('txtemail', $email, 'class="form-control" placeholder="Email"');
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
			echo "<div class='col-sm-3'>";
				echo form_password('txtconfirmpassword', '', 'class="form-control" placeholder="Confirm Password" id="txtconfirmpassword"');
			echo "</div>";
			echo "<div class='help-block with-errors'></div>";
		echo "</div>";
		
		echo "<div class='form-group'>";
			echo "<div class='col-sm-3'>";
				echo form_input('txtphonenumber', $phonenumber, 'class="form-control" placeholder="Phone Number"');
			echo "</div>";
			echo "<div class='help-block with-errors'></div>";
		echo "</div>";
		
		echo "<div class='form-group'>";
		  echo "<label><input type='checkbox' value='' name='cbAgree' id='cbAgree'> I Agree to the Terms and Conditions</label>";
		echo "</div>";
		//echo "<input type='button' class='btn btn-small btn-primary' id='btnPrevious' name='btnprevious' value='Previous'>";
		echo form_submit('btnnext','Register!', 'class="btn btn-small btn-primary" id="btnnext"') ;
		echo form_close();
		echo validation_errors();
		echo $msg;
		echo "Already User? Login <a href='".site_url('gbusnow_controller/login')."'>Here!</a>";
		
	?>
		
			
	</div>
</div>
</body>
<script>
	
	$(function(){
		$("#btnnext").attr("disabled", "disabled");
	});
	
	$(document).ready(function(){
		
		$("#cbAgree").change(function(){
			if(document.getElementById("cbAgree").checked ==true)
			{
				$("#btnnext").removeAttr("disabled");
				//alert("checked");
			}
			else
			{
				$("#btnnext").attr("disabled", "disabled");
				//alert("unchecked");
			}
		});
		
	});
	
	
</script>
</html>