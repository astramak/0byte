function pmdel(id) {
	document.getElementById('pm'+id).style.display="none";
	_touch("twork.php?wt=pmdel&json=1&id="+id);
}
