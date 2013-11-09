<!--
@Name: Simple Breadcrumbs
@Type: PHP
@Author: Peter
@Projectnum: 
@Version: 1.0
@Status: development
@Date: 2012/08/07
-->



<div class="clearfix" id="breadcrumbs">

	<?php 
	
	$max = count($breadcrumbtraildata);
	
	$i = 0;
	
	if($max > 0){ ?>
	
	<ul>
	
	<li>
			<a href="/<?=$lang?>/">Home</a>&gt;</li>
	<li>
		
	<?php foreach($breadcrumbtraildata as $title => $url){

	?>
	<li>
		<a href="/<?=$lang?>/<?=$url?>"><?=$title?></a><?php if($i < ($max -1)) echo "&gt;";	?></li>
	<li>
		
	
	<?php

		$i++;
	} 
	
	
	?>

	</ul>
	
	<?php } ?>
	
	<ul class="social">
		<li class="facebook">
			<a href="https://www.facebook.com/carms.ca" title="Like us on Facebook!">Facebook</a></li>
		<li class="twitter">
			<a href="https://twitter.com/carms_ca" title="Follow us on Twitter!">Twitter</a></li>
	</ul>
</div>

