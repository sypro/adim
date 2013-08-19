function processRequest(response){if(response.replaces instanceof Array){for(var i=0,ilen=response.replaces.length;i<ilen;i++){$(response.replaces[i].what).replaceWith(response.replaces[i].data);}}if(response.js){$("body").append(response.js);}}
$(function(){
});
