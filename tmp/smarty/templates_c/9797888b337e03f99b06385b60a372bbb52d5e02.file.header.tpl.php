<?php /* Smarty version Smarty-3.1.6, created on 2018-05-30 09:53:56
         compiled from "../views/default\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9250890435b0e74b4147934-39097241%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9797888b337e03f99b06385b60a372bbb52d5e02' => 
    array (
      0 => '../views/default\\header.tpl',
      1 => 1527673607,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9250890435b0e74b4147934-39097241',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pageTitle' => 0,
    'templateWebPath' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5b0e74b41b4f4',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b0e74b41b4f4')) {function content_5b0e74b41b4f4($_smarty_tpl) {?><html>
<head>
    <title><?php echo $_smarty_tpl->tpl_vars['pageTitle']->value;?>
</title>
    <link rel="stylesheet" href="/<?php echo $_smarty_tpl->tpl_vars['templateWebPath']->value;?>
styles/main.css"/>
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