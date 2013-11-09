<?php
/*
@Name: Contrast Checker Tool
@Type: PHP
@Filename: wcag_contrast_checker.php
@Description: A simple WCAG color contrast checker
@Projectnum: 1001
@Author: webdev@fixmate.com
@Status: development
@Date: 2012-06-29
*/
?>

<?php

$this->load->library('asset_loader');
$this->load->library('formelement');
		
$this->asset_loader->add_header_css("/assets/" . PROJECTNAME . "/default/widgets/wcag_contrast_checker/css/style.css");		
$this->asset_loader->add_header_css("/assets/" . PROJECTNAME . "/default/widgets/wcag_contrast_checker/css/jpicker.css");
$this->asset_loader->add_header_js("/assets/" . PROJECTNAME . "/default/widgets/wcag_contrast_checker/js/jpicker.js");	
$this->asset_loader->add_header_js("/assets/" . PROJECTNAME . "/default/widgets/wcag_contrast_checker/js/wcag_contrast_checker.js");


?>


<div class="clearfix;" style="padding:10px; background-color:#DDDDDD;">

<label>Background</label>
<input style="width:60px" class="jcolor_picker" type="text" name="background_color" id="background_color" value="000000" />


<label>Foreground</label>
<input style="width:60px" class="jcolor_picker" type="text" name="foreground_color" id="foreground_color" value="ffffff" />


<div class="clearfix"></div>


<table>
<tr>
<td style="padding:10px">
<span style="padding:5px; font-size:12px; float:left;" id="font_style_standard_display">Lorem Ipsum</span>
<div style="float:left" id="font_style_standard_compliance"></div>

</td>
<td>&nbsp;</td>
<td style="padding:10px">
<span style="padding:5px; font-size:18px; float:left;" id="font_style_large_display">Lorem Ipsum</span>
<div style="float:left" id="font_style_large_compliance"></div>
</td>
</tr>

<tr>
<td><label>Brightness Difference: (&gt;= 125)</label><input type="text" maxlength="7" style="width:40px" id="brightness_difference"></td>
</tr>

<tr>
<td><label>Colour Difference: (&gt;= 500)</label><input type="text" maxlength="7" style="width:40px" id="color_difference"></td>
</tr>

<tr>
<td><label>Colours Compliant</label><input type="text" maxlength="7" style="width:40px" id="colors_compliant"></td>
</tr>



<tr>
<td><label>Background RGB</label><input type="text" maxlength="7" style="width:80px" id="background_rgb"></td>
</tr>

<tr>
<td><label>Foreground RGB</label><input type="text" maxlength="7" style="width:80px" id="foreground_rgb"></td>
</tr>

<tr>
<td><label>Contrast Ratio</label><span id="contrastratio"></span></td>
</tr>

</table>



</div>

