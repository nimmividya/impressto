<?php
/*
@Name: Simple News Archive
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
	$CI =& get_instance(); 
	$CI->asset_loader->add_header_js("/assets/" . PROJECTNAME . "/default/custom_modules/news/js/news.js"); 
	$CI->asset_loader->add_header_css("/assets/" . PROJECTNAME . "/default/custom_modules/news/css/style.css"); 
	$CI->load->helper('text');
	$CI->load->library('im_pagination');
?>

<script>

ps_news.newspageurl = '<?=$newspageurl?>';

</script>

<div class="news_list">
<?php if(isset($newsitem) && is_array($newsitem)){ // show the specific article ?>

<?php }else{ // show the full list 


	if(count($newsitems) == 0){ ?>
		
		<h1><?=lang('no_archived_news')?></h1>
			
	<?php  }else{ ?>
	
		<ul class="list_of_news">
		<?php
		
			
			foreach($newsitems as $newsitem){
			
				if($newsitem['newslink'] != "") $linkto = $newsitem['newslink'];
				else $linkto = "?news_id={$newsitem['news_id']}";
				
				
				$extension = substr($newsitem['newslink'], -3, 3);
				if($extension=='pdf'){
					$icon='<img border="0" style="margin-bottom:-5px;" src="/assets/' . PROJECTNAME  . '/default/modules/news/images/pdf_icon.gif"/> ';
				}else{
					$icon='<img border="0" style="margin-bottom:-5px;" src="/assets/' . PROJECTNAME  . '/default/modules/news/images/file_icon.png"/> ';
				}
								
				if($newsitem['opennewwindow']==1)
					$target='target="_blank"';
				else
					$target=' ';
								
				if($newsitem['newstitle'] != NULL){?>
						<li class="menucontent"><?=$icon?>
							<a class="newstitlelink" <?=$target?> href="<?=$linkto?>" title="<?=$newsitem['newstitle']?>"><?=$newsitem['newstitle']?></a>
						</li>
					<?php
				}
						
			}
		?>
	</ul>
<?php 
	//$config['params'] = array(current_url() . "/?sv=");
	$config['max'] = $totalnewscount;
	$config['maxperpage'] = $moduleoptions['news_listlimit'];
	$config['page'] = $news_pager;
	$config['seperator'] = "|";
	$config['maxpagesperpage'] = 10;
	$config['pager_id'] = 'random';
	$config['anchor'] = "";
	$config['script'] = "ps_news.changepage";		
	$config['doajax'] = "";	
	$config['page_varname'] = "news_pager";	

	/* STYLING */
	$config['previmg'] = "pageprev.png";
	$config['nextimg'] = "pagenext.png";

	$config['asset_url'] = ASSETURL . "/public/default/images/";
	
	$CI->im_pagination->initialize($config); 	
	
	echo $CI->im_pagination->create_links();
	
	} 


}

?>
</div>