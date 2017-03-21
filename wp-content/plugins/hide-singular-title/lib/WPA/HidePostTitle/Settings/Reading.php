<?php
namespace WPA\HidePostTitle\Settings;

use WPA\HidePostTitle\PluginHidePostTitle;
/** 
 * @author MyMiniapp.com
 * @version 1.0.0
 * @since 1.0.0
 */
final class Reading {

	/**
	 * Disable construct
	 * @access private
	 */
	private function __construct() {
		return null;
	}

	/**
	 * Show Style input field
	 * @since 1.0.0
	 */
	public static function Show() {

		$args = array(
				'public' => true
		);

		$mode = Options::GetHideMode();
		$checked [ 1 ] = ( $mode == 1 ) ? 'checked' : '';
		$checked [ 0 ] = ( $mode == 0 ) ? 'checked' : '';

		$inp [ ] = '<div id="hideallsingulartitlesettingsbox">';
		$inp [ ] = '<div>';
		$inp [ ] = '<label><input type="radio" name="hide_all_singular_titles" value="1" id="hide_all_singular_titles_1" ' . $checked [ 1 ] . '><strong>Hide all</strong> singular titles</label>';
		$inp [ ] = '</div>';
		$inp [ ] = '<div>';
		$inp [ ] = '<label><input type="radio" name="hide_all_singular_titles" value="0" id="hide_all_singular_titles_0" ' . $checked [ 0 ] . '>' . __( 'Use <strong>Singular Title</strong> settings of each post', 'plghidetitle' ) . '</label>';
		$inp [ ] = '<div id="hideallsingularwiththese">';
		$inp [ ] = '<span class="expanded-settings-pre">in conjunction with these settings:</span><br>';
		# Post types
		$public_post_types = get_post_types( $args, 'objects' );
		$hiden_post_types = Options::GetHideAlsoList();
		foreach ( $public_post_types as $key => $ptype ) {
			$also_checked = array_key_exists( $ptype->name, $hiden_post_types ) ? 'checked' : '';
			$inp [ ] = '<label><input name="hide_also_singular_title_for[' . $ptype->name . ']" type="checkbox" value="0" ' . $also_checked . '>Hide all singular <strong>' . $ptype->labels->singular_name . '</strong> titles</label><br>';
		}
		$inp [ ] = '';
		$inp [ ] = '</div>';
		$inp [ ] = '</div>';
		# CSS Fallback
		$css_checked = ( Options::GetUseCssFallback() == 1 ) ? 'checked' : '';
		$inp [ ] = '<label><input id="hide_all_singular_titles_css" name="hide_all_singular_titles_css" type="checkbox" value="1" ' . $css_checked . '>Use <strong>CSS Fallback</strong></label>';
		# Description
		$descr = __( 'CSS Fallback tries to use some CSS snippets to hide specified singular titles on case if your current theme does not use WordPress singular titles properly. Please modify css-fallback.css file to suite your needs.', 'plghidetitle' );
		$href = '<a href="' . PluginHidePostTitle::GetFallBackCSSEditorAdminLink() . '">' . PluginHidePostTitle::css_fallback_file . '</a>';
		$descr = str_replace( PluginHidePostTitle::css_fallback_file, $href, $descr );
		$inp [ ] = '<div class="descr-max-width"><p class="description">' . $descr . '</p></div>';
		$inp [ ] = '<div class="descr-extra-link-myminiapp"><p class="description">Read more on <a href="http://myminiapp.com" target="_blank">myminiapp.com</a></p></div>';
		$inp [ ] = '</div>';
		# Echo output
		echo implode( PHP_EOL, $inp );
	}

	/**
	 * Hook readings panel settings
	 * @since 1.0.0
	 */
	public static function Hook() {
		add_settings_field( 'hide_all_singular_titles', __( 'Hide Titles', 'plghidetitle' ), 'WPA\HidePostTitle\Settings\Reading::Show', 'reading', $section = 'default' );
		register_setting( 'reading', 'hide_all_singular_titles_css', 'intval' );
		register_setting( 'reading', 'hide_all_singular_titles', 'intval' );
		register_setting( 'reading', 'hide_also_singular_title_for' );
	}

}
