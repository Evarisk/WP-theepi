<?php
/**
 * Affichage pour gérer les données par défaut.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.3.0
 * @version 0.3.0
 * @copyright 2015-2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpeo-form">
	<input type="hidden" name="action" value="save_default_data" />
	<?php wp_nonce_field( 'save_default_data' ); ?>

	<h3><?php esc_html_e( 'Handle default data', 'theepi' ); ?></h3>

	<div class="form-element form-modern <?php echo ! empty( $default_comment ) ? 'form-active' : ''; ?>">
		<input name="default_comment" type="text" value="<?php echo esc_attr( $default_comment ); ?>" />
		<label><?php echo esc_html_e( 'Default comment*', 'theepi' ); ?></label>
		<span class="form-bar"></span>
	</div>

	<p><?php esc_html_e( '*This data is used for the first comment created on a new EPI', 'theepi' ); ?></p>

	<div class="wpeo-button button-green button-progress action-input" data-parent="wpeo-form">
		<span><?php echo esc_html_e( 'Save', 'theepi' ); ?></span>
	</div>
</div>
