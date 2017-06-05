(function ($) {
	"use strict";

// Initialize preloader (dependency imageLoaded plugin)
// ----------------------------------------------------
	preloader();
// Initialize Plugins

	var chartOpts = {
			size       : 150,
			scaleLength: 1,
			barColor   : "#fff",
			trackColor : false,
			lineWidth  : 7,
			scaleColor : false,
			lineCap    : "square",
			rotate     : 90
		},
		smoothScrollOpts = {
			direction: "top",
			offset   : -65
		};


// Initialize Easy Pie Chart
	$(".chart-draw").easyPieChart(chartOpts);
	// and set it to 0, update it inside waypoint.
	$(".chart-draw").each(function () {
		var s = $(this);
		s.data("easyPieChart").update(0);
	});

// Smooth scroll plugin (learn-more btn)
// ---------------------------------
	$('.learn-more a').off('click').on('click', function (e) {
		e.preventDefault();
		if (jQuery("#header_2").length) {

			var height_of = jQuery(window).height();
		} else if (jQuery("#header_3").length) {
			var height_of = jQuery(window).height() - $("#header_3").height();
		} else {
			var height_of = jQuery(window).height() - $("#header").height();
		}
		$('html, body').animate({
			scrollTop: height_of
		}, 1000);
	});

// Animate Resume Page with waypoint
// ------------------------------------
	function animateResumePage() {
		var $rDescBox = $(".timeline-cont .desc-box"),
			oddBox = $rDescBox.filter(":odd"),
			evenBox = $rDescBox.filter(":even");
		$rDescBox.addClass("ar-desc-box");
		oddBox.addClass("ar-left");
		evenBox.addClass("ar-right");

		$rDescBox.waypoint({
			handler    : function () {
				var $s = $(this);
				if ($s.hasClass("ar-left"))
					$s.removeClass("ar-left");
				else
					$s.removeClass("ar-right");
			},
			triggerOnce: true,
			offset     : "100%"
		});
	}

	animateResumePage();    // Initialize

// Magnific Popup 
// -----------------------------------------
	$(".filter-port figure .prettyPhoto").magnificPopup({
		type       : "image",
		image      : {
			titleSrc: function (item) {
				return item.el.parents('figure').find('h6').html();
			},
			tError  : '<a href="%url%">The image #%curr%</a> could not be loaded.'
		},
		key        : "image-key",
		verticalFit: true,
		mainClass  : "image-popup-style", // This same class is used for video popup
		tError     : '<a href="%url%">The image</a> could not be loaded.',
		gallery    : {
			enabled : true,
			tCounter: ''
		},
		callbacks  : {
			open : function () {
				this.content.addClass("fadeInLeft");
			},
			close: function () {
				this.content.removeClass("fadeInLeft");
			}
		}
	});

	$(".filter-port figure .prettyVideo").magnificPopup({
		type       : "iframe",
		image      : {
			titleSrc: function (item) {
				return item.el.parents('figure').find('h6').html();
			},
			tError  : '<a href="%url%">The image #%curr%</a> could not be loaded.'
		},
		key        : "image-key",
		verticalFit: true,
		mainClass  : "image-popup-style", // This same class is used for video popup
		tError     : '<a href="%url%">The image</a> could not be loaded.',
		gallery    : {
			enabled : true,
			tCounter: ''
		},
		callbacks  : {
			open : function () {
				this.content.addClass("fadeInLeft");
			},
			close: function () {
				this.content.removeClass("fadeInLeft");
			}
		}
	});


// Isotope Filter
// ----------------------------------------------
	function isotopeInit() {
		var $container = $(".filter-port"),
			$filter = $(".filter-menu");

		$(window).on("load resize", function () {
			$container.isotope({
				itemSelector     : ".item",
				animationEngine  : "best-available",
				transformsEnabled: true,
				resizesContainer : true,
				resizable        : true,
				easing           : "linear",
				layoutMode       : "masonry"
			});

			$filter.find("a").on("click touchstart", function (e) {
				var $t = $(this),
					selector = $t.data("filter");
				// Don't proceed if already selected
				if ($t.hasClass("filter-current"))
					return false;

				$filter.find("a").removeClass("filter-current");
				$t.addClass("filter-current");
				$container.isotope({filter: selector});

				e.stopPropagation();
				e.preventDefault();
			});
		})
	}

// Initialization
	isotopeInit();


// Form Validation and Settings
// ---------------------------------
	function formValidation() {
		var $form = $("#contact-form");//,
		$form.validate({
			rules       : {
				"name"   : {
					required : true,
					minlength: 2
				},
				"email"  : "required",
				"message": {
					required : true,
					minlength: 5
				}
			},
			errorClass  : "invalid-error",
			errorElement: "span",

		});

		$(".wpcf7-form i").click(function () {
			$("#contact-form").submit();
		});
	}

	formValidation();

// Main Navigation Config 
// ------------------------
	function mainNavInit() {
		var $mainNav = $(".main-nav"),
			$aboutSec = $(".inner-nav a").eq(1);
		$mainNav.find(".nav-control a, .nav-control").on("click touchstart", function (e) {
			if (e.target.parentNode == this) {
				if ($(this).parent().attr('class') == 'nav-control') {
					$(this).parent().find(".inner-nav").toggleClass("show-nav");
					$("#nav-toggle").toggleClass("active");
				} else {

					$(this).find(".inner-nav").toggleClass("show-nav");
					if ($(this).find(".inner-nav").attr('class'))
						$("#nav-toggle").toggleClass("active");
				}


				e.stopPropagation();
				e.preventDefault();
			}
		});

		$('.inner-nav a').off('click').on('click', function (e) {
			var thisHref = jQuery(this).attr('href');
			if (thisHref.charAt(0) != "#") {
				window.location.href = thisHref;
			} else if (jQuery(thisHref).length) {
			} else {
				window.location.href = thisHref;
			}
		});
		// initialize smooth scroll for this
		$aboutSec.smoothScroll(smoothScrollOpts); // for `aboutSection` offset is different.
		$mainNav.find(".inner-nav a").not($aboutSec).smoothScroll({
			direction: "top",
			// offset   : -104,
			offset   : -(jQuery("#header").height()),
			speed    : 800
		});
	}

// Iniitialization
	mainNavInit();


// Main Navigation 2 Config 
// ------------------------
	var before = false;

	function mainNav2Init() {
		$('#header_2 .navbar-nav a').off('click').on('click', function (e) {
			e.preventDefault();

			var thisHref = jQuery(this).attr('href');
			if (thisHref.charAt(0) != "#") {
				window.location.href = thisHref;
			} else if (jQuery(thisHref).length) {
			} else {
				window.location.href = thisHref;
			}
			var about = $('#header_2 .navbar-nav a').eq(1).attr('href');
			if (jQuery(this).attr('href') != about) {
				$('html, body').animate({
					scrollTop: $(jQuery(this).attr('href')).offset().top - ($("#header_2").height())
				}, 1000);
			} else {
				$('html, body').animate({
					scrollTop: $(jQuery(this).attr('href')).offset().top - ($("#header_2").height())
				}, 1000);
			}
		});

	}

// Iniitialization nav 2
	mainNav2Init();

// Main Navigation 3 Config 
// ------------------------
	function mainNav3Init() {
		$('#header_3 .navbar-nav a').off('click').on('click', function (e) {
			e.preventDefault();

			var thisHref = jQuery(this).attr('href');
			if (thisHref.charAt(0) != "#") {
				window.location.href = thisHref;
			} else if (jQuery(thisHref).length) {
			} else {
				window.location.href = thisHref;
			}
			var about = $('#header_3 .navbar-nav a').eq(1).attr('href');
			if (jQuery(this).attr('href') != about) {
				$('html, body').animate({
					scrollTop: $(jQuery(this).attr('href')).offset().top - ($("#header_3").height())
				}, 1000);
			} else {
				$('html, body').animate({
					scrollTop: $(jQuery(this).attr('href')).offset().top - ($("#header_3").height())
				}, 1000);
			}
		});

	}

// Iniitialization nav 3
	mainNav3Init();

// Preloader (require pace.min.js)
	function preloader() {
		$(window).on("load", function () {
			Pace.on("done", function () {
				$("#preload").fadeOut(300);
			});
		});
	}

})(jQuery);

