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

					<div class="pull-left">
 
                      <h3 class="heading"><small>Search results for</small> {$searchterm}</h3>
					  
					  </div>
					  
		
					  
					  <div class="clearfix"></div>
					  
					  
					  
                            <div class="well clearfix">
                                <div class="row-fluid">
                                    <div class="pull-left">Showing {$count_from} - {$count_to} of {$numrecords} Results</div>
                                    
								<form id="site-search-form" action="/en/search?lang=en">
					  
									<div class="pull-right" style="margin-left:20px;">
                                      <span class="sepV_c">
                                            View:
                                            <select style="width:80px" name="listings_per_page" onchange="ps_sitesearch.refresh()">
											<option <?php if($listings_per_page == 10) echo " selected"; ?>>10</option>
                                                <option <?php if($listings_per_page == 25) echo " selected"; ?>>25</option>
                                                <option <?php if($listings_per_page == 50) echo " selected"; ?>>50</option>
												<option <?php if($listings_per_page == 100) echo " selected"; ?>>100</option>
                                            </select>
                                        </span>
                                        <span class="result_view">
                                            <a href="javascript:void(0)" class="box_trgr sepV_b"><i class="icon-th-large"></i></a>
                                            <a href="javascript:void(0)" class="list_trgr"><i class="icon-align-justify"></i></a>
                                        </span>
                                    </div>
									
									
									
					  <div class="pull-right">
				
					  
					  <div class="pull-left" style="margin-right:10px">
					  <div class="controls">
                            <label class="checkbox inline">
							<input type="checkbox" checked="checked" value="" class="style" name="boolean">
							boolean</label>
							
                       </div>
					   </div>
					  <input style="margin:0" type="text" name="keywords" id="q-main" value="{$searchterm}"> <button id="search-form-submit-btn" class="btn"><i class="icon-search"></i></button>
					  </div>
					  
					  </form>
					  
					  
                                </div>
	  </div>

<div class="row-fluid search_page">
<div class="span12">
  
<div class="search_panel clearfix">
							

{$resultrows}

</div>

	</div>
	
	
<div class="pagination">
{$paginator}
</div>
	
	
</div>	


<br />

	
<!-- END SEARCHRESULTS_WRAPPER -->


<!-- BEGIN SEARCHRESULTITEM -->



<div class="search_item clearfix">
	<span class="searchNb">{$rowindex}</span>
	<div class="search_content">
		<h4>
			<a href="{$source_url}" class="sepV_a">{$title}</a>
		</h4>
		<p class="sepH_b item_description">{$content}</p>
		<p class="sepH_a"><strong>Updated:</strong> {$updated}</p>
	
	</div>
</div>


<!-- END SEARCHRESULTITEM -->


<!-- BEGIN NORESULTS -->

No results.


<!-- END NORESULTS -->







