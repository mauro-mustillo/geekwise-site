<?php
namespace WPA\HidePostTitle\Settings;

/** 
 * @author MyMiniapp.com
 * 
 */
final class Options {

	/**
	 * 
	 */
	private function __construct() {

	}

	/**
	 * Return hide option as integer
	 * @return number
	 * @since 1.0.0
	 */
	public static function GetHideMode() {
		return ( int ) get_option( 'hide_all_singular_titles', 0 );
	}

	/**
	 * Return hide option as integer
	 * @return number
	 * @since 1.0.0
	 */
	public static function GetUseCssFallback() {
		return ( int ) get_option( 'hide_all_singular_titles_css', 0 );
	}

	/**
	 * Return hide option as integer
	 * @return array
	 * @since 1.0.0
	 */
	public static function GetHideAlsoList() {
		$also_list = get_option( 'hide_also_singular_title_for', array() );
		if ( !is_array( $also_list ) ) {
			$also_list = array();
		}
		return $also_list;
	}

	public static function HidePostTitle( $post_id ) {
		if ( self::GetHideMode() ) {
			return true;
		}
		if ( array_key_exists( get_post_type( $post_id ), self::GetHideAlsoList() ) ) {
			return true;
		}
		if ( self::GetHideTitle( $post_id ) ) {
			return true;
		}
		return false;
	}

	public static function GetHideTitle( $post_id ) {
		$post_id = ( $post_id == 0 ) ? get_the_ID() : $post_id;
		return ( int ) get_post_meta( $post_id, self::var_hide_singular_title, true );
	}

}
