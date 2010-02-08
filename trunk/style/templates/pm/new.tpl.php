<span class="title">Написание личного соообщения</span>

<form name='pm' id='pm' method="post" action="twork.php?wt=pmnew">

	
	<input type="text" class="post-pm" name="to" value="<?php echo @$name; ?>" /><span class="grey"> - получатель</span><br>

    <input type="text" id="pm_title" class="post-pm" name="title" value="<?php echo @$title; ?>" /><span class="grey"> - заголовок</span>
	

	<div id="rd" class='inpt'></div>
	<textarea onkeypress="do_key(this.form,'pm',event);"
			onkeydown="if('\v'=='v') {do_key(this.form,'pm',event);}" name="text"
			rows="15" cols="70"></textarea>
<br />
<input type="submit" class="tag_w6" value="Отправить!" /></form>