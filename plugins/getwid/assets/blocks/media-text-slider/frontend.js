!function(t){function e(n){if(i[n])return i[n].exports;var a=i[n]={i:n,l:!1,exports:{}};return t[n].call(a.exports,a,a.exports,e),a.l=!0,a.exports}var i={};e.m=t,e.c=i,e.d=function(t,i,n){e.o(t,i)||Object.defineProperty(t,i,{configurable:!1,enumerable:!0,get:n})},e.n=function(t){var i=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(i,"a",i),i},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="",e(e.s=20)}({0:function(t,e,i){"use strict";function n(t,e,i){var n=function(t){var e={animation:"animationend",OAnimation:"oAnimationEnd",MozAnimation:"mozAnimationEnd",WebkitAnimation:"webkitAnimationEnd"};for(var i in e)if(void 0!==t.style[i])return e[i]}(document.createElement("div")),a=void 0!==e.animation?e.animation:"",o=void 0!==e.duration?e.duration:"1s",d=void 0!==e.delay?e.delay:"0s";return t.css({"animation-duration":o,"animation-delay":d,"-webkit-animation-delay":d}),t.addClass("animated "+a).one(n,function(){jQuery(this).removeClass("animated "+a),"function"==typeof i&&i()}),this}e.a=n},20:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var n=i(0);/*!
 * getwid-media-text-slider
 */
!function(t){t(document).ready(function(e){t(document.body).on("post-load",function(t){i()});var i=function(){var e,i,a,o,d,s,l,c,r=t(".wp-block-getwid-media-text-slider:not(.getwid-init) .wp-block-getwid-media-text-slider__content");r.each(function(r){l=t(this),l.closest(".wp-block-getwid-media-text-slider").addClass("getwid-init"),c=void 0!==t(this).closest(".wp-block-getwid-media-text-slider").data("animation"),e=1==l.data("slide-autoplay"),i=1==l.data("slide-pause-on-hover"),a=parseInt(l.data("slide-autoplay-speed")),o="fade"==l.data("slide-effect"),d=parseInt(l.data("slide-speed")),s=1==l.data("infinite"),c&&t(this).find(".wp-block-getwid-media-text-slider-slide .wp-block-getwid-media-text-slider-slide-content__content").css("opacity","0"),l.on("init",function(){c&&t(this).find(".wp-block-getwid-media-text-slider-slide.slick-active .wp-block-getwid-media-text-slider-slide-content__content").css("opacity","1")});var u=!1;l.on("beforeChange",function(t,e,i,n){u=i==n}),l.on("afterChange",function(e,i,a){if(!u){c&&t(this).find(".wp-block-getwid-media-text-slider-slide .wp-block-getwid-media-text-slider-slide-content__content").css("opacity","0");var o=t(this).find('.wp-block-getwid-media-text-slider-slide[data-slick-index="'+a+'"]').find(".wp-block-getwid-media-text-slider-slide-content__content");c&&o.length&&Object(n.a)(o,{animation:t(this).closest(".wp-block-getwid-media-text-slider").data("animation"),duration:t(this).closest(".wp-block-getwid-media-text-slider").data("duration"),delay:t(this).closest(".wp-block-getwid-media-text-slider").data("delay")},o.css("opacity","1"))}});var p=t(this).closest(".".concat("wp-block-getwid-media-text-slider")),f=!p.hasClass("has-arrows-none"),m=!p.hasClass("has-dots-none");l.slick({rows:0,slidesToShow:1,slidesToScroll:1,autoplay:e,pauseOnHover:i,autoplaySpeed:a,fade:o,speed:d,infinite:s,arrows:f,dots:m,rtl:!!Getwid.isRTL})})};i()})}(jQuery)}});