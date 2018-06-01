{* Страница заказа *}
<h2>Данные заказа</h2>
<form id="formOrder" action="/cart/saveorder/" method="POST">
    <table>
        <tr>
            <th>№</th>
            <th>Наименование</th>
            <th>Количество</th>
            <th>Цена за единицу</th>
            <th>Стоимость</th>
        </tr>

        {foreach $rsProducts as $item name=products}
            <tr>
                <td>{$smarty.foreach.products.iteration}</td>
                <td><a href="/product/{$item['id']}/">{$item['name']}</a></td>
                <td>
                    <span id="itemQuantity_{$item['id']}">
                        <input type="hidden" name="itemQuantity_{$item['id']}" value="{$item['quantity']}"/>
                        {$item['quantity']}
                    </span>
                </td>
                <td>
                    <span id="itemPrice_{$item['id']}">
                        <input type="hidden" name="itemPrice_{$item['id']}" value="{$item['price']}"/>
                        {$item['price']}
                    </span>
                </td>
                <td>
                    <span id="itemRealPrice_{$item['id']}">
                        <input type="hidden" name="itemRealPrice_{$item['id']}" value="{$item['realPrice']}"/>
                        {$item['realPrice']}
                    </span>
                </td>
            </tr>
        {/foreach}
    </table>

    {if isset($arrUser)}
        {$buttonClass = ""}
        <h2>Данные заказчика</h2>
        <div class="orderUserInfoBox" {$buttonClass}>
            {$name = $arrUser['name']}
            {$phone = $arrUser['phone']}
            {$address = $arrUser['address']}
            <table>
                <tr>
                    <td>Имя*</td>
                    <td><input type="text" id="name" name="name" value="{$name}"/></td>
                </tr>
                <tr>
                    <td>Тел*</td>
                    <td><input type="text" id="phone" name="phone" value="{$phone}"/></td>
                </tr>
                <tr>
                    <td>Адрес*</td>
                    <td><textarea id="address" name="address">{$address}</textarea></td>
                </tr>
            </table>
        </div>
    {else}
        <div id="loginBox">
            <div class="menuCaption">Авторизация</div>
            <table>
                <tr>
                    <td>Логин</td>
                    <td><input type="text" id="loginEmail" name="loginEmail" value=""/></td>
                </tr>
                <tr>
                    <td>Пароль</td>
                    <td><input type="password" id="loginPasw" name="loginPasw" value=""/></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="button" onclick="login();" value="Войти"/></td>
                </tr>
            </table>
        </div>

        <div id="registerBox"> или <br/>
            <div class="menuCaption">Регистрация нового пользователя:</div>
                email* :<br/>
                <input type="text" id="email" name="email" value=""/><br/>
                password* :<br/>
                <input type="password" id="pasw1" name="pasw1" value=""/><br/>
                repeat password* :<br/>
                <input type="password" id="pasw2" name="pasw2" value=""/><br/>

                Имя* :<input type="text" id="name" name="name" value=""/><br/>
                Тел* :<input type="text" id="phone" name="phone" value=""/><br/>
                Адрес* :<textarea id="address" name="address"></textarea><br/>

                <input type="button" onclick="registerNewUser();" value="Зарегестрироватся"/><br/>
        </div>
        {$buttonClass = "class='hideme'"}
    {/if}

    <input {$buttonClass} id="btnSaveOrder" type="button" value="Оформить заказ" onclick="saveOrder();"/>

</form>