<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Member extends CI_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Access','access',true);
		$this->load->model('Setting_m','sm', true);
		$this->load->library('converter');
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
    }
	
	//SELECT * FROM `chat_detail` WHERE (id_member_to = 2 or id_member_from = 2) AND (id_member_to = 1 or id_member_from = 1)
	
	function list_chat(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$user_code = isset($param['user_code']) ? $param['user_code'] : '';
		$spk_no = isset($param['spk_no']) ? $param['spk_no'] : '';
		
		$sql = 'SELECT master_chat.* FROM `master_chat` WHERE spk_no="'.$spk_no.'" and (user_code_to = "'.$user_code.'" or user_code_from = "'.$user_code.'") AND (user_code_from = "'.$user_code.'" or user_code_to = "'.$user_code.'") order by master_chat.updated_at DESC';
		$dt = $this->db->query($sql)->result_array();		
		$_res = array();
		$result = array();
		$id_cust = array();
		$_id_member = '';
		if(!empty($dt)){
			
			foreach($dt as $_d){
				if($_d['user_code_from'] == $user_code){
					$cnt_unread = $_d['status_from'];
				}
				
				if($_d['user_code_to'] == $user_code){
					$cnt_unread = $_d['status_to'];
				}	
				$_res[] = array(
					'id_chat'			=> $_d['id_chat'],
					'spk_no'			=> $_d['spk_no'],
					'user_code_from'	=> $_d['user_code_from'],
					'nama_from'			=> $_d['user_name'],
					'user_code_to'		=> $_d['user_code_to'],
					'nama_to'			=> $_d['user_name_to'],					
					'pesan'				=> $_d['pesan'],
					// 'cnt_unread'		=> (int)$cnt_unread,
					// 'status_from'		=> $_d['status_from'],
					// 'status_to'			=> $_d['status_to'],
					'updated_at'		=> $_d['updated_at']
				);
			}
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> $_res
			];
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'Data not found'
			];
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function send_chat(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_chat = isset($param['id_chat']) ? (int)$param['id_chat'] : 0;
		$spk_no = isset($param['spk_no']) ? $param['spk_no'] : '';
		$user_code = isset($param['user_code']) ? $param['user_code'] : '';
		$user_code_to = isset($param['user_code_to']) ? $param['user_code_to'] : '';
		$user_name = isset($param['user_name']) ? $param['user_name'] : '';
		$user_name_to = isset($param['user_name_to']) ? $param['user_name_to'] : '';
		$pesan = isset($param['pesan']) ? $param['pesan'] : '';
		$token_fcm_to = isset($param['token_fcm_to']) ? $param['token_fcm_to'] : '';
		
		$status_from = 1;
		$status_to = 1;
		$save = 0;
		$dt_upd = array();
		if($id_chat > 0){
			$dt = $this->access->readtable('master_chat','',array('id_chat' => $id_chat))->row();
			$status_from = (int)$dt->status_from + $status_from;
			$status_to = (int)$dt->status_to + $status_to;
			$user_code_from = (int)$dt->user_code_from;
			$_user_code_to = (int)$dt->user_code;
			if($user_code_from == $user_code){
				$dt_upd = array('status_to' => $status_to);
			}			
			if($_user_code_to == $user_code){
				$dt_upd = array('status_from' => $status_from);
			}
			$dt_upd += array(
				'pesan'			=> $pesan,
			);
			$this->access->updatetable('master_chat',$dt_upd, array("id_chat" => $id_chat));
			$save = $id_chat;
		}else{
			$dt_upd = array();
			$dt_upd = array(
				'spk_no'			=> $spk_no,
				'user_code_from'	=> $user_code,
				'user_code_to'		=> $user_code_to,
				'user_name'			=> $user_name,
				'user_name_to'		=> $user_name_to,
				'pesan'				=> $pesan,
				// 'status_to' 		=> $status_to,
				'created_at'		=> $tgl
			);
			$save = $this->access->inserttable('master_chat', $dt_upd);
		}
		$dt_res = array();
		$result = array();
		$ids = array();
		$notif_fcm = array();
		if((int)$save > 0){			
			$data_save = array();
			$data_save = array(
				'id_chat'			=> $save,
				'user_code_from'	=> $user_code,
				'user_code_to'		=> $user_code_to,
				'user_name_from'	=> $user_name,
				'user_name_to'		=> $user_name_to,
				'pesan'				=> $pesan,
				'fcm_token_to'		=> $token_fcm_to,
				// 'status_from'		=> 0,
				// 'status_to'			=> 1,
				'created_at'		=> $tgl,
				'created_by'		=> $user_code
			);
			$this->access->inserttable('chat_detail', $data_save);
			
			$data_fcm = array();
			$notif_fcm = array();						
			$this->load->library('send_notif');			
			$send_fcm = '';			
			$sort = array('abs(id)','ASC');
			$dt_chat = $this->access->readtable('chat_detail','',array('id_chat' => $save),'','',$sort)->result_array();
			$id_cust = array();
			$_id_member = '';
			if(!empty($dt_chat)){				
				$ids = array($token_fcm_to);
				$data_fcm = array(
					'id'					=> $save,
					'user_code_pengirim'	=> $user_code,
					'user_code_to'			=> $user_code_to,
					'nama_pengirim'			=> $user_name,					
					'title'					=> 'Tera Logistik',
					'type'					=> 1				
				);
				$notif_fcm = array(
					'title'		=> 'Tera Logistik',
					'body'		=> $pesan,
					'badge'		=> 1,
					'sound'		=> 'Default'
				);
				// error_log(serialize($ids));
				if(!empty($ids)) $send_fcm = $this->send_notif->send_fcm($data_fcm, $notif_fcm, $ids);				
				// error_log(serialize($send_fcm));
				foreach($dt_chat as $dc){
					$status_to = 0;
					if($user_code == $dc['user_code_to']){
						$status_to = $dc['status_to'];
					}
					$dt_res[] = array(
						'id_chat'			=> $dc['id_chat'],
						'id_chat_detail'	=> $dc['id'],
						'user_code_from'	=> $dc['user_code_from'],
						'user_name_from'	=> $dc['user_name_from'],						
						'user_code_to'		=> $dc['user_code_to'],						
						'user_name_to'		=> $dc['user_name_to'],						
						'pesan'				=> $dc['pesan'],
						// 'status'			=> $status_to,
						'created_at'		=> $dc['created_at'],
						'created_by'		=> $dc['created_by']
					);
				}
				$result = [
					'err_code'	=> '00',
					'err_msg'	=> 'ok',
					'data'		=> $dt_res
				];
			}else{
				$result = [
					'err_code'	=> '04',
					'err_msg'	=> 'Data not found'
				];
			}			
		}else{
			$result = [
				'err_code'	=> '05',
				'err_msg'	=> 'Insert has problem'
			];
		}
		
		http_response_code(200);
		echo json_encode($result);
	}
	
	function chat_detail(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$id_chat = isset($param['id_chat']) ? (int)$param['id_chat'] : 0;
		$user_code = isset($param['user_code']) ? (int)$param['user_code'] : 0;
		
		$this->access->updatetable('chat_detail',array('status_to'=>0), array("id_chat" => $id_chat,'user_code_to'=>$user_code));
		$dt = $this->access->readtable('master_chat','',array('id_chat' => $id_chat))->row();			
		$user_code_from = (int)$dt->user_code_from;
		$_user_code_to = (int)$dt->user_code_to;
		if($user_code_from == $user_code){
			$dt_upd = array('status_from' => 0);
		}
			
		if($_user_code_to == $user_code){
			$dt_upd = array('status_to' => 0);
		}
		$this->access->updatetable('master_chat',$dt_upd, array("id_chat" => $id_chat));
		
		$sort = array('abs(id)','ASC');
		$dt_chat = $this->access->readtable('chat_detail','',array('id_chat' => $id_chat),'','',$sort)->result_array();
		$id_cust = array();
		$result = array();
		$_id_member = '';
		if(!empty($dt_chat)){
			
			foreach($dt_chat as $dc){
				$status_to = 0;
				if($user_code_from == $dc['id_member_to']){
					$status_to = $dc['status_to'];
				}
				$dt_res[] = array(
					'id_chat'			=> $dc['id_chat'],
					'id_chat_detail'	=> $dc['id'],
					'user_code_from'	=> $dc['user_code_from'],
					'user_name_from'	=> $dc['user_name_from'],						
					'user_code_to'		=> $dc['user_code_to'],						
					'user_name_to'		=> $dc['user_name_to'],						
					'pesan'				=> $dc['pesan'],
					// 'status'			=> $status_to,
					'created_at'		=> $dc['created_at'],
					'created_by'		=> $dc['created_by']
				);
			}
			
			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> $dt_res
			];
		}else{
			$result = [
				'err_code'	=> '04',
				'err_msg'	=> 'Data not found'
			];
		}
		http_response_code(200);
		echo json_encode($result);
	}
	
	function send_pushnotif(){
		$tgl = date('Y-m-d H:i:s');
		$param = $this->input->post();
		$token_fcm_to = isset($param['token_fcm_to']) ? $param['token_fcm_to'] : '';
		$pesan = isset($param['pesan']) ? $param['pesan'] : '';
		// $type = isset($param['type']) ? $param['type'] : '';
		// $id = isset($param['id']) ? $param['id'] : '';
		$title = isset($param['title']) && !empty($param['title']) ? $param['title'] : 'Tera Logistik';
		$data_fcm = array();		
		foreach($param as $key=>$val){
			$data_fcm += array($key=>$val);		
		}
		unset($data_fcm['token_fcm_to']);
		unset($data_fcm['pesan']);
		
		$notif_fcm = array(
			'title'		=> $title,
			'body'		=> $pesan,
			'badge'		=> 1,
			'sound'		=> 'Default'
		);
		$this->load->library('send_notif');	
		$ids = array($token_fcm_to);
		$send_fcm = null;
		if(!empty($ids)) $send_fcm = $this->send_notif->send_fcm($data_fcm, $notif_fcm, $ids);	
		$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'ok',
				'data'		=> $send_fcm,
				'data_fcm'	=> $data_fcm,
				'token_fcm'	=> $token_fcm_to
			];
		http_response_code(200);
		echo json_encode($result);
	}
	
	
	function insert_inbox($id_member=0, $pesan = '', $type=0, $_id=0){
		$tgl = date('Y-m-d H:i:s');
		$dt = array(
			'id_member_from'	=> $id_member,
			'id_member_to'		=> $id_member,
			'pesan'				=> $pesan,
			'status_from'		=> 1,
			'status_to'			=> 1,
			'type'				=> $type,
			'_id'				=> $_id,
			'created_at'		=> $tgl,
		);
		$this->access->inserttable('master_chat', $dt);
	}
	
	
	
}
