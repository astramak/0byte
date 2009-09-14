<h2>Полный список городов</h2>
<table id="users">
   <tr><td class='mettm'><?php echo $fst; ?></td><td class='mettm'><?php echo $scn; ?></td></tr>
    <?php foreach ($elements as $element) { ?>
  <tr> <td class='ulp'><a href='list/user/city/<?php echo $element['name']; ?>'><?php echo $element['name']; ?></a></td>
            <td class='lrte'><?php echo $element['cnt']; ?></td> </tr>
    <?php } ?>
</table>
