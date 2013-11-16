<script>

function setversionconfirm(){

	var url = "/admin/admin/setversionconfirm";
	
	$.get(url, function(data) {
		
		if(data == "complete"){
			$('#ps_version_confirm_notice').fadeOut();
		}
		
	});
	
	
	

}

</script>
<h1>HOME PAGE</h2>

<br />

<?php


if($showversionnotice){ ?>


<div id="ps_version_confirm_notice" class="alert alert-block alert-error fade in">

            <h3 class="alert-heading">PageShaper has been updated</h3>
            <p>Your version of PageShaper has been updated from <?=$old_version?> to <?=$current_version?>. 
			<p>
	
			<?php if(is_array($ps_version_change_notes)){ ?>
			
				<h4>Changes</h4>
				<ul>
			
				<?php
			
				foreach($ps_version_change_notes as $note){ ?>
				
					<li><?=$note?></li>
				
				<?php
				
				}
				
				?>
			
				</ul> 
			
			<?php } ?>
			
			
			</p>
			<a href="http://www.pageshaper.ca/changelogs/<?=$current_version?>">See the full change log</a>.</p>
            <p>
             <a href="javascript:setversionconfirm()" class="btn">Close this dialogue</a>
            </p>
          </div>
		  
<?php 	
}


?>

Welcome to PageShaper. Here are some resources that you may find useful:

<p>
</p>

<br />
<ul>
<li><a style="color:#000000" href="http://kb.pageshaper.ca" target="_blank">Getting Started</a></li>
<li><a style="color:#000000" href="http://kb.pageshaper.ca" target="_blank">PageShaper Developer Guide</a></li>
</ul>


	