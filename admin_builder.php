<?php
/*
  Plugin Name: Admin Builder
  Plugin URI: http://admin-builder.com
  Description: A plugin that generates admin panel pages & posts,sidebars,custom admin pages with tabs, custom post types, rest routes, meta boxes and fields (with unlimited textbox, textarea, checkbox, custom select (dropdown box), datepicker, timepicker, colorpicker, upload media fields, with configurable options) Based on what's exported from http://admin-builder.com
  Version: 1.1.10
  Author: rootabout
  Author URI: http://admin-builder.com
  License: GPLv2 or later
  Text Domain: aB
 */
 require_once 'inc/abEnqueue.php';
 require_once 'inc/abCore.php';

function abLoadPluginFirst($plugin, $network_activation)
{
    // ensure path to this file is via main wp plugin path
   $wp_path_to_this_file = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR.'/$2', __FILE__);
    $this_plugin = plugin_basename(trim($wp_path_to_this_file));
    $active_plugins = get_option('active_plugins');
    $this_plugin_key = array_search($this_plugin, $active_plugins);
    if ($this_plugin_key) { // if it's 0 it's the first plugin already, no need to continue
       array_splice($active_plugins, $this_plugin_key, 1);
        array_unshift($active_plugins, $this_plugin);
        update_option('active_plugins', $active_plugins);
    }
}
add_action('activated_plugin', 'abLoadPluginFirst', 10, 2);
