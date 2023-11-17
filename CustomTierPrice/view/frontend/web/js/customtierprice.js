define([
    'jquery',
    'jquery/ui'
], function ($) {
    $('.masive-purchase').on('click', function(e) {
        e.preventDefault();
        $(`#card_${$(this).attr("id")}`).show(1000);
    })

    $('.close-card').on('click', function(e) {
        e.preventDefault();
       $(`#card_${$(this).attr("id")}`).hide(1000);
    })
});