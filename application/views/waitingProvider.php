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
				
		.bodyBar{
			height: 30px;
			width: 300px;
			border: 2px solid #ABC6ED;
			margin: 15px;
		
		}
		
		#fastnessProgress{
			height: 26px;
			background: lightblue;
		}
		
		#cleanessProgress{
			height: 26px;
			background: lightblue;
		}
		
		#onTimeFrequency{
			height: 26px;
			background: lightblue;
		}
		
	</style>
</head>
<body>
<div id="container">
	<?php
		echo "<div class='header-text'>User Dashboard</div>";
		echo "ORDER <a href='".site_url('gbusnow_controller/selectService')."'>NOW!</a><br>";
		echo "<a href='".site_url('gbusnow_controller/userOnProgressList')."'>ON PROGRESS LIST</a><br>";
		echo "<a href='".site_url('gbusnow_controller/waitingProvider')."'>WAITING PROVIDER</a><br>";
		echo "<a href='".site_url('gbusnow_controller/logout')."'>LOGOUT</a>";
		
		$dataProvider = $this->gbusnow_model->getAppliedProvider($user_email);
		//echo count($dataProvider);
		if(count($dataProvider) >0)
		{
			$service_name = $this->gbusnow_model->getServiceNameInServiceCode($dataProvider[0]->service_quote_id);
			echo "<div class='form-group'>";
				echo "Service : ".$service_name ."<br>";
			echo "</div>";
			
			echo "<label>".$dataProvider[0]->provider_company_name."</label>";
			echo "<div id='fastness'>Fastness</div>";
			echo "<div class='bodyBar'>";
				echo "<div id='fastnessProgress'></div>";
			echo "</div>";
			echo "<div id='fastness'>Cleaness</div>";
			echo "<div class='bodyBar'>";
				echo "<div id='cleanessProgress'></div>";
			echo "</div>";
			echo "<div id='fastness'>On Time Frequency</div>";
			echo "<div class='bodyBar'>";
				echo "<div id='onTimeFrequency'></div>";
			echo "</div>";
		
			echo "<script>
				$('#fastnessProgress').css('width', '".($dataProvider[0]->provider_fastness*30)."px');
				$('#cleanessProgress').css('width', '".($dataProvider[0]->provider_cleaness*30)."px');
				$('#onTimeFrequency').css('width', '".($dataProvider[0]->provider_ontime*30)."px');
				</script>";
			
			echo "<div class='form-group'>";
				echo "Project Done : ".$dataProvider[0]->provider_record;
			echo "</div>";
			
			echo "<div class='form-group'>";
				echo "Apply on : ".$dataProvider[0]->service_datetime;
			echo "</div>";
			
			echo "<input type='button' class='btn btn-small btn-primary' id='btnAccept' name='btnAccept' value='Accept'>";
			echo "<input type='button' class='btn btn-small btn-primary' id='btnDecline' name='btnDecline' value='Decline'>";
			
			echo "<input type='hidden' name='hiddenProvider' id='hiddenProvider' value='".$dataProvider[0]->provider_id."' />";
			echo "<input type='hidden' name='hiddenServiceDate' id='hiddenServiceDate' value='".$dataProvider[0]->date."' />";
			echo "<input type='hidden' name='hiddenServiceTime' id='hiddenServiceTime' value='".$dataProvider[0]->time."' />";
			echo "<input type='hidden' name='hiddenServiceQuoteId' id='hiddenServiceQuoteId' value='".$dataProvider[0]->service_quote_id."' />";
			
		}
		else
		{
			echo "<div class='header-text'>Waiting Provider</div>";
		}
		echo "<input type='hidden' name='hiddenDataCount' id='hiddenDataCount' value='".count($dataProvider)."' />";
	?>
