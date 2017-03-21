<?php
/*
 * Plugin Name: Hide Singular Title
 * Plugin URI: http://myminiapp.com/wordpress-plugins/hide-singular-title/
 * Description: <strong>Hide Singular Title</strong> by MyMiniapp.com provides an easiest and most bulletproof solution to hide titles of singular pages and posts or even of any post type. Probably the best plugin available!.
 * Version: 1.0.2
 * Author: MyMiniapp.com
 * Author URI: http://myminiapp.com
 * License: GNU General Public License
 */
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Hide Singular Title for WordPress
//
/**
 * Output message about missing plugins
 */
function plg_hide_title_admin_notice_wpa_missing () {
    $wpa_install_uri = get_admin_url( null, '/plugin-install.php?tab=plugin-information&amp;plugin=wp-autoloader&amp;TB_iframe=true&amp;width=640&amp;height=546' );
    $msg[] = '<div class="updated"><p>';
    $msg[] = 'Plugin <strong>Hide Singular Title</strong> is not hooked!<br>';
    $msg[] = 'WordPress Autoloader plugin is required to use <strong>Hide Singular Title</strong> plugin.<br>';
    $msg[] = 'Please install and activate <a href="' . $wpa_install_uri . '" class="thickbox" title="More information about WP Autoloader">WordPress Autoloader</a> plugin first.';
    $msg[] = '</p></div>';
    echo implode( PHP_EOL, $msg );
}

/**
 * Output admin notice about PHP version
 */
function plg_hide_title_admin_notice_php_version () {
    $msg[] = '<div class="updated"><p>';
    $msg[] = 'Please upgarde PHP at least to version 5.3.0!<br>';
    $msg[] = 'Your current PHP version is <strong>' . PHP_VERSION . '</strong>, which is not suitable for plugin <strong>Hide Singular Title</strong>';
    $msg[] = '</p></div>';
    echo implode( PHP_EOL, $msg );
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Check PHP version
//
if ( version_compare( PHP_VERSION, '5.3.0' ) < 0 ) {
    add_action( 'admin_notices', 'plg_hide_title_admin_notice_php_version' );
    return;
}
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Hook TubePlus Premium
//
if ( ! class_exists( '\WPAutoloader\AutoLoad' ) ) {
    add_action( 'admin_notices', 'plg_hide_title_admin_notice_wpa_missing' );
    return;
} else {
    call_user_func( '\WPA\HidePostTitle\PluginHidePostTitle::Hook' );
}

