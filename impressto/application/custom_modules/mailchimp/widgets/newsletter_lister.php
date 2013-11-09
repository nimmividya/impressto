<?php

global $net_data;

function smarty_function_supremeadvocacyletters($params, &$smarty){

	global $furlargs, $net_data;
	
	global $mc_api;
	
	
	//////////////////////
	// Fire up the MailChimp API here
	
	require_once(getenv("DOCUMENT_ROOT") . "/includes/mailchimp_api/inc/MCAPI.class.php");
	require_once(getenv("DOCUMENT_ROOT") . "/includes/mailchimp_api/inc/config.inc.php"); //contains apikey

	$mc_api = new MCAPI($apikey);

	$english_can_id = "9d8fdd1a37";
	$french_can_id = "e7982b8035";
	$international_id = "70e12b38f6";
	
	



	$pageshapermoduledir = getenv("DOCUMENT_ROOT") . PROJECTNAME . "/default/custom_modules/modNewsletter/templates";


	$urlinfo = parse_url(getenv("REQUEST_URI")); 
	$urlpathparts = explode("/",$urlinfo['path']);
	if($urlpathparts[1] != ""){ // there is at least one valid path part	
		if($urlpathparts[1] == "en" || $urlpathparts[1] == "fr"){ // a language is specified
			$_GET["lang"] = $urlpathparts[1];
			$_GET["page"] = $urlpathparts[2];		
		}else{
			$_GET["lang"] = "en"; // just default to english is no lang specified
			$_GET["page"] = $urlpathparts[1];
		}
		
	}

	

	$l=$_GET['lang'];
	$lang=$_GET['lang'];
	
	$p=$_GET['p'];
	$url=$_GET['page'];
	


	if(!isset($_GET['n']))
	$issue=0;
	else
	$issue=$_GET['n'];
	

	if(isset($_GET['cid']) && $_GET['cid'] != ""){
		
		
		$html = get_mailchimp_campaign_html($_GET['cid'], $lang);
		
		if($html) echo $html;

		return;
		
	}
	
	
	
	if($l=='en'){


		if ( $url=='most-recent-supreme-court-of-canada-supremeadvocacyletter' ){
			
			$campaigns = get_mailchimp_campaign_list();
			
			if($campaigns){
				
				$most_recent_campaign_id = "";
				
				foreach($campaigns as $campaign){
					
					if($campaign['list_id'] == $english_can_id){
						
						$most_recent_campaign_id = $campaign['id'];
						break;
						
					}
					
				}
				
				
				if( $most_recent_campaign_id != ""){
					
					$html = get_mailchimp_campaign_html( $most_recent_campaign_id, $lang);
					
					if($html) echo $html;
					
					return;
					
				}
				
				
			}
			
			return;
			
			
		}
		
		
		if ( $url=='most-recent-supremeadvocacyletter-from-canada' ){
			
			
			$campaigns = get_mailchimp_campaign_list();
			
			if($campaigns){
				
				$most_recent_campaign_id = "";
				
				foreach($campaigns as $campaign){
					
					if($campaign['list_id'] == $international_id){
						
						$most_recent_campaign_id = $campaign['id'];
						break;
						
					}
					
				}
				
				
				if( $most_recent_campaign_id != ""){
					
					$html = get_mailchimp_campaign_html( $most_recent_campaign_id, $lang);
					
					if($html) echo $html;
					
					return;
					
				}
				
				
			}
			
			return;
			
			
		}
		
		
		if ( $url=='supremeadvocacyletter-archive' ){
			

			
			$i=0;
			echo '<p><strong>Archived SupremeAdvocacyLett@rs</strong></p>';	
			
			echo '<ul>';
			
			
			$campaigns = get_mailchimp_campaign_list();
			
			foreach($campaigns as $campaign){
				
				
				
				if($campaign['list_id'] == $english_can_id){
					
					$i++;
					
					if($i==1){
						echo  "<li><a href=\"?cid={$campaign['id']}\">Click here</a> for this week's <em>SupremeAdvocacyLett@r</em></li>";
					}else{
						echo "<li><a href=\"?cid={$campaign['id']}\">{$campaign['title']}</a></li>";
					}
					
					
				}
				
			}
			
			echo "</ul>";
			
			echo "<p><a href=\"archive-page-complete-list\">Click here</a> for a complete list of <em>SupremeAdvocacyLett@rs</em>.</p>";
			
			echo '<ul>';
			
			
			$i=0;
			
			foreach($campaigns as $campaign){
				
				
				if($campaign['list_id'] == $international_id){
					
					$i++;
					if($i==1){
						echo "<li><a href=\"?cid={$campaign['id']}\">Click here</a> for this month's <em>SupremeAdvocacyLett@r</em></li>";
					}else{
						echo "<li><a href=\"?cid={$campaign['id']}\">{$campaign['title']}</a></li>";
					}
					
					
					
				}
				
			}
			
			echo '</ul>';
			
			echo'<p><strong>Archived SupremeAdvocacyLett@rs from Canada</strong></p>';	
			
			echo '<p><a href="archive-page-complete-list">Click here</a> for a complete list of <em>SupremeAdvocacyLett@rs</em> from Canada.</p>';
			
			
			
			return;
			
			
		}
		
		
		
		if ( $url=='archive-page-complete-list' ){

			
			echo "<ul>";
			
			echo "<p><strong>Archived SupremeAdvocacyLett@rs</strong></p>";	
			
			$campaigns = get_mailchimp_campaign_list();

			$i = 0;
			
			foreach($campaigns as $campaign){
				
				
				if($i > 0 && $campaign['list_id'] == $english_can_id){
					
					echo "<li><a href=\"?cid={$campaign['id']}\">{$campaign['title']}</a></li>";
					
				}
				
				$i++;
				
				
			}
			
			
			echo  "</ul><p><a href=\"most-recent-supreme-court-of-canada-supremeadvocacyletter\">Click here</a> for this week's <em>SupremeAdvocacyLett@r</em>.</p>";
			
			echo "<ul>";
			
			echo "<p><strong>Archived SupremeAdvocacyLett@rs from Canada</strong></p>";	
			

			$i = 0;
			
			foreach($campaigns as $campaign){
				
				
				if($i > 0 && $campaign['list_id'] == $international_id){
					
					echo "<li><a href=\"?cid={$campaign['id']}\">{$campaign['title']}</a></li>";
					
				}
				
				$i++;
				
			}
			
			print "</ul><p><a href=\"most-recent-supremeadvocacyletter-from-canada\">Click here</a> for this month's <em>SupremeAdvocacyLett@r</em> from Canada.</p>";

			return;
			
			
		}
		
		

		
	}else{ // french letters
		

		
		if ( $url=='supremeadvocacyletter-archive' ){

			echo '<p><strong>Archives du <em>SupremeAdvocacyLettr@</em></strong></p>';	
			
			echo '<ul>';
			
			$i=0;
			
			$campaigns = get_mailchimp_campaign_list();
			
			foreach($campaigns as $campaign){
				
				
				
				if($campaign['list_id'] == $french_can_id){
					
					$i++;
					
					if($i==1){
						echo  "<li><a href=\"?cid={$campaign['id']}\">Cliquez ici</a> pour le <em>SupremeAdvocacyLettr@</em> le plus recent</li>";
					}else{
						echo "<li><a href=\"?cid={$campaign['id']}\">{$campaign['title']}</a></li>";
					}
					
					
				}
				
			}
			
			echo "</ul>";
			
			echo "<p><a href=\"archive-page-complete-list\">Cliquez ici</a> pour une liste compl&egrave;te des numéros de <em>SupremeAdvocacyLettr@s </em></p>";
		
			echo '<ul>';
			
			
			$i=0;
			
			foreach($campaigns as $campaign){
			
								
				if($campaign['list_id'] == $international_id){
				
					$i++;
					if($i==1){
						echo "<li><a href=\"?cid={$campaign['id']}\">Cliquez ici</a> pour la dernière édition de <em>SupremeAdvocacyLettr@</em></li>"; 
					}else{
						echo "<li><a href=\"?cid={$campaign['id']}\">{$campaign['title']}</a></li>";
					}
									
					
					
				}
				
			}
		
			echo '</ul>';
			
			echo '<p><strong>Archive du <em>SupremeAdvocacyLett@r</em> from Canada <br/>(disponible en anglais seulement)</strong></p>';	
			
			echo '<p><a href="archive-page-complete-list">Cliquez ici</a> pour la dernière édition de <em>SupremeAdvocacyLettr@</em></p>';
			
			return;
			
			
			
		}

		if ( $url=='archive-page-complete-list' ){
			
			
			echo "<ul>";
			
			echo "<p><strong>Archives du SupremeAdvocacyLett@rs</strong></p>";	
			
			$campaigns = get_mailchimp_campaign_list();

			$i = 0;
			
			foreach($campaigns as $campaign){
				
				
				if($i > 0 && $campaign['list_id'] == $french_can_id){
					
					echo "<li><a href=\"?cid={$campaign['id']}\">{$campaign['title']}</a></li>";
					
				}
				
				$i++;
				
			}
			
			
			echo  "</ul><p><a href=\"most-recent-supreme-court-of-canada-supremeadvocacyletter\">Cliquez ici</a> pour la dernière édition de <em>SupremeAdvocacyLettr@</em></p>";
			
			echo "<ul>";
			
			echo "<p><strong>Archive du SupremeAdvocacyLett@rs from Canada<br/>(disponible en anglais seulement)</strong></p>";	
			

			$i = 0;
			
			foreach($campaigns as $campaign){
				
				
				if($i > 0 && $campaign['list_id'] == $international_id){
					
					echo "<li><a href=\"?cid={$campaign['id']}\">{$campaign['title']}</a></li>";
					
				}
				
				$i++;
				
			}
			
			echo "</ul><p><a href=\"most-recent-supremeadvocacyletter-from-canada\">Cliquez ici</a> pour la dernière édition de <em>SupremeAdvocacyLettr@</em></p>";

			return;
			
			
		}

		if ( $url=='most-recent-supreme-court-of-canada-supremeadvocacyletter' ){
			// nl type = 0 = canadian
			$campaigns = get_mailchimp_campaign_list();
			
			if($campaigns){
				
				$most_recent_campaign_id = "";
				
				foreach($campaigns as $campaign){
					
					if($campaign['list_id'] == $french_can_id){
						
						$most_recent_campaign_id = $campaign['id'];
						break;
						
					}
					
				}
				
				
				if( $most_recent_campaign_id != ""){
					
					$html = get_mailchimp_campaign_html( $most_recent_campaign_id, $lang);
					
					if($html) echo $html;
					
					return;
					
				}else{
					
					include($pageshapermoduledir . "/" . "noresults_fr.html");
					
					
				}
				
				
			}
			
			return;
			
			
			
		}

		if ( $url=='most-recent-supremeadvocacyletter-from-canada' ){
			
			
			$campaigns = get_mailchimp_campaign_list();
			
			if($campaigns){
				
				$most_recent_campaign_id = "";
				
				foreach($campaigns as $campaign){
					
					if($campaign['list_id'] == $international_id){
						
						$most_recent_campaign_id = $campaign['id'];
						break;
						
					}
					
				}
				
				
				if( $most_recent_campaign_id != ""){
					
					$html = get_mailchimp_campaign_html( $most_recent_campaign_id, $lang);
					
					if($html) echo $html;
					
					return;
					
				}
				
				
			}
			
			return;
			
			
			
		}

		
	}
	


}


