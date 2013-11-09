<!-- 
@Name: Liquid Search Results
@Type: the application
@Filename: liquid.tpl.html
@Description: Show the liquid search layout
@Author: galbraithdesmond@gmail.com
@Projectnum: 1001
@Version: 1.0
@Status: development
@Date: 2012-06-16
-->


<!-- BEGIN SEARCHFILTERBOX -->

<?php if(isset($paginator)){ ?> <h3 class="heading"><small>Search results for</small> {$keywords}</h3> <?php } ?>
                            <div class="well clearfix">
                                <div class="row-fluid">
                                    <div class="pull-left">Showing 1 - {$count_to} of {$numrecords} Results</div>
                                    <div class="pull-right">
                                        <span class="sepV_c">
                                            Sort by:
                                            <select>
                                                <option>Name</option>
                                                <option>Date</option>
                                                <option>Relevance</option>
                                            </select>
                                        </span>
                                        <span class="sepV_c">
                                            View:
                                            <select>
                                                <option>12</option>
                                                <option>25</option>
                                                <option>50</option>
                                            </select>
                                        </span>
                                        <span class="result_view">
											<a href="javascript:void(0)" class="box_trgr sepV_b"><i class="icon-th-large"></i></a>
											<a href="javascript:void(0)" class="list_trgr"><i class="icon-align-justify"></i></a>
										</span>
                                    </div>
                                </div>
                            </div>




<!-- END SEARCHFILTERBOX -->


<!-- BEGIN MAINLAYOUT -->

                    <div class="row-fluid search_page">
                        <div class="span12">

						{$searchfilterbox}
						

						{$resultsdisplay}
			 
              
                        </div>
                    </div>

<!-- END MAINLAYOUT -->

	

<!-- BEGIN SEARCHRESULTS_WRAPPER -->

<div class="pagination">
{$paginator}
</div>

							
{$resultrows}

<br />

<div class="pagination">
{$paginator}
</div>

	
	
<!-- END SEARCHRESULTS_WRAPPER -->


<!-- BEGIN SEARCHRESULTITEM -->


                            <div class="search_item clearfix">
                                    <span class="searchNb">{$rowindex}</span>
           
                                    <div class="search_content">
                                        <h4>
                                            <a href="javascript:void(0)" class="sepV_a">Lorem ipsum dolor sit amet</a>
                                            <span class="label label-info">Lorem ipsum</span>
                                        </h4>
                                        <p class="sepH_b item_description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In euismod commodo adipiscing. Nunc lobortis mauris sit amet lectus vulputate vitae porta nulla vehicula. Curabitur in fermentum dui. Integer lobortis odio in quam faucibus ornare. Vivamus sed nulla suscipit tortor volutpat aliquam. Ut a lorem in felis faucibus tincidunt. Duis consectetur pulvinar lacus non pulvinar. Phasellus tempor nisi at sem commodo id vehicula nisl aliquam.</p>
                                        <p class="sepH_a"><strong>Lorem ipsum:</strong> dolor sit amet</p>
                                        <small>Tag 1</small>, <small>Tag 2</small>
                                    </div>
                                </div>
								
						

<!-- END SEARCHRESULTITEM -->


<!-- BEGIN NORESULTS -->

No results.


<!-- END NORESULTS -->







