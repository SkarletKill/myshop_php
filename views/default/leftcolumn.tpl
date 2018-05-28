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

    <div class="menuCaption">Корзина<div/>
    <a href="/cart/" title="Перейти в корзину">В корзине</a>
    <span id="cartQuantityItems">
        {if $cartQuantityItems > 0}{$cartQuantityItems}{else}пусто{/if}
    </span>

</div>