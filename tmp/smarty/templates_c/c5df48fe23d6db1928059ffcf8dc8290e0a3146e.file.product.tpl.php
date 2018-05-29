<?php /* Smarty version Smarty-3.1.6, created on 2018-05-29 10:21:26
         compiled from "../views/default\product.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10948415365b0ae49f5125d2-76413096%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c5df48fe23d6db1928059ffcf8dc8290e0a3146e' => 
    array (
      0 => '../views/default\\product.tpl',
      1 => 1527589283,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10948415365b0ae49f5125d2-76413096',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5b0ae49f6fe94',
  'variables' => 
  array (
    'rsProducts' => 0,
    'itemInCart' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b0ae49f6fe94')) {function content_5b0ae49f6fe94($_smarty_tpl) {?>
<h3><?php echo $_smarty_tpl->tpl_vars['rsProducts']->value['name'];?>
</h3>

<img width="575" src="/images/products/<?php echo $_smarty_tpl->tpl_vars['rsProducts']->value['image'];?>
" alt="product image <?php echo $_smarty_tpl->tpl_vars['rsProducts']->value['id'];?>
">
Стоимость: <?php echo $_smarty_tpl->tpl_vars['rsProducts']->value['price'];?>


<a id="removeCart_<?php echo $_smarty_tpl->tpl_vars['rsProducts']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['itemInCart']->value==0){?>class="hideme"<?php }?> href="#" onClick="removeFromCart(<?php echo $_smarty_tpl->tpl_vars['rsProducts']->value['id'];?>
); return false;" alt="Удалить из корзины">Удалить из корзины</a>
<a id="addCart_<?php echo $_smarty_tpl->tpl_vars['rsProducts']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['itemInCart']->value!=0){?>class="hideme"<?php }?> href="#" onClick="addToCart(<?php echo $_smarty_tpl->tpl_vars['rsProducts']->value['id'];?>
); return false;" alt="Добавить в корзину">Добавить в корзину</a>
<p>Описание <br/><?php echo $_smarty_tpl->tpl_vars['rsProducts']->value['description'];?>
</p><?php }} ?>