/*
<input type='radio' name='name' value='val'/>
<input type='radio' name='name' value='val2'/>
*/
$(function() {
  $('input[name=name]').change(function() {
    if($(this).val() ==='val') {
      //true
    } else {
      //false
    }
  });
}
