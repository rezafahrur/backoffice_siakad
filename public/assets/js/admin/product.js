$(document).on('click', '#updateToggle', function() {
    let id = $(this).data('product');
    $("#updateProductForm").attr('action', '/admin/products/' + id);
    $.ajax({
        url: '/admin/products/' + id,
        type: 'GET',
        success: function(data) {
            $("#nameUpdate").val(data.name);
            $("#priceUpdate").val(data.price);
            $("#quantityUpdate").val(data.quantity);
            $("#categoryUpdate").val(data.category);
            $("#descriptionUpdate").val(data.description);
            $("#categoryUpdate").val(data.category);
        }
    })
});

$(document).on('click', '#modal-button', function() {
    $("#name").val('');
    $("#price").val('');
    $("#quantity").val('');
    $("#description").val('');
    $("#category").val('');
});

$(document).on('click', '#detailToggle', function() {
    let id = $(this).data('product');
    console.log(id);
    $.ajax({
        url: '/admin/products/' + id + '/show',
        type: 'GET',
        success: function(data) {
            $("#nameDetail").val(data.name);
            $("#priceDetail").val(data.price);
            $("#quantityDetail").val(data.quantity);
            $("#categoryDetail").val(data.category);
            $("#descriptionDetail").val(data.description);
            $("#categoryDetail").val(data.category);
            $("#imageDetail").attr('src', '../images/products/' + data.imageUrl);
            console.log(data);
        }
    })
});