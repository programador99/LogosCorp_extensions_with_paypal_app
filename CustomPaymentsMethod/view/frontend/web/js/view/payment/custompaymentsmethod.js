define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';

        rendererList.push(
            {
                type: 'custompaymentsmethod1',
                component: 'LogosCorp_CustomPaymentsMethod/js/view/payment/method-renderer/custompayments-method1'
            },
            {
                type: 'custompaymentsmethod2',
                component: 'LogosCorp_CustomPaymentsMethod/js/view/payment/method-renderer/custompayments-method2'
            },
            {
                type: 'custompaymentsmethod3',
                component: 'LogosCorp_CustomPaymentsMethod/js/view/payment/method-renderer/custompayments-method3'
            },
            {
                type: 'paypal_app',
                component: 'LogosCorp_CustomPaymentsMethod/js/view/payment/method-renderer/custompayments-paypal-app'
            },
            {
                type: 'binance_usdt',
                component: 'LogosCorp_CustomPaymentsMethod/js/view/payment/method-renderer/custompayments-binance-usdt'
            },
            {
                type: 'tether_trc20',
                component: 'LogosCorp_CustomPaymentsMethod/js/view/payment/method-renderer/custompayments-tether-trc20'
            },
            {
                type: 'mony',
                component: 'LogosCorp_CustomPaymentsMethod/js/view/payment/method-renderer/custompayments-mony'
            },
            {
                type: 'boton_banesco',
                component: 'LogosCorp_CustomPaymentsMethod/js/view/payment/method-renderer/custompayments-boton-banesco'
            },
            {
                type: 'c2p_megasoft',
                component: 'LogosCorp_CustomPaymentsMethod/js/view/payment/method-renderer/custompayments-c2p-megasoft'
            },
        );
        return Component.extend({});
    }
);