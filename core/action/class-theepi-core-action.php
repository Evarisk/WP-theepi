<?php
/**
 * Handle main actions.
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.1.0
 * @version   0.7.0
 */

namespace theepi;

use eoxia\Config_Util;
use eoxia\Custom_Menu_Handler as CMH;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle main actions.
 */
class TheEPI_Core_Action {


	/**
	 * Le constructeur
	 *
	 * @since   0.1.0
	 * @version 0.1.0
	 */
	public function __construct() {
		// Initialises ses actions que si nous sommes sur une des pages réglés dans le fichier digirisk.config.json dans la clé "insert_scripts_pages".
		$page = ! empty( $_REQUEST['page'] ) ? sanitize_text_field( $_REQUEST['page'] ) : ''; // WPCS: CSRF ok.

		if ( in_array( $page, Config_Util::$init['theepi']->insert_scripts_pages_css, true ) ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_enqueue_scripts_css' ), 11 );
		}

		if ( in_array( $page, Config_Util::$init['theepi']->insert_scripts_pages_js, true ) ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_before_admin_enqueue_scripts_js' ), 10 );
			add_action( 'admin_enqueue_scripts', array( $this, 'callback_admin_enqueue_scripts_js' ), 11 );
		}

		add_action( 'init', array( $this, 'callback_plugins_loaded' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'callback_enqueue_scripts_js_frontend' ) );
		add_action( 'admin_init', array( $this, 'callback_admin_init' ) );
		add_action( 'admin_menu', array( $this, 'callback_admin_menu' ), 20 );
		add_action( 'wp_print_scripts', array( $this, 'callback_wp_print_scripts' ) );

		add_action( 'wp_ajax_theepi_have_patch_note', array( $this, 'have_patch_note' ) );

	}

	/**
	 * Initialise le fichier style.min.css du plugin Digirisk-EPI.
	 *
	 * @since   0.1.0
	 * @version 0.2.0
	 *
	 * @return void
	 */
	public function callback_admin_enqueue_scripts_css() {
		wp_register_style( 'theepi-style', PLUGIN_THEEPI_URL . 'core/assets/css/style.min.css', array(), Config_Util::$init['theepi']->version );
		wp_enqueue_style( 'theepi-style' );
		wp_enqueue_style( 'theepi-datepicker', PLUGIN_THEEPI_URL . 'core/assets/css/jquery.datetimepicker.css', array(), Config_Util::$init['theepi']->version );
	}

