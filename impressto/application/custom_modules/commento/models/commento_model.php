<?php
/**
*  
* This is the main commento class file. It handles all the render and operations.
* This calss is used to frontend comment system display. Also processes the AJAX request
* that comes from the commento.processor.php file. It also processes the admin panel requests
*
* @author 	Eduardo Pereira
* @date		03/11/2011
* @website	http://www.voindo.eu/commento
*
* @requirements PHP 5.2+ with GD2 library support. 
*
* @package commento.class
* 
*/


class commento_model extends My_Model{

	// THE DATABASE VARS [DO NOT CHANGE HERE]
	private	$db_host;
	private $db_user;
	private $db_pass;
	private $db_database;
	
	// GENERAL CONFIG VARS [DO NOT CHANGE HERE]
	private $allowed_html;
	private $page_url;
	private $commento_url;
	private $image_folder;
	private $smiles_folder;
	private $lang_folder;
	private $current_lang;
	private $conv_url_to_link;
	private $display_order;
	private $mod_comments;
	private $mod_comment;
	private $reg_users_only;
	private $ask_web_address;
	private $is_user_logged;
	private $commento_user_name;
	private $commento_user_email;
	private $closed_comments;
	private $admin_viewing;
	public	$captcha_enabled;
	public	$captcha_width;
	public	$captcha_color1;
	public	$captcha_color2;
	public	$captcha_color3;
	public	$captcha_colorbg;
	private	$karma_on;
	private	$karma_type;
	private $admin_viewing_backend = false;
	
	// Javascript vars  [DO NOT CHANGE HERE]
	public  $maxnumchars;
	public  $Replymaxnumchars;
	
	// Pagination vars  [DO NOT CHANGE HERE]
	public  $current_page = 1;
	public  $mid_range;
	public  $default_ipp;
	public  $items_per_page;
    public  $items_total;
    public  $num_pages;
    public  $low;
    public  $high;
    public  $limit;
    public  $return;
	
	// System vars  [DO NOT CHANGE HERE]
	private $data = array();
	private $blacklist = array();
	public	$nbComments = 0;
	
	
	
	public function __construct() {
		
		/*********************************************************************
		**         		DATABASE CONFIGURATIONS - [CHANGE HERE]				**
		*********************************************************************/
		// if you have a database connection somewhere uncomment and configure the 6 below lines. Remember that this class will be called from different locations, so set path wisely.
		// try using a dirname(__FILE__) and set the path relative to this file path. It's safer. Also, if you do use your own config, don't forget to comment the manual config lines below.
		//
		// global $YOUR_db_host_VAR, $YOUR_db_user_VAR, $YOUR_db_pass_VAR, $YOUR_db_database_VAR;
		// require_once '/path/to/your/database/config.php';
		 $this->db_host 		= $this->db->hostname;
		 $this->db_user 		= $this->db->username;
		 $this->db_pass 		= $this->db->password;
		 $this->db_database 	= $this->db->database;
		
		// THE DATABASE MANUAL CONFIG
		//$this->db_host 			= "localhost";
		//$this->db_user 			= "commento_local";
		//$this->db_pass 			= "commento_local";
		//$this->db_database 		= "commento_local";
		
		/*************************************************************
		**         		END OF DATABASE CONFIGURATIONS				**
		**************************************************************/
		
				
		
		// Create a $link var with the database connection
		$link = mysql_connect($this->db_host, $this->db_user, $this->db_pass) or die('Unable to establish a DB connection');
		// Set UTF-8 mode
		mysql_query("SET NAMES 'utf8'");
		// Selects the database
		mysql_select_db($this->db_database, $link);
		
		
		
		
		$user_session_data = $this->session->all_userdata();	
		

	
		
		// Now let's look for session vars. If not present, default them...
		if ((isset($_SESSION["commento_moderated_com"])) and ($_SESSION["commento_moderated_com"] === true))
			$session_commento_moderated_com = true;
		else
			$session_commento_moderated_com = false;
		
		// Now let's look for session vars. If not present, default them...
		if ((isset($_SESSION["commento_comments_closed"])) and ($_SESSION["commento_comments_closed"] === true))
			$session_commento_comments_closed = true;
		else
			$session_commento_comments_closed = false;
		
		// Now let's look for session vars. If not present, default them...
		if ((isset($_SESSION["commento_admin_viewing"])) and ($_SESSION["commento_admin_viewing"] === true))
			$session_commento_admin_viewing = true;
		else
			$session_commento_admin_viewing = false;
			

			
			
			
			
		// Now let's look for session vars. If not present, default them...
		if ((isset($user_session_data['is_logged_in'])) and ($user_session_data['is_logged_in'] == 1)){
			$this->is_user_logged = true;
		}else{
			$this->is_user_logged = false;
		}
		
		// Now let's look for session vars. If not present, default them...
		if ((isset($user_session_data['username'])) and ($user_session_data['username'] !== ""))
			$this->commento_user_name = $user_session_data['username'];
		else
			$this->commento_user_name = "";
			
					
		// Now let's look for session vars. If not present, default them...
		if ((isset($user_session_data["email_address"])) and ($user_session_data["email_address"] !== ""))
			$this->commento_user_email = $user_session_data["email_address"];
		else
			$this->commento_user_email = "";
		
		
		//print_r($user_session_data);
	
		
		
		/*************************************************************************
		**         		SYSTEM CONFIGURATIONS - [CHANGE HERE]					**
		*************************************************************************/
		
		// We define here COMMENTO_BASE_PATH wich is the ABSOLUTE PATH of this commento.class.php file.
		if(!defined('COMMENTO_BASE_PATH')) define('COMMENTO_BASE_PATH',str_replace('\\','/',dirname(__FILE__)));

		// Include the purifier class. If the purifier folder is in same folder as this commento.class.php file, next line should be fine because we set up earlier COMMENTO_BASE_PATH
		// Remeber to test with error reporting ON, as require_once will throw fatal error if class not found.
		//require_once COMMENTO_BASE_PATH . '/htmlpurifier/HTMLPurifier.auto.php';
		
		$this->load->helper('htmlpurifier');
		
		
		// GENERAL MANUAL CONFIG
		$this->page_url			= $this->config->item('base_url'); // "http://127.0.0.1/Commax/";						// Full page URL (Used to access images for gravatar and smiles) ex.g. http://www.yoursite.com/ OR http://127.0.0.1/Commax/
		$this->commento_url		= "";												// Location of commento foder (ATTENTION $this->page_url RELATIVE) ex.g. commento/
		$this->image_folder		= "assets/" . PROJECTNAME . "/default/custom_modules/commento/img/";									// Location of images foder (ATTENTION $this->page_url RELATIVE) ex.g. assets/img/
		$this->smiles_folder	= "assets/" . PROJECTNAME . "/default/custom_modules/commento/img/emoticons/";							// Location of smiles foder (ATTENTION $this->page_url RELATIVE) ex.g. assets/img/emoticons/
		
		$this->lang->load('commento', $this->config->item('language'), FALSE, TRUE, dirname(dirname(__FILE__)) . '/');
		
		// GENERAL SESSION CONFIG
		
		
		$this->closed_comments	= $session_commento_comments_closed;					// THIS IS SESSION CONFIGURABLE (Per post id comments closed flag)
		$this->mod_comment		= $session_commento_moderated_com;					// THIS IS SESSION CONFIGURABLE (Per post id comments moderation flag. If TRUE will override the main mod_comments FALSE)
		$this->admin_viewing	= $session_commento_admin_viewing;					// THIS IS SESSION CONFIGURABLE (Set to true if admin is viewing comments. Activate admin tools)
		//$this->is_user_logged	= $session_commento_is_user_logged;					// THIS IS SESSION CONFIGURABLE (Set to true if User is Logged In - Only used when $this->reg_users_only is TRUE)
		//$this->commento_user_name	= $session_commento_user_name;						// THIS IS SESSION CONFIGURABLE (Get the logged in user name FROM the session var)
		//$this->commento_user_email= $session_commento_user_email;						// THIS IS SESSION CONFIGURABLE (Get the logged in user email FROM the session var)
		
		

		
		// GENERAL ADMIN PANEL CONFIG
		$this->mod_comments		= $this->getConfigurations("mod_comments");			// THIS IS ADMIN PANEL CONFIGURABLE (All comments are to be moderated? If TRUE will override the main mod_comment FALSE)
		$this->reg_users_only	= $this->getConfigurations("reg_users_only");		// THIS IS ADMIN PANEL CONFIGURABLE (Should comment system only allow registered and logged in users to post comments)

		$this->ask_web_address	= $this->getConfigurations("ask_web_address");		// THIS IS ADMIN PANEL CONFIGURABLE (Should comment system only allow registered and logged in users to post comments)
		
		
		
		$this->allowed_html 	= $this->getConfigurations("allowed_html"); 		// THIS IS ADMIN PANEL CONFIGURABLE (Allow simple HTML in comments. Set empty to disable HTML altogether)
		$this->conv_url_to_link	= $this->getConfigurations("conv_url_to_link");		// THIS IS ADMIN PANEL CONFIGURABLE (Should system convert any url to a link - noffolow and target blank will be added)
		$this->blacklist		= $this->getConfigurations("blacklist");			// THIS IS ADMIN PANEL CONFIGURABLE (List of badwords. Leave blank to disable)
		$this->display_order	= $this->getConfigurations("display_order");		// THIS IS ADMIN PANEL CONFIGURABLE (Order to display comments.) (JAVASCRIPT ALSO USES THIS VAR)
		$this->captcha_enabled	= $this->getConfigurations("captcha_enabled");		// THIS IS ADMIN PANEL CONFIGURABLE (Should Captcha be enabled?)
		$this->captcha_width	= $this->getConfigurations("captcha_width");		// THIS IS ADMIN PANEL CONFIGURABLE (Captcha Image Width)
		
		$this->captcha_color1	= $this->getConfigurations("captcha_color1");		// THIS IS ADMIN PANEL CONFIGURABLE (Captcha Image Width)
		$this->captcha_color2	= $this->getConfigurations("captcha_color2");		// THIS IS ADMIN PANEL CONFIGURABLE (Captcha Image Width)
		$this->captcha_color3	= $this->getConfigurations("captcha_color3");		// THIS IS ADMIN PANEL CONFIGURABLE (Captcha Image Width)
		$this->captcha_colorbg	= $this->getConfigurations("captcha_colorbg");		// THIS IS ADMIN PANEL CONFIGURABLE (Captcha Image Width)
		
		$this->karma_on			= $this->getConfigurations("karma_on");				// THIS IS ADMIN PANEL CONFIGURABLE (Is Karma system turned on?)
		$this->karma_type		= $this->getConfigurations("karma_type");			// THIS IS ADMIN PANEL CONFIGURABLE (What type? Only to registered users, or cookie based?)
		
		
		// JAVASCRIPT ADMIN PANEL CONFIG
		$this->maxnumchars		= $this->getConfigurations("maxnumchars");			// THIS IS ADMIN PANEL CONFIGURABLE (Maximun Number of characters per comment)
		$this->Replymaxnumchars	= $this->getConfigurations("Replymaxnumchars");		// THIS IS ADMIN PANEL CONFIGURABLE (Maximun number of characters per reply)
		
		// PAGINATION ADMIN PANEL CONFIG
		$this->mid_range		= $this->getConfigurations("mid_range");			// THIS IS ADMIN PANEL CONFIGURABLE (This is how many page link to either side of current one)
		$this->default_ipp		= $this->getConfigurations("default_ipp");			// THIS IS ADMIN PANEL CONFIGURABLE	(Default Number of Items Per Page)
		
		/*********************************************************
		**         		END OF SYSTEM CONFIGURATIONS			**
		*********************************************************/
		
		
		// Checks if there is a items per page request, and sets according. If not keeps default.
        $this->items_per_page = (!empty($_REQUEST['ipp'])) ? $_REQUEST['ipp'] : $this->default_ipp;
		
	}
	
	
	
