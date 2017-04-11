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
		
		.dataProvider{
			margin : 5px;
			padding: 10px;
			border: 2px solid #ABC6ED;
			width: 385px;
			float: left;
		}
		
		.dataProviderLeft{
			padding: 25px;
			border: 2px solid #ABC6ED;
			width: 360px;
		}
		.dataProviderRight{
			padding: 25px;
			border: 2px solid #ABC6ED;
			width: 360px;
		}
	</style>
</head>
<body>
	<div id="container">
	<?php
		echo "<div>";
		echo "ADMIN PANEL <br>"; 
		echo "UNCONFIRM PROVIDER";
		echo "</div>";
		
		$dataProvider = $this->gbusnow_model->selectAllUnconfirmProvider();

		for($i=0;$i<count($dataProvider);$i++)
		{
			echo "<div class=dataProvider>";
				echo "<div class=dataProviderLeft>";
					echo "PROVIDER ID : ".$dataProvider[$i]->provider_id . "<br>";
					echo "PROVIDER USER NAME : ".$dataProvider[$i]->provider_first_name." ".$dataProvider[$i]->provider_last_name ."<br>";
					echo "COMPANY NAME : ".$dataProvider[$i]->provider_company_name ."<br>";
					echo "COMPANY TITLE : ".$dataProvider[$i]->provider_company_title ."<br>";
					
					echo "COMPANY TYPE : ".$dataProvider[$i]->typeName ."<br>";
					
					echo "ADDRESS : ".$dataProvider[$i]->provider_company_address ."<br>";
					echo "LOCATION : ".$dataProvider[$i]->provider_state.", ".$dataProvider[$i]->provider_city.", ".$dataProvider[$i]->provider_zip_code ."<br>";
					echo "PRIMARY CONTACT : ".$dataProvider[$i]->provider_prime_contact ."<br>";
					echo "EMAIL : ".$dataProvider[$i]->provider_email ."<br>";
				echo "</div>";
				echo "<div class=dataProviderRight>";
					$mowsplows = "";
					if($dataProvider[$i]->provider_mows=="1")
					{
						$mowsplows = "Mows ";
					}
					if($dataProvider[$i]->provider_plows=="1")
					{
						if($mowsplows != "")
						{
							$mowsplows .= "and Plows";
						}
						else
						{
							$mowsplows .= "Plows";
						}
					}
					echo "SERVICE(S) : ".$mowsplows."<br>";
					echo "SERVICE POINT : ".$dataProvider[$i]->provider_service_address."<br>";
					echo "POINT LOCATION : ".$dataProvider[$i]->provider_service_state.", ".$dataProvider[$i]->provider_service_city.", ".$dataProvider[$i]->provider_zip_code2 ."<br>";
					echo "PHONE NUMBER : ".$dataProvider[$i]->provider_phone_number ."<br>";
					echo "SERVICE RADIUS : ".$dataProvider[$i]->provider_service_radius ." Miles <br>";
					echo "USER CREW(S) : ".$dataProvider[$i]->provider_crew_count."<br>";
					echo "<input type='hidden' name='hiddenCompanyName' id='cn-".$dataProvider[$i]->provider_id."' value='".$dataProvider[$i]->provider_company_name ."' />";
					echo "<input type='hidden' name='hiddenEmail' id='e-".$dataProvider[$i]->provider_id."' value='".$dataProvider[$i]->provider_email ."' />";
					echo "<input type='hidden' name='hiddenProviderId' id='id-".$dataProvider[$i]->provider_id."' value='".$dataProvider[$i]->provider_id."' />";
					echo "<button type='button' class='btnConfirm btn btn-primary' data-toggle='modal' data-target='.bs-example-modal-sm' data-val='".$dataProvider[$i]->provider_id."'>Confirm Provider</button>";
				echo "</div>";
			echo "</div>";
			
		}
	
	?>
		
			
	</div>
	<?php
		echo "<input type='hidden' name='tempProviderId' id='tempProviderId' value='' />";
		echo "<input type='hidden' name='tempProviderEmail' id='tempProviderEmail' value='' />";
					
	?>
	<!----------->
	

	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
	  <div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
		<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Activation</h4>
      </div>
		<form id="confirmForm" class="form-horizontal modal-body" method="post" novalidate="" enctype="multipart/form-data">		
		  	<div class='col-sm-15'>
				Company Name <br>
				<?php echo form_input('txtProviderUserName', '', 'class="form-control" id="providerCompanyName"');?>
			</div>
			<div class='modal-footer form-group'>
				<input type='button' class='btn btn-small btn-primary' id='btnActivate' name='btnActivate' value='Activate Provider'>
			</div>
		</form>
		</div>
	  </div>
	</div>
	
	<!----------->
</div>
</body>
<script>
$(function(){
	var provider_id="";
	$("#providerCompanyName").attr("disabled", "disabled");

	$(".btnConfirm").click(function()
	{
		//alert($(this).data("val"));
		document.getElementById("providerCompanyName").value = document.getElementById("cn-"+$(this).data("val")).value;
		document.getElementById("tempProviderId").value = document.getElementById("id-"+$(this).data("val")).value;
		document.getElementById("tempProviderEmail").value = document.getElementById("e-"+$(this).data("val")).value;
		
	});

	$("#btnActivate").click(function()
	{		
		var provider = document.getElementById("tempProviderId").value;
		var email = document.getElementById("tempProviderEmail").value;
		var pass = randomPass();
		alert(provider+" "+email+" "+pass);
		
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "<?php echo site_url('gbusnow_controller/activateProvider');?>",
			data: {provider_password: pass,
					provider_email: email,
					provider_id: provider
			},
			success: function(obj){ 
					alert("masuk 2");
					window.location.href = "<?php echo site_url('gbusnow_controller/adminPanel'); ?>";
					
				},
				
			error: function(obj){
					alert("masuk error");
			}
			
			});
	});
});

function randomPass()
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 5; i++ )
	{
		text += possible.charAt(Math.floor(Math.random() * possible.length));
	}
	
    return text;
}
</script>
</html>