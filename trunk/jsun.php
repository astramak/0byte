<?php
/*
 *     This file is part of 0byte.
 *
 *  0byte is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 2 of the License.
 *
 *  0byte is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  See <http://www.gnu.org/licenses/>.
 *
 */
session_start();
setcookie(login);
setcookie(pwd);
session_unregister("login");
session_unregister("pwd");
session_destroy();
echo "<a class='lnk' id='lgin' href='javascript:login()'>Войти</a>   <a class='lnk' href='register.php'>Зарегистрироваться</a> ";
?>
<a class="lnk" href="worked.php?wt=help">Справка</a>
