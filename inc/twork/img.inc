<?php
$lst="worked.php?wt=edituser&err=1";
if (!isset($_FILES['img'])) {
    redirect($lst);
}
$sz = getimagesize($_FILES['img']['tmp_name']);
if (strncmp($_FILES['img']['type'],"image",5)==0 && $sz[0]<=70 && $sz[1]<=70
    && $_FILES['img']['size']<400000 ) {
//    $sql_get="SELECT * FROM `users` WHERE name = '".$usr->login."'   ";
//    $result=mysql_query($sql_get,$sql);
    $row = db_fetch_assoc(db_query("SELECT * FROM `users` WHERE name =  %s",$usr->login));
    unlink("tmp/av/".$row['av']);
    $uploaddir = "tmp/av/";
    move_uploaded_file($_FILES['img']['tmp_name'],$uploaddir.$usr->login.time().".".substr($_FILES['img']['type'],6));
    $lst="users.php";
//    $sqlg="UPDATE `users` SET `av` = '".$usr->login.time().".".substr($_FILES['img']['type'],6)."' WHERE `users`.`name` ='"
//        .$usr->login."'";
//    $resul=mysql_query($sqlg,$sql);
    db_query("UPDATE `users` SET `av` = %s WHERE `users`.`name` = %s",
    $usr->login.time().'.'.substr($_FILES['img']['type'],6),$usr->login);
    redirect($lst);
} else {
    redirect($lst);
}
?>