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
                if (!data.status
                ) {
                    console.log('error');
                    $('#result_form')
                        .removeClass()
                        .addClass('out_of_stock__error')
                        .html(data.result);
                } else {
                    console.log('success');
                    $('#result_form')
                        .removeClass()
                        .addClass('out_of_stock__save')
                        .html(data.result);
                }
            }
        });
    });
});