</td>
</tr>
</tbody>
</table>
</div>
<div class='mf' id='btmf'>
<div class='amenuel'><a href="<?php echo $site; ?>"><?php echo $sl_name; ?></a></div>
<div class='menuel'><a href="all/ar">Правила</a></div>
<div class='menuel'><a href="all/act">Цели и задачи</a></div> 
<div class='menuel'><a href="all/help">Справка</a></div>
<div class='menuel'><a href="all/features">Плюшки</a></div>
<div class='menuel'><a href="all/friends">Друзья</a></div>

</div>
<?php echo $SCRIPT;
$end_time = microtime(); 
echo "<!-- time: " . round ($end_time - $start_time, 3) . "-->";
?>
</body>
</html>