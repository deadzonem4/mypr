window.onload = function() {
   var test = getCookie('_jwt');
   var cookie = document.querySelector("#cookies");
   if(test){
     cookie.classList.add("rem-cookie");
   }
}
 
const setCookie=(cname,cvalue,exdays) => {
     console.log('here 1')
     var d = new Date();
       d.setTime(d.getTime() + (exdays*24*60*60*1000*30));
       var expires = "expires=" + d.toGMTString();
       console.log(expires)
       console.log('wwwww',document)
       document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
 const getCookie= (cname) => {
       var name = cname + "=";
       var decodedCookie = decodeURIComponent(document.cookie);
       var ca = decodedCookie.split(';');
       for(var i = 0; i < ca.length; i++) {
           var c = ca[i];
           while (c.charAt(0) == ' ') {
               c = c.substring(1);
           }
           if (c.indexOf(name) == 0) {
               return c.substring(name.length, c.length);
           }
       }
       return "";
}

document.querySelector("#cookies button").addEventListener('click', sendValues);
       
function sendValues(event){
  event.preventDefault();
  var cookie = document.querySelector("#cookies");
  cookie.style.display = "none";
    
  setCookie('_jwt',"wwwwwww",1)
};