</div>

	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalConfirmAccept">
	  <div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
		<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Confirmation</h4>
      </div>
		<form id="confirmForm" class="form-horizontal modal-body" method="post" novalidate="" enctype="multipart/form-data">		
		  	<div class='col-sm-15'>
				<div id='keterangan'>
				</div>
				<label>Are You sure want to Accept?</label>
			<div class='modal-footer form-group'>
				<input type='button' class='btn btn-small btn-primary' id='btnYesAccept' name='btnYesAccept' value='Yes' data-dismiss="modal">
				<input type='button' class='btn btn-small btn-primary' id='btnNo' name='btnNp' value='No' data-dismiss="modal">
			</div>
			</div>
		</form>
	  </div>
		</div>
	</div>
	
	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalConfirmDecline">
	  <div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
		<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Confirmation</h4>
      </div>
		<form id="confirmForm" class="form-horizontal modal-body" method="post" novalidate="" enctype="multipart/form-data">		
		  	<div class='col-sm-15'>
				<div id='keterangan'>
				</div>
				<label>Are You sure want to Decline?</label>
			<div class='modal-footer form-group'>
				<input type='button' class='btn btn-small btn-primary' id='btnYesDecline' name='btnYesDecline' value='Yes' data-dismiss="modal">
				<input type='button' class='btn btn-small btn-primary' id='btnNo' name='btnNp' value='No' data-dismiss="modal">
			</div>
			</div>
		</form>
	  </div>
		</div>
	</div>
	
	
</body>
<script>
$(function(){
	$("#btnAccept").click(function()
	{
		$('#modalConfirmAccept').modal("show");
	});
	
	$("#btnDecline").click(function()
	{
		$('#modalConfirmDecline').modal("show");
	});
	
	$("#btnYesAccept").click(function()
	{
		var service_quote_id= document.getElementById("hiddenServiceQuoteId").value;
		var service_date= document.getElementById("hiddenServiceDate").value;
		var service_time= document.getElementById("hiddenServiceTime").value;
		var provider_id= document.getElementById("hiddenProvider").value;

		$.ajax({
            url: "<?php echo site_url('gbusnow_controller/approveProviderApplication');?>",
            type: "POST",
			dataType: "json",
			data: {service_quote_id: service_quote_id,
					service_date: service_date,
					service_time: service_time,
					provider_id: provider_id
			},
            success: function(dataService) {
				
				alert("DONE");
				window.location.href = "<?php echo site_url('gbusnow_controller/userOnProgressList'); ?>";
				
			},
			error: function(){
				alert("AJAX ERROR");
			}
		});
		
	});
	
	$("#btnYesDecline").click(function()
	{
		var service_quote_id= document.getElementById("hiddenServiceQuoteId").value;
		var provider_id= document.getElementById("hiddenProvider").value;

		$.ajax({
            url: "<?php echo site_url('gbusnow_controller/declineProviderApplication');?>",
            type: "POST",
			dataType: "json",
			data: {service_quote_id: service_quote_id,
					provider_id: provider_id
			},
            success: function(dataService) {
				
				window.location.href = "<?php echo site_url('gbusnow_controller/waitingProvider'); ?>";
				//alert("DONE");
			},
			error: function(){
				alert("AJAX ERROR");
			}
		});
		
	});
});

$(document).ready(function(){

    setInterval(function(){
		var dataCount = document.getElementById("hiddenDataCount").value;
		
        $.ajax({
            url: "<?php echo site_url('gbusnow_controller/anyDataChangeOnWaitingProvider'); ?>",
            type: "POST",
			dataType: "json",
			data: {dataCount: dataCount},
            success: function(dataService) {
					
				if(dataService=="reload")
				{
					window.location.href = "<?php echo site_url('gbusnow_controller/waitingProvider'); ?>";
				}

            },
			error : function(){
				alert("AJAX ERROR");
			}
        });
		
    }, 5000);
	
	
});

function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) 
	{
		return parts.pop().split(";").shift();
	}
}

	
</script>
</html>