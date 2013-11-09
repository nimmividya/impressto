
				
<?php if(isset($breadcrumbs) && is_array($breadcrumbs)){ ?>




				<ul id="breadcrumbs" class="xbreadcrumbs cf">
					<li class="parent">
						<i style="color:#137DBB" class="icon-home"></i>
						<a href="/admin/" class="vam">bitHeads Central</a>
					</li>
					
				<?php foreach($breadcrumbs as $label => $link){
				
					$label = strip_tags(html_entity_decode($label));
					
			

				?>
				<li class="parent">
				<?php if($link == ""){  ?>
				<a><?=$label?></a>
				<?php }	else {?>
				<a href="<?=$link?>"><?=$label?></a>
                   
		<?php } ?>
		</li>
		<?php } ?>
		
		</ul>
				
				
<?php } ?>