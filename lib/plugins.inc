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
$SCRIPT='<script type="text/javascript" src="js/js.php?js=main.js"></script>
		<script type="text/javascript" src="js/js.php?js=right.js"></script>
		<script type="text/javascript" src="js/js.php?js=login.js"></script>
		<script type="text/javascript" src="js/js.php?js=ve.js"></script>
		<script type="text/javascript" src="js/js.php?js=pm.js"></script>';
$native_script=1;
$native_presave=1;
$native_prerender=1;
/**
 * Echanga script plugin
 *
 * @global numeric $native_script
 * @global array $script_plugins
 * @param array $plugin
 */
function plugin_script($plugin) {
    global $native_script,$script_plugins;
    if (strcmp(@$plugin['conflict_type'],'full_script')==0) {
        $native_script=0;
    }
    $script_plugins[]=$plugin;
}
/**
 * Echange pre save plugin
 *
 * @global numeric $native_presave
 * @global array $presave_plugins
 * @param array $plugin
 */
function plugin_presave($plugin) {
    global $native_presave,$presave_plugins;
    if (strcmp(@$plugin['conflict_type'],'pre_save')==0) {
        $native_presave=0;
    }
    $presave_plugins[]=$plugin;
}
/**
 * Echange pre render plugin
 *
 * @global numeric $native_prerender
 * @global array $prerender_plugins
 * @param array $plugin
 */
function plugin_prerender($plugin) {
    global $native_prerender,$prerender_plugins;
    if (strcmp(@$plugin['conflict_type'],'pre_render')==0) {
        $native_prerender=0;
    }
    $prerender_plugins[]=$plugin;
}
/**
 * Initiale plugin by name
 *
 * @global array $block_plugins
 * @param string $name
 */
function init_plugin($name) {
    global $block_plugins,$lib_plugins,$notify_plugins;
    include('plugins/'.$name.'/plugin.php');
    $plugin['name']=$name;
    $plugin['type']=$type;
    //    echo $type
    $plugin['conflict_type']=$conflict_type;
    switch ($type) {
        case 'pre_render':
        //            echo 1;
            plugin_prerender($plugin);
            break;
        case 'pre_save':
            plugin_presave($plugin);
            break;
        case 'script':
            plugin_script($plugin);
            break;
        case 'block':
            $block_plugins[]=$plugin;
            break;
        case 'lib':
            $lib_plugins[]=$plugin;
            break;
        case 'notify':
            $notify_plugins[]=$plugin;
            break;
    }
}
/**
 * Parse plugin array and send it to initiale
 *
 * @param array $array
 */
function parse_plugin_array($array) {
    foreach ($array as $name=>$use) {
        if ($use==1) {
            init_plugin($name);
        }
    }
}
?>
