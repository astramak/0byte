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
    global $native_presave,$presave_plugins;
    if ($native_presave) {
        $replace = array("'" => '&#39;', '"' => '&#34;', '<' => '&lt;', '>' => '&gt;');
        $text = str_replace(array_keys($replace), array_values($replace), $text);
        $text = preg_replace ("/\<quote\>(.*?)\<\/quote\>/is", '<div class="quote">$1</div>', nl2br($text));
    }
    if (@count($presave_plugins)>0) {
        foreach($presave_plugins as $plugin) {
            include('plugins/'.$plugin['name'].'/actions.php');
        }
    }
    return($text);
}
function utext($text) {
    global $native_presave,$presave_plugins;
    if ($native_presave) {
        $text=str_replace('<br />', '', $text);
        $replace = array('<' => '&lt;', '>' => '&gt;');
        $text = str_replace(array_values($replace), array_keys($replace), $text);
        $text = preg_replace ('/\<div class\="quote"\>(.*?)\<\/div\>/is','<quote>$1</quote>', $text);
    }
    if (@count($presave_plugins)>0) {
        foreach($presave_plugins as $plugin) {
            include('plugins/'.$plugin['name'].'/undo_actions.php');
        }
    }

    return($text);
}

class dtxt {
    var $short_text;
    var $full_text;
    /**
     *
     * @deprecated
     */
    var $o;
    /**
     *
     * @deprecated
     */
    var $t;

    function cut($text) {
        if (strpos($text, "[cut]")) {
            $parts = explode('[cut]', $text);
            trim_array($parts);
            $this->short_text = $parts[0];
            $this->full_text = implode('[cut]', $parts);
            // depricated
            $this->t = $parts[0];
            $this->o = implode('[cut]', $parts);
        } elseif (strpos($text, "[fcut]")) {
            $parts = explode('[fcut]', $text);
            trim_array($parts);
            $this->short_text = $parts[0];
            $this->full_text = $parts[1];
            // depricated
            $this->t = $parts[0];
            $this->o = $parts[1];
        } else {
            $this->short_text = $this->full_text = $text;
            // depricated
            $this->o = $this->t = $text;
        }
    }
}

function code($txt) {
    global $native_prerender,$prerender_plugins;

    if (count($prerender_plugins)>0) {
        foreach($prerender_plugins as $plugin) {
            include('plugins/'.$plugin['name'].'/actions.php');
        }
    }
    return $txt;
}
function inducing($num,$variants) {
    if (($num>1 && $num<=4) || ($num>20 && $num%10>1 && $num%10<=3) ) {
        return $variants[0];
    } else if (($num<20 && $num!=1) || ($num>20 && $num%10!=1)) {
            return $variants[1];
        } else return $variants[2];
}
/**
 * Prepare text to code tag
 * @param string $text
 * @return string
 */
function prepare_code($text) {
    $replace = array(  '\"' => '&#34;','"' => '&#34;', '<' => '&lt;', '>' => '&gt;',   "\'" => '&#39;',   "'" => '&#39;' );
    return str_replace(array_keys($replace), array_values($replace),$text);
}
?>