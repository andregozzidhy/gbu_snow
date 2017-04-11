<html lang="en">
<?php
	require_once("includes.php")
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>Snow Project</title>
	<link rel="stylesheet" type="text/css" media="screen and (max-device-width: 1200px)" href="<?php echo base_url('assets/css/default_css_portrait.css'); ?>">
	<script src="//js.stripe.com/v2/"></script>
	<script>
		(function() {
			Stripe.setPublishableKey('pk_test_yjTcVU2HlS2fnd3u9XKphdKm');
		})();
	</script>
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
		<form action="" method="POST">
		  <script
			src="https://checkout.stripe.com/v2/checkout.js" class="stripe-button"
			data-key="pk_test_yjTcVU2HlS2fnd3u9XKphdKm"
			data-amount="2000"
			data-name="Demo Site"
			data-description="2 widgets ($20.00)"
			data-image="/128x128.png">
		  </script>
		</form>
	<?php
		$attributes = array('id' => 'formPayment');
		echo form_open('gbusnow_controller/payment',$attributes,'class="form-horizontal" id="formPayment"');
	
		echo form_submit('btnPayment','Confirm Payment', 'class="btn btn-small btn-primary" id="btnPayment"') ;
		echo form_close();
		
?>
		
			
	</div>
</div>
</body>
<script>
		
	
</script>
</html>