	/**
	* Function getJSConfig()
	* 
	* This function is only called by Ajax Call from commento_engine.js
	* commento_engine.js will get it's configurations vars from here.
	* NOT ONLY conifg vars, but also any translatable strings. Nice hun ? ;)
	*
	* @return json string 	Returns the json containing all the JS variables
	*
	*/
	public function getJSConfig() {
		return json_encode	( 
								array( 
									// config vars
									'status' 		=> 1, 
									'maxchars' 		=> $this->maxnumchars, 
									'replymaxchars' => $this->Replymaxnumchars, 
									'display_order' => $this->display_order,
									// translatable strings
									'L_WORKING' 	=> $this->__L("JS_WORKING"),
									'L_SUBMIT' 		=> $this->__L("SUBMIT"),
									'L_YESREM' 		=> $this->__L("JS_YESREM"),
									'L_NO' 			=> $this->__L("JS_NO"),
									'L_REMOVE' 		=> $this->__L("REMOVE"),
									'L_YESAPP' 		=> $this->__L("JS_YESAPP"),
									'L_APPROVE' 	=> $this->__L("APPROVE"),
									'L_LOADING' 	=> $this->__L("JS_LOADING"),
									'L_REPLY' 		=> $this->__L("JS_REPLY"),
									'L_CANCELREPLY' => $this->__L("JS_CANCELREPLY")
								)
							);
	}
	
	
	
	/**
	* Starts the comment system output. Does all the necessary checks, and calls
	* the recursive_build_comment() function where it generates the comments
	*
	* @param string 	The page id/name. Like your blog post id, or page id or page name.... Anything really
	*
	* @return string 	It return the complete comment system HTML. All the comments and forms.
	*
	*/
	public function build_comment_system($content_type, $content_id) {
		
		// let's start, first check number of total comments and assign to var
		$this->items_total = $this->numberComments($content_type, $content_id);
		
		// Start output var. And start with a hidden input containing the $content_id for the ajax pagination to know what are we showing
		$out = '<input type="hidden" id="content_id_value" value="'.$content_id.'" />';
		$out .= '<input type="hidden" id="content_type_value" value="'.$content_type.'" />';

	
		// check if there are comments
		if ($this->items_total > 0) {
			
			// Do we have a show all option on?
			if ($this->default_ipp != "ALL") {
				// no the start pagination
				$this->paginate();
				// output the top pagination bar with the class commento_top_paginator
				$out .= $this->display_pages("commento_top_paginator");
			}
			
			// output start the recursive build comments loop
			$out .= $this->recursive_build_comment($content_type, $content_id);
			
			// again if we do no have a show all option on, the show bottom pagination with class commento_bottom_paginator
			if ($this->default_ipp != "ALL")
				$out .= $this->display_pages("commento_bottom_paginator");
			
			
			// comments are close?
			if ($this->closed_comments == false) {
				// NO comments are not closed. So is commento only to registered users?
				if ($this->reg_users_only == true) {
					// YES only to registered users. So is user logged in then ?
					if ($this->is_user_logged == true) {
						// YES user is logged in. So show comments form to logged in user. Name and Email will be pre-filled with session vars
						$out .= $this->comment_form_user_logged_in_XHTML($content_type, $content_id);
					} else {
						// NO user not logged in. So show comments only to registered users form
						$out .= $this->comment_only_register_XHTML($content_type, $content_id);
					}
				} else {
					$out .= $this->comment_form_XHTML($content_type, $content_id);
				}
			} else {
				// YES comments closed, so show closed comments form
				$out .= $this->comment_closed_XHTML($content_type, $content_id);
			}
			
			
		} else {
		
			
			
			// so no comments. Show message and next the comment form
			$out .= $this->noCommentsYet_XHTML($content_type, $content_id);
			
			// BUT before showing the form, let´s see... Comments are close?
			if ($this->closed_comments == false) {
				// NO comments are not closed. So is commento only to registered users?
				if ($this->reg_users_only == true) {
					// YES only to registered users. So is user logged in then ?
					if ($this->is_user_logged == true) {
									
						// YES user is logged in. So show comments form to logged in user. Name and Email will be pre-filled with session vars
						$out .= $this->comment_form_user_logged_in_XHTML($content_type, $content_id);
					} else {
						// NO user not logged in. So show comments only to registered users form
						$out .= $this->comment_only_register_XHTML($content_type, $content_id);
					}
				} else {
					$out .= $this->comment_form_XHTML($content_type, $content_id);
				}
			} else {
				// YES comments closed, so show closed comments form
				$out .= $this->comment_closed_XHTML($content_type, $content_id);
			}
			
		}
		
		// return the output
		return $out;
	}
	
	
	
	/**
	* Function recursive_build_comment()
	* This function will render all the comments HTML output. It's recursive because will check if
	* there are any replies for the current comment, and call it self rendering the replies instead of comments
	*
	* @param string 	The page id/name. Like your blog post id, or page id or page name.... Anything really (IT COMES FROM build_comment_system FUNCTION)
	* @param string 	It's a self assigned var. If not passed it's a comment (default "-"). If passed it's the parent comment idname
	*
	* @return string 	It return the complete comment system HTML (ONLY THE COMMENTS) to the build_comment_system() function above
	*
	*/
	private function recursive_build_comment($content_type, $content_id, $parent_id = "-") {
		
		// First check if we have a parent
		if ($parent_id === "-") {
			// no, so LIMIT it
			$limit = $this->limit;
		} else {
			// we have, no limit, get all replies then
			$limit = "";
		}
		
		$sql_filters = array();
		
		// Let's check if it's admin viewing to show all comments, or not and show only published comments
		if ($this->admin_viewing === true){
			//$and_show_it = "";
		}else{
			$sql_filters[] = " show_it = '1'";
		}
			
		
		if($content_type != "") $sql_filters[] = " content_type = '{$content_type}' ";
		if($content_id != "") $sql_filters[] = " content_id = '{$content_id}' ";
		
		$sql_filters[] = " parent = '{$parent_id}' ";
		
		 
		
		// Get the comments
		$sql = "SELECT * FROM {$this->db->dbprefix}commento_comments WHERE " . implode(" AND ",$sql_filters) . " ORDER BY id ".$this->display_order." $limit";
		
		//echo $sql;
		
		$result 	= mysql_query($sql);
		// set the output var to nothing
		$out 		= "";
		
		// Loop trought all the results (comments)
		while($row = mysql_fetch_assoc($result)) {
			// Process the comment
			$this->process_comment($row);
			// Check again if we have a parent (meaning, are we a reply?)
			if ($parent_id === "-") {
				// no, get the comment HTML
				$out .= $this->pre_Markup();
			} else {
				// yes, get the reply HTML
				$out .= $this->pre_Markup(true);
			}
			// Right so is the recursive check. If this comment has childs, call this function again.
			if (($this->commentHasReplies($row["id"]) === true) and ($parent_id === "-"))
				$out .= $this->recursive_build_comment($content_type, $content_id, $row["id"]);
		}
		// Return output
		return $out;
	}
	
	
	
	/**
	* Function commentHasReplies()
	* Simple function to check and return if the requested comment has replies
	*
	* @param	integer 	The comment id
	*
	* @return	boolean 	True it has replies, false it doesn't have replies
	*
	*/
	public function commentHasReplies($id) {
		$result 	= mysql_query("SELECT id FROM {$this->db->dbprefix}commento_comments WHERE parent = '$id'");
		if (mysql_num_rows($result) > 0)
			return true;
		
		return false;
	}
	
	
	
	/**
	* Function numberComments()
	* Easy way to count the total number of comments of a desired page id/name
	*
	* @param	string 		The page id/name. Like your blog post id, or page id or page name.... Anything really (IT COMES FROM build_comment_system FUNCTION)
	*
	* @return	integer 	The number of comments
	*
	*/
	public function numberComments($content_type, $id) {
		// Let's check if it's admin viewing to show all comments, or not and show only published comments
		if ($this->admin_viewing === true)
			$and_show_it = "";
		else
			$and_show_it = "AND show_it = '1'";
		
		// Selects all the comments to that given page id/name
		
		$sql = "SELECT id FROM {$this->db->dbprefix}commento_comments WHERE content_type = '$content_type' AND content_id = '$id' AND parent = '-' $and_show_it ";
		
		
		$result = mysql_query($sql);
		
		//echo $sql;
		// Sets the variable with number of comments
		$this->nbComments = mysql_num_rows($result);
		
		// returns the number of rows (results)
		return mysql_num_rows($result);
	}
	
	
	
	/**
	* Function process_comment()
	* This is just used to set the row (single comment or reply mysql result) into a variable data
	*
	* @param	array 		A mysql result row
	*
	*/
	public function process_comment($row) {
		$this->data = $row;
	}
	
	
	
