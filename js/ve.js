var prw_id=0;
function insert(aTag, eTag,form,el) {
    var input = document.forms[form].elements[el];
    input.focus();
    if(typeof document.selection != 'undefined') {

        var range = document.selection.createRange();
        var insText = range.text;
        range.text = aTag + insText + eTag;

        range = document.selection.createRange();
        if (insText.length == 0) {
            range.move('character', -eTag.length);
        } else {
            range.moveStart('character', aTag.length + insText.length + eTag.length);
        }
        range.select();
    }
 
    else if(typeof input.selectionStart != 'undefined')	{

        var start = input.selectionStart;
        var end = input.selectionEnd;
        var insText = input.value.substring(start, end);
        input.value = input.value.substr(0, start) + aTag + insText + eTag + input.value.substr(end);
  
        var pos;
        if (insText.length == 0) {
            pos = start + aTag.length;
        } else {
            pos = start + aTag.length + insText.length + eTag.length;
        }
        input.selectionStart = pos;
        input.selectionEnd = pos;
    }
}



function cr_d(fr,el) {
    cr();
    x_r('ajax/editor?type=link&fr='+fr+'&el='+el,'box');
}
function code_d(fr,el) {
    cr();
    x_r('ajax/editor?type=code&fr='+fr+'&el='+el,'box');
}
function img_d(fr,el) {
    cr();
    x_r('ajax/editor?type=image&fr='+fr+'&el='+el,'box');

}
function video_d(fr,el) {
    cr();
    x_r('ajax/editor?type=video&fr='+fr+'&el='+el,'box');
}
function audio_d(fr,el) {
    cr();
    x_r('ajax/editor?type=audio&fr='+fr+'&el='+el,'box');
}

