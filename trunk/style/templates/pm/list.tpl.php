<?php if ($num==0) {?>
    <span id='nocom'>Сообщений нет</span>
<?php } else { ?>
<table id='users'><tbody>
    <?php foreach ($pms as $pm) {?>
    <tr <?php echo $pm['class']; ?> id='pm<?php echo $pm['id']; ?>'><td class='avl'>
    <?php if ($pm['avatar']){ ?>
    }
<img class='cauth' src='<?php echo $pm['av_url']; ?>' alt='' />
    <?php } else {?>
    <img class="cnoauth" src="style/img/figure.gif" />
    <?php } ?>
</td>
			<td class='pmn'><a href='user/<?php echo $pm['usr']; ?>'><?php echo $pm['usr']; ?></a></td>
			<td><a href='work/pmread/<?php echo $pm['id']; ?>'
			><?php echo $pm['title']; ?></a></td><td class='pmcl'><a<?php echo $pm['killer']; ?>>[X]</a></td></tr>
<?php } ?>
</tbody></table>
<?php } ?>