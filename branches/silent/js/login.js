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

function add_class(el, new_class) {
	el.className += (el.className ? ' ' : '') + new_class;
}
function rm_class(el, class_name) {
	classes = el.className.split(/\s+/);
	new_classes = [];
	for (i = 0; i < classes.length; i++) {
		if (class_name != classes[i]) {
			new_classes[new_classes.length] = classes[i];
		}
	}
	el.className = new_classes.join(' ');
}

function dtrue(id) {
	rm_class(document.getElementById(id), 'invalidval');
	add_class(document.getElementById(id), 'correctval');
}
function dfalse(id) {
	rm_class(document.getElementById(id), 'correctval');
	add_class(document.getElementById(id), 'invalidval');
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
	if (a.value.length > 3 || wh == 'cap') {
		var xmlhttp = getXmlHttp();
		xmlhttp.open('GET', "ajax/usrchk?"+wh+"="+a.value, true);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState==4) {
				var jr = eval('('+xmlhttp.responseText+')');
				if (jr.val == "true") {
					dtrue("c"+wh);
				} else {
					dfalse("c"+wh);
				}
			}
		};
		xmlhttp.send(null);
	} else {
		dfalse("c"+wh);
	}
}