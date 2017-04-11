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
		
		.dataCustomer{
			margin : 5px;
			padding: 10px;
			border: 2px solid #ABC6ED;
			width: 385px;
			float: left;
		}
		
		.dataCustomerLeft{
			padding: 25px;
			border: 2px solid #ABC6ED;
			width: 360px;
		}
		.dataCustomerRight{
			padding: 25px;
			border: 2px solid #ABC6ED;
			width: 360px;
		}
		.pagePosition{
			clear: both;
		}
		
		.mapLocation{
			border: 2px solid #ABC6ED;
			width: 360px;
		}
	</style>
	<?php
		
		if($paramMap1==1)
		{
			echo $map_one['js'];
		}
		if($paramMap2==1)
		{
			echo $map_two['js']; 
		}
		if($paramMap3==1)
		{
			echo $map_three['js'];
		}
	 
	?>
</head>
<body>
	<div id="container">
	<?php
		echo "<div class='header-text'>Provider Dashboard</div>";
		echo "<a href='".site_url('gbusnow_controller/providerOnProgressList')."'>ON PROGRESS LIST</a><br>";
		echo "<a href='".site_url('gbusnow_controller/providerFinishedService')."'>FINISHED SERVICED</a><br>";
		echo "<a href='".site_url('gbusnow_controller/logout')."'>LOGOUT</a><br>";
		echo "Service Data <br>";
		echo "<div class='pagePosition' id='pagePosition'>";
			echo "<label> PAGE : <br> </label>";
			for($i=0;$i<$mapCount/3;$i++)
			{
				$currentPageClass = "";
				if ($i == $currentPage)
				{
					$currentPageClass = "page-current";
				}
				echo anchor(site_url('gbusnow_controller/providerDashboard').'/'.$i, ($i+1)." ", "class='page " . $currentPageClass . "'");
			}
		echo "</div>";
		//echo $provider_state;
		//echo $provider_city;
		//$dataService = $this->gbusnow_model->getAllUnServicedCustomerInRegion($provider_state, $provider_city);
		//$provider_id = $this->gbusnow_model->getProviderIdbyEmail($login);
		echo "<div id='allData'>";
		for($i=$start;$i<$end;$i++)
		{
			echo "<div class=dataCustomer id='dc-".$dataService[$i]->service_quote_id ."'>";
				
				if($i==$start && $paramMap1==1)
				{
					echo "<div class='mapLocation' id='firstLocation'>";
						echo "<div class='locationMap'>";
							echo $map_one['html']; 
						echo "</div>";
					echo "</div>";
				}
				if($i==($start+1) && $paramMap2==1)
				{
					echo "<div class='mapLocation' id='secondLocation'>";
						echo "<div class='locationMap'>";
							echo $map_two['html']; 
						echo "</div>";
					echo "</div>";
				}
				if($i==($start+2) && $paramMap3==1)
				{
					echo "<div class='mapLocation' id='thirdLocation'>";
						echo "<div class='locationMap'>";
							echo $map_three['html']; 
						echo "</div>";
					echo "</div>";
				}
				
				echo "<div class=dataCustomerLeft id='dcl-".$dataService[$i]->service_quote_id ."'>";
					echo "SERVICE CODE : ".$dataService[$i]->service_quote_id . "<br>";
					echo "CUSTOMER NAME : ".$dataService[$i]->customer_name . "<br>";
					echo "SERVICE : ".$dataService[$i]->service_name . "<br>";
					echo "ADDRESS : ".$dataService[$i]->house_address . "<br>";
					echo "NOTES : ".$dataService[$i]->service_note . "<br>";
					echo "TOTAL QUOTE : $".$dataService[$i]->service_quote_finaltotal . "<br>";
				echo "</div>";
				echo "<div class=dataCustomerRight id='dcr-".$dataService[$i]->service_quote_id ."'>";
					
					$paramApply = ($this->gbusnow_model->getServiceThatAppliedByProvider($provider_id, $dataService[$i]->service_quote_id));
			
					if($paramApply>0)
					{
						echo "<div id='notif-".$dataService[$i]->service_quote_id."'>";			
							$date = $this->gbusnow_model->getTempDateAppliedService($provider_id, $dataService[$i]->service_quote_id);
							echo "SELECTED SERVICE DATE : <br>";
							echo $date . "<br>";
							echo "Waiting for Customer's Approval";
							echo "<button type='button' class='btnCancelApply btn btn-primary' id='btnc-".$dataService[$i]->service_quote_id."' data-target='.bs-example-modal-sm' data-val='".$dataService[$i]->service_quote_id."'>Cancel Apply</button>";
							
						echo "</div>";
					}
					else
					{	
						echo "<div id='dateoption-".$dataService[$i]->service_quote_id."'>";
							echo "SERVICE DATE OPTION : <br>";
							echo "<div class='radio'>";
							echo "<label class='radio'>";
								echo "<input type='radio' name='selectedDateTime-".$dataService[$i]->service_quote_id ."' id='selectedDateTime1-".$dataService[$i]->service_quote_id ."' value='".date("D,d M Y", strtotime($dataService[$i]->service_date1))." - ".date('h:i A', strtotime($dataService[$i]->service_time1))."'> ".date("D,d M Y", strtotime($dataService[$i]->service_date1))." - ".date('h:i A', strtotime($dataService[$i]->service_time1));
							echo "</label>";
							echo "</div>";
							
						echo "<input type='hidden' name='hiddenServiceDate' id='d1-".$dataService[$i]->service_quote_id."' value='".$dataService[$i]->service_date1 ."' />";
						echo "<input type='hidden' name='hiddenServiceTime' id='t1-".$dataService[$i]->service_quote_id."' value='".$dataService[$i]->service_time1 ."' />";
		
							
						if($dataService[$i]->service_date2 != null)
						{
							echo "<div class='radio'>";
							echo "<label class='radio'>";
								echo "<input type='radio' name='selectedDateTime-".$dataService[$i]->service_quote_id ."' id='selectedDateTime2-".$dataService[$i]->service_quote_id ."' value='".date("D,d M Y", strtotime($dataService[$i]->service_date2))." - ".date('h:i A', strtotime($dataService[$i]->service_time2))."'> ".date("D,d M Y", strtotime($dataService[$i]->service_date2))." - ".date('h:i A', strtotime($dataService[$i]->service_time2));
							echo "</label>";
							echo "</div>";
							echo "<input type='hidden' name='hiddenServiceDate' id='d2-".$dataService[$i]->service_quote_id."' value='".$dataService[$i]->service_date2 ."' />";
							echo "<input type='hidden' name='hiddenServiceTime' id='t2-".$dataService[$i]->service_quote_id."' value='".$dataService[$i]->service_time2 ."' />";
		
						}
						if($dataService[$i]->service_date3 != null)
						{
							echo "<div class='radio'>";
							echo "<label class='radio'>";
								echo "<input type='radio' name='selectedDateTime-".$dataService[$i]->service_quote_id ."' id='selectedDateTime3-".$dataService[$i]->service_quote_id ."' value='".date("D,d M Y", strtotime($dataService[$i]->service_date3))." - ".date('h:i A', strtotime($dataService[$i]->service_time3))."'> ".date("D,d M Y", strtotime($dataService[$i]->service_date3))." - ".date('h:i A', strtotime($dataService[$i]->service_time3));
							echo "</label>";
							echo "</div>";
							echo "<input type='hidden' name='hiddenServiceDate' id='d3-".$dataService[$i]->service_quote_id."' value='".$dataService[$i]->service_date3 ."' />";
							echo "<input type='hidden' name='hiddenServiceTime' id='t3-".$dataService[$i]->service_quote_id."' value='".$dataService[$i]->service_time3 ."' />";
		
						}
						
						echo "</div>";
						
						echo "<button type='button' class='btnApply btn btn-primary' id='btn-".$dataService[$i]->service_quote_id."' data-target='.bs-example-modal-sm' data-val='".$dataService[$i]->service_quote_id."'>Apply Service</button>";
					}
									
					echo "</div>";					
					
			
			echo "</div>";
			echo "<input type='hidden' name='hiddenAddress' id='add-".$dataService[$i]->service_quote_id."' value='".$dataService[$i]->house_address."' />";
			echo "<input type='hidden' name='hiddenService' id='s-".$dataService[$i]->service_quote_id."' value='".$dataService[$i]->service_name ."' />";
		
		}
		echo "</div>";
		echo "<input type='hidden' name='hiddenDataCount' id='hiddenDataCount' value='".count($dataService)."' />";
		echo "<input type='hidden' name='tempServiceQuoteId' id='tempServiceQuoteId' value='' />";
		echo "<input type='hidden' name='tempSelectedDate' id='tempSelectedDate' value='' />";
		echo "<input type='hidden' name='tempSelectedTime' id='tempSelectedTime' value='' />";
		
		echo "<input type='hidden' name='hiddenDataCountApply' id='hiddenDataCountApply' value='".$jumlahApply."' />";
		echo "<input type='hidden' name='hiddenProviderId' id='hiddenProviderId' value='".$provider_id."' />";
		
		?>	
	</div>
	
	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalConfirm">
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
				<label>Are You sure want to apply this service?</label>
			<div class='modal-footer form-group'>
				<input type='button' class='btn btn-small btn-primary' id='btnYes' name='btnYes' value='Yes' data-dismiss="modal">
				<input type='button' class='btn btn-small btn-primary' id='btnNo' name='btnNp' value='No' data-dismiss="modal">
			</div>
			</div>
		</form>
	  </div>
		</div>
	</div>
	
	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalCancel">
	  <div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
		<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Confirmation</h4>
      </div>
		<form id="cancelForm" class="form-horizontal modal-body" method="post" novalidate="" enctype="multipart/form-data">		
		  	<div class='col-sm-15'>
			<label>Are You sure want to Cancel the Apply?</label>
			<div class='modal-footer form-group'>
				<input type='button' class='btn btn-small btn-primary' id='btnYesToCancel' name='btnYestoCancel' value='Yes' data-dismiss="modal">
				<input type='button' class='btn btn-small btn-primary' id='btnNoToCancel' name='btnNoToCancel' value='No' data-dismiss="modal">
			</div>
			</div>
		</form>
	  </div>
		</div>
	</div>
