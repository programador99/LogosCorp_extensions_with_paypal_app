define([
    "jquery",
    'domReady!',
], function(
    $
) {
    "use strict";

    return function(config) {

        localStorage.setItem('config',JSON.stringify(config));
        
        function CustomCheckout(config) {

            this.init = function() {

                var configTime = config.customCheckoutData.time * 60000;
                var isActive = false;
                var counter = 0;

                $(document).on('change', '.payment-method._active', function() {

                    var methodSelected = $('.payment-method._active input[name*=payment]').val();

                    function checkTime() {                       
                        if (methodSelected == "net247") {
                            isActive = true;
                            counter++;

                            if (counter <= 1) {
                                setTimeout(() => {
                                    if (isActive) {
                                        console.log('inner checkout')
                                        window.location.replace("/checkout/cart/");
                                    }
                                }, configTime)
                            }
                            
                        } else {
                            isActive = false
                        }
                    }

                    checkTime();                    
                })
            }
        }
        
        var customcheckout = new CustomCheckout(config);

        customcheckout.init();
    }
});

