<!-- 
@Name: Simple Search Results
@Type: impressto
@Filename: standard.tpl.html
@Description: Show the most basic search result layout
@Author: galbraithdesmond@gmail.com
@Projectnum: 1001
@Version: 1.0
@Status: development
@Date: 2012-06-16
-->


<!-- BEGIN SEARCHFILTERBOX -->


<div style="border: 1px solid">


<input type="hidden" name="lang" value= "{$lang}" />

<input type="text" name="keywords" style="width:200px" value="{$keywords}" /> 

<?php if( $pagination_method == "ajax" ){ ?>
	<button type="button" onclick="ps_sitesearch.get_results()" class="btn">Search</button>
<?php }else { ?>
	<button type="submit" class="btn">Search</button>
<?php } ?>

<a href="ps_sitesearch.show_advanced()">Advanced Search</a>

<div class="clearfix"></div>


<div id="advanced_search_options">

<?php

$CI = & get_instance();

$CI->load->library('formelement');

?>

<label for="search_content_filters">Filter by Content Type</label>

<?php
		
	$fielddata = array(
		'name'        => "search_content_filters",
		'type'          => 'multicheck',
					'id'          => "search_content_filters",
					'label'          => "",
					'orientation'          => "horizontal",
					'width' => 5,
					'usewrapper'          => false,
					'options' =>  $active_content_types,
					'value'       =>  (isset($content_filters) ? $content_filters : array()),

			);
				
			echo $CI->formelement->generate($fielddata);
			
			
?>

<label for="search_boolean">Boolean Search</label>

<?php

		$fielddata = array(
		'name'        => "booleanseach",
		'type'          => 'check',
		'id'          => "booleanseach",
		'label'          => "Boolean",
		'orientation'          => "horizontal",
		'width' => 5,
		'usewrapper'          => TRUE,
		'options' =>  1,
		'value'       =>  (isset($booleanseach) ? $booleanseach : ""),

		);
				
			echo $CI->formelement->generate($fielddata);
			
		
		?>
		

</div>


</div>




<!-- END SEARCHFILTERBOX -->


<!-- BEGIN MAINLAYOUT -->

<form id="site_search_form">

{$searchfilterbox}

<br />

<div id="site_search_results">
{$resultsdisplay}
</div>

</form>

<!-- END MAINLAYOUT -->

	

<!-- BEGIN SEARCHRESULTS_WRAPPER -->

<h2>Search Results</h2>

{$resultrows}

<br />
{$paginator}
	
	
<!-- END SEARCHRESULTS_WRAPPER -->


<!-- BEGIN SEARCHRESULTITEM -->


<h3>{$title}</h3>

<p>
{$content}
</p>

Content Type: <a href="{$source_url}">{$content_module}</a><br />

<a href="{$source_url}">{$content_id}</a>

Length: {$contentlength}<br />
Last Updated: {$updated}<br />
					
<div class="clearfix"></div>


<!-- END SEARCHRESULTITEM -->


<!-- BEGIN NORESULTS -->

No results.


<!-- END NORESULTS -->







