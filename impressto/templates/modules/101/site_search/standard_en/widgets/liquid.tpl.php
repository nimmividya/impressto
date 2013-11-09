<!-- 
@Name: Liquid Search Results
@Type: pageshaper
@Filename: liquid.tpl.html
@Description: Show the liquid search layout
@Author: galbraithdesmond@gmail.com
@Projectnum: 1001
@Version: 1.0
@Status: development
@Date: 2012-06-16
-->


<!-- BEGIN SEARCHFILTERBOX -->

<?php 

$CI = & get_instance();

//$CI->asset_loader->add_header_css("third_party/bootstrap/css/bootstrap.css");
		
$CI->asset_loader->add_header_css("core_modules/site_search/css/style.css");
				
		


if(isset($paginator)){ 

?> 
<h3 class="heading" style="float:left; margin-bottom:5px;"><small>Results for</small> {$searchterm}</h3> <div class="clearfix"></div>

<?php } ?>


<form action="<?=$search_page?>">

	<div class="well clearfix">
		<div class="row-fluid">
			<div class="pull-left">Showing {$count_from} - {$count_to} of {$numrecords} Results</div>
            <div class="pull-right">
				<input type="text" name="keywords" id="keywords" value="{$keywords}" />
				<button class="btn" type="submit"><i class="icon-search"></i> Search</button>
			</div>
		</div>
	</div>
							
</form>

<!-- END SEARCHFILTERBOX -->


<!-- BEGIN MAINLAYOUT -->

	<div class="row-fluid search_page">
	
		{$searchfilterbox}

		{$resultsdisplay}
	

	</div>

<!-- END MAINLAYOUT -->

	

<!-- BEGIN SEARCHRESULTS_WRAPPER -->

	<div class="search_panel clearfix">
		{$resultrows}
	</div>
		
	<div class="pagination pull-left">
		{$paginator}
	</div>
		

	
	
<!-- END SEARCHRESULTS_WRAPPER -->


<!-- BEGIN SEARCHRESULTITEM -->


	<div class="search_item clearfix">
        <div class="search_content">
			<h4><a href="{$source_url}" class="sepV_a">{$title}</a></h4>
			<p class="sepH_b item_description">
				{$content}
			</p>
			<p class="result_date"><strong>Updated:</strong> {$updated}</p>
			
			<?php if(count($tags) > 0){
			
				$tagsarray = array();

				foreach($tags as $tag){
				
					$tagsarray[] = "<a href=\"" . $search_page . "/?tag=" . $tag . "\">" . $tag . "</a>";
									
				}
				
				echo '<strong>TAGS: </strong><small>' . implode("</small>, <small>", $tagsarray) . '</small>';
				
			}
			
			?>
			
		</div>
	</div>
								
						

<!-- END SEARCHRESULTITEM -->


<!-- BEGIN NORESULTS -->

No results.


<!-- END NORESULTS -->







