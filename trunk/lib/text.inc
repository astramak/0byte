<?php
/*
 *     This file is part of 0byte.
 *
 *  0byte is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 2 of the License.
 *
 *  0byte is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  See <http://www.gnu.org/licenses/>.
 *
 */
function gtext($text) {
	$text=str_replace("'", "&#39;", $text);
	$text=str_replace('"', "&#34;", $text);
	$text=str_replace('<', "&lt;", $text);
	$text=str_replace('>', "&gt;", $text);
	$bb[] = "#\[b\](.*?)\[/b\]#si";
	$html[] = "<b>\\1</b>";
	$bb[] = "#\[i\](.*?)\[/i\]#si";
	$html[] = "<i>\\1</i>";
	$bb[] = "#\[del\](.*?)\[/del\]#si";
	$html[] = "<del>\\1</del>";
	$bb[] = "#\[ins\](.*?)\[/ins\]#si";
	$html[] = "<ins>\\1</ins>";
	$bb[] = "#\[dl\](.*?)\[/dl\]#si";
	$html[] = "<dl>\\1</dl>";
	$bb[] = "#\[dd\](.*?)\[/dd\]#si";
	$html[] = "<dd>\\1</dd>";
	$bb[] = "#\[dt\](.*?)\[/dt\]#si";
	$html[] = "<dt>\\1</dt>";
	$bb[] = "#\[u\](.*?)\[/u\]#si";
	$html[] = "<u>\\1</u>";
	$bb[] = "#\[s\](.*?)\[/s\]#si";
	$html[] = "<s>\\1</s>";
	$bb[] = "#\[hr\]#si";
	$html[] = "<hr>";
	$bb[] = "#\[h3\](.*?)\[/h3\]#si";
	$html[] = "<h4>\\1</h4>";
	$bb[] = "#\[h2\](.*?)\[/h2\]#si";
	$html[] = "<h3>\\1</h3>";
	$bb[] = "#\[h1\](.*?)\[/h1\]#si";
	$html[] = "<h2>\\1</h2>";
	$bb[] = "/\[url\=(.*?)\](.*?)\[\/url\]/is";
	$html[] = '<a href="$1">$2</a>';
	$bb[] = "/\[url\](.*?)\[\/url\]/is";
	$html[] = '<a href="$1">$1</a>';
	$bb[] = "/\[img\=(.*?)\](.*?)\[\/img\]/is";
	$html[] = '<img src="$2" alt="$1" />';
	$bb[] = "/\[img\](.*?)\[\/img\]/is";
	$html[] = '<img src="$1" />';
	$bb[] = "/\[color:(.*?)\](.*?)\[\/color\]/is";
	$html[] = '<span style="color: $1">$2</span>';
	$bb[] = "/\[size:(.*?)\](.*?)\[\/size\]/is";
	$html[] = '<span style="font-size: $1px">$2</span>';
	$bb[] = "/\[right\](.*?)\[\/right\]/is";
	$html[] = '<div style="float: right">$1</div>';
	$bb[] = "/\[left\](.*?)\[\/left\]/is";
	$html[] = '<div style="float: left">$1</div>';
	$bb[] = "/\[table\](.*?)\[\/table\]/is";
	$html[] = '<table>$1</table>';
	$bb[] = "/\<table\>(.*?)\[tr\](.*?)\[\/tr\]/is";
	$html[] = '<table>$1<tr>$2</tr>';
	$bb[] = "/\[tr\](.*?)\[\/tr\]/is";
	$html[] = '<tr>$1</tr>';
	$bb[] = "/\<tr\>(.*?)\[td\](.*?)\[\/td\]/is";
	$html[] = '<tr>$1<td>$2</td>';
	$bb[] = "/\[td\](.*?)\[\/td\]/is";
	$html[] = '<td>$1</td>';
	$bb[] = "/\<tr\>(.*?)\[th\](.*?)\[\/th\]/is";
	$html[] = '<tr>$1<th>$2</th>';
	$bb[] = "/\<\/th\>(.*?)\[th\](.*?)\[\/th\]/is";
	$html[] = '</th>$1<th>$2</th>';
	$bb[] = "/\[ul\](.*?)\[\/ul\]/is";
	$html[] = '<ul>$1</ul>';
	$bb[] = "/\<ul\>(.*?)\[li\](.*?)\[\/li\]/is";
	$html[] = '<ul>$1<li>$2</li>';
	$bb[] = "/\[ol\](.*?)\[\/ol\]/is";
	$html[] = '<ol>$1</ol>';
	$bb[] = "/\<ol\>(.*?)\[li\](.*?)\[\/li\]/is";
	$html[] = '<ol>$1<li>$2</li>';
	$bb[] = "/\[li\](.*?)\[\/li\]/is";
	$html[] = '<li>$1</li>';
	$bb[] = "/\[pre\](.*?)\[\/pre\]/is";
	$html[] = '<pre>$1</pre>';
	$bb[] = "/\[quote\](.*?)\[\/quote\]/is";
	$html[] = '<div class="quote">$1</div>';
	$bb[] = "/\[flash\](.*?)\[\/flash\]/is";
	$html[] = '<embed src="$1" />';
	$bb[] = '/\<a href\="( *)javascript(.*?)"/is';
	$html[] = '<a href="$1жаваскрипт$2"';
	$bb[] = "/\[flash w\=(.*?) h\=(.*?)\](.*?)\[\/flash\]/is";
	$html[] = '<embed src="$3" width="$1" height="$2" />';
	$bb[] = "/\<ul\>([^\>]*?)\<br \/\>/is";
	$html[] = '<ul>$1';
	$bb[] = "/\<\/ul\>([^\>]*?)\<br \/\>/is";
	$html[] = '</ul>$1';
	$bb[] = "/\<br \/>([^\>]*?)\<ul\>/is";
	$html[] = '$1<ul>';
	$bb[] = "/\<br \/\>([^\>]*?)\<\/ul\>/is";
	$html[] = '$1</ul>';
	$bb[] = "/\<br \/>([^\>]*?)\<li\>/is";
	$html[] = '$1<li>';
	$bb[] = '/\<a href\=\"(.*?)\"\>\<\/a\>/is';
	$html[] = '<a href="$1">$1</a>';
	$text = preg_replace ($bb, $html, nl2br($text));

	return($text);
}
function utext($text) {
	$text=str_replace( "&lt;",'<', $text);
	$text=str_replace("&gt;",'>',  $text);
	$text=str_replace("<br />",'',  $text);
	$bb[] = "#\<b\>(.*?)\</b\>#si";
	$html[] = "[b]\\1[/b]";
	$bb[] = "#\<i\>(.*?)\</i\>#si";
	$html[] = "[i]\\1[/i]";
	$bb[] = "#\<del\>(.*?)\</del\>#si";
	$html[] = "[del]\\1[/del]";
	$bb[] = "#\<ins\>(.*?)\</ins\>#si";
	$html[] = "[ins]\\1[/ins]";
	$bb[] = "#\<dl\>(.*?)\</dl\>#si";
	$html[] = "[dl]\\1[/dl]";
	$bb[] = "#\<dd\>(.*?)\</dd\>#si";
	$html[] = "[dd]\\1[/dd]";
	$bb[] = "#\<dt\>(.*?)\</dt\>#si";
	$html[] = "[dt]\\1[/dt]";
	$bb[] = "#\<u\>(.*?)\</u\>#si";
	$html[] = "[u]\\1[/u]";
	$bb[] = "#\<s\>(.*?)\</s\>#si";
	$html[] = "[s]\\1[/s]";
	$bb[] = "#\<hr\>#si";
	$html[] = "[hr]";
	$bb[] = "#\<h2\>(.*?)\</h2\>#si";
	$html[] = "[h1]\\1[/h1]";
	$bb[] = "#\<h3\>(.*?)\</h3\>#si";
	$html[] = "[h2]\\1[/h2]";
	$bb[] = "#\<h4\>(.*?)\</h4\>#si";
	$html[] = "[h3]\\1[/h3]";
	$bb[] = '/\<a href\="(.*?)"\>(.*?)\<\/a\>/is';
	$html[] = '[url=$1]$2[/url]';
	$bb[] = '/\<img src\="(.*?)"\ alt\="(.*?)" \/\>/is';
	$html[] = '[img=$2]$1[/img]';
	$bb[] = '/\<img src\="(.*?)"\ \/\>/is';
	$html[] = '[img]$1[/img]';
	$bb[] = '/\<span style\="color: (.*?)"\>(.*?)\<\/span\>/is';
	$html[] = '[color:$1]$2[/color]';
	$bb[] = '/\<span style\="font-size: (.*?)px"\>(.*?)\<\/span\>/is';
	$html[] = '[size:$1]$2[/size]';
	$bb[] = '/\<div style\="float: right"\>(.*?)\<\/div\>/is';
	$html[] = '[right]$1[/right]';
	$bb[] = '/\<div style\="float: left"\>(.*?)\<\/div\>/is';
	$html[] = '[left]$1[/left]';
	$bb[] = '/\<table\>(.*?)\<\/table\>/is';
	$html[] = '[table]$1[/table]';
	$bb[] = '/\<tr\>(.*?)\<\/tr\>/is';
	$html[] = '[tr]$1[/tr]';
	$bb[] = '/\<td\>(.*?)\<\/td\>/is';
	$html[] = '[td]$1[/td]';
	$bb[] = '/\<th\>(.*?)\<\/th\>/is';
	$html[] = '[th]$1[/th]';
	$bb[] = '/\<ul\>(.*?)\<\/ul\>/is';
	$html[] = '[ul]$1[/ul]';
	$bb[] = '/\<li\>(.*?)\<\/li\>/is';
	$html[] = '[li]$1[/li]';
	$bb[] = '/\<ol\>(.*?)\<\/ol\>/is';
	$html[] = '[ol]$1[/ol]';
	$bb[] = '/\<pre\>(.*?)\<\/pre\>/is';
	$html[] = '[pre]$1[/pre]';
	$bb[] = '/\<div class\="quote"\>(.*?)\<\/div\>/is';
	$html[] = '[quote]$1[/quote]';
	$bb[] = '/\<embed src\="(.*?)" width\="(.*?)" height\="(.*?)" \/\>/is';
	$html[] = '[flash w=$2 h=$3]$1[/flash]';
	$bb[] = '/\<embed src\="(.*?)" \/\>/is';
	$html[] = '[flash]$1[/flash]';
	$text = preg_replace ($bb, $html, $text);
	return($text);
}
class dtxt {
	var $o;
	var $t;

