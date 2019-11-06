require(['jquery',], function ($) {
    $('#out_of_stock_form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: this.action,
            type: 'post',
            contentType: false,
            processData: false,
            data: new FormData(this),
            dataType: 'json',
            success: function (data) {
                console.log(data);
            }
        });
    });
});