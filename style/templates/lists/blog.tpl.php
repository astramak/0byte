<h2>Блоги</h2>
<table id='users'>
    <tr>
        <td></td><td class='mettm'><?php echo $fst; ?></td><td class='mettm'><?php echo $scn; ?></td>
    </tr>
    <?php foreach ($elements as $element) { ?>
    <tr>
        <td class='avl'><?php echo $element['av']; ?></td>
        <td class='ulp'><?php if ($edit) {?>
            <a href="work/editblog/<?php echo $element['id']; ?>"><img src='style/n_img/edit.png' alt='Редактировать' /></a>
            <?php } ?>
            <a href='blog/<?php echo $element['id']; ?>'><?php echo $element['name']; ?></a></td>

        <td class='lrte'>
            <?php if ($element['rate']>0) { ?>
                <span class='rp'><?php echo $element['rate']; ?></span>
            <?php } else if ($element['rate']<0) { ?>
                <span class='rm'><?php echo $element['rate']; ?></span>
            <?php } else echo 0;  ?>
        </td>
    </tr>
    <?php } ?>
</table>