<?php
//php    XSS      . 

$_GET     && SafeFilter($_GET);
$_POST    && SafeFilter($_POST);
$_COOKIE  && SafeFilter($_COOKIE);
 
function SafeFilter (&$arr) 
{
    
   $ra=Array('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/','/script/','/javascript/','/vbscript/','/expression/','/applet/','/meta/','/xml/','/blink/','/link/','/style/','/embed/','/object/','/frame/','/layer/','/title/','/bgsound/','/base/','/onload/','/onunload/','/onchange/','/onsubmit/','/onreset/','/onselect/','/onblur/','/onfocus/','/onabort/','/onkeydown/','/onkeypress/','/onkeyup/','/onclick/','/ondblclick/','/onmousedown/','/onmousemove/','/onmouseout/','/onmouseover/','/onmouseup/','/onunload/');
    
   if (is_array($arr))
   {
     foreach ($arr as $key => $value) 
     {
        if (!is_array($value))
        {
          if (!get_magic_quotes_gpc())             //  magic_quotes_gpc        addslashes(),      。
          {
             $value  = addslashes($value);           //    （'）、   （"）、   （\）  NUL（NULL   ）       
          }
          $value       = preg_replace($ra,'',$value);     //       ，     xss     
          $arr[$key]     = htmlentities(strip_tags($value)); //   HTML   PHP        HTML   
        }
        else
        {
          SafeFilter($arr[$key]);
        }
     }
   }
}
?>
