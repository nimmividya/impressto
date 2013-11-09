<!--
@Name: utopian
@Type: PHP
@Author: Galbraith Desmond
@Projectnum: 
@Version: 1.0
@Status: development
@Date: 2012/08/29
-->


<?php

$CI = &get_instance();

	$CI->load->library('asset_loader');
	
	// skin1 = rounded borders, skin2 = simple white, skin3 = dark
	$CI->asset_loader->add_header_css("/default/custom_modules/navigation_menu/themes/utopian/css/utopian_menus.css");
	

?>

<div id="navigation">
<ul id="utopian-navigation" class="utopian">
<?php

	echo navbarorderlist($groups);
		
?>
</ul>

</div>
<div style="clear:both"></div>


<?php

	/**
	* loop throught the adjacency array to build a view
	*/
	function navbarorderlist($items, $csstags = null) {
		
		
		global $group_indent, $Image_Color;
		
		$CI =& get_instance();
		
		
		$managegroupspageitems = '';

		if (count($items) && is_array($items)) {
			
			$group_indent ++;
			
			foreach ($items as $cat_id=>$catvals) {
				
				
				$has_childen = false;
				
				if(isset($catvals['children']) && count($catvals['children'])) { 
					$has_childen = true;
				}
				
				
				if($catvals['CO_Active'] == 1 && $catvals['CO_Public'] == 1){
					
					
					
					$code_indent = str_repeat("    ",($group_indent-1)); // sanity saver for lowlife coders
					
					$managegroupspageitems .= "$code_indent<li";
					
				
					if($has_childen) $managegroupspageitems .= " class=\"dropdown\"";
					
					$managegroupspageitems .= ">";
						
					
					$managegroupspageitems .=  "<a href=\"/" . $CI->config->item('lang_selected') . "/";
					
					if($catvals['CO_Url'] != "") $managegroupspageitems .= $catvals['CO_Url'];
					else $managegroupspageitems .= $catvals['CO_Node'];
					
					$managegroupspageitems .= "\">\n";
					
					if($catvals['CO_MenuTitle'] != "") $managegroupspageitems .= $catvals['CO_MenuTitle'];
					else $managegroupspageitems .= $catvals['CO_seoTitle'];
					
					$managegroupspageitems .=  "</a>\n";
					
					
					
					if ($has_childen) {
			
						$subitems = $code_indent . $code_indent . navbarorderlist($catvals['children']);
						
						if(trim($subitems) != ""){
							
							$managegroupspageitems .= $code_indent . $code_indent . "\n<ul>\n";
							$managegroupspageitems .= trim($subitems);
							$managegroupspageitems .= $code_indent . $code_indent . "</ul>\n";
							
							
						}
					
					}
					
					$managegroupspageitems .= "</li>\n";
					
				}
	
				
			}
			
			$group_indent --;
			
			
		}


		
		return $managegroupspageitems;
		
	}///////
	
?>
		
