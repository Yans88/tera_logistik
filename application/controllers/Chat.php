<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
	}	
	
	public function index() {
		if(!$this->session->userdata('login')){
			$this->no_akses();
			return false;
		}
		$this->data['judul_browser'] = 'Chat';
		$this->data['judul_utama'] = 'List';
		$this->data['judul_sub'] = 'Chat';
		$this->data['title_box'] = 'List of users';
		$this->data['level'] = '';		
		
		$this->data['master_chat'] = $this->access->readtable('master_chat')->result_array();			
		$this->data['isi'] = $this->load->view('chat_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function chat_detail($id_chat=0){
		$this->data['judul_browser'] = 'Detail Chat';
		
		$this->data['judul_sub'] = 'Detail Chat';
		$sort = array('ABS(id)','DESC');
		$master_chat = $this->access->readtable('master_chat','',array('id_chat'=>$id_chat))->row();
		$this->data['judul_utama'] = $master_chat->spk_no;
		$this->data['master_chat'] = $master_chat;
		
		$this->data['chat_detail'] = $this->access->readtable('chat_detail','',array('id_chat'=>$id_chat),'','',$sort)->result_array();
		$this->data['isi'] = $this->load->view('chat_detail', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function export_chat(){
		$id_chat = isset($_POST['id_chat']) ? (int)$_POST['id_chat'] : 0;
		$master_chat = $this->access->readtable('master_chat','',array('id_chat'=>$id_chat))->row();
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		
		$this->excel->getActiveSheet()->setShowGridlines(false);
		$this->excel->getActiveSheet()->setTitle('Data Detail');		
		$this->excel->getActiveSheet()->setCellValue('A1', 'Data Chat - '.$master_chat->spk_no);		
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);		
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->excel->getActiveSheet()->mergeCells('A1:E1');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		
	
		$this->excel->getActiveSheet()->getStyle('A2:E2')->getFont()->setSize(10);				
		$this->excel->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);			
		$this->excel->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
		$styleArray = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);				 																		
		$this->excel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($styleArray);
		$this->excel->getActiveSheet()->setCellValue('A2', 'No.');
		$this->excel->getActiveSheet()->setCellValue('B2', 'Chat From');
        $this->excel->getActiveSheet()->setCellValue('C2', 'Chat To');
		$this->excel->getActiveSheet()->setCellValue('D2', 'Message');
        $this->excel->getActiveSheet()->setCellValue('E2', 'Created Date');       
        
		$this->excel->getActiveSheet()->getStyle('A2:E2')->getFill()
					->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
					->getStartColor()->setARGB('FFE8E5E5');
		
		$this->excel->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sort = array('ABS(id)','DESC');
		$chat_detail = $this->access->readtable('chat_detail','',array('id_chat'=>$id_chat),'','',$sort)->result_array();
		$i=3;
		$no = 1;
		if(!empty($chat_detail)){
			foreach($chat_detail as $row){				
				$this->excel->getActiveSheet()->setCellValue('A'.$i, $no++.'.');
				$this->excel->getActiveSheet()->setCellValue('B'.$i, $row['user_name_from']);
				$this->excel->getActiveSheet()->setCellValue('C'.$i, $row['user_name_to']);
				$this->excel->getActiveSheet()->setCellValue('D'.$i, $row['pesan']);
				$this->excel->getActiveSheet()->setCellValue('E'.$i, date('Y-m-d H:i', strtotime($row['created_at'])));				
				
				$this->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->applyFromArray($styleArray);
				$this->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->getFont()->setSize(10);
				$this->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->getAlignment()->setWrapText(true);
				$this->excel->getActiveSheet()->getStyle('B'.$i.':E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);			
				$this->excel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		
				
				$i++;
			}
			unset($styleArray);	
		}
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		
		$filename ='data_chat_'.$master_chat->spk_no.'.xls';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"'); 
		header('Cache-Control: max-age=0'); 					 
		
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  		
		$objWriter->save('php://output');
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
