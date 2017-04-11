<?php 

class gbusnow_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function generateUserId()
	{
		$tahun = date("Y");
		$kodeTahun = substr($tahun,2,2);
		$kodeAwal = "U".$kodeTahun;
		$kodeAngka= $this->getKodeUser($kodeAwal."%");
		$kodeUserId = $kodeAwal . str_pad($kodeAngka, 5, "0", STR_PAD_LEFT);
		
		return $kodeUserId;
	}
		
	function getKodeUser($pKode)
	{
		$qry = "SELECT COUNT(user_id) AS kode FROM gbu_user WHERE user_id LIKE '".$pKode."%'";
		$query = $this->db->query($qry);
		$kode = $query->result_array()[0]['kode']+1;
		
		return $kode;
	}
	
	function generateServiceQuoteId()
	{
		$tahun = date("Y");
		$kodeTahun = substr($tahun,2,2);
		$kodeAwal = "Q".$kodeTahun;
		$kodeAngka= $this->getKodeQuote($kodeAwal."%");
		$kodeServiceQuoteId = $kodeAwal . str_pad($kodeAngka, 5, "0", STR_PAD_LEFT);
		
		return $kodeServiceQuoteId;
	}
	
	
	function getKodeQuote($pKode)
	{
		$qry = "SELECT COUNT(service_quote_id) AS kode FROM gbu_service_quote WHERE service_quote_id LIKE '".$pKode."%'";
		$query = $this->db->query($qry);
		$kode = $query->result_array()[0]['kode']+1;
		
		return $kode;
	}
		
	function generateHouseId()
	{
		$tahun = date("Y");
		$kodeTahun = substr($tahun,2,2);
		$kodeAwal = "H".$kodeTahun;
		$kodeAngka= $this->getKodeHouse($kodeAwal."%");
		$kodeHouseId = $kodeAwal . str_pad($kodeAngka, 5, "0", STR_PAD_LEFT);
		
		return $kodeHouseId;
	}
	
	function getKodeHouse($pKode)
	{
		$qry = "SELECT COUNT(house_id) AS kode FROM gbu_user_house WHERE house_id LIKE '".$pKode."%'";
		$query = $this->db->query($qry);
		$kode = $query->result_array()[0]['kode']+1;
		
		return $kode;
	}
	
	//---
	function generateProviderId()
	{
		$tahun = date("Y");
		$kodeTahun = substr($tahun,2,2);
		$kodeAwal = "P".$kodeTahun;
		$kodeAngka= $this->getKodeProvider($kodeAwal."%");
		$kodeHouseId = $kodeAwal . str_pad($kodeAngka, 5, "0", STR_PAD_LEFT);
		
		return $kodeHouseId;
	}
	
	function getKodeProvider($pKode)
	{
		$qry = "SELECT COUNT(provider_id) AS kode FROM gbu_provider WHERE provider_id LIKE '".$pKode."%'";
		$query = $this->db->query($qry);
		$kode = $query->result_array()[0]['kode']+1;
		
		return $kode;
	}
	//---
	
	function getAllTypeRumah()
	{
		return $this->db->get("gbu_house_type")->result();
	}
	
	function insertHouseData($data)
	{
		$insertData = array(
			"house_id" => $data["house_id"],
			"user_email" => $data["user_email"],
			"house_address" => $data["address"],
			"house_detailaddress" => $data["detail"],
			"house_type" => $data["selectTypeRumah"],
			"house_latitude" => $data["latitude"],
			"house_longitude" => $data["longitude"],
			"house_color" => $data["houseColor"],
			"house_mailbox_color" => $data["mailBoxColor"],
			"house_drivewaywidth" => $data["drivewayWidth"],
			"house_drivewaylength" => $data["drivewayLength"],
			"house_drivewayshape" => $data["drivewayShape"],
			"house_drivewaytype" => $data["drivewayType"],
			
			"house_lawn_size" => $data["lawn_size"],
			"house_lawn_hilly" => $data["lawn_hilly"],
			"house_gate_size" => $data["gate_size"],
			"house_fence" => $data["fence"],
			"house_pool" => $data["pool"],
			"house_sprinklers" => $data["sprinklers"],
			"house_pet" => $data["pet"],
			
			"house_city" => $data["houseCity"],
			"house_state" => $data["houseState"]
		);
		
		$this->db->insert("gbu_user_house", $insertData);
	}
	
	function updateHouseLawnData($data)
	{
		$updateData = array(
			"house_lawn_size" => $data["lawn_size"],
			"house_lawn_hilly" => $data["lawn_hilly"],
			"house_gate_size" => $data["gate_size"],
			"house_fence" => $data["fence"],
			"house_pool" => $data["pool"],
			"house_sprinklers" => $data["sprinklers"],
			"house_pet" => $data["pet"]
		);
		$this->db->where("house_id", $data["house_id"]);
		$this->db->update("gbu_user_house", $updateData);
	}
	
	function cekHouseDriveWay($house_id)
	{
		$qry = "SELECT house_drivewaywidth AS driveway FROM gbu_user_house WHERE house_id='".$house_id."'";
		$query = $this->db->query($qry);
		$ret = $query->result_array()[0]['driveway'];
		
		return $ret;
	}
	
	function cekHouseLawn($house_id)
	{
		$qry = "SELECT house_lawn_size AS lawnsize FROM gbu_user_house WHERE house_id='".$house_id."'";
		$query = $this->db->query($qry);
		$ret = $query->result_array()[0]['lawnsize'];
		
		return $ret;
	}
	
	function cekAdaCity($city, $state)
	{
		$qry = "SELECT COUNT(city_name) as jumlah FROM gbu_city_state WHERE city_name='".$city."' and city_state='".$state."'";
		$query = $this->db->query($qry);
		$ret = $query->result_array()[0]['jumlah'];
		
		return $ret;
	}
	
	function insertNewCity($city, $state)
	{
		$insertData = array(
			"city_name" => $city,
			"city_state" => $state
		);
		
		$this->db->insert("gbu_city_state", $insertData);
	}
		
	function updateHouseSnowData($data)
	{
		$updateData = array(
			"house_drivewaywidth" => $data["drivewayWidth"],
			"house_drivewaylength" => $data["drivewayLength"],
			"house_drivewayshape" => $data["drivewayShape"],
			"house_drivewaytype" => $data["drivewayType"]
		);
		$this->db->where("house_id", $data["house_id"]);
		$this->db->update("gbu_user_house", $updateData);
	}
	
	function insertAdminUser()
	{
		$insertData = array(
			"admin_id" => 'gbusnow',
			"admin_password" => md5('admingbusnow'),
		);
		
		$this->db->insert("gbu_admin", $insertData);
	}
	
	function insertProviderData($data)
	{
		$insertData = array(
			"provider_id" => $data["provider_id"],
			"provider_first_name" => $data["provider_first_name"],
			"provider_last_name" => $data["provider_last_name"],
			"provider_company_name" => $data["provider_company_name"],
			"provider_company_title" => $data["provider_company_title"],
			"provider_company_type" => $data["provider_company_type"],
			"provider_company_address" => $data["provider_company_address"],
			"provider_state" => $data["provider_state"],
			"provider_city" => $data["provider_city"],
			"provider_zip_code" => $data["provider_zip_code"],
			"provider_prime_contact" => $data["provider_prime_contact"],
			"provider_email" => $data["provider_email"],
			"provider_mows" => $data["provider_mows"],
			"provider_plows" => $data["provider_plows"],
			"provider_service_address" => $data["provider_service_address"],
			"provider_service_state" => $data["provider_service_state"],
			"provider_service_city" => $data["provider_service_city"],
			"provider_zip_code2" => $data["provider_zip_code2"],
			"provider_phone_number" => $data["provider_phone_number"],
			"provider_service_radius" => $data["provider_service_radius"],
			"provider_crew_count" => $data["provider_crew_count"],
			"provider_know_from" => $data["provider_know_from"]
		);
		
		$this->db->insert("gbu_provider", $insertData);
	}
	
	function getLawnSize()
	{
		$this->db->select("lawn_size");
		$this->db->from("gbu_lawn_size");
		return $this->db->get()->result();
	}
	
	function getLawnHilly()
	{
		$this->db->select("lawn_hilly_name");
		$this->db->from("gbu_lawn_hilly");
		return $this->db->get()->result();
	}
	
	function getGateSize()
	{
		$this->db->select("gate_size");
		$this->db->from("gbu_gate_size");
		return $this->db->get()->result();
	}
			
	function getDriveWayWidth()
	{
		$this->db->select("dwidth_name");
		$this->db->from("gbu_driveway_width");
		return $this->db->get()->result();
	}
	
	function getDriveWayLength()
	{
		$this->db->select("dlength_name");
		$this->db->from("gbu_driveway_length");
		return $this->db->get()->result();
	}
	
	function getDriveWayShape()
	{
		$this->db->select("dshape_name");
		$this->db->from("gbu_driveway_shape");
		return $this->db->get()->result();
	}
	
	function getDriveWayType()
	{
		$this->db->select("dtype_name");
		$this->db->from("gbu_driveway_type");
		return $this->db->get()->result();
	}
	
	function activateProvider($provider_id, $provider_email, $provider_password)
	{
		//ubah status
		$updateData = array(
			"provider_status" => '1'
		);
		$this->db->where("provider_id", $provider_id);
		$this->db->update("gbu_provider", $updateData);
		
		$provider_password = md5($provider_password);
		
		//insert user
		$insertData = array(
				"provider_id" => $provider_id,
				"provider_email" => $provider_email,
				"provider_password" => $provider_password
		);
		
		$this->db->insert("gbu_user_provider", $insertData);
	}
	
	function getSummaryDataPlows($house_id, $service_id, $email)
	{
		$this->db->select('u.user_name, h.house_address, h.house_detailaddress, s.service_name, s.service_price, h.house_drivewaywidth, h.house_drivewaylength, h.house_drivewayshape, h.house_drivewaytype');
		$this->db->from('gbu_user_house h, gbu_service s, gbu_user u');
		$this->db->where('h.house_id',$house_id);
		$this->db->where('s.service_id',$service_id);
		$this->db->where('u.user_email',$email);
		$this->db->limit(1);
		
		$query = $this->db->get()->result();
		
		return $query;
	}	
	
	function getSummaryDataMows($house_id, $service_id, $email)
	{
		$this->db->select('u.user_name, h.house_address, h.house_detailaddress, s.service_name, s.service_price, h.house_lawn_size, h.house_lawn_hilly, h.house_gate_size, h.house_fence, h.house_pool, h.house_sprinklers, h.house_pet');
		$this->db->from('gbu_user_house h, gbu_service s, gbu_user u');
		$this->db->where('h.house_id',$house_id);
		$this->db->where('s.service_id',$service_id);
		$this->db->where('u.user_email',$email);
		$this->db->limit(1);
		
		$query = $this->db->get()->result();
		
		return $query;
	}	
	
	function getPromoCodeData($promo_id)
	{
		$this->db->select('promo_discount, promo_status');
		$this->db->from('gbu_promo');
		$this->db->where('promo_id',$promo_id);
		$this->db->limit(1);
		
		$query = $this->db->get()->result();
		
		return $query;
	}
	
	function selectAllUnconfirmProvider()
	{
		$qry ="SELECT g.*, c.companytype_name as typeName
				FROM gbu_provider g, gbu_company_type c
				WHERE g.provider_company_type=c.companytype_id
				AND g.provider_status='0'";
		$query = $this->db->query($qry);
		return $query->result();
	}	
	
	function getAllUnServicedCustomerInRegion($provider_state, $provider_city)
	{
		$qry ="SELECT service_quote_id, gsq.house_id, gsq.customer_name, gsq.service_name, guh.house_address, gsq.service_note, gsq.service_quote_finaltotal,
				gsq.service_date1, gsq.service_time1, gsq.service_date2, gsq.service_time2, gsq.service_date3, gsq.service_time3, 
				gsq.service_generate, guh.house_latitude, guh.house_longitude
				FROM gbu_service_quote gsq, gbu_user_house guh, gbu_provider gp
				WHERE gsq.house_id=guh.house_id 
				AND guh.house_state=gp.provider_service_state
				AND guh.house_city=gp.provider_service_city
				AND guh.house_state= '".$provider_state."'
				AND gsq.service_status= '0'
				AND gsq.provider_id IS NULL
				ORDER BY gsq.service_generate DESC ";
				//AND guh.house_city= '".$provider_city."'
				
		$query = $this->db->query($qry);
		return $query->result();
	}
	
	function countAllUnServicedCustomerInRegion($provider_state, $provider_city)
	{
		$qry ="SELECT count(service_quote_id) as jumlah
				FROM gbu_service_quote gsq, gbu_user_house guh, gbu_provider gp
				WHERE gsq.house_id=guh.house_id 
				AND guh.house_state=gp.provider_service_state
				AND guh.house_city=gp.provider_service_city
				AND guh.house_state= '".$provider_state."'
				AND guh.house_city= '".$provider_city."'
				AND gsq.provider_id IS NULL";
		$query = $this->db->query($qry);
		return $query->result();
	}
	
	function countTempApply($provider_id)
	{
		$qry = "SELECT COUNT(service_quote_id) AS jumlah FROM gbu_temp_applyservice WHERE provider_id='".$provider_id."'";
		$query = $this->db->query($qry);
		$ret = $query->result_array()[0]['jumlah'];
		
		return $ret;
	}
	
	function getProviderIdbyEmail($provider_email)
	{
		$qry = "SELECT provider_id FROM gbu_provider WHERE provider_email='".$provider_email."'";
		$query = $this->db->query($qry);
		$provider_id = $query->result();
		
		return $provider_id[0]->provider_id;
	}
	
	function applyServiceToCustomer($service_quote, $provider_email, $service_date, $date, $time)
	{
		$provider_id = $this->getProviderIdbyEmail($provider_email);
		$insertData = array(
			"service_quote_id" => $service_quote,
			"provider_id" => $provider_id,
			"service_datetime" => $service_date,
			"date" => $date,
			"time" => $time
		);
		$this->db->insert("gbu_temp_applyservice", $insertData);
		
		return true;
	}
	
	function getServiceThatAppliedByProvider($provider_id, $service_quote_id)
	{
		$this->db->where("provider_id", $provider_id);
		$this->db->where("service_quote_id", $service_quote_id);
		return $this->db->count_all_results("gbu_temp_applyservice");
	}
	
	function getTempDateAppliedService($provider_id, $service_quote_id)
	{
		$qry = "SELECT service_datetime FROM gbu_temp_applyservice WHERE provider_id='".$provider_id."' AND service_quote_id='".$service_quote_id."'";
		$query = $this->db->query($qry);
		$res= $query->result();
		
		return $res[0]->service_datetime;
	}
	
	function getProviderStateCity($provider_email)
	{
		$this->db->select('provider_service_state, provider_service_city');
		$this->db->from('gbu_provider');
		$this->db->where('provider_email',$provider_email);
		
		$query = $this->db->get()->result();
		
		return $query;
	}
	
	function cancelingApply($provider_email, $service_quote_id)
	{
		$provider_id = $this->getProviderIdbyEmail($provider_email);
		
		$this->db->where("provider_id", $provider_id);
		$this->db->where("service_quote_id", $service_quote_id);
		$this->db->delete("gbu_temp_applyservice");
	}
	
	function cancelingApplyById($provider_id, $service_quote_id)
	{
		$this->db->where("provider_id", $provider_id);
		$this->db->where("service_quote_id", $service_quote_id);
		$this->db->delete("gbu_temp_applyservice");
	}
	
	function getUserHouseData($user_email)
	{
		$this->db->select('house_id, house_address, house_latitude, house_longitude');
		$this->db->from('gbu_user_house');
		$this->db->where('user_email',$user_email);
		$this->db->order_by('house_id', "desc");
		$query = $this->db->get()->result();
		
		return $query;
	
	}
	
	function insertQuoteData($data)
	{
		if($data["secondDatePicked"]=="")
		{
			$dateSecond  = null;
			$timeSecond  = null;
		}
		else
		{
			$dateSecond  = date("Y-m-d",strtotime($data["secondDatePicked"]));
			$timeSecond  = date("H:i", strtotime($data["secondTimePicked"]));
		}
		
		if($data["thirdDatePicked"]=="")
		{
			$dateThird  = null;
			$timeThird  = null;
		}
		else
		{
			$dateThird  = date("Y-m-d",strtotime($data["thirdDatePicked"]));
			$timeThird  = date("H:i", strtotime($data["thirdTimePicked"]));
		}
		
		if($data["promoCode"]=="")
		{
			$promoCode = null;
		}
		else
		{
			$promoCode = $data["promoCode"];
		}
		
		$data["service_quote_id"] = $this->generateServiceQuoteId();

		$insertData = array(
			"service_quote_id" => $data["service_quote_id"],
			"house_id" => $data["house_id"],
			"service_id" => $data["service_id"],
			"promo_id" => $promoCode,
			"footover_status" => $data["footOver"],
			"service_date1" => date("Y-m-d",strtotime($data["firstDatePicked"])),
			"service_time1" => date("H:i", strtotime($data["firstTimePicked"])),
			"service_date2" => $dateSecond,
			"service_time2" => $timeSecond,
			"service_date3" => $dateThird,
			"service_time3" => $timeThird,
			"service_quote_total" => $data["totalQuote"],
			"service_quote_discount" => $data["discountValue"],
			"service_quote_finaltotal" => $data["finalQuote"],
			"service_note" => $data["notes"],
			"customer_name" => $data['customer_name'],
			"service_name" => $data['service_name'],
			"user_email" => $data['user_email']
		);
		
		
		$this->db->insert("gbu_service_quote", $insertData);
	}		
	
	function getStateForAutoComplete($keyword)
	{
		$q = $this->db->query("SELECT * FROM gbu_state WHERE state_name LIKE '%".$keyword."%' ORDER BY state_name ASC LIMIT 5 ");
		return $q;
	}
	
	function getStateForAutoComplete2($city, $state)
	{
		$q = $this->db->query("SELECT * FROM gbu_city_state WHERE city_state='".$state."' and city_name LIKE '%".$city."%' ORDER BY city_name ASC LIMIT 5 ");
		return $q;
	}
	
	function getCompanyType()
	{
		$this->db->select("companytype_id, companytype_name");
		$this->db->from("gbu_company_type");
		return $this->db->get()->result();
	}
	
	function getState()
	{
		$this->db->select("state_id, state_name");
		$this->db->from("gbu_state");
		return $this->db->get()->result();
	}
	
	function getUserLastOrder($user_email)
	{
		
	}
	
	function getLatLng($house_id)
	{
		$this->db->select('h.house_latitude, h.house_longitude');
		$this->db->from('gbu_user_house h');
		$this->db->where('h.house_id',$house_id);
		$this->db->limit(1);
		
		$query = $this->db->get()->result();
		
		return $query;
	}

	function getServicePrice($service_id)
	{
		$qry = "SELECT service_price FROM gbu_service WHERE service_id='".$service_id."'";
		$query = $this->db->query($qry);
		$price = $query->result_array()[0]['service_price'];
		
		return $price;
	}
	
	function getAppliedProvider($user_email)
	{
		$qry = "SELECT sq.provider_id, sq.service_quote_id, sq.service_datetime, sq.date, sq.time, p.provider_company_name, p.provider_fastness, p.provider_cleaness, p.provider_ontime, p.provider_record
				FROM gbu_temp_applyservice sq, gbu_provider p, gbu_service_quote s
				WHERE sq.service_quote_id=s.service_quote_id AND s.user_email ='".$user_email."'
				AND p.provider_id=sq.provider_id ORDER BY apply_clock DESC";
		$query = $this->db->query($qry);
		$res = $query->result();
		
		return $res;
	}
	
	function getOnProgressList($user_email)
	{
		$qry = "SELECT service_quote_id, house_id, service_name, provider_id, 
				service_date_final, service_time_final, service_quote_finaltotal
				FROM gbu_service_quote
				WHERE user_email='".$user_email."' AND provider_id IS NOT NULL AND service_status='0' ";
		$query = $this->db->query($qry);
		$res = $query->result();
		
		return $res;
	}
			
	function getFinishedServiceListToRate($user_email)
	{
		$qry = "SELECT service_quote_id, house_id, service_name, provider_id, 
				service_date_final, service_time_final, service_quote_finaltotal
				FROM gbu_service_quote
				WHERE user_email='".$user_email."' AND provider_id IS NOT NULL AND service_status='1' AND service_rateprovider_status='0'  ";
		$query = $this->db->query($qry);
		$res = $query->result();
		
		return $res;
	}
	
	
	function getHouseAddressUsingHouseId($house_id)
	{
		$qry = "select house_address as alamat from gbu_user_house where house_id='".$house_id."'";
		$query = $this->db->query($qry);
		$price = $query->result_array()[0]['alamat'];
		
		return $price;
	}
	
	function getFinishedService($provider_id)
	{
		$qry = "SELECT service_quote_id, house_id, service_name, customer_name, 
				service_date_final, service_time_final, service_quote_finaltotal
				FROM gbu_service_quote
				WHERE provider_id='".$provider_id."' and service_status='1'";
		$query = $this->db->query($qry);
		$res = $query->result();
		
		return $res;
	}
	
	function getOnProgressListForProvider($provider_id)
	{
		$qry = "SELECT service_quote_id, house_id, service_name, customer_name, 
				service_date_final, service_time_final, service_quote_finaltotal
				FROM gbu_service_quote
				WHERE provider_id='".$provider_id."' and service_status='0'";
		$query = $this->db->query($qry);
		$res = $query->result();
		
		return $res;
	}
	
	function setProviderAndServiceDateTime($data)
	{
		$updateData = array(
			"provider_id" => $data["provider_id"],
			"service_date_final" => $data["service_date"],
			"service_time_final" => $data["service_time"]
		);
		$this->db->where("service_quote_id", $data["service_quote_id"]);
		$this->db->update("gbu_service_quote", $updateData);
	}
	
	function getProviderRecord($provider_id)
	{
		$qry = "SELECT provider_record as record FROM gbu_provider WHERE provider_id='".$provider_id."'";
		$query = $this->db->query($qry);
		$price = $query->result_array()[0]['record'];
	}
	
	function updateRecordProvider($data)
	{
		$record = $this->getProviderRecord($data["provider_id"]);
		$updateData = array(
			"provider_record" => ($record +1),
		);
		$this->db->where("provider_id", $data["provider_id"]);
		$this->db->update("gbu_provider", $updateData);
	}
	
	function updateStatusServiceQuote($data)
	{
		$updateData = array(
			"service_status" => '1',
		);
		$this->db->where("service_quote_id", $data["service_quote_id"]);
		$this->db->update("gbu_service_quote", $updateData);
	}
	
	function deleteServiceQuoteinTemp($service_quote_id)
	{
		$this->db->where("service_quote_id", $service_quote_id);
		$this->db->delete("gbu_temp_applyservice");
	}
	
	function cekAvailableToApply($data)
	{
		$qry = "SELECT COUNT(service_quote_id) as jumlah
				FROM gbu_service_quote
				WHERE service_quote_id='".$data["service_quote_id"]."' AND provider_id IS NULL";
		$query = $this->db->query($qry);
		$price = $query->result_array()[0]['jumlah'];
		
		return $price;
	}
	
	function getCustomerName($user_email)
	{
		$qry = "SELECT user_name FROM gbu_user WHERE user_email='".$user_email."'";
		$query = $this->db->query($qry);
		$price = $query->result_array()[0]['user_name'];
		
		return $price;
	}
	
	function getProviderName($provider_id)
	{
		$qry = "SELECT provider_company_name as name FROM gbu_provider WHERE provider_id='".$provider_id."'";
		$query = $this->db->query($qry);
		$price = $query->result_array()[0]['name'];
		
		return $price;
	}
	
	function getServiceNameInServiceCode($service_quote_id)
	{
		$qry = "SELECT sq.service_name FROM gbu_service_quote sq WHERE sq.service_quote_id='".$service_quote_id."'";
		$query = $this->db->query($qry);
		$name = $query->result_array()[0]['service_name'];
		
		return $name;
	}
	
	function getServiceName($service_id)
	{
		$qry = "SELECT service_name FROM gbu_service WHERE service_id='".$service_id."'";
		$query = $this->db->query($qry);
		$price = $query->result_array()[0]['service_name'];
		
		return $price;
	}
	
	function getPriceFromDriveWay($house_id)
	{
		$qry = "SELECT dl.dlength_price, ds.dshape_price, 
		dt.dtype_price, dw.dwidth_price
		FROM gbu_driveway_length dl, gbu_driveway_shape ds, 
		gbu_driveway_type dt, gbu_driveway_width dw, gbu_user_house uh
		WHERE uh.house_id='".$house_id."' AND dl.dlength_name=uh.house_drivewaylength AND ds.dshape_name=uh.house_drivewayshape
		AND dt.dtype_name=uh.house_drivewaytype AND dw.dwidth_name=uh.house_drivewaywidth";
	
		$query = $this->db->query($qry);
		$res= $query->result();
		
		return $res;
	}
	
	function getProviderDataForCustomer($service_quote_id)
	{
		$qry = "SELECT sq.provider_id, p.provider_company_name, p.provider_fastness, p.provider_cleaness, p.provider_ontime, p.provider_record
		FROM gbu_temp_applyservice sq, gbu_provider p
		WHERE sq.service_quote_id='".$service_quote_id."' AND 
		p.provider_id=sq.provider_id ORDER BY sq.service_datetime";
		
		$query = $this->db->query($qry);
		$res= $query->result();
		
		return $res;
	}
	
	function getPriceFromLawn($house_id)
	{
		$qry = "SELECT lh.lawn_price AS lawn_hilly_price, 
				lz.lawn_price AS lawn_size_price, gz.gate_price
				FROM gbu_lawn_hilly lh, gbu_lawn_size lz, 
				gbu_gate_size gz, gbu_user_house uh
				WHERE uh.house_id='".$house_id."' AND lh.lawn_hilly_name=uh.house_lawn_hilly
				AND lz.lawn_size=uh.house_lawn_size AND  gz.gate_size=uh.house_gate_size";
	
		$query = $this->db->query($qry);
		$res= $query->result();
		
		return $res;
	}
	
	function getAllColor()
	{
		return $this->db->get("gbu_color")->result();
	}
	
	function signup($data)
	{
		$data["user_id"] = $this->generateUserId();
		$insertData = array(
			"user_id" => $data["user_id"],
			"user_name" => $data["name"],
			"user_email" => $data["email"],
			"user_password" => $data["password"],
			"user_phonenumber" => $data["phonenumber"]
		);
		
		$this->db->insert("gbu_user", $insertData);
	}
	
	function cekEmailExist($email)
	{
		$this->db->where("user_email", $email);
		return $this->db->count_all_results("gbu_user");
	}
	
	function changePromoCodeStatus($promo_id)
	{
		$updateData = array(
			"promo_status" => '1'
		);
		$this->db->where("promo_id", $promo_id);
		$this->db->update("gbu_promo", $updateData);
	}
	
	function cekLoginFromDB($email, $password)
	{
		$this->db->where("user_email", $email);
		$this->db->where("user_password", $password);
		return $this->db->count_all_results("gbu_user");
	}
		
	function cekLoginAdmin($admin_id, $password)
	{
		$this->db->where("admin_id", $admin_id);
		$this->db->where("admin_password", $password);
		return $this->db->count_all_results("gbu_admin");
	}
	
	function cekLoginProvider($provider_email, $password)
	{
		$this->db->where("provider_email", $provider_email);
		$this->db->where("provider_password", $password);
		return $this->db->count_all_results("gbu_user_provider");
	}
		
}

?>