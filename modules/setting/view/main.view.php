<?php
/**
 * Gestion des onglets dans la page "digirisk-epi-setting".
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.2.0
 * @version 0.2.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wrap">
	<h1><?php esc_html_e( 'Digirisk EPI settings', 'digirisk' ); ?></h1>

	<div class="digirisk-wrap">
		<div id="digi-capability" class="tab-content <?php echo ( 'digi-capability' === $default_tab ) ? '' : 'hidden'; ?>">
			<?php \eoxia\View_Util::exec( 'digirisk-epi', 'setting', 'capability/main' ); ?>
		</div>
	</div>
</div>
