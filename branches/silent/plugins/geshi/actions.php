<?php

$txt = str_replace("[code]", '[code=]', $txt);
preg_match_all('/\[code([^\]]*?)\]/is',$txt, $lang);
$arr = preg_split("/\[(.?)code(.*?)\]/",$txt);
$q = 1;
$txt = "";
$replace = array('<br />' => "\n", '&lt;' => '<', '&gt;' => '>', '&#39;' => "'", '&#34;' => '"','&amp;'=>'&');
foreach ($arr as $i) {
    
    if ($q % 2 == 0) {
      
        require_once 'lib/geshi/geshi.php';
        $i = str_replace(array_keys($replace), array_values($replace), $i);
        $lang[$q / 2 - 1] = preg_replace('/\[code\=(.*?)\]/is', "$1", $lang[$q / 2 - 1]);
        $i = geshi_highlight($i, $lang[0][$q / 2 - 1], null, true);
        $i = str_replace(array('[code', '[/code]'), '', $i);
        $cnt = substr_count($i, "<br />");
        $ln = "";
        if ($cnt != 0) {
            for ($e = 2; $e <= ($cnt+1); $e++) {
                $ln .= $e . "<br />";
            }
            $i = render_util('code_lines', array('lang' => $lang[0][$q / 2 - 1], 'code' => $i, 'lines' => $ln));
        } else {
            $i = render_util('code_utils', array('lang' => $lang[0][$q / 2 - 1], 'code' => $i));
        }
    }
    $txt .= $i;
    $q++;
}

$txt = str_replace("<a href", "<a rel='nofollow' href", $txt);
$text=$txt;
?>
