<?php 

$sql = "SELECT banner_image FROM ps_top_banners WHERE page_node_id = '{$page_id}'";

$query = $this->db->query($sql);
		
$banner_image = "";
		
if ($query->num_rows() > 0){
			
		$row = $query->row();
			
		$banner_image =  $row->banner_image;
			
}

if($banner_image == "") $banner_image = "lss_about.jpg";

//$projectnum = $this->config->item('projectnum');
	
?>
<img src="<?php echo ASSETURL; ?>upload/widgets/top_banners/images/<?php echo $banner_image; ?>" alt="<?php echo $banner_image; ?>" />

