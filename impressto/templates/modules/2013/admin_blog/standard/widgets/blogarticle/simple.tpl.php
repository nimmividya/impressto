<?php
/*
@Name: Simple Blog Artice
@Type: PHP
@Filename: simple.tpl.php
@Lang: 
@Description: Basic listing page. Also shows full articles if blog_id not null
@Author: peterdrinnan
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-02
*/
$CI =& get_instance(); $CI->asset_loader->add_header_js("/default/custom_modules/admin_blog/themes/simple/js/blog.js"); 
$CI->asset_loader->add_header_css("/default/custom_modules/admin_blog/themes/simple/css/style.css"); 
$CI->load->helper('text');$CI->load->library('im_pagination');

$lang = $CI->config->item('lang_selected');
	

	
if(isset($blogitem) && is_array($blogitem)){ // show the specific article

	$CI->mysmarty->assign('CO_seoTitle', $blogitem['blogtitle']);

	$dbdate = $blogitem['added'];
	$numdate = strtotime($dbdate);
	$date = date('F j, Y', $numdate);
 ?>
	
	<div class="articleFull">
		<span class="goback"><a href="<?=$blogpageurl?>"><?=lang('back_to_blogs')?></a></span>
		<h1><?php echo $blogitem['blogtitle']; ?></h1>
		<div class="acrticleMeta">
			<span><?php echo $date; ?> by <span class="author"><?=$blogitem['author']?></span></span>
		</div><!-- [END].acrticleMeta -->
		<?php echo $blogitem['blogcontent']; ?>
	</div><!-- [END] .articleFull -->
	
	<?php if(isset($comments)) echo $comments; ?>
	
	
<?php }else{


	if(count($blogitems) == 0){ ?>
		
		<h1><?=lang('no_blogs')?></h1>
			
	<?php  }else{
	
		foreach($blogitems as $blogitem){
	
		$dbdate = $blogitem['added'];
		$numdate = strtotime($dbdate);
		$date = date('F j, Y', $numdate);
		
		if($blogitem['blogtitle'] != NULL){ ?>
			
			<div class="articlePreview">
			
			<?php if($blogitem['featured_image'] != ""){ ?>
			
				<img class="blog-featured-image" src="<?=$blogitem['featured_image']?>" style="max-width:200px;" />
						
			<?php }else{ ?>
			
				<div class="blog-empty-image">&nbsp;</div>

			<?php }	?>
			
				<div class="blog-summary">
						
					<h1><a href="<?=$blogpageurl?>/?blog_id=<?php echo $blogitem['blog_id']; ?>" title="<?php echo $blogitem['blogtitle']; ?>"><?php echo $blogitem['blogtitle']; ?></a></h1>
					<div class="acrticleMeta">
						<span><?php echo $date; ?> by <span class="author"><?=$blogitem['author']?></span></span>
					</div><!-- [END].acrticleMeta -->
					<?php echo highlight_phrase($blogitem['blogshortdescription'], $search_keywords, '<span style="background: #FFD760; color:#990000">', '</span>'); ?>
			
				</div>
			
			</div><!-- [END] .articlePreview -->
			
		
			<div class="clearfix"></div>
			<hr />
			
		<?php }
	}

	
	//$config['params'] = array(current_url() . "/?sv=");
	$config['max'] = $totalblogcount;
	$config['maxperpage'] = $moduleoptions['blog_listlimit'];
	$config['page'] = $blog_pager;
	$config['seperator'] = "|";
	$config['maxpagesperpage'] = 10;
	$config['pager_id'] = 'random';
	$config['anchor'] = "";
	$config['script'] = FALSE; //"ps_blog.changepage";		
	$config['doajax'] = "";	
	$config['page_varname'] = "blog_pager";	

	/* STYLING */
	$config['previmg'] = "pageprev.png";
	$config['nextimg'] = "pagenext.png";

	$config['asset_url'] = ASSETURL . "/public/default/images/";
	
	$CI->im_pagination->initialize($config); 	
	echo $CI->im_pagination->create_links();
	
	}

	
}