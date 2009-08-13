<h2>Пользователи</h2>
<table id='users'>
    <tr>
	<td></td><td class='mettm'><?php echo $fst; ?></td><td class='mettm'><?php echo $scn; ?></td>
    </tr>
    <?php foreach ($elements as $element) { ?>
        <tr>
            <td class='avl'><?php echo $element['av']; ?></td>
            <td class='ulp'><a href='user/<?php echo $element['name']; ?>'><?php echo $element['name']; ?></a></td>
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