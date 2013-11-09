<?php

class bgposslider extends CI_Model{




		

/**
* return infpo for the edit fields
* 
*/
function return_editinfo($id){

	$sql = "SELECT * FROM ps_bgslider WHERE id = '{$id}'";
			
	$result = mysql_query($sql);
	
	while($row = mysql_fetch_assoc($result)){
	
	
		$data = array(
		
			'id'=>$row['id'],
			'title'=>$row['title'],
			'content'=>$row['content'],
			'leftpos'=>$row['leftpos']
			
		);
		
		echo json_encode($data);
			
	
	}

}


/**
* 
*
*/
function getDistinctWidgetNames(){

	$sql = "SELECT DISTINCT widget_name FROM ps_bgslider";
				
	$result = mysql_query($sql);
	
	$widget_names = array();
	
	
	while($row = mysql_fetch_assoc($result)){
		
		$widget_names[] = $row['widget_name'];
			
	}
	
	return $widget_names;
	

}///////////




function doajaxfileupload(){
			
	global $_FILES, $thumbwidthheight;
	
	// this is not actually an AJAX call so we must turn the profiles off manually
	$this->config->set_item('debug_profiling',FALSE);
	$this->output->enable_profiler(FALSE);
		
				
	$error = "";
	$msg = "";
	$fileElementName = 'fileToUpload';
	if(!empty($_FILES[$fileElementName]['error']))
	{
		switch($_FILES[$fileElementName]['error'])
		{

			case '1':
				$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				break;
			case '2':
				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;
			case '3':
				$error = 'The uploaded file was only partially uploaded';
				break;
			case '4':
				$error = 'No file was uploaded.';
				break;

			case '6':
				$error = 'Missing a temporary folder';
				break;
			case '7':
				$error = 'Failed to write file to disk';
				break;
			case '8':
				$error = 'File upload stopped by extension';
				break;
			case '999':
			default:
				$error = 'No error code avaiable';
		}
	}elseif(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
	{
		$error = 'No file was uploaded..';
	}else 
	{
			$msg .= " File Name: " . $_FILES['fileToUpload']['name'] . ", ";
			$msg .= " File Size: " . @filesize($_FILES['fileToUpload']['tmp_name']);
			//for security reason, we force to remove all uploaded file
			//@unlink($_FILES['fileToUpload']);	
			move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],"./images/" . $_FILES["fileToUpload"]["name"]);
			
	
			// now resize this thing
			// *** Include the class
			include($_SERVER['DOCUMENT_ROOT'] . "/application/libraries/img_resize.php");
			
			// *** 1) Initialise / load image
			$resizeObj = new img_resize("./images/" . $_FILES["fileToUpload"]["name"]);
			
			// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
			$resizeObj -> resizeImage($thumbwidthheight, $thumbwidthheight, 'crop');
			
			// *** 3) Save image
			$resizeObj -> saveImage("images/thumbs/" . $_FILES["fileToUpload"]["name"], 100);

			
						
 
	}		
	echo "{";
	echo				"error: '" . $error . "',\n";
	echo				"msg: '" . $msg . "',\n";
	echo				"thumbname: '" . $_FILES["fileToUpload"]["name"] . "'\n";
	
	echo "}";


}





function savecrop(){

	global $thumbwidthheight;
	
	
	$targ_w = $targ_h = $thumbwidthheight;
	$jpeg_quality = 90;
	
	//$targ_w = $_GET['w'];
	//$targ_h = $_GET['h'];
		
	$src = './' . $_GET['image'];
	$img_r = imagecreatefromjpeg("./images/" . $src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_GET['x'],$_GET['y'],
	$targ_w,$targ_h,$_GET['w'],$_GET['h']);

	//header('Content-type: image/jpeg');
	
	imagejpeg($dst_r,"./images/thumbs/" . $_GET['image'],$jpeg_quality);
		
	echo "done";
}


/**
* insert a new set of widget rows into the table
*
*/
function createnewwidget($widget_name){

		$sql = "SELECT * FROM `ps_bgslider` WHERE widget_name = '{$widget_name}'";
					
		$query = $this->db->query($sql);
	
		if ($query->num_rows() == 0){
		
			for($i=0; $i < 4; $i++){
				$sql = "INSERT INTO `ps_bgslider` (title, widget_name, content, leftpos) values ('slide{$i}','{$widget_name}','sample','0');";
				//echo $sql;
				$this->db->query($sql);
			}
		}
						
	


}





/**
* save this record to the database
*
*/
function return_save(){

	$sql = "UPDATE {$this->db->dbprefix}bgslider SET ";
	
	$sql .= "title = '{$_POST['s_title']}',";
	$sql .= "content = '" . addslashes($_POST['s_content']) . "',";
	$sql .= "leftpos = '{$_POST['s_leftpos']}'";
	
	$sql .= " WHERE id = '{$_GET['id']}'";
			
	mysql_query($sql);
	
	echo "saved";
	
	

}

/**
* delete record
*
*/
function return_delete($id){

	$sql = "DELETE FROM ps_bgslider WHERE id = '{$id}'";
			
	mysql_query($sql);
	
	echo "deleted";
	
}



function reloadlist(){

	global $tengine;
	
	$sql = "SELECT * FROM ps_bgslider ORDER BY position";
	
	//echo $sql;
	
	
	$result = mysql_query($sql);
	
	$i=0;
	
	$returnarray = array();
	
	
	$datarows = "";
	
	
	$datarows .=  $tengine->showpartial("manager.tpl.html",'LISTTABLEHEAD');
	
	
	while($row = mysql_fetch_assoc($result)){
	
	
		$i++;
		
		if ($i%2==0){
			$rowaltclass ="even";
			$divBdr ="CCCCCC";
		}else{
			$rowaltclass ="odd";//"afdae7";
			$divBdr ="FFFFFF";
		}
		
		$data = array(
		'id'=>$row['id'],
		'title'=>$row['title'],
		'content'=>$row['content'],
		'leftpos'=>$row['leftpos'],
	
		'rowaltclass'=>$rowaltclass,
		'divBdr'=>$divBdr
		);
	
	
		$datarows .= $tengine->showpartial("manager.tpl.html",'MANAGERLSTITEM',$data);
		
	}
	
	$datarows .=  $tengine->showpartial("manager.tpl.html",'LISTTABLEFOOT');
		
	
	return $datarows;
		

}



function settings(){

	global $tengine;
	

	$settingSql="SELECT * FROM ps_slideshow_settings WHERE set_id=1";
	$settingRes=mysql_query($settingSql);
	$setting=mysql_fetch_assoc($settingRes);


	$selected='selected="selected"';

	if ($setting['set_pauseOnHover']==true)
	$checked='checked="checked"';
	else
	$checked='';
	
	
	$data = array(
	
	'selected'=>$selected,
	'setting'=>$setting,
	'checked'=>$checked
	
	);
	
	echo $tengine->showpartial("manager.tpl.html",'SETTINGS',$data);
	
	


}



function showManager(){



	
}


} //end class