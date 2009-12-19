<h2>Пользователи<?php if ($city) { echo ":".$city; } ?></h2><?php if ($city) { ?>

<div id="map_canvas" style="width:640px; height:320px;"></div>

<br /><?php } ?>
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
<?php if ($city) { ?>
<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAAq54shBqWZuPxx6GprepxwRTqd41vcF2VE2ddc7UQSKTm2eikrRSkesAkf1xTgiBwL0mexmXNtp44KQ&lang=ru" type="text/javascript"></script>
<?php
  $fnc='var map = new GMap2(document.getElementById("map_canvas"), { size: new GSize(640,320) });
var geocoder = new GClientGeocoder();
   var customUI = map.getDefaultUI();
        // Remove MapType.G_HYBRID_MAP
        customUI.maptypes.hybrid = false;
        map.setUI(customUI);

function showAddress(address) {
  geocoder.getLatLng(
    address,
    function(point) {
        map.setCenter(point, 10);
        var marker = new GMarker(point);
        map.addOverlay(marker);
        marker.openInfoWindowHtml("<html><body><b>'.$city.'</b><br /><br />Отсюда '.count($elements).' '.inducing(count($elements), array('пользователя','пользователей','пользователь')).'.</body></html>");

    }
  );
}
showAddress("'.$city.'");';

echo '<script>'.$fnc.'</script>';
}
?>