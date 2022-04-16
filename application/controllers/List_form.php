<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class List_form extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {	
		if(!$this->session->userdata('login')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Shipping';
		$this->data['judul_utama'] = 'Shipping';
		$this->data['judul_sub'] = 'List';
		
		$where = array();
		$where = array('deleted_at'=>null);		
		$this->data['master_form'] = $this->access->readtable('form_shipping','',$where)->result_array();
		$this->data['isi'] = $this->load->view('list_form/frm_shipping_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function m_frm($id_shipping=0) {	
		if(!$this->session->userdata('login')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Form';
		$this->data['judul_utama'] = 'Form';
		$this->data['judul_sub'] = 'List';
		
		$where = array();
		$where = array('deleted_at'=>null,'id_shipping'=>$id_shipping);	
		$this->data['master_shipping'] = $this->access->readtable('form_shipping','',$where)->row();		
		$this->data['master_form'] = $this->access->readtable('master_form','',$where)->result_array();
		$this->data['isi'] = $this->load->view('list_form/list_form_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function form_type($id_form = 0){
		if(!$this->session->userdata('login')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Form';
		$this->data['judul_utama'] = 'Form';
		$this->data['judul_sub'] = 'List';
		
		$where = array();
		$where = array('deleted_at'=>null,'id_form'=>$id_form);		
		$m_form = $this->access->readtable('master_form','',$where)->row();
		$where = array();
		$where = array('deleted_at'=>null,'id_shipping'=>$m_form->id_shipping);		
		$this->data['master_shipping'] = $this->access->readtable('form_shipping','',$where)->row();
		$where = array('deleted_at'=>null,'id_form'=>$id_form);			
		$this->data['master_form'] = $this->access->readtable('master_form_type','',$where)->result_array();
		$this->data['m_form'] = $m_form;
		$this->data['id'] = $id_form;
		$this->data['id_shipping'] = $m_form->id_shipping;
		$this->data['isi'] = $this->load->view('list_form/list_form_type', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function add($id_form=0,$input=0) {	
		if(!$this->session->userdata('login')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Form Input';
		$this->data['judul_utama'] = 'Form';
		$this->data['judul_sub'] = 'Input';
		$master_inputan = '';
		$where = array();
		if((int)$input > 0){
			$where = array('master_inputan.deleted_at'=>null,'master_inputan.id_input'=>$input);	
			$master_inputan = $this->access->readtable('master_inputan','',$where)->row();
			$dt_opt = $this->access->readtable('data_option','',array('deleted_at'=>null,'id_inputan'=>$input))->result_array();
		}
			
		$this->data['dt_opt'] = $dt_opt;
		$this->data['master_inputan'] = $master_inputan;
		$this->data['id_form'] = $id_form;
		$this->data['isi'] = $this->load->view('list_form/input_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function list_input($id_form=0) {	
		if(!$this->session->userdata('login')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Input';
		$this->data['judul_utama'] = 'Input';
		$this->data['judul_sub'] = 'List';		
		
		$_region = $this->access->readtable('master_form_type','',array('id'=>$id_form,'deleted_at'=>null))->row();
		
		$where = array();
		$where = array('deleted_at'=>null,'id_form'=>$_region->id_form);		
		$m_form = $this->access->readtable('master_form','',$where)->row();
		
		$where = array();
		$where = array('deleted_at'=>null,'id_shipping'=>$m_form->id_shipping);		
		$this->data['master_shipping'] = $this->access->readtable('form_shipping','',$where)->row();
		
		$where = array('master_inputan.deleted_at'=>null,'master_inputan.id_form'=>$id_form);		
		$this->data['region'] = $this->access->readtable('master_inputan','',$where)->result_array();
		
		$this->data['id_form'] = $id_form;
		$this->data['region_name'] = $_region->title;
		$this->data['m_form'] = $m_form;
		$this->data['id_shipping'] = $m_form->id_shipping;
		$this->data['isi'] = $this->load->view('list_form/list_inputan_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_form' 	=> $_POST['id']
			
		);
		$m_form = $this->access->readtable('master_form','',$where)->row();
		$data = array(
			'deleted_by'	=> $this->session->userdata('operator_id'),
			'deleted_at'	=> $tgl
		);
		$this->api_mform($m_form->id_shipping,$_POST['id'],urlencode($m_form->nama_form),$this->session->userdata('operator_id'),3);
		echo $this->access->updatetable('master_form', $data, $where);
	}
	
	public function del_shipping(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_shipping' 	=> $_POST['id']			
		);
		$form_shipping = $this->access->readtable('form_shipping','',$where)->row();
		$data = array(
			'deleted_by'	=> $this->session->userdata('operator_id'),
			'deleted_at'	=> $tgl
		);
		$this->api_shipping($_POST['id'],urlencode($form_shipping->$shipping_name),$this->session->userdata('operator_id'),3);
		echo $this->access->updatetable('form_shipping', $data, $where);
	}
	
	public function simpan_shipping(){
		$tgl = date('Y-m-d H:i:s');
		$id_form = isset($_POST['id_form']) ? (int)$_POST['id_form'] : 0;		
		$form_title = isset($_POST['form_title']) ? ucwords($_POST['form_title']) : '';		
		$simpan = array(			
			'shipping_name'		=> $form_title
		);
		
		$where = array();
		$save = 0;	
		$action = 0;	
		if($id_form > 0){
			$where = array('id_shipping'=>$id_form);
			$simpan += array('updated_by'=>$this->session->userdata('operator_id'));
			$this->access->updatetable('form_shipping', $simpan, $where);   
			$save = $id_form;   
			$action = 2;
		}else{
			$simpan += array('created_at' => $tgl,'created_by'	=> $this->session->userdata('operator_id'));
			$save = $this->access->inserttable('form_shipping', $simpan);
			$action = 1;
		} 
		
		$this->api_shipping($save,urlencode($form_title),$this->session->userdata('operator_id'),$action);
		echo $save;
	}
	
	public function simpan(){
		$tgl = date('Y-m-d H:i:s');
		$id_form = isset($_POST['id_form']) ? (int)$_POST['id_form'] : 0;		
		$id_shipping = isset($_POST['id_shipping']) ? (int)$_POST['id_shipping'] : 0;		
		$form_title = isset($_POST['form_title']) ? ucwords($_POST['form_title']) : '';		
		$simpan = array(			
			'nama_form'		=> $form_title
		);
		
		$where = array();
		$save = 0;	
		$action = 0;	
		if($id_form > 0){
			$where = array('id_form'=>$id_form);
			$simpan += array('updated_by'=>$this->session->userdata('operator_id'));
			$this->access->updatetable('master_form', $simpan, $where);   
			$save = $id_form;   
			$action = 2;
		}else{
			$simpan += array('id_shipping'=>$id_shipping,'created_at' => $tgl,'created_by'	=> $this->session->userdata('operator_id'));
			$save = $this->access->inserttable('master_form', $simpan);   
			$action = 1;
		}  
		$this->api_mform($id_shipping,$save,urlencode($form_title),$this->session->userdata('operator_id'),$action);
		echo $save;
	}
	
	public function simpan_type(){
		$tgl = date('Y-m-d H:i:s');
		$id_form = isset($_POST['id_form']) ? (int)$_POST['id_form'] : 0;		
		$id_type = isset($_POST['id_type']) ? (int)$_POST['id_type'] : 0;		
		$form_title = isset($_POST['form_title']) ? ucwords($_POST['form_title']) : '';		
		$form_code = isset($_POST['form_code']) ? $_POST['form_code'] : '';		
		$simpan = array(			
			'code'		=> $form_code,
			'title'		=> $form_title
		);
		
		$where = array();
		$save = 0;	
		$action = 0;	
		if($id_type > 0){
			$where = array('id'=>$id_type);
			$simpan += array('updated_by'=>$this->session->userdata('operator_id'));
			$this->access->updatetable('master_form_type', $simpan, $where);   
			$save = $id_type;
			$action = 2;
		}else{
			$simpan += array('id_form'=>$id_form,'created_at' => $tgl,'created_by'	=> $this->session->userdata('operator_id'));
			$save = $this->access->inserttable('master_form_type', $simpan);   
			$action = 1;
		}  
		$this->api_mformtype($save,$id_form,urlencode($form_code),urlencode($form_title),$this->session->userdata('operator_id'),$action);
		echo $save;
	}
	
	public function del_type(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id' 	=> $_POST['id']			
		);
		$form_type = $this->access->readtable('master_form_type','',$where)->row();
		$data = array(
			'deleted_by'	=> $this->session->userdata('operator_id'),
			'deleted_at'	=> $tgl
		);
		$this->api_mformtype($_POST['id'],$id_form,urlencode($form_type->code),urlencode($form_type->title),$this->session->userdata('operator_id'),3);
		echo $this->access->updatetable('master_form_type', $data, $where);
	}
	
	public function simpan_input(){
		$tgl = date('Y-m-d H:i:s');
		$id_form = isset($_POST['id_form']) ? (int)$_POST['id_form'] : 0;
		$id_input = isset($_POST['id_input']) ? (int)$_POST['id_input'] : 0;
		$title = isset($_POST['lbl']) ? $_POST['lbl'] : '';
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		$type = isset($_POST['tipe']) ? $_POST['tipe'] : '';
		$_opt = isset($_POST['opt']) ? $_POST['opt'] : '';
		$_id_opt = isset($_POST['id_opt']) ? $_POST['id_opt'] : 0;
		$_val = isset($_POST['val']) ? $_POST['val'] : '';
		$simpan = array();
		$simpan = array(			
			'title'		=> $title,
			'name'		=> $name,
			'type'		=> $type
		);
		$save = 0;
		$action = 0;
		$get_opt = '';
		if($id_input > 0){			
			$this->access->updatetable('data_option', array('deleted_at'=>$tgl,'deleted_by'=>$this->session->userdata('operator_id')), array('id_inputan'=>$id_input,'deleted_at'=>null));			
			$this->access->updatetable('master_inputan', $simpan, array('id_input'=>$id_input));
			$save = $id_input;
			$action = 2;
		}else{
			$simpan += array('id_form' => $id_form,'created_at' => $tgl,'created_by' => $this->session->userdata('operator_id'));
			$save = $this->access->inserttable('master_inputan', $simpan);
			$action = 1;
		}
		$this->api_inputan($save,$id_form,urlencode($name),urlencode($title),$type,$this->session->userdata('operator_id'),$action);
		$dt_upd = array();
		$dt_simpan = array();
		if(!empty($_opt) && $save > 0 && ($type == 'radio' || $type == 'checkbox' || $type == 'dropdown')){						
			for($i=0;$i<sizeof($_opt);$i++){
				$id_opt = 0;
				$opt = '';
				$val = '';
				$opt = $_opt[$i];
				$val = $_val[$i];
				
				$id_opt = (int)$_id_opt[$i];
				if($id_opt > 0){
					$dt_upd[] = array(
						'id_opt'		=> $id_opt,
						'title'			=> $opt,
						'value'			=> $val,
						'deleted_at'	=> null,
						'deleted_by'	=> null,
						'updated_by'	=> $this->session->userdata('operator_id')
					);					
				}else{
					$dt_simpan[] = array(
						'id_inputan'	=> $save,
						'title'			=> $opt,
						'value'			=> $val,
						'created_at' 	=> $tgl,
						'created_by'	=> $this->session->userdata('operator_id')
					);
				}
			}
		}
		
		if(!empty($dt_upd))$this->db->update_batch('data_option', $dt_upd,'id_opt');
		if(!empty($dt_simpan))$this->db->insert_batch('data_option', $dt_simpan);
		echo $save;
	}
	
	public function del_input(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_input' 	=> $_POST['id']			
		);
		$inputan = $this->access->readtable('master_inputan','',$where)->row();
		$data = array(
			'deleted_by'	=> $this->session->userdata('operator_id'),
			'deleted_at'	=> $tgl
		);
		$this->api_inputan($_POST['id'],$id_form,urlencode($inputan->name),urlencode($inputan->title),$type,$this->session->userdata('operator_id'),3);
		echo $this->access->updatetable('master_inputan', $data, $where);
	}
	
	function api_shipping($id_shipping=0,$shipping_name='',$user=0,$action=0){
		$curl = curl_init();
		$data_post = 'id_shipping='.$id_shipping.'&shipping_name='.$shipping_name.'&user='.$user.'&action='.$action;
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://202.169.43.190:8080/sailing/api/cms/formshipping',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => $data_post,
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/x-www-form-urlencoded',
			'Accept: application/json'
		  ),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		error_log('form_shipping');
		error_log('data_post : '.$data_post);
		error_log(serialize($response));
		// print_r($response);
	}
	
	function api_mform($id_shipping=0,$id_form=0,$nama_form='',$user=0,$action=0){
		$curl = curl_init();
		$data_post = 'id_shipping='.$id_shipping.'&id_form='.$id_form.'&nama_form='.$nama_form.'&user='.$user.'&action='.$action;
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://202.169.43.190:8080/sailing/api/cms/masterform',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => $data_post,
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/x-www-form-urlencoded',
			'Accept: application/json'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		error_log('master_form');
		error_log('data_post : '.$data_post);
		error_log(serialize($response));
		// print_r($response);
	}
	
	function api_mformtype($id=0,$id_form=0,$code='',$title='',$user=0,$action=0){
		$curl = curl_init();
		$data_post = 'id='.$id.'&id_form='.$id_form.'&code='.$code.'&title='.$title.'&user=23&action='.$action;
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://202.169.43.190:8080/sailing/api/cms/masterformtype',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => $data_post,
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/x-www-form-urlencoded',
			'Accept: application/json'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		error_log('masterformtype');
		error_log('data_post : '.$data_post);
		error_log(serialize($response));
		// print_r($response);
	}
	
	function api_inputan($id_input=0,$id_form=0,$name='',$title='',$type='',$user=0,$action=0){
		$curl = curl_init();
		$data_post = 'id_input='.$id_input.'&id_form='.$id_form.'&name='.$name.'&title='.$title.'&type='.$type.'&user='.$user.'&action='.$action;
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://202.169.43.190:8080/sailing/api/cms/masterinputan',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => $data_post,
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/x-www-form-urlencoded',
			'Accept: application/json'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		error_log('masterinputan');
		error_log('data_post : '.$data_post);
		error_log(serialize($response));
		// print_r($response);
	}
	
	function test($id=0){
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
		  CURLOPT_POSTFIELDS => 'id_shipping=8&shipping_name=Test%20dari%20local%20notepad%20by%20yansen&user=1&action=2',
		  CURLOPT_HTTPHEADER => array(
			'Content-Type: application/x-www-form-urlencoded',
			'Accept: application/json'
		  ),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		echo $response;
		print_r($response);
	}
	
	function test_login(){
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://qr.mpm-rent.com/api/user/login',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => array('username' => 'hari.muryanto','password' => 'p@ssw0rdr3nt'),
		  CURLOPT_HTTPHEADER => array(
			'Cookie: mpmApps_session=qbp9lkdkjsta30g31fqc7rq75ltd7pd9'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;
	}
	
	public function no_akses() {
		if ($this->session->userdata('login') == FALSE) {
			redirect('/');
			return false;
		}
		$this->data['judul_browser'] = 'Tidak Ada Akses';
		$this->data['judul_utama'] = 'Tidak Ada Akses';
		$this->data['judul_sub'] = '';
		$this->data['isi'] = '<br/><div class="alert alert-danger" style="margin-left:0;">Anda tidak memiliki Akses.</div><div class="error-page">
        <h3 class="text-red"><i class="fa fa-warning text-yellow"></i> Oops! No Akses.</h3></div>';
		$this->load->view('themes/layout_utama_v', $this->data);
	}


}
