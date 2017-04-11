<html lang="en">
<?php
	require_once("includes.php")
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>Snow Project</title>
	<link rel="stylesheet" type="text/css" media="screen and (max-device-width: 1200px)" href="<?php echo base_url('assets/css/default_css_portrait.css'); ?>">
	<?php echo $map['js']; ?>
	<style type="text/css">
		.header-text {
			font-size: 20pt;
			margin-top: 30px;
			font-weight: bold;
			clear: both;
		}
		
		.locationMap{
			
			width: 48%;
			margin-top: 10px;
		}
		
			#map_canvas{
			height: 300px;
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
		echo "<div class='header-text'>". $summaryData[0]->user_name."</div>";
		echo "<label for='notes'>Your Location : ".$summaryData[0]->house_address."</label>";
		echo "<div id='locationMap' class='locationMap'>";
			echo $map['html'];
		echo "</div>";
		
		echo "<table style='' class='table table-hover table-striped table-responsive' id='tableSummary'>";
			
			if($service_id=='1')
			{
				echo "<tr>";
					echo "<td>";
						echo "<label for='driveway Header'>".$summaryData[0]->service_name."</label>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td>";
						echo "<label for='driveway Header'>Driveway Info</label>";
					echo "</td>";
				echo "</tr>";
				
				
				echo "<tr>";
					echo "<td>";
						echo "Driveway Width : ".$summaryData[0]->house_drivewaywidth;
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td>";
						echo "Driveway Length : ".$summaryData[0]->house_drivewaylength;
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td>";
						echo "Driveway Shape : ".$summaryData[0]->house_drivewayshape;
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td>";
						echo "Driveway Type : ".$summaryData[0]->house_drivewaytype;
					echo "</td>";
				echo "</tr>";
			}
			else if($service_id=='2' || $service_id=='3' )
			{
				echo "<tr>";
					echo "<td>";
						echo "<label for='lawn Header'>".$summaryData[0]->service_name."</label>";
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td>";
						echo "<label for='lawn Header'>Lawn Info</label>";
					echo "</td>";
				echo "</tr>";
				
				
				echo "<tr>";
					echo "<td>";
						echo "Lawn Size : ".$summaryData[0]->house_lawn_size;
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td>";
						echo "Lawn Hilly : ".$summaryData[0]->house_lawn_hilly;
					echo "</td>";
				echo "</tr>";

				echo "<tr>";
					echo "<td>";
						echo "Lawn Gate Size : ".$summaryData[0]->house_gate_size;
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td>";
						if($summaryData[0]->house_fence == '1')
						{
							echo "House Fence : Yes";
						}
						else
						{
							echo "House Fence : No";
						}
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td>";
						if($summaryData[0]->house_pool == '1')
						{
							echo "House Pool : Yes";
						}
						else
						{
							echo "House Pool : No";
						}
					echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
					echo "<td>";
						if($summaryData[0]->house_sprinklers == '1')
						{
							echo "House Sprinklers : Yes";
						}
						else
						{
							echo "House Sprinklers : No";
						}
					echo "</td>";
				echo "</tr>";
			}
			
			echo "<tr>";
				echo "<td>";
					echo "<label for='scheduleHeader'>Schedule</label>";
				echo "</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td>";
					echo $firstDatePicked." / ".$firstTimePicked;
				echo "</td>";
			echo "</tr>";
			
			if($secondDatePicked !="")
			{
				echo "<tr>";
					echo "<td>";
						echo $secondDatePicked." / ".$secondTimePicked;
					echo "</td>";
				echo "</tr>";
			}
				
			if($thirdDatePicked !="")
			{
				echo "<tr>";
					echo "<td>";
						echo $thirdDatePicked." / ".$thirdTimePicked;
					echo "</td>";
				echo "</tr>";
			}
			
			echo "<tr>";
				echo "<td>";
					echo "<label for='pricingHeader'>Pricing</label>";
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td>";
					echo $summaryData[0]->service_name ." : $". $summaryData[0]->service_price;
				echo "</td>";
			echo "</tr>";
			
			if($footOver  == '1')
			{
				echo "<tr>";
					echo "<td>";
						echo " 1+ Foot Snow : $". $summaryData[0]->service_price;
					echo "</td>";
				echo "</tr>";
			}
				
			echo "<tr>";
				echo "<td>";
					echo " House Size Fee : $". $houseSize;
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td>";
					echo " Transaction Fee : $". $transactionFee;
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td>";
					echo " Credits : $". $credits;
				echo "</td>";
			echo "</tr>";
			
			echo "<tr>";
				echo "<td>";
					echo " Sales Tax : $". $credits;
				echo "</td>";
			echo "</tr>";

			echo "<tr>";
				echo "<td>";
					echo "<label id='labeltotalQuote' for='totalQuote' data='".$totalQuote."'>Total Quote : $".$totalQuote."</label>";
				echo "</td>";
			echo "</tr>";
			
	
		echo "</table>";
		
		echo "<form>";
		echo "<div class='form-group'>";
			echo "<div class='col-sm-2'>";
				echo form_input('txtPromoCode', '', 'class="form-control" id="txtPromoCode" placeholder="Promo Code"');
			echo "</div>";
			echo "<input type='button' class='btn btn-small btn-primary' id='btnApply' name='btnApply' value='Apply'>";
			echo "<input type='hidden' name='hiddenPromoCode' id='hiddenPromoCode' value='' />";
		echo "</div>";
		echo "<div class='help-block with-errors'></div>";
		echo "</form>";
		
		/*
		echo "<input type='hidden' name='hiddenTotalQuote' id='hiddenTotalQuote' value='".$totalQuote."' />";
		$attributes = array('id' => 'formConfirm');
		echo form_open('gbusnow_controller/summary',$attributes,'class="form-horizontal" id="formDriveWay"');
		
		echo form_submit('btnConfirm','Confirm', 'class="btn btn-small btn-primary" id="btnConfirm"') ;
		echo form_close();
		*/
		
		echo "<form action='../stripe_payment/checkout' method='POST'>
		  <script
			src='https://checkout.stripe.com/v2/checkout.js' id=buttonStripe' class='stripe-button'
			data-key='pk_test_yjTcVU2HlS2fnd3u9XKphdKm'
			data-amount='".($totalQuote*100)."'
			data-name='GBU Service Payment'
			data-description='Total Quote : $".$totalQuote."'
			data-image='/128x128.png'>
		  </script>
		  <input type='hidden' name='discountValue' id='discountValue' value='".$discountValue."' />
		  <input type='hidden' name='totalQuote' id='totalQuote' value='".$totalQuote."' />
		  <input type='hidden' name='finalQuote' id='finalQuote' value='".$finalQuote."' />
		  <input type='hidden' name='hiddenparameter' id='hiddenparameter' value='0' />
		</form>";
		