	/**
	* Function pre_Markup()
	* It prepares to render a valid XHTML comment. Preparing is needed so we can do a lot of checks from the configurations
	*
	* @param	boolean		Is this comment a reply of another or not
	* @param	boolean		Is this function being called when adding a new comment
	*
	* @return	string		It actually return the result string from another function. Check the finale...
	*
	*/
	public function pre_Markup($replies = false, $adding_new = false) {
			
		// Setting up an alias, so we don't have to write $this->data every time. Remember that $this->data was created by process_comment() above.
		$d = &$this->data;
		
		// Set some empty vars
		$link_open = '';
		$link_close = '';
		
		// If the person has entered a URL when adding a comment, define opening and closing hyperlink tags
		if ($d['url']) {
			$link_open = '<a target="blank" href="'.$d['url'].'">';
			$link_close =  '</a>';
		}
		
		// Converting the time to a UNIX timestamp
		$timeago = $this->time_ago(strtotime($d['dt']));
		$d['dt'] = strtotime($d['dt']);
		
		// Needed for the default gravatar image
		$url = $this->page_url . $this->image_folder . 'default_avatar.png';
		
		// Let's see if this is a comment or a reply.
		// Sets respective html classes, activates reply link for comment and sets string word (says or replied)
		if ($replies === true) {
			$replyClass 	= 'its_a_reply to_'.$d["parent"].'';
			$replyLink 		= '';
			$replyFormXHTML = '';
			// Language string
			$says			= $this->__L("REPLIED");
		} else {
			$replyClass 	= '';
			$replyLink 		= '<a class="reply_btn" id="replyto_'.$d["id"].'" href="#">'.$this->__L("JS_REPLY").'</a>';
			
			// right so this is not a reply, it's a comment. is the system set to registered users only? Is user logged in? Show reply form to user logged in users without captchas overriding any config.
			if (($this->reg_users_only == true) and ($this->is_user_logged === true))
				$replyFormXHTML = $this->reply_form_user_logged_in_XHTML($d["id"], $d["content_type"], $d["content_id"]);
			else
				$replyFormXHTML = $this->reply_form_XHTML($d["id"], $d["content_type"], $d["content_id"]);
			
			// Language string
			$says			= $this->__L("SAID");
		}
		
		// Wait, if comments are closed, clear reply link and form
		if ($this->closed_comments == true) {
			$replyFormXHTML = $this->reply_form_closed_XHTML();
			$replyLink 		= '';
		}
		
		// Wait again, if comments are only for logged in users, and user is not logged in, also clear reply link and form
		if (($this->reg_users_only == true) and ($this->is_user_logged === false)) {
			$replyFormXHTML = "";
			$replyLink 		= '';
		}
		
		// Now check if admin is in the house
		$adminTools = '';
		if ($this->admin_viewing === true) {
			$adminTools = '<a class="btn btn-danger remove_btn" id="rem_btn_'.$d["id"].'" href="#">'.$this->__L("REMOVE").'</a>';
		}
		
		// Finally let's check if comment is hidden (will only be true if admin is viewing and comment has not been approved yet) and assign a special class
		$special_hidden_class = "";
		if ((isset($d["show_it"])) and ($d["show_it"] == "0")) {
			$special_hidden_class = "not_accepted_comment";
			$adminTools .= '<a class="aprove_btn" id="apr_btn_'.$d["id"].'" href="#">'.$this->__L("APPROVE").'</a>';
		}
		
		// Wait a minute. Admin in the house, but next door. It's in the admin panel. Disable replies and supply different tools
		if ($this->admin_viewing_backend === true) {
			$replyFormXHTML = "";
			$replyLink 		= '';
			$adminTools 	= '
								<form name="form_remove_comm" class="form_remove_comm" method="post">
									<input type="hidden" name="post_action" value="rem_comm" />
									<input type="hidden" name="comm_rem_id" value="'.$d["id"].'" />
									<input type="submit" class="btn btn-danger remove_btn" value="'.$this->__L("REMOVE").'" />
								</form>
							';
			if ((isset($d["show_it"])) and ($d["show_it"] == "0"))
				$adminTools    .= '
									<form name="form_approve_comm" class="form_approve_comm" method="post">
										<input type="hidden" name="post_action" value="app_comm" />
										<input type="hidden" name="comm_app_id" value="'.$d["id"].'" />
										<input type="submit" class="btn btn-success aprove_btn" value="'.$this->__L("APPROVE").'" />
									</form>
								';
		}
		
		// Now, are we adding a new comment? I mean, is this a new comment processing call?
		if ($adding_new === true) {
			// Yes, set the karma to zero
			$karmaStuff = $this->karma_system(0, 0, 0, $d["id"]);
		} else {
			// No? So we should have karma values here :)
			$karmaStuff = $this->karma_system($d["karma"], $d["dw_vote"], $d["up_vote"], $d["id"]);
		}
		
		// check if we are adding a new comment or reply and if specific comment thread is moderated or global moderation is On
		if (($adding_new === true) and (($this->mod_comment == true) or ($this->mod_comments == true))) {
			// Return meesage - Thanks, under review
			return $this->commentUnderReview_XHTML($d["id"], $replyClass);
			
		} else {
			// Ok no moderation so return the normal XHTML comment
			return $this->comment_XHTML($d["id"], $replyClass, $link_open, md5($d['email']), urlencode($url), $link_close, $d["name"], $d["body"], date('H:i \o\n d M Y',$d['dt']), $timeago, $replyLink, $replyFormXHTML, $adminTools, $special_hidden_class, $says, $karmaStuff);
			
		}
	}
	
	
	
	/**
	* Generates the XHTML for a single comment
	*
	* @param	integer		The comment id
	* @param	string		The reply class (empty if it's not a reply)
	* @param	string		Html open link (<a ...>) (Empty if there is no link)
	* @param	string		Users email in md5 (gravatar needs this way)
	* @param	string		Default gravatar image in urlencode format (gravatar needs this as well)
	* @param	string		Html link close (</a>) (Empty if there is no link)
	* @param	string		Comment author name
	* @param	string		Comment body
	* @param	string		Date in a format to be used in title
	* @param	string		Date in a format to show in html (we use a time ago function to convert time)
	* @param	string		The reply link (will be empty if this is already a reply)
	* @param	string		The reply XHTML Form (will be empty if this is already a reply)
	* @param	string		Admin tools, like approve or remove (will be empty if admin is not in session - SO NORMALLY IS EMPTY)
	* @param	string		A special class for hidden comments. Well, if we are admin seeing comments, hidden ones will be shown, but this class will be used to distinguish hidden commets from normal ones
	* @param	string		Either "said" or "replied" string
	* @param	string		Karma stuff. Value, and form. Will be empty if karma is turned off.
	*
	* @return	string		returns a valid XHTML for that given comment
	*
	*/
	private function comment_XHTML($id, $replyClass, $link_open, $md5email, $urleUrl, $link_close, $name, $body, $date1, $timeago, $replyLink, $replyFormXHTML, $adminTools, $special_hidden_class, $says, $karmaStuff) {
		// Nothing much to say. Get the vars and mark up the XHTML
		$out	='<div class="comment id_'.$id.' '.$replyClass.' '.$special_hidden_class.'">
					<div class="com_wrapper">
						<a id="comment_'.$id.'"></a>
						<div class="avatar">
							'.$link_open.'
								<img alt="avatar" src="http://www.gravatar.com/avatar/'.$md5email.'?size=50&amp;default='.$urleUrl.'" />
							'.$link_close.'
						</div>
						
						<div class="name">'.$link_open.$name.$link_close.'</div>
						<div class="says">'.$says.'</div>
						
						<div class="body">'.$body.'</div>
						<div class="btn_tools" id="tools_'.$id.'">
							<div class="comment_date" title="Added at '.$date1.'">'.$timeago.'</div>
							'.$karmaStuff.'
							'.$replyLink.'
							<div class="admin_tools">
								'.$adminTools.'
							</div>
							<div class="commento_clear"></div>
						</div>
						<div class="commento_clear"></div>
						<div class="reply_container" id="rplcont_'.$id.'">
							'.$replyFormXHTML.'
						</div>
					</div>
				</div>
				';
		// return the xhtml
		return $out;
	}
	
	
	
	/**
	* Function commentUnderReview_XHTML()
	* It prepares to render a valid XHTML message for Under review comment.
	* This will only happen when someone post a new comment or reply, and the system is in moderation mode
	*
	* @param	integer		The comment or reply ID
	* @param	string		The reply class (will be empty if it is not a reply)
	*
	* @return	string		It return the XHTML
	*
	*/
	private function commentUnderReview_XHTML($id, $replyClass) {
		$out = '
		<div class="comment id_'.$id.' '.$replyClass.'">
			<p>
				'.$this->__L("THANKYOU1").'<br/>
				'.$this->__L("WAITREVIEW").'
			</p>
		</div>
		';
		return $out;
	}
	
	
	
	/**
	* Function noCommentsYet_XHTML()
	* This will output a messge of no commments yet.
	*
	* @param	string 		The page id/name. Like your blog post id, or page id or page name.... Anything really (IT COMES FROM build_comment_system FUNCTION)
	*
	* @return	string		It return the XHTML
	*
	*/
	private function noCommentsYet_XHTML($content_type, $content_id) {
		$out = "<p>".$this->__L("NOCOMMENTS")."</p><br/>";
		return $out;
	}
	
	
	
	/**
	* This will output a "new comment" Form
	*
	* @param	string 		The page id/name. Like your blog post id, or page id or page name.... Anything really (IT COMES FROM build_comment_system FUNCTION)
	*
	* @return	string		It return the XHTML form
	*
	*/
	public function comment_form_XHTML($content_type, $content_id) {
	
		$out = '
		<div id="addCommentContainer">
			<div class="no_javascript_no_form">'.$this->__L("NOJSNOCOMM").'</div>
			<div style="display: none;" class="yes_javascript_yes_form">
				<p>'.$this->__L("ADDCOMM").'</p>
				<form id="addCommentForm" method="post">
					<input type="hidden" name="content_type" value="'.$content_type.'" />
					<input type="hidden" name="content_id" value="'.$content_id.'" />
					<input type="hidden" name="parent" value="-" />
					<div>
						<label class="commento_label" for="name">'.$this->__L("YOURNAME").'</label>
						<input class="commento_textinput" type="text" name="name" id="name" />
						<br />
						<label class="commento_label" for="email">'.$this->__L("YOUREMAIL").'</label>
						<input class="commento_textinput" type="text" name="email" id="email" />
						<br />';
						
						//echo "is_user_logged = {$this->is_user_logged}";
								
						
						if($this->ask_web_address){
						
						$out .= '<label class="commento_label" for="url">'.$this->__L("YOURSITE").'</label>
						<input class="commento_textinput" type="text" name="url" id="url" />
						<br />';
						
						}
						
						
						
						$out .= '<label class="commento_label" for="body">'.$this->__L("YOURCOMM").'</label>
						<textarea name="body" id="body" cols="20" rows="5"></textarea>
						<br />
						<span class="comment_char_counter">'.$this->maxnumchars.'</span>
		';
		
		// If captcha is enabled, show it
		if ($this->captcha_enabled == true) {
			$out .= '
						<img alt="Comment Captcha Image" src="/commento/remote/commento_captcha/" class="commento_captcha_img commento_captcha_img_comm" />
						<a href="#" class="commento_change_image_comm">'.$this->__L("CHANGECAPTCHA").'</a>
						<div class="commento_clear"></div>
						
						<label for="commento_anti_bot_input">'.$this->__L("INSERTCAPTCHA").'</label>
						<br />
						<input type="text" name="commento_anti_bot_input" id="commento_anti_bot_input" class="commento_anti_bot_input" />
					';
		}
					
		$out .= '
						
						<input type="submit" id="submit" value="'.$this->__L("SUBMIT").'" />
					</div>
				</form>
				<div class="commento_clear"></div>
			</div>
		</div>
		';
		return $out;
		
	}
	
	
	
