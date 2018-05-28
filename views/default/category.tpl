{* Страница категорий *}
<h1>Товары категории {$rsCategory['name']}</h1>

{foreach $rsProducts as $item name=products}
    <div style="float: left; padding: 0 30px 40px 0">
        <a href="/product/{$item['id']}/">
            <img src="/images/products/{$item['image']}" width="100" alt="product image {$item['id']}">
        </a><br/>
        <a href="/product/{$item['id']}/">{$item['name']}</a>
    </div>

    {if $smarty.foreach.products.iteration mod 3 == 0}
        <div style="clear: both;"></div>
    {/if}

    {foreachelse}
        {if $rsCategory['id'] > 2}
            <h3>Products not found</h3>
        {/if}
{/foreach}

{foreach $rsChildCategories as $item name=childCategories}
    <h2><a href="/category/{$item['id']}/">{$item['name']}</a></h2>
{/foreach}