function get_mailchimp_campaign_html($campaign_id, $lang){

	global $mc_api;
	
	// first thing is to check if a cached version of this newsletter exits
	$cachefile = getenv("DOCUMENT_ROOT") . "/includes/mailchimp_api/cache/{$lang}/{$campaign_id}.html";
	
	
	if(file_exists($cachefile)){
		
		return file_get_contents($cachefile);
		
	}
	
	$retval = $mc_api->campaignContent($campaign_id);

	if ($mc_api->errorCode){
		echo "Unable to load content()!";
		echo "\n\tCode=".$mc_api->errorCode;
		echo "\n\tMsg=".$mc_api->errorMessage."\n";
		
		return FALSE;
		
	} else {

		$body = preg_replace("/.*<body[^>]*>|<\/body>.*/si", "", $retval['html']);
		
		$body .= "<!-- $campaign_id  -->"; 
		
		file_put_contents($cachefile, $body);
		
		return $body;
		
	}
	
	
	return FALSE;
	

}



function get_mailchimp_campaign_list(){

	global $mc_api;
	
	$retval = $mc_api->campaigns();

	if ($api->errorCode){
		echo "Unable to load content()!";
		echo "\n\tCode=".$api->errorCode;
		echo "\n\tMsg=".$api->errorMessage."\n";
		return FALSE;
		
	}else{
		
		return $retval['data'];
		
	}	
	
	return FALSE;
	

}