?>		
	</div>
</div>
</body>
<script>

$("#btnApply").click(function()
{
	var kode = document.getElementById("txtPromoCode").value;
	 $.ajax({
            url: "<?php echo site_url('gbusnow_controller/usePromoCode'); ?>",
            type: "POST",
			dataType: "json",
			data: {promo_code: kode				
			},
            success: function(promoResult) {
				
				if(promoResult.discount != 0)
				{
					var innerHTML = "";
					innerHTML += "<tr><td><label>Promo Code Discount : $"+promoResult.discount+"</label></td><tr>";
					
					var totalQuote = document.getElementById("totalQuote").value;
					var finalQuote = totalQuote - promoResult.discount;
					
					alert(promoResult.msg);
					
					document.getElementById("finalQuote").value = finalQuote;
					
					innerHTML += "<tr><td><label>Final Quote : $"+finalQuote+"</label></td><tr>";
					
					$('#tableSummary').append(innerHTML );
					$('#btnApply').hide();
					$('#txtPromoCode').hide();
					
					document.getElementById("hiddenparameter").value = '1';
					document.getElementById("hiddenPromoCode").value = kode;
					
					$('#buttonStripe').data("description","Total Quote : $"+finalQuote);
				}
				else
				{
					alert(promoResult.msg);
				}
			},
			error: function(){
				
				alert("AJAX ERROR");
				
			}
	 });
	 
	 
});
	
</script>
</html>