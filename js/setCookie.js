//Set Cookie
function setCookie( name, value, expiredays ) {
  var todayDate = new Date();
  todayDate.setDate( todayDate.getDate() + expiredays );
  document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}

//Get Cookie
function getCookie(cName) {
  cName = cName + '=';
  var cookieData = document.cookie;
  var start = cookieData.indexOf(cName);
  var cValue = '';
  if(start != -1){
    start += cName.length;
    var end = cookieData.indexOf(';', start);
    if(end == -1)end = cookieData.length;
    cValue = cookieData.substring(start, end);
  }
  return unescape(cValue);
}

//example
function closeWin(day, id) {
  $('#popArea').hide();
  setCookie( id, "done", day );    // cookieName , value , Date( ex. 1 = one day, 7 = one week)
  document.getElementById(id).style.display = "none";
}

$(document).ready(function() {
  $('.layer_banner').each(function(){
    var id = $(this).attr('id');
  });
});
