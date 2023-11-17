define(['jquery'], function($) {
    "use strict";
    return function(config) {

        function logicCustomRenderPostCode(config, selectorForm) {
            var that = this;

            console.log('selectorForm ', selectorForm);

            this.init = function() {
                //console.log('logicCustomRenderPostCode init', config);

                if (config.isCheckout) {
                    $(document).on('DOMNodeRemoved', '#checkout-loader', function() {
                        initCustomRenderPostCodeInForm();
                        customFunctions();
                    });
                } else {
                    initCustomRenderPostCodeInForm();
                    customFunctions();
                }

            }

            function customFunctions() {

                if (config.isCheckout) {
                    //apply for checkout add a new addres...
                    $(document).on('click', config.selectorBody + ' #checkout-step-shipping .new-address-popup button.action', function(event) {
                        initCustomRenderPostCodeInForm();
                    });

                    $(document).on('click', config.selectorBody + ' #checkout-step-shipping button.edit-address-link', function(event) {
                        initCustomRenderPostCodeInForm();
                    });

                    $(document).on('change', config.selectorBody + ' #checkout-step-payment select[name="billing_address_id"]', function(event) {
                        initCustomRenderPostCodeInForm();
                    });

                    $(document).on('change', config.selectorBody + ' #checkout-step-payment input[name="billing-address-same-as-shipping"]', function(event) {
                        initCustomRenderPostCodeInForm();
                    });
                }

                $(document).on('change', selectorForm + ' select[name="country_id"]', function(event) {
                    var currentVal = $(this).val().trim();
                    $(selectorForm + ' input[name="postcode"]').val('').trigger('change');
                    $(selectorForm + ' select[name="location"]').val('');

                    if (config.locations.countriesIdentified.includes(currentVal)) {
                        $(selectorForm + ' input[name="postcode"]').hide();
                        $(selectorForm + ' select[name="location"]').show(); //render list filtered by region
                        $(selectorForm + ' input[name="postcode"]').closest('div.field').find('label.label:not(.custom-label-zip)').hide();
                        $(selectorForm + ' input[name="postcode"]').closest('div.field').find('label.label.custom-label-zip').show();
                    } else {
                        $(selectorForm + ' input[name="postcode"]').show();
                        $(selectorForm + ' select[name="location"]').hide();
                        $(selectorForm + ' input[name="postcode"]').closest('div.field').find('label.label:not(.custom-label-zip)').show();
                        $(selectorForm + ' input[name="postcode"]').closest('div.field').find('label.label.custom-label-zip').hide();
                    }
                });

                $(document).on('change', selectorForm + ' select[name="region_id"]', function(event) {
                    var htmlRegions = that.getHtmlRegionsFiltered($(this).val(), $(selectorForm + ' input[name="postcode"]').val());

                    $(selectorForm + ' select[name="location"]').html(htmlRegions).trigger('change');
                });

                $(document).on('change', selectorForm + ' select[name="location"]', function(event) {
                    var currentVal = $(this).val().trim();

                    var countryId = $(selectorForm + ' select[name="country_id"]').val().trim();

                    if (config.locations.countriesIdentified.includes(countryId)) {

                        if (currentVal != '' && currentVal != '1') {
                            //selection location valid... then hide postcode and label postcode
                            $(selectorForm + ' input[name="postcode"]').val(currentVal).trigger('change');
                            $(selectorForm + ' input[name="postcode"]').hide();
                            $(selectorForm + ' input[name="postcode"]').closest('div.field').find('label.label:not(.custom-label-zip)').hide();
                        } else if (currentVal == '1') {
                            //Mi ubicacion no aparece.. then show postcode en label postcode
                            $(selectorForm + ' input[name="postcode"]').val('').trigger('change');
                            $(selectorForm + ' input[name="postcode"]').show();
                            $(selectorForm + ' input[name="postcode"]').closest('div.field').find('label.label:not(.custom-label-zip)').show();
                        } else {
                            //selection location valid... then hide postcode and label postcode
                            $(selectorForm + ' input[name="postcode"]').val('').trigger('change');
                            $(selectorForm + ' input[name="postcode"]').hide();
                            $(selectorForm + ' input[name="postcode"]').closest('div.field').find('label.label:not(.custom-label-zip)').hide();
                        }

                    } else {
                        $(selectorForm + ' input[name="postcode"]').val('').trigger('change');
                        $(selectorForm + ' input[name="postcode"]').show();
                        $(selectorForm + ' input[name="postcode"]').closest('div.field').find('label.label:not(.custom-label-zip)').show();
                    }
                });
            }

            function initCustomRenderPostCodeInForm() {
                //console.log('initCustomRenderPostCodeInForm busca->', selectorForm);
                if ($(selectorForm).length > 0 && $(selectorForm + ' input[name="postcode"]').length > 0 &&
                    !$(selectorForm).hasClass('init-crpc')) {


                    $(selectorForm).addClass('init-crpc');
                    var isSelectedCountryWithPostCodeDefined = ($(selectorForm + ' select[name="country_id"]').length > 0 && config.locations.countriesIdentified.includes($(selectorForm + ' select[name="country_id"]').val()));


                    var regionIdSelected = ($(selectorForm + ' select[name="region_id"]').length > 0) ? $(selectorForm + ' select[name="region_id"]').val() : "";

                    var htmlRegions = that.getHtmlRegionsFiltered(regionIdSelected, $(selectorForm + ' input[name="postcode"]').val());
                    //console.log('isSelectedCountryWithPostCodeDefined', isSelectedCountryWithPostCodeDefined, $(selectorForm + ' select[name="country_id"]').val());

                    var html = '<label style="' + ((isSelectedCountryWithPostCodeDefined) ? '' : 'display:none;') + '" class="label custom-label-zip" for="zip"><span>' + config.labelCodigoPostal + '</span></label>';
                    html += '<select style="' + ((isSelectedCountryWithPostCodeDefined) ? '' : 'display:none;') + '" id="location" name="location" class="required-entry mage-error required" aria-required="true" aria-invalid="true" aria-describedby="zip-error">' + htmlRegions + '</select>';

                    $(selectorForm + ' input[name="postcode"]').closest('div.field').prepend(html);

                    if (isSelectedCountryWithPostCodeDefined) {
                        $(selectorForm + ' input[name="postcode"]').hide();
                        $(selectorForm + ' input[name="postcode"]').closest('div.field').find('label.label:not(.custom-label-zip)').hide();
                    }

                }
            }

            this.getHtmlRegionsFiltered = function(regionId, currentVal) {
                var html = '';
                for (const [i, location] of Object.entries(config.locations.listPostCodes)) {
                    if (location.value == ' ' || location.value == '1' || location.region_id == regionId) {
                        
                        var label = (location.label == ' ' || location.label == null) ? config.labelCodigoPostal : location.label;
                        
                        html += '<option ' + ((currentVal == location.value) ? 'selected' : '') + ' value="' + location.value + '">' + label + '</option>';
                    }
                }
                return html;
            }

        }


        if (typeof config.selectorForms != 'undefined' && typeof config.selectorBody != 'undefined') {

            config.selectorForms.forEach( (slectorForm, index) => {
                //console.log(slectorForm);
                let selectorBody = (config.isCheckout) ? config.selectorBody : config.selectorBody[index];
                
                var componentCustomRenderPostCode = (new logicCustomRenderPostCode(config, selectorBody + ' ' + slectorForm)).init();
            });
        }


    }
});