var Better_Social_Counter = (function($) {
    "use strict";

    return {

        init: function(){

            // Define elements that use elementQuery
            this.fix_element_query();

        },

        /**
         * Define elements that use elementQuery on local/cross domain
         */
        fix_element_query: function(){

            elementQuery({ ".better-social-counter": { "max-width": ["358px","199px","230px"] } });

        }


    };// /return
})(jQuery);

// Load when ready
jQuery(function($) {

    Better_Social_Counter.init();

});