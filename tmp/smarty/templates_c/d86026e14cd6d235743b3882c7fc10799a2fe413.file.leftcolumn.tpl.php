<?php /* Smarty version Smarty-3.1.6, created on 2018-05-30 08:47:06
         compiled from "../views/default\leftcolumn.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9350694365b06d16b6b2ed8-62419100%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd86026e14cd6d235743b3882c7fc10799a2fe413' => 
    array (
      0 => '../views/default\\leftcolumn.tpl',
      1 => 1527670025,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9350694365b06d16b6b2ed8-62419100',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5b06d16b6bea5',
  'variables' => 
  array (
    'rsCategories' => 0,
    'item' => 0,
    'itemChild' => 0,
    'arrUser' => 0,
    'cartQuantityItems' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b06d16b6bea5')) {function content_5b06d16b6bea5($_smarty_tpl) {?>
<div id="leftColumn">

    <div id="leftMenu">
        <div class="menuCaption">Menu:</div>
        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['rsCategories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
            <a href="/category/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a>
            <br/>
            <?php if (isset($_smarty_tpl->tpl_vars['item']->value['children'])){?>
                <?php  $_smarty_tpl->tpl_vars['itemChild'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['itemChild']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['itemChild']->key => $_smarty_tpl->tpl_vars['itemChild']->value){
$_smarty_tpl->tpl_vars['itemChild']->_loop = true;
?>
                    --
                    <a href="/category/<?php echo $_smarty_tpl->tpl_vars['itemChild']->value['id'];?>
/"><?php echo $_smarty_tpl->tpl_vars['itemChild']->value['name'];?>
</a>
                    <br/>
                <?php } ?>
            <?php }?>
        <?php } ?>
    </div>

    <?php if (isset($_smarty_tpl->tpl_vars['arrUser']->value)){?>
        <div id="userBox">
            <a href="/user/" id="userLink"><?php echo $_smarty_tpl->tpl_vars['arrUser']->value['displayName'];?>
</a><br/>
            <a href="/user/logout/" onclick="logout();">Выход</a>
        </div>
    <?php }else{ ?>
        <div id="userBox" class="hideme">
            <a href="#" id="userLink"></a><br/>
            <a href="/user/logout/" onclick="logout();">Выход</a>
        </div>
        <div id="loginBox">
            <div class="menuCaption">Авторизация</div>
            <input type="text" id="loginEmail" name="loginEmail" value=""/><br/>
            <input type="password" id="loginPasw" name="loginPasw" value=""/><br/>
            <input type="button" onclick="login();" value="Войти"/>
        </div>
        <div id="registerBox">
            <div class="menuCaption showHidden" onclick="showRegisterBox();">Регистрация</div>
            <div id="registerBoxHidden">
                email:<br/>
                <input type="text" id="email" name="email" value=""/><br/>
                password:<br/>
                <input type="password" id="pasw1" name="pasw1" value=""/><br/>
                repeat password:<br/>
                <input type="password" id="pasw2" name="pasw2" value=""/><br/>
                <input type="button" onclick="registerNewUser();" value="Зарегестрироватся"/><br/>
            </div>
        </div>
    <?php }?>

    <div class="menuCaption">Корзина
        <div/>
        <a href="/cart/" title="Перейти в корзину">В корзине</a>
        <span id="cartQuantityItems">
        <?php if ($_smarty_tpl->tpl_vars['cartQuantityItems']->value>0){?><?php echo $_smarty_tpl->tpl_vars['cartQuantityItems']->value;?>
<?php }else{ ?>пусто<?php }?>
    </span>

    </div><?php }} ?>