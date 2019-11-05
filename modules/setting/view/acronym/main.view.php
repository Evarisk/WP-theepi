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

		<div class="form-element" style="width : 20%">
			<span class="form-label"><?php esc_html_e( 'Site', 'theepi' ); ?></span>
			<label class="form-field-container">
				<input type="text" class="form-field" name="default-acronym-site" value="<?php ! empty ( $default_acronym_site ) ? esc_attr_e( $default_acronym_site ) : esc_attr_e( 'S', 'theepi' ); ?>"/>
			</label>
		</div>

		<div class="form-element" style="width : 20%">
			<span class="form-label"><?php esc_html_e( 'Personal Protective Equipment', 'theepi' ); ?></span>
			<label class="form-field-container">
				<input type="text" class="form-field" name="default-acronym-epi" value="<?php ! empty ( $default_acronym_epi ) ? esc_attr_e( $default_acronym_epi ) : esc_attr_e( 'EPI', 'theepi' ); ?>"/>
			</label>
		</div>

		<div class="form-element" style="width : 20%">
			<span class="form-label"><?php esc_html_e( 'Control', 'theepi' ); ?></span>
			<label class="form-field-container">
				<input type="text" class="form-field" name="default-acronym-control" value="<?php ! empty ( $default_acronym_control ) ? esc_attr_e( $default_acronym_control ) : esc_attr_e( 'C', 'theepi' ); ?>"/>
			</label>
		</div>

		<div class="wpeo-button button-green button-progress button-disable action-input" data-parent="wpeo-form" style="margin-top : 20px">
			<span class="button-icon fas fa-save"></span>
		</div>
	</form>
</div>
