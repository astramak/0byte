<h2>Полный список городов</h2>
<div id="map_canvas" style="width:640px; height:320px;"></div><br />
<table id="users">
   <tr><td class='mettm'><?php echo $fst; ?></td><td class='mettm'><?php echo $scn; ?></td></tr>
    <?php foreach ($elements as $element) { ?>
  <tr> <td class='ulp'><a href='list/user/city/<?php echo $element['name']; ?>'><?php echo $element['name']; ?></a></td>
            <td class='lrte'><?php echo $element['cnt']; ?></td> </tr>
    <?php } ?>
</table>
<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAAq54shBqWZuPxx6GprepxwRTqd41vcF2VE2ddc7UQSKTm2eikrRSkesAkf1xTgiBwL0mexmXNtp44KQ&lang=ru" type="text/javascript"></script>
<?php
$fnc='var map = new GMap2(document.getElementById("map_canvas"), { size: new GSize(640,320) });
var geocoder = new GClientGeocoder();
   var customUI = map.getDefaultUI();
        // Remove MapType.G_HYBRID_MAP
        customUI.maptypes.hybrid = false;
        map.setUI(customUI);
        map.setCenter(new GLatLng(55.0, 82.0), 2);

function ar(address,cnt) {
  geocoder.getLatLng(
    address,
    function(point) {
    function createMarker(point) {
              var marker = new GMarker(point);
              GEvent.addListener(marker, "click", function() {
                  marker.openInfoWindowHtml(marker.text);
                    });
              return marker;
                }

        var marker = new createMarker(point);
        marker.text="<html><body><br /><b>"+address+" — "+cnt+"</b></body></html>";
        map.addOverlay(marker);
    }
  );
}';
foreach ($elements as $element) { 
$fnc.=" ar('".$element['name']."','".$element['cnt']."'); \n";
}
echo '<script>'.$fnc.'</script>';
?>