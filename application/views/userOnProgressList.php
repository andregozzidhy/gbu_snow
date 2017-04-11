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
	
		echo "<a href='".site_url('gbusnow_controller/userDashboard')."'>USER DASHBOARD</a><br>";
		
		$dataService = $this->gbusnow_model->getOnProgressList($user_email);
		echo "<div class='header-text'>On Progress</div>";
		echo "<div id='allData'>";
		
		if(count($dataService) >0)
		{
			for($i=0;$i<count($dataService);$i++)
			{
				
				echo "<div class=dataService id='dc-".$dataService[$i]->service_quote_id ."'>";
					echo "<div class=dataServiceLeft id='dcl-".$dataService[$i]->service_quote_id ."'>";
						echo "<label>SERVICE : </label>".$dataService[$i]->service_name . "<br>";
						
						$provider_name = $this->gbusnow_model->getProviderName($dataService[$i]->provider_id);
						echo "<label>SERVICED BY : </label>".$provider_name. "<br>";
						echo "<label>ON : </label>".date("D,d M Y", strtotime($dataService[$i]->service_date_final))." - ".date('h:i A', strtotime($dataService[$i]->service_time_final));
					echo "</div>";				
				echo "</div>";
				
			}
			
		}
		else
		{
			echo "<div class='header-text'>No On Progress List</div>";
		}
		
		echo "</div>";
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
				
				//window.location.href = "<?php echo site_url('gbusnow_controller/providerDashboard'); ?>";
				alert("DONE");
			},
			error: function(){
				alert("AJAX ERROR");
			}
		});
		
	});
});
	/*
$(document).ready(function(){
	

    setInterval(function(){
		var dataCount = document.getElementById("hiddenDataCount").value;
	
		//alert(dataCount);
        $.ajax({
            url: "<?php echo site_url('gbusnow_controller/anyDataChange'); ?>",
            type: "POST",
			dataType: "json",
			data: {param: dataCount},
            success: function(dataService) {
			

            }
        });
    }, 5000);
	
	
});*/

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