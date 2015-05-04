/**
 * BetterFramework Newsticker shortcode
 */
(function($){
    $.betterNewsTicker = function(el, options){
        var base = this;
        base.$el = $(el);
        base.el = el;
        base.$el.data("betterNewsTicker", base);

        base.init = function(){
            // load options from js caller
            base.options = $.extend( {}, $.betterNewsTicker.defaultOptions, options );

            // load default data from data attr
            base.options = $.extend( {}, base.$el.data(), options );

            if (!base.$el.find('li.active').length) {
                !base.$el.find('li:first').addClass('active');
            }

            window.setInterval(function() {

                var active = base.$el.find('li.active');
                active.fadeOut(function() {

                    var next = active.next();
                    if (!next.length) {
                        next = base.$el.find('li:first');
                    }

                    next.addClass('active').fadeIn();
                    active.removeClass('active');
                });

            }, base.options.time );

        };

        base.init();
    };

    $.betterNewsTicker.defaultOptions = {
        time: 20000
    };

    $.fn.betterNewsTicker = function(options){
        return this.each(function(){
            (new $.betterNewsTicker(this, options));
        });
    };
})(jQuery);