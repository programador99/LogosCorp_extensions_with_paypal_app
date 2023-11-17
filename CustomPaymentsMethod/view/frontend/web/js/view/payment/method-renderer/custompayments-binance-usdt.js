define(
    [
        'Magento_Checkout/js/view/payment/default'
    ],
    function (Component) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'LogosCorp_CustomPaymentsMethod/payment/binance_usdt'
            },

            /**
             * Returns payment method instructions.
             *
             * @return {*}
             */
            getInstructions: function () {
                return window.checkoutConfig.payment.instructions[this.item.method];
            }
        });
    }
);