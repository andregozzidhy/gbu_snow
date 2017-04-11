<html lang="en">
<?php
	require_once("includes.php")
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>Snow Project</title>
	<link rel="stylesheet" type="text/css" media="screen and (max-device-width: 1200px)" href="<?php echo base_url('assets/css/default_css_portrait.css'); ?>">
	 <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet"></link>
	<link href="<?php echo base_url('assets/bootstrap/css/bootstrap-datetimepicker.min.css')?>" rel="stylesheet"></link>
	<script src="<?php echo base_url('assets/bootstrap/js/bootstrap-datepicker.js')?>"></script>
	<script src="<?php echo base_url('assets/bootstrap/js/bootstrap-datepicker-old.js')?>"></script>
	<script src="<?php echo base_url('assets/bootstrap/js/bootstrap-datetimepicker.min.js')?>"></script>
	
	<style type="text/css">
	<link href="<?php echo base_url('assets/bootstrap/css/bootstrap-datepicker.css')?>" rel="stylesheet">
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
	</style>
</head>
<body>
	<div id="container">
		<?php
		
		$attributes = array('id' => 'formServiceDateTime');
		echo form_open('gbusnow_controller/setDateTimeService',$attributes,'class="form-horizontal" id="formSignUp"');
		
		?>
		<div class='header-text'>When would you like your service</div>
		<table style='' class='table table-hover table-striped table-responsive' id='tablemhs'>
		<th>
		Pick a Date
		</th>
		<th>
		</th>
		<tr>
			<td>
				<div class='form-group'>
					<div class='col-sm-3'>
						<label><input type='checkbox' value='' name='cbASAP' id='cbASAP'> ASAP (Within 4 Hours)</label>
					</div>
				<div class='help-block with-errors'></div>
			</div>
			</td>
		</tr>
		
		<tr>
			<td>
			<div class="form-group">
				<div class='col-sm-2'>
				 <div class='input-group date' id='secondDatePicker'>
					  <input type='text' class="form-control" name="secondDatePicked"/>
					  <span class="input-group-addon">
					  <span class="glyphicon glyphicon-calendar"></span>
				  </span>
				 </div>
				 </div>
			</div>
			
			<div class="form-group">
				<div class='col-sm-2'>
				<div class='input-group date' id='secondTimePicker'>
						<input type='text' class="form-control" name="secondTimePicked" />
						<span class="input-group-addon">
						<span class="glyphicon glyphicon-time"></span>
				  </span>
				 </div>
				 </div>
			</div>
			</td>
		</tr>
		
		<tr>
			<td>
			<div class="form-group">
				<div class='col-sm-2'>
				 <div class='input-group date' id='thirdDatePicker'>
					  <input type='text' class="form-control" name="thirdDatePicked"/>
					  <span class="input-group-addon">
					  <span class="glyphicon glyphicon-calendar"></span>
				  </span>
				 </div>
				 </div>
			</div>
			
			<div class="form-group">
				<div class='col-sm-2'>
				<div class='input-group date' id='thirdTimePicker'>
						<input type='text' class="form-control" name="thirdTimePicked" />
						<span class="input-group-addon">
						<span class="glyphicon glyphicon-time"></span>
				  </span>
				 </div>
				 </div>
			</div>
			</td>
		</tr>
		
		<tr>
			<td>
			 <div class="form-group">
			  <label for="notes">Notes For Your Snow Plow Provider</label>
			  <textarea name="txtNotes" class="form-control" style="width: 30%" rows="5" id="notes"></textarea>
			</div>
			</td>
		</tr>
		
		</table>
		<input type='button' class='btn btn-small btn-primary' id='btnPrevious' name='btnprevious' value='Previous'>
		<?php
		echo form_submit('btnSubmit','Submit', 'class="btn btn-small btn-primary" id="btnSubmit"') ;
		echo form_close();
		?>
		
	</div>
			
			
	<br>
	<br>
	<?php
			
		/*foreach( $this->session->all_userdata() as $isisession)
		{
			if($isisession != null || $isisession!="")
			{echo $isisession . "<br>";
			}
		}*/
		
		//echo $this->session->userdata('selectServices');
		
	?>
 
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap-datetimepicker.min.js')?>"></script>
</body>
     <script type="text/javascript">
           $(function () {
			   
				$('#btnPrevious').on('click',function(){
						window.location.href = "<?php echo site_url('gbusnow_controller/driveWayInfo'); ?>";
					});
				  $('#secondDatePicker').datepicker({
				   format: 'D, dd M yyyy',
				   autoclose: true,
				   readonly: true
				  });
				  
				
                $('#secondTimePicker').datetimepicker({
                    format: 'LT',
                });
				
				$('#thirdDatePicker').datepicker({
				   format: 'D, dd M yyyy',
				   autoclose: true,
				   readonly: true
				 });
				  
				
                $('#thirdTimePicker').datetimepicker({
                    format: 'LT',
				});
		   });
		   
		   
        </script>         
			
</html>