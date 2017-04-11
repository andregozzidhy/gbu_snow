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
		
		
	.service-box{
		width: 120px;
		height:120px;
		background-size: 100%;
		background-color: black;
		cursor: pointer;
		overflow-y: hidden;
		float: left;
		margin-left: 30px;
	}
	</style>
</head>
<body>
	<div id="container">
	<?php
		echo "<div class='header-text'>Driveway Info</div>";
		$attributes = array('id' => 'formDriveWay');
		echo form_open('gbusnow_controller/driveWayInfo',$attributes,'class="form-horizontal" id="formDriveWay"');
	?>
		<div id="driveWay1" class="driveWay col-sm-2 form-group">
			<?php
			$driveWay =$this->gbusnow_model->getDriveWayWidth();
			
			echo " Driveway Width <select name='driveWayWidth' id='driveWayWidth' class='form-control'>";
			for($i=0;$i<count($driveWay );$i++)
			{
				echo "<option value='". $driveWay[$i]->dwidth_name . "'>" . $driveWay [$i]->dwidth_name . "</option>";
			}
			echo "</select><br/>";
			?>
		
		</div>
		
		<div id="driveWay2" class="driveWay col-sm-2 ">
			<?php
			$driveWay =$this->gbusnow_model->getDriveWayLength();
			
			echo " Driveway Length <select name='driveWayLength' id='driveWayLength' class='form-control'>";
			for($i=0;$i<count($driveWay );$i++)
			{
				echo "<option value='". $driveWay[$i]->dlength_name . "'>" . $driveWay [$i]->dlength_name . "</option>";
			}
			echo "</select><br/>";
			?>
		
		</div>
		
		<div id="driveWay3" class="driveWay col-sm-2 form-group">
			<?php
			$driveWay =$this->gbusnow_model->getDriveWayShape();
			
			echo " Driveway Shape<select name='driveWayShape' id='driveWayShape' class='form-control'>";
			for($i=0;$i<count($driveWay );$i++)
			{
				echo "<option value='". $driveWay[$i]->dshape_name . "'>" . $driveWay [$i]->dshape_name . "</option>";
			}
			echo "</select><br/>";
			?>
		
		</div>
		
		<div id="driveWay4" class="driveWay col-sm-2">
			<?php
			$driveWay =$this->gbusnow_model->getDriveWayType();
			
			echo " Driveway Type <select name='driveWayType' id='driveWayType' class='form-control'>";
			for($i=0;$i<count($driveWay );$i++)
			{
				echo "<option value='". $driveWay[$i]->dtype_name . "'>" . $driveWay [$i]->dtype_name . "</option>";
			}
			echo "</select><br/>";
			?>
		
		</div>
		<div class="form-group" style="margin-top: -10px;">
			<div>
			Are you expecting over a foot of snow at the time of service?
			</div>
			<div class="col-sm-5">
				<label class="radio-inline">
					<input type="radio" name="footOver" id="footOver" value="1"> Yes
				</label>
				<label class="radio-inline">
					<input type="radio" name="footOver" id="footOver" value="0"> No
				</label>
			</div>
		</div>
	<?php
		echo "<div class='form-group'>";
		echo form_submit('btnSubmit','Submit', 'class="btn btn-small btn-primary" id="btnSubmit"') ;
		echo form_close();
		echo "</div>";
		
		/*echo $this->session->userdata('selectServices');
		echo "<br>" . $this->session->userdata('selectTypeRumah');
		echo "<br> Latitude : ". $this->session->userdata('latitude');
		echo "<br> Longitude : ". $this->session->userdata('longitude');
		echo "<br> Address : ". $this->session->userdata('address');
		echo "<br> Detail : ". $this->session->userdata('detail');
		echo "<br> House Color : ". $this->session->userdata('houseColor');
		echo "<br> Mail Box Color : ". $this->session->userdata('mailBoxColor');
		*/
	?>	
	</div>
</div>
</body>
<script>



</script>
</html>