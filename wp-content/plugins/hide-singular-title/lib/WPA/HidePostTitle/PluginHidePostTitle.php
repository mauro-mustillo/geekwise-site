<?php
namespace WPA\HidePostTitle;

/**
 *
 * @author MyMiniapp.com
 * @version 1.0.2
 */
final class PluginHidePostTitle extends \WPAutoloader\Abstracts\Plugin {

    const id = 'plghidetitle';

    const filter_the_title = 'WPA\HidePostTitle\TitleFilter::TheTitle';

    const css_fallback_file = 'css-fallback.css';

    const css_id_search = 'post-id-goes-here';

    const uri_of_fallback_css_editor = 'plugin-editor.php?file=wp-hide-singular-title%2Fcss-fallback.css&plugin=wp-hide-singular-title%2Fcss-fallback.css';

    const default_dir = 'wp-hide-singular-title';

    /**
     * Plugin version
     * 
     * @var string
     */
    const version = '1.0.2';

    /**
     * Id of text domain for language
     * 
     * @var string
     */
    const txtdomain = self::id;
    
    /*
     * (non-PHPdoc)
     * @see \WPAutoloader\Abstracts\Plugin::init()
     * @since 1.0.0
     */
    protected function init () {
        global $pagenow;
        
        // Get plugin
        $plugin = self::getInstance();
        
        // Add extra links on plugins page
        self::AddPluginMetaRowItem( __( 'Documentation', self::id ), self::GetUri( '/inc/docs/' ) );
        self::AddPluginActionItem( __( 'Settings', self::id ), admin_url( 'options-reading.php' ) );
        self::AddPluginActionItem( __( 'CSS' ), PluginHidePostTitle::GetFallBackCSSEditorAdminLink() );
        
        // Add admin style sheet
        if ( $pagenow == 'edit.php' || $pagenow == 'post-new.php' || $pagenow == 'post.php' || $pagenow == 'options-reading.php' ) {
            self::AddStyleSheet( 'plghidetitle-admin', self::GetUri( '/inc/style/plghidetitle-admin.css' ), null, self::version, 'all', 2 );
        }
        
        // Register shortcode
        add_shortcode( 'the_title', 'WPA\HidePostTitle\ShortCodes::TheTitle' );
    }

    /**
     * Loads language
     */
    public static function LoadTextDomain () {
        load_plugin_textdomain( self::id, false, self::GetBase( 'languages/' ) );
    }

    /**
     * Adds CSS file into header
     */
    public static function AddCSSFallBackHeader () {
        $post_id = get_the_ID();
        if ( is_singular() && (int) get_option( 'hide_all_singular_titles_css', 0 ) && $post_id > 0 ) {
            if ( \WPA\HidePostTitle\Settings\Options::HidePostTitle( $post_id ) ) {
                $css_file = self::GetDir( PluginHidePostTitle::css_fallback_file );
                if ( file_exists( $css_file ) ) {
                    $ajax_uri = admin_url( 'admin-ajax.php?action=hidesingularcssfallback&p=' . $post_id );
                    self::AddStyleSheet( 'hidesingularcssfallback', $ajax_uri );
                    do_action( 'init' );
                    do_action( 'wp_enqueue_style' );
                }
            }
        }
    }

    public static function OnActionInit () {
        // Hook MetaBox
        MetaBox::Hook();
        //
        add_filter( 'the_title', self::filter_the_title, 10, 2 );
        //
        if ( (int) get_option( 'hide_all_singular_titles_css', 0 ) ) {
            \WPA\HidePostTitle\PluginHidePostTitle::AddCSSFallBackHeader();
            add_action( 'wp_ajax_hidesingularcssfallback', 'WPA\HidePostTitle\PluginHidePostTitle::AjaxResponseCSSFallback' );
            add_action( 'wp_ajax_nopriv_hidesingularcssfallback', 'WPA\HidePostTitle\PluginHidePostTitle::AjaxResponseCSSFallback' );
        }
    }

    public static function OnActionAdminInit () {
        \WPA\HidePostTitle\Settings\Reading::Hook();
    }

    /**
     * Add related actions and filters
     */
    public static function AddActionsAndFilters () {
        
        // Hook MetaBox
        MetaBox::Hook();
        
        add_filter( 'the_title', self::filter_the_title, 10, 2 );
        
        // Hook Reading Settings
        if ( is_admin() ) {
            add_action( 'admin_init', 'WPA\HidePostTitle\Settings\Reading::Hook' );
        }
        
        // CSS Fallback
        if ( (int) get_option( 'hide_all_singular_titles_css', 0 ) ) {
            add_action( 'wp_ajax_hidesingularcssfallback', 'WPA\HidePostTitle\PluginHidePostTitle::AjaxResponseCSSFallback' );
            add_action( 'wp_ajax_nopriv_hidesingularcssfallback', 'WPA\HidePostTitle\PluginHidePostTitle::AjaxResponseCSSFallback' );
            add_action( 'wp', 'WPA\HidePostTitle\PluginHidePostTitle::AddCSSFallBackHeader', 45 );
        }
    }

    /**
     * Response for CSS Fallback AJAX call
     * 
     * @since 1.0.0
     */
    public static function AjaxResponseCSSFallback () {
        $post_id = 0;
        if ( isset( $_REQUEST['p'] ) ) {
            $p = abs( intval( $_REQUEST['p'] ) );
            $post_id = $p > 0 ? $p : $post_id;
        }
        $css = self::GetCSSFallbackCode( $post_id );
        header( "Content-type: text/css", true );
        echo $css;
        exit();
    }

    /**
     * Returns CSS Fallback code
     * 
     * @param int $post_id            
     * @return string
     * @since 1.0.0
     */
    protected static function GetCSSFallbackCode ( $post_id ) {
        $css = '';
        $css_file = PluginHidePostTitle::GetDir( self::css_fallback_file );
        if ( file_exists( $css_file ) ) {
            $css = file_get_contents( $css_file );
            $css = str_replace( self::css_id_search, $post_id, $css );
        }
        return $css;
    }

    /**
     * Get Admin Fallback CSS Editor links
     * 
     * @return string
     * @since 1.0.0
     */
    public static function GetFallBackCSSEditorAdminLink () {
        $uri = str_replace( self::default_dir, dirname( self::GetBase() ), self::uri_of_fallback_css_editor );
        $uri = str_replace( self::css_fallback_file, 'css-fallback.css', $uri );
        $uri = admin_url( $uri );
        return $uri;
    }

}

