<?php
namespace WPA\HidePostTitle;

/** 
 * @author MyMiniapp.com
 * 
 */
final class ShortCodes {

	/**
	 * 
	 */
	private function __construct() {

	}

	/**
	 * @param array $atts
	 */
	public static function TheTitle( $atts ) {
		# Define allowed tags
		static $tags;
		if ( is_null( $tags ) ) {
			for ( $i = 1; $i < 7; $i++ ) {
				$tags [ 'h' . $i ] = 'h' . $i;
			}
		}
		# Get post
		$post = get_post();
		if ( $post instanceof \WP_Post ) {
			$tag = isset( $atts [ 'tag' ] ) ? strtolower( $atts [ 'tag' ] ) : 'h1';
			if ( !array_key_exists( $tag, $tags ) ) {
				$tag = 'h1';
			}
			$classes = isset( $atts [ 'class' ] ) ? trim( strtolower( $atts [ 'class' ] ) ) : '';
			if ( strlen( $classes ) > 0 ) {
				$classes = explode( ' ', $classes );
				$classes = array_unique( $classes );
				foreach ( $classes as $key => $cls ) {
					$classes [ $key ] = sanitize_html_class( $cls );
				}
				$classes = trim( implode( ' ', $classes ) );
				$classes = ' class="' . $classes . '"';
			}
			$title = strip_tags( $post->post_title );
			return '<' . $tag . $classes . '>' . $title . '</' . $tag . '>';
		}
		return '';
	}

}

