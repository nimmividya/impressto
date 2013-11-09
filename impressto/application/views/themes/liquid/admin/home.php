<script type="text/javascript">
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

<?php if($showversionnotice){ ?>

<div id="ps_version_confirm_notice" class="alert alert-block alert-error fade in">
	<h3 class="alert-heading">BitHeads Central has been updated</h3>
	<p>Your version of BitHeads Central has been updated from <?=$old_version?> to <?=$current_version?>. 
	<p>
		<?php if(is_array($ps_version_change_notes)){ ?>
		<h4>Changes</h4>
		<ul>
			<?php foreach($ps_version_change_notes as $note){ ?>
				<li><?php echo $note?></li>
			<?php }	?>
		</ul>
		<?php } ?>
	</p>
		<a href="http://www.central.bitheads.ca/changelogs/<?=$current_version?>">See the full change log</a>.</p>
	<p>
		<a href="javascript:setversionconfirm()" class="btn">Close this dialogue</a>
	</p>
</div>
		  
<?php } ?>

Welcome to <?php echo PROJECTNAME; ?>. Here are some resources that you may find useful:

<ul>
	<li><a href="http://kb.central.bitheads.ca" target="_blank">Getting Started</a></li>
	<li><a href="http://kb.central.bitheads.ca" target="_blank">BitHeads Central</a></li>
</ul>


	