jQuery(function ($) {
	if (jQuery().flexslider) {
		$('.post-formats-wrapper .flexslider').flexslider({
			animation : "slide",
			prevText  : "<i class='fa fa-angle-left'></i>",
			nextText  : "<i class='fa fa-angle-right'></i>",
			controlNav: false
		});
	}
});

//BEGIN DOCUMENT.READY FUNCTION
jQuery(document).ready(function ($) {
	jQuery(".inner-nav > li > a > span").hover(
		function () {
			z = 100;
			jQuery(this).parent().parent().children("ul").css("right", "" + z + "%");
			jQuery(this).parent().parent().children("ul").css("width", "" + (jQuery(this).width() + 42) + "px");
		}, function () {
		}
	);
	jQuery(".inner-nav > li").hover(
		function () {
		}, function () {
			jQuery(this).children("ul").css("right", "-500%");
		}
	);
	/* ------------------------------------------------------------------------ */
	/* BACK TO TOP
	 /* ------------------------------------------------------------------------ */

	$(window).scroll(function () {
		if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
			$('#return-to-top').fadeIn(200);    // Fade in the arrow
		} else {
			$('#return-to-top').fadeOut(200);   // Else fade out the arrow
		}
	});
	$('#return-to-top').click(function () {      // When arrow is clicked
		$('body,html').animate({
			scrollTop: 0                       // Scroll to top of body
		}, 500);
	});

	// Footer Closer
	// ======================
	var finished = true;
	jQuery('.close-footer i').click(function () {
		if (finished) {
			finished = false;
			var checked = true;
			if (jQuery('.footer-contact').css('position') == 'static') {
				jQuery('.footer-contact').css({position: 'relative'});
				$('.footer-contact .footer-content').css({position: 'absolute'});
				$('#google-map .captionMap').fadeOut();
				checked = false;
			}
			jQuery('.footer-active').slideToggle('slow', function () {
				if (checked) {
					jQuery('.footer-contact').css({position: 'static'});
					$('.footer-contact .footer-content').css({position: 'relative'});
					$('#google-map .captionMap').fadeIn();
				}
				finished = true;
			});
		}
	});

});
//END DOCUMENT.READY FUNCTION

