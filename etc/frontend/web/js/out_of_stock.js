require(['jquery']),function () {
    jQuery(document).ready(function () {
        jQuery('#out_of_stock_form').submit(function () {
            let outOfStockEmail = jQuery("input[name = 'email']").val();
            let url = 'outofstock/result/result/';
            jQuery.ajax({
                url: url,
                type: "POST",
                data: {email:outOfStockEmail},
                showLoader: true,
                cache: false,
                success: function (response) {
                    console.log(response.output);
                }
            });
            return false;
        });
    });
};