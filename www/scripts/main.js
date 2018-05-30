/**
 * Функция добавления товара в корзину
 *
 * @param integer itemId ID продукта
 * @return в случае успеха обновятся данные корзины на странице
 */
function addToCart(itemId) {
    console.log("js - addToCart()");
    $.ajax({
        type: 'POST',
        async: false,
        url: "/cart/addtocart/" + itemId + '/',
        dataType: 'json',
        success: function (data) {
            if (data['success']) {
                $('#cartQuantityItems').html(data['quantityItems']);

                $('#addCart_' + itemId).hide();
                $('#removeCart_' + itemId).show();
            }
        }
    });
}

/**
 * Удаление продукта из корзины
 *
 * @param integer itemId ID продукта
 * @return в случае успеха обновятся даные корзины на странице
 */
function removeFromCart(itemId) {
    console.log("js - removeFromCart(" + itemId + ")");
    $.ajax({
        type: 'POST',
        sync: false,
        url: "/cart/removefromcart/" + itemId + '/',
        dataType: 'json',
        success: function (data) {
            if (data['success']) {
                $('#cartQuantityItems').html(data['quantityItems']);

                $('#addCart_' + itemId).show();
                $('#removeCart_' + itemId).hide();
            }
        }
    });
}

/**
 * Подсчет стоимости купленого товара
 *
 * @param integer itemId ID продукта
 */
function conversionPrice(itemId) {
    var newQuantity = $('#itemQuantity_' + itemId).val();
    var itemPrice = $('#itemPrice_' + itemId).attr('value');
    var itemRealPrice = newQuantity * itemPrice;

    $('#itemRealPrice_' + itemId).html(itemRealPrice);
}

/**
 * Получение данных с формы
 *
 */
function getData(obj_form) {
    var hData = {};
    $('input, textarea, select', obj_form).each(function () {
        if (this.name && this.name != '') {
            hData[this.name] = this.value;
            console.log('hData[' + this.name + '] = ' + hData[this.name]);
        }
    });
    return hData;
}

/**
 * Регистрация нового пользователя
 *
 */
function registerNewUser() {
    var posData = getData('#registerBox');

    $.ajax({
        type: 'POST',
        async: false,
        url: "/user/register/",
        data: posData,
        dataType: 'json',
        success: function (data) {
            if (data['success']) {
                alert('Registration successful');

                //> блок в левом столбце
                $('#registerBox').hide();

                $('#userLink').attr('href', '/user/');
                $('#userLink').html(data['userName']);
                $('#userBox').show();
                //<

                //> страница заказа
                // $('#loginBox').hide();
                // $('#btnSaveOrder').show();
                //<
            } else {
                alert(data['message']);
            }
        }
    });
}

/**
 * !!! function not complete
 */
function logout() {

}

/**
 * Авторизация пользователя
 *
 */
function login() {
    var email = $('#loginEmail').val();
    var pass = $('#loginPasw').val();

    var postData = "email=" + email + "&pasw=" + pass;

    $.ajax({
        type: 'POST',
        async: false,
        url: "/user/login/",
        data: postData,
        dataType: 'json',
        success: function(data){
            if(data['success']){
                $('#registerBox').hide();
                $('#loginBox').hide();

                $('#userLink').attr('href', '/user/');
                $('#userLink').html(data['displayName']);
                $('#userBox').show();
            } else {
                alert(data['message']);
            }
        }
    });
}

/**
 * Показать или прятать форму регистрации
 *
 */
function showRegisterBox() {
    if($('#registerBoxHidden').css('display') != 'block'){
        $('#registerBoxHidden').show();
    } else {
        $('#registerBoxHidden').hide();
    }
}