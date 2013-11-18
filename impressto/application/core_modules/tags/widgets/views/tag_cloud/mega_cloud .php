<!--
@Name: MegaCloud
@Type: PHP
@Filename: mega_cloud.php
@Projectnum: 1001
@Author: Nimmitha Vidyathilaka
@Status: complete
@Date: 2012-02
-->
<?php


	$this->load->library('asset_loader');
	$this->asset_loader->add_header_css(ASSETURL . PROJECTNAME . "/core_modules/tags/css/mega_cloud.css");
			

?>

       <h2>Popular Searches</h2>
        <div id="tagcloud">
            <?php 
            // start looping through the tags
            //foreach ($terms as $term):
			foreach($tags_array AS $tag => $frequency){
			  
                // determine the popularity of this term as a percentage
                $percent = floor(($frequency / $maxfrequency) * 100);

                // determine the class for this term based on the percentage
                if ($percent < 20):
                    $class = 'smallest';
                elseif ($percent >= 20 and $percent < 40):
                    $class = 'small';
                elseif ($percent >= 40 and $percent < 60):
                    $class = 'medium';
                elseif ($percent >= 60 and $percent < 80):
                    $class = 'large';
                else:
                    $class = 'largest';
                endif;
            ?>
            <span class="<?php echo $class; ?>">
                <a href="<?=$tag_target?>?tag=<?php echo urlencode($tag); ?>"><?=$tag?></a>
            </span>
            <?php endforeach; ?>
        </div>

