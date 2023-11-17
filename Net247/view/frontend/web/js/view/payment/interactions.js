require([
    "jquery",
    'domReady!'
], function(
    $,
) {
    $(document).ready(function() {

        // Validar formato del monto del micro cargo
        $(document).on('focusout keyup', '#logoscorp_net247_cc_microcharge', function(e) {
            var regex = new RegExp("^[0-9]\.[0-9]{2}$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;
        });

        // limitar campo de numero de tarjeta no mayor a 16 numeros
        $(document).on('focusout keyup', '#logoscorp_net247_cc_number', function(e) {
            if ($(this).val().length > 16) {
                $(this).val($(this).val().slice(0, 16));
            }
        });

        // funcion que restringe los numero a 3 en el campo 
        $(document).on('focusout keyup', '#logoscorp_net247_cc_cid', function(e) {
            if ($(this).val().length > 3) {
                $(this).val($(this).val().slice(0, 3));
            }

        });

        // funcion que no permite caracteres especiales ni numeros
        $(document).on('keypress keyup change', '#logoscorp_net247_cc_owner_name', function(e) {
            var regex = new RegExp("^[a-zA-ZñÑ ]*$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;
        });

        // funcion que no permite caracteres especiales ni letras en el campo
        $(document).on('keypress keyup change', '#logoscorp_net247_cc_cid , #logoscorp_net247_cc_number', function(e) {
            var regex = new RegExp("^[0-9]*$");
            // var regex = new RegExp("/^[a-zA-ZÀ-ÖØ-öø-ÿ]+$/");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;
        });

        $(document).on('click', '#net247-action-primary', function(e) {
            window.scrollTo(0, 0);          
        });
    });

});