<?php
/*
@Name: Search Manager
@Type: PHP
@Filename: manager.php
@Description: settings for site search and the search widget
@Author: Nimmitha Vidyathilaka
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-05-15
*/
?>

<?php 

$CI = &get_instance();

$languages = $this->config->item('languages');


echo $infobar;

?>

<?php
// this is for the jquery UI 1.9 tabs bug
$request_uri = getenv("REQUEST_URI");
?>

	
<form id="searchadmin_form">

 
	<div id="crudTabs" class="management_form" style="display: none;">
	
	
		<ul>
		<li><a href="<?=$request_uri?>#settings_div" >Settings</a></li>
		<li><a href="<?=$request_uri?>#search_records_div">Search Records</a></li>
		<li><a href="<?=$request_uri?>#indexed_content_div">Indexed Content</a></li>
		</ul>
		
	

	    <div id="settings_div" rel="">

	
		<h2>Settings</h2>
	

			<div class="footNav clearfix">
				<ul>
					<li><button class="btn btn-default" type="button" onclick="ps_search_settings.savesettings();">Save</button></li>
				</ul>
			</div>
			
			
		<br />
		<br />
			

	<!-- loop through all available languages -->
	
	<?php

		$lang_avail = $CI ->config->item('lang_avail');
			
		
		foreach($lang_avail AS $langcode=>$language){

		
				
				
	?>
	
	<label for="search_template"><?=$language?> Search Page</label>
	
	<?php 
	
	$data = array(
	"language" => $langcode,
	'name'        => "search_page_" . $langcode,
	'type'          => 'select',
	'showlabels'          => false,
	'id'          => "search_page_" . $langcode,
	'width'          => 300,
	'usewrapper'          => FALSE,
	'label'          => "",
	'onchange' => "",
	'value'       => (isset($searchoptions['search_page_' . $langcode]) ? $searchoptions['search_page_' . $langcode] : '')
	
	);
	
	echo get_ps_page_slector($data); 
	
	?>
	
	<div class="clearfix"></div>
	
	<?php
	
	} 
	
	?>
	
	
	
	<div class="clearfix"></div>
	<br />
		


	<label for="search_template">Search Template</label>
	<?php 

						$fielddata = array(
						'name'        => "search_template",
						'type'          => 'select',
						'id'          => "search_template",
						'label'          => "",
						'width'          => 300,
						'usewrapper'          => FALSE,
						'options' =>  $search_templates,
						'value'       =>  (isset($searchoptions['search_template']) ? $searchoptions['search_template'] : "")
					);
					
					echo $this->formelement->generate($fielddata);

		?>
		
		
		<div class="clearfix"></div>
		
		<br />

				
		<label for="site_title_en">Default Sorting Method</label>
								
		<?php
				
			$fielddata = array(
					'name'        => "sortmethod",
					'type'          => 'select',
					'id'          => "sortmethod",
					'label'          => "",
					'usewrapper'          => false,
					'options' =>  array("Select"=>"","Date"=>"date","Relevance"=>"relevance"),
					'value'       =>  (isset($searchoptions['sortmethod']) ? $searchoptions['sortmethod'] : "")

			);
				
			echo $this->formelement->generate($fielddata);
		
		?>
		
		
		<div class="clearfix"></div>
		
		<br />

				
		<label for="listings_per_page">Listings Per Page</label>
								
		<?php
				
			$fielddata = array(
					'name'        => "listings_per_page",
					'type'          => 'text',
					'id'          => "listings_per_page",
					'label'          => "",
					'width'          => "30",
					'usewrapper'          => false,
					'value'       =>  (isset($searchoptions['listings_per_page']) ? $searchoptions['listings_per_page'] : "")

			);
				
			echo $this->formelement->generate($fielddata);
		
		?>
		
		<div class="clearfix"></div>
		
		<br />

				
		<label for="traillength">Leading and Trailing Result Words Length</label>
								
		<?php
				
			$fielddata = array(
					'name'        => "traillength",
					'type'          => 'text',
					'id'          => "traillength",
					'width'          => "30",
					
					'label'          => "",
					'usewrapper'          => false,
					'value'       =>  (isset($searchoptions['traillength']) ? $searchoptions['traillength'] : "")

			);
				
			echo $this->formelement->generate($fielddata);
		
		?>
		
		
		
		
		
		
		
		<div class="clearfix"></div>
		
		<br />

				
		<label for="pagination_method">Pagination Method</label>
								
		<?php
				
			$fielddata = array(
					'name'        => "pagination_method",
					'type'          => 'radio',
					'id'          => "pagination_method",
					'label'          => "",
					'orientation'          => "horizontal",
					'width' => 2,
					
					'usewrapper'          => false,
					'options' =>  array("Standard"=>"standard","AJAX"=>"ajax"),
					'value'       =>  (isset($searchoptions['pagination_method']) ? $searchoptions['pagination_method'] : "")

			);
				
			echo $this->formelement->generate($fielddata);
		
		?>
		
		
		
		
		<div class="clearfix"></div>
		
		<br />

				
		<label for="pagination_method">Available Filter Content Types</label>
								
		<?php
		
					
			$fielddata = array(
					'name'        => "content_filters",
					'type'          => 'multicheck',
					'id'          => "content_filters",
					'label'          => "",
					'orientation'          => "horizontal",
					'width' => 5,
					'usewrapper'          => false,
					'options' =>  $active_content_types,
					'value'       =>  (isset($searchoptions['content_filters']) ? $searchoptions['content_filters'] : "")

			);
				
			echo $this->formelement->generate($fielddata);
		
		?>
		
		
		<div class="clearfix"></div>
		
		<br />
		
</div>


		<div id="search_records_div" rel="/site_search/search_records">

			<img style="float:left" src="<?php echo ASSETURL; ?><?php echo PROJECTNAME ?>/default/core/images/horizontal_spinner.gif" />
			<span style="float:left; margin-left:20px; margin-top:22px;">LOADING NEW PAGE</span>
			
		</div>
		<div id="indexed_content_div" rel="/site_search/search_indexes">
		
			<img style="float:left" src="<?php echo ASSETURL; ?><?php echo PROJECTNAME ?>/default/core/images/horizontal_spinner.gif" />
			<span style="float:left; margin-left:20px; margin-top:22px;">LOADING NEW PAGE</span>
			
		</div>
		
		<div class="clearfix"></div>
			
	
	</div>
	
</form>
		
					
				
				