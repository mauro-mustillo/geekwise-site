<?php
namespace WPA\HidePostTitle;

/** 
 * @author MyMiniapp.com
 * @version 1.0.0
 */
final class MetaBox {

	const hook_show = 'WPA\HidePostTitle\MetaBox::Show';
	const hook_add = 'WPA\HidePostTitle\MetaBox::Add';
	const hook_save = 'WPA\HidePostTitle\MetaBox::Save';
	const hook_ftjs = 'WPA\HidePostTitle\MetaBox::AddQuickEditRefreshScript';

	const hook_quick_edit = 'WPA\HidePostTitle\MetaBox::AddQuickEdit';
	const hook_quick_edit_man = 'WPA\HidePostTitle\MetaBox::AddQuickEditManage';
	const hook_quick_edit_col = 'WPA\HidePostTitle\MetaBox::AddQuickEditColumn';
	const hook_mbox_save = 'WPA\HidePostTitle\MetaBox::Save';

	const locaton = '';
	const priority = 'high';
	const screen = null;
	const context = 'side';
	const var_hide_singular_title = 'hide_singular_title';

	/**
	 * Determine whether the singular title should be visible
	 * 
	 * @param int $post_id
	 * @return number
	 */
	public static function GetHideTitle( $post_id = 0 ) {
		$post_id = ( $post_id == 0 ) ? get_the_ID() : $post_id;
		return ( int ) get_post_meta( $post_id, self::var_hide_singular_title, true );
	}

	/**
	 * Sets the singular title visibility
	 * @param int $post_id
	 * @param int $mode
	 */
	public static function SetHideTitle( $post_id, $mode ) {
		update_post_meta( $post_id, self::var_hide_singular_title, ( int ) $mode );
	}

	/**
	 * Get HTML code of Meta Box
	 * 
	 * @param WP_Post $post
	 * @return mixed
	 */
	public static function Get( $post ) {
		$hide_title = self::GetHideTitle( $post->ID );
		$file = PluginHidePostTitle::GetDir( '/inc/html/metabox.html' );
		$html = file_get_contents( $file );
		$search = array(
				'data-' . self::var_hide_singular_title . '="0"',
				'data-' . self::var_hide_singular_title . '="1"',
				' Hide ',
				' Show '
		);
		$replace = array(
				$hide_title == 0 ? 'checked' : '',
				$hide_title == 1 ? 'checked' : '',
				__( 'Hide', PluginHidePostTitle::txtdomain ),
				__( 'Show', PluginHidePostTitle::txtdomain )
		);
		$html = str_replace( $search, $replace, $html );
		return $html;
	}

	/**
	 * Output Meta Box
	 * 
	 * @param WP_Post $post
	 */
	public static function Show( $post ) {
		echo self::Get( $post );
	}

	/**
	 * Save WP option for title visibility
	 * 
	 * @param $post_id int
	 * @return mixed
	 */
	public static function Save( $post_id ) {
		# file_put_contents( 'debug.txt', print_r( $_REQUEST, true ) );
		if ( isset( $_REQUEST [ '_inline_edit' ] ) ) {
			if ( isset( $_REQUEST [ self::var_hide_singular_title ] ) ) {
				if ( check_ajax_referer( 'inlineeditnonce', '_inline_edit' ) ) {
					//file_put_contents( 'debug.txt', print_r( $_REQUEST, true ) );
				}
				self::SetHideTitle( $post_id, ( int ) trim( $_REQUEST [ self::var_hide_singular_title ] ) );
				return $post_id;
			}
		}
		if ( !isset( $_REQUEST [ '_wpnonce' ] ) ) {
			return $post_id;
		}
		if ( !wp_verify_nonce( $_REQUEST [ '_wpnonce' ], 'update-post_' . $post_id ) ) {
			return $post_id;
		}
		if ( isset( $_REQUEST [ self::var_hide_singular_title ] ) ) {
		    self::SetHideTitle( $post_id, ( int ) trim( $_POST [ self::var_hide_singular_title ] ) );
		}
		return $post_id;
	}