	/**
	 * Initialise les fichiers JS inclus dans WordPress (jQuery, wp.media et thickbox)
	 *
	 * @since   0.1.0
	 * @version 0.1.0
	 *
	 * @return void
	 */
	public function callback_before_admin_enqueue_scripts_js() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-form' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_media();
	}

	/**
	 * Initialise le fichier backend.min.js du plugin.
	 *
	 * @since   0.1.0
	 * @version 0.1.0
	 *
	 * @return void
	 */
	public function callback_admin_enqueue_scripts_js() {
		wp_enqueue_script( 'digi-epi-datetimepicker-script', PLUGIN_THEEPI_URL . 'core/assets/js/jquery.datetimepicker.full.js', array(), Config_Util::$init['theepi']->version, false );
		wp_enqueue_script( 'digi-epi-script', PLUGIN_THEEPI_URL . 'core/assets/js/backend.min.js', array(), Config_Util::$init['theepi']->version, false );
	}

	/**
	 * Initialise le fichier frontend.min.js du plugin.
	 *
	 * @since   0.1.0
	 * @version 0.1.0
	 *
	 * @return void
	 */
	public function callback_enqueue_scripts_js_frontend() {
		wp_enqueue_style( 'theepi-style', PLUGIN_THEEPI_URL . 'core/assets/css_front/style.min.css', array(), Config_Util::$init['theepi']->version );
		wp_enqueue_script( 'digi-epi-script-frontend', PLUGIN_THEEPI_URL . 'core/assets/js/frontend.min.js', array(), Config_Util::$init['theepi']->version, false );
	}

	/**
	 * Initialise le fichier MO du plugin et les capacitées.
	 *
	 * @since   0.1.0
	 * @version 0.2.0
	 *
	 * @return void
	 */
	public function callback_plugins_loaded() {
		load_plugin_textdomain( 'theepi', false, PLUGIN_THEEPI_DIR . '/core/assets/languages/' );
		if ( ! get_option( 'plugin_permalinks_flushed' ) ) {
			flush_rewrite_rules( false );
			update_option( 'plugin_permalinks_flushed', 1 );
		}
	}

	/**
	 * Initialise les capacitées
	 *
	 * @since   0.1.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	public function callback_admin_init() {
		/**
 * Set capability to subscriber by default
*/
		$subscriber_role = get_role( 'subscriber' );
		if ( ! $subscriber_role->has_cap( 'read_theepi' ) ) {
			$subscriber_role->add_cap( 'read_theepi', true );
		}

		/**
 * Set capability to administrator by default
*/
		$administrator_role = get_role( 'administrator' );
		if ( ! $administrator_role->has_cap( 'manage_theepi' ) ) {
			$administrator_role->add_cap( 'manage_theepi', true );
			$administrator_role->add_cap( 'create_theepi', true );
			$administrator_role->add_cap( 'read_theepi', true );
			$administrator_role->add_cap( 'update_theepi', true );
			$administrator_role->add_cap( 'delete_theepi', true );
		}

		Config_Util::$init['task-manager']->insert_scripts_pages[] = 'theepi';
	}

	/**
	 * Initialise le sous menu "TheEPI" dans le menu WordPress.
	 *
	 * @since   0.1.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	public function callback_admin_menu() {
		CMH::add_logo( PLUGIN_THEEPI_URL . 'core/assets/images/icon-256x256.png', admin_url( 'admin.php?page=theepi' ) );
		CMH::register_container( __( 'TheEPI', 'theepi' ), __( 'TheEPI', 'theepi' ), 'read_theepi', 'theepi' );
		CMH::register_menu( 'theepi', __( 'TheEPI', 'theepi' ), __( 'TheEPI', 'theepi' ), 'read_theepi', 'theepi', array( Class_TheEPI_Core::g(), 'display' ), 'fa fa-hard-hat' );
/*		//'data:image/svg+xml;base64,' . base64_encode( "
//		<svg data-prefix='fas' data-icon='hard-hat'
//			class='svg-inline--fa fa-hard-hat fa-w-16'
//			role='img'
//			xmlns='http://www.w3.org/2000/svg'
//			viewBox='0 0 512 512'>
//			<path fill='rgba(240,245,250,.6)'
//				d='M480 288c0-80.25-49.28-148.92-119.19-177.62L320 192V80a16 16 0 0 0-16-16h-96a16 16 0 0 0-16 16v112l-40.81-81.62C81.28 139.08 32 207.75 32 288v64h448zm16 96H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h480a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z'>
//			</path>
//		</svg> ")
	// );*/
		// "add_action( 'load-' . $hook, array( EPI_Class::g(), 'callback_add_screen_option' ) );"

	}

	/**
	 * Initialise ajaxurl.
	 *
	 * @since 0.7.0
	 * @version 0.7.0
	 *
	 * @return void
	 */
	public function callback_wp_print_scripts() {
		?>
			<script>var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";</script>
		<?php
	}

	public function have_patch_note() {
		$result = Class_TheEPI_Core::g()->get_patch_note();

		ob_start();
		require PLUGIN_THEEPI_PATH . '/core/view/patch-note.view.php';

		wp_send_json_success(
			array(
				'status' => $result['status'],
				'result' => $result,
				'view'   => ob_get_clean(),
			)
		);
	}
}

new TheEPI_Core_Action();
