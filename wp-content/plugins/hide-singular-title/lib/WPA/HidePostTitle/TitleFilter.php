<?php
namespace WPA\HidePostTitle;

use WPA\HidePostTitle\Settings\Options;
/** 
 * @author MyMiniapp.com
 * @version 1.0.0
 * @since 1.0.0
 */
class TitleFilter {

	/**
	 * Disable construct
	 */
	private function __construct() {

	}

	/**
	 * @param string $title
	 * @param int $id
	 * @return null|string
	 */
	public static function TheTitle( $title, $post_id = 0 ) {
		if ( !are_we_in( "the_title" ) ) {
			return $title;
		}
		if ( is_singular() ) {
			if ( Options::GetHideMode() ) {
				return null;
			}
			if ( array_key_exists( get_post_type( $post_id ), Options::GetHideAlsoList() ) ) {
				return null;
			}
			if ( MetaBox::GetHideTitle( $post_id ) ) {
				return null;
			}
		}
		return $title;
	}

}

