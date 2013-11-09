<?php
/*
@Name: CLF 2.0 Status Dialog
@Type: PHP
@Filename: wcag_status.php
@Description: 
@Author: Galbraith Desmond
@Projectnum: 
@Version: 1.0
@Status: development
@Date: 2012/08/01
*/
?>

<?php

				
	$fielddata = array(
		'name'        => "acronyms",
		'type'          => 'checkbox',
		'id'          => "cblock_name",
		'label'          => '',
		'use_wrapper' => FALSE,
		'options' => 'Y',
		'value'  => (isset($acronyms) ? $acronyms : ''),
	);
			
	$acronyms_checkbox = $this->formelement->generate($fielddata);

	$fielddata = array(
		'name'        => "alt_tags",
		'id'          => "alt_tags",
		'options' => 'Y',
		'value'  => (isset($alt_tags) ? $alt_tags : ''),
	);
			
	$alt_tags_checkbox = $this->formelement->generate($fielddata);	
	

	$fielddata = array(
		'name'        => "top_links",
		'id'          => "top_links",
		'options' => 'Y',
		'value'  => (isset($top_links) ? $top_links : ''),
	);
			
	$top_links_checkbox = $this->formelement->generate($fielddata);	

	$fielddata = array(
		'name'        => "plain_html",
		'id'          => "plain_html",
		'options' => 'Y',
		'value'  => (isset($plain_html) ? $plain_html : ''),
	);
			
	$plain_html_checkbox = $this->formelement->generate($fielddata);	
	
	$fielddata = array(
		'name'        => "file_naming",
		'id'          => "file_naming",
		'options' => 'Y',
		'value'  => (isset($file_naming) ? $file_naming : ''),
	);
			
	$file_naming_checkbox = $this->formelement->generate($fielddata);	
	
	$fielddata = array(
		'name'        => "navigation",
		'id'          => "navigation",
		'options' => 'Y',
		'value'  => (isset($navigation) ? $navigation : ''),
	);
			
	$navigation_checkbox = $this->formelement->generate($fielddata);
	
	$fielddata = array(
		'name'        => "element_width",
		'id'          => "element_width",
		'options' => 'Y',
		'value'  => (isset($element_width) ? $element_width : ''),
	);
			
	$element_width_checkbox = $this->formelement->generate($fielddata);
	
	
	

?>

<ul class="nav nav-tabs">
    <li><a href="#swa_checklist" data-toggle="tab">Checklist</a></li>
    <li><a href="#swa_standards" data-toggle="tab">Standards Guide</a></li>
    <li><a href="#swa_autoanalyze" data-toggle="tab">Auto-Analyze</a></li>
    <li><a href="#swa_textools" data-toggle="tab">Text Tools</a></li>
	
	
</ul>
	
<div class="tab-content">
<div class="tab-pane active" id="swa_checklist">


<button style="float:right" type="button" onclick="ps_swa_compliance_manager.save_status()" class="btn">Save</button>  

<div style="clear:both; height:5px"></div>


<form id="clf_checklist_form">

 
<input type="hidden" id="clf_checklist_node_id" name="page_node" value="<?=$page_node?>" />
<input type="hidden" id="clf_checklist_lang" name="lang" value="<?=$lang?>" />

<div class="compliance_item">

<div style="float:left"><?=$alt_tags_checkbox?></div>
Alt tags in place for all images?



</div>



<div class="compliance_item">

<p>

<div style="float:left"><?=$acronyms_checkbox?></div>

When using acronyms the first time is should be spelled out. 
Do not use tooltips on titles. Spell out complete names with acronyms.
Add html tool tips :
<br />

&lt;abbr title="title goes here"&gt;abr&lt;/abbr&gt;
</p>

</div>


<div class="compliance_item">

<p>
<div style="float:left"><?=$top_links_checkbox ?></div>


Ensure to add top of page link (anchor) on long pages every 2 screens 



</p>


</div>

<div class="compliance_item">

