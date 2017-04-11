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
		echo "<div class='header-text'>Which Service Do You Want?</div>";
		echo form_open('gbusnow_controller/selectService',$attributes,'class="form-horizontal"');
	?>
	
		<!--<div class="service-box" name="btnsnow" id="snow" data-val="1"></div>
		<div class="service-box" name="btngrass" id="grass" data-val="2" ></div>
		<div class="service-box" name="btnleave" id="leave" data-val="3" ></div>
		-->
		<div class="form-group" style="margin-top: -10px;">
			<div class="col-sm-5">
				<label class="radio-block">
					<input type="radio" name="service-box" id="service-box" value="1"> Snow
				</label>
				<label class="radio-block">
					<input type="radio" name="service-box" id="service-box" value="2"> Grass
				</label>
				<label class="radio-block">
					<input type="radio" name="service-box" id="service-box" value="3"> Leave
				</label>
			</div>
		</div>
	<?php
		echo "<div class='form-group' style='margin-top: -10px;'>";
		echo "<input type='button' class='btn btn-small btn-primary' id='btnPrevious' name='btnprevious' value='Previous'>";
		echo form_submit('btnnext','Next', 'class="btn btn-small btn-primary" id="btnnext"') ;
		echo form_close();
		echo "</div>";
	
	?>	
	</div>
</div>
</body>
<script>
$(function(){
	$('#btnPrevious').on('click',function(){
		window.location.href = "<?php echo site_url('gbusnow_controller/userDashboard'); ?>";
	});
	//$(".service-box").click(function(){
		
		
		//alert(document.formSelectService.media.value);
		/*$(document).ready(function () { 
			$('input[name="pilihan"]').val($(this).data('val'));
		});*/
		
	//});
	/*$('#snow').click(function () {
		var text = $(this).data('val');
		document.formSelectService.media.value = text;
		alert(text);
		$('#formSelectService').submit();
	});*/
});
</script>
</html>