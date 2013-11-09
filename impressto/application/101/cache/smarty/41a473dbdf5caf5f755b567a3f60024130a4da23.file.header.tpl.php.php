<?php /* Smarty version Smarty-3.1.6, created on 2013-04-24 21:44:42
         compiled from "C:/wamp/www/motuha//motuha/templates/pages/101/standard_en\includes\header.tpl.php" */ ?>
<?php /*%%SmartyHeaderCode:1401251788a8a667606-79837606%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '41a473dbdf5caf5f755b567a3f60024130a4da23' => 
    array (
      0 => 'C:/wamp/www/motuha//motuha/templates/pages/101/standard_en\\includes\\header.tpl.php',
      1 => 1366854101,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1401251788a8a667606-79837606',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'CO_seoTitle' => 0,
    'site_title' => 0,
    'site_keywords' => 0,
    'site_description' => 0,
    'output_misc_header_top_assets' => 0,
    'output_header_css' => 0,
    'output_header_js' => 0,
    'CO_Javascript' => 0,
    'output_header_misc_assets' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_51788a8a880b3',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51788a8a880b3')) {function content_51788a8a880b3($_smarty_tpl) {?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title><?php echo $_smarty_tpl->tpl_vars['CO_seoTitle']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['site_title']->value;?>
</title>
    <meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['site_keywords']->value;?>
" />
    <meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['site_description']->value;?>
" />
	<meta name="robots" content="index, follow" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- change these GEOLOCATION tags for specific clients -->
	<meta name="location" content="CA, ON, Ottawa" />
	<meta name="geo.position" content="43;-76" />
	<meta name="geo.region" content="CA-ON" />
	<meta name="geo.placename" content="Ottawa" />
	<meta name="abstract" content="Website Design and Development" />
	<meta name="classification" content="Website Design and Development" />
	
	<!-- 
		
	WE NEED A CODE METATAG GENERATOR HERE 
	
	-->
	
		
	
    <!-- favicons -->
    <link rel="shortcut icon" href="/assets/public/images/favicon.ico" type="image/x-icon"/>


	<!--[if lte IE 7]>
		<link rel="stylesheet" type="text/css" media="screen" href="/assets/public/css/ie-7.css" />
	<![endif]-->
	
    <!-- scripts -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	

	<?php if (isset($_smarty_tpl->tpl_vars['output_misc_header_top_assets']->value)&&$_smarty_tpl->tpl_vars['output_misc_header_top_assets']->value!=''){?>
		<?php echo $_smarty_tpl->tpl_vars['output_misc_header_top_assets']->value;?>

	<?php }?>
	
		
	<?php if (isset($_smarty_tpl->tpl_vars['output_header_css']->value)&&$_smarty_tpl->tpl_vars['output_header_css']->value!=''){?>
		<?php echo $_smarty_tpl->tpl_vars['output_header_css']->value;?>

	<?php }?>
	
	
	<?php if (isset($_smarty_tpl->tpl_vars['output_header_js']->value)&&$_smarty_tpl->tpl_vars['output_header_js']->value!=''){?>
		<?php echo $_smarty_tpl->tpl_vars['output_header_js']->value;?>

	<?php }?>
	
	<?php if (isset($_smarty_tpl->tpl_vars['CO_Javascript']->value)&&$_smarty_tpl->tpl_vars['CO_Javascript']->value!=''){?>
		<script type="text/javascript">
			<?php echo $_smarty_tpl->tpl_vars['CO_Javascript']->value;?>

		</script>
	<?php }?>
    
	
	<?php if (isset($_smarty_tpl->tpl_vars['output_header_misc_assets']->value)&&$_smarty_tpl->tpl_vars['output_header_misc_assets']->value!=''){?>
		<?php echo $_smarty_tpl->tpl_vars['output_header_misc_assets']->value;?>

	<?php }?>
	
	

</head>
<body>
<div id="wrapper">

<?php }} ?>