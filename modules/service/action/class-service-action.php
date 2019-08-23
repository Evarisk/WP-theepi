<?php
/**
 * Handle Mise en Service
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.5.0
 * @version   0.5.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gères toutes les actions lié au menu mise en service d'un EPI.
 */
class Service_Action {


	/**
	 * Le constructeur
	 *
	 * @since   0.5.0
	 * @version 0.5.0
	 */
	public function __construct() {
		//add_action( 'init', array( $this, 'callback_init' ) );
	}

	/*public function callback_init() {
		$labels = array(
		'name'               => _x( 'Fabricants', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Fabricant', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Fabricants', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Fabricant', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'fabricant', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Fabricant', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Fabricant', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Fabricant', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Fabricant', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Fabricants', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Fabricants', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Fabricants:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No fabricants found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No fabricants found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'fabricant' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

		register_post_type( 'fabricant', $args );


	}*/
}

new Service_Action();
