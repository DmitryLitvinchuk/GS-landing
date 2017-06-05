/*
 * WPAjaxLoader ver. 1.1.2
 * jQuery Ajax Loader for Wordpress
 *
 * Copyright (c) 2014 Mariusz Rek
 * Rascals Themes 2014
 *
 */
(function(a){a.WPAjaxLoader=function(b){var d={home_url:"",theme_uri:"",dir:"",permalinks:"",ajax_async:true,ajax_cache:false,ajax_events:"",ajax_elements:"",content:"#ajax-content",reload_scripts:"/js/custom.js",loadStart:function(){},loadEnd:function(){}},c=this,b=b||{};
c.init=function(){var v=a.extend({},d,b);a.data(document,"WPAjaxLoader",v);var t=true,g=window.history.pushState!==undefined,s=a(v.content),e="",m,l=v.reload_scripts.split(","),h=0,i=new Array(),u=0,o=new Array();
if(v.ajax_async=="on"){v.ajax_async=true;}else{v.ajax_async=false;}if(v.ajax_cache=="on"){v.ajax_cache=true;}else{v.ajax_cache=false;}v.ajax_events=v.ajax_events.split(",");
v.ajax_elements=v.ajax_elements.split(",");a("body").append('<div id="loading-layer"><div id="ajax-loader"><div class="spinner" role="spinner"><div class="spinner-icon"></div></div></div></div>');
a("#loading-layer").css("visibility","hidden");function r(x){var w=false;a.each(v.ajax_elements,function(y,z){if(x.is(a(z))){w=true;return false;}});return w;
}function n(x){var w;if(typeof x==="string"){w=x;}else{w=x.attr("href");if((x.hasClass("comment-reply-link"))||(x.attr("id")==="cancel-comment-reply-link")){return false;
}else{if(r(x)){return false;}else{if(x.is('[target="_blank"]')){return false;}}}}if(w.indexOf("wp-admin")>-1||w.indexOf("wp-login")>-1){return false;}else{if(w.indexOf(".jpg")>-1||w.indexOf(".png")>-1||w.indexOf(".gif")>-1||w.indexOf(".zip")>-1||w.indexOf(".pdf")>-1||w.indexOf(".mp3")>-1||w.indexOf("feed")>-1){return false;
}else{return true;}}}a("#searchform").submit(function(y){t=false;var x=a("#s").val().replace(/ /g,"+");if(x){var w="/?s="+x;a.address.value(w);}y.preventDefault();
});function j(A){var D=A.split("</head")[0];meta_text=D.split("<meta ").length-1,meta_pos=0,metasprocessed=0,all_meta="";while(metasprocessed<meta_text){var C=D.indexOf("<meta",meta_pos);
end=D.indexOf(">",C),meta=D.substring(C,end);metasprocessed++;meta_pos=end;meta=meta+">";all_meta=all_meta+meta;}a("head meta").remove();a("head").append(all_meta);
var z=A.replace("<body",'<body><div id="body"').replace("</body>","</div></body>");var w=a(z).filter("#body");a("body").removeClass();a("body").attr("class",w.attr("class"));
a("body").data("wp_title",w.data("wp_title"));a("body").data("page_id",w.data("page_id"));document.title=a("body").data("wp_title");if(a("#wp-admin-bar-edit").length){var x=a("body").data("page_id");
var y=a("#wp-admin-bar-edit a").attr("href");var B=y.replace(/(post=).*?(&)/,"$1"+x+"$2");a("#wp-admin-bar-edit a").attr("href",B);}}function q(w){if(w>=i.length){return;
}a.ajax({url:i[w],dataType:"script",async:true,cache:false}).done(function(){q(++u);}).error(function(z,x,y){q(++u);});}a("html").find('link[type="text/css"]').each(function(){o.push(this.href);
});function k(y){var z="",x=a("<div>"+y+"</div>").find("style"),w=a("<div>"+y+"</div>").find('link[type="text/css"]');w.each(function(){if(a.inArray(this.href,o)==-1){a("head").append(this);
o.push(this.href);}});x.each(function(){var B=a(this).attr("media");var A=a(this).html();if(B===undefined||B==="screen"){z+=A;}});a('style:not([media="print"])').remove();
a("head").append('<style type="text/css">'+z+"</style>");}function p(w){var x=a("<div>"+w+"</div>").find("#ajax-container");s.RemoveChildrenFromDom();a("#ajax-container").html(x.html());
s=a("#ajax-content");v.loadEnd.call(this);if(e.length&&a(e).length){setTimeout(function(){a(window).scrollTop(a(e).offset().top+h);},500);}a("#loading-layer").removeClass("show-layer");
setTimeout(function(){a("#loading-layer").css("visibility","hidden");},600);a.get(window.location);}var f=function(z){e="";m=a(this);var x=m.attr("href");
if(n(m)){if(m.parents().hasClass("vc_tta-panels")){return;}if(m.attr("href")!=="#"){e=x.split("#")[1];if(e){e=a(this).attr("href").replace(/^.*?#/,"");
e="#"+e;x=x.replace(e,"");h=a(this).data("offset");if(h==undefined||h==""){h=parseInt(a("#header").css("height"),10);h=-(h);}}else{e="";}if(x===""){x=v.home_url+"/";
}if(x!==window.location.href){var y=x.replace(v.home_url,"");if(y===""||y==="/"){t=false;a.address.state(v.dir).value(" ");}else{t=false;a.address.state(v.dir).value(y);
}}else{if(e!==""&&e!=="#"){var w=a(e).offset().top+h;a("html, body").animate({scrollTop:w},900);}}}else{x=x.replace(e,"");e="";}}else{return;}z.preventDefault();
};a(document).on("click","a:urlInternal, a:urlFragment",f);a(".dl-menu a:urlInternal, .dl-menu a:urlFragment").on("click",f);a.address.state(v.dir).init(function(){a('.site a:urlInternal:eq(-"wp-admin"):eq(-"wp-login"):eq(-"#"):eq(-".jpg"):eq(-".gif"):eq(-".png"):eq(-".zip"):eq(-".pdf"):eq(-".mp4"):eq(-".mp3"):eq(-"feed"):not([href="#"])').address();
}).change(function(y){y.value=y.value.replace(" ","");var x=y.value,w=window.location;if(!t){if(n(x)){v.loadStart.call(this);var z=true;a("html, body").animate({scrollTop:0},400,function(){if(!z){return;
}a("#loading-layer").css("visibility","visible").addClass("show-layer");setTimeout(function(){a.ajax({url:v.home_url+y.value,dataType:"html",cache:v.ajax_cache,async:v.ajax_async,success:function(E){var F=a("<div>"+E+"</div>").find("#ajax-container");
var B=E;var D=a(E);var A,C;C=a("<div>"+E+"</div>");A=a("<div>"+E+"</div>").find("script[src]");a("#nav").html(C.find("#nav").html());F.imagesLoaded(function(){j(E);
k(E);p(E);a.each(v.ajax_events,function(H,I){a(document).off(I);});a(window).off("resize");a(window).off("scroll");u=0;i=[];var G=false;A.each(function(){var H=a(this).attr("src");
a("html script[src]").each(function(){if(a(this).attr("src")===H){G=true;return G;}});a.each(l,function(){if(H.indexOf(this)>-1){G=true;return false;}});
if(G===false){i.push(H);}G=false;});a.each(l,function(){if(a('html script[src*="'+this+'"]').length){i.push(a('html script[src*="'+this+'"]').attr("src"));
}else{if(a('script[src*="'+this+'"]',C).length){i.push(a('script[src*="'+this+'"]',C).attr("src"));}}});q(0);a(E).filter('script:contains("theme_vars")').each(function(){a.globalEval(this.text||this.textContent||this.innerHTML||"");
});});},error:function(C,A,B){if(v.permalinks=="0"){window.location.href=ajax_vars.home_url+"/?error=404";}else{window.location.href=ajax_vars.home_url+"/404";
}}});},500);z=false;});}}});return false;};c.init();};a.WPAjaxLoader.init=function(b){b();};})(jQuery);