<?php
echo '<?xml version="1.0" encoding="utf-8"?>' . "
";
?>
<rss version="2.0">

<channel>  
<title><?php echo $feed_name; ?></title>
<link><?php echo $feed_url; ?></link>
<description><?php echo $page_description; ?></description> 
<language><?php echo $page_language; ?></language> 
 

<?php

$lang = $this->config->item('lang_selected');

foreach($news_posts as $key => $feed){ 

	if($feed['newsshortdescription'] == "") 
		$feed['newsshortdescription'] = character_limiter($feed['newscontent'], 200);
		
	
	$rsslink = "{$url_protocol}{$domain_name}" . $moduleoptions['news_page_' . $lang] . "?news_id={$feed['news_id']}";
	
?>  

    <item>  
		<title><?=$feed['newstitle']?></title> 
		<link><?=$rsslink?></link>
		<guid><?=$rsslink?></guid>  
		<description><?php echo htmlspecialchars($feed['newsshortdescription'], ENT_QUOTES, 'UTF-8');?></description>  
		<pubdate><?=$feed['published']?></pubdate>  
	 </item>  
  
<?php } ?>  

</channel>  
</rss>  