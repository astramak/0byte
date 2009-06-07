var log="";
function login ( ) {
cr();
if (log!="") {
document.getElementById("mn").innerHTML=log;
document.getElementsByName('login')[0].focus();
} else {
x_r("login.php?js=1&cur="+cur,"lg");
log=document.getElementById("mn").innerHTML;
}
}
function unlogin() {
a_cr();
}
function dtrue(id) {
	document.getElementById(id).style.color="green";
document.getElementById(id).style.backgroundColor="green";
}
function dfalse(id) {
	document.getElementById(id).style.color="#434242";
		document.getElementById(id).style.backgroundColor="#F2F1F0";
}
function chkpwd(a) {
	if (a.pwd.value==a.pwd2.value && a.pwd.value.length>3) {
	
dtrue("pwd");
dtrue("pwd2");
	} else {
	
	dfalse("pwd");
dfalse("pwd2");
	}
}

function chka(a,wh) {
	if (a.value.length>3 || wh=='cap') {
	var xmlhttp = getXmlHttp();
xmlhttp.open('GET', "js/usrchk.php?"+wh+"="+a.value, true);
xmlhttp.onreadystatechange = function() {
	if (xmlhttp.readyState==4) {
		var jr=eval('('+xmlhttp.responseText+')');
		if (jr.val=="true") {
			dtrue("c"+wh);
	
		} else {dfalse("c"+wh); }
	} };
xmlhttp.send(null);	
} else {
	dfalse("c"+wh);
}
}