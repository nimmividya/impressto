<?php /* Smarty version Smarty-3.1.6, created on 2013-06-30 15:23:41
         compiled from "C:/wamp/www/impressto/impressto/templates/pages/101/standard_en\404.tpl.php" */ ?>
<?php /*%%SmartyHeaderCode:896351d085bd2514f6-82871190%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b10c8d0d0c3baee70fef362a492b765e9198e930' => 
    array (
      0 => 'C:/wamp/www/impressto/impressto/templates/pages/101/standard_en\\404.tpl.php',
      1 => 1372617441,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '896351d085bd2514f6-82871190',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_51d085bd4056c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d085bd4056c')) {function content_51d085bd4056c($_smarty_tpl) {?>

<?php ob_start();?><?php echo $_smarty_tpl->getSubTemplate ("includes/header.tpl.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>

	<div class="content_container twoColumn clearfix">
		<h1>404 - Page not Found</h1>
	</div><!-- [END] .content_container -->
<?php ob_start();?><?php echo $_smarty_tpl->getSubTemplate ("includes/footer.tpl.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>

<?php }} ?>