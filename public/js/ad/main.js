$("#image-gallery").lightSlider({gallery:!0,item:1,thumbItem:9,slideMargin:0,speed:1e3,auto:!0,loop:!0,onSliderLoad:function(){$("#image-gallery").removeClass("cS-hidden")}}),$(".clone").find("a").removeAttr("data-lightbox"),$(".onglet-btn").click(function(){$(".onglet-btn").removeClass("active"),$(this).addClass("active"),"description-btn"==$(this).attr("id")?($(".specificities-ad").css("display","none"),$(".description-ad").css("display","block")):($(".specificities-ad").css("display","block"),$(".description-ad").css("display","none"))}),$(window).resize(function(){$(window).width()<=1050&&(window.onscroll=function(){scroll()})});var sticky=document.getElementById("sticky").offsetTop;function scroll(){window.pageYOffset>=sticky?$(".about-head").addClass("sticky"):$(".about-head").removeClass("sticky")}function init(){var imgDefer = document.getElementsByTagName('img');for(var i=0;i<imgDefer.length;i++){if(imgDefer[i].getAttribute('data-src')){imgDefer[i].setAttribute('src',imgDefer[i].getAttribute('data-src'));}}}window.onload=init();