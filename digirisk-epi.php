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
 * Version:     0.2.0-beta
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

require_once( 'core/external/eo-framework/eo-framework.php' );

\eoxia\Init_Util::g()->exec( PLUGIN_DIGIRISK_EPI_PATH, basename( __FILE__, '.php' ) );
