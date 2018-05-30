{* Страница пользователя *}

<h1>Ваши регистрационные данные</h1>
<table border="0">
    <tr>
        <td>Логин (email)</td>
        <td>{$arrUser['email']}</td>
    </tr>
    <tr>
        <td>Имя</td>
        <td><input type="text" id="newName" value="{$arrUser['name']}"/></td>
    </tr>
    <tr>
        <td>Тел</td>
        <td><input type="text" id="newPhone" value="{$arrUser['phone']}"/></td>
    </tr>
    <tr>
        <td>Адрес</td>
        <td><textarea id="newAddress"/>{$arrUser['address']}</textarea></td>
    </tr>
    <tr>
        <td>Новый пароль</td>
        <td><input type="password" id="newPasw1" value=""/></td>
    </tr>
    <tr>
        <td>Повтор пароля</td>
        <td><input type="password" id="newPasw2" value=""/></td>
    </tr>
    <tr>
        <td>Для того чтобы сохранить данные введите текущий пароль</td>
        <td><input type="password" id="currPasw" value=""/></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><input type="button" value="Сохранить изменения" onclick="updateUserData();"/></td>
    </tr>
</table>