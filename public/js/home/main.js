swipe=document.getElementById("swipe");function scroll(){400<document.documentElement.scrollTop&&(swipe.style.display="none")}window.onscroll=function(){scroll()};swipe.addEventListener("click",function(){setTimeout(function(){window.scrollTo(0,1000);},2);});