	function cut($a) {
		if (strpos($a,"[cut]")) {
			$t="/(.*?)\[cut\]/is";
			preg_match($t,$a,$txt);
			$t="/(.*?)\[cut\](.*?)/is";
			$q="$1[cut]$2";
			$this->t=$txt[0];
			$this->o=preg_replace($t,$q,$a);
		} else if (strpos($a,"[fcut]")) {
			$t="/(.*?)\[fcut\]/is";
			preg_match($t,$a,$txt);
			$this->t=$txt[0];
			$this->o=substr($a,strlen($txt[0]));
		} else {
			$this->o=$a; $this->t=$a;
		}
	}
}

function code($txt) {
	$txt=str_replace("[code]","[code=]",$txt);
	preg_match_all("/\[code\=(.*?)\]/is",$txt,$lang);
	$arr=preg_split("/\[(.?)code(.*?)\]/",$txt);
	$q=1;
	$txt="";
	foreach ($arr as $i) {
		if ($q%2==0) {
			$i=str_replace("<br />","",$i);
			$i=str_replace("&lt;", '<',$i);
			$i=str_replace("&gt;", '>',$i);
			$i=str_replace("&#39;","'",$i);
			$i=str_replace("&#34;", '"',$i);
			$lang[$q/2 -1]=preg_replace("/\[code\=(.*?)\]/is","$1",$lang[$q/2 -1]);
			$i=geshi_highlight($i,$lang[0][$q/2 -1],null,true);
			$i=str_replace("<code>", '',$i);
			$i=str_replace("</code>", '',$i);
			$cnt=substr_count($i,"<br />");
			$ln="";
			if ($cnt!=0) {
				for ($e=2;$e<=($cnt+1);$e++) {
					$ln.=$e."<br />";
				}
				$i='<table><tr><td class="ln">1<br />'.$ln.'</td><td class="code" lang="'.$lang[0][$q/2 -1].'">'.$i.'</td></tr></table>';
			} else {
				$i='<div class="code" lang="'.$lang[0][$q/2 -1].'">'.$i.'</div>';
			}
		}
		$txt.=$i;
		$q++;
	}
	$txt=str_replace("<a href","<a rel='nofollow' href",  $txt);
	return($txt);
}
?>