	/**
	* This will output a "new comment" Form but for the user logged in. It will use the session variables Name and Email on the form.
	*
	* @param	string 		The page id/name. Like your blog post id, or page id or page name.... Anything really (IT COMES FROM build_comment_system FUNCTION)
	*
	* @return	string		It return the XHTML form
	*
	*/
	public function comment_form_user_logged_in_XHTML($content_type, $content_id) {
		$out = '
		<div id="addCommentContainer">
			<div class="no_javascript_no_form">'.$this->__L("NOJSNOCOMM").'</div>
			<div style="display: none;" class="yes_javascript_yes_form">
				<p>'.$this->__L("ADDCOMM").'</p>
				<form id="addCommentForm" method="post">
					<input type="hidden" name="content_type" value="'.$content_type.'" />
					<input type="hidden" name="content_id" value="'.$content_id.'" />
					<input type="hidden" name="parent" value="-" />
					<div>
						<label for="name">'.$this->__L("YOURNAME").'</label>
						<input type="text" name="name" id="name" disabled="disabled" value="'.$this->commento_user_name.'" />
						<label for="email">'.$this->__L("YOUREMAIL").'</label>
						<input type="text" name="email" id="email" disabled="disabled" value="'.$this->commento_user_email.'" />';
						
											
						if($this->ask_web_address){
						$out .= '<label for="url">'.$this->__L("YOURSITE").'</label>
						<input type="text" name="url" id="url" />';
						}						
						
						$out .= '<label for="body">'.$this->__L("YOURCOMM").'</label>
						<textarea name="body" id="body" cols="20" rows="5"></textarea>
						<input type="submit" id="submit" value="'.$this->__L("SUBMIT").'" /><span class="comment_char_counter">'.$this->maxnumchars.'</span>
					</div>
				</form>
			</div>
		</div>
		';
		return $out;
	}
	
	
	
	/**
	* Function comment_closed_XHTML()
	* This will output a "Comments are closed" XHTML
	*
	* @param	string 		The page id/name. Like your blog post id, or page id or page name.... Anything really (IT COMES FROM build_comment_system FUNCTION)
	*
	* @return	string		It return the XHTML
	*
	*/
	public function comment_closed_XHTML($content_type, $content_id) {
		$out = '
		<div id="addCommentContainer">
			<p>'.$this->__L("COMMCLOSED").'</p>
		</div>
		';
		return $out;
	}
	
	
	
	/**
	* Function comment_only_register_XHTML()
	* This will output a "Comment only to registered users" XHTML. Will only be shown when system is set to logged in users only, and user is not logged in
	*
	* @param	string 		The page id/name. Like your blog post id, or page id or page name.... Anything really (IT COMES FROM build_comment_system FUNCTION)
	*
	* @return	string		It return the XHTML
	*
	*/
	public function comment_only_register_XHTML($content_type, $content_id) {
		$out = '
		<div id="addCommentContainer">
			<p>'.$this->__L("LOGGINFIRST").'</p>
		</div>
		';
		return $out;
	}
	
	
	
	/**
	* Function reply_form_XHTML()
	* This will output a "Reply" Form XHTML
	*
	* @param	integer 	The parent comment id
	* @param	string 		The page id/name. Like your blog post id, or page id or page name.... Anything really (IT COMES FROM build_comment_system FUNCTION)
	*
	* @return	string		It return the XHTML form
	*
	*/
	public function reply_form_XHTML($id, $content_type, $content_id) {
		$out = '
		<div class="no_javascript_no_form">'.$this->__L("NOJSNOCOMM").'</div>
		<div style="display: none;" class="yes_javascript_yes_form">
			<form id="addCommentReply_'.$id.'" class="addReplyForm" method="post">
				'.$this->__L("ADDREPLY").'
				<input type="hidden" name="content_type" id="reply_content_type_'.$id.'" value="'.$content_type.'" />
				<input type="hidden" name="content_id" id="reply_content_id_'.$id.'" value="'.$content_id.'" />
				<input type="hidden" name="parent" value="'.$id.'" />
				<div>				
					<label class="commento_label" for="reply_name_'.$id.'">'.$this->__L("YOURNAME").'</label><br>
					<input class="commento_textinput" type="text" name="name" id="reply_name_'.$id.'" />
					
					<label class="commento_label" for="reply_email_'.$id.'">'.$this->__L("YOUREMAIL").'</label><br/>
					<input class="commento_textinput" type="text" name="email" id="reply_email_'.$id.'" />';
					if($this->ask_web_address){
					$out .= '<label class="commento_label" for="reply_url_'.$id.'">'.$this->__L("YOURSITE").'</label><br />
					<input class="commento_textinput" type="text" name="url" id="reply_url_'.$id.'" />';
					}
					$out .= '<label class="commento_label" for="reply_body_'.$id.'">'.$this->__L("YOURCOMM").'</label><br/>
					<textarea class="reply_text_area" name="body" id="reply_body_'.$id.'"></textarea>
					<span id="rpl_count_'.$id.'" class="reply_char_counter">'.$this->Replymaxnumchars.'</span>
		';
		
		// If captcha is enabled, show it
		if ($this->captcha_enabled == true) {
			$out .= '
					<img alt="Commento Captcha Image" src="/commento/remote/commento_captcha" class="commento_captcha_img commento_captcha_img_repl cci_rpl_'.$id.'" />
					<a href="#" id="cgi_rpl_'.$id.'" class="commento_change_image_repl">'.$this->__L("CHANGECAPTCHA").'</a>
					
					<div class="commento_clear"></div>
					<label for="commento_anti_bot_input_'.$id.'">'.$this->__L("INSERTCAPTCHA").'</label>
					<br>
					<input type="text" id="commento_anti_bot_input_'.$id.'" name="commento_anti_bot_input" class="commento_anti_bot_input" />
					';
		}
					
		$out .= '
					<input type="submit" class="reply_submit" id="reply_submit_'.$id.'" value="'.$this->__L("SUBMIT").'" />
				</div>
			</form>
		</div>
		';
		return $out;
	}
	
	
	
	/**
	* Function reply_form_user_logged_in_XHTML()
	* This will output a "Reply Form only to registered users" XHTML. Will only be shown when system is set to logged in users only, and user is not logged in
	*
	* @param	integer 	The parent comment id
	* @param	string 		The page id/name. Like your blog post id, or page id or page name.... Anything really (IT COMES FROM build_comment_system FUNCTION)
	*
	* @return	string		It return the XHTML form
	*
	*/
	public function reply_form_user_logged_in_XHTML($id, $content_type, $content_id) {
		$out = '
		<div class="no_javascript_no_form">'.$this->__L("NOJSNOCOMM").'</div>
		<div style="display: none;" class="yes_javascript_yes_form">
			<form id="addCommentReply_'.$id.'" class="addReplyForm" method="post">
				'.$this->__L("ADDREPLY").'
				<input type="hidden" name="content_type" id="reply_content_type_'.$id.'" value="'.$content_type.'" />
				<input type="hidden" name="content_id" id="reply_content_id_'.$id.'" value="'.$content_id.'" />
				<input type="hidden" name="parent" value="'.$id.'" />
				<div>				
					<label class="commento_label" for="reply_name_'.$id.'">'.$this->__L("YOURNAME").'</label><br>
					<input class="commento_textinput" type="text" name="name" id="reply_name_'.$id.'" disabled="disabled" value="'.$this->commento_user_name.'" />
					
					<label class="commento_label" for="reply_email_'.$id.'">'.$this->__L("YOUREMAIL").'</label><br/>
					<input class="commento_textinput" type="text" name="email" id="reply_email_'.$id.'" disabled="disabled" value="'.$this->commento_user_email.'" />';
					if($this->ask_web_address){
					$out .= '<label class="commento_label" for="reply_url_'.$id.'">'.$this->__L("YOURSITE").'</label><br />
					<input class="commento_textinput" type="text" name="url" id="reply_url_'.$id.'" />';
					}
					$out .= '<label class="commento_label" for="reply_body_'.$id.'">'.$this->__L("YOURCOMM").'</label><br/>
					<textarea class="reply_text_area" name="body" id="reply_body_'.$id.'"></textarea>
					<input type="submit" class="reply_submit" id="reply_submit_'.$id.'" value="'.$this->__L("SUBMIT").'" /><span id="rpl_count_'.$id.'" class="reply_char_counter">'.$this->Replymaxnumchars.'</span>
				</div>
			</form>
		</div>
		';
		return $out;
	}
	
	
	
	/**
	* Function reply_form_closed_XHTML()
	* This will output a "Comments are closed" message instead of form. Used when comments are closed
	*
	*
	* @return	string		It return the XHTML
	*
	*/
	public function reply_form_closed_XHTML() {
		$out = '
		<div>
			<p>'.$this->__L("COMMCLOSED").'</p>
		</div>
		';
		return $out;
	}
	
	
	