<p>
<div style="float:left"><?=$plain_html_checkbox?></div>


Remove all inline styling. Do not format bullets ordered on unordered with css, just put a plain html 



</p>


</div>

<div class="compliance_item">

<p>

<div style="float:left"><?=$file_naming_checkbox?></div>


Files need to be named based on the clients curren convention 



</p>


</div>




<div class="compliance_item">

<p>

<div style="float:left"><?=$navigation_checkbox ?></div>

Navigation should be added to all pages: TOC - Previous - Next

 </p>


</div>


<div class="compliance_item">

<p>
<div style="float:left"><?=$element_width_checkbox?></div>

Ensure table and images do not exceed size of page of 600 pixels.


 </p>
 
</div>
 

</form>




</div>
<div class="tab-pane" id="swa_standards">


<h3 style="margin-bottom: 1.0em;">
	2.0 Requirements</h3>
<p>
	The following requirements respect usability principles. To facilitate implementation, the <a href="http://ircan-rican.gc.ca/projects/gcwwwtemplates">Web Experience Toolkit (<abbr title="Web Experience Toolkit">WET</abbr>)</a> provides a ready-made solution that complies with these requirements and the evolving visual elements and identifiers prescribed by the Federal Identity Program.</p>
<p>
	These requirements apply to each Web page and are optimized for screen widths of 1024 pixels. Web pages can be optimized by default for widths smaller than 1024 pixels, but they must include a &quot;Full site&quot; (<em>&#39;Site entier&#39;</em>) link in the footer for switching to the version of the Web site that is optimized for screen widths of 1024 pixels. Web pages can also be optimized for screen widths larger than 1024 pixels with optimizations limited to proportional increases to the inner widths of the following: header, Government of Canada navigation bar, banner, site navigation bar, breadcrumb, body, footer, site footer, and Government of Canada footer. Recommendations for both smaller and larger screen widths are provided in supporting guidance.</p>
<h4>
	2.1 Each Web page:</h4>
<ul>
	<li>
		Displays the favicon prescribed by the Federal Identity Program; and</li>
	<li>
		Uses Verdana for the default font.</li>
</ul>




<h4>
	2.2 Content pages</h4>
<p>
	The following requirements apply to all Web pages except splash pages and server message pages. Each Web page is structured into three main areas: header, body, and footer. The header includes four areas: Government of Canada navigation bar, banner, site navigation bar, and breadcrumbs. The body includes a content area and may include secondary navigation. The footer includes a site footer and a Government of Canada footer.</p>
<h5>
	2.2.1 Background</h5>
<p>
	Default background for the Web page.</p>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<h5>
	2.2.2 Federal Identity Program signature</h5>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Aligned with the inner left boundary of the header.</li>
	<li>
		Exact location is prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<h5>
	2.2.3 Canada Wordmark</h5>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Aligned with the inner right boundary of the header or the Government of Canada footer.</li>
	<li>
		Exact location is prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<h5>
	2.2.4 Official language selection link</h5>
<p>
	Provides a link for changing the language of the current page to the other official language.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Located in the header.</li>
	<li>
		Exact location is prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Text for the link is the official name of the corresponding language, in its native language and alphabet.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Behaviour:</strong></p>
<ul>
	<li>
		Link is to the version of the current Web page in the other official language.</li>
	<li>
		Confirmation is requested from the user if switching between languages would cause the loss of data or a disruption in the process of a transactional service.</li>
</ul>
<p>
	<strong>Exceptions:</strong></p>
<ul>
	<li>
		Web sites that require users to be logged-in and provide the option of selecting, setting, or changing the language preference</li>
</ul>
<h5>
	2.2.5 Header</h5>
<p>
	Includes the Government of Canada navigation bar, banner, site navigation bar, and breadcrumbs.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Top of the Web page.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Outer width: 100% (full width of the page)</li>
	<li>
		Inner width: 960 pixels (centred)</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Content is limited to the four areas included in the header. Only background colours and images can be used outside of those areas and are prescribed by the Federal Identity Program.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<h6>
	2.2.5.1 Government of Canada navigation bar</h6>
<p>
	Provides links to common Government of Canada resources.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Top of the header.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Height: Prescribed by the Federal Identity Program</li>
	<li>
		Outer width: 100% (full width of the page)</li>
	<li>
		Inner width: 960 pixels (centred)</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Content is prescribed by the Federal Identity Program and is limited to within the inner boundaries of the navigation bar. Only background colours and images can be used outside of those boundaries and are prescribed by the Federal Identity Program.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<h6>
	2.2.5.2 Banner</h6>
<p>
	Includes two elements: site title and search.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Immediately below the Government of Canada navigation bar.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Outer width: 100% (full width of the page)</li>
	<li>
		Inner width: 960 pixels (centred)</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Content is limited to the two elements included in the banner. Only background colours and images can be used outside of those elements and are prescribed by the Federal Identity Program.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>2.2.5.2.1 Site title</strong></p>
<p>
	Provides the title of the Web site.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Aligned with the inner left boundary of the banner.</li>
	<li>
		Below the Federal Identity Program signature.</li>
	<li>
		Exact location is prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Underlined for mouse hover and keyboard focus (not underlined otherwise)</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Behaviour:</strong></p>
<ul>
	<li>
		Links to the home page of the Web site.</li>
</ul>
<p>
	<strong>2.2.5.2.2 Search</strong></p>
<p>
	Provides a common mechanism for searching the Web site.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		&quot;Search&quot; (&quot;<span lang="fr"><em>Recherche</em></span>&quot;) button and search text input field are aligned with the inner right boundary of the banner.</li>
	<li>
		&quot;Search&quot; (&quot;<span lang="fr"><em>Recherche</em></span>&quot;) button and search text input field are at the bottom of the banner.</li>
	<li>
		Search text input field is to the left of the &quot;Search&quot; (&quot;<span lang="fr"><em>Recherche</em></span>&quot;) button.</li>
	<li>
		Exact locations of the &quot;Search&quot; (&quot;<span lang="fr"><em>Recherche</em></span>&quot;) button and search text input field are prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Search text input field width: 27 characters by default</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Search text input field background is white (#FFFFFF) by default.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Behaviour:</strong></p>
<ul>
	<li>
		Submitting a search query sends the user to a search engine results page.</li>
</ul>
<p>
	<strong>Exceptions:</strong></p>
<ul>
	<li>
		Presentation and location do not apply to the search engine results page.</li>
	<li>
		Where the act of executing the search would cause the loss of data or a disruption in the process of a transactional service.</li>
</ul>
<h6>
	2.2.5.3 Site navigation bar</h6>
<p>
	Provides links for moving from section to section across the entire Web site.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Immediately below the banner.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Outer width: 100% (full width of the page)</li>
	<li>
		Inner width: 960 pixels (centred)</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Links are text-based and are the same throughout the site.</li>
	<li>
		Link appearance for mouse hover and keyboard focus must be visually distinct from the default link appearance</li>
	<li>
		Content is limited to within the inner boundaries of the navigation bar. Only background colours and images can be used outside of those boundaries and are prescribed by the Federal Identity Program.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<h6>
	2.2.5.4 Breadcrumbs</h6>
<p>
	Provides links to the pages above the current page in the Web site&#39;s hierarchy.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Immediately below the site navigation bar</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Outer width: 100% (full width of the page)</li>
	<li>
		Inner width: 960 pixels (centred)</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Horizontal list of breadcrumbs (text-based links) representing the pages above the current page within the site&#39;s hierarchy.</li>
	<li>
		Breadcrumbs are separated by the greater-than sign ( &gt; ).</li>
	<li>
		The first breadcrumb is &quot;Home&quot; (&quot;<span lang="fr"><em>Accueil</em></span>&quot;).</li>
	<li>
		Content is limited to within the inner boundaries of the breadcrumb area. Only background colours and images can be used outside of those boundaries and are prescribed by the Federal Identity Program.</li>
	<li>
		Remaining presentation aspects are determined by the department.</li>
</ul>
<p>
	<strong>Behaviour:</strong></p>
<ul>
	<li>
		&quot;Home&quot; (&quot;<span lang="fr"><em>Accueil</em></span>&quot;) links to the home page of the Web site. Subsequent breadcrumbs are linked to the corresponding Web pages.</li>
</ul>
<p>
	<strong>Exceptions:</strong></p>
<ul>
	<li>
		Home pages</li>
</ul>
<h5>
	2.2.6 Body</h5>
<p>
	Includes a content area and may include secondary navigation. The content area includes the Date modified and may include the Government priorities.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Immediately below the header</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Outer width: 100% (full width of the page)</li>
	<li>
		Inner width: 960 pixels (centred)</li>
	<li>
		Content area is the full width and height of the inner body except where accommodating secondary navigation.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Content area and secondary navigation are limited to within the inner boundaries of the body. Only background colours and images can be used outside of those boundaries and are prescribed by the Federal Identity Program.</li>
	<li>
		Remaining presentation aspects are determined by the department.</li>
</ul>
<h6>
	2.2.6.1 Government priorities (departmental site home page only)</h6>
<p>
	Provides links to government priorities.</p>
<p>
	<strong>Location</strong></p>
<ul>
	<li>
		Aligned with the right boundary of the content area.</li>
	<li>
		Exact location to be determined by the Heads of Communication, in consultation with Privy Council Office.</li>
</ul>
<p>
	<strong>Dimensions</strong></p>
<ul>
	<li>
		Dimensions to be determined by the Heads of Communication, in consultation with Privy Council Office.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Section heading is prescribed by the Federal Identity Program.</li>
	<li>
		Remaining presentation aspects are determined by the Head of Communications of the department, in consultation with Privy Council Office.</li>
</ul>
<h6>
	2.2.6.2 Date modified</h6>
<p>
	Provides the most recent date on which the Web page content was formally issued, substantially changed or reviewed.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Aligned with the right boundary of the content area.</li>
	<li>
		Aligned with the bottom boundary of the content area.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		&quot;Date modified:&quot; (&quot;<span lang="fr"><em>Date de modification :</em></span>&quot;) using the ISO standard format (<abbr title="Date format: Year, Month and Day">YYYY-MM-DD</abbr>)</li>
	<li>
		Remaining presentation aspects are determined by the department.</li>
</ul>
<p>
	<strong>Exceptions:</strong></p>
<ul>
	<li>
		Where a version identifier is used.</li>
</ul>
<h5>
	2.2.7 Footer</h5>
<p>
	Includes the site footer and the Government of Canada footer.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Immediately below the body.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Outer width: 100% (full width of the page)</li>
	<li>
		Inner width: 960 pixels (centred)</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Content is limited to the two areas included in the footer. Only background colours and images can be used outside of those areas and are prescribed by the Federal Identity Program.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<h6>
	2.2.7.1 Site footer</h6>
<p>
	Includes links to the site&#39;s Terms and conditions and Transparency pages as well as About us, News, Contact us and Stay connected.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Top of the footer.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Outer width: 100% (full width of the page)</li>
	<li>
		Inner width: 960 pixels (centred)</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Includes the following four links arrayed from left to right in the same order: &quot;About us&quot; (&quot;<span lang="fr"><em>&Agrave; propos de nous</em></span>&quot;), &quot;News&quot; (&quot;<span lang="fr"><em>Nouvelles</em></span>&quot;), &quot;Contact us&quot; (&quot;<span lang="fr"><em>Contactez-nous</em></span>&quot;) and &quot;Stay connected&quot; (&quot;<span lang="fr"><em>Restez branch&eacute;s</em></span>&quot;).</li>
	<li>
		Additional links may be included in columns below the top-most links. Each column of links is left aligned with the associated top-most link.</li>
	<li>
		Top-most links are bolded while the additional links are not.</li>
	<li>
		Link appearance for mouse hover and keyboard focus must be visually distinct from the default link appearance.</li>
	<li>
		Links are text-based and are the same throughout the site.</li>
	<li>
		Content is limited to within the inner boundaries of the site footer. Only background colours and images can be used outside of those boundaries and are prescribed by the Federal Identity Program.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Behaviour:</strong></p>
<ul>
	<li>
		&quot;About us&quot; (&quot;<span lang="fr"><em>&Aacute; propos de nous</em></span>&quot;) links to a page with information about the Web site.</li>
	<li>
		&quot;News&quot; (&quot;<span lang="fr"><em>Nouvelles</em></span>&quot;) links to a page with media products such as press releases.</li>
	<li>
		&quot;Contact us&quot; (&quot;<span lang="fr"><em>Contactez-nous</em></span>&quot;) links to a page with contact information for the Web site.</li>
	<li>
		&quot;Stay connected&quot; (&quot;<span lang="fr"><em>Restez branch&eacute;s</em></span>&quot;) links to a page where social media, email subscriptions and/or Web feeds are available.</li>
</ul>
<p>
	<strong>Exceptions:</strong></p>
<ul>
	<li>
		&quot;News&quot; (&quot;<span lang="fr"><em>Nouvelles</em></span>&quot;) link is removed where the Web site does not release media products such as press releases.</li>
	<li>
		&quot;Stay connected&quot; (&quot;<span lang="fr"><em>Restez branch&eacute;s</em></span>&quot;) link is removed where no social media, email subscriptions or Web syndication feeds are available.</li>
</ul>
<p>
	<strong>2.2.7.1.1 Terms and conditions (&quot;<span lang="fr"><em>Avis</em></span>&quot;) and Transparency (&quot;<span lang="fr"><em>Transparence</em></span>&quot;) links</strong></p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Aligned with the inner left boundary of the site footer.</li>
	<li>
		&quot;Transparency&quot; (&quot;<span lang="fr"><em>Transparence</em></span>&quot;) link is to the right of the &quot;Terms and conditions&quot; (&quot;<span lang="fr"><em>Avis</em></span>&quot;) link.</li>
	<li>
		Exact location is prescribed by the Federal Identity Program</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Links are text-based.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Behaviour:</strong></p>
<ul>
	<li>
		&quot;Terms and conditions&quot; (&quot;<span lang="fr"><em>Avis</em></span>&quot;) links to a page containing the notices in Appendix C, or links to those same notices.</li>
	<li>
		&quot;Transparency&quot; (&quot;<span lang="fr"><em>Transparence</em></span>&quot;) links to either the department&#39;s main Transparency page or the Government-Wide Reporting page on the Treasury Board of Canada Secretariat Web site.</li>
</ul>
<h6>
	2.2.7.2 Government of Canada footer</h6>
<p>
	Provides links to common Government of Canada resources.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Immediately below the site footer.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Height: Prescribed by the Federal Identity Program.</li>
	<li>
		Width: 100% (full width of the page)</li>
	<li>
		Inner width: 960 pixels (centred)</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Content is prescribed by the Federal Identity Program and is limited to within the inner boundaries of the Government of Canada footer. Only background colours and images can be used outside of those boundaries and are prescribed by the Federal Identity Program.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<h4>
	2.3 Content pages - Printer friendly version</h4>
<p>
	Version of a content page that is optimized for printing, which only contains the following elements:</p>
<h5>
	2.3.1 Background</h5>
<ul>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<h5>
	2.3.2 Federal Identity Program signature</h5>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Vertically aligned with the top margin of the first printed page.</li>
	<li>
		Aligned with the left margin of the printed page.</li>
	<li>
		Exact location is prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<h5>
	2.3.3 Canada Wordmark</h5>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Vertically aligned with the top margin of the first printed page.</li>
	<li>
		Aligned with the right margin of the printed page.</li>
	<li>
		Exact location is prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<h5>
	2.3.4 Banner</h5>
<p>
	Includes the site title.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Below the Federal Identity Program signature and the Canada Wordmark.</li>
	<li>
		Exact location is prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Outer width: 100% (full width of the page)</li>
	<li>
		Inner width: 960 pixels (centred)</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Content is limited to the site title.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<h6>
	2.3.4.1 Site title</h6>
<p>
	Provides the title of the Web site.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<h5>
	2.3.5 Body</h5>
<p>
	Includes the content area from the original Web page and the Date modified.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Immediately below the site title.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Width: 100% (full width between the left and right margins of the printed page)</li>
	<li>
		Content area is the full width and height of the body.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Determined by the department.</li>
</ul>
<h6>
	2.3.5.1 Date modified</h6>
<p>
	Provides the most recent date on which the Web page content was formally issued, substantially changed or reviewed.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Aligned with the right boundary of the content area.</li>
	<li>
		Aligned with the bottom boundary of the content area.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		&quot;Date modified:&quot; (&quot;<span lang="fr"><em>Date de modification :</em></span>&quot;) using the ISO standard format (<abbr title="Date format: Year, Month and Day">YYYY-MM-DD</abbr>)</li>
	<li>
		Remaining presentation aspects are determined by the department.</li>
</ul>
<p>
	<strong>Exceptions:</strong></p>
<ul>
	<li>
		Where a version identifier is used.</li>
</ul>
<h4>
	2.4 Splash Pages</h4>
<p>
	The following requirements apply to all splash pages. Each splash page is structured into three main areas: header, body, and footer. The header includes the Federal Identity Program signature. The body includes three elements: the site title in each language, the language selection links and the Canada Wordmark. The footer includes the Terms and conditions links in each language.</p>
<h5>
	2.4.1 Background</h5>
<p>
	Default background for the Web page.</p>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<h5>
	2.4.2 Header</h5>
<p>
	Includes the Federal Identity Program signature.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Top of the splash page.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Outer width: 100% (full width of the page)</li>
	<li>
		Inner width: 960 pixels (centred)</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Content is limited to the Federal Identity Program signature. Only background colours and images can be used outside of that element and are prescribed by the Federal Identity Program.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<h6>
	2.4.2.1 Federal Identity Program signature</h6>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Aligned with the inner left boundary of the header.</li>
	<li>
		Exact location is prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<h5>
	2.4.3 Body</h5>
<p>
	Includes the site title in each language, the language selection links, and the Canada Wordmark.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Immediately below the header</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Outer width: 100% (full width of the page)</li>
	<li>
		Inner width: 960 pixels (centred)</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Content is limited to within the inner boundaries of the body. Only background colours and images can be used outside of those boundaries and are prescribed by the Federal Identity Program.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<h6>
	2.4.3.1 Site title</h6>
<p>
	Provides the title of the Web site.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Site title in the first official language is aligned with the inner left boundary of the body.</li>
	<li>
		Site title in the second official language is aligned with the inner right boundary of the body.</li>
	<li>
		Site titles for the first and second official languages are vertically aligned.</li>
	<li>
		Site titles for additional languages are below the site titles for the first and second official languages.</li>
	<li>
		Exact location of each site title is prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Underlined for mouse hover and keyboard focus (not underlined otherwise)</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Behaviour:</strong></p>
<ul>
	<li>
		Each site title links to the home page of the Web site in the corresponding language.</li>
</ul>
<h6>
	2.4.3.2 Language selection links</h6>
<p>
	Provides links to the home pages in the supported languages.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Aligned with the inner left boundary of the body.</li>
	<li>
		Language selection links for the first and second official languages are vertically aligned below the site title.</li>
	<li>
		Additional language selection links are below the language selection links for the first and second official languages.</li>
	<li>
		Exact location of each language selection link is prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Text for each link is the official name of the corresponding language, in its native language and alphabet.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Behaviour:</strong></p>
<ul>
	<li>
		Each link is to the home page in the corresponding language.</li>
</ul>
<h6>
	2.4.3.3 Canada Wordmark</h6>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Aligned with the inner right boundary of the body.</li>
	<li>
		Vertically aligned with the language selection links for both official languages.</li>
	<li>
		Exact location is prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<h5>
	2.4.4 Footer</h5>
<p>
	Includes the Terms and conditions (&quot;<em>Avis</em>&quot;) link.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Immediately below the body.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Outer width: 100% (full width of the page)</li>
	<li>
		Inner width: 960 pixels (centred)</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Content is limited to the Terms and conditions (&quot;<span lang="fr"><em>Avis</em></span>&quot;) link included in the footer. Only background colours and images can be used outside of those links and are prescribed by the Federal Identity Program.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<h6>
	2.4.4.2 &quot;Terms and conditions&quot; (&quot;<span lang="fr"><em>Avis</em></span>&quot;) link</h6>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Links for the two official languages are vertically aligned at the top of the footer.</li>
	<li>
		Links for additional languages are below the links for the two official languages.</li>
	<li>
		Exact location of each link is prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Behaviour:</strong></p>
<ul>
	<li>
		Each link is to a page in the corresponding language containing the notices in Appendix C, or links to those same notices.</li>
</ul>
<h4>
	2.5 Server Message Pages</h4>
<p>
	The following requirements apply to all server message pages. Each server message page is structured into three main areas: header, body, and footer. The header includes the Federal Identity Program signature, the Canada Wordmark, and the site title in each language. The body includes a content area for each language. The footer includes a Terms and conditions (&quot;<span lang="fr"><em>Avis</em></span>&quot;) link for each language.</p>
<h5>
	2.5.1 Background</h5>
<p>
	Default background for the Web page.</p>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<h5>
	2.5.2 Header</h5>
<p>
	Includes the Federal Identity Program signature, the Canada Wordmark, and the site title in each language.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Top of the server message page.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Outer width: 100% (full width of the page)</li>
	<li>
		Inner width: 960 pixels (centred)</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Content is limited to the three elements in the header. Only background colours and images can be used outside of those elements and are prescribed by the Federal Identity Program.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<h6>
	2.5.2.1 Federal Identity Program signature</h6>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Aligned with the inner left boundary of the header.</li>
	<li>
		Top of the header.</li>
	<li>
		Exact location is prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<h6>
	2.5.2.2 Canada Wordmark</h6>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Aligned with the inner right boundary of the header.</li>
	<li>
		Top of the header.</li>
	<li>
		Exact location is prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<h6>
	2.5.2.3 Site title</h6>
<p>
	Provides the title of the Web site.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		<strong>Bilingual and multilingual server message pages:</strong>
		<ul>
			<li>
				Site title in the first official language:
				<ul>
					<li>
						Aligned with the inner left boundary of the header.</li>
					<li>
						Below the Federal Identity Program signature.</li>
				</ul>
			</li>
			<li>
				Site title in the second official language:
				<ul>
					<li>
						Aligned with the inner right boundary of the header.</li>
					<li>
						Below the Canada Wordmark.</li>
				</ul>
			</li>
			<li>
				Site titles for the first and second official languages are vertically aligned.</li>
			<li>
				Site titles for additional languages are below the site titles for the first and second official languages.</li>
			<li>
				Exact locations are prescribed by the Federal Identity Program.</li>
		</ul>
	</li>
	<li>
		<strong>Unilingual server message pages:</strong>
		<ul>
			<li>
				Aligned with the inner left boundary of the header.</li>
			<li>
				Below the Federal Identity Program signature.</li>
			<li>
				Exact location is prescribed by the Federal Identity Program.</li>
		</ul>
	</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Underlined for mouse hover and keyboard focus (not underlined otherwise)</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Behaviour:</strong></p>
<ul>
	<li>
		Each site title links to the home page of the Web site in the corresponding language.</li>
</ul>
<h5>
	2.5.3 Body</h5>
<p>
	Includes a content area for each language.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Immediately below the header</li>
	<li>
		<strong>Bilingual and multilingual server message pages:</strong>
		<ul>
			<li>
				Content area for the first official language is aligned with the inner left boundary of the body.</li>
			<li>
				Content area for the second official language is aligned with the inner right boundary of the body.</li>
			<li>
				Content areas for the first and second official languages are vertically aligned at the top of the body.</li>
			<li>
				Content areas for additional languages are below the content areas for the first and second official languages.</li>
		</ul>
	</li>
	<li>
		<strong>Unilingual server message pages:</strong>
		<ul>
			<li>
				Content area is at the top of the body.</li>
		</ul>
	</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Outer width: 100% (full width of the page)</li>
	<li>
		Inner width: 960 pixels (centred)</li>
	<li>
		<strong>Bilingual and multilingual server message pages:</strong>
		<ul>
			<li>
				Each content area is half the width of the inner body.</li>
		</ul>
	</li>
	<li>
		<strong>Unilingual server message pages:</strong>
		<ul>
			<li>
				Content area is the full width and height of the body.</li>
		</ul>
	</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Each content area includes &quot;Home&quot; (&quot;<span lang="fr"><em>Accueil</em></span>&quot;) and &quot;Contact us&quot; (&quot;<span lang="fr"><em>Contactez-nous</em></span>&quot;) links.</li>
	<li>
		Content is limited to within the inner boundaries of the body. Only background colours and images can be used outside of those boundaries and are prescribed by the Federal Identity Program.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Behaviour:</strong></p>
<ul>
	<li>
		&quot;Home&quot; (&quot;<span lang="fr"><em>Accueil</em></span>&quot;) links to the home page of the Web site in the corresponding language.</li>
	<li>
		&quot;Contact us&quot; (&quot;<span lang="fr"><em>Contactez-nous</em></span>&quot;) links to a page with contact information for the Web site in the corresponding language.</li>
</ul>
<h5>
	2.5.4 Footer</h5>
<p>
	Includes the Terms and conditions (&quot;<span lang="fr"><em>Avis</em></span>&quot;) link.</p>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Immediately below the body.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Outer width: 100% (full width of the page)</li>
	<li>
		Inner width: 960 pixels (centred)</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Content is limited to the &quot;Terms and conditions&quot; (&quot;<span lang="fr"><em>Avis</em></span>&quot;) link in the footer. Only background colours and images can be used outside of those links and are prescribed by the Federal Identity Program.</li>
	<li>
		Remaining presentation aspects are prescribed by the Federal Identity Program.</li>
</ul>
<h6>
	2.5.4.1 &quot;Terms and conditions&quot; (&quot;<span lang="fr"><em>Avis</em></span>&quot;) link</h6>
<p>
	<strong>Location:</strong></p>
<ul>
	<li>
		Link for the first official language is left aligned with the inner left boundary of the footer.</li>
	<li>
		Link for the second official language is right aligned with the inner right boundary of the footer.</li>
	<li>
		Both links are vertically aligned.</li>
	<li>
		Exact location of each link is prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Dimensions:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Presentation:</strong></p>
<ul>
	<li>
		Prescribed by the Federal Identity Program.</li>
</ul>
<p>
	<strong>Behaviour:</strong></p>
<ul>
	<li>
		Each link is to a page in the corresponding language containing the notices in Appendix C, or links to those same notices.</li>
</ul>



</div>




<div class="tab-pane" id="swa_autoanalyze">

<button style="float:left" type="button" onclick="ps_swa_compliance_manager.validate_content()" class="btn">Test Document</button>  

<div style="clear:both; height:10px;"></div>

<div id="validation_check_div">



</div>

</div>

<div class="tab-pane" id="swa_textools">

<?php Widget::run('dev_shed/text_tools'); ?>

</div>


</div>










