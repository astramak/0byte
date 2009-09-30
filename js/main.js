var hash=location.hash;
var nw=0;
function strt() {
	for (var i=0; i<(document.links.length); i++) {
		if (document.links[i].href.indexOf('twork.php?wt=ratep')+1) {
			document.links[i].href = "javascript:x_r('twork.php"+document.links[i].search+"&json=1','p')";
		} else if (document.links[i].href.indexOf('twork.php?wt=rateu')+1) {
			document.links[i].href = "javascript:x_r('twork.php"+document.links[i].search+"&json=1','u')";
		} else if (document.links[i].href.indexOf('twork.php?wt=rateb')+1) {
			document.links[i].href = "javascript:x_r('twork.php"+document.links[i].search+"&json=1','b')";
		} else if (document.links[i].href.indexOf('twork.php?wt=ratec')+1) {
			document.links[i].href = "javascript:x_r('twork.php"+document.links[i].search+"&json=1','c')";
		} else if (document.links[i].href.indexOf('work/comment')+1) {
			re=/work\/comment\/(.*?)\/(.*?)\/(.*?)/;
			var arr=re.exec(document.links[i].href);
			tm=parseInt(arr[2])+1;
			document.links[i].href = "javascript:doit('"+arr[1]+"','"+tm+"')";
		} else if (document.links[i].href.indexOf('twork.php?wt=pmdel')+1) {
			re=/twork.php\?wt\=pmdel\&id\=(.*?)\&cur(.*?)/;
			var arr=re.exec(document.links[i].href);
			document.links[i].href = "javascript:pmdel('"+arr[1]+"')";
		} else if (document.links[i].href.indexOf('twork.php?wt=mergeblog')+1) {
			document.links[i].href = "javascript:iblog('twork.php"+document.links[i].search+"')";
		} else if (document.links[i].href.indexOf('twork.php?wt=friend')+1) {
			document.links[i].href = "javascript:ifrnd('twork.php"+document.links[i].search+"')";
		} else if (document.links[i].href.indexOf('twork.php?wt=flw')+1) {
			document.links[i].href = "javascript:x_r('twork.php"+document.links[i].search+"&json=1','f')";
		} else if (document.links[i].href.indexOf('work/block/user/')+1) {
//                        re=/work\/block\/user\//;
//			var arr=re.exec(document.links[i].href);
                        txt= document.links[i].href.replace(/(.*?)\/work\/block\/user\//,'');
                        
                        document.links[i].href="javascript:cr(); x_r('ajax/editor?type=block&fr="+txt+"&el=user','box');"
                }  else if (document.links[i].href.indexOf('draft#')+1) {
                    document.links[i].href="javascript:g_plist('draft')";
                }  else if (document.links[i].href.indexOf('favourite#')+1) {
                    document.links[i].href=" javascript:g_plist('favourite')";
                }  else if (document.links[i].href.indexOf('twork.php?wt=favourite')+1) {
			document.links[i].href = "javascript:x_r('twork.php"+document.links[i].search+"&json=1','fav')";
		} else if (document.links[i].href.indexOf('work/blockpost/')+1) {
                        tt=document.links[i].href.replace(/(.*?)\/work\/blockpost\//,'');

                        document.links[i].href="javascript:cr(); x_r('ajax/editor?type=blockpost&id="+tt+"','box');"
                }
               
	}
        if (document.getElementById("view")) {
            document.getElementById("view").style.display="inline";
        }
	if (document.getElementById("lgin")) {
    		document.getElementById("lgin").href="javascript:login()";
	}
	if (document.getElementById('rma')) {
		document.getElementById('adda').href='javascript:adda()';
		document.getElementById('rma').href='javascript:rma()';
	}

}
function getXmlHttp(){
	var xmlhttp;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}
function r_s(xrs,xs,xrt,tp) {
	if (xrs == 4) {
		if(xs == 200 || tp=="newcom") {
			if (tp!='lg' && tp!='ulg') {
				var jr=eval('('+xrt+')');
			}

			if (jr) {
				if (!jr.err) {
                                        if (tp=="box") {
                                            if (jr.clean) {
                                                document.getElementById(jr.id).innerHTML=jr.content;
                                            } else {
                                                document.getElementById(jr.id).innerHTML=jr.content;
                                            }
                                            //put cache here
                                        } else
					if (tp=="p") {
						if (parseInt(jr.rate)>0) {
							jr.rate="<span class='rp' title='"+jr.title+"'>"+jr.rate+"</span>";
						} else if (parseInt(jr.rate)<0) {
							jr.rate="<span class='rm' title='"+jr.title+"'>"+jr.rate+"</span>";
						}
						document.getElementById("rp"+jr.id).innerHTML=jr.rate;
					} else if (tp=="u") {
						if (parseInt(jr.rate)>0) {
							jr.rate="<span class='rp'>"+jr.rate+"</span>";
						} else if (parseInt(jr.rate)<0) {
							jr.rate="<span class='rm'>"+jr.rate+"</span>";
						}
						document.getElementById("ru"+jr.id).innerHTML=jr.rate;
					}  else	if (tp=="b") {
						if (parseInt(jr.rate)>0) {
							jr.rate="<span class='rp'>"+jr.rate+"</span>";
						} else if (parseInt(jr.rate)<0) {
							jr.rate="<span class='rm'>"+jr.rate+"</span>";
						}
						document.getElementById("rb"+jr.id).innerHTML=jr.rate;
					} else if (tp=="c") {
						if (parseInt(jr.rate)>0) {
							jr.rate="<span class='rp'>"+jr.rate+"</span>";
						} else if (parseInt(jr.rate)<0) {
							jr.rate="<span class='rm'>"+jr.rate+"</span>";
						}
						document.getElementById("rc"+jr.id).innerHTML=jr.rate;
					} else if (tp=="m") {
						document.getElementById("cm"+jr.id).innerHTML+=jr.text;
					} else if (tp=='f') {
						document.getElementById('sled').href=jr.lnk;
						document.getElementById('sled').innerHTML='<img src="style/n_img/eye.gif"/>'+jr.txt;
					}
                                        else if (tp=='fav') {
						document.getElementById('favor').href=jr.url;
						document.getElementById('favor').innerHTML='<img src="style/n_img/fav.gif"/>'+jr.txt;
					}
                                        else if (tp=="newcom") {
						
						document.getElementById("cmn").innerHTML+=jr.txt;
						document.location.hash="#cmnt"+jr.id;
			
					}  else if (tp=='scom') {
						document.getElementById('cmadd'+jr.cid).innerHTML+=jr.txt;
						document.location.hash="#cmnt"+jr.id;
					}
				} else {
					make_err(jr.err);
				}
			} else if (tp=='lg') {
				document.getElementById("mn").innerHTML=xrt;
				document.getElementsByName('login')[0].focus();
			} else if (tp=='ulg') {
				document.getElementById("usr").innerHTML=xrt;
			}
		}
	}
}
function x_r(lnk,tp) {
	var xmlhttp = getXmlHttp();
	xmlhttp.open('GET', lnk, true);
	xmlhttp.onreadystatechange = function() {
		r_s(xmlhttp.readyState,xmlhttp.status,xmlhttp.responseText,tp);
	};
	xmlhttp.send(null);
}
function s_c(a,id) {
	var xmlhttp = getXmlHttp();
	xmlhttp.open('POST', "twork.php?wt=newcom&json=1&id="+id, true);
	xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xmlhttp.onreadystatechange = function() {
		r_s(xmlhttp.readyState,xmlhttp.status,xmlhttp.responseText,"newcom");
	};
	xmlhttp.send("text="+encodeURIComponent(a.text.value));

	a.text.value="";
}

function ljs(fl){
	var sc = document.createElement('script');
	sc.setAttribute('src',fl);
	sc.setAttribute('type','text/javascript');
	sc.setAttribute('id',fl);
	document.getElementsByTagName('head')[0].appendChild(sc);
}

function logout() {
	x_r("jsun.php","ulg");
}

function cr() {
	if (!document.getElementById("bs")) {
		var bs=document.createElement('div');
	
		bs.innerHTML="<div id='bs'><div id='wd'><b class='b1'></b>" +
		"<b class='b2'></b><b class='b3'></b><b class='b4'></b>" +
		"<div id='mn'></div>" +
		"<b class='b4'></b><b class='b3'></b><b class='b2'></b><b class='b'></b></div></div>";
		document.getElementsByTagName('body')[0].appendChild(bs);
	} else {
		document.getElementById("bs").style.display='block';
	}
}
function a_cr() {
	document.getElementById("bs").style.display='none';
}
function adda() {
	l=parseInt(document.getElementById('len').value)+1;
	document.getElementById('len').value=l;
	newi=document.createElement("label");
	newi.id="an"+l;
	newi.innerHTML="<input type='text' name='an"+l+"' /><br />";
	document.getElementById('nw').appendChild(newi);
}
function rma() {
	l=parseInt(document.getElementById('len').value);
	document.getElementById('nw').removeChild(document.getElementById('an'+l));
	document.getElementById('len').value=l-1;
}
var w="";
function answe(a,tp) {
    if (tp==1 && a.answ.value==null) {
        make_err('Вы не выбрали вариант ответа!');
    } else {
	a.nox.type='button';
	a.nax.type='button';
	url=a.action+"&json=1";
	re=/(.*?)id\=(.*?)\&json\=1/;
	var id_l=re.exec(url);
	id=id_l[2];
	var xmlhttp = getXmlHttp();
	xmlhttp.open('POST',url, true);
	xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xmlhttp.onreadystatechange = function() { 
		if (xmlhttp.readyState == 4) {
			document.getElementById("a_"+id).innerHTML=xmlhttp.responseText;
		}
	};
	if (tp==2) {
		ts="nox=1";
	} else if (a_type==1) {
		ts=w;
	} else {
		ts="answ="+a.answ.value;
	}
	xmlhttp.send(ts);
    }
    return false;
}
function set_a(a,val) {
	a.answ.value=val;
}
function set_b(val) {
	if (w.indexOf(val+"=on&")+1) {
		w=w.replace(val+"=on&","");
	} else {
		w+=val+"=on&";
	}
}
function _touch(url) {
	var xmlhttp = getXmlHttp();
	xmlhttp.open('GET',url ,true);
	xmlhttp.onreadystatechange = function() {};
	xmlhttp.send(null);
}
function iblog(url) {
	if (document.getElementById("ibl")) {
		_touch(url);
		document.getElementById("ibl").innerHTML="Выйти!";
		document.getElementById("ibl").id="obl";
	} else {
		_touch(url);
		document.getElementById("obl").innerHTML="Вступить!";
		document.getElementById("obl").id="ibl";		
	}
}
function ifrnd(url) {
	if (document.getElementById("ifrn")) {
		_touch(url);
		document.getElementById("ifrn").innerHTML="Перестать дружить";
		document.getElementById("ifrn").id="ofrn";
	} else {
		_touch(url);
		document.getElementById("ofrn").innerHTML="Добавить в друзья";
		document.getElementById("ofrn").id="ifrn";		
	}
}
function make_err(txt) {
	err=document.createElement("div");
	err.innerHTML="<p>"+txt+"</p>";
	err.className="err_bbl";
	date=new Date();
	err.id="err_"+date.getTime();
	document.getElementsByTagName("body")[0].appendChild(err);
	setTimeout("kill_err('"+err.id+"')",5000);
}
function kill_err(id) {
	document.getElementsByTagName("body")[0].removeChild(document.getElementById(id));
}
function to_(e) {
	e = e || window.event;
	if (e.ctrlKey && e.keyCode==37) {
		if (document.getElementById("prev")) {
			document.location=document.getElementById("prev").href;
		}
	} else if (e.ctrlKey && e.keyCode==39) {
		if (document.getElementById("next")) {
			document.location=document.getElementById("next").href;
		}
	} else if (e.altKey && e.keyCode==116) {
		if (document.getElementById('cm')) {
			upd_com();
			d_key(e);
		}
	} else if (e.ctrlKey && e.keyCode==40) {
		if (document.getElementById('cm')) {
			upd_ls();
		}
	}
}
function make_cause(type,url) {
    cr();
    if (type=='user_block') {
        document.getElementById('mn').innerHTML="<h3>Причина блокировки пользователя</h3>";
    }
}