	/**
	* Function karma_system()
	* Builds the karma system (called by pre_Markup() function)
	*
	* @param	integer 	The actual karma value
	* @param	integer 	Number of down votes
	* @param	integer 	Number of up votes
	* @param	integer 	The comment id
	*
	* @return	string		It return the XHTML
	*
	*/
	private function karma_system($karma, $dwn_votes, $up_votes, $com_id) {
		
		// Tricky check here man!
		// (Is Karma on ?) AND ((is it type cookie?)  or  (is it type user AND system is user logged in only AND is user logged in?))
		if (($this->karma_on == true) and ( ($this->karma_type == "cookie") or ( ($this->karma_type == "user") and ($this->reg_users_only == true) and ($this->is_user_logged == true) ) ) ) {
			// now just checking if is positive values, negative or neutral :)
			if ($karma > 0) {
				$k_val 		= "+".$karma;
				$k_class	= "karma_positive";
				$k_title	= $this->__L("KARMAPOSITIVE") . $up_votes . $this->__L("XVOTESUP") .$dwn_votes . $this->__L("XVOTESDOWN") ;
			} else if ($karma < 0) {
				$k_val 		= $karma;
				$k_class	= "karma_negative";
				$k_title	= $this->__L("KARMANEGATIVE") . $up_votes . $this->__L("XVOTESUP") .$dwn_votes . $this->__L("XVOTESDOWN") ;
			} else {
				$k_val 		= $karma;
				$k_class	= "";
				$k_title	= $this->__L("KARMANEUTRAL") . $up_votes . $this->__L("XVOTESUP") .$dwn_votes . $this->__L("XVOTESDOWN") ;
			}
			
			// Build the XHTML
			$karmaStuff	=	'
							<div id="karma_'.$com_id.'" class="karma '.$k_class.'" title="'.$k_title.'">'.$k_val.'</div>
							<div  id="karma_vote_'.$com_id.'" class="vote">
								<a id="karma_vote_up_'.$com_id.'" class="vote_up" href="#"></a><a id="karma_vote_down_'.$com_id.'" class="vote_down" href="#"></a><span id="karma_msg_'.$com_id.'" class="karma_msg"></span>
							</div>
							';
			
			// and return it
			return $karmaStuff;
			
		} else {
			// if karma is off, yes return nothing
			return "";
		}
		
	}
	
	
	
	/**
	* Function karma_vote()
	* This is Ajax called, when a vote button is pressed.
	*
	* @param	integer 	The comment or reply ID
	* @param	integer 	Either "up" pr "down" vote
	*
	* @return	array		It returns a JSON encoded array with the status and extra information
	*
	*/
	public function karma_vote($ID, $UPorDOWN) {
		// Check if user already voted on this ID
		if ($this->karma_checkAlreadyVoted($ID) !== true) {
			// did not vote yet, so is voting up or down
			if ($UPorDOWN == "up")
				$final_karma = $this->karma_increaseVote($ID);
			else
				$final_karma = $this->karma_decreaseVote($ID);
			
			// Now prepare the output, dependingon total karma after voting
			if ($final_karma > 0) {
				$state_class 	= "karma_positive";
				$final_karma	= "+" . $final_karma;
			} else if ($final_karma < 0) {
				$state_class 	= "karma_negative";
				$final_karma	= $final_karma;
			} else {
				$state_class 	= "";
				$final_karma	= "0";
			}
			// Return the success JSON array, with a message, a state class (either positive, negative or neutral to be styled by CSS) and the final karma value
			return json_encode(array( 'status' => 1, 'message' => $this->__L("THANKYOU1"), 'state_class' => $state_class, 'final_karma' => $final_karma ));
		} else {
			// user already voted. Return fail JSON with message (Already Voted)
			return json_encode(array( 'status' => 0, 'message' => $this->__L("ALREADYVOTED") ));
		}
	}
	
	
	
	/**
	* Function karma_increaseVote()
	* It increases one vote
	*
	* @param	integer 	The comment or reply ID
	*
	* @return	integer		Return the total karma value after increasing one vote
	*
	*/
	private function karma_increaseVote($ID) {
		// update the comment up vote value by one
		mysql_query("UPDATE {$this->db->dbprefix}commento_comments SET up_vote = up_vote + 1 WHERE id = '$ID'");
		// get the initial karma value, before adding new vote
		$result 		= mysql_query("SELECT karma FROM {$this->db->dbprefix}commento_comments where id = '$ID'") or die("error db - com.class #" . __line__);
		$row 			= mysql_fetch_object($result);
		$intial_karma 	= $row->karma;
		// adds one more vote
		$final_karma	= $intial_karma + 1;
		// updates karma with new vote
		mysql_query("UPDATE {$this->db->dbprefix}commento_comments SET karma = '$final_karma' WHERE id = '$ID'");
		// returns final karma value
		return $final_karma;
	}
	
	
	
	/**
	* Function karma_decreaseVote()
	* It decreases one vote
	*
	* @param	integer 	The comment or reply ID
	*
	* @return	integer		Return the total karma value after decreasing one vote
	*
	*/
	private function karma_decreaseVote($ID) {
		// update the comment down vote value by one
		mysql_query("UPDATE {$this->db->dbprefix}commento_comments SET dw_vote = dw_vote + 1 WHERE id = '$ID'");
		// get the initial karma value, before adding new vote
		$result 		= mysql_query("SELECT karma FROM {$this->db->dbprefix}commento_comments where id = '$ID'") or die("error db - com.class #" . __line__);
		$row 			= mysql_fetch_object($result);
		$intial_karma 	= $row->karma;
		// subtracts one vote from initial karma
		$final_karma	= $intial_karma - 1;
		// updates karma value
		mysql_query("UPDATE {$this->db->dbprefix}commento_comments SET karma = '$final_karma' WHERE id = '$ID'");
		// returns final karma value
		return $final_karma;
	}
	
	
	
	/**
	* Function karma_checkAlreadyVoted()
	* This function will check if user already voted. Depending on your configuration, 
	* will either check for cookies, or user logged in variable
	*
	* @param	integer 	The comment or reply ID
	*
	* @return	boolean		if wither user has voted or not
	*
	*/
	private function karma_checkAlreadyVoted($ID) {
		// get your configuration karma type (Cookie, or User)
		$type = $this->karma_type;
		
		// check type, is it cookie based ?
		if ($type == "cookie") {
			// prepare our cookie name. MD5 it so it's not so user friendly
			$cookie_name = md5("Commento_karma_votes");
			// check if it exists
			if (isset($_COOKIE[$cookie_name])) {
				// well cookie exists. Explode it's value (So we can have an array with all the ID's user has voted already)
				$cookie_arr = explode("|", $_COOKIE[$cookie_name]);
				// Is the actual ID in the cookie content array
				if (in_array($ID, $cookie_arr)) {
					// yes it is, so user already voted
					return true;
				} else {
					// no, user has not voted in this ID yet. So prepare new cookie content. Content will be equel to the old content plus the new ID
					$cookie_content = $_COOKIE[$cookie_name] . $ID . "|";
					// write cookie
					setcookie($cookie_name, $cookie_content, time()+3600*24*365*10);
					// return false (User has not voted yet
					return false;
				}
			
			// cookie does not exist. Not only user hasn't voted on this ID, but also he has never voted
			} else {
				// prepare cookie content
				$cookie_content = $ID."|";
				// wright cookie
				setcookie($cookie_name, $cookie_content, time()+3600*24*365*10);
				// return false (User has not voted yet
				return false;
			}
			
		// Oh well... voting only for registered users.
		} else if ($type == "user") {
			// So get users email
			$email 	= $this->commento_user_email;
			// check if we have it's email in our database having in mind the actual comment or reply ID
			$result = mysql_query("SELECT id FROM {$this->db->dbprefix}commento_karma_voted WHERE com_id = '$ID' AND email = '$email'");
			// if it returns more than zero rows, he is already in our table. He has voted on this one
			if (mysql_num_rows($result) > 0)
				return true;
			
			// Above return nothing so, insert a new value to database
			mysql_query("INSERT INTO {$this->db->dbprefix}commento_karma_voted(id, com_id, email) VALUES ('', '$ID', '$email')");
			// return false (User has not voted yet
			return false;
		}
	}
	
	
	
	/**
	* Function validate()
	* Here we have one of our most important functions. A public one, that will be called from outside.
	* Whenever a comment or a reply is sent (VIA AJAX), this is the first shot. Validate all input.
	* Notice the $arr passed in there as a parameter, with the ampersand. It is meant to crate a reference of
	* the original $arr variable inside comax.processor.php so we can change one, and another simultaneously
	*
	* @param	array 		empty array, to be created reference and fill it with valid data, or the errors
	* @param	string 		post type, to check if are we validating a reply or a comment
	* @param	string 		auto resets to empty. When we're validating a reply, this parameter must bring the parent page name/id
	*
	* @return	boolean		tru or false. if inputs are valid or not.
	*
	*/
	public function validate(&$arr, $postType, $parentID = "") {
		
		// set array vars for data and erros
		$errors = array();
		$data	= array();
		
		// check what post type is and assign the propper post input names
		if ($postType === "reply") {
			$field_content_id 	= "reply_content_id_".$parentID;
			$field_parent 	= "reply_parent_".$parentID;
			$field_email 	= "reply_email_".$parentID;
			$field_url 		= "reply_url_".$parentID;
			$field_body 	= "reply_body_".$parentID;
			$field_name 	= "reply_name_".$parentID;
			$field_captcha 	= "commento_anti_bot_input_".$parentID;
		} else {
			$field_content_type 	= "content_type";
			$field_content_id 	= "content_id";
			$field_parent 	= "parent";
			$field_email 	= "email";
			$field_url 		= "url";
			$field_body 	= "body";
			$field_name 	= "name";
			$field_captcha 	= "commento_anti_bot_input";
		}

		// Using the filter_input function introduced in PHP 5.2.0
		if (!($data['content_type'] = filter_input(INPUT_POST,'content_type',FILTER_SANITIZE_STRING))) {
			$errors["$field_content_type"] = $this->__L("REFIDPROB");
		}
		
		// Using the filter_input function introduced in PHP 5.2.0
		if (!($data['content_id'] = filter_input(INPUT_POST,'content_id',FILTER_SANITIZE_STRING))) {
			$errors["$field_content_id"] = $this->__L("REFIDPROB");
		}
		
		// Using the filter_input function introduced in PHP 5.2.0
		if (!($data['parent'] = filter_input(INPUT_POST,'parent',FILTER_SANITIZE_STRING))) {
			$errors["$field_parent"] = $this->__L("REFIDPROB");
		}
		
		// Using the filter_input function introduced in PHP 5.2.0
		// but wait. Check if our system is running in registered users only. If true, the field email will come empty and then we MUST use our email variable $this->commento_user_email
		if ($this->reg_users_only == false) {
			if (!($data['email'] = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL))) {
				$errors["$field_email"] = $this->__L("VALIDEMAIL");
			}
		} else {
			if ((!$data['email'] = filter_var($this->commento_user_email,FILTER_VALIDATE_EMAIL))) {
				$errors["$field_email"] = $this->__L("EMAILERROR") . ' - com.class (' . __LINE__ . ').';
			}
		}
		
