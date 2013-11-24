<?php /* Smarty version Smarty-3.1.6, created on 2013-04-24 21:44:42
         compiled from "C:/wamp/www/motuha//motuha/templates/pages/101/standard_en\includes\footer.tpl.php" */ ?>
<?php /*%%SmartyHeaderCode:1798951788a8a8ef460-68130641%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '91e8b8343ee64a1496c35604d8799c285fc77495' => 
    array (
      0 => 'C:/wamp/www/motuha//motuha/templates/pages/101/standard_en\\includes\\footer.tpl.php',
      1 => 1366854101,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1798951788a8a8ef460-68130641',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ps_ismobile' => 0,
    'ps_domobile' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_51788a8a96682',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51788a8a96682')) {function content_51788a8a96682($_smarty_tpl) {?>
<?php if (isset($_smarty_tpl->tpl_vars['ps_ismobile']->value)&&$_smarty_tpl->tpl_vars['ps_ismobile']->value==true&&isset($_smarty_tpl->tpl_vars['ps_domobile']->value)&&$_smarty_tpl->tpl_vars['ps_domobile']->value==false){?>

	<a href="javascript:ps_base.setmobile(true);">Mobile Version</a>

<?php }?>


</div><!-- [END] #wrapper -->



<!-- Piwik -->
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://impressto.com/piwik/" : "http://impressto.com/piwik/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://impressto.com/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Tracking Code -->


</body>
</html><?php }} ?>