function urla(i,fr,el) {
    a_cr();
    insert("<a href='"+i.url.value+"'>","</a>",fr,el);
}
function codea(i,fr,el) {
    a_cr();
    insert("<code lang='"+i.code.value+"'>","</code>",fr,el);
}
function imga(i,fr,el) {
    a_cr();
    alt='';
    if (i.alt.value!='') {
        alt="="+i.alt.value;
    }
    insert("<img alt='"+alt+"' src='"+i.url.value+"' />","",fr,el);
}
function videoa(i,fr,el) {
    a_cr();
    insert("<video src='"+i.url.value+"'>","</video>",fr,el);
}
function audioa(i,fr,el) {
    a_cr();
    insert("<audio src='"+i.url.value+"'>","</audio>",fr,el);
}
function quote(fr,el) {
    if (document.getSelection) {
        text = document.getSelection();
    } else if (document.selection && document.selection.createRange) {
        text = document.selection.createRange().text;
    }
    insert("<quote>"+text,"</quote>",fr,el);
}
var last=null;
var cmn=null;
function doit(id,lvl) {
    if (loged==1) {
        if (!document.getElementById("f"+id)) {
                  
            if (last!=null) {
                document.getElementById("f"+last).style.display="none";
                document.getElementById("wy"+last).style.display="none";
                cmn=document.getElementById("f"+last).text.value;
            }
            last=id;
            document.getElementById("cmnt"+id).innerHTML+="<div class='cprv' id='cprv"+id+"'></div><div class='inpt' id='wy"+id+"'></div>"+"<form onsubmit='scm(this,\""+
            id+"\",\""+lvl+"\"); klcprv("+id+"); return false;' id='f"+
            id+"' name='f"+id+"'><textarea onkeypress='if (ce(event)) {scm(this.form,\""+id+"\",\""+lvl+"\"); klcprv("+id+"); } do_key(this.form,\"f"+id+"\",event);' onkeydown='if(\"\v\"==\"v\") {do_key(this.form,\"f"+id+"\",event);}'  name='text' rows='10' cols='80'></textarea><br />" +
            "<input type='submit'  value='Отправить' /><input type='button' onClick='prw_com(this.form.text.value,"+id+")' value='Предпросмотр' /></form>";
            mk("wy"+id,"f"+id);
            main_h();
            if (cmn!=null) {
                document.getElementById("f"+id).text.value=cmn;
            }
            if (prw_id!=0) {
                klcprv(prw_id);
            }
			
        } else if (document.getElementById("f"+id).style.display=="none") {
            document.getElementById("f"+last).style.display="none";
            document.getElementById("wy"+last).style.display="none";
            document.getElementById("f"+id).style.display="block";
            document.getElementById("wy"+id).style.display="block";
            cmn=document.getElementById("f"+last).text.value;
            main_h();
            document.getElementById("f"+id).text.value=cmn;
            last=id;
        } else {
            document.getElementById("f"+id).style.display="none";
            document.getElementById("wy"+id).style.display="none";
            main_a();
        }
    }
}
function scm(a,id,lvl) {
    document.getElementById("f"+id).style.display="none";
    document.getElementById("wy"+id).style.display="none";
    var xmlhttp = getXmlHttp();
    nw="cmadd"+id;
    xmlhttp.open('POST', "twork.php?wt=newcom&json=1&id="+id+"&lvl="+lvl, true);
    xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;charset=utf-8");
    xmlhttp.onreadystatechange = function() {
        r_s(xmlhttp.readyState,xmlhttp.status,xmlhttp.responseText,"scom");
    };

    xmlhttp.send("text="+encodeURIComponent(a.text.value));
	
    a.text.value="";
}
function nadd(a) {
    l=parseInt(a.nm.value)+1;
    a.nm.value=l;
    itm="<input type='text' id='na"+l+"' /><br />";
    newi=document.createElement("label");
    newi.innerHTML=itm;
    newi.id='n'+l;
    document.getElementById('list').insertBefore(newi,document.getElementById('ad'));
}
function nrm(a) {
    document.getElementById('list').removeChild(document.getElementById('n'+a.nm.value));
    l=parseInt(a.nm.value)-1;
    a.nm.value=l;
}
function main_h() {
    if (!document.getElementById('m-com')) {
               
        newi=document.createElement("a");
        newi.innerHTML="Комментировать пост!";
        newi.id='m-com';
        newi.href="javascript:main_a()";
        document.getElementById('mkt').style.display="none";
        document.getElementById('com').style.display="none";
        document.getElementById('it').insertBefore(newi,document.getElementById('mkt'));
        if (document.getElementById("com").text.value!="") {
            cmn=document.getElementById("com").text.value;
            document.getElementById("com").text.value="";
        }
                 
    } else {
        document.getElementById('mkt').style.display="none";
        document.getElementById('com').style.display="none";
        document.getElementById('m-com').style.display="inline";
        if (document.getElementById("com").text.value!="") {
            cmn=document.getElementById("com").text.value;
            document.getElementById("com").text.value="";
        }
    }
}
function main_a() {
    document.getElementById('mkt').style.display="block";
    document.getElementById('com').style.display="block";
    if (document.getElementById('m-com')) {
        document.getElementById('m-com').style.display="none";
    }
    if (last!=null) {
        document.getElementById("f"+last).style.display="none";
        document.getElementById("wy"+last).style.display="none";
        document.getElementById('com').text.value=document.getElementById("f"+last).text.value;
        cmn=document.getElementById("f"+last).text.value;
    }
    document.getElementById("com").text.value=cmn;
}
var sli="ul";
function li_a(a,id,fg) {
    s="<"+sli+">";
    e="</"+sli+">";
    tins=s;
    for (k=1;k<=parseInt(a.nm.value);k++) {
        if (document.getElementById("n"+k)) {
            tins+="<li>"+document.getElementById("na"+k).value+"</li>";
        } else {
            tins+="<li></li>";
        }
    }
    tins+=e;
    insert(tins,"",id,fg);
    a_cr();
}
function list(id,fg) {
    cr();
    x_r('ajax/editor?type=list&fr='+id+'&el='+fg,'box');
}
function change_color(val,fr) {
    if (val!='1') {
        insert('<span style=\'color:'+val+'\'>','</span>',fr,'text');
    }
}
function insert_font(size,fr) {
    insert('<span style="font-size:'+size+'px">','</span>',fr,'text');
}
function mk(id,fr) {
    //     x_r('ajax/editor?type=lis&fr='+id+'&el='+fg,'box');
    document.getElementById(id).innerHTML="<a class='tdx' href='javascript:insert(\"<b>\",\"</b>\",\""+fr+"\",\"text\")'><b>Ж</b></a>"+
    " <a class='tdx' href='javascript:insert(\"<i>\",\"</i>\",\""+fr+"\",\"text\")'><i>К</i></a>"+
    " <a class='tdx' href='javascript:insert(\"<u>\",\"</u>\",\""+fr+"\",\"text\")'><u>Ч</u></a>"+
    " <a class='tdx' href='javascript:insert(\"<del>\",\"</del>\",\""+fr+"\",\"text\")'><del>П</del></a>"+
    " <a class='tdx' href='javascript:insert(\"<ins>\",\"</ins>\",\""+fr+"\",\"text\")'><ins>Д</ins></a>"+
    " <a class='tdx' href='javascript:insert(\"<span style=&#39;float:left;&#39>\",\"</span>\",\""+fr+"\",\"text\")'>←</a>"+
    " <a class='tdx' href='javascript:insert(\"<span style=&#39;float:right;&#39;>\",\"</span>\",\""+fr+"\",\"text\")'>→</a>"+
    " <a class='tdx' href='javascript:list(\""+fr+"\",\"text\")'>Список</a>"+
    " <a class='tdx' href='javascript:cr_d(\""+fr+"\",\"text\")'>url</a>"+
    " <a class='tdx' href='javascript:img_d(\""+fr+"\",\"text\")'>img</a>"+
    " <select onchange=\"change_color(this.value,'"+fr+"')\">"+
    " <option value='0' selected disabled>Цвет</option>"+
    " <option value='#000000' style='background-color: #000000; color:#ffffff;'>Чёрный</option>"+
    " <option value='#ffffff'style='background-color: #ffffff;'>Белый</option>"+
    " <option value='#ff0000' style='background-color: #ff0000; color:#ffffff;'>Красный</option>"+
    " <option value='#00ff00'style='background-color: #00ff00;'>Зелёный</option>"+
    " <option value='#0000ff' style='background-color: #0000ff; color:#ffffff;'>Синий</option>" +
    " <option value='1' onClick='clr("+'"'+id+'",'+'"'+fr+'"'+")' >Другой</option>"+
    " </select>"+
    " <select onchange=\"insert('<h'+this.value+'>','</h'+this.value+'>','"+fr+"','text'); this.value=0;\">"+
    " <option value='0' selected disabled>Заголовки</option>"+
    " <option value='1'>Заголовок 1</option>"+
    " <option value='2'>Заголовок 2</option>"+
    " <option value='3'>Заголовок 3</option>"+
    " </select>"+
    " <select onchange=\"insert_font(this.value,'"+fr+"'); this.value=0;\">"+
    " <option value='0' selected disabled>Размер</option>"+
    " <option value='8' style='font-size: 8px;'>8</option>"+
    " <option value='12' style='font-size: 12px;'>12</option>"+
    " <option value='16' style='font-size: 16px;'>16</option>"+
    " <option value='18' style='font-size: 18px;'>18</option>"+
    " <option value='22' style='font-size: 22px;'>22</option>"+
    " <option value='24' style='font-size: 24px;'>24</option>"+
    " <option value='36' style='font-size: 36px;'>36</option>"+
    " </select><br />"+
    " <a class='tdx' href='javascript:code_d(\""+fr+"\",\"text\")'>code</a>" +
	" <a class='tdx' href='javascript:quote(\""+fr+"\",\"text\")'>Цитировать</a>"+
    " <a class='tdx' href='javascript:insert(\"<user>\",\"</user>\",\""+fr+"\",\"text\")'>Пользователь</a>"+
    " <a class='tdx' href='javascript:insert(\"<spoiler>\",\"</spoiler>\",\""+fr+"\",\"text\")'>Спойлер</a>" +
    " <a class='tdx' href='javascript:video_d(\""+fr+"\",\"text\")'>Видео</a>"+
    " <a class='tdx' href='javascript:audio_d(\""+fr+"\",\"text\")'>Аудио</a>";
    
}