var scrollTimer = false,
	scrollHandler = function () {
		var scrollPosition = parseInt(jQuery(window).scrollTop(), 10);
		jQuery('.inner-nav li a[href^="#"]').each(function () {
			var thisHref = jQuery(this).attr('href');
			if (jQuery(thisHref).length) {

				var thisTruePosition = parseInt(jQuery(thisHref).offset().top, 10),
					thisPosition = thisTruePosition - 65;
				if (scrollPosition <= parseInt(jQuery(jQuery('.inner-nav li a[href^="#"]').first().attr('href')).height(), 10) + 2 - 65) {

					if (scrollPosition >= thisPosition) {
						jQuery('.inner-nav li a[href^="#"]').removeClass('nav-active');
						jQuery('.inner-nav li a[href="' + thisHref + '"]').addClass('nav-active');
					}
				} else {
					if (scrollPosition >= thisPosition || scrollPosition >= thisPosition) {
						jQuery('.inner-nav li a[href^="#"]').removeClass('nav-active');
						jQuery('.inner-nav li a[href="' + thisHref + '"]').addClass('nav-active');
					}
				}
			}
		});

		/** header 2**/
		var scrollPosition = parseInt(jQuery(window).scrollTop(), 10);
		jQuery('#header_2 .navbar-nav li a[href^="#"]').each(function () {
			var thisHref = jQuery(this).attr('href');
			if (jQuery(thisHref).length) {

				var thisTruePosition = parseInt(jQuery(thisHref).offset().top, 10),
					thisPosition = thisTruePosition - jQuery("#header_2").height();
				if (scrollPosition <= parseInt(jQuery(jQuery('.navbar-nav li a[href^="#"]').first().attr('href')).height(), 10)) {

					if (scrollPosition >= thisPosition) {
						jQuery('.navbar-nav li a[href^="#"]').removeClass('nav-active');
						jQuery('.navbar-nav li a[href="' + thisHref + '"]').addClass('nav-active');
					}
				} else {
					if (scrollPosition >= thisPosition || scrollPosition >= thisPosition) {
						jQuery('.navbar-nav li a[href^="#"]').removeClass('nav-active');
						jQuery('.navbar-nav li a[href="' + thisHref + '"]').addClass('nav-active');
					}
				}
			}
		});

		/** header 3**/
		var scrollPosition = parseInt(jQuery(window).scrollTop(), 10);
		jQuery('#header_3 .navbar-nav li a[href^="#"]').each(function () {
			var thisHref = jQuery(this).attr('href');
			if (jQuery(thisHref).length) {

				var thisTruePosition = parseInt(jQuery(thisHref).offset().top, 10),
					thisPosition = thisTruePosition - jQuery("#header_3").height();
				if (scrollPosition <= parseInt(jQuery(jQuery('.navbar-nav li a[href^="#"]').first().attr('href')).height(), 10)) {

					if (scrollPosition >= thisPosition) {
						jQuery('.navbar-nav li a[href^="#"]').removeClass('nav-active');
						jQuery('.navbar-nav li a[href="' + thisHref + '"]').addClass('nav-active');
					}
				} else {
					if (scrollPosition >= thisPosition || scrollPosition >= thisPosition) {
						jQuery('.navbar-nav li a[href^="#"]').removeClass('nav-active');
						jQuery('.navbar-nav li a[href="' + thisHref + '"]').addClass('nav-active');
					}
				}
			}
		});
	}

