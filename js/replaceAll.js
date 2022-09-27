//replaceAll prototype 선언 
String.prototype.replaceAll = function(org, dest) {     
	return this.split(org).join(dest); 
}  

//replaceAll 사용 
var str = "Hello World"; 
str = str.replaceAll("o","*"); 

alert(str);