function toHex(dec) {
    var hexCharacters = "0123456789ABCDEF"
    if (dec < 0)
        return "00"
    if (dec > 255)
        return "FF"
    var i = Math.floor(dec / 16)
    var j = dec % 16
    return hexCharacters.charAt(i) + hexCharacters.charAt(j)
}
var selcol;
function mkcol() {
    if (parseInt(document.getElementsByName("r")[0].value)>255) {
        document.getElementsByName("r")[0].value=255;
    }
    if (parseInt(document.getElementsByName("g")[0].value)>255) {
        document.getElementsByName("g")[0].value=255;
    }
    if (parseInt(document.getElementsByName("b")[0].value)>255) {
        document.getElementsByName("b")[0].value=255;
    }
    if (parseInt(document.getElementsByName("r")[0].value)<0) {
        document.getElementsByName("r")[0].value=0;
    }
    if (parseInt(document.getElementsByName("g")[0].value)<0) {
        document.getElementsByName("g")[0].value=0;
    }
    if (parseInt(document.getElementsByName("b")[0].value)<0) {
        document.getElementsByName("b")[0].value=0;
    }
    selcol="#"+
    toHex(parseInt(document.getElementsByName("r")[0].value))+
    toHex(parseInt(document.getElementsByName("g")[0].value))+
    toHex(parseInt(document.getElementsByName("b")[0].value));
    document.getElementById('ex').style.backgroundColor=selcol;
}

