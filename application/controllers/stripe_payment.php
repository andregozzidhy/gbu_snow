<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Stripe\Stripe;
use \Stripe\Charge;
use \Stripe\Customer;

class stripe_payment extends CI_Controller {

	public function __construct(){
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
	
	public function index()
	{
		
	}
	
	public function checkout()
	{
		$tokenraw = $_POST['stripeToken'];
		$token = str_replace("%40","@",$tokenraw);
		try{
			require_once('vendor/autoload.php');
			Stripe::setApiKey('sk_test_cbHpsgVxaWkJh0YsZl1XCyFF');
			
			$charge = Charge::create(
				array(
				 "amount" => 1000,
				  "currency" => "usd",
				  "description" => "Example charge",
				  "source" => $token
			));
			
			//-----------GET DATA FROM SUMMARY PAGE---------
			if($this->input->post('hiddenParameter')=='1')
			{
				$data['discountValue'] = $this->input->post('discountValue');
				$data['totalQuote'] = $this->input->post('totalQuote');
				$data['finalQuote'] = $this->input->post('finalValue');
				$data['promoCode'] = $this->input->post('hiddenPromoCode');
			}
			else
			{
				$data['discountValue'] = '0';
				$data['totalQuote'] = $this->input->post('totalQuote');
				$data['finalQuote'] = $data['totalQuote'];
				$data['promoCode'] = '';
			}
				
				$this->session->set_userdata('totalQuote',$data['totalQuote']);
				$this->session->set_userdata('discountValue',$data['discountValue']);
				$this->session->set_userdata('finalQuote',$data['finalQuote']);
				$this->session->set_userdata('promoCode',$data['promoCode']);
			//---------------------------------------
			redirect('gbusnow_controller/payment', 'refresh');
		}
		catch(\Stripe\Error\Card $e)
		{
			$error = $e->getMessage();
			echo $error;
		}
		
	}
}
