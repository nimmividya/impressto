<?php /* Smarty version Smarty-3.1.6, created on 2013-04-24 21:44:42
         compiled from "C:/wamp/www/motuha//motuha/templates/pages/101/standard_en\404.tpl.php" */ ?>
<?php /*%%SmartyHeaderCode:2116751788a8a289ac1-02178318%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9ce1e90d3f72a268f3a5fa3b0153b68b3637827e' => 
    array (
      0 => 'C:/wamp/www/motuha//motuha/templates/pages/101/standard_en\\404.tpl.php',
      1 => 1366854101,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2116751788a8a289ac1-02178318',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_51788a8a5c697',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51788a8a5c697')) {function content_51788a8a5c697($_smarty_tpl) {?>

<?php ob_start();?><?php echo $_smarty_tpl->getSubTemplate ("includes/header.tpl.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>

	<div class="content_container twoColumn clearfix">
		<h1>404 - Page not Found</h1>
	</div><!-- [END] .content_container -->
<?php ob_start();?><?php echo $_smarty_tpl->getSubTemplate ("includes/footer.tpl.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>

<?php }} ?>