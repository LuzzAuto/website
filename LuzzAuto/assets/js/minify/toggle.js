function adjustMenuOnResize(){let e=document.getElementById("menu"),t=document.getElementById("menu-button-container"),i=e.querySelectorAll("a");function n(){t.classList.contains("change")?(e.style.position="static",e.style.margin="0",window.innerWidth>1024?e.style.marginLeft="auto":e.style.marginTop="3.5em",e.setAttribute("tabindex","0"),i.forEach((e=>{e.setAttribute("tabindex","0"),e.style.pointerEvents="here"===e.id?"none":"auto"})),t.setAttribute("aria-label","Seleziona per comprimere il menù di navigazione")):(e.style.position="absolute",e.style.margin="-9999em",e.setAttribute("tabindex","-1"),i.forEach((e=>{e.setAttribute("tabindex","-1"),e.style.pointerEvents="none"})),t.setAttribute("aria-label","Seleziona per espandere il menù di navigazione"))}window.innerWidth>1024?t.classList.add("change"):t.classList.remove("change"),n(),window.addEventListener("resize",(function(){window.innerWidth>1024?t.classList.add("change"):t.classList.remove("change"),n()})),t.addEventListener("click",(function(){t.classList.toggle("change"),n()}))}function switchToggle(){let e=document.getElementById("list_toggle_button");if(e){let i=document.getElementById("list_toggle_filter"),n=document.getElementById("list_filter_form"),s=n.querySelectorAll("input, select");function t(){i.checked?(n.style.position="static",n.style.margin="0",window.innerWidth<=1024?(e.style.position="static",e.style.margin="1em",e.setAttribute("tabindex","0")):(e.style.position="absolute",e.style.margin="-9999em",e.setAttribute("tabindex","-1")),s.forEach((e=>{e.setAttribute("tabindex","0"),e.style.position="static",e.classList.contains("list_button")?e.style.margin="3em auto 0":e.style.margin="0"}))):(n.style.position="absolute",n.style.margin="-9999em",s.forEach((e=>{e.setAttribute("tabindex","-1"),e.style.position="absolute",e.style.margin="-9999em"})))}e.addEventListener("click",(function(){i.checked=!i.checked,t(),e.setAttribute("aria-expanded",i.checked.toString()),e.setAttribute("aria-label",i.checked?"Seleziona per comprimere il form filtro":"Seleziona per espandere il form filtro")})),i.checked=!0,t(),window.addEventListener("resize",(function(){i.checked=!0,t()}))}}document.addEventListener("DOMContentLoaded",(function(){adjustMenuOnResize(),switchToggle()}));