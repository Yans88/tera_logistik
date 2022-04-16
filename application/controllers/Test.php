<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);			
	}	
	
	function index($id=0){
		$post_data = 'id_shipping=8&shipping_name=Test%20dari%20local%20notepad%20by%20yansen&user=1&action=2';
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://202.169.43.190:8080/sailing/api/cms/formshipping',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => $post_data,
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/x-www-form-urlencoded',
			'Accept: application/json'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		echo $post_data;
		echo '<br/>';
		echo $response;
		// print_r($response);
	}
	
	function test_data(){
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://qr.mpm-rent.com/api/device/detail',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => array('id_device' => '1'),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		echo $response;
	}


}
