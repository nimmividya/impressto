<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


// this shit needs to go to the config file.
define('DIR_ROOT',		$_SERVER['DOCUMENT_ROOT']);
define('DIR_IMAGES',	ASSETURL . 'upload');
//Width and height of resized image
define('WIDTH_TO_LINK', 500);
define('HEIGHT_TO_LINK', 500);
//Additional attributes class and rel
define('CLASS_LINK', 'lightview');
define('REL_LINK', 'lightbox');



class image_manager extends PSAdmin_Controller {

	public function __construct(){
		
		parent::__construct();
		
		$this->load->helper('auth');
		is_logged_in();
		
		
	}
	
	
	/**
	* default page - blank in this case
	*
	*/
	public function index(){

			
		$data = array();

		$this->load->library('asset_loader');

		// holy shit look at all this crap!!!
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/core_modules/image_manager/css/fileManagerTool.css");
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/core_modules/image_manager/css/gh-buttons.css");
		$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/core_modules/image_manager/css/jquery.Jcrop.css");

		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/image_manager/js/jquery.purr.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/image_manager/js/jquery.form.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/image_manager/js/jquery.MultiFile.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/image_manager/js/image_manager.js");
		$this->asset_loader->add_header_js(vendor/jquery/plugins/jquery.Jcrop.js");
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/image_manager/js/tmpl.min.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/image_manager/js/load-image.min.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/image_manager/js/canvas-to-blob.min.js");
		
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/image_manager/js/jquery.iframe-transport.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/image_manager/js/jquery.fileupload.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/image_manager/js/jquery.fileupload-fp.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/image_manager/js/jquery.fileupload-ui.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/image_manager/js/locale.js");
		$this->asset_loader->add_header_js(ASSETURL . PROJECTNAME . "/core_modules/image_manager/js/fileUploadProcess.js");

	
		
		$this->load->helper("im_helper");
		
		$data['infobar_help_section'] = getinfobarcontent('IMAGEMANAGERHELP');
		
		$data['infobar'] = $this->load->view("themes/" .$this->config->item('admin_theme') . '/admin/infobar', $data, true);

		
		//$data['data'] = $data; // Alice in Wonderland shit here!
		
		
		// now barf it all out into the main core wrapper
		//$content = $this->load->view('index', $data, TRUE);
		
		
		

		
		$data['main_content'] = 'image_manager';
		
		//$site_settings = $this->site_settings_model->get_settings();
		
		
		
		$data['data'] = $data; // Alice in Wonderland shit here!
		
		
		// now barf it all out into the main core wrapper
		$this->load->view('themes/' .$this->config->item('admin_theme') . '/admin/includes/core_wrapper', $data);	
		
		
		
		
		
	}	
	
	public function process(){
		
		$this->load->library('fileselectortool');
		
		$this->fileselectortool->process();
		
		
	}
	
	
	
	public function crop_image(){
		
		
		$this->load->library('uploadhandler');
		

		$targ_w = $_POST['w'];
		$targ_h = $_POST['h'];
		$targ_x = $_POST['x'];
		$targ_y = $_POST['y'];
		$jpeg_quality = 95;
		$src = explode('?',$_POST['imgSrcProcess']);
		$src = getenv("DOCUMENT_ROOT") . $src[0];

		$ext = pathinfo($src, PATHINFO_EXTENSION);

		$image_info = getimagesize($src);
		$image_type = $image_info[2];

		if($_POST['mode']!='resize')
		$dst_r = imagecreatetruecolor( $targ_w, $targ_h);
		else
		$dst_r = imagecreatetruecolor( $targ_x, $targ_y);



		switch($image_type) {

		case 3: // PNG
			@imagealphablending($dst_r, false);
			@imagesavealpha($dst_r, true);  
			$img_r = @ImageCreateFromPng($src);
			break;

		case 2: // JPEG
			$img_r = @ImageCreateFromJpeg($src);
			break;

		case 1: // GIF
			@imagecolortransparent($dst_r, @imagecolorallocate($dst_r, 0, 0, 0));
			$img_r = @ImageCreateFromGif($src);
			break;

		default:
			$img_r = @ImageCreateFromJpeg($src);
			break;

		}

		switch($_POST['mode']) {

		case 'crop':
			imagecopyresampled($dst_r,$img_r,0,0,$targ_x,$targ_y,$targ_w,$targ_h,$targ_w,$targ_h);
			break;

		case 'resize':
			imagecopyresized( $dst_r, $img_r, 0, 0, 0, 0, $targ_x, $targ_y, $targ_w, $targ_h );
			break;

		case 'flipH':
			imagecopyresampled($dst_r, $img_r, 0, 0, ($targ_w-3), 0, ($targ_w+1), ($targ_h+1), 0-$targ_w+1, $targ_h);
			break;

		case 'flipV':
			imagecopyresampled($dst_r, $img_r, 0, 0, 0, ($targ_h-1), $targ_w, $targ_h, $targ_w, 0-$targ_h);
			break;

		case 'rotateImg':
			$dst_r = imagerotate($img_r, 90, 0);
			break;

		}


		switch($image_type) {

		case 3:
			imagesavealpha($dst_r, TRUE);
			imagepng($dst_r,$src);
			break;

		case 2:
			imagejpeg($dst_r,$src,$jpeg_quality);
			break;

		case 1:
			imagegif($dst_r,$src);
			break;

		default:
			imagejpeg($dst_r,$src,$jpeg_quality);
			break;

		}

		// re-creating scaled image to show it in gallery
		$this->uploadhandler->create_scaled_image($src, null, 1, null);

		@imagedestroy($dst_r);
		@imagedestroy($img_r);
		
		
		
	}
	
	public function uploadhandler(){
		
		
		header('Pragma: no-cache');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
		header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

		
		$this->load->library('uploadhandler');
		
		switch ($_SERVER['REQUEST_METHOD']) {
		case 'OPTIONS':
			break;
		case 'HEAD':
		case 'GET':
			$this->uploadhandler->get();
			break;
		case 'POST':
			if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
				$this->uploadhandler->delete();
			} else {
			
				//$this->load->library('logging');
				// set path and name of log file (optional)
				//$this->logging->lfile(getenv("DOCUMENT_ROOT") . "/mylog.txt");
				// write message to the log file
				//$this->logging->lwrite(print_r($_POST, TRUE));
				// close log file
				///$this->logging->lclose();
		
				$this->uploadhandler->post();
				
			}
			break;
		case 'DELETE':
			$this->uploadhandler->delete();
			break;
		default:
			header('HTTP/1.1 405 Method Not Allowed');
		}

		
		
	}
	
	/**
	* setup this module for the first time
	*	 
	*/
	public function install(){

		$this->load->library('module_installer');
		
		$data['dbprefix'] = $this->db->dbprefix;
		
		
		$this->module_installer->process_file(dirname(dirname(__FILE__)) . "/install/mydata.sql",$data);


		
	}
	

} //end class