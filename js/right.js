var fl_p=0; var fl_c=0; var fl_e=0;
var fl_pid=0; var fl_cid=0;
var fl_u=0; var fl_b=0;
var xy=document.getElementById("alist");
function kill_all() {
    document.getElementById('cf').style.display="none";
    document.getElementById('af').style.display="none";
    document.getElementById('ef').style.display="none";
    document.getElementById('pf').style.display="none";
    document.getElementById('df').style.display="none";
    document.getElementById('ff').style.display="none";
}
function g_plist(tp) {
    var xmlhttp = getXmlHttp();
    if (tp=='post' || tp=='pst') {
        tp='post';
        ttp='pst=1';
        if (fl_p==0) {
            tt="&lm=16";
            fl_p=1;
            nw=1;
        } else {
            tt='&aft='+fl_pid;
            nw=0;
        }
        wh=document.getElementById('plist');
        kill_all();
        document.getElementById('pf').style.display="table-row";
    } else if (tp=='com') {
        ttp='com=1';
        if (fl_c==0) {
            tt="&lm=16";
            fl_c=1;
            nw=1;
        } else {
            tt='&aft='+fl_cid;
            nw=0;
        }
        wh=document.getElementById('clist');
        kill_all();
        document.getElementById('cf').style.display="table-row";
    } else if (tp=='top_user') {
        ttp='top_user=1';
        tt="&lm=16";
        fl_u=0;
        nw=1;
        document.getElementById("bltop").style.display="none";
        document.getElementById("ustop").style.display="table-row";
        document.getElementById("shuser").style.display="block";
        wh=document.getElementById("ulister");
        wh.innerHTML="";
    } else if (tp=='top_blog') {
        ttp='top_blog=1';
        tt='&lm=16';
        nw=1;
        document.getElementById("bltop").style.display="table-row";
        document.getElementById("ustop").style.display="none";
        document.getElementById("shblog").style.display="block";
        document.getElementById("shall").style.display="none";
        wh=document.getElementById("blist");
        wh.innerHTML="";
    } else if (tp=='eye') {
        ttp='eye=1';
        if (fl_e==0) {
            tt="&lm=16";
            fl_e=1;
            nw=1;
        } else {
            tt='&no';
            nw=0;
        }
        wh=document.getElementById('eblist');
        kill_all();
        document.getElementById('ef').style.display="table-row";
    } else if (tp=='draft') {
        ttp='draft=1';
        tt="&lm=16";
        nw=1;
        wh=document.getElementById('drlist');
        kill_all();
        document.getElementById('df').style.display="table-row";
        wh.innerHTML="";
    } else if (tp=='favourite') {
        nw=1;
        tt="&lm=16";
        ttp='favourite=1';
        wh=document.getElementById('fvlist');
        kill_all();
        document.getElementById('ff').style.display="table-row";
        wh.innerHTML="";
    }
    xmlhttp.open('GET', "ajax/r_get?"+ttp+tt, true);
    var atr="";
    if (arguments[1]==1) {
        atr="g_plist('"+arguments[2]+"')";
    }
	
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4) {
            var resp=eval('('+xmlhttp.responseText+')');
     
            for (i=0;i<=resp.num-1;i++) {
                rt="";
                ln="";
                if (resp.arr[i].rate>0) {
                    rt="<span class='scb'>(<span class='rp'>"+resp.arr[i].rate+"</span>)</span>";
                } else if (resp.arr[i].rate<0) {
                    rt="<span class='scb'>(<span class='rm'>"+resp.arr[i].rate+"</span>)</span>";
                }
                if (tp=="com") {
                    if (resp.arr[i].id>fl_cid){
                        fl_cid=resp.arr[i].id;
                    }
                    what='<li class="celis"><a href="user/'+resp.arr[i].who+'/">'+resp.arr[i].who+'</a> &#8212; &laquo;<a href="post/'+resp.arr[i].wid+'/#cmnt'+resp.arr[i].id+'">'+resp.arr[i].blg+' / '+resp.arr[i].where+'</a>&raquo; '+rt+'</li>';
                } else if (tp=='post' || tp=='favourite'){
                    if (resp.arr[i].id>fl_pid && tp!='favourite') {
                        fl_pid=resp.arr[i].id;
                    }
                    what='<li class="pelis"><a href="'+escape(resp.arr[i].url)+'">'+resp.arr[i].who+'</a> &#8212; &laquo;<a href="post/'+resp.arr[i].id+'/">'+resp.arr[i].title+'</a>&raquo; '+rt+'</li>';
                } else if (tp=='top_user') {
                    what='<li><a href="user/'+resp.arr[i].name+'/">'+resp.arr[i].name+'</a> '+rt+'</li>';
                } else if (tp=='top_blog') {
                    what='<li><a href="blog/'+resp.arr[i].id+'/">'+resp.arr[i].name+'</a> '+rt+'</li>';
                } else if (tp=='eye') {
                    what='<li><a href="'+escape(resp.arr[i].url)+'">'+resp.arr[i].who+'</a> &#8212; &laquo;<a href="post/'+resp.arr[i].id+'/">'+resp.arr[i].title+'</a>&raquo;</li>';
                } else if (tp=='draft') {
                    what='<li><a href="'+escape(resp.arr[i].url)+'">'+escape(resp.arr[i].title)+'</a></li>';
                }
                if (nw==0) {
                    xy.innerHTML=what+xy.innerHTML;
                    wh.innerHTML=what+wh.innerHTML;
                } else {
                    wh.innerHTML+=what;
                }
            }
            eval(atr);
		
        }
    };
    xmlhttp.send(null);
}
function hplist() {
    _touch('ajax/r_get?noo=1');
    kill_all();
    document.getElementById('af').style.display="table-row";
}
function hgptop() {
    _touch('ajax/r_get?noo=2');
    document.getElementById("ulister").innerHTML=ulist;
    document.getElementById("blist").innerHTML=blist;
    document.getElementById("bltop").style.display="table-row";
    document.getElementById("ustop").style.display="table-row";
    document.getElementById("shblog").style.display="none";
    document.getElementById("shuser").style.display="none";
    document.getElementById("shall").style.display="block";
}