	/**
	 * Add Meta Box
	 */
	public static function Add() {
		add_meta_box( PluginHidePostTitle::id, __( 'Singular Title', PluginHidePostTitle::txtdomain ), self::hook_show, self::screen, self::context, self::priority );
	}

	/**
	 * Get QuickEdit HTML code
	 * @param int $post_id
	 * @return string
	 */
	public static function GetQuickEdit( $post_id, $as_column = false ) {
		#TODO - Generae HTML for Quick Edit
		$hide_title = self::GetHideTitle( $post_id );
		$file = PluginHidePostTitle::GetDir( '/inc/html/metabox-quick-edit.html' );
		$html = file_get_contents( $file );
		$search = array(
				'Singular Title',
				'data-' . self::var_hide_singular_title . '="0"',
				'data-' . self::var_hide_singular_title . '="1"',
				'data-id=""',
				' Hide ',
				' Show '
		);
		$replace = array(
				__( 'Singular Title', PluginHidePostTitle::txtdomain ),
				$hide_title == 0 ? 'checked' : '',
				$hide_title == 1 ? 'checked' : '',
				'data-id="' . $post_id . '"',
				__( 'Hide', PluginHidePostTitle::txtdomain ),
				__( 'Show', PluginHidePostTitle::txtdomain )
		);
		$html = str_replace( $search, $replace, $html );
		#
		if ( $as_column === true ) {
			$column_tag = ( $hide_title ) ? __( 'Hide', PluginHidePostTitle::txtdomain ) : __( 'Show', PluginHidePostTitle::txtdomain );
			$html = $column_tag . $html;
			$html = str_replace( '<fieldset class="inline-edit-col-right">', '<fieldset class="inline-edit-col-right" style="display:none;">', $html );
		}
		return $html;
	}

	public static function AddQuickEdit( $column_name, $post_type ) {
		if ( $column_name == PluginHidePostTitle::id ) {
			echo self::GetQuickEdit( get_the_ID() );
		}
	}

	public static function AddQuickEditColumn( $posts_columns ) {
		$posts_columns [ PluginHidePostTitle::id ] = __( 'Singular Title', PluginHidePostTitle::txtdomain );
		return $posts_columns;
	}

	public static function AddQuickEditManage( $column_name, $post_id ) {
		if ( $column_name == PluginHidePostTitle::id ) {
			echo self::GetQuickEdit( $post_id, true );
		}
	}

	/**
	 * Hook Meta Box
	 */
	public static function Hook() {
		if ( is_admin() ) {
			global $pagenow;
			# Save Post
			add_action( 'save_post', self::hook_save, 47 );

			# Hook Quick Edit
			add_action( 'quick_edit_custom_box', self::hook_quick_edit, 10, 2 );
			add_filter( 'manage_posts_columns', self::hook_quick_edit_col, 10, 1 );
			add_filter( 'manage_pages_columns', self::hook_quick_edit_col, 10, 1 );
			add_action( 'manage_posts_custom_column', self::hook_quick_edit_man, 10, 2 );
			add_action( 'manage_pages_custom_column', self::hook_quick_edit_man, 10, 2 );
			#
			if ( $pagenow == 'edit.php' || $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
				# Meta Box
				add_action( 'add_meta_boxes', self::hook_add, 45 );
			}
			if ( $pagenow == 'edit.php' ) {
				# Quick Edit Refresher
				add_action( 'admin_footer', self::hook_ftjs );
			}
		}
	}

	/**
	 * Includes the Quick Edit fields refreshing script on the edit page
	 */
	public static function AddQuickEditRefreshScript() {
		global $pagenow;
		if ( $pagenow == 'edit.php' ) {
			echo '<script type="text/javascript" src="' . PluginHidePostTitle::GetUri( '/inc/js/metabox-inline-edit.js' ) . '"></script>';
		}
	}

	/**
	 * Disabled class construction
	 */
	private function __construct() {
		;
	}
}