</body>
<script>
$(function(){
	$(".btnApply").click(function()
	{
		var dateTime = "";
		var flag = false;
		
		if (document.getElementById("selectedDateTime1-"+$(this).data("val")).checked) 
		{
			dateTime = document.getElementById("selectedDateTime1-"+$(this).data("val")).value;
			document.getElementById("tempSelectedDate").value = document.getElementById("d1-"+$(this).data("val")).value;
			document.getElementById("tempSelectedTime").value = document.getElementById("t1-"+$(this).data("val")).value;
			flag = true;
		}
		else 
		{
			if( $("#selectedDateTime2-"+$(this).data("val")).length > 0)
			{
				if (document.getElementById("selectedDateTime2-"+$(this).data("val")).checked) 
				{
					dateTime = document.getElementById("selectedDateTime2-"+$(this).data("val")).value;
					document.getElementById("tempSelectedDate").value = document.getElementById("d2-"+$(this).data("val")).value;
					document.getElementById("tempSelectedTime").value = document.getElementById("t2-"+$(this).data("val")).value;
					flag = true;
				}
			}
			else if( $("#selectedDateTime3-"+$(this).data("val")).length > 0)
			{
				if (document.getElementById("selectedDateTime3-"+$(this).data("val")).checked) 
				{
					dateTime = document.getElementById("selectedDateTime3-"+$(this).data("val")).value;
					document.getElementById("tempSelectedDate").value = document.getElementById("d3-"+$(this).data("val")).value;
					document.getElementById("tempSelectedTime").value = document.getElementById("t3-"+$(this).data("val")).value;
					flag = true;
				}
			}
		}
		
		if(flag == true)
		{	
			//alert($(this).data("val"));
			$('#keterangan').empty();
			var innerhtml = "";
			
			innerhtml += "<label>Service Type : </label><br>"+document.getElementById("s-"+$(this).data("val")).value +"<br><br>";
			innerhtml += "<label>Address :</label><br>"+document.getElementById("add-"+$(this).data("val")).value +"<br><br>";
			//alert(innerhtml);
						
			innerhtml += "<label>Selected Service Date : </label><br>"+dateTime+"<br><br>";
			
			$('#keterangan').append(innerhtml);
			document.getElementById("tempServiceQuoteId").value = $(this).data("val");
			$('#modalConfirm').modal("show");
		}
		else
		{
			alert("ERROR: Please Select Service Date!");
		}
	});
	
	$("#btnYes").click(function()
	{
		var provider = getCookie("snow_provider_user");
		var emailSplit = provider.split("%40");
		emailSplit = emailSplit[0]+"@"+emailSplit[1];
		var service_quote_id= document.getElementById("tempServiceQuoteId").value;
		var service_date = $("input[name=selectedDateTime-"+service_quote_id+"]:checked").val();
		var date = document.getElementById("tempSelectedDate").value;
		var time = document.getElementById("tempSelectedTime").value;
		var innerhtml = "";
		$.ajax({
            url: "<?php echo site_url('gbusnow_controller/applyService');?>",
            type: "POST",
			dataType: "json",
			data: {provider_email: emailSplit,
					service_quote: service_quote_id,
					service_date: service_date,
					date: date,
					time: time
			},
            success: function(dataService) {
				
					window.location.href = "<?php echo site_url('gbusnow_controller/providerDashboard'); ?>";
			
			},
			error: function(){
				alert("AJAX ERROR");
			}
		});
	});
	
	$(".btnCancelApply").click(function()
	{
		document.getElementById("tempServiceQuoteId").value = $(this).data("val");
		$('#modalCancel').modal("show");
		
	});
	
	$("#btnYesToCancel").click(function()
	{
		
		var provider = getCookie("snow_provider_user");
		var emailSplit = provider.split("%40");
		emailSplit = emailSplit[0]+"@"+emailSplit[1];
		var service_quote_id= document.getElementById("tempServiceQuoteId").value;
		
		$.ajax({
            url: "<?php echo site_url('gbusnow_controller/cancelApply');?>",
            type: "POST",
			dataType: "json",
			data: {provider_email: emailSplit,
					service_quote: service_quote_id
			},
            success: function(dataService) {
				
				window.location.href = "<?php echo site_url('gbusnow_controller/providerDashboard'); ?>";
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
		var dataCountApply = document.getElementById("hiddenDataCountApply").value;
		var provider_id = document.getElementById("hiddenProviderId").value;
	
        $.ajax({
            url: "<?php echo site_url('gbusnow_controller/anyDataChange'); ?>",
            type: "POST",
			dataType: "json",
			data: {param: dataCount,
					param2: dataCountApply,
					param3: provider_id					
			},
            success: function(dataService) {
				
				
				if(dataService.param=="1")
				{
					window.location.href = "<?php echo site_url('gbusnow_controller/providerDashboard'); ?>";
			
				}
				else if(dataService.param=="2")
				{
					//alert("param 2");
				}

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