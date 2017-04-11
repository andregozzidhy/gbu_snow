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
		
		.locationMap{
			width: 100%;
		}
		
		.locationAddress{
			padding: 10px;
		}
		
		.buttonCreate{
			padding: 10px;
		}
		
		.mapLocation{
			margin : 5px;
			border: 2px solid #ABC6ED;
			width: 25%;
			float: left;
		}
		
		.pagePosition{
			clear: both;
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
		echo "<div class='header-text'>User Dashboard</div>";
		echo "ORDER <a href='".site_url('gbusnow_controller/selectService')."'>NOW!</a><br>";
		echo "<a href='".site_url('gbusnow_controller/userOnProgressList')."'>ON PROGRESS LIST</a><br>";
		echo "<a href='".site_url('gbusnow_controller/waitingProvider')."'>WAITING PROVIDER</a><br>";
		echo "<a href='".site_url('gbusnow_controller/logout')."'>LOGOUT</a>";
	?>	
	</div>
	<div id="yourLastOrder">
	<?php
	
	?>
	</div>
	<div id="yourProperty">
	<?php
		if($paramMap1==1)
		{
			echo "<div class='mapLocation' id='firstLocation'>";
				echo "<div class='locationMap'>";
					echo $map_one['html']; 
				echo "</div>";
				echo "<div class='locationAddress'>";
					echo "<label>" . $mapOneAddress ."</label>";
				echo "</div>";
				echo "<div class='buttonCreate'>";
					echo "<button type='button' class='btnCreate btn btn-primary' id='btn-".$house_id_one."' data-target='.bs-example-modal-sm' data-val='".$house_id_one."'>Create Order</button>";
				echo "</div>";
			echo "</div>";
			
		}
		if($paramMap2==1)
		{
			echo "<div class='mapLocation' id='secondLocation'>";
				echo "<div class='locationMap'>";
					echo $map_two['html']; 
				echo "</div>";
				echo "<div class='locationAddress'>";
					echo "<label>" .$mapTwoAddress. "</label>";
				echo "</div>";
				echo "<div class='buttonCreate'>";
					echo "<button type='button' class='btnCreate btn btn-primary' id='btn-".$house_id_two."' data-target='.bs-example-modal-sm' data-val='".$house_id_two."'>Create Order</button>";
				echo "</div>";
			echo "</div>";
		}	
		if($paramMap3==1)
		{
			echo "<div class='mapLocation' id='thirdLocation'>";
				echo "<div class='locationMap'>";
					echo $map_three['html'];
				echo "</div>";
				echo "<div class='locationAddress'>";
					echo "<label>" .$mapThreeAddress. "</label>";
				echo "</div>";
				echo "<div class='buttonCreate'>";
					echo "<button type='button' class='btnCreate btn btn-primary' id='btn-".$house_id_three."' data-target='.bs-example-modal-sm' data-val='".$house_id_three."'>Create Order</button>";
				echo "</div>";
			echo "</div>";
		}
		
		echo "<div class='pagePosition' id='pagePosition'>";
			echo "<label> PAGE : <br> </label>";
			for($i=0;$i<$mapCount/3;$i++)
			{
				$currentPageClass = "";
				if ($i == $currentPage)
				{
					$currentPageClass = "page-current";
				}
				echo anchor(site_url('gbusnow_controller/userDashboard').'/'.$i, ($i+1)." ", "class='page " . $currentPageClass . "'");
			}
		echo "</div>";
				
		echo "<input type='hidden' name='hiddenStart' id='hiddenStart' value=".$start." />";
		echo "<input type='hidden' name='hiddenEnd' id='hiddenEnd' value=".$end." />";
		echo "<input type='hidden' name='tempSelectedHouse' id='tempSelectedHouse' value='' />";
		echo "<a href='".site_url('gbusnow_controller/selectHomeType')."'>ADD PROPERTY</a>";
	?>
	</div>
</div>

	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalSelectService">
	  <div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
		<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Select Service</h4>
      </div>
		<form id="confirmForm" class="form-horizontal modal-body" method="post" novalidate="" enctype="multipart/form-data">		
		  	<div class='col-sm-15'>
				<div><label><input type='radio' value='1' name='selectedService' id='Snow'>Snow Service</label></div>
				<div><label><input type='radio' value='2' name='selectedService' id='Grass'>Grass Service</label></div>
				<div><label><input type='radio' value='3' name='selectedService' id='Leave'>Leave Service</label></div>
			<div class='modal-footer form-group'>
				<input type='button' class='btn btn-small btn-primary' id='btnOk' name='btnOk' value='OK' data-dismiss="modal">
				<input type='button' class='btn btn-small btn-primary' id='btnCancel' name='btnCancel' value='Cancel' data-dismiss="modal">
			</div>
			</div>
		</form>
	  </div>
		</div>
	</div>
</body>
<script>
$(function(){

	$(".btnCreate").click(function()
	{
		document.getElementById("tempSelectedHouse").value = $(this).data("val");
		$('#modalSelectService').modal("show");
	});
	
	$("#btnOk").click(function()
	{
		var house_id= document.getElementById("tempSelectedHouse").value;
		var selectService = $("input[name=selectedService]:checked").val();
		var innerhtml = "";
		
		//alert(house_id+" dan "+selectService );
		
		$.ajax({
            url: "<?php echo site_url('gbusnow_controller/setHouseIDandSelectedService');?>",
            type: "POST",
			dataType: "json",
			data: {house_id: house_id,
					selectService: selectService
			},
            success: function(dataService) {
				
				/*
				$("#btn-"+service_quote_id).hide();
				//$("#notif-"+service_quote_id).show();
				$("#dateoption-"+service_quote_id).hide();
				
				innerhtml += "<div id='notif-"+service_quote_id+"'>";			
				innerhtml += "SELECTED SERVICE DATE : <br>";
				innerhtml += service_date + "<br>";
				//innerhtml += "<button type='button' class='btnApply btn btn-primary' id='btn-"+service_quote_id+"' data-target='.bs-example-modal-sm' data-val='"+service_quote_id+"' style='display: none'>Apply Service</button>";
				innerhtml += "Waiting for Customer's Approval";
				
				innerhtml += "<button type='button' class='btnCancelApply btn btn-primary' id='btnc-"+service_quote_id+"' data-target='.bs-example-modal-sm' data-val='"+service_quote_id+"'>Cancel Apply</button>";;
				
				
				innerhtml += "</div>";
				$("#dcr-"+service_quote_id).append(innerhtml);
				*/
				
				if(dataService == "updateHouseDriveWay")
				{
					window.location.href = "<?php echo site_url('gbusnow_controller/driveWayInfo'); ?>";
				}
				else if(dataService == "updateLawn")
				{
					window.location.href = "<?php echo site_url('gbusnow_controller/lawnInfo'); ?>";
				}
				else if (dataService == "noUpdate")
				{
					window.location.href = "<?php echo site_url('gbusnow_controller/setDateTimeService'); ?>";
				}
			},
			error: function(){
				alert("AJAX ERROR");
			}
		});
	});
});	

	
	
</script>
</html>