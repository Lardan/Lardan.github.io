
var CARD = function(){

    'use strict';

    var initAjaxToken = function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            statusCode : {
                500: function() {
                    return;
                }
            }
        });
    };



    return {
        init: function() {
            initAjaxToken();
        },
        alert: function(response) {
            return noty({
                text: response.text,
                type: response.type,
                theme: 'relax',
                layout: 'topRight',
                timeout: 5000,
                animation: {
                    open:   'animated bounceInRight',
                    close:  'animated bounceOutUp'
                }
            });
        }
    }
}();
