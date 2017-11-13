<?php
/**
 * Fichier boot du plugin
 *
 * @package Evarisk\Plugin
 */

namespace evarisk_epi;
/**
 * Plugin Name: Digirisk EPI
 * Plugin URI:  http://www.evarisk.com/document-unique-logiciel
 * Description: Gérer vos EPI en toute simplicité avec ce plugin complémentaire à Digirisk.
 * Version:     1.0.1
 * Author:      Evarisk
 * Author URI:  http://www.evarisk.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path: /core/assets/languages
 * Text Domain: digirisk-epi
 */

DEFINE( 'PLUGIN_DIGIRISK_EPI_PATH', realpath( plugin_dir_path( __FILE__ ) ) . '/' );
DEFINE( 'PLUGIN_DIGIRISK_EPI_URL', plugins_url( basename( __DIR__ ) ) . '/' );
DEFINE( 'PLUGIN_DIGIRISK_EPI_DIR', basename( __DIR__ ) );

// On plugin load change order in order to load WPShop before current plugin.
add_action( 'plugins_loaded', function() {
	$plugins = get_option( 'active_plugins' );
	$sub_plugin_path = 'digirisk-epi/' . basename( __FILE__ );
	foreach ( $plugins as $key => $value ) {
		if ( strpos( $value, 'digirisk.php' ) ) {
			$main_plugin_key = $key;
		}

		if ( strpos( $value, basename( __FILE__ ) ) ) {
			$sub_plugin_key = $key;
			$sub_plugin_path = $value;
		}
	}

	if ( $main_plugin_key > $sub_plugin_key ) {
		array_splice( $plugins, $sub_plugin_key, 1 );
		$plugins[] = $sub_plugin_path;
		update_option( 'active_plugins', $plugins );
	}
} );

if ( class_exists( '\eoxia\Init_Util' ) ) {
	\eoxia\Init_Util::g()->exec( PLUGIN_DIGIRISK_EPI_PATH, basename( __FILE__, '.php' ) );
}
