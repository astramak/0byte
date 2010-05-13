<?php
$lst = "worked.php?wt=myblog";
if (!isset($_FILES['img'])) {
    redirect($lst);
}

$bid = request::get_get('bid');
$sz = getimagesize($_FILES['img']['tmp_name']);
// TODO: replace all "magic numbers" with variables and add error messages
if (strncmp($_FILES['img']['type'], "image", 5) == 0 && $sz[0] <= 70 && $sz[1] <= 70 && $_FILES['img']['size'] < 400000 ) {
    $uploaddir = "tmp/bl/";
    $result = db_query('SELECT * FROM blogs WHERE id = %d', $bid);
    $row = db_fetch_assoc($result);
    $filename = "tmp/bl/" . $row['av'];
    if (is_file($filename)) unlink($filename);

    $filename = 'blog_av_' . $bid . '.' . substr($_FILES['img']['type'], 6);
    move_uploaded_file($_FILES['img']['tmp_name'], $uploaddir . $filename);
    db_query('UPDATE blogs SET av = %s WHERE id = %d', $filename, $bid);
}
redirect($lst);
?>