		// Using the filter_input function introduced in PHP 5.2.0
		if (!($data['url'] = filter_input(INPUT_POST,'url',FILTER_VALIDATE_URL))) {
			// If the URL field was not populated with a valid URL, act as if no URL was entered at all
			$url = '';
		}
		
		// Using the filter with a custom callback function:
		if (!($data['body'] = filter_input(INPUT_POST,'body',FILTER_CALLBACK,array('options' => array($this, 'validate_comment'))))) {
			$errors["$field_body"] = $this->__L("VALIDCOMM");
		} else {
			// Using the filter with a custom callback, now checking for bad words
			// NOTE here we just test the output assigning to a new var $test. Because we do not want to assign the output
			// to te body, cause that function messes with line breaks. All we need to know anyway is if return a string (true) or false.
			if (!($test = filter_input(INPUT_POST,'body',FILTER_CALLBACK,array('options' => array($this, 'checkBadWords'))))) {
				$errors["$field_body"] = $this->__L("WATCHLANGUAGE");
			}
		}
		
		// Using the filter_input function introduced in PHP 5.2.0 with another callback function
		// Again check if our system is running in registered users only. If true, the field name will come empty and then we MUST use our user name variable $this->commento_user_name
		if ($this->reg_users_only == false) {
			if (!($data['name'] = filter_input(INPUT_POST,'name',FILTER_CALLBACK,array('options' => array($this, 'validate_text'))))) {
				$errors["$field_name"] = $this->__L("VALIDNAME");
			}
		} else {
			if (!($data['name'] = filter_var($this->commento_user_name,FILTER_SANITIZE_STRING))) {
				$errors["$field_name"] = $this->__L("NAMEERROR") . ' - com.class (' . __LINE__ . ').';
			}
		}
		
		// right, almost finished. Is captcha on? (also check if system is not to registered users only. If it is, no point in checking captcha)
		if (($this->captcha_enabled == true) and ($this->reg_users_only == false)) {
			// If system is not for registered users only, and we have captcha enabled, check it please.
			
			$commento_random_number = $this->session->userdata('commento_random_number');
			
			
			if (md5($_POST['commento_anti_bot_input']) !== $commento_random_number )	{ 
				$errors["$field_captcha"] = $this->__L("VALIDCAPTCHA");
			}
		}
		
		// If there are errors, copy the $errors array to $arr
		if(!empty($errors)){
			$arr = $errors;
			return false;
		}
		
		// If the data is valid, sanitize all the data and copy it to $arr
		foreach ($data as $k=>$v) {
			$arr[$k] = mysql_real_escape_string($v);
		}
		
		// Ensure that the email is lower case
		$arr['email'] = strtolower(trim($arr['email']));
		