window.clearTimeout(scrollTimer);
scrollHandler();


jQuery(window).scroll(function () {
	window.clearTimeout(scrollTimer);
	scrollTimer = window.setTimeout(function () {
		scrollHandler();
	}, 20);
});
var xy = "";
function sr_FullHeightScreen() {
	if (jQuery("#header_2").length) {
		if (jQuery(".top_site_main").length) {
			jQuery('.top_site_main').css({'margin-bottom': jQuery("#header_2").height()});
			window_height = jQuery('.top_site_main').height();
		} else {
			window_height = jQuery(window).height();
			jQuery('div.home').css({height: window_height});
			if (xy == "") {
				xy = jQuery("#header_2").height() + parseInt(jQuery("#header_2").next().css('margin-top'), 10);
			}
			jQuery("#header_2").next().css({'margin-top': xy});
		}
		if (parseInt(jQuery(window).scrollTop(), 10) >= window_height) {
			jQuery('#header_2').removeClass("h-top");
			jQuery('#header_2').addClass("h-fixed");
		} else {
			jQuery('#header_2').removeClass("h-fixed");
			jQuery('#header_2').addClass("h-top");

			jQuery('#header_2').css({top: window_height});
		}
	} else if (jQuery("#header_3").length) {
		if (jQuery(".top_site_main").length) {
			window_height = jQuery('.top_site_main').height();
		} else {
			window_height = jQuery(window).height();
			jQuery('div.home').css({height: window_height});
		}

		if (parseInt(jQuery(window).scrollTop(), 10) >= window_height - jQuery("#header_3").height()) {
			jQuery('#header_3').addClass("h3_bg");
		} else {
			jQuery('#header_3').removeClass("h3_bg");
		}
	}
	else {
		window_height = jQuery(window).height();
		jQuery('div.home').css({height: window_height});
	}
}
sr_FullHeightScreen();
jQuery(window).bind('resize', function () {
	sr_FullHeightScreen();
});

jQuery(window).scroll(function () {
	sr_FullHeightScreen();
});

