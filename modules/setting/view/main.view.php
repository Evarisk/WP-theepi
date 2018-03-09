<?php
/**
 * Gestion des onglets dans la page "digirisk-epi-setting".
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.2.0
 * @version 0.4.0
 * @copyright 2015-2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wrap wpeo-wrap">
	<h1><?php esc_html_e( 'TheEPI settings', 'theepi' ); ?></h1>

	<div class="digi-tools-main-container">
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php echo ( 'theepi-capability' === $default_tab ) ? 'nav-tab-active' : ''; ?>" href="#" data-id="theepi-capability" ><?php esc_html_e( 'Capacités', 'theepi' ); ?></a>
			<a class="nav-tab <?php echo ( 'theepi-default-data' === $default_tab ) ? 'nav-tab-active' : ''; ?>" href="#" data-id="theepi-default-data" ><?php esc_html_e( 'Default data', 'theepi' ); ?></a>
		</h2>

		<div class="digirisk-wrap">
			<div id="theepi-capability" class="tab-content <?php echo ( 'theepi-capability' === $default_tab ) ? '' : 'hidden'; ?>">
				<?php \eoxia\View_Util::exec( 'theepi', 'setting', 'capability/main' ); ?>
			</div>

			<div id="theepi-default-data" class="tab-content <?php echo ( 'theepi-default-data' === $default_tab ) ? '' : 'hidden'; ?>">
				<?php
				\eoxia\View_Util::exec( 'theepi', 'setting', 'default-data/main', array(
					'default_comment' => $default_comment,
				) );
				?>
			</div>
		</div>
	</div>
</div>
