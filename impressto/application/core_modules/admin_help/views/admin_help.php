<?php
/*
@Name: Help View
@Type: PHP
@Filename: admin_help.php
@Description: 
@Author: Nimmitha Vidyathilaka
@Projectnum: 1001
@Version: 1.2
@Status: complete
@Date: 2012-05-15
*/
?>


<?php 

if(is_array($content)){

	foreach($content as $label => $sectioncontent){ ?>



<p>
<hr />
<?=$sectioncontent?>

</p>

<br />

<?php }

}else{ ?>

<p>

<?=$content?>

</p>

<?php } ?>