		// Return true. Data cleaned and ready :)
		return true;
		
	}
	
	
	
	/**
	* Function validate_comment()
	* Special function, to be called internally from the filter_input function callback above.
	* it will validate the body of the comment or reply. Will use, depending on your configuration
	* a few options. HTMLPurifier, convert urls to links, smiles, etc... It return a clean an valid
	* comment (string) but it might sometimes return empty string. If all user inputs is crap, 
	* this function will strip all, and return empty. Causing the above user_input to trow an error. (EMPTY BODY)
	*
	* @param	string 		The comment body (text)
	*
	* @return	string		always returns the filtered comment.
	*
	*/
	private function validate_comment($str) {
		
		// get your allowed html tags from the configuration
		$html = $this->allowed_html;
		
		
		$this->load->helper('htmlpurifier');
		
		$str = purify($str);
		
		
		
		// Convert the new line characters to <br> tags:
		$str = nl2br($str);
		
		// If config allows, convert any url to a link with nofollow and target blank
		if ($this->conv_url_to_link == true) {
			if (preg_match('@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)*)@',$str,$match)) {	
				if ($match[2]!="") {
					$str = str_replace($match[0], "<a rel=\"nofollow\" target=\"blank\" href=\"".$match[1]."\">$match[1]</a>", $str);
				} else {
					$str = str_replace($match[0], "<a rel=\"nofollow\" target=\"blank\" href=\"http://".$match[1]."\">$match[1]</a>", $str);
				}
			}
		}
		
		// fixes smilies (notice two passes)
		$str = $this->smileTreaterFASE2($this->smileTreaterFASE1($str));
		
		// Remove the new line characters that are left
		$str = str_replace(array(chr(10),chr(13)),'',$str);
		
		// return the cleaned string
		return $str;
	}
	
	
	
	/**
	* Function validate_text()
	* Again, another special function, to be called internally from the filter_input function callback.
	* This one will only clean the name input. Convert any special characters, etc
	*
	* @param	string 		The comment name input (text)
	*
	* @return	string		always returns the filtered name string.
	*
	*/
	private function validate_text($str) {
		
		// It's not empty is it?
		if(mb_strlen($str,'utf8')<1)
			return false;
		
		// Encode all html special characters (<, >, ", & .. etc) and convert the new line characters to <br> tags:
		$str = nl2br(htmlspecialchars($str));
		
		// Remove the new line characters that are left
		$str = str_replace(array(chr(10),chr(13)),'',$str);
		
		// return cleaned name string
		return $str;
	}
	
	
	
	/**
	* Function smileTreaterFASE1()
	* Function to convert smilies. Fase on because here we first convert any :) to :smile:
	* Why? well because ) would be treated as a special character. And in case you might want to
	* do some check before the actual image conversion (nest function) it's safer having them
	* in this format. In our application this is quite useless because we call them sequentially
	* But just in case, two separate function. Fase one (this) and fase two (next func)
	*
	* @param	string 		The comment body (text)
	*
	* @return	string		always returns thebody string with the filtered smiles :)
	*
	*/
	private function smileTreaterFASE1($str) {
		
		// prepare conversion array
		$sm[':D'] = $sm[':oD'] = $sm[':-D'] = $sm[':))'] = $sm[':o))'] = $sm[':-))'] 	= ':biggrin:';
		$sm[':)'] = $sm[':o)'] = $sm[':-)'] 											= ':smile:';
		$sm[';)'] = $sm[';o)'] = $sm[';-)'] 											= ':wink:';
		$sm[':|'] = $sm[':o|'] = $sm[':-|'] 											= ':neutral:';
		$sm[':/'] = $sm[':o/'] = $sm[':-/'] 											= ':unsure:';
		$sm[':['] = $sm[':o['] = $sm[':-['] = $sm[':('] = $sm[':o('] = $sm[':-('] 		= ':sad:';
		$sm[':P'] = $sm[':oP'] = $sm[':-P'] 											= ':tongue:';
		$sm[':o'] = $sm[':oO'] = $sm[':-o'] = $sm[':0'] = $sm[':O']						= ':surprised:';
		$sm[':x'] = $sm[':ox'] = $sm[':-x'] 											= ':angry:';
		
		// now loop and string replace any :) for :smile: or :P for :tongue: etc
		if(count($sm)) {
			$str = str_replace('://', ':µ/', $str);
			reset($sm);
			while(list($code, $img) = each($sm)) {
				$image = $img;
				$str = str_replace($code, $image, $str);
			}
			$str = str_replace(':µ/', '://', $str);
		}
		return $str;
	}
	
	
	
	/**
	* Function smileTreaterFASE2()
	* Fase two. Almost the same, but now we transalate the :smile: for the actual image tag
	*
	* @param	string 		The comment body (text)
	*
	* @return	string		always returns thebody string with the filtered smiles :)
	*
	*/
	private function smileTreaterFASE2($str) {
		
		// prepare the conversion array
		$sm2[':biggrin:'] = 'biggrin.png';
		$sm2[':smile:'] = 'smile.png';
		$sm2[':wink:'] = 'wink.png';
		$sm2[':neutral:'] = 'neutral.png';
		$sm2[':unsure:'] = 'unsure.png';
		$sm2[':sad:'] = 'sad.png';
		$sm2[':tongue:'] = 'tongue.png';
		$sm2[':surprised:'] = 'surprised.png';
		$sm2[':angry:'] = 'angry.png';
		
		// Loop trough all, and replace :smile: for a proper image tag (<img src="...blah...blah.../smile.png" width="16" height="16" align="absmiddle" />
		// remember that the smiles folder is configured at the top __construct() function. Make sure it's correct there. This will start to be saved into database
		if(count($sm2)) {
			$str = str_replace('://', ':µ/', $str);
			reset($sm2);
			while(list($code, $img) = each($sm2)) {
				$image = '<img src="' . $this->page_url . $this->smiles_folder . $img . '" width="16" height="16" align="absmiddle" />';
				$str = str_replace($code, $image, $str);
			}
			$str = str_replace(':µ/', '://', $str);
		}
		return $str;
	}
	
	
	
	/**
	* Function checkBadWords()
	* Easy one, loop trought your configuration bad words and check for any matches
	*
	* @param	string 		The comment body (text)
	*
	* @return	mixed		either return false (bad word found) or the original string (meaning true, no bad words found)
	*
	*/
	private function checkBadWords($str) {
		
		// get your config bad words
		$the_blacklist = $this->blacklist;
		
		// it's not empty is it? if it's empty, badwords is disabled
		if ($the_blacklist != "") {
			// remove any spaces
			$the_blacklist = str_replace (" ", "", $the_blacklist);
			// explode by comma, and create an array
			$the_blacklist = explode(",", $the_blacklist);
			// loop trough all of them, and check
			foreach($the_blacklist as $blackItem) {
				if(stripos($str, $blackItem) !== false) {
					$str = false;
					break;
				}
			}
		}
		return $str;
	}
	
	
	
	/**
	* Function time_ago()
	* Cool function for time to time ago conversion.
	*
	* @param	timestamp 	The comment creation UNIX Timestamp
	*
	* @return	string		the compiled phrase with the time ago values
	*
	*/
	function time_ago($time) {
		// periods array
		$singular_periods 	= array($this->__L("SSECOND"), $this->__L("SMINUTE"), $this->__L("SHOUR"), $this->__L("SDAY"), $this->__L("SWEEK"), $this->__L("SMONTH"), $this->__L("SYEAR"), $this->__L("SDECADE"));
		$plural_periods 	= array($this->__L("PSECOND"), $this->__L("PMINUTE"), $this->__L("PHOUR"), $this->__L("PDAY"), $this->__L("PWEEK"), $this->__L("PMONTH"), $this->__L("PYEAR"), $this->__L("PDECADE"));
		
		// lengths array
		$lengths = array("60","60","24","7","4.35","12","10");
		
		// get now :)
		$now = time();
		
		// get difference
		$difference = $now - $time;
		$tense 		= $this->__L("AGO");
		
		// finds periods difference
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}
		
		// round difference
		$difference = round($difference);
		
		// check for singular or plural
		if($difference == 1) {
			$period = $singular_periods[$j];
		} else {
			$period = $plural_periods[$j];
		}
		
		// return the compiled string
		return "$difference $period $tense";
	}
	
	
	
	/**
	* Function insert_new_comment()
	* Important function. Also Public this one, called from the commento.processor.php 
	* when an AJAX call is made to insert new comment or reply. This one will only be called
	* after validate() function. NEVER call this one before.
	* Notice the $arr passed in there as a parameter, with the ampersand. It is meant to crate a reference of
	* the original $arr variable inside comax.processor.php so we can add new values to it. LIKE IT'S NEW ID
	*
	* @param	array 		Array containing all the values
	*
	* @return	array		Containing the original values plus new ones
	*
	*/
	public function insert_new_comment(&$arr) {
		
		// first set it to be shown
		$show_it = 1;
		
		// but then check if system is in moderation mode. If tru, set it to be hidden
		if (($this->mod_comment == true) or ($this->mod_comments == true))
			$show_it = 0;
		
		// insert data into database
		mysql_query("INSERT INTO {$this->db->dbprefix}commento_comments(content_type, content_id, parent, name, url, email, body, show_it)
						VALUES (
						
							'".$arr['content_type']."',
							'".$arr['content_id']."',
							'".$arr['parent']."',
							'".$arr['name']."',
							'".$arr['url']."',
							'".$arr['email']."',
							'".$arr['body']."',
							'".$show_it."'
						)"
					);
		
		// get the inserted date
		$arr['dt'] = date('r',time());
		
		// get the inserted ID
		$arr['id'] = mysql_insert_id();
		
		// return the array
		return $arr;
	}
	
	
	
	/**
	* Function paginate()
	* Private and independent function. It's called upon the build_comment_system() function call
	* it builds the pagination system, according to current states and configurations.
	*
	* It doesn't return anything. It only prepares a $this->return variable ready to be return
	* when necessary. And will be necessary when we call the newt function display_pages()
	*
	* ALSO note this function is not entirly mine. 
	* Taken from http://net.tutsplus.com/tutorials/php/how-to-paginate-data-with-php/
	*
	*/
	private function paginate() {
		
		// check if we have set a request for the items per page
        if ((isset($_REQUEST['ipp'])) and ($_REQUEST['ipp'] == 'ALL')) {
            $this->num_pages = ceil($this->items_total/intval($this->default_ipp));
            $this->items_per_page = intval($this->default_ipp);
        } else {
            if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = intval($this->default_ipp);
            $this->num_pages = ceil($this->items_total/$this->items_per_page);  
			
        }
		
		// check the requested page number (make sure it's numeric and greater than 0
		// if not, ok zero will be fine for now, we are viewing last page (or first, depending on your order)
		if ((isset($_REQUEST['coms_page'])) and ($_REQUEST['coms_page'] > 0))
			$this->current_page = (int)$_REQUEST['coms_page']; // must be numeric > 0
		else
			$this->current_page = 0;
        
		// check your order, and set current page according
		if($this->current_page < 1 OR !is_numeric($this->current_page)) 
			if ($this->display_order == "ASC")
				$this->current_page = $this->num_pages;
			else
				$this->current_page = 1;
		
        // make sure current page is not bigger than the total number of pages
		if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
        
		// set previous page
		$prev_page = $this->current_page-1;
		// set next page
        $next_page = $this->current_page+1;
		
		// if number of pages is bigger than ten (10) we need to prepare the output having in mind a mid range factor.
		// you know, that thing like [1] ... [9] [10] [11 SELECTED] [12] [13] ...  [+999]
        if($this->num_pages > 10) {
			$new_params["coms_page"] = $prev_page;
			$new_params["ipp"] 	= $this->items_per_page;
			$URL = $this->addUrlParams($new_params);
            $this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<a class=\"paginate\" href=\"$URL\">« ".$this->__L("PREPAGE")."</a> ":"<span class=\"inactive\" href=\"#\">« ".$this->__L("PREPAGE")."</span> ";
			
            $this->start_range = $this->current_page - floor($this->mid_range/2);
            $this->end_range = $this->current_page + floor($this->mid_range/2);
			
            if($this->start_range <= 0) {  
                $this->end_range += abs($this->start_range)+1;
                $this->start_range = 1;
            }
			
            if($this->end_range > $this->num_pages) {
                $this->start_range -= $this->end_range-$this->num_pages;
                $this->end_range = $this->num_pages;
            }
			
            $this->range = range($this->start_range,$this->end_range);
			
            for($i=1;$i<=$this->num_pages;$i++) {
                if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= " <span>...</span> ";  
                
				// loop through all pages. if first, last, or in range, display  
                if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range)) {
					$new_params["coms_page"] = $i;
					$new_params["ipp"] 	= $this->items_per_page;
					$URL = $this->addUrlParams($new_params);
                    $this->return .= ($i == $this->current_page And @$_REQUEST['coms_page'] != 'ALL') ? "<a title=\"".$this->__L("GOTOPAGE")." $i ".$this->__L("OF")." $this->num_pages\" class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" title=\"".$this->__L("GOTOPAGE")." $i ".$this->__L("OF")." $this->num_pages\" href=\"$URL\">$i</a> ";  
                }
                if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= " <span>...</span> ";  
            }
            
			$new_params["coms_page"] = $next_page;
			$new_params["ipp"] 	= $this->items_per_page;
			$URL = $this->addUrlParams($new_params);
			$this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($_REQUEST['coms_page'] != 'ALL')) ? "<a class=\"paginate\" href=\"$URL\">".$this->__L("NEXTPAGE")." »</a>\n":"<span class=\"inactive\" href=\"#\">» ".$this->__L("NEXTPAGE")."</span>\n";
			
			$new_params["coms_page"] = "1";
			$new_params["ipp"] 	= "ALL";
			$URL = $this->addUrlParams($new_params);
            $this->return .= (@$_REQUEST['coms_page'] == 'ALL') ? "<a class=\"current\" style=\"margin-left:10px\" href=\"#\">".$this->__L("ALLPAGES")."</a> \n":"<a class=\"paginate\" style=\"margin-left:10px\" href=\"$URL\">".$this->__L("ALLPAGES")."</a> \n";
		
		// we have less than 10 pages, set normal output
        } else {
            for($i=1;$i<=$this->num_pages;$i++) {
				$new_params["coms_page"] = $i;
				$new_params["ipp"] 	= $this->items_per_page;
				$URL = $this->addUrlParams($new_params);
				if (isset($_REQUEST["ipp"]))
					$this->return .= (($i == $this->current_page) AND ($_REQUEST['ipp'] != 'ALL')) ? "<a class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" href=\"$URL\">$i</a> ";  
				else
					$this->return .= ($i == $this->current_page) ? "<a class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" href=\"$URL\">$i</a> ";  
            }
			
			$new_params["coms_page"] = "1";
			$new_params["ipp"] 	= "ALL";
			
			$URL = $this->addUrlParams($new_params);
			
			$URL = urlencode($URL);
			
			$this->return .= ((isset($_REQUEST['ipp'])) and ($_REQUEST['ipp'] == 'ALL')) ? "<a class=\"current paginate allpages\" href=\"$URL\">".$this->__L("ALLPAGES")."</a> ":"<a class=\"paginate allpages\" href=\"$URL\">".$this->__L("ALLPAGES")."</a>  ";  
        }
		
		
        $this->low 		= ($this->current_page-1) * $this->items_per_page;
        $this->high 	= ((isset($_REQUEST['ipp'])) and ($_REQUEST['ipp'] == 'ALL')) ? $this->items_total:($this->current_page * $this->items_per_page)-1;
        $this->limit 	= ((isset($_REQUEST['ipp'])) and ($_REQUEST['ipp'] == 'ALL')) ? "":" LIMIT $this->low,$this->items_per_page";
    }
	
	// FUNCTION NOT IN USE
	// it's supposed to show a html select items per page form. Felt there is no point in that
    public function display_items_per_page() {  
        $items = '';
        $ipp_array = array(10,25,50,100,'ALL');  
        foreach($ipp_array as $ipp_opt)    $items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n":"<option value=\"$ipp_opt\">$ipp_opt</option>\n";  
        return "<span class=\"paginate\">Items per page:</span><select class=\"paginate\" onchange=\"window.location='" . getenv("REQUEST_URI") . "/?coms_page=1&ipp='+this[this.selectedIndex].value;return false\">$items</select>\n";  
    }
	
	// FUNCTION NOT IN USE
	// it's supposed to show a html select page form. Felt there is no point in that
    public function display_jump_menu() {
        for($i=1;$i<=$this->num_pages;$i++) {
            $option .= ($i==$this->current_page) ? "<option value=\"$i\" selected>$i</option>\n":"<option value=\"$i\">$i</option>\n";  
        }
        return "<span class=\"paginate\">Page:</span><select class=\"paginate\" onchange=\"window.location='" . getenv("REQUEST_URI") . "/?coms_page='+this[this.selectedIndex].value+'&ipp=$this->items_per_page';return false\">$option</select>\n";  
    }
	
	
	
	/**
	* Function display_pages()
	* This one actually returns all the processed content from the paginate() function above
	* again it's called from the build_comment_system() function
	* 
	* @param	string 		extra class, that is passed by build_comment_system() function. Will hold a class for the top or bottom pagination, so you can style different in CSS
	*
	* @return	string		returns a complete rendered pagination HTML system
	*
	*/
    public function display_pages($extra_class = "") {
        return '<div class="commento_paginator '.$extra_class.'"><span class="commento_paginator_title">'. $this->__L("PAGES") .':</span> ' . $this->return . '<br /></div>';
    }  
	
	
	
	/**
	* Function addUrlParams()
	* A very tricky and usefull function here. It will accept an array with url parameters,
	* the will inject these parameters to the actual browser page URL. Usefull because we are adding
	* parameters for the pagination page and stuff. But we want to keep all (if any) actual parameters in URL
	* 
	* @param	array 		The parameters we want to add to current url
	*
	* @return	string		return the complete full url with new parameters
	*
	*/
	function addUrlParams($new_params) {
		
		// get current url
		$url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
		
		// parse current url
		$query = parse_url($url, PHP_URL_QUERY);
		
		// set params array
		$params = array();
		
		// throw any current params to an array
		parse_str($query, $params);
		
		// merge the current params array, with the suplied new params array
		$params = array_merge($params, $new_params);
		
		// build new URL
		$query = http_build_query($params);
		
		// last, is this actually being show with AJAX. If yes, well just return OUR DESIRED PARAMS
		// because ajax will prevent default behaviour, no problem passing just the requested params
		if (isset($params["type"]) and ($params["type"] == "ajax_paginate")) {
			return "?coms_page=".$new_params["coms_page"]."&ipp=".$new_params["ipp"]."";
		}
		
		// return the full current url with new params
		return "?" . $query;
		//return $_SERVER["PHP_SELF"] . "?" . $query;
	}
	
	
	
	/**
	* Function __L()
	* Used to supply a translated string. I know we could get a good gript here using gettext, but thing is...
	* If you are going to include this into a project that already uses gettext, you will be fine converting this function
	* to a gettext equivalent. And this simple function is not about reinventing the wheel. Is just make things easier
	* for a normal end user. Let's be honest, gettext is not that staright forward :)
	* 
	* @param	string 		containing the array index you want the translation
	*
	* @return	string		the translated string value
	*
	*/
	public function __L($phrase){
		// set the global var from the language file
		//global $messages;

		//echo "LOADING " . $this->lang_folder . $this->current_lang . ".php";
			
		// now check if language file exists. If not, load default english
		//if (file_exists($this->lang_folder . $this->current_lang . ".php")){
		

			
		//	require_once ($this->lang_folder . $this->current_lang . ".php");
			
		//}else{
		//			require_once ($this->lang_folder . "en.php");
					
		//}
		
		return $this->lang->line($phrase);
			
		
		// return the desired message
		//return $messages[$phrase];
	}
	
	
	
	/**
	* Function getConfigurations()
	* Function used to retrieve database configurations
	* 
	* @param	string 		Containing what confiuration name is required. (ALL will retrieve array with all configurations)
	*
	* @return	mixed		Either the requested config name value as a string, or an array containing all the configurations names, and values
	*
	*/
	public function getConfigurations($wich = "all") {
	
		$config = array();

		if(!$this->db->table_exists('commento_config')) return $config;
		
		// So, we want all configs
		if ($wich == "all")
			$where_clause = "";
		else
			$where_clause = "WHERE cfg_name = '$wich'";
		
		
		$sql = "SELECT * FROM {$this->db->dbprefix}commento_config $where_clause ORDER BY id ASC";
		
		$query = $this->db->query($sql);
		
	
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row){
			
				// loop trought all results
				//while($row = mysql_fetch_assoc($result)) {
				$config[$row["cfg_name"]] = $row["cfg_value"];
				
			}
			
		
		}
		
		// again, if it's all, return full array result, else return single config value
		if ($wich == "all")
			return $config;
		else
			return $config[$wich];
	}
	
	
	
	/**
	* Function removeComment()
	* Removes a comment from the database.
	* NOTE this is the remove comment, from the front end. Only used on AJAX call
	* 
	* @param	integer 	The comment or reply ID number
	*
	* @return	array		JSON encoded array, with status and any necessary messages
	*
	*/
	public function removeComment($id) {
		
		// First check if it's admin
		if ($this->admin_viewing !== true)
			return json_encode(array( 'status' => 0, 'error' => $this->__L("NOTADMIN") ));
		
		// Then check if what we are removing has replies. If it does have replies, do not allow deletion
		if ($this->commentHasReplies($id) === true)
			return json_encode(array( 'status' => 0, 'error' => $this->__L("HASREPLIES") ));		
		
		// all ok, remove it from db
		mysql_query("DELETE FROM {$this->db->dbprefix}commento_comments WHERE id = '$id'");
		
		// return success
		return json_encode(array( 'status' => 1, 'error' => '' ));
	}
	
	
	
	/**
	* Function approveComment()
	* Approves a comment from the database.
	* NOTE this is the approve comment, from the front end. Only used on AJAX call
	* 
	* @param	integer 	The comment or reply ID number
	*
	* @return	array		JSON encoded array, with status and any necessary messages
	*
	*/
	public function approveComment($id) {
		
		// check if is admin
		if ($this->admin_viewing !== true)
			return json_encode(array( 'status' => 0, 'error' => $this->__L("NOTADMIN") ));
		
		// change status in db
		mysql_query("UPDATE {$this->db->dbprefix}commento_comments SET show_it = '1' WHERE id = '$id'");
		
		// return success
		return json_encode(array( 'status' => 1, 'error' => '' ));
	}
	
	
	
	
	
	
	
	
	
	// BELOW THIS ARE ONLY ADMIN PANEL RELATED FUNCTIONS //
	// Most of this functions do not have extended validation
	// because if we are calling them, IT'S SUPOSED TO BE AN ADMIN
	
	
	
	/**
	* Function saveConfiguration()
	* Saves a configuration value to the database.
	* 
	* @param	string 		Wich value are we changing. (Config name)
	* @param	string 		What is the new value. 		(Config value)
	*
	* @return	mixed		Returns success or die() eroor
	*
	*/
	public function saveConfiguration($wich, $what) {
		return mysql_query("UPDATE {$this->db->dbprefix}commento_config SET cfg_value = '$what' WHERE cfg_name = '$wich'") or die("HMMMM");
	}
	
	
	
	/**
	* Function adminGetMainComments()
	* Gets the comments count by page name/id
	* 
	*
	* @return	array		MySQL result
	*
	*/
	public function adminGetMainComments() {
	
		$result = mysql_query("SELECT content_type, content_id, COUNT(id) AS total FROM {$this->db->dbprefix}commento_comments GROUP BY content_id");
		return $result;
	}
	
	
	
	/**
	* Function adminGetUnreviewdTotalComments()
	* Gets the total number of unreviewed comments
	* 
	* @param	string		Requested page name/id
	*
	* @return	string		Number of results
	*
	*/
	public function adminGetUnreviewdTotalComments($content_type, $content_id) {
		$result = mysql_query("SELECT COUNT(id) AS total FROM {$this->db->dbprefix}commento_comments WHERE content_type = '$content_type' AND content_id = '$content_id' AND show_it = '0'");
		while($row = mysql_fetch_assoc($result)) {
			$out = $row["total"];
		}
		return $out;
	}
	
	
	
	/**
	* Function admin_build_comment_system()
	* Builds the normal comment system, but sets the special vars ($this->admin_viewing and $this->admin_viewing_backend) to true, so system know it's admin in admin panel
	* 
	* @param	string		Requested page name/id
	*
	* @return	string		The comment system XHTML (Remember, admin viewing in backend, no forms, and karma voting system will be included)
	*
	*/
	public function admin_build_comment_system($content_type, $content_id) {
		
		// sets the admin vars
		$this->admin_viewing 			= true;
		$this->admin_viewing_backend 	= true;
		
	
		// starts comments XHTML compiling process
		$out = $this->recursive_build_comment($content_type, $content_id);
		
		// returns output (XHTML Comments)
		return $out;
	}
	
	
	
	/**
	* Function admin_build_unreviewed_comment_system()
	* Builds the comment system but only for the unreviewd comments. Also sets the special vars ($this->admin_viewing and $this->admin_viewing_backend) to true, so system know it's admin in admin panel
	* 
	* @param	string		Requested page name/id
	*
	* @return	string		The comment system XHTML (Remember, admin viewing in backend, no forms, and karma voting system will be included)
	*
	*/
	public function admin_build_unreviewed_comment_system($content_type, $content_id) {
		$this->admin_viewing 			= true;
		$this->admin_viewing_backend 	= true;
		$out = $this->recursive_build_unreviewed_comment($content_type, $content_id);
		return $out;
	}
	
	
	
	/**
	* Function recursive_build_unreviewed_comment()
	* This a very similar function to the one in the beginning (recursive_build_comment). It does the same thing, although only show unreviewd comments and replies
	* 
	* @param	string		Requested page name/id
	*
	* @return	string		The comment system XHTML (Remember, admin viewing in backend, no forms, and karma voting system will be included)
	*
	*/
	private function recursive_build_unreviewed_comment($content_type, $content_id) {
		
		$sql_filters = array();
		
		$sql_filters[] = "show_it = '0'";
		
		$content_type_filter = "";
		
		if($content_type != "") $sql_filters[] = " content_type = '$content_type' ";
		if($content_id != "") $sql_filters[] = " content_id = '$content_id' ";
				
		// this is used by both the front and back end
				
		$sql = "SELECT * FROM {$this->db->dbprefix}commento_comments WHERE " . implode(" AND ", $sql_filters) . " ORDER BY id ASC";
		
		echo $sql;
		
		
		$result 	= mysql_query($sql);
		
		$out 		= "";
		
		while($row = mysql_fetch_assoc($result)) {
			$this->process_comment($row);
			if ($row["parent"] === "-") {
				$out .= $this->pre_Markup();
			} else {
				$out .= $this->pre_Markup(true);
			}
		}
		return $out;
	}
	
	
	
	/**
	* Function admin_approveComment()
	* Approves a comment.
	* NOTE this function is only called from the admin panel, so no verifications needed, right?
	* 
	* @param	integer		The comment or reply ID
	*
	* @return	string		Returns "1" for success or an error if it fails on mysql query (SHOULD NEVER HAPPEN)
	*
	*/
	public function admin_approveComment($id) {
		if (mysql_query("UPDATE {$this->db->dbprefix}commento_comments SET show_it = '1' WHERE id = '$id'"))
			return "1";
		else
			return "Probem in commento.class (#" . __LINE__ . ")";
	}
	
	
	
	/**
	* Function admin_removeComment()
	* Removes a comment.
	* NOTE this function is only called from the admin panel, so no verifications needed, right?
	* 
	* @param	integer		The comment or reply ID
	*
	* @return	string		Returns an error if the requested ID has replies, returns "1" for success or an error if it fails on mysql query (SHOULD NEVER HAPPEN)
	*
	*/
	public function admin_removeComment($id) {
		if ($this->commentHasReplies($id) === true)
			return "Comment has replies. Cannot be removed";
			
		else if (mysql_query("DELETE FROM {$this->db->dbprefix}commento_comments WHERE id = '$id'"))
			return "1";
			
		else
			return "Probem in commento.class (#" . __LINE__ . ")";
	}
	
	
	
}
?>