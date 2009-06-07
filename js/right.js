var fl_p=0; var fl_c=0; var fl_e=0;
var fl_pid=0; var fl_cid=0;
var fl_u=0; var fl_b=0;
var xy=document.getElementById("alist");
function g_plist(tp) {
	var xmlhttp = getXmlHttp();
	if (tp=='post') {
		ttp='pst';
		if (fl_p==0) {
			tt="&lm=16";
			fl_p=1;
			nw=1;
		} else {
			tt='&aft='+fl_pid;
			nw=0;
		}
		wh=document.getElementById('plist');
		document.getElementById('cf').style.display="none";
		document.getElementById('af').style.display="none";
		document.getElementById('ef').style.display="none";
		document.getElementById('pf').style.display="table-row";
	} else if (tp=='com') {
		ttp='com';
		if (fl_c==0) {
			tt="&lm=16";
			fl_c=1;
			nw=1;
		} else {
			tt='&aft='+fl_cid;
			nw=0;
		}
		wh=document.getElementById('clist');
		document.getElementById('cf').style.display="table-row";
		document.getElementById('af').style.display="none";
		document.getElementById('ef').style.display="none";
		document.getElementById('pf').style.display="none";
	} else if (tp=='top_user') {
		ttp='top_user';
		tt="&lm=16";
		fl_u=0;
		nw=1;
		document.getElementById("bltop").style.display="none";
		document.getElementById("ustop").style.display="table-row";
		document.getElementById("shuser").style.display="block";
		wh=document.getElementById("ulister");
		wh.innerHTML="";
	} else if (tp=='top_blog') {
		ttp='top_blog';
		tt='&lm=16';
		nw=1;
		document.getElementById("bltop").style.display="table-row";
		document.getElementById("ustop").style.display="none";
		document.getElementById("shblog").style.display="block";
		document.getElementById("shall").style.display="none";
		wh=document.getElementById("blist");
		wh.innerHTML="";
	} else if (tp=='eye') {
		ttp='eye';
		if (fl_e==0) {
			tt="&lm=16";
			fl_e=1;
			nw=1;
		} else {
			tt='&no';
			nw=0;
		}
		wh=document.getElementById('eblist');
		document.getElementById('ef').style.display="table-row";
		document.getElementById('af').style.display="none";
		document.getElementById('cf').style.display="none";
		document.getElementById('pf').style.display="none";
	}
	xmlhttp.open('GET', "js/r_get.php?"+ttp+tt, true);
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
				} else if (tp=='post'){
					if (resp.arr[i].id>fl_pid) {
						fl_pid=resp.arr[i].id;
					}
					what='<li class="pelis"><a href="'+escape(resp.arr[i].url)+'">'+resp.arr[i].who+'</a> &#8212; &laquo;<a href="post/'+resp.arr[i].id+'/">'+resp.arr[i].title+'</a>&raquo; '+rt+'</li>';
				} else if (tp=='top_user') {
					what='<li><a href="user/'+resp.arr[i].name+'/">'+resp.arr[i].name+'</a> '+rt+'</li>';
				} else if (tp=='top_blog') {
					what='<li><a href="blog/'+resp.arr[i].id+'/">'+resp.arr[i].name+'</a> '+rt+'</li>';
				} else if (tp=='eye') {
					what='<li ><a href="'+escape(resp.arr[i].url)+'">'+resp.arr[i].who+'</a> &#8212; &laquo;<a href="post/'+resp.arr[i].id+'/">'+resp.arr[i].title+'</a>&raquo;</li>';
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
	_touch('js/r_get.php?noo=1');
	document.getElementById('pf').style.display="none";
	document.getElementById('cf').style.display="none";
	document.getElementById('ef').style.display="none";
	document.getElementById('af').style.display="table-row";	
}
function hgptop() {
	_touch('js/r_get.php?noo=2');
	document.getElementById("ulister").innerHTML=ulist;
	document.getElementById("blist").innerHTML=blist;
	document.getElementById("bltop").style.display="table-row";
	document.getElementById("ustop").style.display="table-row";
	document.getElementById("shblog").style.display="none";
	document.getElementById("shuser").style.display="none";
	document.getElementById("shall").style.display="block";
}