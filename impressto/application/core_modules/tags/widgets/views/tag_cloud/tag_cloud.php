<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
@Name: Default Tag Cloud
@Type: PHP
@Filename: tag cloud
@Projectnum: 4660
@Author: Nimmitha Vidyathilaka
@Status: complete
@Date: 2012-02
*/
?>

<?php

	$this->load->library('asset_loader');
	$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/core_modules/tags/css/tag_cloud.css");
			

?>

<div class="tags_container">
 <ul class="tags">
 <?php
 
 $tag_number = 0;

  foreach($tags_array AS $tag => $frequency){
  
   for($i=0; $i<=6; $i++)
   {
    $start = $factor * $i;
    $end = $start + $factor;
    if($frequency > $start && $frequency <= $end)
    {
     $tag_number = $i+1;
    }
   }
 ?>
  <li class="tag<?php echo $tag_number; ?>">
   <a href="<?=$tag_target?>?tag=<?=$tag?>"><?=$tag?></a>
  </li>
 <?php
  }
 ?>
 </ul>
</div>