jQuery(document).ready(function ($) {
	jQuery('.am_animate_when_almost_visible:not(.am_start_animation)').waypoint(function () {
		jQuery(this).addClass('am_start_animation');
	}, {offset: '85%'});

	count_down = 0;
	countInterval = setInterval(function () {
		if (count_down < 20) {
			if (jQuery('.owl-wrapper-outer').length) {
				jQuery('.owl-wrapper-outer').each(function () {
					var wh = jQuery(this).height() / 2;
					if (wh < 30) {
						wh = 0;
					} else {
						wh = wh - 30;
					}
					jQuery(this).next().find('.owl-prev').css({top: wh});
					jQuery(this).next().find('.owl-next').css({top: wh});
				});
			}
			count_down++;
		} else {
			clearInterval(countInterval);
		}
	}, 2000);


}); // END jQuery(document).ready
jQuery(document).ready(function ($) {
	if ($('body').hasClass('single-post')) {
		//alert(window.location.hash.replace('#', ''));
		var elem = window.location.hash.replace('#', '');
		if (elem && $("#header").length) {
			//alert(elem);
			//$.scrollTo(elem.left, elem.top+100);
			$('html, body').animate({
				scrollTop: $("#" + elem).offset().top - $("#header").height()
			}, 500);
		}
	}
});

