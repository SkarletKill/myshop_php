{* left column *}
<div id="leftColumn">

    <div id="leftMenu">
        <div class="menuCaption">Menu:</div>
        {foreach $rsCategories as $item}
            <a href="/category/{$item['id']}/">{$item['name']}</a><br/>

            {if isset($item['children'])}
                {foreach $item['children'] as $itemChild}
                    --<a href="/category/{$itemChild['id']}/">{$itemChild['name']}</a><br/>
                {/foreach}
            {/if}
        {/foreach}
    </div>

    <div id="registerBox">
        <div class="menuCaption showHidden" onclick="showRegisterBox();">Регистрация</div>
        <div class="registerBoxHidden">
            email:<br/>
            <input type="text" id="email" name="email" value=""/><br/>
            password:<br/>
            <input type="password" id="pasw1" name="pasw1" value=""/><br/>
            repeat password:<br/>
            <input type="password" id="pasw2" name="pasw2" value=""/><br/>
            <input type="button" onclick="registerNewUser();" value="Зарегестрироватся"/><br/>
        </div>
    </div>

    <div class="menuCaption">Корзина<div/>
    <a href="/cart/" title="Перейти в корзину">В корзине</a>
    <span id="cartQuantityItems">
        {if $cartQuantityItems > 0}{$cartQuantityItems}{else}пусто{/if}
    </span>

</div>