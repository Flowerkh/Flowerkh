$(function(){

$('#commentbtn').on('click', function(){
  //array value length
  var grpl = $("input[name=groupod]").length;
  
  //make array
  var grparr = new Array(grpl);
  //array value push
  for(var i=0; i<grpl; i++){                         
    grparr[i] = $("input[name=groupod]").eq(i).val();
            alert(grparr[i]);
        }
    });
});
