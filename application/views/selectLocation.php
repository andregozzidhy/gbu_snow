<html lang="en">
<?php
	require_once("includes.php")
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>Snow Project</title>
	<link rel="stylesheet" type="text/css" media="screen and (max-device-width: 1200px)" href="<?php echo base_url('assets/css/default_css_portrait.css'); ?>">

	<script type="text/javascript">
		var centreGot = false;
	</script>
	<?php echo $map['js']; ?>
	
	<style>
		.locationMap{
			
			width: 48%;
			margin-top: 10px;
		}
		
		#map_canvas{
			height: 300px;
		}
		
			
		.form-group{
			height: 30px;
			margin-top: 10px;
			margin-bottom: 10px;
			clear: both;
		}
	</style>
</head>
<body>
	<div id="container">
		<?php
		$attributes = array('id' => 'formSignUp');
		echo form_open('gbusnow_controller/selectLocation',$attributes,'class="form-horizontal"');
				echo "<div class='form-group'>";
					echo "<div class='col-sm-3'>";
					echo form_input('txtlocation', '', 'class="form-control" id="myPlaceTextBox" placeholder="Location"');
					echo "</div>";
				echo "</div>";
				echo "<div class='form-group'>";
					echo "<div class='col-sm-3'>";
					echo form_input('txtDetail', '', 'class="form-control" id="txtDetail" placeholder="Add Address Detail"');
					echo "</div>";
				echo "</div>";
				echo "<div class='help-block with-errors'></div>";
		?>
		
	
		<div id="locationMap" class="locationMap">
		<?php
			echo $map['html'];
		?>		
		</div>
	

		<?php
			$colorList =$this->gbusnow_model->getAllColor();
		?>
		<div class="colorPicker">
			<div id="houseColor" class="houseColor col-sm-3">
				<?php
				echo " House Color <select name='selectedHouseColor' id='selectedHouseColor' placeholder='House Color' class='form-control'>";
				for($i=0;$i<count($colorList);$i++)
				{
					echo "<option value='". $colorList[$i]->color_id . "'>" . $colorList[$i]->color_name . "</option>";
				}
				echo "</select><br/>";
				?>
			</div>
			
			<div id="houseColor" class="houseColor col-sm-3">
				<?php
				echo " Mailbox Color <select name='selectedMailBoxColor' id='selectedMailBoxColor' placeholder='MailBox Color' class='form-control'>";
				for($i=0;$i<count($colorList);$i++)
				{
					echo "<option value='". $colorList[$i]->color_id . "'>" . $colorList[$i]->color_name . "</option>";
				}
				echo "</select><br/>";
				?>
			
			</div>
		</div>
		
		<?php
		echo "<div class='form-group'>";
		  echo "<label><input type='checkbox' value='' name='cbAgree' id='cbAgree'> I Agree to the Terms and Conditions</label>";
		echo "</div>";
		echo "<div class='form-group'>";
			echo "<div class='col-sm-3'>";
				echo "<input type='button' class='btn btn-small btn-primary' id='btnPrevious' name='btnprevious' value='Previous'>";
				echo "<input type='hidden' name='hiddenCity' id='hiddenCity' value='' />";
				echo "<input type='hidden' name='hiddenState' id='hiddenState' value='' />";
				echo form_submit('btnNext','Next', 'class="btn btn-small btn-primary" id="btnNext"') ;
				echo form_close();
			echo "</div>";
		echo "</div>";
		
		?>
	</div>
</div>
</body>
<script>
$(function(){
	$('#btnPrevious').on('click',function(){
		window.location.href = "<?php echo site_url('gbusnow_controller/selectHomeType'); ?>";
	});
	
	$("#btnNext").attr("disabled", "disabled");
});

$(document).ready(function(){
		
		$("#cbAgree").change(function(){
			if(document.getElementById("cbAgree").checked ==true)
			{
				$("#btnNext").removeAttr("disabled");
				//alert("checked");
			}
			else
			{
				$("#btnNext").attr("disabled", "disabled");
				//alert("unchecked");
			}
		});
		
	});

	
</script>
</html>