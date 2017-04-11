<html lang="en">
<?php
	require_once("includes.php")
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>Snow Project</title>
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
	
	label {
		font-weight: normal !important;
	}
	
	.kotakHasil {
		margin: 0px auto;
		padding :0px;
		background-color: #fff;
		border : 1px solid #666;
		width : 150px;
	}

	.daftarPencarian {
		margin: 0px;
		padding: 0px;
	}

	.daftarPencarian ul {
		margin:0px;
		padding: 0px;
	}

	.daftarPencarian li {
		margin:0px;
		padding: 5px;
		cursor: pointer;
		list-style : none;
	}

	.daftarPencarian li:hover {
		background-color: #659CD8;
	}
	
	a{
		text-decoration:none;
		color:#000;
	}
	a:hover{
		text-decoration:underline;
		color:#000;
	}
	</style>
	<link href="<?php echo base_url('assets/js/jquery.autocomplete.css')?>" rel="stylesheet">
    <script src="<?php echo base_url('assets/js/jquery.autocomplete.js')?>"></script>
	<script src="<?=base_url()?>assets/jquery/jquery-ui.js" type="text/javascript"></script>
	
	<link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/jquery/jquery-ui.css" rel="stylesheet">
 
</head>
<body>
	<div class="header-text">Provider Sign up</div>
		
	<div id="container">
	<?php
		$attributes = array('id' => 'formSignUpProvider');
		echo form_open('gbusnow_controller/providerSignUp',$attributes,'class="form-horizontal" id="formSignUpProvider"');
	?>
		<div id="firstForm">
	<?php

		echo "<div class='form-group'>";
			echo "<div class='col-sm-3'>";
				echo "Name*  ";
				echo form_input('txtFirstName', '', 'class="form-control" placeholder="First Name"');
				echo form_input('txtLastName', '', 'class="form-control" placeholder="Last Name"');
			echo "</div>";
			echo "<div class='help-block with-errors'></div>";
		echo "</div>";
		
		echo "<div class='form-group'>";
			echo "<div class='col-sm-3'>";
				echo "Company Name* ";
				echo form_input('txtCompanyName', '', 'class="form-control" placeholder="Company Name"');
			echo "</div>";
			echo "<div class='help-block with-errors'></div>";
		echo "</div>";
		
			echo "<div class='form-group'>";
			echo "<div class='col-sm-3'>";
				echo "Company Title* ";
				echo form_input('txtCompanyTitle', '', 'class="form-control" placeholder="Company Title"');
			echo "</div>";
			echo "<div class='help-block with-errors'></div>";
		echo "</div>";
		
		$companyType =$this->gbusnow_model->getCompanyType();
		echo "<div id='company' class='company col-sm-2 form-group'>";
			echo " Company Type* <select name='companyType' id='companyType' class='form-control'>";
			for($i=0;$i<count($companyType);$i++)
			{
				echo "<option value='". $companyType[$i]->companytype_id . "'>" . $companyType[$i]->companytype_name . "</option>";
			}
			echo "</select>";
		echo "</div>";
		
		echo "<div class='form-group'>";
			echo "<div class='col-sm-3'>";
				echo "Company Address";
				echo form_input('txtCompanyAddress', '', 'class="form-control" placeholder="Company Address"');
			echo "</div>";
			echo "<div class='help-block with-errors'></div>";
		echo "</div>";
			
		?>					
		<div class='form-group'>
			<div class='col-sm-2'>
					State <input class="form-control "type="text" id="namaState" onkeyup="cariState(this.value);" onblur="pilih1();"
					value="" name="namaState" onfocus="if(this.value=='State') this.value='';" placeholder="State" />
					<div class="kotakHasil" id="hasilPencarian" style="display: none; position: absolute; z-index: 99;">
					<div class="daftarPencarian" id="dataPencarian">
					</div>
				</div>
			</div>
			<div class='col-sm-2'>
					City <input class="form-control "type="text" id="namaCity" name="namaCity" onkeyup="cariCity(this.value);" onblur="pilih2();"
					value="" onfocus="if(this.value=='City') this.value='';" placeholder="City" />
					<div class="kotakHasil" id="hasilPencarian2" style="display: none; position: absolute; z-index: 99;">
					<div class="daftarPencarian" id="dataPencarian2">
					</div>
				</div>
			</div>
			<div class='col-sm-2'>
					ZIP Code <input class="form-control "type="text" id="zipCode" name="zipCode" placeholder="ZIP Code" />
			</div>
		</div>
		
	<?php
		echo "<div class='form-group'>";
			echo "<div class='col-sm-3'>";
				echo "Primary Contact Number* ";
				echo form_input('txtphonenumber', '', 'class="form-control" placeholder="Phone Number"');
			echo "</div>";
			echo "<div class='help-block with-errors'></div>";
		echo "</div>";

		echo "<div class='form-group'>";
			echo "<div class='col-sm-3'>";
				echo "Email* ";
				echo form_input('txtEmail', '', 'class="form-control" placeholder="Email"');
			echo "</div>";
			echo "<div class='help-block with-errors'></div>";
		echo "</div>";
		
		echo "<div class='form-group'>";
			echo "<input type='button' class='btn btn-small btn-primary' id='btnNext' name='btnNext' value='Next'>";
		echo "</div>";
		echo validation_errors();	
		?>	
		</div>
		<div id="secondForm" style="display:none;">
		
		<div class='form-group'>
			<div class='col-sm-3'>
				I want to be a:* <br>
				<label><input type='checkbox' value='' name='cbMowzProvider' id='cbMowzProvider'> Mows Provider </label><br>
				<label><input type='checkbox' value='' name='cbPlowzProvider' id='cbPlowzProvider'> Plows Provider </label>
			</div>
		</div>
		
		<div class='form-group'>
			<div class='col-sm-4'>
				The central address of where you want to receive Plowz/Mowz jobs: <br>
				<?php echo form_input('txtServiceAddress', '', 'class="form-control" placeholder="Address"'); ?>	
			</div>
			<div class='help-block with-errors'></div>
		</div>
		
						
		<div class='form-group'>
			<div class='col-sm-2'>
					State <input class="form-control "type="text" id="namaState2" onkeyup="cariState2(this.value);" onblur="pilih3();"
					value="" name="namaState2" onfocus="if(this.value=='State') this.value='';" placeholder="State" />
					<div class="kotakHasil" id="hasilPencarian3" style="display: none; position: absolute; z-index: 99;">
					<div class="daftarPencarian" id="dataPencarian3">
					</div>
				</div>
			</div>
			<div class='col-sm-2'>
					City <input class="form-control "type="text" id="namaCity2" name="namaCity2" onkeyup="cariCity2(this.value);" onblur="pilih4();"
					value="" onfocus="if(this.value=='City') this.value='';" placeholder="City" />
					<div class="kotakHasil" id="hasilPencarian4" style="display: none; position: absolute; z-index: 99;">
					<div class="daftarPencarian" id="dataPencarian4">
					</div>
				</div>
			</div>
			<div class='col-sm-2'>
					ZIP Code <input class="form-control "type="text" id="zipCode2" name="zipCode2" placeholder="ZIP Code" />
			</div>
		</div>
		
		<div id="serviceRadius" class="col-sm-3 form-group">
			How far away do you want to receive work: 
			<select name='selectedRadius' id='selectedRadius' class='form-control'>
				<option value='10'>10 Miles</option>
				<option value='15'>15 Miles</option>
				<option value='20'>20 Miles</option>
				<option value='25'>25 Miles</option>
				<option value='30'>30 Miles</option>
				<option value='35'>35 Miles</option>
				<option value='40'>40 Miles</option>
			</select>
		</div>
		
		<div class="form-group">
				<div class="col-sm-2"><label for="documentUpload">Optional General Liability Insurance Document Upload</label> 
					<input name="documentUpload" id="documentUpload" type="file" accept="image/jpg, image/JPG,image/JPEG, image/jpeg"/>
				</div>
				<label for="documentUpload" class="col-sm-2"></label>
				<div class="col-sm-2">
					<img id="documentUpload_image">
				</div>
			</div>
		
		<div id="crews" class=" col-sm-3 form-group">
			How Many Crews in your Fleet will be using your app?  
			<select name='crewsCount' id='crewsCount' class='form-control'>
				<option value='1'>1 Crew </option>
				<option value='2'>2 Crews </option>
				<option value='3'>3 Crews </option>
				<option value='4'>4 Crews </option>
				<option value='5'>5 Crews </option>
				<option value='6'>6 Crews </option>
				<option value='7'>7 Crews </option>
			</select>
		</div>
		
		<div class='form-group'>
			<div class='col-sm-2'>
				Cell Phone Number Of Provider # 1<br>
				<?php echo form_input('txtProviderPhoneNumber', '', 'class="form-control" placeholder="(XXX)-XXX-XXXX"');	?>
			</div>
			<div class='help-block with-errors'></div>
		</div>
		
		<div id="callTime" class=" col-sm-3 form-group">
			When can we call you to setup your phone? 
			<select name='selectedCallTime' id='selectedCallTime' class='form-control'>
				<option value='0'>Now</option>
				<option value='1'>08.00 AM - 12.00 PM </option>
				<option value='2'>12.00 PM - 05.00 PM </option>
				<option value='3'>05.00 PM - 09.00 PM </option>
			</select>
		</div>
		
		<div id="fromWho" class=" col-sm-3 form-group">
			How did you hear from us? 
			<select name='fromWhoPicked' id='fromWhoPicked' class='form-control'>
				<option value='1'>Google</option>
				<option value='2'>Facebook </option>
				<option value='3'>Others</option>
			</select>
		</div>
		
		<div class='form-group'>
			<div class='col-sm-5'>
				Please Confirm the following *<br>
				<label><input type='checkbox' value='' name='iphoneOrAndroidDevice' id='iphoneOrAndroidDevice'> I have an iPhone or Android Device.</label>
				<label><input type='checkbox' value='' name='haveCommercialGeneral' id='haveCommercialGeneral'> I have Commercial General Liability Insurance.</label>
				<label><input type='checkbox' value='' name='ownCommercialGradeEquipment' id='ownCommercialGradeEquipment'> I own Commercial Grade Equipment.</label>
				<br>These requirements are necessary in order to qualify and will be verified.
			</div>
		</div>
		
		<div class='form-group'>
			<div class='col-sm-5'>
				Please Agree to the Terms and Conditions: <br>
				<label><input type='checkbox' value='' name='cbAgreement' id='cbAgreement'> I have read this Agreement and Agree to the Terms & Conditions and by clicking this button consent to my electronic signature being added to said terms and conditions </label><br>
			</div>
		</div>
	<?php		
		echo "<div class='form-group'>";
		 		echo "<input type='button' class='btn btn-small btn-primary' id='btnPrevious' name='btnPrevious' value='Previous'>";
				echo form_submit('btnSubmit','Submit', 'class="btn btn-small btn-primary" id="btnSubmit"') ;
				echo form_close();
		echo "</div>";
	?>
		
		</div>
		<?
				
		?>
	</div>
