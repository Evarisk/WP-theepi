<?php
/**
 * Affichage pour gérer les acronymes.
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.7.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="setting-epi"  data-page="<?php echo esc_attr( $page ); ?>">
	<form class="wpeo-form">
		<input type="hidden" name="action" value="save_acronym" />
		<?php wp_nonce_field( 'save_acronym' ); ?>

		<h3><?php esc_html_e( 'Handle acronym', 'theepi' ); ?></h3>

		<div class="wpeo-button button-green button-progress button-disable action-input" data-parent="wpeo-form" style="margin-top : 20px">
			<span class="button-icon fas fa-save"></span>
		</div>
	</form>
</div>
