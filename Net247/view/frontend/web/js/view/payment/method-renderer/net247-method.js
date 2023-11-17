/*browser:true*/
/*global define*/
define(
        [
            'jquery',
            'Magento_Payment/js/view/payment/cc-form',
            'Magento_Payment/js/model/credit-card-validation/validator',
        ],
        function ($, Component, validator) {
            'use strict';

            return Component.extend({
                defaults: {
                    template: 'LogosCorp_Net247/payment/main-form',
                    creditCardMicroCharge: '',
                    creditCardCurrency: '',
                },
                
                getCode: function () {
                    return 'net247';
                },

                isActive: function () {
                    return true;
                },

                validate: function () {
                    var $form = $('#' + this.getCode() + '-form');
                    return $form.validation() && $form.validation('isValid');
                },

                getData: function () {

                    console.log(jQuery("#net247_cc_currency").val());
                    var data = {
                        'method': this.item.method,
                        'additional_data': {
                            'cc_cid': this.creditCardVerificationNumber(),
                            'cc_ss_start_month': this.creditCardSsStartMonth(),
                            'cc_ss_start_year': this.creditCardSsStartYear(),
                            'cc_ss_issue': this.creditCardSsIssue(),
                            'cc_type': this.creditCardType(),
                            'cc_exp_year': this.creditCardExpYear(),
                            'cc_exp_month': this.creditCardExpMonth(),
                            'cc_number': this.creditCardNumber(),
                            'cc_microcharge': jQuery("#net247_cc_microcharge").val(), // TODO this.creditCardMicroCharge(),
                            'cc_currency': jQuery("#net247_cc_currency").val(), // TODO this.creditCardCurrency(),
                        }
                    };
                    
                    return data;
                },

                getCms: function () {
                    return window.checkoutConfig.payment.cms[this.item.method];
                },

                getInstructions: function () {
                    return window.checkoutConfig.payment.instructions[this.item.method];
                },

                getSessionTimeOut: function () {

                    if (window.checkoutConfig.payment.session_timeout[this.item.method]) {
                        let config = JSON.parse(localStorage.getItem('config'));
                        let message = config.customCheckoutData.message;
                        
                        $(".checkout-message.net247-message-time").append( 
                            message
                        );
                    }

                    return true;
                },

                getAvailableCurrencys: function () {
                    return window.checkoutConfig.payment.currencyCodes[this.getCode()];
                },
            });
        }
);
