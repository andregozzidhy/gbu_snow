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
		
		.dataService{
			margin : 5px;
			padding: 10px;
			border: 2px solid #ABC6ED;
			width: 385px;
			float: left;
		}
		
		.dataServiceLeft{
			padding: 25px;
			border: 2px solid #ABC6ED;
			width: 360px;
		}
		.dataServiceRight{
			padding: 25px;
			border: 2px solid #ABC6ED;
			width: 360px;
		}
				
	</style>
</head>
<body>
<div id="container">
	<?php
		echo "<a href='".site_url('gbusnow_controller/providerDashboard')."'>PROVIDER DASHBOARD</a><br>";
		echo "<a href='".site_url('gbusnow_controller/logout')."'>LOGOUT</a><br>";
		$dataService = $this->gbusnow_model->getFinishedService($provider_id);
		echo "<div class='header-text'>Finished Service</div>";
		
		echo "<div id='allData'>";
		
		if(count($dataService) >0)
		{
			for($i=0;$i<count($dataService);$i++)
			{
				echo "<div class=dataService id='dc-".$dataService[$i]->service_quote_id ."'>";
					echo "<div class=dataServiceLeft id='dcl-".$dataService[$i]->service_quote_id ."'>";
						echo "<label>SERVICE : </label>".$dataService[$i]->service_name . "<br>";
						echo "<label>CUSTOMER: </label>".$dataService[$i]->customer_name. "<br>";
						$alamat = $this->gbusnow_model->getHouseAddressUsingHouseId($dataService[$i]->house_id);
						echo "<label>ADDRESS : </label>".$alamat. "<br>";
						echo "<label>ON : </label>".date("D,d M Y", strtotime($dataService[$i]->service_date_final))." - ".date('h:i A', strtotime($dataService[$i]->service_time_final));
					echo "</div>";		
				echo "</div>";
				
			}			
		}
		else
		{
			
		}

		echo "</div>";
	?>
</div>

	
	
</body>
<script>

	
</script>
</html>