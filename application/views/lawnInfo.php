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
		echo "<div class='header-text'>Lawn Info</div>";
		$attributes = array('id' => 'formlawnInfo');
		echo form_open('gbusnow_controller/lawnInfo',$attributes,'class="form-horizontal" id="formLawn"');
	?>
		<div id="lawnSizeDiv" class="col-sm-2 form-group">
			<?php
			$lawnSize =$this->gbusnow_model->getLawnSize();
			
			echo " Lawn Size <select name='lawnSize' id='lawnSize' class='form-control'>";
			for($i=0;$i<count($lawnSize );$i++)
			{
				echo "<option value='". $lawnSize[$i]->lawn_size . "'>" .$lawnSize[$i]->lawn_size . "</option>";
			}
			echo "</select><br/>";
			?>
		
		</div>
		
		<div id="lawnHillyDiv" class="lawnHilly col-sm-2 form-group">
			<?php
			$lawnHilly =$this->gbusnow_model->getLawnHilly();
			
			echo " Lawn Hilly <select name='lawnHilly' id='lawnHilly' class='form-control'>";
			for($i=0;$i<count($lawnHilly );$i++)
			{
				echo "<option value='". $lawnHilly[$i]->lawn_hilly_name . "'>" . $lawnHilly[$i]->lawn_hilly_name. "</option>";
			}
			echo "</select><br/>";
			?>
		</div>
		
		<div class="driveWay col-sm-2 form-group">
		Check All The Apply
		</div>
		
		<div id="divFence" class="fence col-sm-2 form-group">
			<label><input type='checkbox' value='' name='checkFence' id='checkBoxFence'> There is a fence</label>
		</div>
		
		<div id="gateSizeDiv" class="gateSize col-sm-2 form-group">
			<label>Gate Size</label>
			<?php
			$gateSize =$this->gbusnow_model->getGateSize();
			
			for($i=0;$i<count($gateSize);$i++)
			{
				echo "<div><label><input type='radio' value='".$gateSize[$i]->gate_size."' name='selectedGateSize' id='rd-".$gateSize[$i]->gate_size."' >".$gateSize[$i]->gate_size."</label></div>";
			}
			?>
		</div>
		
		<div id="divPool" class="pool col-sm-2 form-group">
			<label><input type='checkbox' value='' name='checkPool' id='checkBoxPool'> There is a pool</label>
		</div>
		
		<div id="divSprinklers" class="sprinklers col-sm-2 form-group">
			<label><input type='checkbox' value='' name='checkSprinklers' id='checkSpringklers'> There are Springklers</label>
		</div>
		
		<div id="divPet" class="pet col-sm-2 form-group">
			<label><input type='checkbox' value='' name='checkPet' id='checkPet'> There are pets in the yard </label>
		</div>
		
	<?php
		echo "<div class='form-group'>";
		echo form_submit('btnSubmit','Submit', 'class="btn btn-small btn-primary" id="btnSubmit"') ;
		echo form_close();
		echo "</div>";
		
		
	?>	
	</div>
</div>
</body>
<script>



</script>
</html>