<?php /* Smarty version Smarty-3.1.6, created on 2018-05-28 14:43:14
         compiled from "../views/default\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17707008715b06d16b51ca77-35149061%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9797888b337e03f99b06385b60a372bbb52d5e02' => 
    array (
      0 => '../views/default\\header.tpl',
      1 => 1527518591,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17707008715b06d16b51ca77-35149061',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5b06d16b693ac',
  'variables' => 
  array (
    'pageTitle' => 0,
    'templateWebPath' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b06d16b693ac')) {function content_5b06d16b693ac($_smarty_tpl) {?><html>
<head>
    <title><?php echo $_smarty_tpl->tpl_vars['pageTitle']->value;?>
</title>
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['templateWebPath']->value;?>
styles/main.css" type="text/css" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" src="/scripts/main.js"></script>
</head>
<body>
<div id="header">
    <h1>My Shop</h1>
</div>

<?php echo $_smarty_tpl->getSubTemplate ('leftcolumn.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div id="centerColumn">
<?php }} ?>