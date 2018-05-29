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