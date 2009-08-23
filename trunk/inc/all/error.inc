<?php
$error=request::get_get('err');
switch ($error) {
    case "new_blog_used":
        echo render_error("Блог с таким названием уже существует!");
        break;
    case "not_allow":
        echo render_error("У вас недостаточно прав для совершения этого действия!");
}
?>
