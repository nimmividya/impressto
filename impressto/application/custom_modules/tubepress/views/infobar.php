<table class="infobar_top" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td style="padding: 5px;" valign="top" width="32"><a href="javascript:ps_base.showinfobar(true);" title="Show hints bar"><img src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/images/dialog-info-small.gif" border="0" height="24" width="24"></a></td>
<td style="padding: 5px;" valign="center">Click the info icon for instructions</td>
</tr>
</tbody>
</table>

<br>

<div id="infobar" style="display: <?php if(isset($_COOKIE['showinfobar'])) echo ($_COOKIE['showinfobar'] == "Y") ? "block" : "none" ?>;"><table class="infobar_top" align="center" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="padding: 5px; vertical-align:top" valign="top" width="32"><img src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/images/dialog-info.gif" height="32" width="32"></td>
<td style="padding: 5px;" valign="middle" width="100%"><p>


<?php echo getinfobarcontent('TUBEPRESSHELP');  ?>







</p></td>
<td style="padding: 0px; vertical-align: top;" width="32"><a href="javascript:ps_base.showinfobar(false);" title="Hide hints bar"><img src="<?php echo ASSETURL; ?><?php echo PROJECTNAME; ?>/default/core/images/button-close-small.gif" border="0" height="12" width="12"></a></td></tr></tbody></table></div>
