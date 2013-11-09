<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sticky_notes extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
		
		
		$this->load->helper('auth');
		
		is_logged_in();
		
		
	
		$this->load->model('sticky_notes_model');
		
		

		
	}
	
	/**
	*
	* @since 2.10
	*
	*/
	public function index()
	{
		
		$data = array();
		
		 

		$site_settings = $this->site_settings_model->get_settings();
		
		// need to setup a theme picker here
		
		$data['data'] = $data; // Alice in Wonderland shit here!
		
		
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
		
	}


	
	
	/**
	*
	*
	*/
	public function showreport(){
		
		
		$data['report_data'] = $this->sticky_notes_model->generate_report_data();
		
		echo $this->load->view("report", $data, TRUE);
			
		
	}



	public function report_to_pdf(){
		
		$this->load->library("mypdf");
		
		// create new PDF document
		$pdf = new mypdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator("PageShaper");
		$pdf->SetAuthor('PageShaper');
		$pdf->SetTitle('Sticky Notes Report');
		$pdf->SetSubject('Records');
		$pdf->SetKeywords('Sticky Notes, Records');
		
		// set default header data
		$headerlogo = "../../../../.." . ASSETURL . PROJECTNAME . "/default/custom_modules/sticky_notes/img/postit_pulldown.png";
			

		$headertitle = "Sticky Notes Report";
		$header_string = "All the stuff that need fixing!";
				
		
		$pdf->SetHeaderData($headerlogo, PDF_HEADER_LOGO_WIDTH, $headertitle, $header_string);
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		//set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		$pdf->AddPage();
		
		$data['report_data'] = $this->sticky_notes_model->generate_report_data();
		
		$html = $this->load->view("pdf_report", $data, TRUE);

		$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->Output('sticky_report.pdf', 'I');

	}
	
	
	

	
	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){

		$this->load->library('widget_utils');
		

		$data['dbprefix'] = $this->db->dbprefix;
		
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);
		
		include(dirname(dirname(__FILE__)) . "/install/install.php");
		
		// this widget should never be inserted directly into a page
		//$this->widget_utils->register_widget("sticky_notes","sticky_notes");
		
		
	}	
	
	
	/**
	* remove the module
	*	 
	*/
	public function uninstall(){
		
		
		//$this->widget_utils->un_register_widget("sticky_notes","sticky_notes");
		
		
	}
	
	
}