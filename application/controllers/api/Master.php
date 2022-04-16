<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Master extends CI_Controller {

    function __construct(){        
        parent::__construct();	
		
		// $this->load->model('Api_m');	
		$this->load->model('Access','access',true);	
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
    }	
	
	function get_master_form(){
		$tgl = date('Y-m-d H:i:s');	
		$param = $this->input->post();
		$where = array();
		$where = array('deleted_at'=>null);		
		$master_form = $this->access->readtable('master_form',array('id_form','nama_form'),$where)->result_array();	
		$dt = array();
		if(!empty($master_form)){
			foreach($master_form as $mf=>$val){
				$dt[] = $val;
			}
		}
		if(!empty($dt)){
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> $dt
			];
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'Data not found',
				'data'		=>  null
			];
		}
		
		http_response_code(200);
		echo json_encode($result);
	}
	
	function get_form(){
		$tgl = date('Y-m-d H:i:s');	
		$param = $this->input->post();
		$where = array();
		$id_form = isset($param['id_form']) ? (int)$param['id_form'] : 0;
		$where = array('deleted_at'=>null,'id_form'=>$id_form);		
		$master_form = $this->access->readtable('master_form_type',array('id','id_form','title'),$where)->result_array();	
		$dt = array();
		if(!empty($master_form)){
			foreach($master_form as $mf=>$val){
				$dt[] = $val;
			}
		}
		if(!empty($dt)){
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> $dt
			];
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'Data not found',
				'data'		=>  null
			];
		}
		
		http_response_code(200);
		echo json_encode($result);
	}
	
	function get_inputan(){
		$tgl = date('Y-m-d H:i:s');	
		$param = $this->input->post();
		$id_form = isset($param['id']) ? (int)$param['id'] : 0;
		if($id_form <= 0){			
			$result = [
					'err_code'		=> '06',
					'err_msg'		=> 'id require'
				];
			http_response_code(200);
			echo json_encode($result);
			return false;
		}
				
		$master_form = $this->access->readtable('master_form_type',array('id','title'),array('deleted_at'=>null,'id'=>$id_form))->row();
		$where = array();
		$where = array('deleted_at'=>null,'id_form'=>$id_form);
		$master_input = $this->access->readtable('master_inputan',array('name','title','type','id_input'),$where)->result_array();	
		$dt = array();
		$res = array();
		
		if(!empty($master_input)){
			foreach($master_input as $mf){
				$id_input = 0;
				$id_input = (int)$mf['id_input'];
				$dt_opt = array();
				$dt_option = array();
				if($mf['type'] == 'radio' || $mf['type'] == 'checkbox' || $mf['type'] == 'dropdown'){
					$dt_opt = $this->access->readtable('data_option','',array('deleted_at'=>null,'id_inputan'=>$id_input))->result_array();
					if(!empty($dt_opt)){
						foreach($dt_opt as $do){
							$dt_option[] = array(
								'id_opt'	=> (int)$do['id_opt'],
								'title'		=> $do['title'],
								'value'	=> $do['value'],
							);
						}
					}
					
				}
				$dt_option = !empty($dt_option) ? $dt_option : null;
				$dt[] = array(
					'id_input'	=> $id_input,
					'title'		=> $mf['title'],
					'name'		=> $mf['name'],
					'type'		=> $mf['type'],
					'option' 	=> $dt_option,
				);
			}
		}		
		if(!empty($dt)){
			$res = array(
				'id'		=> $master_form->id,
				'title'		=> $master_form->title,
				'inputan'	=> $dt
			);
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> $res
			];
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'Data not found',
				'data'		=>  null
			];
		}
		
		http_response_code(200);
		echo json_encode($result);
	}
	
	function get_all(){
		$where = array();
		$where = array('deleted_at'=>null);		
		$master_shipping = $this->access->readtable('form_shipping',array('id_shipping','shipping_name'),$where)->result_array();			
		$master_form = $this->access->readtable('master_form',array('id_form','nama_form','id_shipping'),$where)->result_array();			
		$master_form_type = $this->access->readtable('master_form_type',array('id','id_form','code','title'), $where,'', '','title','ASC')->result_array();	
		$master_input = $this->access->readtable('master_inputan',array('name','title','type','id_input','id_form'),$where,,'', '','title','ASC')->result_array();	
		$dt = array();
		$dt_frm = array();
		$dt_type = array();
		$dt_inputan = array();
		if(!empty($master_input)){
			foreach($master_input as $mf){
				$id_input = 0;
				$id_input = (int)$mf['id_input'];
				$dt_opt = array();
				$dt_option = array();
				if($mf['type'] == 'radio' || $mf['type'] == 'checkbox' || $mf['type'] == 'dropdown'){
					$dt_opt = $this->access->readtable('data_option','',array('deleted_at'=>null,'id_inputan'=>$id_input))->result_array();
					if(!empty($dt_opt)){
						foreach($dt_opt as $do){
							$dt_option[] = array(
								'id_opt'	=> (int)$do['id_opt'],
								'title'		=> $do['title'],
								'value'	=> $do['value'],
							);
						}
					}
					
				}
				$dt_option = !empty($dt_option) ? $dt_option : null;
				$dt_inputan[$mf['id_form']][] = array(
					'id_input'	=> $id_input,
					'id_type'	=> $mf['id_form'],
					'title'		=> $mf['title'],
					'name'		=> $mf['name'],
					'type'		=> $mf['type'],
					'option' 	=> $dt_option,
				);
			}
		}		
		if(!empty($master_form_type)){
			foreach($master_form_type as $mft){
				$dt_type[$mft['id_form']][] = array(
					'id'		=> $mft['id'],
					'id_form'	=> $mft['id_form'],
					'code'		=> $mft['code'],
					'title'		=> $mft['title'],
					'inputan'	=> $dt_inputan[$mft['id']],
				);
			}
		}
		if(!empty($master_form)){
			foreach($master_form as $mf){
				$dt_frm[$mf['id_shipping']][] = array(
					'id_form'		=> $mf['id_form'],
					'nama_form'	=> $mf['nama_form'],					
					'form_type'	=> $dt_type[$mf['id_form']],
				);
			}
		}
		if(!empty($master_shipping)){
			foreach($master_shipping as $ms){
				$dt[] = array(
					'id_shipping'	=> $ms['id_shipping'],
					'shipping_name'	=> $ms['shipping_name'],
					'forms'			=> $dt_frm[$ms['id_shipping']]
				);
			}
		}
		if(!empty($dt)){
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> $dt
			];
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'Data not found',
				'data'		=>  null
			];
		}
		
		http_response_code(200);
		echo json_encode($result);
	}
	
}