function col(c,w) {
    if (w==0) {
        if (parseInt(document.getElementsByName(c)[0].value)>0) {
            document.getElementsByName(c)[0].value=parseInt(document.getElementsByName(c)[0].value)-10;
            if (parseInt(document.getElementsByName(c)[0].value)<0) {
                document.getElementsByName(c)[0].value=0;
            }
        }
    } else {
        if (parseInt(document.getElementsByName(c)[0].value)<255) {
            document.getElementsByName(c)[0].value=parseInt(document.getElementsByName(c)[0].value)+10;
            if (parseInt(document.getElementsByName(c)[0].value)>255) {
                document.getElementsByName(c)[0].value=255;
            }
        }
    }
    mkcol();
}

function clr(id,fg) {
    cr();
    x_r('ajax/editor?type=color&fr='+id+'&el='+fg,'box');
}
function clr_s(id,fg) {
    insert("<span style='color:"+selcol+";'>","</color>",fg,"text");
    a_cr();
}
function klprv() {
    document.getElementById('prv').style.display='none';
}
function prv() {
    document.getElementById('prv').style.display='block';
    a=document.getElementById("new");
    var xmlhttp = getXmlHttp();
    xmlhttp.open('POST', "twork.php?wt=rtext", true);
    xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState==4) {
            document.getElementById('prv').innerHTML="<h2>Предпросмотр  <a href='javascript:klprv()'>X</a></h2>"+xmlhttp.responseText;
            make_spoiler('prv');
        }
    };
    xmlhttp.send("text="+encodeURIComponent(a.text.value));
    document.getElementById('prv').style.display='block';
}
function ce(e){
    e = e || window.event;
    if (((e.keyCode == 13) || (e.keyCode == 10)) && (e.ctrlKey == true)) return true;
    return false;
}
function d_key(e) {
    if (e.preventDefault){
        e.preventDefault();
    } else {
        e.returnValue = false;
    }
} 	
function do_key(wh,id,e) {
    e = e || window.event;
    if (e.ctrlKey && (e.keyCode == 66 || e.charCode == 98))  {
        insert("<b>","</b>",id,"text");
        d_key(e);
    } else if (e.ctrlKey && (e.keyCode == 73 || e.charCode == 105))  {
        insert("<i>","</i>",id,"text");
        d_key(e);
    } else if (e.ctrlKey && (e.keyCode == 85 || e.charCode == 117))  {
        insert("<u>","</u>",id,"text");
        d_key(e);
    } else if (e.keyCode==9) {
        insert("	","",id,"text");
        d_key(e);
    }
}
var com_ls=0;
function upd_com() {
    pid=post_id_com;
    num_com=0;
    com_ls=0;
    var xmlhttp = getXmlHttp();
    xmlhttp.open('GET', "ajax/r_get?last_com_id="+last_com_id+"&pid="+pid, true);
    var elements = document.getElementsByTagName("div");
    for(var i = 0;i < elements.length;i++){
        if(elements[i].className.indexOf("cntop") >= 0){
            elements[i].className="ctop";
        }
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState==4) {
            var resp=eval('('+xmlhttp.responseText+')');
            num_com=0;
            document.getElementById('ln_doe').innerHTML="&#8212;";
            for (i=0;i<=resp.num;i++) {
                if (!document.getElementById('cmnt'+resp.arr[i].id)) {
                    resp.arr[i].txt=resp.arr[i].txt.replace('twork.php?wt=ratecom','javascript:x_r("twork.php?wt=ratecom');
                    resp.arr[i].txt=resp.arr[i].txt.replace('from=','json=1","c")');
                    if (resp.arr[i].lvl>0) {
                        document.getElementById('cmadd'+resp.arr[i].cid).innerHTML+=resp.arr[i].txt;
                    } else {
                        document.getElementById('cmn').innerHTML+=resp.arr[i].txt;
                    }
                    com_arr[num_com]="#cmnt"+resp.arr[i].id;
                    num_com+=1;
                    num_come=num_com;
                    last_com_id=resp.arr[i].id;
                }
                if (num_com==0) {
                    num_come="&#8212;";
                }
                document.getElementById('ln_doe').innerHTML=num_come;
            }
        }
    };
    xmlhttp.send(null);
    document.getElementById("nocom").style.display="none";
}
function upd_ls() {
    if (com_ls<num_com) {
        document.location.hash=com_arr[com_ls];
        com_ls+=1;
        document.getElementById('ln_doe').innerHTML=(num_com-com_ls);
        if (num_com-com_ls==0) {
            document.getElementById('ln_doe').innerHTML="&#8212;";
        }
    } else {
        document.getElementById('ln_doe').innerHTML="&#8212;";
    }
}
function prw_com(txt,cid) {
    prw_id=cid;
    var xmlhttp = getXmlHttp();
    document.getElementById('cprv'+cid).display="block";
    xmlhttp.open('POST', "twork.php?wt=rtext", true);
    xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState==4) {
            document.getElementById('cprv'+cid).innerHTML="<h4>Предпросмотр  <a href='javascript:klcprv("+cid+")'>X</a></h4>"+xmlhttp.responseText;
            make_spoiler('cprv'+cid);
        }
    };
    xmlhttp.send("text="+encodeURIComponent(txt));
}
function klcprv(cid) {
    document.getElementById('cprv'+cid).innerHTML="";
    document.getElementById('cprv'+cid).display="none";
}

