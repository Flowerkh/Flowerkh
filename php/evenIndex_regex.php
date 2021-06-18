/*
* @regex string
* @input = abcd1234
* @output = a*c*1*3*
*/
preg_replace('/(\w)(\w)/','$1*',$string)
