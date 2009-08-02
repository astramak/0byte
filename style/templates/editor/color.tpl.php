<table><tr><td>
            <div id="ex" style="width: 50px; height: 50px; "></div></td><td>
            <form onsubmit="clr_s('<?php echo $fr; ?>','<?php echo $el; ?>'); return false;">
                <table><tr><td>Красный</td><td>
                            <input onClick="col('r',1)" type="button" value="+" />
                            <input onkeypress="setTimeout('mkcol()',100)" type="text" style="width: 40px;" name="r" value="0" />
                            <input onClick="col('r',0)" type="button" value="&ndash;" />
                        </td></tr><tr><td>Зелёный</td><td>
                            <input onClick="col('g',1)" type="button" value="+" />
                            <input onkeypress="setTimeout('mkcol()',100)" type="text" style="width: 40px;" name="g" value="0" />
                            <input onClick="col('g',0)" type="button" value="&ndash;" />
                        </td></tr><tr><td>Голубой</td><td>
                            <input onClick="col('b',1)" type="button" value="+" />
                            <input onkeypress="setTimeout('mkcol()',100)" type="text" style="width: 40px;" name="b" value="0" />
                            <input onClick="col('b',0)" type="button" value="&ndash;" />
                        </td></tr></table>
                <input type="submit" value="Выбрать" />
                <input type="button" value="Отмена" onClick="a_cr()" />
            </form> </td></tr></table><br />