!function () {
	function e() {
		z.keyboardSupport && m("keydown", a)
	}

	function t() {
		if (!A && document.body) {
			A = !0;
			var t = document.body, o = document.documentElement, n = window.innerHeight, r = t.scrollHeight;
			if (B = document.compatMode.indexOf("CSS") >= 0 ? o : t, D = t, e(), top != self) X = !0; else if (r > n && (t.offsetHeight <= n || o.offsetHeight <= n)) {
				var a = document.createElement("div");
				a.style.cssText = "position:absolute; z-index:-10000; top:0; left:0; right:0; height:" + B.scrollHeight + "px", document.body.appendChild(a);
				var i;
				T = function () {
					i || (i = setTimeout(function () {
						L || (a.style.height = "0", a.style.height = B.scrollHeight + "px", i = null)
					}, 500))
				}, setTimeout(T, 10), m("resize", T);
				var l = {attributes: !0, childList: !0, characterData: !1};
				if (M = new V(T), M.observe(t, l), B.offsetHeight <= n) {
					var c = document.createElement("div");
					c.style.clear = "both", t.appendChild(c)
				}
			}
			z.fixedBackground || L || (t.style.backgroundAttachment = "scroll", o.style.backgroundAttachment = "scroll")
		}
	}

	function o() {
		M && M.disconnect(), h(I, r), h("mousedown", i), h("keydown", a), h("resize", T), h("load", t)
	}

	function n(e, t, o) {
		if (p(t, o), 1 != z.accelerationMax) {
			var n = Date.now(), r = n - R;
			if (r < z.accelerationDelta) {
				var a = (1 + 50 / r) / 2;
				a > 1 && (a = Math.min(a, z.accelerationMax), t *= a, o *= a)
			}
			R = Date.now()
		}
		if (q.push({x: t, y: o, lastX: 0 > t ? .99 : -.99, lastY: 0 > o ? .99 : -.99, start: Date.now()}), !P) {
			var i = e === document.body, l = function (n) {
				for (var r = Date.now(), a = 0, c = 0, u = 0; u < q.length; u++) {
					var d = q[u], s = r - d.start, f = s >= z.animationTime, m = f ? 1 : s / z.animationTime;
					z.pulseAlgorithm && (m = x(m));
					var h = d.x * m - d.lastX >> 0, w = d.y * m - d.lastY >> 0;
					a += h, c += w, d.lastX += h, d.lastY += w, f && (q.splice(u, 1), u--)
				}
				i ? window.scrollBy(a, c) : (a && (e.scrollLeft += a), c && (e.scrollTop += c)), t || o || (q = []), q.length ? _(l, e, 1e3 / z.frameRate + 1) : P = !1
			};
			_(l, e, 0), P = !0
		}
	}

	function r(e) {
		A || t();
		var o = e.target, r = u(o);
		if (!r || e.defaultPrevented || e.ctrlKey)return !0;
		if (w(D, "embed") || w(o, "embed") && /\.pdf/i.test(o.src) || w(D, "object"))return !0;
		var a = -e.wheelDeltaX || e.deltaX || 0, i = -e.wheelDeltaY || e.deltaY || 0;
		return K && (e.wheelDeltaX && b(e.wheelDeltaX, 120) && (a = -120 * (e.wheelDeltaX / Math.abs(e.wheelDeltaX))), e.wheelDeltaY && b(e.wheelDeltaY, 120) && (i = -120 * (e.wheelDeltaY / Math.abs(e.wheelDeltaY)))), a || i || (i = -e.wheelDelta || 0), 1 === e.deltaMode && (a *= 40, i *= 40), !z.touchpadSupport && v(i) ? !0 : (Math.abs(a) > 1.2 && (a *= z.stepSize / 120), Math.abs(i) > 1.2 && (i *= z.stepSize / 120), n(r, a, i), e.preventDefault(), void l())
	}

	function a(e) {
		var t = e.target, o = e.ctrlKey || e.altKey || e.metaKey || e.shiftKey && e.keyCode !== N.spacebar;
		document.contains(D) || (D = document.activeElement);
		var r = /^(textarea|select|embed|object)$/i, a = /^(button|submit|radio|checkbox|file|color|image)$/i;
		if (r.test(t.nodeName) || w(t, "input") && !a.test(t.type) || w(D, "video") || y(e) || t.isContentEditable || e.defaultPrevented || o)return !0;
		if ((w(t, "button") || w(t, "input") && a.test(t.type)) && e.keyCode === N.spacebar)return !0;
		var i, c = 0, d = 0, s = u(D), f = s.clientHeight;
		switch (s == document.body && (f = window.innerHeight), e.keyCode) {
			case N.up:
				d = -z.arrowScroll;
				break;
			case N.down:
				d = z.arrowScroll;
				break;
			case N.spacebar:
				i = e.shiftKey ? 1 : -1, d = -i * f * .9;
				break;
			case N.pageup:
				d = .9 * -f;
				break;
			case N.pagedown:
				d = .9 * f;
				break;
			case N.home:
				d = -s.scrollTop;
				break;
			case N.end:
				var m = s.scrollHeight - s.scrollTop - f;
				d = m > 0 ? m + 10 : 0;
				break;
			case N.left:
				c = -z.arrowScroll;
				break;
			case N.right:
				c = z.arrowScroll;
				break;
			default:
				return !0
		}
		n(s, c, d), e.preventDefault(), l()
	}

	function i(e) {
		D = e.target
	}

	function l() {
		clearTimeout(E), E = setInterval(function () {
			F = {}
		}, 1e3)
	}

	function c(e, t) {
		for (var o = e.length; o--;)F[j(e[o])] = t;
		return t
	}

	function u(e) {
		var t = [], o = document.body, n = B.scrollHeight;
		do {
			var r = F[j(e)];
			if (r)return c(t, r);
			if (t.push(e), n === e.scrollHeight) {
				var a = s(B) && s(o), i = a || f(B);
				if (X && d(B) || !X && i)return c(t, $())
			} else if (d(e) && f(e))return c(t, e)
		} while (e = e.parentElement)
	}

	function d(e) {
		return e.clientHeight + 10 < e.scrollHeight
	}

	function s(e) {
		var t = getComputedStyle(e, "").getPropertyValue("overflow-y");
		return "hidden" !== t
	}

	function f(e) {
		var t = getComputedStyle(e, "").getPropertyValue("overflow-y");
		return "scroll" === t || "auto" === t
	}

	function m(e, t) {
		window.addEventListener(e, t, !1)
	}

	function h(e, t) {
		window.removeEventListener(e, t, !1)
	}

	function w(e, t) {
		return (e.nodeName || "").toLowerCase() === t.toLowerCase()
	}

	function p(e, t) {
		e = e > 0 ? 1 : -1, t = t > 0 ? 1 : -1, (Y.x !== e || Y.y !== t) && (Y.x = e, Y.y = t, q = [], R = 0)
	}

	function v(e) {
		return e ? (O.length || (O = [e, e, e]), e = Math.abs(e), O.push(e), O.shift(), clearTimeout(H), H = setTimeout(function () {
			window.localStorage && (localStorage.SS_deltaBuffer = O.join(","))
		}, 1e3), !g(120) && !g(100)) : void 0
	}

	function b(e, t) {
		return Math.floor(e / t) == e / t
	}

	function g(e) {
		return b(O[0], e) && b(O[1], e) && b(O[2], e)
	}

	function y(e) {
		var t = e.target, o = !1;
		if (-1 != document.URL.indexOf("www.youtube.com/watch"))do if (o = t.classList && t.classList.contains("html5-video-controls"))break; while (t = t.parentNode);
		return o
	}

	function S(e) {
		var t, o, n;
		return e *= z.pulseScale, 1 > e ? t = e - (1 - Math.exp(-e)) : (o = Math.exp(-1), e -= 1, n = 1 - Math.exp(-e), t = o + n * (1 - o)), t * z.pulseNormalize
	}

	function x(e) {
		return e >= 1 ? 1 : 0 >= e ? 0 : (1 == z.pulseNormalize && (z.pulseNormalize /= S(1)), S(e))
	}

	function k(e) {
		for (var t in e)C.hasOwnProperty(t) && (z[t] = e[t])
	}

	var D, M, T, E, H, C = {
		frameRate        : 150,
		animationTime    : 400,
		stepSize         : 100,
		pulseAlgorithm   : !0,
		pulseScale       : 4,
		pulseNormalize   : 1,
		accelerationDelta: 50,
		accelerationMax  : 3,
		keyboardSupport  : !0,
		arrowScroll      : 50,
		touchpadSupport  : !1,
		fixedBackground  : !0,
		excluded         : ""
	}, z = C, L = !1, X = !1, Y = {
		x: 0,
		y: 0
	}, A = !1, B = document.documentElement, O = [], K = /^Mac/.test(navigator.platform), N = {
		left    : 37,
		up      : 38,
		right   : 39,
		down    : 40,
		spacebar: 32,
		pageup  : 33,
		pagedown: 34,
		end     : 35,
		home    : 36
	}, q = [], P = !1, R = Date.now(), j = function () {
		var e = 0;
		return function (t) {
			return t.uniqueID || (t.uniqueID = e++)
		}
	}(), F = {};
	window.localStorage && localStorage.SS_deltaBuffer && (O = localStorage.SS_deltaBuffer.split(","));
	var I, _ = function () {
			return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || function (e, t, o) {
					window.setTimeout(e, o || 1e3 / 60)
				}
		}(), V = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver, $ = function () {
			var e;
			return function () {
				if (!e) {
					var t = document.createElement("div");
					t.style.cssText = "height:10000px;width:1px;", document.body.appendChild(t);
					var o = document.body.scrollTop;
					document.documentElement.scrollTop;
					window.scrollBy(0, 3), e = document.body.scrollTop != o ? document.body : document.documentElement, window.scrollBy(0, -3), document.body.removeChild(t)
				}
				return e
			}
		}(), U = window.navigator.userAgent, W = /Edge/.test(U), G = /chrome/i.test(U) && !W, J = /safari/i.test(U) && !W,
		Q = /mobile/i.test(U), Z = (G || J) && !Q;
	"onwheel" in document.createElement("div") ? I = "wheel" : "onmousewheel" in document.createElement("div") && (I = "mousewheel"), I && Z && (m(I, r), m("mousedown", i), m("load", t)), k.destroy = o, window.SmoothScrollOptions && k(window.SmoothScrollOptions), "function" == typeof define && define.amd ? define(function () {
		return k
	}) : "object" == typeof exports ? module.exports = k : window.SmoothScroll = k
}();