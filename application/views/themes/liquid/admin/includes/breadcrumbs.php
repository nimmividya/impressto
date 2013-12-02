
<?php if(isset($breadcrumbs) && is_array($breadcrumbs)){ ?>

<nav>
	<div id="jCrumbs" class="breadCrumb module">
	<ul>
		<li>
			<a href="/admin/"><i class="icon-home"></i></a>
		</li>
		<?php foreach($breadcrumbs as $label => $link){ ?>
		<li>
		<?php if($link == ""){ echo $label; }
		else {?>
		
			<a href="<?=$link?>"><?=$label?></a>
                              
		<?php } ?>
		</li>
		<?php } ?>
	</ul>
	</div>
</nav>
					
<?php } ?>