function set(what,prefix) {
    document.getElementById(prefix+'lang').value=what;
    document.getElementById(prefix+'area').innerHTML=null;
    length=0;
}
var active=-1;
function unhover_changer(prefix) {
    for (i=0;i<length;i++) {
        document.getElementById(prefix+'changer_'+i).style.backgroundColor="#ffffff";
    }
}
function changer(value,event,prefix) {
    event = event || window.event;
    if ((event.keyCode==40 || event.keyCode==38) && length!=0) {
        if (event.keyCode==40) {
            active++;
        } else {
            active--
        }
        if (active>=length) {
            active=0;
        } else if (active<0) {
            active=length-1;
        }
        unhover_changer(prefix);
        document.getElementById(prefix+'changer_'+active).style.backgroundColor="#B6B6B6";
    } else if (active!=-1 && length!=0 && (event.keyCode == 13 || event.keyCode == 10)) {
        document.getElementById(prefix+'lang').value=document.getElementById(prefix+'changer_'+active).innerHTML;
        document.getElementById(prefix+'area').innerHTML="";
        length=0;
    } else  if ((active==-1 || length==0) && (event.keyCode == 13 || event.keyCode == 10)) {
        return 1;
    } else if (value.length>0) {
        if (prefix=='code') {
            x_r('ajax/code/'+value,'ac');
        } else {
            x_r('ajax/tag/'+value,'ac');
        }
    } else {
        document.getElementById(prefix+'area').innerHTML="";
    }
    return 0;
}
function show_spoiler(node) {
    element =  getElementsByClassName('inner_spoiler',node.parentNode)[0];
    element.style.display = 'block';
    node.innerHTML='Скрыть';
    node.onclick = function () {
        hide_spoiler(this);
    };
}
function hide_spoiler(node) {
    element =  getElementsByClassName('inner_spoiler',node.parentNode)[0];
    element.style.display = 'none';
    node.innerHTML='Показать';
    node.onclick = function () {
        show_spoiler(this);
    };
}
var saved_form=new Array;
saved_form['text']='';
saved_form['tag']='';
saved_form['blog']='';
saved_form['title']='';
saved_form['lock']='';
saved_form['mng']='';
saved_form['nw']='<label id="an1"><input id="fst" type="text" name="an1"/><br/></label>\n\
<label id="an2"><input id="fst" type="text" name="an2"/><br/></label>\n\
<input type="hidden" id="len" name="len" value="2" />';
function merge_form(type,id) {
    form = document.getElementById(id);
    if (form.text) saved_form['text']=form.text.value;
    if (form.tag) saved_form['tag']=form.tag.value;
    if (form.blog) saved_form['blog']=form.blog.value;
    if (form.title) saved_form['title']=form.title.value;
    if (form.lock) saved_form['lock']=form.lock.value;
    if (form.mng) saved_form['mng']=form.lock.value;
    if (document.getElementById('nw')) saved_form['nw']=document.getElementById('nw').innerHTML;
    x_r('ajax/editor?type=new_post&tp='+type,'new_post');
}
function complite_form(id) {
    form = document.getElementById(id);
    if (form.text) form.text.value=saved_form['text'];
    if (form.tag) form.tag.value=saved_form['tag'];
    if (form.blog) form.blog.value=saved_form['blog'];
    if (form.title) form.title.value=saved_form['title'];
    if (form.lock) form.lock.value=saved_form['lock'];
    if (form.mng) form.mng.value=saved_form['mng'];
    if (document.getElementById('nw')) document.getElementById('nw').innerHTML=saved_form['nw'];
}
