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
		$attributes = array('id' => 'formSelectService');
		echo "<div class='header-text'>Get My Price</div>";
		echo form_open('gbusnow_controller/selectHomeType',$attributes,'class="form-horizontal"');

		echo "<table style='width: auto;' class='table table-hover table-striped table-responsive' id='tablehome'>";
		$typeRumah=$this->gbusnow_model->getAllTypeRumah();
		if(isset($typeRumah) && $typeRumah !="")
		{
			for($i=0;$i<count($typeRumah);$i++)
			{
				echo "<tr>";
				
				echo "<td >".$typeRumah[$i]->housetype_name."</td>";
				echo "<td> $".$typeRumah[$i]->housetype_price."</td>";
				echo "<td><input type='radio' name='houseTypeOption' id='houseTypeOption' value='".$typeRumah[$i]->housetype_id."'></td>";
				echo "</tr>";
			}
		}
		echo "</table>";
		echo "<input type='button' class='btn btn-small btn-primary' id='btnPrevious' name='btnprevious' value='Previous'>";
		echo form_submit('btnnext','Next', 'class="btn btn-small btn-primary" id="btnnext"');
		echo form_close();
		//echo $this->session->userdata('selectServices');
		//echo $this->session->userdata('selectTypeRumah');
		
	?>
	</div>
</div>
</body>
<script>
$(function(){
	$('#btnPrevious').on('click',function(){
		window.location.href = "<?php echo site_url('gbusnow_controller/selectService'); ?>";
	});
});
</script>
</html>