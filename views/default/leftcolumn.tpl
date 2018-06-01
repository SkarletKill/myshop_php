{* left column *}
<div id="leftColumn">

    <div id="leftMenu">
        <div class="menuCaption">Menu:</div>
        {foreach $rsCategories as $item}
            <a href="/category/{$item['id']}/">{$item['name']}</a>
            <br/>
            {if isset($item['children'])}
                {foreach $item['children'] as $itemChild}
                    --
                    <a href="/category/{$itemChild['id']}/">{$itemChild['name']}</a>
                    <br/>
                {/foreach}
            {/if}
        {/foreach}
    </div>


    {if isset($arrUser)}
        <div id="userBox">
            <a href="/user/" id="userLink">{$arrUser['displayName']}</a><br/>
            <a href="/user/logout/" onclick="logout();">Выход</a>
        </div>
    {else}
        <div id="userBox" class="hideme">
            <a href="#" id="userLink"></a><br/>
            <a href="/user/logout/" onclick="logout();">Выход</a>
        </div>
        {if !isset($hideLoginBox)}
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
        {/if}
    {/if}

    <div class="menuCaption">Корзина
        <div></div>
        <a href="/cart/" title="Перейти в корзину">В корзине</a>
        <span id="cartQuantityItems">
            {if $cartQuantityItems > 0}{$cartQuantityItems}{else}пусто{/if}
        </span>
    </div>
</div>