<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class fileselectortool {
	
	var $dir;
	var $firstAct = false;
	var $folderAct = false;
	var $ALLOWED_IMAGES;
	var $SID;
	
	/**
	* Constructor
	*
	*
	*/
	

	public function __construct(){
		
		
	}
	
	
	/**
	*
	*
	*/
	public function process() {
		
		
		error_reporting(E_ALL);
		ob_start("ob_gzhandler");
		header('Content-Type: text/html; charset=utf-8');
		
		if(isset($_POST['SID'])) session_id($_POST['SID']);
		if(!isset($_SESSION)) session_start();
		$this->SID = session_id();
		
		if(!isset($_SESSION['tiny_image_manager_path'])) $_SESSION['tiny_image_manager_path'] = '';
		
		$this->ALLOWED_IMAGES = array('jpeg','jpg','gif','png');

		
		$this->dir = array('images'	=> realpath(DIR_ROOT.DIR_IMAGES));
		
		require(dirname(__FILE__) . '/exifReader.php');
		
		if(isset($_GET['action'])) $action = $_GET['action'];
		else $action = $_POST['action'];
		
		switch ($action) {
			
			// Create folder
		case 'newfolder':
			
			$result = array();
			$dir = $this->AccessDir($_POST['path'], $_POST['type']);
			if($dir) {
				if (preg_match('/[a-z0-9-_]+/sim', $_POST['name'])) {
					if(is_dir($dir.'/'.$_POST['name'])) {
						$result['error'] = 'This dir already contains';
					} else {
						if(mkdir($dir.'/'.$_POST['name'])) {
							$result['tree']  = $this->DirStructure('images', 'first', $dir.'/'.$_POST['name']);
							$result['tree'] .= $this->DirStructure('files', 'first', $dir.'/'.$_POST['name']);
							$result['addr'] = $this->DirPath($_POST['type'], $this->AccessDir($_POST['path'].'/'.$_POST['name'], $_POST['type']));
							$result['error'] = '';
						} else {
							$result['error'] = 'Error creating dir';
						}
					}
				} else {
					$result['error'] = 'Dir name can only contain letters, numbers, dashes and underscores';
				}
			} else {
				$result['error'] = 'Access denied';
			}
			
			echo "{'tree':'{$result['tree']}', 'addr':'{$result['addr']}', 'error':'{$result['error']}'}";
			exit();
			
			break;
			
			// Show folders tree
		case 'showtree':
			if(!isset($_POST['path'])) $_POST['path'] = '';
			if(!isset($_POST['type'])) $_POST['type'] = '';
			
			if($_POST['path'] == '/') $_POST['path'] = '';
			
			if(isset($_POST['default']) && isset($_SESSION['tiny_image_manager_path'])) $path = $_SESSION['tiny_image_manager_path'];
			else $path = $_SESSION['tiny_image_manager_path'] = $_POST['path'];
			
			if($_POST['type']=='files') $this->firstAct = true;
			if($_POST['type']=='files') echo $this->DirStructure('images', 'first');
			else 						echo $this->DirStructure('images', 'first', $this->AccessDir($path, 'images'));
			if($_POST['type']=='files') $this->firstAct = false;
			if($_POST['type']=='images') echo $this->DirStructure('files', 'first');
			else 						 echo $this->DirStructure('files', 'first', $this->AccessDir($path, 'files'));
			exit();
			break;
			
			// Show the path on the header
		case 'showpath':
		
			if(isset($_POST['default']) && isset($_SESSION['tiny_image_manager_path'])) $path = $_SESSION['tiny_image_manager_path'];
			else $path = $_SESSION['tiny_image_manager_path'] = $_POST['path'];
		
			
			echo $this->DirPath($_POST['type'], $this->AccessDir($path, $_POST['type']));
			exit();
			break;
			
			// Show files
		case 'showdir':
			if(isset($_POST['default']) && isset($_SESSION['tiny_image_manager_path'])) $path = $_SESSION['tiny_image_manager_path'];
			else $path = $_SESSION['tiny_image_manager_path'] = $_POST['path'];
			
			echo $this->ShowDir($path, $_POST['pathtype']);
			exit();
			break;

			// Delete file or several files
		case 'delfile':
			if(is_array($_POST['md5'])) {
				foreach ($_POST['md5'] as $k=>$v) {
					$this->DelFile($_POST['pathtype'], $_POST['path'], $v, $_POST['filename'][$k], true);
				}
				echo $this->ShowDir($_POST['path'], $_POST['pathtype']);
			} else {
				echo $this->DelFile($_POST['pathtype'], $_POST['path'], $_POST['md5'], $_POST['filename'], true);
			}
			exit();
			break;
			
		case 'delfolder':
			echo $this->DelFolder($_POST['pathtype'], $_POST['path']);
			exit();
			break;
			
		case 'renamefile':
			echo $this->RenameFile($_POST['pathtype'], $_POST['path'], $_POST['filename'], $_POST['newname']);
			exit();
			break;
			
		case 'SID':
			echo $this->SID;
			exit();
			break;
			
		default:
			;
			break;
		}
		
	}
	
	/**
	* Check for folder write permissions (non system)
	*
	* @param string $requestDirectory Requested folder (relatively DIR_IMAGES)
	* @param (images|files) $typeDirectory Folder type - images or files
	* @return path|false
	*/
	function AccessDir($requestDirectory, $typeDirectory) {
		

		$full_request_images_dir = realpath($this->dir['images'].$requestDirectory);
		if(strpos($full_request_images_dir, $this->dir['images']) === 0) {
			return $full_request_images_dir;
		} else return false;
		
	}
	
	
	/**
	* Folders tree
	* recursive function
	* 
	* @return array
	*/
	function Tree($beginFolder) {
	
		$struct = array();
		$handle = opendir($beginFolder);
		if ($handle) {
			$struct[$beginFolder]['path'] = str_replace(array($this->dir['images']),'',$beginFolder);
			// peterdrinnan
			$tmp = explode('[\\/]',$beginFolder);
			$tmp = array_filter($tmp);
			end($tmp);
			$struct[$beginFolder]['name'] = current($tmp);
			$struct[$beginFolder]['count'] = 0;
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && $file != 'thumbs') {
					if(is_dir($beginFolder.'/'.$file)) {
						$struct[$beginFolder]['childs'][] = $this->Tree($beginFolder.'/'.$file);
					} else{
					
						// peterdrinnan - make sure there is an image here

						$file_info = pathinfo($file);
						$file_info['extension'] = strtolower($file_info['extension']);
						
						if(in_array(strtolower($file_info['extension']),$this->ALLOWED_IMAGES)) {
							$struct[$beginFolder]['count']++;
						}
					}
				}
			}
			closedir($handle);
			asort($struct);
			return $struct;
		}
		return false;
	}
	
	/**
	* Folders tree visualisation
	* recursive function
	* 
	* @param images|files $type
	* @param first|String $innerDirs
	* @param String $currentDir
	* @param int $level
	* @return html
	*/
	function DirStructure($type, $innerDirs='first', $currentDir='', $level=0) {
		// will turn off files for now.
		if($type=='files') return ;
		
		$currentDirArr = array();
		if(!empty($currentDir)) {
			// peterdrinnan
			$currentDirArr = explode('[\\/]',str_replace($this->dir[$type],'',realpath($currentDir)));
			$currentDirArr = array_filter($currentDirArr);
		}
		
		if($innerDirs == 'first') {
			$innerDirs = array();
			$innerDirs = $this->Tree($this->dir[$type]);
			if(realpath($currentDir) == $this->dir[$type] && !$this->firstAct) {
				$firstAct = 'folderAct';
				$this->firstAct = true;
			} else {
				$firstAct = '';
			}
			$ret = '';
			if($innerDirs == false) return 'False set root directory ('.DIR_IMAGES.')';
			// core dirs
			foreach ($innerDirs as $v) {
				$ret = '<div class="folder'.ucfirst($type).' '.$firstAct.'" path="" pathtype="'.$type.'">'.($type=='images'?'Images':'Files').($v['count']>0?' ('.$v['count'].')':'').'</div><div class="folderOpenSection" style="display:block;">';
				if(isset($v['childs'])) {
					$ret .= $this->DirStructure($type, $v['childs'], $currentDir, $level);
				}
				break;
			}
			$ret .= '</div>';
			return $ret;
		}
		
		if(sizeof($innerDirs)==0) return false;
		$ret = '';
		foreach ($innerDirs as $v) {

			foreach ($v as $v) {}

			// flip dir slashes for piece of crap windows machines
			$v['name'] = str_replace("\\","/",$v['name']);
			$v['name'] = str_replace(ASSET_ROOT . "upload","",$v['name']);
			
			
			if(strlen($v['name'])>14) $v['name'] = substr($v['name'], 0, 8).'...'.substr($v['name'], -3, 3);

			if(isset($v['count'])) {
				$files = 'Files: '.$v['count'];
				$count_childs = isset($v['childs'])?sizeof($v['childs']):0;
				if($count_childs!=0) {
					$files .= ', directories: '.$count_childs;
				}
			} else {
				$files = '';
			}
			if(isset($v['childs'])) {

				$folderOpen = '';
				$folderAct = '';
				$folderClass = 'folderS';
				if(isset($currentDirArr[$level+1])) {
					if($currentDirArr[$level+1] == $v['name']) {
						$folderOpen = 'style="display:block;"';
						$folderClass = 'folderOpened';
						if($currentDirArr[sizeof($currentDirArr)]==$v['name'] && !$this->folderAct) {
							$folderAct = 'folderAct';
							$this->folderAct = true;
						} else {
							$folderAct = '';
						}
					}
				}
				// inner dirs


				$ret .= '<div class="'.$folderClass.' '.$folderAct.'" path="'.$v['path'].'" title="'.$files.'" pathtype="'.$type.'">'.$v['name'].($v['count']>0?' ('.$v['count'].')':'').'</div><div class="folderOpenSection" '.$folderOpen.'>';
				$ret .= $this->DirStructure($type, $v['childs'], $currentDir, $level+1);
				$ret .= '</div>';
			} else {
				$soc = sizeof($currentDirArr);
				
					
				if( 
					$soc > 0 
					&& 
					// peterdrinnan
					$currentDirArr[($soc-1)] == $v['name']
				) {
					$folderAct = 'folderAct';
				} else {
					$folderAct = '';
				}
				$ret .= '<div class="folderClosed '.$folderAct.'" path="'.$v['path'].'" title="'.$files.'" pathtype="'.$type.'">'.$v['name'].($v['count']>0?' ('.$v['count'].')':'').'</div>'; 
			}
		}
		
		return $ret;
	}
	
	/**
	* Get folder path
	*
	* @param images|files $type
	* @param String $path
	* @return html
	*/
	private function DirPath($type, $path='') {
		
		if(!empty($path)) {
			
			// peterdrinnan
			$path = explode('[\\/]',str_replace($this->dir[$type],'',realpath($path)));
			
			//print_r($path);
						
			
			$path = array_filter($path);
		}
		
		$ret = '<div class="addrItem" path="" pathtype="'.$type.'" title=""><div class="ich_headerImage" title="Root dir"></div></div>';
		$i=0;
		$addPath = '';
		if(is_array($path)) { 
			foreach ($path as $v) {
				$i++;
				$addPath .= '/'.$v;
				if(sizeof($path) == $i) {
					$ret .= '<div class="addrItemEnd" path="'.$addPath.'" pathtype="'.$type.'" title=""><div>'.$v.'</div></div>';
				} else {
					$ret .= '<div class="addrItem" path="'.$addPath.'" pathtype="'.$type.'" title=""><div>'.$v.'</div></div>';
				}
			}
		}
		
		
		return $ret;
	}
	
	
	/**
	*
	*
	*/
	private function CallDir($dir, $type) {
	
	
		$CI = & get_instance();
	
		$CI->load->library('uploadhandler');
		
	
		$dir = $this->AccessDir($dir, $type);
		if(!$dir) return false;
		
		set_time_limit(120);
		
		$thumb_dir = $dir . "/thumbs";
		
		
		if(!is_dir($thumb_dir)) {
			mkdir($thumb_dir);
		}
		
		$dbfile = $dir.'/thumbs/.db';
		if(is_file($dbfile)) {
			$dbfilehandle = fopen($dbfile, "r");
			$dblength = filesize($dbfile);
			if($dblength>0) $dbdata = fread($dbfilehandle, $dblength);
			fclose($dbfilehandle);
			$dbfilehandle = fopen($dbfile, "w");
		} else {
			$dbfilehandle = fopen($dbfile, "w");
		}
		
		if(!empty($dbdata)) {
			$files = unserialize($dbdata);
		} else $files = array();
		
		
		$handle = opendir($dir);
		if ($handle) {
		
			while (false !== ($file = readdir($handle))) {
			
			
				if ($file != "." && $file != "..") {
				
					if(isset($files[$file])) continue;
					
					if(is_file($dir.'/'.$file) ) {
					
				
							
						$file_info = pathinfo($dir.'/'.$file);
						$file_info['extension'] = strtolower($file_info['extension']);
						if(!in_array(strtolower($file_info['extension']),$this->ALLOWED_IMAGES)) {
							continue;
						}
						$link = str_replace(array('/\\','//','\\\\','\\'),'/', '/'.str_replace(realpath(DIR_ROOT),'',realpath($dir.'/'.$file)));
						$path = pathinfo($link);
						$path = $path['dirname'];
						
						if($file_info['extension']=='jpg' || $file_info['extension']=='jpeg') {
						
							$er = new phpExifReader($dir.'/'.$file);
							$files[$file]['imageinfo'] = getimagesize($dir.'/'.$file);
							
							$files[$file]['general'] = array(
							'filename' => $file,
							'name'	=> basename(strtolower($file_info['basename']), '.'.$file_info['extension']),
							'ext'	=> $file_info['extension'],
							'path'	=> $path,
							'link'	=> $link,
							'size'	=> filesize($dir.'/'.$file),
							'date'	=> filemtime($dir.'/'.$file),
							'width'	=> $files[$file]['imageinfo'][0],
							'height'=> $files[$file]['imageinfo'][1],
							'md5'	=> $file,
							
							);
							
							// now create a thumbnail if one does not exist.							
							$CI->uploadhandler->create_scaled_image($dir."/".$file, null, 1, null);
							
							
							
							
						} else {
							$files[$file]['imageinfo'] = getimagesize($dir.'/'.$file);
							$files[$file]['general'] = array(
							'filename' => $file,
							'name'	=> basename(strtolower($file_info['basename']), '.'.$file_info['extension']),
							'ext'	=> $file_info['extension'],
							'path'	=> $path,
							'link'	=> $link,
							'size'	=> filesize($dir.'/'.$file),
							'date'	=> filemtime($dir.'/'.$file),
							'width'	=> $files[$file]['imageinfo'][0],
							'height'=> $files[$file]['imageinfo'][1],
							'md5'	=> $file,
							
							);
							
							
							// now create a thumbnail if one does not exist.							
							$CI->uploadhandler->create_scaled_image($dir."/".$file, null, 1, null);
							
						}
					}
				}
			}
			closedir($handle);
		}

		fwrite($dbfilehandle, serialize($files));
		fclose($dbfilehandle);

		return $files;
	}

	/**
	*
	*
	*/
	function RenameFile($type, $dir, $filename, $newname) {
		$dir = $this->AccessDir($dir, $type);
		if(!$dir) return false;
		
		$filename = trim($filename);
		
		if(empty($filename)) {
			return 'error';
		}
		
		if(!is_dir($dir.'/thumbs')) {
			return 'error';
		}
		
		$dbfile = $dir.'/thumbs/.db';
		if(is_file($dbfile)) {
			$dbfilehandle = fopen($dbfile, "r");
			$dblength = filesize($dbfile);
			if($dblength>0) $dbdata = fread($dbfilehandle, $dblength);
			fclose($dbfilehandle);
		} else {
			return 'error';
		}
		
		$files = unserialize($dbdata);
		
		foreach ($files as $file=>$fdata) {
			if($file == $filename) {
				$files[$file]['general']['name'] = $newname;
				break;
			}
		}
		
		$dbfilehandle = fopen($dbfile, "w");
		fwrite($dbfilehandle, serialize($files));
		fclose($dbfilehandle);
		
		return 'ok';
	}
	
	/**
	*
	*
	*/
	function bytes_to_str($bytes) {
		$d = '';
		if($bytes >= 1048576) {
			$num = $bytes/1048576;
			$d = 'Mb';
		} elseif($bytes >= 1024) {
			$num = $bytes/1024;
			$d = 'kb';
		} else {
			$num = $bytes;
			$d = 'b';
		}
		
		return number_format($num, 2, ',', ' ').$d;
	}
	
	
	/**
	*
	*
	*/
	public function ShowDir($dir, $type) {


		$dir = $this->CallDir($dir, $type);


		if(!$dir) {
			//echo 'Read error, possible no permissions.';
			exit();
		}

		$ret = '';

		$settings = array('w'=>100,'h'=>100);
		$settings_36 = array('w'=>46,'h'=>46);

		foreach ($dir as $v) {

			
			// pererdrinnan
			//$ext = strtolower(end(explode('.', $v['general']['filename'])));
			
			$ext = explode(".", strtolower($v['general']['filename']));
			
			
			// if the thumbnail image doe snot exist, creat it.
			
			
			//if($v['general']['width'] > WIDTH_TO_LINK || $v['general']['height'] > HEIGHT_TO_LINK) {
			//	list($middle_width, $middle_height) = getimagesize(DIR_ROOT.$middle_thumb);
			//	$middle_thumb_attr = 'fmiddle="'.$middle_thumb.'" fmiddlewidth="'.$middle_width.'" fmiddleheight="'.$middle_height.'" fclass="'.CLASS_LINK.'" frel="'.REL_LINK.'"';
			//} else {
			$middle_thumb = '';
			$middle_thumb_attr = '';
			//}

			$div_params = '';
			if ($type == 'files') { $img_params = ''; $div_params = 'style="width: 100px; height: 80px; padding-top: 16px;"'; }

			// what we can get from EXIF reader

			//     [resolutionUnit] => Inches

			//     [FlashUsed] => 0
			//     [make] => Canon
			//     [model] => Canon EOS 450D
			//     [xResolution] => 72.00 (72/1) Inches
			//     [yResolution] => 72.00 (72/1) Inches
			//     [fileModifiedDate] => 2011:04:30 12:59:42
			//     [YCbCrPositioning] => 2
			//     [exposureTime] =>  0.003 s (1/320) (1/320)
			//     [fnumber] => f/8.0
			//     [exposure] => Reserved
			//     [isoEquiv] => 400
			//     [exifVersion] => 0221
			//     [DateTime] => 2011:04:30 12:59:42
			//     [dateTimeDigitized] => 2011:04:30 12:59:42
			//     [componentConfig] => Does Not Exists
			//     [aperture] => 8
			//     [exposureBias] => 0.00 (0/1)
			//     [meteringMode] => spot
			//     [flashUsed] => No
			//     [focalLength] => 55.00 (55/1)
			//     [makerNote] => NOT IMPLEMENTED
			//     [exifComment] => 
			//     [subSectionTime] => 02
			//     [subSectionTimeOriginal] => 02
			//     [subSectionTimeDigtized] => 02
			//     [flashpixVersion] => 0100
			//     [colorSpace] => 
			//     [Width] => 4272
			//     [Height] => 2848
			//     [GPSLatitudeRef] => Reserved
			//     [GPSLatitude] => Array
			//         (
			//             [Degrees] => 48
			//             [Minutes] => 49
			//             [Seconds] => 48
			//         )
			// 
			//     [focalPlaneYResolution] => 4876.71 (2848000/584)
			//     [customRendered] => Normal Process
			//     [exposureMode] => Manual Exposure
			//     [whiteBalance] => 1
			//     [screenCaptureType] => Standard
			//     [compressScheme] => JPEG compression (thumbnails only)
			//     [CCDWidth] => 22.30mm
			//     [IsColor] => 1
			//     [Process] => 192
			//     [resolution] => 4272x2848
			//     [color] => Color
			//     [jpegProcess] => Baseline

			// $v['general']['jpegProcess']['model']

			$rand = rand(1, 9999);

			$ret .= '<div class="imageBlock1" id="'.$v['general']['link']
			.'" filename="'
			.$v['general']['filename'].'" fname="'
			.$v['general']['name'].'" type="'
			.$type
			.'" ext="'
			.strtoupper($v['general']['ext'])
			.'" path="'
			.$v['general']['path'].'" linkto="'
			.$v['general']['link']
			.'?rand='
			.$rand.'" fsize="'
			.$v['general']['size']
			.'" fsizetext="'
			.$this->bytes_to_str($v['general']['size'])
			.'" date="'
			.date('d.m.Y H:i',$v['general']['date']).'" fwidth="'
			.$v['general']['width']
			.'" fheight="'.$v['general']['height'].'" ';

			if(isset($v['general']['jpegProcess']['orientation']))  $ret .= ' orient="' . $v['general']['jpegProcess']['orientation'] .'"';

			$ret .= ' md5="'
			.$v['general']['md5'].'" '
			.$middle_thumb_attr.'>
	<div class="imageImage">
	<img src="'
			.$this->get_server().$v['general']['path'].'/thumbs/'
			.$v['general']['filename'].'?rand='
			.$rand.'" alt="'
			.$v['general']['name'].'" />
	</div>
	<div class="imageName">'.$v['general']['name'].'</div>
	</div>';
		}
		return $ret;
	}

	/**
	*
	*
	*/
	public function get_server() {
		$protocol = 'http';
		if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') {
			$protocol = 'https';
		}
		$host = $_SERVER['HTTP_HOST'];
		$baseUrl = $protocol . '://' . $host;
		if (substr($baseUrl, -1)=='/') {
			$baseUrl = substr($baseUrl, 0, strlen($baseUrl)-1);
		}
		return $baseUrl;
	}

	/**
	*
	*
	*/
	public function DelFile($pathtype, $path, $md5, $filename, $callShowDir=false) {
		$tmppath = $path;
		$path = $this->AccessDir($path, $pathtype);
		if(!$path) return false;
		
		if(is_dir($path.'/thumbs')) {
			if($pathtype == 'images') {
				$handle = opendir($path.'/thumbs');
				if ($handle) {
					while (false !== ($file = readdir($handle))) {
						if ($file != "." && $file != "..") {
							if(substr($file,0,32) == $md5) 
							unlink($path.'/thumbs/'.$file);
						}
					}
				}
			}
			
			$dbfile = $path.'/thumbs/.db';
			if(is_file($dbfile)) {
				$dbfilehandle = fopen($dbfile, "r");
				$dblength = filesize($dbfile);
				if($dblength>0) $dbdata = fread($dbfilehandle, $dblength);
				fclose($dbfilehandle);
				$dbfilehandle = fopen($dbfile, "w");
			} else {
				$dbfilehandle = fopen($dbfile, "w");
			}
			
			
			if(isset($dbdata)) {
				$files = unserialize($dbdata);
			} else $files = array();
			
			unset($files[$filename]);
			
			fwrite($dbfilehandle, serialize($files));
			fclose($dbfilehandle);
		}
		
		if(is_file($path.'/'.$filename)) {
			if(unlink($path.'/'.$filename)) {
				if($callShowDir) {
					return $this->ShowDir($tmppath, $pathtype);
				} else {
					return true;
				}
			}
		} else return 'error';
		
		return 'error'; 
	}
	
	/**
	*
	*
	*/
	public function DelFolder($pathtype, $path) {
	
	
	
		$path = $this->AccessDir($path, $pathtype);
		if(!$path) return false;
		
		if(realpath($path.'/') == realpath(DIR_ROOT.DIR_IMAGES.'/')) {
			return '{error:"You can not delete a root dir!"}';
		}
		
		$files = array();
		
		$handle = opendir($path);
		if ($handle) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && trim($file) != "" && $file != "thumbs") {
					if(is_dir($path.'/'.$file)) {
						return '{error:"As long the dir contains subfolders, it can\'t be removed."}';
					} else {
						$files[] = $file;
					}
				}
			}
		}
		closedir($handle);
		
		$handle = opendir($path.'/thumbs');
		if ($handle) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if(is_file($path.'/thumbs/'.$file)) {
						unlink($path.'/thumbs/'.$file);
					}
				}
			}
			closedir($handle);
			rmdir($path.'/thumbs');
		}
		
		foreach ($files as $f) {
			if(is_file($path.'/'.$f)) unlink($path.'/'.$f);
		}
		
		if(!rmdir($path)) return '{error:"Error deleting dir"}';
		
		return '{ok:\'\'}';
	}
	
}
