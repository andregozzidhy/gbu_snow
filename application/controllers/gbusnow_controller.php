<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class gbusnow_controller extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->model('gbusnow_model');
		$this->load->library('form_validation');
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper('cookie');
		$this->load->library("pagination");
		$this->load->database();
	}
	
	//-----------------------------------------------------//
						//PAGE FUNCTION//
	//-----------------------------------------------------//
	
	public function index()
	{
		$data = [];
		
		$login = $this->getLoginStatus();
		if ($login != "")
		{
			redirect('gbusnow_controller/userDashboard', 'refresh');
		}
		else
		{
			$this->load->view('index', $data);
		}
		
	}
	
	public function login()
	{
		$data = [];
		$data['msg'] = "";
		$login = $this->getLoginStatus();
		if ($login != "")
		{
			redirect('gbusnow_controller/userDashboard', 'refresh');
		}
		else
		{
			if($this->input->post('btnLogin')==true)
			{
				$this->form_validation->set_rules("txtemail", "Email", "trim|required|valid_email");
				$this->form_validation->set_rules("txtpassword", "Password", "trim|required");
					
				if($this->form_validation->run()==true)
				{
					$data["email"] = $this->input->post('txtemail',true);
					$data["password"] = md5($this->input->post('txtpassword',true));
					
					if($this->cekLogin($data["email"],$data["password"]))
					{
						$cookie = array(
						'name'   => 'snow_user',
						'value'  => $data["email"],
						'expire' => 60*60*7
						);
						$this->input->set_cookie($cookie);
						
						redirect('gbusnow_controller/userDashboard', 'refresh');
					}
					else
					{
						$data["msg"] = "Wrong Email or Password!";
						$this->load->view('login', $data);
					}
				}
				else
				{
					$this->load->view('login', $data);
				}
			}
			else
			{
				$this->load->view('login', $data);
			}
		}
	}
	
	public function providerDashboard()
	{
		$data = [];
		$login = $this->getProviderLoginStatus();
		if ($login != "")
		{
			$data["login"] = $login;
			$dataStateCity = $this->gbusnow_model->getProviderStateCity($login);
			for($i=0;$i<count($dataStateCity);$i++)
			{
				$data["provider_state"]= $dataStateCity[$i]->provider_service_state;
				$data["provider_city"]= $dataStateCity[$i]->provider_service_city;
			}
			$data["dataService"] = $this->gbusnow_model->getAllUnServicedCustomerInRegion($data["provider_state"], $data["provider_city"]);
			$data["provider_id"] = $this->gbusnow_model->getProviderIdbyEmail($login);
			$data["jumlahApply"] = $this->gbusnow_model->countTempApply($data["provider_id"]);
			
			//--------------------------------------------
			//----------USER HOUSE MAPS-----------
			$this->load->library('googlemaps');
				$data["mapCount"] = count($data["dataService"]);
				$data["currentPage"] = 0;
				$data["paramMap1"]=0;
				$data["paramMap2"]=0;
				$data["paramMap3"]=0;
				if ($this->uri->segment(3)==true)
				{
					$page = $this->uri->segment(3);
					$data["start"] = $page*3;
					$data["end"] = ($page*3)+3;
					if(count($data["dataService"])<$data["end"])
					{
						$data["end"] = count($data["dataService"]);
					}
				}
				else
				{
					$data["start"] = 0;
					$data["end"] = 3;
					if(count($data["dataService"])<$data["end"])
					{
						$data["end"] = count($data["dataService"]);
					}
				}
				
				for($i=$data["start"];$i< $data["end"] ; $i++)
				{
					$config['center'] = $data["dataService"][$i]->house_latitude.", ".$data["dataService"][$i]->house_longitude;;
					$config['zoom'] = 15;
					$marker = array();
					$marker['position'] = $data["dataService"][$i]->house_latitude.", ".$data["dataService"][$i]->house_longitude;
						
					if($i%3==0)
					{
						$config['map_name'] = 'map_one';
						$config['map_div_id'] = 'map_canvas_one';
						$this->googlemaps->initialize($config);
						$this->googlemaps->add_marker($marker);
						$data['map_one'] = $this->googlemaps->create_map();
						$data["paramMap1"]=1;
					}
					else if($i%3==1)
					{
						$config['map_name'] = 'map_two';
						$config['map_div_id'] = 'map_canvas_two';
						$this->googlemaps->initialize($config);
						$this->googlemaps->add_marker($marker);
						$data['map_two'] = $this->googlemaps->create_map();
						$data["paramMap2"]=1;
					}
					else if($i%3==2)
					{
						$config['map_name'] = 'map_three';
						$config['map_div_id'] = 'map_canvas_three';
						$this->googlemaps->initialize($config);
						$this->googlemaps->add_marker($marker);
						$data['map_three'] = $this->googlemaps->create_map();
						$data["paramMap3"]=1;
					}
				}
			
			//--------------------------------------------
			
			
		
			$this->load->view('providerDashboard', $data);
		}
		else
		{
			$this->load->view('providerLogin', $data);
		}
	}
	
	public function providerlogin()
	{
		$data = [];
		$data['msg'] = "";
		$login = $this->getProviderLoginStatus();
		if ($login != "")
		{
			
			$dataStateCity = $this->gbusnow_model->getProviderStateCity($login);
			for($i=0;$i<count($dataStateCity);$i++)
			{
				$data["provider_state"]= $dataStateCity[$i]->provider_service_state;
				$data["provider_city"]= $dataStateCity[$i]->provider_service_city;
				$data["login"] = $login;
			}
			$this->load->view('providerDashboard', $data);
		}
		else
		{
			if($this->input->post('btnLogin')==true)
			{
				$this->form_validation->set_rules("txtemail", "Email", "trim|required|valid_email");
				$this->form_validation->set_rules("txtpassword", "Password", "trim|required");
					
				if($this->form_validation->run()==true)
				{
					$data["email"] = $this->input->post('txtemail',true);
					$data["password"] = md5($this->input->post('txtpassword',true));
					
					if($this->cekProviderLogin($data["email"],$data["password"]))
					{
						$cookie = array(
						'name'   => 'snow_provider_user',
						'value'  => $data["email"],
						'expire' => 60*60*7
						);
						$this->input->set_cookie($cookie);
						
						redirect('gbusnow_controller/providerDashboard', 'refresh');
					}
					else
					{
						$data["msg"] = "Wrong Email or Password!";
						$this->load->view('providerLogin', $data);
					}
				}
				else
				{
					$this->load->view('providerLogin', $data);
				}
			}
			else
			{
				$this->load->view('providerLogin', $data);
			}
		}
	}
		
	public function signup()
	{
		$data= [];
		$data["name"] = "";
		$data["email"] = "";
		$data["password"] = "";
		$data["confirmpassword"] = "";
		$data["phonenumber"] = "";
		$data["msg"] = "";
		
		$login = $this->getLoginStatus();
		if ($login != "")
		{
			redirect('gbusnow_controller/userDashboard', 'refresh');
		}
		else
		{
			if($this->input->post('btnnext')==true)
			{
					$this->form_validation->set_rules("txtname", "Name", "trim|required");
					$this->form_validation->set_rules("txtemail", "Email", "trim|required|valid_email|callback_cek_email");
					$this->form_validation->set_rules("txtpassword", "Password", "trim|required");
					$this->form_validation->set_rules("txtconfirmpassword", "Confirm Password", "trim|required|callback_confirm_password");
					
					if($this->form_validation->run()==true)
					{
						$data["name"] = $this->input->post('txtname',true);
						$data["email"] = $this->input->post('txtemail',true);
						$data["password"] = $this->input->post('txtpassword',true);
						$data["confirmpassword"] = $this->input->post('txtconfirmpassword',true);
						$data["phonenumber"] = $this->input->post('txtphonenumber',true);
										
						$data["password"] = md5($data["password"]);
						$this->gbusnow_model->signup($data);
						$data["msg"] = "done";
						
						$cookie = array(
							'name'   => 'snow_user',
							'value'  => $data["email"],
							'expire' => 60*60
							);
							$this->input->set_cookie($cookie);
							
						$this->load->view('selectService', $data);
					}
					else
					{
						$this->load->view('signup', $data);
					}
			}
			else
			{
				$this->load->view('signup', $data);
			}
		}
	}
		
	public function selectService()
	{
		$login = $this->getLoginStatus();
		if ($login != "")
		{
			$data = [];
			$data["selectServices"] = "";
			$data["selectTypeRumah"] = "";
			//jangan lupa perbaharui session disini nanti
			
			$this->destroySession();
			if($this->input->post('btnnext')==true)
			{
				$data["selectServices"]=$this->input->post('service-box',true);
				$this->session->set_userdata('selectServices',$data["selectServices"]);
				redirect('gbusnow_controller/selectHomeType', 'refresh');
			}
			else
			{
				$this->load->view('selectService', $data);
			}
		}
		else
		{
			$this->index();
		}
	}
	
	public function providerSignUp()
	{
		$data=[];

		if($this->input->post('btnSubmit')==true)
		{
			$this->form_validation->set_rules("txtFirstName", "First Name", "trim|required");
			$this->form_validation->set_rules("txtLastName", "Last Name", "trim|required");
			$this->form_validation->set_rules("txtCompanyName", "Company Name", "trim|required");
			$this->form_validation->set_rules("txtCompanyTitle", "Company Title", "trim|required");
			$this->form_validation->set_rules("txtEmail", "Company Address", "trim|required");
			$this->form_validation->set_rules("txtphonenumber", "Phone Number", "trim|required|numeric");
			
			if($this->form_validation->run()==true)
			{
				//dari forrm 1
				$data['provider_first_name'] = $this->input->post('txtFirstName');
				$data['provider_last_name'] = $this->input->post('txtLastName');
				$data['provider_company_name'] = $this->input->post('txtCompanyName');
				$data['provider_company_title'] = $this->input->post('txtCompanyTitle');
				$data['provider_company_type'] = $this->input->post('companyType');
				$data['provider_company_address'] = $this->input->post('txtCompanyAddress');
				$data['provider_city'] = $this->input->post('namaCity');
				$data['provider_state'] = $this->input->post('namaState');
				$data['provider_zip_code'] = $this->input->post('zipCode');
				$data['provider_prime_contact'] = $this->input->post('txtphonenumber');
				$data['provider_email'] = $this->input->post('txtEmail');
				
				//dari form 2
				if(isset($_POST['cbMowzProvider']))
				{
					$data['provider_mows'] = '1';
				}
				else
				{
					$data['provider_mows'] = '0';
				}
				if(isset($_POST['cbPlowzProvider']))
				{
					$data['provider_plows'] = '1';
				}
				else
				{
					$data['provider_plows'] = '0';
				}
				$data['provider_service_address'] = $this->input->post('txtServiceAddress');
				$data['provider_service_city'] = $this->input->post('namaCity2');
				$data['provider_service_state'] = $this->input->post('namaState2');
				$data['provider_zip_code2'] = $this->input->post('zipCode2');
				$data['provider_phone_number'] = $this->input->post('txtProviderPhoneNumber');
				$data['provider_service_radius'] = $this->input->post('selectedRadius');
				$data['provider_crew_count'] = $this->input->post('crewsCount');
				$data['provider_know_from'] = $this->input->post('fromWhoPicked');	
				$data['provider_id'] = $this->gbusnow_model->generateProviderId(); 
				
				$this->gbusnow_model->insertProviderData($data);
								
				//masuk db notif
				$data['selectedCallTime'] = $this->input->post('selectedCallTime');
				
				$this->load->view('thxforsignup', $data);
			}
	
		}
		else
		{
			$this->load->view('signupProvider', $data);
		}
	}
	
	public function userDashboard()
	{
		$this->load->library('googlemaps');
		
		$data= [];
		$data["emailUser"] = $this->getLoginStatus();
		$login = $this->getLoginStatus();
		$this->destroySession();
		if($login != "")
		{
			//-----------MAP LAST ORDER-----------
		
			

		
			//------------------------------------
			//----------USER HOUSE MAPS-----------
			$houseData = $this->gbusnow_model->getUserHouseData($login);
			$data["mapCount"] = count($houseData);
			$data["currentPage"] = 0;
			$data["paramMap1"]=0;
			$data["paramMap2"]=0;
			$data["paramMap3"]=0;
			if ($this->uri->segment(3)==true)
			{
				$page = $this->uri->segment(3);
				$data["start"] = $page*3;
				$data["end"] = ($page*3)+3;
				if(count($houseData)<$data["end"])
				{
					$data["end"] = count($houseData);
				}
			}
			else
			{
				$data["start"] = 0;
				$data["end"] = 3;
				if(count($houseData)<$data["end"])
				{
					$data["end"] = count($houseData);
				}
			}
			
			for($i=$data["start"];$i< $data["end"] ; $i++)
			{
				$config['center'] = $houseData[$i]->house_latitude.", ".$houseData[$i]->house_longitude;;
				$config['zoom'] = 15;
				$marker = array();
				$marker['position'] = $houseData[$i]->house_latitude.", ".$houseData[$i]->house_longitude;
					
				if($i%3==0)
				{
					$config['map_name'] = 'map_one';
					$config['map_div_id'] = 'map_canvas_one';
					$this->googlemaps->initialize($config);
					$this->googlemaps->add_marker($marker);
					$data['map_one'] = $this->googlemaps->create_map();
					$data["paramMap1"]=1;
					$data['mapOneAddress'] =  $houseData[$i]->house_address;
					$data['house_id_one'] =  $houseData[$i]->house_id;
				}
				else if($i%3==1)
				{
					$config['map_name'] = 'map_two';
					$config['map_div_id'] = 'map_canvas_two';
					$this->googlemaps->initialize($config);
					$this->googlemaps->add_marker($marker);
					$data['map_two'] = $this->googlemaps->create_map();
					$data["paramMap2"]=1;
					$data['mapTwoAddress'] =  $houseData[$i]->house_address;
					$data['house_id_two'] =  $houseData[$i]->house_id;
				}
				else if($i%3==2)
				{
					$config['map_name'] = 'map_three';
					$config['map_div_id'] = 'map_canvas_three';
					$this->googlemaps->initialize($config);
					$this->googlemaps->add_marker($marker);
					$data['map_three'] = $this->googlemaps->create_map();
					$data["paramMap3"]=1;
					$data['mapThreeAddress'] =  $houseData[$i]->house_address;
					$data['house_id_three'] =  $houseData[$i]->house_id;
				}
			}
			
			$this->load->view('userDashboard', $data);
			
			/*	
			for($i=0;$i< count($houseData) ; $i++)
			{
				$config['center'] = $houseData[$i]->house_latitude.", ".$houseData[$i]->house_longitude;
				$config['zoom'] = 5;
				$config['map_name'] = "map_".$i;
				$config['map_div_id'] = "map_canvas_".$i;
				$this->googlemaps->initialize($config);

				$marker = array();
				$marker['position'] = $houseData[$i]->house_latitude.", ".$houseData[0]->house_longitude;
				//$marker['infowindow_content'] = "I'm on Map One";
				$this->googlemaps->add_marker($marker);

				$data["map_".$i] = $this->googlemaps->create_map();

			}
			*/
			
			/*
			// Map One
			$config['center'] = $houseData[0]->house_latitude.", ".$houseData[0]->house_longitude;;
			$config['zoom'] = 15;
			$config['map_name'] = 'map_one';
			$config['map_div_id'] = 'map_canvas_one';
			$this->googlemaps->initialize($config);

			$marker = array();
			$marker['position'] = $houseData[0]->house_latitude.", ".$houseData[0]->house_longitude;
			$marker['infowindow_content'] = "I'm on Map One";
			$this->googlemaps->add_marker($marker);

			$data['map_one'] = $this->googlemaps->create_map();

			// Map Two
			$config['center'] = $houseData[1]->house_latitude.", ".$houseData[1]->house_longitude;
			$config['zoom'] = 15;
			$config['map_name'] = 'map_two';
			$config['map_div_id'] = 'map_canvas_two';
			$this->googlemaps->initialize($config);

			$marker = array();
			$marker['position'] = $houseData[1]->house_latitude.", ".$houseData[1]->house_longitude;
			$marker['infowindow_content'] = "I'm on Map Two";
			$this->googlemaps->add_marker($marker);

			$data['map_two'] = $this->googlemaps->create_map();

			// Map Three
			$config['center'] = $houseData[2]->house_latitude.", ".$houseData[2]->house_longitude;
			$config['zoom'] = 15;
			$config['map_name'] = 'map_three';
			$config['map_div_id'] = 'map_canvas_three';
			$this->googlemaps->initialize($config);

			$marker = array();
			$marker['position'] = $houseData[2]->house_latitude.", ".$houseData[2]->house_longitude;
			$marker['infowindow_content'] = "I'm on Map Two";
			$this->googlemaps->add_marker($marker);

			$data['map_three'] = $this->googlemaps->create_map();
			*/
			//------------------------------------
			
		}
		else
		{
			$this->index();
		}
	}
	
	public function selectHomeType()
	{
		$login = $this->getLoginStatus();
		if ($login != "")
		{
			$data = [];
			
			if($this->input->post('btnnext')==true)
			{
				$data["selectTypeRumah"] = $this->input->post('houseTypeOption');
				$this->session->set_userdata('selectTypeRumah',$data["selectTypeRumah"]);
				redirect('gbusnow_controller/selectLocation', 'refresh');
			}
			else
			{
				$this->load->view('selectHomeType', $data);
			}
		}
		else
		{
			$this->index();
		}
	}
	
	
	public function selectLocation()
	{
		$login = $this->getLoginStatus();
		if ($login != "")
		{
			$this->load->library('googlemaps');
			
			if($this->input->post('btnNext')==true)
			{
				$data = [];
				$address = $this->input->post('txtlocation');
				$detail = $this->input->post('txtDetail');
				$houseColor = $this->input->post('selectedHouseColor');
				$mailBoxColor = $this->input->post('selectedMailBoxColor');
				$hiddenCity = $this->input->post('hiddenCity');
				$hiddenState = $this->input->post('hiddenState');
				$this->session->set_userdata('address',$address);
				$this->session->set_userdata('detail',$detail);
				$this->session->set_userdata('houseColor',$houseColor);
				$this->session->set_userdata('mailBoxColor',$mailBoxColor);
				$this->session->set_userdata('houseCity',$hiddenCity);
				$this->session->set_userdata('houseState',$hiddenState);
							
				//$this->load->view('driveWayInfo', $data);
				
				if($this->session->userdata('selectServices')=='1')
				{
					redirect('gbusnow_controller/driveWayInfo', 'refresh');
				}
				else if ($this->session->userdata('selectServices')=='2' || ($this->session->userdata('selectServices')=='3'))
				{
					redirect('gbusnow_controller/lawnInfo', 'refresh');
				}
				else
				{
					$data['drivewayWidth']= null;
					$data['drivewayLength']= null;
					$data['drivewayShape'] = null;
					$data['drivewayType'] = null;
					$data["lawn_size"]= null;
					$data["lawn_hilly"]=null;
					$data["gate_size"]= null;
					$data["fence"]= null;
					$data["pool"]= null;
					$data["sprinklers"]= null;
					$data["pet"] = null;
					$data['selectTypeRumah'] = $this->session->userdata('selectTypeRumah');
					$data['latitude'] = $this->session->userdata('latitude');
					$data['longitude'] = $this->session->userdata('longitude');
					$data['address'] = $this->session->userdata('address');
					$data['detail'] = $this->session->userdata('detail');
					$data['houseColor'] = $this->session->userdata('houseColor');
					$data['mailBoxColor'] = $this->session->userdata('mailBoxColor');
					$data['houseCity'] = $this->session->userdata('houseCity');
					$data['houseState'] = $this->session->userdata('houseState');
					$data['user_email']= $login;
					
					if($this->gbusnow_model->cekAdaCity($data['houseCity'], $data['houseState']) == 0)
					{
						$this->gbusnow_model->insertNewCity($data['houseCity'], $data['houseState']);
					}
					
					$data["house_id"] = $this->gbusnow_model->generateHouseId();
					$this->gbusnow_model->insertHouseData($data);
					
					redirect('gbusnow_controller/userDashboard', 'refresh');
				}
			}
			else
			{
				$config = array();
				$config['center'] = 'auto';
				
				$config['onboundschanged'] = 'if (!centreGot) {
					var mapCentre = map.getCenter();
					marker_0.setOptions({
						position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng()) 
					});
				}';
				
				//--------buat text
				$config['zoom'] = 'auto';
				$config['onzoomchanged']='centreGot = true;';
				$config['places'] = TRUE;
				$config['placesAutocompleteInputID'] = 'myPlaceTextBox';
				$config['placesAutocompleteBoundsMap'] = TRUE; // set results biased towards the maps viewport
				//$config['placesAutocompleteOnChange'] = 'alert(\'You selected a place\');';
				$config['placesAutocompleteOnChange'] = '
							
							var address = $("#myPlaceTextBox").val();
							var geocoder = new google.maps.Geocoder();
							geocoder.geocode({ "address": address }, function (results, status) {
								if (status == google.maps.GeocoderStatus.OK) {
						
									map.setCenter(results[0].geometry.location);
									marker_0.setOptions({
										 position: results[0].geometry.location
									});
				  
									$.ajax({
									type: "POST",
									dataType: "json",
									url:"' .site_url('gbusnow_controller/saveCoordinatesToSession'). '",
									data: {param_latitude: results[0].geometry.location.lat(),
										   param_longitude: results[0].geometry.location.lng()
											},
									success: function (obj) { 
									
										}
									
									});
								
									//alert("Latitude : "+results[0].geometry.location.lat() + " || Longitude : " + results[0].geometry.location.lng());
									
									
									/*  for (var i = 0; i < results.length; i++) {
										if (results[i].types[0] === "locality") {
											var city = results[i].address_components[0].short_name;
											var state = results[i].address_components[2].long_name;
											$("#hiddenCity").val(city);
											$("#hiddenState").val(state);
											alert(city+" and "+state+ " dari Address");
										}
									}
									*/
									
									var city ="";
									var state = "";
									for (var i = 0; i < results[0].address_components.length; i++) 
									{
										//alert(results[0].address_components[i].types + " = " + results[0].address_components[i].long_name);
										if(results[0].address_components[i].types == "administrative_area_level_1,political")
										{
											//alert(results[0].address_components[i].types + " = " + results[0].address_components[i].long_name);
											state = results[0].address_components[i].long_name;
										}
										
										if(results[0].address_components[i].types == "locality,political")
										{
											//alert(results[0].address_components[i].types + " = " + results[0].address_components[i].long_name);
											city = results[0].address_components[i].long_name;
										} 
										else if(results[0].address_components[i].types == "administrative_area_level_2,political")
										{
											if (city=="")
											{
												//alert(results[0].address_components[i].types + " = " + results[0].address_components[i].long_name);
												city = results[0].address_components[i].long_name;
											}
										}
									}
									
									$("#hiddenCity").val(city);
									$("#hiddenState").val(state);
	
									 
								} else {
									alert("Geocode was not successful for the following reason: ");
								}
								
							centreGot = true;
							});
							
						  
						
				';
				$config['ondrag']='centreGot = false;';
				$config['ondragend']='
									var input = marker_0.getPosition();
									
									$.ajax({
									type: "POST",
									dataType: "json",
									url:"' .site_url('gbusnow_controller/saveCoordinatesToSession'). '",
									data: {param_latitude: input.lat(),
										   param_longitude: input.lng()
											},
									success: function (obj) { 
									
										}
									
									});
									
									
									//---------GET ADDRESS
									var latlng = new google.maps.LatLng(input.lat(),  input.lng());
									var geocoder = new google.maps.Geocoder();
									geocoder.geocode({"latLng": latlng}, function(results, status) {
										if (status == google.maps.GeocoderStatus.OK) {
										//alert(results[0].formatted_address);
										var city = "";
										var state = "";
										  /*if(results[1])
										  {
											for (var i = 0; i < results.length; i++) 
											{
												if (results[i].types[0] === "locality") 
												{
													var city = results[i].address_components[0].short_name;
													var state = results[i].address_components[2].short_name;
													$("#hiddenCity").val(city);
													$("#hiddenState").val(state);
													alert(city+" and "+state+ " dari Marker");
												}										
												 
											}
										  }*/
										  
										for (var i = 0; i < results[0].address_components.length; i++) 
										{
											//alert(results[0].address_components[i].types + " = " + results[0].address_components[i].long_name);
											if(results[0].address_components[i].types == "administrative_area_level_1,political")
											{
												//alert(results[0].address_components[i].types + " = " + results[0].address_components[i].long_name);
												state = results[0].address_components[i].long_name;
											}
											
											if(results[0].address_components[i].types == "locality,political")
											{
												//alert(results[0].address_components[i].types + " = " + results[0].address_components[i].long_name);
												city = results[0].address_components[i].long_name;
											} 
											else if(results[0].address_components[i].types == "administrative_area_level_2,political")
											{
												if (city=="")
												{
													//alert(results[0].address_components[i].types + " = " + results[0].address_components[i].long_name);
													city = results[0].address_components[i].long_name;
												}
											}
										}
										
										$("#hiddenCity").val(city);
										$("#hiddenState").val(state);
										  										  
										  if (results[0]) {
										
											$("#myPlaceTextBox").val(results[0].formatted_address);
											
										  } else {
											alert("Tidak ditemukan");
										  }
										} else {
										  alert("Geocoder  gagal: " + status);
										}
									});
									
									//---------------
									
									';
				
				//-------------------------
				
				$this->googlemaps->initialize($config);
				   
				// set up the marker ready for positioning 
				// once we know the users location
				$marker = array();
				$this->googlemaps->add_marker($marker);
				$data['map'] = $this->googlemaps->create_map();
				
				//----------------------------------------
				$this->load->view('selectLocation', $data);
			}
		}
		else
		{
			$this->index();
		}
	}
	
	public function lawnInfo()
	{
		$data = [];
		$login = $this->getLoginStatus();
		if ($login != "")
		{
			if($this->input->post('btnSubmit')==true)
			{
				//data rumah snow dikosongkan
				$data['drivewayWidth']= null;
				$data['drivewayLength']= null;
				$data['drivewayShape'] = null;
				$data['drivewayType'] = null;
					
				//data ruma lawn diisi
				$data["lawn_size"]= $this->input->post('lawnSize');
				$data["lawn_hilly"]= $this->input->post('lawnHilly');
				$data["gate_size"]= $this->input->post('selectedGateSize');
								
				if(isset($_POST["checkFence"]))
				{$data["fence"]= 1;}else
				{$data["fence"]= 0;}
				
				if(isset($_POST["checkPool"]))
				{$data["pool"]= 1;}else
				{$data["pool"]= 0;}
			
				if(isset($_POST["checkSprinklers"]))
				{$data["sprinklers"]= 1;}else
				{$data["sprinklers"]= 0;}
				
				if(isset($_POST["checkPet"]))
				{$data["pet"]= 1;}else
				{$data["pet"]= 0;}		
			
				if($this->session->userdata('house_id')!= null)
				{
					$data["house_id"] = $this->session->userdata('house_id');
					$this->gbusnow_model->updateHouseLawnData($data);
				}
				else
				{
					$data['selectTypeRumah'] = $this->session->userdata('selectTypeRumah');
					$data['latitude'] = $this->session->userdata('latitude');
					$data['longitude'] = $this->session->userdata('longitude');
					$data['address'] = $this->session->userdata('address');
					$data['detail'] = $this->session->userdata('detail');
					$data['houseColor'] = $this->session->userdata('houseColor');
					$data['mailBoxColor'] = $this->session->userdata('mailBoxColor');
					$data['houseCity'] = $this->session->userdata('houseCity');
					$data['houseState'] = $this->session->userdata('houseState');
					$data['user_email']= $login;
					
					if($this->gbusnow_model->cekAdaCity($data['houseCity'], $data['houseState']) == 0)
					{
						$this->gbusnow_model->insertNewCity($data['houseCity'], $data['houseState']);
					}
					
					$data["house_id"] = $this->gbusnow_model->generateHouseId();
					$this->gbusnow_model->insertHouseData($data);
					
					//masukkan id ke house_id
					$this->session->set_userdata('house_id',$data["house_id"]);
				}
				
				redirect('gbusnow_controller/setDateTimeService', 'refresh');
			}
			
			$this->load->view('lawnInfo', $data);
		}
		else
		{
			$this->index();
		}
	}
	
	public function driveWayInfo()
	{
		$login = $this->getLoginStatus();
		if ($login != "")
		{
			$data = [];			
			$data['firstDatePicked'] = "";
			$data['firstTimePicked'] = "";
			$data['secondDatePicked'] = "";
			$data['secondTimePicked'] = "";
			$data['thirdDatePicked'] = "";
			$data['thirdTimePicked'] = "";
			$data['notes'] = "";

			if($this->input->post('btnSubmit')==true)
			{
				//data ruma lawn dikosongkan
				$data["lawn_size"]	= null;
				$data["lawn_hilly"]	= null;
				$data["gate_size"]	= null;
				$data["fence"]		= null;
				$data["pool"]		= null;
				$data["sprinklers"]	= null;
				$data["pet"] 		= null;
				
				//data rumah snow diisi
				$data['drivewayWidth'] = $this->input->post('driveWayWidth');
				$data['drivewayLength'] = $this->input->post('driveWayLength');
				$data['drivewayShape'] = $this->input->post('driveWayShape');
				$data['drivewayType'] = $this->input->post('driveWayType');
				
				if($this->session->userdata('house_id')!= null)
				{
					$data["house_id"] = $this->session->userdata('house_id');
					$this->gbusnow_model->updateHouseSnowData($data);
				}
				else
				{
					$data['selectTypeRumah'] = $this->session->userdata('selectTypeRumah');
					$data['latitude'] = $this->session->userdata('latitude');
					$data['longitude'] = $this->session->userdata('longitude');
					$data['address'] = $this->session->userdata('address');
					$data['detail'] = $this->session->userdata('detail');
					$data['houseColor'] = $this->session->userdata('houseColor');
					$data['mailBoxColor'] = $this->session->userdata('mailBoxColor');
					$data['houseCity'] = $this->session->userdata('houseCity');
					$data['houseState'] = $this->session->userdata('houseState');
					$data['user_email']= $login;
					
					if($this->gbusnow_model->cekAdaCity($data['houseCity'], $data['houseState']) == 0)
					{
						$this->gbusnow_model->insertNewCity($data['houseCity'], $data['houseState']);
					}
							
					$data["house_id"] = $this->gbusnow_model->generateHouseId();
					$this->gbusnow_model->insertHouseData($data);
					
					//masukkan id ke house_id
					$this->session->set_userdata('house_id',$data["house_id"]);
				}
				
				//masukkan tambahan data service ke session
				$footOver =  $this->input->post('footOver');
				$this->session->set_userdata('footOver',$footOver);
		
				//$this->load->view('setDateTimeService', $data);
				redirect('gbusnow_controller/setDateTimeService', 'refresh');
			}
			else
			{
				$this->load->view('driveWayInfo', $data);
			}
		}
		else
		{
			$this->index();
		}
		
	}
	
	public function setDateTimeService()
	{
		$data = [];
		$login = $this->getLoginStatus();
		if ($login != "" && $this->session->userdata('house_id')!="")
		{
			$data['firstDatePicked'] = "";
			$data['firstTimePicked'] = "";
			$data['secondDatePicked'] = "";
			$data['secondTimePicked'] = "";
			$data['thirdDatePicked'] = "";
			$data['thirdTimePicked'] = "";
			$data['notes'] = "";
			
			if($this->input->post('btnSubmit')==true)
			{
				$data['secondDatePicked'] = $this->input->post('secondDatePicked');
				$data['secondTimePicked'] = $this->input->post('secondTimePicked');
				$data['thirdDatePicked'] = $this->input->post('thirdDatePicked');
				$data['thirdTimePicked'] = $this->input->post('thirdTimePicked');
				$data['notes'] = $this->input->post('txtNotes');
				
				if(isset($_POST['cbASAP']))
				{
					$data['firstDatePicked'] = date("D, d M Y");
					$ASAPtime = (date("H")+4).":". date("i:s");
					$newTimeFormat = date('h:i A', strtotime($ASAPtime));
					$data['firstTimePicked'] = $newTimeFormat;
				}
				
				if($data['firstDatePicked']=="")
				{
					$data['firstDatePicked'] = $data['secondDatePicked'];
					$data['firstTimePicked'] = $data['secondTimePicked'];
					$data['secondDatePicked'] = $data['thirdDatePicked'];
					$data['secondTimePicked'] = $data['thirdTimePicked'];
					$data['thirdDatePicked'] = null;
					$data['thirdTimePicked'] = null;				
				}
				
				$this->session->set_userdata('firstDatePicked',$data['firstDatePicked']);
				$this->session->set_userdata('firstTimePicked',$data['firstTimePicked']);
				$this->session->set_userdata('secondDatePicked',$data['secondDatePicked']);
				$this->session->set_userdata('secondTimePicked',$data['secondTimePicked']);
				$this->session->set_userdata('thirdDatePicked',$data['secondDatePicked']);
				$this->session->set_userdata('thirdTimePicked',$data['thirdTimePicked']);
				$this->session->set_userdata('notes',$data['notes']);
				
				//$this->summary();
				redirect('gbusnow_controller/summary', 'refresh');
			}
			else
			{
				$this->load->view('setDateTimeService', $data);
			}
		}
		else if ($login != "")
		{
			redirect('gbusnow_controller/userDashboard', 'refresh');
		}
		else
		{
			$this->index();
		}
		
	}
	
	public function summary()
	{
		
		$data = [];
		$login = $this->getLoginStatus();
		
		if ($login != "" && $this->session->userdata('house_id')!="")
		{
			$data['email'] = $login;
			//1
			$data['house_id'] = $this->session->userdata('house_id');
			//2
			$data['service_id'] = $this->session->userdata('selectServices');
			
			if($data['service_id']=='1')
			{
				$data['summaryData'] =  $this->gbusnow_model->getSummaryDataPlows($data['house_id'], $data['service_id'], $data['email']);
				$data['sizePrice'] = $this->gbusnow_model->getPriceFromDriveWay($data['house_id']);
			}
			else if($data['service_id']=='2'|| $data['service_id']=='3')
			{
				$data['summaryData'] =  $this->gbusnow_model->getSummaryDataMows($data['house_id'], $data['service_id'], $data['email']);
				$data['sizePrice'] = $this->gbusnow_model->getPriceFromLawn($data['house_id']);
			}
			
			//3
			$data['notes'] =  $this->session->userdata('notes');
			//4
			$data['firstDatePicked'] = $this->session->userdata('firstDatePicked');
			//5
			$data['firstTimePicked'] = $this->session->userdata('firstTimePicked');
			//6
			$data['secondDatePicked'] = $this->session->userdata('secondDatePicked');
			//7
			$data['secondTimePicked'] = $this->session->userdata('secondTimePicked');
			//8
			$data['thirdDatePicked'] = $this->session->userdata('thirdDatePicked');
			//9
			$data['thirdTimePicked'] = $this->session->userdata('thirdTimePicked');
			//10
			$data['footOver'] =  $this->session->userdata('footOver');
			
			//----------------MAP---------------
				
				//---get Latitude and Longitude from DB
					$coordinates = $this->gbusnow_model->getLatLng($data['house_id']);
				//---
				$this->load->library('googlemaps');

				$config['center'] = $coordinates[0]->house_latitude.','. $coordinates[0]->house_longitude;
				$config['zoom'] = '15';
				$this->googlemaps->initialize($config);

				$marker = array();
				$marker['position'] = $coordinates[0]->house_latitude.','. $coordinates[0]->house_longitude;
				$this->googlemaps->add_marker($marker);
				$data['map'] = $this->googlemaps->create_map();

			//----------------------------------
			
			$data['servicePrice'] = $this->gbusnow_model->getServicePrice($data['service_id']);
			$data['footOverPrice']= 0.5;
			$data['transactionFee'] = 0.00;
			$data['credits']= 0.00;
			$data['salesTax']= 0.00;
			
			//----------------
			//11
			$data['totalQuote'] = $data['servicePrice']+$data['transactionFee']+$data['credits']+$data['salesTax'];
			
			if($data['footOver']=='1')
			{
				$data['totalQuote'] += $data['footOverPrice'];
			}
			
			$data['houseSize'] = 0;
			if($data['service_id']=='1')
			{
				foreach($data['sizePrice'] as $price)
				{
					$data['houseSize'] += $price->dlength_price;
					$data['houseSize'] += $price->dshape_price;
					$data['houseSize'] += $price->dtype_price;
					$data['houseSize'] += $price->dwidth_price;
				}
			}
			else if ($data['service_id']=='2' || $data['service_id']=='3')
			{
				foreach($data['sizePrice'] as $price)
				{
					$data['houseSize'] += $price->lawn_hilly_price;
					$data['houseSize'] += $price->lawn_size_price;
					$data['houseSize'] += $price->gate_price;
				}
			}
			
			$data['totalQuote'] += $data['houseSize'];
			
			//12
			$data['discountValue'] = '0';
			//13
			$data['finalQuote'] = '0';
			//14
			$data['promoCode'] = ''; 
			if($this->input->post('btnConfirm')==true)
			{
				if($this->input->post('hiddenParameter')=='1')
				{
					$data['discountValue'] = $this->input->post('discountValue');
					$data['finalQuote'] = $this->input->post('finalValue');
					$data['promoCode'] = $this->input->post('hiddenPromoCode');
				}
				else
				{
					$data['discountValue'] = '0';
					$data['finalQuote'] = $data['totalQuote'];
				}
				
				$this->session->set_userdata('totalQuote',$data['totalQuote']);
				$this->session->set_userdata('discountValue',$data['discountValue']);
				$this->session->set_userdata('finalQuote',$data['finalQuote']);
				$this->session->set_userdata('promoCode',$data['promoCode']);
				
				$this->load->view('payment', $data);
			}
			else
			{
				$this->load->view('summary', $data);
			}
		}
		else
		{
			$this->index();
		}
	}
	
	public function waitingProvider()
	{
		$data = [];
		
		$login = $this->getLoginStatus();
		
		if ($login != "")
		{
			$data["user_email"] = $login;
			$this->load->view('waitingProvider', $data);
		}
		else
		{
			$this->index();
		}
		
	}
	
	public function payment()
	{
		$data = [];
		$login = $this->getLoginStatus();
		
		if ($login != "" && $this->session->userdata('house_id')!="")
		{
				//1
				$data['house_id'] = $this->session->userdata('house_id');
				//2
				$data['service_id'] = $this->session->userdata('selectServices');
				//3
				$data['notes'] =  $this->session->userdata('notes');
				//4
				$data['firstDatePicked'] = $this->session->userdata('firstDatePicked');
				//5
				$data['firstTimePicked'] = $this->session->userdata('firstTimePicked');
				//6
				$data['secondDatePicked'] = $this->session->userdata('secondDatePicked');
				//7
				$data['secondTimePicked'] = $this->session->userdata('secondTimePicked');
				//8
				$data['thirdDatePicked'] = $this->session->userdata('thirdDatePicked');
				//9
				$data['thirdTimePicked'] = $this->session->userdata('thirdTimePicked');
				//10
				$data['footOver'] =  $this->session->userdata('footOver');
				//11	
				$data['totalQuote'] = $this->session->userdata('totalQuote');
				//12
				$data['discountValue'] = $this->session->userdata('discountValue');
				//13
				$data['finalQuote'] = $this->session->userdata('finalQuote');
				//14
				$data['promoCode'] = $this->session->userdata('promoCode');
				
				//15
				$data['user_email'] = $login;
				//16
				$data['customer_name'] = $this->gbusnow_model->getCustomerName($login);
				//17
				$data['service_name'] = $this->gbusnow_model->getServiceName($data['service_id']);
				
				$this->gbusnow_model->insertQuoteData($data);
				
				redirect('gbusnow_controller/waitingProvider', 'refresh');
		}
		else
		{
			$this->index();
		}
		
	}
	
	public function thanksForSigningUp()
	{
		$this->load->view('thxforsignup');
	}
	
	//-----------------------------------------------------//
						//ADMIN FUNCTION//
	//-----------------------------------------------------//
	
	public function adminLogin()
	{
		$data= [];
		
		$data["adminid"] = "";
		$data["password"] = "";
		$data["msg"] = "";
		
		if($this->input->post('btnLogin')==true)
		{
			$this->form_validation->set_rules("txtadminid", "Id", "trim|required");
			$this->form_validation->set_rules("txtpassword", "Password", "trim|required");
			
			if($this->form_validation->run()==true)
			{
				$data["adminid"] = $this->input->post('txtadminid',true);
				$data["password"] = md5($this->input->post('txtpassword',true));
				
				if($this->cekAdminLogin($data["adminid"],$data["password"]))
				{
					$cookie = array(
					'name'   => 'admin_snow',
					'value'  => $data["adminid"],
					'expire' => 60*60*7
					);
					$this->input->set_cookie($cookie);
					
					$this->adminPanel();
				}
				else
				{
					$data["msg"] = "Wrong Email or Password!";
					$this->load->view('adminLogin', $data);
				}
			}
			else
			{
				$this->load->view('adminLogin', $data);
			}	
		}
		else
		{
			$this->load->view('adminLogin', $data);
		}
		
	}
	
	public function userOnProgressList()
	{
		$data = [];
		
		$login = $this->getLoginStatus();
		if ($login != "")
		{
			$data["user_email"] = $login;
			$this->load->view('userOnProgressList', $data);
		}
		else
		{
			$this->index();
		}
	}
	
	public function userRateProvider()
	{
		$data = [];
		
		$login = $this->getLoginStatus();
		if ($login != "")
		{
			$data["user_email"] = $login;
			$this->load->view('userRateProvider', $data);
		}
		else
		{
			$this->index();
		}
	}
	
	public function providerOnProgressList()
	{
		$data = [];
		
		$login = $this->getProviderLoginStatus();
		if ($login != "")
		{
			$data["provider_email"] = $login;
			$data["provider_id"] = $this->gbusnow_model->getProviderIdbyEmail($data["provider_email"]);
			$this->load->view('providerOnProgressList', $data);
		}
		else
		{
			$this->index();
		}
	}
	
	public function providerFinishedService()
	{
		$data = [];
		
		$login = $this->getProviderLoginStatus();
		if ($login != "")
		{
			$data["provider_email"] = $login;
			$data["provider_id"] = $this->gbusnow_model->getProviderIdbyEmail($data["provider_email"]);
			$this->load->view('providerFinishedService', $data);
		}
		else
		{
			$this->index();
		}
	}
	
	public function adminPanel()
	{
		$data = [];
		
		
		$this->load->view('adminPanel', $data);
	}
	//-----------------------------------------------------//
						//UTILITY FUNCTION//
	//-----------------------------------------------------//
	
	function getLoginStatus()
	{
		$user = $this->input->cookie("snow_user", true);
		return $user;
	}
	
	function getProviderLoginStatus()
	{
		$user = $this->input->cookie("snow_provider_user", true);
		return $user;
	}
	
	function confirm_password($confirm)
	{
		$password = $this->input->post("txtpassword",true);
		if ($password != $confirm)
		{
			$this->form_validation->set_message("confirm_password", "Confirm Password should match with Password");
			return false;
		}
		
		return true;
	}
	
	function cek_email($email)
	{
		$count = $this->gbusnow_model->cekEmailExist($email);
		if ($count > 0)
		{
			$this->form_validation->set_message("cek_email", "The email address already exists. Use another Email");
			return false;
		}
		
		return true;
	}
	
	function cekLogin($email, $password)
	{
		$count = $this->gbusnow_model->cekLoginFromDB($email, $password);
		if ($count > 0)
		{
			return true;
		}
		
		return false;
	}
	
	function cekAdminLogin($admin_id, $password)
	{
		$count = $this->gbusnow_model->cekLoginAdmin($admin_id, $password);
		if ($count > 0)
		{
			return true;
		}
		
		return false;
	}	
	
	function cekProviderLogin($provider_email, $password)
	{
		$count = $this->gbusnow_model->cekLoginProvider($provider_email, $password);
		if ($count > 0)
		{
			return true;
		}
		
		return false;
	}	
	
	public function saveCoordinatesToSession()
	{
		$latitude = $this->input->post('param_latitude');
		$longitude = $this->input->post('param_longitude');
		$this->session->set_userdata('latitude',$latitude);
		$this->session->set_userdata('longitude',$longitude);		
		if($latitude != "")
		{
			return true;
		}
		else
		{
			return false;
			return false;
		}
	}
	
	public function deletecookies()
	{
		delete_cookie("snow_user");
		delete_cookie("snow_provider_user");
		delete_cookie("admin_snow");
	}
	
	public function providerLogout()
	{
		delete_cookie("snow_provider_user");
	}
	
	public function logout()
	{
		$this->deletecookies();
		$this->index();
	}
	
	public function usePromoCode()
	{
		$promo_id = $this->input->post('promo_code');
		$promoData = $this->gbusnow_model->getPromoCodeData($promo_id);
		
		if(count($promoData)>0)
		{
			if($promoData[0]->promo_status == 0)
			{
				$this->gbusnow_model->changePromoCodeStatus($promo_id);
				echo json_encode(array(
				 'discount'=> $promoData[0]->promo_discount,
				 'msg'=> 'Promo Code Berhasil'
				 ));
			}
			else if($promoData[0]->promo_status == 1)
			{
				echo json_encode(array(
				 'discount'=> 0,
				 'msg'=> 'Promo Code Telah Digunakan'
				 ));
			}
		}
		else
		{
			echo json_encode(array(
				 'discount'=> 0,
				 'msg'=> 'Promo Code Tidak Terdaftar'
				 ));
		}
		
	}
	
	function autoComplete()
	{
		$nama = $this->input->post('kirimNama');
		$param = $this->input->post('param');
		$data['hasil_limit']=$this->gbusnow_model->getStateForAutoComplete($nama);
		if($nama!="")
		{
			echo '<ul>';
				foreach($data['hasil_limit']->result() as $result)
				{
					echo '<li onClick="pilih'.$param.'(\''.$result->state_name.'\');">'.$result->state_name.'</li>';
				}				
			echo '</ul>';
		}
		else
		{
			echo "error";
		}
	}
	
	function autoComplete2()
	{
		$city = $this->input->post('kirimNama');
		$state = $this->input->post('State');
		$param = $this->input->post('param');
		$data['hasil_limit']=$this->gbusnow_model->getStateForAutoComplete2($city,$state);
		if($state!="")
		{
			echo '<ul>';
				foreach($data['hasil_limit']->result() as $result)
				{
					echo '<li onClick="pilih'.$param.'(\''.$result->city_name.'\');">'.$result->city_name.'</li>';
				}				
			echo '</ul>';
		}
		else
		{
			echo "State Not Found!";
		}
	}
	
	function activateProvider()
	{
		$provider_id = $this->input->post('provider_id');
		$provider_email = $this->input->post('provider_email');
		$provider_password = $this->input->post('provider_password');
		
		//-----------------------------------------------------------//
		//	      BAGIAN UPDATE STATUS PROVIDER DAN INSERT USER      //
		//-----------------------------------------------------------//
		
		$this->gbusnow_model->activateProvider($provider_id, $provider_email, $provider_password);	
			
		//--------------------------------//
		//		BAGIAN KIRIM EMAIL        //
		//--------------------------------//
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'gozzidhy@gmail.com',
			'smtp_pass' => 'jalankankode',
			'mailtype'  => 'html', 
			'charset'   => 'iso-8859-1'
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		//Set to, from, message, etc.
		$this->email->from('gozzidhy@gmail.com', 'GBU SNOW');
        $this->email->to($provider_email); 

        $this->email->subject('Provider Activation');
        $this->email->message('Your Provider Account has been activated! <br>
								Your login password is : '.$provider_password);  

		$result = $this->email->send();
		
	}
	
	public function anyDataChangeOnWaitingProvider()
	{
		$email = $this->getLoginStatus();
		$dataCount = $this->input->post('dataCount');
		$dataProvider = $this->gbusnow_model->getAppliedProvider($email);
		if(($dataCount==0 && count($dataProvider)>0)|| 
			($dataCount>0 && count($dataProvider)==0))
		{
			echo json_encode("reload");
		}
		else
		{
			echo json_encode("");
		}
	}
	
	public function anyDataChange()
	{
		$email = $this->getProviderLoginStatus();
		$dataCount = $this->input->post('param');
		$dataCountApply = $this->input->post('param2');
		$provider_id = $this->input->post('param3');
		if($email!="")
		{
			$dataStateCity = $this->gbusnow_model->getProviderStateCity($email);
			for($i=0;$i<count($dataStateCity);$i++)
			{
				$provider_state = $dataStateCity[$i]->provider_service_state;
				$provider_city = $dataStateCity[$i]->provider_service_city;
			}
			
			$countAll = $this->gbusnow_model->countAllUnServicedCustomerInRegion($provider_state, $provider_city);
			$newDataCount = $countAll[0]->jumlah;
			
			$newDataCountApply = $this->gbusnow_model->countTempApply($provider_id);
			
			$arrObj = [];
			if(($newDataCount != $dataCount) || ($newDataCountApply != $dataCountApply))
			{
				/*$dataService = $this->gbusnow_model->getAllUnServicedCustomerInRegion($provider_state, $provider_city);
				$j=0;
				for($i=0;$i < $newDataCount;$i++)
				{
					$arrObj[$j]['service_quote_id']=$dataService[$i]->service_quote_id;
					$arrObj[$j]['customer_name']=$dataService[$i]->customer_name;
					$arrObj[$j]['service_name']=$dataService[$i]->service_name;
					$arrObj[$j]['house_address']=$dataService[$i]->house_address;
					$arrObj[$j]['service_note']=$dataService[$i]->service_note;
					$arrObj[$j]['service_quote_finaltotal']=$dataService[$i]->service_quote_finaltotal;
					
					$arrObj[$j]['date_time1']= date("D,d M Y", strtotime($dataService[$i]->service_date1))." - ".date('h:i A', strtotime($dataService[$i]->service_time1));
					
					if($dataService[$i]->service_date2 != null)
					{
						$arrObj[$j]['date_time2']= date("D,d M Y", strtotime($dataService[$i]->service_date2))." - ".date('h:i A', strtotime($dataService[$i]->service_time2));
					}
					if($dataService[$i]->service_date3 != null)
					{
						$arrObj[$j]['date_time3']= date("D,d M Y", strtotime($dataService[$i]->service_date3))." - ".date('h:i A', strtotime($dataService[$i]->service_time3));
					}
					
					$j++;
				}*/
				//$arrObj["jumlah"]=$j;
				$arrObj["param"]="1";
				
				echo json_encode($arrObj);
			}
			else
			{
				$arrObj["param"]="2";
				
				echo json_encode($arrObj);
			}
		}
		
	}
	
	public function cekServiceStatusInTemp()
	{
		
	}
	
	public function doneServiceFunction()
	{
		$data['provider_id'] = $this->input->post('provider_id');
		$data['service_quote_id'] = $this->input->post('service_quote_id');
		$this->gbusnow_model->updateStatusServiceQuote($data);
		$this->gbusnow_model->updateRecordProvider($data);
		
		$ret = true;
		
		echo json_encode($ret);
	}
	
	public function cancelApply()
	{
		$provider_email = $this->input->post('provider_email');
		$service_quote = $this->input->post('service_quote');
		
		$a = $this->gbusnow_model->cancelingApply($provider_email, $service_quote);
		
		echo json_encode($a);
	}
	
	public function declineProviderApplication()
	{
		$provider_id = $this->input->post('provider_id');
		$service_quote_id = $this->input->post('service_quote_id');
		
		$a = $this->gbusnow_model->cancelingApplyById($provider_id, $service_quote_id);
		
		echo json_encode($a);
	}
	
	public function applyService()
	{
		$provider_email = $this->input->post('provider_email');
		$service_quote = $this->input->post('service_quote');
		$service_date = $this->input->post('service_date');
		$date = $this->input->post('date');
		$time = $this->input->post('time');
		
		$a = $this->gbusnow_model->applyServiceToCustomer($service_quote, $provider_email, $service_date, $date, $time);
		
		echo json_encode($a);
	}
	
	public function setHouseIDandSelectedService()
	{
		$house_id = $this->input->post('house_id');
		$selectService = $this->input->post('selectService');
		
		$this->session->set_userdata('house_id',$house_id);
		$this->session->set_userdata('selectServices',$selectService);	
		
		if($selectService == '1')
		{
			if($this->gbusnow_model->cekHouseDriveWay($house_id) == null)
			{
				$ret="updateHouseDriveWay";
			}
			else
			{
				$ret="noUpdate";
			}
		}
		else 
		{
			if($this->gbusnow_model->cekHouseLawn($house_id) == null)
			{
				$ret="updateLawn";
			}
			else
			{
				$ret="noUpdate";
			}
		}		
		echo json_encode($ret);
	}
	
	public function destroySession()
	{
		session_destroy();
		$_SESSION = [];
	}
	
	public function approveProviderApplication()
	{
		$data["service_quote_id"] = $this->input->post('service_quote_id');
		$data["service_date"] = $this->input->post('service_date');
		$data["service_time"] = $this->input->post('service_time');
		$data["provider_id"]  = $this->input->post('provider_id');
					
		//set provider di service quote
		if($this->gbusnow_model->cekAvailableToApply($data) > 0)
		{
			$this->gbusnow_model->setProviderAndServiceDateTime($data);
		}
		
		//delete service quote di temp
		$this->gbusnow_model->deleteServiceQuoteinTemp($data["service_quote_id"]);
		
		echo json_encode("a");
	}
	
	
}

