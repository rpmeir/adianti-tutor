/**
 * jquery-swiper
 * Copyright Rodrigo Pires Meira
 * Licensed under the MIT license
 */
(function(factory){
    if (typeof define === 'function' && define.amd) {
		define([ 'jquery', 'swiper' ], factory);
	}
	else if (typeof exports === 'object') { // Node/CommonJS
		module.exports = factory(require('jquery'), require('swiper'));
	}
	else {
		factory(jQuery, swiper);
	}
})(function($){
    $.fn.swiper = function(options){
        //var args = Array.prototype.slice.call(arguments, 1); // for a possible method call
        var res = this; // what this function will return (this jQuery object by default)

        this.each(function(){
            var data = $.data(this, 'swiper');

            if (!data) {
                data = new Swiper(this, options);
        
                $.data(this, 'swiper', data);
            }
        });

        return res;
    }
})(jQuery);