</div>
</body>
<script>


	$(document).ready(function(){
		
		$("#cbAgreement").change(function(){
			if(document.getElementById("cbAgreement").checked ==true)
			{
				$("#btnSubmit").removeAttr("disabled");
				//alert("checked");
			}
			else
			{
				$("#btnSubmit").attr("disabled", "disabled");
				//alert("unchecked");
			}
		});
		
	});
	
	$(function(){
		$("#btnSubmit").attr("disabled", "disabled");
		
		$('#btnNext').on('click',function(){
			//alert("A");
			$('#firstForm').hide();
			$('#secondForm').show();
		});

		$('#btnPrevious').on('click',function(){
			//alert("A");
			$('#secondForm').hide();
			$('#firstForm').show();
		});
	});
		
	function cariState(namaState) {
		if(namaState.length == 0) {
			$('#hasilPencarian').hide();
		} else {
				$.post("<?php echo base_url(); ?>index.php/gbusnow_controller/autoComplete", 
				{kirimNama: namaState,
				 param: '1'}, function(data){
					if(data.length >0) {
						$('#hasilPencarian').fadeIn();
						$('#dataPencarian').html(data);
					}
				});
			
		}
	}
	
	function pilih1(thisValue) {
		$('#namaState').val(thisValue);
		setTimeout("$('#hasilPencarian').fadeOut();", 10);
	}
	
	function cariCity(namaCity) {
		if(namaCity.length == 0) {
			$('#hasilPencarian2').hide();
		} else {
				var state = document.getElementById('namaState').value;
				$.post("<?php echo base_url(); ?>index.php/gbusnow_controller/autoComplete2", 
				{kirimNama: namaCity,
				 State: state,
				 param: '2'}, function(data){
					if(data.length >0) {
						$('#hasilPencarian2').fadeIn();
						$('#dataPencarian2').html(data);
					}
				});
		}
	}

	function pilih2(thisValue) {
		$('#namaCity').val(thisValue);
		setTimeout("$('#hasilPencarian2').fadeOut();", 10);
	}
	
	//--------------------------------------------------------------//
	//					UNTUK FORM KE DUA							//
	//--------------------------------------------------------------//
	
	function cariState2(namaState) {
		if(namaState.length == 0) {
			$('#hasilPencarian3').hide();
		} else {
				$.post("<?php echo base_url(); ?>index.php/gbusnow_controller/autoComplete", 
				{kirimNama: namaState,
				 param: '3'}, function(data){
					if(data.length >0) {
						$('#hasilPencarian3').fadeIn();
						$('#dataPencarian3').html(data);
					}
				});
			
		}
	}
	
	function pilih3(thisValue) {
		$('#namaState2').val(thisValue);
		setTimeout("$('#hasilPencarian3').fadeOut();", 10);
	}
	
	function cariCity2(namaCity) {
		if(namaCity.length == 0) {
			$('#hasilPencarian4').hide();
		} else {
				var state = document.getElementById('namaState2').value;
				$.post("<?php echo base_url(); ?>index.php/gbusnow_controller/autoComplete2", 
				{kirimNama: namaCity,
				 State: state,
				 param: '4'}, function(data){
					if(data.length >0) {
						$('#hasilPencarian4').fadeIn();
						$('#dataPencarian4').html(data);
					}
				});
		}
	}

	function pilih4(thisValue) {
		$('#namaCity2').val(thisValue);
		setTimeout("$('#hasilPencarian4').fadeOut();", 10);
	}
			
</script>
</html>