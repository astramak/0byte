<?php if ($num==0) {?>
<span id='nocom'><br><i>Прямо сейчас сообщений тут нет!</i><br></span>
    <?php } else { ?>
<form method="post" action="twork.php?wt=pm_group_action">
    <label>Выделенное: </label><input type="submit" value="Удалить" name="delete" />
    <?php if ($type=='to') { ?><input type="submit" value="Пометить как прочитанное" name="mark" /><?php } ?>
    <input type="button" value="Выделить всё" onclick="select_all('users',true)" />
    <input type="button" value="Снять выделение"  onclick="select_all('users',false)" /><br />
<table id='users'><tbody>


            <?php foreach ($pms as $pm) {?>
        <tr <?php echo $pm['class']; ?> id='pm<?php echo $pm['id']; ?>'>
            <td class="select"><input type="checkbox" class="pm_check" name="pmc_<?php echo $pm['id']; ?>" id="pmc_<?php echo $pm['id']; ?>" /></td>
            <td class='avl'>
                        <?php if ($pm['avatar']) { ?>

                <img class='cauth' src='<?php echo $pm['av_url']; ?>' alt='' />
                            <?php } else {?>
                <img class="cnoauth" src="style/img/figure.gif" />
                            <?php } ?>
            </td>
            <td class='pmn'><a href='user/<?php echo $pm['usr']; ?>'><?php echo $pm['usr']; ?></a></td>
            <td><a href='work/pmread/<?php echo $pm['id']; ?>'>
                            <?php echo $pm['title']; ?></a></td><td class='pmcl'><a<?php echo $pm['killer']; ?>>[X]</a></td></tr>
                <?php } ?>
  
    </tbody></table>
    <input type="hidden" value="<?php echo $ids; ?>" name="ids" id="ids" />
    <input type="hidden" value="<?php echo $type; ?>" name="type" />
</form>
    <?php } ?>