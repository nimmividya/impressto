<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>


<?php

foreach($report_data AS $row){

?>

<hr />
<span><a href="<?=$row['page_link']?>" target="_blank"><?=$row['page_title']?></a></strong>&nbsp;&nbsp;<?=$row['update_stamp']?></span>

<p>
<?=$row['message']?>

</p>

<br />


<?php } ?>

