<?php
/*
@Name: Simple News Artice
@Type: PHP
@Filename: simple.tpl.php
@Lang: 
@Description: Basic listing page. Also shows full articles if news_id not null
@Author: peterdrinnan
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-02
*/
?>

<?php
	$CI->asset_loader->add_header_js("/assets/" . PROJECTNAME . "/default/custom_modules/news/js/news.js"); 
	$CI->asset_loader->add_header_css("/assets/" . PROJECTNAME . "/default/custom_modules/news/css/style.css"); 
	
	$CI->load->helper('text');
	$lang = $CI->config->item('lang_selected');

<script>

ps_news.newspageurl = '<?=$newspageurl?>';

</script>

<div class="news_list">
<?php if(isset($newsitem) && is_array($newsitem)){ // show the specific article ?>
	<ul class="list_of_news">
			
			foreach($newsitems as $newsitem){
			
				if($newsitem['newslink'] == "0") $newsitem['newslink'] = "";
				
				
				if($newsitem['newslink'] != "") $linkto = $newsitem['newslink'];
				else $linkto = "?news_id={$newsitem['news_id']}";
				
				
		?>
	<?php 
		if($lang == 'en'){ ?>
	<p>
		<a href="/en/news-archives">News Archives</a>
	</p>
	<?php } else { ?>
		<p>
		<a href="/fr/archives-des-nouvelles">Archives des nouvelles</a>
	</p>
	<?php } ?>
<?php 

	$config = array();
	
	
	
} ?>
</div>