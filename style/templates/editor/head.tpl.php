<a class='tdx' href='javascript:insert("[b]","[/b]","<?php echo $fr; ?>","text")'><b>Ж</b></a>
	 <a class='tdx' href='javascript:insert("[i]","[/i]","<?php echo $fr; ?>","text")'><i>К</i></a>
	 <a class='tdx' href='javascript:insert("[u]","[/u]","<?php echo $fr; ?>","text")'><u>Ч</u></a>
	 <a class='tdx' href='javascript:insert("[del]","[/del]","<?php echo $fr; ?>","text")'><del>П</del></a>
	 <a class='tdx' href='javascript:insert("[ins]","[/ins]","<?php echo $fr; ?>","text")'><ins>Д</ins></a>
	 <a class='tdx' href='javascript:insert("[left]","[/left]","<?php echo $fr; ?>","text")'>←</a>
	 <a class='tdx' href='javascript:insert("[right]","[/right]","<?php echo $fr; ?>","text")'>→</a>
	 <a class='tdx' href='javascript:list("<?php echo $fr; ?>","text")'>Список</a>
	 <a class='tdx' href='javascript:cr_d("<?php echo $fr; ?>","text")'>url</a>
	 <a class='tdx' href='javascript:img_d("<?php echo $fr; ?>","text")'>img</a>
	 <select onchange=" if (this.value!='1') {insert('[color:'+this.value+']','[/color]','<?php echo $fr; ?>','text');} this.value=0; ">
	 <option value='0' selected disabled>Цвет</option>
	 <option value='#000000' style='background-color: #000000; color:#ffffff;'>Чёрный</option>
	 <option value='#ffffff'style='background-color: #ffffff;'>Белый</option>
	 <option value='#ff0000' style='background-color: #ff0000; color:#ffffff;'>Красный</option>
	 <option value='#00ff00'style='background-color: #00ff00;'>Зелёный</option>
	 <option value='#0000ff' style='background-color: #0000ff; color:#ffffff;'>Синий</option>
	 <option value='1' onClick='clr("<?php echo $el; ?>","<?php echo $fr; ?>")' >Другой</option>
	 </select>
	 <select onchange="insert('[h'+this.value+']','[/h'+this.value+']','<?php echo $fr; ?>','text'); this.value=0;">
	 <option value='0' selected disabled>H1</option>
	 <option value='1'>H1</option>
	 <option value='2'>H2</option>
	 <option value='3'>H3</option>
	 </select>
	 <select onchange="insert('[size:'+this.value+']','[/size]','<?php echo $fr; ?>','text'); this.value=0;">"+
	 <option value='0' selected disabled>Размер</option>
	 <option value='8' style='font-size: 8px;'>8</option>
	 <option value='12' style='font-size: 12px;'>12</option>
	 <option value='16' style='font-size: 16px;'>16</option>
	 <option value='18' style='font-size: 18px;'>18</option>
	 <option value='22' style='font-size: 22px;'>22</option>
	 <option value='24' style='font-size: 24px;'>24</option>
	 <option value='36' style='font-size: 36px;'>36</option>
	 </select>
	 <a class='tdx' href='javascript:code_d("<?php echo $fr; ?>","text")'>code</a>
	 <a class='tdx' href='javascript:quote("<?php echo $fr; ?>","text")'>quote</a>