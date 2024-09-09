$(document).on('click', '#updateToggle', function() {
    let id = $(this).data('category');
    $("#updateCategoryForm").attr('action', '/admin/product/category/' + id);
    $.ajax({
        url: '/admin/products/category/' + id,
        type: 'GET',
        success: function(data) {
            $("#nameUpdate").val(data.name);
        }
    })
});